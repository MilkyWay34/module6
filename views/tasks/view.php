<?php

/**
 * @var Task $model
 */

use app\assets\YandexAsset;
use app\helpers\UIHelper;
use app\models\Opinion;
use app\models\Reply;
use app\models\Task;
use app\models\User;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;
use yii\widgets\ActiveForm;
use function morphos\Russian\pluralize;

$this->title = 'Просмотр задания';

/**
 * @var User $user
 * @var View $this
 * @var Reply $newReply
 * @var Opinion $opinion
 */
$user = Yii::$app->user->getIdentity();
$this->registerJsFile('/js/main.js');

YandexAsset::register($this);
?>

<div class="left-column">
    <div class="head-wrapper">
        <h3 class="head-main"><?=Html::encode($model->name); ?></h3>
        <p class="price price--big"><?=$model->budget; ?>&nbsp;₽</p>
    </div>
    <p class="task-description"><?=Html::encode($model->description); ?></p>

    <h4 class="head-regular">Отклики на задание</h4>

    <?php foreach ($model->getReplies($user)->all() as $reply): ?>
    <div class="response-card">
        <img class="customer-photo" alt="Фото исполнителя" src="<?=$reply->user->avatar;?>" width="146" height="156">
        <div class="feedback-wrapper">
            <a href="<?=Url::to(['user/view', 'id' => $reply->user_id]); ?>" class="link link--block link--big"><?=Html::encode($reply->user->name);?></a>
            <div class="response-wrapper">
                <?=UIHelper::showStarRating($reply->user->rating); ?>
                <?php $reviewsCount = $reply->user->getOpinions()->count(); ?>
                <p class="reviews"><?=pluralize($reviewsCount, 'отзыв'); ?></p>
            </div>
            <p class="response-message">
                <?=Html::encode($reply->description);?>
            </p>
        </div>
        <div class="feedback-wrapper">
            <p class="info-text"><?=Yii::$app->formatter->asRelativeTime($reply->dt_add); ?></p>
            <p class="price price--small"><?=$reply->budget; ?> ₽</p>
        </div>
    </div>
    <?php endforeach; ?>
</div>
<div class="right-column">
    <div class="right-card black info-card">
        <h4 class="head-card">Информация о задании</h4>
        <dl class="black-list">
            <dt>Категория</dt>
            <dd><?=$model->category->name; ?></dd>
            <dt>Дата публикации</dt>
            <dd><?=Yii::$app->formatter->asRelativeTime($model->dt_add); ?></dd>
            <dt>Срок выполнения</dt>
            <dd><?=Yii::$app->formatter->asDatetime($model->expire_dt); ?></dd>
            <dt>Статус</dt>
            <dd><?=$model->status->name; ?></dd>
        </dl>
    </div>
</div>