<?php

/**
 * This is the model class for table "resumemedis_obat_r".
 *
 * The followings are the available columns in table 'resumemedis_obat_r':
 * @property integer $resumemedis_obat_id
 * @property integer $resumemedis_id
 * @property string $nama_obat
 * @property string $indikasi
 * @property string $dosis
 * @property string $caraminum
 * @property string $waktuminum
 * @property integer $obatalkespasien_id
 * @property double $qty
 */
class ResumemedisObatR extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'resumemedis_obat_r';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('resumemedis_id', 'required'),
			array('resumemedis_id, obatalkespasien_id', 'numerical', 'integerOnly'=>true),
			array('qty', 'numerical'),
			array('nama_obat', 'length', 'max'=>100),
			array('indikasi, dosis, caraminum, waktuminum', 'length', 'max'=>50),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('resumemedis_obat_id, resumemedis_id, nama_obat, indikasi, dosis, caraminum, waktuminum, obatalkespasien_id, qty', 'safe', 'on'=>'search'),
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
			'obatalkes'=>array(self::BELONGS_TO, 'ObatalkesM', 'obatalkes_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'resumemedis_obat_id' => 'Resumemedis Obat',
			'resumemedis_id' => 'Resumemedis',
			'nama_obat' => 'Nama Obat',
			'indikasi' => 'Indikasi',
			'dosis' => 'Dosis',
			'caraminum' => 'Caraminum',
			'waktuminum' => 'Waktuminum',
			'obatalkespasien_id' => 'Obatalkespasien',
			'qty' => 'Qty',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('resumemedis_obat_id',$this->resumemedis_obat_id);
		$criteria->compare('resumemedis_id',$this->resumemedis_id);
		$criteria->compare('nama_obat',$this->nama_obat,true);
		$criteria->compare('indikasi',$this->indikasi,true);
		$criteria->compare('dosis',$this->dosis,true);
		$criteria->compare('caraminum',$this->caraminum,true);
		$criteria->compare('waktuminum',$this->waktuminum,true);
		$criteria->compare('obatalkespasien_id',$this->obatalkespasien_id);
		$criteria->compare('qty',$this->qty);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ResumemedisObatR the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
