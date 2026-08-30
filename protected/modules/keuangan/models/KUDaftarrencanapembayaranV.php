<?php

class KUDaftarrencanapembayaranV extends DaftarrencanapembayaranV {

    public $tgl_awal, $tgl_akhir, $no_bkk, $namabank, $buktikaskeluar_id, $norekening, $biayaadministrasi, $totalpengeluaran;

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function searchInformasi() {
        $criteria = new CDbCriteria;
        
        $criteria->addBetweenCondition('DATE(tglvoucher)', $this->tgl_awal, $this->tgl_akhir);
		if(!empty($this->bank_id)){
			$criteria->addCondition('bank_id = '.$this->bank_id);
		}
        $criteria->compare('LOWER(supplier_nama)',strtolower($this->supplier_nama),true);
        $criteria->compare('LOWER(no_voucher)',strtolower($this->no_voucher),true);
//        $criteria->order = 'mataanggaran_id ASC';
        $criteria->limit=10;
        
        return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
            ));
    }
	
	public function jenisBank($bank_id){
		$modjenis=BankM::model()->findByPk($bank_id);
		if(!empty($modjenis)){
			return $modjenis->namabank;
		}
	}
        
        public function getVoucherBukti($verpengeluaran_id){
            $voucer = "";
            $jenispengeluaran = "";
            
            $modePengeluaran = VerpengeluaranT::model()->findByPk($verpengeluaran_id);
            
            if(isset($modePengeluaran)){
                $voucer = substr($modePengeluaran->no_voucher, 0,4);
                
                if(!empty($modePengeluaran->jenispengeluaran_id)){
                    $modeJenis = JenispengeluaranM::model()->findByPk($modePengeluaran->jenispengeluaran_id);
                    
                    if(isset($modeJenis)){
                        $jenispengeluaran = $modeJenis->jenispengeluaran_nama;
                    }
                }
            }
            
            return $voucer."/".$jenispengeluaran;
        }
        
        public function getBank(){
		$modBankList=BankM::model()->findAll("bank_aktif = true AND tipe_bank = 'VENDOR' order by namabank asc");
		
                return CHtml::listData($modBankList, 'bank_id', 'namabank');
	}
        
        public function getClassDaftar($value){
		$cls = "";
		$model = DaftarrencanapembayaranT::model()->findByAttributes(array('verpengeluaran_id'=>$value));
                
                if(isset($model)){
                    $cls = "classRed";
                }
                return $cls;
	}

}
