<?php
/**
 * Created by PhpStorm.
 * User: v_ransu
 * Date: 2017/10/25
 * Time: 16:54
 */

namespace app\modules\admin\controllers;
use app\models\admin\LoginForm;
use app\controllers\BaseController;
use Yii;
use app\models\admin\User;
class AdminController extends BaseController
{

    public function actionLogin()
    {
        if(!\Yii::$app->user->isGuest) { //判断当前用户是否为游客
            return $this->goHome();//不是游客，这里应该跳到列表
        }
        $model = new LoginForm();//是游客，到登录页
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->render('entry-confirm', ['model' => $model]);
        }
        return $this->render('entry', ['model' => $model]);

    }

    public function actionLogout()
    {
        \Yii::$app->user->logout();
        return \Yii::$app->getResponse()->redirect('/admin/admin/login');
    }


    public function actionTest()
    {
        $two = User::findOne('1');
        echo $two['username'];

    }


}