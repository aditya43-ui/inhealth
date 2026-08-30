<?php

/**
 * This is the model class for table "indikatorperilaku_m".
 *
 * The followings are the available columns in table 'indikatorperilaku_m':
 * @property integer $indikatorperilaku_id
 * @property integer $jabatan_id
 * @property integer $kompetensi_id
 * @property integer $jenispenilaian_id
 * @property string $indikatorperilaku_nama
 * @property string $indikatorperilaku_namalain
 * @property boolean $indikatorperilaku_aktif
 */
class IndikatorperilakuM extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return IndikatorperilakuM the static model class
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
		return 'indikatorperilaku_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('kompetensi_id, jenispenilaian_id, indikatorperilaku_nama, indikatorperilaku_namalain', 'required'),
			array('jabatan_id, kompetensi_id, jenispenilaian_id', 'numerical', 'integerOnly'=>true),
			array('indikatorperilaku_nama, indikatorperilaku_namalain', 'length', 'max'=>300),
			array('indikatorperilaku_aktif, indikatorperilaku_urutan, bobotnilai_indikator', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('indikatorperilaku_id, jabatan_id, kompetensi_id, jenispenilaian_id, indikatorperilaku_nama, indikatorperilaku_namalain, indikatorperilaku_aktif, bobotnilai_indikator', 'safe', 'on'=>'search'),
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
			'jenispenilaian'=>array(self::BELONGS_TO,'JenispenilaianM','jenispenilaian_id'),
			'kompetensi'=>array(self::BELONGS_TO,'KompetensiM','kompetensi_id'),
			'jabatan'=>array(self::BELONGS_TO,'JabatanM','jabatan_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'indikatorperilaku_id' => 'Id Indikator Perilaku',
			'jabatan_id' => 'Jabatan',
			'kompetensi_id' => 'Kompetensi',
			'jenispenilaian_id' => 'Jenis Penilaian',
			'indikatorperilaku_nama' => 'Nama Indikator Perilaku',
			'indikatorperilaku_namalain' => 'Nama Lain Indikator Perilaku',
			'indikatorperilaku_aktif' => 'Status',
                        'bobotnilai_indikator' => 'Bobot Nilai Indikator',
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

		if(!empty($this->indikatorperilaku_id)){
			$criteria->addCondition('indikatorperilaku_id = '.$this->indikatorperilaku_id);
		}
		if(!empty($this->jabatan_id)){
			$criteria->addCondition('jabatan_id = '.$this->jabatan_id);
		}
		if(!empty($this->kompetensi_id)){
			$criteria->addCondition('kompetensi_id = '.$this->kompetensi_id);
		}
		if(!empty($this->jenispenilaian_id)){
			$criteria->addCondition('jenispenilaian_id = '.$this->jenispenilaian_id);
		}
		$criteria->compare('LOWER(indikatorperilaku_nama)',strtolower($this->indikatorperilaku_nama),true);
		$criteria->compare('LOWER(indikatorperilaku_namalain)',strtolower($this->indikatorperilaku_namalain),true);
                $criteria->compare('LOWER(bobotnilai_indikator)',strtolower($this->bobotnilai_indikator),true);
		$criteria->compare('indikatorperilaku_aktif',$this->indikatorperilaku_aktif);

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