<?php 

namespace common\modules\order\models\forms;

use Yii;
use yii\base\Model;
use common\modules\order\models\Order;
use common\models\User;

class CreateOrder extends Model
{
	public $author_id;

	public $category_id;

	public $author_name;

	public $author_phone;

	public $content;

	public $status;

	public function rules()
	{
		return [
			[['author_phone'],'required','message' => 'Введите номер'],
			[['content'],'required','message' => 'Опишите ваш заказ'],
			[['category_id'],'required','message' => 'Выберите категорию'],
			[['author_id','category_id','status'],'integer'],
			[['author_name','author_phone'],'string','max' => 255,'message' => 'Превышено максимальное колличество символов'],
			[['content'],'string'],
			[['content'],'swearFilter'],
			[['content'],'phoneFilter'],
			[['author_phone'],'minPhone'],
		];
	}

	public function phoneFilter($attribute,$params)
	{	
		$numberLayout = [
			'/\+996[0-9]{4,}/ui',
			'/0[0-9]{3}[0-9]{4,}/ui',
			'/[0-9]{9,}/ui',
		];

		foreach($numberLayout as $number)
		{
			if(preg_match($number,$this->$attribute))
			{
				$this->addError($attribute,'Указывать номер телефона запрещено');
			}
		}
	}

	public function swearFilter($attribute,$params)
	{
		$swearWords = Yii::$app->params['swearWords'];

		foreach($swearWords as $swear)
		{	

			if(preg_match('/\b'.$swear.'\b/ui',$this->$attribute))
			{
				$this->addError($attribute,'Нецензурные выражения запрещены');
			}
			elseif(preg_match('/^ам$/ui',$this->$attribute))
			{
				$this->addError($attribute,'Нецензурные выражения запрещены');
			}
		}
	}

	public function attributeLabels()
	{	
		return [
			'author_id' => 'Автор',
			'category_id' => 'Категория',
			'author_name' => 'Имя автора',
			'author_phone' => 'Телефон',
			'content' => 'Описание',
			'status' => 'Статус',
		];
	}

	public function minPhone($attribute,$params)
	{
		$reg = '/\+996\([0-9]{3}\)[0-9]{3}\-[0-9]{3}/';

		if(!preg_match($reg, $this->$attribute))
		{
			$this->addError($attribute,'Введите полный номер !');
		}
	}


	public function createOrder()
	{
		if($this->validate())
		{
			$model = new Order();

			$model->attributes = $this->attributes;

			$model->content = trim($this->content,'\n');

			$model->status = 1;

			$result = false;

			if(!Yii::$app->user->isGuest)
			{
				$model->author_id = Yii::$app->user->getId();

				$model->author_name = Yii::$app->user->identity->getUsername();
			}
			else
			{
				$user = User::find()->where(['username' => 'Без автора'])->one();

				$model->author_id = $user->id;

				$model->author_name = 'Гость';
			}

			if($model->save())
			{
				$id = $model->getPrimaryKey();

				$this->sendNotifications($model,$id);

				return true;
			}

			return $result;
		}
	}

	public function sendNotifications($order,$id)
	{	
		//$users = User::find()->select('email')->asArray()->all();
		$users = [
			[
				'email' => 'nemovalex.info@gmail.com'
			],
			[
				'email' => 'azizismailov872872@gmail.com'
			]
		];

		$result = false;

		foreach($users as $user)
		{	
			Yii::$app->mailer->htmlLayout = 'layouts/new-order';
			
			$result = Yii::$app
            ->mailer
            ->compose(
                ['html' => 'new-order'],
                ['order' => $order,'id' =>$id]
            )
            ->setFrom('Artbele@yandex.ru')
            ->setTo($user['email'])
            ->setSubject('Заказ на Nevse.kg: '.$order->content)
            ->send();
		}

		return $result;
		
	}

}