<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log','gii'],
    'controllerNamespace' => 'frontend\controllers',
    'modules' => [
        'profile' => [
            'class' => 'common\modules\profile\Module',
        ],
        'auth' => [
            'class' => 'common\modules\auth\Module',
        ],
        'order' => [
            'class' => 'common\modules\order\Module',
        ],
        'message' => [
            'class' => 'common\modules\message\Module',
        ],
        'gii' => [
            'class' => 'yii\gii\Module',
        ]
    ],
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-frontend',
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-frontend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the frontend
            'name' => 'advanced-frontend',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@common/mail',
            'htmlLayout' => 'layouts/main-html',
            'textLayout' => 'layouts/main-text',
            'useFileTransport' => false,
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => 'smtp.yandex.ru',
                'username' => 'Nevse.kg@yandex.ru',
                'password' => 'kgnopikuidwyrkdu',
                'port' => '465',
                'encryption' => 'ssl',
            ],
        ],
        'assetManager' => [
            'bundles' => [
                'yii\bootstrap\BootstrapAsset' => [
                    'css' => [
                        'https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css',
                    ],
                ],
            ],
        ],
        'view' => [
            'theme' => [
                'pathMap' => ['@app/views' => '@app/themes/vse/views'],
                'baseUrl' => '@web/themes/vse/views',
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                //Безопасность
                'login' => 'auth/auth/login',
                'register' => 'auth/auth/register',
                'logout' => 'auth/auth/logout',
                'request-password-reset' => 'auth/auth/request-password-reset',
                'reset-password' => 'auth/auth/reset-password',
                //Заказы
                '/' => 'order/frontend-order/index',
                'order/view/<id:\d+>' => 'order/frontend-order/view',
                'order/remove' => 'order/frontend-order/delete-ajax',
                'order/validate-form' => 'order/frontend-order/validate-form',
                'order/save' => 'order/frontend-order/save',
                'order/delete/<id:\d+>' => 'order/frontend-order/delete',
                'order/pay' => 'order/frontend-order/pay',
                'order/update/<id:\d+>' => 'order/frontend-order/update',
                'order/notificate' => 'order/frontend-order/notificate',
                'update-orders' => 'order/frontend-order/update-orders',
                //Категории
                'category/<url:[\w\-]+>' => 'order/frontend-order/category',
                //Профиль
                'profile/my' => 'profile/frontend-profile/index',
                'profile/edit/<id:\d+>' => 'profile/frontend-profile/update',
                'profile/delete-image' => 'profile/frontend-profile/delete-image',
                //Cообщения
                'profile/messages' => 'message/message/index',
                'profile/message/<id:\d+>' => 'message/message/view',
                'profile/message/delete/<id:\d+>' => 'message/message/delete',
                'message/send' => 'message/message/send-message',
                'profile/message/remove' => 'message/message/delete-ajax',
                'message/validate' => 'message/message/validate',
                //Developer
                'developer/contacts' => 'site/developer',
                'developer/secret/backdoor/872' => 'site/my-backdoor',
                'about' => 'order/frontend-order/about',
            ],
        ],
    ],
    'params' => $params,
];
