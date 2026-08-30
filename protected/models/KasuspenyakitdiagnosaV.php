<?php

/**
 * This is the model class for table "kasuspenyakitdiagnosa_v".
 *
 * The followings are the available columns in table 'kasuspenyakitdiagnosa_v':
 * @property integer $tabularlist_id
 * @property string $tabularlist_chapter
 * @property string $tabularlist_title
 * @property string $tabularlist_title2
 * @property integer $dtd_id
 * @property string $dtd_kode
 * @property string $dtd_nama
 * @property integer $dtd_nourut
 * @property integer $klasifikasidiagnosa_id
 * @property string $klasifikasidiagnosa_kode
 * @property string $klasifikasidiagnosa_nama
 * @property integer $diagnosa_id
 * @property string $diagnosa_kode
 * @property string $diagnosa_nama
 * @property string $diagnosa_namalainnya
 * @property integer $diagnosa_nourut
 * @property boolean $diagnosa_imunisasi
 * @property string $diagnosa_katakunci
 * @property integer $jeniskasuspenyakit_id
 * @property string $jeniskasuspenyakit_nama
 * @property string $jeniskasuspenyakit_namalainnya
 * @property integer $jeniskasuspenyakit_urutan
 */
class KasuspenyakitdiagnosaV extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return KasuspenyakitdiagnosaV the static model class
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
		return 'kasuspenyakitdiagnosa_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('tabularlist_id, dtd_id, dtd_nourut, klasifikasidiagnosa_id, diagnosa_id, diagnosa_nourut, jeniskasuspenyakit_id, jeniskasuspenyakit_urutan', 'numerical', 'integerOnly'=>true),
			array('tabularlist_chapter', 'length', 'max'=>50),
			array('dtd_kode, klasifikasidiagnosa_kode, diagnosa_kode', 'length', 'max'=>10),
			array('dtd_nama', 'length', 'max'=>255),
			array('klasifikasidiagnosa_nama', 'length', 'max'=>500),
			array('diagnosa_nama, diagnosa_namalainnya', 'length', 'max'=>200),
			array('diagnosa_katakunci, jeniskasuspenyakit_nama, jeniskasuspenyakit_namalainnya', 'length', 'max'=>100),
			array('tabularlist_title, tabularlist_title2, diagnosa_imunisasi', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('tabularlist_id, tabularlist_chapter, tabularlist_title, tabularlist_title2, dtd_id, dtd_kode, dtd_nama, dtd_nourut, klasifikasidiagnosa_id, klasifikasidiagnosa_kode, klasifikasidiagnosa_nama, diagnosa_id, diagnosa_kode, diagnosa_nama, diagnosa_namalainnya, diagnosa_nourut, diagnosa_imunisasi, diagnosa_katakunci, jeniskasuspenyakit_id, jeniskasuspenyakit_nama, jeniskasuspenyakit_namalainnya, jeniskasuspenyakit_urutan', 'safe', 'on'=>'search'),
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
			'tabularlist_id' => 'Tabularlist',
			'tabularlist_chapter' => 'Tabularlist Chapter',
			'tabularlist_title' => 'Tabularlist Title',
			'tabularlist_title2' => 'Tabularlist Title2',
			'dtd_id' => 'Dtd',
			'dtd_kode' => 'Dtd Kode',
			'dtd_nama' => 'Dtd Nama',
			'dtd_nourut' => 'Dtd Nourut',
			'klasifikasidiagnosa_id' => 'Klasifikasidiagnosa',
			'klasifikasidiagnosa_kode' => 'Klasifikasidiagnosa Kode',
			'klasifikasidiagnosa_nama' => 'Klasifikasidiagnosa Nama',
			'diagnosa_id' => 'Diagnosa',
			'diagnosa_kode' => 'Diagnosa Kode',
			'diagnosa_nama' => 'Diagnosa Nama',
			'diagnosa_namalainnya' => 'Diagnosa Namalainnya',
			'diagnosa_nourut' => 'Diagnosa Nourut',
			'diagnosa_imunisasi' => 'Diagnosa Imunisasi',
			'diagnosa_katakunci' => 'Diagnosa Katakunci',
			'jeniskasuspenyakit_id' => 'Jeniskasuspenyakit',
			'jeniskasuspenyakit_nama' => 'Jeniskasuspenyakit Nama',
			'jeniskasuspenyakit_namalainnya' => 'Jeniskasuspenyakit Namalainnya',
			'jeniskasuspenyakit_urutan' => 'Jeniskasuspenyakit Urutan',
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

		$criteria->compare('tabularlist_id',$this->tabularlist_id);
		$criteria->compare('tabularlist_chapter',$this->tabularlist_chapter,true);
		$criteria->compare('tabularlist_title',$this->tabularlist_title,true);
		$criteria->compare('tabularlist_title2',$this->tabularlist_title2,true);
		$criteria->compare('dtd_id',$this->dtd_id);
		$criteria->compare('dtd_kode',$this->dtd_kode,true);
		$criteria->compare('dtd_nama',$this->dtd_nama,true);
		$criteria->compare('dtd_nourut',$this->dtd_nourut);
		$criteria->compare('klasifikasidiagnosa_id',$this->klasifikasidiagnosa_id);
		$criteria->compare('klasifikasidiagnosa_kode',$this->klasifikasidiagnosa_kode,true);
		$criteria->compare('klasifikasidiagnosa_nama',$this->klasifikasidiagnosa_nama,true);
		$criteria->compare('diagnosa_id',$this->diagnosa_id);
		$criteria->compare('diagnosa_kode',$this->diagnosa_kode,true);
		$criteria->compare('diagnosa_nama',$this->diagnosa_nama,true);
		$criteria->compare('diagnosa_namalainnya',$this->diagnosa_namalainnya,true);
		$criteria->compare('diagnosa_nourut',$this->diagnosa_nourut);
		$criteria->compare('diagnosa_imunisasi',$this->diagnosa_imunisasi);
		$criteria->compare('diagnosa_katakunci',$this->diagnosa_katakunci,true);
		$criteria->compare('jeniskasuspenyakit_id',$this->jeniskasuspenyakit_id);
		$criteria->compare('jeniskasuspenyakit_nama',$this->jeniskasuspenyakit_nama,true);
		$criteria->compare('jeniskasuspenyakit_namalainnya',$this->jeniskasuspenyakit_namalainnya,true);
		$criteria->compare('jeniskasuspenyakit_urutan',$this->jeniskasuspenyakit_urutan);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}