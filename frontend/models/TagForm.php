<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/2
 * Time: 16:13
 */

namespace frontend\models;


use common\models\Tags;
use yii\base\Model;

class TagForm extends Model {

    public $id;

    public $tags;

    public function rules() {
        return [
            ['tags','required'],
            ['tags','each','rule'=>['string']],
        ];
    }

    public function saveTags(){
        $ids = [];
        if(!empty($this->tags)){
            foreach ($this->tags as $tag){
                $ids[] = $this->_saveTag($tag);
            }
        }
        return $ids;
    }

    /**
     * 保存单个标签
     */
    private function _saveTag($tag){
        $model = new Tags();
        $res = $model->find()->where(['tag_name'=>$tag])->one();

        if(!$res){
            $model->tag_name = $tag;
            $model->article_num = 1;
            if(!$model->save()){
                throw new \Exception('保存标签失败');
            }
            return $model->id;
        }else{
            $res->updateCounters(['article_num'=>1]);
        }
        return $res->id;

    }


}