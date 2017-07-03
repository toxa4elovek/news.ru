<?php


namespace app\controllers;

use app\models\News;
use yii\web\Controller;
use yii\data\Pagination;
use Yii;

/*
 * Контроллер новостей
 * Выводит все превью новостей
 * Выводит полное описание новости
 */
class NewsController extends Controller
{
    public function actionIndex()
    {
        $query = News::find()->select('id, title, preview, description, img')->orderBy('id');
        $pages = New Pagination(['totalCount' => $query->count(), 'pageSize' => 5,
            'pageSizeParam' => false, 'forcePageParam' => false]);
        $model = $query->offset($pages->offset)->limit($pages->limit)->all();

        return $this->render('index', ['model' => $model, 'pages' => $pages]);
    }

    public function actionView()
    {
        if(Yii::$app->request->get('id'))
        {
            $model = News::findOne(Yii::$app->request->get('id'));
        }else return $this->goBack();

        return $this->render('view', ['model' => $model]);
    }

}