<?php

/**
 * This is the model class for table "rekonobatadmisidet_t".
 *
 * The followings are the available columns in table 'rekonobatadmisidet_t':
 * @property integer $rekonobatadmisidet_id
 * @property integer $rekonobatadmisi_id
 * @property string $nama_obat
 * @property string $dosis
 * @property string $frekuensi
 * @property string $cara_pemberian
 * @property string $waktu_pemberian
 * @property string $jumlah_obat
 * @property string $tindaklanjut
 * @property string $keterangan
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai
 * @property string $update_loginpemakai
 * @property integer $create_ruangan
 *
 * The followings are the available model relations:
 * @property RekonobatadmisiT $rekonobatadmisi
 */
class RekonobatadmisidetT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return RekonobatadmisidetT the static model class
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
		return 'rekonobatadmisidet_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('rekonobatadmisi_id, create_time, create_loginpemakai', 'required'),
			array('rekonobatadmisi_id, create_ruangan', 'numerical', 'integerOnly'=>true),
			array('nama_obat, dosis, frekuensi, cara_pemberian, jumlah_obat, create_loginpemakai, update_loginpemakai', 'length', 'max'=>100),
			array('tindaklanjut', 'length', 'max'=>50),
			array('keterangan, update_time, waktu_pemberian', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('rekonobatadmisidet_id, rekonobatadmisi_id, nama_obat, dosis, frekuensi, cara_pemberian, waktu_pemberian, jumlah_obat, tindaklanjut, keterangan, create_time, update_time, create_loginpemakai, update_loginpemakai, create_ruangan', 'safe', 'on'=>'search'),
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
			'rekonobatadmisi' => array(self::BELONGS_TO, 'RekonobatadmisiT', 'rekonobatadmisi_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'rekonobatadmisidet_id' => 'Rekonobatadmisidet',
			'rekonobatadmisi_id' => 'Rekonobatadmisi',
			'nama_obat' => 'Nama Obat',
			'dosis' => 'Dosis',
			'frekuensi' => 'Frekuensi',
			'cara_pemberian' => 'Cara Pemberian',
			'waktu_pemberian' => 'Waktu Pemberian',
			'jumlah_obat' => 'Jumlah Obat',
			'tindaklanjut' => 'Tindaklanjut',
			'keterangan' => 'Keterangan',
			'create_time' => 'Create Time',
			'update_time' => 'Update Time',
			'create_loginpemakai' => 'Create Loginpemakai',
			'update_loginpemakai' => 'Update Loginpemakai',
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

		$criteria->compare('rekonobatadmisidet_id',$this->rekonobatadmisidet_id);
		$criteria->compare('rekonobatadmisi_id',$this->rekonobatadmisi_id);
		$criteria->compare('nama_obat',$this->nama_obat,true);
		$criteria->compare('dosis',$this->dosis,true);
		$criteria->compare('frekuensi',$this->frekuensi,true);
		$criteria->compare('cara_pemberian',$this->cara_pemberian,true);
		$criteria->compare('waktu_pemberian',$this->waktu_pemberian,true);
		$criteria->compare('jumlah_obat',$this->jumlah_obat,true);
		$criteria->compare('tindaklanjut',$this->tindaklanjut,true);
		$criteria->compare('keterangan',$this->keterangan,true);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('create_loginpemakai',$this->create_loginpemakai,true);
		$criteria->compare('update_loginpemakai',$this->update_loginpemakai,true);
		$criteria->compare('create_ruangan',$this->create_ruangan);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
