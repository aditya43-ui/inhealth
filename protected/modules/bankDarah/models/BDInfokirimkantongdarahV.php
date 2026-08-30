<?php
/**
* Digunakan sebagai Model Extends
* @author  Elham Budianto <elhambudianto1@gmail.com>, 
* @author  Andyka Putra <andykaputra@.com>
* @package application.modules.bankDarah
* @subpackage models
**/
class BDInfokirimkantongdarahV extends InfokirimkantongdarahV
{
        /**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return KarcisV the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        /**
         * Digunakan sebagai pencarian data untuk halaman Informasi Pengiriman Kantong Darah
         * @return \CActiveDataProvider
         */
        public function searchInformasi(){          	
            $criteria = new CDbCriteria();
            $criteria->select = 'no_kirimkantong, ruangankirim_nama, tglkirimkantongdarah, suhu_kirim, petugaskirim_nama, isterima, kirimkantongdarah_id, ruangantujuan_id, ruangantujuan_nama';
            $criteria->group  = $criteria->select;
            
            $criteria->addBetweenCondition('DATE(tglkirimkantongdarah)', $this->tgl_awal, $this->tgl_akhir);
            $criteria->compare('LOWER(no_kirimkantong)',strtolower($this->no_kirimkantong),true);
            if (!empty($this->petugaskirim_id)){
                $criteria->addCondition(" petugaskirim_id = '".$this->petugaskirim_id."' ");
            } 
            if (!empty($this->ruangankirim_id)){
                $criteria->addCondition(" ruangankirim_id = '".$this->ruangankirim_id."' ");
            } 
            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
            ));
	
        }
        
        /**
         * Digunakan sebagai pencarian data untuk halaman Informasi Monitoring Suhu Coolbox
         * @return \CActiveDataProvider
         */
        public function searchInformasiMonitoring(){          	
            $criteria=new CDbCriteria;
                   
            $criteria->select = 'no_kirimkantong, ruangankirim_id, kirimkantongdarah_id, suhu_kirim, tglmonitoring';
            $criteria->group  = $criteria->select;
            $criteria->order  = 'tglmonitoring';
            
            $criteria->addBetweenCondition('DATE(tglmonitoring)', $this->tgl_awal, $this->tgl_akhir);

            if (!empty($this->kirimkantongdarah_id)){
                $criteria->addCondition(" kirimkantongdarah_id = '".$this->kirimkantongdarah_id."' ");
            } 
            if (!empty($this->ruangankirim_id)){
                $criteria->addCondition(" ruangankirim_id = '".$this->ruangankirim_id."' ");
            } 
            $criteria->compare('LOWER(no_kirimkantong)',strtolower($this->no_kirimkantong),true);
            
            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
            ));
	
        }
}