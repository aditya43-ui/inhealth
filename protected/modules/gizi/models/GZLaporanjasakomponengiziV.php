<?php
class GZLaporanjasakomponengiziV extends LaporanjasakomponengiziV
{
	public $jns_periode,$tgl_awal,$tgl_akhir,$bln_awal,$bln_akhir,$thn_awal,$thn_akhir,$jumlahTampil;
        public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        public function searchTable()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

                $criteria->select='pasien_id,nama_pasien,kelaspelayanan_nama,kelaspelayanan_id,sum(tarif_tindakankomp)';
                $criteria->group='pasien_id,nama_pasien,kelaspelayanan_nama,kelaspelayanan_id';
                $criteria->addBetweenCondition('DATE(tglmasukpenunjang)',$this->tgl_awal,$this->tgl_akhir,true);
		$criteria->compare('pasienmasukpenunjang_id',$this->pasienmasukpenunjang_id);
		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('LOWER(no_rekam_medik)',strtolower($this->no_rekam_medik),true);
		$criteria->compare('LOWER(namadepan)',strtolower($this->namadepan),true);
		$criteria->compare('LOWER(nama_pasien)',strtolower($this->nama_pasien),true);
		$criteria->compare('LOWER(nama_bin)',strtolower($this->nama_bin),true);
		$criteria->compare('LOWER(jeniskelamin)',strtolower($this->jeniskelamin),true);
		$criteria->compare('LOWER(tempat_lahir)',strtolower($this->tempat_lahir),true);
		$criteria->compare('LOWER(tanggal_lahir)',strtolower($this->tanggal_lahir),true);
		$criteria->compare('LOWER(alamat_pasien)',strtolower($this->alamat_pasien),true);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('LOWER(no_pendaftaran)',strtolower($this->no_pendaftaran),true);
		$criteria->compare('ruanganasal_id',$this->ruanganasal_id);
		$criteria->compare('kelaspelayanan_id',$this->kelaspelayanan_id);
		$criteria->compare('LOWER(kelaspelayanan_nama)',strtolower($this->kelaspelayanan_nama),true);
		$criteria->compare('LOWER(no_masukpenunjang)',strtolower($this->no_masukpenunjang),true);
		$criteria->compare('tindakanpelayanan_id',$this->tindakanpelayanan_id);
		$criteria->compare('tindakankomponen_id',$this->tindakankomponen_id);
		$criteria->compare('tarif_tindakankomp',$this->tarif_tindakankomp);
		$criteria->compare('komponentarif_id',$this->komponentarif_id);
		$criteria->compare('LOWER(komponentarif_nama)',strtolower($this->komponentarif_nama),true);
		$criteria->compare('daftartindakan_id',$this->daftartindakan_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                        'pagination' => array('pageSize' => $this->jumlahTampil,),
                        'totalItemCount' => $this->jumlahTampil,
		));
	}
        
        public function searchPrint()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

               $criteria->select='pasien_id,nama_pasien,kelaspelayanan_nama,kelaspelayanan_id,sum(tarif_tindakankomp)';
                $criteria->group='pasien_id,nama_pasien,kelaspelayanan_nama,kelaspelayanan_id';
                $criteria->addBetweenCondition('DATE(tglmasukpenunjang)',$this->tgl_awal,$this->tgl_akhir,true);
		$criteria->compare('pasienmasukpenunjang_id',$this->pasienmasukpenunjang_id);
		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('LOWER(no_rekam_medik)',strtolower($this->no_rekam_medik),true);
		$criteria->compare('LOWER(namadepan)',strtolower($this->namadepan),true);
		$criteria->compare('LOWER(nama_pasien)',strtolower($this->nama_pasien),true);
		$criteria->compare('LOWER(nama_bin)',strtolower($this->nama_bin),true);
		$criteria->compare('LOWER(jeniskelamin)',strtolower($this->jeniskelamin),true);
		$criteria->compare('LOWER(tempat_lahir)',strtolower($this->tempat_lahir),true);
		$criteria->compare('LOWER(tanggal_lahir)',strtolower($this->tanggal_lahir),true);
		$criteria->compare('LOWER(alamat_pasien)',strtolower($this->alamat_pasien),true);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('LOWER(no_pendaftaran)',strtolower($this->no_pendaftaran),true);
		$criteria->compare('ruanganasal_id',$this->ruanganasal_id);
		$criteria->compare('kelaspelayanan_id',$this->kelaspelayanan_id);
		$criteria->compare('LOWER(kelaspelayanan_nama)',strtolower($this->kelaspelayanan_nama),true);
		$criteria->compare('LOWER(no_masukpenunjang)',strtolower($this->no_masukpenunjang),true);
		$criteria->compare('tindakanpelayanan_id',$this->tindakanpelayanan_id);
		$criteria->compare('tindakankomponen_id',$this->tindakankomponen_id);
		$criteria->compare('tarif_tindakankomp',$this->tarif_tindakankomp);
		$criteria->compare('komponentarif_id',$this->komponentarif_id);
		$criteria->compare('LOWER(komponentarif_nama)',strtolower($this->komponentarif_nama),true);
		$criteria->compare('daftartindakan_id',$this->daftartindakan_id);
                
                $criteria->limit = -1;

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                        'pagination' => array('pageSize' => $this->jumlahTampil,),
                        'totalItemCount' => $this->jumlahTampil,
		));
	}
        
        public function getSumKomponen($groups = array(), $nama_kolom = null){
            $format = new MyFormatter();
            $criteria=new CDbCriteria();
            $criteria->group = 'komponentarif_id';
            foreach($groups AS $i => $group){
                if($group == 'pasien'){
                    $criteria->group .= ', pasien_id';
                    $criteria->compare('pasien_id',$this->pasien_id);
                }else if($group == 'kelas'){
                    $criteria->group .= ', kelaspelayanan_id';
                    $criteria->compare('kelaspelayanan_id',$this->kelaspelayanan_id);
                }
            }
            if($nama_kolom == 'insentif'){
                $criteria->addCondition('komponentarif_id IN(27,39,40)'); //diseuaikan dengan kebutuhan RS
            }else if($nama_kolom == 'ag'){
                $criteria->addCondition('komponentarif_id = 7'); //diseuaikan dengan kebutuhan RS
            }else if($nama_kolom == 'rs'){
                $criteria->addCondition('komponentarif_id = 1'); //diseuaikan dengan kebutuhan RS
            }else if($nama_kolom == 'total'){
                $criteria->addCondition('komponentarif_id = 6'); //diseuaikan dengan kebutuhan RS

            }
            
            if(isset($_GET['GZLaporanjasakomponengiziV'])){
                $tgl_awal = $format->formatDateTimeForDb($_GET['GZLaporanjasakomponengiziV']['tgl_awal']);
                $tgl_akhir = $format->formatDateTimeForDb($_GET['GZLaporanjasakomponengiziV']['tgl_akhir']);
                $criteria->addBetweenCondition('tglmasukpenunjang',$tgl_awal,$tgl_akhir);
            }
            $criteria->select = $criteria->group.', sum(tarif_tindakankomp) AS tarif_tindakankomp';
            $modTarif = LaporanjasakomponengiziV::model()->findAll($criteria);
            $totTarif = 0;
            foreach($modTarif as $key=>$tarif){
                $totTarif += $tarif->tarif_tindakankomp;
            }
            return $totTarif;
        }
                
        public function getSumTotal($groups = array(), $nama_kolom = null){
            $format = new MyFormatter();
            $criteria=new CDbCriteria();
            $criteria->group = 'komponentarif_id';
            foreach($groups AS $i => $group){
                if($group == 'pasien'){
                    $criteria->group .= ', pasien_id';
                    $criteria->compare('pasien_id',$this->pasien_id);
                }else if($group == 'kelas'){
                    $criteria->group .= ', kelaspelayanan_id';
                    $criteria->compare('kelaspelayanan_id',$this->kelaspelayanan_id);
                }
            }
            
                $criteria->addCondition('komponentarif_id = '.Params::KOMPONENTARIF_ID_TOTAL);
            if(isset($_GET['GZLaporanjasakomponengiziV'])){
                $tgl_awal = $format->formatDateTimeForDb($_GET['GZLaporanjasakomponengiziV']['tgl_awal']);
                $tgl_akhir = $format->formatDateTimeForDb($_GET['GZLaporanjasakomponengiziV']['tgl_akhir']);
                $criteria->addBetweenCondition('tglmasukpenunjang',$tgl_awal,$tgl_akhir);
            }
            $criteria->select = $criteria->group.', sum(tarif_tindakankomp) AS tarif_tindakankomp';
            $modTarif = LaporanjasakomponengiziV::model()->findAll($criteria);
            $totTarif = 0;
            foreach($modTarif as $key=>$tarif){
                $totTarif += $tarif->tarif_tindakankomp;
            }
            return $totTarif;
        }
        public function getSumTotalKomponen($groups = array(), $nama_kolom = null){
            $format = new MyFormatter();
            $criteria=new CDbCriteria();
            $criteria->group = 'komponentarif_id';
            if($nama_kolom == 'insentif'){
                $criteria->addCondition('komponentarif_id IN(27,39,40)'); //disesuaikan dengan kebutuhan RS
            }else if($nama_kolom == 'ag'){
                $criteria->addCondition('komponentarif_id = 35'); //disesuaikan dengan kebutuhan RS
            }
            if(isset($_GET['GZLaporanjasakomponengiziV'])){
                $tgl_awal = $format->formatDateTimeForDb($_GET['GZLaporanjasakomponengiziV']['tgl_awal']);
                $tgl_akhir = $format->formatDateTimeForDb($_GET['GZLaporanjasakomponengiziV']['tgl_akhir']);
                $criteria->addBetweenCondition('tglmasukpenunjang',$tgl_awal,$tgl_akhir);
            }
            $criteria->select = $criteria->group.', sum(tarif_tindakankomp) AS tarif_tindakankomp';
            $modTarif = LaporanjasakomponengiziV::model()->findAll($criteria);
            $totTarif = 0;
            if(count((array)$modTarif) > 0){
                foreach($modTarif as $key=>$tarif){
                    $totTarif += $tarif->tarif_tindakankomp;
                }
            }else{
                $totTarif = 0;
            }
            return $totTarif;
        }
        public function getTotalKomponen($groups = array(), $nama_kolom = null){
            $format = new MyFormatter();
            $criteria=new CDbCriteria();
            $criteria->group = 'komponentarif_id';
                $criteria->addInCondition('komponentarif_id',array(35,27,39,40)); //disesuaikan dengan kebutuhan RS
            if(isset($_GET['GZLaporanjasakomponengiziV'])){
                $tgl_awal = $format->formatDateTimeForDb($_GET['GZLaporanjasakomponengiziV']['tgl_awal']);
                $tgl_akhir = $format->formatDateTimeForDb($_GET['GZLaporanjasakomponengiziV']['tgl_akhir']);
                $criteria->addBetweenCondition('tglmasukpenunjang',$tgl_awal,$tgl_akhir);
            }
            $criteria->select = $criteria->group.', sum(tarif_tindakankomp) AS tarif_tindakankomp';
            $modTarif = LaporanjasakomponengiziV::model()->findAll($criteria);
            $totTarif = 0;
            if(count((array)$modTarif) > 0){
                foreach($modTarif as $key=>$tarif){
                    $totTarif += $tarif->tarif_tindakankomp;
                }
            }else{
                $totTarif = 0;
            }
            return $totTarif;
        }
}
?>