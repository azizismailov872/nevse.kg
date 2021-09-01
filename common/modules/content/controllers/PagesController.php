<?php

namespace common\modules\content\controllers;

use Yii;
use common\modules\content\models\Pages;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class PagesController extends Controller
{
    public $layout = 'dashboard';

    public function behaviors()
    {
        return [
             'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['edit'],
                        'allow' => true,
                        'roles' => ['admin','editor'],
                    ],
                ],
                'denyCallback' => function ($rule, $action) 
                {
                    throw new NotFoundHttpException('У вас нет прав для этого действия');
                }
            ],
        ];
    }

    public function actionEdit($url)
    {
        $page = Pages::find()->where(['page' => $url])->one();
            
        if(!isset($page) && empty($page))
        {
            $model = new Pages();
            $model->page = $url;
            $model->title = $url;
            $model->save();
            $page = Pages::find()->where(['page' => $url])->one();

        }   
        if ($page->load(Yii::$app->request->post()) && $page->save()) {
            return $this->redirect(['/menu']);
        }

        $this->view->title = 'Изменить страницу';

        return $this->render('edit',[
            'model' => $page
        ]);
       
    }

}
