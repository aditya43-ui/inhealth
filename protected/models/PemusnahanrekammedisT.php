<?php

/**
 * @package application.models
 * 
 * This is the model class for table "pemusnahanrekammedis_t".
 *
 * The followings are the available columns in table 'pemusnahanrekammedis_t':
 * @property integer $pemusnahanrekammedis_id
 * @property string $nopemusnahanrekammedis
 * @property string $tglpemusnahanrekammedis
 * @property integer $pegawai_id
 * @property integer $penanggungjawab_id
 * @property string $keterangan
 * 
 * @author   Andyka <andykaputra@.com>
 * @package  application.models
 * @category model
 */
class PemusnahanrekammedisT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PemusnahanrekammedisT the static model class
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
		return 'pemusnahanrekammedis_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pegawai_id, penanggungjawab_id', 'numerical', 'integerOnly'=>true),
			array('nopemusnahanrekammedis', 'length', 'max'=>20),
			array('tglpemusnahanrekammedis, keterangan', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('pemusnahanrekammedis_id, nopemusnahanrekammedis, tglpemusnahanrekammedis, pegawai_id, penanggungjawab_id, keterangan', 'safe', 'on'=>'search'),
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
			'pemusnahanrekammedis_id' => 'Pemusnahan Rekam Medis',
			'nopemusnahanrekammedis' => 'No. Pemusnahan Inaktif',
			'tglpemusnahanrekammedis' => 'Tanggal Pemusnahan',
			'pegawai_id' => 'Petugas Pemusnahan',
			'penanggungjawab_id' => 'Petugas Mengetahui',
			'keterangan' => 'Keterangan',
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

		$criteria->compare('pemusnahanrekammedis_id',$this->pemusnahanrekammedis_id);
		$criteria->compare('nopemusnahanrekammedis',$this->nopemusnahanrekammedis,true);
		$criteria->compare('tglpemusnahanrekammedis',$this->tglpemusnahanrekammedis,true);
		$criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->compare('penanggungjawab_id',$this->penanggungjawab_id);
		$criteria->compare('keterangan',$this->keterangan,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}