<?php

/**
 * This is the model class for table "petunjukpenggunaan_m".
 *
 * The followings are the available columns in table 'petunjukpenggunaan_m':
 * @property integer $petunjukpenggunaan_id
 * @property integer $modul_id
 * @property integer $menu_id
 * @property string $petunjukpenggunaan_versi
 * @property string $petunjukpenggunaan_deskripsi
 * @property string $petunjukpenggunaan_image
 * @property string $petunjukpenggunaan_video
 * @property boolean $petunjukpenggunaan_aktif
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 */
class PetunjukpenggunaanM extends CActiveRecord
{
	public $modul_nama, $menu_nama, $modul_id;

	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PetunjukpenggunaanM the static model class
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
		return 'petunjukpenggunaan_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('menu_id', 'required'),
			array('menu_id, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'numerical', 'integerOnly'=>true),
			array('petunjukpenggunaan_versi', 'length', 'max'=>50),
			array('petunjukpenggunaan_video', 'length', 'max'=>500),
			array('create_time, update_time','safe'),
			array('petunjukpenggunaan_deskripsi, petunjukpenggunaan_aktif', 'safe'),

			array('create_time','default','value'=>date( 'Y-m-d H:i:s'),'setOnEmpty'=>false,'on'=>'insert'),
			array('update_time','default','value'=>date( 'Y-m-d H:i:s'),'setOnEmpty'=>false,'on'=>'update,insert'),
			array('create_loginpemakai_id','default','value'=>Yii::app()->user->id,'on'=>'insert'),
			array('update_loginpemakai_id','default','value'=>Yii::app()->user->id,'on'=>'update,insert'),
			array('create_ruangan','default','value'=>Yii::app()->user->getState('ruangan_id'),'on'=>'insert'),
		
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('petunjukpenggunaan_id, menu_id, petunjukpenggunaan_versi, petunjukpenggunaan_deskripsi, petunjukpenggunaan_video, petunjukpenggunaan_aktif, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
            'menu' => array(self::BELONGS_TO, 'MenumodulK', 'menu_id'),
            // 'modul' => array(self::BELONGS_TO, 'ModulK', 'modul_id'),

		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'petunjukpenggunaan_id' => 'Petunjukpenggunaan',
			// 'modul_id' => 'Modul',
			'menu_id' => 'Menu',
			'petunjukpenggunaan_versi' => 'Versi Petunjuk Penggunaan',
			'petunjukpenggunaan_deskripsi' => 'Deskripsi Petunjuk Penggunaan',
			// 'petunjukpenggunaan_image' => 'Gambar',
			'petunjukpenggunaan_video' => 'Video',
			'petunjukpenggunaan_aktif' => 'Status Aktif',
			'create_time' => 'Waktu Create',
			'update_time' => 'Waktu Update',
			'create_loginpemakai_id' => 'Create Login Pemakai',
			'update_loginpemakai_id' => 'Update Login Pemakai',
			'create_ruangan' => 'Create Ruangan',
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

		$criteria->compare('petunjukpenggunaan_id',$this->petunjukpenggunaan_id);
		// $criteria->compare('modul_id',$this->modul_id);
		$criteria->compare('menu_id',$this->menu_id);
		$criteria->compare('petunjukpenggunaan_versi',$this->petunjukpenggunaan_versi,true);
		$criteria->compare('petunjukpenggunaan_deskripsi',$this->petunjukpenggunaan_deskripsi,true);
		// $criteria->compare('petunjukpenggunaan_image',$this->petunjukpenggunaan_image,true);
		$criteria->compare('petunjukpenggunaan_video',$this->petunjukpenggunaan_video,true);
		$criteria->compare('petunjukpenggunaan_aktif',$this->petunjukpenggunaan_aktif);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('create_loginpemakai_id',$this->create_loginpemakai_id);
		$criteria->compare('update_loginpemakai_id',$this->update_loginpemakai_id);
		$criteria->compare('create_ruangan',$this->create_ruangan);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function searchPrint()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('petunjukpenggunaan_id',$this->petunjukpenggunaan_id);
		// $criteria->compare('modul_id',$this->modul_id);
		$criteria->compare('menu_id',$this->menu_id);
		$criteria->compare('petunjukpenggunaan_versi',$this->petunjukpenggunaan_versi,true);
		$criteria->compare('petunjukpenggunaan_deskripsi',$this->petunjukpenggunaan_deskripsi,true);
		// $criteria->compare('petunjukpenggunaan_image',$this->petunjukpenggunaan_image,true);
		$criteria->compare('petunjukpenggunaan_video',$this->petunjukpenggunaan_video,true);
		$criteria->compare('petunjukpenggunaan_aktif',$this->petunjukpenggunaan_aktif);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('create_loginpemakai_id',$this->create_loginpemakai_id);
		$criteria->compare('update_loginpemakai_id',$this->update_loginpemakai_id);
		$criteria->compare('create_ruangan',$this->create_ruangan);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	function getNamaMenu(){
		$var = '';
		if(!empty($this->menu_id)){
			$menu = MenumodulK::model()->findByPk($this->menu_id);
			$var = (!empty($menu)? $menu->menu_nama :"");
		}

		return $var;
	}
}