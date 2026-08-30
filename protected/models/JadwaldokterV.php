<?php

/**
 * This is the model class for table "jadwaldokter_v".
 *
 * The followings are the available columns in table 'jadwaldokter_v':
 * @property integer $ruangan_id
 * @property string $ruangan_nama
 * @property integer $instalasi_id
 * @property string $jadwaldokter_tgl
 * @property string $jadwaldokter_hari
 * @property string $jadwaldokter_buka
 * @property string $jadwaldokter_mulai
 * @property string $jadwaldokter_tutup
 * @property string $gelardepan
 * @property string $nama_pegawai
 * @property string $gelarbelakang_nama
 */
class JadwaldokterV extends CActiveRecord
{        
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return JadwaldokterV the static model class
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
		return 'jadwaldokter_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('ruangan_id, instalasi_id', 'numerical', 'integerOnly'=>true),
			array('ruangan_nama, jadwaldokter_buka, nama_pegawai', 'length', 'max'=>50),
			array('jadwaldokter_hari', 'length', 'max'=>20),
			array('gelardepan', 'length', 'max'=>10),
			array('gelarbelakang_nama', 'length', 'max'=>15),
			array('jadwaldokter_tgl, jadwaldokter_mulai, jadwaldokter_tutup', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('ruangan_id, ruangan_nama, instalasi_id, jadwaldokter_tgl, jadwaldokter_hari, jadwaldokter_buka, jadwaldokter_mulai, jadwaldokter_tutup, gelardepan, nama_pegawai, gelarbelakang_nama', 'safe', 'on'=>'search'),
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
			'ruangan_id' => 'Ruangan',
			'ruangan_nama' => 'Ruangan Nama',
			'instalasi_id' => 'Instalasi',
			'jadwaldokter_tgl' => 'Jadwaldokter Tgl',
			'jadwaldokter_hari' => 'Jadwaldokter Hari',
			'jadwaldokter_buka' => 'Jadwaldokter Buka',
			'jadwaldokter_mulai' => 'Jadwaldokter Mulai',
			'jadwaldokter_tutup' => 'Jadwaldokter Tutup',
			'gelardepan' => 'Gelardepan',
			'nama_pegawai' => 'Nama Pegawai',
			'gelarbelakang_nama' => 'Gelarbelakang Nama',
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

		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('LOWER(ruangan_nama)',strtolower($this->ruangan_nama),true);
		$criteria->compare('instalasi_id',$this->instalasi_id);
		$criteria->compare('LOWER(jadwaldokter_tgl)',strtolower($this->jadwaldokter_tgl),true);
		$criteria->compare('LOWER(jadwaldokter_hari)',strtolower($this->jadwaldokter_hari),true);
		$criteria->compare('LOWER(jadwaldokter_buka)',strtolower($this->jadwaldokter_buka),true);
		$criteria->compare('LOWER(jadwaldokter_mulai)',strtolower($this->jadwaldokter_mulai),true);
		$criteria->compare('LOWER(jadwaldokter_tutup)',strtolower($this->jadwaldokter_tutup),true);
		$criteria->compare('LOWER(gelardepan)',strtolower($this->gelardepan),true);
		$criteria->compare('LOWER(nama_pegawai)',strtolower($this->nama_pegawai),true);
		$criteria->compare('LOWER(gelarbelakang_nama)',strtolower($this->gelarbelakang_nama),true);

		return $criteria;
	}
        
        public function searchHariIni()
        {
            // Warning: Please modify the following code to remove attributes that
            // should not be searched.

            $criteria=$this->criteriaSearch();
            $criteria->compare('DATE(jadwaldokter_tgl)', date('Y-m-d'));
//            $criteria->limit=10;

            return new CActiveDataProvider($this, array(
                    'pagination' => array('pageSize' => 10),
                    'criteria'=>$criteria,
            ));
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
        
        public function getNamaLengkap(){
            return (!empty($this->gelardepan)?$this->gelardepan.' ':'').$this->nama_pegawai.(!empty($this->gelarbelakang_nama)?', '.$this->gelarbelakang_nama:'');
        }
}