<?php

/**
 * This is the model class for table "informasikomposisibahanmakanan_v".
 *
 * The followings are the available columns in table 'informasikomposisibahanmakanan_v':
 * @property integer $bahanmakanan_id
 * @property string $kelbahanmakanan
 * @property string $namabahanmakanan
 * @property integer $zatbahanmakan_id
 * @property integer $zatgizi_id
 * @property double $kandunganbahan
 * @property double $kalori
 * @property double $protein
 * @property double $lemak
 * @property double $hidrat_arang
 * @property double $calsium
 * @property double $fosfor
 * @property double $fe
 * @property double $vit_a
 * @property double $vit_b1
 * @property double $vit_c
 * @property double $air
 * @property double $bkaroten
 */
class InformasikomposisibahanmakananV extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return InformasikomposisibahanmakananV the static model class
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
		return 'informasikomposisibahanmakanan_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('bahanmakanan_id, zatbahanmakan_id, zatgizi_id', 'numerical', 'integerOnly'=>true),
			array('kandunganbahan, kalori, protein, lemak, hidrat_arang, calsium, fosfor, fe, vit_a, vit_b1, vit_c, air, bkaroten', 'numerical'),
			array('kelbahanmakanan', 'length', 'max'=>50),
			array('namabahanmakanan', 'length', 'max'=>100),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('bahanmakanan_id, kelbahanmakanan, namabahanmakanan, zatbahanmakan_id, zatgizi_id, kandunganbahan, kalori, protein, lemak, hidrat_arang, calsium, fosfor, fe, vit_a, vit_b1, vit_c, air, bkaroten', 'safe', 'on'=>'search'),
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
			'bahanmakanan_id' => 'Bahanmakanan',
			'kelbahanmakanan' => 'Kelbahanmakanan',
			'namabahanmakanan' => 'Nama Bahan Makanan',
			'zatbahanmakan_id' => 'Zatbahanmakan',
			'zatgizi_id' => 'Zatgizi',
			'kandunganbahan' => 'Kandunganbahan',
			'kalori' => 'Kalori',
			'protein' => 'Protein',
			'lemak' => 'Lemak',
			'hidrat_arang' => 'Hidrat Arang',
			'calsium' => 'Calsium',
			'fosfor' => 'Fosfor',
			'fe' => 'Fe',
			'vit_a' => 'Vit A',
			'vit_b1' => 'Vit B1',
			'vit_c' => 'Vit C',
			'air' => 'Air',
			'bkaroten' => 'Bkaroten',
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

		$criteria->compare('bahanmakanan_id',$this->bahanmakanan_id);
		$criteria->compare('kelbahanmakanan',$this->kelbahanmakanan,true);
		$criteria->compare('namabahanmakanan',$this->namabahanmakanan,true);
		$criteria->compare('zatbahanmakan_id',$this->zatbahanmakan_id);
		$criteria->compare('zatgizi_id',$this->zatgizi_id);
		$criteria->compare('kandunganbahan',$this->kandunganbahan);
		$criteria->compare('kalori',$this->kalori);
		$criteria->compare('protein',$this->protein);
		$criteria->compare('lemak',$this->lemak);
		$criteria->compare('hidrat_arang',$this->hidrat_arang);
		$criteria->compare('calsium',$this->calsium);
		$criteria->compare('fosfor',$this->fosfor);
		$criteria->compare('fe',$this->fe);
		$criteria->compare('vit_a',$this->vit_a);
		$criteria->compare('vit_b1',$this->vit_b1);
		$criteria->compare('vit_c',$this->vit_c);
		$criteria->compare('air',$this->air);
		$criteria->compare('bkaroten',$this->bkaroten);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}