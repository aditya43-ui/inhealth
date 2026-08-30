<?php

/**
 * This is the model class for table "tatatertibpengunjungri_t".
 *
 * The followings are the available columns in table 'tatatertibpengunjungri_t':
 * @property integer $tatatertibpengunjungri_id
 * @property integer $pasienadmisi_id
 * @property integer $pendaftaran_id
 * @property integer $pasien_id
 * @property string $tatatertibpengunjung_judul
 * @property string $tatatertibpengunjung_isi
 * @property string $tgl_menyetujui
 * @property string $pihak_menyetujui
 * @property string $namapihak_menyetujui
 * @property integer $jmlprint
 * @property string $tglawal_print
 * @property integer $petugasawal_print
 * @property string $tglupdate_print
 * @property string $petugasakhir_print
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai
 * @property string $update_loginpemakai
 * @property integer $create_petugaspengisi_id
 * @property integer $create_ruangan_id
 *
 * The followings are the available model relations:
 * @property PasienadmisiT $pasienadmisi
 * @property PendaftaranT $pendaftaran
 * @property PasienM $pasien
 */
class TatatertibpengunjungriT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return TatatertibpengunjungriT the static model class
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
		return 'tatatertibpengunjungri_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pasienadmisi_id, pendaftaran_id, pasien_id, tatatertibpengunjung_judul, tatatertibpengunjung_isi, tgl_menyetujui, create_time, create_loginpemakai', 'required'),
			array('pasienadmisi_id, pendaftaran_id, pasien_id, jmlprint, petugasawal_print, create_petugaspengisi_id, create_ruangan_id', 'numerical', 'integerOnly'=>true),
			array('pihak_menyetujui, namapihak_menyetujui', 'length', 'max'=>50),
			array('create_loginpemakai, update_loginpemakai', 'length', 'max'=>100),
			array('namapasien_menyetujui, petugas_menyetujui', 'length', 'max'=>200),
			array('tglawal_print, tglupdate_print, petugasakhir_print, update_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('tatatertibpengunjungri_id, pasienadmisi_id, pendaftaran_id, pasien_id, tatatertibpengunjung_judul, tatatertibpengunjung_isi, tgl_menyetujui, pihak_menyetujui, namapihak_menyetujui, jmlprint, tglawal_print, petugasawal_print, tglupdate_print, petugasakhir_print, create_time, update_time, create_loginpemakai, update_loginpemakai, create_petugaspengisi_id, create_ruangan_id, namapasien_menyetujui, petugas_menyetujui', 'safe', 'on'=>'search'),
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
			'pasienadmisi' => array(self::BELONGS_TO, 'PasienadmisiT', 'pasienadmisi_id'),
			'pendaftaran' => array(self::BELONGS_TO, 'PendaftaranT', 'pendaftaran_id'),
			'pasien' => array(self::BELONGS_TO, 'PasienM', 'pasien_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'tatatertibpengunjungri_id' => 'Tatatertibpengunjungri',
			'pasienadmisi_id' => 'Pasienadmisi',
			'pendaftaran_id' => 'Pendaftaran',
			'pasien_id' => 'Pasien',
			'tatatertibpengunjung_judul' => 'Tatatertibpengunjung Judul',
			'tatatertibpengunjung_isi' => 'Tatatertibpengunjung Isi',
			'tgl_menyetujui' => 'Tgl Menyetujui',
			'pihak_menyetujui' => 'Pihak Menyetujui',
			'namapihak_menyetujui' => 'Namapihak Menyetujui',
			'jmlprint' => 'Jmlprint',
			'tglawal_print' => 'Tglawal Print',
			'petugasawal_print' => 'Petugasawal Print',
			'tglupdate_print' => 'Tglupdate Print',
			'petugasakhir_print' => 'Petugasakhir Print',
			'create_time' => 'Create Time',
			'update_time' => 'Update Time',
			'create_loginpemakai' => 'Create Loginpemakai',
			'update_loginpemakai' => 'Update Loginpemakai',
			'create_petugaspengisi_id' => 'Create Petugaspengisi',
			'create_ruangan_id' => 'Create Ruangan',
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

		$criteria->compare('tatatertibpengunjungri_id',$this->tatatertibpengunjungri_id);
		$criteria->compare('pasienadmisi_id',$this->pasienadmisi_id);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('tatatertibpengunjung_judul',$this->tatatertibpengunjung_judul,true);
		$criteria->compare('tatatertibpengunjung_isi',$this->tatatertibpengunjung_isi,true);
		$criteria->compare('tgl_menyetujui',$this->tgl_menyetujui,true);
		$criteria->compare('pihak_menyetujui',$this->pihak_menyetujui,true);
		$criteria->compare('namapihak_menyetujui',$this->namapihak_menyetujui,true);
		$criteria->compare('jmlprint',$this->jmlprint);
		$criteria->compare('tglawal_print',$this->tglawal_print,true);
		$criteria->compare('petugasawal_print',$this->petugasawal_print);
		$criteria->compare('tglupdate_print',$this->tglupdate_print,true);
		$criteria->compare('petugasakhir_print',$this->petugasakhir_print,true);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('create_loginpemakai',$this->create_loginpemakai,true);
		$criteria->compare('update_loginpemakai',$this->update_loginpemakai,true);
		$criteria->compare('create_petugaspengisi_id',$this->create_petugaspengisi_id);
		$criteria->compare('create_ruangan_id',$this->create_ruangan_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
