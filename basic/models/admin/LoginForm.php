<?php

namespace app\models\admin;

use Yii;
use yii\base\Model;

/**
 * LoginForm is the model behind the login form.
 *
 * @property User|null $user This property is read-only.
 *
 */
class LoginForm extends Model
{
    public $username;
    public $password;
    public $rememberMe = true;
    private $_user = false;

    private $user = [
        'id' => 1,
        'username' => 'smister',
        'password' => '123456'
    ];
    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['username', 'password'], 'required'],
            // rememberMe must be a boolean value
            ['rememberMe', 'boolean'],
            // password is validated by validatePassword()
            ['password', 'validatePassword'],
        ];
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            //var_dump(' password '.$user->password);
               // if (!$user || !$user->validatePassword($this->password)) {
            if($this->user['username'] != $this->username || $this->user['password'] != $this->password){
                $this->addError($attribute, 'Incorrect username or password.');
            }
        }
    }

    /**
     * Logs in a user using the provided username and password.
     * @return bool whether the user is logged in successfully
     */
    public function login()
    {
        if ($this->validate()) {

            self::createUserSession($this->user['id'] , $this->user['username']);

            if($this->rememberMe)
            {
                //$user = $this->getUser();
                //$user->generateAuthKey();
                $time = time() + 60 * 60 * 24 * 7;
                $cookie = new \yii\web\Cookie();
                $cookie -> name = 'mrs_remeber';
                $cookie -> expire = $time;
                $cookie -> httpOnly = true;
                $cookie -> value = base64_encode($this->user['id'] . '#' . $this->user['username'] . '#' .$time);
                Yii::$app->response->getCookies()->add($cookie);
                return true;
            }

            //return Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600*24*30 : 0);
        }
        return false;
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
    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    public function getUser()
    {
        if ($this->_user === false) {
            $this->_user = User::findByUsername($this->username);
        }
        return $this->_user;
    }
}
