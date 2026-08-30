<?php
class LBPasienmorbiditasT extends PasienmorbiditasT
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PasienmorbiditasT the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        public function searchRiwayatDiagnosa($pendaftaran_id = null)
	{
            // Warning: Please modify the following code to remove attributes that
            // should not be searched.

            $criteria=new CDbCriteria;
            
            if(!empty($pendaftaran_id)){
                $criteria->addCondition('pendaftaran_id='.$pendaftaran_id);
            }else{
				if(!empty($this->pendaftaran_id)){
					$criteria->addCondition('pendaftaran_id = '.$this->pendaftaran_id);
				}
            }
			if(!empty($this->pasienmorbiditas_id)){
				$criteria->addCondition('pasienmorbiditas_id = '.$this->pasienmorbiditas_id);
			}
			if(!empty($this->kelompokdiagnosa_id)){
				$criteria->addCondition('kelompokdiagnosa_id = '.$this->kelompokdiagnosa_id);
			}
			if(!empty($this->ruangan_id)){
				$criteria->addCondition('ruangan_id = '.$this->ruangan_id);
			}
			if(!empty($this->pasienadmisi_id)){
				$criteria->addCondition('pasienadmisi_id = '.$this->pasienadmisi_id);
			}
			if(!empty($this->pasien_id)){
				$criteria->addCondition('pasien_id = '.$this->pasien_id);
			}
			if(!empty($this->jenisin_id)){
				$criteria->addCondition('jenisin_id = '.$this->jenisin_id);
			}
			if(!empty($this->sebabdiagnosa_id)){
				$criteria->addCondition('sebabdiagnosa_id = '.$this->sebabdiagnosa_id);
			}        
			if(!empty($this->pegawai_id)){
				$criteria->addCondition('pegawai_id = '.$this->pegawai_id);
			}
			if(!empty($this->kelompokumur_id)){
				$criteria->addCondition('kelompokumur_id = '.$this->kelompokumur_id);
			}
			if(!empty($this->penyebabluarcedera_id)){
				$criteria->addCondition('penyebabluarcedera_id = '.$this->penyebabluarcedera_id);
			}
			if(!empty($this->diagnosa_id)){
				$criteria->addCondition('diagnosa_id = '.$this->diagnosa_id);
			}
			if(!empty($this->jenisketunaan_id)){
				$criteria->addCondition('jenisketunaan_id = '.$this->jenisketunaan_id);
			}
			if(!empty($this->jeniskasuspenyakit_id)){
				$criteria->addCondition('jeniskasuspenyakit_id = '.$this->jeniskasuspenyakit_id);
			}
			if(!empty($this->golonganumur_id)){
				$criteria->addCondition('golonganumur_id = '.$this->golonganumur_id);
			}
			if(!empty($this->morfologineoplasma_id)){
				$criteria->addCondition('morfologineoplasma_id = '.$this->morfologineoplasma_id);
			}
			if(!empty($this->sebabin_id)){
				$criteria->addCondition('sebabin_id = '.$this->sebabin_id);
			}
			if(!empty($this->diagnosaicdix_id)){
				$criteria->addCondition('diagnosaicdix_id = '.$this->diagnosaicdix_id);
			}
            $criteria->compare('LOWER(tglmorbiditas)',strtolower($this->tglmorbiditas),true);
            $criteria->compare('LOWER(kasusdiagnosa)',strtolower($this->kasusdiagnosa),true);
            $criteria->compare('infeksinosokomial',$this->infeksinosokomial);
			
            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
            ));
	}

}