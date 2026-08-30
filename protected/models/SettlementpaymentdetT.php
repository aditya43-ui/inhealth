<?php

/**
 * This is the model class for table "settlementpaymentdet_t".
 *
 * The followings are the available columns in table 'settlementpaymentdet_t':
 * @property integer $settlementpaymentdet_id
 * @property integer $settlementpayment_id
 * @property integer $jenispengeluaran_id
 * @property string $tgltransaksi
 * @property string $deskripsi
 * @property string $noreferensi
 * @property double $volume
 * @property string $satuanvol
 * @property double $hargasatuan
 * @property double $totalharga
 *
 * The followings are the available model relations:
 * @property SettlementpaymentT $settlementpayment
 * @property JenispengeluaranM $jenispengeluaran
 */
class SettlementpaymentdetT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return SettlementpaymentdetT the static model class
	 */
	public $rekening5_nama,$jenispengeluaran_nama;
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'settlementpaymentdet_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('tgltransaksi', 'required'),
			array('settlementpayment_id,rekening5_id, jenispengeluaran_id', 'numerical', 'integerOnly'=>true),
			array('volume, hargasatuan, totalharga', 'numerical'),
			array('noreferensi', 'length', 'max'=>100),
			array('satuanvol', 'length', 'max'=>50),
			array('deskripsi', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('settlementpaymentdet_id, settlementpayment_id, jenispengeluaran_id, tgltransaksi, deskripsi, noreferensi, volume, satuanvol, hargasatuan, totalharga', 'safe', 'on'=>'search'),
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
			'settlementpayment' => array(self::BELONGS_TO, 'SettlementpaymentT', 'settlementpayment_id'),
			'jenispengeluaran' => array(self::BELONGS_TO, 'JenispengeluaranM', 'jenispengeluaran_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'settlementpaymentdet_id' => 'Settlementpaymentdet',
			'settlementpayment_id' => 'Settlementpayment',
			'jenispengeluaran_id' => 'Jenispengeluaran',
			'tgltransaksi' => 'Tgltransaksi',
			'deskripsi' => 'Deskripsi',
			'noreferensi' => 'Noreferensi',
			'volume' => 'Volume',
			'satuanvol' => 'Satuanvol',
			'hargasatuan' => 'Hargasatuan',
			'totalharga' => 'Totalharga',
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

		$criteria->compare('settlementpaymentdet_id',$this->settlementpaymentdet_id);
		$criteria->compare('settlementpayment_id',$this->settlementpayment_id);
		$criteria->compare('jenispengeluaran_id',$this->jenispengeluaran_id);
		$criteria->compare('tgltransaksi',$this->tgltransaksi,true);
		$criteria->compare('deskripsi',$this->deskripsi,true);
		$criteria->compare('noreferensi',$this->noreferensi,true);
		$criteria->compare('volume',$this->volume);
		$criteria->compare('satuanvol',$this->satuanvol,true);
		$criteria->compare('hargasatuan',$this->hargasatuan);
		$criteria->compare('totalharga',$this->totalharga);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}