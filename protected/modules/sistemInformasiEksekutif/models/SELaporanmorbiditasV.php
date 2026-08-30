<?php
class SELaporanmorbiditasV extends LaporanmorbiditasV
{

        public $tgl_awal;
        public $tgl_akhir;
        public $bln_awal;
        public $bln_akhir;
        public $thn_awal;
        public $thn_akhir;
        public $jumlahTampil;
        public $jns_periode;
        public $data_2;
        public $jumlah;

        public $lakilaki,$perempuan,$jumlahkunjungan;


	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        /**
         *  method untuk criteria
         * @return CDbCriteria 
         */
        protected function searchCriteria()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.


		$criteria=new CDbCriteria;
//               

        $criteria->addCondition('DATE(tglmorbiditas) BETWEEN \''.$this->tgl_awal.'\' AND \''.$this->tgl_akhir.'\'');

		if(!empty($this->pasien_id)){
			$criteria->addCondition("pasien_id = ".$this->pasien_id);			
		}
		if(!empty($this->pendaftaran_id)){
			$criteria->addCondition("pendaftaran_id = ".$this->pendaftaran_id);			
		}
		$criteria->compare('LOWER(kasusdiagnosa)',strtolower($this->kasusdiagnosa),true);
		if(!empty($this->diagnosa_id)){
			$criteria->addCondition("diagnosa_id = ".$this->diagnosa_id);			
		}
		$criteria->compare('LOWER(diagnosa_kode)',strtolower($this->diagnosa_kode),true);
		$criteria->compare('LOWER(diagnosa_nama)',strtolower($this->diagnosa_nama),true);
		$criteria->compare('LOWER(diagnosa_namalainnya)',strtolower($this->diagnosa_namalainnya),true);
		$criteria->compare('diagnosa_nourut',$this->diagnosa_nourut);
		if(!empty($this->golonganumur_id)){
			$criteria->addCondition("golonganumur_id = ".$this->golonganumur_id);			
		}
		$criteria->compare('LOWER(jeniskelamin)',strtolower($this->jeniskelamin),true);
                
                

		return $criteria;
	}


    public function searchGrafikGaris() {
        $criteria = $this->searchCriteria();
        $tgl_awal = date("Y-m-d",strtotime($this->tgl_awal));
        $tgl_akhir = date("Y-m-d",strtotime($this->tgl_akhir));
        $jmlhari = floor(abs(strtotime($this->tgl_awal)-strtotime($this->tgl_akhir))/(60*60*24));
        if($jmlhari > 30){
            $criteria->select = 'count(diagnosa_kode) as jumlah, EXTRACT(MONTH FROM tglmorbiditas::timestamp) as data, EXTRACT(YEAR FROM tglmorbiditas::timestamp) as data_2';
            $criteria->group = 'data_2,data';
        }else{
            $criteria->select = 'count(diagnosa_kode) as jumlah, date(tglmorbiditas) as data';
            $criteria->group = 'data';
        }
        $criteria->order = 'jumlah DESC';
        $criteria->limit = 10;
        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                    'pagination' => false,
                ));
    }


    public function searchGrafikBatangPiePenjamin() {
        $criteria = $this->searchCriteria();
        $criteria->select = 'count(diagnosa_kode) as jumlah, diagnosa_nama as data';
        $criteria->group = 'diagnosa_nama';
        $criteria->order = 'jumlah DESC';
        $criteria->limit = 10;
        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                    'pagination' => false,
                ));
    }

    public function searchSpeedo() {
        $criteria = $this->searchCriteria();
        $criteria->select = 'count(diagnosa_kode) as data';
        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                ));
    }

}