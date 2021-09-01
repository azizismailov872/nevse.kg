<?php
use yii\helpers\Html;
?>
<table class="body-wrap">
    <tr>
        <td class="container">

            <!-- Message start -->
            <table>
                <tr>
                    <td align="left" class="masthead">
                        <a href="https://nevse.kg/" class="header-link">VSE</a>
                    </td>
                </tr>
                <tr>
                    <td class="content">
                        <h2 class="header">Новый заказ на сайте nevse:</h2>
                        <a href="https://nevse.kg/order/view/<?= $id?>" class="order-title"><?= $order->substrContent()?></a>
                        <p>Время: <?= $order->new_time($order->created_at) ;?></p>
                        <table>
                            <tr>
                                <td align="center">
                                    <p>
                                        <a href="https://nevse.kg/order/view/<?= $id?>"" class="button">Перейти к заказу</a>
                                    </p>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>

        </td>
    </tr>
</table>