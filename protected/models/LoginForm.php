<?php

/**
 * LoginForm class.
 * LoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class LoginForm extends CFormModel
{
    public $username;
    public $email;
    public $password;
    public $password_confirmation;
    public $rememberMe;

    private $_identity;

    /**
     * Declares the validation rules.
     * The rules state that username and password are required,
     * and password needs to be authenticated.
     */
    public function rules()
    {
        return array(
            // username and password are required
            array('username, password', 'required'),
            array('username, email','uniqueCheck','on'=>'register'),
            array('email','email','on'=>'register'),
            array('email, password_confirmation', 'required', 'on'=>'register'),
            array('password_confirmation', 'compare', 'compareAttribute'=>'password', 'on'=>'register'),
            // rememberMe needs to be a boolean
            array('rememberMe', 'boolean'),
            // password needs to be authenticated
            array('password', 'authenticate', 'on'=>'login'),
        );
    }

    /**
     * Declares attribute labels.
     */
    public function attributeLabels()
    {
        return array(
            'rememberMe'=>'Remember me next time',
        );
    }

    /**
     * Authenticates the password.
     * This is the 'authenticate' validator as declared in rules().
     */
    public function authenticate($attribute,$params)
    {
        if(!$this->hasErrors())
        {
            $this->_identity=new UserIdentity($this->username,$this->password);
            if(!$this->_identity->authenticate())
                $this->addError('password','Incorrect username or password.');
        }
    }
    public function uniqueCheck($attribute,$params)
    {
        if($this->{$attribute}){
            if(User::model()->find('LOWER('.$attribute.')=?',array(strtolower($this->{$attribute}))))
                $this->addError($attribute,ucfirst($attribute).' is already registered.');
        }
    }

    /**
     * Logs in the user using the given username and password in the model.
     * @return boolean whether login is successful
     */
    public function login()
    {
        if($this->getScenario() == 'register'){
            $user = new User('register');
            $user->attributes = $_POST['LoginForm'];
            if(!$user->save()){
                return false;
            }
        }

        if($this->_identity===null)
        {
            $this->_identity=new UserIdentity($this->username,$this->password);
            $this->_identity->authenticate();
        }
        if($this->_identity->errorCode===UserIdentity::ERROR_NONE)
        {
            $duration=$this->rememberMe ? 3600*24*30 : 0; // 30 days
            Yii::app()->user->login($this->_identity,$duration);
            return true;
        }
        else
        {
            return false;
        }
    }

    /**
     * Get error code generated in UserIdentity->authenticate
     */
    public function getLoginErrorCode()
    {
        return $this->_identity==null ? 0 : $this->_identity->errorCode;
    }
}
