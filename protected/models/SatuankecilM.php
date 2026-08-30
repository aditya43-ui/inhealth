<?php

/**
 * This is the model class for table "satuankecil_m".
 *
 * The followings are the available columns in table 'satuankecil_m':
 * @property integer $satuankecil_id
 * @property string $satuankecil_nama
 * @property string $satuankecil_namalain
 * @property boolean $satuankecil_aktif
 */
class SatuankecilM extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return SatuankecilM the static model class
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
		return 'satuankecil_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('satuankecil_nama', 'required'),
			array('satuankecil_nama, satuankecil_namalain', 'length', 'max'=>50),
			array('satuankecil_aktif', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('satuankecil_id, satuankecil_nama, satuankecil_namalain, satuankecil_aktif', 'safe', 'on'=>'search'),
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
			'satuankecil_id' => 'ID',
			'satuankecil_nama' => 'Nama',
			'satuankecil_namalain' => 'Nama Lainnya',
			'satuankecil_aktif' => 'Aktif',
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

		$criteria->compare('satuankecil_id',$this->satuankecil_id);
		$criteria->compare('LOWER(satuankecil_nama)',strtolower($this->satuankecil_nama),true);
		$criteria->compare('LOWER(satuankecil_namalain)',strtolower($this->satuankecil_namalain),true);
		$criteria->compare('satuankecil_aktif',isset($this->satuankecil_aktif)?$this->satuankecil_aktif:true);
//                $criteria->addCondition('satuankecil_aktif is true');
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		$criteria->compare('satuankecil_id',$this->satuankecil_id);
		$criteria->compare('LOWER(satuankecil_nama)',strtolower($this->satuankecil_nama),true);
		$criteria->compare('LOWER(satuankecil_namalain)',strtolower($this->satuankecil_namalain),true);
		$criteria->compare('satuankecil_aktif',isset($this->satuankecil_aktif)?$this->satuankecil_aktif:true);
//		$criteria->compare('satuankecil_aktif',$this->satuankecil_aktif);
                // $criteria->order='satuankecil_nama';
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
        
         public function beforeSave() {
            $this->satuankecil_nama = ucwords(strtolower($this->satuankecil_nama));
            $this->satuankecil_namalain = strtoupper($this->satuankecil_namalain);
            return parent::beforeSave();
        }
}