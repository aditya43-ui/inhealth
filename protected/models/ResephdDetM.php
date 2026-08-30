<?php

/**
 * This is the model class for table "resephd_det_m".
 *
 * The followings are the available columns in table 'resephd_det_m':
 * @property integer $resephd_det_id
 * @property integer $obatalkes_id
 * @property integer $resephd_id
 *
 * The followings are the available model relations:
 * @property ResephdM $resephd
 * @property ObatalkesM $obatalkes
 * @property KelengkapanAlatHdT[] $kelengkapanAlatHdTs
 * @property ResepturdetailT[] $resepturdetailTs
 */
class ResephdDetM extends CActiveRecord
{
    public $resephd_nama, $resephd_desc, $resephd_aktif;
    public $obatalkes_kode, $obatalkes_nama, $harga_satuan, $hargajual;
    public $satuankecil_nama, $satuankecil_id;

    /**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ResephdDetM the static model class
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
		return 'resephd_det_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(

//			array('obatalkes_id, resephd_id', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
//			array('resephd_det_id, obatalkes_id, resephd_id', 'safe', 'on'=>'search'),

			array('', 'required'),
			array(' obatalkes_id, resephd_id', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array(' obatalkes_id, resephd_id', 'safe', 'on'=>'search'),

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

			'resepturdetailTs' => array(self::HAS_MANY, 'ResepturdetailT', 'resephd_det_id'),
			'kelengkapanAlatHdTs' => array(self::HAS_MANY, 'KelengkapanAlatHdT', 'resephd_det_id'),
			'resephd' => array(self::BELONGS_TO, 'ResephdM', 'resephd_id'),
			'obatalkes' => array(self::BELONGS_TO, 'ObatalkesM', 'obatalkes_id'),

//			'resephd' => array(self::BELONGS_TO, 'ResephdM', 'resephd_id'),
//			'obatalkes' => array(self::BELONGS_TO, 'ObatalkesM', 'obatalkes_id'),
//			'kelengkapanAlatHdTs' => array(self::HAS_MANY, 'KelengkapanAlatHdT', 'resephd_det_id'),
//			'resepturdetailTs' => array(self::HAS_MANY, 'ResepturdetailT', 'resephd_det_id'),

		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'resephd_det_id' => 'Resephd Det',
			'obatalkes_id' => 'Obatalkes',
			'resephd_id' => 'Resephd',
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

		$criteria->compare('resephd_det_id',$this->resephd_det_id);
		$criteria->compare('obatalkes_id',$this->obatalkes_id);
		$criteria->compare('resephd_id',$this->resephd_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	
        public function searchDetail()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
                $criteria->select = "t.*, b.*, c.*, d.satuankecil_nama";
                $criteria->join = "JOIN obatalkes_m b ON t.obatalkes_id = b.obatalkes_id ".
                        "JOIN resephd_m c ON t.resephd_id = c.resephd_id ".
                        "JOIN satuankecil_m d ON b.satuankecil_id = d.satuankecil_id";
		$criteria->compare('t.resephd_det_id',$this->resephd_det_id);
		$criteria->compare('t.obatalkes_id',$this->obatalkes_id);
		$criteria->compare('t.resephd_id',$this->resephd_id);
                $criteria->compare('LOWER(c.resephd_nama)', strtolower($this->resephd_nama), true);
                $criteria->compare('LOWER(b.obatalkes_kode)', strtolower($this->obatalkes_kode), true);
                $criteria->compare('LOWER(b.obatalkes_nama)', strtolower($this->obatalkes_nama), true);
		$criteria->compare('b.satuankecil_id', $this->satuankecil_id);
                
//                var_dump($criteria);die;
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        public function searchPrint()
        {
            // Warning: Please modify the following code to remove attributes that
            // should not be searched.

            $criteria=new CDbCriteria;
            $criteria->select = "t.*, b.*, c.*, d.satuankecil_nama";
            $criteria->join = "JOIN obatalkes_m b ON t.obatalkes_id = b.obatalkes_id ".
                    "JOIN resephd_m c ON t.resephd_id = c.resephd_id ".
                    "JOIN satuankecil_m d ON b.satuankecil_id = d.satuankecil_id";
            $criteria->compare('t.resephd_det_id',$this->resephd_det_id);
            $criteria->compare('t.obatalkes_id',$this->obatalkes_id);
            $criteria->compare('t.resephd_id',$this->resephd_id);
            $criteria->compare('LOWER(c.resephd_nama)',strtolower($this->resephd_nama),true);
            $criteria->compare('LOWER(b.obatalkes_kode)', strtolower($this->obatalkes_kode), true);
            $criteria->compare('LOWER(b.obatalkes_nama)', strtolower($this->obatalkes_nama), true);
            $criteria->compare('b.satuankecil_id',$this->satuankecil_id);
            $criteria->limit=-1; 

            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
                    'pagination'=>false,
            ));
        }
}