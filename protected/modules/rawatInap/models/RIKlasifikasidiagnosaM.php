<?php
class RIKlasifikasidiagnosaM extends KlasifikasidiagnosaM
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return KlasifikasidiagnosaM the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function getKlasifikasiKodeNama(){
		return $this->klasifikasidiagnosa_kode." - ".$this->klasifikasidiagnosa_nama;
	}
}