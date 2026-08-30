<?php

/**
 * This is the model class for table "bahanmenudiet_m".
 *
 * The followings are the available columns in table 'bahanmenudiet_m':
 * @property integer $bahanmenudiet_id
 * @property integer $menudiet_id
 * @property integer $bahanmakanan_id
 * @property double $jmlbahan
 * 
 * The followings are the available model relations:
 * @property BahanmakananM $bahanmakanan
 * @property MenuDietM $menudiet
 */
class BahanMenuDietM extends CActiveRecord
{
                public $menudiet_nama;
                public $namabahanmakanan;				
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return BahanMenuDietM the static model class
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
		return 'bahanmenudiet_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('menudiet_id, bahanmakanan_id', 'required'),
			array('menudiet_id, bahanmakanan_id', 'numerical', 'integerOnly'=>true),
			array('jmlbahan', 'numerical'),
			array('satuanbahan', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('bahanmenudiet_id, menudiet_id, bahanmakanan_id, jmlbahan', 'safe', 'on'=>'search'),
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
                                    'menudiet'=>array(self::BELONGS_TO,'MenuDietM','menudiet_id'),
                                    'bahanmakanan'=>array(self::BELONGS_TO,'BahanmakananM','bahanmakanan_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'bahanmenudiet_id' => 'Bahan Menu Diet',
			'menudiet_id' => 'Menu Diet',
			'bahanmakanan_id' => 'Bahan Makanan',
			'jmlbahan' => 'Jumlah Bahan',
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

		$criteria->compare('bahanmenudiet_id',$this->bahanmenudiet_id);
		$criteria->compare('menudiet_id',$this->menudiet_id);
		$criteria->compare('bahanmakanan_id',$this->bahanmakanan_id);
		$criteria->compare('jmlbahan',$this->jmlbahan);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		$criteria->compare('bahanmenudiet_id',$this->bahanmenudiet_id);
		$criteria->compare('menudiet_id',$this->menudiet_id);
		$criteria->compare('bahanmakanan_id',$this->bahanmakanan_id);
		$criteria->compare('jmlbahan',$this->jmlbahan);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
        
        public function getMenuDietItems()
        {
            return MenuDietM::model()->findAll(array('order'=>'menudiet_nama'));
        }
        
        public function getBahanMakananItems()
        {
            return BahanmakananM::model()->findAll(array('order'=>'namabahanmakanan'));
        }
}