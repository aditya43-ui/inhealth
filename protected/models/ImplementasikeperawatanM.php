<?php

/**
 * This is the model class for table "implementasikeperawatan_m".
 *
 * The followings are the available columns in table 'implementasikeperawatan_m':
 * @property integer $implementasikeperawatan_id
 * @property integer $diagnosakeperawatan_id
 * @property integer $rencanakeperawatan_id
 * @property string $implementasikeperawatan_kode
 * @property string $implementasi_nama
 * @property boolean $iskolaborasiimplementasi
 */
class ImplementasikeperawatanM extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ImplementasikeperawatanM the static model class
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
		return 'implementasikeperawatan_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('diagnosakeperawatan_id, implementasikeperawatan_kode, implementasi_nama', 'required'),
			array('diagnosakeperawatan_id, rencanakeperawatan_id', 'numerical', 'integerOnly'=>true),
			array('implementasikeperawatan_kode', 'length', 'max'=>20),
			array('iskolaborasiimplementasi', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('implementasikeperawatan_id, diagnosakeperawatan_id, rencanakeperawatan_id, implementasikeperawatan_kode, implementasi_nama, iskolaborasiimplementasi', 'safe', 'on'=>'search'),
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
                'diagnosakeperawatan'=>array(self::BELONGS_TO,'DiagnosakeperawatanM','diagnosakeperawatan_id'),
                'rencanakeperawatan'=>array(self::BELONGS_TO,'RencanakeperawatanM','rencanakeperawatan_id')
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'implementasikeperawatan_id' => 'ID ',
			'diagnosakeperawatan_id' => 'Diagnosa Keperawatan',
			'rencanakeperawatan_id' => 'Rencana Keperawatan',
			'implementasikeperawatan_kode' => 'Kode',
			'implementasi_nama' => 'Nama Implementasi',
			'iskolaborasiimplementasi' => 'Kolaborasi Implementasi',
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

		$criteria->compare('implementasikeperawatan_id',$this->implementasikeperawatan_id);
		$criteria->compare('diagnosakeperawatan_id',$this->diagnosakeperawatan_id);
		$criteria->compare('rencanakeperawatan_id',$this->rencanakeperawatan_id);
		$criteria->compare('LOWER(implementasikeperawatan_kode)',strtolower($this->implementasikeperawatan_kode),true);
		$criteria->compare('LOWER(implementasi_nama)',strtolower($this->implementasi_nama),true);
		$criteria->compare('iskolaborasiimplementasi',isset($this->iskolaborasiimplementasi)?$this->iskolaborasiimplementasi:true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		$criteria->compare('implementasikeperawatan_id',$this->implementasikeperawatan_id);
		$criteria->compare('diagnosakeperawatan_id',$this->diagnosakeperawatan_id);
		$criteria->compare('rencanakeperawatan_id',$this->rencanakeperawatan_id);
		$criteria->compare('LOWER(implementasikeperawatan_kode)',strtolower($this->implementasikeperawatan_kode),true);
		$criteria->compare('LOWER(implementasi_nama)',strtolower($this->implementasi_nama),true);
		//$criteria->compare('iskolaborasiimplementasi',$this->iskolaborasiimplementasi);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
         public function getDiagnosaKeperawatanItems()
        {
            return DiagnosakeperawatanM::model()->findAll("diagnosa_keperawatan_aktif = TRUE ORDER BY diagnosakeperawatan_kode ASC");
        }
        public function getRencanaKeperawatanItems()
        {
            return RencanakeperawatanM::model()->findAll(array('order'=>'rencana_kode'));
        }
}