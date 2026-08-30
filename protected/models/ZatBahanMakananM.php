<?php

/**
 * This is the model class for table "zatbahanmakan_m".
 *
 * The followings are the available columns in table 'zatbahanmakan_m':
 * @property integer $zatbahanmakan_id
 * @property integer $zatgizi_id
 * @property integer $bahanmakanan_id
 * @property double $kandunganbahan
 */
class ZatBahanMakananM extends CActiveRecord
{
                public $zatgizi_nama, $bahanmakananNama;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ZatBahanMakananM the static model class
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
		return 'zatbahanmakan_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('zatgizi_id, bahanmakanan_id, kandunganbahan', 'required'),
			array('zatgizi_id, bahanmakanan_id', 'numerical', 'integerOnly'=>true),
			array('kandunganbahan', 'numerical'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('zatbahanmakan_id, zatgizi_id, bahanmakananNama, zatgizi_nama, bahanmakanan_id, kandunganbahan', 'safe', 'on'=>'search'),
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
                                    'zatgizi' => array(self::BELONGS_TO, 'ZatgiziM', 'zatgizi_id'),
                                    'bahanmakanan' => array(self::BELONGS_TO, 'BahanmakananM', 'bahanmakanan_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'zatbahanmakan_id' => 'ID',
			'zatgizi_id' => 'Zat Gizi',
			'bahanmakanan_id' => 'Nama Makanan',
			'kandunganbahan' => 'Kandungan Makanan',
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

		$criteria->compare('zatbahanmakan_id',$this->zatbahanmakan_id);
		$criteria->compare('zatgizi_id',$this->zatgizi_id);
		$criteria->compare('bahanmakanan_id',$this->bahanmakanan_id);
		$criteria->compare('kandunganbahan',$this->kandunganbahan);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		$criteria->compare('zatbahanmakan_id',$this->zatbahanmakan_id);
		$criteria->compare('zatgizi_id',$this->zatgizi_id);
		$criteria->compare('bahanmakanan_id',$this->bahanmakanan_id);
		$criteria->compare('kandunganbahan',$this->kandunganbahan);
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
        
        public function getBahanMakananItems()
        {
            return BahanmakananM::model()->findAll(array('order'=>'namabahanmakanan ASC'));
        }
}