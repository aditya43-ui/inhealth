<?php

/**
 * This is the model class for table "jenissebab_m".
 *
 * The followings are the available columns in table 'jenissebab_m':
 * @property integer $jenissebab_id
 * @property string $jenissebab_nama
 * @property string $jenissebab_namalainnya
 * @property boolean $jenissebab_aktif
 */
class JenissebabM extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return JenissebabM the static model class
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
		return 'jenissebab_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('jenissebab_nama', 'required'),
			array('jenissebab_nama, jenissebab_namalainnya', 'length', 'max'=>100),
			array('jenissebab_aktif', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('jenissebab_id, jenissebab_nama, jenissebab_namalainnya, jenissebab_aktif', 'safe', 'on'=>'search'),
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
			'jenissebab_id' => 'ID',
			'jenissebab_nama' => 'Nama Jenis Sebab',
			'jenissebab_namalainnya' => 'Nama Lainnya',
			'jenissebab_aktif' => 'Aktif',
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

		$criteria->compare('jenissebab_id',$this->jenissebab_id);
		$criteria->compare('LOWER(jenissebab_nama)',strtolower($this->jenissebab_nama),true);
		$criteria->compare('LOWER(jenissebab_namalainnya)',strtolower($this->jenissebab_namalainnya),true);
		$criteria->compare('jenissebab_aktif',isset($this->jenissebab_aktif)?$this->jenissebab_aktif:true);
                //$criteria->addCondition('jenissebab_aktif is true');

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		$criteria->compare('jenissebab_id',$this->jenissebab_id);
		$criteria->compare('LOWER(jenissebab_nama)',strtolower($this->jenissebab_nama),true);
		$criteria->compare('LOWER(jenissebab_namalainnya)',strtolower($this->jenissebab_namalainnya),true);
		$criteria->compare('jenissebab_aktif',$this->jenissebab_aktif);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
}