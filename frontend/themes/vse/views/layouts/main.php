<?php

use yii\helpers\Html;
use frontend\themes\vse\assets\AppAsset;
use common\modules\order\models\Category;
use common\modules\content\models\Menu;
use yii\widgets\Pjax;
use yii\helpers\Url;

$menuList = Menu::getSidebarMenuList();

$categoriesList = Category::getCategoryList();

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100;200;400;500;600;700;900&display=swap" rel="stylesheet">
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="keywords" content="Vsё – Найти товары и услуги в Кыргызстане легко!">
    <meta name="description" content="Создайте заказ и найдите любой товар и услугу в Бишкеке и Кыргызстане.
    Не нужно искать и тратить время на поиски. Просто напишите, что вы хотите и вам перезвонят исполнители/продавцы. Это Бесплатно!">
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
        <section class="category" style="background-image: url(<?= Yii::$app->params['defaultCategoryBg'];?>);">
            <div class="row align-items-center">
                <div class="col-12">
                    <h2><a href="<?= Url::toRoute([Yii::$app->params['categoryUrl']]);?>" class="category-title"><?= Yii::$app->params['categoryTitle'];?></a></h2>
                    <?php if(Yii::$app->params['categorySubTitle'] !== null):?>
                        <h3 class="category-sub-title text-center"><?= Yii::$app->params['categorySubTitle'];?></h3>
                    <?php endif;?>
                </div>
            </div>
        </section>
        <section class="main">
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
                        <?= $this->render('sidebar',[
                            'menuList' => $menuList,
                            'categoriesList' => $categoriesList,
                        ]);?>
                    </div>
                    <div class="col-lg-8">
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
      "marginBottom":"10",
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