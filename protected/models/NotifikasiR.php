<?php

/**
 * This is the model class for table "notifikasi_r".
 *
 * The followings are the available columns in table 'notifikasi_r':
 * @property integer $nofitikasi_id
 * @property integer $instalasi_id
 * @property integer $modul_id
 * @property string $tglnotifikasi
 * @property string $judulnotifikasi
 * @property string $isinotifikasi
 * @property boolean $isread
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai_id
 * @property string $update_loginpemakai_id
 * @property string $create_ruangan
 * @property integer $lamahrnotif
 * @property string $icon
 *
 * The followings are the available model relations:
 * @property InstalasiM $instalasi
 * @property ModulK $modul
 * @property LoginpemakaiK $createLoginpemakai
 * @property RuanganM $createRuangan
 * @property LoginpemakaiK $updateLoginpemakai
 */
class NotifikasiR extends CActiveRecord
{
    public $icon;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'notifikasi_r';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('tglnotifikasi, judulnotifikasi, isinotifikasi, create_time, create_loginpemakai_id', 'required'),
			array('instalasi_id, modul_id, lamahrnotif', 'numerical', 'integerOnly'=>true),
			array('judulnotifikasi', 'length', 'max'=>50),
			array('icon', 'length', 'max'=>255),
			array('isread, update_time, update_loginpemakai_id, create_ruangan, class_icon', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('nofitikasi_id, instalasi_id, modul_id, tglnotifikasi, judulnotifikasi, isinotifikasi, isread, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, lamahrnotif, icon', 'safe', 'on'=>'search'),
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
			'instalasi' => array(self::BELONGS_TO, 'InstalasiM', 'instalasi_id'),
			'modul' => array(self::BELONGS_TO, 'ModulK', 'modul_id'),
			'createLoginpemakai' => array(self::BELONGS_TO, 'LoginpemakaiK', 'create_loginpemakai_id'),
			'createRuangan' => array(self::BELONGS_TO, 'RuanganM', 'create_ruangan'),
			'updateLoginpemakai' => array(self::BELONGS_TO, 'LoginpemakaiK', 'update_loginpemakai_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'nofitikasi_id' => 'Nofitikasi',
			'instalasi_id' => 'Instalasi',
			'modul_id' => 'Modul',
			'tglnotifikasi' => 'Date Notifikasi',
			'judulnotifikasi' => 'Title Notifikasi',
			'isinotifikasi' => 'Description Notification',
			'isread' => 'Isread',
			'create_time' => 'Waktu Create',
			'update_time' => 'Waktu Update',
			'create_loginpemakai_id' => 'Create Login Pemakai',
			'update_loginpemakai_id' => 'Update Login Pemakai',
			'create_ruangan' => 'Create Ruangan',
			'lamahrnotif' => 'Lamahrnotif',
			'icon' => 'Icon',
			'class_icon' => 'Class Icon',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('nofitikasi_id',$this->nofitikasi_id);
		$criteria->compare('instalasi_id',$this->instalasi_id);
		$criteria->compare('modul_id',$this->modul_id);
		$criteria->compare('tglnotifikasi',$this->tglnotifikasi,true);
		$criteria->compare('judulnotifikasi',$this->judulnotifikasi,true);
		$criteria->compare('isinotifikasi',$this->isinotifikasi,true);
		$criteria->compare('isread',$this->isread);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('create_loginpemakai_id',$this->create_loginpemakai_id,true);
		$criteria->compare('update_loginpemakai_id',$this->update_loginpemakai_id,true);
		$criteria->compare('create_ruangan',$this->create_ruangan,true);
		$criteria->compare('lamahrnotif',$this->lamahrnotif);
		$criteria->compare('icon',$this->icon,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return NotifikasiR the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function searchNotifikasiAll(){
		$criteria=new CDbCriteria;

		$criteria->addCondition("create_loginpemakai_id != '".Yii::app()->user->getState('loginpemakai_id')."' AND date(tglnotifikasi) = '".date('Y-m-d')."' ");

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
