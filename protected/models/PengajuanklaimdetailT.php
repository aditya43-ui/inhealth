<?php

/**
 * This is the model class for table "pengajuanklaimdetail_t".
 *
 * The followings are the available columns in table 'pengajuanklaimdetail_t':
 * @property integer $pengajuanklaimdetail_id
 * @property integer $pendaftaran_id
 * @property integer $pasien_id
 * @property integer $pengajuanklaimpiutang_id
 * @property integer $pembayaranpelayanan_id
 * @property integer $tandabuktibayar_id
 * @property double $jmlpiutang
 * @property double $jumlahbayar
 * @property double $jmltelahbayar
 * @property double $jmlsisapiutang
 *
 * The followings are the available model relations:
 * @property PasienM $pasien
 * @property PembayaranpelayananT $pembayaranpelayanan
 * @property PengajuanklaimpiutangT $pengajuanklaimpiutang
 * @property PendaftaranT $pendaftaran
 * @property TandabuktibayarT $tandabuktibayar
 */
class PengajuanklaimdetailT extends CActiveRecord
{
        public $piutang;
        public $telahbayar;
        public $carabayar_nama;
        public $penjamin_nama;

	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PengajuanklaimdetailT the static model class
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
		return 'pengajuanklaimdetail_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('jmldiskon, pendaftaran_id, pasien_id, pengajuanklaimpiutang_id, jmlpiutang, jumlahbayar, jmltelahbayar, jmlsisapiutang', 'required'),
			array('pendaftaran_id, pasien_id, pengajuanklaimpiutang_id, pembayaranpelayanan_id, tandabuktibayar_id', 'numerical', 'integerOnly'=>true),
			array('jmlpiutang, jumlahbayar, jmltelahbayar, jmlsisapiutang', 'numerical'),
      array('noreferensi', 'length', 'max' => 50),

			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('pengajuanklaimdetail_id, pendaftaran_id, pasien_id, pengajuanklaimpiutang_id, pembayaranpelayanan_id, tandabuktibayar_id, jmlpiutang, jumlahbayar, jmltelahbayar, jmlsisapiutang, noreferensi', 'safe', 'on'=>'search'),
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
			'pasien' => array(self::BELONGS_TO, 'PasienM', 'pasien_id'),
			'pembayaranpelayanan' => array(self::BELONGS_TO, 'PembayaranpelayananT', 'pembayaranpelayanan_id'),
			'pengajuanklaimpiutang' => array(self::BELONGS_TO, 'PengajuanklaimpiutangT', 'pengajuanklaimpiutang_id'),
			'pendaftaran' => array(self::BELONGS_TO, 'PendaftaranT', 'pendaftaran_id'),
			'tandabuktibayar' => array(self::BELONGS_TO, 'TandabuktibayarT', 'tandabuktibayar_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'pengajuanklaimdetail_id' => 'Pengajuanklaimdetail',
			'pendaftaran_id' => 'Pendaftaran',
			'pasien_id' => 'Pasien',
			'pengajuanklaimpiutang_id' => 'Pengajuanklaimpiutang',
			'pembayaranpelayanan_id' => 'Pembayaranpelayanan',
			'tandabuktibayar_id' => 'Tandabuktibayar',
			'jmlpiutang' => 'Jmlpiutang',
			'jumlahbayar' => 'Jumlahbayar',
			'jmltelahbayar' => 'Jmltelahbayar',
			'jmlsisapiutang' => 'Jmlsisapiutang',
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

		$criteria->compare('pengajuanklaimdetail_id',$this->pengajuanklaimdetail_id);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('pengajuanklaimpiutang_id',$this->pengajuanklaimpiutang_id);
		$criteria->compare('pembayaranpelayanan_id',$this->pembayaranpelayanan_id);
		$criteria->compare('tandabuktibayar_id',$this->tandabuktibayar_id);
		$criteria->compare('jmlpiutang',$this->jmlpiutang);
		$criteria->compare('jumlahbayar',$this->jumlahbayar);
		$criteria->compare('jmltelahbayar',$this->jmltelahbayar);
		$criteria->compare('jmlsisapiutang',$this->jmlsisapiutang);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

        public function getAllAsutansi(){
            $cri = new CDbCriteria();
            $cri->select = "cb.carabayar_nama, pp.penjamin_nama, sum(t.jmlpiutang) as piutang, sum(t.jmltelahbayar) as telahbayar";
            $cri->join = "  JOIN pengajuanklaimpiutang_t pengklaim ON pengklaim.pengajuanklaimpiutang_id = t.pengajuanklaimpiutang_id
                            JOIN carabayar_m cb ON cb.carabayar_id = pengklaim.carabayar_id
                            JOIN penjaminpasien_m pp ON pp.penjamin_id = pengklaim.penjamin_id ";
            $cri->addCondition(" cb.carabayar_id = '".Params::CARABAYAR_ID_ASURANSI."' ");
            $cri->addCondition(" t.jmlsisapiutang > 0 ");
            $cri->group = "cb.carabayar_nama, pp.penjamin_nama ";

           return PengajuanklaimdetailT::model()->findAll($cri);
        }
}
