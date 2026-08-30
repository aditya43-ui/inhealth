<?php

/**
 * This is the model class for table "pemeriksaankala_t".
 *
 * The followings are the available columns in table 'pemeriksaankala_t':
 * @property integer $pemeriksaankala_id
 * @property string $tgl_pemeriksaan
 * @property integer $pendaftaran_id
 * @property integer $pasien_id
 * @property integer $pemeriksaanfisik_id
 * @property integer $persalinan_id
 * @property boolean $kala_i_partogram_gariswaspada
 * @property string $kala_i_masalahlain
 * @property string $kala_i_penatalaksaan_masalah_tsb
 * @property string $kala_i_hasilnya
 * @property boolean $kala_ii_is_episotomi
 * @property string $kala_ii_episotomo_indikasi
 * @property boolean $kala_ii_suami
 * @property boolean $kala_ii_keluarga
 * @property boolean $kala_ii_teman
 * @property boolean $kala_ii_dukun
 * @property boolean $kala_ii_tidak_ada
 * @property boolean $kala_ii_is_gawatjanin
 * @property string $kala_ii_gawatjanin_tindakan
 * @property boolean $kala_ii_is_distosiabahu
 * @property string $kala_ii_distosiabahu_tindakan
 * @property string $kala_ii_masalahlain
 * @property string $kala_ii_penatalaksaan_masalah_tsb
 * @property string $kala_ii_hasilnya
 * @property integer $kala_iii_lama
 * @property boolean $kala_iii_is_beri_olsitosin
 * @property integer $kala_iii_beri_olsitosin_waktu
 * @property string $kala_iii_alasan_tidak_beri_olsitosin
 * @property boolean $kala_iii_is_beri_ulang_oksitosin
 * @property string $kala_iii_beri_ulang_oksitosin_alasan
 * @property boolean $kala_iii_is_penegangan_tali_pusat
 * @property string $kala_iii_tidak_penegangan_talipusat_alasan
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 */
class PemeriksaankalaT extends CActiveRecord
{
        public $kala_iii_is_masase_fundusuteri, $kala_iii_masase_fundusuteri_alasantidak, $kala_iii_is_plasenta_lahirlengkap;
        public $kala_iii_plasenta_lahirlengkap_tidak_ket, $kala_iii_is_plasenta_tidak_lahirlebih30mnt; 
        public $kala_iii_plasenta_tidak_lahirlebih30mnt_ya_ket, $kala_iii_is_laserasi, $kala_iii_laserasi_ya_dimana;
        public $kala_iii_laserasi_perineum_derajat, $kala_iii_is_laserasi_perineum_penjahitan, $kala_iii_tidak_laserasi_perineum_penjahitan_alasan;
        public $kala_iii_is_atoni_uteri, $kala_iii_ya_atoni_uteri_tindakan, $kala_iii_jumlah_pendarahan, $kala_iii_masalah_lain, $kala_iii_penatalaksaan_masalah_tsb, $kala_iii_hasilnya;
		public $kala_1_petugaspemeriksa_nama, $kala_2_petugaspemeriksa_nama, $kala_3_petugaspemeriksa_nama, $kala_4_petugaspemeriksa_nama;
		public $kala_1_ppds_nama, $kala_2_ppds_nama, $kala_3_ppds_nama, $kala_4_ppds_nama;
		public $kala_1_ppds_id, $kala_2_ppds_id, $kala_3_ppds_id, $kala_4_ppds_id;
		

		/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PemeriksaankalaT the static model class
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
		return 'pemeriksaankala_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('tgl_pemeriksaan, pendaftaran_id, pasien_id, create_time, create_loginpemakai_id, create_ruangan', 'required'),
			array('pendaftaran_id, pasien_id, pemeriksaanfisik_id, persalinan_id, kala_iii_lama, kala_iii_beri_olsitosin_waktu, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, kala_1_petugaspemeriksa, kala_2_petugaspemeriksa, kala_3_petugaspemeriksa, kala_4_petugaspemeriksa,kala_1_ppds_id, kala_2_ppds_id, kala_3_ppds_id, kala_4_ppds_id ', 'numerical', 'integerOnly'=>true),
			array('kala_ii_jmlpendarahan', 'numerical'),
			array('kala_iii_isimd, kala_iii_penjepitaltalipusar, kala_iii_pmtct', 'length', 'max'=>30),
			array('kala_i_hasilnya', 'length', 'max'=>120),
			array('kala_ii_episotomo_indikasi, kala_iii_laserasi_perineum_penjahitan_keterangan', 'length', 'max'=>100),
			array('kala_ii_penatalaksaan_masalah_tsb, kala_ii_hasilnya, kala_iii_alasan_tidak_beri_olsitosin, kala_iii_beri_ulang_oksitosin_alasan, kala_iii_tidak_penegangan_talipusat_alasan', 'length', 'max'=>150),
			array('kala_i_temuanlaten, kala_i_partogram_gariswaspada, kala_i_masalahlain, kala_1_ppds_nama,kala_2_ppds_nama,kala_3_ppds_nama,kala_4_ppds_nama kala_i_penatalaksaan_masalah_tsb, kala_ii_is_episotomi, kala_ii_suami, kala_ii_keluarga, kala_ii_teman, kala_ii_dukun, kala_ii_tidak_ada, kala_ii_is_gawatjanin, kala_ii_gawatjanin_tindakan, kala_ii_is_distosiabahu, kala_ii_distosiabahu_tindakan, kala_ii_masalahlain, kala_iii_is_beri_olsitosin, kala_iii_is_beri_ulang_oksitosin, kala_iii_is_penegangan_tali_pusat, update_time', 'safe'),
            array('kala_iv_masalah_lain, kala_iv_penatalaksaan_masalah_tsb, kala_iv_hasilnya', 'safe'),
                        array('kala_iii_is_masase_fundusuteri, kala_iii_masase_fundusuteri_alasantidak, kala_iii_is_plasenta_lahirlengkap, kala_iii_plasenta_lahirlengkap_tidak_ket, kala_iii_is_plasenta_tidak_lahirlebih30mnt, kala_iii_plasenta_tidak_lahirlebih30mnt_ya_ket, kala_iii_is_laserasi, kala_iii_laserasi_ya_dimana, kala_iii_laserasi_perineum_derajat, kala_iii_is_laserasi_perineum_penjahitan, kala_iii_tidak_laserasi_perineum_penjahitan_alasan','safe'),
                        array('kala_iii_is_atoni_uteri, kala_iii_ya_atoni_uteri_tindakan, kala_iii_jumlah_pendarahan, kala_iii_masalah_lain, kala_iii_penatalaksaan_masalah_tsb, kala_iii_hasilnya, kala_iii_laserasi_perineum_penjahitan_keterangan, kala_4_waktupemeriksaan, kala_iii_isalasantindakpmtct, kala_1_waktupemeriksaan, kala_2_waktupemeriksaan, kala_ii_isperiksadjj, kala_ii_hasilpemantauandjj, kala_3_waktupemeriksaan, kala_iii_alasantidak_imd, kala_iv_keadaanumum','safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('pemeriksaankala_id, tgl_pemeriksaan, pendaftaran_id, pasien_id, pemeriksaanfisik_id, persalinan_id, kala_i_partogram_gariswaspada, kala_i_masalahlain, kala_i_penatalaksaan_masalah_tsb, kala_i_hasilnya, kala_ii_is_episotomi, kala_ii_episotomo_indikasi, kala_ii_suami, kala_ii_keluarga, kala_ii_teman, kala_ii_dukun, kala_ii_tidak_ada, kala_ii_is_gawatjanin, kala_ii_gawatjanin_tindakan, kala_ii_is_distosiabahu, kala_ii_distosiabahu_tindakan, kala_ii_masalahlain, kala_ii_penatalaksaan_masalah_tsb, kala_ii_hasilnya, kala_iii_lama, kala_iii_is_beri_olsitosin, kala_iii_beri_olsitosin_waktu, kala_iii_alasan_tidak_beri_olsitosin, kala_iii_is_beri_ulang_oksitosin, kala_iii_beri_ulang_oksitosin_alasan, kala_iii_is_penegangan_tali_pusat, kala_iii_tidak_penegangan_talipusat_alasan, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, kala_iii_laserasi_perineum_penjahitan_keterangan, kala_4_waktupemeriksaan, kala_iii_isalasantindakpmtct, kala_1_waktupemeriksaan, kala_2_waktupemeriksaan, kala_ii_isperiksadjj, kala_ii_hasilpemantauandjj, kala_3_waktupemeriksaan, kala_iii_alasantidak_imd, kala_iv_keadaanumum, kala_1_petugaspemeriksa, kala_2_petugaspemeriksa, kala_3_petugaspemeriksa, kala_4_petugaspemeriksa, kala_ii_jmlpendarahan, kala_iii_isimd, kala_iii_penjepitaltalipusar, kala_iii_pmtct', 'safe', 'on'=>'search'),
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
			'pemeriksaankala_id' => 'Pemeriksaankala',
			'tgl_pemeriksaan' => 'Tgl. Pemeriksaan',
			'pendaftaran_id' => 'Pendaftaran',
			'pasien_id' => 'Pasien',
			'pemeriksaanfisik_id' => 'Pemeriksaanfisik',
			'persalinan_id' => 'Persalinan',
            'kala_i_temuanlaten'=>'Temuan selama fase laten',
			'kala_i_partogram_gariswaspada' => 'Partogram Melewati Garis Waspada',
			'kala_i_masalahlain' => 'Masalah lain, sebutkan',
			'kala_i_penatalaksaan_masalah_tsb' => 'Penatalaksaan Masalah Tsb',
			'kala_i_hasilnya' => 'Hasilnya',
			'kala_ii_is_episotomi' => 'Kala Ii Is Episotomi',
			'kala_ii_episotomo_indikasi' => 'Kala Ii Episotomo Indikasi',
			'kala_ii_suami' => 'Kala Ii Suami',
			'kala_ii_keluarga' => 'Kala Ii Keluarga',
			'kala_ii_teman' => 'Kala Ii Teman',
			'kala_ii_dukun' => 'Kala Ii Dukun',
			'kala_ii_tidak_ada' => 'Kala Ii Tidak Ada',
			'kala_ii_is_gawatjanin' => 'Kala Ii Is Gawatjanin',
			'kala_ii_gawatjanin_tindakan' => 'Kala Ii Gawatjanin Tindakan',
			'kala_ii_is_distosiabahu' => 'Kala Ii Is Distosiabahu',
			'kala_ii_distosiabahu_tindakan' => 'Kala Ii Distosiabahu Tindakan',
			'kala_ii_masalahlain' => 'Masalah lain, sebutkan',
			'kala_ii_penatalaksaan_masalah_tsb' => 'Penatalaksaan Masalah Tsb',
			'kala_ii_hasilnya' => 'Hasilnya',
			'kala_iii_lama' => 'Kala Iii Lama',
			'kala_iii_is_beri_olsitosin' => 'Kala Iii Is Beri Olsitosin',
			'kala_iii_beri_olsitosin_waktu' => 'Kala Iii Beri Olsitosin Waktu',
			'kala_iii_alasan_tidak_beri_olsitosin' => 'Kala Iii Alasan Tidak Beri Olsitosin',
			'kala_iii_is_beri_ulang_oksitosin' => 'Kala Iii Is Beri Ulang Oksitosin',
			'kala_iii_beri_ulang_oksitosin_alasan' => 'Kala Iii Beri Ulang Oksitosin Alasan',
			'kala_iii_is_penegangan_tali_pusat' => 'Kala Iii Is Penegangan Tali Pusat',
			'kala_iii_tidak_penegangan_talipusat_alasan' => 'Kala Iii Tidak Penegangan Talipusat Alasan',
			'create_time' => 'Waktu Create',
			'update_time' => 'Waktu Update',
			'create_loginpemakai_id' => 'Create Login Pemakai',
			'update_loginpemakai_id' => 'Update Login Pemakai',
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

		$criteria->compare('pemeriksaankala_id',$this->pemeriksaankala_id);
		$criteria->compare('tgl_pemeriksaan',$this->tgl_pemeriksaan,true);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('pemeriksaanfisik_id',$this->pemeriksaanfisik_id);
		$criteria->compare('persalinan_id',$this->persalinan_id);
		$criteria->compare('kala_i_partogram_gariswaspada',$this->kala_i_partogram_gariswaspada);
		$criteria->compare('kala_i_masalahlain',$this->kala_i_masalahlain,true);
		$criteria->compare('kala_i_penatalaksaan_masalah_tsb',$this->kala_i_penatalaksaan_masalah_tsb,true);
		$criteria->compare('kala_i_hasilnya',$this->kala_i_hasilnya,true);
		$criteria->compare('kala_ii_is_episotomi',$this->kala_ii_is_episotomi);
		$criteria->compare('kala_ii_episotomo_indikasi',$this->kala_ii_episotomo_indikasi,true);
		$criteria->compare('kala_ii_suami',$this->kala_ii_suami);
		$criteria->compare('kala_ii_keluarga',$this->kala_ii_keluarga);
		$criteria->compare('kala_ii_teman',$this->kala_ii_teman);
		$criteria->compare('kala_ii_dukun',$this->kala_ii_dukun);
		$criteria->compare('kala_ii_tidak_ada',$this->kala_ii_tidak_ada);
		$criteria->compare('kala_ii_is_gawatjanin',$this->kala_ii_is_gawatjanin);
		$criteria->compare('kala_ii_gawatjanin_tindakan',$this->kala_ii_gawatjanin_tindakan,true);
		$criteria->compare('kala_ii_is_distosiabahu',$this->kala_ii_is_distosiabahu);
		$criteria->compare('kala_ii_distosiabahu_tindakan',$this->kala_ii_distosiabahu_tindakan,true);
		$criteria->compare('kala_ii_masalahlain',$this->kala_ii_masalahlain,true);
		$criteria->compare('kala_ii_penatalaksaan_masalah_tsb',$this->kala_ii_penatalaksaan_masalah_tsb,true);
		$criteria->compare('kala_ii_hasilnya',$this->kala_ii_hasilnya,true);
		$criteria->compare('kala_iii_lama',$this->kala_iii_lama);
		$criteria->compare('kala_iii_is_beri_olsitosin',$this->kala_iii_is_beri_olsitosin);
		$criteria->compare('kala_iii_beri_olsitosin_waktu',$this->kala_iii_beri_olsitosin_waktu);
		$criteria->compare('kala_iii_alasan_tidak_beri_olsitosin',$this->kala_iii_alasan_tidak_beri_olsitosin,true);
		$criteria->compare('kala_iii_is_beri_ulang_oksitosin',$this->kala_iii_is_beri_ulang_oksitosin);
		$criteria->compare('kala_iii_beri_ulang_oksitosin_alasan',$this->kala_iii_beri_ulang_oksitosin_alasan,true);
		$criteria->compare('kala_iii_is_penegangan_tali_pusat',$this->kala_iii_is_penegangan_tali_pusat);
		$criteria->compare('kala_iii_tidak_penegangan_talipusat_alasan',$this->kala_iii_tidak_penegangan_talipusat_alasan,true);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('create_loginpemakai_id',$this->create_loginpemakai_id);
		$criteria->compare('update_loginpemakai_id',$this->update_loginpemakai_id);
		$criteria->compare('create_ruangan',$this->create_ruangan);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}