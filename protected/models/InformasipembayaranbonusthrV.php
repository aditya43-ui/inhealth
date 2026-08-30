<?php

/**
 * This is the model class for table "informasipembayaranbonusthr_v".
 *
 * The followings are the available columns in table 'informasipembayaranbonusthr_v':
 * @property integer $pembbonusthr_id
 * @property string $tglpembayaran
 * @property string $nopembayaran
 * @property string $jenisgaji
 * @property double $totalhutang
 * @property double $totaldibayarkan
 * @property double $totalsisahutang
 * @property integer $pegawaibatal_id
 * @property integer $tandabuktikeluar_id
 * @property string $tglkaskeluar
 * @property string $nokaskeluar
 * @property double $biayaadministrasi
 * @property double $jmlkaskeluar
 * @property string $petugaspenyetor
 * @property integer $pegawai_id
 */
class InformasipembayaranbonusthrV extends CActiveRecord
{
	public $tgl_awal, $tgl_akhir, $tglnyetor_awal, $tglnyetor_akhir, $ceklis, $status_penyetoran, $status_pembatalan;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return InformasipembayaranbonusthrV the static model class
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
		return 'informasipembayaranbonusthr_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pembbonusthr_id, pegawaibatal_id, tandabuktikeluar_id, pegawai_id', 'numerical', 'integerOnly'=>true),
			array('totalhutang, totaldibayarkan, totalsisahutang, biayaadministrasi, jmlkaskeluar', 'numerical'),
			array('nopembayaran, jenisgaji, nokaskeluar', 'length', 'max'=>50),
			array('tglpembayaran, tglkaskeluar, petugaspenyetor', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('pembbonusthr_id, tglpembayaran, nopembayaran, jenisgaji, totalhutang, totaldibayarkan, totalsisahutang, pegawaibatal_id, tandabuktikeluar_id, tglkaskeluar, nokaskeluar, biayaadministrasi, jmlkaskeluar, petugaspenyetor, pegawai_id', 'safe', 'on'=>'search'),
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
			'pembbonusthr_id' => 'Pemb. Bonus THR',
			'tglpembayaran' => 'Tgl. Pembayaran',
			'nopembayaran' => 'No. Pembayaran',
			'jenisgaji' => 'Jenis Gaji',
			'totalhutang' => 'Total Utang',
			'totaldibayarkan' => 'Total Dibayarkan',
			'totalsisahutang' => 'Total Sisa Utang',
			'pegawaibatal_id' => 'Pegawai Batal',
			'tandabuktikeluar_id' => 'Tanda Bukti Keluar',
			'tglkaskeluar' => 'Tgl. Kas Keluar',
			'nokaskeluar' => 'No. Kas Keluar',
			'biayaadministrasi' => 'Biaya Administrasi',
			'jmlkaskeluar' => 'Jumlah Kas Keluar',
			'petugaspenyetor' => 'Petugas Penyetor',
			'pegawai_id' => 'Pegawai',
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
		$criteria->compare('tglpembayaran',$this->tglpembayaran,true);
		$criteria->compare('nopembayaran',$this->nopembayaran,true);
		$criteria->compare('jenisgaji',$this->jenisgaji,true);
		$criteria->compare('totalhutang',$this->totalhutang);
		$criteria->compare('totaldibayarkan',$this->totaldibayarkan);
		$criteria->compare('totalsisahutang',$this->totalsisahutang);
		$criteria->compare('pegawaibatal_id',$this->pegawaibatal_id);
		$criteria->compare('tandabuktikeluar_id',$this->tandabuktikeluar_id);
		$criteria->compare('tglkaskeluar',$this->tglkaskeluar,true);
		$criteria->compare('nokaskeluar',$this->nokaskeluar,true);
		$criteria->compare('biayaadministrasi',$this->biayaadministrasi);
		$criteria->compare('jmlkaskeluar',$this->jmlkaskeluar);
		$criteria->compare('petugaspenyetor',$this->petugaspenyetor,true);
		$criteria->compare('pegawai_id',$this->pegawai_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function searchInformasi()
	{

			$criteria=new CDbCriteria;

			$criteria->addBetweenCondition('DATE(tglkaskeluar)', $this->tgl_awal, $this->tgl_akhir);

			if($this->ceklis){
					$criteria->addBetweenCondition('DATE(tglpembayaran)', $this->tglnyetor_awal, $this->tglnyetor_akhir);
			}

			$criteria->compare('LOWER(nokaskeluar)', strtolower($this->nokaskeluar),true);
			$criteria->compare('LOWER(nopembayaran)', strtolower($this->nopembayaran),true);
			$criteria->compare('LOWER(jenisgaji)', strtolower($this->jenisgaji),false);

		 if(!empty($this->status_penyetoran)){
				 if($this->status_penyetoran == '1'){
						 $criteria->addCondition('totalhutang > totaldibayarkan');
				 }else if($this->status_penyetoran == '2'){
						 $criteria->addCondition('totalhutang = totaldibayarkan');
				 }
			}

			if(!empty($this->status_pembatalan)){
				 if($this->status_pembatalan == '1'){
						 $criteria->addCondition('pegawaibatal_id IS NULL');
				 }else if($this->status_pembatalan == '2'){
						 $criteria->addCondition('pegawaibatal_id IS NOT NULL');
				 }
			}

			if(!empty($this->pegawai_id)){
					$criteria->addCondition('pegawai_id = '.$this->pegawai_id);
			}

			return new CActiveDataProvider($this, array(
							'criteria'=>$criteria,
			));
	}
}
