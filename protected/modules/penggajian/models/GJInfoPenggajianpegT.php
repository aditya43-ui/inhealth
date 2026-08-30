<?php

/**
 * This is the model class for table "penggajianpeg_t".
 *
 * The followings are the available columns in table 'penggajianpeg_t':
 * @property integer $penggajianpeg_id
 * @property integer $pegawai_id
 * @property string $tglpenggajian
 * @property string $nopenggajian
 * @property string $keterangan
 * @property string $mengetahui
 * @property string $menyetujui
 * @property double $totalterima
 * @property double $totalpajak
 * @property double $totalpotongan
 * @property double $penerimaanbersih
 */
class GJInfoPenggajianpegT extends PenggajianpegT
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PenggajianpegT the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

}