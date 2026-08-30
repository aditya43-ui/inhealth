<?php
/**
*       - digunakan untuk menyimpaan fungsi model dan memanggil view InfopenilaianpegawaiV, yang digunakan hanya untuk modul kepegawaian saja
*       @author		M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
*       @website	<piindonesia.co.id>
*/

class KPInfopenilaianpegawaiV extends InfopenilaianpegawaiV
{	

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        
        public function searchInformasi(){          	
            $criteria=new CDbCriteria;
			$criteria->select = "jumlahpenilaian, nilairatapenilaian, penilaianpegawai_id,nama_pegawai, gelardepan, gelarbelakang_nama, penilainama, tglpenilaian, sampaidengan, periodepenilaian, jabatan_nama, namaunitkerja, kategoripegawai, pimpinannama, tanggal_approvepenilai,tanggal_approvepemimpin ";
            $criteria->addBetweenCondition('DATE(tglpenilaian)', $this->tgl_awal, $this->tgl_akhir);
            $criteria->compare('LOWER(nama_pegawai)', strtolower($this->nama_pegawai),true);            
            if (!empty($this->jabatan_id)){
                $criteria->addCondition(" jabatan_id = '".$this->jabatan_id."' ");
            }
            
            if (!empty($this->unitkerja_id)){
                $criteria->addCondition(" unitkerja_id = '".$this->unitkerja_id."' ");
            }
			
			if (!empty($this->kategoripegawai)){
                $criteria->addCondition(" kategoripegawai = '".$this->kategoripegawai."' ");
            }
			$criteria->group = $criteria->select;
            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
            ));
	
        }
}