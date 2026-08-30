<?php

class PPTindakanPelayananT extends TindakanpelayananT
{
        public $is_pilihtindakan = 0; //karcis uncheck
        public $jenistarif_id; //untuk membantu filter tarif dari form
				public $pemeriksaanlab_id; //untuk form daftar tindakan pemeriksaan
				
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