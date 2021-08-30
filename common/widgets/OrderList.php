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
        if(!Yii::$app->user->isGuest)
        {
            $this->returnUserContent();
        }
        else
        {
            $this->returnGuestContent();
        }
    }

    public function returnUserContent()
    {
        if(isset($this->orders) && !empty($this->orders))
        {
            foreach($this->orders as $order)
            {   
                $paid = PaidOrders::find()->where(['user_id' => $this->user->id,'order_id' => $order->id])->exists();

                $phoneLength = mb_strlen($order->author_phone) - 2;
                
                $phoneNumber = $paid ? $order->author_phone : mb_substr($order->author_phone,0,$phoneLength).'xx';

                if($this->user->id == $order->author_id)
                {
                    $phoneNumber = $order->author_phone;
                }

                if($this->profile)
                {
                    echo 
                    '<div class="order" id="'.$order->id.'" onclick="openOrder(this)">
                        <div class="row">
                            <div class="col-lg-auto">
                                <p class="order-content">
                                '.$order->substrContent().'
                                </p>
                            </div> 
                        </div>
                         <div class="row">
                            <div class="col-auto pr-0">
                                <a class="order-category-header" href="'.Url::toRoute(['/category/'.$order->category->url]).'">'.$order->category->title.'</a>
                            </div>
                        </div>
                        <div class="row justify-content-between">
                            <div class="col-auto">
                                <i class="fa fa-phone phone-icon fa-lg mr-1"></i><span class="author-number">'.$phoneNumber.'</span>
                            </div>
                            <div class="col-auto">
                                <span class="order-time">'.$order->new_time($order->created_at).'</span>
                            </div>
                        </div>
                    </div>';
                }
                else
                {
                    /*echo '<div class="order" id="'.$order->id.'" onclick="openOrder(this)">
                        <div class="row justify-content-between align-items-center">
                            <div class="col-lg-auto">
                                <a href="'.Url::toRoute(['/category/'.$order->category->url]).'"class="order-header">'.$order->category->title.'</a>
                            </div>
                            <div class="col-lg-4 d-lg-flex justify-content-end ">
                                <span class="order-time">'.$order->new_time($order->created_at).'</span>
                            </div>
                        </div>
                        <div class="row content-row">
                            <div class="col-12">
                                <p class="order-content">
                                '.$order->substrContent().'
                            </p>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-lg-4 col-6">
                                <span class="author-phone smaller">
                            '.
                              $phoneNumber  
                            .'</span></div>
                        </div>
                    </div>';*/
                    echo 
                    '<div class="order" id="'.$order->id.'" onclick="openOrder(this)">
                        <div class="row">
                            <div class="col-lg-auto">
                                <p class="order-content">
                                '.$order->substrContent().'
                                </p>
                            </div> 
                        </div>
                         <div class="row">
                            <div class="col-auto pr-0">
                                <a class="order-category-header" href="'.Url::toRoute(['/category/'.$order->category->url]).'">'.$order->category->title.'</a>
                            </div>
                        </div>
                        <div class="row justify-content-between">
                            <div class="col-auto">
                                <i class="fa fa-phone phone-icon fa-lg mr-1"></i><span class="author-number">'.$phoneNumber.'</span>
                            </div>
                            <div class="col-auto">
                                <span class="order-time">'.$order->new_time($order->created_at).'</span>
                            </div>
                        </div>
                    </div>';
                }
            }
        }
    }

    public function returnGuestContent()
    {
        if(isset($this->orders) && !empty($this->orders))
        {
            foreach($this->orders as $order)
            {
                $phoneLength = mb_strlen($order->author_phone) - 2;
                
                $phoneNumber = mb_substr($order->author_phone,0,$phoneLength).'xx';

                echo 
                    '<div class="order" id="'.$order->id.'" onclick="openOrder(this)">
                        <div class="row">
                            <div class="col-lg-auto">
                                <p class="order-content">
                                '.$order->substrContent().'
                                </p>
                            </div> 
                        </div>
                         <div class="row">
                            <div class="col-auto pr-0">
                                <a class="order-category-header" href="'.Url::toRoute(['/category/'.$order->category->url]).'">'.$order->category->title.'</a>
                            </div>
                        </div>
                        <div class="row justify-content-between">
                            <div class="col-auto">
                                <i class="fa fa-phone phone-icon fa-lg mr-1"></i><span class="author-number">'.$phoneNumber.'</span>
                            </div>
                            <div class="col-auto">
                                <span class="order-time">'.$order->new_time($order->created_at).'</span>
                            </div>
                        </div>
                    </div>';
            }
        }
    }
}