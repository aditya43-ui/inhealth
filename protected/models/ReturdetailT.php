<?php

/**
 * This is the model class for table "returdetail_t".
 *
 * The followings are the available columns in table 'returdetail_t':
 * @property integer $returdetail_id
 * @property integer $penerimaandetail_id
 * @property integer $obatalkes_id
 * @property integer $satuanbesar_id
 * @property integer $fakturdetail_id
 * @property integer $sumberdana_id
 * @property integer $returpembelian_id
 * @property integer $satuankecil_id
 * @property double $jmlretur
 * @property double $harganettoretur
 * @property double $hargappnretur
 * @property double $hargapphretur
 * @property double $jmldiscount
 * @property double $hargasatuanretur
 */
class ReturdetailT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ReturdetailT the static model class
	 */
         public $nofaktur;
         public $tgl_awal;
         public $tgl_akhir;
         public $namaObat;
         public $noFaktur;
         public $noRetur;
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'returdetail_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('returpembelian_id, jmlretur, harganettoretur, hargappnretur, hargapphretur, jmldiscount', 'required'),
			array('penerimaandetail_id, obatalkes_id, satuanbesar_id, fakturdetail_id, sumberdana_id, returpembelian_id, satuankecil_id', 'numerical', 'integerOnly'=>true),
			array('nofaktur, jmlretur, harganettoretur, hargappnretur, hargapphretur, jmldiscount, hargasatuanretur', 'numerical'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array(' tgl_awal, tgl_akhir, returdetail_id, penerimaandetail_id, obatalkes_id, satuanbesar_id, noFaktur, fakturdetail_id, sumberdana_id, returpembelian_id, satuankecil_id, jmlretur, harganettoretur, hargappnretur, hargapphretur, jmldiscount, hargasatuanretur', 'safe', 'on'=>'search'),
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
                    'retur'=>array(self::BELONGS_TO,'ReturpembelianT','returpembelian_id'),
                    'obatalkes'=>array(self::BELONGS_TO, 'ObatalkesM','obatalkes_id'),
                    'fakturdetail'=>array(self::BELONGS_TO, 'FakturdetailT','fakturdetail_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'returdetail_id' => 'Returdetail',
			'penerimaandetail_id' => 'Penerimaandetail',
			'obatalkes_id' => 'Obatalkes',
			'satuanbesar_id' => 'Satuanbesar',
			'fakturdetail_id' => 'Fakturdetail',
                        'nomorfaktur'=> 'Nomor Faktur',
			'sumberdana_id' => 'Sumberdana',
			'returpembelian_id' => 'Returpembelian',
			'satuankecil_id' => 'Satuankecil',
			'jmlretur' => 'Jmlretur',
			'harganettoretur' => 'Harganettoretur',
			'hargappnretur' => 'Hargappnretur',
			'hargapphretur' => 'Hargapphretur',
			'jmldiscount' => 'Jumlah Keringanan',
			'hargasatuanretur' => 'Hargasatuanretur',
                        'tgl_awal'=>'Tanggal Awal Retur',
                        'tgl_akhir'=>'Tanggal Akhir Retur',
                        'namaObat'=>'Nama Obat Alkes',
                        'noFaktur'=>'Nomor Faktur',
                        'noRetur'=>'Nomor Retur',
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

		$criteria->compare('returdetail_id',$this->returdetail_id);
		$criteria->compare('penerimaandetail_id',$this->penerimaandetail_id);
		$criteria->compare('obatalkes_id',$this->obatalkes_id);
		$criteria->compare('satuanbesar_id',$this->satuanbesar_id);
		$criteria->compare('fakturdetail_id',$this->fakturdetail_id);
		$criteria->compare('sumberdana_id',$this->sumberdana_id);
		$criteria->compare('returpembelian_id',$this->returpembelian_id);
		$criteria->compare('satuankecil_id',$this->satuankecil_id);
		$criteria->compare('jmlretur',$this->jmlretur);
		$criteria->compare('harganettoretur',$this->harganettoretur);
		$criteria->compare('hargappnretur',$this->hargappnretur);
		$criteria->compare('hargapphretur',$this->hargapphretur);
		$criteria->compare('jmldiscount',$this->jmldiscount);
		$criteria->compare('hargasatuanretur',$this->hargasatuanretur);
                
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		$criteria->compare('returdetail_id',$this->returdetail_id);
		$criteria->compare('penerimaandetail_id',$this->penerimaandetail_id);
		$criteria->compare('obatalkes_id',$this->obatalkes_id);
		$criteria->compare('satuanbesar_id',$this->satuanbesar_id);
		$criteria->compare('fakturdetail_id',$this->fakturdetail_id);
		$criteria->compare('sumberdana_id',$this->sumberdana_id);
		$criteria->compare('returpembelian_id',$this->returpembelian_id);
		$criteria->compare('satuankecil_id',$this->satuankecil_id);
		$criteria->compare('jmlretur',$this->jmlretur);
		$criteria->compare('harganettoretur',$this->harganettoretur);
		$criteria->compare('hargappnretur',$this->hargappnretur);
		$criteria->compare('hargapphretur',$this->hargapphretur);
		$criteria->compare('jmldiscount',$this->jmldiscount);
		$criteria->compare('hargasatuanretur',$this->hargasatuanretur);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
}