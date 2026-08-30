<?php

/**
 * This is the model class for table "renkebbahanmakanandet_t".
 *
 * The followings are the available columns in table 'renkebbahanmakanandet_t':
 * @property integer $renkebbahanmakanandet_id
 * @property integer $renkebbahanmakanan_id
 * @property integer $bahanmakanan_id
 * @property string $satuanbahan
 * @property integer $jmlpermintaandet
 * @property double $harga_barangdet
 * @property integer $stokakhir_bahanmakanan
 * @property integer $minstok_bahanmakanan
 * @property integer $makstok_bahanmakanan
 *
 * The followings are the available model relations:
 * @property RenkebbahanmakananT $renkebbahanmakanan
 * @property BahanmakananM $bahanmakanan
 */
class RenkebbahanmakanandetT extends CActiveRecord
{
    public $namabahanmakanan, $harga_barang, $subtotal, $jml_ppn;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return RenkebbahanmakanandetT the static model class
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
		return 'renkebbahanmakanandet_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('renkebbahanmakanan_id, bahanmakanan_id, satuanbahan, jmlpermintaandet, harga_barangdet, stokakhir_bahanmakanan, minstok_bahanmakanan, makstok_bahanmakanan', 'required'),
			array('renkebbahanmakanan_id, bahanmakanan_id, stokakhir_bahanmakanan, minstok_bahanmakanan, makstok_bahanmakanan', 'numerical', 'integerOnly'=>true),
			array('harga_barangdet, persen_ppn, jmlpermintaandet', 'numerical'),
			array('satuanbahan', 'length', 'max'=>50),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('renkebbahanmakanandet_id, renkebbahanmakanan_id, bahanmakanan_id, satuanbahan, jmlpermintaandet, harga_barangdet, stokakhir_bahanmakanan, minstok_bahanmakanan, makstok_bahanmakanan, persen_ppn, jmlpermintaandet', 'safe', 'on'=>'search'),
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
			'renkebbahanmakanan' => array(self::BELONGS_TO, 'RenkebbahanmakananT', 'renkebbahanmakanan_id'),
			'bahanmakanan' => array(self::BELONGS_TO, 'BahanmakananM', 'bahanmakanan_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'renkebbahanmakanandet_id' => 'Renkebbahanmakanandet',
			'renkebbahanmakanan_id' => 'Renkebbahanmakanan',
			'bahanmakanan_id' => 'Bahanmakanan',
			'satuanbahan' => 'Satuanbahan',
			'jmlpermintaandet' => 'Jmlpermintaandet',
			'harga_barangdet' => 'Harga Barangdet',
			'stokakhir_bahanmakanan' => 'Stokakhir Bahanmakanan',
			'minstok_bahanmakanan' => 'Minstok Bahanmakanan',
			'makstok_bahanmakanan' => 'Makstok Bahanmakanan',
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

		$criteria->compare('renkebbahanmakanandet_id',$this->renkebbahanmakanandet_id);
		$criteria->compare('renkebbahanmakanan_id',$this->renkebbahanmakanan_id);
		$criteria->compare('bahanmakanan_id',$this->bahanmakanan_id);
		$criteria->compare('satuanbahan',$this->satuanbahan,true);
		$criteria->compare('jmlpermintaandet',$this->jmlpermintaandet);
		$criteria->compare('harga_barangdet',$this->harga_barangdet);
		$criteria->compare('stokakhir_bahanmakanan',$this->stokakhir_bahanmakanan);
		$criteria->compare('minstok_bahanmakanan',$this->minstok_bahanmakanan);
		$criteria->compare('makstok_bahanmakanan',$this->makstok_bahanmakanan);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}