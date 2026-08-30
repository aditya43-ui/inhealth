<?php

/**
 * This is the model class for table "bahandiet_m".
 *
 * The followings are the available columns in table 'bahandiet_m':
 * @property integer $bahandiet_id
 * @property string $bahandiet_nama
 * @property string $bahandiet_namalain
 * @property boolean $bahandiet_aktif
 * 
 * 
 * The followings are the available model relations:
 * @property KirimmenudietT[] $kirimmenudietTs
 * @property PesanmenudietT[] $pesanmenudietTs
 */
class BahandietM extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return BahandietM the static model class
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
		return 'bahandiet_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('bahandiet_nama', 'required'),
			array('bahandiet_nama, bahandiet_namalain', 'length', 'max'=>100),
			array('bahandiet_aktif', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('bahandiet_id, bahandiet_nama, bahandiet_namalain, bahandiet_aktif', 'safe', 'on'=>'search'),
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
                    'kirimmenudietTs' => array(self::HAS_MANY, 'KirimmenudietT', 'bahandiet_id'),
                    'pesanmenudietTs' => array(self::HAS_MANY, 'PesanmenudietT', 'bahandiet_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'bahandiet_id' => 'Bahan Diet',
			'bahandiet_nama' => 'Nama Bahan Diet',
			'bahandiet_namalain' => 'Nama Lain Bahan Diet',
			'bahandiet_aktif' => 'Aktif',
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

		$criteria->compare('bahandiet_id',$this->bahandiet_id);
		$criteria->compare('LOWER(bahandiet_nama)',strtolower($this->bahandiet_nama),true);
		$criteria->compare('LOWER(bahandiet_namalain)',strtolower($this->bahandiet_namalain),true);
		$criteria->compare('bahandiet_aktif',isset($this->bahandiet_aktif)?$this->bahandiet_aktif:true);
                //$criteria->addCondition('bahandiet_aktif is true');

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		$criteria->compare('bahandiet_id',$this->bahandiet_id);
		$criteria->compare('LOWER(bahandiet_nama)',strtolower($this->bahandiet_nama),true);
		$criteria->compare('LOWER(bahandiet_namalain)',strtolower($this->bahandiet_namalain),true);
		//$criteria->compare('bahandiet_aktif',$this->bahandiet_aktif);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
}