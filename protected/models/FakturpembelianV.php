<?php

/**
 * This is the model class for table "fakturpembelian_v".
 *
 * The followings are the available columns in table 'fakturpembelian_v':
 * @property integer $faktur_id
 * @property string $nofaktur
 * @property string $tglfaktur
 * @property double $totalnetto
 * @property double $pajakppn
 * @property double $pajakpph
 * @property double $totalhargabruto
 * @property integer $pajak_id
 * @property string $pajak_nama
 * @property string $typefaktur
 */
class FakturpembelianV extends CActiveRecord
{
    public $checklist, $jmlsetoran, $sisahutang, $keterangan;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return FakturpembelianV the static model class
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
		return 'fakturpembelian_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('faktur_id, pajak_id', 'numerical', 'integerOnly'=>true),
			array('totalnetto, pajakppn, pajakpph, totalhargabruto', 'numerical'),
			array('nofaktur', 'length', 'max'=>50),
			array('pajak_nama', 'length', 'max'=>100),
			array('tglfaktur, typefaktur', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('faktur_id, nofaktur, tglfaktur, totalnetto, pajakppn, pajakpph, totalhargabruto, pajak_id, pajak_nama, typefaktur', 'safe', 'on'=>'search'),
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
			'faktur_id' => 'Faktur',
			'nofaktur' => 'No. Faktur',
			'tglfaktur' => 'Tanggal Faktur',
			'totalnetto' => 'Totalnetto',
			'pajakppn' => 'Pajakppn',
			'pajakpph' => 'Pajakpph',
			'totalhargabruto' => 'Totalhargabruto',
			'pajak_id' => 'Pajak',
			'pajak_nama' => 'Pajak Nama',
			'typefaktur' => 'Typefaktur',
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

		$criteria->compare('faktur_id',$this->faktur_id);
		$criteria->compare('nofaktur',$this->nofaktur,true);
		$criteria->compare('tglfaktur',$this->tglfaktur,true);
		$criteria->compare('totalnetto',$this->totalnetto);
		$criteria->compare('pajakppn',$this->pajakppn);
		$criteria->compare('pajakpph',$this->pajakpph);
		$criteria->compare('totalhargabruto',$this->totalhargabruto);
		$criteria->compare('pajak_id',$this->pajak_id);
		$criteria->compare('pajak_nama',$this->pajak_nama,true);
		$criteria->compare('typefaktur',$this->typefaktur,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}