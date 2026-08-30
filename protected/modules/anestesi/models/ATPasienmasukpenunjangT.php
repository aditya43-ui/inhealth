<?php

/**
 * This is the model class for table "pasienmasukpenunjang_t".
 *
 * The followings are the available columns in table 'pasienmasukpenunjang_t':
 * @property integer $pasienmasukpenunjang_id
 * @property integer $pasien_id
 * @property integer $jeniskasuspenyakit_id
 * @property integer $pendaftaran_id
 * @property integer $pegawai_id
 * @property integer $kelaspelayanan_id
 * @property integer $ruangan_id
 * @property integer $pasienadmisi_id
 * @property integer $pasienkirimkeunitlain_id
 * @property string $no_masukpenunjang
 * @property string $tglmasukpenunjang
 * @property string $no_urutperiksa
 * @property string $kunjungan
 * @property string $statusperiksa
 * @property string $ruanganasal_id
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai_id
 * @property string $update_loginpemakai_id
 * @property string $create_ruangan
 */
class ATPasienmasukpenunjangT extends PasienmasukpenunjangT {
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PasienmasukpenunjangT the static model class
	 */
	public static function model($className = __CLASS__) {
		return parent::model($className);
	}
}
