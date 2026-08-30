<?php

class AKPembayaranpelayananT extends PembayaranpelayananT
{
        public $tgl_awal, $tgl_akhir;
        public $no_pendaftaran;
        public $nama_pasien;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return KursrpM the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        public function searchInformasi()
        {
            $criteria = new CDbCriteria();
            $criteria->join = " JOIN pendaftaran_t p ON p.pendaftaran_id = t.pendaftaran_id "
                            . " JOIN carabayar_m cb ON cb.carabayar_id = t.carabayar_id "
                            . " JOIN pasien_m pa ON pa.pasien_id = t.pasien_id ";
            $criteria->addBetweenCondition("t.tglpembayaran", $this->tgl_awal.' 00:00:00', $this->tgl_akhir.' 23:59:59');                       
            $criteria->compare("LOWER(p.no_pendaftaran)", strtolower($this->no_pendaftaran), TRUE);
            $criteria->compare("LOWER(pa.nama_pasien)", strtolower($this->nama_pasien), TRUE);
            $criteria->addCondition(" t.carabayar_id = '".Params::CARABAYAR_ID_MEMBAYAR."' ");
            $criteria->order = "t.tglpembayaran DESC";
            
            return new CActiveDataProvider($this, array(
                'criteria'=>$criteria,
            ));
        }

}

?>