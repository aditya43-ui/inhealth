<?php

/**
 * This is the model class for table "tandabuktikeluar_t".
 *
 * The followings are the available columns in table 'tandabuktikeluar_t':
 * @property integer $tandabuktikeluar_id
 * @property integer $returbayarpelayanan_id
 * @property integer $pembatalanuangmuka_id
 * @property integer $shift_id
 * @property integer $pengeluaranumum_id
 * @property integer $batalbayarsupplier_id
 * @property integer $uangmukabeli_id
 * @property integer $batalkeluarumum_id
 * @property integer $bayarkesupplier_id
 * @property integer $ruangan_id
 * @property string $tahun
 * @property string $tglkaskeluar
 * @property string $nokaskeluar
 * @property string $carabayarkeluar
 * @property string $melalubank
 * @property string $denganrekening
 * @property string $atasnamarekening
 * @property string $namapenerima
 * @property string $alamatpenerima
 * @property string $untukpembayaran
 * @property double $jmlkaskeluar
 * @property double $biayaadministrasi
 * @property string $keterangan_pengeluaran
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai_id
 * @property string $update_loginpemakai_id
 * @property string $create_ruangan
 *
 * The followings are the available model relations:
 * @property ReturbayarpelayananT[] $returbayarpelayananTs
 * @property PinjamanpegT[] $pinjamanpegTs
 * @property PengeluaranumumT[] $pengeluaranumumTs
 * @property PembatalanuangmukaT[] $pembatalanuangmukaTs
 * @property PembayaranjasaT[] $pembayaranjasaTs
 * @property ReturpenerimaanumumT $returpenerimaanumum
 * @property BatalbayarsupplierT $batalbayarsupplier
 * @property BatalkeluarumumT $batalkeluarumum
 * @property BayarkesupplierT $bayarkesupplier
 * @property PembatalanuangmukaT $pembatalanuangmuka
 * @property PengeluaranumumT $pengeluaranumum
 * @property ReturbayarpelayananT $returbayarpelayanan
 * @property RuanganM $ruangan
 * @property ShiftM $shift
 * @property UangmukabeliT $uangmukabeli
 * @property BayarkesupplierT[] $bayarkesupplierTs
 * @property BatalkeluarumumT[] $batalkeluarumumTs
 * @property BatalbayarsupplierT[] $batalbayarsupplierTs
 */
class TandabuktikeluarT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return TandabuktikeluarT the static model class
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
		return 'tandabuktikeluar_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('shift_id, ruangan_id, tahun, tglkaskeluar, nokaskeluar, namapenerima, jmlkaskeluar, biayaadministrasi, create_time, create_loginpemakai_id, create_ruangan', 'required'),
			array('returbayarpelayanan_id, pembatalanuangmuka_id, shift_id, pengeluaranumum_id, batalbayarsupplier_id, uangmukabeli_id, batalkeluarumum_id, bayarkesupplier_id, ruangan_id, bank_id, advancepayment_id, settlementpayment_id', 'numerical', 'integerOnly'=>true),
			array('jmlkaskeluar, biayaadministrasi, biayaongkos_kirim, biaya_materai', 'numerical'),
			array('tahun', 'length', 'max'=>4),
			array('nokaskeluar, carabayarkeluar, no_setorpajakpembelian, norekpenerima', 'length', 'max'=>50),
			array('melalubank, denganrekening, atasnamarekening, namapenerima, untukpembayaran', 'length', 'max'=>100),
			array('pembatalanuangmuka_id, nobukti_transfer, alamatpenerima, keterangan_pengeluaran, update_time, update_loginpemakai_id, biayaongkos_kirim', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
                    
                        array('create_time','default','value'=>date('Y-m-d H:i:s'),'setOnEmpty'=>false,'on'=>'insert'),
                        array('update_time','default','value'=>date('Y-m-d H:i:s'),'setOnEmpty'=>false,'on'=>'update,insert'),
                        array('create_loginpemakai_id','default','value'=>Yii::app()->user->id,'on'=>'insert'),
                        array('update_loginpemakai_id','default','value'=>Yii::app()->user->id,'on'=>'update,insert'),
                        array('create_ruangan','default','value'=>Yii::app()->user->getState('ruangan_id'),'on'=>'insert'),
                    
                    
			array('tandabuktikeluar_id, returbayarpelayanan_id, pembatalanuangmuka_id, shift_id, pengeluaranumum_id, batalbayarsupplier_id, uangmukabeli_id, batalkeluarumum_id, bayarkesupplier_id, ruangan_id, tahun, tglkaskeluar, nokaskeluar, carabayarkeluar, melalubank, denganrekening, atasnamarekening, namapenerima, alamatpenerima, untukpembayaran, jmlkaskeluar, biayaadministrasi, keterangan_pengeluaran, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, biayaongkos_kirim, no_setorpajakpembelian, bank_id, biaya_materai, norekpenerima, advancepayment_id, settlementpayment_id', 'safe', 'on'=>'search'),
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
			'returbayarpelayananTs' => array(self::HAS_MANY, 'ReturbayarpelayananT', 'tandabuktikeluar_id'),
			'pinjamanpegTs' => array(self::HAS_MANY, 'PinjamanpegT', 'tandabuktikeluar_id'),
			'pengeluaranumumTs' => array(self::HAS_MANY, 'PengeluaranumumT', 'tandabuktikeluar_id'),
			'pembatalanuangmukaTs' => array(self::HAS_MANY, 'PembatalanuangmukaT', 'tandabuktikeluar_id'),
			'pembayaranjasaTs' => array(self::HAS_MANY, 'PembayaranjasaT', 'tandabuktikeluar_id'),
			'batalbayarsupplier' => array(self::BELONGS_TO, 'BatalbayarsupplierT', 'batalbayarsupplier_id'),
			'batalkeluarumum' => array(self::BELONGS_TO, 'BatalkeluarumumT', 'batalkeluarumum_id'),
			'bayarkesupplier' => array(self::BELONGS_TO, 'BayarkesupplierT', 'bayarkesupplier_id'),
			'pembatalanuangmuka' => array(self::BELONGS_TO, 'PembatalanuangmukaT', 'pembatalanuangmuka_id'),
			'pengeluaranumum' => array(self::BELONGS_TO, 'PengeluaranumumT', 'pengeluaranumum_id'),
			'returbayarpelayanan' => array(self::BELONGS_TO, 'ReturbayarpelayananT', 'returbayarpelayanan_id'),
			'ruangan' => array(self::BELONGS_TO, 'RuanganM', 'ruangan_id'),
			'shift' => array(self::BELONGS_TO, 'ShiftM', 'shift_id'),
			'uangmukabeli' => array(self::BELONGS_TO, 'UangmukabeliT', 'uangmukabeli_id'),
			'bayarkesupplierTs' => array(self::HAS_MANY, 'BayarkesupplierT', 'tandabuktikeluar_id'),
			'batalkeluarumumTs' => array(self::HAS_MANY, 'BatalkeluarumumT', 'tandabuktikeluar_id'),
			'batalbayarsupplierTs' => array(self::HAS_MANY, 'BatalbayarsupplierT', 'tandabuktikeluar_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'tandabuktikeluar_id' => 'Tanda Bukti Keluar',
			'returbayarpelayanan_id' => 'Retur Bayar Pelayanan',
			'pembatalanuangmuka_id' => 'Pembatalan Uang Muka',
			'shift_id' => 'Shift',
			'pengeluaranumum_id' => 'Pengeluaran Umum',
			'batalbayarsupplier_id' => 'Batal Bayar Supplier',
			'uangmukabeli_id' => 'Uang Muka Beli',
			'batalkeluarumum_id' => 'Batal Keluar Umum',
			'bayarkesupplier_id' => 'Bayar Ke Supplier',
			'ruangan_id' => 'Ruangan',
			'tahun' => 'Tahun',
			'tglkaskeluar' => 'Tgl. Kas Keluar',
			'nokaskeluar' => 'No. Kas Keluar',
			'carabayarkeluar' => 'Cara Pembayaran',
			'melalubank' => 'Melalui Bank',
			'denganrekening' => 'Dengan Rekening',
			'atasnamarekening' => 'Atas Nama Rekening',
			'namapenerima' => 'Nama Penerima',
			'alamatpenerima' => 'Alamat Penerima',
			'untukpembayaran' => 'Sebagai Pembayaran',
			'jmlkaskeluar' => 'Jumlah Kas Keluar',
			'biayaadministrasi' => 'Biaya Administrasi',
			'keterangan_pengeluaran' => 'Keterangan Pengeluaran',
			'create_time' => 'Waktu Create',
			'update_time' => 'Waktu Update',
			'create_loginpemakai_id' => 'Create Login Pemakai',
			'update_loginpemakai_id' => 'Update Login Pemakai',
			'create_ruangan' => 'Create Ruangan',
                        'nobukti_transfer'=> 'No. Bukti Transfer',
                        'biayaongkos_kirim'=>'Biaya Ongkos Kirim',
                    'bank_id'=>'Nama Bank Penerima',
                    'norekpenerima' => 'No Rekening Penerima'
                    
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

		if(!empty($this->tandabuktikeluar_id)){
			$criteria->addCondition('tandabuktikeluar_id = '.$this->tandabuktikeluar_id);
		}
		if(!empty($this->returbayarpelayanan_id)){
			$criteria->addCondition('returbayarpelayanan_id = '.$this->returbayarpelayanan_id);
		}
		if(!empty($this->pembatalanuangmuka_id)){
			$criteria->addCondition('pembatalanuangmuka_id = '.$this->pembatalanuangmuka_id);
		}
		if(!empty($this->shift_id)){
			$criteria->addCondition('shift_id = '.$this->shift_id);
		}
		if(!empty($this->pengeluaranumum_id)){
			$criteria->addCondition('pengeluaranumum_id = '.$this->pengeluaranumum_id);
		}
		if(!empty($this->batalbayarsupplier_id)){
			$criteria->addCondition('batalbayarsupplier_id = '.$this->batalbayarsupplier_id);
		}
		if(!empty($this->uangmukabeli_id)){
			$criteria->addCondition('uangmukabeli_id = '.$this->uangmukabeli_id);
		}
		if(!empty($this->batalkeluarumum_id)){
			$criteria->addCondition('batalkeluarumum_id = '.$this->batalkeluarumum_id);
		}
		if(!empty($this->bayarkesupplier_id)){
			$criteria->addCondition('bayarkesupplier_id = '.$this->bayarkesupplier_id);
		}
		if(!empty($this->ruangan_id)){
			$criteria->addCondition('ruangan_id = '.$this->ruangan_id);
		}
		$criteria->compare('LOWER(tahun)',strtolower($this->tahun),true);
		$criteria->compare('LOWER(tglkaskeluar)',strtolower($this->tglkaskeluar),true);
		$criteria->compare('LOWER(nokaskeluar)',strtolower($this->nokaskeluar),true);
		$criteria->compare('LOWER(carabayarkeluar)',strtolower($this->carabayarkeluar),true);
		$criteria->compare('LOWER(melalubank)',strtolower($this->melalubank),true);
		$criteria->compare('LOWER(denganrekening)',strtolower($this->denganrekening),true);
		$criteria->compare('LOWER(atasnamarekening)',strtolower($this->atasnamarekening),true);
		$criteria->compare('LOWER(namapenerima)',strtolower($this->namapenerima),true);
		$criteria->compare('LOWER(alamatpenerima)',strtolower($this->alamatpenerima),true);
		$criteria->compare('LOWER(untukpembayaran)',strtolower($this->untukpembayaran),true);
		$criteria->compare('jmlkaskeluar',$this->jmlkaskeluar);
		$criteria->compare('biayaadministrasi',$this->biayaadministrasi);
		$criteria->compare('LOWER(keterangan_pengeluaran)',strtolower($this->keterangan_pengeluaran),true);
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
		$criteria->compare('LOWER(create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);
		$criteria->compare('LOWER(update_loginpemakai_id)',strtolower($this->update_loginpemakai_id),true);
		$criteria->compare('LOWER(create_ruangan)',strtolower($this->create_ruangan),true);

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
		
		public function searchBayarSupplier() {
			$criteria = $this->criteriaSearch();
			$criteria->addCondition('bayarkesupplier_id IS NOT NULL');
			
			return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
            ));
		}
}