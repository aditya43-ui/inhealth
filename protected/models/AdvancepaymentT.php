<?php

/**
 * This is the model class for table "advancepayment_t".
 *
 * The followings are the available columns in table 'advancepayment_t':
 * @property integer $advancepayment_id
 * @property string $jenistransaksi
 * @property string $tglpengajuan
 * @property string $nopengajuan
 * @property string $nodokumen
 * @property string $noanggaran
 * @property string $keterangan
 * @property integer $pegawai_id
 * @property string $nip
 * @property integer $jabatan_id
 * @property integer $pegawaipemeriksa_id
 * @property integer $pegawaimenyetujui_id
 * @property string $catatanpembayaran
 * @property double $jmlpembayaran
 * @property integer $tandabuktikeluar_id
 * @property integer $profilrs_id
 * @property integer $jurnalrekening_id
 *
 * The followings are the available model relations:
 * @property TandabuktikeluarT $tandabuktikeluar
 * @property ProfilrumahsakitM $profilrs
 * @property SettlementpaymentT[] $settlementpaymentTs
 */
class AdvancepaymentT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return AdvancepaymentT the static model class
	 */
	public $pegawai_nama,$nokaskeluar,$pegawaibatal_nama,$jabatan_nama,$pegawaipemeriksa_nama,$pegawaimenyetujui_nama;
	public $tgl_awal,$tgl_akhir,$nama_rumahsakit;
	public $tgl_awal2,$tgl_akhir2,$tglpengajuan2,$ceklis,$tglkaskeluar;
	public $statusadvancepayment,$statusbatal;
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'advancepayment_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('jenistransaksi,pegawaimenyetujui_id,nip,pegawaipemeriksa_id, tglpengajuan,nopengajuan, pegawai_id, jmlpembayaran,profilrs_id', 'required'),
			array('pegawai_id, jabatan_id, pegawaipemeriksa_id, pegawaimenyetujui_id, tandabuktikeluar_id, profilrs_id, jurnalrekening_id', 'numerical', 'integerOnly'=>true),
			array('jmlpembayaran', 'numerical'),
			array('jenistransaksi, nodokumen, noanggaran, nip', 'length', 'max'=>50),
			array('nopengajuan', 'length', 'max'=>100),
			array('tglpengajuan,tglbatal,pegawaibatal_id,alasanbatal, keterangan, catatanpembayaran', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('advancepayment_id, jenistransaksi, tglpengajuan, nopengajuan, nodokumen, noanggaran, keterangan, pegawai_id, nip, jabatan_id, pegawaipemeriksa_id, pegawaimenyetujui_id, catatanpembayaran, jmlpembayaran, tandabuktikeluar_id, profilrs_id, jurnalrekening_id', 'safe', 'on'=>'search'),
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
			'tandabuktikeluar' => array(self::BELONGS_TO, 'TandabuktikeluarT', 'tandabuktikeluar_id'),
			'profilrs' => array(self::BELONGS_TO, 'ProfilrumahsakitM', 'profilrs_id'),
			'pegawai' => array(self::BELONGS_TO, 'PegawaiM', 'pegawai_id'),
			'pegawaibatal' => array(self::BELONGS_TO, 'PegawaiM', 'pegawaibatal_id'),
			'pegawaipemeriksa' => array(self::BELONGS_TO, 'PegawaiM', 'pegawaipemeriksa_id'),
			'pegawaimenyetujui' => array(self::BELONGS_TO, 'PegawaiM', 'pegawaimenyetujui_id'),
			'settlementpaymentTs' => array(self::HAS_MANY, 'SettlementpaymentT', 'advancepayment_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'advancepayment_id' => 'Advancepayment',
			'jenistransaksi' => 'Jenis Transaksi',
			'tglpengajuan' => 'Tgl. Pengajuan',
			'nopengajuan' => 'No. Pengajuan',
			'nodokumen' => 'No. Dokumen',
			'noanggaran' => 'No. Anggaran',
			'keterangan' => 'Keterangan Pengajuan',
			'pegawai_id' => 'Pegawai',
			'nip' => 'NIP',
			'tglbatal' => 'Tgl.Pembatalan',
			'jabatan_id' => 'Jabatan',
			'pegawaipemeriksa_id' => 'Pegawai Pemeriksa',
			'pegawaimenyetujui_id' => 'Pegawai Menyetujui',
			'pegawaibatal_nama' => 'Pegawai Yang Membatalkan',
			'catatanpembayaran' => 'Catatan Pembayaran',
			'jmlpembayaran' => 'Jumlah Pembayaran',
			'tandabuktikeluar_id' => 'Tandabuktikeluar',
			'profilrs_id' => 'Klinik',
			'jurnalrekening_id' => 'Jurnalrekening',
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

		$criteria->compare('advancepayment_id',$this->advancepayment_id);
		$criteria->compare('jenistransaksi',$this->jenistransaksi,true);
		$criteria->compare('tglpengajuan',$this->tglpengajuan,true);
		$criteria->compare('nopengajuan',$this->nopengajuan,true);
		$criteria->compare('nodokumen',$this->nodokumen,true);
		$criteria->compare('noanggaran',$this->noanggaran,true);
		$criteria->compare('keterangan',$this->keterangan,true);
		$criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->compare('nip',$this->nip,true);
		$criteria->compare('jabatan_id',$this->jabatan_id);
		$criteria->compare('pegawaipemeriksa_id',$this->pegawaipemeriksa_id);
		$criteria->compare('pegawaimenyetujui_id',$this->pegawaimenyetujui_id);
		$criteria->compare('catatanpembayaran',$this->catatanpembayaran,true);
		$criteria->compare('jmlpembayaran',$this->jmlpembayaran);
		$criteria->compare('tandabuktikeluar_id',$this->tandabuktikeluar_id);
		$criteria->compare('profilrs_id',$this->profilrs_id);
		$criteria->compare('jurnalrekening_id',$this->jurnalrekening_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function searchInformasi()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
		// $criteria->addCondition('pegawaibatal_id IS NULL');
		$criteria->join ='JOIN tandabuktikeluar_t tb ON t.tandabuktikeluar_id = tb.tandabuktikeluar_id';
		// $criteria->
		$criteria->addBetweenCondition('DATE(t.tglpengajuan)', $this->tgl_awal, $this->tgl_akhir);

		if ($this->ceklis) {
			$criteria->addBetweenCondition('DATE(tb.tglkaskeluar)', $this->tgl_awal2, $this->tgl_akhir2);
		}

		$criteria->compare('advancepayment_id',$this->advancepayment_id);
		$criteria->compare('t.jenistransaksi',$this->jenistransaksi,true);
		// $criteria->compare('tglpengajuan',$this->tglpengajuan,true);
		$criteria->compare('t.nopengajuan',$this->nopengajuan,true);
		$criteria->compare('t.nodokumen',$this->nodokumen,true);
		$criteria->compare('t.noanggaran',$this->noanggaran,true);
		$criteria->compare('t.keterangan',$this->keterangan,true);
		$criteria->compare('tb.nokaskeluar',$this->nokaskeluar,true);

		if (!empty($this->statusadvancepayment)) {
			if ($this->statusadvancepayment == 'LUNAS') {
				$criteria->join ='JOIN settlementpayment_t s ON t.advancepayment_id = s.advancepayment_id';
				$criteria->addCondition('s.hutangrealisasi = 0');
				$criteria->addCondition('s.sisarealisasi = 0');
			}else{

			}
		}

		if (!empty($this->statusbatal)) {
			if ($this->statusbatal == 'SUDAH DIBATALKAN') {
				$criteria->addCondition('t.tglbatal IS NOT NULL');
			}
			if ($this->statusbatal == 'BELUM DIBATALKAN') {
				$criteria->addCondition('t.tglbatal IS NULL');
			}
		}
		// $criteria->compare('pegawai_id',$this->pegawai_id);
		// $criteria->compare('nip',$this->nip,true);
		// $criteria->compare('jabatan_id',$this->jabatan_id);
		// $criteria->compare('pegawaipemeriksa_id',$this->pegawaipemeriksa_id);
		// $criteria->compare('pegawaimenyetujui_id',$this->pegawaimenyetujui_id);
		// // $criteria->compare('catatanpembayaran',$this->catatanpembayaran,true);
		// $criteria->compare('jmlpembayaran',$this->jmlpembayaran);
		// $criteria->compare('tandabuktikeluar_id',$this->tandabuktikeluar_id);
		// $criteria->compare('profilrs_id',$this->profilrs_id);
		// $criteria->compare('jurnalrekening_id',$this->jurnalrekening_id);

		if (!empty($this->profilrs_id)) {
			if(is_array($this->profilrs_id)){
				$criteria->addInCondition('t.profilrs_id',$this->profilrs_id);
			}else{
				$criteria->addCondition('t.profilrs_id ='.$this->profilrs_id);
			}
		}
		$criteria->order = 't.tglpengajuan DESC';
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function searchPrint()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('advancepayment_id',$this->advancepayment_id);
		$criteria->compare('jenistransaksi',$this->jenistransaksi,true);
		$criteria->compare('tglpengajuan',$this->tglpengajuan,true);
		$criteria->compare('nopengajuan',$this->nopengajuan,true);
		$criteria->compare('nodokumen',$this->nodokumen,true);
		$criteria->compare('noanggaran',$this->noanggaran,true);
		$criteria->compare('keterangan',$this->keterangan,true);
		$criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->compare('nip',$this->nip,true);
		$criteria->compare('jabatan_id',$this->jabatan_id);
		$criteria->compare('pegawaipemeriksa_id',$this->pegawaipemeriksa_id);
		$criteria->compare('pegawaimenyetujui_id',$this->pegawaimenyetujui_id);
		$criteria->compare('catatanpembayaran',$this->catatanpembayaran,true);
		$criteria->compare('jmlpembayaran',$this->jmlpembayaran);
		$criteria->compare('tandabuktikeluar_id',$this->tandabuktikeluar_id);
		$criteria->compare('profilrs_id',$this->profilrs_id);
		$criteria->compare('jurnalrekening_id',$this->jurnalrekening_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

}
