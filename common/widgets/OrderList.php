<?php 

namespace common\widgets;

use Yii;
use yii\helpers\Url;
use yii\base\Widget;
use common\modules\order\models\Order;
use common\modules\order\models\PaidOrders;

class OrderList extends Widget
{
    public $orders;

    public $profile;

    public $user;

    public function init()
    {
        parent::init();

        $this->user = Yii::$app->user->isGuest ? null : Yii::$app->user;

    }

    public function run()
    {
        foreach($this->orders as $order)
        {   
            $phoneNumber = $this->hidePhoneNumber($order['author_phone']);

            echo 
            '<div class="order" id="'.$order['id'].'" onclick="openOrder(this)">
                <div class="row">
                    <div class="col-lg-auto">
                        <p class="order-content">
                        '.$this->substrContent($order['content']).'
                        </p>
                    </div> 
                </div>
                 <div class="row">
                    <div class="col-auto pr-0">
                        <a class="order-category-header" href="'.Url::toRoute(['/category/'.$order['category']['url']]).'">'.$order['category']['title'].'</a>
                    </div>
                </div>
                <div class="row justify-content-between">
                    <div class="col-auto">
                        <i class="fa fa-phone phone-icon fa-lg mr-1"></i><span class="author-number">'.$phoneNumber.'</span>
                    </div>
                    <div class="col-auto">
                        <span class="order-time">'.$this->new_time($order['created_at']).'</span>
                    </div>
                </div>
            </div>';
        }
    }

    public function substrContent($content)
    {
        return trim($content).'...';
    }

    public function hidePhoneNumber($number)
    {
        $length = mb_strlen($number) - 2;
                
        return mb_substr($number,0,$length).'xx';
    }

    public function new_time($a) 
    { 
         date_default_timezone_set('Asia/Bishkek');
         $ndate = date('Y-m-d', $a);
         $ndate_time = date('H:i', $a);
         $ndate_exp = explode('-', $ndate);
        
         $nmonth = array(
          1 => 'янв',
          2 => 'фев',
          3 => 'мар',
          4 => 'апр',
          5 => 'мая',
          6 => 'июн',
          7 => 'июл',
          8 => 'авг',
          9 => 'сен',
          10 => 'окт',
          11 => 'ноя',
          12 => 'дек'
         );

         foreach ($nmonth as $key => $value) {
          if($key == intval($ndate_exp[1])) $nmonth_name = $value;
         }

         if($ndate == date('Y-m-d')) return 'Cегодня в '.$ndate_time;
         elseif($ndate == date('Y-m-d', strtotime('-1 day'))) return 'Вчера в '.$ndate_time;
         else return $ndate_exp[2].' '.$nmonth_name.' '.$ndate_time;
        /* else return $ndate_exp[0].' '.$nmonth_name.' '.$ndate_exp[2].' в '.$ndate_time;*/
        
    }
}