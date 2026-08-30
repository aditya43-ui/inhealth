<?php

/**
 * This is the model class for table "returresepdet_t".
 *
 * The followings are the available columns in table 'returresepdet_t':
 * @property integer $returresepdet_id
 * @property integer $obatalkespasien_id
 * @property integer $returresep_id
 * @property integer $satuankecil_id
 * @property double $qty_retur
 * @property double $hargasatuan
 * @property string $kondisibrg
 */
class ReturresepdetT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ReturresepdetT the static model class
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
		return 'returresepdet_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('satuankecil_id, qty_retur, hargasatuan', 'required'),
			array('obatalkespasien_id, returresep_id, satuankecil_id', 'numerical', 'integerOnly'=>true),
			array('qty_retur, hargasatuan', 'numerical'),
			array('kondisibrg', 'length', 'max'=>50),
                        array('qty_retur', 'setValidasi', 'on'=>'ReturPenjualanResep'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('returresepdet_id, obatalkespasien_id, returresep_id, satuankecil_id, qty_retur, hargasatuan, kondisibrg', 'safe', 'on'=>'search'),
		);
	}
        
        public function setValidasi(){
            $obatAlkes = ObatalkespasienT::model()->findByPk($this->obatalkespasien_id);
            if (!$this->hasErrors()){
                if ($this->qty_retur > $obatAlkes->qty_oa){
                    $this->addError('qty_retur', 'Quantity Retur tidak boleh lebih dari '.$obatAlkes->qty_oa);
                }
                if ($this->hargasatuan != $obatAlkes->hargasatuan_oa){
                    $this->addError('hargasatuan', 'Harga Satuan tidak boleh kurang atau lebih dari '.$obatAlkes->hargasatuan_oa);
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
                        'satuan'=>array(self::BELONGS_TO, 'SatuankecilM','satuankecil_id'),
                        'obatpasien'=>array(self::BELONGS_TO, 'ObatalkespasienT','obatalkespasien_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'returresepdet_id' => 'Returresepdet',
			'obatalkespasien_id' => 'Obatalkespasien',
			'returresep_id' => 'Returresep',
			'satuankecil_id' => 'Satuankecil',
			'qty_retur' => 'Jumlah Retur',
			'hargasatuan' => 'Hargasatuan',
			'kondisibrg' => 'Kondisibrg',
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

		$criteria->compare('returresepdet_id',$this->returresepdet_id);
		$criteria->compare('obatalkespasien_id',$this->obatalkespasien_id);
		$criteria->compare('returresep_id',$this->returresep_id);
		$criteria->compare('satuankecil_id',$this->satuankecil_id);
		$criteria->compare('qty_retur',$this->qty_retur);
		$criteria->compare('hargasatuan',$this->hargasatuan);
		$criteria->compare('LOWER(kondisibrg)',strtolower($this->kondisibrg),true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		$criteria->compare('returresepdet_id',$this->returresepdet_id);
		$criteria->compare('obatalkespasien_id',$this->obatalkespasien_id);
		$criteria->compare('returresep_id',$this->returresep_id);
		$criteria->compare('satuankecil_id',$this->satuankecil_id);
		$criteria->compare('qty_retur',$this->qty_retur);
		$criteria->compare('hargasatuan',$this->hargasatuan);
		$criteria->compare('LOWER(kondisibrg)',strtolower($this->kondisibrg),true);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
}