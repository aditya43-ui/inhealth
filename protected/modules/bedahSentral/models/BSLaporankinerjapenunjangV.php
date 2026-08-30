<?php

class BSLaporankinerjapenunjangV extends LaporankinerjapenunjangV {

    public $jeniskelamin,$ruanganpenunj_nama, $kelaspelayanan_nama,$tgl_masukpenunjang;
    public $total,$tarif_satuan, $qty_tindakan;
    public $jumlah, $data, $tick;
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
    
    public function searchTableBangsal()
    {
            // Warning: Please modify the following code to remove attributes that
            // should not be searched.

            $criteria=new CDbCriteria;

            $criteria->select = "t.no_rekam_medik, t.nama_pasien, t.jeniskelamin, t.daftartindakan_nama,date(tglmasukpenunjang) as tgl_masukpenunjang,
                                t.ruanganpenunj_nama,sum(t.qty_tindakan) as qty_tindakan,t.tarif_satuan, sum(t.tarif_satuan * t.qty_tindakan) as total";
            $criteria->group = "t.no_rekam_medik, t.nama_pasien, t.jeniskelamin, t.daftartindakan_nama, date(tglmasukpenunjang),t.ruanganpenunj_nama,
                                t.tarif_satuan";
			if(!empty($this->pasien_id)){
				$criteria->addCondition('pasien_id = '.$this->pasien_id);
			}
            $criteria->addBetweenCondition('t.tglmasukpenunjang',$this->tgl_awal,$this->tgl_akhir,true);
            $criteria->addCondition('ruanganpenunj_id = '.Yii::app()->user->getState('ruangan_id'));
            if(isset($this->ruanganpenunj_id)){
				if(!empty($this->ruanganpenunj_id)){
					$criteria->addCondition('ruanganpenunj_id = '.$this->ruanganpenunj_id);
				}
            }

            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
            ));
    }
    public function searchPrintBangsal()
    {
            // Warning: Please modify the following code to remove attributes that
            // should not be searched.

            $criteria=new CDbCriteria;

            $criteria->select = "t.no_rekam_medik, t.nama_pasien, t.jeniskelamin, t.daftartindakan_nama,date(tglmasukpenunjang) as tgl_masukpenunjang,
                                t.ruanganpenunj_nama,sum(t.qty_tindakan) as qty_tindakan,t.tarif_satuan, sum(t.tarif_satuan * t.qty_tindakan) as total";
            $criteria->group = "t.no_rekam_medik, t.nama_pasien, t.jeniskelamin, t.daftartindakan_nama, date(tglmasukpenunjang),t.ruanganpenunj_nama,
                                t.tarif_satuan";
			if(!empty($this->pasien_id)){
				$criteria->addCondition('pasien_id = '.$this->pasien_id);
			}
            $criteria->addBetweenCondition('t.tglmasukpenunjang',$this->tgl_awal,$this->tgl_akhir,true);            
            $criteria->addCondition('ruanganpenunj_id = '.Yii::app()->user->getState('ruangan_id'));
            if(isset($this->ruanganpenunj_id)){
				if(!empty($this->ruanganpenunj_id)){
					$criteria->addCondition('ruanganpenunj_id = '.$this->ruanganpenunj_id);
				}
            }
            $criteria->limit = -1;

            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
                    'pagination'=>false,
            ));
    }
    public function searchGrafikBangsal()
    {
            // Warning: Please modify the following code to remove attributes that
            // should not be searched.

            $criteria=new CDbCriteria;

            $criteria->select = "count(t.pasien_id) as jumlah, t.daftartindakan_nama as data, t.no_rekam_medik, t.nama_pasien, t.jeniskelamin,
                                date(t.tglmasukpenunjang) as tgl_masukpenunjang, t.ruanganpenunj_nama,
                                sum(t.qty_tindakan) as qty_tindakan,t.tarif_satuan, sum(t.tarif_satuan * t.qty_tindakan) as total";
            $criteria->group = "t.no_rekam_medik, t.nama_pasien, t.jeniskelamin, date(t.tglmasukpenunjang), t.daftartindakan_nama, t.ruanganpenunj_nama,
                                t.tarif_satuan";
			if(!empty($this->pasien_id)){
				$criteria->addCondition('pasien_id = '.$this->pasien_id);
			}
            $criteria->addBetweenCondition('t.tglmasukpenunjang',$this->tgl_awal,$this->tgl_akhir,true);
            $criteria->addCondition('ruanganpenunj_id = '.Yii::app()->user->getState('ruangan_id'));
            if(isset($this->ruanganpenunj_id)){
				if(!empty($this->ruanganpenunj_id)){
					$criteria->addCondition('ruanganpenunj_id = '.$this->ruanganpenunj_id);
				}
            }
            $criteria->limit = -1;

            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
                    'pagination'=>false,
            ));
    }
    public function searchTableKelas()
    {
        // Warning: Please modify the following code to remove attributes that
            // should not be searched.

            $criteria=new CDbCriteria;

            $criteria->select = "t.no_rekam_medik, t.nama_pasien, t.jeniskelamin, date(t.tglmasukpenunjang) as tgl_masukpenunjang, t.daftartindakan_nama, 
                                t.ruanganpenunj_nama,t.kelaspelayanan_id,kelaspelayanan_nama,sum(t.qty_tindakan) as qty_tindakan,t.tarif_satuan,
                                sum(t.tarif_satuan * t.qty_tindakan) as total";
            $criteria->group = "t.no_rekam_medik, t.nama_pasien, t.jeniskelamin,t.kelaspelayanan_id, date(t.tglmasukpenunjang), t.daftartindakan_nama, 
                                t.ruanganpenunj_nama, t.tarif_satuan,kelaspelayanan_nama";
			if(!empty($this->pasien_id)){
				$criteria->addCondition('pasien_id = '.$this->pasien_id);
			}                        
            $criteria->addBetweenCondition('t.tglmasukpenunjang',$this->tgl_awal,$this->tgl_akhir,true);
			if(!empty($this->kelaspelayanan_id)){
				$criteria->addCondition('kelaspelayanan_id = '.$this->kelaspelayanan_id);
			}
            $criteria->compare('LOWER(nama_pasien)',strtolower($this->nama_pasien),true);
            $criteria->compare('LOWER(no_rekam_medik)',strtolower($this->no_rekam_medik),true);
            $criteria->compare('LOWER(tgl_rekam_medik)',strtolower($this->tgl_rekam_medik),true);
			if(!empty($this->pendaftaran_id)){
				$criteria->addCondition('pendaftaran_id = '.$this->pendaftaran_id);
			}
            $criteria->compare('LOWER(no_pendaftaran)',strtolower($this->no_pendaftaran),true);
            $criteria->compare('LOWER(tgl_pendaftaran)',strtolower($this->tgl_pendaftaran),true);
            $criteria->compare('LOWER(kelaspelayanan_nama)',strtolower($this->kelaspelayanan_nama),true);
            $criteria->compare('LOWER(no_masukpenunjang)',strtolower($this->no_masukpenunjang),true);
            $criteria->compare('LOWER(tglmasukpenunjang)',strtolower($this->tglmasukpenunjang),true);
            $criteria->compare('LOWER(daftartindakan_nama)',strtolower($this->daftartindakan_nama),true);
            $criteria->addCondition('ruanganpenunj_id = '.Yii::app()->user->getState('ruangan_id'));

            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
            ));
    }
    public function searchPrintKelas()
    {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria=new CDbCriteria;

        $criteria->select = "t.no_rekam_medik, t.nama_pasien, t.jeniskelamin, date(t.tglmasukpenunjang) as tgl_masukpenunjang, t.daftartindakan_nama, t.kelaspelayanan_nama,
                            t.kelaspelayanan_id,sum(t.qty_tindakan) as qty_tindakan,t.tarif_satuan, sum(t.tarif_satuan * t.qty_tindakan) as total";
        $criteria->group = "t.no_rekam_medik, t.nama_pasien, t.jeniskelamin, date(t.tglmasukpenunjang),t.kelaspelayanan_id,t.daftartindakan_nama, 
                            t.kelaspelayanan_nama, t.tarif_satuan";
		if(!empty($this->pasien_id)){
			$criteria->addCondition('pasien_id = '.$this->pasien_id);
		}
        $criteria->addBetweenCondition('t.tglmasukpenunjang',$this->tgl_awal,$this->tgl_akhir,true);
		if(!empty($this->kelaspelayanan_id)){
			$criteria->addCondition('kelaspelayanan_id = '.$this->kelaspelayanan_id);
		}
        $criteria->compare('LOWER(nama_pasien)',strtolower($this->nama_pasien),true);
        $criteria->compare('LOWER(no_rekam_medik)',strtolower($this->no_rekam_medik),true);
        $criteria->compare('LOWER(tgl_rekam_medik)',strtolower($this->tgl_rekam_medik),true);
		if(!empty($this->pendaftaran_id)){
			$criteria->addCondition('pendaftaran_id = '.$this->pendaftaran_id);
		}
        $criteria->compare('LOWER(no_pendaftaran)',strtolower($this->no_pendaftaran),true);
        $criteria->compare('LOWER(tgl_pendaftaran)',strtolower($this->tgl_pendaftaran),true);
        $criteria->compare('LOWER(kelaspelayanan_nama)',strtolower($this->kelaspelayanan_nama),true);
        $criteria->compare('LOWER(no_masukpenunjang)',strtolower($this->no_masukpenunjang),true);
        $criteria->compare('LOWER(tglmasukpenunjang)',strtolower($this->tglmasukpenunjang),true);
        $criteria->compare('LOWER(daftartindakan_nama)',strtolower($this->daftartindakan_nama),true);
        $criteria->addCondition('ruanganpenunj_id = '.Yii::app()->user->getState('ruangan_id'));
        $criteria->limit = -1;

        return new CActiveDataProvider($this, array(
                'criteria'=>$criteria,
                'pagination'=>false,
        ));
    }
    public function searchGrafikKelas()
    {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria=new CDbCriteria;

        $criteria->select = "count(t.pasien_id) as jumlah, t.kelaspelayanan_nama as data, t.no_rekam_medik, t.nama_pasien, t.jeniskelamin, 
                            t.kelaspelayanan_id,date(t.tglmasukpenunjang) as tgl_masukpenunjang, t.daftartindakan_nama,sum(t.qty_tindakan) as qty_tindakan,t.tarif_satuan, 
                            sum(t.tarif_satuan * t.qty_tindakan) as total";
        $criteria->group = "t.no_rekam_medik, kelaspelayanan_nama, t.nama_pasien, t.jeniskelamin, t.kelaspelayanan_id,date(t.tglmasukpenunjang), 
                            t.daftartindakan_nama,t.tarif_satuan";
        $criteria->addBetweenCondition('t.tglmasukpenunjang',$this->tgl_awal,$this->tgl_akhir,true);
		if(!empty($this->pasien_id)){
			$criteria->addCondition('pasien_id = '.$this->pasien_id);
		}     
		if(!empty($this->kelaspelayanan_id)){
			$criteria->addCondition('kelaspelayanan_id = '.$this->kelaspelayanan_id);
		}
        $criteria->compare('LOWER(nama_pasien)',strtolower($this->nama_pasien),true);
        $criteria->compare('LOWER(no_rekam_medik)',strtolower($this->no_rekam_medik),true);
        $criteria->compare('LOWER(tgl_rekam_medik)',strtolower($this->tgl_rekam_medik),true);
		if(!empty($this->pendaftaran_id)){
			$criteria->addCondition('pendaftaran_id = '.$this->pendaftaran_id);
		}
        $criteria->compare('LOWER(no_pendaftaran)',strtolower($this->no_pendaftaran),true);
        $criteria->compare('LOWER(tgl_pendaftaran)',strtolower($this->tgl_pendaftaran),true);
        $criteria->compare('LOWER(kelaspelayanan_nama)',strtolower($this->kelaspelayanan_nama),true);
        $criteria->compare('LOWER(no_masukpenunjang)',strtolower($this->no_masukpenunjang),true);
        $criteria->compare('LOWER(tglmasukpenunjang)',strtolower($this->tglmasukpenunjang),true);
        $criteria->compare('LOWER(daftartindakan_nama)',strtolower($this->daftartindakan_nama),true);
        $criteria->addCondition('ruanganpenunj_id = '.Yii::app()->user->getState('ruangan_id'));
        $criteria->limit = -1;

        return new CActiveDataProvider($this, array(
                'criteria'=>$criteria,
                'pagination'=>false,
        ));
    }
    protected function afterFind(){
            foreach($this->metadata->tableSchema->columns as $columnName => $column){
                $format = new MyFormatter();
                if (!strlen($this->tgl_masukpenunjang)) continue;

                if ($column->dbType == 'date'){                         
                   $this->tgl_masukpenunjang = $format->formatDateTimeId($this->tgl_masukpenunjang);
                }elseif ($column->dbType == 'timestamp without time zone'){
                        $this->tgl_masukpenunjang = $format->formatDateTimeId($this->tgl_masukpenunjang);
                }
            }
            return true;
        }


}

?>
