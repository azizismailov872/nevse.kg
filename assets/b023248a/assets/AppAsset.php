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
        'css/main.css',
        'css/update.css',
        'boxicons/css/boxicons.min.css',
      	'fonts/typicons.min.css',
      	'fonts/fontawesome-all.min.css',
      	'fonts/typicons.min.css',
      	'fonts/font-awesome.min.css',
        'css/developer.css',
    ];
    public $js = [
        'js/mask/inputmask.binding.js',
        'js/mask/inputmask.js',
        'js/mask/jquery.inputmask.js',
        'js/main.js',
        'js/menu.js',
        'js/textarea.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}