<?php
namespace app\models;

use yii\base\Model;
use app\models\News;
use Yii;
use yii\helpers\Html;

class NewsForm extends Model
{
    public $title;
    public $preview;
    public $description;
    public $img;

    public function rules()
    {
        return [
            [['title', 'description', 'preview'], 'required' , 'trim'],
            ['img', 'image']
        ];
    }

    public function reg()
    {
        $news = New News();
        $news->title = Html::encode($this->title);
        $news->preview = Html::encode($this->preview);
        $news->description = Html::encode($this->description);
        $news->img = ($this->img->name) ? $this->img->name : $this->img;
        $news->created_at = time();
        $news->id_user = 'id_user';

        return $news->save() ? $news : null;
    }
}