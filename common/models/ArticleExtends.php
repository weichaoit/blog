<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "article_extends".
 *
 * @property integer $id
 * @property integer $article_id
 * @property integer $browser
 * @property integer $collect
 * @property integer $praise
 * @property integer $comment
 */
class ArticleExtends extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'article_extends';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['article_id', 'browser', 'collect', 'praise', 'comment'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'article_id' => 'Article ID',
            'browser' => 'Browser',
            'collect' => 'Collect',
            'praise' => 'Praise',
            'comment' => 'Comment',
        ];
    }

    /**
     * 更新文章统计
     * @param $cond
     * @param $attribute
     * @param $num
     */
    public function upCounter($cond,$attribute,$num){
        $counter = $this->findOne($cond);
        if(!$counter){
            $this->setAttributes($cond);
            $this->$attribute = 1;
            $this->save();
        }else{
            $countData[$attribute] = $num;
            // 浏览量+1
            $counter->updateCounters($countData);
        }
    }

}
