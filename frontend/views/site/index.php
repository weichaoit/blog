<?php

/* @var $this yii\web\View */

$this->title = '博客-首页';
?>
<div class="row">
    <div class="col-lg-9">
        <!--图片轮播组件-->
        <?=\frontend\widgets\banner\BannerWidget::widget()?>
        <!--文章列表组件-->
        <?=\frontend\widgets\article\ArticleWidget::widget()?>
    </div>
    <div class="col-lg-3">
        <!--留言板组件-->
        <?=\frontend\widgets\chat\ChatWidget::widget()?>
        <!--热门浏览组件-->
        <?=\frontend\widgets\hot\HotWidget::widget()?>
        <!--标签云组件-->
        <?=\frontend\widgets\tag\TagWidget::widget()?>
    </div>
</div>
