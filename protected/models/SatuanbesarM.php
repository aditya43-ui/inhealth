<?php

/**
 * This is the model class for table "satuanbesar_m".
 *
 * The followings are the available columns in table 'satuanbesar_m':
 * @property integer $satuanbesar_id
 * @property string $satuanbesar_nama
 * @property string $satuanbesar_namalain
 * @property boolean $satuanbesar_aktif
 */
class SatuanbesarM extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return SatuanbesarM the static model class
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
		return 'satuanbesar_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('satuanbesar_nama', 'required'),
			array('satuanbesar_nama, satuanbesar_namalain', 'length', 'max'=>50),
			array('satuanbesar_aktif', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('satuanbesar_id, satuanbesar_nama, satuanbesar_namalain, satuanbesar_aktif', 'safe', 'on'=>'search'),
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
			'satuanbesar_id' => 'ID',
			'satuanbesar_nama' => 'Nama',
			'satuanbesar_namalain' => 'Nama Lainnya',
			'satuanbesar_aktif' => 'Aktif',
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

		$criteria->compare('satuanbesar_id',$this->satuanbesar_id);
		$criteria->compare('LOWER(satuanbesar_nama)',strtolower($this->satuanbesar_nama),true);
		$criteria->compare('LOWER(satuanbesar_namalain)',strtolower($this->satuanbesar_namalain),true);
		$criteria->compare('satuanbesar_aktif',isset($this->satuanbesar_aktif)?$this->satuanbesar_aktif:true);
                $criteria->order='satuanbesar_nama ASC';
//                $criteria->addCondition('satuanbesar_aktif is true');
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		$criteria->compare('satuanbesar_id',$this->satuanbesar_id);
		$criteria->compare('LOWER(satuanbesar_nama)',strtolower($this->satuanbesar_nama),true);
		$criteria->compare('LOWER(satuanbesar_namalain)',strtolower($this->satuanbesar_namalain),true);
		$criteria->compare('satuanbesar_aktif',$this->satuanbesar_aktif);
                $criteria->order='satuanbesar_nama ASC';
                
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
        
          public function beforeSave() {
            $this->satuanbesar_nama = ucwords(strtolower($this->satuanbesar_nama));
            $this->satuanbesar_namalain = strtoupper($this->satuanbesar_namalain);
            return parent::beforeSave();
        }
}