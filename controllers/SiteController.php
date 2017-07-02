<?php

namespace app\controllers;

use app\models\AccountActivation;
use app\models\User;
use Yii;
use yii\base\InvalidParamException;
use yii\filters\AccessControl;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm as LoginModel;
use app\models\ContactForm;
use app\models\Signup;

class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->getUser()->isGuest) {
            return $this->goHome();
        }

        $model = new LoginModel();
        if ($model->load(Yii::$app->getRequest()->post()) && $model->login()) {
            return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    public function actionSignup()
    {
        if(Yii::$app->user->isGuest) {
            $emailActivation = Yii::$app->params['emailActivation'];
            $model = $emailActivation ? new Signup(['scenario' => 'emailActivation']) : New Signup();

            if ($model->load(Yii::$app->getRequest()->post())) {
                if ($user = $model->signup()) {
                    if ($user->status === User::STATUS_ACTIVE) {
                        if (Yii::$app->getUser()->login($user))
                            return $this->goHome();
                    } else {
                        if ($model->sendActivationEmail($user) ) {
                            $model->sendAdminEmail($user);
                            Yii::$app->session->setFlash('success', "Письмо успешно отправлено на email<strong>" . Html::encode($user->email) . "</strong> проверьте вашу почту");

                        } else {
                            Yii::$app->session->setFlash('error', 'При отправке письма произошла ошибка');
                            Yii::error('Ошибка отправки письма');
                        }
                        return $this->refresh();
                    }

                }
            }

            return $this->render('signup', [
                'model' => $model,
            ]);
        } else return $this->goHome();
    }

    public function actionActivateAccount($key)
    {
        try{
            $user = New AccountActivation($key);
        }
        catch (InvalidParamException $e){
            throw new InvalidParamException($e->getMessage());
        }

        if($user->activateAccount())
            Yii::$app->session->setFlash('success','Активация прошла успешно');

        else{
            Yii::$app->session->setFlash('error', 'Ошибка активации');
            Yii::error('Ошибка при активации');
        }

        return $this->redirect(Url::to(['news/index']));
    }


    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }
}
