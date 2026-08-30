<?php

class PIPasienygPulangriV  extends PasienygpulangriV
{
	public $is_nursestation;
        /**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PasienygpulangriV the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        public function searchPI()
        {
			// Warning: Please modify the following code to remove attributes that
			// should not be searched.
			$criteria=new CDbCriteria;
			if($this->ceklis==1){
				$criteria->addBetweenCondition('DATE(tglpasienpulang)',$this->tgl_awal,$this->tgl_akhir,true);
//                    $criteria->addCondition('tglpasienpulang BETWEEN \''.$this->tgl_awal.'\' AND \''.$this->tgl_akhir.'\' ');
			}
                        if($this->is_nursestation == 1 && Yii::app()->user->getState('nursestation_id') != null){ //RSKG-864
                                $ruangan = array();
                                $modNurseRuangan = NursestationruanganM::model()->findAll('nursestation_id='.Yii::app()->user->getState('nursestation_id'));
                                if(count((array)$modNurseRuangan)>0){
                                        foreach ($modNurseRuangan as $value) {
                                                $ruangan[] = $value->ruangan_id;
                                        }
                                }
                                $criteria->addInCondition('ruangan_id', $ruangan);
                        }else{
                                $criteria->addCondition('ruangan_id = ' . Yii::app()->user->getState('ruangan_id'));
                        }
			$criteria->compare('LOWER(no_pendaftaran)',strtolower($this->no_pendaftaran),true);
			$criteria->compare('LOWER(nama_pasien)',strtolower($this->nama_pasien),true);
			$criteria->compare('LOWER(nama_bin)',strtolower($this->nama_bin),true);
			$criteria->compare('LOWER(no_rekam_medik)',strtolower($this->no_rekam_medik),true);
			$criteria->compare('LOWER(keterangan_kamar)',strtolower($this->keterangan_kamar),true);
			$criteria->addCondition('ruangan_id = '.Yii::app()->user->getState('ruangan_id'));
			if(!empty($this->penjamin_id)){
				$criteria->addCondition("penjamin_id = ".$this->penjamin_id); 	
			}
			if(!empty($this->carabayar_id)){
				$criteria->addCondition("carabayar_id = ".$this->carabayar_id); 	
			}


			return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
			));
        }
        
        public function IDpembayaranpelayanan($pendaftaran_id) {
            $pembayaranpelayananId = null;
            $idPembayaran = InformasipasiensudahbayarV::model()->findByAttributes(array('pendaftaran_id'=>$pendaftaran_id));
            if(isset($idPembayaran)){
                $pembayaranpelayananId = $idPembayaran->pembayaranpelayanan_id;
            }
            return $pembayaranpelayananId;
        }

}