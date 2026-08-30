<?php

class LBLaporansensuslabV extends LaporansensuslabV {

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function searchGrafik() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria = $this->functionCriteria();
        
        if ($_GET['tampilGrafik'] == 'kunjungan'){
            $criteria->select = 'count(pendaftaran_id) as jumlah, kunjungan as data';
            $criteria->group = 'kunjungan';
        }elseif ($_GET['tampilGrafik'] == 'carabayar'){            
            $criteria->select = 'count(pendaftaran_id) as jumlah, carabayar_nama as data';
            $criteria->group = 'carabayar_nama';
        }elseif ($_GET['tampilGrafik'] == 'jenispemeriksaan'){            
            $criteria->select = 'count(pendaftaran_id) as jumlah, jenispemeriksaanlab_nama as data';
            $criteria->group = 'jenispemeriksaanlab_nama';
        }elseif ($_GET['tampilGrafik'] == 'pemeriksaan'){            
            $criteria->select = 'count(pendaftaran_id) as jumlah, pemeriksaanlab_nama as data';
            $criteria->group = 'pemeriksaanlab_nama';
        }elseif ($_GET['tampilGrafik'] == 'instalasiasal'){            
            $criteria->select = 'count(pendaftaran_id) as jumlah, instalasiasal_nama as data';
            $criteria->group = 'instalasiasal_nama';
        }elseif ($_GET['tampilGrafik'] == 'ruanganasal'){            
            $criteria->select = 'count(pendaftaran_id) as jumlah, ruanganasal_nama as data';
            $criteria->group = 'ruanganasal_nama';
        }
        
        /*
        if ($this->pilihan == 'carabayar'){
            if (!empty($this->penjamin_id)) {
                $criteria->select .= ', penjamin_nama as tick';
                $criteria->group .= ', penjamin_nama';
            } else if (!empty($this->carabayar_id)) {
                $criteria->select .= ', penjamin_nama as tick';
                $criteria->group .= ', penjamin_nama';
            } else {
                $criteria->select .= ', carabayar_nama as tick';
                $criteria->group .= ', carabayar_nama';
            }
        }
        else{
            $criteria->select .= ', jenispemeriksaanlab_nama as tick';
            $criteria->group .= ', jenispemeriksaanlab_nama';
        }
*/
        $criteria->order = "jumlah DESC";
        
        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                ));
    }

    public function searchTable() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria = $this->functionCriteria();
        $criteria->order = "tglmasukpenunjang ASC";

        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                ));
    }

    public function searchPrint() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria = $this->functionCriteria();
        $criteria->order = "tglmasukpenunjang ASC";
        
        return new CActiveDataProvider($this, array(
                    'pagination' => false,
                    'criteria' => $criteria,
                ));
    }

    protected function functionCriteria() {
        $criteria = new CDbCriteria();
        $format = new MyFormatter();
//        $criteria->select = 'no_rekam_medik, no_masukpenunjang, tglmasukpenunjang, rt, rw, instalasiasal_nama, carabayar_nama, penjamin_nama, no_pendaftaran, nama_pasien, nama_bin, jeniskelamin, alamat_pasien, umur, ruanganasal_nama, pendaftaran_id';
//        $criteria->group = 'no_rekam_medik, no_masukpenunjang, tglmasukpenunjang, rt, rw, instalasiasal_nama, carabayar_nama, penjamin_nama, no_pendaftaran, nama_pasien, nama_bin, jeniskelamin, alamat_pasien, umur, ruanganasal_nama, pendaftaran_id';
        
        if (!is_array($this->kunjungan)){
            $this->kunjungan = 0;
        }else{
            $data = array();
            foreach(  $this->kunjungan as $i => $values ){
                                
                if( $values == "KUNJUNGAN ULANG"){
                    $data[]="KUNJUNGAN LAMA";
                } else{
                    $data[]=$values;
                }
            }                                            
            $criteria->addInCondition('kunjungan', $data);
        }
        
        if ($this->pilihan == 'jenis'){
            if(!empty($this->jenispemeriksaanlab_id)){
                    $criteria->addCondition('jenispemeriksaanlab_id = '.$this->jenispemeriksaanlab_id);
            }
        }
        $this->tgl_awal = $format->formatDateTimeForDb($this->tgl_awal);
        $this->tgl_akhir = $format->formatDateTimeForDb($this->tgl_akhir);
        $criteria->addBetweenCondition('DATE(tglmasukpenunjang)', $this->tgl_awal, $this->tgl_akhir);
        $criteria->addCondition('ruanganpenunj_id = '.Yii::app()->user->getState('ruangan_id'));
        
		
        $criteria->compare('jenispemeriksaanlab_nama', $this->jenispemeriksaanlab_nama);
        if(!empty($this->pemeriksaanlab_id)){
                $criteria->addCondition('pemeriksaanlab_id = '.$this->pemeriksaanlab_id);
        }
        $criteria->compare('pemeriksaanlab_nama', $this->pemeriksaanlab_nama, true);
        if(!empty($this->penjamin_id)){
                $criteria->addInCondition('penjamin_id', $this->penjamin_id);
        }
        if(!empty($this->carabayar_id)){
                $criteria->addInCondition('carabayar_id', $this->carabayar_id);
        }
        
        if (!empty($this->instalasiasal_id)){
            $criteria->addInCondition("instalasiasal_id", $this->instalasiasal_id);
        }
        
        if (!empty($this->ruanganasal_id)){
            $criteria->addInCondition("ruanganasal_id",$this->ruanganasal_id);
        }
        
        return $criteria;
    }

        public function getNamaModel(){
            return __CLASS__;
        }
}

?>
