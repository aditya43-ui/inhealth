<?php

/**
 * This is the model class for table "resumeperawat_r".
 *
 * The followings are the available columns in table 'resumeperawat_r':
 * @property integer $resumeperawat_id
 * @property integer $pasien_id
 * @property integer $kelaspelayanan_id
 * @property integer $kamarruangan_id
 * @property integer $pendaftaran_id
 * @property integer $pegawai_id
 * @property string $nodocresperwt
 * @property string $tglreseumperwt
 * @property string $tglmasukrs
 * @property string $tglkeluarrs
 * @property integer $ruanganakhir_id
 * @property integer $perawatbidan_id
 * @property string $keluhansaatmasuk
 * @property integer $diagnosaawal_id
 * @property string $diagkeprwtdiatasi
 * @property string $diagkeprwtblmteratasi
 * @property string $tindakankeprwatan
 * @property string $hasikperiksalab
 * @property string $hasilperiksarad
 * @property string $hasilperiksadiet
 * @property string $hasilperiksarehabmedis
 * @property string $hasilperiksalainlain
 * @property string $keadaansaatkeluar
 * @property string $keadaanumumkeluar
 * @property string $suhu_saatkeluar
 * @property string $nadi_saatkeluar
 * @property string $tensi_saatkeluar
 * @property string $nafas_saatkeluar
 * @property integer $diagnosautama_id
 * @property integer $diagnosasekunder1_id
 * @property integer $diagnosasekunder2_id
 * @property integer $diagnosasekunder3_id
 * @property string $terapilanjutan
 * @property string $nasehat_diit
 * @property string $nasehat_mobilisasi
 * @property string $nasehat_eliminasi
 * @property string $nasehat_kontrol
 * @property string $carakeluar
 * @property string $tglkontrol
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 */
class RIResumeperawatR extends ResumeperawatR
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ResumeperawatR the static model class
	 */
	public $diagnosaawal_nama,$diagnosautama_nama,$diagnosasekunder1_nama,$diagnosasekunder2_nama,$diagnosasekunder3_nama;
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'diagnosaawal'=>array(self::BELONGS_TO,'DiagnosaM','diagnosaawal_id'),
			'diagnosautama'=>array(self::BELONGS_TO,'DiagnosaM','diagnosautama_id'),
			'diagnosasekunder1'=>array(self::BELONGS_TO,'DiagnosaM','diagnosasekunder1_id'),
			'diagnosasekunder2'=>array(self::BELONGS_TO,'DiagnosaM','diagnosasekunder2_id'),
			'diagnosasekunder3'=>array(self::BELONGS_TO,'DiagnosaM','diagnosasekunder3_id'),
			'createlogin'=>array(self::BELONGS_TO,'PegawaiM','create_loginpemakai_id'),
			'updatelogin'=>array(self::BELONGS_TO,'PegawaiM','update_loginpemakai_id'),
		);
	}
}