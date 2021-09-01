<?php

namespace common\modules\order\controllers;

use Yii;
use common\models\User;
use common\modules\content\models\Menu;
use common\modules\content\models\Pages;
use common\modules\message\models\forms\WriteMessage;
use common\modules\order\models\Category;
use common\modules\order\models\Order;
use common\modules\order\models\PaidOrders;
use common\modules\order\models\forms\CreateOrder;
use common\modules\order\models\forms\EditOrder;
use yii\data\Pagination;
use yii\filters\AccessControl;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\widgets\ActiveForm;


/**
 * FrontendOrderController implements the CRUD actions for Order model.
 */
class FrontendOrderController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['delete','update'],
                'rules' => [
                    [
                        'actions' => ['delete','update'],
                        'allow' => true,
                        'matchCallback' => function($rule,$action)
                        {
                            if(Yii::$app->user->can('admin') or Yii::$app->user->can('editor'))
                            {
                                return true;
                            }
                            else
                            {
                                return Yii::$app->user->can('updateOrder',['item' => $this->findModel(Yii::$app->request->get('id'))]);
                            }
                        }
                    ],
                ],
                'denyCallback' => function ($rule, $action) 
                {   
                    throw new NotFoundHttpException('У вас нет прав для этого действия');
                }
            ],
        ];
    }

    public function beforeAction($action) 
    { 
        Yii::$app->controller->enableCsrfValidation = false;

        $this->view->params['menu'] = Yii::$app->user->isGuest ? null : Menu::getSidebarMenuList();

        $categoriesList = Category::getSidebarCategoriesList();

        $this->view->params['sidebarCategories'] = (isset($categoriesList) && !empty($categoriesList)) ? $categoriesList : null;

        $this->view->params['defaultCategoryBg'] = '/common/modules/order/images/main-bg.jpg';

        return parent::beforeAction($action); 
        
    }

    public function actionAbout()
    {   
        $this->layout = 'view-layout';

        $model = Pages::find()->where(['page' => 'about'])->one();

        if(!isset($model) && empty($model))
        {
            return $this->redirect(['/']);
        }

        $this->view->params['pageTitle'] = $model->title;

        $this->view->title = $model->title;

        $this->view->params['pageUrl'] = '/about';

        return $this->render('about',[
            'model' => $model
        ]);
    }

    public function actionIndex()
    {   

        $query = Order::find();

        $page = Pages::find()->where(['page' => 'main'])->one();
        
        $pagination = new Pagination([
            'totalCount' => $query->count(),
            'pageSize' => 6,
        ]);

        $orders = $query->offset($pagination->offset)
        ->limit($pagination->limit)
        ->orderBy([
            'created_at' =>  SORT_DESC,
        ])
        ->with(['category' => function($query){
            $query->select(['id','url','title']);
            }
        ])
        ->asArray()
        ->all();

        $this->view->title = 'VSЁ';

        $this->view->params['model'] = new CreateOrder();

        $this->view->params['categoriesList'] = Category::getCategoriesList();

        $this->view->params['phoneValue'] = (!Yii::$app->user->isGuest) ? Yii::$app->user->identity->setPhoneValue() : '';

        $this->view->params['pageTitle'] = (isset($page) && !empty($page)) ? $page->title : null;

        return $this->render('main',[
            'orders' => $orders,
            'pagination' => $pagination,
        ]);
    }

    public function actionCategory($url)
    {   
        $category = Category::find()->where(['url' => $url])->one();

        $query = Order::find()->where(['category_id' => $category->id]);

        $pagination = new Pagination([
            'totalCount' => $query->count(),
            'pageSize' => 6,
        ]);

        $orders = $query->offset($pagination->offset)
        ->limit($pagination->limit)
        ->orderBy([
            'created_at' =>  SORT_DESC,
        ])
        ->all();

        $this->view->params['model'] = new CreateOrder();

        $this->view->params['categoriesList'] = Category::getCategoriesList();

        $this->view->params['categoryId'] = $category->id;

        $this->view->params['phoneValue'] = (!Yii::$app->user->isGuest) ? Yii::$app->user->identity->setPhoneValue() : '';

        $this->view->params['defaultCategoryBg'] = $category->getImage();

        $this->view->title = $category->title;

        $this->view->params['pageTitle'] = $category->pageTitle;

        return $this->render('category',[
            'orders' => $orders,
            'pagination' => $pagination,
            'category' => $category,
        ]);
    }

    public function actionView($id)
    {   
        $this->layout = 'view-layout';

        $model = $this->findModel($id);

        $message = new WriteMessage();

        $this->view->params['defaultCategoryBg'] = $model->category->getImage();

        $this->view->params['pageTitle'] = $model->category->title;

        $this->view->params['pageUrl'] = '/category/'.$model->category->url;

        Yii::$app->session->removeFlash('error-model');

        $this->view->title = 'Заказ '.$model->substrContent($model->content);

        return $this->render('view', [
            'model' => $this->findModel($id),
            'message' => $message,
        ]);
    }


    public function actionSave()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $request = \Yii::$app->getRequest();

        $result = false;

        $msg = 'Запрос не был создан';

        if($request->isAjax)
        {
            $post = Yii::$app->request->post();
           
            //Get model
            $model = new CreateOrder();
            
            //Validate data
            if($model->load(Yii::$app->request->post()))
            {   
                //Save data in modele
                if($model->createOrder())
                {      
                    $result = true;

                    $msg = 'Ваш запрос опубликован';

                    Yii::$app->session->removeFlash('error-model');
                }
            }
        }

        return ['result' => $result, 'msg' => $msg];
        
    }

    public function actionUpdateOrders()
    {   
        $user = User::find()->where(['username' => 'Без автора'])->one();

        $orders = Order::find()->where(['author_id' => $user->id])->all();

        if(isset($orders) && !empty($orders))
        {
            foreach($orders as $order)
            {
                if($order->setNoActive())
                {
                    $order->status = 0;

                    $order->save();
                }
            }
        }
    }


    //Валидация формы
    public function actionValidateForm()
    {   
        $model = new CreateOrder();

        $categoriesList = Category::getCategoriesList();

        if(Yii::$app->request->isAjax) 
        {            
            if($model->load(Yii::$app->request->post()))
            {   
                Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

                return ActiveForm::validate($model);
            }
            
        }

        throw new \yii\web\BadRequestHttpException('Bad request!');   
    }

    public function actionPay()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        
        $request = \Yii::$app->getRequest();

        $result = false;
        
        $msg = 'Оплата не была снята';

        $user = Yii::$app->user->identity;

        if($request->isAjax)
        {
            $post = Yii::$app->request->post();
            
            $paid = PaidOrders::find()->where(['user_id' => $user->id,'order_id' => $post['id']])->one();

            if(!empty($paid))
            {
                $result = true;

                $msg = '';

            }
            else
            {
                if($user->checkBalance())
                {
                    if($user->takePayment($post['id']))
                    {
                        if($user->save())
                        {
                            $result = true;

                            $msg = '';
                        }
                    }
                }
            }
        }

    }

    /**
     * Displays a single Order model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */

    /**
     * Updates an existing Order model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {   
        $this->layout = 'view-layout';
        $model = $this->findModel($id);

        $update = new EditOrder($model);

        $categoriesList = Category::getCategoriesList();

        if(Yii::$app->request->isPost)
        {
            if($update->load(Yii::$app->request->post()) && $update->saveOrder())
            {   
                Yii::$app->session->setFlash('success','Запрос успешно обновлён');

                return $this->redirect(['/order/view/'.$model->id]);
            }
        }

        Yii::$app->params['defaultCategoryBg'] = $model->category->getImage();

        Yii::$app->params['categoryTitle'] = $model->category->title;

        Yii::$app->params['categoryUrl'] = '/category/'.$model->category->url;

        Yii::$app->params['categorySubTitle'] = null;

        $this->view->title = 'Изменить запрос';

        return $this->render('update', [
            'model' => $model,
            'categoriesList' => $categoriesList,
            'update' => $update,
        ]);
    }

    /**
     * Deletes an existing Order model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        Yii::$app->session->setFlash('success','Запрос успешно удален');

        if(Yii::$app->user->can('admin'))
        {
            return $this->redirect(['index']);
        }
        else
        {
            return $this->redirect(['/profile/my']);
        }
    }

    /**
     * Finds the Order model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Order the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Order::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
