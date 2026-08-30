<?php

class BKClosingkasirT extends ClosingkasirT {

    public $no_pendaftaran,$nama_pasien,$jumlahuang,$total;
    public $jns_periode,$tgl_awal,$tgl_akhir,$bln_awal,$bln_akhir,$thn_awal,$thn_akhir;
    
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function searchKasHarian(){
        
        $criteria=new CDbCriteria;

        $criteria->select = 't.closingkasir_id, rincianclosing_t.closingkasir_id,t.shift_id,t.pegawai_id,
                            sum(t.terimauangmuka) as terimauangmuka,
                            sum(rincianclosing_t.jumlahuang) as jumlahuang,
                            sum(t.piutang) as piutang, 
                            sum(t.terimauangpelayanan) as uangpelayanan,
                            sum(rincianclosing_t.jumlahuang + t.piutang) as total,
                            t.keterangan_closing, 
                            sum(t.totalsetoran) as totalsetoran, 
                            sum(t.totalpengeluaran) as totalpengeluaran,t.create_ruangan';
        $criteria->group = 't.shift_id,t.pegawai_id,t.closingkasir_id, rincianclosing_t.closingkasir_id, t.keterangan_closing,t.create_ruangan';
        $criteria->addBetweenCondition('date(t.tglclosingkasir)',$this->tgl_awal, $this->tgl_akhir);
		if(!empty($this->closingkasir_id)){
			$criteria->addCondition('closingkasir_id = '.$this->closingkasir_id);
		}
		if(!empty($this->shift_id)){
                    if (is_array($this->shift_id)){
                        $criteria->addInCondition('t.shift_id',$this->shift_id);
                    }else{
			$criteria->addCondition('t.shift_id = '.$this->shift_id);
                    }
		}
		if(!empty($this->pegawai_id)){
                    if (is_array($this->pegawai_id)){
			$criteria->addInCondition('t.pegawai_id',$this->pegawai_id);
                    }else{
                        $criteria->addCondition('t.pegawai_id = '.$this->pegawai_id);
                    }
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
        $criteria->compare('t.create_ruangan',Yii::app()->user->getState('ruangan_id'));
        
        $criteria->join ='LEFT JOIN rincianclosing_t ON rincianclosing_t.closingkasir_id = t.closingkasir_id LEFT JOIN tandabuktibayar_t 
                          ON tandabuktibayar_t.closingkasir_id = t.closingkasir_id';

        return new CActiveDataProvider($this, array(
                'criteria'=>$criteria,
        ));
        
    }
    
    public function searchPrintKasHarian(){
        
        $criteria=new CDbCriteria;

        $criteria->select = 't.shift_id,t.pegawai_id,t.closingkasir_id, rincianclosing_t.closingkasir_id,
                            sum(t.terimauangmuka) as terimauangmuka,
                            sum(rincianclosing_t.jumlahuang) as jumlahuang,
                            sum(t.piutang) as piutang, 
                            sum(t.terimauangpelayanan) as uangpelayanan,
                            sum(rincianclosing_t.jumlahuang + t.piutang) as total,
                            t.keterangan_closing, 
                            sum(t.totalsetoran) as totalsetoran, 
                            sum(t.totalpengeluaran) as totalpengeluaran,t.create_ruangan';
        
        $criteria->group = 't.shift_id,t.pegawai_id,t.closingkasir_id, rincianclosing_t.closingkasir_id, t.keterangan_closing,t.create_ruangan';
        $criteria->addBetweenCondition('date(t.tglclosingkasir)',$this->tgl_awal, $this->tgl_akhir);
		if(!empty($this->closingkasir_id)){
			$criteria->addCondition('closingkasir_id = '.$this->closingkasir_id);
		}
		if(!empty($this->shift_id)){
                    if (is_array($this->shift_id)){
                        $criteria->addInCondition('t.shift_id',$this->shift_id);
                    }else{
			$criteria->addCondition('t.shift_id = '.$this->shift_id);
                    }
		}
		if(!empty($this->pegawai_id)){
                    if (is_array($this->pegawai_id)){
			$criteria->addInCondition('t.pegawai_id',$this->pegawai_id);
                    }else{
                        $criteria->addCondition('t.pegawai_id = '.$this->pegawai_id);
                    }
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
        $criteria->compare('t.create_ruangan',Yii::app()->user->getState('ruangan_id'));
        
        $criteria->join ='LEFT JOIN rincianclosing_t ON rincianclosing_t.closingkasir_id = t.closingkasir_id LEFT JOIN tandabuktibayar_t 
                          ON tandabuktibayar_t.closingkasir_id = t.closingkasir_id';

        return new CActiveDataProvider($this, array(
                'criteria'=>$criteria,
                'pagination'=>false,
        ));
        
    }
    
    public function searchDetailKas(){
        
        $criteria=new CDbCriteria;

        $criteria->select = 't.shift_id,t.pegawai_id,t.closingkasir_id, rincianclosing_t.closingkasir_id,pendaftaran_t.pendaftaran_id, pasien_m.pasien_id, pendaftaran_t.no_pendaftaran, pasien_m.nama_pasien,
                            sum(t.terimauangmuka) as terimauangmuka,
                            sum(rincianclosing_t.jumlahuang) as jumlahuang,
                            sum(t.piutang) as piutang, 
                            sum(t.terimauangpelayanan) as uangpelayanan,
                            sum(rincianclosing_t.jumlahuang + t.piutang) as total,
                            t.keterangan_closing, 
                            sum(t.totalsetoran) as totalsetoran, 
                            sum(t.totalpengeluaran) as totalpengeluaran,t.create_ruangan';
        $criteria->group = 't.shift_id,t.pegawai_id,t.closingkasir_id, t.create_ruangan, rincianclosing_t.closingkasir_id, t.keterangan_closing,pendaftaran_t.pendaftaran_id, pendaftaran_t.no_pendaftaran, pasien_m.pasien_id, pasien_m.nama_pasien';
        $criteria->addBetweenCondition('date(t.tglclosingkasir)',$this->tgl_awal, $this->tgl_akhir);
		if(!empty($this->closingkasir_id)){
			$criteria->addCondition('t.closingkasir_id = '.$this->closingkasir_id);
		}
		if(!empty($this->shift_id)){
                    if (is_array($this->shift_id)){
                        $criteria->addInCondition('t.shift_id',$this->shift_id);
                    }else{
			$criteria->addCondition('t.shift_id = '.$this->shift_id);
                    }
		}
		if(!empty($this->pegawai_id)){
                    if (is_array($this->pegawai_id)){
			$criteria->addInCondition('t.pegawai_id',$this->pegawai_id);
                    }else{
                        $criteria->addCondition('t.pegawai_id = '.$this->pegawai_id);
                    }
		}
		if(!empty($this->setorbank_id)){
			$criteria->addCondition('t.setorbank_id = '.$this->setorbank_id);
		}
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
        $criteria->compare('t.create_ruangan',Yii::app()->user->getState('ruangan_id'));
        
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

        $criteria->select = 't.shift_id,t.pegawai_id,t.closingkasir_id, rincianclosing_t.closingkasir_id,pendaftaran_t.pendaftaran_id, pasien_m.pasien_id, pendaftaran_t.no_pendaftaran, pasien_m.nama_pasien,
                            sum(t.terimauangmuka) as terimauangmuka,
                            sum(rincianclosing_t.jumlahuang) as jumlahuang,
                            sum(t.piutang) as piutang, 
                            sum(t.terimauangpelayanan) as uangpelayanan,
                            sum(rincianclosing_t.jumlahuang + t.piutang) as total,
                            t.keterangan_closing, 
                            sum(t.totalsetoran) as totalsetoran, 
                            sum(t.totalpengeluaran) as totalpengeluaran,t.create_ruangan';
        $criteria->group = 't.shift_id,t.pegawai_id,t.closingkasir_id, t.create_ruangan, rincianclosing_t.closingkasir_id, t.keterangan_closing,pendaftaran_t.pendaftaran_id, pendaftaran_t.no_pendaftaran, pasien_m.pasien_id, pasien_m.nama_pasien';
        $criteria->addBetweenCondition('date(t.tglclosingkasir)',$this->tgl_awal, $this->tgl_akhir);
		if(!empty($this->closingkasir_id)){
			$criteria->addCondition('t.closingkasir_id = '.$this->closingkasir_id);
		}
		if(!empty($this->shift_id)){
                    if (is_array($this->shift_id)){
                        $criteria->addInCondition('t.shift_id',$this->shift_id);
                    }else{
			$criteria->addCondition('t.shift_id = '.$this->shift_id);
                    }
		}
		if(!empty($this->pegawai_id)){
                    if (is_array($this->pegawai_id)){
			$criteria->addInCondition('t.pegawai_id',$this->pegawai_id);
                    }else{
                        $criteria->addCondition('t.pegawai_id = '.$this->pegawai_id);
                    }
		}
		if(!empty($this->setorbank_id)){
			$criteria->addCondition('t.setorbank_id = '.$this->setorbank_id);
		}
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
        $criteria->compare('t.create_ruangan',Yii::app()->user->getState('ruangan_id'));
        
        $criteria->join ='LEFT JOIN rincianclosing_t ON rincianclosing_t.closingkasir_id = t.closingkasir_id LEFT JOIN tandabuktibayar_t 
                          ON tandabuktibayar_t.closingkasir_id = t.closingkasir_id LEFT JOIN pembayaranpelayanan_t ON 
                          pembayaranpelayanan_t.tandabuktibayar_id = tandabuktibayar_t.tandabuktibayar_id LEFT JOIN pendaftaran_t ON pendaftaran_t.pendaftaran_id = pembayaranpelayanan_t.pendaftaran_id
                          LEFT JOIN pasien_m ON pasien_m.pasien_id = pendaftaran_t.pasien_id';

        return new CActiveDataProvider($this, array(
                'criteria'=>$criteria,
        ));
        
    }
	
	public function searchSetoran()
	{
		$prov = $this->search();
		$prov->criteria->join = 'left join setorankasir_t s on s.closingkasir_id = t.closingkasir_id';
		$prov->criteria->addCondition('s.setorankasir_id is null');
		$prov->sort->defaultOrder = 't.tglclosingkasir desc';
		return $prov;
	}

    public function getTotal($nama_field){
        $criteria=new CDbCriteria;
        if($nama_field=='terimauangmuka'){$criteria->select = 'sum(t.terimauangmuka) as total';}
        elseif($nama_field=='jumlahuang'){$criteria->select = 'sum(rincianclosing_t.jumlahuang) as total';}
        elseif($nama_field=='piutang'){$criteria->select = 'sum(t.piutang) as total';}
        elseif($nama_field=='uangpelayanan'){$criteria->select = 'sum(t.terimauangpelayanan) as total';}
        elseif($nama_field=='total'){$criteria->select = 'sum(rincianclosing_t.jumlahuang + t.piutang) as total';}
        elseif($nama_field=='totalsetoran'){$criteria->select = 'sum(t.totalsetoran) as total';}
        elseif($nama_field=='totalpengeluaran'){$criteria->select = 'sum(t.totalpengeluaran) as total';}

    

        $criteria->addBetweenCondition('date(t.tglclosingkasir)',$this->tgl_awal, $this->tgl_akhir);
		if(!empty($this->shift_id)){
                    if (is_array($this->shift_id)){
                        $criteria->addInCondition('t.shift_id',$this->shift_id);
                    }else{
			$criteria->addCondition('t.shift_id = '.$this->shift_id);
                    }
		}
		if(!empty($this->pegawai_id)){
                    if (is_array($this->pegawai_id)){
			$criteria->addInCondition('t.pegawai_id',$this->pegawai_id);
                    }else{
                        $criteria->addCondition('t.pegawai_id = '.$this->pegawai_id);
                    }
		}
		if(!empty($this->setorbank_id)){
			$criteria->addCondition('t.setorbank_id = '.$this->setorbank_id);
		}
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
        $criteria->compare('t.create_ruangan',Yii::app()->user->getState('ruangan_id'));
        
        $criteria->join ='LEFT JOIN rincianclosing_t ON rincianclosing_t.closingkasir_id = t.closingkasir_id LEFT JOIN tandabuktibayar_t 
                          ON tandabuktibayar_t.closingkasir_id = t.closingkasir_id LEFT JOIN pembayaranpelayanan_t ON 
                          pembayaranpelayanan_t.tandabuktibayar_id = tandabuktibayar_t.tandabuktibayar_id LEFT JOIN pendaftaran_t ON pendaftaran_t.pendaftaran_id = pembayaranpelayanan_t.pendaftaran_id
                          LEFT JOIN pasien_m ON pasien_m.pasien_id = pendaftaran_t.pasien_id';

        $jumlah = BKClosingkasirT::model()->find($criteria)->total;
        
        if (empty($jumlah)){
                $jumlah = 0;
            }
            return $jumlah;
        }
    
    public function getNamaModel() {
        return __CLASS__;
    }

    public function getShiftItems(){
		$mod = [];
		$modShiftpeg = ShiftpegawaiM::model()->findAllByAttributes(['pegawai_id'=>Yii::app()->user->getState('pegawai_id')]);
		foreach ($modShiftpeg as $key => $value) {
			$modShift = ShiftM::model()->findByPk($value->shift_id);
			$mod[]=$modShift;
		}
        return $mod;
	}

}

?>
