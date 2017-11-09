<?php
namespace frontend\widgets\banner;
use yii\bootstrap\Widget;

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/8
 * Time: 17:20
 */
class BannerWidget extends Widget {

    public $items = [];

    public function init() {
        if(empty($this->items)){
            $this->items = [
                [
                    'label' => 'demo',
                    'image_url'=>'/statics/images/banner/bg_1.jpg',
                    'url'=>['site/index'],
                    'html' => '',
                    'active' => 'active',
                ],
                [
                    'label' => 'demo',
                    'image_url'=>'/statics/images/banner/bg_2.jpg',
                    'url'=>['site/index'],
                    'html' => '',
                    'active' => '',
                ],
                [
                    'label' => 'demo',
                    'image_url'=>'/statics/images/banner/bg_3.jpg',
                    'url'=>['site/index'],
                    'html' => '',
                    'active' => '',
                ],
                [
                    'label' => 'demo',
                    'image_url'=>'/statics/images/banner/bg_4.jpg',
                    'url'=>['site/index'],
                    'html' => '',
                    'active' => '',
                ],

            ];
        }

    }

    public function run() {
        $data['items'] = $this->items;
        return $this->render('index',['data'=>$data]);
    }



}