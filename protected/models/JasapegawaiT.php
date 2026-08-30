<?php

/**
 * This is the model class for table "jasapegawai_t".
 *
 * The followings are the available columns in table 'jasapegawai_t':
 * @property integer $jasapegawai_id
 * @property integer $pegawai_id
 * @property integer $komponentarif_id
 * @property integer $tindakankomponen_id
 *
 * The followings are the available model relations:
 * @property PegawaiM $pegawai
 * @property KomponentarifM $komponentarif
 * @property TindakankomponenT $tindakankomponen
 */
class JasapegawaiT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return JasapegawaiT the static model class
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
		return 'jasapegawai_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pegawai_id, komponentarif_id, tindakankomponen_id', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('jasapegawai_id, pegawai_id, komponentarif_id, tindakankomponen_id', 'safe', 'on'=>'search'),
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
			'pegawai' => array(self::BELONGS_TO, 'PegawaiM', 'pegawai_id'),
			'komponentarif' => array(self::BELONGS_TO, 'KomponentarifM', 'komponentarif_id'),
			'tindakankomponen' => array(self::BELONGS_TO, 'TindakankomponenT', 'tindakankomponen_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'jasapegawai_id' => 'Jasapegawai',
			'pegawai_id' => 'Pegawai',
			'komponentarif_id' => 'Komponentarif',
			'tindakankomponen_id' => 'Tindakankomponen',
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

		$criteria->compare('jasapegawai_id',$this->jasapegawai_id);
		$criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->compare('komponentarif_id',$this->komponentarif_id);
		$criteria->compare('tindakankomponen_id',$this->tindakankomponen_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}