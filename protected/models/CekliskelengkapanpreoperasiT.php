<?php

/**
 * This is the model class for table "cekliskelengkapanpreoperasi_t".
 *
 * The followings are the available columns in table 'cekliskelengkapanpreoperasi_t':
 * @property integer $cekliskelengkapanpreoperasi_id
 * @property integer $pasien_id
 * @property integer $pendaftaran_id
 * @property integer $pasienadmisi_id
 * @property integer $pasienmasukpenunjang_id
 * @property string $tanggal
 * @property integer $petugasok_id
 * @property integer $pertugasrawatinap_id
 * @property boolean $is_penjelasanpadapasien
 * @property string $ket_penjelasanpadapasien
 * @property boolean $is_suratpersetujuanoperasi
 * @property string $ket_suratpersetujuanoeprasi
 * @property boolean $is_suratpersetujuanbiaya
 * @property string $ket_suratpersetujuanbiaya
 * @property boolean $is_hasillaboratorium
 * @property string $ket_hasillaboratorium
 * @property boolean $is_hasilecg
 * @property string $ket_hasilecg
 * @property boolean $is_hasilrontgen
 * @property string $ket_hasilrontgen
 * @property boolean $is_alatbantu
 * @property string $ket_alatbantu
 * @property boolean $is_perhiasandilepas
 * @property string $ket_perhiasandilepas
 * @property boolean $is_kebersihanbadan
 * @property string $ket_kebersihanbadan
 * @property boolean $is_puasa
 * @property string $ket_puasa
 * @property boolean $is_cukurdaerahoperasi
 * @property string $ket_cukurdaerahoeprasi
 * @property boolean $is_berisavlondaerahoperasi
 * @property string $ket_berisavlondaerahoperasi
 * @property boolean $is_lavement1
 * @property string $ekt_lavement1
 * @property boolean $is_lavement2
 * @property string $ket_lavement2
 * @property boolean $is_terpasangcairan
 * @property string $ket_terpasangcarian
 * @property boolean $is_terpasangmaagslag
 * @property string $ket_terpasangmaagslag
 * @property boolean $is_terpasangkateter
 * @property string $ket_terpasangkateter
 * @property integer $tensi_sistolik
 * @property boolean $is_tensi_sistolik
 * @property string $ket_tensi_sistolik
 * @property integer $tensi_diastolik
 * @property boolean $is_tensi_diastolik
 * @property string $ket_tensi_diastolik
 * @property integer $nadi
 * @property boolean $is_nadi
 * @property string $ket_nadi
 * @property double $suhu
 * @property boolean $is_suhu
 * @property string $ket_suhu
 * @property integer $rr
 * @property boolean $is_rr
 * @property boolean $ket_rr
 * @property double $bb
 * @property boolean $is_bb
 * @property string $ket_bb
 * @property double $tb
 * @property boolean $is_tb
 * @property string $ket_tb
 * @property string $lainlainterapi
 * @property boolean $is_lainlainterapi
 * @property string $ket_lainlainterapi
 * @property string $lainlainpremedikasi
 * @property boolean $is_lainlainpremedikasi
 * @property string $ket_lainlainpremedikasi
 * @property string $lainlainriwayatpengobatan
 * @property boolean $is_lainlainriwayatpengobatan
 * @property string $ket_lainlainriwayatpengobatan
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $createruangan_id
 *
 * The followings are the available model relations:
 * @property PasienM $pasien
 * @property PasienadmisiT $pasienadmisi
 * @property PasienmasukpenunjangT $pasienmasukpenunjang
 * @property PendaftaranT $pendaftaran
 * @property PegawaiM $pertugasrawatinap
 * @property PegawaiM $petugasok
 */
class CekliskelengkapanpreoperasiT extends CActiveRecord
{
	public $petugasok_nama, $pertugasrawatinap_nama;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'cekliskelengkapanpreoperasi_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('petugasok_id, pertugasrawatinap_id, pasien_id, pendaftaran_id, create_time, create_loginpemakai_id, createruangan_id', 'required'),
			array('pasien_id, pendaftaran_id, pasienadmisi_id, pasienmasukpenunjang_id, petugasok_id, pertugasrawatinap_id, tensi_sistolik, tensi_diastolik, nadi, rr, create_loginpemakai_id, update_loginpemakai_id, createruangan_id', 'numerical', 'integerOnly'=>true),
			array('suhu, bb, tb', 'numerical'),
			array('tanggal, is_penjelasanpadapasien, ket_penjelasanpadapasien, is_suratpersetujuanoperasi, ket_suratpersetujuanoeprasi, is_suratpersetujuanbiaya, ket_suratpersetujuanbiaya, is_hasillaboratorium, ket_hasillaboratorium, is_hasilecg, ket_hasilecg, is_hasilrontgen, ket_hasilrontgen, is_alatbantu, ket_alatbantu, is_perhiasandilepas, ket_perhiasandilepas, is_kebersihanbadan, ket_kebersihanbadan, is_puasa, ket_puasa, is_cukurdaerahoperasi, ket_cukurdaerahoeprasi, is_berisavlondaerahoperasi, ket_berisavlondaerahoperasi, is_lavement1, ekt_lavement1, is_lavement2, ket_lavement2, is_terpasangcairan, ket_terpasangcarian, is_terpasangmaagslag, ket_terpasangmaagslag, is_terpasangkateter, ket_terpasangkateter, is_tensi_sistolik, ket_tensi_sistolik, is_tensi_diastolik, ket_tensi_diastolik, is_nadi, ket_nadi, is_suhu, ket_suhu, is_rr, ket_rr, is_bb, ket_bb, is_tb, ket_tb, lainlainterapi, is_lainlainterapi, ket_lainlainterapi, lainlainpremedikasi, is_lainlainpremedikasi, ket_lainlainpremedikasi, lainlainriwayatpengobatan, is_lainlainriwayatpengobatan, ket_lainlainriwayatpengobatan, update_time', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('cekliskelengkapanpreoperasi_id, pasien_id, pendaftaran_id, pasienadmisi_id, pasienmasukpenunjang_id, tanggal, petugasok_id, pertugasrawatinap_id, is_penjelasanpadapasien, ket_penjelasanpadapasien, is_suratpersetujuanoperasi, ket_suratpersetujuanoeprasi, is_suratpersetujuanbiaya, ket_suratpersetujuanbiaya, is_hasillaboratorium, ket_hasillaboratorium, is_hasilecg, ket_hasilecg, is_hasilrontgen, ket_hasilrontgen, is_alatbantu, ket_alatbantu, is_perhiasandilepas, ket_perhiasandilepas, is_kebersihanbadan, ket_kebersihanbadan, is_puasa, ket_puasa, is_cukurdaerahoperasi, ket_cukurdaerahoeprasi, is_berisavlondaerahoperasi, ket_berisavlondaerahoperasi, is_lavement1, ekt_lavement1, is_lavement2, ket_lavement2, is_terpasangcairan, ket_terpasangcarian, is_terpasangmaagslag, ket_terpasangmaagslag, is_terpasangkateter, ket_terpasangkateter, tensi_sistolik, is_tensi_sistolik, ket_tensi_sistolik, tensi_diastolik, is_tensi_diastolik, ket_tensi_diastolik, nadi, is_nadi, ket_nadi, suhu, is_suhu, ket_suhu, rr, is_rr, ket_rr, bb, is_bb, ket_bb, tb, is_tb, ket_tb, lainlainterapi, is_lainlainterapi, ket_lainlainterapi, lainlainpremedikasi, is_lainlainpremedikasi, ket_lainlainpremedikasi, lainlainriwayatpengobatan, is_lainlainriwayatpengobatan, ket_lainlainriwayatpengobatan, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, createruangan_id', 'safe', 'on'=>'search'),
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
			'pasien' => array(self::BELONGS_TO, 'PasienM', 'pasien_id'),
			'pasienadmisi' => array(self::BELONGS_TO, 'PasienadmisiT', 'pasienadmisi_id'),
			'pasienmasukpenunjang' => array(self::BELONGS_TO, 'PasienmasukpenunjangT', 'pasienmasukpenunjang_id'),
			'pendaftaran' => array(self::BELONGS_TO, 'PendaftaranT', 'pendaftaran_id'),
			'pertugasrawatinap' => array(self::BELONGS_TO, 'PegawaiM', 'pertugasrawatinap_id'),
			'petugasok' => array(self::BELONGS_TO, 'PegawaiM', 'petugasok_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'cekliskelengkapanpreoperasi_id' => 'Cekliskelengkapanpreoperasi',
			'pasien_id' => 'Pasien',
			'pendaftaran_id' => 'Pendaftaran',
			'pasienadmisi_id' => 'Pasienadmisi',
			'pasienmasukpenunjang_id' => 'Pasienmasukpenunjang',
			'tanggal' => 'Tanggal',
			'petugasok_id' => 'Petugasok',
			'pertugasrawatinap_id' => 'Pertugasrawatinap',
			'is_penjelasanpadapasien' => 'Is Penjelasanpadapasien',
			'ket_penjelasanpadapasien' => 'Ket Penjelasanpadapasien',
			'is_suratpersetujuanoperasi' => 'Is Suratpersetujuanoperasi',
			'ket_suratpersetujuanoeprasi' => 'Ket Suratpersetujuanoeprasi',
			'is_suratpersetujuanbiaya' => 'Is Suratpersetujuanbiaya',
			'ket_suratpersetujuanbiaya' => 'Ket Suratpersetujuanbiaya',
			'is_hasillaboratorium' => 'Is Hasillaboratorium',
			'ket_hasillaboratorium' => 'Ket Hasillaboratorium',
			'is_hasilecg' => 'Is Hasilecg',
			'ket_hasilecg' => 'Ket Hasilecg',
			'is_hasilrontgen' => 'Is Hasilrontgen',
			'ket_hasilrontgen' => 'Ket Hasilrontgen',
			'is_alatbantu' => 'Is Alatbantu',
			'ket_alatbantu' => 'Ket Alatbantu',
			'is_perhiasandilepas' => 'Is Perhiasandilepas',
			'ket_perhiasandilepas' => 'Ket Perhiasandilepas',
			'is_kebersihanbadan' => 'Is Kebersihanbadan',
			'ket_kebersihanbadan' => 'Ket Kebersihanbadan',
			'is_puasa' => 'Is Puasa',
			'ket_puasa' => 'Ket Puasa',
			'is_cukurdaerahoperasi' => 'Is Cukurdaerahoperasi',
			'ket_cukurdaerahoeprasi' => 'Ket Cukurdaerahoeprasi',
			'is_berisavlondaerahoperasi' => 'Is Berisavlondaerahoperasi',
			'ket_berisavlondaerahoperasi' => 'Ket Berisavlondaerahoperasi',
			'is_lavement1' => 'Is Lavement1',
			'ekt_lavement1' => 'Ekt Lavement1',
			'is_lavement2' => 'Is Lavement2',
			'ket_lavement2' => 'Ket Lavement2',
			'is_terpasangcairan' => 'Is Terpasangcairan',
			'ket_terpasangcarian' => 'Ket Terpasangcarian',
			'is_terpasangmaagslag' => 'Is Terpasangmaagslag',
			'ket_terpasangmaagslag' => 'Ket Terpasangmaagslag',
			'is_terpasangkateter' => 'Is Terpasangkateter',
			'ket_terpasangkateter' => 'Ket Terpasangkateter',
			'tensi_sistolik' => 'Tensi Sistolik',
			'is_tensi_sistolik' => 'Is Tensi Sistolik',
			'ket_tensi_sistolik' => 'Ket Tensi Sistolik',
			'tensi_diastolik' => 'Tensi Diastolik',
			'is_tensi_diastolik' => 'Is Tensi Diastolik',
			'ket_tensi_diastolik' => 'Ket Tensi Diastolik',
			'nadi' => 'Nadi',
			'is_nadi' => 'Is Nadi',
			'ket_nadi' => 'Ket Nadi',
			'suhu' => 'Suhu',
			'is_suhu' => 'Is Suhu',
			'ket_suhu' => 'Ket Suhu',
			'rr' => 'Rr',
			'is_rr' => 'Is Rr',
			'ket_rr' => 'Ket Rr',
			'bb' => 'Bb',
			'is_bb' => 'Is Bb',
			'ket_bb' => 'Ket Bb',
			'tb' => 'Tb',
			'is_tb' => 'Is Tb',
			'ket_tb' => 'Ket Tb',
			'lainlainterapi' => 'Lainlainterapi',
			'is_lainlainterapi' => 'Is Lainlainterapi',
			'ket_lainlainterapi' => 'Ket Lainlainterapi',
			'lainlainpremedikasi' => 'Lainlainpremedikasi',
			'is_lainlainpremedikasi' => 'Is Lainlainpremedikasi',
			'ket_lainlainpremedikasi' => 'Ket Lainlainpremedikasi',
			'lainlainriwayatpengobatan' => 'Lainlainriwayatpengobatan',
			'is_lainlainriwayatpengobatan' => 'Is Lainlainriwayatpengobatan',
			'ket_lainlainriwayatpengobatan' => 'Ket Lainlainriwayatpengobatan',
			'create_time' => 'Create Time',
			'update_time' => 'Update Time',
			'create_loginpemakai_id' => 'Create Loginpemakai',
			'update_loginpemakai_id' => 'Update Loginpemakai',
			'createruangan_id' => 'Createruangan',
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

		$criteria->compare('cekliskelengkapanpreoperasi_id',$this->cekliskelengkapanpreoperasi_id);
		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('pasienadmisi_id',$this->pasienadmisi_id);
		$criteria->compare('pasienmasukpenunjang_id',$this->pasienmasukpenunjang_id);
		$criteria->compare('tanggal',$this->tanggal,true);
		$criteria->compare('petugasok_id',$this->petugasok_id);
		$criteria->compare('pertugasrawatinap_id',$this->pertugasrawatinap_id);
		$criteria->compare('is_penjelasanpadapasien',$this->is_penjelasanpadapasien);
		$criteria->compare('ket_penjelasanpadapasien',$this->ket_penjelasanpadapasien,true);
		$criteria->compare('is_suratpersetujuanoperasi',$this->is_suratpersetujuanoperasi);
		$criteria->compare('ket_suratpersetujuanoeprasi',$this->ket_suratpersetujuanoeprasi,true);
		$criteria->compare('is_suratpersetujuanbiaya',$this->is_suratpersetujuanbiaya);
		$criteria->compare('ket_suratpersetujuanbiaya',$this->ket_suratpersetujuanbiaya,true);
		$criteria->compare('is_hasillaboratorium',$this->is_hasillaboratorium);
		$criteria->compare('ket_hasillaboratorium',$this->ket_hasillaboratorium,true);
		$criteria->compare('is_hasilecg',$this->is_hasilecg);
		$criteria->compare('ket_hasilecg',$this->ket_hasilecg,true);
		$criteria->compare('is_hasilrontgen',$this->is_hasilrontgen);
		$criteria->compare('ket_hasilrontgen',$this->ket_hasilrontgen,true);
		$criteria->compare('is_alatbantu',$this->is_alatbantu);
		$criteria->compare('ket_alatbantu',$this->ket_alatbantu,true);
		$criteria->compare('is_perhiasandilepas',$this->is_perhiasandilepas);
		$criteria->compare('ket_perhiasandilepas',$this->ket_perhiasandilepas,true);
		$criteria->compare('is_kebersihanbadan',$this->is_kebersihanbadan);
		$criteria->compare('ket_kebersihanbadan',$this->ket_kebersihanbadan,true);
		$criteria->compare('is_puasa',$this->is_puasa);
		$criteria->compare('ket_puasa',$this->ket_puasa,true);
		$criteria->compare('is_cukurdaerahoperasi',$this->is_cukurdaerahoperasi);
		$criteria->compare('ket_cukurdaerahoeprasi',$this->ket_cukurdaerahoeprasi,true);
		$criteria->compare('is_berisavlondaerahoperasi',$this->is_berisavlondaerahoperasi);
		$criteria->compare('ket_berisavlondaerahoperasi',$this->ket_berisavlondaerahoperasi,true);
		$criteria->compare('is_lavement1',$this->is_lavement1);
		$criteria->compare('ekt_lavement1',$this->ekt_lavement1,true);
		$criteria->compare('is_lavement2',$this->is_lavement2);
		$criteria->compare('ket_lavement2',$this->ket_lavement2,true);
		$criteria->compare('is_terpasangcairan',$this->is_terpasangcairan);
		$criteria->compare('ket_terpasangcarian',$this->ket_terpasangcarian,true);
		$criteria->compare('is_terpasangmaagslag',$this->is_terpasangmaagslag);
		$criteria->compare('ket_terpasangmaagslag',$this->ket_terpasangmaagslag,true);
		$criteria->compare('is_terpasangkateter',$this->is_terpasangkateter);
		$criteria->compare('ket_terpasangkateter',$this->ket_terpasangkateter,true);
		$criteria->compare('tensi_sistolik',$this->tensi_sistolik);
		$criteria->compare('is_tensi_sistolik',$this->is_tensi_sistolik);
		$criteria->compare('ket_tensi_sistolik',$this->ket_tensi_sistolik,true);
		$criteria->compare('tensi_diastolik',$this->tensi_diastolik);
		$criteria->compare('is_tensi_diastolik',$this->is_tensi_diastolik);
		$criteria->compare('ket_tensi_diastolik',$this->ket_tensi_diastolik,true);
		$criteria->compare('nadi',$this->nadi);
		$criteria->compare('is_nadi',$this->is_nadi);
		$criteria->compare('ket_nadi',$this->ket_nadi,true);
		$criteria->compare('suhu',$this->suhu);
		$criteria->compare('is_suhu',$this->is_suhu);
		$criteria->compare('ket_suhu',$this->ket_suhu,true);
		$criteria->compare('rr',$this->rr);
		$criteria->compare('is_rr',$this->is_rr);
		$criteria->compare('ket_rr',$this->ket_rr);
		$criteria->compare('bb',$this->bb);
		$criteria->compare('is_bb',$this->is_bb);
		$criteria->compare('ket_bb',$this->ket_bb,true);
		$criteria->compare('tb',$this->tb);
		$criteria->compare('is_tb',$this->is_tb);
		$criteria->compare('ket_tb',$this->ket_tb,true);
		$criteria->compare('lainlainterapi',$this->lainlainterapi,true);
		$criteria->compare('is_lainlainterapi',$this->is_lainlainterapi);
		$criteria->compare('ket_lainlainterapi',$this->ket_lainlainterapi,true);
		$criteria->compare('lainlainpremedikasi',$this->lainlainpremedikasi,true);
		$criteria->compare('is_lainlainpremedikasi',$this->is_lainlainpremedikasi);
		$criteria->compare('ket_lainlainpremedikasi',$this->ket_lainlainpremedikasi,true);
		$criteria->compare('lainlainriwayatpengobatan',$this->lainlainriwayatpengobatan,true);
		$criteria->compare('is_lainlainriwayatpengobatan',$this->is_lainlainriwayatpengobatan);
		$criteria->compare('ket_lainlainriwayatpengobatan',$this->ket_lainlainriwayatpengobatan,true);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('create_loginpemakai_id',$this->create_loginpemakai_id);
		$criteria->compare('update_loginpemakai_id',$this->update_loginpemakai_id);
		$criteria->compare('createruangan_id',$this->createruangan_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return CekliskelengkapanpreoperasiT the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}