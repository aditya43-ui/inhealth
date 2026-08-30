<?php

/**
 * This is the model class for table "laporanmesinsterilisasi_v".
 *
 * The followings are the available columns in table 'laporanmesinsterilisasi_v':
 * @property string $sterilisasi_tgl
 * @property integer $sterilisasi_id
 * @property string $sterilisasi_no
 * @property string $nama_pegawai
 * @property string $alatmedis_nama
 * @property string $barang_nama
 * @property integer $sterilisasidetail_jml
 * @property string $sterilisasidetail_ket
 */
class LaporanmesinsterilisasiV extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return LaporanmesinsterilisasiV the static model class
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
		return 'laporanmesinsterilisasi_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('sterilisasi_id, sterilisasidetail_jml', 'numerical', 'integerOnly'=>true),
			array('sterilisasi_no', 'length', 'max'=>20),
			array('nama_pegawai', 'length', 'max'=>50),
			array('alatmedis_nama, barang_nama', 'length', 'max'=>100),
			array('sterilisasidetail_ket', 'length', 'max'=>200),
			array('sterilisasi_tgl', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('sterilisasi_tgl, sterilisasi_id, sterilisasi_no, nama_pegawai, alatmedis_nama, barang_nama, sterilisasidetail_jml, sterilisasidetail_ket', 'safe', 'on'=>'search'),
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
			'sterilisasi_tgl' => 'Sterilisasi Tgl',
			'sterilisasi_id' => 'Sterilisasi',
			'sterilisasi_no' => 'Sterilisasi No',
			'nama_pegawai' => 'Nama Pegawai',
			'alatmedis_nama' => 'Alatmedis Nama',
			'barang_nama' => 'Barang Nama',
			'sterilisasidetail_jml' => 'Sterilisasidetail Jml',
			'sterilisasidetail_ket' => 'Sterilisasidetail Ket',
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

		$criteria->compare('LOWER(sterilisasi_tgl)',strtolower($this->sterilisasi_tgl),true);
		if(!empty($this->sterilisasi_id)){
			$criteria->addCondition('sterilisasi_id = '.$this->sterilisasi_id);
		}
		$criteria->compare('LOWER(sterilisasi_no)',strtolower($this->sterilisasi_no),true);
		$criteria->compare('LOWER(nama_pegawai)',strtolower($this->nama_pegawai),true);
		$criteria->compare('LOWER(alatmedis_nama)',strtolower($this->alatmedis_nama),true);
		$criteria->compare('LOWER(barang_nama)',strtolower($this->barang_nama),true);
		if(!empty($this->sterilisasidetail_jml)){
			$criteria->addCondition('sterilisasidetail_jml = '.$this->sterilisasidetail_jml);
		}
		$criteria->compare('LOWER(sterilisasidetail_ket)',strtolower($this->sterilisasidetail_ket),true);

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