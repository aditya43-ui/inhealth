<?php

/**
 * This is the model class for table "tipediet_m".
 *
 * The followings are the available columns in table 'tipediet_m':
 * @property integer $tipediet_id
 * @property string $tipediet_nama
 * @property string $tipediet_namalainnya
 * @property boolean $tipediet_aktif
 */
class TipeDietM extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return TipeDietM the static model class
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
		return 'tipediet_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('tipediet_nama', 'required'),
			array('tipediet_nama, tipediet_namalainnya', 'length', 'max'=>400),
			array('tipediet_aktif', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('tipediet_id, tipediet_nama, tipediet_namalainnya, tipediet_aktif', 'safe', 'on'=>'search'),
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
                                    'tipediet' => array(self::BELONGS_TO,'TipeDietM','tipediet_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'tipediet_id' => 'ID',
			'tipediet_nama' => 'Nama Tipe',
			'tipediet_namalainnya' => 'Nama Lainnya',
			'tipediet_aktif' => 'Aktif',
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

		$criteria->compare('tipediet_id',$this->tipediet_id);
		$criteria->compare('LOWER(tipediet_nama)',strtolower($this->tipediet_nama),true);
		$criteria->compare('LOWER(tipediet_namalainnya)',strtolower($this->tipediet_namalainnya),true);
		$criteria->compare('tipediet_aktif',isset($this->tipediet_aktif)?$this->tipediet_aktif:true);
                $criteria->order="tipediet_nama ASC";
                //$criteria->addCondition('tipediet_aktif is true');

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		$criteria->compare('tipediet_id',$this->tipediet_id);
		$criteria->compare('LOWER(tipediet_nama)',strtolower($this->tipediet_nama),true);
		$criteria->compare('LOWER(tipediet_namalainnya)',strtolower($this->tipediet_namalainnya),true);
		$criteria->order="tipediet_nama ASC";
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
}