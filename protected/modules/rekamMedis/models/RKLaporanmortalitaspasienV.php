<?php
class RKLaporanmortalitaspasienV extends LaporanmortalitaspasienV
{
        public $jns_periode,$tgl_awal,$tgl_akhir,$bln_awal,$bln_akhir,$thn_awal,$thn_akhir;
        public $kondisipulang1, $kondisipulang2, $jumlahkunjungan;
        public $instalasi_id;
        
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        /**
         * method untuk criteria
         * @return CActiveDataProvider 
         */
	protected function functionCriteria()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->select = "golonganumur_nama, tglmorbiditas, diagnosa_nama,umur_0_28hr,umur_28hr_1thn, umur_1_4thn,umur_5_14thn,umur_15_24thn,umur_25_44thn,umur_45_64thn, umur_65, kondisipulang, pendaftaran_id , CASE WHEN kondisipulang = '".Params::KONDISIPULANG_MENINGGAL_1."' THEN 1 else 0 END AS kondisipulang1, CASE WHEN kondisipulang = '".Params::KONDISIPULANG_MENINGGAL_1."' THEN 0 else 1 END AS kondisipulang2";
		$criteria->group = "golonganumur_nama, tglmorbiditas, diagnosa_nama,umur_0_28hr,umur_28hr_1thn, umur_1_4thn,umur_5_14thn,umur_15_24thn,umur_25_44thn,umur_45_64thn, umur_65, kondisipulang, pendaftaran_id";
                    
		if(!empty($this->pasien_id)){
			$criteria->addCondition("pasien_id = ".$this->pasien_id);			
		}
		if(!empty($this->pendaftaran_id)){
			$criteria->addCondition("pendaftaran_id = ".$this->pendaftaran_id);			
		}
		$criteria->addBetweenCondition('DATE(tglmorbiditas)',$this->tgl_awal,$this->tgl_akhir);
		$criteria->compare('LOWER(kasusdiagnosa)',strtolower($this->kasusdiagnosa),true);
		$criteria->compare('umur_0_28hr',$this->umur_0_28hr);
		$criteria->compare('umur_28hr_1thn',$this->umur_28hr_1thn);
		$criteria->compare('umur_1_4thn',$this->umur_1_4thn);
		$criteria->compare('umur_5_14thn',$this->umur_5_14thn);
		$criteria->compare('umur_15_24thn',$this->umur_15_24thn);
		$criteria->compare('umur_25_44thn',$this->umur_25_44thn);
		$criteria->compare('umur_45_64thn',$this->umur_45_64thn);
		$criteria->compare('umur_65',$this->umur_65);
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
                
                if (!empty($this->ruangan_id)){
                    if (is_array($this->ruangan_id)){
                        $criteria->addInCondition('ruangan_id', $this->ruangan_id);
                    }
                }else{
                    if (!empty($this->instalasi_id)){
                         $ins = new CDbCriteria();
                        $ins->addInCondition(" instalasi_id ", $this->instalasi_id);
                        $ins->addCondition(" ruangan_aktif = TRUE ");                        
                        $ruangan = RuanganM::model()->findAll($ins);
                        $r = array();
                        foreach($ruangan as $ruang){
                            $r[] = $ruang->ruangan_id; 
                        }
                        
                        $criteria->addInCondition('ruangan_id', $r);
                    }
                }
                
		$criteria->compare('LOWER(kondisipulang)',strtolower($this->kondisipulang),true);
		$criteria->compare('LOWER(carakeluar)',strtolower($this->carakeluar),true);

		return $criteria;
	}
        /**
         * method data provider laporan
         * @return CActiveDataProvider 
         */
        public function searchPrint(){
            $criteria = $this->functionCriteria();
            $crit = $criteria;
            $crit->select = 'diagnosa_nama, '
                    . 'count(CASE WHEN ( (golonganumur_id = '.Params::GOLONGAN_UMUR_BARU_LAHIR.') AND (kondisikeluar_id IN  (\''.Params::KONDISIKELUAR_ID_MENINGGAL_1.'\',\''.Params::KONDISIKELUAR_ID_MENINGGAL_2.'\') )) THEN 1 ELSE null END ) as umur_0_28hr, '
                    . 'count(CASE WHEN ( (golonganumur_id = '.Params::GOLONGAN_UMUR_BAYI.') AND (kondisikeluar_id IN  (\''.Params::KONDISIKELUAR_ID_MENINGGAL_1.'\',\''.Params::KONDISIKELUAR_ID_MENINGGAL_2.'\') )) THEN 1 ELSE null END ) as umur_28hr_1thn, '
                    . 'count(CASE WHEN ( (golonganumur_id = '.Params::GOLONGAN_UMUR_BALITA.') AND (kondisikeluar_id IN  (\''.Params::KONDISIKELUAR_ID_MENINGGAL_1.'\',\''.Params::KONDISIKELUAR_ID_MENINGGAL_2.'\') )) THEN 1 ELSE null END ) as umur_1_4thn, '
                    . 'count(CASE WHEN ( (golonganumur_id = '.Params::GOLONGAN_UMUR_ANAK_ANAK.') AND (kondisikeluar_id IN  (\''.Params::KONDISIKELUAR_ID_MENINGGAL_1.'\',\''.Params::KONDISIKELUAR_ID_MENINGGAL_2.'\') )) THEN 1 ELSE null END ) as umur_5_14thn, '
                    . 'count(CASE WHEN ( (golonganumur_id = '.Params::GOLONGAN_UMUR_REMAJA.') AND (kondisikeluar_id IN  (\''.Params::KONDISIKELUAR_ID_MENINGGAL_1.'\',\''.Params::KONDISIKELUAR_ID_MENINGGAL_2.'\') )) THEN 1 ELSE null END ) as umur_15_24thn, '
                    . 'count(CASE WHEN ( (golonganumur_id = '.Params::GOLONGAN_UMUR_DEWASA.') AND (kondisikeluar_id IN  (\''.Params::KONDISIKELUAR_ID_MENINGGAL_1.'\',\''.Params::KONDISIKELUAR_ID_MENINGGAL_2.'\') )) THEN 1 ELSE null END ) as umur_25_44thn,'
                    . 'count(CASE WHEN ( (golonganumur_id = '.Params::GOLONGAN_UMUR_ORANG_TUA.') AND (kondisikeluar_id IN  (\''.Params::KONDISIKELUAR_ID_MENINGGAL_1.'\',\''.Params::KONDISIKELUAR_ID_MENINGGAL_2.'\') )) THEN 1 ELSE null END ) as umur_45_64thn, '
                    . 'count(CASE WHEN ( (golonganumur_id = '.Params::GOLONGAN_UMUR_MANULA.') AND (kondisikeluar_id IN  (\''.Params::KONDISIKELUAR_ID_MENINGGAL_1.'\',\''.Params::KONDISIKELUAR_ID_MENINGGAL_2.'\') )) THEN 1 ELSE null END ) as umur_65, count(pendaftaran_id) as jumlah, '
                    . 'COUNT(CASE WHEN ((kondisikeluar_id IN  (\''.Params::KONDISIKELUAR_ID_MENINGGAL_1.'\') )) THEN 1 ELSE NULL END) AS kondisipulang1, '
                    . 'COUNT(CASE WHEN ((kondisikeluar_id IN  (\''.Params::KONDISIKELUAR_ID_MENINGGAL_2.'\') )) THEN 1 ELSE NULL END) AS kondisipulang2, '                    
                    . 'count(CASE WHEN ((kondisikeluar_id IN  (\''.Params::KONDISIKELUAR_ID_MENINGGAL_1.'\',\''.Params::KONDISIKELUAR_ID_MENINGGAL_2.'\') )) THEN 1 ELSE null END ) as jumlahkunjungan';
            $crit->group = 'diagnosa_nama';
            return new CActiveDataProvider($this, array(
			'criteria'=>$crit,
                        'pagination'=>false,
		));
        }
        /**
         * method untuk data provider table
         * @return CActiveDataProvider 
         */
        public function searchTable(){
            $criteria = $this->functionCriteria();            
            $crit = $criteria;
            $crit->select = 'diagnosa_nama, '
                    . 'count(CASE WHEN ( (golonganumur_id = '.Params::GOLONGAN_UMUR_BARU_LAHIR.') AND (kondisikeluar_id IN  (\''.Params::KONDISIKELUAR_ID_MENINGGAL_1.'\',\''.Params::KONDISIKELUAR_ID_MENINGGAL_2.'\') )) THEN 1 ELSE null END ) as umur_0_28hr, '
                    . 'count(CASE WHEN ( (golonganumur_id = '.Params::GOLONGAN_UMUR_BAYI.') AND (kondisikeluar_id IN  (\''.Params::KONDISIKELUAR_ID_MENINGGAL_1.'\',\''.Params::KONDISIKELUAR_ID_MENINGGAL_2.'\') )) THEN 1 ELSE null END ) as umur_28hr_1thn, '
                    . 'count(CASE WHEN ( (golonganumur_id = '.Params::GOLONGAN_UMUR_BALITA.') AND (kondisikeluar_id IN  (\''.Params::KONDISIKELUAR_ID_MENINGGAL_1.'\',\''.Params::KONDISIKELUAR_ID_MENINGGAL_2.'\') )) THEN 1 ELSE null END ) as umur_1_4thn, '
                    . 'count(CASE WHEN ( (golonganumur_id = '.Params::GOLONGAN_UMUR_ANAK_ANAK.') AND (kondisikeluar_id IN  (\''.Params::KONDISIKELUAR_ID_MENINGGAL_1.'\',\''.Params::KONDISIKELUAR_ID_MENINGGAL_2.'\') )) THEN 1 ELSE null END ) as umur_5_14thn, '
                    . 'count(CASE WHEN ( (golonganumur_id = '.Params::GOLONGAN_UMUR_REMAJA.') AND (kondisikeluar_id IN  (\''.Params::KONDISIKELUAR_ID_MENINGGAL_1.'\',\''.Params::KONDISIKELUAR_ID_MENINGGAL_2.'\') )) THEN 1 ELSE null END ) as umur_15_24thn, '
                    . 'count(CASE WHEN ( (golonganumur_id = '.Params::GOLONGAN_UMUR_DEWASA.') AND (kondisikeluar_id IN  (\''.Params::KONDISIKELUAR_ID_MENINGGAL_1.'\',\''.Params::KONDISIKELUAR_ID_MENINGGAL_2.'\') )) THEN 1 ELSE null END ) as umur_25_44thn,'
                    . 'count(CASE WHEN ( (golonganumur_id = '.Params::GOLONGAN_UMUR_ORANG_TUA.') AND (kondisikeluar_id IN  (\''.Params::KONDISIKELUAR_ID_MENINGGAL_1.'\',\''.Params::KONDISIKELUAR_ID_MENINGGAL_2.'\') )) THEN 1 ELSE null END ) as umur_45_64thn, '
                    . 'count(CASE WHEN ( (golonganumur_id = '.Params::GOLONGAN_UMUR_MANULA.') AND (kondisikeluar_id IN  (\''.Params::KONDISIKELUAR_ID_MENINGGAL_1.'\',\''.Params::KONDISIKELUAR_ID_MENINGGAL_2.'\') )) THEN 1 ELSE null END ) as umur_65, count(pendaftaran_id) as jumlah, '
                    . 'COUNT(CASE WHEN ((kondisikeluar_id IN  (\''.Params::KONDISIKELUAR_ID_MENINGGAL_1.'\') )) THEN 1 ELSE NULL END) AS kondisipulang1, '
                    . 'COUNT(CASE WHEN ((kondisikeluar_id IN  (\''.Params::KONDISIKELUAR_ID_MENINGGAL_2.'\') )) THEN 1 ELSE NULL END) AS kondisipulang2, '                    
                    . 'count(CASE WHEN ((kondisikeluar_id IN  (\''.Params::KONDISIKELUAR_ID_MENINGGAL_1.'\',\''.Params::KONDISIKELUAR_ID_MENINGGAL_2.'\') )) THEN 1 ELSE null END ) as jumlahkunjungan';
            $crit->group = 'diagnosa_nama';
//            $crit->select = 'diagnosa_nama, sum(umur_0_28hr) as umur_0_28hr,sum(umur_28hr_1thn) as umur_28hr_1thn, sum(umur_1_4thn) as umur_1_4thn, sum(umur_5_14thn) as umur_5_14thn, sum(umur_15_24thn) as umur_15_24thn,sum(umur_25_44thn) as umur_25_44thn,sum(umur_45_64thn) as umur_45_64thn, sum(umur_65) as umur_65, count(pendaftaran_id) as jumlah, sum(kondisipulang1) as kondisipulang1 , sum(kondisipulang2) as kondisipulang2, count(pendaftaran_id) as jumlahkunjungan';
//            $crit->group = 'diagnosa_nama';
            return new CActiveDataProvider($this, array(
			'criteria'=>$crit,
		));
        }
        /**
         * method untuk data provider Grafik
         * @return CActiveDataProvider 
         */
        public function searchGrafik(){
            $criteria = $this->functionCriteria();
            $crit = $criteria;
            $crit->select = 'golonganumur_nama as data, kondisipulang as tick, count(pendaftaran_id) as jumlah';
            $crit->group = 'golonganumur_nama,kondisipulang';
            return new CActiveDataProvider($this, array(
			'criteria'=>$crit,
		));
        }
        
        public function primaryKey() {
            return 'pendaftaran_id';
        }

}