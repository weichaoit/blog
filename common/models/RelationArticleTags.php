<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "relation_article_tags".
 *
 * @property integer $id
 * @property integer $article_id
 * @property integer $tag_id
 */
class RelationArticleTags extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'relation_article_tags';
    }

    /**
     * 关联标签表
     * @return \yii\db\ActiveQuery
     */
    public function getTag(){
        return $this->hasOne(Tags::className(),['id'=>'tag_id']);
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['article_id', 'tag_id'], 'integer'],
            [['article_id', 'tag_id'], 'unique', 'targetAttribute' => ['article_id', 'tag_id'], 'message' => 'The combination of Article ID and Tag ID has already been taken.']
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
            'tag_id' => 'Tag ID',
        ];
    }
}
