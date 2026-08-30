<?php

/**
 * This is the model class for table "laporanrealisasianggaranpenerimaan_v".
 *
 * The followings are the available columns in table 'laporanrealisasianggaranpenerimaan_v':
 * @property integer $renanggpenerimaan_id
 * @property string $noren_penerimaan
 * @property integer $konfiganggaran_id
 * @property string $deskripsiperiode
 * @property string $tglrenanggaranpen
 * @property integer $sumberanggaran_id
 * @property string $sumberanggarannama
 * @property double $nilaipenerimaananggaran
 * @property integer $realisasianggpenerimaan_id
 * @property double $realisasipenerimaan
 */
class LaporanrealisasianggaranpenerimaanV extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return LaporanrealisasianggaranpenerimaanV the static model class
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
		return 'laporanrealisasianggaranpenerimaan_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('renanggpenerimaan_id, konfiganggaran_id, sumberanggaran_id, realisasianggpenerimaan_id', 'numerical', 'integerOnly'=>true),
			array('nilaipenerimaananggaran, realisasipenerimaan', 'numerical'),
			array('noren_penerimaan', 'length', 'max'=>50),
			array('deskripsiperiode', 'length', 'max'=>100),
			array('sumberanggarannama', 'length', 'max'=>200),
			array('tglrenanggaranpen', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('renanggpenerimaan_id, noren_penerimaan, konfiganggaran_id, deskripsiperiode, tglrenanggaranpen, sumberanggaran_id, sumberanggarannama, nilaipenerimaananggaran, realisasianggpenerimaan_id, realisasipenerimaan', 'safe', 'on'=>'search'),
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
			'renanggpenerimaan_id' => 'Renanggpenerimaan',
			'noren_penerimaan' => 'Noren Penerimaan',
			'konfiganggaran_id' => 'Konfiganggaran',
			'deskripsiperiode' => 'Deskripsiperiode',
			'tglrenanggaranpen' => 'Tglrenanggaranpen',
			'sumberanggaran_id' => 'Sumberanggaran',
			'sumberanggarannama' => 'Sumberanggarannama',
			'nilaipenerimaananggaran' => 'Nilaipenerimaananggaran',
			'realisasianggpenerimaan_id' => 'Realisasianggpenerimaan',
			'realisasipenerimaan' => 'Realisasipenerimaan',
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

		$criteria->compare('renanggpenerimaan_id',$this->renanggpenerimaan_id);
		$criteria->compare('noren_penerimaan',$this->noren_penerimaan,true);
		$criteria->compare('konfiganggaran_id',$this->konfiganggaran_id);
		$criteria->compare('deskripsiperiode',$this->deskripsiperiode,true);
		$criteria->compare('tglrenanggaranpen',$this->tglrenanggaranpen,true);
		$criteria->compare('sumberanggaran_id',$this->sumberanggaran_id);
		$criteria->compare('sumberanggarannama',$this->sumberanggarannama,true);
		$criteria->compare('nilaipenerimaananggaran',$this->nilaipenerimaananggaran);
		$criteria->compare('realisasianggpenerimaan_id',$this->realisasianggpenerimaan_id);
		$criteria->compare('realisasipenerimaan',$this->realisasipenerimaan);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}