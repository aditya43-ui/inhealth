<?php

class AGRenanggpenerimaanT extends RenanggpenerimaanT{
	public $pegawaimengetahui_nama, $pegawaimenyetujui_nama, $deskripsiperiode,$sumberanggarannama,$digitnilai,$totalnilaipenerimaan,$statusDetail,$jmlRow;
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function searchInformasiRencAnggPen(){
		$criteria = new CDbCriteria;
		$criteria->with = array('konfiganggaran');
		if(!empty($this->renanggpenerimaan_id)){
			$criteria->addCondition('renanggpenerimaan_id = '.$this->renanggpenerimaan_id);
		}
		if(!empty($this->konfiganggaran_id)){
			$criteria->addCondition('konfiganggaran_id = '.$this->konfiganggaran_id);
		}
		if(!empty($this->sumberanggaran_id)){
			$criteria->addCondition('t.sumberanggaran_id = '.$this->sumberanggaran_id);
		}
		$criteria->compare('LOWER(noren_penerimaan)',strtolower($this->noren_penerimaan),true);
		$criteria->order = 'noren_penerimaan';
		$criteria->limit=10;

		return new CActiveDataProvider($this, array('criteria'=>$criteria));
	}
	
	public function getSearchTglPeriode()
	{
		$date = date("Y-m-d");
		$criteria = new CDbCriteria();
		if(!empty($this->konfiganggaran_id)){
			$criteria->addCondition('konfiganggaran_id = '.$this->konfiganggaran_id);
		}
		$criteria->order = "sd_tglanggaran";
		$criteria->addCondition("isclosing_anggaran IS FALSE");
        $periodes = KonfiganggaranK::model()->findAll($criteria);
		foreach($periodes as $i => $periode){
			$periodes[$i]->sd_tglanggaran = MyFormatter::formatDateTimeForUser($periode->tglanggaran). " - " .  MyFormatter::formatDateTimeForUser($periode->sd_tglanggaran);
		}
		return $periodes;
	}
	
	public function getIsApprove(){
		$status = false;
		$criteria = new CDbCriteria;
		if(!empty($this->renanggpenerimaan_id)){
			$criteria->addCondition('renanggpenerimaan_id = '.$this->renanggpenerimaan_id);
		}
		$criteria->addCondition('approverenanggpen_id IS NOT NULL');
		$approve = self::model()->find($criteria);
			if ($approve)
			$status = true;
						
		return $status;
	}
	
	public function searchInformasiAnggPen(){
		$criteria = new CDbCriteria;
		$criteria->join = "	JOIN konfiganggaran_k ON konfiganggaran_k.konfiganggaran_id = t.konfiganggaran_id
							JOIN approverenanggpen_t ON approverenanggpen_t.approverenanggpen_id = t.approverenanggpen_id";
		if(!empty($this->renanggpenerimaan_id)){
			$criteria->addCondition('renanggpenerimaan_id = '.$this->renanggpenerimaan_id);
		}
		if(!empty($this->konfiganggaran_id)){
			$criteria->addCondition('t.konfiganggaran_id = '.$this->konfiganggaran_id);
		}
		if(!empty($this->sumberanggaran_id)){
			$criteria->addCondition('t.sumberanggaran_id = '.$this->sumberanggaran_id);
		}
		if(!empty($this->approverenanggpen_id)){
			$criteria->addCondition('t.approverenanggpen_id = '.$this->approverenanggpen_id);
		}
		$criteria->compare('LOWER(noren_penerimaan)',strtolower($this->noren_penerimaan),true);
		$criteria->order = 'noren_penerimaan';
		$criteria->limit=10;

		return new CActiveDataProvider($this, array('criteria'=>$criteria));
	}
        
        public function searchInformasiAnggPenBelumRelasasi()
        {
                $provider = $this->searchInformasiAnggPen();
                //$provider->criteria->addCondition('t.renanggpenerimaan_id is null');
                $provider->criteria->select = 't.nilaipenerimaananggaran, t.konfiganggaran_id, t.sumberanggaran_id, t.renanggpenerimaan_id, '
                        . 't.noren_penerimaan, t.renpen_mengetahui_id, t.renpen_tglmengetahui, t.renpen_menyetujui_id, t.renpen_tglmenyetujui';
                $provider->criteria->group = $provider->criteria->select;
                $provider->criteria->join .= " left join realisasianggpenerimaan_t ra on ra.renanggpenerimaan_id = t.renanggpenerimaan_id "
                        . "left join renanggaranpenerimaandet_t rp on rp.renanggpenerimaan_id = t.renanggpenerimaan_id";
                $provider->criteria->addCondition('t.approverenanggpen_id is not null');
                $provider->criteria->having = 'count(rp.renanggpenerimaan_id) <> count(ra.renanggpenerimaan_id)';
                return $provider;
        }
	
	public function getIsRealisasi($renanggpenerimaan_id){
		$status = false;
		$jmlRealisasis = 0;
		$jmlDetail = 0;
		$modRealisasis = AGRealisasianggpenerimaanT::model()->findAllByAttributes(array('renanggpenerimaan_id'=>$renanggpenerimaan_id));
		$jmlRealisasis = count((array)$modRealisasis);
				$criteria = new CDbCriteria;
				if(!empty($renanggpenerimaan_id)){
				$criteria->addCondition('renanggpenerimaan_id ='.$renanggpenerimaan_id);
				}
				$modDetail = AGRenanggaranpenerimaandetT::model()->findAll($criteria);
				$jmlDetail = count((array)$modDetail);
			if ($jmlRealisasis == $jmlDetail)
			$status = true;
			
			return $status;
	}
        
        public function getJson()
        {
            $res = array(
                'base'=>$this->attributes,
            );
            $res['base']['nilaipenerimaananggaran'] = MyFormatter::formatNumberForPrint($this->nilaipenerimaananggaran);
            $konf = KonfiganggaranK::model()->findByPk($this->konfiganggaran_id);
            $sumber = SumberanggaranM::model()->findByPk($this->sumberanggaran_id);
            
            $termin = AGRenanggaranpenerimaandetT::model()->getTermin($this->renanggpenerimaan_id);
            $resTermin = '<option value="">-- Pilih --</option>';
            foreach ($termin as $item) {
                $resTermin .= '<option value="'.$item->renanggaranpenerimaandet_id.'">'.$item->renanggaran_ke.'</option>';
            }
            
            
            $res['konfig'] = $konf->attributes;
            $res['sumber'] = $sumber->attributes;
            $res['termin'] = $resTermin;
            return CJSON::encode($res);
        }
}
