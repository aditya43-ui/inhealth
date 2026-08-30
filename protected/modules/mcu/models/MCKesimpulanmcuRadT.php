<?php

/**
 * This is the model class for table "kesimpulanmcu_t".
 *
 * The followings are the available columns in table 'kesimpulanmcu_t':
 * @property integer $kesimpulanmcu_id
 * @property integer $pendaftaran_id
 * @property integer $pasien_id
 * @property integer $permintaanmcu_id
 * @property integer $ruangan_id
 * @property string $tgl_kesimpulanmcu
 * @property string $keterangan_kesimpulanmcu
 * @property boolean $kesimpulan1_status
 * @property string $kesimpulan1_desc
 * @property boolean $kesimpulan2_status
 * @property string $kesimpulan2_desc
 * @property boolean $kesimpulan3_status
 * @property string $kesimpulan3_desc
 * @property string $kesimpulanperorangan
 * @property boolean $saran1_status
 * @property string $saran1_desc
 * @property boolean $saran1_1_status
 * @property string $saran1_1_desc
 * @property boolean $saran1_2_status
 * @property string $saran1_2_desc
 * @property boolean $saran1_3_status
 * @property string $saran1_3_desc
 * @property boolean $saran2_status
 * @property string $saran2_desc
 * @property boolean $saran3_status
 * @property string $saran3_desc
 * @property string $saran3_1_desc
 * @property string $saran3_2_desc
 * @property string $saran3_3_desc
 * @property boolean $saran3_3_1_status
 * @property string $saran3_3_1_desc
 * @property boolean $saran3_3_2_status
 * @property string $saran3_3_2_desc
 * @property boolean $saran3_3_3_status
 * @property string $saran3_3_3_desc
 * @property boolean $saran3_3_4_status
 * @property string $saran3_3_4_desc
 * @property string $saran3_4_desc
 * @property string $saranperorangan
 * @property string $nama_pemeriksa_kes
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 */
class MCKesimpulanmcuRadT extends KesimpulanmcuRadT
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return KesimpulanmcuT the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}