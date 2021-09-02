<?php 

namespace frontend\themes\vse\assets;

use yii\web\AssetBundle;

class AppAsset extends AssetBundle
{
	public function init()
    {
        parent::init();
        $this->publishOptions['forceCopy'] = true;
    }
    
    public $baseUrl = '@app/themes/vse';
    public $sourcePath = '@app/themes/vse';
    public $css = [
        //'css/main.min.css',
        'css/main.css',
        'boxicons/css/boxicons.min.css',
      	'fonts/typicons.min.css',
      	'fonts/fontawesome-all.min.css',
      	'fonts/typicons.min.css',
      	'fonts/font-awesome.min.css',
        'css/swiper-bundle.min.css',
    ];
    public $js = [
        'js/bootstrap.min.js',
        'js/popper.min.js',
        'js/swiper-bundle.min.js',
        'js/mask/inputmask.binding.js',
        'js/mask/inputmask.js',
        'js/mask/jquery.inputmask.js',
        //'js/main.min.js',
        'js/main.js',
      
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}