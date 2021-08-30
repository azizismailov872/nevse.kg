<?php 

namespace common\widgets;

use Yii;
use common\modules\order\models\PaidOrders;
use yii\base\Widget;
use yii\helpers\Html;
use yii\helpers\Url;


class OrderButton extends Widget 
{

	public $user;

	public $order;

	public $paid;

	public $phone;

	public $length;

	public function init()
	{
		parent::init();

		if(!Yii::$app->user->isGuest)
		{
			$this->user = Yii::$app->user->identity;

			$this->paid = PaidOrders::find()->where(['user_id' => $this->user->id,'order_id' => $this->order->id])->one();
		}

		$this->phone = $this->order->author_phone;
		$this->length = mb_strlen($this->phone) - 2;
	}

	public function run()
	{
		if(Yii::$app->user->can('updateOrder',['item' => $this->order]) or Yii::$app->user->can('admin'))
		{
			$content = '
				<div class="col-lg-4">'.
					Html::a('Редактировать',Url::toRoute(['/order/update/'.$this->order->id]),[
						'class' => 'button full green mb-sm-10'
					])
				.'
				</div>
				<div class="col-lg-4">'.
					Html::a('Удалить',Url::toRoute(['/order/delete/'.$this->order->id]),[
						'class' => 'button red full',
					])
				.'
			';
		}
		elseif(isset($this->paid) && !empty($this->paid))
		{
			if($this->order->status == 0)
			{
				$content = '
					<div class="col-lg-4">'.
						Html::button($this->phone,[
							'class' => 'button full green',
							'id' => 'no-active',
						])
					.'
				';
				/*$content = '<div class="col-lg-4">
					<span class="author-phone" id="no-active">'.$this->phone.'</span>';*/
			}
			else
			{
				$content = '
					<div class="col-lg-4">'.
						Html::button($this->phone,[
							'class' => 'button full green popup-open',
							'id' => 'call',
						])
					.'
				';
				/*$content = '<div class="col-lg-4">
					<span class="author-phone popup-open" id="call">'.$this->phone.'</span>';*/
			}
			
		}
		elseif(!Yii::$app->user->isGuest)
		{	
			$balance = $this->user->checkBalance();
			
			if($balance)
			{	
				if($this->order->status == 0)
				{	
					$string = mb_substr($this->phone,0,$this->length).'xx';
					$content = '
						<div class="col-lg-4">'.
							Html::button($string,[
								'class' => 'button full green',
								'id' => 'no-active',
							])
						.'
					';
					/*$content = 
					'<div class="col-lg-4">
						<span class="author-phone" id="no-active">'.
						mb_substr($this->phone,0,$this->length)
						.'XX</span>';*/
				}
				else
				{	
					$string = mb_substr($this->phone,0,$this->length).'xx';
					$content = '
						<div class="col-lg-4">'.
							Html::button($string,[
								'class' => 'button full green  popup-open',
								'id' => 'call',
								'onclick' => 'takePayment(this)'
							])
						.'
					';
					/*$content = '<div class="col-lg-4">
						<span class="author-phone popup-open" id="call" onclick="takePayment(this)">'.
						mb_substr($this->phone,0,$this->length).'XX</span>';*/
				}
			}
			else
			{	
				$string = mb_substr($this->phone,0,$this->length).'xx';
				$content = '
					<div class="col-lg-4">'.
						Html::button($string,[
							'class' => 'button full green popup-open',
							'id' => 'no-balance',
						])
					.'
				';
			}
		}
		elseif(Yii::$app->user->isGuest)
		{	
			$string = mb_substr($this->phone,0,$this->length).'xx';
			$content = '
				<div class="col-lg-4">'.
					Html::button($string,[
						'class' => 'button full green popup-open',
						'id' => 'register',
					])
				.'
			';
			/*$content = '
			<div class="col-lg-4">
				<span class="author-phone popup-open" id="register">'.
				mb_substr($this->phone,0,$this->length)
				.'XX</span>';*/
		}


		return $content;
	}

}