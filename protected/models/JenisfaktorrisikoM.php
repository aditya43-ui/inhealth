<?php

/**
 * This is the model class for table "jenisfaktorrisiko_m".
 *
 * The followings are the available columns in table 'jenisfaktorrisiko_m':
 * @property integer $jenisfaktorrisiko_id
 * @property string $jenisfaktorrisiko_nama
 * @property string $jenisfaktorrisiko_namalain
 * @property integer $jenisfaktorrisiko_urutan
 * @property boolean $jenisfaktorrisiko_aktif
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan_id
 *
 * The followings are the available model relations:
 * @property KelompokfaktorrisikodaftarM[] $kelompokfaktorrisikodaftarMs
 */
class JenisfaktorrisikoM extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return JenisfaktorrisikoM the static model class
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
		return 'jenisfaktorrisiko_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('jenisfaktorrisiko_nama, create_time, create_loginpemakai_id, create_ruangan_id', 'required'),
			array('jenisfaktorrisiko_urutan, create_loginpemakai_id, update_loginpemakai_id, create_ruangan_id', 'numerical', 'integerOnly'=>true),
			array('jenisfaktorrisiko_nama, jenisfaktorrisiko_namalain', 'length', 'max'=>100),
			array('jenisfaktorrisiko_aktif, update_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('jenisfaktorrisiko_id, jenisfaktorrisiko_nama, jenisfaktorrisiko_namalain, jenisfaktorrisiko_urutan, jenisfaktorrisiko_aktif, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan_id', 'safe', 'on'=>'search'),
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
			'kelompokfaktorrisikodaftarMs' => array(self::HAS_MANY, 'KelompokfaktorrisikodaftarM', 'jenisfaktorrisiko_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'jenisfaktorrisiko_id' => 'Jenisfaktorrisiko',
			'jenisfaktorrisiko_nama' => 'Jenisfaktorrisiko Nama',
			'jenisfaktorrisiko_namalain' => 'Jenisfaktorrisiko Namalain',
			'jenisfaktorrisiko_urutan' => 'Jenisfaktorrisiko Urutan',
			'jenisfaktorrisiko_aktif' => 'Jenisfaktorrisiko Aktif',
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

		$criteria->compare('jenisfaktorrisiko_id',$this->jenisfaktorrisiko_id);
		$criteria->compare('jenisfaktorrisiko_nama',$this->jenisfaktorrisiko_nama,true);
		$criteria->compare('jenisfaktorrisiko_namalain',$this->jenisfaktorrisiko_namalain,true);
		$criteria->compare('jenisfaktorrisiko_urutan',$this->jenisfaktorrisiko_urutan);
		$criteria->compare('jenisfaktorrisiko_aktif',$this->jenisfaktorrisiko_aktif);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('create_loginpemakai_id',$this->create_loginpemakai_id);
		$criteria->compare('update_loginpemakai_id',$this->update_loginpemakai_id);
		$criteria->compare('create_ruangan_id',$this->create_ruangan_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        /**
         * Set data dropdown jenis faktor risiko
         * @return array $data option untuk dropdown
         */
        public static function getDropDownJenis() {
           $data = array();
           $criteria = new CDbCriteria();
           $criteria->order = "jenisfaktorrisiko_nama ASC";
           $models = JenisfaktorrisikoM::model()->findAll($criteria);
           if (count($models) > 0) {
               foreach ($models as $model) {
                   $data[$model->jenisfaktorrisiko_id] = $model->jenisfaktorrisiko_nama;
               }
           }
           return $data;
       }
}