<?php

class BKLaporankinerjapenunjangV extends LaporankinerjapenunjangV {

    public $jeniskelamin,$ruanganpenunj_nama, $kelaspelayanan_nama,$tgl_masukpenunjang;
    public $total,$tarif_satuan, $qty_tindakan;
    public $jumlah, $data, $tick;
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
    
    public function searchKinerja()
    {
            // Warning: Please modify the following code to remove attributes that
            // should not be searched.

            $criteria=new CDbCriteria;

            $criteria->select = "t.kelaspelayanan_id,t.kelaspelayanan_nama, t.no_rekam_medik, t.nama_pasien, t.jeniskelamin, t.daftartindakan_nama,date(tglmasukpenunjang) as tgl_masukpenunjang,
                                t.ruanganpenunj_nama,sum(t.qty_tindakan) as qty_tindakan,t.tarif_satuan, sum(t.tarif_satuan * t.qty_tindakan) as total";
            $criteria->group = "t.kelaspelayanan_id,t.kelaspelayanan_nama,t.no_rekam_medik, t.nama_pasien, t.jeniskelamin, t.daftartindakan_nama, date(tglmasukpenunjang),t.ruanganpenunj_nama,
                                t.tarif_satuan";
			if(!empty($this->pasien_id)){
				$criteria->addCondition('pasien_id = '.$this->pasien_id);
			}
            $criteria->addBetweenCondition('t.tglmasukpenunjang',$this->tgl_awal,$this->tgl_akhir,true);
            if(isset($this->ruanganpenunj_id)){
				if(!empty($this->ruanganpenunj_id)){
					$criteria->addCondition('ruanganpenunj_id = '.$this->ruanganpenunj_id);
				}
            }
            if(!empty($this->kelaspelayanan_id)){
                    if (is_array($this->kelaspelayanan_id)){
                        $criteria->addInCondition('kelaspelayanan_id',$this->kelaspelayanan_id);
                    }else{
			$criteria->addCondition('kelaspelayanan_id = '.$this->kelaspelayanan_id);
                    }
		}

            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
            ));
    }
    public function searchPrintKinerja()
    {
            // Warning: Please modify the following code to remove attributes that
            // should not be searched.

            $criteria=new CDbCriteria;

            $criteria->select = "t.kelaspelayanan_id,t.kelaspelayanan_nama,t.no_rekam_medik, t.nama_pasien, t.jeniskelamin, t.daftartindakan_nama,date(tglmasukpenunjang) as tgl_masukpenunjang,
                                t.ruanganpenunj_nama,sum(t.qty_tindakan) as qty_tindakan,t.tarif_satuan, sum(t.tarif_satuan * t.qty_tindakan) as total";
            $criteria->group = "t.kelaspelayanan_id,t.kelaspelayanan_nama,t.no_rekam_medik, t.nama_pasien, t.jeniskelamin, t.daftartindakan_nama, date(tglmasukpenunjang),t.ruanganpenunj_nama,
                                t.tarif_satuan";
			if(!empty($this->pasien_id)){
				$criteria->addCondition('pasien_id = '.$this->pasien_id);
			}
            $criteria->addBetweenCondition('t.tglmasukpenunjang',$this->tgl_awal,$this->tgl_akhir,true); 
             if(isset($this->ruanganpenunj_id)){
				if(!empty($this->ruanganpenunj_id)){
					$criteria->addCondition('ruanganpenunj_id = '.$this->ruanganpenunj_id);
				}
            }
         
            if(!empty($this->kelaspelayanan_id)){
                    if (is_array($this->kelaspelayanan_id)){
                        $criteria->addInCondition('kelaspelayanan_id',$this->kelaspelayanan_id);
                    }else{
			$criteria->addCondition('kelaspelayanan_id = '.$this->kelaspelayanan_id);
                    }
		}
            $criteria->limit = -1;

            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
                    'pagination'=>false,
            ));
    }
    public function searchGrafikKinerja()
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
//        RND-6992 Format date langsung diedit di view nya.      	
//    protected function afterFind(){
//            foreach($this->metadata->tableSchema->columns as $columnName => $column){
//                $format = new MyFormatter();
//                if (!strlen($this->tgl_masukpenunjang)) continue;
//
//                if ($column->dbType == 'date'){                         
//                   $this->tgl_masukpenunjang = $format->formatDateTimeId($this->tgl_masukpenunjang);
//                }elseif ($column->dbType == 'timestamp without time zone'){
//                        $this->tgl_masukpenunjang = $format->formatDateTimeId($this->tgl_masukpenunjang);
//                }
//            }
//            return true;
//        }
}

?>
