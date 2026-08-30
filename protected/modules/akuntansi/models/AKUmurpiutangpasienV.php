<?php

class AKUmurpiutangpasienV extends UmurpiutangpasienV
{
        public $tgl_awal, $tgl_akhir;
        public $sd_0_30;
        public $sd_31_60;
        public $sd_61_90;
        public $sd_91;
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
            $criteria->select = "pasien_id,tglpembayaran, nopembayaran, namadepan, nama_pasien, totalsisatagihan, lama_piutang, totaliurbiaya, "
                                . " (CASE WHEN (lama_piutang >= 0 AND  lama_piutang <= 30) THEN (CASE WHEN (totalsisatagihan != 0) THEN totalsisatagihan ELSE 0 END) ELSE 0 END) as sd_0_30, "
                                . " (CASE WHEN (lama_piutang >= 31 AND  lama_piutang <= 60) THEN (CASE WHEN (totalsisatagihan != 0) THEN totalsisatagihan ELSE 0 END) ELSE 0 END) as sd_31_60, "
                                . " (CASE WHEN (lama_piutang >= 61 AND  lama_piutang <= 90) THEN (CASE WHEN (totalsisatagihan != 0) THEN totalsisatagihan ELSE 0 END) ELSE 0 END) as sd_61_90, "
                                . " (CASE WHEN (lama_piutang >= 91) THEN (CASE WHEN (totalsisatagihan != 0) THEN totalsisatagihan ELSE 0 END) ELSE 0 END) as sd_91 ";
            $criteria->group = "pasien_id,tglpembayaran, nopembayaran, namadepan, nama_pasien, totalsisatagihan, lama_piutang, totaliurbiaya";
//            if (isset($_GET['filterTanggal'])){
                $criteria->addBetweenCondition("date(tglpembayaran)", $this->tgl_awal.' 00:00:00', $this->tgl_akhir.' 23:59:59');
//            }
            $criteria->compare("LOWER(nopembayaran)", strtolower($this->nopembayaran), TRUE);
            $criteria->compare("LOWER(pasien_id)", strtolower($this->nama_pasien), TRUE);
            $criteria->compare("LOWER(nama_pasien)", strtolower($this->nama_pasien), TRUE);
            $criteria->addCondition('totalsisatagihan > 0');
            $criteria->order = "tglpembayaran DESC";


            return new CActiveDataProvider($this, array(
                'criteria'=>$criteria,
            ));
        }

}

?>
