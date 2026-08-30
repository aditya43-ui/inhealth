<?php

/**
 * This is the model class for table "pasienbatalpulang_t".
 *
 * The followings are the available columns in table 'pasienbatalpulang_t':
 * @property integer $pasienbatalpulang_id
 * @property integer $pasienpulang_id
 * @property string $tglpembatalan
 * @property string $alasanpembatalan
 * @property string $namauser_otorisasi
 * @property integer $iduser_otorisasi
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai_id
 * @property string $update_loginpemakai_id
 * @property string $create_ruangan
 */
class PasienbatalpulangT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PasienbatalpulangT the static model class
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
		return 'pasienbatalpulang_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('tglpembatalan, alasanpembatalan', 'required'),
			array('pasienpulang_id, iduser_otorisasi', 'numerical', 'integerOnly'=>true),
			array('namauser_otorisasi', 'length', 'max'=>50),
			array('update_time, update_loginpemakai_id', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
                         array('create_time','default','value'=>date('Y-m-d H:i:s'),'setOnEmpty'=>false,'on'=>'insert'),
                        array('update_time','default','value'=>date('Y-m-d H:i:s'),'setOnEmpty'=>false,'on'=>'update,insert'),
                        array('create_loginpemakai_id','default','value'=>Yii::app()->user->id,'on'=>'insert'),
                        array('update_loginpemakai_id','default','value'=>Yii::app()->user->id,'on'=>'update,insert'),
                        array('create_ruangan','default','value'=>Yii::app()->user->getState('ruangan_id'),'on'=>'insert'),
                    
			array('pasienbatalpulang_id, pasienpulang_id, tglpembatalan, alasanpembatalan, namauser_otorisasi, iduser_otorisasi, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
			'pasienbatalpulang_id' => 'Pasienbatalpulang',
			'pasienpulang_id' => 'Pasienpulang',
			'tglpembatalan' => 'Tanggal Pembatalan',
			'alasanpembatalan' => 'Alasan Pembatalan',
			'namauser_otorisasi' => 'Namauser Otorisasi',
			'iduser_otorisasi' => 'Iduser Otorisasi',
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

		$criteria->compare('pasienbatalpulang_id',$this->pasienbatalpulang_id);
		$criteria->compare('pasienpulang_id',$this->pasienpulang_id);
		$criteria->compare('LOWER(tglpembatalan)',strtolower($this->tglpembatalan),true);
		$criteria->compare('LOWER(alasanpembatalan)',strtolower($this->alasanpembatalan),true);
		$criteria->compare('LOWER(namauser_otorisasi)',strtolower($this->namauser_otorisasi),true);
		$criteria->compare('iduser_otorisasi',$this->iduser_otorisasi);
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
		$criteria->compare('pasienbatalpulang_id',$this->pasienbatalpulang_id);
		$criteria->compare('pasienpulang_id',$this->pasienpulang_id);
		$criteria->compare('LOWER(tglpembatalan)',strtolower($this->tglpembatalan),true);
		$criteria->compare('LOWER(alasanpembatalan)',strtolower($this->alasanpembatalan),true);
		$criteria->compare('LOWER(namauser_otorisasi)',strtolower($this->namauser_otorisasi),true);
		$criteria->compare('iduser_otorisasi',$this->iduser_otorisasi);
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