<?php

/**
 * This is the model class for table "observasipasienri_t".
 *
 * The followings are the available columns in table 'observasipasienri_t':
 * @property integer $observasipasienri_id
 * @property integer $pendaftaran_id
 * @property integer $pasienadmisi_id
 * @property integer $pasien_id
 * @property boolean $isobservasi_anakbayi
 * @property string $tgl_observasi
 * @property string $jam_observasi
 * @property integer $petugas_id
 * @property integer $td_sistolic
 * @property integer $td_diastolic
 * @property integer $detaknadi
 * @property double $suhutubuh
 * @property integer $pernapasan
 * @property string $cairan_jenis
 * @property integer $jml_tetesan
 * @property string $kolf
 * @property string $minum_sonde
 * @property string $muntah
 * @property string $bak
 * @property string $bab
 * @property string $catatan
 * @property double $spo2_nilai
 * @property string $jml_urine
 * @property integer $bunyijantung_anak
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai
 * @property string $update_loginpemakai
 * @property integer $create_petugaspengisi_id
 * @property integer $create_ruangan_id
 *
 * The followings are the available model relations:
 * @property PendaftaranT $pendaftaran
 * @property PasienadmisiT $pasienadmisi
 * @property PasienM $pasien
 */
class ObservasipasienriT extends CActiveRecord
{
    public $tgl_observasi_dewasa, $jam_observasi_dewasa;
    
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ObservasipasienriT the static model class
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
		return 'observasipasienri_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pendaftaran_id, pasien_id, isobservasi_anakbayi, create_time, create_loginpemakai, create_petugaspengisi_id, create_ruangan_id', 'required'),
			array('pendaftaran_id, pasienadmisi_id, pasien_id, petugas_id, td_sistolic, td_diastolic, detaknadi, pernapasan, jml_tetesan, bunyijantung_anak, create_petugaspengisi_id, create_ruangan_id', 'numerical', 'integerOnly'=>true),
			array('suhutubuh, spo2_nilai', 'numerical'),
			array('cairan_jenis', 'length', 'max'=>300),
			array('kolf', 'length', 'max'=>50),
			array('minum_sonde, muntah, bak, bab, jml_urine, create_loginpemakai, update_loginpemakai', 'length', 'max'=>100),
			array('tgl_observasi, jam_observasi, catatan, update_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('observasipasienri_id, pendaftaran_id, pasienadmisi_id, pasien_id, isobservasi_anakbayi, tgl_observasi, jam_observasi, petugas_id, td_sistolic, td_diastolic, detaknadi, suhutubuh, pernapasan, cairan_jenis, jml_tetesan, kolf, minum_sonde, muntah, bak, bab, catatan, spo2_nilai, jml_urine, bunyijantung_anak, create_time, update_time, create_loginpemakai, update_loginpemakai, create_petugaspengisi_id, create_ruangan_id', 'safe', 'on'=>'search'),
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
			'pasienadmisi' => array(self::BELONGS_TO, 'PasienadmisiT', 'pasienadmisi_id'),
			'pasien' => array(self::BELONGS_TO, 'PasienM', 'pasien_id'),
                        'petugas' => array(self::BELONGS_TO, 'PegawaiM', 'petugas_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'observasipasienri_id' => 'Observasipasienri',
			'pendaftaran_id' => 'Pendaftaran',
			'pasienadmisi_id' => 'Pasienadmisi',
			'pasien_id' => 'Pasien',
			'isobservasi_anakbayi' => 'Isobservasi Anakbayi',
			'tgl_observasi' => 'Tgl Observasi',
			'jam_observasi' => 'Jam Observasi',
			'petugas_id' => 'Petugas',
			'td_sistolic' => 'Td Sistolic',
			'td_diastolic' => 'Td Diastolic',
			'detaknadi' => 'Detaknadi',
			'suhutubuh' => 'Suhutubuh',
			'pernapasan' => 'Pernapasan',
			'cairan_jenis' => 'Cairan Jenis',
			'jml_tetesan' => 'Jml Tetesan',
			'kolf' => 'Kolf',
			'minum_sonde' => 'Minum Sonde',
			'muntah' => 'Muntah',
			'bak' => 'Bak',
			'bab' => 'Bab',
			'catatan' => 'Catatan',
			'spo2_nilai' => 'Spo2 Nilai',
			'jml_urine' => 'Jml Urine',
			'bunyijantung_anak' => 'Bunyijantung Anak',
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

		$criteria->compare('observasipasienri_id',$this->observasipasienri_id);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('pasienadmisi_id',$this->pasienadmisi_id);
		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('isobservasi_anakbayi',$this->isobservasi_anakbayi);
		$criteria->compare('tgl_observasi',$this->tgl_observasi,true);
		$criteria->compare('jam_observasi',$this->jam_observasi,true);
		$criteria->compare('petugas_id',$this->petugas_id);
		$criteria->compare('td_sistolic',$this->td_sistolic);
		$criteria->compare('td_diastolic',$this->td_diastolic);
		$criteria->compare('detaknadi',$this->detaknadi);
		$criteria->compare('suhutubuh',$this->suhutubuh);
		$criteria->compare('pernapasan',$this->pernapasan);
		$criteria->compare('cairan_jenis',$this->cairan_jenis,true);
		$criteria->compare('jml_tetesan',$this->jml_tetesan);
		$criteria->compare('kolf',$this->kolf,true);
		$criteria->compare('minum_sonde',$this->minum_sonde,true);
		$criteria->compare('muntah',$this->muntah,true);
		$criteria->compare('bak',$this->bak,true);
		$criteria->compare('bab',$this->bab,true);
		$criteria->compare('catatan',$this->catatan,true);
		$criteria->compare('spo2_nilai',$this->spo2_nilai);
		$criteria->compare('jml_urine',$this->jml_urine,true);
		$criteria->compare('bunyijantung_anak',$this->bunyijantung_anak);
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