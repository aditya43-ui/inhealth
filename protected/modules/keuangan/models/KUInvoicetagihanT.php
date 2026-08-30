<?php

/**
 * This is the model class for table "invoicetagihan_t".
 *
 * The followings are the available columns in table 'invoicetagihan_t':
 * @property integer $invoicetagihan_id
 * @property integer $ruangan_id
 * @property string $invoicetagihan_no
 * @property string $invoicetagihan_tgl
 * @property string $namapenagih
 * @property string $perihal_tagihan
 * @property string $rekanan_tagihan
 * @property string $ket_pembayaran
 * @property string $isisurat_tagihan
 * @property boolean $status_verifikasi
 * @property integer $peg_verifikasi_tag_id
 * @property string $tgl_verfikasi_tagihan
 * @property double $total_tagihan
 * @property string $disetujui_nama
 * @property string $disetujui_posisi
 * @property string $verifikator_nama
 * @property string $verifikator_posisi
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemekai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 */
class KUInvoicetagihanT extends InvoicetagihanT
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return InvoicetagihanT the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

}