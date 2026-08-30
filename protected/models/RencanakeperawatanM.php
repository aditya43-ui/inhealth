<?php

/**
 * This is the model class for table "rencanakeperawatan_m".
 *
 * The followings are the available columns in table 'rencanakeperawatan_m':
 * @property integer $rencanakeperawatan_id
 * @property integer $diagnosakeperawatan_id
 * @property string $rencana_kode
 * @property string $rencana_intervensi
 * @property string $rencana_rasionalisasi
 * @property boolean $iskolaborasiintervensi
 */
class RencanakeperawatanM extends CActiveRecord
{
        public $diagnosakeperawatan_kode;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return RencanakeperawatanM the static model class
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
		return 'rencanakeperawatan_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('diagnosakeperawatan_id, rencana_kode, rencana_intervensi', 'required'),
			array('diagnosakeperawatan_id', 'numerical', 'integerOnly'=>true),
			array('rencana_kode', 'length', 'max'=>20),
			array('rencana_rasionalisasi, iskolaborasiintervensi', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('diagnosakeperawatan_kode, rencanakeperawatan_id, diagnosakeperawatan_id, rencana_kode, rencana_intervensi, rencana_rasionalisasi, iskolaborasiintervensi', 'safe', 'on'=>'search'),
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
			'diagnosakeperawatan'=>array(self::BELONGS_TO,'DiagnosakeperawatanM','diagnosakeperawatan_id')
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'rencanakeperawatan_id' => 'ID',
			'diagnosakeperawatan_id' => 'Diagnosa Keperawatan',
			'rencana_kode' => 'Rencana Kode',
			'rencana_intervensi' => 'Rencana Intervensi',
			'rencana_rasionalisasi' => 'Rencana Rasionalisasi',
			'iskolaborasiintervensi' => 'Kolaborasi Intervensi',
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

		$criteria->compare('rencanakeperawatan_id',$this->rencanakeperawatan_id);
		$criteria->compare('diagnosakeperawatan_id',$this->diagnosakeperawatan_id);
                $criteria->compare('LOWER(rencana_kode)',strtolower($this->rencana_kode),true);
		$criteria->compare('LOWER(rencana_intervensi)',strtolower($this->rencana_intervensi),true);
		$criteria->compare('LOWER(rencana_rasionalisasi)',strtolower($this->rencana_rasionalisasi),true);
		$criteria->compare('iskolaborasiintervensi',isset($this->iskolaborasiintervensi)?$this->iskolaborasiintervensi:true);
                // $criteria->with=array('diagnosakeperawatan');

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		$criteria->compare('rencanakeperawatan_id',$this->rencanakeperawatan_id);
		$criteria->compare('diagnosakeperawatan_id',$this->diagnosakeperawatan_id);
		$criteria->compare('LOWER(rencana_kode)',strtolower($this->rencana_kode),true);
		$criteria->compare('LOWER(rencana_intervensi)',strtolower($this->rencana_intervensi),true);
		$criteria->compare('LOWER(rencana_rasionalisasi)',strtolower($this->rencana_rasionalisasi),true);
		//$criteria->compare('iskolaborasiintervensi',$this->iskolaborasiintervensi);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
        public function getDiagnosaKeperawatanItems()
        {
            return DiagnosakeperawatanM::model()->findAll('diagnosa_keperawatan_aktif=TRUE ORDER BY diagnosakeperawatan_kode');
        }
}