<?php

/**
 * This is the model class for table "kritikdansaran_m".
 *
 * The followings are the available columns in table 'kritikdansaran_m':
 * @property integer $kritikdansaran_id
 * @property integer $urutan_soal
 * @property string $label_soal
 * @property string $soal
 * @property boolean $soal_aktif
 */
class KritikdansaranM extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return KritikdansaranM the static model class
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
		return 'kritikdansaran_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('urutan_soal, label_soal', 'required'),
			array('urutan_soal', 'numerical', 'integerOnly'=>true),
			array('label_soal', 'length', 'max'=>100),
			array('soal', 'length', 'max'=>1000),
			array('soal_aktif', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('kritikdansaran_id, urutan_soal, label_soal, soal, soal_aktif', 'safe', 'on'=>'search'),
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
			'kritikdansaran_id' => 'Kritikdansaran',
			'urutan_soal' => 'Urutan Soal',
			'label_soal' => 'Label Soal',
			'soal' => 'Soal',
			'soal_aktif' => 'Soal Aktif',
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

		$criteria->compare('kritikdansaran_id',$this->kritikdansaran_id);
		$criteria->compare('urutan_soal',$this->urutan_soal);
		$criteria->compare('label_soal',$this->label_soal,true);
		$criteria->compare('soal',$this->soal,true);
		$criteria->compare('soal_aktif',$this->soal_aktif);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        public function searchPrint()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('kritikdansaran_id',$this->kritikdansaran_id);
		$criteria->compare('urutan_soal',$this->urutan_soal);
		$criteria->compare('label_soal',$this->label_soal,true);
		$criteria->compare('soal',$this->soal,true);
		$criteria->compare('soal_aktif',$this->soal_aktif);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                        'pagination'=>false,
		));
	}
}