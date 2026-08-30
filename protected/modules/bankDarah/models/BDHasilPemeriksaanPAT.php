<?php

class BDHasilPemeriksaanPAT extends HasilpemeriksaanpaT
{
	public $no_pendaftaran,$tglmasukpenunjang,$no_masukpenunjang,$no_rekam_medik;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return HasilpemeriksaanpaT the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function searchDashboardBD()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
		$criteria->select = 'pendaftaran_t.no_pendaftaran,pasienmasukpenunjang_t.tglmasukpenunjang,
       pasienmasukpenunjang_t.no_masukpenunjang, pasien_m.no_rekam_medik,pasien_m.nama_pasien';
		$criteria->join = 'JOIN pasienmasukpenunjang_t ON pasienmasukpenunjang_t.pasienmasukpenunjang_id=t.pasienmasukpenunjang_id
		JOIN pendaftaran_t ON pendaftaran_t.pendaftaran_id=t.pendaftaran_id
		JOIN pasien_m ON pasien_m.pasien_id=t.pasien_id';
		$criteria->group = 'pendaftaran_t.no_pendaftaran,pasienmasukpenunjang_t.tglmasukpenunjang, pasienmasukpenunjang_t.no_masukpenunjang, pasien_m.no_rekam_medik,pasien_m.nama_pasien';
		$criteria->order = 'tglmasukpenunjang desc';
		$criteria->limit = 10;

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}