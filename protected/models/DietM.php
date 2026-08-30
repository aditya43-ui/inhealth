<?php

/**
 * This is the model class for table "diet_m".
 *
 * The followings are the available columns in table 'diet_m':
 * @property integer $diet_id
 * @property integer $tipediet_id
 * @property integer $zatgizi_id
 * @property integer $jenisdiet_id
 * @property double $diet_kandungan
 */
class DietM extends CActiveRecord
{
                public $tipediet_nama;
                public $zatgizi_nama;
                public $jenisdiet_nama;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return DietM the static model class
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
		return 'diet_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('tipediet_id, zatgizi_id, jenisdiet_id, diet_kandungan', 'required'),
			array('tipediet_id, zatgizi_id, jenisdiet_id', 'numerical', 'integerOnly'=>true),
			array('diet_kandungan', 'numerical'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('diet_id, tipediet_nama, zatgizi_nama, jenisdiet_id, diet_kandungan', 'safe', 'on'=>'search'),
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
                        'tipediet' => array(self::BELONGS_TO, 'TipeDietM', 'tipediet_id'),
			'zatgizi' => array(self::BELONGS_TO, 'ZatgiziM', 'zatgizi_id'),
                        'jenisdiet' => array(self::BELONGS_TO, 'JenisdietM', 'jenisdiet_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'diet_id' => 'ID',
			'tipediet_id' => 'Tipe Diet',
			'zatgizi_id' => 'Zat Gizi',
			'jenisdiet_id' => 'Jenis Diet',
			'diet_kandungan' => 'Kandungan Gizi',
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

		$criteria->compare('diet_id',$this->diet_id);
		$criteria->compare('tipediet_id',$this->tipediet_id);
		$criteria->compare('zatgizi_id',$this->zatgizi_id);
		$criteria->compare('jenisdiet_id',$this->jenisdiet_id);
		$criteria->compare('diet_kandungan',$this->diet_kandungan);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		$criteria->compare('diet_id',$this->diet_id);
		$criteria->compare('tipediet_id',$this->tipediet_id);
		$criteria->compare('zatgizi_id',$this->zatgizi_id);
		$criteria->compare('jenisdiet_id',$this->jenisdiet_id);
		$criteria->compare('diet_kandungan',$this->diet_kandungan);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
        
        public function getTipeDietItems()
        {
            return TipeDietM::model()->findAll('tipediet_aktif=TRUE ORDER BY tipediet_nama');
        }
        
        public function getZatgiziItems()
        {
            return ZatgiziM::model()->findAll('zatgizi_aktif=TRUE ORDER BY zatgizi_nama');
        }
        
        public function getJenisdietItems()
        {
            return JenisdietM::model()->findAll('jenisdiet_aktif=TRUE ORDER BY jenisdiet_nama');
        }
}