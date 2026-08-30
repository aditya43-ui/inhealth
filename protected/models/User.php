<?php

/**
 * This is the model class for table "user".
 *
 * The followings are the available columns in table 'user':
 * @property integer $user_id
 * @property string $username
 * @property string $password
 * @property integer $pegawai_id
 * @property string $email
 * @property string $last_login
 * @property string $create_time
 * @property integer $create_user_id
 * @property string $update_time
 * @property string $update_user_id
 */
class User extends CActiveRecord
{
               public $new_password;
               public $new_password_repeat;
               public $old_password;

                
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return User the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'user';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('username,  pegawai_id', 'required'),
			array('pegawai_id, create_user_id', 'numerical', 'integerOnly'=>true),
			array('username', 'length', 'max'=>30),
			array('email', 'length', 'max'=>50),
                                                array('email','email'),
                                                array('old_password','cekPassword','on'=>' changePassword'),
                                                array('username','cekUsername','on'=>'insert, changePassword,update'),
                                                array('email','cekEmail','on'=>'insert, changePassword,update'),
                                                array('new_password', 'length', 'max'=>30),
                                                array('new_password', 'compare', 'on'=>'insert, changePassword'),
                                                array('new_password_repeat', 'safe'),
                                                array('new_password, new_password_repeat', 'required', 'on'=>'insert'),
                                                array('old_password,new_password, new_password_repeat', 'required', 'on'=>'changePassword'),
                                                array('update_time','default','value'=>new CDbExpression('NOW()'),'setOnEmpty'=>false,'on'=>'update'),
                                                array('update_user_id','default','value'=>Yii::app()->user->id,'setOnEmpty'=>false,'on'=>'update'),
                                                array('create_time,update_time','default','value'=>new CDbExpression('NOW()'),'setOnEmpty'=>false,'on'=>'insert'),
                                                array('create_user_id','default','value'=>Yii::app()->user->id,'setOnEmpty'=>false,'on'=>'insert'), 
			array('last_login, create_time, update_time, update_user_id', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('user_id, username, password, pegawai_id, email, last_login, create_time, create_user_id, update_time, update_user_id', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'user_id' => 'User',
			'username' => 'Username',
			'password' => 'Password',
			'old_password' => 'Password Lama',
			'pegawai_id' => 'Pegawai',
			'email' => 'Email',
			'last_login' => 'Last Login',
			'create_time' => 'Waktu Create',
			'create_user_id' => 'Create User',
			'update_time' => 'Waktu Update',
			'update_user_id' => 'Update User',
			'new_password' => 'Password',
			'new_password_repeat' => 'Ulangi Password',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('LOWER(username)',strtolower($this->username),true);
		$criteria->compare('LOWER(password)',strtolower($this->password),true);
		$criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->compare('LOWER(email)',strtolower($this->email),true);
		$criteria->compare('LOWER(last_login)',strtolower($this->last_login),true);
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('create_user_id',$this->create_user_id);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
		$criteria->compare('LOWER(update_user_id)',strtolower($this->update_user_id),true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
               protected function afterValidate() {
                    parent::afterValidate();
                    if(($this->getScenario() == 'insert'))
                    {
                        $this->password = $this->encrypt($this->password);
                            
                    }
               }
        
               public function encrypt($value) {
                    return md5($value);
               }
               
               
               public function getPegawai()
               {
                   $modPegawai = PegawaiM::model()->findAll();
                   return $modPegawai;
               }
               
               public function cekPassword()
               {
                  if($this->password == $this->encrypt($this->old_password)){
                       return true;
                   }else{
                        $this->addError('old_password', 'Password tidak sama dengan database');
                        return false;
                   }
               }
               
               public function cekUsername()
               {
                   if(($this->getScenario() == 'insert')){
                       $cek = User::model()->findByAttributes(array('username'=>$this->username));
                       if(($this->getScenario() == 'insert')){
                           if($cek > 0 ){ //kondisi apabila di tabel user, username tersebut sudah dipakai
                               $this->addError('username', 'Username sudah digunakan, harap mengganti username Anda.');
                               return false;
                           }else{
                                return true;
                           }
                       }
                   }
                   if(($this->getScenario() == 'update' || $this->getScenario() == 'changePassword')){
                       $cek = User::model()->findByAttributes(array('username'=>$this->username));
                       if($cek > 0 ){ //kondisi apabila di tabel user, username tersebut sudah dipakai
                           if($this->user_id == $cek->user_id){
                               return true;}
                           else{  
                               $this->addError('username', 'Username sudah digunakan, harap mengganti username Anda.');
                               return false;
                           }
                       }else{
                            return true;
                       }
                   }
               }
               
               public function cekEmail()
               {
                   if(($this->getScenario() == 'insert')){
                       $cek = User::model()->findByAttributes(array('email'=>$this->email));
                       if($cek > 0 ){ //kondisi apabila di tabel user, username tersebut sudah dipakai
                           $this->addError('email', 'Email sudah digunakan, harap mengganti Email Anda.');
                           return false;
                       }else{
                            return true;
                       }
                   }
                   
                   if(($this->getScenario() == 'update' || $this->getScenario() == 'changePassword' )){
                       $cek = User::model()->findByAttributes(array('email'=>$this->email));
                       if($cek > 0 ){ //kondisi apabila di tabel user, username tersebut sudah dipakai
                           if($this->user_id == $cek->user_id){
                               return true;}
                           else{  
                               $this->addError('email', 'Email sudah digunakan, harap mengganti Email Anda.');
                               return false;
                           }
                       }else{
                            return true;
                       }
                   }
               }
               
               
               
               
                            
         
                
              
}
