<?php 

use yii\helpers\Url;
use yii\helpers\Html;

?>
<h3 class="content-header d-lg-block text-lg-left text-center new-cont"><?= $this->params['pageTitle']?></h3>
<div class="about">
    <div class="row">
        <div class="col-12">
            <div class="about-content">
                <?php if(isset($model->content) && !empty($model->content)) :?>
                    <?= $model->content;?>
                <?php else: ?>
                    Нет содержимого
                <?php endif;?>
            </div>
        </div>
    </div>
</div>
