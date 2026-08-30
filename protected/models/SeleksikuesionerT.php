<?php

/**
 * This is the model class for table "seleksikuesioner_t".
 *
 * The followings are the available columns in table 'seleksikuesioner_t':
 * @property integer $seleksidonor_id
 * @property integer $daftardonasi_id
 * @property integer $kuesionerdonor_id
 * @property boolean $ceklist
 *
 * The followings are the available model relations:
 * @property KuesionerdonorM $kuesionerdonor
 * @property SeleksipendonorT $seleksidonor
 */
class SeleksikuesionerT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return SeleksikuesionerT the static model class
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
		return 'seleksikuesioner_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('daftardonasi_id, kuesionerdonor_id, ceklist', 'required'),
			array('seleksidonor_id, daftardonasi_id, kuesionerdonor_id', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('seleksidonor_id, daftardonasi_id, kuesionerdonor_id, ceklist', 'safe', 'on'=>'search'),
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
			'kuesionerdonor' => array(self::BELONGS_TO, 'KuesionerdonorM', 'kuesionerdonor_id'),
			'seleksidonor' => array(self::BELONGS_TO, 'SeleksipendonorT', 'seleksidonor_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'seleksidonor_id' => 'Seleksidonor',
			'daftardonasi_id' => 'Daftardonasi',
			'kuesionerdonor_id' => 'Kuesionerdonor',
			'ceklist' => 'Ceklist',
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

		if(!empty($this->seleksidonor_id)){
			$criteria->addCondition('seleksidonor_id = '.$this->seleksidonor_id);
		}
		if(!empty($this->daftardonasi_id)){
			$criteria->addCondition('daftardonasi_id = '.$this->daftardonasi_id);
		}
		if(!empty($this->kuesionerdonor_id)){
			$criteria->addCondition('kuesionerdonor_id = '.$this->kuesionerdonor_id);
		}
		$criteria->compare('ceklist',$this->ceklist);

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