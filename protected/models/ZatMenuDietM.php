<?php

/**
 * This is the model class for table "zatmenudiet_m".
 *
 * The followings are the available columns in table 'zatmenudiet_m':
 * @property integer $zatmenudiet_id
 * @property integer $zatgizi_id
 * @property integer $menudiet_id
 * @property double $kandunganmenudiet
 */
class ZatMenuDietM extends CActiveRecord
{
                public $zatgizi_nama;
                public $menudiet_nama;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ZatMenuDietM the static model class
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
		return 'zatmenudiet_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('zatgizi_id, menudiet_id, kandunganmenudiet', 'required'),
			array('zatgizi_id, menudiet_id', 'numerical', 'integerOnly'=>true),
			array('kandunganmenudiet', 'numerical'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('zatmenudiet_id, zatgizi_id, menudiet_id, kandunganmenudiet', 'safe', 'on'=>'search'),
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
                                                'zatgizi' => array(self::BELONGS_TO,'ZatgiziM','zatgizi_id'),
                                                'menudiet'=> array(self::BELONGS_TO,'MenuDietM','menudiet_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'zatmenudiet_id' => 'ID',
			'zatgizi_id' => 'Zat Gizi',
			'menudiet_id' => 'Menu Diet',
			'kandunganmenudiet' => 'Kandungan Menu',
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

		$criteria->compare('zatmenudiet_id',$this->zatmenudiet_id);
		$criteria->compare('zatgizi_id',$this->zatgizi_id);
		$criteria->compare('menudiet_id',$this->menudiet_id);
		$criteria->compare('kandunganmenudiet',$this->kandunganmenudiet);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		$criteria->compare('zatmenudiet_id',$this->zatmenudiet_id);
		$criteria->compare('zatgizi_id',$this->zatgizi_id);
		$criteria->compare('menudiet_id',$this->menudiet_id);
		$criteria->compare('kandunganmenudiet',$this->kandunganmenudiet);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
        
        public function getZatgiziItems()
        {
            return ZatgiziM::model()->findAll('zatgizi_aktif=TRUE ORDER BY zatgizi_nama');
        }
        
        public function getMenuDietItems()
        {
            return MenuDietM::model()->findAll(array('order'=>'menudiet_nama'));
        }
}