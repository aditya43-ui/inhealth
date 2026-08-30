<?php

/**
 * This is the model class for table "jenistindakanrm_m".
 *
 * The followings are the available columns in table 'jenistindakanrm_m':
 * @property integer $jenistindakanrm_id
 * @property string $jenistindakanrm_nama
 * @property string $jenistindakanrm_namalainnya
 * @property boolean $jenistindakanrm_aktif
 */
class JenistindakanrmM extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return JenistindakanrmM the static model class
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
		return 'jenistindakanrm_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('jenistindakanrm_namalainnya', 'required'),
			array('jenistindakanrm_nama, jenistindakanrm_namalainnya', 'length', 'max'=>50),
			array('jenistindakanrm_aktif', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('jenistindakanrm_id, jenistindakanrm_nama, jenistindakanrm_namalainnya, jenistindakanrm_aktif', 'safe', 'on'=>'search'),
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
			'jenistindakanrm_id' => 'ID',
			'jenistindakanrm_nama' => 'Nama Jenis Tindakan',
			'jenistindakanrm_namalainnya' => 'Nama Lain Jenis Tindakan',
			'jenistindakanrm_aktif' => 'Aktif',
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

		$criteria->compare('jenistindakanrm_id',$this->jenistindakanrm_id);
		$criteria->compare('LOWER(jenistindakanrm_nama)',strtolower($this->jenistindakanrm_nama),true);
		$criteria->compare('LOWER(jenistindakanrm_namalainnya)',strtolower($this->jenistindakanrm_namalainnya),true);
		$criteria->compare('jenistindakanrm_aktif',isset($this->jenistindakanrm_aktif)?$this->jenistindakanrm_aktif:true);
                //$criteria->addCondition('jenistindakanrm_aktif is true');

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		$criteria->compare('jenistindakanrm_id',$this->jenistindakanrm_id);
		$criteria->compare('LOWER(jenistindakanrm_nama)',strtolower($this->jenistindakanrm_nama),true);
		$criteria->compare('LOWER(jenistindakanrm_namalainnya)',strtolower($this->jenistindakanrm_namalainnya),true);
		$criteria->compare('jenistindakanrm_aktif',$this->jenistindakanrm_aktif);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
}