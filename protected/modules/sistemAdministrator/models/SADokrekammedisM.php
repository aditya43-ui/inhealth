<?php

/**
 * This is the model class for table "dokrekammedis_m".
 *
 * The followings are the available columns in table 'dokrekammedis_m':
 * @property integer $dokrekammedis_id
 * @property integer $warnadokrm_id
 * @property integer $subrak_id
 * @property integer $lokasirak_id
 * @property integer $pasien_id
 * @property string $nodokumenrm
 * @property string $tglrekammedis
 * @property string $tglmasukrak
 * @property string $statusrekammedis
 * @property string $tglkeluarakhir
 * @property string $tglmasukakhir
 * @property string $nomortertier
 * @property string $nomorsekunder
 * @property string $nomorprimer
 * @property string $warnanorm_i
 * @property string $warnanorm_ii
 * @property string $tgl_in_aktif
 * @property string $tglpemusnahan
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai_id
 * @property string $update_loginpemakai_id
 * @property string $create_ruangan
 */
class SADokrekammedisM extends DokrekammedisM
{
        public $tgl_awal;
        public $tgl_akhir;
        public $nama_pasien;
        public $no_rekam_medik;
        public $print;
        public $tglpendaftaran;
        public $instalasi;
        public $ruangan;
		public $lookup_id;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return DokrekammedisM the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}