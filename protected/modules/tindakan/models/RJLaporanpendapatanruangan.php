<?php

class RJLaporanpendapatanruangan extends LaporanpendapatanruanganV {

    public $jumlah;
    public $data;
    public $tick;
    public $tgl_awal;
    public $tgl_akhir;
    public $bln_awal;
    public $bln_akhir;
    public $thn_awal;
    public $thn_akhir;
    public $jns_periode;

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function searchTable() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria = $this->functionCriteria();

        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                ));
    }

    public function searchGrafik() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;
        
        $criteria = $this->functionCriteria();

        $criteria->select = 'count(t.pendaftaran_id) as jumlah, t.kelaspelayanan_nama as data';
        $criteria->group = 't.kelaspelayanan_nama';
        if (!empty($this->carabayar_id)) {
            $criteria->select .= ', t.penjamin_nama as tick';
            $criteria->group .= ', t.penjamin_nama';
        } else {
            $criteria->select .= ', t.carabayar_nama as tick';
            $criteria->group .= ', t.carabayar_nama';
        }

        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                ));
    }

    public function searchPrint() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria = $this->functionCriteria();

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
        
        $criteria->addBetweenCondition('date(t.tgl_pendaftaran)', $this->tgl_awal, $this->tgl_akhir);
		if(!empty($this->penjamin_id)){
			$criteria->addInCondition("t.penjamin_id",$this->penjamin_id);		
		}
        $criteria->compare('LOWER(t.penjamin_nama)', strtolower($this->penjamin_nama), true);
		if(!empty($this->carabayar_id)){
			$criteria->addInCondition("t.carabayar_id", $this->carabayar_id);		
		}
        $criteria->compare('LOWER(t.carabayar_nama)', strtolower($this->carabayar_nama), true);
		if(!empty($this->kelaspelayanan_id)){
			$criteria->addInCondition("t.kelaspelayanan_id",$this->kelaspelayanan_id);		
		}
        $criteria->compare('LOWER(t.kelaspelayanan_nama)', strtolower($this->kelaspelayanan_nama), true);
		if(!empty($this->instalasi_id)){
			$criteria->addCondition("t.instalasi_id = ".$this->instalasi_id);		
		}
        $criteria->compare('LOWER(t.instalasi_nama)', strtolower($this->instalasi_nama), true);
        $criteria->addCondition('t.ruangan_id = '.Yii::app()->user->getState('ruangan_id'));
        $criteria->compare('LOWER(t.ruangan_nama)', strtolower($this->ruangan_nama), true);
        $criteria->compare('LOWER(t.tgl_tindakan)', strtolower($this->tgl_tindakan), true);
		if(!empty($this->tipepaket_id)){
			$criteria->addCondition("t.tipepaket_id = ".$this->tipepaket_id);		
		}
        $criteria->compare('LOWER(t.tipepaket_nama)', strtolower($this->tipepaket_nama), true);
        if (is_array($this->nama_pegawai)) {
            # code...
            $criteria->addInCondition("t.nama_pegawai", $this->nama_pegawai);

        }
		//$criteria->compare('LOWER(t.nama_pegawai)', strtolower($this->nama_pegawai), true);
        
        return $criteria;
    }

    public function getNamaModel() {
        return __CLASS__;
    }

}