<?php

/**
 * This is the model class for table "rakobat_m".
 *
 * The followings are the available columns in table 'rakobat_m':
 * @property integer $rakobat_id
 * @property string $rakobat_nama
 * @property string $rakobat_namalain
 * @property string $rakobat_label
 * @property boolean $rakobat_aktif
 *
 * The followings are the available model relations:
 * @property StokobatalkesT[] $stokobatalkesTs
 */
class RakobatM extends CActiveRecord
{
	public $instalasi_id;

	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return RakobatM the static model class
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
		return 'rakobat_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('rakobat_nama, rakobat_namalain, rakobat_label', 'required'),
			array('rakobat_nama, rakobat_namalain', 'length', 'max'=>200),
			array('rakobat_label', 'length', 'max'=>1),
			array('rakobat_aktif, ruangan_id', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('ruangan_id, instalasi_id, rakobat_id, rakobat_nama, rakobat_namalain, rakobat_label, rakobat_aktif', 'safe', 'on'=>'search'),
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
			'stokobatalkesTs' => array(self::HAS_MANY, 'StokobatalkesT', 'rakobat_id'),
			'ruangan' => array(self::BELONGS_TO, 'RuanganM', 'ruangan_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'rakobat_id' => 'Rak Obat ID',
			'rakobat_nama' => 'Rak Obat',
			'rakobat_namalain' => 'Rak Obat Lainnya',
			'rakobat_label' => 'Rak Obat Label',
			'rakobat_aktif' => 'Rak Obat Aktif',
			'instalasi_id' => "Instalasi",
			'ruangan_id' => "Ruangan",
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
        
		if(!empty($this->rakobat_id)){
			$criteria->addCondition('t.rakobat_id = '.$this->rakobat_id);
		}
		$criteria->compare('LOWER(t.rakobat_nama)',strtolower($this->rakobat_nama),true);
		$criteria->compare('LOWER(t.rakobat_namalain)',strtolower($this->rakobat_namalain),true);
		$criteria->compare('LOWER(t.rakobat_label)',strtolower($this->rakobat_label),true);
		$criteria->compare('r.instalasi_id', $this->instalasi_id);
		$criteria->compare('r.ruangan_id', $this->ruangan_id);
		$criteria->compare('t.rakobat_aktif',$this->rakobat_aktif);
		$criteria->join = 'left join ruangan_m r on r.ruangan_id = t.ruangan_id';
        
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

		public static function getRakObatItems() {
			return self::model()->findAll();
		}
}