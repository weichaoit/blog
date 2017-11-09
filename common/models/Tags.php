<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "tags".
 *
 * @property integer $id
 * @property string $tag_name
 * @property integer $article_num
 */
class Tags extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tags';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['article_num'], 'integer'],
            [['tag_name'], 'string', 'max' => 255],
            [['tag_name'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'tag_name' => 'Tag Name',
            'article_num' => 'Article Num',
        ];
    }
}
