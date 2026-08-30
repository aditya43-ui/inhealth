<?php

/**
 * This is the model class for table "coolboxdarah_m".
 *
 * The followings are the available columns in table 'coolboxdarah_m':
 * @property integer $coolboxdarah_id
 * @property integer $jml_icepack
 * @property string $coolboxdarah_nama
 * @property string $coolbox_merk
 * @property string $coolbox_jenis
 * @property string $coolbox_ukuran
 * @property integer $coolbox_jml
 * @property integer $jml_isikantong
 *
 * The followings are the available model relations:
 * @property MonitoringkantongT[] $monitoringkantongTs
 */
class CoolboxdarahM extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return CoolboxdarahM the static model class
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
		return 'coolboxdarah_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('coolboxdarah_nama', 'required'),
			array('jml_icepack, coolbox_jml, jml_isikantong', 'numerical', 'integerOnly'=>true),
			array('coolboxdarah_nama', 'length', 'max'=>100),
			array('coolbox_merk, coolbox_jenis, coolbox_ukuran, jenis_kantong, standart_suhu', 'length', 'max'=>50),
                        array('coolbox_aktif', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('coolboxdarah_id, jml_icepack, coolboxdarah_nama, coolbox_merk, coolbox_jenis, coolbox_ukuran, coolbox_jml, jml_isikantong, jenis_kantong, standart_suhu, coolbox_aktif', 'safe', 'on'=>'search'),
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
			'monitoringkantongTs' => array(self::HAS_MANY, 'MonitoringkantongT', 'coolboxdarah_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'coolboxdarah_id' => 'Coolboxdarah',
			'jml_icepack' => 'Jumlah Kantong',
			'coolboxdarah_nama' => 'Nama Cool Box',
			'coolbox_merk' => 'Merek',
			'coolbox_jenis' => 'Jenis Cool Box',
			'coolbox_ukuran' => 'Ukuran',
			'coolbox_jml' => 'Jumlah Ice Pack',
			'jml_isikantong' => 'Jumlah Isi kantong',
                        'jenis_kantong' => 'Jenis Kantong',
                        'standart_suhu' => 'Standart Suhu',
                        'coolbox_aktif' => 'Aktif',
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

		if(!empty($this->coolboxdarah_id)){
			$criteria->addCondition('coolboxdarah_id = '.$this->coolboxdarah_id);
		}
		if(!empty($this->jml_icepack)){
			$criteria->addCondition('jml_icepack = '.$this->jml_icepack);
		}
		$criteria->compare('LOWER(coolboxdarah_nama)',strtolower($this->coolboxdarah_nama),true);
		$criteria->compare('LOWER(coolbox_merk)',strtolower($this->coolbox_merk),true);
		$criteria->compare('LOWER(coolbox_jenis)',strtolower($this->coolbox_jenis),true);
		$criteria->compare('LOWER(coolbox_ukuran)',strtolower($this->coolbox_ukuran),true);
                $criteria->compare('LOWER(jenis_kantong)',strtolower($this->jenis_kantong),true);
                $criteria->compare('LOWER(standart_suhu)',strtolower($this->standart_suhu),true);
                $criteria->compare('LOWER(coolbox_aktif)',strtolower($this->coolbox_aktif),true);
		if(!empty($this->coolbox_jml)){
			$criteria->addCondition('coolbox_jml = '.$this->coolbox_jml);
		}
		if(!empty($this->jml_isikantong)){
			$criteria->addCondition('jml_isikantong = '.$this->jml_isikantong);
		}

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

            $criteria=new CDbCriteria;

		if(!empty($this->coolboxdarah_id)){
			$criteria->addCondition('coolboxdarah_id = '.$this->coolboxdarah_id);
		}
		
                $criteria->compare('jml_icepack',$this->jml_icepack,true);
		$criteria->compare('LOWER(coolboxdarah_nama)',strtolower($this->coolboxdarah_nama),true);
		$criteria->compare('LOWER(coolbox_merk)',strtolower($this->coolbox_merk),true);
		$criteria->compare('LOWER(coolbox_jenis)',strtolower($this->coolbox_jenis),true);
		$criteria->compare('LOWER(coolbox_ukuran)',strtolower($this->coolbox_ukuran),true);
                $criteria->compare('LOWER(jenis_kantong)',strtolower($this->jenis_kantong),true);
                $criteria->compare('LOWER(standart_suhu)',strtolower($this->standart_suhu),true);
                $criteria->compare('coolbox_aktif',isset($this->coolbox_aktif)?$this->coolbox_aktif:true);

            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
            ));
        }
}