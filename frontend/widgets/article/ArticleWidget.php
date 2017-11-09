<?php
namespace frontend\widgets\article;
use common\models\Article;
use frontend\models\ArticleForm;
use yii\base\Widget;
use yii\data\Pagination;
use yii\helpers\Url;

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/8
 * Time: 15:03
 *
 * 文章列表组件
 */
class ArticleWidget extends Widget {

    /**
     * 文章列表.
     * @var string
     */
    public $title = '';

    /**
     * 显示条数.
     * @var int
     */
    public $limit = 10;

    /**
     * 是否显示更多.
     * @var bool
     */
    public $more = true;

    /**
     * 是否显示分页.
     * @var bool
     */
    public $page = true;

    public function run() {
        $curPage = \Yii::$app->request->get('page',1);
        // 查询条件.
        $cond = ['=','is_valid',ArticleForm::IS_VALID];
        $res = ArticleForm::getList($cond,$curPage,$this->limit);

        $result['title'] = $this->title ?:'最新文章';
        $result['more'] = Url::to('/article/index');
        $result['body'] = $res['data']?:[];
        if($this->page){
            $pages = new Pagination(['totalCount'=>$res['count'],'pageSize'=>$res['pageSize']]);
            $result['page'] = $pages;
        }


        return $this->render('index',['data'=>$result]);
    }
}