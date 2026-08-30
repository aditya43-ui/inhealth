<?php

/**
 * This is the model class for table "scanpasiendarialat_t".
 *
 * The followings are the available columns in table 'scanpasiendarialat_t':
 * @property integer $scanpasiendarialat_id
 * @property integer $pasien_id
 * @property integer $pendaftaran_id
 * @property double $waktuscan
 * @property double $suhu_tubuh
 * @property boolean $pake_masker
 * @property string $data_gambar
 *
 * The followings are the available model relations:
 * @property PasienM $pasien
 * @property PendaftaranT $pendaftaran
 */
class ScanpasiendarialatT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ScanpasiendarialatT the static model class
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
		return 'scanpasiendarialat_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pasien_id, pendaftaran_id', 'required'),
			array('pasien_id, pendaftaran_id', 'numerical', 'integerOnly'=>true),
			array('waktuscan, suhu_tubuh', 'numerical'),
			array('pake_masker, data_gambar', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('scanpasiendarialat_id, pasien_id, pendaftaran_id, waktuscan, suhu_tubuh, pake_masker, data_gambar', 'safe', 'on'=>'search'),
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
			'pasien' => array(self::BELONGS_TO, 'PasienM', 'pasien_id'),
			'pendaftaran' => array(self::BELONGS_TO, 'PendaftaranT', 'pendaftaran_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'scanpasiendarialat_id' => 'Scanpasiendarialat',
			'pasien_id' => 'Pasien',
			'pendaftaran_id' => 'Pendaftaran',
			'waktuscan' => 'Waktuscan',
			'suhu_tubuh' => 'Suhu Tubuh',
			'pake_masker' => 'Pake Masker',
			'data_gambar' => 'Data Gambar',
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

		$criteria->compare('scanpasiendarialat_id',$this->scanpasiendarialat_id);
		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('waktuscan',$this->waktuscan);
		$criteria->compare('suhu_tubuh',$this->suhu_tubuh);
		$criteria->compare('pake_masker',$this->pake_masker);
		$criteria->compare('data_gambar',$this->data_gambar,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}