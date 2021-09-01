<?php 

use yii\helpers\Url;
use yii\helpers\Html;

?>
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
