<?php

/**
 * This is the model class for table "nilaipoin_m".
 *
 * The followings are the available columns in table 'nilaipoin_m':
 * @property integer $nilaipoin_id
 * @property string $nilaipoin_nama
 * @property string $nilaipoin_namalain
 * @property integer $nilaipoin_jumlah
 * @property boolean $nilaipoin_aktif
 * @property string $nilaipoin_tgl
 * @property string $nilaipoin_tgl_sd
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 *
 * The followings are the available model relations:
 * @property PoinpegdetR[] $poinpegdetRs
 */
class NilaipoinM extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return NilaipoinM the static model class
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
		return 'nilaipoin_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('nilaipoin_nama, nilaipoin_jumlah, nilaipoin_aktif, nilaipoin_tgl, nilaipoin_tgl_sd, create_time, create_loginpemakai_id, create_ruangan', 'required'),
			array('nilaipoin_jumlah, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'numerical', 'integerOnly'=>true),
			array('nilaipoin_nama, nilaipoin_namalain', 'length', 'max'=>100),
			array('update_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('nilaipoin_id, nilaipoin_nama, nilaipoin_namalain, nilaipoin_jumlah, nilaipoin_aktif, nilaipoin_tgl, nilaipoin_tgl_sd, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
			'poinpegdetRs' => array(self::HAS_MANY, 'PoinpegdetR', 'nilaipoin_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'nilaipoin_id' => 'ID',
			'nilaipoin_nama' => 'Nama',
			'nilaipoin_namalain' => 'Nama Lain',
			'nilaipoin_jumlah' => 'Poin',
			'nilaipoin_aktif' => 'Aktif',
			'nilaipoin_tgl' => 'Tanggal',
			'nilaipoin_tgl_sd' => 'Sampai Dengan',
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

		$criteria->compare('nilaipoin_id',$this->nilaipoin_id);
		$criteria->compare('LOWER(nilaipoin_nama)', strtolower($this->nilaipoin_nama),true);
		$criteria->compare('LOWER(nilaipoin_namalain)',strtolower($this->nilaipoin_namalain),true);
		$criteria->compare('nilaipoin_jumlah',$this->nilaipoin_jumlah);
		$criteria->compare('nilaipoin_aktif', isset($this->nilaipoin_aktif)?$this->nilaipoin_aktif:true);
		$criteria->compare('nilaipoin_tgl',$this->nilaipoin_tgl,true);
		$criteria->compare('nilaipoin_tgl_sd',$this->nilaipoin_tgl_sd,true);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('create_loginpemakai_id',$this->create_loginpemakai_id);
		$criteria->compare('update_loginpemakai_id',$this->update_loginpemakai_id);
		$criteria->compare('create_ruangan',$this->create_ruangan);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        /**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function searchPrint()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('nilaipoin_id',$this->nilaipoin_id);
		$criteria->compare('LOWER(nilaipoin_nama)', strtolower($this->nilaipoin_nama),true);
		$criteria->compare('LOWER(nilaipoin_namalain)',strtolower($this->nilaipoin_namalain),true);
		$criteria->compare('nilaipoin_jumlah',$this->nilaipoin_jumlah);
		$criteria->compare('nilaipoin_aktif', isset($this->nilaipoin_aktif)?$this->nilaipoin_aktif:true);
		$criteria->compare('nilaipoin_tgl',$this->nilaipoin_tgl,true);
		$criteria->compare('nilaipoin_tgl_sd',$this->nilaipoin_tgl_sd,true);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('create_loginpemakai_id',$this->create_loginpemakai_id);
		$criteria->compare('update_loginpemakai_id',$this->update_loginpemakai_id);
		$criteria->compare('create_ruangan',$this->create_ruangan);
                //$criteria->limit = 1;
                        

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                        'pagination'=>false
		));
	}
        
        /**
         * - digunakan untuk menggabungkan data nama dengan jumlah
         * @return type
         */
        public function getNamaDanPoin(){
            return $this->nilaipoin_nama.' - '.$this->nilaipoin_jumlah;
        }
}