<?php

/**
 * This is the model class for table "riwayatresikokerja_r".
 *
 * The followings are the available columns in table 'riwayatresikokerja_r':
 * @property integer $riwayatresikokerja_id
 * @property integer $anamesa_id
 * @property string $jenis_faktor_resiko
 * @property string $nama_faktor_resiko
 * @property string $status_faktor_resiko
 */
class MCRiwayatresikokerjaR extends RiwayatresikokerjaR
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return RiwayatresikokerjaR the static model class
	 */
	public $kebisingan,$suhu_panas,$kelembaban,$pencahayaan_kurang,$kesilauan,$getaran_padatangan,$getaran_seluruhbadan,$ventilasi_kurang,$radiasi_pengion;
	public $radiasi_bukanpengion,$ketinggian,$bakteri,$darah_cairan,$nyamuk,$limbah,$asam,$basa,$pelarut_organik,$uap_logam,$gas,$pestisida,$debu,$posisi_kerja,$gerakan_repetitif;
	public $berdiri_lama,$duduk_lama,$angkat_angkut,$bekerja_denganmotor,$stress_kerja,$kekerasan,$pelecehan,$ketidakjelasan_tugas,$konflik;
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	public function getResikoKerjaByJenis(){
		$ret = RiwayatresikokerjaR::model()->findAllByAttributes(array('jenis_faktor_resiko'=>$this->jenis_faktor_resiko,'anamesa_id'=>$this->anamesa_id));
		return $ret;
	}
	
}