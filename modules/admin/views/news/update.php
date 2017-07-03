<?php
use yii\bootstrap\ActiveForm;
use kartik\file\FileInput;
use yii\helpers\Html;
?>

<h1 class="text-center">Редактировать новость</h1>
<div class="container">
<?$form = ActiveForm::begin([
    'id' => 'update-form',
    'layout' => 'horizontal',
    'fieldConfig' => [
        'template' => "{label}\n<div class=\"col-lg-6\" style='width: 90%'>{input}</div>\n<div class=\"col-lg-3\">{error}</div>",
        'labelOptions' => ['class' => 'col-lg-3 control-label'],
    ],
])?>

<?=$form->field($model,'title')
    ->textInput(['value' => $model->title])
    ->label(false)?>

<?=$form->field($model,'preview')
    ->textarea(['placeholder' => 'Значение превью не должно превышать 255 символов'])
    ->label(false)?>

<?=$form->field($model,'description')
    ->textarea(['value' => $model->description])
    ->label(false)?>

<?= $form->field($model, 'img')->widget(FileInput::classname(), [
    'options' => ['accept' => 'image/*'],
    'pluginOptions' => [
        'showUpload' => false,
        'showPreview' => true,
        'maxFileCount' => 1,
        'showClose' => false,
        'layoutTemplates' => 'main1',
        'allowedFileType' => ['image'],
        'allowedPreviewType' => ['image'],
        'defaultPreviewContent' =>
            Html::img('/images/news/'.$model->img, ['width' => 240]),
        'browseLabel' => 'Заменить фото...'
    ]
])->label('');?>

<div class="row">
    <div class="col-lg-3" style="width: 90%">
        <?= Html::submitButton('Обновить новость', ['class' => 'btn btn-primary']) ?>
    </div>

    <div class="col-lg-3" style="margin-top: 20px" ">
        <?= Html::a('Удалить новость', ['/admin/news/delete?id='.$model->id], ['class'=>'btn btn-primary']) ?>
    </div>
</div>
</div>

<?php ActiveForm::end()?>