<?php

namespace app\controllers;

use yii\web\Controller;
use Yii;

class LoginController extends Controller{

	public function actions(){
		return [
			'captcha' => [
				'class' => 'yii\captcha\CaptchaAction',
				'maxLength' => 4,
				'minLength' => 4,
				'width' => 80,
				'height' => 40
			],
		];
	}

	public function actionIndex(){

		$model = new \app\models\Login();

		if(Yii::$app->request->isPost && $model->load(Yii::$app->request->post()) && $model->login()){
			return $this->redirect(['center']);
		}

		return $this->renderPartial('index' , ['model' => $model]);
	}


	public function actionCenter(){
		//echo 'Center';
		//echo Yii::$app->session->get('mrs_username');
		
		if(!($username =  Yii::$app->session->get('mrs_username')) && !($username = \app\models\Login::loginByCookie())){
			return $this->redirect(['index']);
		}

		echo '欢迎 , ' . $username;

		//var_dump(Yii::$app->session->get('mrs_username'));

	}
}







?>