<?php

/**
 * This is the model class for table "rekeninganggaran_v".
 *
 * The followings are the available columns in table 'rekeninganggaran_v':
 * @property integer $programkerja_id
 * @property string $programkerja_kode
 * @property string $programkerja_nama
 * @property string $programkerja_ket
 * @property integer $programkerja_nourut
 * @property integer $subprogramkerja_id
 * @property string $subprogramkerja_kode
 * @property string $subprogramkerja_nama
 * @property string $subprogramkerja_ket
 * @property integer $subprogramkerja_nourut
 * @property integer $kegiatanprogram_id
 * @property string $kegiatanprogram_kode
 * @property string $kegiatanprogram_nama
 * @property string $kegiatanprogram_ket
 * @property integer $kegiatanprogram_nourut
 * @property integer $subkegiatanprogram_id
 * @property string $subkegiatanprogram_kode
 * @property string $subkegiatanprogram_nama
 * @property string $subkegiatanprogram_ket
 * @property integer $subkegiatanprogram_nourut
 * @property integer $rekening1debit_id
 * @property string $rekening1debit_kode
 * @property string $rekening1debit_nama
 * @property integer $rekening2debit_id
 * @property string $rekening2debit_kode
 * @property string $rekening2debit_nama
 * @property integer $rekening3debit_id
 * @property string $rekening3debit_kode
 * @property string $rekening3debit_nama
 * @property integer $rekening4debit_id
 * @property string $rekening4debit_kode
 * @property string $rekening4debit_nama
 * @property integer $rekening5debit_id
 * @property string $rekening5debit_kode
 * @property string $rekening5debit_nama
 * @property integer $rekening1kredit_id
 * @property string $rekening1kredit_kode
 * @property string $rekening1kredit_nama
 * @property integer $rekening2kredit_id
 * @property string $rekening2kredit_kode
 * @property string $rekening2kredit_nama
 * @property integer $rekening3kredit_id
 * @property string $rekening3kredit_kode
 * @property string $rekening3kredit_nama
 * @property integer $rekening4kredit_id
 * @property string $rekening4kredit_kode
 * @property string $rekening4kredit_nama
 * @property integer $rekening5kredit_id
 * @property string $rekening5kredit_kode
 * @property string $rekening5kredit_nama
 */
class RekeninganggaranV extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return RekeninganggaranV the static model class
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
		return 'rekeninganggaran_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('programkerja_id, programkerja_nourut, subprogramkerja_id, subprogramkerja_nourut, kegiatanprogram_id, kegiatanprogram_nourut, subkegiatanprogram_id, subkegiatanprogram_nourut, rekening1debit_id, rekening2debit_id, rekening3debit_id, rekening4debit_id, rekening5debit_id, rekening1kredit_id, rekening2kredit_id, rekening3kredit_id, rekening4kredit_id, rekening5kredit_id', 'numerical', 'integerOnly'=>true),
			array('programkerja_kode, subprogramkerja_kode, kegiatanprogram_kode, subkegiatanprogram_kode, rekening1debit_kode, rekening2debit_kode, rekening3debit_kode, rekening4debit_kode, rekening5debit_kode, rekening1kredit_kode, rekening2kredit_kode, rekening3kredit_kode, rekening4kredit_kode, rekening5kredit_kode', 'length', 'max'=>5),
			array('programkerja_nama, subprogramkerja_nama, kegiatanprogram_nama, subkegiatanprogram_nama, rekening5debit_nama, rekening5kredit_nama', 'length', 'max'=>500),
			array('rekening1debit_nama, rekening1kredit_nama', 'length', 'max'=>100),
			array('rekening2debit_nama, rekening2kredit_nama', 'length', 'max'=>200),
			array('rekening3debit_nama, rekening3kredit_nama', 'length', 'max'=>300),
			array('rekening4debit_nama, rekening4kredit_nama', 'length', 'max'=>400),
			array('programkerja_ket, subprogramkerja_ket, kegiatanprogram_ket, subkegiatanprogram_ket', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('programkerja_id, programkerja_kode, programkerja_nama, programkerja_ket, programkerja_nourut, subprogramkerja_id, subprogramkerja_kode, subprogramkerja_nama, subprogramkerja_ket, subprogramkerja_nourut, kegiatanprogram_id, kegiatanprogram_kode, kegiatanprogram_nama, kegiatanprogram_ket, kegiatanprogram_nourut, subkegiatanprogram_id, subkegiatanprogram_kode, subkegiatanprogram_nama, subkegiatanprogram_ket, subkegiatanprogram_nourut, rekening1debit_id, rekening1debit_kode, rekening1debit_nama, rekening2debit_id, rekening2debit_kode, rekening2debit_nama, rekening3debit_id, rekening3debit_kode, rekening3debit_nama, rekening4debit_id, rekening4debit_kode, rekening4debit_nama, rekening5debit_id, rekening5debit_kode, rekening5debit_nama, rekening1kredit_id, rekening1kredit_kode, rekening1kredit_nama, rekening2kredit_id, rekening2kredit_kode, rekening2kredit_nama, rekening3kredit_id, rekening3kredit_kode, rekening3kredit_nama, rekening4kredit_id, rekening4kredit_kode, rekening4kredit_nama, rekening5kredit_id, rekening5kredit_kode, rekening5kredit_nama', 'safe', 'on'=>'search'),
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
			'programkerja_id' => 'Programkerja',
			'programkerja_kode' => 'Programkerja Kode',
			'programkerja_nama' => 'Programkerja Nama',
			'programkerja_ket' => 'Programkerja Ket',
			'programkerja_nourut' => 'Programkerja Nourut',
			'subprogramkerja_id' => 'Subprogramkerja',
			'subprogramkerja_kode' => 'Subprogramkerja Kode',
			'subprogramkerja_nama' => 'Subprogramkerja Nama',
			'subprogramkerja_ket' => 'Subprogramkerja Ket',
			'subprogramkerja_nourut' => 'Subprogramkerja Nourut',
			'kegiatanprogram_id' => 'Kegiatanprogram',
			'kegiatanprogram_kode' => 'Kegiatanprogram Kode',
			'kegiatanprogram_nama' => 'Kegiatanprogram Nama',
			'kegiatanprogram_ket' => 'Kegiatanprogram Ket',
			'kegiatanprogram_nourut' => 'Kegiatanprogram Nourut',
			'subkegiatanprogram_id' => 'Subkegiatanprogram',
			'subkegiatanprogram_kode' => 'Subkegiatanprogram Kode',
			'subkegiatanprogram_nama' => 'Subkegiatanprogram Nama',
			'subkegiatanprogram_ket' => 'Subkegiatanprogram Ket',
			'subkegiatanprogram_nourut' => 'Subkegiatanprogram Nourut',
			'rekening1debit_id' => 'Rekening1debit',
			'rekening1debit_kode' => 'Rekening1debit Kode',
			'rekening1debit_nama' => 'Rekening1debit Nama',
			'rekening2debit_id' => 'Rekening2debit',
			'rekening2debit_kode' => 'Rekening2debit Kode',
			'rekening2debit_nama' => 'Rekening2debit Nama',
			'rekening3debit_id' => 'Rekening3debit',
			'rekening3debit_kode' => 'Rekening3debit Kode',
			'rekening3debit_nama' => 'Rekening3debit Nama',
			'rekening4debit_id' => 'Rekening4debit',
			'rekening4debit_kode' => 'Rekening4debit Kode',
			'rekening4debit_nama' => 'Rekening4debit Nama',
			'rekening5debit_id' => 'Rekening5debit',
			'rekening5debit_kode' => 'Rekening5debit Kode',
			'rekening5debit_nama' => 'Rekening5debit Nama',
			'rekening1kredit_id' => 'Rekening1kredit',
			'rekening1kredit_kode' => 'Rekening1kredit Kode',
			'rekening1kredit_nama' => 'Rekening1kredit Nama',
			'rekening2kredit_id' => 'Rekening2kredit',
			'rekening2kredit_kode' => 'Rekening2kredit Kode',
			'rekening2kredit_nama' => 'Rekening2kredit Nama',
			'rekening3kredit_id' => 'Rekening3kredit',
			'rekening3kredit_kode' => 'Rekening3kredit Kode',
			'rekening3kredit_nama' => 'Rekening3kredit Nama',
			'rekening4kredit_id' => 'Rekening4kredit',
			'rekening4kredit_kode' => 'Rekening4kredit Kode',
			'rekening4kredit_nama' => 'Rekening4kredit Nama',
			'rekening5kredit_id' => 'Rekening5kredit',
			'rekening5kredit_kode' => 'Rekening5kredit Kode',
			'rekening5kredit_nama' => 'Rekening5kredit Nama',
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

		if(!empty($this->programkerja_id)){
			$criteria->addCondition('programkerja_id = '.$this->programkerja_id);
		}
		$criteria->compare('LOWER(programkerja_kode)',strtolower($this->programkerja_kode),true);
		$criteria->compare('LOWER(programkerja_nama)',strtolower($this->programkerja_nama),true);
		$criteria->compare('LOWER(programkerja_ket)',strtolower($this->programkerja_ket),true);
		if(!empty($this->programkerja_nourut)){
			$criteria->addCondition('programkerja_nourut = '.$this->programkerja_nourut);
		}
		if(!empty($this->subprogramkerja_id)){
			$criteria->addCondition('subprogramkerja_id = '.$this->subprogramkerja_id);
		}
		$criteria->compare('LOWER(subprogramkerja_kode)',strtolower($this->subprogramkerja_kode),true);
		$criteria->compare('LOWER(subprogramkerja_nama)',strtolower($this->subprogramkerja_nama),true);
		$criteria->compare('LOWER(subprogramkerja_ket)',strtolower($this->subprogramkerja_ket),true);
		if(!empty($this->subprogramkerja_nourut)){
			$criteria->addCondition('subprogramkerja_nourut = '.$this->subprogramkerja_nourut);
		}
		if(!empty($this->kegiatanprogram_id)){
			$criteria->addCondition('kegiatanprogram_id = '.$this->kegiatanprogram_id);
		}
		$criteria->compare('LOWER(kegiatanprogram_kode)',strtolower($this->kegiatanprogram_kode),true);
		$criteria->compare('LOWER(kegiatanprogram_nama)',strtolower($this->kegiatanprogram_nama),true);
		$criteria->compare('LOWER(kegiatanprogram_ket)',strtolower($this->kegiatanprogram_ket),true);
		if(!empty($this->kegiatanprogram_nourut)){
			$criteria->addCondition('kegiatanprogram_nourut = '.$this->kegiatanprogram_nourut);
		}
		if(!empty($this->subkegiatanprogram_id)){
			$criteria->addCondition('subkegiatanprogram_id = '.$this->subkegiatanprogram_id);
		}
		$criteria->compare('LOWER(subkegiatanprogram_kode)',strtolower($this->subkegiatanprogram_kode),true);
		$criteria->compare('LOWER(subkegiatanprogram_nama)',strtolower($this->subkegiatanprogram_nama),true);
		$criteria->compare('LOWER(subkegiatanprogram_ket)',strtolower($this->subkegiatanprogram_ket),true);
		if(!empty($this->subkegiatanprogram_nourut)){
			$criteria->addCondition('subkegiatanprogram_nourut = '.$this->subkegiatanprogram_nourut);
		}
		if(!empty($this->rekening1debit_id)){
			$criteria->addCondition('rekening1debit_id = '.$this->rekening1debit_id);
		}
		$criteria->compare('LOWER(rekening1debit_kode)',strtolower($this->rekening1debit_kode),true);
		$criteria->compare('LOWER(rekening1debit_nama)',strtolower($this->rekening1debit_nama),true);
		if(!empty($this->rekening2debit_id)){
			$criteria->addCondition('rekening2debit_id = '.$this->rekening2debit_id);
		}
		$criteria->compare('LOWER(rekening2debit_kode)',strtolower($this->rekening2debit_kode),true);
		$criteria->compare('LOWER(rekening2debit_nama)',strtolower($this->rekening2debit_nama),true);
		if(!empty($this->rekening3debit_id)){
			$criteria->addCondition('rekening3debit_id = '.$this->rekening3debit_id);
		}
		$criteria->compare('LOWER(rekening3debit_kode)',strtolower($this->rekening3debit_kode),true);
		$criteria->compare('LOWER(rekening3debit_nama)',strtolower($this->rekening3debit_nama),true);
		if(!empty($this->rekening4debit_id)){
			$criteria->addCondition('rekening4debit_id = '.$this->rekening4debit_id);
		}
		$criteria->compare('LOWER(rekening4debit_kode)',strtolower($this->rekening4debit_kode),true);
		$criteria->compare('LOWER(rekening4debit_nama)',strtolower($this->rekening4debit_nama),true);
		if(!empty($this->rekening5debit_id)){
			$criteria->addCondition('rekening5debit_id = '.$this->rekening5debit_id);
		}
		$criteria->compare('LOWER(rekening5debit_kode)',strtolower($this->rekening5debit_kode),true);
		$criteria->compare('LOWER(rekening5debit_nama)',strtolower($this->rekening5debit_nama),true);
		if(!empty($this->rekening1kredit_id)){
			$criteria->addCondition('rekening1kredit_id = '.$this->rekening1kredit_id);
		}
		$criteria->compare('LOWER(rekening1kredit_kode)',strtolower($this->rekening1kredit_kode),true);
		$criteria->compare('LOWER(rekening1kredit_nama)',strtolower($this->rekening1kredit_nama),true);
		if(!empty($this->rekening2kredit_id)){
			$criteria->addCondition('rekening2kredit_id = '.$this->rekening2kredit_id);
		}
		$criteria->compare('LOWER(rekening2kredit_kode)',strtolower($this->rekening2kredit_kode),true);
		$criteria->compare('LOWER(rekening2kredit_nama)',strtolower($this->rekening2kredit_nama),true);
		if(!empty($this->rekening3kredit_id)){
			$criteria->addCondition('rekening3kredit_id = '.$this->rekening3kredit_id);
		}
		$criteria->compare('LOWER(rekening3kredit_kode)',strtolower($this->rekening3kredit_kode),true);
		$criteria->compare('LOWER(rekening3kredit_nama)',strtolower($this->rekening3kredit_nama),true);
		if(!empty($this->rekening4kredit_id)){
			$criteria->addCondition('rekening4kredit_id = '.$this->rekening4kredit_id);
		}
		$criteria->compare('LOWER(rekening4kredit_kode)',strtolower($this->rekening4kredit_kode),true);
		$criteria->compare('LOWER(rekening4kredit_nama)',strtolower($this->rekening4kredit_nama),true);
		if(!empty($this->rekening5kredit_id)){
			$criteria->addCondition('rekening5kredit_id = '.$this->rekening5kredit_id);
		}
		$criteria->compare('LOWER(rekening5kredit_kode)',strtolower($this->rekening5kredit_kode),true);
		$criteria->compare('LOWER(rekening5kredit_nama)',strtolower($this->rekening5kredit_nama),true);

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