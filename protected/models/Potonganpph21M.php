<?php

/**
 * This is the model class for table "potonganpph21_m".
 *
 * The followings are the available columns in table 'potonganpph21_m':
 * @property integer $potonganpph21_id
 * @property double $penghasilandari
 * @property double $sampaidgn_thn
 * @property double $persentarifpenghsl
 */
class Potonganpph21M extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Potonganpph21M the static model class
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
		return 'potonganpph21_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('penghasilandari, sampaidgn_thn, persentarifpenghsl', 'required'),
			array('penghasilandari, sampaidgn_thn, persentarifpenghsl', 'numerical'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('potonganpph21_id, penghasilandari, sampaidgn_thn, persentarifpenghsl', 'safe', 'on'=>'search'),
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
			'potonganpph21_id' => 'Id Potongan PPh 21',
			'penghasilandari' => 'Penghasilan Dari',
			'sampaidgn_thn' => 'Sampai Dengan Tahun',
			'persentarifpenghsl' => 'Persentase Tarif Penghasilan',
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

		$criteria->compare('potonganpph21_id',$this->potonganpph21_id);
		$criteria->compare('penghasilandari',$this->penghasilandari);
		$criteria->compare('sampaidgn_thn',$this->sampaidgn_thn);
		$criteria->compare('persentarifpenghsl',$this->persentarifpenghsl);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		$criteria->compare('potonganpph21_id',$this->potonganpph21_id);
		$criteria->compare('penghasilandari',$this->penghasilandari);
		$criteria->compare('sampaidgn_thn',$this->sampaidgn_thn);
		$criteria->compare('persentarifpenghsl',$this->persentarifpenghsl);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
}