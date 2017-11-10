<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "cats".
 *
 * @property integer $id
 * @property string $cat_name
 */
class Cats extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cats';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cat_name'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'cat_name' => '分类',
        ];
    }

    /**
     * 获取到所有分类数据
     * @return array|\yii\db\ActiveRecord[]
     */
    public static function getAllCats(){
        $cat = ['0'=>'暂无分类'];
        $res = self::find()->asArray()->all();

        if($res){
            foreach ($res as $k=>$val) {
                $cat[$val['id']] = $val['cat_name'];
            }
        }

        return $cat;
    }
}
