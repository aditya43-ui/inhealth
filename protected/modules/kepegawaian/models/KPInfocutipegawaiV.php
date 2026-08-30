<?php
/**
*       - digunakan untuk menyimpaan fungsi model dan memanggil view InfocutipegawaiV, yang digunakan hanya untuk modul kepegawaian saja
*       @author		M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
*       @website	<piindonesia.co.id>
*/

class KPInfocutipegawaiV extends InfocutipegawaiV
{	

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        
        public function searchInformasi(){          	
            $criteria=new CDbCriteria;
            $criteria->addBetweenCondition('DATE(t.tanggal_transaksi)', $this->tgl_awal, $this->tgl_akhir);
            $criteria->compare('LOWER(t.nama_pegawai)', strtolower($this->nama_pegawai),true);  
            if (!empty($this->jeniscuti_id)){
                $criteria->addCondition(" t.jeniscuti_id = '".$this->jeniscuti_id."' ");
            }

            if (!empty($this->ruangan_id)){
                $criteria->join = "join ("
                        . "select a.pegawai_id from ruanganpegawai_m a where a.ruangan_id = ".$this->ruangan_id.""
                        . " group by a.pegawai_id) r on r.pegawai_id = t.pegawai_id";
            }

            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
            ));
	
        }
}