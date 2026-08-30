<?php

/**
 * This is the model class for table "obatalkespasien_t".
 *
 * The followings are the available columns in table 'obatalkespasien_t':
 *
 * @package application.models
 * @author M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
 * @version     2.0.0
 * @link    <http://piindonesia.co.id>
 * @property integer $obatalkespasien_id
 * @property integer $penjamin_id
 * @property integer $carabayar_id
 * @property integer $daftartindakan_id
 * @property integer $sumberdana_id
 * @property integer $pasienmasukpenunjang_id
 * @property integer $pasienanastesi_id
 * @property integer $pasien_id
 * @property integer $satuankecil_id
 * @property integer $ruangan_id
 * @property integer $tindakanpelayanan_id
 * @property integer $tipepaket_id
 * @property integer $obatalkes_id
 * @property integer $penjualanresep_id
 * @property integer $pegawai_id
 * @property integer $racikan_id
 * @property integer $pendaftaran_id
 * @property integer $kelaspelayanan_id
 * @property integer $shift_id
 * @property integer $pasienadmisi_id
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
 * @property string $create_ruanganj
 * @property integer $permohonanoadetail_id
 */
class ObatalkespasienT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ObatalkespasienT the static model class
	 */
        public $subtotal,$diskon,$totaltarifservice,$tarif_satuan,$discount_tindakan,$qty_tindakan,$tarifcyto_tindakan,$iurbiaya_tindakan,$tgl_tindakan;
        public $is_pilihoa;
        public $biayalain = 0;
        public $subtotaloa=0;

        public $tglAwal, $tglAkhir;
        public $no_pendaftaran, $no_rekam_medik, $nama_pasien;

        public $jenisobatalkes_id, $obatalkes_kategori, $obatalkes_golongan, $obatalkes_nama;
		public $penggunaan_oa, $persendiskon, $totalbiayaadministrasi;

        public $qty_stok, $stokobatalkes_id, $satuankecil_nama, $prefix_pendaftaran,$ppnpersen, $jmlselisihbpjs, $iurbiaya_temporary, $jmlbayar_oa;
		public $bmhpsearch, $jml_obat;
        /**
         * mengenerate fungsi yii cActiveRecord
         * @param type $className
         * @return type
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
		return 'obatalkespasien_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('penjamin_id, carabayar_id, sumberdana_id, pasien_id, ruangan_id, tipepaket_id, obatalkes_id, shift_id, tglpelayanan', 'required'),
			array('penjamin_id, carabayar_id, daftartindakan_id, sumberdana_id, pasienmasukpenunjang_id, pasienanastesi_id, pasien_id, satuankecil_id, ruangan_id, tindakanpelayanan_id, tipepaket_id, obatalkes_id, penjualanresep_id, pegawai_id, racikan_id, pendaftaran_id, kelaspelayanan_id, shift_id, pasienadmisi_id, rke, permohonanoadetail_id, pajak_id, persenppnjual, formulaobatkronis_id', 'numerical', 'integerOnly'=>true),
			// array('qty_oa, hargasatuan_oa, harganetto_oa, hargajual_oa, jmlexposerad, biayaservice, biayakonseling, jasadokterresep, biayakemasan, biayaadministrasi, tarifcyto, discount, subsidiasuransi, subsidipemerintah, subsidirs, iurbiaya, permintaan_oa, jmlkemasan_oa, kekuatan_oa, jumlahppn, persen_discount, qty_jual, total_embalase, jasapelayanan_farmasi', 'numerical'),
			array('qty_oa, hargasatuan_oa, harganetto_oa, hargajual_oa, jmlexposerad, biayaservice, biayakonseling, jasadokterresep, biayakemasan, biayaadministrasi, tarifcyto, discount, subsidiasuransi, subsidipemerintah, subsidirs, iurbiaya, jmlkemasan_oa, kekuatan_oa, jumlahppn, persen_discount, qty_jual, total_embalase, jasapelayanan_farmasi', 'numerical'),
			array('r, oa', 'length', 'max'=>2),
			array('satuankekuatan_oa, kontrasrad', 'length', 'max'=>20),
			array('signa_oa', 'length', 'max'=>30),
			array('etiket', 'length', 'max'=>100),
            array('pasienruangpulih_id, dosis_jml, carapemberian', 'safe'),
			array('therapiobat_id, penggunaan_oa, statusoa, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, discount, create_ruangan', 'safe'),
			array('keterangan', 'safe'),
            array('create_time','default','value'=>date( 'Y-m-d H:i:s'),'setOnEmpty'=>false,'on'=>'insert'),
            array('update_time','default','value'=>date( 'Y-m-d H:i:s'),'setOnEmpty'=>false,'on'=>'update,insert'),
            array('create_loginpemakai_id','default','value'=>Yii::app()->user->id,'on'=>'insert'),
            array('update_loginpemakai_id','default','value'=>Yii::app()->user->id,'on'=>'update,insert'),
            array('create_ruangan','default','value'=>Yii::app()->user->getState('ruangan_id'),'on'=>'insert'),
            array('qty_oa','cekStok','on'=>'retail'),
			array('ket_penggunaan, is_obatkronis','safe'),
			array('formulariumobat_id, is_permintaandosispecahan, permintaandosis_pembilang, permintaandosis_penyebut', 'safe'),

			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('obatalkespasien_id, is_pilihoa, penjamin_id, subtotal, diskon, totaltarifservice, carabayar_id, daftartindakan_id, sumberdana_id, pasienmasukpenunjang_id, pasienanastesi_id, pasien_id, satuankecil_id, ruangan_id, tindakanpelayanan_id, tipepaket_id, obatalkes_id, penjualanresep_id, pegawai_id, racikan_id, pendaftaran_id, kelaspelayanan_id, shift_id, pasienadmisi_id, tglpelayanan, r, rke, permintaan_oa, jmlkemasan_oa, kekuatan_oa, satuankekuatan_oa, qty_oa, hargasatuan_oa, signa_oa, harganetto_oa, hargajual_oa, etiket, jmlexposerad, kontrasrad, biayaservice, biayakonseling, jasadokterresep, biayakemasan, biayaadministrasi, tarifcyto, discount, subsidiasuransi, subsidipemerintah, subsidirs, iurbiaya, oa, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, permohonanoadetail_id, pajak_id, jumlahppn, persenppnjual, persen_discount, qty_jual, jasapelayanan_farmasi, is_obatkronis, formulaobatkronis_id, total_embalase', 'safe', 'on'=>'search'),
		);
	}

        /**
         * fungsi yang digenerate sesudah disimpan ke database
         */
        protected function afterSave() {
            parent::afterSave();

            if (!empty($this->pendaftaran)) $this->checkSudahbayar();
        }

        /**
         * cek status pembayaran
         */
        function checkSudahBayar() {
            $pendaftaran = PendaftaranT::model()->findByPk($this->pendaftaran_id);

            $adm = PasienadmisiT::model()->findByAttributes(array('pendaftaran_id'=>$pendaftaran->pendaftaran_id));

            if ($this->cekTindakanOa()) {
                // echo $this->pendaftaran_id; die;
                PendaftaranT::model()->updateByPk($this->pendaftaran_id, array(
                    'pembayaranpelayanan_id'=>null,
                ));
                if (!empty($adm)) {
                    PasienadmisiT::model()->updateByPk($adm->pasienadmisi_id, array(
                        'pembayaranpelayanan_id'=>null,
                    ));
                }
            }
        }

        /**
         * cek tindakan oa
         * @return type
         */
        function cekTindakanOa() {
            $tindakan = TindakanpelayananT::model()->findAllByAttributes(array(
                'pendaftaran_id'=>$this->pendaftaran_id,
            ), array(
                'condition'=>'tindakansudahbayar_id is null',
            ));

            $oa = self::model()->findAllByAttributes(array(
                'pendaftaran_id'=>$this->pendaftaran_id,
            ), array(
                'condition'=>'oasudahbayar_id is null',
            ));

            return (count((array)$tindakan) + count((array)$oa)) > 0;
        }

        public function cekStok(){
            if (!$this->hasErrors()){
                $stok = StokobatalkesT::getJumlahStok($this->obatalkes_id);
//                if ($stok < 0){
//                    $this->addError('qty', 'Stok Barang tidak ada' );
//                }
//                if ($this->qty_oa > $stok){
//                    $this->addError('qty_oa', 'Barang tidak boleh lebih dari '.$stok);
//                }

                if ($this->discount > $this->hargajual_oa){
                    $this->addError('discount', 'Discount tidak boleh lebih besar dari '.$this->hargajual_oa);
                }
                // di comment tgl 1 April 2013 //
                if ($this->qty_oa <= 0){
                    $this->addError('qty_oa', 'Quantity tidak boleh kurang dari 1');
                }

                // end dicomment //
            }
        }

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
                    'ruangan'=>array(self::BELONGS_TO,'RuanganM','ruangan_id'),
                    'obatalkes'=>array(self::BELONGS_TO, 'ObatalkesM', 'obatalkes_id'),
                    'satuankecil'=>array(self::BELONGS_TO, 'SatuankecilM', 'satuankecil_id'),
                    'daftartindakan'=>array(self::BELONGS_TO, 'DaftartindakanM', 'daftartindakan_id'),
                    'tindakanpelayanan'=>array(self::BELONGS_TO, 'TindakanpelayananT', 'tindakanpelayanan_id'),
                    'penjualanresep'=>array(self::BELONGS_TO, 'PenjualanresepT', 'penjualanresep_id'), //untuk handling relasi dengan penjualan resep
                    'oasudahbayar'=>array(self::BELONGS_TO, 'OasudahbayarT', 'oasudahbayar_id'), // handling relasi dengan oasudahbayar
                    'pendaftaran'=>array(self::BELONGS_TO, 'PendaftaranT','pendaftaran_id'),
                    'racikan'=>array(self::BELONGS_TO, 'RacikanM','racikan_id'),
                    'carabayar'=>array(self::BELONGS_TO, 'CarabayarM', 'carabayar_id'),
                    'penjamin'=>array(self::BELONGS_TO, 'PenjaminpasienM', 'penjamin_id'),
                    'pegawai'=>array(self::BELONGS_TO, 'PegawaiM', 'pegawai_id'),
                    'obatTriage'=>array(self::BELONGS_TO, 'PengambilanobatTriageT', 'pengambilanobat_triage_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'obatalkespasien_id' => 'Obatalkespasien',
			'penjamin_id' => 'Penjamin',
			'carabayar_id' => 'Jenis Penjamin',
			'daftartindakan_id' => 'Daftartindakan',
			'sumberdana_id' => 'Sumberdana',
			'pasienmasukpenunjang_id' => 'Pasienmasukpenunjang',
			'pasienanastesi_id' => 'Pasienanastesi',
			'pasien_id' => 'Pasien',
			'satuankecil_id' => 'Satuankecil',
			'ruangan_id' => 'Ruangan',
			'tindakanpelayanan_id' => 'Tindakanpelayanan',
			'tipepaket_id' => 'Tipepaket',
			'obatalkes_id' => 'Obatalkes',
			'penjualanresep_id' => 'Penjualanresep',
			'pegawai_id' => 'Pegawai',
			'racikan_id' => 'Racikan',
			'pendaftaran_id' => 'Pendaftaran',
			'kelaspelayanan_id' => 'Kelaspelayanan',
			'shift_id' => 'Shift',
			'pasienadmisi_id' => 'Pasienadmisi',
			'tglpelayanan' => 'Tanggal Pelayanan',
			'r' => 'R',
			'rke' => 'Rke',
			'permintaan_oa' => 'Permintaan Oa',
			'jmlkemasan_oa' => 'Jmlkemasan Oa',
			'kekuatan_oa' => 'Kekuatan Oa',
			'satuankekuatan_oa' => 'Satuankekuatan Oa',
			'qty_oa' => 'Jumlah Oa',
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
                        'jenisobatalkes_id' => 'Jenis Obat',
                        'obatalkes_kategori' => 'Kategori Obat',
                        'obatalkes_golongan' => 'Golongan Obat',
                        'obatalkes_nama' => 'Nama Obat Alkes',
			'keterangan' => 'Keterangan',
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

		$criteria->compare('t.obatalkespasien_id',$this->obatalkespasien_id);
		$criteria->compare('t.penjamin_id',$this->penjamin_id);
		$criteria->compare('t.carabayar_id',$this->carabayar_id);
		$criteria->compare('t.daftartindakan_id',$this->daftartindakan_id);
		$criteria->compare('t.sumberdana_id',$this->sumberdana_id);
		$criteria->compare('t.pasienmasukpenunjang_id',$this->pasienmasukpenunjang_id);
		$criteria->compare('t.pasienanastesi_id',$this->pasienanastesi_id);
		$criteria->compare('t.pasien_id',$this->pasien_id);
		$criteria->compare('t.satuankecil_id',$this->satuankecil_id);
		$criteria->compare('t.ruangan_id',$this->ruangan_id);
		$criteria->compare('t.tindakanpelayanan_id',$this->tindakanpelayanan_id);
		$criteria->compare('t.tipepaket_id',$this->tipepaket_id);
		$criteria->compare('t.obatalkes_id',$this->obatalkes_id);
		$criteria->compare('t.penjualanresep_id',$this->penjualanresep_id);
		$criteria->compare('t.pegawai_id',$this->pegawai_id);
		$criteria->compare('t.racikan_id',$this->racikan_id);
		$criteria->compare('t.pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('t.kelaspelayanan_id',$this->kelaspelayanan_id);
		$criteria->compare('t.shift_id',$this->shift_id);
		$criteria->compare('t.pasienadmisi_id',$this->pasienadmisi_id);
		$criteria->compare('LOWER(t.tglpelayanan)',strtolower($this->tglpelayanan),true);
		$criteria->compare('LOWER(t.r)',strtolower($this->r),true);
		$criteria->compare('t.rke',$this->rke);
		$criteria->compare('t.permintaan_oa',$this->permintaan_oa);
		$criteria->compare('t.jmlkemasan_oa',$this->jmlkemasan_oa);
		$criteria->compare('t.kekuatan_oa',$this->kekuatan_oa);
		$criteria->compare('LOWER(t.satuankekuatan_oa)',strtolower($this->satuankekuatan_oa),true);
		$criteria->compare('t.qty_oa',$this->qty_oa);
		$criteria->compare('t.hargasatuan_oa',$this->hargasatuan_oa);
		$criteria->compare('LOWER(t.signa_oa)',strtolower($this->signa_oa),true);
		$criteria->compare('t.harganetto_oa',$this->harganetto_oa);
		$criteria->compare('t.hargajual_oa',$this->hargajual_oa);
		$criteria->compare('LOWER(t.etiket)',strtolower($this->etiket),true);
		$criteria->compare('t.jmlexposerad',$this->jmlexposerad);
		$criteria->compare('LOWER(t.kontrasrad)',strtolower($this->kontrasrad),true);
		$criteria->compare('t.biayaservice',$this->biayaservice);
		$criteria->compare('t.biayakonseling',$this->biayakonseling);
		$criteria->compare('t.jasadokterresep',$this->jasadokterresep);
		$criteria->compare('t.biayakemasan',$this->biayakemasan);
		$criteria->compare('t.biayaadministrasi',$this->biayaadministrasi);
		$criteria->compare('t.tarifcyto',$this->tarifcyto);
		$criteria->compare('t.discount',$this->discount);
		$criteria->compare('t.subsidiasuransi',$this->subsidiasuransi);
		$criteria->compare('t.subsidipemerintah',$this->subsidipemerintah);
		$criteria->compare('t.subsidirs',$this->subsidirs);
		$criteria->compare('t.iurbiaya',$this->iurbiaya);
		$criteria->compare('LOWER(t.oa)',strtolower($this->oa),true);
		$criteria->compare('(t.create_time)',($this->create_time));
		$criteria->compare('(t.update_time)',($this->update_time));
		$criteria->compare('(t.create_loginpemakai_id)',($this->create_loginpemakai_id));
		$criteria->compare('(t.update_loginpemakai_id)',($this->update_loginpemakai_id));
		$criteria->compare('(t.create_ruangan)',($this->create_ruangan));

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

        public function searchPemakaianBahan() {
            $provider = $this->search();
            $provider->criteria->join =
                    "join pendaftaran_t pendaftaran on pendaftaran.pendaftaran_id = t.pendaftaran_id "
                    . "join pasien_m pasien on pasien.pasien_id = t.pasien_id "
                    . "join obatalkes_m obatalkes on obatalkes.obatalkes_id = t.obatalkes_id ";
            if (!empty($this->tglAwal) && !empty($this->tglAkhir)) {
                $provider->criteria->addBetweenCondition('date(tglpelayanan)', $this->tglAwal, $this->tglAkhir);
            }
            $provider->criteria->addCondition('penjualanresep_id is null');
            $provider->criteria->compare('t.ruangan_id', Yii::app()->user->getState('ruangan_id'));

            $provider->criteria->compare('lower(pendaftaran.no_pendaftaran)', strtolower($this->prefix_pendaftaran.$this->no_pendaftaran), true);
            $provider->criteria->compare('lower(pasien.no_rekam_medik)', strtolower($this->no_rekam_medik), true);
            $provider->criteria->compare('lower(pasien.nama_pasien)', strtolower($this->nama_pasien), true);

            $provider->criteria->compare('t.carabayar_id', $this->carabayar_id);
            $provider->criteria->compare('t.penjamin_id', $this->penjamin_id);

            $provider->criteria->compare('obatalkes.jenisobatalkes_id', $this->jenisobatalkes_id);
            $provider->criteria->compare('lower(obatalkes.obatalkes_kategori)', strtolower($this->obatalkes_kategori));
            $provider->criteria->compare('lower(obatalkes.obatalkes_golongan)', strtolower($this->obatalkes_golongan));
            $provider->criteria->compare('lower(obatalkes.obatalkes_nama)', strtolower($this->obatalkes_nama), true);
            $provider->criteria->order = "t.tglpelayanan DESC";

            return $provider;
        }

        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		$criteria->compare('obatalkespasien_id',$this->obatalkespasien_id);
		$criteria->compare('penjamin_id',$this->penjamin_id);
		$criteria->compare('carabayar_id',$this->carabayar_id);
		$criteria->compare('daftartindakan_id',$this->daftartindakan_id);
		$criteria->compare('sumberdana_id',$this->sumberdana_id);
		$criteria->compare('pasienmasukpenunjang_id',$this->pasienmasukpenunjang_id);
		$criteria->compare('pasienanastesi_id',$this->pasienanastesi_id);
		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('satuankecil_id',$this->satuankecil_id);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('tindakanpelayanan_id',$this->tindakanpelayanan_id);
		$criteria->compare('tipepaket_id',$this->tipepaket_id);
		$criteria->compare('obatalkes_id',$this->obatalkes_id);
		$criteria->compare('penjualanresep_id',$this->penjualanresep_id);
		$criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->compare('racikan_id',$this->racikan_id);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('kelaspelayanan_id',$this->kelaspelayanan_id);
		$criteria->compare('shift_id',$this->shift_id);
		$criteria->compare('pasienadmisi_id',$this->pasienadmisi_id);
		$criteria->compare('LOWER(tglpelayanan)',strtolower($this->tglpelayanan),true);
		$criteria->compare('LOWER(r)',strtolower($this->r),true);
		$criteria->compare('rke',$this->rke);
		$criteria->compare('permintaan_oa',$this->permintaan_oa);
		$criteria->compare('jmlkemasan_oa',$this->jmlkemasan_oa);
		$criteria->compare('kekuatan_oa',$this->kekuatan_oa);
		$criteria->compare('LOWER(satuankekuatan_oa)',strtolower($this->satuankekuatan_oa),true);
		$criteria->compare('qty_oa',$this->qty_oa);
		$criteria->compare('hargasatuan_oa',$this->hargasatuan_oa);
		$criteria->compare('LOWER(signa_oa)',strtolower($this->signa_oa),true);
		$criteria->compare('harganetto_oa',$this->harganetto_oa);
		$criteria->compare('hargajual_oa',$this->hargajual_oa);
		$criteria->compare('LOWER(etiket)',strtolower($this->etiket),true);
		$criteria->compare('jmlexposerad',$this->jmlexposerad);
		$criteria->compare('LOWER(kontrasrad)',strtolower($this->kontrasrad),true);
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
		$criteria->compare('LOWER(oa)',strtolower($this->oa),true);
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
		$criteria->compare('LOWER(create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);
		$criteria->compare('LOWER(update_loginpemakai_id)',strtolower($this->update_loginpemakai_id),true);
		$criteria->compare('LOWER(create_ruangan)',strtolower($this->create_ruangan),true);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit
                $criteria->limit=-1;

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }

        protected function afterFind(){
            foreach($this->metadata->tableSchema->columns as $columnName => $column)
            {
                if (!strlen($this->$columnName)) continue;
                if ($column->dbType == 'date')
                {
                    $this->$columnName = Yii::app()->dateFormatter->formatDateTime(
                    CDateTimeParser::parse($this->$columnName, 'yyyy-MM-dd'),'medium',null);
                }elseif ($column->dbType == 'timestamp without time zone'){
                    $this->$columnName = Yii::app()->dateFormatter->formatDateTime(
                    CDateTimeParser::parse($this->$columnName, 'yyyy-MM-dd hh:mm:ss','medium',null));
                }
            }
            return true;
        }

        protected function beforeSave() {
            if (!$this->isNewRecord) return true;
            $oa = ObatalkesM::model()->findByPk($this->obatalkes_id);
            // $this->persenppnjual = $oa->ppn_persen;

            return true;
        }


        protected function beforeValidate ()
        {
            $format = new MyFormatter();
            foreach($this->metadata->tableSchema->columns as $columnName => $column)
            {
                if ($column->dbType == 'date')
                {
                    $this->$columnName = $format->formatDateTimeForDb($this->$columnName);
                }elseif ($column->dbType == 'timestamp without time zone'){
                    $this->$columnName = $format->formatDateTimeForDb($this->$columnName);
                }
            }
            return parent::beforeValidate();
        }
        //Jika gagal memanggil nama obat
        public function getInfoObat($id){
            $modObat = ObatalkesM::model()->findByPk($id);
            if(!empty($modObat->obatalkes_id)){
                return $modObat->obatalkes_kode." - ".$modObat->obatalkes_nama;
            }else{
                return "";
            }
        }

        public function getSubsidiPenjamin($attr, $float = false) {
            $pendaftaran = PendaftaranT::model()->findByPk($this->pendaftaran_id);
			$modTanggungan = null;

			if(!empty($pendaftaran)){
				$modAsuransipasien = AsuransipasienM::model()->findByPk($pendaftaran->asuransipasien_id);
				$kelaspelayanan_id = 6;

				if (!empty($this->kelastanggungan_id)) {
					$kelaspelayanan_id = $this->kelastanggungan_id;
				} else {
					if(empty($modAsuransipasien)){
						$kelaspelayanan_id = $this->kelaspelayanan_id;
					} else {
						$kelaspelayanan_id = $modAsuransipasien->kelastanggunganasuransi_id;
					}
				}

				// if (empty($this->kelaspelayanan_id)) $this->kelaspelayanan_id = 6;

				$penjamin = $pendaftaran->penjamin_id;
				if (!empty($pendaftaran->pasienadmisi_id)) {
					$admisi = PasienadmisiT::model()->findByPk($pendaftaran->pasienadmisi_id);
					$penjamin = $admisi->penjamin_id;
				}
				$modTanggungan = TanggunganpenjaminM::model()->findByAttributes(array('kelaspelayanan_id'=>$kelaspelayanan_id,'penjamin_id'=>$penjamin));
			}
            

            $res = 0;
            if (!empty($modTanggungan)){
            // if (!empty($modTanggungan) && !in_array($modTanggungan->carabayar_id, array(Params::CARABAYAR_ID_BPJS, Params::CARABAYAR_ID_BPJS_TENAGAKERJA))) {
                // if ($this->obatalkes_id == 180) {
                //     var_dump($this->hargasatuan_oa, $this->qty_oa, $modTanggungan[$attr]); die;
                // }


                $qty_oa = $this->qty_oa;
                if (!$float) {
                    $qty_oa = round($this->qty_oa);
                }


                $res = ($this->hargasatuan_oa * $qty_oa) * ($modTanggungan[$attr]/100);
                //var_dump($modTanggungan[$attr]); die;
            }
                // var_dump($res); die;


            return $res;
        }

		  public function searchDetailPemakaianBahan($data)
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		if(!empty($this->obatalkespasien_id)){
			$criteria->addCondition("obatalkespasien_id = ".$this->obatalkespasien_id);
		}
		if(!empty($this->penjamin_id)){
			$criteria->addCondition("penjamin_id = ".$this->penjamin_id);
		}
		if(!empty($this->carabayar_id)){
			$criteria->addCondition("carabayar_id = ".$this->carabayar_id);
		}
		if(!empty($this->daftartindakan_id)){
			$criteria->addCondition("daftartindakan_id = ".$this->daftartindakan_id);
		}
		if(!empty($this->sumberdana_id)){
			$criteria->addCondition("sumberdana_id = ".$this->sumberdana_id);
		}
		if(!empty($this->pasienmasukpenunjang_id)){
			$criteria->addCondition("pasienmasukpenunjang_id = ".$this->pasienmasukpenunjang_id);
		}
		if(!empty($this->pasienanastesi_id)){
			$criteria->addCondition("pasienanastesi_id = ".$this->pasienanastesi_id);
		}
		if(!empty($this->pasien_id)){
			$criteria->addCondition("pasien_id = ".$this->pasien_id);
		}
		if(!empty($this->satuankecil_id)){
			$criteria->addCondition("satuankecil_id = ".$this->satuankecil_id);
		}
		if(!empty($this->ruangan_id)){
			$criteria->addCondition("ruangan_id = ".$this->ruangan_id);
		}
		if(!empty($this->tindakanpelayanan_id)){
			$criteria->addCondition("tindakanpelayanan_id = ".$this->tindakanpelayanan_id);
		}
		if(!empty($this->tipepaket_id)){
			$criteria->addCondition("tipepaket_id = ".$this->tipepaket_id);
		}
		if(!empty($this->obatalkes_id)){
			$criteria->addCondition("obatalkes_id = ".$this->obatalkes_id);
		}
		if(!empty($this->penjualanresep_id)){
			$criteria->addCondition("penjualanresep_id = ".$this->penjualanresep_id);
		}
		if(!empty($this->pegawai_id)){
			$criteria->addCondition("pegawai_id = ".$this->pegawai_id);
		}
		if(!empty($this->racikan_id)){
			$criteria->addCondition("racikan_id = ".$this->racikan_id);
		}
		if(!empty($this->pendaftaran_id)){
			$criteria->addCondition("pendaftaran_id = ".$this->pendaftaran_id);
		}
		if(!empty($this->kelaspelayanan_id)){
			$criteria->addCondition("kelaspelayanan_id = ".$this->kelaspelayanan_id);
		}
		$criteria->addCondition('pendaftaran_id ='.$data);
		$criteria->addCondition('t.penjualanresep_id is Null'); //pemakaian bahan bukan obat dari penjualan resep
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function searchRiwayatBMHP() {
		$criteria=new CDbCriteria;

		$criteria->addCondition("oa = 'BM'");
		if(!empty($this->pendaftaran_id)){
			$criteria->addCondition('pendaftaran_id = '.$this->pendaftaran_id);
		}else{
			$criteria->addCondition('pendaftaran_id is null');
		}	

		

		// $provider->criteria->join =
		// 		"join pendaftaran_t pendaftaran on pendaftaran.pendaftaran_id = t.pendaftaran_id "
		// 		. "join pasien_m pasien on pasien.pasien_id = t.pasien_id "
		// 		. "join obatalkes_m obatalkes on obatalkes.obatalkes_id = t.obatalkes_id ";
		// if (!empty($this->tglAwal) && !empty($this->tglAkhir)) {
		// 	$provider->criteria->addBetweenCondition('date(tglpelayanan)', $this->tglAwal, $this->tglAkhir);
		// }
		// $provider->criteria->addCondition('penjualanresep_id is null');
		// $provider->criteria->compare('t.ruangan_id', Yii::app()->user->getState('ruangan_id'));

		// $provider->criteria->compare('lower(pendaftaran.no_pendaftaran)', strtolower($this->prefix_pendaftaran.$this->no_pendaftaran), true);
		// $provider->criteria->compare('lower(pasien.no_rekam_medik)', strtolower($this->no_rekam_medik), true);
		// $provider->criteria->compare('lower(pasien.nama_pasien)', strtolower($this->nama_pasien), true);

		// $provider->criteria->compare('t.carabayar_id', $this->carabayar_id);
		// $provider->criteria->compare('t.penjamin_id', $this->penjamin_id);

		// $provider->criteria->compare('obatalkes.jenisobatalkes_id', $this->jenisobatalkes_id);
		// $provider->criteria->compare('lower(obatalkes.obatalkes_kategori)', strtolower($this->obatalkes_kategori));
		// $provider->criteria->compare('lower(obatalkes.obatalkes_golongan)', strtolower($this->obatalkes_golongan));
		// $provider->criteria->compare('lower(obatalkes.obatalkes_nama)', strtolower($this->obatalkes_nama), true);
		// $provider->criteria->order = "t.tglpelayanan DESC";

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
