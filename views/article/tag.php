<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ListView;

$this->title = Html::encode($model->name);
$this->params['breadcrumbs'][] = Yii::t('article', 'Articles');
$this->params['breadcrumbs'][] = Html::encode($model->name);
?>
<div class="row">
    <div class="col-xs-12 col-md-9 main">
        <section class="tag-header mt-20">
            <div>
                <span class="h4 tag-header-title"><?=Html::encode($model->name)?></span>

                <div class="tag-header-follow">
                    <?php
                    if (!Yii::$app->user->isGuest && Yii::$app->user->identity->hasTagValues($model->id)) {
                        ?>
                        <button type="button" data-target="follow-tag" class="btn btn-default btn-xs active"
                                data-source_id="<?= $model->id ?>" data-show_num="false" data-toggle="tooltip"
                                data-placement="right" title="" data-original-title="关注后将获得更新提醒">已关注
                        </button>
                        <?php
                    } else {
                        ?>
                        <button type="button" data-target="follow-tag" class="btn btn-default btn-xs"
                                data-source_id="<?= $model->id ?>" data-show_num="false" data-toggle="tooltip"
                                data-placement="right" title="" data-original-title="关注后将获得更新提醒">关注
                        </button>
                        <?php
                    }
                    ?>
                </div>
            </div>
            <p class="tag-header-summary"><?= empty($model->description) ? Yii::t('question', 'No introduction') : Html::encode($model->description); ?></p>
        </section>
        <?= ListView::widget([
            'options' => [
                'class' => 'stream-list blog-stream'
            ],
            'itemOptions' => ['tag' => 'section', 'class' => 'stream-list-item clearfix'],
            'layout' => '{items} <div class="text-center">{pager}</div>',
            'pager' => [
                'maxButtonCount' => 10,
                'nextPageLabel' => Yii::t('app', 'Next page'),
                'prevPageLabel' => Yii::t('app', 'Previous page'),
            ],
            'dataProvider' => $dataProvider,
            'itemView' => '_item'
        ]);
        ?>
    </div><!-- /.main -->

    <div class="col-xs-12 col-md-3 side">

        <?= \yuncms\article\widgets\PopularArticle::widget(['limit'=>10,'cache'=>3600]); ?>

        <?= \yuncms\article\widgets\PopularTag::widget(['limit'=>10,'cache'=>3600]); ?>
    </div><!-- /.side -->
</div>