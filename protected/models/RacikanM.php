<?php

/**
 * This is the model class for table "racikan_m".
 *
 * The followings are the available columns in table 'racikan_m':
 * @property integer $racikan_id
 * @property string $racikan_nama
 * @property string $racikan_singkatan
 * @property double $tarifservice
 * @property double $persenservice
 * @property double $biayakemasan
 * @property boolean $racikan_aktif
 */
class RacikanM extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return RacikanM the static model class
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
		return 'racikan_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('racikan_nama, tarifservice, persenservice, biayakemasan', 'required'),
			array('tarifservice, persenservice, biayakemasan', 'numerical'),
			array('racikan_nama', 'length', 'max'=>50),
			array('racikan_singkatan', 'length', 'max'=>20),
			array('racikan_aktif', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('racikan_id, racikan_nama, racikan_singkatan, tarifservice, persenservice, biayakemasan, racikan_aktif', 'safe', 'on'=>'search'),
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
			'racikan_id' => 'Racikan',
			'racikan_nama' => 'Racikan Nama',
			'racikan_singkatan' => 'Racikan Singkatan',
			'tarifservice' => 'Tarifservice',
			'persenservice' => 'Persenservice',
			'biayakemasan' => 'Biayakemasan',
			'racikan_aktif' => 'Racikan Aktif',
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

		$criteria->compare('racikan_id',$this->racikan_id);
		$criteria->compare('LOWER(racikan_nama)',strtolower($this->racikan_nama),true);
		$criteria->compare('LOWER(racikan_singkatan)',strtolower($this->racikan_singkatan),true);
		$criteria->compare('tarifservice',$this->tarifservice);
		$criteria->compare('persenservice',$this->persenservice);
		$criteria->compare('biayakemasan',$this->biayakemasan);
		$criteria->compare('racikan_aktif',$this->racikan_aktif);
                $criteria->addCondition('racikan_aktif is true');

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		$criteria->compare('racikan_id',$this->racikan_id);
		$criteria->compare('LOWER(racikan_nama)',strtolower($this->racikan_nama),true);
		$criteria->compare('LOWER(racikan_singkatan)',strtolower($this->racikan_singkatan),true);
		$criteria->compare('tarifservice',$this->tarifservice);
		$criteria->compare('persenservice',$this->persenservice);
		$criteria->compare('biayakemasan',$this->biayakemasan);
		$criteria->compare('racikan_aktif',$this->racikan_aktif);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
}