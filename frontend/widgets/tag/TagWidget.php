<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/9
 * Time: 17:41
 */

namespace frontend\widgets\tag;


use common\models\Tags;
use yii\bootstrap\Widget;

class TagWidget extends Widget {

    public $title = '';

    public $limit = 20;

    public function run() {
        $res = Tags::find()
            ->orderBy(['article_num'=>SORT_DESC,'id'=>SORT_DESC])
            ->limit($this->limit)
            ->all();
        $result['title'] = $this->title?:'标签云';
        $result['body'] = $res;

        return $this->render('index',['data'=>$result]);
    }
}