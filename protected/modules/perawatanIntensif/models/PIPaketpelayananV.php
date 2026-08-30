<?php
class PIPaketpelayananV extends PaketpelayananV
{
    public $daftartindakan_kode,$daftartindakan_nama,$harga_tariftindakan,$jenistarif_id;
	public $harga_min,$harga_max;
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
    public function searchTindakan()
    {
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$jeniswaktukerja = null;

		if (!empty($_GET['pasienadmisi_id'])) {
			$modAdmisi = PasienadmisiT::model()->findByPk($_GET['pasienadmisi_id']);
			if(!empty($modAdmisi)){
					$peg = PegawaiM::model()->findByPk($modAdmisi->pegawai_id);
					$jeniswaktukerja = ((!empty($peg)) ? $peg->jeniswaktukerja : null);
			}
		}

		if(!empty($this->daftartindakan_id)){
			$criteria->addCondition("daftartindakan_id = ".$this->daftartindakan_id); 	
		}
		$criteria->compare('LOWER(daftartindakan_nama)',strtolower($this->daftartindakan_nama),true);
		if(!empty($this->kategoritindakan_id)){
			$criteria->addCondition("kategoritindakan_id = ".$this->kategoritindakan_id); 	
		}
		$criteria->compare('LOWER(kategoritindakan_nama)',strtolower($this->kategoritindakan_nama),true);
		if(!empty($this->kelompoktindakan_id)){
			$criteria->addCondition("kelompoktindakan_id = ".$this->kelompoktindakan_id); 	
		}
		$criteria->compare('LOWER(daftartindakan_kode)',strtolower($this->daftartindakan_kode),true);
		$criteria->compare('LOWER(kelompoktindakan_nama)',strtolower($this->kelompoktindakan_nama),true);
		$criteria->compare('LOWER(tindakanmedis_nama)',strtolower($this->tindakanmedis_nama),true);
		$criteria->compare('LOWER(tipepaket_nama)',strtolower($this->tipepaket_nama),true);
		if(!empty($this->kelaspelayanan_id)){
			$criteria->addCondition("kelaspelayanan_id = ".$this->kelaspelayanan_id); 	
		}
		$criteria->compare('LOWER(kelaspelayanan_nama)',strtolower($this->kelaspelayanan_nama),true);
		if(!empty($this->jeniskelas_id)){
			$criteria->addCondition("jeniskelas_id = ".$this->jeniskelas_id); 	
		}
		if(!empty($this->carabayar_id)){
			$criteria->addCondition("carabayar_id = ".$this->carabayar_id); 	
		}
		$criteria->compare('LOWER(carabayar_nama)',strtolower($this->carabayar_nama),true);
		if(!empty($this->penjamin_id)){
			$criteria->addCondition("penjamin_id = ".$this->penjamin_id); 	
		}
		$criteria->compare('LOWER(penjamin_nama)',strtolower($this->penjamin_nama),true);
		if(!empty($this->ruangan_id)){
			$criteria->addCondition("ruangan_id = ".$this->ruangan_id); 	
		}
		$criteria->compare('LOWER(namatindakan)',strtolower($this->namatindakan),true);
		$criteria->compare('tarifpaketpel',$this->tarifpaketpel);
		$criteria->compare('subsidiasuransi',$this->subsidiasuransi);
		$criteria->compare('subsidipemerintah',$this->subsidipemerintah);
		$criteria->compare('subsidirumahsakit',$this->subsidirumahsakit);
		$criteria->compare('iurbiaya',$this->iurbiaya);
		$criteria->compare('tipepaket_aktif',$this->tipepaket_aktif);
		$criteria->compare('LOWER(tglkesepakatantarif)',strtolower($this->tglkesepakatantarif),true);
		$criteria->compare('LOWER(nokesepakatantarif)',strtolower($this->nokesepakatantarif),true);
		$criteria->compare('tarifpaket',$this->tarifpaket);
		$criteria->compare('paketsubsidiasuransi',$this->paketsubsidiasuransi);
		$criteria->compare('paketsubsidipemerintah',$this->paketsubsidipemerintah);
		$criteria->compare('paketsubsidirs',$this->paketsubsidirs);
		$criteria->compare('paketiurbiaya',$this->paketiurbiaya);
		$criteria->compare('LOWER(keterangan_tipepaket)',strtolower($this->keterangan_tipepaket),true);            

		if($this->tipepaket_id == Params::TIPEPAKET_ID_NONPAKET){
			if(!empty($this->jenistarif_id)){
				$criteria->addCondition("jenistarif_id = ".$this->jenistarif_id); 	
			}
			if(Yii::app()->user->getState('tindakankelas'));{
				if(!empty($this->kelaspelayanan_id)){
					$criteria->addCondition("kelaspelayanan_id = ".$this->kelaspelayanan_id); 	
				}
			}

			$criteria->compare("jeniswaktukerja" , ((!empty($jeniswaktukerja)) ? $jeniswaktukerja : null), false);
			if(Yii::app()->user->getState('tindakanruangan')){
				$criteria->addCondition('ruangan_id = '.Yii::app()->user->getState('ruangan_id'));
				//$criteria->limit = 5;
				$models = new PITarifTindakanPerdaRuanganV;
				
			} else {
				if(Yii::app()->user->getState('tindakanruangan')){
					if(!empty($this->ruangan_id)){
						$criteria->addCondition("ruangan_id = ".$this->ruangan_id); 	
					}
				}
				if(Yii::app()->user->getState('tindakankelas')){
					if(!empty($this->kelaspelayanan_id)){
						$criteria->addCondition("kelaspelayanan_id = ".$this->kelaspelayanan_id); 	
					}
					if(!empty($this->tipepaket_id)){
						$criteria->addCondition("tipepaket_id = ".$this->tipepaket_id); 	
					}
				}
				//$criteria->limit = 5;
				$models = new TariftindakanperdaV;
			}
		}else{
			if(!empty($this->tipepaket_id)){
				$criteria->addCondition("tipepaket_id = ".$this->tipepaket_id); 	
			}
			//$criteria->limit = 5;
			$models = new PIPaketpelayananV;
		}

		return new CActiveDataProvider($models, array(
			'criteria'=>$criteria,
            'sort'=>array(
                'defaultOrder'=>'daftartindakan_nama',
            )
		));
    }
        

}