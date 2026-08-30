<?php

/**
 * This is the model class for table "terimamutasidetail_t".
 *
 * The followings are the available columns in table 'terimamutasidetail_t':
 * @property integer $terimamutasidetail_id
 * @property integer $ruangan_id
 * @property integer $satuankecil_id
 * @property integer $obatalkes_id
 * @property integer $terimamutasi_id
 * @property integer $stokobatalkes_id
 * @property integer $sumberdana_id
 * @property double $jmlmutasi
 * @property double $jmlterima
 * @property double $harganettoterima
 * @property double $hargajualterim
 * @property double $persendiscount
 * @property double $totalhargaterima
 * @property string $tglkadaluarsa
 * @property integer $jmlkemasan
 */
class TerimamutasidetailT extends CActiveRecord
{
        public $stok, $subTotal;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return TerimamutasidetailT the static model class
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
		return 'terimamutasidetail_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('ruangan_id, satuankecil_id, obatalkes_id, terimamutasi_id, sumberdana_id, jmlmutasi, jmlterima, harganettoterima, hargajualterim, persendiscount, totalhargaterima', 'required'),
			array('ruangan_id, satuankecil_id, obatalkes_id, terimamutasi_id, stokobatalkes_id, sumberdana_id, jmlkemasan', 'numerical', 'integerOnly'=>true),
			array('jmlmutasi, jmlterima, harganettoterima, hargajualterim, persendiscount, totalhargaterima', 'numerical'),
			array('stok, subTotal, tglkadaluarsa', 'safe'),
                        array('jmlterima', 'cekTerima'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('terimamutasidetail_id, ruangan_id, satuankecil_id, obatalkes_id, terimamutasi_id, stokobatalkes_id, sumberdana_id, jmlmutasi, jmlterima, harganettoterima, hargajualterim, persendiscount, totalhargaterima, tglkadaluarsa, jmlkemasan', 'safe', 'on'=>'search'),
		);
	}
        
        public function cekTerima($attribute, $params){
            if (!$this->hasErrors()){
                if ($this->jmlterima > $this->jmlmutasi){
                    $this->errors('jmlterima', 'Jumlah terima tidak boleh lebih dari '.$this->jmlmutasi);
                }
            }
        }

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
                      'obatalkes'=>array(self::BELONGS_TO,'ObatalkesM','obatalkes_id'),
                      'sumberdana'=>array(self::BELONGS_TO,'SumberdanaM','sumberdana_id'),
                      'satuankecil'=>array(self::BELONGS_TO,'SatuankecilM','satuankecil_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'terimamutasidetail_id' => 'Terimamutasidetail',
			'ruangan_id' => 'Ruangan',
			'satuankecil_id' => 'Satuankecil',
			'obatalkes_id' => 'Obatalkes',
			'terimamutasi_id' => 'Terimamutasi',
			'stokobatalkes_id' => 'Stokobatalkes',
			'sumberdana_id' => 'Sumberdana',
			'jmlmutasi' => 'Jmlmutasi',
			'jmlterima' => 'Jmlterima',
			'harganettoterima' => 'Harganettoterima',
			'hargajualterim' => 'Hargajualterim',
			'persendiscount' => 'Persen Keringanan',
			'totalhargaterima' => 'Totalhargaterima',
			'tglkadaluarsa' => 'Tglkadaluarsa',
			'jmlkemasan' => 'Jmlkemasan',
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

		$criteria->compare('terimamutasidetail_id',$this->terimamutasidetail_id);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('satuankecil_id',$this->satuankecil_id);
		$criteria->compare('obatalkes_id',$this->obatalkes_id);
		$criteria->compare('terimamutasi_id',$this->terimamutasi_id);
		$criteria->compare('stokobatalkes_id',$this->stokobatalkes_id);
		$criteria->compare('sumberdana_id',$this->sumberdana_id);
		$criteria->compare('jmlmutasi',$this->jmlmutasi);
		$criteria->compare('jmlterima',$this->jmlterima);
		$criteria->compare('harganettoterima',$this->harganettoterima);
		$criteria->compare('hargajualterim',$this->hargajualterim);
		$criteria->compare('persendiscount',$this->persendiscount);
		$criteria->compare('totalhargaterima',$this->totalhargaterima);
		$criteria->compare('LOWER(tglkadaluarsa)',strtolower($this->tglkadaluarsa),true);
		$criteria->compare('jmlkemasan',$this->jmlkemasan);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		$criteria->compare('terimamutasidetail_id',$this->terimamutasidetail_id);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('satuankecil_id',$this->satuankecil_id);
		$criteria->compare('obatalkes_id',$this->obatalkes_id);
		$criteria->compare('terimamutasi_id',$this->terimamutasi_id);
		$criteria->compare('stokobatalkes_id',$this->stokobatalkes_id);
		$criteria->compare('sumberdana_id',$this->sumberdana_id);
		$criteria->compare('jmlmutasi',$this->jmlmutasi);
		$criteria->compare('jmlterima',$this->jmlterima);
		$criteria->compare('harganettoterima',$this->harganettoterima);
		$criteria->compare('hargajualterim',$this->hargajualterim);
		$criteria->compare('persendiscount',$this->persendiscount);
		$criteria->compare('totalhargaterima',$this->totalhargaterima);
		$criteria->compare('LOWER(tglkadaluarsa)',strtolower($this->tglkadaluarsa),true);
		$criteria->compare('jmlkemasan',$this->jmlkemasan);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
        
        public function beforeSave() {
            if($this->tglkadaluarsa===null || trim($this->tglkadaluarsa)==''){
	        $this->setAttribute('tglkadaluarsa', null);
            }
            return parent::beforeSave();
        }
        
        protected function beforeValidate ()
        {
            // convert to storage format
            //$this->tglrevisimodul = date ('Y-m-d', strtotime($this->tglrevisimodul));
            $format = new MyFormatter();
            //$this->tglrevisimodul = $format->formatDateTimeForDb($this->tglrevisimodul);
            foreach($this->metadata->tableSchema->columns as $columnName => $column){
                    if ($column->dbType == 'date')
                        {
                            $this->$columnName = $format->formatDateTimeForDb($this->$columnName);
                        }
                    else if ( $column->dbType == 'timestamp without time zone')
                        {
                            $this->$columnName = $format->formatDateTimeForDb($this->$columnName);
                        }
            }

            return parent::beforeValidate ();
        }
}