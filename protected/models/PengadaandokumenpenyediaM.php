<?php

/**
 * This is the model class for table "pengadaandokumenpenyedia_m".
 * @author Aida Rahmawati <aidarahmawati@.com>
 * @package application.models
 * @category model
 * The followings are the available columns in table 'pengadaandokumenpenyedia_m':
 * @property integer $pengadaandokumenpenyedia_id
 * @property integer $penyedia_id
 * @property integer $dokumenpengadaan_id
 * @property string $jenis_dokumen
 * @property string $nomor_dokumen
 * @property string $pengadaandokumenpenyedia_file
 *
 * The followings are the available model relations:
 * @property DokumenpengadaanM $dokumenpengadaan
 * @property PenyediaM $penyedia
 */
class PengadaandokumenpenyediaM extends CActiveRecord
{
        public $temp_file;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PengadaandokumenpenyediaM the static model class
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
		return 'pengadaandokumenpenyedia_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('dokumenpengadaan_id', 'required'),
			array('penyedia_id, dokumenpengadaan_id', 'numerical', 'integerOnly'=>true),
			array('jenis_dokumen', 'length', 'max'=>100),
			array('nomor_dokumen', 'length', 'max'=>50),
			array('pengadaandokumenpenyedia_file', 'length', 'max'=>500),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('pengadaandokumenpenyedia_id, penyedia_id, dokumenpengadaan_id, jenis_dokumen, nomor_dokumen, pengadaandokumenpenyedia_file', 'safe', 'on'=>'search'),
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
			'dokumenpengadaan' => array(self::BELONGS_TO, 'DokumenpengadaanM', 'dokumenpengadaan_id'),
			'penyedia' => array(self::BELONGS_TO, 'PenyediaM', 'penyedia_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'pengadaandokumenpenyedia_id' => 'Pengadaandokumenpenyedia',
			'penyedia_id' => 'Penyedia',
			'dokumenpengadaan_id' => 'Dokumenpengadaan',
			'jenis_dokumen' => 'Jenis Dokumen',
			'nomor_dokumen' => 'Nomor Dokumen',
			'pengadaandokumenpenyedia_file' => 'Pengadaandokumenpenyedia File',
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

		$criteria->compare('pengadaandokumenpenyedia_id',$this->pengadaandokumenpenyedia_id);
		$criteria->compare('penyedia_id',$this->penyedia_id);
		$criteria->compare('dokumenpengadaan_id',$this->dokumenpengadaan_id);
		$criteria->compare('jenis_dokumen',$this->jenis_dokumen,true);
		$criteria->compare('nomor_dokumen',$this->nomor_dokumen,true);
		$criteria->compare('pengadaandokumenpenyedia_file',$this->pengadaandokumenpenyedia_file,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
}