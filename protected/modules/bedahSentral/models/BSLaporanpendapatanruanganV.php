<?php

class BSLaporanpendapatanruanganV extends LaporanpendapatanruanganV {
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
    
    public function searchTable() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria = $this->functionCriteria();
        $criteria->select = 'sum(qty_tindakan) as qty_tindakan, tarif_satuan, daftartindakan_nama, daftartindakan_kode, daftartindakan_id, carabayar_id, carabayar_nama,penjamin_id,penjamin_nama';
        $criteria->group = 'daftartindakan_nama, daftartindakan_kode, daftartindakan_id, carabayar_id, carabayar_nama,penjamin_id, penjamin_nama, tarif_satuan';
        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                ));
    }

    public function searchGrafik() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;
        
        $criteria = $this->functionCriteria();

		if ($_GET['tampilGrafik'] == 'kelaspelayanan'){
			$criteria->select = 'count(pendaftaran_id) as jumlah, kelaspelayanan_nama as data';
			$criteria->group = 'data';
		}elseif ($_GET['tampilGrafik'] == 'carabayar'){
			if (!empty($this->penjamin_id)){
				$criteria->select = 'count(pendaftaran_id) as jumlah, penjamin_nama as data';
				$criteria->group = 'data';
			}else{
				$criteria->select = 'count(pendaftaran_id) as jumlah, carabayar_nama as data';
				$criteria->group = 'data';
			}
		}
        
		$criteria->order = 'jumlah DESC';
        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                ));
    }

    public function searchPrint() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria = $this->functionCriteria();
        $criteria->select = 'sum(qty_tindakan) as qty_tindakan, tarif_satuan, daftartindakan_nama, daftartindakan_kode, daftartindakan_id, carabayar_id, carabayar_nama,penjamin_id,penjamin_nama';
        $criteria->group = 'daftartindakan_nama, daftartindakan_kode, daftartindakan_id, carabayar_id, carabayar_nama,penjamin_id, penjamin_nama, tarif_satuan';
        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                    'pagination' => false,
                ));
    }
    
    public function functionCriteria(){
        $criteria = new CDbCriteria();
        
        if (!is_array($this->kelaspelayanan_id)){
            $this->kelaspelayanan_id = 0;
        }
        $this->tgl_awal = MyFormatter::formatDateTimeForDb($this->tgl_awal);
        $this->tgl_akhir = MyFormatter::formatDateTimeForDb($this->tgl_akhir);
        $criteria->addBetweenCondition('DATE(tgl_pendaftaran)', $this->tgl_awal, $this->tgl_akhir);
		if (!empty($this->penjamin_id)){
            $criteria->addCondition('penjamin_id ='.$this->penjamin_id);
        }else{
			if (!empty($this->carabayar_id)){
				$criteria->addCondition('carabayar_id ='.$this->carabayar_id);
			}
        }
        $criteria->compare('LOWER(kelaspelayanan_nama)', strtolower($this->kelaspelayanan_nama), true);
		if(!empty($this->instalasi_id)){
			$criteria->addCondition('instalasi_id = '.$this->instalasi_id);
		}
        $criteria->compare('LOWER(instalasi_nama)', strtolower($this->instalasi_nama), true);
        $criteria->addCondition('ruangan_id = '.Yii::app()->user->getState('ruangan_id'));
        $criteria->compare('LOWER(ruangan_nama)', strtolower($this->ruangan_nama), true);
		$criteria->compare('LOWER(nama_pegawai)', strtolower($this->nama_pegawai));
        $criteria->compare('LOWER(tgl_tindakan)', strtolower($this->tgl_tindakan), true);
		if(!empty($this->tipepaket_id)){
			$criteria->addCondition('tipepaket_id = '.$this->tipepaket_id);
		}
        $criteria->compare('LOWER(tipepaket_nama)', strtolower($this->tipepaket_nama), true);
        
        
        return $criteria;
    }

    public function getNamaModel() {
        return __CLASS__;
    }
}

?>
