<?php
class SELaporan10besarpenyakitV extends Laporan10besarpenyakitV{
    public $tgl_awal;
    public $tgl_akhir;
    public $bln_awal;
    public $bln_akhir;
    public $thn_awal;
    public $thn_akhir;
    public $jns_periode;
    public $data_2;
    public $jumlah;
        
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
    
    /**
     * this method used in 
     * @return CActiveDataProvider 
     */
    public function searchDashboard(){
        $criteria= new CDbCriteria;
            
        $criteria->select = 'count(diagnosa_id) as jumlah, diagnosa_id, diagnosa_nama as data, diagnosa_kode';
        $criteria->group = 'diagnosa_nama, diagnosa_id, diagnosa_kode';
        $criteria->order = 'jumlah DESC';
        $criteria->addCondition('DATE(tglmorbiditas) BETWEEN \''.$this->tgl_awal.'\' AND \''.$this->tgl_akhir.'\'');
		if(!empty($this->ruangan_id)){
			$criteria->addCondition("ruangan_id = ".$this->ruangan_id);			
		}
        $criteria->compare('LOWER(ruangan_nama)',strtolower($this->ruangan_nama),true);
		if(!empty($this->instalasi_id)){
			$criteria->addCondition("instalasi_id = ".$this->instalasi_id);			
		}
        $criteria->compare('LOWER(instalasi_nama)',strtolower($this->instalasi_nama),true);

        return new CActiveDataProvider($this, array(
                'criteria'=>$criteria,
                'pagination' => array('pageSize' => $this->jumlahTampil,),
                'totalItemCount' => $this->jumlahTampil,
        ));
    }
    
    public function searchTable()
    {
            // Warning: Please modify the following code to remove attributes that
            // should not be searched.

            $criteria=new CDbCriteria;
            
            $criteria->addCondition('DATE(tglmorbiditas) BETWEEN \''.$this->tgl_awal.'\' AND \''.$this->tgl_akhir.'\'');
			if(!empty($this->diagnosa_id)){
				$criteria->addCondition("diagnosa_id = ".$this->diagnosa_id);			
			}
            $criteria->compare('LOWER(diagnosa_kode)',strtolower($this->diagnosa_kode),true);
            $criteria->compare('LOWER(diagnosa_nama)',strtolower($this->diagnosa_nama),true);
            $criteria->compare('LOWER(tglmorbiditas)',strtolower($this->tglmorbiditas),true);
			if(!empty($this->pasienmorbiditas_id)){
				$criteria->addCondition("pasienmorbiditas_id = ".$this->pasienmorbiditas_id);			
			}
			if(!empty($this->ruangan_id)){
				$criteria->addCondition("ruangan_id = ".$this->ruangan_id);			
			};
            $criteria->compare('LOWER(ruangan_nama)',strtolower($this->ruangan_nama),true);
			if(!empty($this->instalasi_id)){
				$criteria->addCondition("instalasi_id = ".$this->instalasi_id);			
			}
            $criteria->compare('LOWER(instalasi_nama)',strtolower($this->instalasi_nama),true);

            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
            ));
    }

    public function searchCriteria(){
        
            $criteria= new CDbCriteria;
            
            $criteria->addBetweenCondition('DATE(tglmorbiditas)', $this->tgl_awal, $this->tgl_akhir);
			if(!empty($this->diagnosa_id)){
				$criteria->addCondition("diagnosa_id = ".$this->diagnosa_id);			
			}
            $criteria->compare('LOWER(diagnosa_kode)',strtolower($this->diagnosa_kode),true);
            $criteria->compare('LOWER(diagnosa_nama)',strtolower($this->diagnosa_nama),true);
            $criteria->compare('LOWER(tglmorbiditas)',strtolower($this->tglmorbiditas),true);
			if(!empty($this->pasienmorbiditas_id)){
				$criteria->addCondition("pasienmorbiditas_id = ".$this->pasienmorbiditas_id);			
			}
			if(!empty($this->ruangan_id)){
				$criteria->addCondition("ruangan_id = ".$this->ruangan_id);			
			}			
            $criteria->compare('LOWER(ruangan_nama)',strtolower($this->ruangan_nama),true);
			if(!empty($this->instalasi_id)){
				$criteria->addCondition("instalasi_id = ".$this->instalasi_id);			
			}
            $criteria->compare('LOWER(instalasi_nama)',strtolower($this->instalasi_nama),true);
            $criteria->limit = 10;
            $criteria->order = 'diagnosa_id desc';
            $criteria->group = 'diagnosa_id';

            return $criteria;
    }

    /**
    * untuk grafik garis:
    * @return CActiveDataProvider : tgl_pendaftaran, jumlah
    */
    public function searchGrafikGaris() {
        $criteria = $this->searchCriteria();
        $tgl_awal = date("Y-m-d",strtotime($this->tgl_awal));
        $tgl_akhir = date("Y-m-d",strtotime($this->tgl_akhir));
        $jmlhari = floor(abs(strtotime($this->tgl_awal)-strtotime($this->tgl_akhir))/(60*60*24));
        if($jmlhari > 30){
            $criteria->select = 'count(diagnosa_id) as jumlah, EXTRACT(MONTH FROM tglmorbiditas::timestamp) as data, EXTRACT(YEAR FROM tglmorbiditas::timestamp) as data_2';
            $criteria->group = 'data_2,data';
        }else{
            $criteria->select = 'count(diagnosa_id) as jumlah, date(tglmorbiditas) as data';
            $criteria->group = 'data';
        }
        $criteria->order = $criteria->group;
        $criteria->limit = -1;
        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                    'pagination' => false,
                ));
    }

    /**
    * untuk grafik batang dan pie Sepuluh besar Penyakit :
    * @return CActiveDataProvider : diagnosa_nama, diagnosa_id
    */
    public function searchGrafikBatangPieSepuluhBesarPenyakit() {
        $criteria = $this->searchCriteria();
        $criteria->select = 'count(diagnosa_id) as jumlah, diagnosa_nama as data';
        $criteria->group = 'diagnosa_nama';
        $criteria->order = 'jumlah DESC';//$criteria->group;

        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                ));
    }
    /**
    * untuk speedo meter
    * @return CActiveDataProvider : persen
    */
    public function searchSpeedo() {
        $criteria = $this->searchCriteria();
        $criteria->select = 'count(diagnosa_id) as jumlah, diagnosa_nama as data';
        $criteria->group = 'diagnosa_nama';
        $criteria->order = 'jumlah DESC';//$criteria->group;
        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                ));
    }


}