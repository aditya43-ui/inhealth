<?php
class AKInformasirekonsiliasibankV extends InformasirekonsiliasibankV
{
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

		$criteria->addBetweenCondition('DATE(rekonsiliasibank_tgl)', $this->tgl_awal, $this->tgl_akhir);
		$criteria->compare('LOWER(rekonsiliasibank_no)',strtolower($this->rekonsiliasibank_no),true);
		if(!empty($this->bank_id)){
			$criteria->addCondition('bank_id = '.$this->bank_id);
		}
		if(!empty($this->matauang_id)){
			$criteria->addCondition('matauang_id = '.$this->matauang_id);
		}
		$criteria->compare('LOWER(matauang)',strtolower($this->matauang),true);
		$criteria->compare('LOWER(singkatan)',strtolower($this->singkatan),true);
		if(!empty($this->kabupaten_id)){
			$criteria->addCondition('kabupaten_id = '.$this->kabupaten_id);
		}
		$criteria->compare('LOWER(kabupaten_nama)',strtolower($this->kabupaten_nama),true);
		if(!empty($this->propinsi_id)){
			$criteria->addCondition('propinsi_id = '.$this->propinsi_id);
		}
		$criteria->compare('LOWER(propinsi_nama)',strtolower($this->propinsi_nama),true);
		$criteria->compare('LOWER(namabank)',strtolower($this->namabank),true);
		$criteria->compare('LOWER(norekening)',strtolower($this->norekening),true);
		$criteria->compare('LOWER(alamatbank)',strtolower($this->alamatbank),true);
		$criteria->compare('LOWER(telpbank1)',strtolower($this->telpbank1),true);
		$criteria->compare('LOWER(telpbank2)',strtolower($this->telpbank2),true);
		$criteria->compare('LOWER(faxbank)',strtolower($this->faxbank),true);
		$criteria->compare('LOWER(emailbank)',strtolower($this->emailbank),true);
		$criteria->compare('LOWER(website)',strtolower($this->website),true);
		$criteria->compare('LOWER(kodepos)',strtolower($this->kodepos),true);
		$criteria->compare('LOWER(cabangdari)',strtolower($this->cabangdari),true);
		$criteria->compare('LOWER(negara)',strtolower($this->negara),true);
		if(!empty($this->rekonsiliasibankdetail_id)){
			$criteria->addCondition('rekonsiliasibankdetail_id = '.$this->rekonsiliasibankdetail_id);
		}
		if(!empty($this->jenisrekonsiliasibank_id)){
			$criteria->addCondition('jenisrekonsiliasibank_id = '.$this->jenisrekonsiliasibank_id);
		}
		$criteria->compare('LOWER(jenisrekonsiliasibank_nama)',strtolower($this->jenisrekonsiliasibank_nama),true);
		if(!empty($this->kelrekening_id)){
			$criteria->addCondition('kelrekening_id = '.$this->kelrekening_id);
		}
		$criteria->compare('LOWER(koderekeningkel)',strtolower($this->koderekeningkel),true);
		$criteria->compare('LOWER(namakelrekening)',strtolower($this->namakelrekening),true);
		// if(!empty($this->rekening1_id)){
		// 	$criteria->addCondition('rekening1_id = '.$this->rekening1_id);
		// }
		// $criteria->compare('LOWER(kdrekening1)',strtolower($this->kdrekening1),true);
		// $criteria->compare('LOWER(nmrekening1)',strtolower($this->nmrekening1),true);
		// if(!empty($this->rekening2_id)){
		// 	$criteria->addCondition('rekening2_id = '.$this->rekening2_id);
		// }
		// $criteria->compare('LOWER(kdrekening2)',strtolower($this->kdrekening2),true);
		// $criteria->compare('LOWER(nmrekening2)',strtolower($this->nmrekening2),true);
		// if(!empty($this->rekening3_id)){
		// 	$criteria->addCondition('rekening3_id = '.$this->rekening3_id);
		// }
		// $criteria->compare('LOWER(kdrekening3)',strtolower($this->kdrekening3),true);
		// $criteria->compare('LOWER(nmrekening3)',strtolower($this->nmrekening3),true);
		// if(!empty($this->rekening4_id)){
		// 	$criteria->addCondition('rekening4_id = '.$this->rekening4_id);
		// }
		// $criteria->compare('LOWER(kdrekening4)',strtolower($this->kdrekening4),true);
		// $criteria->compare('LOWER(nmrekening4)',strtolower($this->nmrekening4),true);
		if(!empty($this->rekening5_id)){
			$criteria->addCondition('rekening5_id = '.$this->rekening5_id);
		}
		$criteria->compare('LOWER(kdrekening5)',strtolower($this->kdrekening5),true);
		$criteria->compare('LOWER(nmrekening5)',strtolower($this->nmrekening5),true);
		$criteria->compare('saldodebit',$this->saldodebit);
		$criteria->compare('saldokredit',$this->saldokredit);
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
		
		$criteria->order = 'rekonsiliasibankdetail_id ASC';
		$criteria->limit=10;

		return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
		));
	}

	public function getKodeRekening()
    {
        if(isset($this->rekening5_id))
        {
            $kode_rekening = $this->kdrekening1 . "-" . $this->kdrekening2 . "-" . $this->kdrekening3 . "-" . $this->kdrekening4 . "-" . $this->kdrekening5;
        }else{
            if(isset($this->rekening4_id))
            {
                $kode_rekening = $this->kdrekening1 . "-" . $this->kdrekening2 . "-" . $this->kdrekening3 . "-" . $this->kdrekening4;
            }else{
                $kode_rekening = $this->kdrekening1 . "-" . $this->kdrekening2 . "-" . $this->kdrekening3;
            }
        }
        
        return $kode_rekening;
    }
    
    public function getNamaRekening()
    {
        if(isset($this->rekening5_id))
        {
            $kode_rekening = $this->nmrekening5;
        }else{
            if(isset($this->rekening4_id))
            {
                $kode_rekening = $this->nmrekening4;
            }else{
                $kode_rekening = $this->nmrekening3;
            }
        }
        
        return $kode_rekening;
    }
}