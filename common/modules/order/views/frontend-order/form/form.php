<?php 
use yii\widgets\ActiveForm;
use yii\helpers\Url;

?>
<div class="guest__content">
    <h1 class="guest__title">
        Выполним ваш заказ <br>Все услуги на одном сайте
    </h1>
    <div class="guest__form-container">
    	<?php $form = ActiveForm::begin([
    		'id' => 'guest-order-form',
			'enableClientValidation' => false,
		    'enableAjaxValidation' => true,
		    'validateOnType' => false,
		    'validateOnChange' => false,
		    'validateOnBlur' => false,
		    'validateOnSubmit' => true,
		    'validationUrl' => Url::toRoute(['/order/validate-form']),
			'options' => [
				'class' => 'guest__form'
			]
		])?>
			<?= $form->field($model,'content',[
				'template' => "
					<div class='guest__order-input-container'>
						{input}
						<button type='button' id='new-order' class='guest__order-button popup-open weight d-lg-block d-none'>
							Создать заказ
						</button>
					</div>
					<button class='button weight custom-btn green d-lg-none d-block mt-2 full new-order-btn popup-open' id='new-order' type='button'>
						Cоздать заказ
					</button>
					{error}
				",
				'options' => [
					'tag' => 'div'
				],
				'errorOptions' => [
		            'tag' => 'span',
		            'class' => 'error-message'
		        ],
			])->textInput(['placeholder' => 'Напишите ваш заказ', 'class' => 'guest__order-input']) ?>
			<div class="popup new-order">
			    <div class="popup-content">
			        <span class="popup-close fa fa-close"></span>
			        <div class="popup-body">
			            <div class="row">
			                <div class="col-12">
			                    <h3 class="new-order-header">Укажите информацию</h3>
			                </div>
			                <div class="col-12">
			                    <p class="new-order-text">Выберите категорию и введите номер телефона для связи</p>
			                </div>
			            </div>
			            <?= $form->field($model,'category_id',[
						    'template' => '
						        <div class="col-12">
						             {error}
						        </div>
						        <div class="col-12 pr-lg-2 mb-lg-3 mb-md-2">
						            {input}
						        </div>
						    ',
						    'options' => [
						        'tag' => 'div',
						        'class' => 'row justify-content-end',
						    ],
						    'errorOptions' => [
						        'tag' => 'span',
						        'class' => 'error-message'
						    ],
						    'validateOnChange' => true,
						])->dropDownList($categoriesList,['class' => 'order-form-select custom-select','prompt' => 'Выберите категорию']);?>
			            <?= $form->field($model,'author_phone',[
			                'template' => '
			                    <div class="col-12">
			                        {error}
			                    </div>
			                    <div class="col-12 pr-lg-2">
			                        <div class="input__container new-order-phone w-100">
			                            {input}
			                            <i class="bx bx-phone icon"></i>
			                            <div class="bg"></div>
			                        </div>
			                    </div>
			                    <div class="col-12">
			                        <button class="button green full new-order-btn" id="create-order-btn" type="submit">Создать запрос</button>
			                    </div>
			                ',
			                'options' => [
			                    'tag' => 'div',
			                    'class' => 'row',
			                ],
			                'errorOptions' => [
			                    'tag' => 'span',
			                    'class' => 'error-message',
			                ],
			                'validateOnChange' => true,
			            ])->textInput(['class' => 'mask','placeholder' => '+996','value' => $phoneValue,'inputmode' => 'tel']);?>
			        </div>
			    </div>
			</div>
		<?php ActiveForm::end();?>
    </div>
</div>