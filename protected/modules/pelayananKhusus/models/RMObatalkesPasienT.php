<?php

class RMObatalkesPasienT extends ObatalkespasienT
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return AnamnesaT the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

        public function searchDetailPemakaianBahan($data)
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
		
		if (!empty($this->obatalkespasien_id)){
			$criteria->addCondition('obatalkespasien_id ='.$this->obatalkespasien_id);
		}
		if (!empty($this->penjamin_id)){
			$criteria->addCondition('penjamin_id ='.$this->penjamin_id);
		}
		if (!empty($this->carabayar_id)){
			$criteria->addCondition('carabayar_id ='.$this->carabayar_id);
		}
		if (!empty($this->daftartindakan_id)){
			$criteria->addCondition('daftartindakan_id ='.$this->daftartindakan_id);
		}
		if (!empty($this->sumberdana_id)){
			$criteria->addCondition('sumberdana_id ='.$this->sumberdana_id);
		}
		if (!empty($this->pasienmasukpenunjang_id)){
			$criteria->addCondition('pasienmasukpenunjang_id ='.$this->pasienmasukpenunjang_id);
		}
		if (!empty($this->pasienanastesi_id)){
			$criteria->addCondition('pasienanastesi_id ='.$this->pasienanastesi_id);
		}
		if (!empty($this->pasien_id)){
			$criteria->addCondition('pasien_id ='.$this->pasien_id);
		}
		if (!empty($this->satuankecil_id)){
			$criteria->addCondition('satuankecil_id ='.$this->satuankecil_id);
		}
		if (!empty($this->ruangan_id)){
			$criteria->addCondition('ruangan_id ='.$this->ruangan_id);
		}
		if (!empty($this->tindakanpelayanan_id)){
			$criteria->addCondition('tindakanpelayanan_id ='.$this->tindakanpelayanan_id);
		}
		if (!empty($this->tipepaket_id)){
			$criteria->addCondition('tipepaket_id ='.$this->tipepaket_id);
		}
		if (!empty($this->obatalkes_id)){
			$criteria->addCondition('obatalkes_id ='.$this->obatalkes_id);
		}
		if (!empty($this->penjualanresep_id)){
			$criteria->addCondition('penjualanresep_id ='.$this->penjualanresep_id);
		}
		if (!empty($this->pegawai_id)){
			$criteria->addCondition('pegawai_id ='.$this->pegawai_id);
		}
		if (!empty($this->racikan_id)){
			$criteria->addCondition('racikan_id ='.$this->racikan_id);
		}
		if (!empty($this->pendaftaran_id)){
			$criteria->addCondition('pendaftaran_id ='.$this->pendaftaran_id);
		}
		if (!empty($this->kelaspelayanan_id)){
			$criteria->addCondition('kelaspelayanan_id ='.$this->kelaspelayanan_id);
		}
                $criteria->condition = 'pendaftaran_id = '.$data;
//		$criteria->compare('shift_id',$this->shift_id);
//		$criteria->compare('pasienadmisi_id',$this->pasienadmisi_id);
//		$criteria->compare('LOWER(tglpelayanan)',strtolower($this->tglpelayanan),true);
//		$criteria->compare('LOWER(r)',strtolower($this->r),true);
//		$criteria->compare('rke',$this->rke);
//		$criteria->compare('permintaan_oa',$this->permintaan_oa);
//		$criteria->compare('jmlkemasan_oa',$this->jmlkemasan_oa);
//		$criteria->compare('kekuatan_oa',$this->kekuatan_oa);
//		$criteria->compare('LOWER(satuankekuatan_oa)',strtolower($this->satuankekuatan_oa),true);
//		$criteria->compare('qty_oa',$this->qty_oa);
//		$criteria->compare('hargasatuan_oa',$this->hargasatuan_oa);
//		$criteria->compare('LOWER(signa_oa)',strtolower($this->signa_oa),true);
//		$criteria->compare('harganetto_oa',$this->harganetto_oa);
//		$criteria->compare('hargajual_oa',$this->hargajual_oa);
//		$criteria->compare('LOWER(etiket)',strtolower($this->etiket),true);
//		$criteria->compare('jmlexposerad',$this->jmlexposerad);
//		$criteria->compare('LOWER(kontrasrad)',strtolower($this->kontrasrad),true);
//		$criteria->compare('biayaservice',$this->biayaservice);
//		$criteria->compare('biayakonseling',$this->biayakonseling);
//		$criteria->compare('jasadokterresep',$this->jasadokterresep);
//		$criteria->compare('biayakemasan',$this->biayakemasan);
//		$criteria->compare('biayaadministrasi',$this->biayaadministrasi);
//		$criteria->compare('tarifcyto',$this->tarifcyto);
//		$criteria->compare('discount',$this->discount);
//		$criteria->compare('subsidiasuransi',$this->subsidiasuransi);
//		$criteria->compare('subsidipemerintah',$this->subsidipemerintah);
//		$criteria->compare('subsidirs',$this->subsidirs);
//		$criteria->compare('iurbiaya',$this->iurbiaya);
//		$criteria->compare('LOWER(oa)',strtolower($this->oa),true);
//		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
//		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
//		$criteria->compare('LOWER(create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);
//		$criteria->compare('LOWER(update_loginpemakai_id)',strtolower($this->update_loginpemakai_id),true);
//		$criteria->compare('LOWER(create_ruangan)',strtolower($this->create_ruangan),true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}