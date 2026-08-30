<?php

class BKLaporanpenerimaankasirV extends LaporanpenerimaankasirV {

    public $tgl_awal,$tgl_akhir;
    
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function searchGrafik() {

        $criteria = new CDbCriteria;

        $criteria = $this->functionCriteria();
        
        $criteria->select = 'sum(t.uangditerima) as jumlah, ruangan_nama as data';
        $criteria->group = 'data';

        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                ));
    }
    
    public function searchTable() {

        $criteria = new CDbCriteria;

        $criteria = $this->functionCriteria();

        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                ));
    }
    
    public function searchPrint() {

        $criteria = new CDbCriteria;

        $criteria = $this->functionCriteria();

        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                    'pagination'=>false,
                ));
    }

    protected function functionCriteria() {
        $criteria = new CDbCriteria();
        $criteria->join = " JOIN tandabuktibayar_t tbb ON tbb.tandabuktibayar_id = t.tandabuktibayar_id "
                        . " JOIN loginpemakai_k lp ON  lp.loginpemakai_id = tbb.create_loginpemakai_id";

        if (!is_array($this->ruangan_id)){
            $this->ruangan_id = 0;
        }
        
        if (!empty($this->pegawai_id)){
            if (is_array($this->pegawai_id)){
                $criteria->addInCondition(" lp.pegawai_id  ",$this->pegawai_id);
            }else{
                $criteria->addCondition(" lp.pegawai_id = '".$this->pegawai_id."' ");
            }
        }
        
        $criteria->addBetweenCondition('DATE(t.tglbuktibayar)', $this->tgl_awal, $this->tgl_akhir);
		if(!empty($this->ruangan_id)){
			$criteria->addInCondition('t.ruangan_id ',$this->ruangan_id);
		}
        $criteria->compare('LOWER(ruangan_nama)', strtolower($this->ruangan_nama), true);
		if(!empty($this->shift_id)){
			$criteria->addInCondition('t.shift_id', $this->shift_id);
		}
        $criteria->compare('LOWER(shift_nama)', strtolower($this->shift_nama), true);

        return $criteria;
    }

}