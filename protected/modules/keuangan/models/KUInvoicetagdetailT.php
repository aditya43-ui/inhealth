<?php

/**
 * This is the model class for table "invoicetagdetail_t".
 *
 * The followings are the available columns in table 'invoicetagdetail_t':
 * @property integer $invoicetagdetail_id
 * @property integer $invoicetagihan_id
 * @property string $uraian_tagdetail
 * @property double $total_tagdetail
 * @property string $ket_tagdetail
 */
class KUInvoicetagdetailT extends InvoicetagdetailT
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return InvoicetagdetailT the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

}