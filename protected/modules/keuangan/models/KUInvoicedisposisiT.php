<?php

/**
 * This is the model class for table "invoicedisposisi_t".
 *
 * The followings are the available columns in table 'invoicedisposisi_t':
 * @property integer $invoicedisposisi_id
 * @property integer $invoicetagihan_id
 * @property string $uraian_disoposisi
 * @property double $total_disposisi
 * @property string $ket_disposisi
 */
class KUInvoicedisposisiT extends InvoicedisposisiT
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return InvoicedisposisiT the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

}