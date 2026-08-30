<?php

/**
 * This is the model class for table "verifikasiberkasmcu_v".
 *
 * The followings are the available columns in table 'verifikasiberkasmcu_v':
 * @property integer $pendaftaran_id
 * @property string $tglverifikasiberkasmcu
 * @property string $noverifkasiberkasmcu
 * @property string $nosurat_rs
 * @property string $tglsurat_rs
 * @property string $statusverifikasiberkas
 * @property string $tglberkasmcumasuk
 * @property string $tglberkasdikembalikan
 * @property string $namarumahsakit
 * @property integer $verifikasiberkasmcu_id
 * @property integer $pasien_id
 * @property string $tgl_pendaftaran
 * @property string $no_pendaftaran
 * @property string $no_rekam_medik
 * @property string $tgl_rekam_medik
 * @property string $namadepan
 * @property string $nama_pasien
 * @property string $nama_bin
 * @property string $alamat_pasien
 * @property integer $rt
 * @property integer $rw
 * @property integer $penjamin_id
 * @property string $penjamin_nama
 * @property integer $carabayar_id
 * @property string $carabayar_nama
 * @property integer $pegawai_id
 * @property string $gelardepan
 * @property string $nama_pegawai
 * @property integer $gelarbelakang_id
 * @property string $gelarbelakang_nama
 * @property integer $kelaspelayanan_id
 * @property string $kelaspelayanan_nama
 * @property string $statusperiksa
 * @property integer $rujukankeluar_id
 * @property string $rumahsakitrujukan
 * @property integer $ruangan_id
 * @property string $ruangan_nama
 * @property double $tagihan
 */
class VerifikasiberkasmcuV extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return VerifikasiberkasmcuV the static model class
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
		return 'verifikasiberkasmcu_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pendaftaran_id, verifikasiberkasmcu_id, pasien_id, rt, rw, penjamin_id, carabayar_id, pegawai_id, gelarbelakang_id, kelaspelayanan_id, rujukankeluar_id, ruangan_id', 'numerical', 'integerOnly'=>true),
			array('tagihan', 'numerical'),
			array('noverifkasiberkasmcu, no_pendaftaran, namadepan', 'length', 'max'=>20),
			array('nosurat_rs, namarumahsakit, nama_pasien, penjamin_nama, carabayar_nama, nama_pegawai, kelaspelayanan_nama, statusperiksa, rumahsakitrujukan, ruangan_nama', 'length', 'max'=>50),
			array('statusverifikasiberkas, nama_bin', 'length', 'max'=>30),
			array('no_rekam_medik, gelardepan', 'length', 'max'=>10),
			array('gelarbelakang_nama', 'length', 'max'=>15),
			array('tglverifikasiberkasmcu, tglsurat_rs, tglberkasmcumasuk, tglberkasdikembalikan, tgl_pendaftaran, tgl_rekam_medik, alamat_pasien', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('pendaftaran_id, tglverifikasiberkasmcu, noverifkasiberkasmcu, nosurat_rs, tglsurat_rs, statusverifikasiberkas, tglberkasmcumasuk, tglberkasdikembalikan, namarumahsakit, verifikasiberkasmcu_id, pasien_id, tgl_pendaftaran, no_pendaftaran, no_rekam_medik, tgl_rekam_medik, namadepan, nama_pasien, nama_bin, alamat_pasien, rt, rw, penjamin_id, penjamin_nama, carabayar_id, carabayar_nama, pegawai_id, gelardepan, nama_pegawai, gelarbelakang_id, gelarbelakang_nama, kelaspelayanan_id, kelaspelayanan_nama, statusperiksa, rujukankeluar_id, rumahsakitrujukan, ruangan_id, ruangan_nama, tagihan', 'safe', 'on'=>'search'),
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
			'pendaftaran_id' => 'Pendaftaran',
			'tglverifikasiberkasmcu' => 'Tanggal Verifikasi Berkas',
			'noverifkasiberkasmcu' => 'No. Verifikasi Berkas',
			'nosurat_rs' => 'No. Surat RS',
			'tglsurat_rs' => 'Tanggal Surat RS',
			'statusverifikasiberkas' => 'Status Berkas',
			'tglberkasmcumasuk' => 'Tanggal Berkas Masuk',
			'tglberkasdikembalikan' => 'Tanggal Berkas Kembali',
			'namarumahsakit' => 'Nama Rumah Sakit',
			'verifikasiberkasmcu_id' => 'ID Verifikasi Berkas',
			'pasien_id' => 'Pasien',
			'tgl_pendaftaran' => 'Tanggal Pendaftaran',
			'no_pendaftaran' => 'No. Pendaftaran',
			'no_rekam_medik' => 'No. Rekam Medik',
			'tgl_rekam_medik' => 'Tanggal Rekam Medik',
			'namadepan' => 'Nama Depan',
			'nama_pasien' => 'Nama Pasien',
			'nama_bin' => 'Alias',
			'alamat_pasien' => 'Alamat Pasien',
			'rt' => 'RT',
			'rw' => 'RW',
			'penjamin_id' => 'Penjamin',
			'penjamin_nama' => 'Penjamin',
			'carabayar_id' => 'Jenis Penjamin',
			'carabayar_nama' => 'Jenis Penjamin',
			'pegawai_id' => 'Pegawai',
			'gelardepan' => 'Gelar Depan',
			'nama_pegawai' => 'Nama Pegawai',
			'gelarbelakang_id' => 'Gelar Belakang',
			'gelarbelakang_nama' => 'Gelar Belakang',
			'kelaspelayanan_id' => 'Kelas Pelayanan',
			'kelaspelayanan_nama' => 'Kelas Pelayanan',
			'statusperiksa' => 'Status Periksa',
			'rujukankeluar_id' => 'Rujukan Keluar',
			'rumahsakitrujukan' => 'Rumah Sakit Rujukan',
			'ruangan_id' => 'Ruangan',
			'ruangan_nama' => 'Ruangan',
			'tagihan' => 'Total Tagihan',
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

		if(!empty($this->pendaftaran_id)){
			$criteria->addCondition('pendaftaran_id = '.$this->pendaftaran_id);
		}
		$criteria->compare('LOWER(tglverifikasiberkasmcu)',strtolower($this->tglverifikasiberkasmcu),true);
		$criteria->compare('LOWER(noverifkasiberkasmcu)',strtolower($this->noverifkasiberkasmcu),true);
		$criteria->compare('LOWER(nosurat_rs)',strtolower($this->nosurat_rs),true);
		$criteria->compare('LOWER(tglsurat_rs)',strtolower($this->tglsurat_rs),true);
		$criteria->compare('LOWER(statusverifikasiberkas)',strtolower($this->statusverifikasiberkas),true);
		$criteria->compare('LOWER(tglberkasmcumasuk)',strtolower($this->tglberkasmcumasuk),true);
		$criteria->compare('LOWER(tglberkasdikembalikan)',strtolower($this->tglberkasdikembalikan),true);
		$criteria->compare('LOWER(namarumahsakit)',strtolower($this->namarumahsakit),true);
		if(!empty($this->verifikasiberkasmcu_id)){
			$criteria->addCondition('verifikasiberkasmcu_id = '.$this->verifikasiberkasmcu_id);
		}
		if(!empty($this->pasien_id)){
			$criteria->addCondition('pasien_id = '.$this->pasien_id);
		}
		$criteria->compare('LOWER(tgl_pendaftaran)',strtolower($this->tgl_pendaftaran),true);
		$criteria->compare('LOWER(no_pendaftaran)',strtolower($this->no_pendaftaran),true);
		$criteria->compare('LOWER(no_rekam_medik)',strtolower($this->no_rekam_medik),true);
		$criteria->compare('LOWER(tgl_rekam_medik)',strtolower($this->tgl_rekam_medik),true);
		$criteria->compare('LOWER(namadepan)',strtolower($this->namadepan),true);
		$criteria->compare('LOWER(nama_pasien)',strtolower($this->nama_pasien),true);
		$criteria->compare('LOWER(nama_bin)',strtolower($this->nama_bin),true);
		$criteria->compare('LOWER(alamat_pasien)',strtolower($this->alamat_pasien),true);
		if(!empty($this->rt)){
			$criteria->addCondition('rt = '.$this->rt);
		}
		if(!empty($this->rw)){
			$criteria->addCondition('rw = '.$this->rw);
		}
		if(!empty($this->penjamin_id)){
			$criteria->addCondition('penjamin_id = '.$this->penjamin_id);
		}
		$criteria->compare('LOWER(penjamin_nama)',strtolower($this->penjamin_nama),true);
		if(!empty($this->carabayar_id)){
			$criteria->addCondition('carabayar_id = '.$this->carabayar_id);
		}
		$criteria->compare('LOWER(carabayar_nama)',strtolower($this->carabayar_nama),true);
		if(!empty($this->pegawai_id)){
			$criteria->addCondition('pegawai_id = '.$this->pegawai_id);
		}
		$criteria->compare('LOWER(gelardepan)',strtolower($this->gelardepan),true);
		$criteria->compare('LOWER(nama_pegawai)',strtolower($this->nama_pegawai),true);
		if(!empty($this->gelarbelakang_id)){
			$criteria->addCondition('gelarbelakang_id = '.$this->gelarbelakang_id);
		}
		$criteria->compare('LOWER(gelarbelakang_nama)',strtolower($this->gelarbelakang_nama),true);
		if(!empty($this->kelaspelayanan_id)){
			$criteria->addCondition('kelaspelayanan_id = '.$this->kelaspelayanan_id);
		}
		$criteria->compare('LOWER(kelaspelayanan_nama)',strtolower($this->kelaspelayanan_nama),true);
		$criteria->compare('LOWER(statusperiksa)',strtolower($this->statusperiksa),true);
		if(!empty($this->rujukankeluar_id)){
			$criteria->addCondition('rujukankeluar_id = '.$this->rujukankeluar_id);
		}
		$criteria->compare('LOWER(rumahsakitrujukan)',strtolower($this->rumahsakitrujukan),true);
		if(!empty($this->ruangan_id)){
			$criteria->addCondition('ruangan_id = '.$this->ruangan_id);
		}
		$criteria->compare('LOWER(ruangan_nama)',strtolower($this->ruangan_nama),true);
		$criteria->compare('tagihan',$this->tagihan);

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