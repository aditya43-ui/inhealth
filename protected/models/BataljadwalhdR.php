<?php

/**
 * This is the model class for table "bataljadwalhd_r".
 *
 * The followings are the available columns in table 'bataljadwalhd_r':
 * @property integer $bataljadwalhd_id
 * @property integer $pasien_id
 * @property string $bataljadwalhd_tgl
 * @property string $bataljadwalhd_alasan
 * @property string $bataljadwalhd_desc
 * @property string $bjhd_create_time
 * @property string $bjhd_update_time
 * @property integer $bjhd_create_loginid
 * @property integer $bjhd_update_loginid
 * @property integer $bjhd_create_ruangan_id
 */
class BataljadwalhdR extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return BataljadwalhdR the static model class
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
		return 'bataljadwalhd_r';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pasien_id, bataljadwalhd_tgl, bataljadwalhd_alasan, bjhd_create_time, bjhd_create_loginid, bjhd_create_ruangan_id', 'required'),
			array('bataljadwalhd_id, pasien_id, bjhd_create_loginid, bjhd_update_loginid, bjhd_create_ruangan_id', 'numerical', 'integerOnly'=>true),
			array('bataljadwalhd_alasan', 'length', 'max'=>200),
			array('bataljadwalhd_desc, bjhd_update_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('bataljadwalhd_id, pasien_id, bataljadwalhd_tgl, bataljadwalhd_alasan, bataljadwalhd_desc, bjhd_create_time, bjhd_update_time, bjhd_create_loginid, bjhd_update_loginid, bjhd_create_ruangan_id', 'safe', 'on'=>'search'),
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
			'bataljadwalhd_id' => 'ID Batal',
			'pasien_id' => 'Pasien',
			'bataljadwalhd_tgl' => 'Tanggal Pembatalan',
			'bataljadwalhd_alasan' => 'Alasan Pembatalan',
			'bataljadwalhd_desc' => 'Deskripsi',
			'bjhd_create_time' => 'Bjhd Create Time',
			'bjhd_update_time' => 'Bjhd Update Time',
			'bjhd_create_loginid' => 'Bjhd Create Loginid',
			'bjhd_update_loginid' => 'Bjhd Update Loginid',
			'bjhd_create_ruangan_id' => 'Bjhd Create Ruangan',
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

		if(!empty($this->bataljadwalhd_id)){
			$criteria->addCondition('bataljadwalhd_id = '.$this->bataljadwalhd_id);
		}
		if(!empty($this->pasien_id)){
			$criteria->addCondition('pasien_id = '.$this->pasien_id);
		}
		$criteria->compare('LOWER(bataljadwalhd_tgl)',strtolower($this->bataljadwalhd_tgl),true);
		$criteria->compare('LOWER(bataljadwalhd_alasan)',strtolower($this->bataljadwalhd_alasan),true);
		$criteria->compare('LOWER(bataljadwalhd_desc)',strtolower($this->bataljadwalhd_desc),true);
		$criteria->compare('LOWER(bjhd_create_time)',strtolower($this->bjhd_create_time),true);
		$criteria->compare('LOWER(bjhd_update_time)',strtolower($this->bjhd_update_time),true);
		if(!empty($this->bjhd_create_loginid)){
			$criteria->addCondition('bjhd_create_loginid = '.$this->bjhd_create_loginid);
		}
		if(!empty($this->bjhd_update_loginid)){
			$criteria->addCondition('bjhd_update_loginid = '.$this->bjhd_update_loginid);
		}
		if(!empty($this->bjhd_create_ruangan_id)){
			$criteria->addCondition('bjhd_create_ruangan_id = '.$this->bjhd_create_ruangan_id);
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