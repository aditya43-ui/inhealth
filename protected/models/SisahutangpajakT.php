<?php

/**
 * This is the model class for table "sisahutangpajak_t".
 *
 * The followings are the available columns in table 'sisahutangpajak_t':
 * @property integer $sisahutangpajak_id
 * @property integer $setoranpajak_id
 * @property integer $penggajianpeg_id
 * @property integer $pembayaranjasa_id
 * @property double $jmlpembayaran
 * @property double $totalsisahutang
 *
 * The followings are the available model relations:
 * @property SetoranpajakT $setoranpajak
 * @property PenggajianpegT $penggajianpeg
 * @property PembayaranjasaT $pembayaranjasa
 */
class SisahutangpajakT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return SisahutangpajakT the static model class
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
		return 'sisahutangpajak_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('setoranpajak_id, jmlpembayaran, totalsisahutang', 'required'),
			array('setoranpajak_id, penggajianpeg_id, pembayaranjasa_id', 'numerical', 'integerOnly'=>true),
			array('jmlpembayaran, totalsisahutang', 'numerical'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('sisahutangpajak_id, setoranpajak_id, penggajianpeg_id, pembayaranjasa_id, jmlpembayaran, totalsisahutang', 'safe', 'on'=>'search'),
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
			'setoranpajak' => array(self::BELONGS_TO, 'SetoranpajakT', 'setoranpajak_id'),
			'penggajianpeg' => array(self::BELONGS_TO, 'PenggajianpegT', 'penggajianpeg_id'),
			'pembayaranjasa' => array(self::BELONGS_TO, 'PembayaranjasaT', 'pembayaranjasa_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'sisahutangpajak_id' => 'Sisahutangpajak',
			'setoranpajak_id' => 'Setoranpajak',
			'penggajianpeg_id' => 'Penggajianpeg',
			'pembayaranjasa_id' => 'Pembayaranjasa',
			'jmlpembayaran' => 'Jmlpembayaran',
			'totalsisahutang' => 'Total Sisa Utang',
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

		$criteria->compare('sisahutangpajak_id',$this->sisahutangpajak_id);
		$criteria->compare('setoranpajak_id',$this->setoranpajak_id);
		$criteria->compare('penggajianpeg_id',$this->penggajianpeg_id);
		$criteria->compare('pembayaranjasa_id',$this->pembayaranjasa_id);
		$criteria->compare('jmlpembayaran',$this->jmlpembayaran);
		$criteria->compare('totalsisahutang',$this->totalsisahutang);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}