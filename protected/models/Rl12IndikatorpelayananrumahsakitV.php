<?php

/**
 * This is the model class for table "rl1_2_indikatorpelayananrumahsakit_v".
 *
 * The followings are the available columns in table 'rl1_2_indikatorpelayananrumahsakit_v':
 * @property string $tgl_laporan
 * @property string $propinsi
 * @property string $kabupaten
 * @property integer $profilrs_id
 * @property string $koders
 * @property string $namars
 * @property double $bor
 * @property double $los
 * @property double $bto
 * @property double $toi
 * @property double $ndr
 * @property double $gdr
 */
class Rl12IndikatorpelayananrumahsakitV extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Rl12IndikatorpelayananrumahsakitV the static model class
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
		return 'rl1_2_indikatorpelayananrumahsakit_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('profilrs_id', 'numerical', 'integerOnly'=>true),
			array('bor, los, bto, toi, ndr, gdr', 'numerical'),
			array('propinsi, kabupaten, koders, namars', 'length', 'max'=>50),
			array('tgl_laporan', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('tgl_laporan, propinsi, kabupaten, profilrs_id, koders, namars, bor, los, bto, toi, ndr, gdr', 'safe', 'on'=>'search'),
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
			'tgl_laporan' => 'Tgl. Laporan',
			'propinsi' => 'Provinsi',
			'kabupaten' => 'Kabupaten',
			'profilrs_id' => 'Profilrs',
			'koders' => 'Koders',
			'namars' => 'Namars',
			'bor' => 'Bor',
			'los' => 'Los',
			'bto' => 'Bto',
			'toi' => 'Toi',
			'ndr' => 'Ndr',
			'gdr' => 'Gdr',
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

		$criteria->compare('LOWER(tgl_laporan)',strtolower($this->tgl_laporan),true);
		$criteria->compare('LOWER(propinsi)',strtolower($this->propinsi),true);
		$criteria->compare('LOWER(kabupaten)',strtolower($this->kabupaten),true);
		if(!empty($this->profilrs_id)){
			$criteria->addCondition('profilrs_id = '.$this->profilrs_id);
		}
		$criteria->compare('LOWER(koders)',strtolower($this->koders),true);
		$criteria->compare('LOWER(namars)',strtolower($this->namars),true);
		$criteria->compare('bor',$this->bor);
		$criteria->compare('los',$this->los);
		$criteria->compare('bto',$this->bto);
		$criteria->compare('toi',$this->toi);
		$criteria->compare('ndr',$this->ndr);
		$criteria->compare('gdr',$this->gdr);

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