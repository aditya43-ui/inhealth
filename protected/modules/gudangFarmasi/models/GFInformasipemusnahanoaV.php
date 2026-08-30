<?php

class GFInformasipemusnahanoaV extends InformasipemusnahanoaV
{
	public $tgl_awal;
        public $tgl_akhir;
	
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return InformasipemusnahanoaV the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function searchInformasi()
	{
	    // Warning: Please modify the following code to remove attributes that
	    // should not be searched.

	    $criteria=new CDbCriteria;

	    $criteria->addBetweenCondition('DATE(tglpemusnahan)',$this->tgl_awal,$this->tgl_akhir,true);
	    if(!empty($this->pemusnahanobatalkes_id)){
		    $criteria->addCondition('pemusnahanobatalkes_id = '.$this->pemusnahanobatalkes_id);
	    }
	    $criteria->compare('LOWER(nopemusnahan)',strtolower($this->nopemusnahan),true);
	    $criteria->compare('LOWER(keterangan)',strtolower($this->keterangan),true);
	    if(!empty($this->instalasi_id)){
		    $criteria->addCondition('instalasi_id = '.$this->instalasi_id);
	    }
	    $criteria->compare('LOWER(instalasi_nama)',strtolower($this->instalasi_nama),true);
	    if(!empty($this->ruangan_id)){
		    $criteria->addCondition('ruangan_id = '.$this->ruangan_id);
	    }
	    $criteria->compare('LOWER(ruangan_nama)',strtolower($this->ruangan_nama),true);
	    if(!empty($this->pegawaipelaksana_id)){
		    $criteria->addCondition('pegawaipelaksana_id = '.$this->pegawaipelaksana_id);
	    }
	    $criteria->compare('LOWER(pegawaipelaksana_nip)',strtolower($this->pegawaipelaksana_nip),true);
	    $criteria->compare('LOWER(pegawaipelaksana_jenisidentitas)',strtolower($this->pegawaipelaksana_jenisidentitas),true);
	    $criteria->compare('LOWER(pegawaipelaksana_noidentitas)',strtolower($this->pegawaipelaksana_noidentitas),true);
	    $criteria->compare('LOWER(pegawaipelaksana_gelardepan)',strtolower($this->pegawaipelaksana_gelardepan),true);
	    $criteria->compare('LOWER(pegawaipelaksana_nama)',strtolower($this->pegawaipelaksana_nama),true);
	    $criteria->compare('LOWER(pegawaipelaksana_gelarbelakang)',strtolower($this->pegawaipelaksana_gelarbelakang),true);
	    if(!empty($this->pegawaimengetahui_id)){
		    $criteria->addCondition('pegawaimengetahui_id = '.$this->pegawaimengetahui_id);
	    }
	    $criteria->compare('LOWER(pegawaimengetahui_nip)',strtolower($this->pegawaimengetahui_nip),true);
	    $criteria->compare('LOWER(pegawaimengetahui_jenisidentitas)',strtolower($this->pegawaimengetahui_jenisidentitas),true);
	    $criteria->compare('LOWER(pegawaimengetahui_noidentitas)',strtolower($this->pegawaimengetahui_noidentitas),true);
	    $criteria->compare('LOWER(pegawaimengetahui_gelardepan)',strtolower($this->pegawaimengetahui_gelardepan),true);
	    $criteria->compare('LOWER(pegawaimengetahui_nama)',strtolower($this->pegawaimengetahui_nama),true);
	    $criteria->compare('LOWER(pegawaimengetahui_gelarbelakang)',strtolower($this->pegawaimengetahui_gelarbelakang),true);
	    if(!empty($this->pegawaimenyetujui_id)){
		    $criteria->addCondition('pegawaimenyetujui_id = '.$this->pegawaimenyetujui_id);
	    }
	    $criteria->compare('LOWER(pegawaimenyetujui_nip)',strtolower($this->pegawaimenyetujui_nip),true);
	    $criteria->compare('LOWER(pegawaimenyetujui_jenisdentitas)',strtolower($this->pegawaimenyetujui_jenisdentitas),true);
	    $criteria->compare('LOWER(pegawaimenyetujui_noidentitas)',strtolower($this->pegawaimenyetujui_noidentitas),true);
	    $criteria->compare('LOWER(pegawaimenyetujui_gelardepan)',strtolower($this->pegawaimenyetujui_gelardepan),true);
	    $criteria->compare('LOWER(pegawaimenyetujui_nama)',strtolower($this->pegawaimenyetujui_nama),true);
	    $criteria->compare('LOWER(pegawaimenyetujui_gelarbelakang)',strtolower($this->pegawaimenyetujui_gelarbelakang),true);
	    $criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
	    $criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
	    if(!empty($this->create_loginpemakai_id)){
		    $criteria->addCondition('create_loginpemakai_id = '.$this->create_loginpemakai_id);
	    }
	    if(!empty($this->update_loginpemakai_id)){
		    $criteria->addCondition('update_loginpemakai_id = '.$this->update_loginpemakai_id);
	    }
	    if(!empty($this->create_ruangan)){
		    $criteria->addCondition('create_ruangan = '.$this->create_ruangan);
	    }

	    $criteria->limit=10;

	    return new CActiveDataProvider($this, array(
		    'criteria'=>$criteria,
	    ));
	}
	
	public function getPegawaimengetahuiLengkap()
        {
            return (isset($this->pegawaimengetahui_gelardepan) ? $this->pegawaimengetahui_gelardepan : "").' '.$this->pegawaimengetahui_nama.(isset($this->pegawaimengetahui_gelarbelakang) ? ', '.$this->pegawaimengetahui_gelardepan : "");
        }

        public function getPegawaimenyetujuiLengkap()
        {
            return (isset($this->pegawaimenyetujui_gelardepan) ? $this->pegawaimenyetujui_gelardepan : "").' '.$this->pegawaimenyetujui_nama.(isset($this->pegawaimenyetujui_gelarbelakang) ? ', '.$this->pegawaimenyetujui_gelardepan : "");
        }

}