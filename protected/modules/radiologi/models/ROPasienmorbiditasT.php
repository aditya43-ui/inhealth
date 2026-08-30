<?php
class ROPasienmorbiditasT extends PasienmorbiditasT
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
                $criteria->addCondition('pendaftaran_id = '.$pendaftaran_id);
            }else{
				if(!empty($this->pendaftaran_id)){
					$criteria->addCondition("pendaftaran_id = ".$this->pendaftaran_id);					
				}
            }
			if(!empty($this->pasienmorbiditas_id)){
				$criteria->addCondition("pasienmorbiditas_id = ".$this->pasienmorbiditas_id);					
			}
			if(!empty($this->kamarruangan_id)){
				$criteria->addCondition("kamarruangan_id = ".$this->kamarruangan_id);					
			}
			if(!empty($this->kelompokdiagnosa_id)){
				$criteria->addCondition("kelompokdiagnosa_id = ".$this->kelompokdiagnosa_id);					
			}
			if(!empty($this->ruangan_id)){
				$criteria->addCondition("ruangan_id = ".$this->ruangan_id);					
			}
			if(!empty($this->pasienadmisi_id)){
				$criteria->addCondition("pasienadmisi_id = ".$this->pasienadmisi_id);					
			}
			if(!empty($this->pasien_id)){
				$criteria->addCondition("pasien_id = ".$this->pasien_id);					
			}
			if(!empty($this->jenisin_id)){
				$criteria->addCondition("jenisin_id = ".$this->jenisin_id);					
			}
			if(!empty($this->sebabdiagnosa_id)){
				$criteria->addCondition("sebabdiagnosa_id = ".$this->sebabdiagnosa_id);					
			}          
			if(!empty($this->pegawai_id)){
				$criteria->addCondition("pegawai_id = ".$this->pegawai_id);					
			}          
			if(!empty($this->kelompokumur_id)){
				$criteria->addCondition("kelompokumur_id = ".$this->kelompokumur_id);					
			}
			if(!empty($this->penyebabluarcedera_id)){
				$criteria->addCondition("penyebabluarcedera_id = ".$this->penyebabluarcedera_id);					
			}
			if(!empty($this->diagnosa_id)){
				$criteria->addCondition("diagnosa_id = ".$this->diagnosa_id);					
			}
			if(!empty($this->jenisketunaan_id)){
				$criteria->addCondition("jenisketunaan_id = ".$this->jenisketunaan_id);					
			}
			if(!empty($this->jeniskasuspenyakit_id)){
				$criteria->addCondition("jeniskasuspenyakit_id = ".$this->jeniskasuspenyakit_id);					
			}
			if(!empty($this->golonganumur_id)){
				$criteria->addCondition("golonganumur_id = ".$this->golonganumur_id);					
			}
			if(!empty($this->morfologineoplasma_id)){
				$criteria->addCondition("morfologineoplasma_id = ".$this->morfologineoplasma_id);					
			}
			if(!empty($this->sebabin_id)){
				$criteria->addCondition("sebabin_id = ".$this->sebabin_id);					
			}
			if(!empty($this->diagnosaicdix_id)){
				$criteria->addCondition("diagnosaicdix_id = ".$this->diagnosaicdix_id);					
			}
            $criteria->compare('LOWER(tglmorbiditas)',strtolower($this->tglmorbiditas),true);
            $criteria->compare('LOWER(kasusdiagnosa)',strtolower($this->kasusdiagnosa),true);
            $criteria->compare('umur_0_28hr',$this->umur_0_28hr);
            $criteria->compare('umur_28hr_1thn',$this->umur_28hr_1thn);
            $criteria->compare('umur_1_4thn',$this->umur_1_4thn);
            $criteria->compare('umur_5_14thn',$this->umur_5_14thn);
            $criteria->compare('umur_15_24thn',$this->umur_15_24thn);
            $criteria->compare('umur_25_44thn',$this->umur_25_44thn);
            $criteria->compare('umur_45_64thn',$this->umur_45_64thn);
            $criteria->compare('umur_65',$this->umur_65);
            $criteria->compare('infeksinosokomial',$this->infeksinosokomial);
            $criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
            $criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
            $criteria->compare('LOWER(create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);
            $criteria->compare('LOWER(update_loginpemakai_id)',strtolower($this->update_loginpemakai_id),true);
            $criteria->compare('LOWER(create_ruangan)',strtolower($this->create_ruangan),true);
            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
            ));
	}

}