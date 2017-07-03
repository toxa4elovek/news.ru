<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \mdm\admin\models\form\Signup */

$this->title =  'Регистрация';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-signup">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Пожалуйста заполните все поля для регистрации</p>
    <?= Html::errorSummary($model)?>
    <div class="row">
        <div class="col-lg-5">
            <?if (is_string(Yii::$app->session->getFlash('success'))):?>
            <div class="alert alert-success">
                <?=Yii::$app->session->getFlash('success')?>
            </div>
            <?endif;?>

            <?php if(is_string(Yii::$app->session->getFlash('error'))):?>
                <div class="alert alert-danger">
                    <?=Yii::$app->session->getFlash('error')?>
                </div>
            <?endif;?>


            <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>
            <?= $form->field($model, 'username') ?>
            <?= $form->field($model, 'email') ?>
            <?= $form->field($model, 'password')->passwordInput() ?>
            <div class="form-group">
                <?= Html::submitButton('Регистрация', ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
            </div>
            <?php ActiveForm::end(); ?>

            <?php if($model->scenario === 'emailActivation'):?>
                <div class="alert alert-warning">
            <i>*На указанный email будет выслано письмо активации аккаунта</i>
                </div>
            <?endif;?>
        </div>
    </div>
</div>
