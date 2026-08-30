<?php

/**
 * This is the model class for table "pengajuanpettydet_t".
 *
 * The followings are the available columns in table 'pengajuanpettydet_t':
 * @property integer $pengajuanpettydet_id
 * @property integer $pengajuanpetty_id
 * @property string $pengajuanpettydet_item
 * @property integer $pengajuanpettydet_qty
 * @property double $pengajuanpettydet_hargasatuan
 * @property double $pengajuanpettydet_subtotal
 * @property string $pengajuanpettydet_keterangan
 *
 * The followings are the available model relations:
 * @property PengajuanpettyT $pengajuanpetty
 */
class PengajuanpettydetT extends CActiveRecord
{
	public $pilih;
	public $pengajuanpetty_no;
	public $pengajuanpetty_tgl;
	
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PengajuanpettydetT the static model class
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
		return 'pengajuanpettydet_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pengajuanpetty_id', 'required'),
			array('pengajuanpetty_id, pengajuanpettydet_qty', 'numerical', 'integerOnly'=>true),
			array('pengajuanpettydet_hargasatuan, pengajuanpettydet_subtotal', 'numerical'),
			array('pengajuanpettydet_item', 'length', 'max'=>250),
			array('pengajuanpettydet_keterangan', 'length', 'max'=>100),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('pengajuanpettydet_id, pengajuanpetty_id, pengajuanpettydet_item, pengajuanpettydet_qty, pengajuanpettydet_hargasatuan, pengajuanpettydet_subtotal, pengajuanpettydet_keterangan', 'safe', 'on'=>'search'),
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
			'pengajuanpetty' => array(self::BELONGS_TO, 'PengajuanpettyT', 'pengajuanpetty_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'pengajuanpettydet_id' => 'ID',
			'pengajuanpetty_id' => 'Pengajuan Petty',
			'pengajuanpettydet_item' => 'Item',
			'pengajuanpettydet_qty' => 'Qty',
			'pengajuanpettydet_hargasatuan' => 'Harga Satuan',
			'pengajuanpettydet_subtotal' => 'Subtotal',
			'pengajuanpettydet_keterangan' => 'Keterangan',
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

		$criteria->compare('pengajuanpettydet_id',$this->pengajuanpettydet_id);
		$criteria->compare('pengajuanpetty_id',$this->pengajuanpetty_id);
		$criteria->compare('pengajuanpettydet_item',$this->pengajuanpettydet_item,true);
		$criteria->compare('pengajuanpettydet_qty',$this->pengajuanpettydet_qty);
		$criteria->compare('pengajuanpettydet_hargasatuan',$this->pengajuanpettydet_hargasatuan);
		$criteria->compare('pengajuanpettydet_subtotal',$this->pengajuanpettydet_subtotal);
		$criteria->compare('pengajuanpettydet_keterangan',$this->pengajuanpettydet_keterangan,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}