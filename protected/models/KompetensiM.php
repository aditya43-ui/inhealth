<?php

/**
 * This is the model class for table "kompetensi_m".
 *
 * The followings are the available columns in table 'kompetensi_m':
 * @property integer $kompetensi_id
 * @property string $kompetensi_nama
 * @property string $kompetensi_namalain
 * @property boolean $kompetensi_aktif
 */
class KompetensiM extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return KompetensiM the static model class
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
		return 'kompetensi_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('jenispenilaian_id,kompetensi_nama, kompetensi_namalain', 'required'),
			array('kompetensi_nama, kompetensi_namalain', 'length', 'max'=>100),
			array('kompetensi_urutan, jenispenilaian_id, kompetensi_aktif', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('kompetensi_id, kompetensi_nama, kompetensi_namalain, kompetensi_aktif', 'safe', 'on'=>'search'),
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
                    'jenispenilaian' => array(self::BELONGS_TO,'JenispenilaianM','jenispenilaian_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'kompetensi_id' => 'Kompetensi',
			'kompetensi_nama' => 'Nama Kompetensi',
			'kompetensi_namalain' => 'Nama Lain',
			'kompetensi_aktif' => 'Aktif',
                        'jenispenilaian_id' => 'Jenis Penilaian',
                        'kompetensi_urutan' => 'Urutan'
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

		if(!empty($this->kompetensi_id)){
			$criteria->addCondition('kompetensi_id = '.$this->kompetensi_id);
		}
                if (!empty($this->jenispenilaian_id)){
                    $criteria->addCondition(" jenispenilaian_id = '".$this->jenispenilaian_id."' ");
                }
		$criteria->compare('LOWER(kompetensi_nama)',strtolower($this->kompetensi_nama),true);
		$criteria->compare('LOWER(kompetensi_namalain)',strtolower($this->kompetensi_namalain),true);
		$criteria->compare('kompetensi_aktif',$this->kompetensi_aktif);

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