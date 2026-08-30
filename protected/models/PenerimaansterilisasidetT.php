<?php

/**
 * This is the model class for table "penerimaansterilisasidet_t".
 *
 * The followings are the available columns in table 'penerimaansterilisasidet_t':
 * @property integer $penerimaansterilisasidet_id
 * @property integer $linen_id
 * @property integer $penerimaansterilisasi_id
 * @property integer $barang_id
 * @property integer $penerimaansterilisasidet_jml
 * @property string $penerimaansterilisasidet_ket
 */
class PenerimaansterilisasidetT extends CActiveRecord
{     
    
        public $jenisperalatan;
        public $namaPeralatan;
        public $peralatansterilisasi_nama;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PenerimaansterilisasidetT the static model class
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
		return 'penerimaansterilisasidet_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('penerimaansterilisasi_id, penerimaansterilisasidet_jml', 'required'),
			array('penerimaansterilisasi_id, penerimaansterilisasidet_jml, barang_id', 'numerical', 'integerOnly'=>true),
			array('penerimaansterilisasidet_ket', 'length', 'max'=>200),
                        array('peralatansterilisasi_id, keadaanperalatan,jenisperalatan','safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('penerimaansterilisasidet_id, penerimaansterilisasi_id, penerimaansterilisasidet_jml, penerimaansterilisasidet_ket, barang_id', 'safe', 'on'=>'search'),
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
                    'linen' => array(self::BELONGS_TO, 'LinenM', 'linen_id'),
                    'barang'=>array(self::BELONGS_TO,'BarangM','barang_id'),
                    'penerimaansterilisasi'=>array(self::BELONGS_TO,'PenerimaansterilisasiT','penerimaansterilisasi_id'),
                    'peralatansterilisasi'=>array(self::BELONGS_TO,'PeralatansterilisasiM','peralatansterilisasi_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'penerimaansterilisasidet_id' => 'Penerimaansterilisasidet',
			'linen_id' => 'Linen',
			'penerimaansterilisasi_id' => 'Penerimaansterilisasi',
			'barang_id' => 'Barang',
			'penerimaansterilisasidet_jml' => 'Penerimaansterilisasidet Jml',
			'penerimaansterilisasidet_ket' => 'Penerimaansterilisasidet Ket',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CdbCriteria that can return criterias.
	 */
	public function criteriaSearch()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		if(!empty($this->penerimaansterilisasidet_id)){
			$criteria->addCondition('penerimaansterilisasidet_id = '.$this->penerimaansterilisasidet_id);
		}
		if(!empty($this->linen_id)){
			$criteria->addCondition('linen_id = '.$this->linen_id);
		}
		if(!empty($this->penerimaansterilisasi_id)){
			$criteria->addCondition('penerimaansterilisasi_id = '.$this->penerimaansterilisasi_id);
		}
		if(!empty($this->barang_id)){
			$criteria->addCondition('barang_id = '.$this->barang_id);
		}
		if(!empty($this->penerimaansterilisasidet_jml)){
			$criteria->addCondition('penerimaansterilisasidet_jml = '.$this->penerimaansterilisasidet_jml);
		}
		$criteria->compare('LOWER(penerimaansterilisasidet_ket)',strtolower($this->penerimaansterilisasidet_ket),true);

		return $criteria;
	}
        
        
        /**
         * Retrieves a list of models based on the current search/filter conditions.
         * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
         */
        public function search()
        {
            // Warning: Please modify the following code to remove attributes that
            // should not be searched.

            $criteria=$this->criteriaSearch();
            $criteria->limit=10;

            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
            ));
        }


        public function searchPrint()
        {
            // Warning: Please modify the following code to remove attributes that
            // should not be searched.

            $criteria=$this->criteriaSearch();
            $criteria->limit=-1; 

            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
                    'pagination'=>false,
            ));
        }
}