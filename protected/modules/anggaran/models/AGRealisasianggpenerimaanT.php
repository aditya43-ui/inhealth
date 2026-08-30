<?php
class AGRealisasianggpenerimaanT extends RealisasianggpenerimaanT{
	public $pegawaimenyetujui_nama,$pegawaimengetahui_nama,$transfer,$cek;
	public $sumberanggarannama,$sumberanggaran_id;
	public $konfiganggaran_id,$renpen_mengetahui_id,$renpen_menyetujui_id,$renpen_tglmengetahui,$renpen_tglmenyetujui;
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function getSumberanggaranNama()
    {
        return (isset($this->renanggpenerimaan->sumberanggaran_id) ? $this->renanggpenerimaan->sumberanggaran->sumberanggarannama : "");
    }
	
	public function getSumberanggaranId()
    {
        return (isset($this->renanggpenerimaan->sumberanggaran_id) ? $this->renanggpenerimaan->sumberanggaran_id : "");
    }
	
	public function getSisaAnggaran(){ // menampilkan sisa anggaran yang ada di alokasianggaran_id
		$modAlokasiAnggaran = AlokasianggaranT::model()->findAllByAttributes(array('realisasianggpenerimaan_id'=>$this->realisasianggpenerimaan_id));
		$total_nilaipenerimaan = 0;
		$total_nilaialokasi = 0;
		if(count((array)$modAlokasiAnggaran) > 0 ){			
			foreach($modAlokasiAnggaran as $i=>$data){
				$total_nilaialokasi += $data->nilaiygdialokasikan;
			}
		}
		$modRealisasiPenerimaan = RealisasianggpenerimaanT::model()->findByPk($this->realisasianggpenerimaan_id);
		if(!empty($modRealisasiPenerimaan)){
			$total_nilaipenerimaan = $modRealisasiPenerimaan->realisasipenerimaan;
		}
		$sisaanggaran = $total_nilaipenerimaan - $total_nilaialokasi;
		if($sisaanggaran <= 0){
			$sisaanggaran = $total_nilaipenerimaan;
		}
		return $sisaanggaran;
	}
	
	public function searchInformasiRealAnggPener(){
		$criteria = new CDbCriteria;
		$criteria->compare('LOWER(norealisasianggpen)',strtolower($this->norealisasianggpen),true);
		if(!empty($this->konfiganggaran_id)){
			$criteria->addCondition('renanggpenerimaan_t.konfiganggaran_id = '.$this->konfiganggaran_id);
		}
		if(!empty($this->sumberanggaran_id)){
			$criteria->addCondition('renanggpenerimaan_t.sumberanggaran_id = '.$this->sumberanggaran_id);
		}
		$criteria->group = 'norealisasianggpen,konfiganggaran_id,sumberanggaran_id,renpen_mengetahui_id,renpen_menyetujui_id';
		$criteria->select = $criteria->group;
		$criteria->join = 'JOIN renanggpenerimaan_t ON t.renanggpenerimaan_id = renanggpenerimaan_t.renanggpenerimaan_id';
		return new CActiveDataProvider($this, array(
													'criteria'=>$criteria,
											));
	}
}