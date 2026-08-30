<?php

/**
 * This is the model class for table "interpretasiskor_m".
 *
 * The followings are the available columns in table 'interpretasiskor_m':
 * @property integer $interpretasiskor_id
 * @property string $intepretasi_nama
 * @property string $interpretasijmlskor
 * @property integer $interpretasimin
 * @property integer $interpretasimax
 * @property string $catatan
 * @property boolean $interpretasiskor_aktif
 */
class InterpretasiskorM extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return InterpretasiskorM the static model class
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
		return 'interpretasiskor_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('intepretasi_nama, interpretasijmlskor, interpretasimin, interpretasimax', 'required'),
			array('interpretasimin, interpretasimax', 'numerical', 'integerOnly'=>true),
			array('intepretasi_nama', 'length', 'max'=>100),
			array('interpretasijmlskor', 'length', 'max'=>50),
			array('catatan, interpretasiskor_aktif', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('interpretasiskor_id, intepretasi_nama, interpretasijmlskor, interpretasimin, interpretasimax, catatan, interpretasiskor_aktif', 'safe', 'on'=>'search'),
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
			'interpretasiskor_id' => 'ID',
			'intepretasi_nama' => 'Intepretasi Nama',
			'interpretasijmlskor' => 'Interpretasi Jumlah Skor',
			'interpretasimin' => 'Interpretasi Minimum',
			'interpretasimax' => 'Interpretasi Maximum',
			'catatan' => 'Catatan',
			'interpretasiskor_aktif' => 'Aktif',
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

		$criteria->compare('interpretasiskor_id',$this->interpretasiskor_id);
		$criteria->compare('LOWER(intepretasi_nama)',strtolower($this->intepretasi_nama),true);
		$criteria->compare('LOWER(interpretasijmlskor)',strtolower($this->interpretasijmlskor),true);
		$criteria->compare('interpretasimin',$this->interpretasimin);
		$criteria->compare('interpretasimax',$this->interpretasimax);
		$criteria->compare('LOWER(catatan)',strtolower($this->catatan),true);
		$criteria->compare('interpretasiskor_aktif',isset($this->interpretasiskor_aktif)?$this->interpretasiskor_aktif:true);
//                $criteria->addCondition('interpretasiskor_aktif is true');

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		$criteria->compare('interpretasiskor_id',$this->interpretasiskor_id);
		$criteria->compare('LOWER(intepretasi_nama)',strtolower($this->intepretasi_nama),true);
		$criteria->compare('LOWER(interpretasijmlskor)',strtolower($this->interpretasijmlskor),true);
		$criteria->compare('interpretasimin',$this->interpretasimin);
		$criteria->compare('interpretasimax',$this->interpretasimax);
		$criteria->compare('LOWER(catatan)',strtolower($this->catatan),true);
		//$criteria->compare('interpretasiskor_aktif',$this->interpretasiskor_aktif);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
}