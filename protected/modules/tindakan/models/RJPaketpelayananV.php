<?php
class RJPaketpelayananV extends PaketpelayananV
{
    public $daftartindakan_kode,$daftartindakan_nama,$harga_tariftindakan,$jenistarif_id, $dokter_id;
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
    public function searchTindakan()
    {
            // Warning: Please modify the following code to remove attributes that
            // should not be searched.
            $konfig = KonfigsystemK::model()->find();
            $criteria=new CDbCriteria;
            $jeniswaktukerja = null;

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
            $criteria->compare('LOWER(kelompoktindakan_nama)',strtolower($this->kelompoktindakan_nama),true);
            $criteria->compare('LOWER(tindakanmedis_nama)',strtolower($this->tindakanmedis_nama),true);
            $criteria->compare('LOWER(tipepaket_nama)',strtolower($this->tipepaket_nama),true);
            $criteria->compare('LOWER(daftartindakan_kode)',strtolower($this->daftartindakan_kode),true);
            
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
            
            if(Yii::app()->user->getState('tindakankelas') || in_array(Yii::app()->user->getState('modul_id'), array(
                Params::MODUL_ID_RJ, Params::MODUL_ID_RD
            ))){
                if (in_array(Yii::app()->user->getState('modul_id'), array(
                    Params::MODUL_ID_RJ, Params::MODUL_ID_RD
                ))) {
                    $criteria->addCondition('kelaspelayanan_id = '.Params::KELASPELAYANAN_ID_TANPA_KELAS);
                } else {
                    if(!empty($this->kelaspelayanan_id)){
                        $criteria->addCondition('kelaspelayanan_id = '.$this->kelaspelayanan_id);
                    }
                }
            }

            if (!empty($_GET['pendaftaran_id'])) {
                $modPendaftaran = PendaftaranT::model()->findByPk($_GET['pendaftaran_id']);
                if(!empty($modPendaftaran)){
                    $peg = PegawaiM::model()->findByPk($modPendaftaran->pegawai_id);
                    $jeniswaktukerja = ((!empty($peg)) ? $peg->jeniswaktukerja : null);
                }
                
            }
            
            if($this->tipepaket_id == Params::TIPEPAKET_ID_LUARPAKET){
				if(!empty($this->tipepaket_id)){
					$criteria->addCondition("tipepaket_id = ".$this->tipepaket_id);		
				}
                // if(Yii::app()->user->getState('tindakanruangan')){
                if ($konfig->tindakanruangan == true){
                    $criteria->compare('ruangan_id', Yii::app()->user->getState('ruangan_id'));
				}
                $models = new RJPaketpelayananV;
            }else if($this->tipepaket_id == Params::TIPEPAKET_ID_NONPAKET){
				if(!empty($this->jenistarif_id)){
					$criteria->addCondition("jenistarif_id = ".$this->jenistarif_id);		
				}
                
                $ruangan_id = Yii::app()->user->getState('ruangan_id');
                
                
                // if (!Yii::app()->user->getState('tindakanruangan')) {
                if ($konfig->tindakanruangan == false){
                    $criteria->compare("jeniswaktukerja" , ((!empty($jeniswaktukerja)) ? $jeniswaktukerja : null), false);
                    $ruangan_id = null;
                    $models = new TariftindakanperdaV;
                    $criteria->compare("kelaspelayanan_id", $this->kelaspelayanan_id);
                } else {
                    $criteria->compare("jeniswaktukerja" , ((!empty($jeniswaktukerja)) ? $jeniswaktukerja : null), false);
                    $models = new RJTarifTindakanPerdaRuanganV;
                    $criteria->compare("ruangan_id", $ruangan_id);
                    $criteria->compare("kelaspelayanan_id", $this->kelaspelayanan_id);
                }
                
            }else{
				if(!empty($this->tipepaket_id)){
					$criteria->addCondition("tipepaket_id = ".$this->tipepaket_id);		
				}
                
                //if (!Yii::app()->user->getState('tindakankelas')) {
                //    $this->kelaspelayanan_id = null;
                //}
                
                $ruangan_id = Yii::app()->user->getState('ruangan_id');
                $cekmasuk = false;
                // if (!Yii::app()->user->getState('tindakanruangan')) {
                if ($konfig->tindakanruangan == false){
                    $ruangan_id = null;
                    $cekmasuk = true;
                    $models = new TariftindakanperdaV;
                } else {
                    $cekmasuk = true;
                    
                    $models = new RJTarifTindakanPerdaRuanganV;
                    $criteria->compare("ruangan_id", $ruangan_id);
                }
                
                

                if($cekmasuk){
                    $criteria->compare("jeniswaktukerja" , ((!empty($jeniswaktukerja)) ? $jeniswaktukerja : null), false);
                }else{
                    $models = new RJPaketpelayananV;
                }
            }
            
            
            return new CActiveDataProvider($models, array(
                        'criteria'=>$criteria,
                        'pagination'=>array('pageSize'=>10),
                ));
    }
        

}