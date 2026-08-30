<?php

/**
 * This is the model class for table "suratpersetujuantm_t".
 *
 * The followings are the available columns in table 'suratpersetujuantm_t':
 * @property integer $suratpersetujuantm_id
 * @property integer $pasienanastesi_id
 * @property integer $ruangan_id
 * @property string $tglpersetujuan
 * @property string $nopersetujuan
 * @property string $nama_menyetujui
 * @property string $umur_menyetujui
 * @property string $jeniskelamin_menyetujui
 * @property string $alamat_menyetujui
 * @property string $noktp_menyetujui
 * @property string $tindakanterhadap
 * @property integer $pegawaisaksi1_id
 * @property string $nama_saksi2
 * @property integer $dokter_id
 * @property string $nama_yangmenyetujui
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 *
 * The followings are the available model relations:
 * @property PasienanastesiT $pasienanastesi
 * @property RuanganM $ruangan
 * @property PegawaiM $pegawaisaksi1
 * @property PegawaiM $dokter
 */
class ATSuratpersetujuantmT extends SuratpersetujuantmT
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return SuratpersetujuantmT the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}