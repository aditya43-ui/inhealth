<?php

class PPLaporan10besarpenyakit extends Laporan10besarpenyakitV {
    public $data;
    public $jumlah;
    public $tick;
    public $tgl_awal,$tgl_akhir;
    public $jumlahTampil;
    
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
    
    public function searchTableLaporan()
    {
            // Warning: Please modify the following code to remove attributes that
            // should not be searched.

            $criteria=new CDbCriteria;
            
          //  if (!empty($this->ruangan_id)){
            //    $criteria->select = 'count(diagnosa_id) as jumlah, diagnosa_id, diagnosa_nama as data, diagnosa_kode, ruangan_id, ruangan_nama';
              //  $criteria->group = 'diagnosa_nama, diagnosa_id, diagnosa_kode, ruangan_id, ruangan_nama';
           // }
           // elseif (!empty($this->instalasi_id)){
             //   $criteria->select = 'count(diagnosa_id) as jumlah, diagnosa_id, diagnosa_nama as data, diagnosa_kode, instalasi_id, instalasi_nama';
               // $criteria->group = 'diagnosa_nama, diagnosa_id, diagnosa_kode, instalasi_id, instalasi_nama';
           // }else{
                $criteria->select = 'count(diagnosa_id) as jumlah, diagnosa_id, diagnosa_nama as data, diagnosa_kode';
                $criteria->group = 'diagnosa_nama, diagnosa_id, diagnosa_kode';
            //}
                       
            $criteria->order = 'jumlah DESC';
            $criteria->addCondition('DATE(tglmorbiditas) BETWEEN \''.$this->tgl_awal.'\' AND \''.$this->tgl_akhir.'\'');
			if(!empty($this->diagnosa_id)){
				$criteria->addCondition("diagnosa_id = ".$this->diagnosa_id);			
			}
            $criteria->compare('LOWER(diagnosa_kode)',strtolower($this->diagnosa_kode),true);
            $criteria->compare('LOWER(diagnosa_nama)',strtolower($this->diagnosa_nama),true);
            $criteria->compare('date(tglmorbiditas)',$this->tglmorbiditas,true);
			if(!empty($this->pasienmorbiditas_id)){
				$criteria->addCondition("pasienmorbiditas_id = ".$this->pasienmorbiditas_id);			
			}
            if(!empty($this->ruangan_id)){
				if (is_array($this->ruangan_id)){
					$criteria->addInCondition("ruangan_id",$this->ruangan_id);
				}else{
					$criteria->addCondition("ruangan_id = ".$this->ruangan_id);			
				}
            }
//$criteria->compare('LOWER(ruangan_nama)',strtolower($this->ruangan_nama),true);
            if(!empty($this->instalasi_id)){
				if (is_array($this->instalasi_id)){
					$criteria->addInCondition("instalasi_id",$this->instalasi_id);
				}else{
					$criteria->addCondition("instalasi_id = ".$this->instalasi_id);	
				}
            }
          //  $criteria->compare('LOWER(instalasi_nama)',strtolower($this->instalasi_nama),true);            
            $criteria->limit = $this->jumlahTampil;
                        
//            return new CActiveDataProvider($this, array(
//                    'criteria'=>$criteria,
//                    'pagination' => array('pageSize' => $this->jumlahTampil,),
//                    'totalItemCount' => $this->jumlahTampil,
//					'criteria'=>$criteria,
//            ));
			return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                        'pagination' => false
		));
    }
    
    public function searchPrint()
    {
            // Warning: Please modify the following code to remove attributes that
            // should not be searched.

//            $criteria=new CDbCriteria;
//            
//            if (!empty($this->ruangan_id)){
//                $criteria->select = 'count(diagnosa_id) as jumlah, diagnosa_id, diagnosa_nama as data, diagnosa_kode, ruangan_id, ruangan_nama';
//                $criteria->group = 'diagnosa_nama, diagnosa_id, diagnosa_kode, ruangan_id, ruangan_nama';
//            }
//            else if (!empty($this->instalasi_id)){
//                $criteria->select = 'count(diagnosa_id) as jumlah, diagnosa_id, diagnosa_nama as data, diagnosa_kode, instalasi_id, instalasi_nama';
//                $criteria->group = 'diagnosa_nama, diagnosa_id, diagnosa_kode, instalasi_id, instalasi_nama';
//            }else{
//                $criteria->select = 'count(diagnosa_id) as jumlah, diagnosa_id, diagnosa_nama as data, diagnosa_kode';
//                $criteria->group = 'diagnosa_nama, diagnosa_id, diagnosa_kode';
//            }
//			
//            $criteria->order = 'jumlah DESC';
//            $criteria->addCondition('DATE(tglmorbiditas) BETWEEN \''.$this->tgl_awal.'\' AND \''.$this->tgl_akhir.'\'');
//			if(!empty($this->ruangan_id)){
//				$criteria->addCondition("ruangan_id = ".$this->ruangan_id);			
//			}
//            $criteria->compare('LOWER(ruangan_nama)',strtolower($this->ruangan_nama),true);
//			if(!empty($this->instalasi_id)){
//				$criteria->addCondition("instalasi_id = ".$this->instalasi_id);			
//			}
//            $criteria->compare('LOWER(instalasi_nama)',strtolower($this->instalasi_nama),true);
//
//            return new CActiveDataProvider($this, array(
//                    'pagination' => array('pageSize' => $this->jumlahTampil,),
//                    'totalItemCount' => $this->jumlahTampil,
//                    'criteria'=>$criteria,
//            ));
		$criteria=new CDbCriteria;
            
            //if (!empty($this->ruangan_id)){
              //  $criteria->select = 'count(diagnosa_id) as jumlah, diagnosa_id, diagnosa_nama as data, diagnosa_kode, ruangan_id, ruangan_nama';
              //  $criteria->group = 'diagnosa_nama, diagnosa_id, diagnosa_kode, ruangan_id, ruangan_nama';
           // }
           // else if (!empty($this->instalasi_id)){
             //   $criteria->select = 'count(diagnosa_id) as jumlah, diagnosa_id, diagnosa_nama as data, diagnosa_kode, instalasi_id, instalasi_nama';
               // $criteria->group = 'diagnosa_nama, diagnosa_id, diagnosa_kode, instalasi_id, instalasi_nama';
           // }else{
                $criteria->select = 'count(diagnosa_id) as jumlah, diagnosa_id, diagnosa_nama as data, diagnosa_kode';
                $criteria->group = 'diagnosa_nama, diagnosa_id, diagnosa_kode';
           // }
                       
            $criteria->order = 'jumlah DESC';
            $criteria->addCondition('DATE(tglmorbiditas) BETWEEN \''.$this->tgl_awal.'\' AND \''.$this->tgl_akhir.'\'');
			if(!empty($this->diagnosa_id)){
				$criteria->addCondition("diagnosa_id = ".$this->diagnosa_id);			
			}
            $criteria->compare('LOWER(diagnosa_kode)',strtolower($this->diagnosa_kode),true);
            $criteria->compare('LOWER(diagnosa_nama)',strtolower($this->diagnosa_nama),true);
            $criteria->compare('date(tglmorbiditas)',$this->tglmorbiditas,true);
			if(!empty($this->pasienmorbiditas_id)){
				$criteria->addCondition("pasienmorbiditas_id = ".$this->pasienmorbiditas_id);			
			}
			 if(!empty($this->ruangan_id)){
				if (is_array($this->ruangan_id)){
					$criteria->addInCondition("ruangan_id",$this->ruangan_id);
				}else{
					$criteria->addCondition("ruangan_id = ".$this->ruangan_id);			
				}
            }
//$criteria->compare('LOWER(ruangan_nama)',strtolower($this->ruangan_nama),true);
            if(!empty($this->instalasi_id)){
				if (is_array($this->instalasi_id)){
					$criteria->addInCondition("instalasi_id",$this->instalasi_id);
				}else{
					$criteria->addCondition("instalasi_id = ".$this->instalasi_id);	
				}
            }
            $criteria->compare('LOWER(instalasi_nama)',strtolower($this->instalasi_nama),true);
                   $criteria->limit = $this->jumlahTampil;      
//            return new CActiveDataProvider($this, array(
//                    'criteria'=>$criteria,
//                    'pagination' => array('pageSize' => $this->jumlahTampil,),
//                    'totalItemCount' => $this->jumlahTampil,
//                    'criteria'=>$criteria,
//            ));
			 return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
    }
    
    public function searchGrafik()
    {
            // Warning: Please modify the following code to remove attributes that
            // should not be searched.

            $criteria=new CDbCriteria;
            
            //if (!empty($this->ruangan_id)){
              //  $criteria->select = 'count(diagnosa_id) as jumlah, diagnosa_id, diagnosa_nama as data, diagnosa_kode, ruangan_id, ruangan_nama';
                //$criteria->group = 'diagnosa_nama, diagnosa_id, diagnosa_kode, ruangan_id, ruangan_nama';
           // }
           // else if (!empty($this->instalasi_id)){
             //   $criteria->select = 'count(diagnosa_id) as jumlah, diagnosa_id, diagnosa_nama as data, diagnosa_kode, instalasi_id, instalasi_nama';
               // $criteria->group = 'diagnosa_nama, diagnosa_id, diagnosa_kode, instalasi_id, instalasi_nama';
           // }else{
                $criteria->select = 'count(diagnosa_id) as jumlah, diagnosa_id, diagnosa_nama as data, diagnosa_kode';
                $criteria->group = 'diagnosa_nama, diagnosa_id, diagnosa_kode';
            //}
            $criteria->order = 'jumlah DESC';
            $criteria->addBetweenCondition('DATE(tglmorbiditas)',$this->tgl_awal,$this->tgl_akhir,true);
			 if(!empty($this->ruangan_id)){
				if (is_array($this->ruangan_id)){
					$criteria->addInCondition("ruangan_id",$this->ruangan_id);
				}else{
					$criteria->addCondition("ruangan_id = ".$this->ruangan_id);			
				}
            }
//$criteria->compare('LOWER(ruangan_nama)',strtolower($this->ruangan_nama),true);
            if(!empty($this->instalasi_id)){
				if (is_array($this->instalasi_id)){
					$criteria->addInCondition("instalasi_id",$this->instalasi_id);
				}else{
					$criteria->addCondition("instalasi_id = ".$this->instalasi_id);	
				}
            }
            $criteria->compare('LOWER(instalasi_nama)',strtolower($this->instalasi_nama),true);
            $criteria->limit = 10;

            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
                    //'pagination' => array('pageSize' => $this->jumlahTampil,),
                                        
            ));
    }

    public function getJenisKasusPenyakitItems()
            {
                return JeniskasuspenyakitM::model()->findAllByAttributes(array('jeniskasuspenyakit_aktif'=>true),array('order'=>'jeniskasuspenyakit_nama'));
            }
    public function getNamaModel()
    {
        return __CLASS__;
    }

}