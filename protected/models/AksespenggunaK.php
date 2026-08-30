<?php

/**
 * This is the model class for table "aksespengguna_k".
 *
 * The followings are the available columns in table 'aksespengguna_k':
 * @property integer $aksespengguna_id
 * @property integer $peranpengguna_id
 * @property integer $modul_id
 * @property integer $loginpemakai_id
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 */

class AksespenggunaK extends CActiveRecord
{
	public $nama_pegawai;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return AksespenggunaK the static model class
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
		return 'aksespengguna_k';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('peranpengguna_id, loginpemakai_id', 'required'),
			array('peranpengguna_id, modul_id, loginpemakai_id, create_loginpemakai_id, update_loginpemakai_id', 'numerical', 'integerOnly'=>true),
			array('create_time, modul_id, update_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('aksespengguna_id, peranpengguna_id, modul_id, loginpemakai_id, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id', 'safe', 'on'=>'search'),
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
			'modul' => array(self::BELONGS_TO, 'ModulK', 'modul_id'),
			'peranpengguna' => array(self::BELONGS_TO, 'PeranpenggunaK', 'peranpengguna_id'),
			'loginpemakai' => array(self::BELONGS_TO, 'LoginpemakaiK', 'loginpemakai_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'aksespengguna_id' => 'Akses Pengguna',
			'peranpengguna_id' => 'Peran Pengguna',
			 'modul_id' => 'Modul',
		
			'loginpemakai_id' => 'Login Pemakai',
			'create_time' => 'Waktu Create',
			'update_time' => 'Waktu Update',
			'create_loginpemakai_id' => 'Create Login Pemakai',
			'update_loginpemakai_id' => 'Update Login Pemakai',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CdbCriteria that can return criterias.
	 */
	public function criteriaSearch()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		// $criteria->select = " t.loginpemakai_id, t.aksespengguna_id, t.create_time";

		// $criteria->join = " LEFT JOIN loginpemakai_k ap ON ap.loginpemakai_id = t.loginpemakai_id 
		//                     LEFT JOIN pegawai_m x ON x.pegawai_id = t.pegawai_id";
	
		$criteria->compare('aksespengguna_id',$this->aksespengguna_id);
		$criteria->compare('peranpengguna_id',$this->peranpengguna_id);
		$criteria->compare('modul_id',$this->modul_id);
		$criteria->compare('loginpemakai_id',$this->loginpemakai_id);
		$criteria->compare('create_loginpemakai_id',$this->create_loginpemakai_id);
		$criteria->compare('update_loginpemakai_id',$this->update_loginpemakai_id);
		
	    return $criteria;
	}
        
        
        /**
         * Retrieves a list of models based on the current search/filter conditions.
         * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
         */
        public function search()
        {
            // Warning: Please modify the following code to remove attributes that
            // should not be searched.

            $criteria=$this->criteriaSearch();
            $criteria->limit=10;

            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
            ));
        }


        public function searchPrint()
        {
            // Warning: Please modify the following code to remove attributes that
            // should not be searched.

            $criteria=$this->criteriaSearch();
            $criteria->limit=-1; 

            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
                    'pagination'=>false,
            ));
        }
}