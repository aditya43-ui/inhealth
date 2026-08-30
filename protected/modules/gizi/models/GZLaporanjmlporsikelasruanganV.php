<?php
class GZLaporanjmlporsikelasruanganV extends LaporanjmlporsikelasruanganV
{
	public $jns_periode,$tgl_awal,$tgl_akhir,$bln_awal,$bln_akhir,$thn_awal,$thn_akhir;
        public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        public function searchTable()
	{
		$criteria=new CDbCriteria;
                
		$criteria = $this->functionCriteria();

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        public function searchPrint()
	{
		$criteria=new CDbCriteria;

		$criteria = $this->functionCriteria();
                $criteria->limit = -1;

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                        'pagination'=>false,
		));
	}
        public function functionCriteria()
	{
		$criteria=new CDbCriteria;

                $criteria->select ='jenisdiet_nama,jenisdiet_id';
                $criteria->group = 'jenisdiet_nama,jenisdiet_id';
                
                $criteria->addBetweenCondition('DATE(tglkirimmenu)',$this->tgl_awal,$this->tgl_akhir,true);
		$criteria->compare('jenisdiet_id',$this->jenisdiet_id);
		$criteria->compare('LOWER(jenisdiet_nama)',strtolower($this->jenisdiet_nama),true);
		$criteria->compare('LOWER(jml_kirim)',strtolower($this->jml_kirim),true);
		$criteria->compare('kelaspelayanan_id',$this->kelaspelayanan_id);
		$criteria->compare('LOWER(kelaspelayanan_nama)',strtolower($this->kelaspelayanan_nama),true);
		$criteria->compare('kirimmenudiet_id',$this->kirimmenudiet_id);

		return $criteria;
	}
        
         public function getSumJmlPorsi($groups = array(), $nama_kolom = null){
            $format = new MyFormatter();
            $criteria=new CDbCriteria();
            $criteria->group = 'jenisdiet_id';
            foreach($groups AS $i => $group){
                if($group == 'jenisdiet'){
                    $criteria->group .= ', jenisdiet_id';
                    $criteria->compare('jenisdiet_id',$this->jenisdiet_id);
                }
            }
            
            /*if($nama_kolom == 'BANGSAL'){
                $criteria->addCondition('kelaspelayanan_id = 19');
            }else if($nama_kolom == 'OBS'){
                $criteria->addCondition('kelaspelayanan_id = 22');
            }else if($nama_kolom == 'ICU'){
                $criteria->addCondition('kelaspelayanan_id = 6');
            }else if($nama_kolom == 'VVIP'){
                $criteria->addCondition('kelaspelayanan_id = 8');
            }else if($nama_kolom == 'VIPA'){
                $criteria->addCondition('kelaspelayanan_id = 9');
            }else if($nama_kolom == 'VIPB'){
                $criteria->addCondition('kelaspelayanan_id = 10');
            }else if($nama_kolom == 'UTAMA'){
                $criteria->addCondition('kelaspelayanan_id = 18');
            }else if($nama_kolom == 'MADYA'){
                $criteria->addCondition('kelaspelayanan_id IN(13,14)');
            }else if($nama_kolom == 'I'){
                $criteria->addCondition('kelaspelayanan_id = 15');
            }else if($nama_kolom == 'II'){
                $criteria->addCondition('kelaspelayanan_id = 16');
            }else if($nama_kolom == 'III'){
                $criteria->addCondition('kelaspelayanan_id = 17');
            }if($nama_kolom == 'JML'){
                $kelas = array(19,22,6,8,9,10,18,13,14,15,16,17);
                $criteria->addInCondition('kelaspelayanan_id',$kelas);
            }*/
            if ($nama_kolom == 'JML'){
                 $kelas = KelaspelayananM::model()->findAll('kelaspelayanan_aktif = TRUE ORDER BY kelaspelayanan_nama');
                    $id=array();
                    foreach($kelas as $pecah_id){
                        $id[].= $pecah_id->kelaspelayanan_id;
                    }   
                $criteria->addInCondition("kelaspelayanan_id",$id);
            }else{
                $criteria->addCondition("kelaspelayanan_id = '$nama_kolom' ");
            }
            
            if(isset($_GET['GZLaporanjmlporsikelasruanganV'])){
                $tgl_awal = $format->formatDateTimeForDb($_GET['GZLaporanjmlporsikelasruanganV']['tgl_awal']);
                $tgl_akhir = $format->formatDateTimeForDb($_GET['GZLaporanjmlporsikelasruanganV']['tgl_akhir']);
                $jenisdiet_nama =$_GET['GZLaporanjmlporsikelasruanganV']['jenisdiet_nama'];
                $criteria->addBetweenCondition('DATE(tglkirimmenu)',$tgl_awal,$tgl_akhir);
                $criteria->compare('LOWER(jenisdiet_nama)',strtolower($this->jenisdiet_nama));
            }
            $criteria->select = $criteria->group.', sum(jml_kirim) AS jml_kirim';
            $modKirim = LaporanjmlporsikelasruanganV::model()->findAll($criteria);
            $totKirim = 0;
            foreach($modKirim as $key=>$kirim){
                $totKirim += $kirim->jml_kirim;
            }
            return $totKirim;
        }
        public function getSumTotalPorsi($groups = array(), $nama_kolom = null){
            $format = new MyFormatter();
            $criteria=new CDbCriteria();
            $criteria->group = 'kelaspelayanan_id, jenisdiet_nama';
            foreach($groups AS $i => $group){
                if($group == 'jenisdiet'){
                   // $criteria->group .= ', kelaspelayanan_id';
                    //$criteria->compare('kelaspelayanan_id',$this->kelaspelayanan_id);
                }
            }
            
            /*if($nama_kolom == 'BANGSAL'){
                $criteria->addCondition('kelaspelayanan_id = 19');
            }else if($nama_kolom == 'OBS'){
                $criteria->addCondition('kelaspelayanan_id = 22');
            }else if($nama_kolom == 'ICU'){
                $criteria->addCondition('kelaspelayanan_id = 6');
            }else if($nama_kolom == 'VVIP'){
                $criteria->addCondition('kelaspelayanan_id = 8');
            }else if($nama_kolom == 'VIPA'){
                $criteria->addCondition('kelaspelayanan_id = 9');
            }else if($nama_kolom == 'VIPB'){
                $criteria->addCondition('kelaspelayanan_id = 10');
            }else if($nama_kolom == 'UTAMA'){
                $criteria->addCondition('kelaspelayanan_id = 18');
            }else if($nama_kolom == 'MADYA'){
                $criteria->addCondition('kelaspelayanan_id IN(13,14)');
            }else if($nama_kolom == 'I'){
                $criteria->addCondition('kelaspelayanan_id = 15');
            }else if($nama_kolom == 'II'){
                $criteria->addCondition('kelaspelayanan_id = 16');
            }else if($nama_kolom == 'III'){
                $criteria->addCondition('kelaspelayanan_id = 17');
            }if($nama_kolom == 'TOTAL'){
                $kelas = array(19,22,6,8,9,10,18,13,14,15,16,17);
                $criteria->addInCondition('kelaspelayanan_id',$kelas);
            }*/
             if ($nama_kolom == 'TOTAL'){
                    $kelas = KelaspelayananM::model()->findAll('kelaspelayanan_aktif = TRUE ORDER BY kelaspelayanan_nama');
                    $id=array();
                    foreach($kelas as $pecah_id){
                        $id[].= $pecah_id->kelaspelayanan_id;
                    }            
               $criteria->addInCondition("kelaspelayanan_id", $id);
            }else{
                $criteria->addCondition("kelaspelayanan_id = $nama_kolom ");
            }
            
            if(isset($_GET['GZLaporanjmlporsikelasruanganV'])){
                $tgl_awal = $format->formatDateTimeForDb($_GET['GZLaporanjmlporsikelasruanganV']['tgl_awal']);
                $tgl_akhir = $format->formatDateTimeForDb($_GET['GZLaporanjmlporsikelasruanganV']['tgl_akhir']);
                $jenisdiet_nama =$_GET['GZLaporanjmlporsikelasruanganV']['jenisdiet_nama'];
                $criteria->addBetweenCondition('DATE(tglkirimmenu)',$tgl_awal,$tgl_akhir);
                $criteria->compare('LOWER(jenisdiet_nama)',strtolower($jenisdiet_nama));
            }
            $criteria->select = $criteria->group.', jenisdiet_nama, sum(jml_kirim) AS jml_kirim';
            $modKirim = LaporanjmlporsikelasruanganV::model()->findAll($criteria);
            $totKirim = 0;
            foreach($modKirim as $key=>$kirim){
                $totKirim += $kirim->jml_kirim;
            }
            return $totKirim;
        }
}
?>