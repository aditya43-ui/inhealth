<?php

/**
 * This is the model class for table "penyimpananlinendet_t". 
 * @package application.models 
 * @author M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
 * @version     1.0.0
 * @link    <http://piindonesia.co.id>
 * The followings are the available columns in table 'penyimpananlinendet_t':
 * @property integer $penyimpananlinendet_id
 * @property integer $penyimpananlinen_id
 * @property integer $ruangan_id
 * @property integer $pencucianlinen_id
 * @property integer $perawatanlinen_id
 * @property integer $lokasipenyimpanan_id
 * @property integer $linen_id
 * @property integer $rakpenyimpanan_id
 * @property string $keterangan_penyimpaanlinen
 */
class PenyimpananlinendetT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PenyimpananlinendetT the static model class
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
		return 'penyimpananlinendet_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('penyimpananlinen_id, lokasipenyimpanan_id, rakpenyimpanan_id', 'required'),
			array('penyimpananlinen_id, ruangan_id, pencucianlinen_id, perawatanlinen_id, lokasipenyimpanan_id, linen_id, rakpenyimpanan_id', 'numerical', 'integerOnly'=>true),
			array('keterangan_penyimpaanlinen', 'length', 'max'=>200),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('penyimpananlinendet_id, penyimpananlinen_id, ruangan_id, pencucianlinen_id, perawatanlinen_id, lokasipenyimpanan_id, linen_id, rakpenyimpanan_id, keterangan_penyimpaanlinen', 'safe', 'on'=>'search'),
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
			'lokasipenyimpanan'=>array(self::BELONGS_TO,'LokasipenyimpananM','lokasipenyimpanan_id'),
			'linen'=>array(self::BELONGS_TO,'LinenM','linen_id'),
			'rakpenyimpanan'=>array(self::BELONGS_TO,'RakpenyimpananM','rakpenyimpanan_id'),
			'pencucianlinen'=>array(self::BELONGS_TO,'PencucianlinenT','pencucianlinen_id'),
			'perawatanlinen'=>array(self::BELONGS_TO,'PerawatanlinenT','perawatanlinen_id'),
                        'penyimpananlinen'=>array(self::BELONGS_TO,'PenyimpananlinenT','penyimpananlinen_id')
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'penyimpananlinendet_id' => 'Penyimpanan Linen Detail',
			'penyimpananlinen_id' => 'Penyimpanan Linen',
			'ruangan_id' => 'Ruangan',
			'pencucianlinen_id' => 'Pencucian Linen',
			'perawatanlinen_id' => 'Perawatan Linen',
			'lokasipenyimpanan_id' => 'Lokasi Penyimpanan',
			'linen_id' => 'Linen',
			'rakpenyimpanan_id' => 'Rak Penyimpanan',
			'keterangan_penyimpaanlinen' => 'Keterangan',
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

		if(!empty($this->penyimpananlinendet_id)){
			$criteria->addCondition('penyimpananlinendet_id = '.$this->penyimpananlinendet_id);
		}
		if(!empty($this->penyimpananlinen_id)){
			$criteria->addCondition('penyimpananlinen_id = '.$this->penyimpananlinen_id);
		}
		if(!empty($this->ruangan_id)){
			$criteria->addCondition('ruangan_id = '.$this->ruangan_id);
		}
		if(!empty($this->pencucianlinen_id)){
			$criteria->addCondition('pencucianlinen_id = '.$this->pencucianlinen_id);
		}
		if(!empty($this->perawatanlinen_id)){
			$criteria->addCondition('perawatanlinen_id = '.$this->perawatanlinen_id);
		}
		if(!empty($this->lokasipenyimpanan_id)){
			$criteria->addCondition('lokasipenyimpanan_id = '.$this->lokasipenyimpanan_id);
		}
		if(!empty($this->linen_id)){
			$criteria->addCondition('linen_id = '.$this->linen_id);
		}
		if(!empty($this->rakpenyimpanan_id)){
			$criteria->addCondition('rakpenyimpanan_id = '.$this->rakpenyimpanan_id);
		}
		$criteria->compare('LOWER(keterangan_penyimpaanlinen)',strtolower($this->keterangan_penyimpaanlinen),true);

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


        /**
         * action untuk mencetak printout
         * @return \CActiveDataProvider
         */
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