<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class KPResignT extends ResignT {

    
    public $nama_pegawai;
    public $jabatan_id;
    public $tgl_awal;
    public $tgl_akhir, $jabatan_nama, $jabatan_baru, $unitkerja, $unitkerja_baru, $unitkerja_id;
    
    
    public static function model($className = __CLASS__) {
        parent::model($className);
    }

	public function searchInfo($pegawai = null)
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.
		$criteria=new CDbCriteria;
		if(!empty($pegawai)){
		$criteria->addCondition('pegawai_id = '.$pegawai);
		}
		if(!empty($this->resign_id)){
		$criteria->addCondition('resign_id = '.$this->resign_id);
		}
		$criteria->compare('LOWER(noresign)',strtolower($this->noresign),true);
		$criteria->compare('LOWER(alasanresign)',strtolower($this->alasanresign),true);
		$criteria->compare('LOWER(jabatan_id)',strtolower($this->jabatan_id),true);
		$criteria->compare('LOWER(untikerja_id)',strtolower($this->untikerja_id),true);
		$criteria->compare('DATE(tglditerima)',$this->tglditerima);
		$criteria->compare('DATE(tglresign)',$this->tglresign);
		$criteria->compare('LOWER(lamakerja)',strtolower($this->lamakerja),true);
		$criteria->compare('LOWER(lampiran_surat)',strtolower($this->lampiran_surat),true);
		$criteria->limit=5; 
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        public function searchInformasi()
        {
            $criteria=new CDbCriteria;
            $criteria->join =    " JOIN pegawai_m p ON p.pegawai_id = t.pegawai_id ";  
            $criteria->addBetweenCondition('date(tglresign)', $this->tgl_awal, $this->tgl_akhir);
            $criteria->compare('LOWER(t.noresign)', strtolower($this->noresign));
            $criteria->compare('LOWER(p.nama_pegawai)', strtolower($this->nama_pegawai), TRUE);
            if (!empty($this->jabatan_nama)){
                $criteria->addCondition("t.jabatan_nama = '".$this->jabatan_nama."' ");
            }
            
             if (!empty($this->unitkerja)){
                $criteria->addCondition("t.unitkerja = '".$this->unitkerja."' ");
            }
            
            return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
        }
		
	public function jenisJabatan($jabatan_id){
		$modjenis= JabatanM::model()->findByPk($jabatan_id);
		if(!empty($modjenis)){
			return $modjenis->jabatan_nama;
		}
	}
	
	public function jenisUnit($unitkerja_id){
		$modjenis= UnitkerjaM::model()->findByPk($unitkerja_id);
		if(!empty($modjenis)){
			return $modjenis->namaunitkerja;
		}
	}
	
	public function Pegawai($pegawai_id){
		$modjenis= PegawaiM::model()->findByPk($pegawai_id);
		if(!empty($modjenis)){
			return $modjenis->nama_pegawai;
		}
	}

}

?>
