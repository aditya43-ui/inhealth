<?php

/**
 * This is the model class for table "rl3_13_penulisandanpelayananresep_v".
 *
 * The followings are the available columns in table 'rl3_13_penulisandanpelayananresep_v':
 * @property double $tahun
 * @property integer $profilrs_id
 * @property string $nokode_rumahsakit
 * @property string $nama_rumahsakit
 * @property string $obatalkes_kategori
 * @property double $rawatjalan
 * @property double $igd
 * @property double $rawatinap
 */
class Rl313PenulisandanpelayananresepV extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Rl313PenulisandanpelayananresepV the static model class
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
		return 'rl3_13_penulisandanpelayananresep_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('profilrs_id', 'numerical', 'integerOnly'=>true),
			array('tahun, rawatjalan, igd, rawatinap', 'numerical'),
			array('nokode_rumahsakit', 'length', 'max'=>10),
			array('nama_rumahsakit', 'length', 'max'=>100),
			array('obatalkes_kategori', 'length', 'max'=>50),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('tahun, profilrs_id, nokode_rumahsakit, nama_rumahsakit, obatalkes_kategori, rawatjalan, igd, rawatinap', 'safe', 'on'=>'search'),
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
			'tahun' => 'Tahun',
			'profilrs_id' => 'Profilrs',
			'nokode_rumahsakit' => 'Nokode Rumahsakit',
			'nama_rumahsakit' => 'Nama Rumahsakit',
			'obatalkes_kategori' => 'Obatalkes Kategori',
			'rawatjalan' => 'Rawatjalan',
			'igd' => 'Igd',
			'rawatinap' => 'Rawatinap',
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

		$criteria->compare('tahun',$this->tahun);
		$criteria->compare('profilrs_id',$this->profilrs_id);
		$criteria->compare('nokode_rumahsakit',$this->nokode_rumahsakit,true);
		$criteria->compare('nama_rumahsakit',$this->nama_rumahsakit,true);
		$criteria->compare('obatalkes_kategori',$this->obatalkes_kategori,true);
		$criteria->compare('rawatjalan',$this->rawatjalan);
		$criteria->compare('igd',$this->igd);
		$criteria->compare('rawatinap',$this->rawatinap);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}