<?php

/**
 * This is the model class for table "riwayatkelahiran_t".
 *
 * The followings are the available columns in table 'riwayatkelahiran_t':
 * @property integer $riwayatkelahiran_id
 * @property integer $pemeriksaanginekologi_id
 * @property integer $anak_ke
 * @property string $keterangan
 *
 * The followings are the available model relations:
 * @property PasienM $pemeriksaanginekologi
 */
class RiwayatkelahiranT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return RiwayatkelahiranT the static model class
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
		return 'riwayatkelahiran_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pemeriksaanginekologi_id', 'required'),
			array('pemeriksaanginekologi_id, anak_ke', 'numerical', 'integerOnly'=>true),
			array('keterangan', 'length', 'max'=>100),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('riwayatkelahiran_id, pemeriksaanginekologi_id, anak_ke, keterangan', 'safe', 'on'=>'search'),
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
			'pemeriksaanginekologi' => array(self::BELONGS_TO, 'PasienM', 'pemeriksaanginekologi_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'riwayatkelahiran_id' => 'Riwayatkelahiran',
			'pemeriksaanginekologi_id' => 'Pemeriksaanginekologi',
			'anak_ke' => 'Anak Ke',
			'keterangan' => 'Keterangan',
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

		$criteria->compare('riwayatkelahiran_id',$this->riwayatkelahiran_id);
		$criteria->compare('pemeriksaanginekologi_id',$this->pemeriksaanginekologi_id);
		$criteria->compare('anak_ke',$this->anak_ke);
		$criteria->compare('keterangan',$this->keterangan,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}