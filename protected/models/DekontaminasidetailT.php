<?php

/**
 * This is the model class for table "dekontaminasidetail_t".
 *
 * The followings are the available columns in table 'dekontaminasidetail_t':
 * @property integer $dekontaminasidetail_id
 * @property integer $penerimaansterilisasi_id
 * @property integer $ruangan_id
 * @property integer $dekontaminasi_id
 * @property integer $barang_id
 * @property integer $dekontaminasidetail_jml
 * @property string $dekontaminasidetail_ket
 * @property string $dekontaminasidetail_lama
 */
class DekontaminasidetailT extends CActiveRecord
{
    public $peralatansterilisasi_nama;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return DekontaminasidetailT the static model class
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
		return 'dekontaminasidetail_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('penerimaansterilisasi_id, ruangan_id, dekontaminasi_id, peralatansterilisasi_id, dekontaminasidetail_jml', 'required'),
			array('penerimaansterilisasi_id, ruangan_id, dekontaminasi_id, peralatansterilisasi_id, dekontaminasidetail_jml, penerimaansterilisasidet_id', 'numerical', 'integerOnly'=>true),
			array('dekontaminasidetail_ket', 'length', 'max'=>200),
			array('dekontaminasidetail_lama', 'length', 'max'=>20),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('dekontaminasidetail_id, penerimaansterilisasi_id, ruangan_id, dekontaminasi_id, peralatansterilisasi_id, dekontaminasidetail_jml, dekontaminasidetail_ket, dekontaminasidetail_lama, penerimaansterilisasidet_id', 'safe', 'on'=>'search'),
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
			'ruangan'=>array(self::BELONGS_TO,'RuanganM','ruangan_id'),
			'peralatansterilisasi'=>array(self::BELONGS_TO,'PeralatansterilisasiM','peralatansterilisasi_id'),
			'dekontaminasi'=>array(self::BELONGS_TO,'DekontaminasiT','dekontaminasi_id'),
			'penerimaansterilisasi'=>array(self::BELONGS_TO,'PenerimaansterilisasiT','penerimaansterilisasi_id'),
			'penerimaansterilisasidet'=>array(self::BELONGS_TO,'PenerimaansterilisasidetT','penerimaansterilisasidet_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'dekontaminasidetail_id' => 'ID Dekontaminasi Detail',
			'penerimaansterilisasi_id' => 'ID Penerimaan Sterilisasi',
			'ruangan_id' => 'Ruangan',
			'dekontaminasi_id' => 'ID Dekontaminasi',
			'peralatansterilisasi_id' => 'Peralatan Sterilisasi',
			'dekontaminasidetail_jml' => 'Jumlah',
			'dekontaminasidetail_ket' => 'Keterangan',
			'dekontaminasidetail_lama' => 'Lama Dekontaminasi',
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

		if(!empty($this->dekontaminasidetail_id)){
			$criteria->addCondition('dekontaminasidetail_id = '.$this->dekontaminasidetail_id);
		}
		if(!empty($this->penerimaansterilisasi_id)){
			$criteria->addCondition('penerimaansterilisasi_id = '.$this->penerimaansterilisasi_id);
		}
		if(!empty($this->ruangan_id)){
			$criteria->addCondition('ruangan_id = '.$this->ruangan_id);
		}
		if(!empty($this->dekontaminasi_id)){
			$criteria->addCondition('dekontaminasi_id = '.$this->dekontaminasi_id);
		}
		if(!empty($this->peralatansterilisasi_id)){
			$criteria->addCondition('peralatansterilisasi_id = '.$this->peralatansterilisasi_id);
		}
		if(!empty($this->dekontaminasidetail_jml)){
			$criteria->addCondition('dekontaminasidetail_jml = '.$this->dekontaminasidetail_jml);
		}
		$criteria->compare('LOWER(dekontaminasidetail_ket)',strtolower($this->dekontaminasidetail_ket),true);
		$criteria->compare('LOWER(dekontaminasidetail_lama)',strtolower($this->dekontaminasidetail_lama),true);

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