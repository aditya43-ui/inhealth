<?php
class BKLaporantindakankomponenV extends LaporantindakankomponenV
{
        public $komponentarif_id;
		public $tgl_awal,$tgl_akhir;
        public $jns_periode,$bln_awal,$bln_akhir,$thn_awal,$thn_akhir;
		public $data, $jumlah;
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        // -- REKAP JASA DOKTER -- //
        
	public function searchJasaDokter($pagination = true)
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
		$criteria->addBetweenCondition('tgl_pendaftaran',$this->tgl_awal,$this->tgl_akhir,true);
		if(!empty($this->pegawai_id)){
			$criteria->addCondition("pegawai_id = ".$this->pegawai_id);					
		}
		$criteria->addCondition('ruangan_id = '.Yii::app()->user->getState('ruangan_id'));
		$criteria->group = 'pegawai_id,nama_pegawai,gelardepan,gelarbelakang_nama';
		$criteria->select = $criteria->group;
		if($pagination == false){
			$pagination = false;
			$criteria->limit = -1;
		}else{
			$pagination = array('pageSize'=>10);
		}
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                        'pagination'=>$pagination,
		));
	}
        public function searchDetailJasaDokter($pagination = true)
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

                $criteria=new CDbCriteria;
                $criteria->addBetweenCondition('tgl_pendaftaran',$this->tgl_awal,$this->tgl_akhir,true);
				if(!empty($this->pegawai_id)){
					$criteria->addCondition("pegawai_id = ".$this->pegawai_id);					
				}
                $criteria->group = 'pendaftaran_id, pasien_id, nama_pasien, namaperusahaan, no_pendaftaran, no_rekam_medik,tgl_pendaftaran,ruangan_nama,ruangan_id,pegawai_id,gelardepan,nama_pegawai,gelarbelakang_nama,instalasi_nama,instalasi_id';
				if(!empty($this->ruangan_id)){
					$criteria->addCondition("instalasi_id = ".$this->ruangan_id);					
				}
				if(!empty($this->ruangan_id)){
					$criteria->addCondition("ruangan_id = ".$this->ruangan_id);					
				}
                $criteria->select = $criteria->group.", sum(qty_tindakan) As qty_tindakan";
                if($pagination == false){
                    $pagination = false;
                    $criteria->limit = -1;
                }else{
                    $pagination = array('pageSize'=>10);
                }
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                        'pagination'=>$pagination,
		));
	}
        // -- END REKAP JASA DOKTER -- //
        public function getDokterItems()
        {
            return DokterV::model()->findAll();
        }
        
        public function getSumKomponen($groups = array(), $nama_kolom = null){
            if(isset($_GET['BKLaporantindakankomponenV']['komponentarif_id'])){
                $komponentarif_id = $_GET['BKLaporantindakankomponenV']['komponentarif_id'];
            }
            $format = new MyFormatter();
            $criteria=new CDbCriteria();
            $criteria->group = 'komponentarif_id,daftartindakan_tindakan,daftartindakan_konsul,daftartindakan_visite,daftartindakan_karcis';
            foreach($groups AS $i => $group){
                if($group == 'pegawai'){
                    $criteria->group .= ', pegawai_id';
					if(!empty($this->pegawai_id)){
						$criteria->addCondition("pegawai_id = ".$this->pegawai_id);					
					}
                }else if($group == 'pendaftaran'){
                    $criteria->group .= ', pendaftaran_id, tgl_pendaftaran';
					if(!empty($this->pendaftaran_id)){
						$criteria->addCondition("pendaftaran_id = ".$this->pendaftaran_id);					
					}
                }else if($group == 'ruangan'){
                    $criteria->group .= ', ruangan_id, instalasi_id';
					if(!empty($this->ruangan_id)){
						$criteria->addCondition("ruangan_id = ".$this->ruangan_id);					
					}
					if(!empty($this->instalasi_id)){
						$criteria->addCondition("instalasi_id = ".$this->instalasi_id);					
					}
                }
            }
//            RND-6992
//            if(is_array($komponentarif_id)){
//                $criteria->addInCondition('komponentarif_id',$komponentarif_id);
//            }else{
//                $criteria->addCondition('komponentarif_id IS NULL'); //data tdk dimunculkan
//            }
			
			 $criteria->addCondition('komponentarif_id IS NULL');
			
			
            if($nama_kolom == 'visite'){
                $criteria->addCondition('daftartindakan_visite = TRUE');
            }else if($nama_kolom == 'konsul'){
                $criteria->addCondition('daftartindakan_konsul = TRUE');
            }else if($nama_kolom == 'jasaoperator'){
                $criteria->addCondition('komponentarif_id = 21'); //disesuaikan dengan kebutuhan RS
            }else if($nama_kolom == 'sewaalat'){
                $criteria->addCondition('komponentarif_id = 26'); //disesuaikan dengan kebutuhan RS
            }else if($nama_kolom == 'alatbahan'){
                $criteria->addCondition('komponentarif_id = 15'); //disesuaikan dengan kebutuhan RS
            }else if($nama_kolom == 'lainnya'){
                $criteria->addCondition('daftartindakan_visite = FALSE');
                $criteria->addCondition('daftartindakan_konsul = FALSE');
                $criteria->addCondition('daftartindakan_tindakan = FALSE');
                $criteria->addCondition('komponentarif_id <> 21');
                $criteria->addCondition('komponentarif_id <> 26');
                $criteria->addCondition('komponentarif_id <> 15');
            }
            if(isset($_GET['BKLaporantindakankomponenV'])){
                $tgl_awal = $format->formatDateTimeForDb($_GET['BKLaporantindakankomponenV']['tgl_awal']);
                $tgl_akhir = $format->formatDateTimeForDb($_GET['BKLaporantindakankomponenV']['tgl_akhir']);
                $criteria->addBetweenCondition('tgl_pendaftaran',$tgl_awal,$tgl_akhir);
            }
            $criteria->select = $criteria->group.', sum(tarif_tindakankomp) AS tarif_tindakankomp';
            $modTarif = LaporantindakankomponenV::model()->findAll($criteria);
            $totTarif = 0;
            foreach($modTarif as $key=>$tarif){
                $totTarif += $tarif->tarif_tindakankomp;
            }
            return $totTarif;
        }
        
        public function getSumTindakan($groups = array()){
            if(isset($_GET['BKLaporantindakankomponenV']['komponentarif_id'])){
                $komponentarif_id = $_GET['BKLaporantindakankomponenV']['komponentarif_id'];
            }
            $format = new MyFormatter();
            $criteria = new CDbCriteria;
            $criteria->group = 'daftartindakan_id';
            foreach($groups AS $i => $group){
                if($group == 'pegawai'){
                    $criteria->group .= ', pegawai_id';
					if(!empty($this->pegawai_id)){
						$criteria->addCondition("pegawai_id = ".$this->pegawai_id);					
					}
                }else if($group == 'pendaftaran'){
                    $criteria->group .= ', pendaftaran_id, tgl_pendaftaran';
					if(!empty($this->pendaftaran_id)){
						$criteria->addCondition("pendaftaran_id = ".$this->pendaftaran_id);					
					}
                }else if($group == 'ruangan'){
                    $criteria->group .= ', ruangan_id';
					if(!empty($this->ruangan_id)){
						$criteria->addCondition("ruangan_id = ".$this->ruangan_id);					
					}
                }
            }
            $criteria->addCondition('daftartindakan_tindakan = TRUE');
            if(isset($_GET['BKLaporantindakankomponenV'])){
                $tgl_awal = $format->formatDateTimeForDb($_GET['BKLaporantindakankomponenV']['tgl_awal']);
                $tgl_akhir = $format->formatDateTimeForDb($_GET['BKLaporantindakankomponenV']['tgl_akhir']);
                $criteria->addBetweenCondition('tgl_pendaftaran',$tgl_awal,$tgl_akhir);
            }
            $criteria->select = $criteria->group.', sum(tarif_tindakan) AS tarif_tindakan';
            $modTarif = LaporantindakankomponenV::model()->findAll($criteria);
            $totTarif = 0;
            foreach($modTarif as $key=>$tarif){
                $totTarif += $tarif->tarif_tindakan;
            }
            return $totTarif;
        }
}