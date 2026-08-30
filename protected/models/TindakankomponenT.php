<?php

/**
 * This is the model class for table "tindakankomponen_t".
 *
 * The followings are the available columns in table 'tindakankomponen_t':
 * @property integer $tindakankomponen_id
 * @property integer $tindakanpelayanan_id
 * @property integer $komponentarif_id
 * @property double $tarif_tindakankomp
 * @property double $tarifcyto_tindakankomp
 * @property double $subsidiasuransikomp
 * @property double $subsidipemerintahkomp
 * @property double $subsidirumahsakitkomp
 * @property double $iurbiayakomp
 * @property double $tarif_kompsatuan
 */
class TindakankomponenT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return TindakankomponenT the static model class
	 */
	public static function model($className = __CLASS__)
	{
		return parent::model($className);
	}
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tindakankomponen_t';
	}
	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('tindakanpelayanan_id, komponentarif_id, tarif_tindakankomp, tarifcyto_tindakankomp, subsidiasuransikomp, subsidipemerintahkomp, subsidirumahsakitkomp, iurbiayakomp', 'required'),
			array('tindakanpelayanan_id, komponentarif_id', 'numerical', 'integerOnly'=>true),
			array('tarif_tindakankomp, tarifcyto_tindakankomp, subsidiasuransikomp, subsidipemerintahkomp, subsidirumahsakitkomp, iurbiayakomp, discountkomptindakan', 'numerical'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('tindakankomponen_id, tindakanpelayanan_id, komponentarif_id, tarif_tindakankomp, tarifcyto_tindakankomp, subsidiasuransikomp, subsidipemerintahkomp, subsidirumahsakitkomp, iurbiayakomp, discountkomptindakan', 'safe', 'on'=>'search'),
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
			'komponentarif' => array(self::BELONGS_TO, 'KomponentarifM', 'komponentarif_id'),
			'tindakanpelayanan' => array(self::BELONGS_TO, 'TindakanpelayananT', 'tindakanpelayanan_id'),
		);
	}
	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'tindakankomponen_id' => 'ID Tindakan Komponen',
			'tindakanpelayanan_id' => 'Tindakan Pelayanan',
			'komponentarif_id' => 'Tarif Komponen',
			'tarif_tindakankomp' => 'Nominal Tarif Komponen',
			'tarifcyto_tindakankomp' => 'Tarif Cyto',
			'subsidiasuransikomp' => 'Tanggungan Asuransi',
			'subsidipemerintahkomp' => 'Tanggungan Pemerintah',
			'subsidirumahsakitkomp' => 'Tanggungan Rumah Sakit',
			'iurbiayakomp' => 'Iur Biaya',
			'tarif_kompsatuan' => 'Tarif Komponen Satuan',
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
		$criteria = new CDbCriteria;
		$criteria->compare('tindakankomponen_id', $this->tindakankomponen_id);
		$criteria->compare('tindakanpelayanan_id', $this->tindakanpelayanan_id);
		$criteria->compare('komponentarif_id', $this->komponentarif_id);
		$criteria->compare('tarif_tindakankomp', $this->tarif_tindakankomp);
		$criteria->compare('tarifcyto_tindakankomp', $this->tarifcyto_tindakankomp);
		$criteria->compare('subsidiasuransikomp', $this->subsidiasuransikomp);
		$criteria->compare('subsidipemerintahkomp', $this->subsidipemerintahkomp);
		$criteria->compare('subsidirumahsakitkomp', $this->subsidirumahsakitkomp);
		$criteria->compare('iurbiayakomp', $this->iurbiayakomp);
		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}
	public function searchPrint()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.
		$criteria = new CDbCriteria;
		$criteria->compare('tindakankomponen_id', $this->tindakankomponen_id);
		$criteria->compare('tindakanpelayanan_id', $this->tindakanpelayanan_id);
		$criteria->compare('komponentarif_id', $this->komponentarif_id);
		$criteria->compare('tarif_tindakankomp', $this->tarif_tindakankomp);
		$criteria->compare('tarifcyto_tindakankomp', $this->tarifcyto_tindakankomp);
		$criteria->compare('subsidiasuransikomp', $this->subsidiasuransikomp);
		$criteria->compare('subsidipemerintahkomp', $this->subsidipemerintahkomp);
		$criteria->compare('subsidirumahsakitkomp', $this->subsidirumahsakitkomp);
		$criteria->compare('iurbiayakomp', $this->iurbiayakomp);
		// Klo limit lebih kecil dari nol itu berarti ga ada limit 
		$criteria->limit = -1;
		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
			'pagination' => false,
		));
	}
}
