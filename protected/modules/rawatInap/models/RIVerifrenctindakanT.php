<?php
class RIVerifrenctindakanT extends VerifrenctindakanT
{
	public $mengetahui_nama;
	public $nama_pegawai;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return VerifrenctindakanT the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}