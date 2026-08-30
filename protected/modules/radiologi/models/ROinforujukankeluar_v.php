<?php
/**
 * - digunakan untuk meload data pada view inforujukankeluar_v, hanya untuk di modul radiologi
 * @author M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
 * @website <piindonesia.co.id>
 */
class ROinforujukankeluar_v extends InforujukankeluarV
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return AnamnesaT the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
	public function searchInformasi(){          	
		$criteria=new CDbCriteria;
		$criteria->addBetweenCondition('DATE(pemeriksaankeluar_tgl)', $this->tgl_awal, $this->tgl_akhir);
		$criteria->compare('LOWER(nama_pegawai)', strtolower($this->nama_pegawai),true);            
		$criteria->compare('LOWER(nama_pasien)', strtolower($this->nama_pasien),true);            
		$criteria->compare('LOWER(no_rekam_medik)', strtolower($this->no_rekam_medik),true);
		$criteria->compare('LOWER(no_pendaftaran)', strtolower($this->no_pendaftaran),true);
		if (!empty($this->labklinikrujukan_id)){
			$criteria->addCondition(" labklinikrujukan_id = '".$this->labklinikrujukan_id."' ");
		}

		return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
		));

	}
}