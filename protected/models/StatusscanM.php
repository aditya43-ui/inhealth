<?php

/**
 * This is the model class for table "statusscan_m".
 *
 * The followings are the available columns in table 'statusscan_m':
 * @property integer $statusscan_id
 * @property string $statusscan_nama
 * @property string $statusscan_namalain
 * @property string $statusscan_singkatan
 * @property boolean $statusscan_aktif
 */
class StatusscanM extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return StatusscanM the static model class
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
		return 'statusscan_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('statusscan_nama', 'required'),
			array('statusscan_nama', 'length', 'max'=>100),
			array('statusscan_namalain, statusscan_singkatan', 'length', 'max'=>50),
			array('statusscan_aktif', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('statusscan_id, statusscan_nama, statusscan_namalain, statusscan_singkatan, statusscan_aktif', 'safe', 'on'=>'search'),
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
			'statusscan_id' => 'ID',
			'statusscan_nama' => 'Nama Status Scan',
			'statusscan_namalain' => 'Nama Lain',
			'statusscan_singkatan' => 'Singkatan',
			'statusscan_aktif' => 'Aktif',
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

		$criteria->compare('statusscan_id',$this->statusscan_id);
		$criteria->compare('LOWER(statusscan_nama)',strtolower($this->statusscan_nama),true);
		$criteria->compare('LOWER(statusscan_namalain)',strtolower($this->statusscan_namalain),true);
		$criteria->compare('LOWER(statusscan_singkatan)',strtolower($this->statusscan_singkatan),true);
		$criteria->compare('statusscan_aktif',isset($this->statusscan_aktif)?$this->statusscan_aktif:true);
                //$criteria->addCondition('statusscan_aktif is true');

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		$criteria->compare('statusscan_id',$this->statusscan_id);
		$criteria->compare('LOWER(statusscan_nama)',strtolower($this->statusscan_nama),true);
		$criteria->compare('LOWER(statusscan_namalain)',strtolower($this->statusscan_namalain),true);
		$criteria->compare('LOWER(statusscan_singkatan)',strtolower($this->statusscan_singkatan),true);
		$criteria->compare('statusscan_aktif',$this->statusscan_aktif);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
}