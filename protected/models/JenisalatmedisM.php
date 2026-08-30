<?php

/**
 * This is the model class for table "jenisalatmedis_m".
 *
 * The followings are the available columns in table 'jenisalatmedis_m':
 * @property integer $jenisalatmedis_id
 * @property string $jenisalatmedis_nama
 * @property string $jenisalatmedis_namalain
 * @property boolean $jenisalatmedis_aktif
 */
class JenisalatmedisM extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return JenisalatmedisM the static model class
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
		return 'jenisalatmedis_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('jenisalatmedis_nama', 'required'),
			array('jenisalatmedis_nama, jenisalatmedis_namalain', 'length', 'max'=>100),
			array('jenisalatmedis_aktif', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('jenisalatmedis_id, jenisalatmedis_nama, jenisalatmedis_namalain, jenisalatmedis_aktif', 'safe', 'on'=>'search'),
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
			'jenisalatmedis_id' => 'ID',
			'jenisalatmedis_nama' => 'Nama jenis Alat Medis',
			'jenisalatmedis_namalain' => 'Nama Lainnya',
			'jenisalatmedis_aktif' => 'Aktif',
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

		$criteria->compare('jenisalatmedis_id',$this->jenisalatmedis_id);
		$criteria->compare('LOWER(jenisalatmedis_nama)',strtolower($this->jenisalatmedis_nama),true);
		$criteria->compare('LOWER(jenisalatmedis_namalain)',strtolower($this->jenisalatmedis_namalain),true);
		$criteria->compare('jenisalatmedis_aktif',isset($this->jenisalatmedis_aktif)?$this->jenisalatmedis_aktif:true);
//                $criteria->addCondition('jenisalatmedis_aktif is true');

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        public function searchPrint()
        {
                // Warning: Please modifyaaqaaaa the following code to remove attributes that
                // should not be searched.
                $criteria=new CDbCriteria;
		$criteria->compare('jenisalatmedis_id',$this->jenisalatmedis_id);
		$criteria->compare('LOWER(jenisalatmedis_nama)',strtolower($this->jenisalatmedis_nama),true);
		$criteria->compare('LOWER(jenisalatmedis_namalain)',strtolower($this->jenisalatmedis_namalain),true);
		//$criteria->compare('jenisalatmedis_aktif',$this->jenisalatmedis_aktif);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
}