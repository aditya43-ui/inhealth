<?php

class RDLaporankepenunjangrd extends LaporankepenunjangrdV {

    public $jumlah;
    public $data;
    public $tick;
    public $tgl_awal,$tgl_akhir,$bln_awal,$bln_akhir,$thn_awal,$thn_akhir,$jns_periode;
    
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
    
    public function getRuanganKepenunjang(){
        $model = RuanganpenunjangV::model()->findAll('ruangan_aktif = true');
        $result = array();
        foreach ($model as $i=>$v){
            $result[$v->ruangan_id] = $v->ruangan_nama;
        }

        return $result;
    }
    
    public function searchTable()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
                
		$criteria->addBetweenCondition('tgl_pendaftaran', $this->tgl_awal, $this->tgl_akhir);
		$criteria->compare('LOWER(nama_pasien)',strtolower($this->nama_pasien),true);
		$criteria->compare('LOWER(jeniskelamin)',strtolower($this->jeniskelamin),true);
		$criteria->compare('LOWER(no_rekam_medik)',strtolower($this->no_rekam_medik),true);
		$criteria->compare('LOWER(no_pendaftaran)',strtolower($this->no_pendaftaran),true);
		$criteria->compare('LOWER(umur)',strtolower($this->umur),true);
		$criteria->addCondition('ruanganasal_id = '.Yii::app()->user->getState('ruangan_id'));
		$criteria->compare('LOWER(ruanganasal_nama)',strtolower($this->ruanganasal_nama),true);
		$criteria->compare('LOWER(no_masukpenunjang)',strtolower($this->no_masukpenunjang),true);
		$criteria->compare('LOWER(tglmasukpenunjang)',strtolower($this->tglmasukpenunjang),true);
		$criteria->compare('LOWER(no_urutperiksa)',strtolower($this->no_urutperiksa),true);
		$criteria->compare('LOWER(statusperiksa)',strtolower($this->statusperiksa),true);
		if(!empty($this->ruanganpenunj_id)){
			$criteria->addInCondition("ruanganpenunj_id",$this->ruanganpenunj_id);				
		}
		$criteria->compare('LOWER(ruanganpenunj_nama)',strtolower($this->ruanganpenunj_nama),true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
    public function searchGrafik()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
		$criteria->select = 'count(pendaftaran_id) as jumlah, ruanganpenunj_nama as data';
		$criteria->group = 'ruanganpenunj_nama';
		$criteria->addBetweenCondition('tgl_pendaftaran', $this->tgl_awal, $this->tgl_akhir);
		$criteria->compare('LOWER(nama_pasien)',strtolower($this->nama_pasien),true);
		$criteria->compare('LOWER(jeniskelamin)',strtolower($this->jeniskelamin),true);
		$criteria->compare('LOWER(no_rekam_medik)',strtolower($this->no_rekam_medik),true);
		$criteria->compare('LOWER(no_pendaftaran)',strtolower($this->no_pendaftaran),true);
		$criteria->compare('LOWER(umur)',strtolower($this->umur),true);
		$criteria->addCondition('ruanganasal_id = '.Yii::app()->user->getState('ruangan_id'));
		$criteria->compare('LOWER(ruanganasal_nama)',strtolower($this->ruanganasal_nama),true);
		$criteria->compare('LOWER(no_masukpenunjang)',strtolower($this->no_masukpenunjang),true);
		$criteria->compare('LOWER(tglmasukpenunjang)',strtolower($this->tglmasukpenunjang),true);
		$criteria->compare('LOWER(no_urutperiksa)',strtolower($this->no_urutperiksa),true);
		$criteria->compare('LOWER(statusperiksa)',strtolower($this->statusperiksa),true);
		if(!empty($this->ruanganpenunj_id)){
			$criteria->addInCondition("ruanganpenunj_id",$this->ruanganpenunj_id);				
		}
		$criteria->compare('LOWER(ruanganpenunj_nama)',strtolower($this->ruanganpenunj_nama),true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
         public function searchPrint()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
                
                $criteria->addBetweenCondition('tgl_pendaftaran', $this->tgl_awal, $this->tgl_akhir);
		$criteria->compare('LOWER(nama_pasien)',strtolower($this->nama_pasien),true);
		$criteria->compare('LOWER(jeniskelamin)',strtolower($this->jeniskelamin),true);
		$criteria->compare('LOWER(no_rekam_medik)',strtolower($this->no_rekam_medik),true);
		$criteria->compare('LOWER(no_pendaftaran)',strtolower($this->no_pendaftaran),true);
		$criteria->compare('LOWER(umur)',strtolower($this->umur),true);
		$criteria->addCondition('ruanganasal_id = '.Yii::app()->user->getState('ruangan_id'));
		$criteria->compare('LOWER(ruanganasal_nama)',strtolower($this->ruanganasal_nama),true);
		$criteria->compare('LOWER(no_masukpenunjang)',strtolower($this->no_masukpenunjang),true);
		$criteria->compare('LOWER(tglmasukpenunjang)',strtolower($this->tglmasukpenunjang),true);
		$criteria->compare('LOWER(no_urutperiksa)',strtolower($this->no_urutperiksa),true);
		$criteria->compare('LOWER(statusperiksa)',strtolower($this->statusperiksa),true);
		if(!empty($this->ruanganpenunj_id)){
			$criteria->addInCondition("ruanganpenunj_id",$this->ruanganpenunj_id);				
		}
		$criteria->compare('LOWER(ruanganpenunj_nama)',strtolower($this->ruanganpenunj_nama),true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                        'pagination'=>false,
		));
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
		$criteria->compare('DATE(tglmasukpenunjang)', date("Y-m-d"));
		$criteria->order = 'tglmasukpenunjang ASC';
		$criteria->limit = 10;
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>false
		));
	}

}