<?php


class PIPasienPulangT  extends PasienpulangT
{
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return PasienpulangT the static model class
     */
    public static function model($className=__CLASS__)
    {
            return parent::model($className);
    }
        
    /**
    * Mengambil daftar semua carakeluar_m
    * @return CActiveDataProvider 
    */
    public function getCarakeluarItems()
    {
        return CarakeluarM::model()->findAllByAttributes(array('carakeluar_aktif'=>true),array('order'=>'carakeluar_nama'));
    }

    /**
    * Mengambil daftar semua kondisikeluar
    * @return CActiveDataProvider 
    */
    public function getKondisikeluarItems($carakeluar_id=null)
    {
         if(!empty($carakeluar_id))
               return KondisiKeluarM::model()->findAllByAttributes(array('carakeluar_id'=>$carakeluar_id,'kondisikeluar_aktif'=>true),array('order'=>'kondisikeluar_nama'));
        else
               return array();
    }
	
	
	
	/**
	 * kriteria pencarian untuk dashboard
	 * @return \CActiveDataProvider
	 */
	public function searchDashboardPI() {
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria = new CDbCriteria;
		$criteria->select = 't.tglpasienpulang,pasien_m.tgl_meninggal,pasien_m.no_rekam_medik,pendaftaran_t.no_pendaftaran, pasien_m.nama_pasien, pendaftaran_t.umur, pasien_m.jeniskelamin, ruangan_m.ruangan_nama';
		$criteria->join = 'JOIN pendaftaran_t ON pendaftaran_t.pendaftaran_id = t.pendaftaran_id';
		$criteria->join .= ' JOIN ruangan_m ON ruangan_m.ruangan_id= pendaftaran_t.ruangan_id';
		$criteria->join .= ' JOIN instalasi_m ON ruangan_m.instalasi_id=instalasi_m.instalasi_id';
		$criteria->join .= ' JOIN pasien_m ON pendaftaran_t.pasien_id = pasien_m.pasien_id';
		$criteria->join .= ' JOIN carakeluar_m ON t.carakeluar_id = carakeluar_m.carakeluar_id';
		$criteria->addCondition('t.pasienbatalpulang_id IS NULL');
		$criteria->addCondition('ruangan_m.instalasi_id = 4');
		$criteria->addCondition('carakeluar_m.carakeluar_id = 4 ');
		$criteria->addCondition("date(t.tglpasienpulang)= '" . date('Y-m-d') . "'");
		$criteria->order = 't.tglpasienpulang DESC';
		$criteria->limit = 10;
		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
			'pagination' => false
		));
	}

}