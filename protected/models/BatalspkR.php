<?php

/**
 * This is the model class for table "batalspk_r".
 *
 * @author  Andyka <andykaputra@.com>
 * @package application.models
 * 
 * The followings are the available columns in table 'batalspk_r':
 * @property integer $batalspk_id
 * @property integer $persiapanpengadaan_id
 * @property integer $suratperjanjiankerja_id
 * @property integer $infoumumpengadaan_id
 * @property integer $penawaranpenyedia_id
 * @property integer $bapengadaanlangsung_id
 * @property integer $banegosiasi_id
 * @property integer $penetapanpemenang_id
 * @property integer $pengumumanpemenang_id
 * @property integer $penunjukanpenyedia_id
 * @property integer $notadinaspengadaan_id
 *
 * The followings are the available model relations:
 * @property NotadinaspengadaanT $notadinaspengadaan
 * @property PenunjukanpenyediaT $penunjukanpenyedia
 * @property PengumumanpemenangT $pengumumanpemenang
 * @property PenetapanpemenangT $penetapanpemenang
 * @property BanegosiasiT $banegosiasi
 * @property BapengadaanlangsungT $bapengadaanlangsung
 * @property PenawaranpenyediaT $penawaranpenyedia
 * @property InfoumumpengadaanT $infoumumpengadaan
 * @property SuratperjanjiankerjaT $suratperjanjiankerja
 * @property PersiapanpengadaanT $persiapanpengadaan
 */
class BatalspkR extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return BatalspkR the static model class
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
		return 'batalspk_r';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('persiapanpengadaan_id, suratperjanjiankerja_id, infoumumpengadaan_id ', 'required'),
			array('persiapanpengadaan_id, suratperjanjiankerja_id, infoumumpengadaan_id, penawaranpenyedia_id, bapengadaanlangsung_id, banegosiasi_id, penetapanpemenang_id, pengumumanpemenang_id, penunjukanpenyedia_id, notadinaspengadaan_id', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('batalspk_id, persiapanpengadaan_id, suratperjanjiankerja_id, infoumumpengadaan_id, penawaranpenyedia_id, bapengadaanlangsung_id, banegosiasi_id, penetapanpemenang_id, pengumumanpemenang_id, penunjukanpenyedia_id, notadinaspengadaan_id', 'safe', 'on'=>'search'),
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
			'notadinaspengadaan' => array(self::BELONGS_TO, 'NotadinaspengadaanT', 'notadinaspengadaan_id'),
			'penunjukanpenyedia' => array(self::BELONGS_TO, 'PenunjukanpenyediaT', 'penunjukanpenyedia_id'),
			'pengumumanpemenang' => array(self::BELONGS_TO, 'PengumumanpemenangT', 'pengumumanpemenang_id'),
			'penetapanpemenang' => array(self::BELONGS_TO, 'PenetapanpemenangT', 'penetapanpemenang_id'),
			'banegosiasi' => array(self::BELONGS_TO, 'BanegosiasiT', 'banegosiasi_id'),
			'bapengadaanlangsung' => array(self::BELONGS_TO, 'BapengadaanlangsungT', 'bapengadaanlangsung_id'),
			'penawaranpenyedia' => array(self::BELONGS_TO, 'PenawaranpenyediaT', 'penawaranpenyedia_id'),
			'infoumumpengadaan' => array(self::BELONGS_TO, 'InfoumumpengadaanT', 'infoumumpengadaan_id'),
			'suratperjanjiankerja' => array(self::BELONGS_TO, 'SuratperjanjiankerjaT', 'suratperjanjiankerja_id'),
			'persiapanpengadaan' => array(self::BELONGS_TO, 'PersiapanpengadaanT', 'persiapanpengadaan_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'batalspk_id' => 'Batalspk',
			'persiapanpengadaan_id' => 'Persiapanpengadaan',
			'suratperjanjiankerja_id' => 'Suratperjanjiankerja',
			'infoumumpengadaan_id' => 'Infoumumpengadaan',
			'penawaranpenyedia_id' => 'Penawaranpenyedia',
			'bapengadaanlangsung_id' => 'Bapengadaanlangsung',
			'banegosiasi_id' => 'Banegosiasi',
			'penetapanpemenang_id' => 'Penetapanpemenang',
			'pengumumanpemenang_id' => 'Pengumumanpemenang',
			'penunjukanpenyedia_id' => 'Penunjukanpenyedia',
			'notadinaspengadaan_id' => 'Notadinaspengadaan',
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

		$criteria->compare('batalspk_id',$this->batalspk_id);
		$criteria->compare('persiapanpengadaan_id',$this->persiapanpengadaan_id);
		$criteria->compare('suratperjanjiankerja_id',$this->suratperjanjiankerja_id);
		$criteria->compare('infoumumpengadaan_id',$this->infoumumpengadaan_id);
		$criteria->compare('penawaranpenyedia_id',$this->penawaranpenyedia_id);
		$criteria->compare('bapengadaanlangsung_id',$this->bapengadaanlangsung_id);
		$criteria->compare('banegosiasi_id',$this->banegosiasi_id);
		$criteria->compare('penetapanpemenang_id',$this->penetapanpemenang_id);
		$criteria->compare('pengumumanpemenang_id',$this->pengumumanpemenang_id);
		$criteria->compare('penunjukanpenyedia_id',$this->penunjukanpenyedia_id);
		$criteria->compare('notadinaspengadaan_id',$this->notadinaspengadaan_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}