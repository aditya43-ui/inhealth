<?php

/**
 * This is the model class for table "retpendetail_t".
 *
 * The followings are the available columns in table 'retpendetail_t':
 * @property integer $retpendetail_id
 * @property integer $returpenerimaan_id
 * @property integer $terimapersdetail_id
 * @property double $jmlretur
 * @property double $hargasatuan
 * @property string $satuanbeli
 * @property string $kondisibarang
 */
class RetpendetailT extends CActiveRecord
{
        public $jmlterima, $persendiscount, $persenppn, $persenpph;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return RetpendetailT the static model class
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
		return 'retpendetail_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('returpenerimaan_id, jmlretur, hargasatuan, satuanbeli, kondisibarang', 'required'),
			array('returpenerimaan_id, terimapersdetail_id', 'numerical', 'integerOnly'=>true),
			array('jmlretur, hargasatuan, jmldiscount, jmlppn, jmlpph, hargaretur', 'numerical'),
			array('satuanbeli, kondisibarang', 'length', 'max'=>50),
                        array('jmlterima', 'safe'),
                        array('jmlretur', 'cekRetur'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('retpendetail_id, returpenerimaan_id, terimapersdetail_id, jmlretur, hargasatuan, satuanbeli, kondisibarang, jmldiscount, jmlppn, jmlpph, hargaretur', 'safe', 'on'=>'search'),
		);
	}
        
        public function cekRetur($attribute,$params){
            if (!$this->hasErrors()){
                if ($this->jmlretur > $this->jmlterima){
                    $this->addError('jmlretur','Jumlah Retur tidak boleh lebih dari '.$this->jmlterima);
                }
            }
        }

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
                    'terimapersdetail'=>array(self::BELONGS_TO, 'TerimapersdetailT', 'terimapersdetail_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'retpendetail_id' => 'Retpendetail',
			'returpenerimaan_id' => 'Returpenerimaan',
			'terimapersdetail_id' => 'Terimapersdetail',
			'jmlretur' => 'Jmlretur',
			'hargasatuan' => 'Hargasatuan',
			'satuanbeli' => 'Satuanbeli',
			'kondisibarang' => 'Kondisibarang',
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

		$criteria->compare('retpendetail_id',$this->retpendetail_id);
		$criteria->compare('returpenerimaan_id',$this->returpenerimaan_id);
		$criteria->compare('terimapersdetail_id',$this->terimapersdetail_id);
		$criteria->compare('jmlretur',$this->jmlretur);
		$criteria->compare('hargasatuan',$this->hargasatuan);
		$criteria->compare('LOWER(satuanbeli)',strtolower($this->satuanbeli),true);
		$criteria->compare('LOWER(kondisibarang)',strtolower($this->kondisibarang),true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		$criteria->compare('retpendetail_id',$this->retpendetail_id);
		$criteria->compare('returpenerimaan_id',$this->returpenerimaan_id);
		$criteria->compare('terimapersdetail_id',$this->terimapersdetail_id);
		$criteria->compare('jmlretur',$this->jmlretur);
		$criteria->compare('hargasatuan',$this->hargasatuan);
		$criteria->compare('LOWER(satuanbeli)',strtolower($this->satuanbeli),true);
		$criteria->compare('LOWER(kondisibarang)',strtolower($this->kondisibarang),true);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
}