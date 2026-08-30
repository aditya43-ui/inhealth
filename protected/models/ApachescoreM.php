<?php

/**
 * This is the model class for table "apachescore_m".
 *
 * The followings are the available columns in table 'apachescore_m':
 * @property integer $apachescore_id
 * @property integer $varfisiologik_nourut
 * @property string $varfisiologik_nama
 * @property string $varfisiologik_satuan
 * @property string $varfisiologik_namalain
 * @property boolean $apachescore_aktif
 */
class ApachescoreM extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ApachescoreM the static model class
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
		return 'apachescore_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('varfisiologik_nourut, varfisiologik_nama', 'required'),
			array('varfisiologik_nourut', 'numerical', 'integerOnly'=>true),
			array('varfisiologik_nama, varfisiologik_namalain', 'length', 'max'=>200),
			array('varfisiologik_satuan', 'length', 'max'=>50),
			array('apachescore_aktif', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('apachescore_id, varfisiologik_nourut, varfisiologik_nama, varfisiologik_satuan, varfisiologik_namalain, apachescore_aktif', 'safe', 'on'=>'search'),
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
			'apachescore_id' => 'Apache Score',
			'varfisiologik_nourut' => 'Varfisiologik Nourut',
			'varfisiologik_nama' => 'Varfisiologik Nama',
			'varfisiologik_satuan' => 'Varfisiologik Satuan',
			'varfisiologik_namalain' => 'Varfisiologik Namalain',
			'apachescore_aktif' => 'Apachescore Aktif',
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

		$criteria->compare('apachescore_id',$this->apachescore_id);
		$criteria->compare('varfisiologik_nourut',$this->varfisiologik_nourut);
		$criteria->compare('LOWER(varfisiologik_nama)',strtolower($this->varfisiologik_nama),true);
		$criteria->compare('LOWER(varfisiologik_satuan)',strtolower($this->varfisiologik_satuan),true);
		$criteria->compare('LOWER(varfisiologik_namalain)',strtolower($this->varfisiologik_namalain),true);
		$criteria->compare('apachescore_aktif',$this->apachescore_aktif);
                $criteria->addCondition('apachescore_aktif is true');

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		$criteria->compare('apachescore_id',$this->apachescore_id);
		$criteria->compare('varfisiologik_nourut',$this->varfisiologik_nourut);
		$criteria->compare('LOWER(varfisiologik_nama)',strtolower($this->varfisiologik_nama),true);
		$criteria->compare('LOWER(varfisiologik_satuan)',strtolower($this->varfisiologik_satuan),true);
		$criteria->compare('LOWER(varfisiologik_namalain)',strtolower($this->varfisiologik_namalain),true);
		$criteria->compare('apachescore_aktif',$this->apachescore_aktif);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
}