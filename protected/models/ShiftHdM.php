<?php

/**
 * This is the model class for table "shift_hd_m".
 *
 * The followings are the available columns in table 'shift_hd_m':
 * @property integer $shift_hd_id
 * @property string $shift_hd_nama
 * @property string $shift_hd_namalainnya
 * @property string $shift_hd_jamawal
 * @property string $shift_hd_jamakhir
 * @property boolean $shift_hd_aktif
 * @property integer $shift_hd_urutan
 */
class ShiftHdM extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ShiftHdM the static model class
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
		return 'shift_hd_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('shift_hd_jamawal, shift_hd_jamakhir, shift_hd_aktif', 'required'),
			array('shift_hd_urutan', 'numerical', 'integerOnly'=>true),
			array('shift_hd_nama', 'length', 'max'=>100),
			array('shift_hd_namalainnya', 'length', 'max'=>50),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('shift_hd_id, shift_hd_nama, shift_hd_namalainnya, shift_hd_jamawal, shift_hd_jamakhir, shift_hd_aktif, shift_hd_urutan', 'safe', 'on'=>'search'),
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
			'shift_hd_id' => 'Shift Hd',
			'shift_hd_nama' => 'Nama Shift',
			'shift_hd_namalainnya' => 'Nama Lainnya',
			'shift_hd_jamawal' => 'Jam Awal Shift',
			'shift_hd_jamakhir' => 'Jam Akhir Shift',
			'shift_hd_aktif' => 'Shift Hd Aktif',
			'shift_hd_urutan' => 'Urutan Shift',
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

		$criteria->compare('shift_hd_id',$this->shift_hd_id);
		$criteria->compare('shift_hd_nama',$this->shift_hd_nama,true);
		$criteria->compare('shift_hd_namalainnya',$this->shift_hd_namalainnya,true);
		$criteria->compare('shift_hd_jamawal',$this->shift_hd_jamawal,true);
		$criteria->compare('shift_hd_jamakhir',$this->shift_hd_jamakhir,true);
		$criteria->compare('shift_hd_aktif',$this->shift_hd_aktif);
		$criteria->compare('shift_hd_urutan',$this->shift_hd_urutan);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        public function searchData()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
                
                if(isset($_GET['ShiftHdM']['shift_hd_jamawal'])){
                    $criteria->addBetweenCondition('TIME(shift_hd_jamawal)',date('H:i:s', strtotime($_GET['ShiftHdM']['shift_hd_jamawal'])),date('H:i:s', strtotime($_GET['ShiftHdM']['shift_hd_jamakhir'])));
                }
                
		$criteria->compare('shift_hd_id',$this->shift_hd_id);
		$criteria->compare('shift_hd_nama',$this->shift_hd_nama,true);
		$criteria->compare('shift_hd_namalainnya',$this->shift_hd_namalainnya,true);
//		$criteria->compare('shift_hd_jamawal',$this->shift_hd_jamawal,true);
//		$criteria->compare('shift_hd_jamakhir',$this->shift_hd_jamakhir,true);
		$criteria->compare('shift_hd_aktif',$this->shift_hd_aktif);
		$criteria->compare('shift_hd_urutan',$this->shift_hd_urutan);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        public function searchPrint()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
                
                if(isset($_GET['ShiftHdM']['shift_hd_jamawal'])){
                    $criteria->addBetweenCondition('TIME(shift_hd_jamawal)',date('H:i:s', strtotime($_GET['ShiftHdM']['shift_hd_jamawal'])),date('H:i:s', strtotime($_GET['ShiftHdM']['shift_hd_jamakhir'])));
                }
                
		$criteria->compare('shift_hd_id',$this->shift_hd_id);
		$criteria->compare('shift_hd_nama',$this->shift_hd_nama,true);
		$criteria->compare('shift_hd_namalainnya',$this->shift_hd_namalainnya,true);
//		$criteria->compare('shift_hd_jamawal',$this->shift_hd_jamawal,true);
//		$criteria->compare('shift_hd_jamakhir',$this->shift_hd_jamakhir,true);
		$criteria->compare('shift_hd_aktif',$this->shift_hd_aktif);
		$criteria->compare('shift_hd_urutan',$this->shift_hd_urutan);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
//        public function searchPrint()
//        {
//            // Warning: Please modify the following code to remove attributes that
//            // should not be searched.
//
//            $criteria=$this->criteriaSearch();
//            $criteria->limit=-1; 
//
//            return new CActiveDataProvider($this, array(
//                    'criteria'=>$criteria,
//                    'pagination'=>false,
//            ));
//        }
}
