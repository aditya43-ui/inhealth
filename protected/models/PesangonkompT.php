<?php

/**
 * This is the model class for table "pesangonkomp_t".
 *
 * The followings are the available columns in table 'pesangonkomp_t':
 * @property integer $pesangonkomp_id
 * @property integer $komponengaji_id
 * @property integer $pesangonpeg_id
 * @property double $jumlah
 * @property double $qty
 * @property double $satuan
 * @property string $unit
 *
 * The followings are the available model relations:
 * @property KomponengajiM $komponengaji
 * @property PesangonpegT $pesangonpeg
 */
class PesangonkompT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PesangonkompT the static model class
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
		return 'pesangonkomp_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('komponengaji_id, pesangonpeg_id, jumlah', 'required'),
			array('komponengaji_id, pesangonpeg_id', 'numerical', 'integerOnly'=>true),
			array('jumlah, qty, satuan', 'numerical'),
			array('unit', 'length', 'max'=>50),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('pesangonkomp_id, komponengaji_id, pesangonpeg_id, jumlah, qty, satuan, unit', 'safe', 'on'=>'search'),
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
			'komponengaji' => array(self::BELONGS_TO, 'KomponengajiM', 'komponengaji_id'),
			'pesangonpeg' => array(self::BELONGS_TO, 'PesangonpegT', 'pesangonpeg_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'pesangonkomp_id' => 'Pesangonkomp',
			'komponengaji_id' => 'Komponengaji',
			'pesangonpeg_id' => 'Pesangonpeg',
			'jumlah' => 'Jumlah',
			'qty' => 'Qty',
			'satuan' => 'Satuan',
			'unit' => 'Unit',
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

		if(!empty($this->pesangonkomp_id)){
			$criteria->addCondition('pesangonkomp_id = '.$this->pesangonkomp_id);
		}
		if(!empty($this->komponengaji_id)){
			$criteria->addCondition('komponengaji_id = '.$this->komponengaji_id);
		}
		if(!empty($this->pesangonpeg_id)){
			$criteria->addCondition('pesangonpeg_id = '.$this->pesangonpeg_id);
		}
		$criteria->compare('jumlah',$this->jumlah);
		$criteria->compare('qty',$this->qty);
		$criteria->compare('satuan',$this->satuan);
		$criteria->compare('LOWER(unit)',strtolower($this->unit),true);

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