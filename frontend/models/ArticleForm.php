<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/1
 * Time: 14:42
 */

namespace frontend\models;

use common\models\Article;
use common\models\RelationArticleTags;
use common\models\Tags;
use yii;
use yii\base\Model;


class ArticleForm extends Model {

    public $id;
    public $title;
    public $content;
    public $label_img;
    public $cat_id;
    public $tags;

    public $_lastError = '';

    /**
     * 定义场景
     * SCENARIOS_CREATE 创建
     * SCENARIOS_UPDATE 更新
     *
     */
    const SCENARIOS_CREATE = 'create';
    const SCENARIOS_UPDATE = 'update';

    const IS_VALID = 1; // 已发布
    const NO_VALID = 0; // 未发布

    /**
     * 定义事件
     * EVENT_AFTER_CREATE 添加后的事件
     * EVENT_AFTER_UPDATE 更新后的事件
     */
    const EVENT_AFTER_CREATE = 'eventAfterCreate';
    const EVENT_AFTER_UPDATE = 'eventAfterUpdate';

    /**
     * 场景设置.
     */
    public function scenarios() {
        $scenarios = [
            self::SCENARIOS_CREATE =>['title','content','label_img','cat_id','tags'],
            self::SCENARIOS_UPDATE =>['title','content','label_img','cat_id','tags'],
        ];

        return array_merge(parent::scenarios(),$scenarios);
    }

    public function rules() {
        return [
            [['id','title','content','cat_id'],'required'],
            [['id','cat_id'],'integer'],
            ['title','string','min'=>4,'max'=>50],
        ];
    }

    public function attributeLabels() {
        return [
            'id' => \Yii::t('common','ID'),
            'title' => \Yii::t('common','Title'),
            'content' => \Yii::t('common','Content'),
            'label_img' => \Yii::t('common','LabelImg'),
            'tags' => \Yii::t('common','Tags'),
            'cat_id' => \Yii::t('common','CatId')
        ];
    }

    public function create(){
        //事务

        $transaction = \Yii::$app->db->beginTransaction();
        try{
            $model = new Article();
            $model->setAttributes($this->attributes);
            $model->summary = $this->_getSummary();
            $model->user_id = Yii::$app->user->identity->id;
            $model->user_name = Yii::$app->user->identity->username;
            $model->is_valid = ArticleForm::IS_VALID;
            $model->created_at = time();
            $model->updated_at = time();


            if(!$model->save()){
                $transaction->rollBack();
                throw new \Exception('文章保存失败');
            }
            $this->id = $model->id;

            // 调用事件
            $data = array_merge($this->getAttributes(),$model->getAttributes());
            $this->_eventAfterCreate($data);

            $transaction->commit();
            return true;
        }catch (\Exception $e){

            $transaction->rollBack();
            $this->_lastError = $e->getMessage();
            return false;
        }
    }

    /**
     * 通过id获取文章内容
     * @param $id
     */
    public function getViewById($id){
        $data = Article::find()->with('relate.tag','extend')->where(['id'=>$id])->asArray()->one();
        if(!$data){
            throw new yii\web\NotFoundHttpException('文章不存在');

        }
        // 出来标签格式
        $data['tags'] = [];
        if(isset($data['relate']) && !empty($data['relate'])){
            foreach ($data['relate'] as $list){
                $data['tags'][] = $list['tag']['tag_name'];
            }
        }
        unset($data['relate']);
        return $data;
    }


    private function _getSummary($start=0,$end=90,$char = 'utf-8'){
        if(empty($this->content)) return null;

        return mb_substr(str_replace('&nbsp;','',strip_tags($this->content)),$start,$end,$char);
    }

    /**
     * 文章创建后的事件
     * @param $data
     */
    public function _eventAfterCreate($data){
        // 添加事件
        $this->on(self::EVENT_AFTER_CREATE,[$this,'_eventAddTag'],$data);
        // 触发事件
        $this->trigger(self::EVENT_AFTER_CREATE);
    }

    /**
     * 添加标签
     * @param $event
     */
    public function _eventAddTag($event){
        // 保存标签.
        $tag = new TagForm();
        $tag->tags = $event->data['tags'];
        $tagIds = $tag->saveTags();

        // 删除原先的关联.
        RelationArticleTags::deleteAll(['article_id'=>$event->data['id']]);

        // 批量保存文章和标签关联关系
        if(!empty($tagIds)){
            foreach ($tagIds as $k=>$id){
                $row[$k]['article_id'] = $this->id;
                $row[$k]['tag_id'] = $id;
            }
            // 批量插入
            $res = (new yii\db\Query())->createCommand()
                ->batchInsert(RelationArticleTags::tableName(),['article_id','tag_id'],$row)
                ->execute();

            if(!$res){
                throw new \Exception('关联关系保存失败!');
            }
        }

    }

    public static function getList($cond,$curPage=1,$pageSize=10,$orderBy=['id'=>SORT_DESC]){

        $model = new Article();

        $fields = ['id','title','summary','label_img','cat_id','user_id','user_name','created_at','updated_at'];

        $query = $model->find()
            ->select($fields)
            ->where($cond)
            ->with('relate.tag','extend')
            ->orderBy($orderBy);

        // 获取分页数据.
        $res = $model->getPages($query,$curPage,$pageSize);
        // 格式化
        $res['data'] = self::_formatList($res['data']);

        return $res;

    }

    /**
     * 数据格式化.
     * @param $data
     */
    public static function _formatList($data){
        foreach ($data as &$value){
            $value['tags'] = [];
            if(isset($value['relate']) && !empty($value['relate'])){
                foreach ($value['relate'] as $item){
                    $value['tags'][] = $item['tag']['tag_name'];
                }
            }
            unset($value['relate']);
        }

        return $data;

    }

}























