<?php

/**
 * This is the model class for table "riwayatindividu_r".
 *
 * The followings are the available columns in table 'riwayatindividu_r':
 * @property integer $riwayatindividu_id
 * @property integer $anamesa_id
 * @property string $nama_riwayat_individu
 * @property string $status_riwayatinidividu
 */
class MCRiwayatindividuR extends RiwayatindividuR
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return RiwayatindividuR the static model class
	 */
	public $pengobatan_tbc,$pengobatan_hepatitis,$asma,$radang_sendi,$serangan_jantung,$patah_tulang,$hemoroid,$hipertensi,$diabetes_melitus,$tyroid,$penyakit_ginjal;
	public $saluran_kemih,$penyakit_stroke,$epilepsi,$thypus,$tranfusi_darah,$hiv,$kanker,$lainnya_label,$lainnya,$riwayat_kecelakankerja,$riwayat_jenisoperasi;
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}