<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user common\models\User */

$verifyLink = Yii::$app->urlManager->createAbsoluteUrl(['site/verify-email', 'token' => $user->verification_token]);
?>
<div class="verify-email">

    <p>Перейдите по ссылке чтобы сбросить пароль</p>

    <p><?= Html::a(Html::encode($verifyLink), $verifyLink) ?></p>
</div>
