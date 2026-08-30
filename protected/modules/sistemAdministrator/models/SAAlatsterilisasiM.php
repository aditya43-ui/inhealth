<?php

class SAAlatsterilisasiM extends AlatmedisM
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return GolonganpegawaiM the static model class
	 */
	public $jenisalatmedis_nama;
	public $instalasi_nama;
	
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function attributeLabels()
	{
		return array(
			'alatmedis_id' => 'ID',
			'instalasi_id' => 'Instalasi',
			'jenisalatmedis_id' => 'Jenis Alat Sterilisasi',
			'alatmedis_noaset' => 'No. Aset',
			'alatmedis_nama' => 'Nama Alat Sterilisasi',
			'alatmedis_namalain' => 'Nama Lainnya',
			'alatmedis_aktif' => 'Alat Sterilisasi Aktif',
			'alatmedis_kode' => 'Kode',
			'alatmedis_format' => 'Format',
		);
	}
	
	public function getInstalasiItems()
	{
		 return InstalasiM::model()->findAll('instalasi_aktif=TRUE ORDER BY instalasi_nama');
	}
	
	public function getJenisalatmedisItems()
	{
		 return JenisalatmedisM::model()->findAll('jenisalatmedis_aktif=TRUE ORDER BY jenisalatmedis_nama');
	}
}