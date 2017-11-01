<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/1
 * Time: 14:42
 */

namespace frontend\models;


use yii\base\Model;

class ArticleForm extends Model {

    public $id;
    public $title;
    public $content;
    public $label_img;
    public $cat_id;
    public $tags;

    public $_lastError = '';

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


}