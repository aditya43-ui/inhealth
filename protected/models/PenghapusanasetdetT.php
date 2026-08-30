<?php

/**
 * This is the model class for table "penghapusanasetdet_t".
 *
 * The followings are the available columns in table 'penghapusanasetdet_t':
 * @property integer $penghapusanasetdet_id
 * @property integer $penghapusanaset_id
 * @property integer $invperalatan_id
 * @property integer $pengeluaranaset_id
 */
class PenghapusanasetdetT extends CActiveRecord
{
        public $ispilih;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PenghapusanasetdetT the static model class
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
		return 'penghapusanasetdet_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('penghapusanaset_id, invperalatan_id, pengeluaranaset_id', 'required'),
			array('penghapusanaset_id, invperalatan_id, pengeluaranaset_id', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('penghapusanasetdet_id, penghapusanaset_id, invperalatan_id, pengeluaranaset_id', 'safe', 'on'=>'search'),
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
			'penghapusanasetdet_id' => 'Penghapusanasetdet',
			'penghapusanaset_id' => 'Penghapusanaset',
			'invperalatan_id' => 'Invperalatan',
			'pengeluaranaset_id' => 'Pengeluaranaset',
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

		$criteria->compare('penghapusanasetdet_id',$this->penghapusanasetdet_id);
		$criteria->compare('penghapusanaset_id',$this->penghapusanaset_id);
		$criteria->compare('invperalatan_id',$this->invperalatan_id);
		$criteria->compare('pengeluaranaset_id',$this->pengeluaranaset_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}