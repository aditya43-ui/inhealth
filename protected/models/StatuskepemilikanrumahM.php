<?php

/**
 * This is the model class for table "statuskepemilikanrumah_m".
 *
 * The followings are the available columns in table 'statuskepemilikanrumah_m':
 * @property integer $statuskepemilikanrumah_id
 * @property string $statuskepemilikanrumah_nama
 * @property string $statuskepemilikanrumah_namalain
 * @property boolean $statuskepemilikanrumah_aktif
 */
class StatuskepemilikanrumahM extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return StatuskepemilikanrumahM the static model class
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
		return 'statuskepemilikanrumah_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('statuskepemilikanrumah_nama', 'required'),
			array('statuskepemilikanrumah_nama, statuskepemilikanrumah_namalain', 'length', 'max'=>10),
			array('statuskepemilikanrumah_aktif', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('statuskepemilikanrumah_id, statuskepemilikanrumah_nama, statuskepemilikanrumah_namalain, statuskepemilikanrumah_aktif', 'safe', 'on'=>'search'),
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
			'statuskepemilikanrumah_id' => 'ID',
			'statuskepemilikanrumah_nama' => 'Status Kepemilikan Rumah',
			'statuskepemilikanrumah_namalain' => 'Nama Lain',
			'statuskepemilikanrumah_aktif' => 'Aktif',
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

		$criteria->compare('statuskepemilikanrumah_id',$this->statuskepemilikanrumah_id);
		$criteria->compare('LOWER(statuskepemilikanrumah_nama)',strtolower($this->statuskepemilikanrumah_nama),true);
		$criteria->compare('LOWER(statuskepemilikanrumah_namalain)',strtolower($this->statuskepemilikanrumah_namalain),true);
		$criteria->compare('statuskepemilikanrumah_aktif',isset($this->statuskepemilikanrumah_aktif)?$this->statuskepemilikanrumah_aktif:true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		$criteria->compare('statuskepemilikanrumah_id',$this->statuskepemilikanrumah_id);
		$criteria->compare('LOWER(statuskepemilikanrumah_nama)',strtolower($this->statuskepemilikanrumah_nama),true);
		$criteria->compare('LOWER(statuskepemilikanrumah_namalain)',strtolower($this->statuskepemilikanrumah_namalain),true);
		$criteria->compare('statuskepemilikanrumah_aktif',$this->statuskepemilikanrumah_aktif);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
}