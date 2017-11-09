<div class="row">
    <div class="col-lg-9">
        <?=\frontend\widgets\article\ArticleWidget::widget(['limit'=>10])?>
    </div>
    <div class="col-lg-3">
        <!--热门浏览组件-->
        <?=\frontend\widgets\hot\HotWidget::widget()?>
        <!--标签云组件-->
        <?=\frontend\widgets\tag\TagWidget::widget()?>
    </div>
</div>
