<?php

/**
 * This is the model class for table "gantijadwalhd_r".
 *
 * The followings are the available columns in table 'gantijadwalhd_r':
 * @property integer $gantijadwalhd_id
 * @property integer $pasien_id
 * @property string $gantijadwalhd_tgl
 * @property string $gantijadwalhd_alasan
 * @property string $gantijadwalhd_desc
 * @property string $gantijadwalhd_tglsblmnya
 * @property string $gjhd_create_time
 * @property string $gjhd_update_time
 * @property integer $gjhd_create_loginid
 * @property integer $gjhd_update_loginid
 * @property integer $gjhd_create_ruangan_id
 * @property string $gjhd_create_iphost
 */
class GantijadwalhdR extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return GantijadwalhdR the static model class
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
		return 'gantijadwalhd_r';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('gantijadwalhd_tgl, gantijadwalhd_alasan, gantijadwalhd_tglsblmnya, gjhd_create_time, gjhd_create_loginid, gjhd_create_ruangan_id, gjhd_create_iphost', 'required'),
			array('pasien_id, gjhd_create_loginid, gjhd_update_loginid, gjhd_create_ruangan_id', 'numerical', 'integerOnly'=>true),
			array('gantijadwalhd_alasan', 'length', 'max'=>100),
			array('gjhd_create_iphost', 'length', 'max'=>50),
			array('gantijadwalhd_desc, gjhd_update_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('gantijadwalhd_id, pasien_id, gantijadwalhd_tgl, gantijadwalhd_alasan, gantijadwalhd_desc, gantijadwalhd_tglsblmnya, gjhd_create_time, gjhd_update_time, gjhd_create_loginid, gjhd_update_loginid, gjhd_create_ruangan_id, gjhd_create_iphost', 'safe', 'on'=>'search'),
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
			'gantijadwalhd_id' => 'Id Ganti',
			'pasien_id' => 'Pasien',
			'gantijadwalhd_tgl' => 'Tanggal Ubah',
			'gantijadwalhd_alasan' => 'Alasan Ubah',
			'gantijadwalhd_desc' => 'Deskripsi',
			'gantijadwalhd_tglsblmnya' => 'Tgl. Sebelumnya',
			'gjhd_create_time' => 'Gjhd Create Time',
			'gjhd_update_time' => 'Gjhd Update Time',
			'gjhd_create_loginid' => 'Gjhd Create Loginid',
			'gjhd_update_loginid' => 'Gjhd Update Loginid',
			'gjhd_create_ruangan_id' => 'Gjhd Create Ruangan',
			'gjhd_create_iphost' => 'Gjhd Create Iphost',
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

		if(!empty($this->gantijadwalhd_id)){
			$criteria->addCondition('gantijadwalhd_id = '.$this->gantijadwalhd_id);
		}
		if(!empty($this->pasien_id)){
			$criteria->addCondition('pasien_id = '.$this->pasien_id);
		}
		$criteria->compare('LOWER(gantijadwalhd_tgl)',strtolower($this->gantijadwalhd_tgl),true);
		$criteria->compare('LOWER(gantijadwalhd_alasan)',strtolower($this->gantijadwalhd_alasan),true);
		$criteria->compare('LOWER(gantijadwalhd_desc)',strtolower($this->gantijadwalhd_desc),true);
		$criteria->compare('LOWER(gantijadwalhd_tglsblmnya)',strtolower($this->gantijadwalhd_tglsblmnya),true);
		$criteria->compare('LOWER(gjhd_create_time)',strtolower($this->gjhd_create_time),true);
		$criteria->compare('LOWER(gjhd_update_time)',strtolower($this->gjhd_update_time),true);
		if(!empty($this->gjhd_create_loginid)){
			$criteria->addCondition('gjhd_create_loginid = '.$this->gjhd_create_loginid);
		}
		if(!empty($this->gjhd_update_loginid)){
			$criteria->addCondition('gjhd_update_loginid = '.$this->gjhd_update_loginid);
		}
		if(!empty($this->gjhd_create_ruangan_id)){
			$criteria->addCondition('gjhd_create_ruangan_id = '.$this->gjhd_create_ruangan_id);
		}
		$criteria->compare('LOWER(gjhd_create_iphost)',strtolower($this->gjhd_create_iphost),true);

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