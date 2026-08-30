<?php

/**
 * This is the model class for table "riwayattht_r".
 *
 * The followings are the available columns in table 'riwayattht_r':
 * @property integer $riwayattht_id
 * @property integer $pemeriksaanfisik_id
 * @property string $jenis_tht
 * @property string $bagian_tht
 * @property string $status_bagiantht
 */
class MCRiwayatthtR extends RiwayatthtR
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return RiwayatthtR the static model class
	 */
	public $bentuk_telinga, $liang_telinga, $membran_timpani, $serumen, $keterangan_telinga; // telinga
	public $bentuk_hidung, $septum_nasi, $konka_nasal, $keterangan_hidung; // hidung
	public $pharynx, $tonsil, $ukuran, $keterangan_tenggorokan; // tenggorokan
	public $oral_hygine, $gusi, $gigi, $keterangan_mulut; // mulut
	public $bentuk_leher, $kelenjar_thyroid, $keterangan_leher; // leher
	public $paru_inspeksi, $paru_palpasi, $paru_perkusi, $paru_auskultasi, $keterangan_paru; // paru
	public $jantung_inspeksi, $jantung_palpasi, $jantung_perkusi, $jantung_auskultasi, $keterangan_jantung; // jantung
	public $bentuk_abdomen, $inspeksi_abdomen, $hati, $limpa, $keterangan_abdomen; // abdomen
	public $anus, $keterangan_rectal; // rectal
	public $extremitas, $keterangan_extremitas; // extremitas
	public $neurologis, $keterangan_neurologis; // neurologis
	public $warna_kulit, $kelainan_kulit, $sensibilitas_kulit, $keterangan_kulit; // kulit
	public $rectal_tidakdilakukan;
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	public function getTHTByJenis(){
		$ret = RiwayatthtR::model()->findAllByAttributes(array('jenis_tht'=>$this->jenis_tht,'pemeriksaanfisik_id'=>$this->pemeriksaanfisik_id));
		return $ret;
	}
}