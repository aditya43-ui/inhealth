<?php

/**
 * This is the model class for table "rincianpiutangrekeningpasien_v".
 *
 * The followings are the available columns in table 'rincianpiutangrekeningpasien_v':
 * @property integer $profilrs_id
 * @property integer $pasien_id
 * @property string $no_rekam_medik
 * @property string $namadepan
 * @property string $nama_pasien
 * @property string $nama_bin
 * @property integer $pendaftaran_id
 * @property string $no_pendaftaran
 * @property string $tgl_pendaftaran
 * @property integer $tindakanpelayanan_id
 * @property integer $penjamin_id
 * @property string $penjamin_nama
 * @property integer $carabayar_id
 * @property string $carabayar_nama
 * @property integer $instalasi_id
 * @property string $instalasi_nama
 * @property integer $ruangan_id
 * @property string $ruangan_nama
 * @property integer $daftartindakan_id
 * @property string $daftartindakan_kode
 * @property string $daftartindakan_nama
 * @property integer $pembayaranpelayanan_id
 * @property integer $ruanganpendaftaran_id
 * @property integer $tindakansudahbayar_id
 * @property integer $rincianobyek_id
 * @property string $kdstruktur
 * @property string $kdkelompok
 * @property string $kdjenis
 * @property string $kdobyek
 * @property string $kdrincianobyek
 * @property string $nmrincianobyek
 * @property string $nmrincianobyeklain
 * @property string $rincianobyek_nb
 * @property string $keterangan
 * @property integer $nourutrek
 * @property double $saldotarif
 * @property integer $struktur_id
 * @property integer $kelompok_id
 * @property integer $jenis_id
 * @property integer $obyek_id
 * @property string $jnspelayanan
 * @property string $tm
 */
class RincianpiutangrekeningpasienV extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return RincianpiutangrekeningpasienV the static model class
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
		return 'rincianpiutangrekeningpasien_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('profilrs_id, pasien_id, pendaftaran_id, tindakanpelayanan_id, penjamin_id, carabayar_id, instalasi_id, ruangan_id, daftartindakan_id, pembayaranpelayanan_id, ruanganpendaftaran_id, tindakansudahbayar_id, rincianobyek_id, nourutrek, struktur_id, kelompok_id, jenis_id, obyek_id', 'numerical', 'integerOnly'=>true),
			array('saldotarif', 'numerical'),
			array('no_rekam_medik', 'length', 'max'=>10),
			array('namadepan, no_pendaftaran, jnspelayanan', 'length', 'max'=>20),
			array('nama_pasien, penjamin_nama, carabayar_nama, instalasi_nama, ruangan_nama', 'length', 'max'=>50),
			array('nama_bin', 'length', 'max'=>30),
			array('kdstruktur, kdkelompok, kdjenis, kdobyek, kdrincianobyek', 'length', 'max'=>5),
			array('nmrincianobyek, nmrincianobyeklain', 'length', 'max'=>500),
			array('rincianobyek_nb', 'length', 'max'=>1),
			array('tm', 'length', 'max'=>2),
			array('tgl_pendaftaran, daftartindakan_kode, daftartindakan_nama, keterangan', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('profilrs_id, pasien_id, no_rekam_medik, namadepan, nama_pasien, nama_bin, pendaftaran_id, no_pendaftaran, tgl_pendaftaran, tindakanpelayanan_id, penjamin_id, penjamin_nama, carabayar_id, carabayar_nama, instalasi_id, instalasi_nama, ruangan_id, ruangan_nama, daftartindakan_id, daftartindakan_kode, daftartindakan_nama, pembayaranpelayanan_id, ruanganpendaftaran_id, tindakansudahbayar_id, rincianobyek_id, kdstruktur, kdkelompok, kdjenis, kdobyek, kdrincianobyek, nmrincianobyek, nmrincianobyeklain, rincianobyek_nb, keterangan, nourutrek, saldotarif, struktur_id, kelompok_id, jenis_id, obyek_id, jnspelayanan, tm', 'safe', 'on'=>'search'),
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
			'profilrs_id' => 'Profilrs',
			'pasien_id' => 'Pasien',
			'no_rekam_medik' => 'No. Rekam Medik',
			'namadepan' => 'Namadepan',
			'nama_pasien' => 'Nama Pasien',
			'nama_bin' => 'Nama Bin',
			'pendaftaran_id' => 'Pendaftaran',
			'no_pendaftaran' => 'No. Pendaftaran',
			'tgl_pendaftaran' => 'Tgl. Pendaftaran',
			'tindakanpelayanan_id' => 'Tindakanpelayanan',
			'penjamin_id' => 'Penjamin',
			'penjamin_nama' => 'Penjamin Nama',
			'carabayar_id' => 'Jenis Penjamin',
			'carabayar_nama' => 'Carabayar Nama',
			'instalasi_id' => 'Instalasi',
			'instalasi_nama' => 'Instalasi Nama',
			'ruangan_id' => 'Ruangan',
			'ruangan_nama' => 'Ruangan Nama',
			'daftartindakan_id' => 'Daftartindakan',
			'daftartindakan_kode' => 'Daftartindakan Kode',
			'daftartindakan_nama' => 'Nama Daftar Tindakan',
			'pembayaranpelayanan_id' => 'Pembayaranpelayanan',
			'ruanganpendaftaran_id' => 'Ruanganpendaftaran',
			'tindakansudahbayar_id' => 'Tindakansudahbayar',
			'rincianobyek_id' => 'Rincianobyek',
			'kdstruktur' => 'Kdstruktur',
			'kdkelompok' => 'Kdkelompok',
			'kdjenis' => 'Kdjenis',
			'kdobyek' => 'Kdobyek',
			'kdrincianobyek' => 'Kdrincianobyek',
			'nmrincianobyek' => 'Nmrincianobyek',
			'nmrincianobyeklain' => 'Nmrincianobyeklain',
			'rincianobyek_nb' => 'Rincianobyek Nb',
			'keterangan' => 'Keterangan',
			'nourutrek' => 'Nourutrek',
			'saldotarif' => 'Saldotarif',
			'struktur_id' => 'Struktur',
			'kelompok_id' => 'Kelompok',
			'jenis_id' => 'Jenis',
			'obyek_id' => 'Obyek',
			'jnspelayanan' => 'Jnspelayanan',
			'tm' => 'Tm',
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

		if(!empty($this->profilrs_id)){
			$criteria->addCondition('profilrs_id = '.$this->profilrs_id);
		}
		if(!empty($this->pasien_id)){
			$criteria->addCondition('pasien_id = '.$this->pasien_id);
		}
		$criteria->compare('LOWER(no_rekam_medik)',strtolower($this->no_rekam_medik),true);
		$criteria->compare('LOWER(namadepan)',strtolower($this->namadepan),true);
		$criteria->compare('LOWER(nama_pasien)',strtolower($this->nama_pasien),true);
		$criteria->compare('LOWER(nama_bin)',strtolower($this->nama_bin),true);
		if(!empty($this->pendaftaran_id)){
			$criteria->addCondition('pendaftaran_id = '.$this->pendaftaran_id);
		}
		$criteria->compare('LOWER(no_pendaftaran)',strtolower($this->no_pendaftaran),true);
		$criteria->compare('LOWER(tgl_pendaftaran)',strtolower($this->tgl_pendaftaran),true);
		if(!empty($this->tindakanpelayanan_id)){
			$criteria->addCondition('tindakanpelayanan_id = '.$this->tindakanpelayanan_id);
		}
		if(!empty($this->penjamin_id)){
			$criteria->addCondition('penjamin_id = '.$this->penjamin_id);
		}
		$criteria->compare('LOWER(penjamin_nama)',strtolower($this->penjamin_nama),true);
		if(!empty($this->carabayar_id)){
			$criteria->addCondition('carabayar_id = '.$this->carabayar_id);
		}
		$criteria->compare('LOWER(carabayar_nama)',strtolower($this->carabayar_nama),true);
		if(!empty($this->instalasi_id)){
			$criteria->addCondition('instalasi_id = '.$this->instalasi_id);
		}
		$criteria->compare('LOWER(instalasi_nama)',strtolower($this->instalasi_nama),true);
		if(!empty($this->ruangan_id)){
			$criteria->addCondition('ruangan_id = '.$this->ruangan_id);
		}
		$criteria->compare('LOWER(ruangan_nama)',strtolower($this->ruangan_nama),true);
		if(!empty($this->daftartindakan_id)){
			$criteria->addCondition('daftartindakan_id = '.$this->daftartindakan_id);
		}
		$criteria->compare('LOWER(daftartindakan_kode)',strtolower($this->daftartindakan_kode),true);
		$criteria->compare('LOWER(daftartindakan_nama)',strtolower($this->daftartindakan_nama),true);
		if(!empty($this->pembayaranpelayanan_id)){
			$criteria->addCondition('pembayaranpelayanan_id = '.$this->pembayaranpelayanan_id);
		}
		if(!empty($this->ruanganpendaftaran_id)){
			$criteria->addCondition('ruanganpendaftaran_id = '.$this->ruanganpendaftaran_id);
		}
		if(!empty($this->tindakansudahbayar_id)){
			$criteria->addCondition('tindakansudahbayar_id = '.$this->tindakansudahbayar_id);
		}
		if(!empty($this->rincianobyek_id)){
			$criteria->addCondition('rincianobyek_id = '.$this->rincianobyek_id);
		}
		$criteria->compare('LOWER(kdstruktur)',strtolower($this->kdstruktur),true);
		$criteria->compare('LOWER(kdkelompok)',strtolower($this->kdkelompok),true);
		$criteria->compare('LOWER(kdjenis)',strtolower($this->kdjenis),true);
		$criteria->compare('LOWER(kdobyek)',strtolower($this->kdobyek),true);
		$criteria->compare('LOWER(kdrincianobyek)',strtolower($this->kdrincianobyek),true);
		$criteria->compare('LOWER(nmrincianobyek)',strtolower($this->nmrincianobyek),true);
		$criteria->compare('LOWER(nmrincianobyeklain)',strtolower($this->nmrincianobyeklain),true);
		$criteria->compare('LOWER(rincianobyek_nb)',strtolower($this->rincianobyek_nb),true);
		$criteria->compare('LOWER(keterangan)',strtolower($this->keterangan),true);
		if(!empty($this->nourutrek)){
			$criteria->addCondition('nourutrek = '.$this->nourutrek);
		}
		$criteria->compare('saldotarif',$this->saldotarif);
		if(!empty($this->struktur_id)){
			$criteria->addCondition('struktur_id = '.$this->struktur_id);
		}
		if(!empty($this->kelompok_id)){
			$criteria->addCondition('kelompok_id = '.$this->kelompok_id);
		}
		if(!empty($this->jenis_id)){
			$criteria->addCondition('jenis_id = '.$this->jenis_id);
		}
		if(!empty($this->obyek_id)){
			$criteria->addCondition('obyek_id = '.$this->obyek_id);
		}
		$criteria->compare('LOWER(jnspelayanan)',strtolower($this->jnspelayanan),true);
		$criteria->compare('LOWER(tm)',strtolower($this->tm),true);

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