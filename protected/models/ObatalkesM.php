<?php

/**
 * This is the model class for table "obatalkes_m".
 *
 * The followings are the available columns in table 'obatalkes_m':
 * @property integer $obatalkes_id
 * @property integer $jenisobatalkes_id
 * @property integer $sumberdana_id
 * @property integer $lokasigudang_id
 * @property integer $satuankecil_id
 * @property integer $satuanbesar_id
 * @property integer $subjenis_id
 * @property integer $generik_id
 * @property string $obatalkes_barcode
 * @property string $obatalkes_kode
 * @property string $obatalkes_nama
 * @property string $obatalkes_namalain
 * @property string $obatalkes_golongan
 * @property string $obatalkes_kategori
 * @property string $obatalkes_kadarobat
 * @property integer $kemasanbesar
 * @property integer $kekuatan
 * @property string $satuankekuatan
 * @property double $ppn_persen
 * @property double $harganetto
 * @property double $hargajual
 * @property double $hargamaksimum
 * @property double $hargaminimum
 * @property double $hargaaverage
 * @property double $margin
 * @property double $gp_persen
 * @property double $discount
 * @property string $tglkadaluarsa
 * @property integer $minimalstok
 * @property string $formularium
 * @property boolean $discountinue
 * @property string $image_obat
 * @property string $activedate
 * @property boolean $mintransaksi
 * @property boolean $obatalkes_aktif
 * @property boolean $obatalkes_farmasi
 * @property string $noregister
 * @property string $nobatch
 * @property double $marginresep
 * @property double $jasadokter
 * @property double $hjaresep
 * @property double $marginnonresep
 * @property double $hjanonresep
 * @property double $hpp
 * @property string $jnskelompok
 * @property string $ven
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 * @property integer $pabrik_id
 * @property integer $atc_id
 * @property integer $maksimalstok
 * @property integer $urutan_ven
 *
 * The followings are the available model relations:
 * @property GenerikM $generik
 * @property JenisobatalkesM $jenisobatalkes
 * @property LokasigudangM $lokasigudang
 * @property SatuanbesarM $satuanbesar
 * @property SatuankecilM $satuankecil
 * @property SubjenisM $subjenis
 * @property SumberdanaM $sumberdana
 * @property AtcM $atc
 * @property PabrikM $pabrik
 * @property StokobatalkesT[] $stokobatalkesTs
 * @property TerimamutasidetailT[] $terimamutasidetailTs
 * @property ObatalkespasienT[] $obatalkespasienTs
 * @property PenerimaandetailT[] $penerimaandetailTs
 * @property PemusnahanoadetailT[] $pemusnahanoadetailTs
 * @property ResepturdetailT[] $resepturdetailTs
 * @property StokopnamedetT[] $stokopnamedetTs
 * @property FormstokopnameR[] $formstokopnameRs
 * @property UbahhargaobatR[] $ubahhargaobatRs
 * @property ReturdetailT[] $returdetailTs
 * @property ProduksiobatdetT[] $produksiobatdetTs
 * @property DiagnosaM[] $diagnosaMs
 * @property UnitdosisdetailT[] $unitdosisdetailTs
 * @property RencdetailkebT[] $rencdetailkebTs
 * @property PesanoadetailT[] $pesanoadetailTs
 * @property PermintaandetailT[] $permintaandetailTs
 * @property PenawarandetailT[] $penawarandetailTs
 * @property PaketbmhpM[] $paketbmhpMs
 * @property ObatsupplierM[] $obatsupplierMs
 * @property ObatalkesdetailM[] $obatalkesdetailMs
 * @property ObatalkesproduksiM[] $obatalkesproduksiMs
 * @property PermohonanoadetailT[] $permohonanoadetailTs
 * @property JeniskasuspenyakitM[] $jeniskasuspenyakitMs
 * @property OasudahbayarT[] $oasudahbayarTs
 * @property MutasioadetailT[] $mutasioadetailTs
 * @property FakturdetailT[] $fakturdetailTs
 */
ini_set('memory_limit', '512M'); //Raise to 512 MB

class ObatalkesM extends CActiveRecord
{
	public $satuankecilNama;
	public $satuankecil_nama,$satuanbesar_nama;
	public $sumberdanaNama;
	public $satuanbesarNama;
	public $generikNama;
	public $generik_nama;
	public $pbfNama;
	public $default;
	public $lokasigudangNama;
	public $obatalkes_nama;
	public $therapiobatNama;
	public $formObatAlkesDetail = false;
	public $tglkadaluarsa_akhir, $tglkadaluarsa_awal,$obatAlkes,$sumberdana_id,$signa,$signa_obatalkes;
	public $isobatruangan = false;

        public $instalasi_id, $ruangan_id, $jmlstok, $jenisobatalkes_nama;
		public $obat_prb;

	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ObatalkesM the static model class
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
		return 'obatalkes_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('sumberdana_id, satuankecil_id,  satuanbesar_id, obatalkes_kode, obatalkes_nama, ppn_persen, harganetto, hargajual, hargamaksimum, hargaminimum, hargaaverage, discount', 'required'),
			array('jenisobatalkes_id, sumberdana_id, lokasigudang_id, satuankecil_id, satuanbesar_id, subjenis_id, generik_id, kemasanbesar, minimalstok, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, pabrik_id, atc_id, maksimalstok, urutan_ven, pegawaipenghapusankemenkes, pegawaipengirimkemenkes, pegawaiubahpengirimankemenkes', 'numerical', 'integerOnly'=>true),
			array('ppn_persen, harganetto, hargajual, hargamaksimum, hargaminimum, hargaaverage, margin, gp_persen, discount, marginresep, jasadokter, hjaresep, marginnonresep, hjanonresep, hpp, het', 'numerical'),
			array('obatalkes_barcode, obatalkes_kode, obatalkes_nama, image_obat, obatalkes_namalain', 'length', 'max'=>200),
			array('obatalkes_golongan, obatalkes_kategori, formularium, nobatch', 'length', 'max'=>50),
			array('obatalkes_kadarobat, satuankekuatan, jnskelompok, statuspengiriman', 'length', 'max'=>20),
			array('noregister', 'length', 'max'=>100),
			array('ven', 'length', 'max'=>1),
            array('satuanterkecil_id, kemasanterkecil, kekuatan, logpenghapusandatakemenkes', 'safe'),
			array('bentuk_obat, tglkadaluarsa, discountinue, activedate, mintransaksi, obatalkes_aktif, obatalkes_farmasi, create_time, update_time, tglpenghapusankemenkes, tglpengiriminkemenkes, tglubahpengirimankemenkes', 'safe'),
                        ['kodeobatbpjs_prb, namaobatbpjs_prb','safe'],
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('pemakaian,bentuk_obat, obatalkes_id, jenisobatalkes_id, sumberdana_id, lokasigudang_id, satuankecil_id, satuanbesar_id, subjenis_id, generik_id, obatalkes_barcode, obatalkes_kode, obatalkes_nama, obatalkes_namalain, obatalkes_golongan, obatalkes_kategori, obatalkes_kadarobat, kemasanbesar, kekuatan, satuankekuatan, ppn_persen, harganetto, hargajual, hargamaksimum, hargaminimum, hargaaverage, margin, gp_persen, discount, tglkadaluarsa, minimalstok, formularium, discountinue, image_obat, activedate, mintransaksi, obatalkes_aktif, obatalkes_farmasi, noregister, nobatch, marginresep, jasadokter, hjaresep, marginnonresep, hjanonresep, hpp, jnskelompok, ven, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, pabrik_id, atc_id, maksimalstok, urutan_ven, is_nobatch_tglkadaluarsa, signa_obatalkes, het, , tglpenghapusankemenkes, tglpengiriminkemenkes, tglubahpengirimankemenkes, pegawaipenghapusankemenkes, pegawaipengirimkemenkes, pegawaiubahpengirimankemenkes, logpenghapusandatakemenkes, statuspengiriman', 'safe', 'on'=>'search'),
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
			'generik' => array(self::BELONGS_TO, 'GenerikM', 'generik_id'),
			'jenisobatalkes' => array(self::BELONGS_TO, 'JenisobatalkesM', 'jenisobatalkes_id'),
			'lokasigudang' => array(self::BELONGS_TO, 'LokasigudangM', 'lokasigudang_id'),
			'satuanbesar' => array(self::BELONGS_TO, 'SatuanbesarM', 'satuanbesar_id'),
			'satuankecil' => array(self::BELONGS_TO, 'SatuankecilM', 'satuankecil_id'),
			'subjenis' => array(self::BELONGS_TO, 'SubjenisM', 'subjenis_id'),
			'sumberdana' => array(self::BELONGS_TO, 'SumberdanaM', 'sumberdana_id'),
			'atc' => array(self::BELONGS_TO, 'AtcM', 'atc_id'),
			'pabrik' => array(self::BELONGS_TO, 'PabrikM', 'pabrik_id'),
			'stokobatalkesTs' => array(self::HAS_MANY, 'StokobatalkesT', 'obatalkes_id'),
			'terimamutasidetailTs' => array(self::HAS_MANY, 'TerimamutasidetailT', 'obatalkes_id'),
			'obatalkespasienTs' => array(self::HAS_MANY, 'ObatalkespasienT', 'obatalkes_id'),
			'penerimaandetailTs' => array(self::HAS_MANY, 'PenerimaandetailT', 'obatalkes_id'),
			'pemusnahanoadetailTs' => array(self::HAS_MANY, 'PemusnahanoadetailT', 'obatalkes_id'),
			'resepturdetailTs' => array(self::HAS_MANY, 'ResepturdetailT', 'obatalkes_id'),
			'stokopnamedetTs' => array(self::HAS_MANY, 'StokopnamedetT', 'obatalkes_id'),
			'formstokopnameRs' => array(self::HAS_MANY, 'FormstokopnameR', 'obatalkes_id'),
			'ubahhargaobatRs' => array(self::HAS_MANY, 'UbahhargaobatR', 'obatalkes_id'),
			'returdetailTs' => array(self::HAS_MANY, 'ReturdetailT', 'obatalkes_id'),
			'produksiobatdetTs' => array(self::HAS_MANY, 'ProduksiobatdetT', 'obatalkes_id'),
			'diagnosaMs' => array(self::MANY_MANY, 'DiagnosaM', 'diagnosaobat_m(obatalkes_id, diagnosa_id)'),
			'unitdosisdetailTs' => array(self::HAS_MANY, 'UnitdosisdetailT', 'obatalkes_id'),
			'rencdetailkebTs' => array(self::HAS_MANY, 'RencdetailkebT', 'obatalkes_id'),
			'pesanoadetailTs' => array(self::HAS_MANY, 'PesanoadetailT', 'obatalkes_id'),
			'permintaandetailTs' => array(self::HAS_MANY, 'PermintaandetailT', 'obatalkes_id'),
			'penawarandetailTs' => array(self::HAS_MANY, 'PenawarandetailT', 'obatalkes_id'),
			'paketbmhpMs' => array(self::HAS_MANY, 'PaketbmhpM', 'obatalkes_id'),
			'obatsupplierMs' => array(self::HAS_MANY, 'ObatsupplierM', 'obatalkes_id'),
			'obatalkesdetailMs' => array(self::HAS_MANY, 'ObatalkesdetailM', 'obatalkes_id'),
			'obatalkesproduksiMs' => array(self::HAS_MANY, 'ObatalkesproduksiM', 'obatalkes_id'),
			'permohonanoadetailTs' => array(self::HAS_MANY, 'PermohonanoadetailT', 'obatalkes_id'),
			'jeniskasuspenyakitMs' => array(self::MANY_MANY, 'JeniskasuspenyakitM', 'kasuspenyakitobat_m(obatalkes_id, jeniskasuspenyakit_id)'),
			'oasudahbayarTs' => array(self::HAS_MANY, 'OasudahbayarT', 'obatalkes_id'),
			'mutasioadetailTs' => array(self::HAS_MANY, 'MutasioadetailT', 'obatalkes_id'),
			'fakturdetailTs' => array(self::HAS_MANY, 'FakturdetailT', 'obatalkes_id'),
            'satuanterkecil' => array(self::BELONGS_TO, 'SatuankecilM', 'satuanterkecil_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'obatalkes_id' => 'ID',
			'jenisobatalkes_id' => 'Jenis Obat dan Alkes',
			'sumberdana_id' => 'Sumber Dana',
			'lokasigudang_id' => 'Lokasi Gudang',
			'satuankecil_id' => 'Satuan Kecil',
			'satuanbesar_id' => 'Satuan Besar',
			'subjenis_id' => 'Sub Jenis',
			'generik_id' => 'Generik',
			'obatalkes_barcode' => 'Barcode Obat dan Alkes',
			'obatalkes_kode' => 'Kode',
			'obatalkes_nama' => 'Nama Obat dan Alkes',
			'obatalkes_namalain' => 'Nama Lain Obat dan Alkes',
			'obatalkes_golongan' => 'Golongan',
			'obatalkes_kategori' => 'Kategori',
			'obatalkes_kadarobat' => 'Kadar Obat',
			'kemasanbesar' => 'Kemasan Besar',
			'kekuatan' => 'Kekuatan',
			'satuankekuatan' => 'Satuan Kekuatan',
			'ppn_persen' => 'PPN',
			'harganetto' => 'Harga Netto',
			'hargajual' => 'Harga Jual',
			'hargamaksimum' => 'Harga Maksimum',
			'hargaminimum' => 'Harga Minimum',
			'hargaaverage' => 'Harga Average',
			'margin' => 'Margin',
			'gp_persen' => 'Gp Persen',
			'discount' => 'Keringanan',
			'tglkadaluarsa' => 'Tanggal Kedaluwarsa',
			'minimalstok' => 'Stok Minimal',
			'formularium' => 'Formularium',
			'discountinue' => 'Discountinue',
			'image_obat' => 'Gambar Obat',
			'activedate' => 'Active Date',
			'mintransaksi' => 'Minimal Transaksi',
			'obatalkes_aktif' => 'Obat dan Alkes Aktif',
			'obatalkes_farmasi' => 'Obat dan Alkes Farmasi',
			'noregister' => 'No. Register',
			'nobatch' => 'No. Batch',
			'marginresep' => 'Margin Resep',
			'jasadokter' => 'Jasa Dokter',
			'hjaresep' => 'HJA Resep',
			'marginnonresep' => 'Margin Non Resep',
			'hjanonresep' => 'HJA Non Resep',
			'hpp' => 'HPP',
			'jnskelompok' => 'Jenis Kelompok',
			'ven' => 'VEN',
			'create_time' => 'Waktu Create',
			'update_time' => 'Waktu Update',
			'create_loginpemakai_id' => 'Create Login Pemakai',
			'update_loginpemakai_id' => 'Update Login Pemakai',
			'create_ruangan' => 'Create Ruangan',
			'pabrik_id' => 'Pabrik',
			'atc_id' => 'ATC',
			'maksimalstok' => 'Stok Maksimal',
			'urutan_ven'=>'Urutan VEN',
			'signa'=>'Signa Obat',
                        'signa_obatalkes'=>'Signa Obat Alkes',
                        'jenisobatalkes_nama'=>'Jenis Obat Alkes',
            'satuanterkecil_id' => 'Satuan Terkecil',
            'kemasanterkecil' => 'Kemasan Terkecil',
            //'hargajualnonrj' => 'Harga Jual RI/RD/VK/Intensif',  
			'pemakaian' => 'Pemakaian'                  
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

		$criteria->with = array('sumberdana','satuankecil','satuanbesar','lokasigudang');

		if(!empty($this->obatalkes_id)){
			$criteria->addCondition('obatalkes_id = '.$this->obatalkes_id);
		}
		if(!empty($this->jenisobatalkes_id)){
			$criteria->addCondition('jenisobatalkes_id = '.$this->jenisobatalkes_id);
                }else{
                      if(Yii::app()->session['modul_id'] == 87) {//modul strerilisasi
                        $this->jenisobatalkes_id = 1; // 1 -> ALKES
                        $criteria->addCondition('jenisobatalkes_id = '.$this->jenisobatalkes_id);
                        }
                }
		if(!empty($this->sumberdana_id)){
			$criteria->addCondition('t.sumberdana_id = '.$this->sumberdana_id);
		}
		if(!empty($this->lokasigudang_id)){
			$criteria->addCondition('t.lokasigudang_id = '.$this->lokasigudang_id);
		}
		if(!empty($this->satuankecil_id)){
			$criteria->addCondition('t.satuankecil_id = '.$this->satuankecil_id);
		}
		if(!empty($this->satuanbesar_id)){
			$criteria->addCondition('t.satuanbesar_id = '.$this->satuanbesar_id);
		}
		if(!empty($this->subjenis_id)){
			$criteria->addCondition('subjenis_id = '.$this->subjenis_id);
		}
		if(!empty($this->generik_id)){
			$criteria->addCondition('generik_id = '.$this->generik_id);
		}
		$criteria->compare('LOWER(obatalkes_barcode)',strtolower($this->obatalkes_barcode),true);
		$criteria->compare('LOWER(obatalkes_kode)',strtolower($this->obatalkes_kode),true);
		$criteria->compare('LOWER(obatalkes_nama)',strtolower($this->obatalkes_nama),true);
		$criteria->compare('LOWER(obatalkes_namalain)',strtolower($this->obatalkes_namalain),true);
		$criteria->compare('LOWER(obatalkes_golongan)',strtolower($this->obatalkes_golongan),true);
		$criteria->compare('LOWER(obatalkes_kategori)',strtolower($this->obatalkes_kategori),true);
		$criteria->compare('LOWER(obatalkes_kadarobat)',strtolower($this->obatalkes_kadarobat),true);
		if(!empty($this->kemasanbesar)){
			$criteria->addCondition('kemasanbesar = '.$this->kemasanbesar);
		}
		if(!empty($this->kekuatan)){
			$criteria->addCondition('kekuatan = '.$this->kekuatan);
		}
		$criteria->compare('LOWER(satuankekuatan)',strtolower($this->satuankekuatan),true);
		$criteria->compare('ppn_persen',$this->ppn_persen);
		$criteria->compare('harganetto',$this->harganetto);
		$criteria->compare('hargajual',$this->hargajual);
		$criteria->compare('hargamaksimum',$this->hargamaksimum);
		$criteria->compare('hargaminimum',$this->hargaminimum);
		$criteria->compare('hargaaverage',$this->hargaaverage);
		$criteria->compare('margin',$this->margin);
		$criteria->compare('gp_persen',$this->gp_persen);
		$criteria->compare('discount',$this->discount);
		$criteria->compare('LOWER(tglkadaluarsa)',strtolower($this->tglkadaluarsa),true);
		if(!empty($this->minimalstok)){
			$criteria->addCondition('minimalstok = '.$this->minimalstok);
		}
		$criteria->compare('LOWER(formularium)',strtolower($this->formularium),true);
		$criteria->compare('discountinue',$this->discountinue);
		$criteria->compare('LOWER(image_obat)',strtolower($this->image_obat),true);
		$criteria->compare('LOWER(activedate)',strtolower($this->activedate),true);
		$criteria->compare('mintransaksi',$this->mintransaksi);
		$criteria->compare('obatalkes_aktif',isset($this->obatalkes_aktif)?$this->obatalkes_aktif:true);
		$criteria->compare('obatalkes_farmasi',$this->obatalkes_farmasi);
		$criteria->compare('LOWER(noregister)',strtolower($this->noregister),true);
		$criteria->compare('LOWER(nobatch)',strtolower($this->nobatch),true);
		$criteria->compare('marginresep',$this->marginresep);
		$criteria->compare('jasadokter',$this->jasadokter);
		$criteria->compare('hjaresep',$this->hjaresep);
		$criteria->compare('marginnonresep',$this->marginnonresep);
		$criteria->compare('hjanonresep',$this->hjanonresep);
		$criteria->compare('hpp',$this->hpp);
		$criteria->compare('LOWER(jnskelompok)',strtolower($this->jnskelompok),true);
		$criteria->compare('LOWER(ven)',strtolower($this->ven),true);
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
		if(!empty($this->pabrik_id)){
			$criteria->addCondition('pabrik_id = '.$this->pabrik_id);
		}
		if(!empty($this->atc_id)){
			$criteria->addCondition('atc_id = '.$this->atc_id);
		}
		if(!empty($this->maksimalstok)){
			$criteria->addCondition('maksimalstok = '.$this->maksimalstok);
		}
		if(!empty($this->urutan_ven)){
			$criteria->addCondition('urutan_ven = '.$this->urutan_ven);
		}
		$criteria->compare('LOWER(satuankecil.satuankecil_nama)',strtolower($this->satuankecilNama),true);
		$criteria->compare('LOWER(satuanbesar.satuanbesar_nama)',strtolower($this->satuanbesarNama),true);
		$criteria->compare('LOWER(sumberdana.sumberdana_nama)',strtolower($this->sumberdanaNama),true);
		$criteria->compare('LOWER(lokasigudang.lokasigudang_nama)',strtolower($this->lokasigudangNama),true);
		$criteria->compare('t.obatalkes_farmasi',$this->obatalkes_farmasi);
		$criteria->order='obatalkes_nama ASC';

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

		public function searchGudangFarmasi(){
			$criteria=$this->criteriaSearch();
            $criteria->limit=10;

            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
            ));
		}

		public function searchObatFarmasi(){

			$criteria=$this->criteriaSearch();
            $criteria->limit=10;

            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
            ));
		}

		public function getLokasiGudangItems()
        {
            return LokasigudangM::model()->findAll('lokasigudang_aktif=true ORDER BY lokasigudang_nama');

        }

        public function getTherapiObatItems()
        {
            return TherapiobatM::model()->findAll('therapiobat_aktif=true ORDER BY therapiobat_nama');
        }

        public function getPbfItems()
        {
            return PbfM::model()->findAll('pbf_aktif=true ORDER BY pbf_nama');
        }

        public function getGenerikItems()
        {
            return GenerikM::model()->findAll('generik_aktif=true ORDER BY generik_nama');
        }

        public function getSatuanBesarItems()
        {
            return SatuanbesarM::model()->findAll('satuanbesar_aktif=true ORDER BY satuanbesar_nama');
        }

        public function getSatuanKecilItems()
        {
            return SatuankecilM::model()->findAll('satuankecil_aktif=TRUE ORDER BY satuankecil_nama');
        }

        public function getJenisObatAlkesItems()
        {
            return JenisobatalkesM::model()->findAll('jenisobatalkes_aktif=TRUE ORDER BY jenisobatalkes_nama');
        }

         public function getSumberDanaItems()
        {
            return SumberdanaM::model()->findAll('sumberdana_aktif=TRUE ORDER BY sumberdana_nama');
        }

        public function showKomposisi($detailObat)
        {
            //$tmp = '<div class="raw">';
            $tmp = '';
            foreach ($detailObat as $obat) {
                $tmp = $tmp.$obat->komposisi.'';
            }
            //$tmp = $tmp.'</div>';
            return $tmp;

        }
        public function getKadaluarsa(){ //menampilkan status kedaluwarsa saat input obat pada transaksi: penjualan
            $format = new MyFormatter;
            $kadaluarsa = ((strtotime($format->formatDateTimeForDb($this->tglkadaluarsa)) - strtotime(date('Y-m-d'))) > 0) ? 0 : 1 ;
            return $kadaluarsa;
        }
        public function getStokObatRuangan(){ // menampilkan stok obat per ruangan login
            return StokobatalkesT::getJumlahStok($this->obatalkes_id,Yii::app()->user->getState('ruangan_id'));
        }
        public function getNamaSumberDana(){ // menampilkan sumber dana pada dialog box (grid)
            $sumberdana = SumberdanaM::model()->findByPk($this->sumberdana_id);
            return (!empty($sumberdana->sumberdana_nama)) ? $sumberdana->sumberdana_nama : "";
        }
        /**
         * getDiskonJual diskon dari stokobatalkes_t untuk :
         * 1. semua penjualan obat
         * 2. mutasi
         * 3. retur
         * @return type
         */
        public function getDiskonJual(){
            $diskon = 0;
            if(Yii::app()->user->getState('persdiskpasien') > 0){ //jika persdiskpasien di aktifkan
                //cari obat yang terakhir diterima
                $modStokObat = StokobatalkesT::model()->findAllByAttributes(array('obatalkes_id'=>$this->obatalkes_id), array('order'=>'tglstok_in DESC'));
                if(!empty($modStokObat[0]->obatalkes_id)){
                    $diskon = $modStokObat[0]->discount;
                }
            }
            return $diskon;
        }

        public function getSatuankecilNama(){
            return $this->satuankecil->satuankecil_nama;
        }

        public function searchObatAlkes(){
            $criteria = new CDbCriteria();
            $criteria->compare('LOWER(obatalkes_kode)', strtolower($this->obatalkes_kode),true);

             return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
            ));
        }

		public function getSatuanKecil(){
			return $this->satuankecil->satuankecil_nama;
		}

		public function getSatuanBesar(){
			return $this->satuanbesar->satuanbesar_nama;
		}

		 /**
         * menampilkan harga netto apotek
         * @return type
         */
        public function getJumHPP(){
            $hpp = $this->harganetto - ($this->harganetto * $this->discount / 100); //di persendiscount dan jmldiscount HARUS salahsatu
            if ($this->ppn_persen > 0){
                $hpp = ($hpp + ($hpp * ($this->ppn_persen/100)));
            }

            return $hpp;
        }

	public function searchDialogBHPRuangan()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
		$criteria->select = "t.obatalkes_id, t.obatalkes_nama, jenisobatalkes_m.jenisobatalkes_nama, satuankecil_m.satuankecil_nama, sum(stokobatalkes_t.qtystok_in - stokobatalkes_t.qtystok_out) AS jmlstok";	
		$criteria->group = "t.obatalkes_id, t.obatalkes_nama, jenisobatalkes_m.jenisobatalkes_nama, satuankecil_m.satuankecil_nama";
		$criteria->join = "JOIN sumberdana_m ON sumberdana_m.sumberdana_id = t.sumberdana_id 
						JOIN satuankecil_m ON satuankecil_m.satuankecil_id = t.satuankecil_id
						JOIN jenisobatalkes_m ON jenisobatalkes_m.jenisobatalkes_id = t.jenisobatalkes_id 
						JOIN stokobatalkes_t on stokobatalkes_t.obatalkes_id = t.obatalkes_id";

		$criteria->addCondition('stokobatalkes_t.ruangan_id = '.Yii::app()->user->getState('ruangan_id'));
		$criteria->addCondition('(stokobatalkes_t.qtystok_in - stokobatalkes_t.qtystok_out) > 0');
		$criteria->addCondition('jenisobatalkes_m.isbmhp = true');
		$criteria->compare('LOWER(obatalkes_nama)',strtolower($this->obatalkes_nama),true);
		$criteria->addCondition('obatalkes_aktif = TRUE');
		
		$criteria->order='obatalkes_nama ASC';
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}		
        
        public function searchObat(){
            $cri = new CDbCriteria();
            $cri->addCondition("obatalkes_aktif = TRUE");
            $cri->compare('LOWER(obatalkes_nama)', strtolower($this->obatalkes_nama), true);

            return new CActiveDataProvider($this, array(
                'criteria' => $cri,
            ));
        }

	public function searchPaketObat()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->with = array('sumberdana','satuankecil','satuanbesar','lokasigudang');

		if(!empty($this->obatalkes_id)){
			$criteria->addCondition('obatalkes_id = '.$this->obatalkes_id);
		}
		if(!empty($this->jenisobatalkes_id)){
			$criteria->addCondition('jenisobatalkes_id = '.$this->jenisobatalkes_id);
		}
		if(!empty($this->sumberdana_id)){
			$criteria->addCondition('t.sumberdana_id = '.$this->sumberdana_id);
		}
		if(!empty($this->lokasigudang_id)){
			$criteria->addCondition('t.lokasigudang_id = '.$this->lokasigudang_id);
		}
		if(!empty($this->satuankecil_id)){
			$criteria->addCondition('t.satuankecil_id = '.$this->satuankecil_id);
		}
		if(!empty($this->satuanbesar_id)){
			$criteria->addCondition('t.satuanbesar_id = '.$this->satuanbesar_id);
		}
		if(!empty($this->subjenis_id)){
			$criteria->addCondition('subjenis_id = '.$this->subjenis_id);
		}
		if(!empty($this->generik_id)){
			$criteria->addCondition('generik_id = '.$this->generik_id);
		}
		$criteria->compare('LOWER(obatalkes_barcode)',strtolower($this->obatalkes_barcode),true);
		$criteria->compare('LOWER(obatalkes_kode)',strtolower($this->obatalkes_kode),true);
		$criteria->compare('LOWER(obatalkes_nama)',strtolower($this->obatalkes_nama),true);
		$criteria->compare('LOWER(obatalkes_namalain)',strtolower($this->obatalkes_namalain),true);
		$criteria->compare('LOWER(obatalkes_golongan)',strtolower($this->obatalkes_golongan),true);
		$criteria->compare('LOWER(obatalkes_kategori)',strtolower($this->obatalkes_kategori),true);
		$criteria->compare('LOWER(obatalkes_kadarobat)',strtolower($this->obatalkes_kadarobat),true);
		if(!empty($this->kemasanbesar)){
			$criteria->addCondition('kemasanbesar = '.$this->kemasanbesar);
		}
		if(!empty($this->kekuatan)){
			$criteria->addCondition('kekuatan = '.$this->kekuatan);
		}
		$criteria->compare('LOWER(satuankekuatan)',strtolower($this->satuankekuatan),true);
		$criteria->compare('ppn_persen',$this->ppn_persen);
		$criteria->compare('harganetto',$this->harganetto);
		$criteria->compare('hargajual',$this->hargajual);
		$criteria->compare('hargamaksimum',$this->hargamaksimum);
		$criteria->compare('hargaminimum',$this->hargaminimum);
		$criteria->compare('hargaaverage',$this->hargaaverage);
		$criteria->compare('margin',$this->margin);
		$criteria->compare('gp_persen',$this->gp_persen);
		$criteria->compare('discount',$this->discount);
		$criteria->compare('LOWER(tglkadaluarsa)',strtolower($this->tglkadaluarsa),true);
		if(!empty($this->minimalstok)){
			$criteria->addCondition('minimalstok = '.$this->minimalstok);
		}
		$criteria->compare('LOWER(formularium)',strtolower($this->formularium),true);
		$criteria->compare('discountinue',$this->discountinue);
		$criteria->compare('LOWER(image_obat)',strtolower($this->image_obat),true);
		$criteria->compare('LOWER(activedate)',strtolower($this->activedate),true);
		$criteria->compare('mintransaksi',$this->mintransaksi);
		$criteria->compare('obatalkes_aktif',isset($this->obatalkes_aktif)?$this->obatalkes_aktif:true);
		$criteria->compare('obatalkes_farmasi',$this->obatalkes_farmasi);
		$criteria->compare('LOWER(noregister)',strtolower($this->noregister),true);
		$criteria->compare('LOWER(nobatch)',strtolower($this->nobatch),true);
		$criteria->compare('marginresep',$this->marginresep);
		$criteria->compare('jasadokter',$this->jasadokter);
		$criteria->compare('hjaresep',$this->hjaresep);
		$criteria->compare('marginnonresep',$this->marginnonresep);
		$criteria->compare('hjanonresep',$this->hjanonresep);
		$criteria->compare('hpp',$this->hpp);
		$criteria->compare('LOWER(jnskelompok)',strtolower($this->jnskelompok),true);
		$criteria->compare('LOWER(ven)',strtolower($this->ven),true);
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
		if(!empty($this->pabrik_id)){
			$criteria->addCondition('pabrik_id = '.$this->pabrik_id);
		}
		if(!empty($this->atc_id)){
			$criteria->addCondition('atc_id = '.$this->atc_id);
		}
		if(!empty($this->maksimalstok)){
			$criteria->addCondition('maksimalstok = '.$this->maksimalstok);
		}
		if(!empty($this->urutan_ven)){
			$criteria->addCondition('urutan_ven = '.$this->urutan_ven);
		}
		$criteria->compare('LOWER(satuankecil.satuankecil_nama)',strtolower($this->satuankecilNama),true);
		$criteria->compare('LOWER(satuanbesar.satuanbesar_nama)',strtolower($this->satuanbesarNama),true);
		$criteria->compare('LOWER(sumberdana.sumberdana_nama)',strtolower($this->sumberdanaNama),true);
		$criteria->compare('LOWER(lokasigudang.lokasigudang_nama)',strtolower($this->lokasigudangNama),true);
		$criteria->compare('t.obatalkes_farmasi',$this->obatalkes_farmasi);
		$criteria->order='obatalkes_nama ASC';
		$criteria->limit=10;

		return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
		));
	}

	        
	public function searchDialogBHP()
	{
			// Warning: Please modify the following code to remove attributes that
			// should not be searched.

			$criteria=new CDbCriteria;
			$criteria->join = "JOIN sumberdana_m ON sumberdana_m.sumberdana_id = t.sumberdana_id 
											JOIN satuankecil_m ON satuankecil_m.satuankecil_id = t.satuankecil_id
											LEFT JOIN jenisobatalkes_m ON jenisobatalkes_m.jenisobatalkes_id = t.jenisobatalkes_id";
			$criteria->addCondition('jenisobatalkes_m.jenisobatalkes_aktif = TRUE');
			if (!empty($this->jenisobatalkes_id)){
					$criteria->addCondition("t.jenisobatalkes_id = '".$this->jenisobatalkes_id."' ");
			}
			$criteria->compare('LOWER(obatalkes_nama)',strtolower($this->obatalkes_nama),true);
			$criteria->addCondition('obatalkes_aktif = TRUE');
			
			if ($this->isobatruangan){                    
				$sql = Yii::app()->db->createCommand(" SELECT obatalkes_id, SUM(qtystokoa) as qtystokoa FROM infostokobatalkesruangan_v WHERE ruangan_id =  ".Yii::app()->user->getState('ruangan_id')." GROUP BY obatalkes_id ")->queryAll();            
				$oa_id = [];
				if (!empty($sql)){
					foreach($sql as $key => $val){                           
						$oa_id[$val['obatalkes_id']] = $val['obatalkes_id'];                            
					}
					$criteria->addInCondition(" obatalkes_id ", $oa_id);
				}else{
					$criteria->addCondition(" obatalkes_id IS NULL");
				}                    
			}
			
			$criteria->order='obatalkes_nama ASC';
			return new CActiveDataProvider($this, array(
					'criteria'=>$criteria,
			));
	}
			
	public static function getObatalkesItems() {
		return self::model()->findAll() ?? "-";
	}	
}
