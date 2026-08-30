<?php
class GZPaketpelayananV extends PaketpelayananV
{
    public $daftartindakan_kode,$daftartindakan_nama,$harga_tariftindakan;
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
    public function searchTindakan()
    {
            // Warning: Please modify the following code to remove attributes that
            // should not be searched.

            $criteria=new CDbCriteria;

            $criteria->compare('daftartindakan_id',$this->daftartindakan_id);
            $criteria->compare('LOWER(daftartindakan_nama)',strtolower($this->daftartindakan_nama),true);
            $criteria->compare('kategoritindakan_id',$this->kategoritindakan_id);
            $criteria->compare('LOWER(kategoritindakan_nama)',strtolower($this->kategoritindakan_nama),true);
            $criteria->compare('kelompoktindakan_id',$this->kelompoktindakan_id);
            $criteria->compare('LOWER(kelompoktindakan_nama)',strtolower($this->kelompoktindakan_nama),true);
            $criteria->compare('LOWER(tindakanmedis_nama)',strtolower($this->tindakanmedis_nama),true);
            $criteria->compare('LOWER(tipepaket_nama)',strtolower($this->tipepaket_nama),true);
            $criteria->compare('kelaspelayanan_id',$this->kelaspelayanan_id);
            $criteria->compare('LOWER(kelaspelayanan_nama)',strtolower($this->kelaspelayanan_nama),true);
            $criteria->compare('jeniskelas_id',$this->jeniskelas_id);
            $criteria->compare('carabayar_id',$this->carabayar_id);
            $criteria->compare('LOWER(carabayar_nama)',strtolower($this->carabayar_nama),true);
            $criteria->compare('penjamin_id',$this->penjamin_id);
            $criteria->compare('LOWER(penjamin_nama)',strtolower($this->penjamin_nama),true);
            $criteria->compare('ruangan_id',$this->ruangan_id);
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

            if($this->tipepaket_id == Params::TIPEPAKET_ID_LUARPAKET){
                $criteria->compare('tipepaket_id',$this->tipepaket_id);
                if(Yii::app()->user->getState('tindakanruangan'))
                    $criteria->compare('ruangan_id',Yii::app()->user->getState('ruangan_id'));
                if(Yii::app()->user->getState('tindakankelas'))
                    $criteria->compare('kelaspelayanan_id',$this->kelaspelayanan_id);
                $models = new GZPaketpelayananV;
            }else if($this->tipepaket_id == Params::TIPEPAKET_ID_NONPAKET){
                if(Yii::app()->user->getState('tindakankelas'));
                    $criteria->compare('kelaspelayanan_id',$this->kelaspelayanan_id);
                if(Yii::app()->user->getState('tindakanruangan')){
                    $criteria->compare('ruangan_id',Yii::app()->user->getState('ruangan_id'));
                    $models = new GZTarifTindakanPerdaRuanganV;
                } else {
                    if(Yii::app()->user->getState('tindakanruangan'))
                        $criteria->compare('ruangan_id',$this->ruangan_id);
                    if(Yii::app()->user->getState('tindakankelas'))
                        $criteria->compare('kelaspelayanan_id',$this->kelaspelayanan_id);
                        $criteria->compare('tipepaket_id',$this->tipepaket_id);
                    $models = new GZTariftindakanperdaV;
                }
            }else{
                $criteria->compare('tipepaket_id',$this->tipepaket_id);
                $models = new GZPaketpelayananV;
            }
            
            return new CActiveDataProvider($models, array(
                        'criteria'=>$criteria,
                        'pagination'=>array('pageSize'=>5),
                ));
    }
	
	public function searchTindakanKonsul()
    {
            // Warning: Please modify the following code to remove attributes that
            // should not be searched.

            $criteria=new CDbCriteria;

            $criteria->compare('daftartindakan_id',$this->daftartindakan_id);
            $criteria->compare('LOWER(daftartindakan_nama)',strtolower($this->daftartindakan_nama),true);
            $criteria->compare('kategoritindakan_id',$this->kategoritindakan_id);
            $criteria->compare('LOWER(kategoritindakan_nama)',strtolower($this->kategoritindakan_nama),true);
            $criteria->compare('kelompoktindakan_id',$this->kelompoktindakan_id);
            $criteria->compare('LOWER(kelompoktindakan_nama)',strtolower($this->kelompoktindakan_nama),true);
            $criteria->compare('LOWER(tindakanmedis_nama)',strtolower($this->tindakanmedis_nama),true);
            $criteria->compare('LOWER(tipepaket_nama)',strtolower($this->tipepaket_nama),true);
            $criteria->compare('kelaspelayanan_id',$this->kelaspelayanan_id);
            $criteria->compare('LOWER(kelaspelayanan_nama)',strtolower($this->kelaspelayanan_nama),true);
            $criteria->compare('jeniskelas_id',$this->jeniskelas_id);
            $criteria->compare('carabayar_id',$this->carabayar_id);
            $criteria->compare('LOWER(carabayar_nama)',strtolower($this->carabayar_nama),true);
            $criteria->compare('penjamin_id',$this->penjamin_id);
            $criteria->compare('LOWER(penjamin_nama)',strtolower($this->penjamin_nama),true);
            $criteria->compare('ruangan_id',$this->ruangan_id);
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
			
            if($this->tipepaket_id == Params::TIPEPAKET_ID_LUARPAKET){ 
				// dikomen karena di view nya belum ada daftartindakan_konsul : sedang ditambahkan RND-6293
				$criteria->addCondition('daftartindakan_konsul is true');
				$criteria->addCondition('komponenunit_id = '.Params::KOMPONENUNIT_ID_GIZI);
				$criteria->addCondition('kelompoktindakan_id = '.Params::KELOMPOKTINDAKAN_ID_GIZI);
                $criteria->compare('tipepaket_id',$this->tipepaket_id);
                if(Yii::app()->user->getState('tindakanruangan'))
                    $criteria->compare('ruangan_id',Yii::app()->user->getState('ruangan_id'));
                if(Yii::app()->user->getState('tindakankelas')){
					$criteria->compare('kelaspelayanan_id',$this->kelaspelayanan_id);
				}
                $models = new GZPaketpelayananV;
            }else if($this->tipepaket_id == Params::TIPEPAKET_ID_NONPAKET){
				$criteria->addCondition('daftartindakan_konsul is true');
				$criteria->addCondition('komponenunit_id = '.Params::KOMPONENUNIT_ID_GIZI);
				$criteria->addCondition('kelompoktindakan_id = '.Params::KELOMPOKTINDAKAN_ID_GIZI);
                if(Yii::app()->user->getState('tindakankelas')){ 
					$criteria->compare('kelaspelayanan_id',$this->kelaspelayanan_id);
				}
                if(Yii::app()->user->getState('tindakanruangan')){
                    $criteria->compare('ruangan_id',Yii::app()->user->getState('ruangan_id'));
                    $models = new GZTarifTindakanPerdaRuanganV;
                } else {
                    if(Yii::app()->user->getState('tindakanruangan')){
                        $criteria->compare('ruangan_id',$this->ruangan_id);
					}
                    if(Yii::app()->user->getState('tindakankelas')){
                        $criteria->compare('kelaspelayanan_id',$this->kelaspelayanan_id);
                        $criteria->compare('tipepaket_id',$this->tipepaket_id);
					}
                    $models = new GZTariftindakanperdaV;
                }
				
            }else{
				$criteria->addCondition('daftartindakan_konsul is true');
				$criteria->addCondition('komponenunit_id = '.Params::KOMPONENUNIT_ID_GIZI);
				$criteria->addCondition('kelompoktindakan_id = '.Params::KELOMPOKTINDAKAN_ID_GIZI);
                $criteria->compare('tipepaket_id',$this->tipepaket_id);
                $models = new GZPaketpelayananV;
            }
			
            return new CActiveDataProvider($models, array(
                        'criteria'=>$criteria,
                        'pagination'=>array('pageSize'=>10),
                ));
    }
        

}