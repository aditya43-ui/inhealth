<?php

/**
 * This is the model class for table "penerimaansterilisasi_v".
 *
 * The followings are the available columns in table 'penerimaansterilisasi_v':
 * @property string $penerimaansterilisasi_tgl
 * @property integer $penerimaansterilisasi_id
 * @property string $penerimaansterilisasi_no
 * @property integer $penerimaansterilisasidet_jml
 * @property string $penerimaansterilisasidet_ket
 * @property integer $linen_id
 * @property integer $barang_id
 * @property string $barang_nama
 * @property integer $instalasi_id
 * @property integer $ruangan_id
 * @property string $ruangan_nama
 * @property string $instalasi_nama
 */
class PenerimaansterilisasiV extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PenerimaansterilisasiV the static model class
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
		return 'penerimaansterilisasi_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('penerimaansterilisasi_id, penerimaansterilisasidet_jml, linen_id, barang_id, instalasi_id, ruangan_id', 'numerical', 'integerOnly'=>true),
			array('penerimaansterilisasi_no', 'length', 'max'=>20),
			array('penerimaansterilisasidet_ket', 'length', 'max'=>200),
			array('barang_nama', 'length', 'max'=>100),
			array('ruangan_nama, instalasi_nama', 'length', 'max'=>50),
			array('penerimaansterilisasi_tgl', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('penerimaansterilisasi_tgl, penerimaansterilisasi_id, penerimaansterilisasi_no, penerimaansterilisasidet_jml, penerimaansterilisasidet_ket, linen_id, barang_id, barang_nama, instalasi_id, ruangan_id, ruangan_nama, instalasi_nama', 'safe', 'on'=>'search'),
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
			'penerimaansterilisasi_tgl' => 'Penerimaansterilisasi Tgl',
			'penerimaansterilisasi_id' => 'Penerimaansterilisasi',
			'penerimaansterilisasi_no' => 'Penerimaansterilisasi No',
			'penerimaansterilisasidet_jml' => 'Penerimaansterilisasidet Jml',
			'penerimaansterilisasidet_ket' => 'Penerimaansterilisasidet Ket',
			'linen_id' => 'Linen',
			'barang_id' => 'Barang',
			'barang_nama' => 'Barang Nama',
			'instalasi_id' => 'Instalasi',
			'ruangan_id' => 'Ruangan',
			'ruangan_nama' => 'Ruangan Nama',
			'instalasi_nama' => 'Instalasi Nama',
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

		$criteria->compare('LOWER(penerimaansterilisasi_tgl)',strtolower($this->penerimaansterilisasi_tgl),true);
		if(!empty($this->penerimaansterilisasi_id)){
			$criteria->addCondition('penerimaansterilisasi_id = '.$this->penerimaansterilisasi_id);
		}
		$criteria->compare('LOWER(penerimaansterilisasi_no)',strtolower($this->penerimaansterilisasi_no),true);
		if(!empty($this->penerimaansterilisasidet_jml)){
			$criteria->addCondition('penerimaansterilisasidet_jml = '.$this->penerimaansterilisasidet_jml);
		}
		$criteria->compare('LOWER(penerimaansterilisasidet_ket)',strtolower($this->penerimaansterilisasidet_ket),true);
		if(!empty($this->linen_id)){
			$criteria->addCondition('linen_id = '.$this->linen_id);
		}
		if(!empty($this->barang_id)){
			$criteria->addCondition('barang_id = '.$this->barang_id);
		}
		$criteria->compare('LOWER(barang_nama)',strtolower($this->barang_nama),true);
		if(!empty($this->instalasi_id)){
			$criteria->addCondition('instalasi_id = '.$this->instalasi_id);
		}
		if(!empty($this->ruangan_id)){
			$criteria->addCondition('ruangan_id = '.$this->ruangan_id);
		}
		$criteria->compare('LOWER(ruangan_nama)',strtolower($this->ruangan_nama),true);
		$criteria->compare('LOWER(instalasi_nama)',strtolower($this->instalasi_nama),true);

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