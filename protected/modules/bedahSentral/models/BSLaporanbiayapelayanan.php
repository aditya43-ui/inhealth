<?php

class BSLaporanbiayapelayanan extends LaporanbiayapelayananV{
    public $jns_periode,$tgl_awal,$tgl_akhir,$bln_awal,$bln_akhir,$thn_awal,$thn_akhir;
    public function searchTable() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria = $this->functionCriteria();

        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                ));
    }
    public function searchGrafik(){
        $criteria = new CDbCriteria;		
        $format = new MyFormatter();
		
		if ($_GET['tampilGrafik'] == 'kelaspelayanan'){
			$criteria->select = 'count(pendaftaran_id) as jumlah, kelaspelayanan_nama as data';
			$criteria->group = 'data';
		}elseif ($_GET['tampilGrafik'] == 'carabayar'){
			if (!empty($this->penjamin_nama)){
				$criteria->select = 'count(pendaftaran_id) as jumlah, penjamin_nama as data';
				$criteria->group = 'data';
			}else{
				$criteria->select = 'count(pendaftaran_id) as jumlah, carabayar_nama as data';
				$criteria->group = 'data';
			}
		}
		
       // $this->tgl_awal = $format->formatDateTimeForDb($this->tgl_awal);
      //  $this->tgl_akhir = $format->formatDateTimeForDb($this->tgl_akhir);
        $criteria->addBetweenCondition('DATE(tgl_pendaftaran)', $this->tgl_awal, $this->tgl_akhir);        
        if (!empty($this->penjamin_id)){
            $criteria->addCondition('penjamin_id ='.$this->penjamin_id);
        }else{
			if (!empty($this->carabayar_id)){
				$criteria->addCondition('carabayar_id ='.$this->carabayar_id);
			}
        }
        if (is_array($this->kelaspelayanan_id)){
            $criteria->addInCondition('kelaspelayanan_id', $this->kelaspelayanan_id);
        }else{
            //$criteria->addCondition('kelaspelayanan_id is null');
        }
        $criteria->addCondition('ruangan_id = '.Yii::app()->user->getState('ruangan_id'));
        
        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
        ));
    }
    
//    public function searchGrafik() {
//        // Warning: Please modify the following code to remove attributes that
//        // should not be searched.
//
//        $criteria = new CDbCriteria;
//        
//        $table1 = 'select kelaspelayanan_nama, pendaftaran_id, ruangan_id, penjamin_nama'; 
//            
//        $table2 = ' from laporanbiayapelayanan_v where ruangan_id = '.Yii::app()->user->getState('ruangan_id');
//            
//        $group = ' group by pendaftaran_id, kelaspelayanan_nama, ruangan_id, penjamin_nama';
//        $group2 = '';
//        if (is_array($this->penjamin_id)){
//            $table2 .=' and penjamin_id in ('.implode(',', $this->penjamin_id).')';
//            $group2 .= ', penjamin_id';
//        }else{
//            $table2 .= ' and penjamin_id is null';
//            $group2 .= ', penjamin_id';
//        }
//        if (is_array($this->kelaspelayanan_id)){
//            $table2 .= ' and kelaspelayanan_id in ('.implode(',',$this->kelaspelayanan_id).')';
//            $group2 .= ', kelaspelayanan_id';
//        }else{
//            $table2 .= ' and kelaspelayanan_id is null';
//            $group2 .= ', kelaspelayanan_id';
//        }
//        
//        $table = $table1.$group2.$table2.$group.$group2;
//        $sql = 'select count(*) as jumlah, kelaspelayanan_nama as data, penjamin_nama as tick from ('.$table.') x group by kelaspelayanan_nama, penjamin_nama';
//        
//        return new CSqlDataProvider($sql);
//
//    }
    public function searchPrint() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;
        
        $criteria = $this->functionCriteria();

        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                    'pagination'=>false,
                ));
    }
    
    protected function functionCriteria(){
        $criteria = new CDbCriteria();
        $format = new MyFormatter();
        $this->tgl_awal = $format->formatDateTimeForDb($this->tgl_awal);
        $this->tgl_akhir = $format->formatDateTimeForDb($this->tgl_akhir);
        $criteria->addBetweenCondition('DATE(tgl_pendaftaran)', $this->tgl_awal, $this->tgl_akhir);
        $criteria->select = 'pendaftaran_id, ruangan_id, tgl_pendaftaran, no_rekam_medik, nama_pasien, nama_bin, jeniskelamin, umur, no_pendaftaran, jeniskasuspenyakit_nama, kelaspelayanan_nama, kelaspelayanan_id, carabayar_nama, penjamin_nama, penjamin_id, carabayar_id, sum(tarif_tindakan) as total, sum(iurbiaya_tindakan) as iurbiaya';
        $criteria->group = 'pendaftaran_id, ruangan_id, tgl_pendaftaran, no_rekam_medik, nama_pasien, nama_bin, jeniskelamin, umur, no_pendaftaran, jeniskasuspenyakit_nama, kelaspelayanan_nama, kelaspelayanan_id, carabayar_nama, penjamin_nama, penjamin_id, carabayar_id';

        if (!empty($this->penjamin_id)){
            $criteria->addCondition('penjamin_id ='.$this->penjamin_id);
        }else{
			if (!empty($this->carabayar_id)){
				$criteria->addCondition('carabayar_id ='.$this->carabayar_id);
			}
        }
        if (is_array($this->kelaspelayanan_id)){
            $criteria->addInCondition('kelaspelayanan_id', $this->kelaspelayanan_id);
        }else{
            //$criteria->addCondition('kelaspelayanan_id is null');
        }
        $criteria->addCondition('ruangan_id = '.Yii::app()->user->getState('ruangan_id'));

        
        return $criteria;
    }
    
    public function getNamaModel(){
        return __CLASS__;
    }
}

?>
