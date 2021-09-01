<?php
use yii\helpers\Html;

/* @var $this \yii\web\View view component instance */
/* @var $message \yii\mail\MessageInterface the message being composed */
/* @var $content string main view render result */
?>
<?php $this->beginPage() ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=<?= Yii::$app->charset ?>" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;700&display=swap" rel="stylesheet">
    <title><?= Html::encode($this->title) ?></title>
    <style type="text/css">
    * { margin: 0; padding: 0; font-size: 100%; font-family: 'Montserrat','Avenir Next', "Helvetica Neue", "Helvetica", Helvetica, Arial, sans-serif; line-height: 1.65; }

    img { max-width: 100%; margin: 0 auto; display: block; }

    body, .body-wrap { width: 100% !important; height: 100%; background: #f8f8f8; }

    a { color: #71bc37; text-decoration: none; }

    a:hover { text-decoration: underline; }

    .text-center { text-align: center; }

    .text-right { text-align: right; }

    .text-left { text-align: left; }

    .button { 
        display: inline-block; color: white; 
        background: #2ecd70; 
        border: solid #2ecd70; 
        border-width: 20px; 
        font-weight: bold; 
        border-radius: 4px; 
    }

    .button:hover { text-decoration: none; }

    h1, h2, h3, h4, h5, h6 { margin-bottom: 20px; line-height: 1.25; }

    h1 { font-size: 32px; }

    h2 { font-size: 28px; }

    h3 { font-size: 24px; }

    h4 { font-size: 20px; }

    h5 { font-size: 16px; }

    p, ul, ol { font-size: 16px; font-weight: normal; margin-bottom: 20px; }

    .container { display: block !important; clear: both !important; margin: 0 auto !important; max-width: 580px !important; }

    .container table { width: 100% !important; border-collapse: collapse; }

    .container .masthead { padding: 10px; background: #2ecd70; color: white; }

    .container .masthead h1 { margin: 0 auto !important; max-width: 90%; text-transform: uppercase; }

    .container .content { background: white; padding: 30px 35px; }

    .header-link{
        color: #fff;
        font-weight: bold;
        font-size: 18px;
        text-decoration: none;
        cursor: pointer;
    }

    .order-time
    {
        text-align: center;
    }

    .header
    {
        font-size: 26px;
        color: #2e2e2e;
        margin-bottom: 10px;
        text-align: center;
    }

    .order-title
    {   
        display: block;
        font-size: 20px;
        font-weight: bold;
        text-decoration: none;
        color: #2e2e2e;
        margin-bottom: 10px;
        text-align: center;
    }

    </style>
    <?php $this->head() ?>
</head>
<body>
    <?php $this->beginBody() ?>

        <?= $content ?>

    <?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>