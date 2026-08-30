<?php
class KUBayarkesupplierT extends BayarkesupplierT
{
	public $tgl_awal, $tgl_akhir, $tgl_awalbayarkesupplier, $tgl_akhirbayarkesupplier, $nofaktur, $supplier_id, $tgljatuhtempo;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return BayarkesupplierT the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function getSupplierItems()
	{
		return SupplierM::model()->findAll('supplier_aktif=TRUE ORDER BY supplier_nama');
	}
}