<?php
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use kartik\file\FileInput;
?>

<h1 class="text-center">Добавить новость</h1>

<?$form = ActiveForm::begin([
    'id' => 'addnews-form',
    'layout' => 'horizontal',
    'fieldConfig' => [
        'template' => "{label}\n<div class=\"col-lg-6\" style='width: 90%'>{input}</div>\n<div class=\"col-lg-3\">{error}</div>",
        'labelOptions' => ['class' => 'col-lg-3 control-label'],
    ],
])?>

<?=$form->field($model,'title')
    ->textInput(['placeholder' => 'Введите заголовок'])
    ->label(false)?>
<?=$form->field($model,'preview')
    ->textarea(['placeholder' => 'Значение превью не должно превышать 255 символов'])
    ->label(false)?>

<?=$form->field($model,'description')
    ->textarea(['placeholder' => 'Заполните описание'])
    ->label(false)?>

<?= $form->field($model, 'img')->widget(FileInput::classname(), [
    'options' => ['accept' => 'image/*'],
    'pluginOptions' => [
        'showUpload' => false,
        'maxFileCount' => 1,
        'showClose' => false,
        'layoutTemplates' => 'main1',
        'allowedFileType' => ['image'],
        'allowedPreviewType' => ['image'],
        'browseLabel' => 'Выберите фото новости...'
    ]
])->label('');?>

<div class="form-group">
    <div class="col-lg-6" style="width: 90%">
    <?= Html::submitButton('Добавить новость', ['class' => 'btn btn-primary']) ?>
    </div>
</div>

<?php ActiveForm::end()?>
