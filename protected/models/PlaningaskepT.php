<?php

/**
 * This is the model class for table "planingaskep_t".
 *
 * The followings are the available columns in table 'planingaskep_t':
 * @property integer $planingaskep_id
 * @property integer $asuhankeperawatan_id
 * @property string $intervensilanjutan
 * @property string $kolaborasilanjutan
 */
class PlaningaskepT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PlaningaskepT the static model class
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
		return 'planingaskep_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('asuhankeperawatan_id', 'required'),
			array('asuhankeperawatan_id', 'numerical', 'integerOnly'=>true),
			array('intervensilanjutan, kolaborasilanjutan', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('planingaskep_id, asuhankeperawatan_id, intervensilanjutan, kolaborasilanjutan', 'safe', 'on'=>'search'),
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
			'planingaskep_id' => 'Planingaskep',
			'asuhankeperawatan_id' => 'Asuhankeperawatan',
			'intervensilanjutan' => 'Intervensilanjutan',
			'kolaborasilanjutan' => 'Kolaborasilanjutan',
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

		$criteria->compare('planingaskep_id',$this->planingaskep_id);
		$criteria->compare('asuhankeperawatan_id',$this->asuhankeperawatan_id);
		$criteria->compare('LOWER(intervensilanjutan)',strtolower($this->intervensilanjutan),true);
		$criteria->compare('LOWER(kolaborasilanjutan)',strtolower($this->kolaborasilanjutan),true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		$criteria->compare('planingaskep_id',$this->planingaskep_id);
		$criteria->compare('asuhankeperawatan_id',$this->asuhankeperawatan_id);
		$criteria->compare('LOWER(intervensilanjutan)',strtolower($this->intervensilanjutan),true);
		$criteria->compare('LOWER(kolaborasilanjutan)',strtolower($this->kolaborasilanjutan),true);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
}