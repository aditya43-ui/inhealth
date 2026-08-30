<?php

/**
 * This is the model class for table "kelompokfaktorrisikodaftar_m".
 * 
 * @author Yudhit Widy Wicaksono <yudhitwicaksono@.com>
 * @package application.models
 *
 * The followings are the available columns in table 'kelompokfaktorrisikodaftar_m':
 * @property integer $kelompokfaktorrisikodaftar_id
 * @property integer $jenisfaktorrisiko_id
 * @property integer $faktorrisiko_daftar_id
 * @property boolean $kelompokfaktorrisikodaftar_aktif
 * @property integer $kelompokfaktorrisikodaftar_urutan
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan_id
 *
 * The followings are the available model relations:
 * @property FaktorrisikoDaftarM $faktorrisikoDaftar
 * @property JenisfaktorrisikoM $jenisfaktorrisiko
 * @property FaktorrisikoM[] $faktorrisikoMs
 */
class KelompokfaktorrisikodaftarM extends CActiveRecord
{
        public $faktorrisiko_daftar_nama, $jenisfaktorrisiko_nama, $no, $status;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return KelompokfaktorrisikodaftarM the static model class
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
		return 'kelompokfaktorrisikodaftar_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('faktorrisiko_daftar_id, create_time, create_loginpemakai_id, create_ruangan_id', 'required'),
			array('jenisfaktorrisiko_id, faktorrisiko_daftar_id, kelompokfaktorrisikodaftar_urutan, create_loginpemakai_id, update_loginpemakai_id, create_ruangan_id', 'numerical', 'integerOnly'=>true),
			array('kelompokfaktorrisikodaftar_aktif, update_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('kelompokfaktorrisikodaftar_id, jenisfaktorrisiko_id, faktorrisiko_daftar_id, kelompokfaktorrisikodaftar_aktif, kelompokfaktorrisikodaftar_urutan, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan_id', 'safe', 'on'=>'search'),
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
			'faktorrisikoDaftar' => array(self::BELONGS_TO, 'FaktorrisikoDaftarM', 'faktorrisiko_daftar_id'),
			'jenisfaktorrisiko' => array(self::BELONGS_TO, 'JenisfaktorrisikoM', 'jenisfaktorrisiko_id'),
			'faktorrisikoMs' => array(self::HAS_MANY, 'FaktorrisikoM', 'kelompokfaktorrisikodaftar_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'kelompokfaktorrisikodaftar_id' => 'Kelompokfaktorrisikodaftar',
			'jenisfaktorrisiko_id' => 'Jenisfaktorrisiko',
			'faktorrisiko_daftar_id' => 'Faktorrisiko Daftar',
			'kelompokfaktorrisikodaftar_aktif' => 'Kelompokfaktorrisikodaftar Aktif',
			'kelompokfaktorrisikodaftar_urutan' => 'Kelompokfaktorrisikodaftar Urutan',
			'create_time' => 'Waktu Create',
			'update_time' => 'Waktu Update',
			'create_loginpemakai_id' => 'Create Login Pemakai',
			'update_loginpemakai_id' => 'Update Login Pemakai',
			'create_ruangan_id' => 'Create Ruangan',
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
                $criteria->select = 't.*, faktorrisiko_daftar_m.faktorrisiko_daftar_nama, jenisfaktorrisiko_m.jenisfaktorrisiko_nama ';
                $criteria->join = 'LEFT JOIN jenisfaktorrisiko_m ON jenisfaktorrisiko_m.jenisfaktorrisiko_id = t.jenisfaktorrisiko_id '
                        . 'LEFT JOIN faktorrisiko_daftar_m ON faktorrisiko_daftar_m.faktorrisiko_daftar_id = t.faktorrisiko_daftar_id ';
		$criteria->compare('t.kelompokfaktorrisikodaftar_id',$this->kelompokfaktorrisikodaftar_id);
                $criteria->compare('t.jenisfaktorrisiko_id', $this->jenisfaktorrisiko_id);
		$criteria->compare('t.faktorrisiko_daftar_id',$this->faktorrisiko_daftar_id);
		$criteria->compare('t.kelompokfaktorrisikodaftar_aktif',isset($this->kelompokfaktorrisikodaftar_aktif) ? $this->kelompokfaktorrisikodaftar_aktif : true);
		$criteria->compare('t.kelompokfaktorrisikodaftar_urutan',$this->kelompokfaktorrisikodaftar_urutan);
                $criteria->compare('LOWER(faktorrisiko_daftar_m.faktorrisiko_daftar_nama)', strtolower($this->faktorrisiko_daftar_nama), true);
                $criteria->compare('LOWER(jenisfaktorrisiko_m.jenisfaktorrisiko_nama)', strtolower($this->jenisfaktorrisiko_nama), true);
		$criteria->compare('t.create_time',$this->create_time,true);
		$criteria->compare('t.update_time',$this->update_time,true);
		$criteria->compare('t.create_loginpemakai_id',$this->create_loginpemakai_id);
		$criteria->compare('t.update_loginpemakai_id',$this->update_loginpemakai_id);
		$criteria->compare('t.create_ruangan_id',$this->create_ruangan_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        /**
        * untuk mendapatkan data jenis faktor
        * @return type
        */
       public function getJenisFaktorItems() {
           return JenisfaktorrisikoM::model()->findAll('jenisfaktorrisiko_aktif=TRUE ORDER BY jenisfaktorrisiko_nama');
       }

       /**
        * untuk mendapatkan data faktor risiko
        * @return type
        */
       public function getFaktorRisikoItems() {
           return FaktorrisikoDaftarM::model()->findAll('faktorrisiko_daftar_aktif=TRUE ORDER BY faktorrisiko_daftar_nama');
       }
}