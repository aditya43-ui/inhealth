<?php

class RIPasienygPulangriV  extends PasienygpulangriV
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PasienygpulangriV the static model class
	 */
         public $pegawai_id, $kondisikeluar_id, $carakeluar_id;
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        public function searchRI()
        {
			// Warning: Please modify the following code to remove attributes that
			// should not be searched.
			$criteria=new CDbCriteria;
                        $criteria->join = "JOIN pasienpulang_t pp ON pp.pasienpulang_id = t.pasienpulang_id ";
			if($this->ceklis==1){
				$criteria->addBetweenCondition('DATE(t.tglpasienpulang)',$this->tgl_awal,$this->tgl_akhir,true);
//                    $criteria->addCondition('tglpasienpulang BETWEEN \''.$this->tgl_awal.'\' AND \''.$this->tgl_akhir.'\' ');
			}
			$criteria->compare('LOWER(t.no_pendaftaran)',strtolower($this->prefix_pendaftaran.$this->no_pendaftaran),true);
			$criteria->compare('LOWER(t.nama_pasien)',strtolower($this->nama_pasien),true);
			$criteria->compare('LOWER(t.nama_bin)',strtolower($this->nama_bin),true);
			$criteria->compare('LOWER(t.no_rekam_medik)',strtolower($this->no_rekam_medik),true);
			$criteria->compare('LOWER(t.keterangan_kamar)',strtolower($this->keterangan_kamar),true);
            $criteria->compare('t.dokterpenerima_id', $this->dokterpenerima_id);
        
            if (!empty($this->pegawai_id)) {
                $criteria->addCondition('t.pegawai_id = '.$this->pegawai_id.' or t.dpjp2_id = '.$this->pegawai_id.' or t.dpjp3_id = '.$this->pegawai_id);
            }
            
            
			$criteria->addCondition('pp.ruanganakhir_id = '.Yii::app()->user->getState('ruangan_id'));
			if(!empty($this->penjamin_id)){
				$criteria->addCondition("t.penjamin_id = ".$this->penjamin_id); 	
			}
			if(!empty($this->carabayar_id)){
				$criteria->addCondition("t.carabayar_id = ".$this->carabayar_id); 	
			}
                        if (!empty($this->kelaspelayanan_id)){
                            $criteria->addCondition("t.kelaspelayanan_id = '".$this->kelaspelayanan_id."' ");
                        }
                         if (!empty($this->kamarruangan_id)){
                            $criteria->addCondition("t.kamarruangan_id = '".$this->kamarruangan_id."' ");
                        }
                        if (!empty($this->jeniskasuspenyakit_id)){
                            $criteria->addCondition("t.jeniskasuspenyakit_id = '".$this->jeniskasuspenyakit_id."' ");
                        }
                        
                        if (!empty($this->pegawai_id)){
                            $criteria->addCondition("t.nama_pegawai = '".$this->pegawai_id."' ");
                        }
                        
                        if (!empty($this->carakeluar_id)){
                            $criteria->addCondition("t.carakeluar_id = '".$this->carakeluar_id."' ");
                        }
                        
                        if (!empty($this->kondisikeluar_id)){
                            $criteria->addCondition("t.kondisikeluar_id = '".$this->kondisikeluar_id."' ");
                        }
                        
                        $criteria->order = "t.tglpasienpulang DESC";

			return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
			));
        }

}