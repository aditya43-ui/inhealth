<?php

/**
 * This is the model class for table "janjipolitindakan_t".
 *
 * The followings are the available columns in table 'janjipolitindakan_t':
 * @property integer $janjipolitindakan_id
 * @property integer $buatjanjipoli_id
 * @property integer $daftartindakan_id
 * @property double $tarif_tindakan
 *
 * The followings are the available model relations:
 * @property BuatjanjipoliT $buatjanjipoli
 * @property DaftartindakanM $daftartindakan
 */
class JanjipolitindakanT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return JanjipolitindakanT the static model class
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
		return 'janjipolitindakan_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('buatjanjipoli_id, daftartindakan_id', 'numerical', 'integerOnly'=>true),
			array('tarif_tindakan', 'numerical'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('janjipolitindakan_id, buatjanjipoli_id, daftartindakan_id, tarif_tindakan', 'safe', 'on'=>'search'),
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
			'buatjanjipoli' => array(self::BELONGS_TO, 'BuatjanjipoliT', 'buatjanjipoli_id'),
			'daftartindakan' => array(self::BELONGS_TO, 'DaftartindakanM', 'daftartindakan_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'janjipolitindakan_id' => 'Janjipolitindakan',
			'buatjanjipoli_id' => 'Buatjanjipoli',
			'daftartindakan_id' => 'Daftartindakan',
			'tarif_tindakan' => 'Nominal Tarif',
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

		$criteria->compare('janjipolitindakan_id',$this->janjipolitindakan_id);
		$criteria->compare('buatjanjipoli_id',$this->buatjanjipoli_id);
		$criteria->compare('daftartindakan_id',$this->daftartindakan_id);
		$criteria->compare('tarif_tindakan',$this->tarif_tindakan);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}