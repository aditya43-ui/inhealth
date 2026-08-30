<?php

/**
 * This is the model class for table "laporanrekappengaduan_v".
 * @author rusdiyanto <rusdiyanto@.com>
 * @subpackage models
 * The followings are the available columns in table 'laporanrekappengaduan_v':
 * @property string $tgl_pengaduan
 * @property integer $pasien_id
 * @property string $nama
 * @property string $alamat
 * @property string $uraian_keluhan
 * @property integer $layanansurvei_id
 * @property string $jenis_pelayanan
 * @property string $instalasi_tujuan
 * @property string $tindakan_awal
 * @property string $tindakan_lanjut
 */
class LaporanrekappengaduanV extends CActiveRecord
{
    public $tgl_awal,$tgl_akhir,$lookup;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return LaporanrekappengaduanV the static model class
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
		return 'laporanrekappengaduan_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pasien_id, kategoripengaduan_id, layanansurvei_id', 'numerical', 'integerOnly'=>true),
			array('nama', 'length', 'max'=>100),
			array('alamat, jenis_pelayanan', 'length', 'max'=>200),
			array('instalasi_tujuan, namakategori, warnakategoripengaduan', 'length', 'max'=>50),
			array('mediapengaduan', 'length', 'max'=>20),
			array('tindakan_awal, tindakan_lanjut', 'length', 'max'=>2000),
			array('tgl_pengaduan, uraian_keluhan, estimasipenyelesaian', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('tgl_pengaduan, pasien_id, kategoripengaduan_id, nama, alamat, uraian_keluhan, layanansurvei_id, jenis_pelayanan, instalasi_tujuan, tindakan_awal, tindakan_lanjut, mediapengaduan, namakategori, estimasipenyelesaian', 'safe', 'on'=>'search'),
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
			'tgl_pengaduan' => 'Tgl. Pengaduan',
			'pasien_id' => 'Pasien',
			'nama' => 'Nama',
			'alamat' => 'Alamat',
			'uraian_keluhan' => 'Uraian Keluhan',
			'layanansurvei_id' => 'Layanansurvei',
			'jenis_pelayanan' => 'Jenis Pelayanan',
			'instalasi_tujuan' => 'Instalasi Tujuan',
			'tindakan_awal' => 'Tindakan Awal',
			'tindakan_lanjut' => 'Tindakan Lanjut',
			'mediapengaduan' => 'Jenis Pengaduan',
			'namakategori' => 'Kategori Pengaduan', 
			'estimasipenyelesaian' => 'Tgl Estimasi Penyelesaian',
			'warnakategoripengaduan' => 'Warna'
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

		$criteria->compare('LOWER(tgl_pengaduan)',strtolower($this->tgl_pengaduan),true);
		$criteria->compare('LOWER(estimasipenyelesaian)',strtolower($this->estimasipenyelesaian),true);
		if(!empty($this->pasien_id)){
			$criteria->addCondition('pasien_id = '.$this->pasien_id);
		}
		if(!empty($this->kategoripengaduan_id)){
			$criteria->addCondition('kategoripengaduan_id = '.$this->kategoripengaduan_id);
		}
		$criteria->compare('LOWER(nama)',strtolower($this->nama),true);
		$criteria->compare('LOWER(alamat)',strtolower($this->alamat),true);
		$criteria->compare('LOWER(uraian_keluhan)',strtolower($this->uraian_keluhan),true);
		if(!empty($this->layanansurvei_id)){
			$criteria->addCondition('layanansurvei_id = '.$this->layanansurvei_id);
		}
		$criteria->compare('LOWER(jenis_pelayanan)',strtolower($this->jenis_pelayanan),true);
		$criteria->compare('LOWER(instalasi_tujuan)',strtolower($this->instalasi_tujuan),true);
		$criteria->compare('LOWER(tindakan_awal)',strtolower($this->tindakan_awal),true);
		$criteria->compare('LOWER(tindakan_lanjut)',strtolower($this->tindakan_lanjut),true);
		$criteria->compare('LOWER(mediapengaduan)',strtolower($this->mediapengaduan),true);
		$criteria->compare('LOWER(namakategori)',strtolower($this->namakategori),true);

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

        /**
         * Retrieves a list of models based on the current search/filter conditions.
         * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
         */
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
        
        /**
         * Retrieves a list of models based on the current search/filter conditions.
         * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
         */
        public function searchInformasi() 
        {
		$criteria=new CDbCriteria;
		$criteria->addBetweenCondition('DATE(tgl_pengaduan)', $this->tgl_awal, $this->tgl_akhir);
		// $criteria->compare('LOWER(tgl_pengaduan)',strtolower($this->tgl_pengaduan),true);
		// echo '<pre>'; var_dump($criteria); die;
		if(!empty($this->pasien_id)){
			$criteria->addCondition('pasien_id = '.$this->pasien_id);
		}
		if(!empty($this->kategoripengaduan_id)){
			$criteria->addCondition('kategoripengaduan_id = '.$this->kategoripengaduan_id);
		}
		$criteria->compare('LOWER(nama)',strtolower($this->nama),true);
		$criteria->compare('LOWER(alamat)',strtolower($this->alamat),true);
		$criteria->compare('LOWER(uraian_keluhan)',strtolower($this->uraian_keluhan),true);
		if(!empty($this->layanansurvei_id)){
			$criteria->addCondition('layanansurvei_id = '.$this->layanansurvei_id);
		}
		$criteria->compare('LOWER(jenis_pelayanan)',strtolower($this->jenis_pelayanan),true);
		$criteria->compare('LOWER(instalasi_tujuan)',strtolower($this->instalasi_tujuan),true);
		$criteria->compare('LOWER(tindakan_awal)',strtolower($this->tindakan_awal),true);
		$criteria->compare('LOWER(tindakan_lanjut)',strtolower($this->tindakan_lanjut),true);
		$criteria->compare('LOWER(nama_pasien)',strtolower($this->nama_pasien),true);
		$criteria->compare('LOWER(namakategori)',strtolower($this->namakategori),true);
		$criteria->compare('LOWER(mediapengaduan)',strtolower($this->mediapengaduan),true);
		$criteria->compare('LOWER(estimasipenyelesaian)',strtolower($this->estimasipenyelesaian),true);

		if(!empty($this->lookup)){
			if($this->lookup =='Sangat Puas'){
				$criteria->addCondition('kp_sangatpuas = 1');
			}else if($this->lookup =='Puas'){
				$criteria->addCondition('kp_puas = 1');
			}else if($this->lookup =='Tidak Puas'){
				$criteria->addCondition('kp_tidakpuas = 1');
			}
		}
		
			$criteria->order = 'kepuasanpasien_id desc';
			return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
		));

	}
}