<?php

class BKInformasikasirhdpulangV extends InformasikasirhdpulangV
{
	public $tgl_awal, $tgl_akhir;
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	 public function searchHD()
	{
		$criteria=new CDbCriteria;
        $criteria->addBetweenCondition('date(tgl_pendaftaran)',$this->tgl_awal,$this->tgl_akhir,true);
		$criteria->compare('LOWER(no_rekam_medik)',strtolower($this->no_rekam_medik),true);
		$criteria->compare('LOWER(no_pendaftaran)',strtolower($this->no_pendaftaran),true);
		$criteria->compare('LOWER(nama_pasien)',strtolower($this->nama_pasien),true);
		$criteria->compare('LOWER(nama_bin)',strtolower($this->nama_bin),true);
		$criteria->compare('LOWER(statusperiksa)',strtolower($this->statusperiksa),true); 
		if(!empty($this->ruangan_id)){
			$criteria->addCondition('ruangan_id = '.$this->ruangan_id);
		}
		if (!empty($this->shift_id)) {
			$criteria->addCondition("shift_id = " . $this->shift_id);
		}
		$criteria->order = 'tgl_pendaftaran DESC';
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria
		));
		
		
	 }
	 
	 public function getTanggalDaftarPulang() {
            $format = new MyFormatter();
            $this->tgl_pendaftaran = $format->formatDateTimeForUser($this->tgl_pendaftaran);
            $this->tglpasienpulang = $format->formatDateTimeForUser($this->tglpasienpulang);
            return $this->tgl_pendaftaran." / <br/> ".$this->tglpasienpulang;
        }

	public function getRuanganItems($instalasi_id=null)
        {
            if($instalasi_id==null){
            return RuanganM::model()->findAllByAttributes(array(),array('order'=>'ruangan_nama'));
            }else{
            return RuanganM::model()->findAllByAttributes(array('instalasi_id'=>$instalasi_id),array('order'=>'ruangan_nama'));   
            }
        }
		
	public function getShiftNama()
        {
			$namaShift = ShiftM::model()->findByPk($this->shift_id)->shift_nama;
			return $namaShift;
        }
	
	public function getNoBed()
        {
			$mod = KamarruanganM::model()->findByAttributes(array('ruangan_id'=>$this->ruangan_id, 'kelaspelayanan_id'=>$this->kelaspelayanan_id));
            if(isset($mod)){
                $noBed = "Bed ".$mod->kamarruangan_nobed;
            }else{
                $noBed = "";
            }
			return $noBed;
        }
	
}

