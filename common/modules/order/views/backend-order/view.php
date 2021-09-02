<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;
use common\modules\content\models\Menu;
?>
<div class="row">
    <?php if( Yii::$app->session->hasFlash('success') ): ?>
        <div class="col-12">
            <div class="alert alert-success alert-dismissible" role="alert" id="success-alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <?php echo Yii::$app->session->getFlash('success'); ?>
            </div>
        </div>
    <?php endif;?>
    <?php if( Yii::$app->session->hasFlash('error') ):?>
        <div class="col-12">
            <div class="alert alert-danger alert-dismissible" role="alert" id="error-alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <?php echo Yii::$app->session->getFlash('error'); ?>
            </div>
        </div>
    <?php endif;?>
    <div class="col-12">
        <div class="x_panel">
            <div class="x_title">
                <h1><?= Html::encode($this->title) ?></h1>
                <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                    </li>
                    <li><a class="close-link"><i class="fa fa-close"></i></a>
                    </li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <p>
                    <?= Html::a('Изменить',Url::toRoute(['/order/update/'.$model->id]), ['class' => 'btn btn-primary']) ?>
                    <?= Html::a('Удалить',Url::toRoute(['/order/delete/'.$model->id]), [
                        'class' => 'btn btn-danger',
                        'data' => [
                            'confirm' => 'Вы точно хотите удалить ?',
                            'method' => 'post',
                        ],
                    ]) ?>
                    <?= Html::a('Уведомить',Url::toRoute(['/order/notificate/'.$model->id]), [
                        'class' => 'btn btn-success',
                        'data' => [
                            'confirm' => 'Вы точно хотите уведомить пользователей о новом заказе ?',
                            'method' => 'get',
                        ],
                    ]) ?>
                </p>
                <?= DetailView::widget([
                    'model' => $model,
                    'attributes' => [
                        'id',
                        [
                            'attribute' => 'author_id',
                            'format' => 'text',
                            'label' => 'Автор',
                            'value' => function($model)
                            {
                                return (!empty($model->author->username)) ? $model->author->username : $model->author->email;
                            }
                        ],
                        [
                            'attribute' => 'category_id',
                            'format' => 'html',
                            'label' => 'Категория',
                            'value' => function($model)
                            {
                                return (!empty($model->category_id)) ? '<a href="'.Url::toRoute(['/category/'.$model->category->url]).'">'.$model->category->title.'</a>' : 'Нет категории';
                            }
                        ],
                        [
                            'attribute' => 'content',
                            'format' => 'text',
                            'label' => 'Описание заказа',
                            'value' => function($model){
                                return (!empty($model->content)) ? $model->content : 'Нет описания';
                            }
                          
                        ],
                        [
                            'attribute' => 'author_name',
                            'format' => 'text',
                            'label' => 'Имя автора',
                        ],
                         [
                            'attribute' => 'author_phone',
                            'format' => 'text',
                            'label' => 'Номер автора',
                        ],
                        [
                            'attribute' => 'status',
                            'format' => 'text',
                            'label' => 'Статус',
                            'value' => function($model)
                            {
                                return ($model->status !== 0) ? 'Активен' : 'Не активен';
                            }
                        ],
                        [
                            'attribute'=>'created_at',
                            'format'=>['date','php: yy-m-d H:i:s'],//raw, html
                            'label' => 'Дата создания',
                        ],
                        [
                            'attribute'=>'updated_at',
                            'format'=>['date','php: yy-m-d H:i:s'],//raw, html
                            'label' => 'Дата обновления',
                        ],

                    ],
                ]) ?>
            </div>
        </div>
    </div>
</div>