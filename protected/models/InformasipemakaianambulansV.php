<?php

/**
 * This is the model class for table "informasipemakaianambulans_v".
 *
 * The followings are the available columns in table 'informasipemakaianambulans_v':
 * @property integer $instalasi_id
 * @property string $instalasi_nama
 * @property integer $ruangan_id
 * @property string $ruangan_nama
 * @property integer $pesanambulans_t
 * @property string $pesanambulans_tgl
 * @property string $pesanambulans_no
 * @property integer $pemakaianambulans_id
 * @property string $tglpemakaianambulans
 * @property string $tglkembaliambulans
 * @property string $untukkeperluan
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
 * @property integer $pasien_id
 * @property string $pemakai_nomorrekammedis
 * @property string $no_rekam_medik
 * @property string $pemakai_noidentitas
 * @property string $pasien_jenisidentitas
 * @property string $no_identitas_pasien
 * @property string $namadepan
 * @property string $pemakai_nama
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
 * @property string $namapj
 * @property string $hubunganpj
 * @property string $alamatpj
 * @property double $kmawal
 * @property double $kmakhir
 * @property double $jmlbbmliter
 * @property double $jumlahkm
 * @property double $tarifperkm
 * @property double $totaltarifambulans
 * @property integer $supir_id
 * @property string $supir_nip
 * @property string $supir_jenisidentitas
 * @property string $supir_noidentitas
 * @property string $supir_gelardepan
 * @property string $supir_nama
 * @property string $supir_gelarbelakang
 * @property integer $paramedis1_id
 * @property string $paramedis1_nip
 * @property string $paramedis1_jenisidentitas
 * @property string $paramedis1_noidentitas
 * @property string $paramedis1_gelardepan
 * @property string $paramedis1_nama
 * @property string $paramedis1_gelarbelakang
 * @property integer $paramedis2_id
 * @property string $paramedis2_nip
 * @property string $paramedis2_jenisidentitas
 * @property string $paramedis2_noidentitas
 * @property string $paramedis2_gelardepan
 * @property string $paramedis2_nama
 * @property string $paramedis2_gelarbelakang
 */
class InformasipemakaianambulansV extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return InformasipemakaianambulansV the static model class
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
		return 'informasipemakaianambulans_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('instalasi_id, ruangan_id, pesanambulans_t, pemakaianambulans_id, mobilambulans_id, isibbmliter, pasien_id, rt, rw, pendaftaran_id, supir_id, paramedis1_id, paramedis2_id', 'numerical', 'integerOnly'=>true),
			array('hargabbmliter, kmawal, kmakhir, jmlbbmliter, jumlahkm, tarifperkm, totaltarifambulans', 'numerical'),
			array('instalasi_nama, ruangan_nama, formulajasars, formulajasaba, formulajasapel, nama_pasien, nama_ibu, tempattujuan, kelurahan_nama, hubunganpj, supir_nama, paramedis1_nama, paramedis2_nama', 'length', 'max'=>50),
			array('pesanambulans_no, mobilambulans_kode, nopolisi, pasien_jenisidentitas, namadepan, jeniskelamin, statusperkawinan, agama, no_mobile_pasien, no_pendaftaran, rt_rw, supir_jenisidentitas, paramedis1_jenisidentitas, paramedis2_jenisidentitas', 'length', 'max'=>20),
			array('jeniskendaraan, pemakai_noidentitas, pemakai_nama, nomobile, notelepon, namapj, supir_noidentitas, paramedis1_noidentitas, paramedis2_noidentitas', 'length', 'max'=>100),
			array('pemakai_nomorrekammedis, no_rekam_medik, supir_gelardepan, paramedis1_gelardepan, paramedis2_gelardepan', 'length', 'max'=>10),
			array('no_identitas_pasien, nama_bin, supir_nip, paramedis1_nip, paramedis2_nip', 'length', 'max'=>30),
			array('tempat_lahir, warga_negara', 'length', 'max'=>25),
			array('golongandarah', 'length', 'max'=>2),
			array('no_telepon_pasien, supir_gelarbelakang, paramedis1_gelarbelakang, paramedis2_gelarbelakang', 'length', 'max'=>15),
			array('photopasien', 'length', 'max'=>200),
			array('pesanambulans_tgl, tglpemakaianambulans, tglkembaliambulans, untukkeperluan, kmterakhirkend, photokendaraan, tanggal_lahir, alamat_pasien, tgl_pendaftaran, alamattujuan, alamatpj', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('instalasi_id, instalasi_nama, ruangan_id, ruangan_nama, pesanambulans_t, pesanambulans_tgl, pesanambulans_no, pemakaianambulans_id, tglpemakaianambulans, tglkembaliambulans, untukkeperluan, mobilambulans_id, mobilambulans_kode, nopolisi, jeniskendaraan, isibbmliter, kmterakhirkend, photokendaraan, hargabbmliter, formulajasars, formulajasaba, formulajasapel, pasien_id, pemakai_nomorrekammedis, no_rekam_medik, pemakai_noidentitas, pasien_jenisidentitas, no_identitas_pasien, namadepan, pemakai_nama, nama_pasien, nama_bin, jeniskelamin, tempat_lahir, tanggal_lahir, alamat_pasien, rt, rw, statusperkawinan, agama, golongandarah, no_telepon_pasien, no_mobile_pasien, warga_negara, photopasien, nama_ibu, pendaftaran_id, no_pendaftaran, tgl_pendaftaran, tempattujuan, kelurahan_nama, alamattujuan, rt_rw, nomobile, notelepon, namapj, hubunganpj, alamatpj, kmawal, kmakhir, jmlbbmliter, jumlahkm, tarifperkm, totaltarifambulans, supir_id, supir_nip, supir_jenisidentitas, supir_noidentitas, supir_gelardepan, supir_nama, supir_gelarbelakang, paramedis1_id, paramedis1_nip, paramedis1_jenisidentitas, paramedis1_noidentitas, paramedis1_gelardepan, paramedis1_nama, paramedis1_gelarbelakang, paramedis2_id, paramedis2_nip, paramedis2_jenisidentitas, paramedis2_noidentitas, paramedis2_gelardepan, paramedis2_nama, paramedis2_gelarbelakang', 'safe', 'on'=>'search'),
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
			'pesanambulans_no' => 'Pesanambulans No',
			'pemakaianambulans_id' => 'Pemakaianambulans',
			'tglpemakaianambulans' => 'Tglpemakaianambulans',
			'tglkembaliambulans' => 'Tanggal Kembali Ambulans',
			'untukkeperluan' => 'Untukkeperluan',
			'mobilambulans_id' => 'Mobilambulans',
			'mobilambulans_kode' => 'Mobilambulans Kode',
			'nopolisi' => 'No. Polisi',
			'jeniskendaraan' => 'Jeniskendaraan',
			'isibbmliter' => 'Isibbmliter',
			'kmterakhirkend' => 'Kmterakhirkend',
			'photokendaraan' => 'Photokendaraan',
			'hargabbmliter' => 'Hargabbmliter',
			'formulajasars' => 'Formulajasars',
			'formulajasaba' => 'Formulajasaba',
			'formulajasapel' => 'Formulajasapel',
			'pasien_id' => 'Pasien',
			'pemakai_nomorrekammedis' => 'Pemakai Nomorrekammedis',
			'no_rekam_medik' => 'No. Rekam Medik',
			'pemakai_noidentitas' => 'Pemakai Noidentitas',
			'pasien_jenisidentitas' => 'Pasien Jenisidentitas',
			'no_identitas_pasien' => 'No. Identitas Pasien',
			'namadepan' => 'Namadepan',
			'pemakai_nama' => 'Nama Pemakai',
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
			'nomobile' => 'No. Handphone',
			'notelepon' => 'No. Telepon',
			'namapj' => 'Namapj',
			'hubunganpj' => 'Hubunganpj',
			'alamatpj' => 'Alamatpj',
			'kmawal' => 'KM Awal',
			'kmakhir' => 'KM Akhir',
			'jmlbbmliter' => 'Jmlbbmliter',
			'jumlahkm' => 'Jumlah KM',
			'tarifperkm' => 'Tarif / KM',
			'totaltarifambulans' => 'Total Tarif Ambulans',
			'supir_id' => 'Supir',
			'supir_nip' => 'Supir Nip',
			'supir_jenisidentitas' => 'Supir Jenisidentitas',
			'supir_noidentitas' => 'Supir Noidentitas',
			'supir_gelardepan' => 'Supir Gelardepan',
			'supir_nama' => 'Supir Nama',
			'supir_gelarbelakang' => 'Supir Gelarbelakang',
			'paramedis1_id' => 'Paramedis1',
			'paramedis1_nip' => 'Paramedis1 Nip',
			'paramedis1_jenisidentitas' => 'Paramedis1 Jenisidentitas',
			'paramedis1_noidentitas' => 'Paramedis1 Noidentitas',
			'paramedis1_gelardepan' => 'Paramedis1 Gelardepan',
			'paramedis1_nama' => 'Paramedis1 Nama',
			'paramedis1_gelarbelakang' => 'Paramedis1 Gelarbelakang',
			'paramedis2_id' => 'Paramedis2',
			'paramedis2_nip' => 'Paramedis2 Nip',
			'paramedis2_jenisidentitas' => 'Paramedis2 Jenisidentitas',
			'paramedis2_noidentitas' => 'Paramedis2 Noidentitas',
			'paramedis2_gelardepan' => 'Paramedis2 Gelardepan',
			'paramedis2_nama' => 'Paramedis2 Nama',
			'paramedis2_gelarbelakang' => 'Paramedis2 Gelarbelakang',
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
		$criteria->compare('pemakaianambulans_id',$this->pemakaianambulans_id);
		$criteria->compare('LOWER(tglpemakaianambulans)',strtolower($this->tglpemakaianambulans),true);
		$criteria->compare('LOWER(tglkembaliambulans)',strtolower($this->tglkembaliambulans),true);
		$criteria->compare('LOWER(untukkeperluan)',strtolower($this->untukkeperluan),true);
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
		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('LOWER(pemakai_nomorrekammedis)',strtolower($this->pemakai_nomorrekammedis),true);
		$criteria->compare('LOWER(no_rekam_medik)',strtolower($this->no_rekam_medik),true);
		$criteria->compare('LOWER(pemakai_noidentitas)',strtolower($this->pemakai_noidentitas),true);
		$criteria->compare('LOWER(pasien_jenisidentitas)',strtolower($this->pasien_jenisidentitas),true);
		$criteria->compare('LOWER(no_identitas_pasien)',strtolower($this->no_identitas_pasien),true);
		$criteria->compare('LOWER(namadepan)',strtolower($this->namadepan),true);
		$criteria->compare('LOWER(pemakai_nama)',strtolower($this->pemakai_nama),true);
		$criteria->compare('LOWER(nama_pasien)',strtolower($this->nama_pasien),true);
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
		$criteria->compare('LOWER(namapj)',strtolower($this->namapj),true);
		$criteria->compare('LOWER(hubunganpj)',strtolower($this->hubunganpj),true);
		$criteria->compare('LOWER(alamatpj)',strtolower($this->alamatpj),true);
		$criteria->compare('kmawal',$this->kmawal);
		$criteria->compare('kmakhir',$this->kmakhir);
		$criteria->compare('jmlbbmliter',$this->jmlbbmliter);
		$criteria->compare('jumlahkm',$this->jumlahkm);
		$criteria->compare('tarifperkm',$this->tarifperkm);
		$criteria->compare('totaltarifambulans',$this->totaltarifambulans);
		$criteria->compare('supir_id',$this->supir_id);
		$criteria->compare('LOWER(supir_nip)',strtolower($this->supir_nip),true);
		$criteria->compare('LOWER(supir_jenisidentitas)',strtolower($this->supir_jenisidentitas),true);
		$criteria->compare('LOWER(supir_noidentitas)',strtolower($this->supir_noidentitas),true);
		$criteria->compare('LOWER(supir_gelardepan)',strtolower($this->supir_gelardepan),true);
		$criteria->compare('LOWER(supir_nama)',strtolower($this->supir_nama),true);
		$criteria->compare('LOWER(supir_gelarbelakang)',strtolower($this->supir_gelarbelakang),true);
		$criteria->compare('paramedis1_id',$this->paramedis1_id);
		$criteria->compare('LOWER(paramedis1_nip)',strtolower($this->paramedis1_nip),true);
		$criteria->compare('LOWER(paramedis1_jenisidentitas)',strtolower($this->paramedis1_jenisidentitas),true);
		$criteria->compare('LOWER(paramedis1_noidentitas)',strtolower($this->paramedis1_noidentitas),true);
		$criteria->compare('LOWER(paramedis1_gelardepan)',strtolower($this->paramedis1_gelardepan),true);
		$criteria->compare('LOWER(paramedis1_nama)',strtolower($this->paramedis1_nama),true);
		$criteria->compare('LOWER(paramedis1_gelarbelakang)',strtolower($this->paramedis1_gelarbelakang),true);
		$criteria->compare('paramedis2_id',$this->paramedis2_id);
		$criteria->compare('LOWER(paramedis2_nip)',strtolower($this->paramedis2_nip),true);
		$criteria->compare('LOWER(paramedis2_jenisidentitas)',strtolower($this->paramedis2_jenisidentitas),true);
		$criteria->compare('LOWER(paramedis2_noidentitas)',strtolower($this->paramedis2_noidentitas),true);
		$criteria->compare('LOWER(paramedis2_gelardepan)',strtolower($this->paramedis2_gelardepan),true);
		$criteria->compare('LOWER(paramedis2_nama)',strtolower($this->paramedis2_nama),true);
		$criteria->compare('LOWER(paramedis2_gelarbelakang)',strtolower($this->paramedis2_gelarbelakang),true);

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