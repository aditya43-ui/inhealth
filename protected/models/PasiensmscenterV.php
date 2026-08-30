<?php

/**
 * This is the model class for table "pasiensmscenter_v".
 *
 * The followings are the available columns in table 'pasiensmscenter_v':
 * @property string $tgl_rekam_medik
 * @property string $no_rekam_medik
 * @property string $namadepan
 * @property string $nama_pasien
 * @property string $nama_bin
 * @property string $jeniskelamin
 * @property string $tempat_lahir
 * @property string $tanggal_lahir
 * @property string $alamat_pasien
 * @property integer $rt
 * @property integer $rw
 * @property string $statusperkawinan
 * @property string $agama
 * @property string $golongandarah
 * @property string $rhesus
 * @property string $no_mobile_pasien
 * @property integer $kelompokumur_id
 * @property string $kelompokumur_nama
 * @property integer $profilrs_id
 * @property integer $propinsi_id
 * @property string $propinsi_nama
 * @property integer $kabupaten_id
 * @property string $kabupaten_nama
 * @property integer $kelurahan_id
 * @property string $kelurahan_nama
 * @property integer $kecamatan_id
 * @property string $kecamatan_nama
 */
class PasiensmscenterV extends CActiveRecord
{
        public $pasien_ulang_tahun,$pilih,$nomor_valid,$is_tgllahir;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PasiensmscenterV the static model class
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
		return 'pasiensmscenter_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('rt, rw, kelompokumur_id, profilrs_id, propinsi_id, kabupaten_id, kelurahan_id, kecamatan_id', 'numerical', 'integerOnly'=>true),
			array('no_rekam_medik', 'length', 'max'=>10),
			array('namadepan, jeniskelamin, statusperkawinan, agama, rhesus, no_mobile_pasien', 'length', 'max'=>20),
			array('nama_pasien, propinsi_nama, kabupaten_nama, kelurahan_nama, kecamatan_nama', 'length', 'max'=>50),
			array('nama_bin', 'length', 'max'=>30),
			array('tempat_lahir, kelompokumur_nama', 'length', 'max'=>25),
			array('golongandarah', 'length', 'max'=>2),
			array('tgl_rekam_medik, tanggal_lahir, alamat_pasien', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('tgl_rekam_medik, no_rekam_medik, namadepan, nama_pasien, nama_bin, jeniskelamin, tempat_lahir, tanggal_lahir, alamat_pasien, rt, rw, statusperkawinan, agama, golongandarah, rhesus, no_mobile_pasien, kelompokumur_id, kelompokumur_nama, profilrs_id, propinsi_id, propinsi_nama, kabupaten_id, kabupaten_nama, kelurahan_id, kelurahan_nama, kecamatan_id, kecamatan_nama', 'safe', 'on'=>'search'),
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
			'tgl_rekam_medik' => 'Tgl. Rekam Medik',
			'no_rekam_medik' => 'No. Rekam Medik',
			'namadepan' => 'Namadepan',
			'nama_pasien' => 'Nama Pasien',
			'nama_bin' => 'Nama Bin',
			'jeniskelamin' => 'Jenis Kelamin',
			'tempat_lahir' => 'Tempat Lahir',
			'tanggal_lahir' => 'Tanggal Lahir',
			'alamat_pasien' => 'Alamat Pasien',
			'rt' => 'RT',
			'rw' => 'RW',
			'statusperkawinan' => 'Statusperkawinan',
			'agama' => 'Agama',
			'golongandarah' => 'Golongandarah',
			'rhesus' => 'Rhesus',
			'no_mobile_pasien' => 'No. Handphone Pasien',
			'kelompokumur_id' => 'Kelompokumur',
			'kelompokumur_nama' => 'Kelompokumur Nama',
			'profilrs_id' => 'Profilrs',
			'propinsi_id' => 'Provinsi',
			'propinsi_nama' => 'Propinsi Nama',
			'kabupaten_id' => 'Kabupaten',
			'kabupaten_nama' => 'Kabupaten Nama',
			'kelurahan_id' => 'Kelurahan',
			'kelurahan_nama' => 'Kelurahan Nama',
			'kecamatan_id' => 'Kecamatan',
			'kecamatan_nama' => 'Kecamatan Nama',
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

//		$criteria->compare('LOWER(tgl_rekam_medik)',strtolower($this->tgl_rekam_medik),true);
		$criteria->compare('LOWER(no_rekam_medik)',strtolower($this->no_rekam_medik),true);
		$criteria->compare('LOWER(namadepan)',strtolower($this->namadepan),true);
		$criteria->compare('LOWER(nama_pasien)',strtolower($this->nama_pasien),true);
		$criteria->compare('LOWER(nama_bin)',strtolower($this->nama_bin),true);
		$criteria->compare('LOWER(jeniskelamin)',strtolower($this->jeniskelamin),true);
		$criteria->compare('LOWER(tempat_lahir)',strtolower($this->tempat_lahir),true);
//		$criteria->compare('LOWER(tanggal_lahir)',strtolower($this->tanggal_lahir),true);
//		$criteria->compare('LOWER(alamat_pasien)',strtolower($this->alamat_pasien),true);
		if(!empty($this->rt)){
			$criteria->addCondition('rt = '.$this->rt);
		}
		if(!empty($this->rw)){
			$criteria->addCondition('rw = '.$this->rw);
		}
		$criteria->compare('LOWER(statusperkawinan)',strtolower($this->statusperkawinan),true);
		$criteria->compare('LOWER(agama)',strtolower($this->agama),true);
		$criteria->compare('LOWER(golongandarah)',strtolower($this->golongandarah),true);
		$criteria->compare('LOWER(rhesus)',strtolower($this->rhesus),true);
		$criteria->compare('LOWER(no_mobile_pasien)',strtolower($this->no_mobile_pasien),true);
		if(!empty($this->kelompokumur_id)){
			$criteria->addCondition('kelompokumur_id = '.$this->kelompokumur_id);
		}
		$criteria->compare('LOWER(kelompokumur_nama)',strtolower($this->kelompokumur_nama),true);
		if(!empty($this->profilrs_id)){
			$criteria->addCondition('profilrs_id = '.$this->profilrs_id);
		}
		if(!empty($this->propinsi_id)){
			$criteria->addCondition('propinsi_id = '.$this->propinsi_id);
		}
		$criteria->compare('LOWER(propinsi_nama)',strtolower($this->propinsi_nama),true);
		if(!empty($this->kabupaten_id)){
			$criteria->addCondition('kabupaten_id = '.$this->kabupaten_id);
		}
		$criteria->compare('LOWER(kabupaten_nama)',strtolower($this->kabupaten_nama),true);
		if(!empty($this->kelurahan_id)){
			$criteria->addCondition('kelurahan_id = '.$this->kelurahan_id);
		}
		$criteria->compare('LOWER(kelurahan_nama)',strtolower($this->kelurahan_nama),true);
		if(!empty($this->kecamatan_id)){
			$criteria->addCondition('kecamatan_id = '.$this->kecamatan_id);
		}
		$criteria->compare('LOWER(kecamatan_nama)',strtolower($this->kecamatan_nama),true);

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
        
        public function searchDialog()
        {
            // Warning: Please modify the following code to remove attributes that
            // should not be searched.

            $criteria=$this->criteriaSearch();
            
            $tgl_rm = $this->tgl_rekam_medik;
            $Tgl = (explode(" - ",$tgl_rm));
            
            //harus di format date dulu karena hasil dri widget tidak sama seperti format DB
            $Tgl[0] = DateTime::createFromFormat('m/d/Y', $Tgl[0]);
            $Tgl[0] = $Tgl[0]->format('Y-m-d');
            $Tgl[1] = DateTime::createFromFormat('m/d/Y', $Tgl[1]);
            $Tgl[1] = $Tgl[1]->format('Y-m-d');
            
            $criteria->addBetweenCondition('DATE(tgl_rekam_medik)', $Tgl[0], $Tgl[1]);
            if($this->is_tgllahir==1){
               $criteria->addBetweenCondition('DATE(tanggal_lahir)', $this->tanggal_lahir, $this->tanggal_lahir); 
            }
            
            if(!empty($this->alamat_pasien)){
                $criteria->addCondition("alamat_pasien ILIKE '%".$this->alamat_pasien."%' OR propinsi_nama ILIKE '%".$this->alamat_pasien."%' OR kabupaten_nama ILIKE '%".$this->alamat_pasien."%' OR kecamatan_nama ILIKE '%".$this->alamat_pasien."%' OR kelurahan_nama ILIKE '%".$this->alamat_pasien."%'");
            }
            
            if(!empty($this->pasien_ulang_tahun) && $this->pasien_ulang_tahun==1){
                $criteria->addCondition("DATE_PART('DAY', tanggal_lahir) = DATE_PART('DAY', CURRENT_DATE) AND DATE_PART('MONTH', tanggal_lahir) = DATE_PART('MONTH', CURRENT_DATE)");
            }
            
            if($this->nomor_valid==1){
                $criteria->addCondition("length(no_mobile_pasien) >= 9 OR LEFT(no_mobile_pasien, 2) = '08' OR LEFT(no_mobile_pasien, 4) = '+628'");
            }

//            $criteria->addCondition("no_mobile_pasien IS NOT NULL");
//            $criteria->addCondition("no_mobile_pasien <> ''");
            $criteria->limit=10;

            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
//                    'pagination'=>false,
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