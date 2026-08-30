<?php
/**
 * @author Wahyu Wicaksono <wahyuwicaksono@.com>
 * @issue RSST-8873
 * @category New Feature
 */
/**
 * This is the model class for table "faktorhub_daftar_m".
 *
 * The followings are the available columns in table 'faktorhub_daftar_m':
 * @property integer $faktorhub_daftar_id
 * @property string $faktorhub_daftar_nama
 * @property string $faktorhub_daftar_namalain
 * @property boolean $faktorhub_daftar_aktif
 */
class FaktorhubDaftarM extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return FaktorhubDaftarM the static model class
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
		return 'faktorhub_daftar_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
        public $aktif;
        public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('faktorhub_daftar_nama', 'required'),
			array('faktorhub_daftar_namalain, faktorhub_daftar_aktif', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('faktorhub_daftar_id, faktorhub_daftar_nama, faktorhub_daftar_namalain, faktorhub_daftar_aktif', 'safe', 'on'=>'search'),
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
			'faktorhub_daftar_id' => 'Faktorhub Daftar',
			'faktorhub_daftar_nama' => 'Faktorhub Daftar Nama',
			'faktorhub_daftar_namalain' => 'Faktorhub Daftar Namalain',
			'faktorhub_daftar_aktif' => 'Faktorhub Daftar Aktif',
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

		$criteria->compare('faktorhub_daftar_id',$this->faktorhub_daftar_id);

                $criteria->compare('LOWER(t.faktorhub_daftar_nama)',strtolower($this->faktorhub_daftar_nama),true);
                $criteria->compare('LOWER(t.faktorhub_daftar_namalain)',strtolower($this->faktorhub_daftar_namalain),true);
                if ($this->faktorhub_daftar_aktif == '1') {
                    $criteria->addCondition('t.faktorhub_daftar_aktif = TRUE');
                }
                if ($this->faktorhub_daftar_aktif == '0'){
                    $criteria->addCondition('t.faktorhub_daftar_aktif = FALSE');
                }
                
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        public function printData()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('faktorhub_daftar_id',$this->faktorhub_daftar_id);

                $criteria->compare('LOWER(t.faktorhub_daftar_nama)',strtolower($this->faktorhub_daftar_nama),true);
                $criteria->compare('LOWER(t.faktorhub_daftar_namalain)',strtolower($this->faktorhub_daftar_namalain),true);
                if ($this->faktorhub_daftar_aktif == '1') {
                    $criteria->addCondition('t.faktorhub_daftar_aktif = TRUE');
                }
                if ($this->faktorhub_daftar_aktif == '0'){
                    $criteria->addCondition('t.faktorhub_daftar_aktif = FALSE');
                }
                
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                        'pagination' => false,
		));
	}
}