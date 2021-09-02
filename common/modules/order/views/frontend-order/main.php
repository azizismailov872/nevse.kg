<?php 

use common\widgets\OrderList;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\widgets\LinkPager;
use yii\widgets\Pjax;
?>
<?= $this->render('categories-carusel') ?>
<h3 class="content-header d-lg-block text-lg-left text-center new-cont">Новые заказы</h3>
<div class="orders-list" id="orders-list">
<?php Pjax::begin(['id' => 'orders-list-pjax']);?>
    <?php if(isset($orders) && !empty($orders)) :?>
        <?= OrderList::widget(['orders' => $orders]);?>
    <?php Pjax::end();?>
        <?= LinkPager::widget([
            'pagination' => $pagination,
            'activePageCssClass' => 'active',
            'maxButtonCount' => 5,
            'options' => ['class' => 'pagination'],
            'linkContainerOptions' => ['class' => 'pager'],
            'linkOptions' => [
                'class' => 'pager-link',
            ], 
        ]); ?>
    <?php else: ?>
        <div class="no-order">
            <h2 class="no-order-header">Нет заказов</h2>
        </div>
    <?php endif;?>
</div>
<div class="popup success">
    <div class="popup-content">
        <span class="popup-close fa fa-close"></span>
        <div class="popup-body">
            <h3 class="success-header">Ваш заказ успешно создан<br>Ожидайте звонка <br class="d-md-none d-block">от специалистов</h3>
            <div class="success-img">
                <img src="/frontend/themes/vse/img/success.png" alt="">
            </div>
        </div>
    </div>
</div>