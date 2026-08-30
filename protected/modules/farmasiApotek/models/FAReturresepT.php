<?php

class FAReturresepT extends ReturresepT
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return AnamnesaT the static model class
	 */
	public $tgl_awal,$tgl_akhir;
	public $totalpenjualan = 0;
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

}