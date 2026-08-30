<?php

/**
 * LoginForm class.
 * LoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class LoginForm extends CFormModel
{
	public $username;
	public $password;
	public $instalasi;
	public $ruangan;
	public $modul;
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
			array('username, password,instalasi,ruangan,modul', 'required'),
			// rememberMe needs to be a boolean
			array('rememberMe', 'boolean'),
			// password needs to be authenticated
			array('password', 'authenticate'),
		);
	}

	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array(
			'rememberMe'=>'Remember me next time',
                                                'instalasi'=>'Instalasi',
                                                'ruangan'=>'Ruangan',
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
			$this->_identity=new UserIdentity($this->username,$this->password,$this->ruangan);
			if(!$this->_identity->authenticate())
                        {
                            switch ($this->_identity->errorCode)
                            {
                                case UserIdentity::ERROR_PASSWORD_INVALID : Yii::app()->user->setFlash('error', '<strong>Username/Password</strong> Tidak Sesuai.');break;
                                case UserIdentity::ERROR_USERNAME_INVALID : Yii::app()->user->setFlash('error', '<strong>Username/Password</strong> Tidak Sesuai.');break;
                                case UserIdentity::ERROR_RUANGAN_INVALID : Yii::app()->user->setFlash('error', '<strong>Kesalahan Pada Ruangan</strong>.');break;
                            }   
                        }           
		}
	
	}
	/**
	 * Logs in the user using the given username and password in the model.
	 * @return boolean whether login is successful
	 */
	public function login()
	{
		if($this->_identity===null)
		{
			$this->_identity=new UserIdentity($this->username,$this->password,$this->ruangan);
			$this->_identity->authenticate();
		}
		if($this->_identity->errorCode===UserIdentity::ERROR_NONE)
		{
                        //$duration=$this->rememberMe ? 3600*24*30 : 0; // 30 days
                        $duration = 3600*24*1;
                        Yii::app()->user->login($this->_identity,$duration);
                        LoginpemakaiK::model()->updateByPk($this->_identity->id, array('statuslogin'=>TRUE));
                        return true;
		}
		else
			return false;
	}
	
	public function getCodeError()
	{
		if(!$this->hasErrors())
		{
			$this->_identity=new UserIdentity($this->username,$this->password,$this->ruangan);
			if(!$this->_identity->authenticate())
                        {
                            switch ($this->_identity->errorCode)
                            {                                                             
								case UserIdentity::ERROR_PASSWORD_INVALID : '<strong>Username/Password</strong> Tidak Sesuai';break;
                                case UserIdentity::ERROR_USERNAME_INVALID :'<strong>Username/Password</strong> Tidak Sesuai';break;
                                case UserIdentity::ERROR_RUANGAN_INVALID : '<strong>Kesalahan Pada Ruangan</strong>';break;
                            }   
                        }           
		}
	
	}
}
