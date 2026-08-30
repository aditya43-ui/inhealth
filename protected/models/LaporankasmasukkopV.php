<?php

/**
 * This is the model class for table "laporankasmasukkop_v".
 *
 * The followings are the available columns in table 'laporankasmasukkop_v':
 * @property integer $buktikasmasukkop_id
 * @property integer $jenistransaksi_id
 * @property string $namatransaksi
 * @property string $tgl_kasmasuk
 * @property string $nobuktimasuk
 * @property string $darinama_bkm
 * @property string $alamat_bkm
 * @property string $sebagaipembayaran_bkm
 * @property double $jmlpembayaran
 * @property double $biayaadministrasi
 * @property double $biayamaterai
 * @property double $uangditerima
 * @property double $uangkembalian
 * @property string $keterangan_pembayaran
 * @property integer $preparedby
 * @property string $prepareddate
 * @property integer $reviewedby
 * @property string $revieweddate
 * @property integer $approvedby
 * @property string $approveddate
 */
class LaporankasmasukkopV extends CActiveRecord
{
        public $tgl_awal, $bln_awal, $thn_awal;
        public $tgl_akhir, $bln_akhir, $thn_akhir;
        public $jns_periode;
        
        
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return LaporankasmasukkopV the static model class
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
		return 'laporankasmasukkop_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('buktikasmasukkop_id, jenistransaksi_id, preparedby, reviewedby, approvedby', 'numerical', 'integerOnly'=>true),
			array('jmlpembayaran, biayaadministrasi, biayamaterai, uangditerima, uangkembalian', 'numerical'),
			array('namatransaksi', 'length', 'max'=>200),
			array('nobuktimasuk', 'length', 'max'=>50),
			array('darinama_bkm, sebagaipembayaran_bkm', 'length', 'max'=>100),
			array('tgl_kasmasuk, alamat_bkm, keterangan_pembayaran, prepareddate, revieweddate, approveddate', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('buktikasmasukkop_id, jenistransaksi_id, namatransaksi, tgl_kasmasuk, nobuktimasuk, darinama_bkm, alamat_bkm, sebagaipembayaran_bkm, jmlpembayaran, biayaadministrasi, biayamaterai, uangditerima, uangkembalian, keterangan_pembayaran, preparedby, prepareddate, reviewedby, revieweddate, approvedby, approveddate', 'safe', 'on'=>'search'),
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
			'buktikasmasukkop_id' => 'Buktikasmasukkop',
			'jenistransaksi_id' => 'Jenis Transaksi',
			'namatransaksi' => 'Nama Transaksi',
			'tgl_kasmasuk' => 'Tgl. Kasmasuk',
			'nobuktimasuk' => 'Nobuktimasuk',
			'darinama_bkm' => 'Darinama Bkm',
			'alamat_bkm' => 'Alamat Bkm',
			'sebagaipembayaran_bkm' => 'Sebagaipembayaran Bkm',
			'jmlpembayaran' => 'Jmlpembayaran',
			'biayaadministrasi' => 'Biaya Administrasi',
			'biayamaterai' => 'Biayamaterai',
			'uangditerima' => 'Uang Diterima',
			'uangkembalian' => 'Uangkembalian',
			'keterangan_pembayaran' => 'Keterangan Pembayaran',
			'preparedby' => 'Dibuat Oleh',
			'prepareddate' => 'Waktu Persiapan',
			'reviewedby' => 'Direview Oleh',
			'revieweddate' => 'Tanggal Review',
			'approvedby' => 'Disetujui Oleh',
			'approveddate' => 'Tanggal Disetujui',
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

		$criteria->compare('buktikasmasukkop_id',$this->buktikasmasukkop_id);
		$criteria->compare('jenistransaksi_id',$this->jenistransaksi_id);
		$criteria->compare('namatransaksi',$this->namatransaksi,true);
		$criteria->compare('tgl_kasmasuk',$this->tgl_kasmasuk,true);
		$criteria->compare('nobuktimasuk',$this->nobuktimasuk,true);
		$criteria->compare('darinama_bkm',$this->darinama_bkm,true);
		$criteria->compare('alamat_bkm',$this->alamat_bkm,true);
		$criteria->compare('sebagaipembayaran_bkm',$this->sebagaipembayaran_bkm,true);
		$criteria->compare('jmlpembayaran',$this->jmlpembayaran);
		$criteria->compare('biayaadministrasi',$this->biayaadministrasi);
		$criteria->compare('biayamaterai',$this->biayamaterai);
		$criteria->compare('uangditerima',$this->uangditerima);
		$criteria->compare('uangkembalian',$this->uangkembalian);
		$criteria->compare('keterangan_pembayaran',$this->keterangan_pembayaran,true);
		$criteria->compare('preparedby',$this->preparedby);
		$criteria->compare('prepareddate',$this->prepareddate,true);
		$criteria->compare('reviewedby',$this->reviewedby);
		$criteria->compare('revieweddate',$this->revieweddate,true);
		$criteria->compare('approvedby',$this->approvedby);
		$criteria->compare('approveddate',$this->approveddate,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        public function getTotJB($provider) {
		$prov = clone $provider;
		$prov->pagination = false;
		$total = 0;
		foreach ($prov->data as $item) {
			$total += $item->jmlpembayaran;
		}
		return $total;
	}

	public function getTotBA($provider) {
		$prov = clone $provider;
		$prov->pagination = false;
		$total = 0;
		foreach ($prov->data as $item) {
			$total += $item->biayaadministrasi;
		}
		return $total;
	}

	public function getTotBM($provider) {
		$prov = clone $provider;
		$prov->pagination = false;
		$total = 0;
		foreach ($prov->data as $item) {
			$total += $item->biayamaterai;
		}
		return $total;
	}

	public function getTotJKM($provider) {
		$prov = clone $provider;
		$prov->pagination = false;
		$total = 0;
		foreach ($prov->data as $item) {
			$total += $item->uangditerima;
		}
		return $total;
	}
}