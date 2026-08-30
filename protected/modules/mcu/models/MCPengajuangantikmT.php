<?php
class MCPengajuangantikmT extends PengajuangantikmT
{
	public $supervisor_nama,$mengetahui_nama;
	public $tgl_awal,$tgl_akhir,$status;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PengajuangantikmT the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}