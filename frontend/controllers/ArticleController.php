<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/1
 * Time: 13:44
 */

namespace frontend\controllers;


use common\models\ArticleExtends;
use common\models\Cats;
use frontend\controllers\base\BaseController;
use frontend\models\ArticleForm;
use yii\helpers\Url;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;

class ArticleController extends BaseController {

    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'create','upload','ueditor'],
                'rules' => [
                    [
                        'actions' => ['index'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['create','upload','ueditor'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    '*'      =>['get','post'],
                ],
            ],
        ];
    }
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
                return $this->redirect(['article/view','id'=>$model->id]);
            }
        }
        // 获取所有分类.
        $cats = Cats::getAllCats();
        return $this->render('create',['model'=>$model,'cats'=>$cats]);
    }

    public function actionView($id){
        $model = new ArticleForm();
        $data = $model->getViewById($id);

        // 文章统计
        $model = new ArticleExtends();
        $model->upCounter(['article_id'=>$id],'browser',1);

        return $this->render('view',['data'=>$data]);
    }

}