<?php

/**
 * This is the model class for table "golongangaji_m".
 *
 * The followings are the available columns in table 'golongangaji_m':
 * @property integer $golongangaji_id
 * @property integer $golonganpegawai_id
 * @property integer $masakerja
 * @property double $jmlgaji
 * @property string $jenisgolongan
 * @property boolean $golongangaji_aktif
 */
class SAKomponengajirekM extends KomponengajirekM
{
	public $komponen_gaji,$rekening,$jenis,$komponengaji_nama,$nmrekening5;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return GolonganGajiM the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('komponengaji_id, rekening5_id', 'required'),
			array('komponengaji_id, rekening5_id', 'numerical', 'integerOnly'=>true),
			array('debitkredit', 'length', 'max'=>1),
			array('ispenggajian, ispembayarangaji', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('komponengajirek_id, komponengaji_id, rekening5_id, ispenggajian, ispembayarangaji, debitkredit', 'safe', 'on'=>'search'),
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
			'komponengaji' => array(self::BELONGS_TO, 'KomponengajiM', 'komponengaji_id'),
			'rekening5' => array(self::BELONGS_TO, 'Rekening5M', 'rekening5_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'komponengajirek_id' => 'ID',
			'komponengaji_id' => 'Komponen Gaji',
			'rekening5_id' => 'Rekening',
			'ispenggajian' => 'Penggajian',
			'ispembayarangaji' => 'Pembayaran Gaji',
			'debitkredit' => 'Debit / Kredit',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CdbCriteria that can return criterias.
	 */
	public function criteriaSearch() {
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria = new CDbCriteria;
		$criteria->with = array('komponengaji','rekening5');
		if (!empty($this->komponengajirek_id)) {
			$criteria->addCondition('komponengajirek_id = ' . $this->komponengajirek_id);
		}

		if (!empty($this->rekening5_id)) {
			$criteria->addCondition('rekening5_id = ' . $this->rekening5_id);
		}
		if (!empty($this->nmrekening5)) {
			$criteria->compare('LOWER(rekening5.nmrekening5)', strtolower($this->nmrekening5), true);
		}
		if (!empty($this->rekening)) {
			$criteria->compare('LOWER(rekening5.nmrekening5)', strtolower($this->rekening), true);
		}
		if (!empty($this->komponengaji_id)) {
			$criteria->addCondition('t.komponengaji_id = ' . $this->komponengaji_id);
		}
		if (!empty($this->komponengaji_nama)) {
			$criteria->compare('LOWER(komponengaji.komponengaji_nama)', strtolower($this->komponengaji_nama), true);
		}
		if (!empty($this->komponen_gaji)) {
			$criteria->compare('LOWER(komponengaji.komponengaji_nama)', strtolower($this->komponen_gaji), true);
		}

		if (!empty($this->debitkredit)) {
			$criteria->compare('LOWER(debitkredit)', strtolower($this->debitkredit), true);
		}
		
		if($this->ispenggajian == 1 || $this->jenis == 'ispenggajian'){
			$criteria->addCondition('ispenggajian = TRUE');
		}
		if($this->ispembayarangaji == 1 || $this->jenis == 'ispembayarangaji'){
			$criteria->addCondition('ispembayarangaji = TRUE');
		}
		
		return $criteria;
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search() {
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.
		$criteria = $this->criteriaSearch();
		$criteria->limit = 10;

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}

	public function searchPrint() {
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria = $this->criteriaSearch();
		$criteria->limit = -1;

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
			'pagination' => false,
		));
	}
}