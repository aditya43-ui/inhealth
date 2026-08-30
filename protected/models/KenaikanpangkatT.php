<?php

/**
 * This is the model class for table "kenaikanpangkat_t".
 *
 * The followings are the available columns in table 'kenaikanpangkat_t':
 * @property integer $kenaikanpangkat_id
 * @property integer $realisasikenpangkat_id
 * @property integer $usulankenaikangaji_id
 * @property integer $pegawai_id
 * @property string $jabatan
 * @property string $pangkat
 * @property string $keterangan
 * @property string $pimpinannama
 */
class KenaikanpangkatT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return KenaikanpangkatT the static model class
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
		return 'kenaikanpangkat_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pegawai_id, jabatan, pangkat', 'required'),
			array('realisasikenpangkat_id, uskenpangkat_id, pegawai_id', 'numerical', 'integerOnly'=>true),
			array('jabatan, pangkat, pimpinannama', 'length', 'max'=>100),
			array('keterangan', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('kenaikanpangkat_id, realisasikenpangkat_id, uskenpangkat_id, pegawai_id, jabatan, pangkat, keterangan, pimpinannama', 'safe', 'on'=>'search'),
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
                    'usulan'=>array(self::BELONGS_TO,'UskenpangkatR','uskenpangkat_id'),
                    'realisasi'=>array(self::BELONGS_TO, 'RealisasikenpangkatR','realisasikenpangkat_id'),
                    'jabatan'=>array(self::BELONGS_TO,'JabatanM','jabatan'),
                    'pangkat'=>array(self::BELONGS_TO,'PangkatM','pangkat'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'kenaikanpangkat_id' => 'Kenaikanpangkat',
			'realisasikenpangkat_id' => 'Realisasikenaikangaji',
			'uskenpangkat_id' => 'Usulankenaikangaji',
			'pegawai_id' => 'Pegawai',
			'jabatan' => 'Jabatan',
			'pangkat' => 'Pangkat',
			'keterangan' => 'Keterangan',
			'pimpinannama' => 'Pimpinannama',
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

		$criteria->compare('kenaikanpangkat_id',$this->kenaikanpangkat_id);
		$criteria->compare('realisasikenpangkat_id',$this->realisasikenpangkat_id);
		$criteria->compare('uskenpangkat_id',$this->usulankenaikangaji_id);
		$criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->compare('LOWER(jabatan)',strtolower($this->jabatan),true);
		$criteria->compare('LOWER(pangkat)',strtolower($this->pangkat),true);
		$criteria->compare('LOWER(keterangan)',strtolower($this->keterangan),true);
		$criteria->compare('LOWER(pimpinannama)',strtolower($this->pimpinannama),true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		$criteria->compare('kenaikanpangkat_id',$this->kenaikanpangkat_id);
		$criteria->compare('realisasikenpangkat_id',$this->realisasikenpangkat_id);
		$criteria->compare('uskenpangkat_id',$this->usulankenaikangaji_id);
		$criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->compare('LOWER(jabatan)',strtolower($this->jabatan),true);
		$criteria->compare('LOWER(pangkat)',strtolower($this->pangkat),true);
		$criteria->compare('LOWER(keterangan)',strtolower($this->keterangan),true);
		$criteria->compare('LOWER(pimpinannama)',strtolower($this->pimpinannama),true);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
}