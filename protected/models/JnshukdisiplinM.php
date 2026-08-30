<?php

/**
 * This is the model class for table "jnshukdisiplin_m".
 *
 * The followings are the available columns in table 'jnshukdisiplin_m':
 * @property integer $jnshukdisiplin_id
 * @property string $jnshukdisiplin_nama
 * @property string $jnshukdisiplin_namalain
 * @property boolean $jnshukdisiplin_aktif
 */
class JnshukdisiplinM extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return JnshukdisiplinM the static model class
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
		return 'jnshukdisiplin_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('jnshukdisiplin_nama', 'required'),
			array('jnshukdisiplin_nama, jnshukdisiplin_namalain', 'length', 'max'=>100),
			array('jnshukdisiplin_aktif', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('jnshukdisiplin_id, jnshukdisiplin_nama, jnshukdisiplin_namalain, jnshukdisiplin_aktif', 'safe', 'on'=>'search'),
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
			'jnshukdisiplin_id' => 'Jnshukdisiplin',
			'jnshukdisiplin_nama' => 'Jnshukdisiplin Nama',
			'jnshukdisiplin_namalain' => 'Jnshukdisiplin Namalain',
			'jnshukdisiplin_aktif' => 'Jnshukdisiplin Aktif',
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

		$criteria->compare('jnshukdisiplin_id',$this->jnshukdisiplin_id);
		$criteria->compare('LOWER(jnshukdisiplin_nama)',strtolower($this->jnshukdisiplin_nama),true);
		$criteria->compare('LOWER(jnshukdisiplin_namalain)',strtolower($this->jnshukdisiplin_namalain),true);
		$criteria->compare('jnshukdisiplin_aktif',$this->jnshukdisiplin_aktif);
                $criteria->addCondition('jnshukdisiplin_aktif is true');

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		$criteria->compare('jnshukdisiplin_id',$this->jnshukdisiplin_id);
		$criteria->compare('LOWER(jnshukdisiplin_nama)',strtolower($this->jnshukdisiplin_nama),true);
		$criteria->compare('LOWER(jnshukdisiplin_namalain)',strtolower($this->jnshukdisiplin_namalain),true);
		$criteria->compare('jnshukdisiplin_aktif',$this->jnshukdisiplin_aktif);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
}