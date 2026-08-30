<?php

/**
 * This is the model class for table "rincian_cetakan".
 *
 * The followings are the available columns in table 'rincian_cetakan':
 * @property integer $rincian_cetakan_id
 * @property integer $pendaftaran_id
 * @property string $jenis_cetakan
 * @property integer $jumlah
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai_id
 * @property string $update_loginpemakai
 * @property string $create_ruangan
 */
class RincianCetakan extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return RincianCetakan the static model class
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
		return 'rincian_cetakan';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
//			array('create_time, create_loginpemakai_id, create_ruangan', 'required'),
			array('pendaftaran_id, jumlah', 'numerical', 'integerOnly'=>true),
			array('jenis_cetakan', 'length', 'max'=>32),
			array('update_time, update_loginpemakai, update_ruangan', 'safe'),
                    
                        array('create_time','default','value'=>date( 'Y-m-d H:i:s'),'on'=>'insert'),
                        array('update_time','default','value'=>date( 'Y-m-d H:i:s'),'setOnEmpty'=>false,'on'=>'update'),
                        array('create_loginpemakai_id','default','value'=>Yii::app()->user->id,'on'=>'insert'),
                        array('update_loginpemakai_id','default','value'=>Yii::app()->user->id,'setOnEmpty'=>false,'on'=>'update'),
                        array('create_ruangan','default','value'=>Yii::app()->user->getState('ruangan_id'),'on'=>'insert'),
                        array('update_ruangan','default','value'=>Yii::app()->user->getState('ruangan_id'),'setOnEmpty'=>false,'on'=>'update'),
                    
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('rincian_cetakan_id, pendaftaran_id, jenis_cetakan, jumlah, create_time, update_time, create_loginpemakai_id, update_loginpemakai, create_ruangan', 'safe', 'on'=>'search'),
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
			'rincian_cetakan_id' => 'Rincian Cetakan',
			'pendaftaran_id' => 'Pendaftaran',
			'jenis_cetakan' => 'Jenis Cetakan',
			'jumlah' => 'Jumlah',
			'create_time' => 'Waktu Create',
			'update_time' => 'Waktu Update',
			'create_loginpemakai_id' => 'Create Login Pemakai',
			'update_loginpemakai' => 'Update Loginpemakai',
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

		$criteria->compare('rincian_cetakan_id',$this->rincian_cetakan_id);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('LOWER(jenis_cetakan)',strtolower($this->jenis_cetakan),true);
		$criteria->compare('jumlah',$this->jumlah);
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
		$criteria->compare('LOWER(create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);
		$criteria->compare('LOWER(update_loginpemakai)',strtolower($this->update_loginpemakai),true);
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
		$criteria->compare('rincian_cetakan_id',$this->rincian_cetakan_id);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('LOWER(jenis_cetakan)',strtolower($this->jenis_cetakan),true);
		$criteria->compare('jumlah',$this->jumlah);
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
		$criteria->compare('LOWER(create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);
		$criteria->compare('LOWER(update_loginpemakai)',strtolower($this->update_loginpemakai),true);
		$criteria->compare('LOWER(create_ruangan)',strtolower($this->create_ruangan),true);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
}