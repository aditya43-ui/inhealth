<?php

class BKInformasipembebasantarifV extends InformasipembebasantarifV
{
        public $tgl_awal, $tgl_akhir;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return InformasipembebasantarifV the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * searchInformasi digunakan di:
         * - Biling Kasir/Informasi/Pembebasan Tarif
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function searchInformasi()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
		$format=new MyFormatter;
		
		if(!empty($this->pembebasantarif_id)){
			$criteria->addCondition('pembebasantarif_id = '.$this->pembebasantarif_id);
		}
		$criteria->addBetweenCondition('tglpembebasan',$this->tgl_awal.' 00:00:00',$this->tgl_akhir.' 23:59:59');
		$criteria->compare('jmlpembebasan',$this->jmlpembebasan);
		if(!empty($this->pegawai_id)){
			$criteria->addCondition('pegawai_id = '.$this->pegawai_id);
		}
		$criteria->compare('LOWER(nama_pegawai)', strtolower($this->nama_pegawai),true);
		if(!empty($this->tindakanpelayanan_id)){
			$criteria->addCondition('tindakanpelayanan_id = '.$this->tindakanpelayanan_id);
		}
		if(!empty($this->daftartindakan_id)){
			$criteria->addCondition('daftartindakan_id = '.$this->daftartindakan_id);
		}
		$criteria->compare('LOWER(daftartindakan_nama)',strtolower($this->daftartindakan_nama),true);
		if(!empty($this->komponentarif_id)){
			$criteria->addCondition('komponentarif_id = '.$this->komponentarif_id);
		}
		$criteria->compare('LOWER(komponentarif_nama)',strtolower($this->komponentarif_nama),true);
		if(!empty($this->pendaftaran_id)){
			$criteria->addCondition('pendaftaran_id = '.$this->pendaftaran_id);
		}
		$criteria->compare('LOWER(no_pendaftaran)',strtolower($this->no_pendaftaran),true);
		if(!empty($this->pasien_id)){
			$criteria->addCondition('pasien_id = '.$this->pasien_id);
		}
		$criteria->compare('LOWER(no_rekam_medik)',strtolower($this->no_rekam_medik),true);
		$criteria->compare('LOWER(nama_pasien)',strtolower($this->nama_pasien),true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}