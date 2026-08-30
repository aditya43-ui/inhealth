<?php

/**
 * This is the model class for table "laporanpenyusutanaset_v".
 *
 * The followings are the available columns in table 'laporanpenyusutanaset_v':
 * @property integer $instalasi_id
 * @property string $instalasi_nama
 * @property integer $ruangan_id
 * @property string $ruangan_nama
 * @property integer $penyusutanaset_id
 * @property string $tgl_penyusutan
 * @property string $no_penyusutan
 * @property integer $barang_id
 * @property string $barang_type
 * @property string $barang_kode
 * @property string $barang_nama
 * @property string $barang_merk
 * @property string $barang_noseri
 * @property string $barang_ukuran
 * @property string $barang_bahan
 * @property string $barang_thnbeli
 * @property string $barang_warna
 * @property boolean $barang_statusregister
 * @property integer $barang_ekonomis_thn
 * @property string $barang_satuan
 * @property integer $barang_jmldlmkemasan
 * @property string $barang_image
 * @property double $barang_harganetto
 * @property double $barang_persendiskon
 * @property double $barang_ppn
 * @property double $barang_hpp
 * @property double $barang_hargajual
 * @property integer $invgedung_id
 * @property string $invgedung_kode
 * @property string $invgedung_noregister
 * @property integer $invjalan_id
 * @property string $invjalan_kode
 * @property string $invjalan_noregister
 * @property integer $invasetlain_id
 * @property string $invasetlain_kode
 * @property string $invasetlain_noregister
 * @property integer $invtanah_id
 * @property string $invtanah_kode
 * @property string $invtanah_noregister
 * @property integer $invperalatan_id
 * @property string $invperalatan_kode
 * @property string $invperalatan_noregister
 * @property double $hargaperolehan
 * @property double $residu
 * @property double $umurekonomis
 * @property double $totalpenyusutan
 * @property integer $penyusutanasetdetail_id
 * @property integer $penyusutanaset_urutan
 * @property string $penyusutanaset_periode
 * @property double $penyusutanaset_saldo
 * @property double $penyusutanaset_persentase
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 * @property integer $jurnalrekening_id
 * @property integer $rekperiod_id
 * @property string $perideawal
 * @property string $sampaidgn
 * @property string $deskripsi
 * @property boolean $isclosing
 * @property integer $jenisjurnal_id
 * @property string $jenisjurnal_nama
 * @property string $tglbuktijurnal
 * @property string $nobuktijurnal
 * @property string $kodejurnal
 * @property string $noreferensi
 * @property string $tglreferensi
 * @property integer $nobku
 * @property integer $jurnaldebit_id
 * @property integer $rekeningdebit1_id
 * @property string $rekeningdebit1_kode
 * @property string $rekeningdebit1_nama
 * @property integer $rekeningdebit2_id
 * @property string $rekeningdebit2_kode
 * @property string $rekeningdebit2_nama
 * @property integer $rekeningdebit3_id
 * @property string $rekeningdebit3_kode
 * @property string $rekeningdebit3_nama
 * @property integer $rekeningdebit4_id
 * @property string $rekeningdebit4_kode
 * @property string $rekeningdebit4_nama
 * @property integer $rekeningdebit5_id
 * @property string $rekeningdebit5_kode
 * @property string $rekeningdebit5_nama
 * @property double $saldodebit
 * @property integer $jurnalkredit_id
 * @property integer $rekeningkredit1_id
 * @property string $rekeningkredit1_kode
 * @property string $rekeningkredit1_nama
 * @property integer $rekeningkredit2_id
 * @property string $rekeningkredit2_kode
 * @property string $rekeningkredit2_nama
 * @property integer $rekeningkredit3_id
 * @property string $rekeningkredit3_kode
 * @property string $rekeningkredit3_nama
 * @property integer $rekeningkredit4_id
 * @property string $rekeningkredit4_kode
 * @property string $rekeningkredit4_nama
 * @property integer $rekeningkredit5_id
 * @property string $rekeningkredit5_kode
 * @property string $rekeningkredit5_nama
 * @property double $saldokredit
 */
class LaporanpenyusutanasetV extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return LaporanpenyusutanasetV the static model class
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
		return 'laporanpenyusutanaset_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('instalasi_id, ruangan_id, penyusutanaset_id, barang_id, barang_ekonomis_thn, barang_jmldlmkemasan, invgedung_id, invjalan_id, invasetlain_id, invtanah_id, invperalatan_id, penyusutanasetdetail_id, penyusutanaset_urutan, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, jurnalrekening_id, rekperiod_id, jenisjurnal_id, nobku, jurnaldebit_id, rekeningdebit1_id, rekeningdebit2_id, rekeningdebit3_id, rekeningdebit4_id, rekeningdebit5_id, jurnalkredit_id, rekeningkredit1_id, rekeningkredit2_id, rekeningkredit3_id, rekeningkredit4_id, rekeningkredit5_id', 'numerical', 'integerOnly'=>true),
			array('barang_harganetto, barang_persendiskon, barang_ppn, barang_hpp, barang_hargajual, hargaperolehan, residu, umurekonomis, totalpenyusutan, penyusutanaset_saldo, penyusutanaset_persentase, saldodebit, saldokredit', 'numerical'),
			array('instalasi_nama, ruangan_nama, barang_type, barang_kode, barang_merk, barang_warna, barang_satuan, invgedung_kode, invgedung_noregister, invjalan_kode, invjalan_noregister, invasetlain_kode, invasetlain_noregister, invtanah_kode, invtanah_noregister, invperalatan_kode, invperalatan_noregister, penyusutanaset_periode, nobuktijurnal', 'length', 'max'=>50),
			array('no_penyusutan', 'length', 'max'=>25),
			array('barang_nama, jenisjurnal_nama, rekeningdebit1_nama, rekeningkredit1_nama', 'length', 'max'=>100),
			array('barang_noseri, barang_ukuran, barang_bahan, kodejurnal', 'length', 'max'=>20),
			array('barang_thnbeli, rekeningdebit1_kode, rekeningdebit2_kode, rekeningdebit3_kode, rekeningdebit4_kode, rekeningdebit5_kode, rekeningkredit1_kode, rekeningkredit2_kode, rekeningkredit3_kode, rekeningkredit4_kode, rekeningkredit5_kode', 'length', 'max'=>5),
			array('barang_image, deskripsi, rekeningdebit2_nama, rekeningkredit2_nama', 'length', 'max'=>200),
			array('rekeningdebit3_nama, rekeningkredit3_nama', 'length', 'max'=>300),
			array('rekeningdebit4_nama, rekeningkredit4_nama', 'length', 'max'=>400),
			array('rekeningdebit5_nama, rekeningkredit5_nama', 'length', 'max'=>500),
			array('tgl_penyusutan, barang_statusregister, create_time, update_time, perideawal, sampaidgn, isclosing, tglbuktijurnal, noreferensi, tglreferensi', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('instalasi_id, instalasi_nama, ruangan_id, ruangan_nama, penyusutanaset_id, tgl_penyusutan, no_penyusutan, barang_id, barang_type, barang_kode, barang_nama, barang_merk, barang_noseri, barang_ukuran, barang_bahan, barang_thnbeli, barang_warna, barang_statusregister, barang_ekonomis_thn, barang_satuan, barang_jmldlmkemasan, barang_image, barang_harganetto, barang_persendiskon, barang_ppn, barang_hpp, barang_hargajual, invgedung_id, invgedung_kode, invgedung_noregister, invjalan_id, invjalan_kode, invjalan_noregister, invasetlain_id, invasetlain_kode, invasetlain_noregister, invtanah_id, invtanah_kode, invtanah_noregister, invperalatan_id, invperalatan_kode, invperalatan_noregister, hargaperolehan, residu, umurekonomis, totalpenyusutan, penyusutanasetdetail_id, penyusutanaset_urutan, penyusutanaset_periode, penyusutanaset_saldo, penyusutanaset_persentase, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, jurnalrekening_id, rekperiod_id, perideawal, sampaidgn, deskripsi, isclosing, jenisjurnal_id, jenisjurnal_nama, tglbuktijurnal, nobuktijurnal, kodejurnal, noreferensi, tglreferensi, nobku, jurnaldebit_id, rekeningdebit1_id, rekeningdebit1_kode, rekeningdebit1_nama, rekeningdebit2_id, rekeningdebit2_kode, rekeningdebit2_nama, rekeningdebit3_id, rekeningdebit3_kode, rekeningdebit3_nama, rekeningdebit4_id, rekeningdebit4_kode, rekeningdebit4_nama, rekeningdebit5_id, rekeningdebit5_kode, rekeningdebit5_nama, saldodebit, jurnalkredit_id, rekeningkredit1_id, rekeningkredit1_kode, rekeningkredit1_nama, rekeningkredit2_id, rekeningkredit2_kode, rekeningkredit2_nama, rekeningkredit3_id, rekeningkredit3_kode, rekeningkredit3_nama, rekeningkredit4_id, rekeningkredit4_kode, rekeningkredit4_nama, rekeningkredit5_id, rekeningkredit5_kode, rekeningkredit5_nama, saldokredit', 'safe', 'on'=>'search'),
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
			'ruangan_nama' => 'Ruangan Nama',
			'penyusutanaset_id' => 'Penyusutanaset',
			'tgl_penyusutan' => 'Tanggal Penyusutan',
			'no_penyusutan' => 'No. Penyusutan',
			'barang_id' => 'Barang',
			'barang_type' => 'Barang Type',
			'barang_kode' => 'Barang Kode',
			'barang_nama' => 'Barang Nama',
			'barang_merk' => 'Barang Merk',
			'barang_noseri' => 'Barang Noseri',
			'barang_ukuran' => 'Barang Ukuran',
			'barang_bahan' => 'Barang Bahan',
			'barang_thnbeli' => 'Barang Thnbeli',
			'barang_warna' => 'Barang Warna',
			'barang_statusregister' => 'Barang Statusregister',
			'barang_ekonomis_thn' => 'Barang Ekonomis Thn',
			'barang_satuan' => 'Barang Satuan',
			'barang_jmldlmkemasan' => 'Barang Jmldlmkemasan',
			'barang_image' => 'Barang Image',
			'barang_harganetto' => 'Barang Harganetto',
			'barang_persendiskon' => 'Barang Persendiskon',
			'barang_ppn' => 'Barang Ppn',
			'barang_hpp' => 'Barang Hpp',
			'barang_hargajual' => 'Barang Hargajual',
			'invgedung_id' => 'Invgedung',
			'invgedung_kode' => 'Invgedung Kode',
			'invgedung_noregister' => 'Invgedung Noregister',
			'invjalan_id' => 'Invjalan',
			'invjalan_kode' => 'Invjalan Kode',
			'invjalan_noregister' => 'Invjalan Noregister',
			'invasetlain_id' => 'Invasetlain',
			'invasetlain_kode' => 'Invasetlain Kode',
			'invasetlain_noregister' => 'Invasetlain Noregister',
			'invtanah_id' => 'Invtanah',
			'invtanah_kode' => 'Invtanah Kode',
			'invtanah_noregister' => 'Invtanah Noregister',
			'invperalatan_id' => 'Invperalatan',
			'invperalatan_kode' => 'Invperalatan Kode',
			'invperalatan_noregister' => 'Invperalatan Noregister',
			'hargaperolehan' => 'Harga Perolehan',
			'residu' => 'Residu',
			'umurekonomis' => 'Umur Ekonomis',
			'totalpenyusutan' => 'Total Penyusutan',
			'penyusutanasetdetail_id' => 'Penyusutanasetdetail',
			'penyusutanaset_urutan' => 'Penyusutanaset Urutan',
			'penyusutanaset_periode' => 'Periode Penyusutan',
			'penyusutanaset_saldo' => 'Penyusutanaset Saldo',
			'penyusutanaset_persentase' => 'Penyusutanaset Persentase',
			'create_time' => 'Waktu Create',
			'update_time' => 'Waktu Update',
			'create_loginpemakai_id' => 'Create Login Pemakai',
			'update_loginpemakai_id' => 'Update Login Pemakai',
			'create_ruangan' => 'Create Ruangan',
			'jurnalrekening_id' => 'Jurnalrekening',
			'rekperiod_id' => 'Rekperiod',
			'perideawal' => 'Perideawal',
			'sampaidgn' => 'Sampaidgn',
			'deskripsi' => 'Deskripsi',
			'isclosing' => 'Isclosing',
			'jenisjurnal_id' => 'Jenisjurnal',
			'jenisjurnal_nama' => 'Jenisjurnal Nama',
			'tglbuktijurnal' => 'Tglbuktijurnal',
			'nobuktijurnal' => 'Nobuktijurnal',
			'kodejurnal' => 'Kodejurnal',
			'noreferensi' => 'Noreferensi',
			'tglreferensi' => 'Tglreferensi',
			'nobku' => 'Nobku',
			'jurnaldebit_id' => 'Jurnaldebit',
			'rekeningdebit1_id' => 'Rekeningdebit1',
			'rekeningdebit1_kode' => 'Rekeningdebit1 Kode',
			'rekeningdebit1_nama' => 'Rekeningdebit1 Nama',
			'rekeningdebit2_id' => 'Rekeningdebit2',
			'rekeningdebit2_kode' => 'Rekeningdebit2 Kode',
			'rekeningdebit2_nama' => 'Rekeningdebit2 Nama',
			'rekeningdebit3_id' => 'Rekeningdebit3',
			'rekeningdebit3_kode' => 'Rekeningdebit3 Kode',
			'rekeningdebit3_nama' => 'Rekeningdebit3 Nama',
			'rekeningdebit4_id' => 'Rekeningdebit4',
			'rekeningdebit4_kode' => 'Rekeningdebit4 Kode',
			'rekeningdebit4_nama' => 'Rekeningdebit4 Nama',
			'rekeningdebit5_id' => 'Rekeningdebit5',
			'rekeningdebit5_kode' => 'Rekeningdebit5 Kode',
			'rekeningdebit5_nama' => 'Rekeningdebit5 Nama',
			'saldodebit' => 'Saldodebit',
			'jurnalkredit_id' => 'Jurnalkredit',
			'rekeningkredit1_id' => 'Rekeningkredit1',
			'rekeningkredit1_kode' => 'Rekeningkredit1 Kode',
			'rekeningkredit1_nama' => 'Rekeningkredit1 Nama',
			'rekeningkredit2_id' => 'Rekeningkredit2',
			'rekeningkredit2_kode' => 'Rekeningkredit2 Kode',
			'rekeningkredit2_nama' => 'Rekeningkredit2 Nama',
			'rekeningkredit3_id' => 'Rekeningkredit3',
			'rekeningkredit3_kode' => 'Rekeningkredit3 Kode',
			'rekeningkredit3_nama' => 'Rekeningkredit3 Nama',
			'rekeningkredit4_id' => 'Rekeningkredit4',
			'rekeningkredit4_kode' => 'Rekeningkredit4 Kode',
			'rekeningkredit4_nama' => 'Rekeningkredit4 Nama',
			'rekeningkredit5_id' => 'Rekeningkredit5',
			'rekeningkredit5_kode' => 'Rekeningkredit5 Kode',
			'rekeningkredit5_nama' => 'Rekeningkredit5 Nama',
			'saldokredit' => 'Saldokredit',
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

		if(!empty($this->instalasi_id)){
			$criteria->addCondition('instalasi_id = '.$this->instalasi_id);
		}
		$criteria->compare('LOWER(instalasi_nama)',strtolower($this->instalasi_nama),true);
		if(!empty($this->ruangan_id)){
			$criteria->addCondition('ruangan_id = '.$this->ruangan_id);
		}
		$criteria->compare('LOWER(ruangan_nama)',strtolower($this->ruangan_nama),true);
		if(!empty($this->penyusutanaset_id)){
			$criteria->addCondition('penyusutanaset_id = '.$this->penyusutanaset_id);
		}
		$criteria->compare('LOWER(tgl_penyusutan)',strtolower($this->tgl_penyusutan),true);
		$criteria->compare('LOWER(no_penyusutan)',strtolower($this->no_penyusutan),true);
		if(!empty($this->barang_id)){
			$criteria->addCondition('barang_id = '.$this->barang_id);
		}
		$criteria->compare('LOWER(barang_type)',strtolower($this->barang_type),true);
		$criteria->compare('LOWER(barang_kode)',strtolower($this->barang_kode),true);
		$criteria->compare('LOWER(barang_nama)',strtolower($this->barang_nama),true);
		$criteria->compare('LOWER(barang_merk)',strtolower($this->barang_merk),true);
		$criteria->compare('LOWER(barang_noseri)',strtolower($this->barang_noseri),true);
		$criteria->compare('LOWER(barang_ukuran)',strtolower($this->barang_ukuran),true);
		$criteria->compare('LOWER(barang_bahan)',strtolower($this->barang_bahan),true);
		$criteria->compare('LOWER(barang_thnbeli)',strtolower($this->barang_thnbeli),true);
		$criteria->compare('LOWER(barang_warna)',strtolower($this->barang_warna),true);
		$criteria->compare('barang_statusregister',$this->barang_statusregister);
		if(!empty($this->barang_ekonomis_thn)){
			$criteria->addCondition('barang_ekonomis_thn = '.$this->barang_ekonomis_thn);
		}
		$criteria->compare('LOWER(barang_satuan)',strtolower($this->barang_satuan),true);
		if(!empty($this->barang_jmldlmkemasan)){
			$criteria->addCondition('barang_jmldlmkemasan = '.$this->barang_jmldlmkemasan);
		}
		$criteria->compare('LOWER(barang_image)',strtolower($this->barang_image),true);
		$criteria->compare('barang_harganetto',$this->barang_harganetto);
		$criteria->compare('barang_persendiskon',$this->barang_persendiskon);
		$criteria->compare('barang_ppn',$this->barang_ppn);
		$criteria->compare('barang_hpp',$this->barang_hpp);
		$criteria->compare('barang_hargajual',$this->barang_hargajual);
		if(!empty($this->invgedung_id)){
			$criteria->addCondition('invgedung_id = '.$this->invgedung_id);
		}
		$criteria->compare('LOWER(invgedung_kode)',strtolower($this->invgedung_kode),true);
		$criteria->compare('LOWER(invgedung_noregister)',strtolower($this->invgedung_noregister),true);
		if(!empty($this->invjalan_id)){
			$criteria->addCondition('invjalan_id = '.$this->invjalan_id);
		}
		$criteria->compare('LOWER(invjalan_kode)',strtolower($this->invjalan_kode),true);
		$criteria->compare('LOWER(invjalan_noregister)',strtolower($this->invjalan_noregister),true);
		if(!empty($this->invasetlain_id)){
			$criteria->addCondition('invasetlain_id = '.$this->invasetlain_id);
		}
		$criteria->compare('LOWER(invasetlain_kode)',strtolower($this->invasetlain_kode),true);
		$criteria->compare('LOWER(invasetlain_noregister)',strtolower($this->invasetlain_noregister),true);
		if(!empty($this->invtanah_id)){
			$criteria->addCondition('invtanah_id = '.$this->invtanah_id);
		}
		$criteria->compare('LOWER(invtanah_kode)',strtolower($this->invtanah_kode),true);
		$criteria->compare('LOWER(invtanah_noregister)',strtolower($this->invtanah_noregister),true);
		if(!empty($this->invperalatan_id)){
			$criteria->addCondition('invperalatan_id = '.$this->invperalatan_id);
		}
		$criteria->compare('LOWER(invperalatan_kode)',strtolower($this->invperalatan_kode),true);
		$criteria->compare('LOWER(invperalatan_noregister)',strtolower($this->invperalatan_noregister),true);
		$criteria->compare('hargaperolehan',$this->hargaperolehan);
		$criteria->compare('residu',$this->residu);
		$criteria->compare('umurekonomis',$this->umurekonomis);
		$criteria->compare('totalpenyusutan',$this->totalpenyusutan);
		if(!empty($this->penyusutanasetdetail_id)){
			$criteria->addCondition('penyusutanasetdetail_id = '.$this->penyusutanasetdetail_id);
		}
		if(!empty($this->penyusutanaset_urutan)){
			$criteria->addCondition('penyusutanaset_urutan = '.$this->penyusutanaset_urutan);
		}
		$criteria->compare('LOWER(penyusutanaset_periode)',strtolower($this->penyusutanaset_periode),true);
		$criteria->compare('penyusutanaset_saldo',$this->penyusutanaset_saldo);
		$criteria->compare('penyusutanaset_persentase',$this->penyusutanaset_persentase);
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
		if(!empty($this->create_loginpemakai_id)){
			$criteria->addCondition('create_loginpemakai_id = '.$this->create_loginpemakai_id);
		}
		if(!empty($this->update_loginpemakai_id)){
			$criteria->addCondition('update_loginpemakai_id = '.$this->update_loginpemakai_id);
		}
		if(!empty($this->create_ruangan)){
			$criteria->addCondition('create_ruangan = '.$this->create_ruangan);
		}
		if(!empty($this->jurnalrekening_id)){
			$criteria->addCondition('jurnalrekening_id = '.$this->jurnalrekening_id);
		}
		if(!empty($this->rekperiod_id)){
			$criteria->addCondition('rekperiod_id = '.$this->rekperiod_id);
		}
		$criteria->compare('LOWER(perideawal)',strtolower($this->perideawal),true);
		$criteria->compare('LOWER(sampaidgn)',strtolower($this->sampaidgn),true);
		$criteria->compare('LOWER(deskripsi)',strtolower($this->deskripsi),true);
		$criteria->compare('isclosing',$this->isclosing);
		if(!empty($this->jenisjurnal_id)){
			$criteria->addCondition('jenisjurnal_id = '.$this->jenisjurnal_id);
		}
		$criteria->compare('LOWER(jenisjurnal_nama)',strtolower($this->jenisjurnal_nama),true);
		$criteria->compare('LOWER(tglbuktijurnal)',strtolower($this->tglbuktijurnal),true);
		$criteria->compare('LOWER(nobuktijurnal)',strtolower($this->nobuktijurnal),true);
		$criteria->compare('LOWER(kodejurnal)',strtolower($this->kodejurnal),true);
		$criteria->compare('LOWER(noreferensi)',strtolower($this->noreferensi),true);
		$criteria->compare('LOWER(tglreferensi)',strtolower($this->tglreferensi),true);
		if(!empty($this->nobku)){
			$criteria->addCondition('nobku = '.$this->nobku);
		}
		if(!empty($this->jurnaldebit_id)){
			$criteria->addCondition('jurnaldebit_id = '.$this->jurnaldebit_id);
		}
		if(!empty($this->rekeningdebit1_id)){
			$criteria->addCondition('rekeningdebit1_id = '.$this->rekeningdebit1_id);
		}
		$criteria->compare('LOWER(rekeningdebit1_kode)',strtolower($this->rekeningdebit1_kode),true);
		$criteria->compare('LOWER(rekeningdebit1_nama)',strtolower($this->rekeningdebit1_nama),true);
		if(!empty($this->rekeningdebit2_id)){
			$criteria->addCondition('rekeningdebit2_id = '.$this->rekeningdebit2_id);
		}
		$criteria->compare('LOWER(rekeningdebit2_kode)',strtolower($this->rekeningdebit2_kode),true);
		$criteria->compare('LOWER(rekeningdebit2_nama)',strtolower($this->rekeningdebit2_nama),true);
		if(!empty($this->rekeningdebit3_id)){
			$criteria->addCondition('rekeningdebit3_id = '.$this->rekeningdebit3_id);
		}
		$criteria->compare('LOWER(rekeningdebit3_kode)',strtolower($this->rekeningdebit3_kode),true);
		$criteria->compare('LOWER(rekeningdebit3_nama)',strtolower($this->rekeningdebit3_nama),true);
		if(!empty($this->rekeningdebit4_id)){
			$criteria->addCondition('rekeningdebit4_id = '.$this->rekeningdebit4_id);
		}
		$criteria->compare('LOWER(rekeningdebit4_kode)',strtolower($this->rekeningdebit4_kode),true);
		$criteria->compare('LOWER(rekeningdebit4_nama)',strtolower($this->rekeningdebit4_nama),true);
		if(!empty($this->rekeningdebit5_id)){
			$criteria->addCondition('rekeningdebit5_id = '.$this->rekeningdebit5_id);
		}
		$criteria->compare('LOWER(rekeningdebit5_kode)',strtolower($this->rekeningdebit5_kode),true);
		$criteria->compare('LOWER(rekeningdebit5_nama)',strtolower($this->rekeningdebit5_nama),true);
		$criteria->compare('saldodebit',$this->saldodebit);
		if(!empty($this->jurnalkredit_id)){
			$criteria->addCondition('jurnalkredit_id = '.$this->jurnalkredit_id);
		}
		if(!empty($this->rekeningkredit1_id)){
			$criteria->addCondition('rekeningkredit1_id = '.$this->rekeningkredit1_id);
		}
		$criteria->compare('LOWER(rekeningkredit1_kode)',strtolower($this->rekeningkredit1_kode),true);
		$criteria->compare('LOWER(rekeningkredit1_nama)',strtolower($this->rekeningkredit1_nama),true);
		if(!empty($this->rekeningkredit2_id)){
			$criteria->addCondition('rekeningkredit2_id = '.$this->rekeningkredit2_id);
		}
		$criteria->compare('LOWER(rekeningkredit2_kode)',strtolower($this->rekeningkredit2_kode),true);
		$criteria->compare('LOWER(rekeningkredit2_nama)',strtolower($this->rekeningkredit2_nama),true);
		if(!empty($this->rekeningkredit3_id)){
			$criteria->addCondition('rekeningkredit3_id = '.$this->rekeningkredit3_id);
		}
		$criteria->compare('LOWER(rekeningkredit3_kode)',strtolower($this->rekeningkredit3_kode),true);
		$criteria->compare('LOWER(rekeningkredit3_nama)',strtolower($this->rekeningkredit3_nama),true);
		if(!empty($this->rekeningkredit4_id)){
			$criteria->addCondition('rekeningkredit4_id = '.$this->rekeningkredit4_id);
		}
		$criteria->compare('LOWER(rekeningkredit4_kode)',strtolower($this->rekeningkredit4_kode),true);
		$criteria->compare('LOWER(rekeningkredit4_nama)',strtolower($this->rekeningkredit4_nama),true);
		if(!empty($this->rekeningkredit5_id)){
			$criteria->addCondition('rekeningkredit5_id = '.$this->rekeningkredit5_id);
		}
		$criteria->compare('LOWER(rekeningkredit5_kode)',strtolower($this->rekeningkredit5_kode),true);
		$criteria->compare('LOWER(rekeningkredit5_nama)',strtolower($this->rekeningkredit5_nama),true);
		$criteria->compare('saldokredit',$this->saldokredit);

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