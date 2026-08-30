<?php

/**
 * This is the model class for table "informasiasuransipasien_v".
 *
 * The followings are the available columns in table 'informasiasuransipasien_v':
 * @property integer $pasien_id
 * @property string $no_rekam_medik
 * @property string $tgl_rekam_medik
 * @property string $jenisidentitas
 * @property string $no_identitas_pasien
 * @property string $namadepan
 * @property string $nama_pasien
 * @property string $nama_bin
 * @property string $jeniskelamin
 * @property string $tempat_lahir
 * @property string $tanggal_lahir
 * @property string $alamat_pasien
 * @property integer $rt
 * @property integer $rw
 * @property integer $kelurahan_id
 * @property string $kelurahan_nama
 * @property integer $kecamatan_id
 * @property string $kecamatan_nama
 * @property integer $kabupaten_id
 * @property string $kabupaten_nama
 * @property integer $propinsi_id
 * @property string $propinsi_nama
 * @property string $statusperkawinan
 * @property string $agama
 * @property string $no_telepon_pasien
 * @property string $no_mobile_pasien
 * @property string $nama_ibu
 * @property string $nama_ayah
 * @property integer $pegawaipenanggung_id
 * @property string $pegawaipenanggung_nip
 * @property string $pegawaipenanggung_jenisidentitas
 * @property string $pegawaipenanggung_noidentitas
 * @property string $pegawaipenanggung_gelardepan
 * @property string $pegawaipenanggung_nama
 * @property string $pegawaipenanggung_gelarbelakang
 * @property integer $asuransipasien_id
 * @property integer $jenispeserta_id
 * @property string $jenispeserta_nama
 * @property string $jenispeserta_keterangan
 * @property integer $carabayar_id
 * @property string $carabayar_nama
 * @property integer $penjamin_id
 * @property string $penjamin_nama
 * @property integer $kelastanggunganasuransi_id
 * @property string $kelastanggunganasuransi_nama
 * @property string $nokartuasuransi
 * @property string $nopeserta
 * @property string $namapemilikasuransi
 * @property string $hubkeluarga
 * @property string $tglcetakkartuasuransi
 * @property string $tgl_konfirmasi
 * @property string $status_konfirmasi
 * @property string $kodefeskestk1
 * @property string $nama_feskestk1
 * @property string $kodefeskesgigi
 * @property string $namafeskesgigi
 * @property string $namaperusahaan
 * @property string $nomorpokokperusahaan
 * @property string $masaberlakukartu
 * @property string $nokartukeluarga
 * @property string $nopassport
 * @property boolean $asuransipasien_aktif
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 */
class InformasiasuransipasienV extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return InformasiasuransipasienV the static model class
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
		return 'informasiasuransipasien_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pasien_id, rt, rw, kelurahan_id, kecamatan_id, kabupaten_id, propinsi_id, pegawaipenanggung_id, asuransipasien_id, jenispeserta_id, carabayar_id, penjamin_id, kelastanggunganasuransi_id, create_loginpemakai_id, update_loginpemakai_id', 'numerical', 'integerOnly'=>true),
			array('no_rekam_medik, pegawaipenanggung_gelardepan', 'length', 'max'=>10),
			array('jenisidentitas, namadepan, jeniskelamin, statusperkawinan, agama, no_mobile_pasien, pegawaipenanggung_jenisidentitas', 'length', 'max'=>20),
			array('no_identitas_pasien, nama_bin, pegawaipenanggung_nip', 'length', 'max'=>30),
			array('nama_pasien, kelurahan_nama, kecamatan_nama, kabupaten_nama, propinsi_nama, nama_ibu, nama_ayah, pegawaipenanggung_nama, carabayar_nama, penjamin_nama, kelastanggunganasuransi_nama, nokartuasuransi, nopeserta, namapemilikasuransi, status_konfirmasi, kodefeskestk1, kodefeskesgigi, namaperusahaan, nomorpokokperusahaan', 'length', 'max'=>50),
			array('tempat_lahir', 'length', 'max'=>25),
			array('no_telepon_pasien, pegawaipenanggung_gelarbelakang', 'length', 'max'=>15),
			array('pegawaipenanggung_noidentitas, hubkeluarga, nokartukeluarga', 'length', 'max'=>100),
			array('jenispeserta_nama, nama_feskestk1, namafeskesgigi, nopassport', 'length', 'max'=>200),
			array('tgl_rekam_medik, tanggal_lahir, alamat_pasien, jenispeserta_keterangan, tglcetakkartuasuransi, tgl_konfirmasi, masaberlakukartu, asuransipasien_aktif, create_time, update_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('pasien_id, no_rekam_medik, tgl_rekam_medik, jenisidentitas, no_identitas_pasien, namadepan, nama_pasien, nama_bin, jeniskelamin, tempat_lahir, tanggal_lahir, alamat_pasien, rt, rw, kelurahan_id, kelurahan_nama, kecamatan_id, kecamatan_nama, kabupaten_id, kabupaten_nama, propinsi_id, propinsi_nama, statusperkawinan, agama, no_telepon_pasien, no_mobile_pasien, nama_ibu, nama_ayah, pegawaipenanggung_id, pegawaipenanggung_nip, pegawaipenanggung_jenisidentitas, pegawaipenanggung_noidentitas, pegawaipenanggung_gelardepan, pegawaipenanggung_nama, pegawaipenanggung_gelarbelakang, asuransipasien_id, jenispeserta_id, jenispeserta_nama, jenispeserta_keterangan, carabayar_id, carabayar_nama, penjamin_id, penjamin_nama, kelastanggunganasuransi_id, kelastanggunganasuransi_nama, nokartuasuransi, nopeserta, namapemilikasuransi, hubkeluarga, tglcetakkartuasuransi, tgl_konfirmasi, status_konfirmasi, kodefeskestk1, nama_feskestk1, kodefeskesgigi, namafeskesgigi, namaperusahaan, nomorpokokperusahaan, masaberlakukartu, nokartukeluarga, nopassport, asuransipasien_aktif, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id', 'safe', 'on'=>'search'),
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
			'pasien_id' => 'Pasien',
			'no_rekam_medik' => 'No. Rekam Medik',
			'tgl_rekam_medik' => 'Tgl. Rekam Medik',
			'jenisidentitas' => 'Jenisidentitas',
			'no_identitas_pasien' => 'No Identitas Pasien',
			'namadepan' => 'Namadepan',
			'nama_pasien' => 'Nama Pasien',
			'nama_bin' => 'Nama Bin',
			'jeniskelamin' => 'Jenis Kelamin',
			'tempat_lahir' => 'Tempat Lahir',
			'tanggal_lahir' => 'Tanggal Lahir',
			'alamat_pasien' => 'Alamat Pasien',
			'rt' => 'RT',
			'rw' => 'RW',
			'kelurahan_id' => 'Kelurahan',
			'kelurahan_nama' => 'Kelurahan Nama',
			'kecamatan_id' => 'Kecamatan',
			'kecamatan_nama' => 'Kecamatan Nama',
			'kabupaten_id' => 'Kabupaten',
			'kabupaten_nama' => 'Kabupaten Nama',
			'propinsi_id' => 'Provinsi',
			'propinsi_nama' => 'Propinsi Nama',
			'statusperkawinan' => 'Statusperkawinan',
			'agama' => 'Agama',
			'no_telepon_pasien' => 'No. Telepon Pasien',
			'no_mobile_pasien' => 'No. Handphone Pasien',
			'nama_ibu' => 'Nama Ibu',
			'nama_ayah' => 'Nama Ayah',
			'pegawaipenanggung_id' => 'Pegawaipenanggung',
			'pegawaipenanggung_nip' => 'Pegawaipenanggung Nip',
			'pegawaipenanggung_jenisidentitas' => 'Pegawaipenanggung Jenisidentitas',
			'pegawaipenanggung_noidentitas' => 'Pegawaipenanggung Noidentitas',
			'pegawaipenanggung_gelardepan' => 'Pegawaipenanggung Gelardepan',
			'pegawaipenanggung_nama' => 'Pegawaipenanggung Nama',
			'pegawaipenanggung_gelarbelakang' => 'Pegawaipenanggung Gelarbelakang',
			'asuransipasien_id' => 'Asuransipasien',
			'jenispeserta_id' => 'Jenispeserta',
			'jenispeserta_nama' => 'Jenispeserta Nama',
			'jenispeserta_keterangan' => 'Jenispeserta Keterangan',
			'carabayar_id' => 'Jenis Penjamin',
			'carabayar_nama' => 'Carabayar Nama',
			'penjamin_id' => 'Penjamin',
			'penjamin_nama' => 'Penjamin Nama',
			'kelastanggunganasuransi_id' => 'Kelastanggunganasuransi',
			'kelastanggunganasuransi_nama' => 'Kelastanggunganasuransi Nama',
			'nokartuasuransi' => 'Nokartuasuransi',
			'nopeserta' => 'Nopeserta',
			'namapemilikasuransi' => 'Namapemilikasuransi',
			'hubkeluarga' => 'Hubkeluarga',
			'tglcetakkartuasuransi' => 'Tglcetakkartuasuransi',
			'tgl_konfirmasi' => 'Tgl. Konfirmasi',
			'status_konfirmasi' => 'Status Konfirmasi',
			'kodefeskestk1' => 'Kodefeskestk1',
			'nama_feskestk1' => 'Nama Feskestk1',
			'kodefeskesgigi' => 'Kodefeskesgigi',
			'namafeskesgigi' => 'Namafeskesgigi',
			'namaperusahaan' => 'Namaperusahaan',
			'nomorpokokperusahaan' => 'Nomorpokokperusahaan',
			'masaberlakukartu' => 'Masaberlakukartu',
			'nokartukeluarga' => 'Nokartukeluarga',
			'nopassport' => 'Nopassport',
			'asuransipasien_aktif' => 'Asuransipasien Aktif',
			'create_time' => 'Waktu Create',
			'update_time' => 'Waktu Update',
			'create_loginpemakai_id' => 'Create Login Pemakai',
			'update_loginpemakai_id' => 'Update Login Pemakai',
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

		if(!empty($this->pasien_id)){
			$criteria->addCondition('pasien_id = '.$this->pasien_id);
		}
		$criteria->compare('LOWER(no_rekam_medik)',strtolower($this->no_rekam_medik),true);
		$criteria->compare('LOWER(tgl_rekam_medik)',strtolower($this->tgl_rekam_medik),true);
		$criteria->compare('LOWER(jenisidentitas)',strtolower($this->jenisidentitas),true);
		$criteria->compare('LOWER(no_identitas_pasien)',strtolower($this->no_identitas_pasien),true);
		$criteria->compare('LOWER(namadepan)',strtolower($this->namadepan),true);
		$criteria->compare('LOWER(nama_pasien)',strtolower($this->nama_pasien),true);
		$criteria->compare('LOWER(nama_bin)',strtolower($this->nama_bin),true);
		$criteria->compare('LOWER(jeniskelamin)',strtolower($this->jeniskelamin),true);
		$criteria->compare('LOWER(tempat_lahir)',strtolower($this->tempat_lahir),true);
		$criteria->compare('LOWER(tanggal_lahir)',strtolower($this->tanggal_lahir),true);
		$criteria->compare('LOWER(alamat_pasien)',strtolower($this->alamat_pasien),true);
		if(!empty($this->rt)){
			$criteria->addCondition('rt = '.$this->rt);
		}
		if(!empty($this->rw)){
			$criteria->addCondition('rw = '.$this->rw);
		}
		if(!empty($this->kelurahan_id)){
			$criteria->addCondition('kelurahan_id = '.$this->kelurahan_id);
		}
		$criteria->compare('LOWER(kelurahan_nama)',strtolower($this->kelurahan_nama),true);
		if(!empty($this->kecamatan_id)){
			$criteria->addCondition('kecamatan_id = '.$this->kecamatan_id);
		}
		$criteria->compare('LOWER(kecamatan_nama)',strtolower($this->kecamatan_nama),true);
		if(!empty($this->kabupaten_id)){
			$criteria->addCondition('kabupaten_id = '.$this->kabupaten_id);
		}
		$criteria->compare('LOWER(kabupaten_nama)',strtolower($this->kabupaten_nama),true);
		if(!empty($this->propinsi_id)){
			$criteria->addCondition('propinsi_id = '.$this->propinsi_id);
		}
		$criteria->compare('LOWER(propinsi_nama)',strtolower($this->propinsi_nama),true);
		$criteria->compare('LOWER(statusperkawinan)',strtolower($this->statusperkawinan),true);
		$criteria->compare('LOWER(agama)',strtolower($this->agama),true);
		$criteria->compare('LOWER(no_telepon_pasien)',strtolower($this->no_telepon_pasien),true);
		$criteria->compare('LOWER(no_mobile_pasien)',strtolower($this->no_mobile_pasien),true);
		$criteria->compare('LOWER(nama_ibu)',strtolower($this->nama_ibu),true);
		$criteria->compare('LOWER(nama_ayah)',strtolower($this->nama_ayah),true);
		if(!empty($this->pegawaipenanggung_id)){
			$criteria->addCondition('pegawaipenanggung_id = '.$this->pegawaipenanggung_id);
		}
		$criteria->compare('LOWER(pegawaipenanggung_nip)',strtolower($this->pegawaipenanggung_nip),true);
		$criteria->compare('LOWER(pegawaipenanggung_jenisidentitas)',strtolower($this->pegawaipenanggung_jenisidentitas),true);
		$criteria->compare('LOWER(pegawaipenanggung_noidentitas)',strtolower($this->pegawaipenanggung_noidentitas),true);
		$criteria->compare('LOWER(pegawaipenanggung_gelardepan)',strtolower($this->pegawaipenanggung_gelardepan),true);
		$criteria->compare('LOWER(pegawaipenanggung_nama)',strtolower($this->pegawaipenanggung_nama),true);
		$criteria->compare('LOWER(pegawaipenanggung_gelarbelakang)',strtolower($this->pegawaipenanggung_gelarbelakang),true);
		if(!empty($this->asuransipasien_id)){
			$criteria->addCondition('asuransipasien_id = '.$this->asuransipasien_id);
		}
		if(!empty($this->jenispeserta_id)){
			$criteria->addCondition('jenispeserta_id = '.$this->jenispeserta_id);
		}
		$criteria->compare('LOWER(jenispeserta_nama)',strtolower($this->jenispeserta_nama),true);
		$criteria->compare('LOWER(jenispeserta_keterangan)',strtolower($this->jenispeserta_keterangan),true);
		if(!empty($this->carabayar_id)){
			$criteria->addCondition('carabayar_id = '.$this->carabayar_id);
		}
		$criteria->compare('LOWER(carabayar_nama)',strtolower($this->carabayar_nama),true);
		if(!empty($this->penjamin_id)){
			$criteria->addCondition('penjamin_id = '.$this->penjamin_id);
		}
		$criteria->compare('LOWER(penjamin_nama)',strtolower($this->penjamin_nama),true);
		if(!empty($this->kelastanggunganasuransi_id)){
			$criteria->addCondition('kelastanggunganasuransi_id = '.$this->kelastanggunganasuransi_id);
		}
		$criteria->compare('LOWER(kelastanggunganasuransi_nama)',strtolower($this->kelastanggunganasuransi_nama),true);
		$criteria->compare('LOWER(nokartuasuransi)',strtolower($this->nokartuasuransi),true);
		$criteria->compare('LOWER(nopeserta)',strtolower($this->nopeserta),true);
		$criteria->compare('LOWER(namapemilikasuransi)',strtolower($this->namapemilikasuransi),true);
		$criteria->compare('LOWER(hubkeluarga)',strtolower($this->hubkeluarga),true);
		$criteria->compare('LOWER(tglcetakkartuasuransi)',strtolower($this->tglcetakkartuasuransi),true);
		$criteria->compare('LOWER(tgl_konfirmasi)',strtolower($this->tgl_konfirmasi),true);
		$criteria->compare('LOWER(status_konfirmasi)',strtolower($this->status_konfirmasi),true);
		$criteria->compare('LOWER(kodefeskestk1)',strtolower($this->kodefeskestk1),true);
		$criteria->compare('LOWER(nama_feskestk1)',strtolower($this->nama_feskestk1),true);
		$criteria->compare('LOWER(kodefeskesgigi)',strtolower($this->kodefeskesgigi),true);
		$criteria->compare('LOWER(namafeskesgigi)',strtolower($this->namafeskesgigi),true);
		$criteria->compare('LOWER(namaperusahaan)',strtolower($this->namaperusahaan),true);
		$criteria->compare('LOWER(nomorpokokperusahaan)',strtolower($this->nomorpokokperusahaan),true);
		$criteria->compare('LOWER(masaberlakukartu)',strtolower($this->masaberlakukartu),true);
		$criteria->compare('LOWER(nokartukeluarga)',strtolower($this->nokartukeluarga),true);
		$criteria->compare('LOWER(nopassport)',strtolower($this->nopassport),true);
		$criteria->compare('asuransipasien_aktif',$this->asuransipasien_aktif);
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
		if(!empty($this->create_loginpemakai_id)){
			$criteria->addCondition('create_loginpemakai_id = '.$this->create_loginpemakai_id);
		}
		if(!empty($this->update_loginpemakai_id)){
			$criteria->addCondition('update_loginpemakai_id = '.$this->update_loginpemakai_id);
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