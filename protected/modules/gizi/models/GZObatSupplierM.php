<?php

/**
 * This is the model class for table "obatsupplier_m".
 *
 * The followings are the available columns in table 'obatsupplier_m':
 * @property integer $obatalkes_id
 * @property integer $supplier_id
 */
class GZObatSupplierM extends ObatsupplierM
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ObatsupplierM the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}