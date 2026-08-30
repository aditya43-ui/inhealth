<?php

/**
 * This is the model class for table "penerimaandarahpmidet_t".
 *
 * The followings are the available columns in table 'penerimaandarahpmidet_t':
 * @property integer $penerimaandarahpmidet_id
 * @property integer $penerimaandarahpmi_id
 * @property integer $jeniskomponendarah_id
 * @property string $golongandarah
 * @property string $rhesus
 * @property integer $jumlah_permintaan
 * @property integer $jumlah_terima
 * @property string $keterangan_det
 * 
 * @author Deni Hamdani <denihamdani@piindonesia.co.id>
 * @package application.models
 */
class PenerimaandarahpmidetT extends CActiveRecord
{
	public $jeniskomponendarah_nama;
    public $komponendarah_id, $tglkadaluarsa, $tglaftap;
    public $jumlah;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PenerimaandarahpmidetT the static model class
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
		return 'penerimaandarahpmidet_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('penerimaandarahpmi_id, jeniskomponendarah_id, jumlah_permintaan, jumlah_terima', 'numerical', 'integerOnly'=>true),
			array('golongandarah, rhesus, keterangan_det', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('penerimaandarahpmidet_id, penerimaandarahpmi_id, jeniskomponendarah_id, golongandarah, rhesus, jumlah_permintaan, jumlah_terima, keterangan_det', 'safe', 'on'=>'search'),
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
			'penerimaandarahpmidet_id' => 'Penerimaandarahpmidet',
			'penerimaandarahpmi_id' => 'Penerimaandarahpmi',
			'jeniskomponendarah_id' => 'Jeniskomponendarah',
			'golongandarah' => 'Golongandarah',
			'rhesus' => 'Rhesus',
			'jumlah_permintaan' => 'Jumlah Permintaan',
			'jumlah_terima' => 'Jumlah Terima',
			'keterangan_det' => 'Keterangan Det',
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

		$criteria->compare('penerimaandarahpmidet_id',$this->penerimaandarahpmidet_id);
		$criteria->compare('penerimaandarahpmi_id',$this->penerimaandarahpmi_id);
		$criteria->compare('jeniskomponendarah_id',$this->jeniskomponendarah_id);
		$criteria->compare('golongandarah',$this->golongandarah,true);
		$criteria->compare('rhesus',$this->rhesus,true);
		$criteria->compare('jumlah_permintaan',$this->jumlah_permintaan);
		$criteria->compare('jumlah_terima',$this->jumlah_terima);
		$criteria->compare('keterangan_det',$this->keterangan_det,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}