<?php
$this->title = $data['title'];
$this->params['breadcrumbs'][] = ['label'=>'文章','url'=>['post/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <div class="col-lg-9">
        <div class="page-title">
            <h1><?=$data['title']?></h1>
            <span>作者:<?=$data['user_name']?></span>
            <span>发布:<?=date('Y-m-d H:i:s',$data['created_at'])?></span>
            <span>浏览:<?=$data['extend']['browser']?>次</span>
        </div>
        <div class="page-content">
            <?=$data['content']?>
        </div>

        <div class="page-tag">
         标签:
            <?php foreach ($data['tags'] as $tag): ?>
                <span><a href="#"><?=$tag?></a> </span>
            <?php endforeach;?>
        </div>
    </div>
    <div class="col-lg-3">
        <a href="<?=\yii\helpers\Url::to(['article/create'])?>" class="btn btn-success article-btn">
        创建文章
        </a>
        <a href="<?=\yii\helpers\Url::to(['article/edit','id'=>\Yii::$app->request->get('id')])?>" class="btn btn-primary article-btn">
        编辑文章
        </a>
        <!--热门浏览组件-->
        <?=\frontend\widgets\hot\HotWidget::widget()?>
        <!--标签云组件-->
        <?=\frontend\widgets\tag\TagWidget::widget()?>
    </div>

</div>
