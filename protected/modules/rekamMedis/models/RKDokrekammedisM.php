<?php

class RKDokrekammedisM extends DokrekammedisM {

	public $namadepan,$ceklis,$default,$nama_pasien,$tanggal_lahir,$tgl_awal,$tgl_akhir;
    public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
    /**
    * kriteria pencarian untuk dashboard
    * @return \CActiveDataProvider
    */
   
    public function searchDashboard()
    {
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.
		$criteria=new CDbCriteria;
		$criteria->compare('DATE(tglrekammedis)', date("Y-m-d"));
		$criteria->with=array('warnadok','lokasirak','subrak');
		$criteria->order = 'tglrekammedis DESC';
		$criteria->limit = 10;

		return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
		));
    }
	
	public function searchinformasi()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
		
		$criteria->with = array('pasien');
			
		// if (!empty($this->ceklis)==1) {
        // 	$criteria->addBetweenCondition('DATE(tglrekammedis)',$this->tgl_awal,$this->tgl_akhir);
        // }else{
		// $criteria->addBetweenCondition('DATE(tglrekammedis)',$this->tgl_awal,$this->tgl_akhir);
		// }
		

		if(!empty($this->ceklis) && $this->ceklis == true){
			
			$criteria->addBetweenCondition('DATE(tglrekammedis)',$this->tgl_awal,$this->tgl_akhir);
		}
		
		if (!empty($this->dokrekammedis_id)){
		$criteria->addCondition('t.dokrekammedis_id ='.$this->dokrekammedis_id);
		}
		if (!empty($this->warnadokrm_id)){
		$criteria->addCondition('t.warnadokrm_id ='.$this->warnadokrm_id);
		}
		if (!empty($this->subrak_id)){
		$criteria->addCondition('t.subrak_id ='.$this->subrak_id);
		}
		if (!empty($this->lokasirak_id)){
		$criteria->addCondition('t.lokasirak_id ='.$this->lokasirak_id);
		}
		if (!empty($this->pasien_id)){
		$criteria->addCondition('t.pasien_id ='.$this->pasien_id);
		}
		
		$criteria->compare('LOWER(pasien.nama_pasien)', strtolower($this->nama_pasien),true);
		$criteria->compare('LOWER(pasien.namadepan)',$this->namadepan,true);
		$criteria->compare('LOWER(pasien.tanggal_lahir)',$this->tanggal_lahir,true);
		
		$criteria->compare('LOWER(nodokumenrm)',strtolower($this->nodokumenrm),true);
		
		$criteria->compare('LOWER(tglmasukrak)',strtolower($this->tglmasukrak),true);
		$criteria->compare('LOWER(t.statusrekammedis)',strtolower($this->statusrekammedis),true);
		$criteria->compare('LOWER(tglkeluarakhir)',strtolower($this->tglkeluarakhir),true);
		$criteria->compare('LOWER(tglmasukakhir)',strtolower($this->tglmasukakhir),true);
		$criteria->compare('LOWER(nomortertier)',strtolower($this->nomortertier),true);
		$criteria->compare('LOWER(nomorsekunder)',strtolower($this->nomorsekunder),true);
		$criteria->compare('LOWER(nomorprimer)',strtolower($this->nomorprimer),true);
		$criteria->compare('LOWER(warnanorm_i)',strtolower($this->warnanorm_i),true);
		$criteria->compare('LOWER(warnanorm_ii)',strtolower($this->warnanorm_ii),true);
		$criteria->compare('LOWER(tgl_in_aktif)',strtolower($this->tgl_in_aktif),true);
		$criteria->compare('LOWER(tglpemusnahan)',strtolower($this->tglpemusnahan),true);
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
		$criteria->compare('LOWER(create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);
		$criteria->compare('LOWER(update_loginpemakai_id)',strtolower($this->update_loginpemakai_id),true);
		$criteria->compare('LOWER(create_ruangan)',strtolower($this->create_ruangan),true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public function getTampilkanPosisiTerakhir(){
		$posisi = '';
		$criteria = new CDbCriteria();
		if(!empty($this->dokrekammedis_id)){
			$criteria->addCondition('dokrekammedis_id = '.$this->dokrekammedis_id);
		}
		$criteria->order = 'pengirimanrm_id DESC';
		$criteria->limit = 1;
                $link = "";
		$model = RKPengirimanrmT::model()->find($criteria);

                
                
		if(!empty($model)){
                        // return $model->pengirimanrm_id;
                        if ($model->ruangan_id == Yii::app()->user->getState('ruangan_id')) {
                            $link = CHtml::link("<i class=\"icon-form-detail\"></i>", "#", array(
                                'rel'=>'tooltip',
                                'title'=>'Klik untuk menerima Dokumen Rekam Medis',
                                'onclick'=>'terimaRM('.$model->pengirimanrm_id.'); return false;',
                            ));
                        }
			if(empty($model->tglterimadokrm)){
				$posisi = $model->ruanganpengirim->instalasi->instalasi_nama." / ".$model->ruanganpengirim->ruangan_nama."<br/>".$link;
			}else{
				$posisi = $model->ruanganpenerima->instalasi->instalasi_nama." / ".$model->ruanganpenerima->ruangan_nama;
			}
		}else{
			$criteria2 = new CDbCriteria();
			if(!empty($this->create_ruangan)){
				$criteria2->addCondition('ruangan_id ='.$this->create_ruangan);
			}
			$modRuangan = RuanganM::model()->find($criteria2);
			if(!empty($modRuangan)){
				$posisi = $modRuangan->instalasi->instalasi_nama." / ".$modRuangan->ruangan_nama;
			}
		}

		return isset($posisi) ? $posisi : "";
	}
}