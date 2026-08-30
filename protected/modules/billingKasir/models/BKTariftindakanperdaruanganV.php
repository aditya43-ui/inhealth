<?php

class BKTariftindakanperdaruanganV extends TariftindakanperdaruanganV
{
        public $is_pilih = 0;
        public $kegiatanoperasi_id;
        public $operasi_id;
        public $kegiatanoperasi_nama;
        public $operasi_nama, $pendaftaran_id, $pasienadmisi_id;
        public $tipepaket_id = Params::TIPEPAKET_ID_NONPAKET; //untuk PaketpelayananV di search dialog
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return TariftindakanperdaruanganV the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}


	/**
	 * untuk dialog box pilih tindakan
	 */
	public function searchDialog()
	{
            $criteria = new CDbCriteria();
            $criteria->compare('LOWER(daftartindakan_nama)', strtolower($this->daftartindakan_nama), true);
            $criteria->compare('LOWER(kategoritindakan_nama)', strtolower($this->kategoritindakan_nama), true);
            $criteria->compare('LOWER(daftartindakan_kode)', strtolower($this->daftartindakan_kode), true);
            $criteria->compare('daftartindakan_akomodasi', $this->daftartindakan_akomodasi);
            $criteria->order = 'daftartindakan_nama';
            $criteria->limit = 5;
						$jeniswaktukerja = null;

						if(!empty($this->pasienadmisi_id)){
							$modAdmisi = PasienadmisiT::model()->findByPk($this->pasienadmisi_id);
							if(!empty($modAdmisi)){
									$peg = PegawaiM::model()->findByPk($modAdmisi->dokterpenerima_id);
									$jeniswaktukerja = ((!empty($peg)) ? $peg->jeniswaktukerja : null);
							}
						}else{
							if (!empty($this->pendaftaran_id)) {
								$modPendaftaran = PendaftaranT::model()->findByPk($this->pendaftaran_id);
								if(!empty($modPendaftaran)){
										$peg = PegawaiM::model()->findByPk($modPendaftaran->pegawai_id);
										$jeniswaktukerja = ((!empty($peg)) ? $peg->jeniswaktukerja : null);
								}
							}
						}

            if($this->tipepaket_id == Params::TIPEPAKET_ID_NONPAKET) {
							if(!empty($this->penjamin_id)){
								$criteria->addCondition("penjamin_id = ".$this->penjamin_id);					
							}
                //if(Yii::app()->user->getState('tindakankelas')){
								if(!empty($this->kelaspelayanan_id)){
									$criteria->addCondition("kelaspelayanan_id = ".$this->kelaspelayanan_id);					
								}
                //}
                //if(Yii::app()->user->getState('tindakanruangan')){
									if(!empty($this->ruangan_id)){
										$criteria->addCondition("ruangan_id = ".$this->ruangan_id);					
									}
									$criteria->compare('jeniswaktukerja', $jeniswaktukerja);
										
                    $model = new BKTariftindakanperdaruanganV;
                //} else {
//                    $model = new TariftindakanperdaV;
                //}
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
                }
								if(!empty($this->tipepaket_id)){
									$criteria->addCondition("tipepaket_id = ".$this->tipepaket_id);					
								}
								if(!empty($this->kelaspelayanan_id)){
									$criteria->addCondition("kelaspelayanan_id = ".$this->kelaspelayanan_id);					
								}
                $model = new PaketpelayananV;
            }
            $criteria->limit = 5;
            return new CActiveDataProvider($model, array(
                    'criteria'=>$criteria,
                    'pagination'=>array('pageSize'=>5),
            ));
	}
        
}