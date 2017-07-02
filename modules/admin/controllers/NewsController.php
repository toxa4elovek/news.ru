<?php
/**
 * Created by PhpStorm.
 * User: a.valkov
 * Date: 28.06.2017
 * Time: 15:41
 */

namespace app\modules\admin\controllers;

use app\models\News;
use app\models\UpdateForm;
use yii\data\Pagination;
use yii\web\Controller;
use app\models\NewsForm;
use Yii;
use yii\web\UploadedFile;


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

    public function actionAdd()
    {
        $model = new NewsForm();

        if ($model->load(Yii::$app->request->post()) && $model->validate())
        {
            if($model->img = UploadedFile::getInstance($model, 'img')){
                $model->img->name = 'news_'.date('hms').'.'.$model->img->extension;
                $model->img->saveAs('images/news/'.$model->img->name);
            }else $model->img = 'default.jpg';

            if ($news = $model->reg())
            {
                return $this->goHome();
            }else
            {
                Yii::$app->session->setFlash('erorr', 'Возникла ошибка при добавлении');
                Yii::error('Ошибка при добавлении новости');
                return $this->refresh();
            }
        }

        return $this->render('add', ['model' => $model]);
    }

    public function actionView()
    {
        if(Yii::$app->request->get('id'))
        {
            $model = News::findOne(Yii::$app->request->get('id'));
        }else return $this->goBack();

        return $this->render('view', ['model' => $model]);
    }

    public function actionUpdate()
    {
        $model = New UpdateForm();
        $model->getNewsOne(Yii::$app->request->get('id'));

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if($model->img = UploadedFile::getInstance($model, 'img')){
                $model->img->name = 'news_'.date('hms').'.'.$model->img->extension;
                $model->img->saveAs('images/news/'.$model->img->name);
            }else $model->img = '';


            if ($news = $model->update(Yii::$app->request->get('id')))
                return $this->redirect('/admin/news');
            else{
                Yii::$app->session->setFlash('erorr', 'Возникла ошибка при добавлении');
                Yii::error('Ошибка при добавлении новости');
                return $this->refresh();
            }
        }
        return $this->render('update', ['model' => $model]);
    }

    public function actionDelete()
    {
        $model = News::findOne(Yii::$app->request->get('id'));
        if($model->delete())
            return $this->goHome();
    }

}