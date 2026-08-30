<?php

/**
 * This is the model class for table "pemakaianbhnmkndet_t".
 *
 * The followings are the available columns in table 'pemakaianbhnmkndet_t':
 * @property integer $pemakaianbhnmkndet_id
 * @property integer $pemakaianbhnmkn_id
 * @property integer $bahanmakanan_id
 * @property double $jmlpemakaianbhnmkn
 *
 * The followings are the available model relations:
 * @property PemakaianbhnmknT $pemakaianbhnmkn
 * @property BahanmakananM $bahanmakanan
 */
class PemakaianbhnmkndetT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PemakaianbhnmkndetT the static model class
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
		return 'pemakaianbhnmkndet_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pemakaianbhnmkn_id, bahanmakanan_id, jmlpemakaianbhnmkn', 'required'),
			array('pemakaianbhnmkn_id, bahanmakanan_id', 'numerical', 'integerOnly'=>true),
			array('jmlpemakaianbhnmkn', 'numerical'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('pemakaianbhnmkndet_id, pemakaianbhnmkn_id, bahanmakanan_id, jmlpemakaianbhnmkn', 'safe', 'on'=>'search'),
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
			'pemakaianbhnmkn' => array(self::BELONGS_TO, 'PemakaianbhnmknT', 'pemakaianbhnmkn_id'),
			'bahanmakanan' => array(self::BELONGS_TO, 'BahanmakananM', 'bahanmakanan_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'pemakaianbhnmkndet_id' => 'Pemakaianbhnmkndet',
			'pemakaianbhnmkn_id' => 'Pemakaianbhnmkn',
			'bahanmakanan_id' => 'Bahanmakanan',
			'jmlpemakaianbhnmkn' => 'Jmlpemakaianbhnmkn',
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

		$criteria->compare('pemakaianbhnmkndet_id',$this->pemakaianbhnmkndet_id);
		$criteria->compare('pemakaianbhnmkn_id',$this->pemakaianbhnmkn_id);
		$criteria->compare('bahanmakanan_id',$this->bahanmakanan_id);
		$criteria->compare('jmlpemakaianbhnmkn',$this->jmlpemakaianbhnmkn);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}