<?php

class STPesanperlinensterilT extends PesanperlinensterilT {
	public $instalasi_id, $instalasi_nama, $ruangan_nama;
	public $pegawaimemesan_nama,$pegawaimengetahui_nama;
	public $tgl_awal,$tgl_akhir;
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}	
	
	public function searchInformasi(){
		
		$criteria=new CDbCriteria;

		$criteria->addBetweenCondition('DATE(pesanperlinensteril_tgl)',$this->tgl_awal,$this->tgl_akhir);
		if(!empty($this->pesanperlinensteril_id)){
			$criteria->addCondition('pesanperlinensteril_id = '.$this->pesanperlinensteril_id);
		}
		if(!empty($this->ruangan_id)){
			$criteria->addCondition('ruangan_id = '.$this->ruangan_id);
		}
		$criteria->compare('LOWER(pesanperlinensteril_no)',strtolower($this->pesanperlinensteril_no),true);
		$criteria->compare('LOWER(pesanperlinensteril_ket)',strtolower($this->pesanperlinensteril_ket),true);
		if(!empty($this->pegmengetahui_id)){
			$criteria->addCondition('pegmengetahui_id = '.$this->pegmengetahui_id);
		}
		if(!empty($this->pegpemesan_id)){
			$criteria->addCondition('pegpemesan_id = '.$this->pegpemesan_id);
		}
		$criteria->compare('iskirimperlinensteril',$this->iskirimperlinensteril);
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
        
        public function searchInformasiDashboard(){
		
		$criteria=new CDbCriteria;
                $tanggal = date('Y-m-d');
		$criteria->addCondition("date(pesanperlinensteril_tgl) = '".$tanggal."'");
		$criteria->limit=10;

		return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
		));

	}
}

