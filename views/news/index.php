<?php
use yii\widgets\LinkPager;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
?>
<div class="site-index">

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

    <div class="body-content">
        <div class="container">
            <h3>Свежие новости:</h3>
            <div class="container">
            </div>
            <table class="table table-condensed">
                <?foreach ($model as $news):?>
                    <tr>

                        <td class="col-md-3"><?=\yii\helpers\Html::img('/images/news/'.$news->img, ['width' => 160])?></td>

                        <td class="col-md-9">

                            <?=Html::a($news->title, ['/view', 'id' => $news->id])?>
                            <p><?=$news->preview;?></p>
                        </td>

                    </tr>

                <?php endforeach;?>
            </table>
        </div>
        <?=LinkPager::widget(['pagination' => $pages])?>


    </div>
</div>

