<?php

/**
 * This is the model class for table "penyimpananlinen_v".
 *
 * The followings are the available columns in table 'penyimpananlinen_v':
 * @property string $tglpenyimpananlinen
 * @property integer $penyimpananlinen_id
 * @property string $nopenyimpananlinen
 * @property string $keterangan_penyimpanan
 * @property integer $ruangan_id
 * @property string $ruangan_nama
 */
class PenyimpananlinenV extends CActiveRecord
{
	public $linen_id, $kodelinen, $namalinen;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PenyimpananlinenV the static model class
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
		return 'penyimpananlinen_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('penyimpananlinen_id, ruangan_id', 'numerical', 'integerOnly'=>true),
			array('nopenyimpananlinen, ruangan_nama', 'length', 'max'=>50),
			array('keterangan_penyimpanan', 'length', 'max'=>200),
			array('tglpenyimpananlinen', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('tglpenyimpananlinen, penyimpananlinen_id, nopenyimpananlinen, keterangan_penyimpanan, ruangan_id, ruangan_nama, kodelinen, namalinen', 'safe', 'on'=>'search'),
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
			'tglpenyimpananlinen' => 'Tgl. Penyimpanan',
			'penyimpananlinen_id' => 'Penyimpananlinen',
			'nopenyimpananlinen' => 'No Penyimpanan',
			'keterangan_penyimpanan' => 'Keterangan',
			'ruangan_id' => 'Ruangan',
			'ruangan_nama' => 'Ruangan',
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

		$criteria->compare('LOWER(tglpenyimpananlinen)',strtolower($this->tglpenyimpananlinen),true);
		if(!empty($this->penyimpananlinen_id)){
			$criteria->addCondition('penyimpananlinen_id = '.$this->penyimpananlinen_id);
		}
		$criteria->compare('LOWER(nopenyimpananlinen)',strtolower($this->nopenyimpananlinen),true);
		$criteria->compare('LOWER(keterangan_penyimpanan)',strtolower($this->keterangan_penyimpanan),true);
		if(!empty($this->ruangan_id)){
			$criteria->addCondition('ruangan_id = '.$this->ruangan_id);
		}
		$criteria->compare('LOWER(ruangan_nama)',strtolower($this->ruangan_nama),true);

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