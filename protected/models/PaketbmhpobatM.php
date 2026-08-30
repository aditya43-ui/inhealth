<?php

/**
 * This is the model class for table "paketbmhpobat_m".
 *
 * The followings are the available columns in table 'paketbmhpobat_m':
 * @property integer $paketbmhptindakan_id
 * @property integer $obatalkes_id
 * @property integer $qty
 * @property double $tarifsatuan
 * @property double $totaltarif
 *
 * The followings are the available model relations:
 * @property ObatalkesM $obatalkes
 */
class PaketbmhpobatM extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'paketbmhpobat_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('obatalkes_id', 'required'),
			array('obatalkes_id, qty', 'numerical', 'integerOnly'=>true),
			array('tarifsatuan, totaltarif', 'numerical'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('paketbmhptindakan_id, obatalkes_id, qty, tarifsatuan, totaltarif', 'safe', 'on'=>'search'),
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
			'paketbmhp' => array(self::BELONGS_TO, 'PaketbmhpM', 'paketbmhp_id'),
			'obatalkes' => array(self::BELONGS_TO, 'ObatalkesM', 'obatalkes_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'paketbmhptindakan_id' => 'Paketbmhptindakan',
			'obatalkes_id' => 'Obatalkes',
			'qty' => 'Qty',
			'tarifsatuan' => 'Tarifsatuan',
			'totaltarif' => 'Totaltarif',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('paketbmhptindakan_id',$this->paketbmhptindakan_id);
		$criteria->compare('obatalkes_id',$this->obatalkes_id);
		$criteria->compare('qty',$this->qty);
		$criteria->compare('tarifsatuan',$this->tarifsatuan);
		$criteria->compare('totaltarif',$this->totaltarif);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return PaketbmhpobatM the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
