<?php

/**
 * This is the model class for table "pemeriksaangoldar_t".
 *
 * The followings are the available columns in table 'pemeriksaangoldar_t':
 * @property integer $pemeriksaangoldar_id
 * @property integer $hasilujicocokserasi_id
 * @property integer $pasien_id
 * @property integer $pendaftaran_id
 * @property integer $pasienkirimkeunitlain_id
 * @property integer $pasienmasukpenunjang_id
 * @property integer $ruangan_id
 * @property integer $pegawai_id
 * @property integer $create_loginpemakai_id
 * @property integer $create_ruangan
 * @property string $create_time
 * @property integer $stokkantongdarah_id
 * @property string $nomorbarcode
 * @property integer $pengujiandarah_id
 * @property string $anti_a
 * @property string $anti_b
 * @property string $tessel_a
 * @property string $tessel_b
 * @property string $tessel_o
 * @property string $autocontrol
 * @property string $antid
 * @property string $bvalbumin
 * @property string $kesimpulan
 * @property string $mayor1
 * @property string $mayor2
 * @property string $mayor3
 * @property string $mayor4
 * @property string $minor1
 * @property string $minor2
 * @property string $minor3
 * @property string $minor4
 * @property string $autocontrol_goldar
 * @property boolean $screeningab
 * @property boolean $imediate_spin
 * @property string $kesimpulan_goldar
 * @property string $catatan
 * @property integer $penyiapandarah_id
 * @property string $tanggal_keluardarah
 * @property string $no_kantongpabrik
 */
class PemeriksaangoldarT extends CActiveRecord
{
	public $singkatan_komp, $kirim_penyiapan;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'pemeriksaangoldar_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('hasilujicocokserasi_id, pasien_id, pendaftaran_id, pasienkirimkeunitlain_id, pasienmasukpenunjang_id', 'required'),
			array('hasilujicocokserasi_id, pasien_id, pendaftaran_id, pasienkirimkeunitlain_id, pasienmasukpenunjang_id, ruangan_id, pegawai_id, create_loginpemakai_id, create_ruangan, stokkantongdarah_id, pengujiandarah_id, penyiapandarah_id', 'numerical', 'integerOnly'=>true),
			array('nomorbarcode, anti_a, anti_b, tessel_a, tessel_b, tessel_o, autocontrol, antid, bvalbumin, kesimpulan, mayor1, mayor2, mayor3, mayor4, minor1, minor2, minor3, minor4, autocontrol_goldar, kesimpulan_goldar, catatan, no_kantongpabrik', 'length', 'max'=>255),
			array('create_time, screeningab, imediate_spin, tanggal_keluardarah', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('pemeriksaangoldar_id, hasilujicocokserasi_id, pasien_id, pendaftaran_id, pasienkirimkeunitlain_id, pasienmasukpenunjang_id, ruangan_id, pegawai_id, create_loginpemakai_id, create_ruangan, create_time, stokkantongdarah_id, nomorbarcode, pengujiandarah_id, anti_a, anti_b, tessel_a, tessel_b, tessel_o, autocontrol, antid, bvalbumin, kesimpulan, mayor1, mayor2, mayor3, mayor4, minor1, minor2, minor3, minor4, autocontrol_goldar, screeningab, imediate_spin, kesimpulan_goldar, catatan, penyiapandarah_id, tanggal_keluardarah, no_kantongpabrik', 'safe', 'on'=>'search'),
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
			'stokkantongdarah' => array(self::BELONGS_TO, 'StokkantongdarahT', 'stokkantongdarah_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'pemeriksaangoldar_id' => 'Pemeriksaangoldar',
			'hasilujicocokserasi_id' => 'Hasilujicocokserasi',
			'pasien_id' => 'Pasien',
			'pendaftaran_id' => 'Pendaftaran',
			'pasienkirimkeunitlain_id' => 'Pasienkirimkeunitlain',
			'pasienmasukpenunjang_id' => 'Pasienmasukpenunjang',
			'ruangan_id' => 'Ruangan',
			'pegawai_id' => 'Pegawai',
			'create_loginpemakai_id' => 'Create Loginpemakai',
			'create_ruangan' => 'Create Ruangan',
			'create_time' => 'Create Time',
			'stokkantongdarah_id' => 'Stokkantongdarah',
			'nomorbarcode' => 'Nomorbarcode',
			'pengujiandarah_id' => 'Pengujiandarah',
			'anti_a' => 'Anti A',
			'anti_b' => 'Anti B',
			'tessel_a' => 'Tessel A',
			'tessel_b' => 'Tessel B',
			'tessel_o' => 'Tessel O',
			'autocontrol' => 'Autocontrol',
			'antid' => 'Antid',
			'bvalbumin' => 'Bvalbumin',
			'kesimpulan' => 'Kesimpulan',
			'mayor1' => 'Mayor1',
			'mayor2' => 'Mayor2',
			'mayor3' => 'Mayor3',
			'mayor4' => 'Mayor4',
			'minor1' => 'Minor1',
			'minor2' => 'Minor2',
			'minor3' => 'Minor3',
			'minor4' => 'Minor4',
			'autocontrol_goldar' => 'Autocontrol Goldar',
			'screeningab' => 'Screeningab',
			'imediate_spin' => 'Imediate Spin',
			'kesimpulan_goldar' => 'Kesimpulan Goldar',
			'catatan' => 'Catatan',
			'penyiapandarah_id' => 'Penyiapandarah',
			'tanggal_keluardarah' => 'Tanggal Keluardarah',
			'no_kantongpabrik' => 'No Kantongpabrik',
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

		$criteria->compare('pemeriksaangoldar_id',$this->pemeriksaangoldar_id);
		$criteria->compare('hasilujicocokserasi_id',$this->hasilujicocokserasi_id);
		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('pasienkirimkeunitlain_id',$this->pasienkirimkeunitlain_id);
		$criteria->compare('pasienmasukpenunjang_id',$this->pasienmasukpenunjang_id);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->compare('create_loginpemakai_id',$this->create_loginpemakai_id);
		$criteria->compare('create_ruangan',$this->create_ruangan);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('stokkantongdarah_id',$this->stokkantongdarah_id);
		$criteria->compare('nomorbarcode',$this->nomorbarcode,true);
		$criteria->compare('pengujiandarah_id',$this->pengujiandarah_id);
		$criteria->compare('anti_a',$this->anti_a,true);
		$criteria->compare('anti_b',$this->anti_b,true);
		$criteria->compare('tessel_a',$this->tessel_a,true);
		$criteria->compare('tessel_b',$this->tessel_b,true);
		$criteria->compare('tessel_o',$this->tessel_o,true);
		$criteria->compare('autocontrol',$this->autocontrol,true);
		$criteria->compare('antid',$this->antid,true);
		$criteria->compare('bvalbumin',$this->bvalbumin,true);
		$criteria->compare('kesimpulan',$this->kesimpulan,true);
		$criteria->compare('mayor1',$this->mayor1,true);
		$criteria->compare('mayor2',$this->mayor2,true);
		$criteria->compare('mayor3',$this->mayor3,true);
		$criteria->compare('mayor4',$this->mayor4,true);
		$criteria->compare('minor1',$this->minor1,true);
		$criteria->compare('minor2',$this->minor2,true);
		$criteria->compare('minor3',$this->minor3,true);
		$criteria->compare('minor4',$this->minor4,true);
		$criteria->compare('autocontrol_goldar',$this->autocontrol_goldar,true);
		$criteria->compare('screeningab',$this->screeningab);
		$criteria->compare('imediate_spin',$this->imediate_spin);
		$criteria->compare('kesimpulan_goldar',$this->kesimpulan_goldar,true);
		$criteria->compare('catatan',$this->catatan,true);
		$criteria->compare('penyiapandarah_id',$this->penyiapandarah_id);
		$criteria->compare('tanggal_keluardarah',$this->tanggal_keluardarah,true);
		$criteria->compare('no_kantongpabrik',$this->no_kantongpabrik,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return PemeriksaangoldarT the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
