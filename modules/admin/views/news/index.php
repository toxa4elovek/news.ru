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
                       <h4> <?=Html::a($news->title, ['/admin/news/view', 'id' => $news->id])?></h4>
                       <p><?=$news->preview?>
                   </td>
                   <td>

                           <?=Html::a(" <span class=\"glyphicon glyphicon-pencil\"></span>", ['news/update', 'id' => $news->id])?>

                   </td>

                </tr>

            <?php endforeach;?>
            </table>
        </div>
        <?=LinkPager::widget(['pagination' => $pages])?>


    </div>
</div>

