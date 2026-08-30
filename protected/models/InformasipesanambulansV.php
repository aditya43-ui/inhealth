<?php

/**
 * This is the model class for table "informasipesanambulans_v".
 *
 * The followings are the available columns in table 'informasipesanambulans_v':
 * @property integer $instalasi_id
 * @property string $instalasi_nama
 * @property integer $ruangan_id
 * @property string $ruangan_nama
 * @property integer $pesanambulans_t
 * @property string $pesanambulans_tgl
 * @property string $pesanambulans_no
 * @property integer $pasien_id
 * @property string $pasien_norekammedis
 * @property string $pasien_jenisidentitas
 * @property string $no_identitas_pasien
 * @property string $namadepan
 * @property string $pasien_nama
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
 * @property string $no_telepon_pasien
 * @property string $no_mobile_pasien
 * @property string $warga_negara
 * @property string $photopasien
 * @property string $nama_ibu
 * @property integer $pendaftaran_id
 * @property string $no_pendaftaran
 * @property string $tgl_pendaftaran
 * @property string $tempattujuan
 * @property string $kelurahan_nama
 * @property string $alamattujuan
 * @property string $rt_rw
 * @property string $nomobile
 * @property string $notelepon
 * @property string $tglpemakaianambulans
 * @property string $untukkeperluan
 * @property string $keteranganpesan
 * @property string $longitude
 * @property string $latitude
 * @property integer $pemakaianambulans_id
 * @property integer $mobilambulans_id
 * @property string $mobilambulans_kode
 * @property string $nopolisi
 * @property string $jeniskendaraan
 * @property integer $isibbmliter
 * @property string $kmterakhirkend
 * @property string $photokendaraan
 * @property double $hargabbmliter
 * @property string $formulajasars
 * @property string $formulajasaba
 * @property string $formulajasapel
 * @property string $pemesan_norekammedis
 * @property string $pemesan_nama
 */
class InformasipesanambulansV extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return InformasipesanambulansV the static model class
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
		return 'informasipesanambulans_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('instalasi_id, ruangan_id, pesanambulans_t, pasien_id, rt, rw, pendaftaran_id, pemakaianambulans_id, mobilambulans_id, isibbmliter', 'numerical', 'integerOnly'=>true),
			array('hargabbmliter', 'numerical'),
			array('instalasi_nama, ruangan_nama, pasien_nama, nama_ibu, tempattujuan, kelurahan_nama, formulajasars, formulajasaba, formulajasapel', 'length', 'max'=>50),
			array('pesanambulans_no, pasien_jenisidentitas, namadepan, jeniskelamin, statusperkawinan, agama, no_mobile_pasien, no_pendaftaran, rt_rw, mobilambulans_kode, nopolisi', 'length', 'max'=>20),
			array('pasien_norekammedis, pemesan_norekammedis', 'length', 'max'=>10),
			array('no_identitas_pasien, nama_bin', 'length', 'max'=>30),
			array('tempat_lahir, warga_negara', 'length', 'max'=>25),
			array('golongandarah', 'length', 'max'=>2),
			array('no_telepon_pasien', 'length', 'max'=>15),
			array('photopasien', 'length', 'max'=>200),
			array('nomobile, notelepon, jeniskendaraan, pemesan_nama', 'length', 'max'=>100),
			array('pesanambulans_tgl, tanggal_lahir, alamat_pasien, tgl_pendaftaran, alamattujuan, tglpemakaianambulans, untukkeperluan, keteranganpesan, longitude, latitude, kmterakhirkend, photokendaraan', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('instalasi_id, instalasi_nama, ruangan_id, ruangan_nama, pesanambulans_t, pesanambulans_tgl, pesanambulans_no, pasien_id, pasien_norekammedis, pasien_jenisidentitas, no_identitas_pasien, namadepan, pasien_nama, nama_bin, jeniskelamin, tempat_lahir, tanggal_lahir, alamat_pasien, rt, rw, statusperkawinan, agama, golongandarah, no_telepon_pasien, no_mobile_pasien, warga_negara, photopasien, nama_ibu, pendaftaran_id, no_pendaftaran, tgl_pendaftaran, tempattujuan, kelurahan_nama, alamattujuan, rt_rw, nomobile, notelepon, tglpemakaianambulans, untukkeperluan, keteranganpesan, longitude, latitude, pemakaianambulans_id, mobilambulans_id, mobilambulans_kode, nopolisi, jeniskendaraan, isibbmliter, kmterakhirkend, photokendaraan, hargabbmliter, formulajasars, formulajasaba, formulajasapel, pemesan_norekammedis, pemesan_nama', 'safe', 'on'=>'search'),
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
			'instalasi_id' => 'Instalasi',
			'instalasi_nama' => 'Instalasi Nama',
			'ruangan_id' => 'Ruangan',
			'ruangan_nama' => 'Ruangan',
			'pesanambulans_t' => 'Pesanambulans T',
			'pesanambulans_tgl' => 'Pesanambulans Tgl',
			'pesanambulans_no' => 'No. Pesan Ambulans',
			'pasien_id' => 'Pasien',
			'pasien_norekammedis' => 'No. Rekam Medik',
			'pasien_jenisidentitas' => 'Pasien Jenisidentitas',
			'no_identitas_pasien' => 'No. Identitas Pasien',
			'namadepan' => 'Namadepan',
			'pasien_nama' => 'Nama Pasien',
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
			'no_telepon_pasien' => 'No. Telepon Pasien',
			'no_mobile_pasien' => 'No. Handphone Pasien',
			'warga_negara' => 'Warga Negara',
			'photopasien' => 'Photopasien',
			'nama_ibu' => 'Nama Ibu',
			'pendaftaran_id' => 'Pendaftaran',
			'no_pendaftaran' => 'No. Pendaftaran',
			'tgl_pendaftaran' => 'Tgl. Pendaftaran',
			'tempattujuan' => 'Tempat Tujuan',
			'kelurahan_nama' => 'Kelurahan Nama',
			'alamattujuan' => 'Alamat Tujuan',
			'rt_rw' => 'Rt Rw',
			'nomobile' => 'Nomobile',
			'notelepon' => 'Notelepon',
			'tglpemakaianambulans' => 'Tanggal Pemakaian Ambulans',
			'untukkeperluan' => 'Untuk Keperluan',
			'keteranganpesan' => 'Keteranganpesan',
			'longitude' => 'Longitude',
			'latitude' => 'Latitude',
			'pemakaianambulans_id' => 'Pemakaianambulans',
			'mobilambulans_id' => 'Mobilambulans',
			'mobilambulans_kode' => 'Mobilambulans Kode',
			'nopolisi' => 'Nopolisi',
			'jeniskendaraan' => 'Jeniskendaraan',
			'isibbmliter' => 'Isibbmliter',
			'kmterakhirkend' => 'Kmterakhirkend',
			'photokendaraan' => 'Photokendaraan',
			'hargabbmliter' => 'Hargabbmliter',
			'formulajasars' => 'Formulajasars',
			'formulajasaba' => 'Formulajasaba',
			'formulajasapel' => 'Formulajasapel',
			'pemesan_norekammedis' => 'Pemesan Norekammedis',
			'pemesan_nama' => 'Nama Pemesan',
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

		$criteria->compare('instalasi_id',$this->instalasi_id);
		$criteria->compare('LOWER(instalasi_nama)',strtolower($this->instalasi_nama),true);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('LOWER(ruangan_nama)',strtolower($this->ruangan_nama),true);
		$criteria->compare('pesanambulans_t',$this->pesanambulans_t);
		$criteria->compare('LOWER(pesanambulans_tgl)',strtolower($this->pesanambulans_tgl),true);
		$criteria->compare('LOWER(pesanambulans_no)',strtolower($this->pesanambulans_no),true);
		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('LOWER(pasien_norekammedis)',strtolower($this->pasien_norekammedis),true);
		$criteria->compare('LOWER(pasien_jenisidentitas)',strtolower($this->pasien_jenisidentitas),true);
		$criteria->compare('LOWER(no_identitas_pasien)',strtolower($this->no_identitas_pasien),true);
		$criteria->compare('LOWER(namadepan)',strtolower($this->namadepan),true);
		$criteria->compare('LOWER(pasien_nama)',strtolower($this->pasien_nama),true);
		$criteria->compare('LOWER(nama_bin)',strtolower($this->nama_bin),true);
		$criteria->compare('LOWER(jeniskelamin)',strtolower($this->jeniskelamin),true);
		$criteria->compare('LOWER(tempat_lahir)',strtolower($this->tempat_lahir),true);
		$criteria->compare('LOWER(tanggal_lahir)',strtolower($this->tanggal_lahir),true);
		$criteria->compare('LOWER(alamat_pasien)',strtolower($this->alamat_pasien),true);
		$criteria->compare('rt',$this->rt);
		$criteria->compare('rw',$this->rw);
		$criteria->compare('LOWER(statusperkawinan)',strtolower($this->statusperkawinan),true);
		$criteria->compare('LOWER(agama)',strtolower($this->agama),true);
		$criteria->compare('LOWER(golongandarah)',strtolower($this->golongandarah),true);
		$criteria->compare('LOWER(no_telepon_pasien)',strtolower($this->no_telepon_pasien),true);
		$criteria->compare('LOWER(no_mobile_pasien)',strtolower($this->no_mobile_pasien),true);
		$criteria->compare('LOWER(warga_negara)',strtolower($this->warga_negara),true);
		$criteria->compare('LOWER(photopasien)',strtolower($this->photopasien),true);
		$criteria->compare('LOWER(nama_ibu)',strtolower($this->nama_ibu),true);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('LOWER(no_pendaftaran)',strtolower($this->no_pendaftaran),true);
		$criteria->compare('LOWER(tgl_pendaftaran)',strtolower($this->tgl_pendaftaran),true);
		$criteria->compare('LOWER(tempattujuan)',strtolower($this->tempattujuan),true);
		$criteria->compare('LOWER(kelurahan_nama)',strtolower($this->kelurahan_nama),true);
		$criteria->compare('LOWER(alamattujuan)',strtolower($this->alamattujuan),true);
		$criteria->compare('LOWER(rt_rw)',strtolower($this->rt_rw),true);
		$criteria->compare('LOWER(nomobile)',strtolower($this->nomobile),true);
		$criteria->compare('LOWER(notelepon)',strtolower($this->notelepon),true);
		$criteria->compare('LOWER(tglpemakaianambulans)',strtolower($this->tglpemakaianambulans),true);
		$criteria->compare('LOWER(untukkeperluan)',strtolower($this->untukkeperluan),true);
		$criteria->compare('LOWER(keteranganpesan)',strtolower($this->keteranganpesan),true);
		$criteria->compare('LOWER(longitude)',strtolower($this->longitude),true);
		$criteria->compare('LOWER(latitude)',strtolower($this->latitude),true);
		$criteria->compare('pemakaianambulans_id',$this->pemakaianambulans_id);
		$criteria->compare('mobilambulans_id',$this->mobilambulans_id);
		$criteria->compare('LOWER(mobilambulans_kode)',strtolower($this->mobilambulans_kode),true);
		$criteria->compare('LOWER(nopolisi)',strtolower($this->nopolisi),true);
		$criteria->compare('LOWER(jeniskendaraan)',strtolower($this->jeniskendaraan),true);
		$criteria->compare('isibbmliter',$this->isibbmliter);
		$criteria->compare('LOWER(kmterakhirkend)',strtolower($this->kmterakhirkend),true);
		$criteria->compare('LOWER(photokendaraan)',strtolower($this->photokendaraan),true);
		$criteria->compare('hargabbmliter',$this->hargabbmliter);
		$criteria->compare('LOWER(formulajasars)',strtolower($this->formulajasars),true);
		$criteria->compare('LOWER(formulajasaba)',strtolower($this->formulajasaba),true);
		$criteria->compare('LOWER(formulajasapel)',strtolower($this->formulajasapel),true);
		$criteria->compare('LOWER(pemesan_norekammedis)',strtolower($this->pemesan_norekammedis),true);
		$criteria->compare('LOWER(pemesan_nama)',strtolower($this->pemesan_nama),true);

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