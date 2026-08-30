<?php

/**
 * This is the model class for table "rekonsiliasiobat_t".
 *
 * The followings are the available columns in table 'rekonsiliasiobat_t':
 * @property integer $rekonsiliasiobat_id
 * @property integer $pendaftaran_id
 * @property integer $pasien_id
 * @property boolean $isalergiobat
 * @property string $namaobat
 * @property string $tgl_pengisiandokter
 * @property integer $dokter_pengisi
 * @property boolean $obatdiapakai
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai
 * @property string $update_loginpemakai
 * @property integer $create_ruangan
 *
 * The followings are the available model relations:
 * @property PendaftaranT $pendaftaran
 * @property PasienM $pasien
 * @property PegawaiM $dokterPengisi
 * @property RekonsiliasiobatdetT[] $rekonsiliasiobatdetTs
 */
class RekonsiliasiobatT extends CActiveRecord
{
	public $dokter_pengisi_nama, $tgl_pengisianapoteker, $apoteker_pengisi, $apoteker_pengisi_nama;

	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return RekonsiliasiobatT the static model class
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
		return 'rekonsiliasiobat_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pendaftaran_id, pasien_id, isalergiobat, tgl_pengisiandokter, dokter_pengisi, obatdiapakai', 'required'),
			array('pendaftaran_id, pasien_id, dokter_pengisi, create_ruangan', 'numerical', 'integerOnly'=>true),
			array('create_loginpemakai, update_loginpemakai', 'length', 'max'=>100),
			array('namaobat, create_time, update_time', 'safe'),


			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('rekonsiliasiobat_id, pendaftaran_id, pasien_id, isalergiobat, namaobat, tgl_pengisiandokter, dokter_pengisi, obatdiapakai, create_time, update_time, create_loginpemakai, update_loginpemakai, create_ruangan', 'safe', 'on'=>'search'),
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
			'pendaftaran' => array(self::BELONGS_TO, 'PendaftaranT', 'pendaftaran_id'),
			'pasien' => array(self::BELONGS_TO, 'PasienM', 'pasien_id'),
			'dokterPengisi' => array(self::BELONGS_TO, 'PegawaiM', 'dokter_pengisi'),
			'rekonsiliasiobatdetTs' => array(self::HAS_MANY, 'RekonsiliasiobatdetT', 'rekonsiliasiobat_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'rekonsiliasiobat_id' => 'Rekonsiliasiobat',
			'pendaftaran_id' => 'Pendaftaran',
			'pasien_id' => 'Pasien',
			'isalergiobat' => 'Isalergiobat',
			'namaobat' => 'Nama Obat',
			'tgl_pengisiandokter' => 'Tanggal Pengisian',
			'dokter_pengisi' => 'Dokter Pengisi',
			'obatdiapakai' => 'Obatdiapakai',
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

		$criteria->compare('rekonsiliasiobat_id',$this->rekonsiliasiobat_id);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('isalergiobat',$this->isalergiobat);
		$criteria->compare('namaobat',$this->namaobat,true);
		$criteria->compare('tgl_pengisiandokter',$this->tgl_pengisiandokter,true);
		$criteria->compare('dokter_pengisi',$this->dokter_pengisi);
		$criteria->compare('obatdiapakai',$this->obatdiapakai);
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
