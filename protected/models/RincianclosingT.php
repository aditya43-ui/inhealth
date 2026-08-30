<?php

/**
 * This is the model class for table "rincianclosing_t".
 *
 * The followings are the available columns in table 'rincianclosing_t':
 * @property integer $rincianclosing_id
 * @property integer $closingkasir_id
 * @property integer $nourutrincian
 * @property double $nilaiuang
 * @property integer $banyakuang
 * @property double $jumlahuang
 */
class RincianclosingT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return RincianclosingT the static model class
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
		return 'rincianclosing_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('closingkasir_id, nourutrincian, nilaiuang, banyakuang, jumlahuang', 'required'),
			array('closingkasir_id, nourutrincian, banyakuang', 'numerical', 'integerOnly'=>true),
			array('nilaiuang, jumlahuang', 'numerical'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('rincianclosing_id, closingkasir_id, nourutrincian, nilaiuang, banyakuang, jumlahuang', 'safe', 'on'=>'search'),
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
			'rincianclosing_id' => 'Rincianclosing',
			'closingkasir_id' => 'Closingkasir',
			'nourutrincian' => 'Nourutrincian',
			'nilaiuang' => 'Nilaiuang',
			'banyakuang' => 'Banyakuang',
			'jumlahuang' => 'Jumlahuang',
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

		$criteria->compare('rincianclosing_id',$this->rincianclosing_id);
		$criteria->compare('closingkasir_id',$this->closingkasir_id);
		$criteria->compare('nourutrincian',$this->nourutrincian);
		$criteria->compare('nilaiuang',$this->nilaiuang);
		$criteria->compare('banyakuang',$this->banyakuang);
		$criteria->compare('jumlahuang',$this->jumlahuang);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		$criteria->compare('rincianclosing_id',$this->rincianclosing_id);
		$criteria->compare('closingkasir_id',$this->closingkasir_id);
		$criteria->compare('nourutrincian',$this->nourutrincian);
		$criteria->compare('nilaiuang',$this->nilaiuang);
		$criteria->compare('banyakuang',$this->banyakuang);
		$criteria->compare('jumlahuang',$this->jumlahuang);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
}