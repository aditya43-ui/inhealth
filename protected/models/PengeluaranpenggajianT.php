<?php

/**
 * This is the model class for table "pengeluaranpenggajian_t".
 *
 * The followings are the available columns in table 'pengeluaranpenggajian_t':
 * @property integer $pengeluaranumum_id
 * @property integer $penggajianpeg_id
 */
class PengeluaranpenggajianT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PengeluaranpenggajianT the static model class
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
		return 'pengeluaranpenggajian_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pengeluaranumum_id, penggajianpeg_id', 'required'),
			array('pengeluaranumum_id, penggajianpeg_id', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('pengeluaranumum_id, penggajianpeg_id', 'safe', 'on'=>'search'),
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
			'pengeluaranumum_id' => 'Pengeluaranumum',
			'penggajianpeg_id' => 'Penggajianpeg',
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

		$criteria->compare('pengeluaranumum_id',$this->pengeluaranumum_id);
		$criteria->compare('penggajianpeg_id',$this->penggajianpeg_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}