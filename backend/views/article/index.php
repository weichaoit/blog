<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\ArticleSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '内容管理';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="article-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'title'=>[
                'attribute' => 'title',
                'format' => 'raw',
                'value' => function($model){
                    return '<a href="'.Yii::$app->params['base_url'].\yii\helpers\Url::to(['article/view','id'=>$model->id]).'">'.$model->title.'</a>';
                },
            ],
            'summary',
//            'content:ntext',
//            'label_img',
             'cat.cat_name',
            // 'user_id',
             'user_name',
             'is_valid'=>[
                     'attribute' => 'is_valid',
                     'value' => function($model){
                         return ($model->is_valid == 1)?'有效':'无效';
                     },
                     'filter' => [1=>'有效',0=>'无效'],
             ],
             'created_at:datetime',
            // 'updated_at',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
