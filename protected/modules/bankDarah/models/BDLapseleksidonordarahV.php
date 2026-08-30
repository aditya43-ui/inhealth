<?php
/**
 * Digunakan untuk mengekstend model LapseleksidonordarahV
 * @author  Andyka <andykaputra@.com>
 * @website	   <.com>
 * @package application.modules.bankDarah
 * @subpackage models
 */
class BDLapseleksidonordarahV extends LapseleksidonordarahV
{
        public $tgl_awal, $tgl_akhir, $jns_periode, $bln_awal, $bln_akhir, $thn_awal, $thn_akhir, $is_gagalseleksi, $pilihanx, $data, $jumlah, $status;

        public $donor_itd_ke;
	
        /**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return LapseleksidonordarahV the static model class
	 */
	public static function model($className=__CLASS__)
	{
            return parent::model($className);
	}
        
        /**
         * Fungsi pencarian pada tabel
         * @return \CActiveDataProvider
         */
	public function searchTable(){          	
            $criteria=new CDbCriteria;
            
            $criteria->addBetweenCondition('DATE(tglseleksidonor)', $this->tgl_awal, $this->tgl_akhir);
            //Lolos
            if ($this->status == 'Lolos') {
                $criteria->addCondition("status_pendonor = 'DITERIMA'");
                $criteria->addCondition('is_gagalseleksi IS FALSE');
            } else {
            //Gagal
                $criteria->addCondition("status_pendonor = 'DITOLAK'");
            }
            return new CActiveDataProvider($this, array(
                'criteria'=>$criteria,
            ));
	
        }
        
        /**
         * Kriteria pencarian
         * @return \CDbCriteria
         */
        protected function functionCriteria() {
            // Warning: Please modify the following code to remove attributes that
            // should not be searched.

            $criteria = new CDbCriteria;

            $criteria->addBetweenCondition('DATE(tglseleksidonor)', $this->tgl_awal, $this->tgl_akhir);
            if(!empty($this->pendonor_id)){
                $criteria->addCondition("pendonor_id = ".$this->pendonor_id); 			
            }
            //Lolos
            if ($this->status == 'Lolos') {
                $criteria->addCondition("status_pendonor = 'DITERIMA'");
                $criteria->addCondition('is_gagalseleksi IS FALSE');
            } else {
            //Gagal
                $criteria->addCondition("status_pendonor = 'DITOLAK'");
            }

            return $criteria;
        }
        
        /**
         * Pencarian grafik
         * @return \CActiveDataProvider
         */
        public function searchGrafik() {
        $criteria = new CDbCriteria();
        $criteria->select = "count(pendonor_id) as jumlah";

        //Lolos
        if ($this->status == 'Lolos') {
            $criteria->addBetweenCondition('DATE(tglseleksidonor)', $this->tgl_awal, $this->tgl_akhir);
            $criteria->select .= ", DATE(waktu_pendaftaran) as data ";
            $criteria->compare('LOWER(status_pendonor)',strtolower($this->status_pendonor),true);
            $criteria->addCondition("status_pendonor = 'DITERIMA'");
            $criteria->addCondition('is_gagalseleksi IS FALSE');
            $criteria->group .= " DATE(waktu_pendaftaran)";
        } else {
        //Gagal
            $criteria->addBetweenCondition('DATE(tglseleksidonor)', $this->tgl_awal, $this->tgl_akhir);
            $criteria->select .= ", DATE(waktu_pendaftaran) as data ";
            $criteria->compare('LOWER(status_pendonor)',strtolower($this->status_pendonor),true);
            $criteria->addCondition("status_pendonor = 'DITOLAK'");
            $criteria->group .= " DATE(waktu_pendaftaran)";
        }

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }
}