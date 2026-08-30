<?php

class BKInformasiorderbatalpembayaranV extends InformasiorderbatalpembayaranV
{
	public $tgl_awal, $tgl_akhir;

	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return OrderbatalalokasiT the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function searchInformasi() {
		$cr = new CDbCriteria;
		$cr->addBetweenCondition('create_time::date', $this->tgl_awal, $this->tgl_akhir);
		$cr->compare('lower(no_pendaftaran)', strtolower($this->no_pendaftaran), true);
		$cr->compare('lower(nama_pasien)', strtolower($this->nama_pasien), true);
		$cr->compare('lower(no_rekam_medik)', strtolower($this->no_rekam_medik), true);
		$cr->compare('lower(nama_petugas)', strtolower($this->nama_petugas), true);
		$cr->compare('carabayar_id', $this->carabayar_id);
		$cr->compare('penjamin_id', $this->penjamin_id);
		$cr->compare('instalasi_id', $this->instalasi_id);
		$cr->compare('ruangan_id', $this->ruangan_id);
		
		//var_dump($cr); die;
		
		return new CActiveDataProvider($this, array(
			'criteria'=>$cr
		));
	}
}