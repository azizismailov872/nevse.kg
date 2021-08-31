<?php

use yii\helpers\Html;
use frontend\themes\vse\assets\AppAsset;
use common\modules\order\models\Category;
use common\modules\content\models\Menu;
use yii\widgets\Pjax;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
<meta charset="<?= Yii::$app->charset ?>">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<?php $this->registerCsrfMetaTags() ?>
<title>
    <?= Html::encode($this->title) ?>
</title>
<?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>
    <div class="wrap">
        <?= $this->render('header');?>
        <section class="profile-content">
            <div class="sidebar-wrap"></div>
            <div class="container">
            <?php Pjax::begin(['id' => 'alerts']);?>
                <?php if( Yii::$app->session->hasFlash('success') ): ?>
                <div class="row">
                    <div class="col-12">
                        <div class="alert alert-success alert-dismissible" role="alert" id="success-alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <?php echo Yii::$app->session->getFlash('success'); ?>
                        </div>
                    </div>
                </div>
                <?php endif;?>
                <?php if( Yii::$app->session->hasFlash('error') ):?>
                    <div class="row">
                        <div class="col-12">
                            <div class="alert alert-success alert-dismissible" role="alert" id="error-alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <?php echo Yii::$app->session->getFlash('error'); ?>
                            </div>
                        </div>
                    </div>
                <?php endif;?>
            <?php Pjax::end();?>
                <div class="row">
                    <div class="col-lg-4">
                        <?= $this->render('sidebar');?>
                    </div>
                    <div class="col-lg-8 mb-lg-0 mb-3">
                       <?= $content;?>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <div class="up-to-top" id="up-to-top"></div>
    <script>
    var url = 'https://wati-integration-service.clare.ai/ShopifyWidget/shopifyWidget.js?36989';
    var s = document.createElement('script');
    s.type = 'text/javascript';
    s.async = true;
    s.src = url;
    var options = {
  "enabled":true,
  "chatButtonSetting":{
      "backgroundColor":"#4dc247",
      "ctaText":"",
      "borderRadius":"25",
      "marginLeft":"0",
      "marginBottom":"65",
      "marginRight":"15",
      "position":"right"
  },
  "brandSetting":{
      "brandName":"VSE.KG",
      "brandSubTitle":"Напишите нам !",
      "brandImg":"https://cdn.icon-icons.com/icons2/2037/PNG/512/media_social_whatsapp_icon_124250.png",
      "welcomeText":"Здравствуйте, чем можем вам помочь?",
      "messageText":"Здравствуйте, я с сайта nevse.kg",
      "backgroundColor":"#0a5f54",
      "ctaText":"Отправить",
      "borderRadius":"25",
      "autoShow":false,
      "phoneNumber":"996708903088"
  }
};
    s.onload = function() {
        CreateWhatsappChatWidget(options);
    };
    var x = document.getElementsByTagName('script')[0];
    x.parentNode.insertBefore(s, x);
</script>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>