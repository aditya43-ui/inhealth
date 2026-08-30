<?php

/**
 * This is the model class for table "kriteriaicu_m".
 *
 * The followings are the available columns in table 'kriteriaicu_m':
 * @property integer $kriteriaicu_id
 * @property string $jenis_kriteria
 * @property string $deskripsi
 * @property integer $level_kriteria
 * @property integer $berhubungan_dengan
 * @property integer $urutan
 * @property boolean $status
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai
 * @property integer $update_loginpemakai
 * @property integer $create_ruangan
 *
 * The followings are the available model relations:
 * @property KriteriaicuM $berhubunganDengan
 * @property KriteriaicuM[] $kriteriaicuMs
 */
class KriteriaicuM extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return KriteriaicuM the static model class
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
		return 'kriteriaicu_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('jenis_kriteria, deskripsi, level_kriteria, urutan, create_time, create_loginpemakai, create_ruangan', 'required'),
			array('level_kriteria, berhubungan_dengan, urutan, create_loginpemakai, update_loginpemakai, create_ruangan', 'numerical', 'integerOnly'=>true),
			array('jenis_kriteria', 'length', 'max'=>100),
			array('deskripsi', 'length', 'max'=>200),
			array('status, update_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('kriteriaicu_id, jenis_kriteria, deskripsi, level_kriteria, berhubungan_dengan, urutan, status, create_time, update_time, create_loginpemakai, update_loginpemakai, create_ruangan', 'safe', 'on'=>'search'),
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
			'berhubunganDengan' => array(self::BELONGS_TO, 'KriteriaicuM', 'berhubungan_dengan'),
			'kriteriaicuMs' => array(self::HAS_MANY, 'KriteriaicuM', 'berhubungan_dengan'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'kriteriaicu_id' => 'Kriteriaicu',
			'jenis_kriteria' => 'Jenis Kriteria',
			'deskripsi' => 'Deskripsi',
			'level_kriteria' => 'Level',
			'berhubungan_dengan' => 'Berhubungan Dengan',
			'urutan' => 'Urutan',
			'status' => 'Status',
			'create_time' => 'Create Time',
			'update_time' => 'Update Time',
			'create_loginpemakai' => 'Create Loginpemakai',
			'update_loginpemakai' => 'Update Loginpemakai',
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
		$criteria->compare('jenis_kriteria',$this->jenis_kriteria);
		$criteria->compare('level_kriteria',$this->level_kriteria);

		if(!empty($this->berhubungan_dengan)){
			$criteria->addCondition('berhubungan_dengan = '.$this->berhubungan_dengan);
		}
		$criteria->compare('LOWER(deskripsi)',strtolower($this->deskripsi),true);

		$criteria->compare('status',$this->status);
	
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function searchPrint()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
		$criteria->compare('jenis_kriteria',$this->jenis_kriteria);
		$criteria->compare('level_kriteria',$this->level_kriteria);

		if(!empty($this->berhubungan_dengan)){
			$criteria->addCondition('berhubungan_dengan = '.$this->berhubungan_dengan);
		}
		$criteria->compare('LOWER(deskripsi)',strtolower($this->deskripsi),true);

		$criteria->compare('status',$this->status);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>false
		));
	}
}
