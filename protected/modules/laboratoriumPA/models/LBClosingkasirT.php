<?php

class LBClosingkasirT extends ClosingkasirT {

    public $no_pendaftaran,$nama_pasien,$jumlahuang,$total;
    
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function searchKasHarian(){
        
        $criteria=new CDbCriteria;

        $criteria->select = 't.closingkasir_id, rincianclosing_t.closingkasir_id,
                            sum(t.terimauangmuka) as terimauangmuka,
                            sum(rincianclosing_t.jumlahuang) as jumlahuang,
                            sum(t.piutang) as piutang, 
                            sum(t.terimauangpelayanan) as uangpelayanan,
                            sum(rincianclosing_t.jumlahuang + t.piutang) as total,
                            t.keterangan_closing, 
                            sum(t.totalsetoran) as totalsetoran, 
                            sum(t.totalpengeluaran) as totalpengeluaran';
        $criteria->group = 't.closingkasir_id, rincianclosing_t.closingkasir_id, t.keterangan_closing';
        $criteria->addBetweenCondition('t.tglclosingkasir',$this->tgl_awal, $this->tgl_akhir);
		if(!empty($this->closingkasir_id)){
			$criteria->addCondition('closingkasir_id = '.$this->closingkasir_id);
		}
		if(!empty($this->shift_id)){
			$criteria->addCondition('shift_id = '.$this->shift_id);
		}
		if(!empty($this->pegawai_id)){
			$criteria->addCondition('pegawai_id = '.$this->pegawai_id);
		}
		if(!empty($this->setorbank_id)){
			$criteria->addCondition('setorbank_id = '.$this->setorbank_id);
		}
        $criteria->compare('LOWER(closingdari)',strtolower($this->closingdari),true);
        $criteria->compare('LOWER(sampaidengan)',strtolower($this->sampaidengan),true);
        $criteria->compare('closingsaldoawal',$this->closingsaldoawal);
        $criteria->compare('terimauangmuka',$this->terimauangmuka);
        $criteria->compare('terimauangpelayanan',$this->terimauangpelayanan);
        $criteria->compare('totalpengeluaran',$this->totalpengeluaran);
        $criteria->compare('nilaiclosingtrans',$this->nilaiclosingtrans);
        $criteria->compare('totalsetoran',$this->totalsetoran);
        $criteria->compare('jmluanglogam',$this->jmluanglogam);
        $criteria->compare('jmluangkertas',$this->jmluangkertas);
        $criteria->compare('jmltransaksi',$this->jmltransaksi);
        $criteria->compare('piutang',$this->piutang);
        $criteria->compare('LOWER(keterangan_closing)',strtolower($this->keterangan_closing),true);
        $criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
        $criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
        $criteria->compare('LOWER(create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);
        $criteria->compare('LOWER(update_loginpemakai_id)',strtolower($this->update_loginpemakai_id),true);
        $criteria->compare('LOWER(create_ruangan)',strtolower($this->create_ruangan),true);
        $criteria->join ='LEFT JOIN rincianclosing_t ON rincianclosing_t.closingkasir_id = t.closingkasir_id LEFT JOIN tandabuktibayar_t 
                          ON tandabuktibayar_t.closingkasir_id = t.closingkasir_id';

        return new CActiveDataProvider($this, array(
                'criteria'=>$criteria,
        ));
        
    }
    
    public function searchPrintKasHarian(){
        
        $criteria=new CDbCriteria;

        $criteria->select = 't.closingkasir_id, rincianclosing_t.closingkasir_id,
                            sum(t.terimauangmuka) as terimauangmuka,
                            sum(rincianclosing_t.jumlahuang) as jumlahuang,
                            sum(t.piutang) as piutang, 
                            sum(t.terimauangpelayanan) as uangpelayanan,
                            sum(rincianclosing_t.jumlahuang + t.piutang) as total,
                            t.keterangan_closing, 
                            sum(t.totalsetoran) as totalsetoran, 
                            sum(t.totalpengeluaran) as totalpengeluaran';
        $criteria->group = 't.closingkasir_id, rincianclosing_t.closingkasir_id, t.keterangan_closing';
        $criteria->addBetweenCondition('t.tglclosingkasir',$this->tgl_awal, $this->tgl_akhir);
		if(!empty($this->closingkasir_id)){
			$criteria->addCondition('closingkasir_id = '.$this->closingkasir_id);
		}
		if(!empty($this->shift_id)){
			$criteria->addCondition('shift_id = '.$this->shift_id);
		}
		if(!empty($this->pegawai_id)){
			$criteria->addCondition('pegawai_id = '.$this->pegawai_id);
		}
		if(!empty($this->setorbank_id)){
			$criteria->addCondition('setorbank_id = '.$this->setorbank_id);
		}
        $criteria->compare('LOWER(closingdari)',strtolower($this->closingdari),true);
        $criteria->compare('LOWER(sampaidengan)',strtolower($this->sampaidengan),true);
        $criteria->compare('closingsaldoawal',$this->closingsaldoawal);
        $criteria->compare('terimauangmuka',$this->terimauangmuka);
        $criteria->compare('terimauangpelayanan',$this->terimauangpelayanan);
        $criteria->compare('totalpengeluaran',$this->totalpengeluaran);
        $criteria->compare('nilaiclosingtrans',$this->nilaiclosingtrans);
        $criteria->compare('totalsetoran',$this->totalsetoran);
        $criteria->compare('jmluanglogam',$this->jmluanglogam);
        $criteria->compare('jmluangkertas',$this->jmluangkertas);
        $criteria->compare('jmltransaksi',$this->jmltransaksi);
        $criteria->compare('piutang',$this->piutang);
        $criteria->compare('LOWER(keterangan_closing)',strtolower($this->keterangan_closing),true);
        $criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
        $criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
        $criteria->compare('LOWER(create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);
        $criteria->compare('LOWER(update_loginpemakai_id)',strtolower($this->update_loginpemakai_id),true);
        $criteria->compare('LOWER(create_ruangan)',strtolower($this->create_ruangan),true);
        $criteria->join ='LEFT JOIN rincianclosing_t ON rincianclosing_t.closingkasir_id = t.closingkasir_id LEFT JOIN tandabuktibayar_t 
                          ON tandabuktibayar_t.closingkasir_id = t.closingkasir_id';

        return new CActiveDataProvider($this, array(
                'criteria'=>$criteria,
                'pagination'=>false,
        ));
        
    }
    
    public function searchDetailKas(){
        
        $criteria=new CDbCriteria;

        $criteria->select = 't.closingkasir_id, rincianclosing_t.closingkasir_id,pendaftaran_t.pendaftaran_id, pasien_m.pasien_id, pendaftaran_t.no_pendaftaran, pasien_m.nama_pasien,
                            sum(t.terimauangmuka) as terimauangmuka,
                            sum(rincianclosing_t.jumlahuang) as jumlahuang,
                            sum(t.piutang) as piutang, 
                            sum(t.terimauangpelayanan) as uangpelayanan,
                            sum(rincianclosing_t.jumlahuang + t.piutang) as total,
                            t.keterangan_closing, 
                            sum(t.totalsetoran) as totalsetoran, 
                            sum(t.totalpengeluaran) as totalpengeluaran';
        $criteria->group = 't.closingkasir_id, rincianclosing_t.closingkasir_id, t.keterangan_closing,pendaftaran_t.pendaftaran_id, pendaftaran_t.no_pendaftaran, pasien_m.pasien_id, pasien_m.nama_pasien';
        $criteria->addBetweenCondition('t.tglclosingkasir',$this->tgl_awal, $this->tgl_akhir);
		if(!empty($this->closingkasir_id)){
			$criteria->addCondition('t.closingkasir_id = '.$this->closingkasir_id);
		}
		if(!empty($this->shift_id)){
			$criteria->addCondition('t.shift_id = '.$this->shift_id);
		}
		if(!empty($this->pegawai_id)){
			$criteria->addCondition('t.pegawai_id = '.$this->pegawai_id);
		}
		if(!empty($this->setorbank_id)){
			$criteria->addCondition('t.setorbank_id = '.$this->setorbank_id);
		}
        $criteria->compare('LOWER(t.tglclosingkasir)',strtolower($this->tglclosingkasir),true);
        $criteria->compare('LOWER(t.sampaidengan)',strtolower($this->sampaidengan),true);
        $criteria->compare('t.closingsaldoawal',$this->closingsaldoawal);
        $criteria->compare('t.terimauangmuka',$this->terimauangmuka);
        $criteria->compare('t.terimauangpelayanan',$this->terimauangpelayanan);
        $criteria->compare('t.totalpengeluaran',$this->totalpengeluaran);
        $criteria->compare('t.nilaiclosingtrans',$this->nilaiclosingtrans);
        $criteria->compare('t.totalsetoran',$this->totalsetoran);
        $criteria->compare('t.jmluanglogam',$this->jmluanglogam);
        $criteria->compare('t.jmluangkertas',$this->jmluangkertas);
        $criteria->compare('t.jmltransaksi',$this->jmltransaksi);
        $criteria->compare('t.piutang',$this->piutang);
        $criteria->compare('LOWER(t.keterangan_closing)',strtolower($this->keterangan_closing),true);
        $criteria->compare('LOWER(t.create_time)',strtolower($this->create_time),true);
        $criteria->compare('LOWER(t.update_time)',strtolower($this->update_time),true);
        $criteria->compare('LOWER(t.create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);
        $criteria->compare('LOWER(t.update_loginpemakai_id)',strtolower($this->update_loginpemakai_id),true);
        $criteria->compare('LOWER(t.create_ruangan)',strtolower($this->create_ruangan),true);
        
        $criteria->join ='LEFT JOIN rincianclosing_t ON rincianclosing_t.closingkasir_id = t.closingkasir_id LEFT JOIN tandabuktibayar_t 
                          ON tandabuktibayar_t.closingkasir_id = t.closingkasir_id LEFT JOIN pembayaranpelayanan_t ON 
                          pembayaranpelayanan_t.tandabuktibayar_id = tandabuktibayar_t.tandabuktibayar_id LEFT JOIN pendaftaran_t ON pendaftaran_t.pendaftaran_id = pembayaranpelayanan_t.pendaftaran_id
                          LEFT JOIN pasien_m ON pasien_m.pasien_id = pendaftaran_t.pasien_id';

        return new CActiveDataProvider($this, array(
                'criteria'=>$criteria,
        ));
        
    }
    
    public function searchPrintDetailKas(){
        
        $criteria=new CDbCriteria;

        $criteria->select = 't.closingkasir_id, rincianclosing_t.closingkasir_id,pendaftaran_t.pendaftaran_id, pasien_m.pasien_id, pendaftaran_t.no_pendaftaran, pasien_m.nama_pasien,
                            sum(t.terimauangmuka) as terimauangmuka,
                            sum(rincianclosing_t.jumlahuang) as jumlahuang,
                            sum(t.piutang) as piutang, 
                            sum(t.terimauangpelayanan) as uangpelayanan,
                            sum(rincianclosing_t.jumlahuang + t.piutang) as total,
                            t.keterangan_closing, 
                            sum(t.totalsetoran) as totalsetoran, 
                            sum(t.totalpengeluaran) as totalpengeluaran';
        $criteria->group = 't.closingkasir_id, rincianclosing_t.closingkasir_id, t.keterangan_closing,pendaftaran_t.pendaftaran_id, pendaftaran_t.no_pendaftaran, pasien_m.pasien_id, pasien_m.nama_pasien';
        $criteria->addBetweenCondition('t.tglclosingkasir',$this->tgl_awal, $this->tgl_akhir);
		if(!empty($this->closingkasir_id)){
			$criteria->addCondition('t.closingkasir_id = '.$this->closingkasir_id);
		}
		if(!empty($this->shift_id)){
			$criteria->addCondition('t.shift_id = '.$this->shift_id);
		}
		if(!empty($this->pegawai_id)){
			$criteria->addCondition('t.pegawai_id = '.$this->pegawai_id);
		}
		if(!empty($this->setorbank_id)){
			$criteria->addCondition('t.setorbank_id = '.$this->setorbank_id);
		}
        $criteria->compare('LOWER(t.tglclosingkasir)',strtolower($this->tglclosingkasir),true);
        $criteria->compare('LOWER(t.sampaidengan)',strtolower($this->sampaidengan),true);
        $criteria->compare('t.closingsaldoawal',$this->closingsaldoawal);
        $criteria->compare('t.terimauangmuka',$this->terimauangmuka);
        $criteria->compare('t.terimauangpelayanan',$this->terimauangpelayanan);
        $criteria->compare('t.totalpengeluaran',$this->totalpengeluaran);
        $criteria->compare('t.nilaiclosingtrans',$this->nilaiclosingtrans);
        $criteria->compare('t.totalsetoran',$this->totalsetoran);
        $criteria->compare('t.jmluanglogam',$this->jmluanglogam);
        $criteria->compare('t.jmluangkertas',$this->jmluangkertas);
        $criteria->compare('t.jmltransaksi',$this->jmltransaksi);
        $criteria->compare('t.piutang',$this->piutang);
        $criteria->compare('LOWER(t.keterangan_closing)',strtolower($this->keterangan_closing),true);
        $criteria->compare('LOWER(t.create_time)',strtolower($this->create_time),true);
        $criteria->compare('LOWER(t.update_time)',strtolower($this->update_time),true);
        $criteria->compare('LOWER(t.create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);
        $criteria->compare('LOWER(t.update_loginpemakai_id)',strtolower($this->update_loginpemakai_id),true);
        $criteria->compare('LOWER(t.create_ruangan)',strtolower($this->create_ruangan),true);
        
        $criteria->join ='LEFT JOIN rincianclosing_t ON rincianclosing_t.closingkasir_id = t.closingkasir_id LEFT JOIN tandabuktibayar_t 
                          ON tandabuktibayar_t.closingkasir_id = t.closingkasir_id LEFT JOIN pembayaranpelayanan_t ON 
                          pembayaranpelayanan_t.tandabuktibayar_id = tandabuktibayar_t.tandabuktibayar_id LEFT JOIN pendaftaran_t ON pendaftaran_t.pendaftaran_id = pembayaranpelayanan_t.pendaftaran_id
                          LEFT JOIN pasien_m ON pasien_m.pasien_id = pendaftaran_t.pasien_id';

        return new CActiveDataProvider($this, array(
                'criteria'=>$criteria,
        ));
        
    }
    
    public function getNamaModel() {
        return __CLASS__;
    }

}

?>
