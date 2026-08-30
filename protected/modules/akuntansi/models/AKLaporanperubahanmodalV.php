<?php
class AKLaporanperubahanmodalV extends LaporanperubahanmodalV
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return LaporanperubahanmodalV the static model class
	 */
	public $tgl_awal, $tgl_akhir, $ruangan_id;
        public $deskripsiperiodeposting;

	public static function model($className=__CLASS__)
	{
			return parent::model($className);
	}
        
	public function searchLaporan()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		if(!empty($this->rekperiod_id)){
			$criteria->addCondition('rekperiod_id = '.$this->rekperiod_id);
		}
		$criteria->compare('LOWER(perideawal)',strtolower($this->perideawal),true);
		$criteria->compare('LOWER(sampaidgn)',strtolower($this->sampaidgn),true);
		$criteria->compare('LOWER(deskripsi)',strtolower($this->deskripsi),true);
		$criteria->compare('isclosing',$this->isclosing);
		if(!empty($this->konfiganggaran_id)){
			$criteria->addCondition('konfiganggaran_id = '.$this->konfiganggaran_id);
		}
		$criteria->compare('LOWER(deskripsiperiode)',strtolower($this->deskripsiperiode),true);
		$criteria->compare('LOWER(tglanggaran)',strtolower($this->tglanggaran),true);
		$criteria->compare('LOWER(sd_tglanggaran)',strtolower($this->sd_tglanggaran),true);
		$criteria->compare('LOWER(tglrencanaanggaran)',strtolower($this->tglrencanaanggaran),true);
		$criteria->compare('LOWER(sd_tglrencanaanggaran)',strtolower($this->sd_tglrencanaanggaran),true);
		$criteria->compare('LOWER(tglrevisianggaran)',strtolower($this->tglrevisianggaran),true);
		$criteria->compare('LOWER(sd_tglrevisianggaran)',strtolower($this->sd_tglrevisianggaran),true);
		$criteria->compare('isclosing_anggaran',$this->isclosing_anggaran);
		$criteria->compare('LOWER(digitnilaianggaran)',strtolower($this->digitnilaianggaran),true);
		if(!empty($this->periodeposting_id)){
			$criteria->addCondition('periodeposting_id = '.$this->periodeposting_id);
		}
		$criteria->compare('LOWER(periodeposting_nama)',strtolower($this->periodeposting_nama),true);
		$criteria->compare('LOWER(tglperiodeposting_awal)',strtolower($this->tglperiodeposting_awal),true);
		$criteria->compare('LOWER(tglperiodeposting_akhir)',strtolower($this->tglperiodeposting_akhir),true);
		$criteria->compare('LOWER(deskripsiperiodeposting)',strtolower($this->deskripsiperiodeposting),true);
		if(!empty($this->laporanperubahanmodal_id)){
			$criteria->addCondition('laporanperubahanmodal_id = '.$this->laporanperubahanmodal_id);
		}
		if(!empty($this->laporanperubahanmodaldetail_id)){
			$criteria->addCondition('laporanperubahanmodaldetail_id = '.$this->laporanperubahanmodaldetail_id);
		}
		if(!empty($this->rekening1_id)){
			$criteria->addCondition('rekening1_id = '.$this->rekening1_id);
		}
		$criteria->compare('LOWER(kdrekening1)',strtolower($this->kdrekening1),true);
		$criteria->compare('LOWER(nmrekening1)',strtolower($this->nmrekening1),true);
		if(!empty($this->rekening2_id)){
			$criteria->addCondition('rekening2_id = '.$this->rekening2_id);
		}
		$criteria->compare('LOWER(kdrekening2)',strtolower($this->kdrekening2),true);
		$criteria->compare('LOWER(nmrekening2)',strtolower($this->nmrekening2),true);
		if(!empty($this->rekening3_id)){
			$criteria->addCondition('rekening3_id = '.$this->rekening3_id);
		}
		$criteria->compare('LOWER(kdrekening3)',strtolower($this->kdrekening3),true);
		$criteria->compare('LOWER(nmrekening3)',strtolower($this->nmrekening3),true);
		if(!empty($this->rekening4_id)){
			$criteria->addCondition('rekening4_id = '.$this->rekening4_id);
		}
		$criteria->compare('LOWER(kdrekening4)',strtolower($this->kdrekening4),true);
		$criteria->compare('LOWER(nmrekening4)',strtolower($this->nmrekening4),true);
		if(!empty($this->rekening5_id)){
			$criteria->addCondition('rekening5_id = '.$this->rekening5_id);
		}
		$criteria->compare('LOWER(kdrekening5)',strtolower($this->kdrekening5),true);
		$criteria->compare('LOWER(nmrekening5)',strtolower($this->nmrekening5),true);
		$criteria->compare('saldodebit',$this->saldodebit);
		$criteria->compare('saldokredit',$this->saldokredit);
		$criteria->compare('saldoakhirberjalan',$this->saldoakhirberjalan);
		if(!empty($this->bukubesar_id)){
			$criteria->addCondition('bukubesar_id = '.$this->bukubesar_id);
		}
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
		if(!empty($this->create_loginpemakai_id)){
			$criteria->addCondition('create_loginpemakai_id = '.$this->create_loginpemakai_id);
		}
		if(!empty($this->update_loginpemakai_id)){
			$criteria->addCondition('update_loginpemakai_id = '.$this->update_loginpemakai_id);
		}
		if(!empty($this->create_ruangan)){
			$criteria->addCondition('create_ruangan = '.$this->create_ruangan);
		}
		
		$criteria->limit=10;

		return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
		));
	}
	
	public function getPerRuang($ruangId=null,$modalAwal=FALSE)
	{
		if($modalAwal===TRUE){
			$criteriaPerRuang=new CDbCriteria;
			$criteriaPerRuang->group = "ruangan_id, rekening1_id";
			$criteriaPerRuang->select = "ruangan_id, sum(saldo) as saldo,  rekening1_id";
			$criteriaPerRuang->compare('ruangan_id',$ruangId);
			$conditionPerRuang = "nmrekening3 not like '%%Pembagian Deviden%%'";
			$criteriaPerRuang->addCondition($conditionPerRuang);
			$criteriaPerRuang->compare('LOWER(perideawal)',strtolower($periode['tgl_awal']),true);
			$criteriaPerRuang->compare('LOWER(sampaidgn)',strtolower($periode['tgl_akhir']),true);
			$dataPerRuang = LaporanperubahanmodalV::model()->findAll($criteriaPerRuang);
			$saldo_a = 0; $saldokredit_a = 0;
			$saldo_b = 0; $saldokredit_b = 0;
			$saldo_d = 0; $saldokredit_d = 0;
			$saldo_e = 0; $saldokredit_e = 0;
			$saldo_g = 0; $saldokredit_g = 0;

			foreach ($dataPerRuang as $key => $value) 
			{ 
			  $rekening[$key]     = $value['rekening1_id'];
			  $saldo[$key]   = $value['saldo'];
			  $issaldoawal          = "";

			  if($issaldoawal==TRUE){ 
				$saldo_a     += $saldo[$key];
			  }else{ 
				if($rekening[$key]==10){
				  $saldo_b     += $saldo[$key];
				}elseif($rekening[$key]==3){
				  $saldo_d     += $saldo[$key];
				}elseif($rekening[$key]==4){
				  $saldo_e     += $saldo[$key];
				}elseif($rekening[$key]==11){
				  $saldo_g     += $saldo[$key];
				}
			  }
			}
			$saldo = array();
			$saldo[0] = $saldo_a;
			$saldo[1] = $saldo_b;
			$saldo[2] = $saldo_d;
			$saldo[3] = $saldo_e;
			$saldo[4] = $saldokredit_g;
			return $saldo;

		}else{
			$criteriaPerRuang=new CDbCriteria;
			$criteriaPerRuang->group = 'ruangan_id, ruangan_nama';
			$criteriaPerRuang->select = $criteriaPerRuang->group;
			$dataPerRuang = LaporanperubahanmodalV::model()->findAll($criteriaPerRuang);
			return $dataPerRuang;
		}
	}
        
	public function getPemDev($ruangId=null)
	{
		$criteriaPerRuang=new CDbCriteria;
		$criteriaPerRuang->group = "ruangan_id, rekening1_id";
		$criteriaPerRuang->select = "ruangan_id, sum(saldoakhirberjalan) as saldo,  rekening1_id";
		$criteriaPerRuang->compare('ruangan_id',$ruangId);
		$conditionPerRuang = "nmrekening3 like '%%Pembagian Deviden%%'";
		$criteriaPerRuang->addCondition($conditionPerRuang);
		$dataPerRuang = LaporanperubahanmodalV::model()->findAll($criteriaPerRuang);
		$saldo_f = 0; //$saldokredit_f = 0;
			foreach ($dataPerRuang as $key => $value2) {
				$saldo[$key]		= $value2['saldo'];
				$issaldoawal        = "";
				if($issaldoawal==false){
				  $saldo_f     += $saldo[$key];
				}
				$saldo = $saldo_f;// - $saldokredit_f;
				return $saldo;
			}
	}

	public function getModal($issaldoawal,$rekening3_id){
		$saldo = 0;
		$criteria=new CDbCriteria;
		$criteria->group = " rekening3_id,  nmrekening3";
		$criteria->select = " rekening3_id, nmrekening3, sum(saldoakhirberjalan) as saldo";
//		$criteria->compare('issaldoawal',$issaldoawal);
		$criteria->compare('rekening3_id',$rekening3_id);
		$data = LaporanperubahanmodalV::model()->find($criteria);
		
		if(isset($data)){
			$saldo = $data->saldo;
		}
		return $saldo;
	}

	public function getTotal($rekening3_id){
		$criteria=new CDbCriteria;
		$criteria->select = "sum(saldoakhirberjalan) as saldo";
		$criteria->compare('rekening3_id',$rekening3_id);
		$data = LaporanperubahanmodalV::model()->find($criteria);
		return $data;
	}
	
	public function getRekening(){
        if(!empty($this->rekening5_id)){
			$rekening_id = $this->rekening5_id;
		}else if(!empty($this->rekening4_id)){
			$rekening_id = $this->rekening4_id;
		}else if(!empty($this->rekening3_id)){
			$rekening_id = $this->rekening3_id;
		}else if(!empty($this->rekening2_id)){
			$rekening_id = $this->rekening2_id;
		}
        
        return $rekening_id;
    }
	
	public function getNamaRekening(){
        if(!empty($this->rekening5_id)){
			$nama_rekening = $this->nmrekening5;
		}else if(!empty($this->rekening4_id)){
			$nama_rekening = $this->nmrekening4;
		}else if(!empty($this->rekening3_id)){
			$nama_rekening = $this->nmrekening3;
		}else if(!empty($this->rekening2_id)){
			$nama_rekening = $this->nmrekening2;
		}
        
        return $nama_rekening;
    }
	
	public function getTglPeriode($rekperiod_id = null)
	{
		$next_year = date('Y-m-d',mktime(0, 0, 0, date("m"),   date("d"),   date("Y")));
		$criteria = new CDbCriteria();
//		$criteria->addCondition('DATE(tglperiodeposting_awal) <=\''.$next_year.'\'');
//		$criteria->addCondition('DATE(tglperiodeposting_akhir) >= \''.$next_year.'\'');
		$criteria->compare('LOWER(deskripsiperiodeposting)',strtolower($this->deskripsiperiodeposting),true);
		$criteria->order = "tglperiodeposting_akhir";
		if(!empty($rekperiod_id)){
			$criteria->addCondition('rekperiode_id = '.$rekperiod_id);
		}
		$data = AKLaporanperubahanmodalV::model()->find($criteria);
		return $data;
	}
        
}