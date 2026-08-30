<?php

/**
 * @author Aida Rahmawati <aidarahmawati@.com>
 * @package application.models
 * 
 * This is the model class for table "rincianbayarobatalkes_v".
 *
 * The followings are the available columns in table 'rincianbayarobatalkes_v':
 * @property integer $obatalkespasien_id
 * @property integer $sumberdana_id
 * @property integer $racikan_id
 * @property integer $returresepdet_id
 * @property integer $tipepaket_id
 * @property integer $ruangan_id
 * @property integer $carabayar_id
 * @property integer $pegawai_id
 * @property integer $daftartindakan_id
 * @property integer $tindakanpelayanan_id
 * @property integer $satuankecil_id
 * @property integer $shift_id
 * @property integer $pendaftaran_id
 * @property integer $obatalkes_id
 * @property integer $pasien_id
 * @property integer $penjamin_id
 * @property integer $kelaspelayanan_id
 * @property integer $pasienanastesi_id
 * @property integer $pasienmasukpenunjang_id
 * @property integer $pasienadmisi_id
 * @property integer $oasudahbayar_id
 * @property integer $penjualanresep_id
 * @property string $tglpelayanan
 * @property string $r
 * @property integer $rke
 * @property integer $permintaan_oa
 * @property integer $jmlkemasan_oa
 * @property integer $kekuatan_oa
 * @property string $satuankekuatan_oa
 * @property double $qty_oa
 * @property double $hargasatuan_oa
 * @property string $signa_oa
 * @property double $harganetto_oa
 * @property double $hargajual_oa
 * @property string $etiket
 * @property double $jmlexposerad
 * @property string $kontrasrad
 * @property double $biayaservice
 * @property double $biayakonseling
 * @property double $jasadokterresep
 * @property double $biayakemasan
 * @property double $biayaadministrasi
 * @property double $tarifcyto
 * @property double $discount
 * @property double $subsidiasuransi
 * @property double $subsidipemerintah
 * @property double $subsidirs
 * @property double $iurbiaya
 * @property string $oa
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai_id
 * @property string $update_loginpemakai_id
 * @property string $create_ruangan
 * @property integer $verifikasitagihan_id
 * @property integer $jurnalrekening_id
 * @property integer $permohonanoadetail_id
 * @property integer $persenppnjual
 * @property integer $resepturdetail_id
 * @property string $no_rekam_medik
 * @property string $namadepan
 * @property string $nama_pasien
 * @property string $jeniskelamin
 * @property string $tempat_lahir
 * @property string $tanggal_lahir
 * @property string $alamat_pasien
 * @property string $umur
 * @property string $no_pendaftaran
 * @property string $tgl_pendaftaran
 * @property string $ruangan_nama
 * @property string $instalasi_nama
 * @property integer $jeniskelas_id
 * @property string $kelaspelayanan_nama
 * @property string $penjamin_nama
 * @property string $tipepaket_nama
 * @property string $carabayar_nama
 * @property string $daftartindakan_kode
 * @property string $daftartindakan_nama
 * @property string $tindakanmedis_nama
 * @property string $obatalkes_nama
 * @property double $jmlsubsidi_asuransi
 * @property double $jmlsubsidi_pemerintah
 * @property double $jmlsubsidi_rs
 * @property double $jmliurbiaya
 * @property double $jmlbayar_oa
 * @property double $jmlsisabayar_oa
 * @property string $noresep
 * @property string $tglresep
 * @property string $obatalkes_kode
 * @property integer $pembayaranpelayanan_id
 */
class RincianbayarobatalkesV extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return RincianbayarobatalkesV the static model class
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
		return 'rincianbayarobatalkes_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('obatalkespasien_id, sumberdana_id, racikan_id, returresepdet_id, tipepaket_id, ruangan_id, carabayar_id, pegawai_id, daftartindakan_id, tindakanpelayanan_id, satuankecil_id, shift_id, pendaftaran_id, obatalkes_id, pasien_id, penjamin_id, kelaspelayanan_id, pasienanastesi_id, pasienmasukpenunjang_id, pasienadmisi_id, oasudahbayar_id, penjualanresep_id, rke, permintaan_oa, jmlkemasan_oa, kekuatan_oa, verifikasitagihan_id, jurnalrekening_id, permohonanoadetail_id, persenppnjual, resepturdetail_id, jeniskelas_id, pembayaranpelayanan_id', 'numerical', 'integerOnly'=>true),
			array('qty_oa, hargasatuan_oa, harganetto_oa, hargajual_oa, jmlexposerad, biayaservice, biayakonseling, jasadokterresep, biayakemasan, biayaadministrasi, tarifcyto, discount, subsidiasuransi, subsidipemerintah, subsidirs, iurbiaya, jmlsubsidi_asuransi, jmlsubsidi_pemerintah, jmlsubsidi_rs, jmliurbiaya, jmlbayar_oa, jmlsisabayar_oa', 'numerical'),
			array('r, oa', 'length', 'max'=>2),
			array('satuankekuatan_oa, kontrasrad, namadepan, jeniskelamin, no_pendaftaran, daftartindakan_kode', 'length', 'max'=>20),
			array('signa_oa, umur', 'length', 'max'=>30),
			array('etiket', 'length', 'max'=>100),
			array('no_rekam_medik', 'length', 'max'=>10),
			array('nama_pasien, ruangan_nama, instalasi_nama, kelaspelayanan_nama, penjamin_nama, tipepaket_nama, carabayar_nama, noresep', 'length', 'max'=>50),
			array('tempat_lahir', 'length', 'max'=>25),
			array('daftartindakan_nama, tindakanmedis_nama, obatalkes_nama, obatalkes_kode', 'length', 'max'=>200),
			array('tglpelayanan, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, tanggal_lahir, alamat_pasien, tgl_pendaftaran, tglresep', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('obatalkespasien_id, sumberdana_id, racikan_id, returresepdet_id, tipepaket_id, ruangan_id, carabayar_id, pegawai_id, daftartindakan_id, tindakanpelayanan_id, satuankecil_id, shift_id, pendaftaran_id, obatalkes_id, pasien_id, penjamin_id, kelaspelayanan_id, pasienanastesi_id, pasienmasukpenunjang_id, pasienadmisi_id, oasudahbayar_id, penjualanresep_id, tglpelayanan, r, rke, permintaan_oa, jmlkemasan_oa, kekuatan_oa, satuankekuatan_oa, qty_oa, hargasatuan_oa, signa_oa, harganetto_oa, hargajual_oa, etiket, jmlexposerad, kontrasrad, biayaservice, biayakonseling, jasadokterresep, biayakemasan, biayaadministrasi, tarifcyto, discount, subsidiasuransi, subsidipemerintah, subsidirs, iurbiaya, oa, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, verifikasitagihan_id, jurnalrekening_id, permohonanoadetail_id, persenppnjual, resepturdetail_id, no_rekam_medik, namadepan, nama_pasien, jeniskelamin, tempat_lahir, tanggal_lahir, alamat_pasien, umur, no_pendaftaran, tgl_pendaftaran, ruangan_nama, instalasi_nama, jeniskelas_id, kelaspelayanan_nama, penjamin_nama, tipepaket_nama, carabayar_nama, daftartindakan_kode, daftartindakan_nama, tindakanmedis_nama, obatalkes_nama, jmlsubsidi_asuransi, jmlsubsidi_pemerintah, jmlsubsidi_rs, jmliurbiaya, jmlbayar_oa, jmlsisabayar_oa, noresep, tglresep, obatalkes_kode, pembayaranpelayanan_id', 'safe', 'on'=>'search'),
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
			'obatalkespasien_id' => 'Obatalkespasien',
			'sumberdana_id' => 'Sumberdana',
			'racikan_id' => 'Racikan',
			'returresepdet_id' => 'Returresepdet',
			'tipepaket_id' => 'Tipepaket',
			'ruangan_id' => 'Ruangan',
			'carabayar_id' => 'Jenis Penjamin',
			'pegawai_id' => 'Pegawai',
			'daftartindakan_id' => 'Daftartindakan',
			'tindakanpelayanan_id' => 'Tindakanpelayanan',
			'satuankecil_id' => 'Satuankecil',
			'shift_id' => 'Shift',
			'pendaftaran_id' => 'Pendaftaran',
			'obatalkes_id' => 'Obatalkes',
			'pasien_id' => 'Pasien',
			'penjamin_id' => 'Penjamin',
			'kelaspelayanan_id' => 'Kelaspelayanan',
			'pasienanastesi_id' => 'Pasienanastesi',
			'pasienmasukpenunjang_id' => 'Pasienmasukpenunjang',
			'pasienadmisi_id' => 'Pasienadmisi',
			'oasudahbayar_id' => 'Oasudahbayar',
			'penjualanresep_id' => 'Penjualanresep',
			'tglpelayanan' => 'Tglpelayanan',
			'r' => 'R',
			'rke' => 'Rke',
			'permintaan_oa' => 'Permintaan Oa',
			'jmlkemasan_oa' => 'Jmlkemasan Oa',
			'kekuatan_oa' => 'Kekuatan Oa',
			'satuankekuatan_oa' => 'Satuankekuatan Oa',
			'qty_oa' => 'Qty Oa',
			'hargasatuan_oa' => 'Hargasatuan Oa',
			'signa_oa' => 'Signa Oa',
			'harganetto_oa' => 'Harganetto Oa',
			'hargajual_oa' => 'Hargajual Oa',
			'etiket' => 'Etiket',
			'jmlexposerad' => 'Jmlexposerad',
			'kontrasrad' => 'Kontrasrad',
			'biayaservice' => 'Biayaservice',
			'biayakonseling' => 'Biayakonseling',
			'jasadokterresep' => 'Jasadokterresep',
			'biayakemasan' => 'Biayakemasan',
			'biayaadministrasi' => 'Biaya Administrasi',
			'tarifcyto' => 'Tarifcyto',
			'discount' => 'Keringanan',
			'subsidiasuransi' => 'Subsidiasuransi',
			'subsidipemerintah' => 'Subsidipemerintah',
			'subsidirs' => 'Subsidirs',
			'iurbiaya' => 'Iurbiaya',
			'oa' => 'Oa',
			'create_time' => 'Waktu Create',
			'update_time' => 'Waktu Update',
			'create_loginpemakai_id' => 'Create Login Pemakai',
			'update_loginpemakai_id' => 'Update Login Pemakai',
			'create_ruangan' => 'Create Ruangan',
			'verifikasitagihan_id' => 'Verifikasitagihan',
			'jurnalrekening_id' => 'Jurnalrekening',
			'permohonanoadetail_id' => 'Permohonanoadetail',
			'persenppnjual' => 'Persenppnjual',
			'resepturdetail_id' => 'Resepturdetail',
			'no_rekam_medik' => 'No. Rekam Medik',
			'namadepan' => 'Namadepan',
			'nama_pasien' => 'Nama Pasien',
			'jeniskelamin' => 'Jenis Kelamin',
			'tempat_lahir' => 'Tempat Lahir',
			'tanggal_lahir' => 'Tanggal Lahir',
			'alamat_pasien' => 'Alamat Pasien',
			'umur' => 'Umur',
			'no_pendaftaran' => 'No. Pendaftaran',
			'tgl_pendaftaran' => 'Tgl. Pendaftaran',
			'ruangan_nama' => 'Ruangan Nama',
			'instalasi_nama' => 'Instalasi Nama',
			'jeniskelas_id' => 'Jeniskelas',
			'kelaspelayanan_nama' => 'Kelaspelayanan Nama',
			'penjamin_nama' => 'Penjamin Nama',
			'tipepaket_nama' => 'Tipepaket Nama',
			'carabayar_nama' => 'Carabayar Nama',
			'daftartindakan_kode' => 'Daftartindakan Kode',
			'daftartindakan_nama' => 'Nama Daftar Tindakan',
			'tindakanmedis_nama' => 'Tindakanmedis Nama',
			'obatalkes_nama' => 'Obatalkes Nama',
			'jmlsubsidi_asuransi' => 'Jmlsubsidi Asuransi',
			'jmlsubsidi_pemerintah' => 'Jmlsubsidi Pemerintah',
			'jmlsubsidi_rs' => 'Jmlsubsidi Rs',
			'jmliurbiaya' => 'Jmliurbiaya',
			'jmlbayar_oa' => 'Jmlbayar Oa',
			'jmlsisabayar_oa' => 'Jmlsisabayar Oa',
			'noresep' => 'Noresep',
			'tglresep' => 'Tglresep',
			'obatalkes_kode' => 'Obatalkes Kode',
			'pembayaranpelayanan_id' => 'Pembayaranpelayanan',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('obatalkespasien_id',$this->obatalkespasien_id);
		$criteria->compare('sumberdana_id',$this->sumberdana_id);
		$criteria->compare('racikan_id',$this->racikan_id);
		$criteria->compare('returresepdet_id',$this->returresepdet_id);
		$criteria->compare('tipepaket_id',$this->tipepaket_id);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('carabayar_id',$this->carabayar_id);
		$criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->compare('daftartindakan_id',$this->daftartindakan_id);
		$criteria->compare('tindakanpelayanan_id',$this->tindakanpelayanan_id);
		$criteria->compare('satuankecil_id',$this->satuankecil_id);
		$criteria->compare('shift_id',$this->shift_id);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('obatalkes_id',$this->obatalkes_id);
		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('penjamin_id',$this->penjamin_id);
		$criteria->compare('kelaspelayanan_id',$this->kelaspelayanan_id);
		$criteria->compare('pasienanastesi_id',$this->pasienanastesi_id);
		$criteria->compare('pasienmasukpenunjang_id',$this->pasienmasukpenunjang_id);
		$criteria->compare('pasienadmisi_id',$this->pasienadmisi_id);
		$criteria->compare('oasudahbayar_id',$this->oasudahbayar_id);
		$criteria->compare('penjualanresep_id',$this->penjualanresep_id);
		$criteria->compare('tglpelayanan',$this->tglpelayanan,true);
		$criteria->compare('r',$this->r,true);
		$criteria->compare('rke',$this->rke);
		$criteria->compare('permintaan_oa',$this->permintaan_oa);
		$criteria->compare('jmlkemasan_oa',$this->jmlkemasan_oa);
		$criteria->compare('kekuatan_oa',$this->kekuatan_oa);
		$criteria->compare('satuankekuatan_oa',$this->satuankekuatan_oa,true);
		$criteria->compare('qty_oa',$this->qty_oa);
		$criteria->compare('hargasatuan_oa',$this->hargasatuan_oa);
		$criteria->compare('signa_oa',$this->signa_oa,true);
		$criteria->compare('harganetto_oa',$this->harganetto_oa);
		$criteria->compare('hargajual_oa',$this->hargajual_oa);
		$criteria->compare('etiket',$this->etiket,true);
		$criteria->compare('jmlexposerad',$this->jmlexposerad);
		$criteria->compare('kontrasrad',$this->kontrasrad,true);
		$criteria->compare('biayaservice',$this->biayaservice);
		$criteria->compare('biayakonseling',$this->biayakonseling);
		$criteria->compare('jasadokterresep',$this->jasadokterresep);
		$criteria->compare('biayakemasan',$this->biayakemasan);
		$criteria->compare('biayaadministrasi',$this->biayaadministrasi);
		$criteria->compare('tarifcyto',$this->tarifcyto);
		$criteria->compare('discount',$this->discount);
		$criteria->compare('subsidiasuransi',$this->subsidiasuransi);
		$criteria->compare('subsidipemerintah',$this->subsidipemerintah);
		$criteria->compare('subsidirs',$this->subsidirs);
		$criteria->compare('iurbiaya',$this->iurbiaya);
		$criteria->compare('oa',$this->oa,true);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('create_loginpemakai_id',$this->create_loginpemakai_id,true);
		$criteria->compare('update_loginpemakai_id',$this->update_loginpemakai_id,true);
		$criteria->compare('create_ruangan',$this->create_ruangan,true);
		$criteria->compare('verifikasitagihan_id',$this->verifikasitagihan_id);
		$criteria->compare('jurnalrekening_id',$this->jurnalrekening_id);
		$criteria->compare('permohonanoadetail_id',$this->permohonanoadetail_id);
		$criteria->compare('persenppnjual',$this->persenppnjual);
		$criteria->compare('resepturdetail_id',$this->resepturdetail_id);
		$criteria->compare('no_rekam_medik',$this->no_rekam_medik,true);
		$criteria->compare('namadepan',$this->namadepan,true);
		$criteria->compare('nama_pasien',$this->nama_pasien,true);
		$criteria->compare('jeniskelamin',$this->jeniskelamin,true);
		$criteria->compare('tempat_lahir',$this->tempat_lahir,true);
		$criteria->compare('tanggal_lahir',$this->tanggal_lahir,true);
		$criteria->compare('alamat_pasien',$this->alamat_pasien,true);
		$criteria->compare('umur',$this->umur,true);
		$criteria->compare('no_pendaftaran',$this->no_pendaftaran,true);
		$criteria->compare('tgl_pendaftaran',$this->tgl_pendaftaran,true);
		$criteria->compare('ruangan_nama',$this->ruangan_nama,true);
		$criteria->compare('instalasi_nama',$this->instalasi_nama,true);
		$criteria->compare('jeniskelas_id',$this->jeniskelas_id);
		$criteria->compare('kelaspelayanan_nama',$this->kelaspelayanan_nama,true);
		$criteria->compare('penjamin_nama',$this->penjamin_nama,true);
		$criteria->compare('tipepaket_nama',$this->tipepaket_nama,true);
		$criteria->compare('carabayar_nama',$this->carabayar_nama,true);
		$criteria->compare('daftartindakan_kode',$this->daftartindakan_kode,true);
		$criteria->compare('daftartindakan_nama',$this->daftartindakan_nama,true);
		$criteria->compare('tindakanmedis_nama',$this->tindakanmedis_nama,true);
		$criteria->compare('obatalkes_nama',$this->obatalkes_nama,true);
		$criteria->compare('jmlsubsidi_asuransi',$this->jmlsubsidi_asuransi);
		$criteria->compare('jmlsubsidi_pemerintah',$this->jmlsubsidi_pemerintah);
		$criteria->compare('jmlsubsidi_rs',$this->jmlsubsidi_rs);
		$criteria->compare('jmliurbiaya',$this->jmliurbiaya);
		$criteria->compare('jmlbayar_oa',$this->jmlbayar_oa);
		$criteria->compare('jmlsisabayar_oa',$this->jmlsisabayar_oa);
		$criteria->compare('noresep',$this->noresep,true);
		$criteria->compare('tglresep',$this->tglresep,true);
		$criteria->compare('obatalkes_kode',$this->obatalkes_kode,true);
		$criteria->compare('pembayaranpelayanan_id',$this->pembayaranpelayanan_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}