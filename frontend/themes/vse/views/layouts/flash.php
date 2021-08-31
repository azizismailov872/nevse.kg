<?php
use yii\widgets\Pjax;
?>
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