<?php
use \yii\widgets\ActiveForm;

$this->title = '创建';
$this->params['breadcrumbs'][] = ['label' => '文章' ,'url' => ['article/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <div class="col-lg-9">
        <div class="panel-title box-title">
            <span>创建文章</span>
        </div>
        <div class="panel-body">
            <?php $form = ActiveForm::begin() ?>
            <?=$form->field($model,'title')->textInput(['maxlength'=>true])?>
            <?=$form->field($model,'cat_id')->dropDownList($cats)?>
            <?=$form->field($model,'label_img')->widget('common\widgets\file_upload\FileUpload')?>
            <?= $form->field($model, 'content')->widget('common\widgets\ueditor\Ueditor',[
                'options'=>[
                    'initialFrameWidth' => 850,
                    'initialFrameHeight' => 400,
                ]
            ]) ?>
            <?=$form->field($model,'tags')->widget('common\widgets\tags\TagWidget')?>
            <?=\yii\helpers\Html::submitButton('发布',['class'=> 'btn btn-success'])?>
            <?php ActiveForm::end()?>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="panel-title box-title">
            <span>注意事项</span>
        </div>
        <div class="panel-body">
            <p>1.xxxxxxxx</p>
            <p>2.yyyyyyyy</p>
            <p>3.zzzzzzzz</p>
        </div>
    </div>
</div>
