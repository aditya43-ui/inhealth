<?php

/**
 * This is the model class for table "laporankegiatanlaundry_v".
 *
 * The followings are the available columns in table 'laporankegiatanlaundry_v':
 * @property string $tglpenerimaanlinen
 * @property integer $penerimaanlinen_id
 * @property integer $instalasi_id
 * @property string $instalasi_nama
 * @property integer $ruangan_id
 * @property string $ruangan_nama
 * @property integer $beratlinen
 * @property string $dekontaminasi
 * @property string $perbaikan
 * @property string $pencucian
 * @property string $keterangan_penerimaanlinen
 */
class LaporankegiatanlaundryV extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return LaporankegiatanlaundryV the static model class
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
		return 'laporankegiatanlaundry_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('penerimaanlinen_id, instalasi_id, ruangan_id, beratlinen', 'numerical', 'integerOnly'=>true),
			array('instalasi_nama, ruangan_nama', 'length', 'max'=>50),
			array('tglpenerimaanlinen, dekontaminasi, perbaikan, pencucian', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('tglpenerimaanlinen, penerimaanlinen_id, instalasi_id, instalasi_nama, ruangan_id, ruangan_nama, beratlinen, dekontaminasi, perbaikan, pencucian, keterangan_penerimaanlinen', 'safe', 'on'=>'search'),
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
			'tglpenerimaanlinen' => 'Tglpenerimaanlinen',
			'penerimaanlinen_id' => 'Penerimaanlinen',
			'instalasi_id' => 'Instalasi',
			'instalasi_nama' => 'Instalasi Nama',
			'ruangan_id' => 'Ruangan',
			'ruangan_nama' => 'Ruangan Nama',
			'beratlinen' => 'Beratlinen',
			'dekontaminasi' => 'Dekontaminasi',
			'perbaikan' => 'Perbaikan',
			'pencucian' => 'Pencucian',
			'keterangan_penerimaanlinen' => 'Keterangan',
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

		$criteria->compare('LOWER(tglpenerimaanlinen)',strtolower($this->tglpenerimaanlinen),true);
		if(!empty($this->penerimaanlinen_id)){
			$criteria->addCondition('penerimaanlinen_id = '.$this->penerimaanlinen_id);
		}
		if(!empty($this->instalasi_id)){
			$criteria->addCondition('instalasi_id = '.$this->instalasi_id);
		}
		$criteria->compare('LOWER(instalasi_nama)',strtolower($this->instalasi_nama),true);
		if(!empty($this->ruangan_id)){
			$criteria->addCondition('ruangan_id = '.$this->ruangan_id);
		}
		$criteria->compare('LOWER(ruangan_nama)',strtolower($this->ruangan_nama),true);
		if(!empty($this->beratlinen)){
			$criteria->addCondition('beratlinen = '.$this->beratlinen);
		}
		$criteria->compare('LOWER(dekontaminasi)',strtolower($this->dekontaminasi),true);
		$criteria->compare('LOWER(perbaikan)',strtolower($this->perbaikan),true);
		$criteria->compare('LOWER(pencucian)',strtolower($this->pencucian),true);

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