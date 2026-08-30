<?php

/**
 * This is the model class for table "ratedokter_t".
 *
 * The followings are the available columns in table 'ratedokter_t':
 * @property integer $ratedokter_id
 * @property integer $pasien_id
 * @property string $tglratedokter
 * @property double $ratedokter
 * @property integer $pegawai_id
 */
class MORatedokterT extends RatedokterT
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return MORatedokterT the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

		
	/**
     * menampilkan nama lengkap dokter
     */
    public function getNamaDokter(){
        if(!empty($this->pegawai_id)){
            $modPegawai = PegawaiM::model()->findByPk($this->pegawai_id);
            return $modPegawai->gelardepan." ".$modPegawai->nama_pegawai.(isset($modPegawai->gelarbelakang_id) ? " ".$modPegawai->gelarbelakang->gelarbelakang_nama : "");
        }else{
            return null;
        }
    }
}