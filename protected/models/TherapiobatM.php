<?php

/**
 * This is the model class for table "therapiobat_m".
 *
 * The followings are the available columns in table 'therapiobat_m':
 * @property integer $therapiobat_id
 * @property string $therapiobat_nama
 * @property string $therapiobat_namalain
 * @property boolean $therapiobat_aktif
 */
class TherapiobatM extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return TherapiobatM the static model class
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
		return 'therapiobat_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('therapiobat_nama', 'required'),
			array('therapiobat_nama, therapiobat_namalain', 'length', 'max'=>100),
			array('therapiobat_aktif', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('therapiobat_id, therapiobat_nama, therapiobat_namalain, therapiobat_aktif', 'safe', 'on'=>'search'),
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
			'therapiobat_id' => 'ID',
			'therapiobat_nama' => 'Nama',
			'therapiobat_namalain' => 'Nama Lainnya',
			'therapiobat_aktif' => 'Aktif',
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

		$criteria->compare('therapiobat_id',$this->therapiobat_id);
		$criteria->compare('LOWER(therapiobat_nama)',strtolower($this->therapiobat_nama),true);
		$criteria->compare('LOWER(therapiobat_namalain)',strtolower($this->therapiobat_namalain),true);
		$criteria->compare('therapiobat_aktif',isset($this->therapiobat_aktif)?$this->therapiobat_aktif:true);
//                $criteria->addCondition('therapiobat_aktif is true');
                 $criteria->order='therapiobat_nama ASC';
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		$criteria->compare('therapiobat_id',$this->therapiobat_id);
		$criteria->compare('LOWER(therapiobat_nama)',strtolower($this->therapiobat_nama),true);
		$criteria->compare('LOWER(therapiobat_namalain)',strtolower($this->therapiobat_namalain),true);
                $criteria->order='therapiobat_nama';
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
        
         public function beforeSave() {
            $this->therapiobat_namalain = strtoupper($this->therapiobat_namalain);
            $this->therapiobat_nama = ucwords(strtolower($this->therapiobat_nama));
            return parent::beforeSave();
        }
}