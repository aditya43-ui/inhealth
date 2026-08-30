<?php

class GZKirimmenudietT extends KirimmenudietT {

    public $instalasi_id;
    public $ruangan_id;
    public $tgl_awal;
    public $tgl_akhir;
    public $pesan_menu;
    public $namaPasien;
    
//    public $jenispesanmenu;

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function getNamaModel() {
        return __CLASS__;
    }

    public function searchInformasi() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;
        $criteria->join = "LEFT JOIN pesanmenudiet_t ON t.pesanmenudiet_id = pesanmenudiet_t.pesanmenudiet_id 
                            LEFT JOIN ruangan_m ON pesanmenudiet_t.ruangan_id = ruangan_m.ruangan_id  ";			    
        $criteria->addBetweenCondition('DATE(t.tglkirimmenu)', $this->tgl_awal, $this->tgl_akhir);
        $criteria->compare('t.kirimmenudiet_id', $this->kirimmenudiet_id);
        $criteria->compare('t.bahandiet_id', $this->bahandiet_id);
        $criteria->compare('t.jenisdiet_id', $this->jenisdiet_id);
        $criteria->compare('t.pesanmenudiet_id', $this->pesanmenudiet_id);
        $criteria->compare('LOWER(t.nokirimmenu)', strtolower($this->nokirimmenu), true);
        $criteria->compare('LOWER(t.jenispesanmenu)',strtolower($this->jenispesanmenu),true);
//        $criteria->compare('LOWER(tglkirimmenu)', strtolower($this->tglkirimmenu), true);
        $criteria->compare('LOWER(t.keterangan_kirim)', strtolower($this->keterangan_kirim), true);
        $criteria->compare('LOWER(t.create_time)', strtolower($this->create_time), true);
        $criteria->compare('LOWER(t.update_time)', strtolower($this->update_time), true);
        $criteria->compare('t.create_loginpemakai_id', $this->create_loginpemakai_id);
        $criteria->compare('LOWER(t.update_loginpemakai_id)', strtolower($this->update_loginpemakai_id), true);
        $criteria->compare('LOWER(t.create_ruangan)', strtolower($this->create_ruangan), true);
        $criteria->compare('pesanmenudiet_t.ruangan_id', $this->ruangan_id);
        //$criteria->compare('ruangan_m.instalasi_id', $this->instalasi_id);
        $criteria->compare('LOWER(pesanmenudiet_t.nopesanmenu)', strtolower($this->pesan_menu), true);
        // $criteria->with yg dibawah untuk menghasilkan relasi dari tabel master transaksi ke detail transaksinya .
        //$criteria->with = array('kirimmenupasien','kirimmenupegawai','pesanmenudiet');
        $criteria->order='t.tglkirimmenu DESC';

        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                ));
    }
    
    /**
     * menampilkan instalasi untuk kirim menu diet pasien
     * @return array
     */
    public function getInstalasiItems(){
        $criteria = new CDbCriteria();
        $criteria->addInCondition('instalasi_id',array(
                    Params::INSTALASI_ID_RJ, 
                    Params::INSTALASI_ID_RD, 
                    Params::INSTALASI_ID_RI,
                    Params::INSTALASI_ID_PERAWATAN_INTENSIF) 
                );
        $criteria->addCondition('instalasi_aktif = true');
        $modInstalasis = InstalasiM::model()->findAll($criteria);
        if(count((array)$modInstalasis) > 0)
            return $modInstalasis;
        else
            return array();
    }

}