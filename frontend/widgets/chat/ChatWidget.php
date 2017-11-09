<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/9
 * Time: 15:12
 */

namespace frontend\widgets\chat;

use frontend\models\FeedForm;
use yii\bootstrap\Widget;

class ChatWidget  extends Widget {

    public function run() {
        $feed = new FeedForm();
        $data['feed'] = $feed->getList();
        return $this->render('index',['data'=>$data]);
    }

}