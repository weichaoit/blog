<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "article".
 *
 * @property integer $id
 * @property string $title
 * @property string $summary
 * @property string $content
 * @property string $label_img
 * @property integer $cat_id
 * @property integer $user_id
 * @property string $user_name
 * @property integer $is_valid
 * @property integer $created_at
 * @property integer $updated_at
 */
class Article extends \yii\db\ActiveRecord
{
    const IS_VALID = 1; // 已发布
    const NO_VALID = 0; // 未发布
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'article';
    }

    /**
     * 关联标签关系表
     * @return \yii\db\ActiveQuery
     */
    public function getRelate(){
        return $this->hasMany(RelationArticleTags::className(),['article_id'=>'id']);
    }

    /**
     * 关联文章统计表
     * @return \yii\db\ActiveQuery
     */
    public function getExtend(){
        return $this->hasOne(ArticleExtends::className(),['article_id'=>'id']);
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['content'], 'string'],
            [['cat_id', 'user_id', 'is_valid', 'created_at', 'updated_at'], 'integer'],
            [['title', 'summary', 'label_img', 'user_name'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'summary' => 'Summary',
            'content' => 'Content',
            'label_img' => 'Label Img',
            'cat_id' => 'Cat ID',
            'user_id' => 'User ID',
            'user_name' => 'User Name',
            'is_valid' => 'Is Valid',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * 获取分页数据.
     * @param $query
     * @param int $curPage
     * @param int $pageSize
     * @param null $search
     * @return array
     */
    public function getPages($query,$curPage=1,$pageSize=10,$search=null){
        if($search){
            $query = $query->andFilerWhere($search);
        }
        $data['count'] = $query->count();
        if(!$data['count']){
            return ['count'=>0,'curPage'=>$curPage,'pageSize'=>$pageSize,'start'=>0,'end'=>0,'data'=>[]];
        }

        // 超人实际页数.不取curPage为当前页
        $curPage = (ceil($data['count']/$pageSize)<$curPage)
            ?ceil($data['count']/$pageSize) : $curPage ;
        // 当前页
        $data['curPage'] = $curPage;
        // 每页显示条数
        $data['pageSize'] = $pageSize;
        // 起始页
        $data['start'] = ($curPage-1)*$pageSize+1;
        // 末页.
        $data['end'] = (ceil($data['count']/$pageSize) == $curPage)? $data['count'] : ($curPage-1)*$pageSize+$pageSize;
        // 获取数据.
        $data['data'] = $query
            ->offset(($curPage-1)*$pageSize)
            ->limit($pageSize)
            ->asArray()
            ->all();

        return $data;
    }
}
