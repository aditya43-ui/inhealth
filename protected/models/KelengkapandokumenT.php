<?php

/**
 * This is the model class for table "kelengkapandokumen_t".
 *
 * The followings are the available columns in table 'kelengkapandokumen_t':
 * @property integer $kelengkapandokumen_id
 * @property integer $pendaftaran_id
 * @property string $ktp
 * @property string $kodeicd
 * @property string $kepalalist
 * @property string $formcairan
 * @property string $diagnosatindakan
 * @property string $namadokteroperasi
 * @property string $tandatangandokter
 * @property string $namapasien
 * @property string $tandatanganpasien
 * @property string $namasaksi1
 * @property string $tandatangansaksi1
 * @property string $namasaksi2
 * @property string $tandatangansaksi2
 * @property string $dischargesum
 * @property string $formoperasi
 * @property string $formanastesi
 * @property string $formkematian
 * @property string $formaskep
 * @property string $generalconsent
 * @property string $formic
 * @property string $f1_a
 * @property string $ket_f1_a
 * @property string $f2_a
 * @property string $ket_f2_a
 * @property string $f2_b
 * @property string $ket_f2_b
 * @property string $f3_a
 * @property string $ket_f3_a
 * @property string $f3_b
 * @property string $ket_f3_b
 * @property string $f5_a_operasi
 * @property string $ket_f5_a_operasi
 * @property string $is_f5_b_operasi
 * @property string $ket_f5_b_operasi
 * @property string $is_f5_c_operasi
 * @property string $ket_f5_c_operasi
 * @property string $f5_d_operasi
 * @property string $ket_f5_d_operasi
 * @property string $f5_e_operasi
 * @property string $ket_f5_e_operasi
 * @property string $f5_f_operasi
 * @property string $ket_f5_f_operasi
 * @property string $f5_g_operasi
 * @property string $ket_f5_g_operasi
 * @property string $f5_h_operasi
 * @property string $ket_f5_h_operasi
 * @property string $f5_a_anastesi
 * @property string $ket_f5_a_anastesi
 * @property string $f5_b_anastesi
 * @property string $ket_f5_b_anastesi
 * @property string $f5_c_anastesi
 * @property string $ket_f5_c_anastesi
 * @property string $f5_a_kemoterapi
 * @property string $ket_f5_a_kemoterapi
 * @property string $f5_b_kemoterapi
 * @property string $ket_f5_b_kemoterapi
 * @property string $f5_a_transfusi
 * @property string $ket_f5_a_transfusi
 * @property string $f5_b_transfusi
 * @property string $ket_f5_b_transfusi
 * @property string $f5_c_transfusi
 * @property string $ket_f5_c_transfusi
 * @property string $f6_a_cppt
 * @property string $ket_f6_a_cppt
 * @property string $f6_b_cppt
 * @property string $ket_f6_b_cppt
 * @property string $f6_c_cppt
 * @property string $ket_f6_c_cppt
 * @property string $f6_d_cppt
 * @property string $ket_f6_d_cppt
 * @property string $f8_a_ringkasan
 * @property string $ket_f8_a_ringkasan
 * @property string $f8_b_ringkasan
 * @property string $ket_f8_b_ringkasan
 * @property string $f8_c_ringkasan
 * @property string $ket_f8_c_ringkasan
 * @property string $f8_a_kematian
 * @property string $ket_f8_a_kematian
 * @property string $f8_b_kematian
 * @property string $ket_f8_b_kematian
 * @property string $casemix_a
 * @property string $ket_casemix_a
 * @property string $casemix_b
 * @property string $ket_casemix_b
 * @property string $f5_i_operasi
 * @property string $ket_f5_i_operasi
 * @property string $f5_c_kemoterapi
 * @property string $ket_f5_c_kemoterapi
 * @property string $f8_d_ringkasan
 * @property string $ket_f8_d_ringkasan
 * @property string $f8_e_ringkasan
 * @property string $ket_f8_e_ringkasan
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $createruangan_id
 * @property integer $pasienadmisi_id
 *
 * The followings are the available model relations:
 * @property PendaftaranT $pendaftaran
 */
class KelengkapandokumenT extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public $f5_b_operasi, $f5_b_anestesi, $f5_a_cppt, $ket_f5_a_cppt, $f5_b_cppt, $ket_f5_b_cppt,
	 		$is_f5_b_operasi, $is_f5_c_operasi, $f5_b_anastesi;
	public function tableName()
	{
		return 'kelengkapandokumen_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pendaftaran_id, create_time, create_loginpemakai_id, createruangan_id', 'required'),
			array('pendaftaran_id, create_loginpemakai_id, update_loginpemakai_id, createruangan_id, pasienadmisi_id', 'numerical', 'integerOnly'=>true),
			array('ktp, kodeicd, kepalalist, formcairan, diagnosatindakan, namadokteroperasi, tandatangandokter, namapasien, tandatanganpasien, namasaksi1, tandatangansaksi1, namasaksi2, tandatangansaksi2, dischargesum, formoperasi, formanastesi, formkematian, formaskep, generalconsent, formic, f1_a, f2_a, f2_b, f3_a, f3_b, f5_a_operasi, is_f5_b_operasi, is_f5_c_operasi, f5_d_operasi, f5_e_operasi, f5_f_operasi, f5_g_operasi, f5_h_operasi, f5_a_anastesi, f5_b_anastesi, f5_c_anastesi, f5_a_kemoterapi, f5_b_kemoterapi, f5_a_transfusi, f5_b_transfusi, f5_c_transfusi, f6_a_cppt, f6_b_cppt, f6_c_cppt, f6_d_cppt, f8_a_ringkasan, f8_b_ringkasan, f8_c_ringkasan, f8_a_kematian, f8_b_kematian, casemix_a, casemix_b, f5_i_operasi, f5_c_kemoterapi, f8_d_ringkasan, f8_e_ringkasan', 'length', 'max'=>255),
			array('ket_f1_a, ket_f2_a, ket_f2_b, ket_f3_a, ket_f3_b, ket_f5_a_operasi, ket_f5_b_operasi, ket_f5_c_operasi, ket_f5_d_operasi, ket_f5_e_operasi, ket_f5_f_operasi, ket_f5_g_operasi, ket_f5_h_operasi, ket_f5_a_anastesi, ket_f5_b_anastesi, ket_f5_c_anastesi, ket_f5_a_kemoterapi, ket_f5_b_kemoterapi, ket_f5_a_transfusi, ket_f5_b_transfusi, ket_f5_c_transfusi, ket_f6_a_cppt, ket_f6_b_cppt, ket_f6_c_cppt, ket_f6_d_cppt, ket_f8_a_ringkasan, ket_f8_b_ringkasan, ket_f8_c_ringkasan, ket_f8_a_kematian, ket_f8_b_kematian, ket_casemix_a, ket_casemix_b, ket_f5_i_operasi, ket_f5_c_kemoterapi, ket_f8_d_ringkasan, ket_f8_e_ringkasan, update_time', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('kelengkapandokumen_id, pendaftaran_id, ktp, kodeicd, kepalalist, formcairan, diagnosatindakan, namadokteroperasi, tandatangandokter, namapasien, tandatanganpasien, namasaksi1, tandatangansaksi1, namasaksi2, tandatangansaksi2, dischargesum, formoperasi, formanastesi, formkematian, formaskep, generalconsent, formic, f1_a, ket_f1_a, f2_a, ket_f2_a, f2_b, ket_f2_b, f3_a, ket_f3_a, f3_b, ket_f3_b, f5_a_operasi, ket_f5_a_operasi, is_f5_b_operasi, ket_f5_b_operasi, is_f5_c_operasi, ket_f5_c_operasi, f5_d_operasi, ket_f5_d_operasi, f5_e_operasi, ket_f5_e_operasi, f5_f_operasi, ket_f5_f_operasi, f5_g_operasi, ket_f5_g_operasi, f5_h_operasi, ket_f5_h_operasi, f5_a_anastesi, ket_f5_a_anastesi, f5_b_anastesi, ket_f5_b_anastesi, f5_c_anastesi, ket_f5_c_anastesi, f5_a_kemoterapi, ket_f5_a_kemoterapi, f5_b_kemoterapi, ket_f5_b_kemoterapi, f5_a_transfusi, ket_f5_a_transfusi, f5_b_transfusi, ket_f5_b_transfusi, f5_c_transfusi, ket_f5_c_transfusi, f6_a_cppt, ket_f6_a_cppt, f6_b_cppt, ket_f6_b_cppt, f6_c_cppt, ket_f6_c_cppt, f6_d_cppt, ket_f6_d_cppt, f8_a_ringkasan, ket_f8_a_ringkasan, f8_b_ringkasan, ket_f8_b_ringkasan, f8_c_ringkasan, ket_f8_c_ringkasan, f8_a_kematian, ket_f8_a_kematian, f8_b_kematian, ket_f8_b_kematian, casemix_a, ket_casemix_a, casemix_b, ket_casemix_b, f5_i_operasi, ket_f5_i_operasi, f5_c_kemoterapi, ket_f5_c_kemoterapi, f8_d_ringkasan, ket_f8_d_ringkasan, f8_e_ringkasan, ket_f8_e_ringkasan, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, createruangan_id, pasienadmisi_id', 'safe', 'on'=>'search'),
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
			'create_loginpemakai' => array(self::BELONGS_TO, 'PegawaiM', 'create_loginpemakai_id'),
			'loginpemakai' => array(self::BELONGS_TO, 'LoginpemakaiK', 'create_loginpemakai_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'kelengkapandokumen_id' => 'Kelengkapandokumen',
			'pendaftaran_id' => 'Pendaftaran',
			'ktp' => 'Ktp',
			'kodeicd' => 'Kodeicd',
			'kepalalist' => 'Kepalalist',
			'formcairan' => 'Formcairan',
			'diagnosatindakan' => 'Diagnosatindakan',
			'namadokteroperasi' => 'Namadokteroperasi',
			'tandatangandokter' => 'Tandatangandokter',
			'namapasien' => 'Namapasien',
			'tandatanganpasien' => 'Tandatanganpasien',
			'namasaksi1' => 'Namasaksi1',
			'tandatangansaksi1' => 'Tandatangansaksi1',
			'namasaksi2' => 'Namasaksi2',
			'tandatangansaksi2' => 'Tandatangansaksi2',
			'dischargesum' => 'Dischargesum',
			'formoperasi' => 'Formoperasi',
			'formanastesi' => 'Formanastesi',
			'formkematian' => 'Formkematian',
			'formaskep' => 'Formaskep',
			'generalconsent' => 'Generalconsent',
			'formic' => 'Formic',
			'f1_a' => 'F1 A',
			'ket_f1_a' => 'Ket F1 A',
			'f2_a' => 'F2 A',
			'ket_f2_a' => 'Ket F2 A',
			'f2_b' => 'F2 B',
			'ket_f2_b' => 'Ket F2 B',
			'f3_a' => 'F3 A',
			'ket_f3_a' => 'Ket F3 A',
			'f3_b' => 'F3 B',
			'ket_f3_b' => 'Ket F3 B',
			'f5_a_operasi' => 'F5 A Operasi',
			'ket_f5_a_operasi' => 'Ket F5 A Operasi',
			'is_f5_b_operasi' => 'Is F5 B Operasi',
			'ket_f5_b_operasi' => 'Ket F5 B Operasi',
			'is_f5_c_operasi' => 'Is F5 C Operasi',
			'ket_f5_c_operasi' => 'Ket F5 C Operasi',
			'f5_d_operasi' => 'F5 D Operasi',
			'ket_f5_d_operasi' => 'Ket F5 D Operasi',
			'f5_e_operasi' => 'F5 E Operasi',
			'ket_f5_e_operasi' => 'Ket F5 E Operasi',
			'f5_f_operasi' => 'F5 F Operasi',
			'ket_f5_f_operasi' => 'Ket F5 F Operasi',
			'f5_g_operasi' => 'F5 G Operasi',
			'ket_f5_g_operasi' => 'Ket F5 G Operasi',
			'f5_h_operasi' => 'F5 H Operasi',
			'ket_f5_h_operasi' => 'Ket F5 H Operasi',
			'f5_a_anastesi' => 'F5 A Anastesi',
			'ket_f5_a_anastesi' => 'Ket F5 A Anastesi',
			'f5_b_anastesi' => 'F5 B Anastesi',
			'ket_f5_b_anastesi' => 'Ket F5 B Anastesi',
			'f5_c_anastesi' => 'F5 C Anastesi',
			'ket_f5_c_anastesi' => 'Ket F5 C Anastesi',
			'f5_a_kemoterapi' => 'F5 A Kemoterapi',
			'ket_f5_a_kemoterapi' => 'Ket F5 A Kemoterapi',
			'f5_b_kemoterapi' => 'F5 B Kemoterapi',
			'ket_f5_b_kemoterapi' => 'Ket F5 B Kemoterapi',
			'f5_a_transfusi' => 'F5 A Transfusi',
			'ket_f5_a_transfusi' => 'Ket F5 A Transfusi',
			'f5_b_transfusi' => 'F5 B Transfusi',
			'ket_f5_b_transfusi' => 'Ket F5 B Transfusi',
			'f5_c_transfusi' => 'F5 C Transfusi',
			'ket_f5_c_transfusi' => 'Ket F5 C Transfusi',
			'f6_a_cppt' => 'F6 A Cppt',
			'ket_f6_a_cppt' => 'Ket F6 A Cppt',
			'f6_b_cppt' => 'F6 B Cppt',
			'ket_f6_b_cppt' => 'Ket F6 B Cppt',
			'f6_c_cppt' => 'F6 C Cppt',
			'ket_f6_c_cppt' => 'Ket F6 C Cppt',
			'f6_d_cppt' => 'F6 D Cppt',
			'ket_f6_d_cppt' => 'Ket F6 D Cppt',
			'f8_a_ringkasan' => 'F8 A Ringkasan',
			'ket_f8_a_ringkasan' => 'Ket F8 A Ringkasan',
			'f8_b_ringkasan' => 'F8 B Ringkasan',
			'ket_f8_b_ringkasan' => 'Ket F8 B Ringkasan',
			'f8_c_ringkasan' => 'F8 C Ringkasan',
			'ket_f8_c_ringkasan' => 'Ket F8 C Ringkasan',
			'f8_a_kematian' => 'F8 A Kematian',
			'ket_f8_a_kematian' => 'Ket F8 A Kematian',
			'f8_b_kematian' => 'F8 B Kematian',
			'ket_f8_b_kematian' => 'Ket F8 B Kematian',
			'casemix_a' => 'Casemix A',
			'ket_casemix_a' => 'Ket Casemix A',
			'casemix_b' => 'Casemix B',
			'ket_casemix_b' => 'Ket Casemix B',
			'f5_i_operasi' => 'F5 I Operasi',
			'ket_f5_i_operasi' => 'Ket F5 I Operasi',
			'f5_c_kemoterapi' => 'F5 C Kemoterapi',
			'ket_f5_c_kemoterapi' => 'Ket F5 C Kemoterapi',
			'f8_d_ringkasan' => 'F8 D Ringkasan',
			'ket_f8_d_ringkasan' => 'Ket F8 D Ringkasan',
			'f8_e_ringkasan' => 'F8 E Ringkasan',
			'ket_f8_e_ringkasan' => 'Ket F8 E Ringkasan',
			'create_time' => 'Create Time',
			'update_time' => 'Update Time',
			'create_loginpemakai_id' => 'Create Loginpemakai',
			'update_loginpemakai_id' => 'Update Loginpemakai',
			'createruangan_id' => 'Createruangan',
			'pasienadmisi_id' => 'Pasienadmisi',
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

		$criteria->compare('kelengkapandokumen_id',$this->kelengkapandokumen_id);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('ktp',$this->ktp,true);
		$criteria->compare('kodeicd',$this->kodeicd,true);
		$criteria->compare('kepalalist',$this->kepalalist,true);
		$criteria->compare('formcairan',$this->formcairan,true);
		$criteria->compare('diagnosatindakan',$this->diagnosatindakan,true);
		$criteria->compare('namadokteroperasi',$this->namadokteroperasi,true);
		$criteria->compare('tandatangandokter',$this->tandatangandokter,true);
		$criteria->compare('namapasien',$this->namapasien,true);
		$criteria->compare('tandatanganpasien',$this->tandatanganpasien,true);
		$criteria->compare('namasaksi1',$this->namasaksi1,true);
		$criteria->compare('tandatangansaksi1',$this->tandatangansaksi1,true);
		$criteria->compare('namasaksi2',$this->namasaksi2,true);
		$criteria->compare('tandatangansaksi2',$this->tandatangansaksi2,true);
		$criteria->compare('dischargesum',$this->dischargesum,true);
		$criteria->compare('formoperasi',$this->formoperasi,true);
		$criteria->compare('formanastesi',$this->formanastesi,true);
		$criteria->compare('formkematian',$this->formkematian,true);
		$criteria->compare('formaskep',$this->formaskep,true);
		$criteria->compare('generalconsent',$this->generalconsent,true);
		$criteria->compare('formic',$this->formic,true);
		$criteria->compare('f1_a',$this->f1_a,true);
		$criteria->compare('ket_f1_a',$this->ket_f1_a,true);
		$criteria->compare('f2_a',$this->f2_a,true);
		$criteria->compare('ket_f2_a',$this->ket_f2_a,true);
		$criteria->compare('f2_b',$this->f2_b,true);
		$criteria->compare('ket_f2_b',$this->ket_f2_b,true);
		$criteria->compare('f3_a',$this->f3_a,true);
		$criteria->compare('ket_f3_a',$this->ket_f3_a,true);
		$criteria->compare('f3_b',$this->f3_b,true);
		$criteria->compare('ket_f3_b',$this->ket_f3_b,true);
		$criteria->compare('f5_a_operasi',$this->f5_a_operasi,true);
		$criteria->compare('ket_f5_a_operasi',$this->ket_f5_a_operasi,true);
		$criteria->compare('is_f5_b_operasi',$this->is_f5_b_operasi,true);
		$criteria->compare('ket_f5_b_operasi',$this->ket_f5_b_operasi,true);
		$criteria->compare('is_f5_c_operasi',$this->is_f5_c_operasi,true);
		$criteria->compare('ket_f5_c_operasi',$this->ket_f5_c_operasi,true);
		$criteria->compare('f5_d_operasi',$this->f5_d_operasi,true);
		$criteria->compare('ket_f5_d_operasi',$this->ket_f5_d_operasi,true);
		$criteria->compare('f5_e_operasi',$this->f5_e_operasi,true);
		$criteria->compare('ket_f5_e_operasi',$this->ket_f5_e_operasi,true);
		$criteria->compare('f5_f_operasi',$this->f5_f_operasi,true);
		$criteria->compare('ket_f5_f_operasi',$this->ket_f5_f_operasi,true);
		$criteria->compare('f5_g_operasi',$this->f5_g_operasi,true);
		$criteria->compare('ket_f5_g_operasi',$this->ket_f5_g_operasi,true);
		$criteria->compare('f5_h_operasi',$this->f5_h_operasi,true);
		$criteria->compare('ket_f5_h_operasi',$this->ket_f5_h_operasi,true);
		$criteria->compare('f5_a_anastesi',$this->f5_a_anastesi,true);
		$criteria->compare('ket_f5_a_anastesi',$this->ket_f5_a_anastesi,true);
		$criteria->compare('f5_b_anastesi',$this->f5_b_anastesi,true);
		$criteria->compare('ket_f5_b_anastesi',$this->ket_f5_b_anastesi,true);
		$criteria->compare('f5_c_anastesi',$this->f5_c_anastesi,true);
		$criteria->compare('ket_f5_c_anastesi',$this->ket_f5_c_anastesi,true);
		$criteria->compare('f5_a_kemoterapi',$this->f5_a_kemoterapi,true);
		$criteria->compare('ket_f5_a_kemoterapi',$this->ket_f5_a_kemoterapi,true);
		$criteria->compare('f5_b_kemoterapi',$this->f5_b_kemoterapi,true);
		$criteria->compare('ket_f5_b_kemoterapi',$this->ket_f5_b_kemoterapi,true);
		$criteria->compare('f5_a_transfusi',$this->f5_a_transfusi,true);
		$criteria->compare('ket_f5_a_transfusi',$this->ket_f5_a_transfusi,true);
		$criteria->compare('f5_b_transfusi',$this->f5_b_transfusi,true);
		$criteria->compare('ket_f5_b_transfusi',$this->ket_f5_b_transfusi,true);
		$criteria->compare('f5_c_transfusi',$this->f5_c_transfusi,true);
		$criteria->compare('ket_f5_c_transfusi',$this->ket_f5_c_transfusi,true);
		$criteria->compare('f6_a_cppt',$this->f6_a_cppt,true);
		$criteria->compare('ket_f6_a_cppt',$this->ket_f6_a_cppt,true);
		$criteria->compare('f6_b_cppt',$this->f6_b_cppt,true);
		$criteria->compare('ket_f6_b_cppt',$this->ket_f6_b_cppt,true);
		$criteria->compare('f6_c_cppt',$this->f6_c_cppt,true);
		$criteria->compare('ket_f6_c_cppt',$this->ket_f6_c_cppt,true);
		$criteria->compare('f6_d_cppt',$this->f6_d_cppt,true);
		$criteria->compare('ket_f6_d_cppt',$this->ket_f6_d_cppt,true);
		$criteria->compare('f8_a_ringkasan',$this->f8_a_ringkasan,true);
		$criteria->compare('ket_f8_a_ringkasan',$this->ket_f8_a_ringkasan,true);
		$criteria->compare('f8_b_ringkasan',$this->f8_b_ringkasan,true);
		$criteria->compare('ket_f8_b_ringkasan',$this->ket_f8_b_ringkasan,true);
		$criteria->compare('f8_c_ringkasan',$this->f8_c_ringkasan,true);
		$criteria->compare('ket_f8_c_ringkasan',$this->ket_f8_c_ringkasan,true);
		$criteria->compare('f8_a_kematian',$this->f8_a_kematian,true);
		$criteria->compare('ket_f8_a_kematian',$this->ket_f8_a_kematian,true);
		$criteria->compare('f8_b_kematian',$this->f8_b_kematian,true);
		$criteria->compare('ket_f8_b_kematian',$this->ket_f8_b_kematian,true);
		$criteria->compare('casemix_a',$this->casemix_a,true);
		$criteria->compare('ket_casemix_a',$this->ket_casemix_a,true);
		$criteria->compare('casemix_b',$this->casemix_b,true);
		$criteria->compare('ket_casemix_b',$this->ket_casemix_b,true);
		$criteria->compare('f5_i_operasi',$this->f5_i_operasi,true);
		$criteria->compare('ket_f5_i_operasi',$this->ket_f5_i_operasi,true);
		$criteria->compare('f5_c_kemoterapi',$this->f5_c_kemoterapi,true);
		$criteria->compare('ket_f5_c_kemoterapi',$this->ket_f5_c_kemoterapi,true);
		$criteria->compare('f8_d_ringkasan',$this->f8_d_ringkasan,true);
		$criteria->compare('ket_f8_d_ringkasan',$this->ket_f8_d_ringkasan,true);
		$criteria->compare('f8_e_ringkasan',$this->f8_e_ringkasan,true);
		$criteria->compare('ket_f8_e_ringkasan',$this->ket_f8_e_ringkasan,true);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('create_loginpemakai_id',$this->create_loginpemakai_id);
		$criteria->compare('update_loginpemakai_id',$this->update_loginpemakai_id);
		$criteria->compare('createruangan_id',$this->createruangan_id);
		$criteria->compare('pasienadmisi_id',$this->pasienadmisi_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return KelengkapandokumenT the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
