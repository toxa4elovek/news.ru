<?php
use yii\helpers\Html;
?>

<div class="body-content">
    <div class="container">
        <?=Html::a(" <span class=\"glyphicon glyphicon-arrow-left\"></span>", ['/admin/news'])?>
        <?=Html::a(" <span class=\"glyphicon glyphicon-pencil\"></span>", ['news/update', 'id' => $model->id])?>
    <div class="row">
        <div class="col-md-12">
            <h3><?=$model->title?></h3>

        </div>
        <div class="col-md-6">
            <?=Html::img('/images/news/'.$model->img, ['class' => 'img-responsive'])?>
        </div>
        <div class="col-md-12" style="margin-top: 20px">
            <p class="text-left"><?=$model->preview?></p>
            <p class="text"><?=$model->description?></p>
        </div>

    </div>
    </div>
</div>