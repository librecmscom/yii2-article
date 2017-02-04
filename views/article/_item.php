<?php
use yii\helpers\Url;
use yii\helpers\Html;

?>
<section class="list-note-item col-lg-3 col-md-4">


    <h3><a href="<?= Url::to(['/article/article/view', 'id' => $model->id]); ?>"
           target="_blank"><?= Html::encode($model->title) ?></a></h3>
    <p>
        <?= Yii::$app->formatter->asRelativeTime($model->created_at); ?>
    </p>

</section>
