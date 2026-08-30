<?php

class PCPendaftaranT extends PendaftaranT
{
	public $jeniskasuspenyakit_nama,$kelas_layanan;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PendaftaranT the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}