<?php

class FAInformasiresepturV extends InformasiresepturV
{
	public $tgl_awal,$tgl_akhir, $statusJual, $statuspasien, $ppds_id;
    public $antrianfarmasi_id;

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function searchInformasiPasienResep()
    {
        $criteria=$this->criteriaSearch();
        if ($this->statuspasien == 1) {
            $criteria->addCondition('ispasienbaru is not null and ispasienbaru is not false and ispasienbaru is true');
        }else if($this->statuspasien == 2){
            $criteria->addCondition('isterapipulang is not null and isterapipulang is not false and isterapipulang is true');
        }
        if (!empty($this->ruanganreseptur_id)) {
            //$r = RuanganM::model()->findByPk(Yii::app()->user->getState('ruangan_id'));
            //$cekIns = Params::getInsPelByApotek($r);
            //if (Yii::app()->user->getState('ruangan_nama') == "Apotek Rawat Jalan"):
              //  $criteria->addInCondition('instalasireseptur_id', array(2));
           // else:
              //  $criteria->addInCondition('instalasireseptur_id', array(2,3,4));//menampung semua 
            //endif;            
              //$criteria->addInCondition('instalasireseptur_id', $cekIns);//menampung semua 
			if (is_array($this->ruanganreseptur_id)){
				$criteria->addInCondition("ruanganreseptur_id",$this->ruanganreseptur_id);
			}else{
				$criteria->addCondition("ruanganreseptur_id = '".$this->ruanganreseptur_id."' ");
			}
        }
		
		if (!empty($this->instalasireseptur_id)){
			if (is_array($this->instalasireseptur_id)){
				$criteria->addInCondition("instalasireseptur_id",$this->instalasireseptur_id);
			}else{
				$criteria->addCondition("instalasireseptur_id = '".$this->instalasireseptur_id."' ");
			}
		}
        
        if(!empty($this->carabayar_id)) {
            if(is_array($this->carabayar_id)) {
                $criteria->addInCondition('carabayar_id', $this->carabayar_id);
            } else {
                $criteria->addCondition('carabayar_id = ' . $this->carabayar_id);
            }
        }
        if ($this->statusJual == 1) {
            $criteria->addCondition('penjualanresep_id is not null');
        } else if ($this->statusJual == 2) {
            $criteria->addCondition('penjualanresep_id is null');
        }
        
        if ($this->isbatal == 0) {
            $criteria->addCondition('isbatal is null or isbatal is false');
        } else if ($this->isbatal == 1) {
            $criteria->addCondition('isbatal is true');
        }
        if (!empty($this->no_rekam_medik) || !empty($this->nama_pasien)) {
			$criteria->compare('LOWER(t.no_rekam_medik)',strtolower($this->no_rekam_medik),true);
			$criteria->compare('LOWER(t.nama_pasien)',strtolower($this->nama_pasien),true);
            $criteria->addBetweenCondition('date(t.tglreseptur)', $this->tgl_awal, $this->tgl_akhir);

		}else{
            $criteria->addBetweenCondition('date(t.tglreseptur)', $this->tgl_awal, $this->tgl_akhir);
		}
        $criteria->order = 'CASE WHEN is_cito = true THEN 0 ELSE 1 END, t.tglreseptur DESC';
        // $criteria->join = "join pendaftaran_t p on p.pendaftaran_id = t.pendaftaran_id";
        $criteria->compare('lower(t.statusperiksa)', strtolower($this->statusperiksa), true);

        $criteria->compare('lower(t.pasien_noidentitas)', strtolower($this->pasien_noidentitas), true);
        // $criteria->limit=10;
        
        return new CActiveDataProvider($this, array(
                'criteria'=>$criteria,
        ));
    }
	
	public function GetNoPenjualanResep($reseptur_id)
    {
		$modPenjualans = FAPenjualanResepT::model()->findAllByAttributes(array('reseptur_id'=>$reseptur_id));
		$echo ='';
		if(count((array)$modPenjualans) > 0){
			foreach($modPenjualans as $i => $modPenjualan){
				$echo .= $modPenjualan->noresep."<br>";
			}
		}
		return $echo;
	}
    
    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function searchAntrianResep() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = $this->criteriaSearch();
        $criteria->select = "t.*, a.antrianfarmasi_id";
        $criteria->join = "left join antrianfarmasi_t a on a.reseptur_id = t.reseptur_id";
        $criteria->addCondition('penjualanresep_id is null');
        $criteria->limit = 10;

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }
    
    public function getAlergiObat() {
        $nama = ''; 
        $modAnamnesa = AnamnesaT::model()->findAllByAttributes(array('pendaftaran_id' => $this->pendaftaran_id));
        
        
        if (count((array)$modAnamnesa)) {
            $no = 1;
            $checkAlergi = 0;
            foreach ($modAnamnesa as $anamnesa => $val) {
                if(!empty(trim($val->riwayatalergiobat))){
                    $val->riwayatalergiobat = preg_replace('/\s+/', '', $val->riwayatalergiobat);
                    $datatable = explode(',', trim($val->riwayatalergiobat));
                    if(!empty($datatable)){
                        foreach ($datatable as $key => $value) {
                            $nama .=' ' . $no . '.' . $value . '<br>';
                            $no++;
                        }
                    }
                    $checkAlergi++;
                }else{
                    if($checkAlergi > 1){
                        $checkAlergi--;
                    }
                }
            }    
            if($checkAlergi == 0){
                $nama = 'TIDAK ADA'; 
            }
        }else{
            $nama = 'TIDAK ADA'; 
        }
        return $nama;
    }
}

