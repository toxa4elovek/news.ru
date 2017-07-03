<?php

namespace app\models;

use yii\base\Model;
use yii\helpers\Html;

/*
 * Модель формы редактирования новостей
 */
class UpdateForm extends Model
{
    public $id;
    public $title;
    public $preview;
    public $description;
    public $img;

    public function rules()
    {
        return [
            [['title', 'description', 'preview'], 'required']
        ];
    }

    public function getNewsOne($id)
    {
        $news = News::findOne($id);
        $this->id = $id;
        $this->title = $news->title;
        $this->preview = $news->preview;
        $this->description = $news->description;
        $this->img = $news->img;
    }

    public function update($id)
    {
        $news = News::findOne($id);
        $news->title = Html::encode($this->title);
        $news->preview = Html::encode($this->preview);
        $news->description = Html::encode($this->description);
        $news->img = ($this->img) ? $this->img : $news->img;
        $news->updated_at = time();

        return $news->update() ? $news : null;
    }
}