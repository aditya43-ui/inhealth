<?php

/**
 * This is the model class for table "simulasianggaran_t".
 *
 * The followings are the available columns in table 'simulasianggaran_t':
 * @property integer $simulasianggaran_id
 * @property integer $konfiganggaran_id
 * @property integer $unitkerja_id
 * @property integer $subkegiatanprogram_id
 * @property string $nosimulasianggaran
 * @property string $tglsimulasianggaran
 * @property double $nilai_anggaran
 * @property string $kenaikan_persen
 * @property double $kenaikan_rupiah
 * @property double $total_nilaianggaran
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 */
class AGSimulasianggaranT extends SimulasianggaranT
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return SimulasianggaranT the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}