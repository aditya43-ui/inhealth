<?php

/**
 * This is the model class for table "pembayaranpelayanan_t".
 *
 * The followings are the available columns in table 'pembayaranpelayanan_t':
 * @property integer $pembayaranpelayanan_id
 * @property integer $pembebasantarif_id
 * @property integer $suratketjaminan_id
 * @property integer $pasien_id
 * @property integer $carabayar_id
 * @property integer $penjamin_id
 * @property integer $ruangan_id
 * @property integer $tandabuktibayar_id
 * @property integer $pendaftaran_id
 * @property integer $pasienadmisi_id
 * @property string $nopembayaran
 * @property string $tglpembayaran
 * @property string $noresep
 * @property string $nosjp
 * @property double $totalbiayaoa
 * @property double $totalbiayatindakan
 * @property double $totalbiayapelayanan
 * @property double $totalsubsidiasuransi
 * @property double $totalsubsidipemerintah
 * @property double $totalsubsidirs
 * @property double $totaliurbiaya
 * @property double $totalbayartindakan
 * @property double $totaldiscount
 * @property double $totalpembebasan
 * @property double $totalsisatagihan
 * @property integer $ruanganpelakhir_id
 * @property string $statusbayar
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai_id
 * @property string $update_loginpemakai_id
 * @property string $create_ruangan
 */
class KUPembayaranpelayananT extends PembayaranpelayananT
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PembayaranpelayananT the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
