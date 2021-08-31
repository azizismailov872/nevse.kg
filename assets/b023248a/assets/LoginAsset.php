<?php 
namespace frontend\themes\vse\assets;

use yii\web\AssetBundle;

class LoginAsset extends AssetBundle
{
	public function init()
	{
		parent::init();
		$this->publishOptions['forceCopy'] = true;
	}
	
	public $baseUrl = '@app/themes/vse';
	public $sourcePath = '@app/themes/vse';
	public $css = [
		'css/style.min.css',
		'css/login.min.css',
		'boxicons/css/boxicons.min.css',
		'fonts/typicons.min.css',
		'fonts/fontawesome-all.min.css',
		'fonts/typicons.min.css',
		'fonts/font-awesome.min.css',
	];
	public $js = [
		'js/mask/inputmask.binding.js',
		'js/mask/inputmask.js',
		'js/mask/jquery.inputmask.js',
		'js/script.js',
		'js/popup.js',
	];
	public $depends = [
		'yii\web\YiiAsset',
		'yii\bootstrap\BootstrapAsset',
	];
}