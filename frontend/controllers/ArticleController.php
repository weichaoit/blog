<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/1
 * Time: 13:44
 */

namespace frontend\controllers;


use common\models\Cats;
use frontend\controllers\base\BaseController;
use frontend\models\ArticleForm;
use yii\helpers\Url;

class ArticleController extends BaseController {

    public function actions()
    {
        return [
            'upload'=>[
                'class' => 'common\widgets\file_upload\UploadAction',     //这里扩展地址别写错
                'config' => [
                    'imagePathFormat' => "/image/{yyyy}{mm}{dd}/{time}{rand:6}",
                ]
            ],
            'ueditor'=>[
                'class' => 'common\widgets\ueditor\UeditorAction',
                'config'=>[
                    //上传图片配置
                    'imageUrlPrefix' => "", /* 图片访问路径前缀 */
                    'imagePathFormat' => "/image/{yyyy}{mm}{dd}/{time}{rand:6}", /* 上传保存路径,可以自定义保存路径和文件名格式 */
                ]
            ],

        ];
    }

    public function actionIndex(){

        return $this->render('index');
    }

    /**
     * 创建文章页面
     * @return string
     */
    public function actionCreate(){
        $model = new ArticleForm();
        // 定义场景
        $model->setScenario(ArticleForm::SCENARIOS_CREATE);

        if($model->load(\Yii::$app->request->post()) && $model->validate()){
            if(!$model->create()){
                \Yii::$app->session->setFlash('warning',$model->_lastError);
            }else{
                return $this->redirect(['Article/view']);
            }
        }
        // 获取所有分类.
        $cats = Cats::getAllCats();
        return $this->render('create',['model'=>$model,'cats'=>$cats]);
    }


}