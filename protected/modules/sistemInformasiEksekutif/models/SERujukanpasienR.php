<?php

/**
 * This is the model class for table "rujukanpasien_r".
 *
 * The followings are the available columns in table 'rujukanpasien_r':
 * @property integer $rujukanpasien_id
 * @property string $tanggal
 * @property integer $rujukanrs
 * @property integer $rujukanklinik
 * @property integer $rujukandokter
 * @property integer $rujukanpuskesmas
 */
class SERujukanpasienR extends RujukanpasienR
{	
	public $jns_periode;
	public $periode, $jumlah_rs, $jumlah_klinik, $jumlah_dokter, $jumlah_puskesmas;
	public $tgl_awal, $tgl_akhir, $bln_awal, $bln_akhir, $thn_awal, $thn_akhir;
	public $data, $data_2;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return RujukanpasienR the static model class
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
		return 'rujukanpasien_r';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('rujukanrs, rujukanklinik, rujukandokter, rujukanpuskesmas', 'numerical', 'integerOnly'=>true),
			array('tanggal', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('rujukanpasien_id, tanggal, rujukanrs, rujukanklinik, rujukandokter, rujukanpuskesmas', 'safe', 'on'=>'search'),
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
			'rujukanpasien_id' => 'Rujukanpasien',
			'tanggal' => 'Tanggal',
			'rujukanrs' => 'Rujukanrs',
			'rujukanklinik' => 'Rujukanklinik',
			'rujukandokter' => 'Rujukandokter',
			'rujukanpuskesmas' => 'Rujukanpuskesmas',
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

		if(!empty($this->rujukanpasien_id)){
			$criteria->addCondition('rujukanpasien_id = '.$this->rujukanpasien_id);
		}
		$criteria->compare('LOWER(tanggal)',strtolower($this->tanggal),true);
		if(!empty($this->rujukanrs)){
			$criteria->addCondition('rujukanrs = '.$this->rujukanrs);
		}
		if(!empty($this->rujukanklinik)){
			$criteria->addCondition('rujukanklinik = '.$this->rujukanklinik);
		}
		if(!empty($this->rujukandokter)){
			$criteria->addCondition('rujukandokter = '.$this->rujukandokter);
		}
		if(!empty($this->rujukanpuskesmas)){
			$criteria->addCondition('rujukanpuskesmas = '.$this->rujukanpuskesmas);
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