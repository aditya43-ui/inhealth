<?php

/**
 * This is the model class for table "persenkelkomponentarif_m".
 *
 * The followings are the available columns in table 'persenkelkomponentarif_m':
 * @property integer $komponentarif_id
 * @property integer $kelompokkomponentarif_id
 * @property double $persentase
 */
class PersenkelkomponentarifM extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PersenkelkomponentarifM the static model class
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
		return 'persenkelkomponentarif_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('komponentarif_id, kelompokkomponentarif_id', 'required'),
			array('komponentarif_id, kelompokkomponentarif_id', 'numerical', 'integerOnly'=>true),
			array('persentase', 'numerical'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('komponentarif_id, kelompokkomponentarif_id, persentase', 'safe', 'on'=>'search'),
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
                    'kelompokkomponentarif'=>array(self::BELONGS_TO, 'KelompokkomponentarifM', 'kelompokkomponentarif_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'komponentarif_id' => 'Komponentarif',
			'kelompokkomponentarif_id' => 'Kelompokkomponentarif',
			'persentase' => 'Persentase',
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

		$criteria->compare('komponentarif_id',$this->komponentarif_id);
		$criteria->compare('kelompokkomponentarif_id',$this->kelompokkomponentarif_id);
		$criteria->compare('persentase',$this->persentase);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}