<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/2
 * Time: 16:13
 */

namespace frontend\models;


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


}