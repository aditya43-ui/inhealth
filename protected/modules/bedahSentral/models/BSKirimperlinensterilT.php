<?php

class BSKirimperlinensterilT extends KirimperlinensterilT {
	public $instalasi_id, $instalasi_nama, $ruangan_nama;
	public $pegawaimengajukan_nama,$pegawaimengetahui_nama,$pegawaipengirim_nama;
	public $tgl_awal,$tgl_akhir;
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function searchInformasi()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->addBetweenCondition('DATE(kirimperlinensteril_tgl)', $this->tgl_awal, $this->tgl_akhir);
				
		if(!empty($this->kirimperlinensteril_id)){
			$criteria->addCondition('kirimperlinensteril_id = '.$this->kirimperlinensteril_id);
		}
		if(!empty($this->pesanperlinensteril_id)){
			$criteria->addCondition('pesanperlinensteril_id = '.$this->pesanperlinensteril_id);
		}
		if(!empty($this->ruangan_id)){
			$criteria->addCondition('ruangan_id = '.$this->ruangan_id);
		}
		$criteria->compare('LOWER(kirimperlinensteril_no)',strtolower($this->kirimperlinensteril_no),true);
		$criteria->compare('LOWER(kirimperlinensteril_tgl)',strtolower($this->kirimperlinensteril_tgl),true);
		$criteria->compare('LOWER(kirimperlinensteril_ket)',strtolower($this->kirimperlinensteril_ket),true);
		if(!empty($this->pegpengirim_id)){
			$criteria->addCondition('pegpengirim_id = '.$this->pegpengirim_id);
		}
		if(!empty($this->pegmengetahui_id)){
			$criteria->addCondition('pegmengetahui_id = '.$this->pegmengetahui_id);
		}
		$criteria->compare('isterimaperlinensteril',$this->isterimaperlinensteril);
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
        
        public function cekPenSterilRuangan($kirimperlinensteril_id) {
//		$hasil = false;
		$cekRow = TerimaperlinensterilT::model()->findByAttributes(array('kirimperlinensteril_id'=>$kirimperlinensteril_id));
		if(!empty($cekRow)){
//			$hasil = true;
			$ket = 'Sudah diterima';
		}
		else{
                    $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
                    if(Yii::app()->session['modul_id'] == Params::MODUL_ID_RD){
                       $controller = 'PenerimaanPeralatanSterilRuanganTRD';
                    }
                    else if(Yii::app()->session['modul_id'] == Params::MODUL_ID_PERSALINAN){
                        $controller = 'PenerimaanPeralatanSterilRuanganTPS';
                    }
                    else if(Yii::app()->session['modul_id'] == Params::MODUL_ID_LAUNDRY_NOTIF){
                        $controller = 'PenerimaanPeralatanSterilRuanganTLD';
                    }
                    else{
                        $controller = 'PenerimaanPeralatanSterilRuanganTBS';
                    }
			$ket = CHtml::link("<button class='btn btn-success'><i class='icon-ok icon-white'></i> Proses</button>",  
							Yii::app()->createUrl($module."/".$controller."/Index",
							array("kirimperlinensteril_id"=>$kirimperlinensteril_id)),
							array("rel"=>"tooltip","title"=>"Klik untuk Penerimaan Peralatan Steril","disabled"=>true));
		}
		echo $ket;
	}
        
}
