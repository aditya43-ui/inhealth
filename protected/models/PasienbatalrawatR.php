<?php

/**
 * This is the model class for table "pasienbatalrawat_r".
 *
 * The followings are the available columns in table 'pasienbatalrawat_r':
 * @property integer $pasienbatalrawat_id
 * @property integer $pasienadmisi_id
 * @property string $tglbatalrawat
 * @property string $alasanpembatalan
 * @property string $keteranganpembatalan
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai_id
 * @property string $update_loginpemakai_id
 * @property string $create_ruangan
 */
class PasienbatalrawatR extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PasienbatalrawatR the static model class
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
		return 'pasienbatalrawat_r';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('tglbatalrawat, alasanpembatalan, create_time, create_loginpemakai_id, create_ruangan', 'required'),
			array('pasienadmisi_id', 'numerical', 'integerOnly'=>true),
			array('alasanpembatalan', 'length', 'max'=>200),
			array('keteranganpembatalan, update_time, update_loginpemakai_id', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('pasienbatalrawat_id, pasienadmisi_id, tglbatalrawat, alasanpembatalan, keteranganpembatalan, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
			'pasienbatalrawat_id' => 'Pasienbatalrawat',
			'pasienadmisi_id' => 'Pasienadmisi',
			'tglbatalrawat' => 'Tanggal Pembatalan',
			'alasanpembatalan' => 'Alasan Pembatalan',
			'keteranganpembatalan' => 'Keterangan',
			'create_time' => 'Waktu Create',
			'update_time' => 'Waktu Update',
			'create_loginpemakai_id' => 'Create Login Pemakai',
			'update_loginpemakai_id' => 'Update Login Pemakai',
			'create_ruangan' => 'Create Ruangan',
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

		$criteria->compare('pasienbatalrawat_id',$this->pasienbatalrawat_id);
		$criteria->compare('pasienadmisi_id',$this->pasienadmisi_id);
		$criteria->compare('LOWER(tglbatalrawat)',strtolower($this->tglbatalrawat),true);
		$criteria->compare('LOWER(alasanpembatalan)',strtolower($this->alasanpembatalan),true);
		$criteria->compare('LOWER(keteranganpembatalan)',strtolower($this->keteranganpembatalan),true);
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
		$criteria->compare('LOWER(create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);
		$criteria->compare('LOWER(update_loginpemakai_id)',strtolower($this->update_loginpemakai_id),true);
		$criteria->compare('LOWER(create_ruangan)',strtolower($this->create_ruangan),true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		$criteria->compare('pasienbatalrawat_id',$this->pasienbatalrawat_id);
		$criteria->compare('pasienadmisi_id',$this->pasienadmisi_id);
		$criteria->compare('LOWER(tglbatalrawat)',strtolower($this->tglbatalrawat),true);
		$criteria->compare('LOWER(alasanpembatalan)',strtolower($this->alasanpembatalan),true);
		$criteria->compare('LOWER(keteranganpembatalan)',strtolower($this->keteranganpembatalan),true);
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
		$criteria->compare('LOWER(create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);
		$criteria->compare('LOWER(update_loginpemakai_id)',strtolower($this->update_loginpemakai_id),true);
		$criteria->compare('LOWER(create_ruangan)',strtolower($this->create_ruangan),true);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
}