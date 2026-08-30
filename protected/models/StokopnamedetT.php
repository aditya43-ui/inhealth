<?php

/**
 * This is the model class for table "stokopnamedet_t".
 *
 * The followings are the available columns in table 'stokopnamedet_t':
 * @property integer $stokopnamedet_id
 * @property integer $formstokopname_id
 * @property integer $satuankecil_id
 * @property integer $sumberdana_id
 * @property integer $stokopname_id
 * @property integer $obatalkes_id
 * @property double $volume_fisik
 * @property double $volume_sistem
 * @property double $hargasatuan
 * @property double $jumlahharga
 * @property double $harganetto
 * @property double $jumlahnetto
 * @property string $tglkadaluarsa
 * @property string $kondisibarang
 * @property string $tglperiksafisik
 * @property double $jmlselisihstok
 *
 * The followings are the available model relations:
 * @property FormstokopnameR[] $formstokopnameRs
 * @property FormstokopnameR $formstokopname
 * @property ObatalkesM $obatalkes
 * @property SatuankecilM $satuankecil
 * @property StokopnameT $stokopname
 * @property SumberdanaM $sumberdana
 * @property StokobatalkesT[] $stokobatalkesTs
 */
class StokopnamedetT extends CActiveRecord
{
  public $hpp;
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return StokopnamedetT the static model class
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
        return 'stokopnamedet_t';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('satuankecil_id, sumberdana_id, stokopname_id, obatalkes_id, volume_fisik, volume_sistem, hargasatuan, jumlahharga, harganetto, jumlahnetto, kondisibarang', 'required'),
            array('formstokopname_id, satuankecil_id, sumberdana_id, stokopname_id, obatalkes_id', 'numerical', 'integerOnly'=>true),
            array('volume_fisik, volume_sistem, hargasatuan, jumlahharga, harganetto, jumlahnetto, jmlselisihstok, totalnilaipersediaan', 'numerical'),
            array('kondisibarang', 'length', 'max'=>50),
            array('tglkadaluarsa, tglperiksafisik', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('stokopnamedet_id, formstokopname_id, satuankecil_id, sumberdana_id, stokopname_id, obatalkes_id, volume_fisik, volume_sistem, hargasatuan, jumlahharga, harganetto, jumlahnetto, tglkadaluarsa, kondisibarang, tglperiksafisik, jmlselisihstok, totalnilaipersediaan', 'safe', 'on'=>'search'),
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
            'formstokopnameRs' => array(self::HAS_MANY, 'FormstokopnameR', 'stokopnamedet_id'),
            'formstokopname' => array(self::BELONGS_TO, 'FormstokopnameR', 'formstokopname_id'),
            'obatalkes' => array(self::BELONGS_TO, 'ObatalkesM', 'obatalkes_id'),
            'satuankecil' => array(self::BELONGS_TO, 'SatuankecilM', 'satuankecil_id'),
            'stokopname' => array(self::BELONGS_TO, 'StokopnameT', 'stokopname_id'),
            'sumberdana' => array(self::BELONGS_TO, 'SumberdanaM', 'sumberdana_id'),
            'stokobatalkesTs' => array(self::HAS_MANY, 'StokobatalkesT', 'stokopnamedet_id'),
        );
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'stokopnamedet_id' => 'Stock Opname Det',
			'formstokopname_id' => 'Form Stock Opname',
			'satuankecil_id' => 'Satuan Kecil',
			'sumberdana_id' => 'Sumber Dana',
			'stokopname_id' => 'Stock Opname',
			'obatalkes_id' => 'Obat Alkes',
			'volume_fisik' => 'Volume Fisik',
			'volume_sistem' => 'Volume Sistem',
			'hargasatuan' => 'Harga Satuan',
			'jumlahharga' => 'Jumlah Harga',
			'harganetto' => 'Harga Netto',
			'jumlahnetto' => 'Jumlah Netto',
			'tglkadaluarsa' => 'Tanggal Kedaluwarsa',
			'kondisibarang' => 'Kondisi Barang',
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

		$criteria->compare('stokopnamedet_id',$this->stokopnamedet_id);
		$criteria->compare('formstokopname_id',$this->formstokopname_id);
		$criteria->compare('satuankecil_id',$this->satuankecil_id);
		$criteria->compare('sumberdana_id',$this->sumberdana_id);
		$criteria->compare('stokopname_id',$this->stokopname_id);
		$criteria->compare('obatalkes_id',$this->obatalkes_id);
		$criteria->compare('volume_fisik',$this->volume_fisik);
		$criteria->compare('volume_sistem',$this->volume_sistem);
		$criteria->compare('hargasatuan',$this->hargasatuan);
		$criteria->compare('jumlahharga',$this->jumlahharga);
		$criteria->compare('harganetto',$this->harganetto);
		$criteria->compare('jumlahnetto',$this->jumlahnetto);
		$criteria->compare('LOWER(tglkadaluarsa)',strtolower($this->tglkadaluarsa),true);
		$criteria->compare('LOWER(kondisibarang)',strtolower($this->kondisibarang),true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}


        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		$criteria->compare('stokopnamedet_id',$this->stokopnamedet_id);
		$criteria->compare('formstokopname_id',$this->formstokopname_id);
		$criteria->compare('satuankecil_id',$this->satuankecil_id);
		$criteria->compare('sumberdana_id',$this->sumberdana_id);
		$criteria->compare('stokopname_id',$this->stokopname_id);
		$criteria->compare('obatalkes_id',$this->obatalkes_id);
		$criteria->compare('volume_fisik',$this->volume_fisik);
		$criteria->compare('volume_sistem',$this->volume_sistem);
		$criteria->compare('hargasatuan',$this->hargasatuan);
		$criteria->compare('jumlahharga',$this->jumlahharga);
		$criteria->compare('harganetto',$this->harganetto);
		$criteria->compare('jumlahnetto',$this->jumlahnetto);
		$criteria->compare('LOWER(tglkadaluarsa)',strtolower($this->tglkadaluarsa),true);
		$criteria->compare('LOWER(kondisibarang)',strtolower($this->kondisibarang),true);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit
                $criteria->limit=-1;

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }

//        HINDARI PENGGUNAAN AFTERFIND / BEFORE VALIDATE / BEFORE SAVE
//        protected function beforeValidate ()
//        {
//            // convert to storage format
//            //$this->tglrevisimodul = date ('Y-m-d', strtotime($this->tglrevisimodul));
//            $format = new MyFormatter();
//            //$this->tglrevisimodul = $format->formatDateTimeForDb($this->tglrevisimodul);
//            foreach($this->metadata->tableSchema->columns as $columnName => $column){
//                    if ($column->dbType == 'date')
//                        {
//                            $this->$columnName = $format->formatDateTimeForDb($this->$columnName);
//                        }
//                    else if ( $column->dbType == 'timestamp without time zone')
//                        {
//                            $this->$columnName = $format->formatDateTimeForDb($this->$columnName);
//                        }
//            }
//
//            return parent::beforeValidate ();
//        }
//
//        public function beforeSave() {
//            if($this->tglkadaluarsa===null || trim($this->tglkadaluarsa)==''){
//	        $this->setAttribute('tglkadaluarsa', null);
//            }
//
//            return parent::beforeSave();
//        }

//        HINDARI PENGGUNAAN AFTERFIND
//        protected function afterFind(){
//            foreach($this->metadata->tableSchema->columns as $columnName => $column){
//
//                if (!strlen($this->$columnName)) continue;
//
//                if ($column->dbType == 'date'){
//                        $this->$columnName = Yii::app()->dateFormatter->formatDateTime(
//                                        CDateTimeParser::parse($this->$columnName, 'yyyy-MM-dd'),'medium',null);
//                        }elseif ($column->dbType == 'timestamp without time zone'){
//                                $this->$columnName = Yii::app()->dateFormatter->formatDateTime(
//                                        CDateTimeParser::parse($this->$columnName, 'yyyy-MM-dd hh:mm:ss'));
//                        }
//            }
//            return true;
//        }
}
