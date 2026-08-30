<?php

/**
 * This is the model class for table "periodeasetopname_k".
 *
 * The followings are the available columns in table 'periodeasetopname_k':
 * @property integer $periodeasetopname_id
 * @property string $periodeasetopname_nama
 * @property string $tanggal_awal
 * @property string $tanggal_akhir
 * @property boolean $periodeasetopname_aktif
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 *
 * The followings are the available model relations:
 * @property AsetopnameT[] $asetopnameTs
 */
class PeriodeasetopnameK extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PeriodeasetopnameK the static model class
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
		return 'periodeasetopname_k';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('periodeasetopname_nama, tanggal_awal, tanggal_akhir, create_time, create_loginpemakai_id, create_ruangan', 'required'),
			array('create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'numerical', 'integerOnly'=>true),
			array('periodeasetopname_nama', 'length', 'max'=>100),
			array('periodeasetopname_aktif, update_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('periodeasetopname_id, periodeasetopname_nama, tanggal_awal, tanggal_akhir, periodeasetopname_aktif, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
			'asetopnameTs' => array(self::HAS_MANY, 'AsetopnameT', 'periodeasetopname_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'periodeasetopname_id' => 'Periodeasetopname',
			'periodeasetopname_nama' => 'Periode Aset Opname',
			'tanggal_awal' => 'Tanggal',
			'tanggal_akhir' => 'Tanggal Akhir',
			'periodeasetopname_aktif' => 'Status',
			'create_time' => 'Create Time',
			'update_time' => 'Update Time',
			'create_loginpemakai_id' => 'Create Loginpemakai',
			'update_loginpemakai_id' => 'Update Loginpemakai',
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

		$criteria->compare('periodeasetopname_id',$this->periodeasetopname_id);
		$criteria->compare('LOWER(periodeasetopname_nama)', strtolower($this->periodeasetopname_nama),true);
                if (!empty($this->tanggal_awal)){
                    $criteria->addCondition("tanggal_awal = '".$this->tanggal_awal."' ");
                }
                if (!empty($this->tanggal_akhir)){
                    $criteria->addCondition("tanggal_akhir = '".$this->tanggal_akhir."' ");
                }		
		$criteria->compare('periodeasetopname_aktif', isset($this->periodeasetopname_aktif)?$this->periodeasetopname_aktif:true);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('create_loginpemakai_id',$this->create_loginpemakai_id);
		$criteria->compare('update_loginpemakai_id',$this->update_loginpemakai_id);
		$criteria->compare('create_ruangan',$this->create_ruangan);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}