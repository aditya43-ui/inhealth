<?php

/**
 * This is the model class for table "edukasitransfusiitem_m".
 *
 * The followings are the available columns in table 'edukasitransfusiitem_m':
 * @property string $edukasitransfusiitem_id
 * @property string $edukasitransfusiitem_nama
 * @property integer $edukasitransfusiitem_urutan
 * @property string $edukasitransfusiitem_deskripsi
 * @property boolean $edukasitransfusiitem_aktif
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 *
 * The followings are the available model relations:
 * @property LoginpemakaiK $createLoginpemakai
 * @property LoginpemakaiK $updateLoginpemakai
 * @property LoginpemakaiK $createRuangan
 */
class EdukasitransfusiitemM extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return EdukasitransfusiitemM the static model class
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
		return 'edukasitransfusiitem_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('create_time', 'required'),
			array('edukasitransfusiitem_urutan, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'numerical', 'integerOnly'=>true),
			array('edukasitransfusiitem_nama, edukasitransfusiitem_deskripsi, edukasitransfusiitem_aktif, update_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
            array('create_time','default','value'=>date('Y-m-d H:i:s'),'setOnEmpty'=>false,'on'=>'insert'),
			array('update_time','default','value'=>date('Y-m-d H:i:s'),'setOnEmpty'=>false,'on'=>'update,insert'),
			array('create_loginpemakai_id','default','value'=>Yii::app()->user->id,'on'=>'insert'),
			array('update_loginpemakai_id','default','value'=>Yii::app()->user->id,'on'=>'update,insert'),
			array('create_ruangan','default','value'=>Yii::app()->user->getState('ruangan_id'),'on'=>'insert'),
			array('edukasitransfusiitem_id, edukasitransfusiitem_nama, edukasitransfusiitem_urutan, edukasitransfusiitem_deskripsi, edukasitransfusiitem_aktif, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
			'createLoginpemakai' => array(self::BELONGS_TO, 'LoginpemakaiK', 'create_loginpemakai_id'),
			'updateLoginpemakai' => array(self::BELONGS_TO, 'LoginpemakaiK', 'update_loginpemakai_id'),
			'createRuangan' => array(self::BELONGS_TO, 'LoginpemakaiK', 'create_ruangan'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'edukasitransfusiitem_id' => 'ID',
			'edukasitransfusiitem_nama' => 'Nama',
			'edukasitransfusiitem_urutan' => 'Urutan',
			'edukasitransfusiitem_deskripsi' => 'Deskripsi',
			'edukasitransfusiitem_aktif' => 'Aktif',
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

		$criteria->compare('edukasitransfusiitem_id',$this->edukasitransfusiitem_id,true);
		$criteria->compare('edukasitransfusiitem_nama',$this->edukasitransfusiitem_nama,true);
		$criteria->compare('edukasitransfusiitem_urutan',$this->edukasitransfusiitem_urutan);
		$criteria->compare('edukasitransfusiitem_deskripsi',$this->edukasitransfusiitem_deskripsi,true);
		$criteria->compare('edukasitransfusiitem_aktif',$this->edukasitransfusiitem_aktif);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('create_loginpemakai_id',$this->create_loginpemakai_id);
		$criteria->compare('update_loginpemakai_id',$this->update_loginpemakai_id);
		$criteria->compare('create_ruangan',$this->create_ruangan);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        public function searchPrint()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('edukasitransfusiitem_id',$this->edukasitransfusiitem_id,true);
		$criteria->compare('edukasitransfusiitem_nama',$this->edukasitransfusiitem_nama,true);
		$criteria->compare('edukasitransfusiitem_urutan',$this->edukasitransfusiitem_urutan);
		$criteria->compare('edukasitransfusiitem_deskripsi',$this->edukasitransfusiitem_deskripsi,true);
		$criteria->compare('edukasitransfusiitem_aktif',$this->edukasitransfusiitem_aktif);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('create_loginpemakai_id',$this->create_loginpemakai_id);
		$criteria->compare('update_loginpemakai_id',$this->update_loginpemakai_id);
		$criteria->compare('create_ruangan',$this->create_ruangan);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                        'pagination'=>false
		));
	}
}