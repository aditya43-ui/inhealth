<?php

/**
 * This is the model class for table "kelompokkomponentarif_m".
 *
 * The followings are the available columns in table 'kelompokkomponentarif_m':
 * @property integer $kelompokkomponentarif_id
 * @property string $kelompokkomponentarif_nama
 * @property string $kelompokkomponentarif_namalain
 * @property boolean $kelompokkomponentarif_aktif
 */
class KelompokkomponentarifM extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return KelompokkomponentarifM the static model class
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
		return 'kelompokkomponentarif_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('kelompokkomponentarif_nama', 'required'),
			array('kelompokkomponentarif_nama, kelompokkomponentarif_namalain', 'length', 'max'=>200),
			array('kelompokkomponentarif_aktif', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('kelompokkomponentarif_id, kelompokkomponentarif_nama, kelompokkomponentarif_namalain, kelompokkomponentarif_aktif', 'safe', 'on'=>'search'),
		
                                            
                        array('create_time','default','value'=>date('Y-m-d H:i:s'),'setOnEmpty'=>false,'on'=>'insert'),
                        array('update_time','default','value'=>date('Y-m-d H:i:s'),'setOnEmpty'=>false,'on'=>'update,insert'),
                        array('create_loginpemakai_id','default','value'=>Yii::app()->user->id,'on'=>'insert'),
                        array('update_loginpemakai_id','default','value'=>Yii::app()->user->id,'on'=>'update,insert'),
                        array('create_ruangan','default','value'=>Yii::app()->user->getState('ruangan_id'),'on'=>'insert'),
                        
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
			'kelompokkomponentarif_id' => 'Kelompok Komponen Tarif',
			'kelompokkomponentarif_nama' => 'Nama Kelompok Komponen Tarif',
			'kelompokkomponentarif_namalain' => 'Nama Lain Kelompok Komponen Tarif',
			'kelompokkomponentarif_aktif' => 'Aktif',
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

		$criteria->compare('kelompokkomponentarif_id',$this->kelompokkomponentarif_id);
		$criteria->compare('lower(kelompokkomponentarif_nama)',strtolower($this->kelompokkomponentarif_nama),true);
		$criteria->compare('lower(kelompokkomponentarif_namalain)',strtolower($this->kelompokkomponentarif_namalain),true);
		$criteria->compare('kelompokkomponentarif_aktif',$this->kelompokkomponentarif_aktif);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}