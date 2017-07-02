<?php
use yii\widgets\LinkPager;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
?>
<div class="site-index">

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
                            <p><?=$news->description?>
                        </td>

                    </tr>

                <?php endforeach;?>
            </table>
        </div>
        <?=LinkPager::widget(['pagination' => $pages])?>


    </div>
</div>

