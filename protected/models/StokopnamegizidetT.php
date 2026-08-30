<?php

/**
 * This is the model class for table "stokopnamegizidet_t".
 *
 * The followings are the available columns in table 'stokopnamegizidet_t':
 * @property integer $stokopnamegizidet_id
 * @property integer $formuliropnamegizidet_id
 * @property integer $stokopnamegizi_id
 * @property integer $bahanmakanan_id
 * @property double $volume_fisik
 * @property double $volume_sistem
 * @property string $tglkadaluarsabahan
 * @property string $kondisibarang
 * @property string $tglperiksafisik
 * @property double $jmlselisihstok
 *
 * The followings are the available model relations:
 * @property StokopnamegiziT $stokopnamegizi
 * @property BahanmakananM $bahanmakanan
 */
class StokopnamegizidetT extends CActiveRecord
{
    public $jenisbahanmakanan;
    public $namabahanmakanan;
    public $golbahanmakanan_nama, $kelbahanmakanan;
    public $qtystok;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return StokopnamegizidetT the static model class
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
		return 'stokopnamegizidet_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('stokopnamegizi_id, bahanmakanan_id, volume_fisik, volume_sistem, kondisibarang', 'required'),
			array('formuliropnamegizidet_id, stokopnamegizi_id, bahanmakanan_id', 'numerical', 'integerOnly'=>true),
			array('volume_fisik, volume_sistem, jmlselisihstok, totalnilaipersediaan', 'numerical'),
			array('kondisibarang', 'length', 'max'=>50),
			array('tglkadaluarsabahan, tglperiksafisik, tglkadaluarsa', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('stokopnamegizidet_id, formuliropnamegizidet_id, stokopnamegizi_id, bahanmakanan_id, volume_fisik, volume_sistem, tglkadaluarsabahan, kondisibarang, tglperiksafisik, jmlselisihstok, tglkadaluarsa, totalnilaipersediaan', 'safe', 'on'=>'search'),
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
			'stokopnamegizi' => array(self::BELONGS_TO, 'StokopnamegiziT', 'stokopnamegizi_id'),
			'bahanmakanan' => array(self::BELONGS_TO, 'BahanmakananM', 'bahanmakanan_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'stokopnamegizidet_id' => 'Stokopnamegizidet',
			'formuliropnamegizidet_id' => 'Formstokopname',
			'stokopnamegizi_id' => 'Stokopnamegizi',
			'bahanmakanan_id' => 'Bahanmakanan',
			'volume_fisik' => 'Volume Fisik',
			'volume_sistem' => 'Volume Sistem',
			'tglkadaluarsabahan' => 'Tglkadaluarsabahan',
			'kondisibarang' => 'Kondisibarang',
			'tglperiksafisik' => 'Tglperiksafisik',
			'jmlselisihstok' => 'Jmlselisihstok',
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

		$criteria->compare('stokopnamegizidet_id',$this->stokopnamegizidet_id);
		$criteria->compare('formuliropnamegizidet_id',$this->formuliropnamegizidet_id);
		$criteria->compare('stokopnamegizi_id',$this->stokopnamegizi_id);
		$criteria->compare('bahanmakanan_id',$this->bahanmakanan_id);
		$criteria->compare('volume_fisik',$this->volume_fisik);
		$criteria->compare('volume_sistem',$this->volume_sistem);
		$criteria->compare('tglkadaluarsabahan',$this->tglkadaluarsabahan,true);
		$criteria->compare('kondisibarang',$this->kondisibarang,true);
		$criteria->compare('tglperiksafisik',$this->tglperiksafisik,true);
		$criteria->compare('jmlselisihstok',$this->jmlselisihstok);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}