<?php
class ADPermintaanpembelianT extends PermintaanpembelianT
{
        public $pegawaimengetahui_nama;
        public $pegawaimenyetujui_nama;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PermintaanpembelianT the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
	public function getSyaratBayarItems()
	{
		return SyaratbayarM::model()->findAll('syaratbayar_aktif=TRUE ORDER BY syaratbayar_nama');
	}

	}
