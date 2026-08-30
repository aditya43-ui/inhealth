<?php
class MCDetailHasilPemeriksaanLabT extends DetailhasilpemeriksaanlabT
{
	public $jenispemeriksaanlab_nama, $pemeriksaanlab_nama;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return DetailhasilpemeriksaanlabT the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	/**
	 * nilai yang sudah ada converting symbol
	 */
	public function getNilaiRujukan(){
		return CustomFunction::symbolsConverter($this->nilairujukan);
	}
	/**
	 * nilai yang sudah ada converting symbol
	 */
	public function getHasilPemeriksaanSatuan(){
		return CustomFunction::symbolsConverter($this->hasilpemeriksaan_satuan);
	}
	/**
	 * nilai yang sudah ada converting symbol
	 */
	public function getHasilPemeriksaanMetode(){
		return CustomFunction::symbolsConverter($this->hasilpemeriksaan_metode);
	}

}