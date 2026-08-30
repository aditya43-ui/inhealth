<?php

/**
 * This is the model class for table "bagiantubuh_m".
 *
 * The followings are the available columns in table 'bagiantubuh_m':
 * @property integer $bagiantubuh_id
 * @property string $namabagtubuh
 * @property string $bagtubuh_namalain
 * @property double $kordinat_x
 * @property double $kordinat_y
 * @property boolean $bagiantubuh_aktif
 */
class BagiantubuhM extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return BagiantubuhM the static model class
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
		return 'bagiantubuh_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('namabagtubuh, bagtubuh_namalain, kordinat_x, kordinat_y, gambartubuh_id', 'required'),
			array('kordinat_x, kordinat_y', 'numerical'),
			array('namabagtubuh, bagtubuh_namalain', 'length', 'max'=>200),
			array('bagiantubuh_aktif, kordinat_x2, kordinat_y2, bagiantubuh_urutan', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('gambartubuh_id, bagiantubuh_id, namabagtubuh, bagtubuh_namalain, kordinat_x, kordinat_y, bagiantubuh_aktif, kordinat_x2, kordinat_y2, bagiantubuh_urutan', 'safe', 'on'=>'search'),
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
			'bagiantubuh_id' => 'Bagian Tubuh',
			'gambartubuh_id' => 'Gambar Tubuh',
			'namabagtubuh' => 'Nama Bagian Tubuh',
			'bagtubuh_namalain' => 'Nama Lain',
			'bagiantubuh_urutan' => 'Urutan',
			'kordinat_x' => 'Koordinat X',
			'kordinat_y' => 'Koordinat Y',
			'bagiantubuh_aktif' => 'Bagian Tubuh Aktif',
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

		if(!empty($this->bagiantubuh_id)){
			$criteria->addCondition('bagiantubuh_id = '.$this->bagiantubuh_id);
		}
		$criteria->compare('LOWER(namabagtubuh)',strtolower($this->namabagtubuh),true);
		$criteria->compare('LOWER(bagtubuh_namalain)',strtolower($this->bagtubuh_namalain),true);
		$criteria->compare('kordinat_x',$this->kordinat_x);
		$criteria->compare('kordinat_y',$this->kordinat_y);
		$criteria->compare('gambartubuh_id',$this->gambartubuh_id);
		$criteria->compare('bagiantubuh_aktif',isset($this->bagiantubuh_aktif)?$this->bagiantubuh_aktif:true);

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

		public function getBagianTubuh() {
			$modBagianTubuh = BagiantubuhM::model()->findAll("bagiantubuh_aktif is true ORDER BY namabagtubuh ASC");
			return $modBagianTubuh;
		}
}