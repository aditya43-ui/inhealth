<?php

/**
 * This is the model class for table "tiperekening_m".
 *
 * The followings are the available columns in table 'tiperekening_m':
 * @property integer $tiperekening_id
 * @property string $tiperekening
 * @property string $keterangan
 * @property boolean $tiperekening_aktif
 */
class TiperekeningM extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return TiperekeningM the static model class
         * 
	 */
        private static $_items=array();
        
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tiperekening_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('tiperekening', 'required'),
			array('tiperekening', 'length', 'max'=>50),
			array('keterangan, tiperekening_aktif', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('tiperekening_id, tiperekening, keterangan, tiperekening_aktif', 'safe', 'on'=>'search'),
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
			'tiperekening_id' => 'ID Tipe Rekening',
			'tiperekening' => 'Tipe Rekening',
			'keterangan' => 'Keterangan',
			'tiperekening_aktif' => 'Tipe Rekening Aktif',
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

		$criteria->compare('tiperekening_id',$this->tiperekening_id);
		$criteria->compare('LOWER(tiperekening)',strtolower($this->tiperekening),true);
		$criteria->compare('LOWER(keterangan)',strtolower($this->keterangan),true);
		$criteria->compare('tiperekening_aktif',isset($this->tiperekening_aktif)?$this->tiperekening_aktif:true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		$criteria->compare('tiperekening_id',$this->tiperekening_id);
		$criteria->compare('LOWER(tiperekening)',strtolower($this->tiperekening),true);
		$criteria->compare('LOWER(keterangan)',strtolower($this->keterangan),true);
		$criteria->compare('tiperekening_aktif',$this->tiperekening_aktif);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
        
        public static function items()
        {
            $models = self::model()->findAll(
                array(
                    'condition'=>'tiperekening_aktif = true',
                    'order'=>'tiperekening ASC ',
                )
            );
            foreach($models as $model)
            {
                self::$_items[$model->tiperekening_id] = $model->tiperekening;
            }
            return self::$_items;
        }
}