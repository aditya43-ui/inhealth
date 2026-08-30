<?php

class RMPenjualanresepT extends PenjualanresepT {

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
    
    public function searchDetailTerapi($data)
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->with = array('obatalkes');
		if (!empty($this->penjualanresep_id)){
			$criteria->addCondition('penjualanresep_id ='.$this->penjualanresep_id);
		}
		if (!empty($this->reseptur_id)){
			$criteria->addCondition('reseptur_id ='.$this->reseptur_id);
		}
		if (!empty($this->pasienadmisi_id)){
			$criteria->addCondition('pasienadmisi_id ='.$this->pasienadmisi_id);
		}
		if (!empty($this->penjamin_id)){
			$criteria->addCondition('penjamin_id ='.$this->penjamin_id);
		}
		if (!empty($this->carabayar_id)){
			$criteria->addCondition('carabayar_id ='.$this->carabayar_id);
		}
		if (!empty($this->pendaftaran_id)){
			$criteria->addCondition('t.pendaftaran_id ='.$this->pendaftaran_id);
		}
		if (!empty($this->ruangan_id)){
			$criteria->addCondition('t.ruangan_id ='.$this->ruangan_id);
		}
		if (!empty($this->pegawai_id)){
			$criteria->addCondition('pegawai_id ='.$this->pegawai_id);
		}
		if (!empty($this->kelaspelayanan_id)){
			$criteria->addCondition('kelaspelayanan_id ='.$this->kelaspelayanan_id);
		}
		if (!empty($this->pasien_id)){
			$criteria->addCondition('pasien_id ='.$this->pasien_id);
		}
                $criteria->condition = 't.pendaftaran_id = '.$data;
//		$criteria->compare('LOWER(tglpenjualan)',strtolower($this->tglpenjualan),true);
//		$criteria->compare('LOWER(jenispenjualan)',strtolower($this->jenispenjualan),true);
//		$criteria->compare('LOWER(tglresep)',strtolower($this->tglresep),true);
//		$criteria->compare('LOWER(noresep)',strtolower($this->noresep),true);
//		$criteria->compare('totharganetto',$this->totharganetto);
//		$criteria->compare('totalhargajual',$this->totalhargajual);
//		$criteria->compare('totaltarifservice',$this->totaltarifservice);
//		$criteria->compare('biayaadministrasi',$this->biayaadministrasi);
//		$criteria->compare('biayakonseling',$this->biayakonseling);
//		$criteria->compare('pembulatanharga',$this->pembulatanharga);
//		$criteria->compare('jasadokterresep',$this->jasadokterresep);
//		$criteria->compare('LOWER(instalasiasal_nama)',strtolower($this->instalasiasal_nama),true);
//		$criteria->compare('LOWER(ruanganasal_nama)',strtolower($this->ruanganasal_nama),true);
//		$criteria->compare('discount',$this->discount);
//		$criteria->compare('subsidiasuransi',$this->subsidiasuransi);
//		$criteria->compare('subsidipemerintah',$this->subsidipemerintah);
//		$criteria->compare('subsidirs',$this->subsidirs);
//		$criteria->compare('iurbiaya',$this->iurbiaya);
//		$criteria->compare('lamapelayanan',$this->lamapelayanan);
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