<?php

/**
 * This is the model class for table "pesanperlinensterildet_t".
 *
 * The followings are the available columns in table 'pesanperlinensterildet_t':
 * @property integer $pesanperlinensterildet_id
 * @property integer $barang_id
 * @property integer $pesanperlinensteril_id
 * @property integer $linen_id
 * @property integer $pesanperlinensterildet_jml
 * @property string $pesanperlinensterildet_ket
 */
class PesanperlinensterildetT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PesanperlinensterildetT the static model class
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
		return 'pesanperlinensterildet_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('barang_id, pesanperlinensteril_id, pesanperlinensterildet_jml', 'required'),
			array('barang_id, pesanperlinensteril_id, linen_id, pesanperlinensterildet_jml', 'numerical', 'integerOnly'=>true),
			array('pesanperlinensterildet_ket', 'length', 'max'=>200),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('pesanperlinensterildet_id, barang_id, pesanperlinensteril_id, linen_id, pesanperlinensterildet_jml, pesanperlinensterildet_ket', 'safe', 'on'=>'search'),
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
            'linen' => array(self::BELONGS_TO, 'LinenM', 'linen_id'),
			'barang'=>array(self::BELONGS_TO,'BarangM','barang_id'),
			'pesan'=>array(self::BELONGS_TO,'PesanperlinensterilT','pesanperlinensteril_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'pesanperlinensterildet_id' => 'Pesanperlinensterildet',
			'barang_id' => 'Barang',
			'pesanperlinensteril_id' => 'Pesanperlinensteril',
			'linen_id' => 'Linen',
			'pesanperlinensterildet_jml' => 'Jumlah',
			'pesanperlinensterildet_ket' => 'Keterangan',
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

		if(!empty($this->pesanperlinensterildet_id)){
			$criteria->addCondition('pesanperlinensterildet_id = '.$this->pesanperlinensterildet_id);
		}
		if(!empty($this->barang_id)){
			$criteria->addCondition('barang_id = '.$this->barang_id);
		}
		if(!empty($this->pesanperlinensteril_id)){
			$criteria->addCondition('pesanperlinensteril_id = '.$this->pesanperlinensteril_id);
		}
		if(!empty($this->linen_id)){
			$criteria->addCondition('linen_id = '.$this->linen_id);
		}
		if(!empty($this->pesanperlinensterildet_jml)){
			$criteria->addCondition('pesanperlinensterildet_jml = '.$this->pesanperlinensterildet_jml);
		}
		$criteria->compare('LOWER(pesanperlinensterildet_ket)',strtolower($this->pesanperlinensterildet_ket),true);

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