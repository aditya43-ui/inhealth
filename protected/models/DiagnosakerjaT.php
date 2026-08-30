<?php

/**
 * This is the model class for table "diagnosakerja_t".
 *
 * The followings are the available columns in table 'diagnosakerja_t':
 * @property integer $diagnosakerja_id
 * @property integer $pemeriksaanfisik_id
 * @property string $diagnosakerja_isi
 *
 * The followings are the available model relations:
 * @property PemeriksaanfisikT $pemeriksaanfisik
 */
class DiagnosakerjaT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return DiagnosakerjaT the static model class
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
		return 'diagnosakerja_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pemeriksaanfisik_id', 'required'),
			array('pemeriksaanfisik_id', 'numerical', 'integerOnly'=>true),
			array('diagnosakerja_isi', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('diagnosakerja_id, pemeriksaanfisik_id, diagnosakerja_isi', 'safe', 'on'=>'search'),
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
			'pemeriksaanfisik' => array(self::BELONGS_TO, 'PemeriksaanfisikT', 'pemeriksaanfisik_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'diagnosakerja_id' => 'Diagnosakerja',
			'pemeriksaanfisik_id' => 'Pemeriksaanfisik',
			'diagnosakerja_isi' => 'Diagnosakerja Isi',
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

		$criteria->compare('diagnosakerja_id',$this->diagnosakerja_id);
		$criteria->compare('pemeriksaanfisik_id',$this->pemeriksaanfisik_id);
		$criteria->compare('diagnosakerja_isi',$this->diagnosakerja_isi,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}