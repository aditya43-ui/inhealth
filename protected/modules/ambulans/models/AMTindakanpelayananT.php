<?php

class AMTindakanpelayananT extends TindakanpelayananT
{
        public $kepropinsi_nama,$kekabupaten_nama,$kekecamatan_nama,$kekelurahan_nama,$jmlkilometer,$tarifperkm,$tarif_pelayanan; //untuk form daftar tindakan pelayanan
        /**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return TindakanpelayananT the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}