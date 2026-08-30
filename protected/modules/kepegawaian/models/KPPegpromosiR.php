<?php
/**
*       - digunakan sebagai model untuk memanggil fungsi - fungsi yang hanya untuk modul kepegawaian
*       @author		M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
*       @website	<piindonesia.co.id>
*/
class KPPegpromosiR extends PegpromosiR {

    
    public $nama_pegawai;
    public $jabatan_id;
    public $tgl_awal;
    public $tgl_akhir;
            

	public function searchInfo($pegawai = null)
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.
		$criteria=new CDbCriteria;
		if(!empty($pegawai)){
		$criteria->addCondition('pegawai_id = '.$pegawai);
		}
		if(!empty($this->pegmutasi_id)){
		$criteria->addCondition('pegmutasi_id = '.$this->pegmutasi_id);
		}
		$criteria->compare('LOWER(nomorsurat)',strtolower($this->nomorsurat),true);
		$criteria->compare('LOWER(jabatan_nama)',strtolower($this->jabatan_nama),true);
		$criteria->compare('LOWER(pangkat_nama)',strtolower($this->pangkat_nama),true);
		$criteria->compare('LOWER(unitkerja)',strtolower($this->unitkerja),true);
		$criteria->compare('LOWER(nosk)',strtolower($this->nosk),true);
		$criteria->compare('DATE(tglsk)',$this->tglsk);
		$criteria->compare('LOWER(tmtsk)',strtolower($this->tmtsk),true);
		$criteria->compare('LOWER(mengetahui_nama)',strtolower($this->mengetahui_nama),true);
		$criteria->compare('LOWER(pimpinan_nama)',strtolower($this->pimpinan_nama),true);
		$criteria->compare('LOWER(jabatan_baru)',strtolower($this->jabatan_baru),true);
		$criteria->compare('LOWER(unitkerja_baru)',strtolower($this->unitkerja_baru),true);
		$criteria->compare('LOWER(pangkat_baru)',strtolower($this->pangkat_baru),true);
		$criteria->order='pegmutasi_id';
		$criteria->limit=5; 
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        public function searchInformasi()
        {
            $criteria=new CDbCriteria;
            $criteria->join =    " JOIN pegawai_m p ON p.pegawai_id = t.pegawai_id ";  
            $criteria->addBetweenCondition('date(prom_tglsk)', $this->tgl_awal, $this->tgl_akhir);
            $criteria->compare('LOWER(t.prom_nosk)', strtolower($this->prom_nosk));
            $criteria->compare('LOWER(p.nama_pegawai)', strtolower($this->nama_pegawai), TRUE);
            if (!empty($this->jabatan_nama)){
                $criteria->addCondition("t.prom_jabatan_lama = '".$this->prom_jabatan_lama."' ");
            }
            
            if (!empty($this->jabatan_baru)){
                $criteria->addCondition("t.prom_jabatan_baru = '".$this->prom_jabatan_baru."' ");
            }
            
             if (!empty($this->unitkerja)){
                $criteria->addCondition("t.prom_unitkerja = '".$this->prom_unitkerja."' ");
            }
            
            if (!empty($this->unitkerja_baru)){
                $criteria->addCondition("t.prom_unitkerja_baru = '".$this->prom_unitkerja_baru."' ");
            }
            
            return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
        }

}

?>
