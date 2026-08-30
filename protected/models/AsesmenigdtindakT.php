<?php

/**
 * This is the model class for table "asesmenigdtindak_t".
 *
 * The followings are the available columns in table 'asesmenigdtindak_t':
 * @property integer $asesmenigdtindak_id
 * @property string $asesmenigdtindak_tgl
 * @property integer $asesmenpasienigd_id
 * @property integer $daftartindakan_id
 * @property string $tindakan_nama
 * @property integer $tindakan_oleh
 *
 * The followings are the available model relations:
 * @property AsesmenpasienigdT $asesmenpasienigd
 */
class AsesmenigdtindakT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return AsesmenigdtindakT the static model class
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
		return 'asesmenigdtindak_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('asesmenigdtindak_tgl, asesmenpasienigd_id, tindakan_oleh', 'required'),
			array('asesmenpasienigd_id, daftartindakan_id, tindakan_oleh', 'numerical', 'integerOnly'=>true),
			array('tindakan_nama', 'length', 'max'=>250),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('asesmenigdtindak_id, asesmenigdtindak_tgl, asesmenpasienigd_id, daftartindakan_id, tindakan_nama, tindakan_oleh', 'safe', 'on'=>'search'),
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
			'asesmenpasienigd' => array(self::BELONGS_TO, 'AsesmenpasienigdT', 'asesmenpasienigd_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'asesmenigdtindak_id' => 'Asesmenigdtindak',
			'asesmenigdtindak_tgl' => 'Asesmenigdtindak Tgl',
			'asesmenpasienigd_id' => 'Asesmenpasienigd',
			'daftartindakan_id' => 'Daftartindakan',
			'tindakan_nama' => 'Tindakan Nama',
			'tindakan_oleh' => 'Tindakan Oleh',
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

		$criteria->compare('asesmenigdtindak_id',$this->asesmenigdtindak_id);
		$criteria->compare('asesmenigdtindak_tgl',$this->asesmenigdtindak_tgl,true);
		$criteria->compare('asesmenpasienigd_id',$this->asesmenpasienigd_id);
		$criteria->compare('daftartindakan_id',$this->daftartindakan_id);
		$criteria->compare('tindakan_nama',$this->tindakan_nama,true);
		$criteria->compare('tindakan_oleh',$this->tindakan_oleh);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}