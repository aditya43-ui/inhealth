<?php
class RKLaporanmorbiditasV extends LaporanmorbiditasV
{
        public $jns_periode,$tgl_awal,$tgl_akhir,$bln_awal,$bln_akhir,$thn_awal,$thn_akhir;
        public $lakilaki,$perempuan,$jumlahkunjungan;
        public $instalasi_id, $ruangan_id;
        public $umur_1_5thn;
        public $kasusbaru;
        public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        /**
         *  method untuk criteria
         * @return CDbCriteria 
         */
	protected function functionCriteria()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;                
		$criteria->select = "t.golonganumur_nama, t.tglmorbiditas, t.diagnosa_nama, t.nama_pasien, t.umur_0_28hr, t.umur_28hr_1thn, t.umur_1_4thn, t.umur_5_14thn, t.umur_15_24thn, t.umur_25_44thn, t.umur_45_64thn, t.umur_65, t.jeniskelamin, t.pendaftaran_id , CASE WHEN jeniskelamin = '".Params::JENIS_KELAMIN_PEREMPUAN."' THEN 0 else 1 END AS lakilaki, CASE WHEN jeniskelamin = '".Params::JENIS_KELAMIN_PEREMPUAN."' THEN 1 else 0 END AS perempuan";
		$criteria->group = "t.golonganumur_nama, t.tglmorbiditas, t.diagnosa_nama,t.nama_pasien t.umur_0_28hr, t.umur_28hr_1thn, t.umur_1_4thn, t.umur_5_14thn, t.umur_15_24thn, t.umur_25_44thn, t.umur_45_64thn, t.umur_65, t.jeniskelamin, t.pendaftaran_id";
//             
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
        /**
         *  method untuk data provider pada table laporan
         * @return CActiveDataProvider 
         */
        public function searchTable(){
            $asd = Params::ASALRUJUKAN_ID_RS;
            $criteria = $this->functionCriteria();
            $crit = $criteria;
            $crit->select = 'diagnosa_nama, '
                    . 'count(CASE WHEN ( (golonganumur_id = '.Params::GOLONGAN_UMUR_BARU_LAHIR.') AND (kasusdiagnosa = \'KASUS BARU\' )) THEN 1 ELSE null END ) as umur_0_28hr, '
                    . 'count(CASE WHEN ( (golonganumur_id = '.Params::GOLONGAN_UMUR_BAYI.') AND (kasusdiagnosa = \'KASUS BARU\' )) THEN 1 ELSE null END ) as umur_28hr_1thn, '
                    . 'count(CASE WHEN ( (golonganumur_id = '.Params::GOLONGAN_UMUR_BALITA.') AND (kasusdiagnosa = \'KASUS BARU\' )) THEN 1 ELSE null END ) as umur_1_4thn, '
                    . 'count(CASE WHEN ( (golonganumur_id = '.Params::GOLONGAN_UMUR_ANAK_ANAK.') AND (kasusdiagnosa = \'KASUS BARU\' )) THEN 1 ELSE null END ) as umur_5_14thn, '
                    . 'count(CASE WHEN ( (golonganumur_id = '.Params::GOLONGAN_UMUR_REMAJA.') AND (kasusdiagnosa = \'KASUS BARU\' )) THEN 1 ELSE null END ) as umur_15_24thn, '
                    . 'count(CASE WHEN ( (golonganumur_id = '.Params::GOLONGAN_UMUR_DEWASA.') AND (kasusdiagnosa = \'KASUS BARU\' )) THEN 1 ELSE null END ) as umur_25_44thn,'
                    . 'count(CASE WHEN ( (golonganumur_id = '.Params::GOLONGAN_UMUR_ORANG_TUA.') AND (kasusdiagnosa = \'KASUS BARU\' )) THEN 1 ELSE null END ) as umur_45_64thn, '
                    . 'count(CASE WHEN ( (golonganumur_id = '.Params::GOLONGAN_UMUR_MANULA.') AND (kasusdiagnosa = \'KASUS BARU\' )) THEN 1 ELSE null END ) as umur_65, count(pendaftaran_id) as jumlah, '
                    . 'COUNT(CASE WHEN (jeniskelamin !=\''.Params::JENIS_KELAMIN_PEREMPUAN.'\' AND (kasusdiagnosa = \'KASUS BARU\' )) THEN 1 ELSE NULL END) AS lakilaki, '
                    . 'COUNT(CASE WHEN (jeniskelamin =\''.Params::JENIS_KELAMIN_PEREMPUAN.'\' AND (kasusdiagnosa = \'KASUS BARU\' )) THEN 1 ELSE NULL END) AS perempuan, '
                    . 'COUNT(CASE WHEN (kasusdiagnosa = \'KASUS BARU\' ) THEN 1 ELSE NULL END) AS kasusbaru, '
                    . 'count(pendaftaran_id) as jumlahkunjungan';
            $crit->group = 'diagnosa_nama';
            return new CActiveDataProvider($this, array(
			'criteria'=>$crit,
		));
        }

        public function searchTable2(){
            $asd = Params::ASALRUJUKAN_ID_RS;
            $criteria = $this->functionCriteria();
            $crit = $criteria;
            $crit->select = 'diagnosa_nama, '
                    . 'count(CASE WHEN ( (golonganumur_id = '.Params::GOLONGAN_UMUR_BARU_LAHIR.') AND (kasusdiagnosa = \'KASUS BARU\' )) THEN 1 ELSE null END ) as umur_0_28hr, '
                    . 'count(CASE WHEN ( (golonganumur_id = '.Params::GOLONGAN_UMUR_BAYI.') AND (kasusdiagnosa = \'KASUS BARU\' )) THEN 1 ELSE null END ) as umur_28hr_1thn, '
                    . 'count(CASE WHEN ( (golonganumur_id = '.Params::GOLONGAN_UMUR_BALITA.') AND (kasusdiagnosa = \'KASUS BARU\' )) THEN 1 ELSE null END ) as umur_1_4thn, '
                    . 'count(CASE WHEN ( (golonganumur_id = '.Params::GOLONGAN_UMUR_ANAK_ANAK.') AND (kasusdiagnosa = \'KASUS BARU\' )) THEN 1 ELSE null END ) as umur_5_14thn, '
                    . 'count(CASE WHEN ( (golonganumur_id = '.Params::GOLONGAN_UMUR_REMAJA.') AND (kasusdiagnosa = \'KASUS BARU\' )) THEN 1 ELSE null END ) as umur_15_24thn, '
                    . 'count(CASE WHEN ( (golonganumur_id = '.Params::GOLONGAN_UMUR_DEWASA.') AND (kasusdiagnosa = \'KASUS BARU\' )) THEN 1 ELSE null END ) as umur_25_44thn,'
                    . 'count(CASE WHEN ( (golonganumur_id = '.Params::GOLONGAN_UMUR_ORANG_TUA.') AND (kasusdiagnosa = \'KASUS BARU\' )) THEN 1 ELSE null END ) as umur_45_64thn, '
                    . 'count(CASE WHEN ( (golonganumur_id = '.Params::GOLONGAN_UMUR_MANULA.') AND (kasusdiagnosa = \'KASUS BARU\' )) THEN 1 ELSE null END ) as umur_65, count(pendaftaran_id) as jumlah, '
                    . 'COUNT(CASE WHEN (jeniskelamin !=\''.Params::JENIS_KELAMIN_PEREMPUAN.'\' AND (kasusdiagnosa = \'KASUS BARU\' )) THEN 1 ELSE NULL END) AS lakilaki, '
                    . 'COUNT(CASE WHEN (jeniskelamin =\''.Params::JENIS_KELAMIN_PEREMPUAN.'\' AND (kasusdiagnosa = \'KASUS BARU\' )) THEN 1 ELSE NULL END) AS perempuan, '
                    . 'COUNT(CASE WHEN (kasusdiagnosa = \'KASUS BARU\' ) THEN 1 ELSE NULL END) AS kasusbaru, '
                    . 'count(pendaftaran_id) as jumlahkunjungan';
            $crit->group = 'diagnosa_nama';

            // echo "<pre>";
            // var_dump($crit);die;
            return new CActiveDataProvider($this, array(
			'criteria'=>$crit,
		));
        }
        /**
         * method untuk data provider pada print laporan
         * @return CActiveDataProvider 
         */
        public function searchPrint(){
            $criteria = $this->functionCriteria();
            $crit = $criteria;
             $crit->select = 'diagnosa_nama, '
                    . 'count(CASE WHEN ( (golonganumur_id = '.Params::GOLONGAN_UMUR_BARU_LAHIR.') AND (kasusdiagnosa = \'KASUS BARU\' )) THEN 1 ELSE null END ) as umur_0_28hr, '
                    . 'count(CASE WHEN ( (golonganumur_id = '.Params::GOLONGAN_UMUR_BAYI.') AND (kasusdiagnosa = \'KASUS BARU\' )) THEN 1 ELSE null END ) as umur_28hr_1thn, '
                    . 'count(CASE WHEN ( (golonganumur_id = '.Params::GOLONGAN_UMUR_BALITA.') AND (kasusdiagnosa = \'KASUS BARU\' )) THEN 1 ELSE null END ) as umur_1_4thn, '
                    . 'count(CASE WHEN ( (golonganumur_id = '.Params::GOLONGAN_UMUR_ANAK_ANAK.') AND (kasusdiagnosa = \'KASUS BARU\' )) THEN 1 ELSE null END ) as umur_5_14thn, '
                    . 'count(CASE WHEN ( (golonganumur_id = '.Params::GOLONGAN_UMUR_REMAJA.') AND (kasusdiagnosa = \'KASUS BARU\' )) THEN 1 ELSE null END ) as umur_15_24thn, '
                    . 'count(CASE WHEN ( (golonganumur_id = '.Params::GOLONGAN_UMUR_DEWASA.') AND (kasusdiagnosa = \'KASUS BARU\' )) THEN 1 ELSE null END ) as umur_25_44thn,'
                    . 'count(CASE WHEN ( (golonganumur_id = '.Params::GOLONGAN_UMUR_ORANG_TUA.') AND (kasusdiagnosa = \'KASUS BARU\' )) THEN 1 ELSE null END ) as umur_45_64thn, '
                    . 'count(CASE WHEN ( (golonganumur_id = '.Params::GOLONGAN_UMUR_MANULA.') AND (kasusdiagnosa = \'KASUS BARU\' )) THEN 1 ELSE null END ) as umur_65, count(pendaftaran_id) as jumlah, '
                    . 'COUNT(CASE WHEN (jeniskelamin !=\''.Params::JENIS_KELAMIN_PEREMPUAN.'\' AND (kasusdiagnosa = \'KASUS BARU\' )) THEN 1 ELSE NULL END) AS lakilaki, '
                    . 'COUNT(CASE WHEN (jeniskelamin =\''.Params::JENIS_KELAMIN_PEREMPUAN.'\' AND (kasusdiagnosa = \'KASUS BARU\' )) THEN 1 ELSE NULL END) AS perempuan, '
                    . 'COUNT(CASE WHEN (kasusdiagnosa = \'KASUS BARU\' ) THEN 1 ELSE NULL END) AS kasusbaru, '
                    . 'count(pendaftaran_id) as jumlahkunjungan';
            $crit->group = 'diagnosa_nama';
            $crit->order = 'diagnosa_nama ASC';
            return new CActiveDataProvider($this, array(
			'criteria'=>$crit,
                        'pagination'=>false, 
                        'sort' => false,
		));
        }

         /**
         * method untuk data provider pada print laporan Pasien
         * @return CActiveDataProvider 
         */
        public function searchPrint2(){
            $criteria = $this->functionCriteria();
            $crit = $criteria;
             $crit->select = 'nama_pasien, '
                    . 'count(CASE WHEN ( (golonganumur_id = '.Params::GOLONGAN_UMUR_BARU_LAHIR.') AND (kasusdiagnosa = \'KASUS BARU\' )) THEN 1 ELSE null END ) as umur_0_28hr, '
                    . 'count(CASE WHEN ( (golonganumur_id = '.Params::GOLONGAN_UMUR_BAYI.') AND (kasusdiagnosa = \'KASUS BARU\' )) THEN 1 ELSE null END ) as umur_28hr_1thn, '
                    . 'count(CASE WHEN ( (golonganumur_id = '.Params::GOLONGAN_UMUR_BALITA.') AND (kasusdiagnosa = \'KASUS BARU\' )) THEN 1 ELSE null END ) as umur_1_4thn, '
                    . 'count(CASE WHEN ( (golonganumur_id = '.Params::GOLONGAN_UMUR_ANAK_ANAK.') AND (kasusdiagnosa = \'KASUS BARU\' )) THEN 1 ELSE null END ) as umur_5_14thn, '
                    . 'count(CASE WHEN ( (golonganumur_id = '.Params::GOLONGAN_UMUR_REMAJA.') AND (kasusdiagnosa = \'KASUS BARU\' )) THEN 1 ELSE null END ) as umur_15_24thn, '
                    . 'count(CASE WHEN ( (golonganumur_id = '.Params::GOLONGAN_UMUR_DEWASA.') AND (kasusdiagnosa = \'KASUS BARU\' )) THEN 1 ELSE null END ) as umur_25_44thn,'
                    . 'count(CASE WHEN ( (golonganumur_id = '.Params::GOLONGAN_UMUR_ORANG_TUA.') AND (kasusdiagnosa = \'KASUS BARU\' )) THEN 1 ELSE null END ) as umur_45_64thn, '
                    . 'count(CASE WHEN ( (golonganumur_id = '.Params::GOLONGAN_UMUR_MANULA.') AND (kasusdiagnosa = \'KASUS BARU\' )) THEN 1 ELSE null END ) as umur_65, count(pendaftaran_id) as jumlah, '
                    . 'COUNT(CASE WHEN (jeniskelamin !=\''.Params::JENIS_KELAMIN_PEREMPUAN.'\' AND (kasusdiagnosa = \'KASUS BARU\' )) THEN 1 ELSE NULL END) AS lakilaki, '
                    . 'COUNT(CASE WHEN (jeniskelamin =\''.Params::JENIS_KELAMIN_PEREMPUAN.'\' AND (kasusdiagnosa = \'KASUS BARU\' )) THEN 1 ELSE NULL END) AS perempuan, '
                    . 'COUNT(CASE WHEN (kasusdiagnosa = \'KASUS BARU\' ) THEN 1 ELSE NULL END) AS kasusbaru, '
                    . 'count(pendaftaran_id) as jumlahkunjungan';
            $crit->group = 'nama_pasien';
            $crit->order = 'nama_pasien ASC';
            return new CActiveDataProvider($this, array(
			'criteria'=>$crit,
                        'pagination'=>false, 
                        'sort' => false,
		));
        }
        /**
         * method untuk data provider grafik
         * @return CActiveDataProvider 
         */
        public function searchGrafik(){
            $criteria = $this->functionCriteria();
            $crit = $criteria;
            $crit->select = 'golonganumur_nama as tick, jeniskelamin as data, count(pendaftaran_id) as jumlah';
            $crit->group = 'golonganumur_nama,jeniskelamin';
            return new CActiveDataProvider($this, array(
			'criteria'=>$crit,
		));
        }
        
        public function getPasienByUmu(){
            
        }

}