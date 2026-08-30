<?php

/**
 * This is the model class for table "perintahpengiriman_t".
 * @author Aida Rahmawati <aidarhamawati@.com>
 * @package application.models
 * @category model
 * The followings are the available columns in table 'perintahpengiriman_t':
 * @property integer $perintahpengiriman_id
 * @property integer $suratperjanjiankerja_id
 * @property integer $persiapanpengadaan_id
 * @property string $perintahpengiriman_tanggal
 * @property string $perintahpengiriman_nomor
 * @property string $nomor_dokumen
 * @property string $nama_pekerjaan
 * @property integer $supplier_id
 * @property string $direktur_supplier
 * @property string $tanggal_awal
 * @property string $tanggal_akhir
 * @property integer $jangka_pelaksanaan
 * @property integer $pegppk_id
 * @property string $denda_keterangan
 * @property double $jumlah_harga
 * @property double $jumlah_pajak
 * @property double $pajak_persen
 * @property double $total_harga
 * @property double $total_dibulatkan
 * @property integer $konfigtemplatesurat_id
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 *
 * The followings are the available model relations:
 * @property PerintahpengirimandetT[] $perintahpengirimandetTs
 * @property KonfigtemplatesuratK $konfigtemplatesurat
 * @property SupplierM $supplier
 * @property PegawaiM $pegppk
 * @property PersiapanpengadaanT $persiapanpengadaan
 * @property SuratperjanjiankerjaT $suratperjanjiankerja
 */
class PerintahpengirimanT extends CActiveRecord
{   
        public $cek_spk, $nosuratperjanjiankerja, $tglsuratperjanjian, $pegppk_nama, $pegppk_nip, $pegppk_alamat, $total_kontrak, $total_spp_sebelumnya, $sisa_pembayaran,
               $direktursupplier, $alamat_supplier, $nama_supplier, $termin_jumlah, $termin_angka,$dasar; 
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PerintahpengirimanT the static model class
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
		return 'perintahpengiriman_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('konfigtemplatesurat_id, suratperjanjiankerja_id, perintahpengiriman_tanggal, perintahpengiriman_nomor, nama_pekerjaan, supplier_id, pegppk_id, jumlah_harga, jumlah_pajak, pajak_persen, total_harga, total_dibulatkan, create_time, create_loginpemakai_id, create_ruangan', 'required'),
			array('suratperjanjiankerja_id, persiapanpengadaan_id, supplier_id, jangka_pelaksanaan, pegppk_id, konfigtemplatesurat_id, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'numerical', 'integerOnly'=>true),
			array('jumlah_harga, jumlah_pajak, pajak_persen, total_harga, total_dibulatkan', 'numerical'),
			array('perintahpengiriman_nomor, nomor_dokumen', 'length', 'max'=>50),
			array('nama_pekerjaan', 'length', 'max'=>500),
			array('direktur_supplier', 'length', 'max'=>100),
			array('total_pembayaran, terminke, termin_persen, tanggal_awal, tanggal_akhir, denda_keterangan, update_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('perintahpengiriman_id, suratperjanjiankerja_id, persiapanpengadaan_id, perintahpengiriman_tanggal, perintahpengiriman_nomor, nomor_dokumen, nama_pekerjaan, supplier_id, direktur_supplier, tanggal_awal, tanggal_akhir, jangka_pelaksanaan, pegppk_id, denda_keterangan, jumlah_harga, jumlah_pajak, pajak_persen, total_harga, total_dibulatkan, konfigtemplatesurat_id, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
			'perintahpengirimandetTs' => array(self::HAS_MANY, 'PerintahpengirimandetT', 'perintahpengiriman_id'),
			'konfigtemplatesurat' => array(self::BELONGS_TO, 'KonfigtemplatesuratK', 'konfigtemplatesurat_id'),
			'supplier' => array(self::BELONGS_TO, 'SupplierM', 'supplier_id'),
			'pegppk' => array(self::BELONGS_TO, 'PegawaiM', 'pegppk_id'),
			'persiapanpengadaan' => array(self::BELONGS_TO, 'PersiapanpengadaanT', 'persiapanpengadaan_id'),
			'suratperjanjiankerja' => array(self::BELONGS_TO, 'SuratperjanjiankerjaT', 'suratperjanjiankerja_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'perintahpengiriman_id' => 'Perintahpengiriman',
			'suratperjanjiankerja_id' => 'Suratperjanjiankerja',
			'persiapanpengadaan_id' => 'Persiapanpengadaan',
			'perintahpengiriman_tanggal' => 'Perintahpengiriman Tanggal',
			'perintahpengiriman_nomor' => 'Nomor Transaksi',
			'nomor_dokumen' => 'Nomor Dokumen',
			'nama_pekerjaan' => 'Nama Pekerjaan',
			'supplier_id' => 'Supplier',
			'direktur_supplier' => 'Direktur Supplier',
			'tanggal_awal' => 'Tanggal Awal',
			'tanggal_akhir' => 'Tanggal Akhir',
			'jangka_pelaksanaan' => 'Jangka Pelaksanaan',
			'pegppk_id' => 'Pegppk',
			'denda_keterangan' => 'Denda Keterangan',
			'jumlah_harga' => 'Jumlah Harga',
			'jumlah_pajak' => 'Jumlah Pajak',
			'pajak_persen' => 'Pajak Persen',
			'total_harga' => 'Total Harga',
			'total_dibulatkan' => 'Total Dibulatkan',
			'konfigtemplatesurat_id' => 'Template Surat',
			'create_time' => 'Create Time',
			'update_time' => 'Update Time',
			'create_loginpemakai_id' => 'Create Loginpemakai',
			'update_loginpemakai_id' => 'Update Loginpemakai',
			'create_ruangan' => 'Create Ruangan',
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

		$criteria->compare('perintahpengiriman_id',$this->perintahpengiriman_id);
		$criteria->compare('suratperjanjiankerja_id',$this->suratperjanjiankerja_id);
		$criteria->compare('persiapanpengadaan_id',$this->persiapanpengadaan_id);
		$criteria->compare('perintahpengiriman_tanggal',$this->perintahpengiriman_tanggal,true);
		$criteria->compare('perintahpengiriman_nomor',$this->perintahpengiriman_nomor,true);
		$criteria->compare('nomor_dokumen',$this->nomor_dokumen,true);
		$criteria->compare('nama_pekerjaan',$this->nama_pekerjaan,true);
		$criteria->compare('supplier_id',$this->supplier_id);
		$criteria->compare('direktur_supplier',$this->direktur_supplier,true);
		$criteria->compare('tanggal_awal',$this->tanggal_awal,true);
		$criteria->compare('tanggal_akhir',$this->tanggal_akhir,true);
		$criteria->compare('jangka_pelaksanaan',$this->jangka_pelaksanaan);
		$criteria->compare('pegppk_id',$this->pegppk_id);
		$criteria->compare('denda_keterangan',$this->denda_keterangan,true);
		$criteria->compare('jumlah_harga',$this->jumlah_harga);
		$criteria->compare('jumlah_pajak',$this->jumlah_pajak);
		$criteria->compare('pajak_persen',$this->pajak_persen);
		$criteria->compare('total_harga',$this->total_harga);
		$criteria->compare('total_dibulatkan',$this->total_dibulatkan);
		$criteria->compare('konfigtemplatesurat_id',$this->konfigtemplatesurat_id);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('create_loginpemakai_id',$this->create_loginpemakai_id);
		$criteria->compare('update_loginpemakai_id',$this->update_loginpemakai_id);
		$criteria->compare('create_ruangan',$this->create_ruangan);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}