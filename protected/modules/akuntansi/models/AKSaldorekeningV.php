<?php

class AKSaldorekeningV extends SaldorekeningV
{
	//public $NamaRekPeriod,$KodeRekening,$kdstruktur,$kdkelompok,$kdjenis,$kdobyek,$kdrincianobyek;
    /**
    * Returns the static model of the specified AR class.
    * @param string $className active record class name.
    * @return AnamnesaT the static model class
    */

    public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
    
	public function searchByFilter()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
		$criteria->compare('LOWER(perideawal)',strtolower($this->perideawal),true);
		$criteria->compare('(periodeposting_id)',($this->periodeposting_id));
		$criteria->compare('LOWER(sampaidgn)',strtolower($this->sampaidgn),true);
		$criteria->compare('nilai',$this->nilai);
		$criteria->compare('LOWER(matauang)',strtolower($this->matauang),true);
		$criteria->compare('jmlanggaran',$this->jmlanggaran);
		$criteria->compare('jmlsaldoawald',$this->jmlsaldoawald);
		$criteria->compare('jmlsaldoawalk',$this->jmlsaldoawalk);
		$criteria->compare('jmlmutasid',$this->jmlmutasid);
		$criteria->compare('jmlmutasik',$this->jmlmutasik);
		$criteria->compare('jmlsaldoakhird',$this->jmlsaldoakhird);
		$criteria->compare('jmlsaldoakhirk',$this->jmlsaldoakhirk);
		$criteria->compare('struktur_id',$this->struktur_id);
		$criteria->compare('LOWER(kdstruktur)',strtolower($this->kdstruktur),true);
		$criteria->compare('LOWER(nmstruktur)',strtolower($this->nmstruktur),true);
		$criteria->compare('LOWER(nmstrukturlain)',strtolower($this->nmstrukturlain),true);
		$criteria->compare('LOWER(struktur_nb)',strtolower($this->struktur_nb),true);
		$criteria->compare('struktur_aktif',$this->struktur_aktif);
		$criteria->compare('kelompok_id',$this->kelompok_id);
		$criteria->compare('LOWER(kdkelompok)',strtolower($this->kdkelompok),true);
		$criteria->compare('LOWER(nmkelompok)',strtolower($this->nmkelompok),true);
		$criteria->compare('LOWER(nmkelompoklain)',strtolower($this->nmkelompoklain),true);
		$criteria->compare('LOWER(kelompok_nb)',strtolower($this->kelompok_nb),true);
		$criteria->compare('kelompok_aktif',$this->kelompok_aktif);
		$criteria->compare('jenis_id',$this->jenis_id);
		$criteria->compare('LOWER(kdjenis)',strtolower($this->kdjenis),true);
		$criteria->compare('LOWER(nmjenis)',strtolower($this->nmjenis),true);
		$criteria->compare('LOWER(nmjenislain)',strtolower($this->nmjenislain),true);
		$criteria->compare('LOWER(jenis_nb)',strtolower($this->jenis_nb),true);
		$criteria->compare('jenis_aktif',$this->jenis_aktif);
		$criteria->compare('obyek_id',$this->obyek_id);
		$criteria->compare('LOWER(kdobyek)',strtolower($this->kdobyek),true);
		$criteria->compare('LOWER(nmobyek)',strtolower($this->nmobyek),true);
		$criteria->compare('LOWER(nmobyeklain)',strtolower($this->nmobyeklain),true);
		$criteria->compare('LOWER(obyek_nb)',strtolower($this->obyek_nb),true);
		$criteria->compare('obyek_aktif',$this->obyek_aktif);
		$criteria->compare('rincianobyek_id',$this->rincianobyek_id);
		$criteria->compare('LOWER(kdrincianobyek)',strtolower($this->kdrincianobyek),true);
		$criteria->compare('LOWER(nmrincianobyek)',strtolower($this->nmrincianobyek),true);
		$criteria->compare('LOWER(nmrincianobyeklain)',strtolower($this->nmrincianobyeklain),true);
		$criteria->compare('LOWER(rincianobyek_nb)',strtolower($this->rincianobyek_nb),true);
		$criteria->compare('LOWER(keterangan)',strtolower($this->keterangan),true);
		$criteria->compare('nourutrek',$this->nourutrek);
		$criteria->compare('rincianobyek_aktif',$this->rincianobyek_aktif);
		$criteria->compare('LOWER(kelompokrek)',strtolower($this->kelompokrek),true);
		$criteria->compare('sak',$this->sak);
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
		$criteria->compare('LOWER(create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);
		$criteria->compare('LOWER(update_loginpemakai_id)',strtolower($this->update_loginpemakai_id),true);
		$criteria->compare('LOWER(create_ruangan)',strtolower($this->create_ruangan),true);
		$criteria->compare('unitkerja_id', $this->unitkerja_id);
		$criteria->order = 'periodeposting_id desc, kdrincianobyek asc';

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}    
	public function searchByFilterPrint()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria->compare('LOWER(perideawal)',strtolower($this->perideawal),true);
		$criteria->compare('LOWER(sampaidgn)',strtolower($this->sampaidgn),true);
		$criteria->compare('nilai',$this->nilai);
		$criteria->compare('LOWER(matauang)',strtolower($this->matauang),true);
		$criteria->compare('jmlanggaran',$this->jmlanggaran);
		$criteria->compare('jmlsaldoawald',$this->jmlsaldoawald);
		$criteria->compare('jmlsaldoawalk',$this->jmlsaldoawalk);
		$criteria->compare('jmlmutasid',$this->jmlmutasid);
		$criteria->compare('jmlmutasik',$this->jmlmutasik);
		$criteria->compare('jmlsaldoakhird',$this->jmlsaldoakhird);
		$criteria->compare('jmlsaldoakhirk',$this->jmlsaldoakhirk);
		$criteria->compare('struktur_id',$this->struktur_id);
		$criteria->compare('LOWER(kdstruktur)',strtolower($this->kdstruktur),true);
		$criteria->compare('LOWER(nmstruktur)',strtolower($this->nmstruktur),true);
		$criteria->compare('LOWER(nmstrukturlain)',strtolower($this->nmstrukturlain),true);
		$criteria->compare('LOWER(struktur_nb)',strtolower($this->struktur_nb),true);
		$criteria->compare('struktur_aktif',$this->struktur_aktif);
		$criteria->compare('kelompok_id',$this->kelompok_id);
		$criteria->compare('LOWER(kdkelompok)',strtolower($this->kdkelompok),true);
		$criteria->compare('LOWER(nmkelompok)',strtolower($this->nmkelompok),true);
		$criteria->compare('LOWER(nmkelompoklain)',strtolower($this->nmkelompoklain),true);
		$criteria->compare('LOWER(kelompok_nb)',strtolower($this->kelompok_nb),true);
		$criteria->compare('kelompok_aktif',$this->kelompok_aktif);
		$criteria->compare('jenis_id',$this->jenis_id);
		$criteria->compare('LOWER(kdjenis)',strtolower($this->kdjenis),true);
		$criteria->compare('LOWER(nmjenis)',strtolower($this->nmjenis),true);
		$criteria->compare('LOWER(nmjenislain)',strtolower($this->nmjenislain),true);
		$criteria->compare('LOWER(jenis_nb)',strtolower($this->jenis_nb),true);
		$criteria->compare('jenis_aktif',$this->jenis_aktif);
		$criteria->compare('obyek_id',$this->obyek_id);
		$criteria->compare('LOWER(kdobyek)',strtolower($this->kdobyek),true);
		$criteria->compare('LOWER(nmobyek)',strtolower($this->nmobyek),true);
		$criteria->compare('LOWER(nmobyeklain)',strtolower($this->nmobyeklain),true);
		$criteria->compare('LOWER(obyek_nb)',strtolower($this->obyek_nb),true);
		$criteria->compare('obyek_aktif',$this->obyek_aktif);
		$criteria->compare('rincianobyek_id',$this->rincianobyek_id);
		$criteria->compare('LOWER(kdrincianobyek)',strtolower($this->kdrincianobyek),true);
		$criteria->compare('LOWER(nmrincianobyek)',strtolower($this->nmrincianobyek),true);
		$criteria->compare('LOWER(nmrincianobyeklain)',strtolower($this->nmrincianobyeklain),true);
		$criteria->compare('LOWER(rincianobyek_nb)',strtolower($this->rincianobyek_nb),true);
		$criteria->compare('LOWER(keterangan)',strtolower($this->keterangan),true);
		$criteria->compare('nourutrek',$this->nourutrek);
		$criteria->compare('rincianobyek_aktif',$this->rincianobyek_aktif);
		$criteria->compare('LOWER(kelompokrek)',strtolower($this->kelompokrek),true);
		$criteria->compare('sak',$this->sak);
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
		$criteria->compare('LOWER(create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);
		$criteria->compare('LOWER(update_loginpemakai_id)',strtolower($this->update_loginpemakai_id),true);
		$criteria->compare('LOWER(create_ruangan)',strtolower($this->create_ruangan),true);
		$criteria->order = 'struktur_id, kelompok_id, jenis_id, obyek_id, nourutrek';                
		$criteria->limit = -1;

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                        'pagination'=>false,
		));
	}    
	
	public function getNamaRekPeriod()
    {
		$deskripsi = "";
        $rekperiod_id = isset($this->rekperiod_id) ? $this->rekperiod_id : null;
		$modRekPeriod = AKRekperiodM::model()->findByPk($rekperiod_id);
		if(isset($modRekPeriod) && !empty($modRekPeriod)){
			$deskripsi = $modRekPeriod->deskripsi;
		}
		return $deskripsi;
    }
	
	public function getKodeRekening(){
		$kodeRekening = '';
		if ((!empty($this->kdrekening5))){
			$kodeRekening .=  $this->kdrekening5;
		}else{
			$kodeRekening .= "-";
		}
		
		return $kodeRekening;
	}
	
	public function getNamaRekening(){
		$nama_rekening = '';
		 if(!empty($this->nmrekening5)){
			$nama_rekening = $this->nmrekening5;
		}
		
		return $nama_rekening;
	}
	
	
    
    
}
?>
