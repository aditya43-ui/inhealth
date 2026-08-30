<?php

/**
 * This is the model class for table "pembbonusthr_t".
 *
 * The followings are the available columns in table 'pembbonusthr_t':
 * @property integer $pembbonusthr_id
 * @property integer $pengbonusthr_id
 * @property integer $tandabuktikeluar_id
 * @property integer $pegawai_id
 * @property string $tglpembayaran
 * @property string $nopembayaran
 * @property string $periode
 * @property string $sampaidgn
 * @property string $jenisgaji
 * @property double $totalhutang
 * @property double $totaldibayarkan
 * @property double $totalsisahutang
 * @property string $tglbatalbayar
 * @property integer $pegawaibatal_id
 * @property string $alasanbatal
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai
 * @property string $update_loginpemakai
 * @property string $create_ruangan
 *
 * The followings are the available model relations:
 * @property PegawaiM $pegawai
 * @property PengbonusthrT $pengbonusthr
 * @property TandabuktikeluarT $tandabuktikeluar
 * @property PembbonusthrdetT[] $pembbonusthrdetTs
 */
class PembbonusthrT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PembbonusthrT the static model class
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
		return 'pembbonusthr_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pengbonusthr_id, tandabuktikeluar_id, pegawai_id, pegawaibatal_id', 'numerical', 'integerOnly'=>true),
			array('totalhutang, totaldibayarkan, totalsisahutang', 'numerical'),
			array('nopembayaran, jenisgaji', 'length', 'max'=>50),
			array('tglpembayaran, periode, sampaidgn, tglbatalbayar, alasanbatal, create_time, update_time, create_loginpemakai, update_loginpemakai, create_ruangan', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('pembbonusthr_id, pengbonusthr_id, tandabuktikeluar_id, pegawai_id, tglpembayaran, nopembayaran, periode, sampaidgn, jenisgaji, totalhutang, totaldibayarkan, totalsisahutang, tglbatalbayar, pegawaibatal_id, alasanbatal, create_time, update_time, create_loginpemakai, update_loginpemakai, create_ruangan', 'safe', 'on'=>'search'),
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
			'pegawai' => array(self::BELONGS_TO, 'PegawaiM', 'pegawai_id'),
			'pengbonusthr' => array(self::BELONGS_TO, 'PengbonusthrT', 'pengbonusthr_id'),
			'tandabuktikeluar' => array(self::BELONGS_TO, 'TandabuktikeluarT', 'tandabuktikeluar_id'),
			'pembbonusthrdetTs' => array(self::HAS_MANY, 'PembbonusthrdetT', 'pembbonusthr_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'pembbonusthr_id' => 'Pemb. Bonus THR',
			'pengbonusthr_id' => 'Pengbonusthr',
			'tandabuktikeluar_id' => 'Tanda Bukti Keluar',
			'pegawai_id' => 'Pegawai',
			'tglpembayaran' => 'Tgl. pembayaran',
			'nopembayaran' => 'No. Pembayaran',
			'periode' => 'Periode',
			'sampaidgn' => 'Sampaidgn',
			'jenisgaji' => 'Jenis Gaji',
			'totalhutang' => 'Total Hutang',
			'totaldibayarkan' => 'Total Yang Dibayarkan',
			'totalsisahutang' => 'Total Sisa Hutang',
			'tglbatalbayar' => 'Tgl. Batal Bayar',
			'pegawaibatal_id' => 'Pegawai Batal',
			'alasanbatal' => 'Alasanbatal',
			'create_time' => 'Waktu Create',
			'update_time' => 'Waktu Update',
			'create_loginpemakai' => 'Create Loginpemakai',
			'update_loginpemakai' => 'Update Loginpemakai',
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

		$criteria->compare('pembbonusthr_id',$this->pembbonusthr_id);
		$criteria->compare('pengbonusthr_id',$this->pengbonusthr_id);
		$criteria->compare('tandabuktikeluar_id',$this->tandabuktikeluar_id);
		$criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->compare('tglpembayaran',$this->tglpembayaran,true);
		$criteria->compare('nopembayaran',$this->nopembayaran,true);
		$criteria->compare('periode',$this->periode,true);
		$criteria->compare('sampaidgn',$this->sampaidgn,true);
		$criteria->compare('jenisgaji',$this->jenisgaji,true);
		$criteria->compare('totalhutang',$this->totalhutang);
		$criteria->compare('totaldibayarkan',$this->totaldibayarkan);
		$criteria->compare('totalsisahutang',$this->totalsisahutang);
		$criteria->compare('tglbatalbayar',$this->tglbatalbayar,true);
		$criteria->compare('pegawaibatal_id',$this->pegawaibatal_id);
		$criteria->compare('alasanbatal',$this->alasanbatal,true);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('create_loginpemakai',$this->create_loginpemakai,true);
		$criteria->compare('update_loginpemakai',$this->update_loginpemakai,true);
		$criteria->compare('create_ruangan',$this->create_ruangan,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
