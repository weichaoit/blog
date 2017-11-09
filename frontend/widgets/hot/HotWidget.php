<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/9
 * Time: 17:09
 */

namespace frontend\widgets\hot;


use common\models\Article;
use common\models\ArticleExtends;
use yii\bootstrap\Widget;
use yii\db\Query;

class HotWidget extends Widget {

    public $title = '';

    public $limit = 6;

    public function run() {
        $res = (new Query())
            ->select('a.browser,b.id,b.title')
            ->from(['a'=>ArticleExtends::tableName()])
            ->join('LEFT JOIN',['b'=>Article::tableName()],'a.article_id=b.id')
            ->where('b.is_valid='.Article::IS_VALID)
            ->orderBy(['browser'=>SORT_DESC,'id'=>SORT_DESC])
            ->limit($this->limit)
            ->all();

        $result['title'] = $this->title?:'热门浏览';
        $result['body'] = $res?:[];
        return $this->render('index',['data'=>$result]);
    }


}