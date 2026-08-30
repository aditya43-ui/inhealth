<?php

/**
 * This is the model class for table "jabatan_m".
 *
 * The followings are the available columns in table 'jabatan_m':
 * @property integer $jabatan_id
 * @property string $jabatan_nama
 * @property string $jabatan_lainnya
 * @property boolean $jabatan_aktif
 */
class JabatanM extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return JabatanM the static model class
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
		return 'jabatan_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('jabatan_nama, jabatan_aktif', 'required'),
			array('jabatan_nama, jabatan_lainnya', 'length', 'max'=>20),
			array('nominal_sip', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('nominal_sip, jabatan_id, jabatan_nama, jabatan_lainnya, jabatan_aktif', 'safe', 'on'=>'search'),
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

			'jabatan_id' => 'ID',
			'jabatan_nama' => 'Jabatan',
			'jabatan_lainnya' => 'Nama Lainnya',
			'jabatan_aktif' => 'Aktif',
			'nominal_sip' => 'Nominal SIP',
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

		//$criteria->compare('jabatan_id',$this->jabatan_id);
		if(!empty($this->jabatan_id)){
			$criteria->addCondition('jabatan_id = '.$this->jabatan_id);
		}  
		$criteria->compare('LOWER(jabatan_nama)',strtolower($this->jabatan_nama),true);
		$criteria->compare('LOWER(jabatan_lainnya)',strtolower($this->jabatan_lainnya),true);
		$criteria->compare('jabatan_aktif',isset($this->jabatan_aktif)?$this->jabatan_aktif:true);
//                $criteria->addCondition('jabatan_aktif is true');

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		//$criteria->compare('jabatan_id',$this->jabatan_id);
			if(!empty($this->jabatan_id)){
			    $criteria->addCondition('jabatan_id = '.$this->jabatan_id);
		    }  
		        $criteria->compare('LOWER(jabatan_nama)',strtolower($this->jabatan_nama),true);
		        $criteria->compare('LOWER(jabatan_lainnya)',strtolower($this->jabatan_lainnya),true);
                $criteria->compare('jabatan_aktif',$this->jabatan_aktif);

                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }

            
        public function beforeSave() {
            $this->jabatan_nama = ucwords(strtolower($this->jabatan_nama));
            $this->jabatan_lainnya = strtoupper($this->jabatan_lainnya);
            return parent::beforeSave();
        }
        
    public static function jabatanList() {
        return CHtml::listData(self::model()->findAll('jabatan_aktif = true order by jabatan_nama'), 'jabatan_id', 'jabatan_nama');
    }
}