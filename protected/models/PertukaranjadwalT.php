<?php

/**
 * This is the model class for table "pertukaranjadwal_t".
 *
 * The followings are the available columns in table 'pertukaranjadwal_t':
 * @property integer $pertukaranjadwal_id
 * @property integer $ruangan_id
 * @property string $tglpermohonanpertukaran
 * @property string $no_permohonanpertukaran
 * @property integer $ygmengajukan1_id
 * @property integer $ygmengjajukan2_id
 * @property integer $ygmenyetujui1_id
 * @property integer $ygmenyetujui2_id
 * @property integer $ygmengetahui_id
 */
class PertukaranjadwalT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PertukaranjadwalT the static model class
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
		return 'pertukaranjadwal_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('tglpermohonanpertukaran, no_permohonanpertukaran', 'required'),
			array('ruangan_id, ygmengajukan1_id, ygmengjajukan2_id, ygmenyetujui1_id, ygmenyetujui2_id, ygmengetahui_id', 'numerical', 'integerOnly'=>true),
			array('no_permohonanpertukaran', 'length', 'max'=>20),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('pertukaranjadwal_id, ruangan_id, tglpermohonanpertukaran, no_permohonanpertukaran, ygmengajukan1_id, ygmengjajukan2_id, ygmenyetujui1_id, ygmenyetujui2_id, ygmengetahui_id', 'safe', 'on'=>'search'),
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
			'ygmengajukan1'=>array(self::BELONGS_TO,'PegawaiM','ygmengajukan1_id'),
			'ygmengajukan2'=>array(self::BELONGS_TO,'PegawaiM','ygmengjajukan2_id'),
			'ygmenyetujui1'=>array(self::BELONGS_TO,'PegawaiM','ygmenyetujui1_id'),
			'ygmenyetujui2'=>array(self::BELONGS_TO,'PegawaiM','ygmenyetujui2_id'),
			'ygmengetahui'=>array(self::BELONGS_TO,'PegawaiM','ygmengetahui_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'pertukaranjadwal_id' => 'Pertukaran Jadwal',
			'ruangan_id' => 'Ruangan',
			'tglpermohonanpertukaran' => 'Tanggal Permohonan',
			'no_permohonanpertukaran' => 'No. Permohonan',
			'ygmengajukan1_id' => 'Yang Mengajukan 1',
			'ygmengjajukan2_id' => 'Yang Mengajukan 2',
			'ygmenyetujui1_id' => 'Yang Menyetujui 1',
			'ygmenyetujui2_id' => 'Yang Menyetujui 2',
			'ygmengetahui_id' => 'Yang Mengetahui',
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

		if(!empty($this->pertukaranjadwal_id)){
			$criteria->addCondition('pertukaranjadwal_id = '.$this->pertukaranjadwal_id);
		}
		if(!empty($this->ruangan_id)){
			$criteria->addCondition('ruangan_id = '.$this->ruangan_id);
		}
		$criteria->compare('LOWER(tglpermohonanpertukaran)',strtolower($this->tglpermohonanpertukaran),true);
		$criteria->compare('LOWER(no_permohonanpertukaran)',strtolower($this->no_permohonanpertukaran),true);
		if(!empty($this->ygmengajukan1_id)){
			$criteria->addCondition('ygmengajukan1_id = '.$this->ygmengajukan1_id);
		}
		if(!empty($this->ygmengjajukan2_id)){
			$criteria->addCondition('ygmengjajukan2_id = '.$this->ygmengjajukan2_id);
		}
		if(!empty($this->ygmenyetujui1_id)){
			$criteria->addCondition('ygmenyetujui1_id = '.$this->ygmenyetujui1_id);
		}
		if(!empty($this->ygmenyetujui2_id)){
			$criteria->addCondition('ygmenyetujui2_id = '.$this->ygmenyetujui2_id);
		}
		if(!empty($this->ygmengetahui_id)){
			$criteria->addCondition('ygmengetahui_id = '.$this->ygmengetahui_id);
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