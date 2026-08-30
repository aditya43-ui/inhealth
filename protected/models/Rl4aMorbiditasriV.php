<?php

/**
 * This is the model class for table "rl4a_morbiditasri_v".
 *
 * The followings are the available columns in table 'rl4a_morbiditasri_v':
 * @property integer $pasien_id
 * @property integer $pendaftaran_id
 * @property string $tglmorbiditas
 * @property string $kasusdiagnosa
 * @property integer $diagnosa_id
 * @property string $diagnosa_kode
 * @property string $diagnosa_nama
 * @property string $diagnosa_namalainnya
 * @property integer $diagnosa_nourut
 * @property integer $golonganumur_id
 * @property string $golonganumur_namalainnya
 * @property string $jmlgolumur
 * @property string $jeniskelamin
 * @property string $jmljeniskelamin
 * @property integer $instalasi_id
 * @property string $jmlpsnhidupmeninggal
 */
class Rl4aMorbiditasriV extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Rl4aMorbiditasriV the static model class
	 */
        public $jmlpsn;
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'rl4a_morbiditasri_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pasien_id, pendaftaran_id, diagnosa_id, diagnosa_nourut, golonganumur_id, instalasi_id', 'numerical', 'integerOnly'=>true),
			array('kasusdiagnosa, jeniskelamin', 'length', 'max'=>20),
			array('diagnosa_kode', 'length', 'max'=>10),
			array('diagnosa_nama, diagnosa_namalainnya', 'length', 'max'=>200),
			array('golonganumur_namalainnya', 'length', 'max'=>25),
			array('tglmorbiditas, jmlgolumur, jmljeniskelamin, jmlpsnhidupmeninggal', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('pasien_id, pendaftaran_id, tglmorbiditas, kasusdiagnosa, diagnosa_id, diagnosa_kode, diagnosa_nama, diagnosa_namalainnya, diagnosa_nourut, golonganumur_id, golonganumur_namalainnya, jmlgolumur, jeniskelamin, jmljeniskelamin, instalasi_id, jmlpsnhidupmeninggal', 'safe', 'on'=>'search'),
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
			'pasien_id' => 'Pasien',
			'pendaftaran_id' => 'Pendaftaran',
			'tglmorbiditas' => 'Tglmorbiditas',
			'kasusdiagnosa' => 'Kasusdiagnosa',
			'diagnosa_id' => 'Diagnosa',
			'diagnosa_kode' => 'Diagnosa Kode',
			'diagnosa_nama' => 'Diagnosa Nama',
			'diagnosa_namalainnya' => 'Diagnosa Namalainnya',
			'diagnosa_nourut' => 'Diagnosa Nourut',
			'golonganumur_id' => 'Golonganumur',
			'golonganumur_namalainnya' => 'Golonganumur Namalainnya',
			'jmlgolumur' => 'Jmlgolumur',
			'jeniskelamin' => 'Jenis Kelamin',
			'jmljeniskelamin' => 'Jmljeniskelamin',
			'instalasi_id' => 'Instalasi',
			'jmlpsnhidupmeninggal' => 'Jmlpsnhidupmeninggal',
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

		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('tglmorbiditas',$this->tglmorbiditas,true);
		$criteria->compare('kasusdiagnosa',$this->kasusdiagnosa,true);
		$criteria->compare('diagnosa_id',$this->diagnosa_id);
		$criteria->compare('diagnosa_kode',$this->diagnosa_kode,true);
		$criteria->compare('diagnosa_nama',$this->diagnosa_nama,true);
		$criteria->compare('diagnosa_namalainnya',$this->diagnosa_namalainnya,true);
		$criteria->compare('diagnosa_nourut',$this->diagnosa_nourut);
		$criteria->compare('golonganumur_id',$this->golonganumur_id);
		$criteria->compare('golonganumur_namalainnya',$this->golonganumur_namalainnya,true);
		$criteria->compare('jmlgolumur',$this->jmlgolumur,true);
		$criteria->compare('jeniskelamin',$this->jeniskelamin,true);
		$criteria->compare('jmljeniskelamin',$this->jmljeniskelamin,true);
		$criteria->compare('instalasi_id',$this->instalasi_id);
		$criteria->compare('jmlpsnhidupmeninggal',$this->jmlpsnhidupmeninggal,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}