<?php

/**
 * This is the model class for table "edukasi_keteranganevaluasi_m".
 *
 * The followings are the available columns in table 'edukasi_keteranganevaluasi_m':
 * @property integer $edukasi_keteranganevaluasi_id
 * @property string $kodeedukator
 * @property string $keterangan_evaluasi
 * @property integer $urutan
 * @property boolean $is_aktif
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 */
class EdukasiKeteranganevaluasiM extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return EdukasiKeteranganevaluasiM the static model class
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
		return 'edukasi_keteranganevaluasi_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('kodeedukator, keterangan_evaluasi, urutan, create_time, create_loginpemakai_id, create_ruangan', 'required'),
			array('urutan, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'numerical', 'integerOnly'=>true),
			array('kodeedukator, keterangan_evaluasi', 'length', 'max'=>200),
			array('is_aktif, update_time', 'safe'),
            
            array('create_time','default','value'=>date('Y-m-d H:i:s'),'setOnEmpty'=>false,'on'=>'insert'),
			array('update_time','default','value'=>date('Y-m-d H:i:s'),'setOnEmpty'=>false,'on'=>'update,insert'),
			array('create_loginpemakai_id','default','value'=>Yii::app()->user->id,'on'=>'insert'),
			array('update_loginpemakai_id','default','value'=>Yii::app()->user->id,'on'=>'update,insert'),
			array('create_ruangan','default','value'=>Yii::app()->user->getState('ruangan_id'),'on'=>'insert'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('edukasi_keteranganevaluasi_id, kodeedukator, keterangan_evaluasi, urutan, is_aktif, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
			'edukasi_keteranganevaluasi_id' => 'Edukasi Keteranganevaluasi',
			'kodeedukator' => 'Kode Edukator',
			'keterangan_evaluasi' => 'Keterangan Evaluasi',
			'urutan' => 'Urutan',
			'is_aktif' => 'Aktif',
			'create_time' => 'Create Time',
			'update_time' => 'Update Time',
			'create_loginpemakai_id' => 'Create Loginpemakai',
			'update_loginpemakai_id' => 'Update Loginpemakai',
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

		$criteria->compare('edukasi_keteranganevaluasi_id',$this->edukasi_keteranganevaluasi_id);
		$criteria->compare('kodeedukator',$this->kodeedukator,true);
		$criteria->compare('keterangan_evaluasi',$this->keterangan_evaluasi,true);
		$criteria->compare('urutan',$this->urutan);
		$criteria->compare('is_aktif',$this->is_aktif);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('create_loginpemakai_id',$this->create_loginpemakai_id);
		$criteria->compare('update_loginpemakai_id',$this->update_loginpemakai_id);
		$criteria->compare('create_ruangan',$this->create_ruangan);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
    
    public function searchPrint() {
		// $prov = $this->search();
        // $prov->pagination = false;
        
        // return $prov;
		$criteria=new CDbCriteria;

		$criteria->compare('edukasi_keteranganevaluasi_id',$this->edukasi_keteranganevaluasi_id);
		$criteria->compare('kodeedukator',$this->kodeedukator,true);
		$criteria->compare('keterangan_evaluasi',$this->keterangan_evaluasi,true);
		$criteria->compare('urutan',$this->urutan);
		// $criteria->compare('is_aktif',$this->is_aktif);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('create_loginpemakai_id',$this->create_loginpemakai_id);
		$criteria->compare('update_loginpemakai_id',$this->update_loginpemakai_id);
		$criteria->compare('create_ruangan',$this->create_ruangan);
		$criteria->limit=-1;

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			 'pagination'=>false,
	));
    }
}