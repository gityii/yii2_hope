<?php

namespace app\models;

use yii\base\Model;

use Yii;

class Login extends Model{

	public $username;
	public $password;
	public $verifyCode;
	public $remeber;

	private $user = [
		'id' => 1,
		'username' => 'smister',
		'password' => '123456'
	];

	public function rules(){
		return [
			['username' , 'required' , 'message' => '用户名不能为空'],
			['verifyCode' , 'captcha' , 'captchaAction' => 'login/captcha' , 'message' => '验证码不正确'],
			['password' , 'checkPwd' , 'skipOnEmpty' => false],
			['remeber' , 'safe'],
		];
	}


	public function checkPwd($attribute , $params){
		if(empty($this->$attribute)){
			$this->addError($attribute , '密码不能为空');
		}else if(strlen($this->$attribute) < 6){
			$this->addError($attribute , '密码错误');
		}else if(empty($this->getErrors())){
			//密码验证 , 连接数据库
			if($this->user['username'] != $this->username || $this->user['password'] != $this->password){
				$this->addError($attribute , '账户或密码错误');
			}
		}
	}



	public function login(){
		if(!$this->validate()) return false;
		//首先生成session
		self::createUserSession($this->user['id'] , $this->user['username']);		

		//如果有记住密码，则把信息记录到Cookie
		if($this->remeber){
			$time = time() + 60 * 60 * 24 * 7;
			$cookie = new \yii\web\Cookie();
			$cookie -> name = 'mrs_remeber';
			$cookie -> expire = $time;
			$cookie -> httpOnly = true;
			$cookie -> value = base64_encode($this->user['id'] . '#' . $this->user['username'] . '#' .$time);
			Yii::$app->response->getCookies()->add($cookie);
		}

		return true;
	}


	public static function createUserSession($user_id , $username){
		$session = Yii::$app->session;
		$session -> set('mrs_id' , $user_id);
		$session -> set('mrs_username' , $username);
	}


	public static function loginByCookie(){
		//$remCookie = Yii::$app->session->get('mrs_remeber');
		$remCookie = Yii::$app->request->cookies->get('mrs_remeber');
		if($remCookie){
			list($id , $username , $time) = explode('#' , base64_decode($remCookie));
			if($time > time()){
				self::createUserSession($id , $username);
				return $username;
			}
		}
		return false;
	}


}





?>