<?php
class KUSettlementpaymentT extends SettlementpaymentT
{
	
	public $tgl_awal,$tgl_akhir,$tgl_awal2,$tgl_akhir2,$statusbatal;
	public $tglpengajuan,$nopengajuan,$pegawai_nama,$pegawaisettlement_nama,$nip,$jenistransaksi,$ceklis,$statussettlement;
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}


	public function searchInformasi()
	{
		$criteria = new CDbCriteria();
		
		$criteria=new CDbCriteria;
		$criteria->join ='JOIN advancepayment_t a ON t.advancepayment_id = a.advancepayment_id';
		// $criteria->
		$criteria->addBetweenCondition('DATE(t.tglsettlement)', $this->tgl_awal, $this->tgl_akhir);
		
		if ($this->ceklis) {
			$criteria->addBetweenCondition('DATE(a.tglpengajuan)', $this->tgl_awal2, $this->tgl_akhir2);
		}

		// $criteria->compare('advancepayment_id',$this->advancepayment_id);
		// $criteria->compare('t.jenistransaksi',$this->jenistransaksi,true);
		// // $criteria->compare('tglpengajuan',$this->tglpengajuan,true);
		// $criteria->compare('t.nopengajuan',$this->nopengajuan,true);
		// $criteria->compare('t.nodokumen',$this->nodokumen,true);
		// $criteria->compare('t.noanggaran',$this->noanggaran,true);
		$criteria->compare('t.nosettlement',$this->nosettlement,true);
		$criteria->compare('a.nopengajuan',$this->nopengajuan,true);

		if (!empty($this->statussettlement)) {
			if ($this->statussettlement == 'LUNAS') {
				$criteria->addCondition('t.sisakekurangan = 0');
				$criteria->addCondition('t.sisapengembalian = 0');
				$criteria->addCondition('t.sisaadvance = 0');
			}else if($this->statussettlement == 'BELUM LUNAS'){
				// $criteria->addCondition('t.sisakekurangan != 0');
				// $criteria->addCondition('t.sisapengembalian != 0');
				// $criteria->addCondition('t.sisaadvance != 0');
			}

			// echo "<pre>";
			// print_r($criteria);
			// exit();
		}
		if(!empty($this->statusbatal)){
			if($this->statusbatal == 'SUDAH DIBATALKAN'){
				$criteria->addCondition('t.pegawaibatal_id IS NOT NULL');
			}else if($this->statusbatal == 'BELUM DIBATALKAN'){
				$criteria->addCondition('t.pegawaibatal_id IS NULL');
			}
		}

		if (!empty($this->profilrs_id)) {
			if(is_array($this->profilrs_id)){
				$criteria->addInCondition('t.profilrs_id',$this->profilrs_id);
			}else{
				$criteria->addCondition('t.profilrs_id ='.$this->profilrs_id);
			}
		}

		if (!empty($this->pegawai_id)) {
			$criteria->addCondition('t.pegawai_id ='.$this->pegawai_id);
		}
		if (!empty($this->pegawaisettlement_id)) {
			$criteria->addCondition('t.pegawaisettlement_id ='.$this->pegawaisettlement_id);
		}



		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,                    
	));
	}

}