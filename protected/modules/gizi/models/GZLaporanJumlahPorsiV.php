<?php
/**
 * model ini digunakan untuk mengakses view laporanjmlporsigiziruangan_v
 * 
 * @package application.modules.gizi
 * @subpackage models
 * @author M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
 * @version     2.0.0 
 * @link    <http://piindonesia.co.id>
 */
class GZLaporanJumlahPorsiV extends LaporanjmlporsigiziruanganV {
    
    public $tgl_awal, $bln_awal, $thn_awal;
    public $tgl_akhir, $bln_akhir,$thn_akhir;
    public $jns_periode;
     
    /**
     * digunakan untuk mengenerate fungsi Yii CActiveRecord
     * @param type $className
     * @return type
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * generate tabel
     * @return \CActiveDataProvider
     */
   public function searchTable() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.
        $criteria=new CDbCriteria;
        $criteria->select='jenisdiet_nama, jenisdiet_id';
        $criteria->group='jenisdiet_nama, jenisdiet_id';
        $criteria->addBetweenCondition('tglkirimmenu', $this->tgl_awal, $this->tgl_akhir);        
        $criteria->compare('jenisdiet_id',$this->jenisdiet_id);
        $criteria->compare('LOWER(jenisdiet_nama)',strtolower($this->jenisdiet_nama),true);
        $criteria->compare('LOWER(jml_kirim)',strtolower($this->jml_kirim),true);
        if (!empty($this->ruangan_id)){
            if (is_array($this->ruangan_id)){
                $criteria->addInCondition(" ruangan_id ",$this->ruangan_id);
            }else{
                $criteria->addCondition(" ruangan_id = ".$this->ruangan_id);
            }
        }
        //$criteria->compare('ruangan_id',$this->ruangan_id);
        $criteria->compare('LOWER(ruangan_nama)',strtolower($this->ruangan_nama),true);
        $criteria->compare('kelaspelayanan_id',$this->kelaspelayanan_id);
        $criteria->compare('LOWER(kelaspelayanan_nama)',strtolower($this->kelaspelayanan_nama),true);
        $criteria->compare('kirimmenudiet_id',$this->kirimmenudiet_id);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }

    /**
     * mengenerate filter untuk prinout
     * @return \CActiveDataProvider
     */
    public function searchPrint()
        {
                 // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria=new CDbCriteria;
        $criteria->select='jenisdiet_nama, jenisdiet_id';
        $criteria->group='jenisdiet_nama, jenisdiet_id';
        $criteria->addBetweenCondition('tglkirimmenu', $this->tgl_awal, $this->tgl_akhir);        
        $criteria->compare('jenisdiet_id',$this->jenisdiet_id);
        $criteria->compare('LOWER(jenisdiet_nama)',strtolower($this->jenisdiet_nama),true);
        $criteria->compare('LOWER(jml_kirim)',strtolower($this->jml_kirim),true);
        if (!empty($this->ruangan_id)){
            if (is_array($this->ruangan_id)){
                $criteria->addInCondition(" ruangan_id ",$this->ruangan_id);
            }else{
                $criteria->addCondition(" ruangan_id = ".$this->ruangan_id);
            }
        }
        $criteria->compare('LOWER(ruangan_nama)',strtolower($this->ruangan_nama),true);
        $criteria->compare('kelaspelayanan_id',$this->kelaspelayanan_id);
        $criteria->compare('LOWER(kelaspelayanan_nama)',strtolower($this->kelaspelayanan_nama),true);
        $criteria->compare('kirimmenudiet_id',$this->kirimmenudiet_id);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
        }
    
    // public function searchPrint() {
    //     // Warning: Please modify the following code to remove attributes that
    //     // should not be searched.

    //     $criteria = new CDbCriteria;
    //     $criteria = $this->functionCriteria();

    //     return new CActiveDataProvider($this, array(
    //                 'criteria' => $criteria,
    //                 // 'pagination'=>false,
    //             ));
    // }
    
        /**
         * pencarian untuk data grafik
         * @return \CActiveDataProvider
         */
     public function searchGrafik() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;
        $criteria = $this->functionCriteria();

        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                ));
    }

    /**
     * fungsi utama pencarian
     * @return \CActiveDataProvider
     */
    protected function functionCriteria(){
        $criteria=new CDbCriteria;

        $criteria->addBetweenCondition('tglkirimmenu', $this->tgl_awal, $this->tgl_akhir);
        $criteria->compare('LOWER(tglkirimmenu)',strtolower($this->tglkirimmenu),true);
        $criteria->compare('jenisdiet_id',$this->jenisdiet_id);
        $criteria->compare('LOWER(jenisdiet_nama)',strtolower($this->jenisdiet_nama),true);
        $criteria->compare('LOWER(jml_kirim)',strtolower($this->jml_kirim),true);
        if (!empty($this->ruangan_id)){
            if (is_array($this->ruangan_id)){
                $criteria->addInCondition(" ruangan_id ",$this->ruangan_id);
            }else{
                $criteria->addCondition(" ruangan_id = ".$this->ruangan_id);
            }
        }
        $criteria->compare('LOWER(ruangan_nama)',strtolower($this->ruangan_nama),true);
        $criteria->compare('kelaspelayanan_id',$this->kelaspelayanan_id);
        $criteria->compare('LOWER(kelaspelayanan_nama)',strtolower($this->kelaspelayanan_nama),true);
        $criteria->compare('kirimmenudiet_id',$this->kirimmenudiet_id);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }   

    /**
     * total jumlah dari kelas pelayanan
     * @param type $kelaspelayanan_id
     * @param type $idjenisdiet
     * @param type $ruangan_id
     * @return type
     */
    public function getSumKelas($kelaspelayanan_id = null, $idjenisdiet, $ruangan_id = null){
            if(isset($_GET['GZLaporanJumlahPorsiV']['kelaspelayanan_id'])){
                $komponentarif_id = $_GET['GZLaporanJumlahPorsiV']['kelaspelayanan_id'];
            }
            // var_dump($idjenisdiet);
            $format = new MyFormatter();
            $criteria=new CDbCriteria();
            $criteria->group = 'ruangan_id, kelaspelayanan_id, jenisdiet_id, pasien_id';
            // foreach($groups AS $i => $group){
            //     if($group == 'jenisdiet_id'){
            //         $criteria->group .= ', jenisdiet_id';
            //         $criteria->compare('jenisdiet_id',$this->jenisdiet_id);
            //     }
            // }
            
    $criteria->compare('jenisdiet_id',$idjenisdiet);
    if(!empty($kelaspelayanan_id)){
            $criteria->addCondition('kelaspelayanan_id = '.$kelaspelayanan_id);
    }
            if(!empty($ruangan_id)){
                $criteria->addCondition('ruangan_id = '.$ruangan_id);
            }
            if(isset($_GET['GZLaporanJumlahPorsiV'])){
                $this->jns_periode = $_GET['GZLaporanJumlahPorsiV']['jns_periode'];
                $this->tgl_awal = $format->formatDateTimeForDb($_GET['GZLaporanJumlahPorsiV']['tgl_awal']);
                $this->tgl_akhir = $format->formatDateTimeForDb($_GET['GZLaporanJumlahPorsiV']['tgl_akhir']);
                $this->bln_awal = $format->formatMonthForDb($_GET['GZLaporanJumlahPorsiV']['bln_awal']);
                $this->bln_akhir = $format->formatMonthForDb($_GET['GZLaporanJumlahPorsiV']['bln_akhir']);
                $bln_akhir = $this->bln_akhir."-".date("t",strtotime($this->bln_akhir));
                $thn_akhir = $this->thn_akhir."-".date("m-t",strtotime($this->thn_akhir."-12"));
                switch($this->jns_periode){
                    case 'bulan' : $this->tgl_awal = $this->bln_awal."-01"; $this->tgl_akhir = $bln_akhir; break;
                    case 'tahun' : $this->tgl_awal = $this->thn_awal."-01-01"; $this->tgl_akhir = $thn_akhir; break;
                    default : null;
                }
                $tgl_awal = $this->tgl_awal." 00:00:00";
                $tgl_akhir = $this->tgl_akhir." 23:59:59";                    
                $criteria->addBetweenCondition('tglkirimmenu',$tgl_awal,$tgl_akhir);
            }
            $criteria->select = $criteria->group.'';
            $modTarif = LaporanjmlporsigiziruanganV::model()->findAll($criteria);
            $totTarif = 0;
            foreach($modTarif as $key=>$tarif){
                $totTarif++;
            }
             return $totTarif;
        }

    /**
     * jumlah masing - masing jenis diet
     * @param type $idjenisdiet
     * @param type $ruangan_id
     * @return type
     */
    public function getSumJml($idjenisdiet, $ruangan_id=null){
        if (isset($_GET['GZLaporanJumlahPorsiV']['kelaspelayanan_id'])){
            $komponentarif_id = $_GET['GZLaporanJumlahPorsiV']['kelaspelayanan_id'];
            
        }
        $format = new MyFormatter();
        $criteria = new CDbCriteria();
        $criteria->group = 'ruangan_id, jenisdiet_id, pasien_id';
        $criteria->compare('jenisdiet_id',$idjenisdiet);

		if(!empty($ruangan_id)){
			$criteria->addCondition('ruangan_id = '.$ruangan_id);
		}
		if(isset($_GET['GZLaporanJumlahPorsiV'])){
			$this->jns_periode = $_GET['GZLaporanJumlahPorsiV']['jns_periode'];
                        $this->tgl_awal = $format->formatDateTimeForDb($_GET['GZLaporanJumlahPorsiV']['tgl_awal']);
                        $this->tgl_akhir = $format->formatDateTimeForDb($_GET['GZLaporanJumlahPorsiV']['tgl_akhir']);
                        $this->bln_awal = $format->formatMonthForDb($_GET['GZLaporanJumlahPorsiV']['bln_awal']);
                        $this->bln_akhir = $format->formatMonthForDb($_GET['GZLaporanJumlahPorsiV']['bln_akhir']);
                        $bln_akhir = $this->bln_akhir."-".date("t",strtotime($this->bln_akhir));
                        $thn_akhir = $this->thn_akhir."-".date("m-t",strtotime($this->thn_akhir."-12"));
                        switch($this->jns_periode){
                            case 'bulan' : $this->tgl_awal = $this->bln_awal."-01"; $this->tgl_akhir = $bln_akhir; break;
                            case 'tahun' : $this->tgl_awal = $this->thn_awal."-01-01"; $this->tgl_akhir = $thn_akhir; break;
                            default : null;
                        }
                        $tgl_awal = $this->tgl_awal." 00:00:00";
                        $tgl_akhir = $this->tgl_akhir." 23:59:59";     
			$criteria->addBetweenCondition('tglkirimmenu',$tgl_awal,$tgl_akhir);
		}
		$criteria->select = $criteria->group.'';
		$modTarif = LaporanjmlporsigiziruanganV::model()->findAll($criteria);
		$totTarif = 0;
		foreach($modTarif as $key=>$tarif){
			$totTarif ++;
		}
		 return $totTarif;

    }        

    /**
     * jumlah 
     * @param type $ruangan_id
     * @return type
     */
    public function getSumJmlT($ruangan_id=null){
            $format = new MyFormatter();
            $criteria = new CDbCriteria();
            $criteria->group = 'kelaspelayanan_id,ruangan_id,jenisdiet_nama, pasien_id';
//            foreach($groups AS $i => $group){
//            if($group == 'jenisdiet'){
//                    $criteria->group .= ', kelaspelayanan_id,ruangan_id';
//                    $criteria->compare('kelaspelayanan_id',$this->kelaspelayanan_id);
//                    $criteria->compare('ruangan_id',$this->ruangan_id);
//                // $criteria->compare('ruangan_id',$this->ruangan_id);
//            } }

            if(!empty($ruangan_id)){
                $criteria->addCondition('ruangan_id = '.$ruangan_id);
            }

            if(isset($_GET['GZLaporanJumlahPorsiV'])){
                $this->jns_periode = $_GET['GZLaporanJumlahPorsiV']['jns_periode'];
                $this->tgl_awal = $format->formatDateTimeForDb($_GET['GZLaporanJumlahPorsiV']['tgl_awal']);
                $this->tgl_akhir = $format->formatDateTimeForDb($_GET['GZLaporanJumlahPorsiV']['tgl_akhir']);
                $this->bln_awal = $format->formatMonthForDb($_GET['GZLaporanJumlahPorsiV']['bln_awal']);
                $this->bln_akhir = $format->formatMonthForDb($_GET['GZLaporanJumlahPorsiV']['bln_akhir']);
                $bln_akhir = $this->bln_akhir."-".date("t",strtotime($this->bln_akhir));
                $thn_akhir = $this->thn_akhir."-".date("m-t",strtotime($this->thn_akhir."-12"));
                switch($this->jns_periode){
                    case 'bulan' : $this->tgl_awal = $this->bln_awal."-01"; $this->tgl_akhir = $bln_akhir; break;
                    case 'tahun' : $this->tgl_awal = $this->thn_awal."-01-01"; $this->tgl_akhir = $thn_akhir; break;
                    default : null;
                }
                $tgl_awal = $this->tgl_awal." 00:00:00";
                $tgl_akhir = $this->tgl_akhir." 23:59:59";     
//                $jenisdiet_nama =$_GET['GZLaporanJumlahPorsiV']['jenisdiet_nama'];
                $criteria->addBetweenCondition('tglkirimmenu',$tgl_awal,$tgl_akhir);
                $criteria->compare('LOWER(jenisdiet_nama)',strtolower($this->jenisdiet_nama));
                $criteria->addInCondition('jenisdiet_id',$this->jenisdiet_id);
                if (!empty($this->ruangan_id)){
                    if (is_array($this->ruangan_id)){
                        $criteria->addInCondition(" ruangan_id ",$this->ruangan_id);
                    }else{
                        $criteria->addCondition(" ruangan_id = ".$this->ruangan_id);
                    }
                }
            }
            $criteria->select = $criteria->group.',jenisdiet_nama';
            $modTarif = LaporanjmlporsigiziruanganV::model()->findAll($criteria);
            $totTarif = 0;
            foreach($modTarif as $key=>$tarif){
                $totTarif ++;
            }
             return $totTarif;

            // if(isset($_GET['GZLaporanJumlahPorsiV'])){
            //     $tgl_awal = $format->formatDateTimeForDb($_GET['GZLaporanJumlahPorsiV']['tgl_awal']);
            //     $tgl_akhir = $format->formatDateTimeForDb($_GET['GZLaporanJumlahPorsiV']['tgl_akhir']);
            //     $criteria->addBetweenCondition('tglkirimmenu',$tgl_awal,$tgl_akhir);
            // }
            // $criteria->select = $criteria->group.', sum(jml_kirim) AS jml_kirim';
            // $modTarif = LaporanjmlporsigiziruanganV::model()->findAll($criteria);
            // $totTarif = 0;
            // foreach($modTarif as $key=>$tarif){
            //     $totTarif += $tarif->jml_kirim;
            // }
            //  return $totTarif;

    }        

    /**
     * jumlah jenis diet
     * @param type $idjenisdiet
     * @return type
     */
     public function getSumTotal($idjenisdiet){

         if (isset($_GET['GZLaporanJumlahPorsiV']['kelaspelayanan_id'])){
            $komponentarif_id = $_GET['GZLaporanJumlahPorsiV']['kelaspelayanan_id'];
            
        }
        $format = new MyFormatter();
        $criteria = new CDbCriteria();
        $criteria->group = 'kelaspelayanan_id, jenisdiet_id, pasien_id';
        $criteria->compare('jenisdiet_id',$idjenisdiet);




            if(isset($_GET['GZLaporanJumlahPorsiV'])){
                $this->jns_periode = $_GET['GZLaporanJumlahPorsiV']['jns_periode'];
                $this->tgl_awal = $format->formatDateTimeForDb($_GET['GZLaporanJumlahPorsiV']['tgl_awal']);
                $this->tgl_akhir = $format->formatDateTimeForDb($_GET['GZLaporanJumlahPorsiV']['tgl_akhir']);
                $this->bln_awal = $format->formatMonthForDb($_GET['GZLaporanJumlahPorsiV']['bln_awal']);
                $this->bln_akhir = $format->formatMonthForDb($_GET['GZLaporanJumlahPorsiV']['bln_akhir']);
                $bln_akhir = $this->bln_akhir."-".date("t",strtotime($this->bln_akhir));
                $thn_akhir = $this->thn_akhir."-".date("m-t",strtotime($this->thn_akhir."-12"));
                switch($this->jns_periode){
                    case 'bulan' : $this->tgl_awal = $this->bln_awal."-01"; $this->tgl_akhir = $bln_akhir; break;
                    case 'tahun' : $this->tgl_awal = $this->thn_awal."-01-01"; $this->tgl_akhir = $thn_akhir; break;
                    default : null;
                }
                $tgl_awal = $this->tgl_awal." 00:00:00";
                $tgl_akhir = $this->tgl_akhir." 23:59:59";     
                $criteria->addBetweenCondition('tglkirimmenu',$tgl_awal,$tgl_akhir);
            }
            $criteria->select = $criteria->group.'';
            $modTarif = LaporanjmlporsigiziruanganV::model()->findAll($criteria);
            $totTarif = 0;
            foreach($modTarif as $key=>$tarif){
                $totTarif ++;
            }
             return $totTarif;
     }

     /**
      * total keseluruhan
      * @param type $idjenisdiet
      * @return type
      */
     public function getSumTotalT($idjenisdiet=null){

         $format = new MyFormatter();
         $criteria = new CDbCriteria();
         $criteria->group = 'kelaspelayanan_id,ruangan_id,jenisdiet_nama, pasien_id';
//        foreach($groups AS $i => $group){
//            if($group == 'jenisdiet'){
//                $criteria->group .= ', kelaspelayanan_id,ruangan_id';
//                $criteria->compare('kelaspelayanan_id',$this->kelaspelayanan_id);
//                $criteria->compare('ruangan_id',$this->ruangan_id);
//                // $criteria->compare('ruangan_id',$this->ruangan_id);
//            }
//        }

        if(isset($_GET['GZLaporanJumlahPorsiV'])){
                $this->jns_periode = $_GET['GZLaporanJumlahPorsiV']['jns_periode'];
                $this->tgl_awal = $format->formatDateTimeForDb($_GET['GZLaporanJumlahPorsiV']['tgl_awal']);
                $this->tgl_akhir = $format->formatDateTimeForDb($_GET['GZLaporanJumlahPorsiV']['tgl_akhir']);
                $this->bln_awal = $format->formatMonthForDb($_GET['GZLaporanJumlahPorsiV']['bln_awal']);
                $this->bln_akhir = $format->formatMonthForDb($_GET['GZLaporanJumlahPorsiV']['bln_akhir']);
                $bln_akhir = $this->bln_akhir."-".date("t",strtotime($this->bln_akhir));
                $thn_akhir = $this->thn_akhir."-".date("m-t",strtotime($this->thn_akhir."-12"));
                switch($this->jns_periode){
                    case 'bulan' : $this->tgl_awal = $this->bln_awal."-01"; $this->tgl_akhir = $bln_akhir; break;
                    case 'tahun' : $this->tgl_awal = $this->thn_awal."-01-01"; $this->tgl_akhir = $thn_akhir; break;
                    default : null;
                }
                $tgl_awal = $this->tgl_awal." 00:00:00";
                $tgl_akhir = $this->tgl_akhir." 23:59:59";     
//                $jenisdiet_nama =$_GET['GZLaporanJumlahPorsiV']['jenisdiet_nama'];
                $criteria->addBetweenCondition('tglkirimmenu',$tgl_awal,$tgl_akhir);
                $criteria->compare('LOWER(jenisdiet_nama)',strtolower($this->jenisdiet_nama));
                $criteria->addInCondition('jenisdiet_id',$this->jenisdiet_id);
                if (!empty($this->ruangan_id)){
                    if (is_array($this->ruangan_id)){
                        $criteria->addInCondition(" ruangan_id ",$this->ruangan_id);
                    }else{
                        $criteria->addCondition(" ruangan_id = ".$this->ruangan_id);
                    }
                }
            }
            $criteria->select = $criteria->group.',jenisdiet_nama';
            $modTarif = LaporanjmlporsigiziruanganV::model()->findAll($criteria);
            $totTarif = 0;
            foreach($modTarif as $key=>$tarif){
                $totTarif ++;
            }
             return $totTarif;
     }

  /**
   * jumlah kelas
   * @param type $groups
   * @param type $kelaspelayanan_id
   * @param type $ruangan_id
   * @return type
   */
 public function getSumKelasP($groups=array(),$kelaspelayanan_id = null, $ruangan_id = null){
       
        //  if (isset($_GET['GZLaporanJumlahPorsiV']['kelaspelayanan_id'])){
        //     $komponentarif_id = $_GET['GZLaporanJumlahPorsiV']['kelaspelayanan_id'];
            
        // }
        $format = new MyFormatter();
        $criteria = new CDbCriteria();
        $criteria->group = 'kelaspelayanan_id,ruangan_id,jenisdiet_nama, pasien_id';
            foreach($groups AS $i => $group){
            if($group == 'jenisdiet'){
                $criteria->group .= ', kelaspelayanan_id,ruangan_id';
               // $criteria->compare('kelaspelayanan_id',$this->kelaspelayanan_id);
               // $criteria->compare('ruangan_id',$this->ruangan_id);
                // $criteria->compare('ruangan_id',$this->ruangan_id);
            }
        }
            if(!empty($kelaspelayanan_id)){
                $criteria->addCondition('kelaspelayanan_id = '.$kelaspelayanan_id);
            }
            if(!empty($ruangan_id)){
                $criteria->addCondition('ruangan_id = '.$ruangan_id);
            }

            if(isset($_GET['GZLaporanJumlahPorsiV'])){
                $this->jns_periode = $_GET['GZLaporanJumlahPorsiV']['jns_periode'];
                $this->tgl_awal = $format->formatDateTimeForDb($_GET['GZLaporanJumlahPorsiV']['tgl_awal']);
                $this->tgl_akhir = $format->formatDateTimeForDb($_GET['GZLaporanJumlahPorsiV']['tgl_akhir']);
                $this->bln_awal = $format->formatMonthForDb($_GET['GZLaporanJumlahPorsiV']['bln_awal']);
                $this->bln_akhir = $format->formatMonthForDb($_GET['GZLaporanJumlahPorsiV']['bln_akhir']);
                $bln_akhir = $this->bln_akhir."-".date("t",strtotime($this->bln_akhir));
                $thn_akhir = $this->thn_akhir."-".date("m-t",strtotime($this->thn_akhir."-12"));
                switch($this->jns_periode){
                    case 'bulan' : $this->tgl_awal = $this->bln_awal."-01"; $this->tgl_akhir = $bln_akhir; break;
                    case 'tahun' : $this->tgl_awal = $this->thn_awal."-01-01"; $this->tgl_akhir = $thn_akhir; break;
                    default : null;
                }
                $tgl_awal = $this->tgl_awal." 00:00:00";
                $tgl_akhir = $this->tgl_akhir." 23:59:59";     
//                $jenisdiet_nama =$_GET['GZLaporanJumlahPorsiV']['jenisdiet_nama'];
                $criteria->addBetweenCondition('tglkirimmenu',$tgl_awal,$tgl_akhir);
                $criteria->compare('LOWER(jenisdiet_nama)',strtolower($this->jenisdiet_nama));
                $criteria->addInCondition('jenisdiet_id',$this->jenisdiet_id);
                if (!empty($this->ruangan_id)){
                    if (is_array($this->ruangan_id)){
                        $criteria->addInCondition(" ruangan_id ",$this->ruangan_id);
                    }else{
                        $criteria->addCondition(" ruangan_id = ".$this->ruangan_id);
                    }
                }
            }
            $criteria->select = $criteria->group.',jenisdiet_nama';
            $modTarif = LaporanjmlporsigiziruanganV::model()->findAll($criteria);
            $totTarif = 0;
            foreach($modTarif as $key=>$tarif){
                $totTarif ++;
            }
             return $totTarif;
     }
    // if(isset($_GET['GZLaporanjmlporsikelasruanganV'])){
    // $tgl_awal = $format->formatDateTimeForDb($_GET['GZLaporanjmlporsikelasruanganV']['tgl_awal']);
    // $tgl_akhir = $format->formatDateTimeForDb($_GET['GZLaporanjmlporsikelasruanganV']['tgl_akhir']);
    // $jenisdiet_nama =$_GET['GZLaporanjmlporsikelasruanganV']['jenisdiet_nama'];
    // $criteria->addBetweenCondition('tglkirimmenu',$tgl_awal,$tgl_akhir);
    // $criteria->compare('LOWER(jenisdiet_nama)',strtolower($this->jenisdiet_nama));
    // }
    // $criteria->select = $criteria->group.', sum(jml_kirim) AS jml_kirim';
    // $modKirim = LaporanjmlporsikelasruanganV::model()->findAll($criteria);
    // $totKirim = 0;

     /**
      * mengenerate data ruangan
      * @param type $ruangan_id
      * @return type
      */
     public function getRuangan($ruangan_id){
         return RuanganM::model()->findByPk($ruangan_id)->ruangan_nama;
     }


    /**
     * load nama model
     * @return system
     */
    public function getNamaModel(){
        return __CLASS__;
    }

}