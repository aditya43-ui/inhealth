<?php
/**
* @author      M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>, Rusdiyanto
* @author      Elham Budianto <elhambudianto@.com>
* @author      Aida Rahmawati <aidarahmawati@.com>
* @version     2.0.0
* @package application.modules.bankDarah
* @subpackage models 
* @category model
* RSST-1498
*/
class BDDaftardonasiT extends DaftardonasiT
{
    
    public $jns_periode, $bln_awal, $bln_akhir, $thn_awal, $thn_akhir,$tgl_awal, $tgl_akhir, $no_identitas, $nama_lengkap, $tempat_lahir, $alamat_lengkap,
           $gol_darah, $rhesus, $status_pendonor, $jeniskelamin, $jenis_kelamin, $dpjp_nama, $tampilGrafik;
	
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return DaftardonasiT the static model class
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
    
    /**
     * fungsi untuk informasi
     * @return \CActiveDataProvider
     */
    public function searchInformasi(){          	
        $criteria=new CDbCriteria;
        $criteria->join = ' LEFT JOIN pendonor_m ON pendonor_m.pendonor_id = t.pendonor_id ';
        $criteria->addBetweenCondition('DATE(t.waktu_pendaftaran)', $this->tgl_awal, $this->tgl_akhir);
        $criteria->compare('LOWER(pendonor_m.no_identitas)',strtolower($this->no_identitas),true);
        $criteria->compare('LOWER(pendonor_m.no_pendonor)',strtolower($this->no_pendonor),true);
        $criteria->compare('LOWER(t.no_formulir)',strtolower($this->no_formulir),true);
        $criteria->compare('LOWER(pendonor_m.nama_lengkap)',strtolower($this->nama_lengkap),true);
        $criteria->compare('LOWER(pendonor_m.gol_darah)',strtolower($this->gol_darah),true);
        $criteria->compare('LOWER(pendonor_m.rhesus)',strtolower($this->rhesus),true);
        $criteria->compare('LOWER(t.status)',strtolower($this->status),true);
        $criteria->compare('LOWER(pendonor_m.jenis_kelamin)',strtolower($this->jeniskelamin),true);
        $criteria->addCondition('t.bataldonordarah IS NOT TRUE');
        $criteria->addCondition('t.ruangan_id = '.Yii::app()->user->getState('ruangan_id'));
        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }
    
    /**
     * Untuk menampilkan tombol Seleksi Donor
     * @param type $pendonor_id
     * @param type $daftardonasi_id
     */
    public function getSeleksi($pendonor_id,$daftardonasi_id )
    {
        $cekSeleksi = SeleksipendonorT::model()->findByAttributes(array('pendonor_id'=>$pendonor_id,'daftardonasi_id'=>$daftardonasi_id ));
        $cekKantong = KantongdarahT::model()->findByAttributes(array('pendonor_id'=>$pendonor_id,'daftarpendonor_id'=>$daftardonasi_id));

        $seleksi = '';                                   
        if(!empty($cekSeleksi)){
            if($cekSeleksi->status_pendonor == 'DITERIMA'){
                    if(!empty($cekSeleksi->detaknadi)){
                        $seleksi .= CHtml::link('<button class="btn btn-green btn-xs"> <span class="fa fa-check-square-o"></span> DITERIMA </button>', Yii::app()->controller->createUrl('seleksiDonorDarahT/index', array('pendonor_id'=>$pendonor_id, 'daftardonasi_id'=>$daftardonasi_id)), array(
                            'data-toggle'=>'tooltip',
                            'title'=>'Klik untuk Melakukan Seleksi Donor',
                        ));
                    }else{
                        $seleksi .= CHtml::link('<button class="btn btn-gold btn-xs"> <span class="fa fa-check-square-o"></span> SELEKSI </button>', Yii::app()->controller->createUrl('seleksiDonorDarahT/index', array('pendonor_id'=>$pendonor_id, 'daftardonasi_id'=>$daftardonasi_id)), array(
                            'data-toggle'=>'tooltip',
                            'title'=>'Klik untuk Melakukan Seleksi Donor',
                        ));
                    }
                } elseif($cekSeleksi->status_pendonor == 'DITOLAK'){
                    $seleksi .= CHtml::link('<button class="btn btn-red btn-xs"> <span class="fa fa-check-square-o"></span> DITOLAK </button>', Yii::app()->controller->createUrl('seleksiDonorDarahT/index', array('pendonor_id'=>$pendonor_id, 'daftardonasi_id'=>$daftardonasi_id)), array(
                            'data-toggle'=>'tooltip',
                            'title'=>'Klik untuk Melakukan Seleksi Donor',
                        ));
                }
        }else{
            $seleksi .= CHtml::link('<button class="btn btn-gold btn-xs"> <span class="fa fa-check-square-o"></span> SELEKSI </button>', Yii::app()->controller->createUrl('seleksiDonorDarahT/index', array('pendonor_id'=>$pendonor_id, 'daftardonasi_id'=>$daftardonasi_id)), array(
                        'data-toggle'=>'tooltip',
                        'title'=>'Klik untuk Melakukan Seleksi Donor',
            ));
        }
        
        echo $seleksi;
    }
    
    /**
     * Untuk menampilkan tombol Observasi Donor Darah
     * @param type $pendonor_id
     * @param type $daftardonasi_id
     */
    public function getObservasi($pendonor_id,$daftardonasi_id )
    {
        $cekDonasi = DaftardonasiT::model()->findByPk($daftardonasi_id); 
        $cekSeleksi = SeleksipendonorT::model()->findByAttributes(array('pendonor_id'=>$pendonor_id, 'daftardonasi_id'=>$daftardonasi_id));
        $cekObservasi = ObservasipendonorT::model()->findByAttributes(array('pendonor_id'=>$pendonor_id, 'daftardonasi_id'=>$daftardonasi_id));
        $cekKantong = KantongdarahT::model()->findByAttributes(array('pendonor_id'=>$pendonor_id,'daftarpendonor_id'=>$daftardonasi_id));
        $observasi = '';
        
        if(!empty($cekSeleksi)){
            if($cekSeleksi->status_pendonor == 'DITOLAK'){
                $observasi .= "<i style='color:#ff000080' class=\"entypo-droplet\"></i>";
                
            }elseif($cekSeleksi->status_pendonor == 'DITERIMA' && $cekDonasi->status == 'SELEKSI'){
                if(!empty($cekSeleksi->detaknadi)){
                        $observasi .= CHtml::Link("<i style='color:red' class=\"entypo-droplet\"></i>",Yii::app()->controller->createUrl("ObservasiDonorDarah/index",array("daftardonasi_id"=>$daftardonasi_id)),
                            array("class"=>"", 
                                    "rel"=>"tooltip",
                                    "title"=>"Klik untuk melakukan Observasi Donor Darah", 
                            )); 
                        
                }else{
                    $observasi .= "<i style='color:#ff000080' class=\"entypo-droplet\"></i>";
                }
            }elseif($cekSeleksi->status_pendonor == 'DITERIMA' && $cekDonasi->status == 'OBSERVASI'){
                if (!empty($cekObservasi)){
                    if($cekObservasi->is_batalpenyadapan == true){
                        $observasi .= CHtml::Link("<i style='color:red' class=\"entypo-droplet\"></i><br/>GAGAL SADAP",Yii::app()->controller->createUrl("ObservasiDonorDarah/index",array("daftardonasi_id"=>$daftardonasi_id)),
                                array("class"=>"", 
                                        "rel"=>"tooltip",
                                        "title"=>"Klik untuk melakukan Observasi Donor Darah", 
                                )); 
                    }else{
                        $observasi .= CHtml::Link("<i style='color:red' class=\"entypo-droplet\"></i><br/>BERHASIL SADAP",Yii::app()->controller->createUrl("ObservasiDonorDarah/index",array("daftardonasi_id"=>$daftardonasi_id)),
                                array("class"=>"", 
                                        "rel"=>"tooltip",
                                        "title"=>"Klik untuk melakukan Observasi Donor Darah", 
                                )); 
                    }
                }else{
                     $observasi .= CHtml::Link("<i style='color:red' class=\"entypo-droplet\"></i>",Yii::app()->controller->createUrl("ObservasiDonorDarah/index",array("daftardonasi_id"=>$daftardonasi_id)),
                                array("class"=>"", 
                                        "rel"=>"tooltip",
                                        "title"=>"Klik untuk melakukan Observasi Donor Darah", 
                                )); 
                }
                
            }elseif($cekSeleksi->status_pendonor == 'DITERIMA' && $cekDonasi->status == 'SELESAI'){
                if(empty($cekObservasi)){
                    $observasi .= CHtml::Link("<i style='color:red' class=\"entypo-droplet\"></i>",Yii::app()->controller->createUrl("ObservasiDonorDarah/index",array("daftardonasi_id"=>$daftardonasi_id)),
                                array("class"=>"", 
                                        "rel"=>"tooltip",
                                        "title"=>"Klik untuk melakukan Observasi Donor Darah", 
                                ));
                }else{
                    $observasi .= CHtml::Link("<i style='color:red' class=\"entypo-droplet\"></i> <br>BERHASIL SADAP",Yii::app()->controller->createUrl("ObservasiDonorDarah/detailobservasi",array("daftardonasi_id"=>$daftardonasi_id, 'observasipendonor_id'=>$cekObservasi->observasipendonor_id,"frame"=>1,"popup"=>"true")),
                            array("class"=>"", 
                                    "target"=>"iframeObservasi",
                                    "onclick"=>"$(\"#dialogObservasi\").dialog(\"open\");",
                                    "rel"=>"tooltip",
                                    "title"=>"Klik untuk Melihat Detail Observasi", 
                            ));
                }
            }
        }elseif(empty($cekSeleksi)){
            $observasi .= "<i style='color:#ff000080' class=\"entypo-droplet\"></i>";
        }
        
        echo $observasi;
    }
    
    /**
     * Untuk menampilkan tombol Detail Kantong
     * @param type $pendonor_id
     * @param type $daftardonasi_id
     */
    public function getKantong($pendonor_id,$daftardonasi_id )
    {
        $cekDonasi = DaftardonasiT::model()->findByPk($daftardonasi_id);
        $cekSeleksi = SeleksipendonorT::model()->findByAttributes(array('pendonor_id'=>$pendonor_id, 'daftardonasi_id'=>$daftardonasi_id));
        $kantong ='';  
        
        if(!empty($cekSeleksi)){
            if($cekSeleksi->status_pendonor == 'DITOLAK'){
                $kantong .= "<i style='color:#green' class=\"entypo-box disabled\" ></i>";
            } else {
            $kantong .= CHtml::Link("<i style='color:#795548' class=\"entypo-box\"></i>",Yii::app()->controller->createUrl("informasiDaftarPendonor/setKantong",array('pendonor_id'=>$pendonor_id, 'daftardonasi_id' => $daftardonasi_id, "frame"=>2,"popup"=>"true")),
                                        array("class"=>"", 
                                                "target"=>"iframeKantong",
                                                "onclick"=>"$(\"#dialogKantong\").dialog(\"open\");",
                                                "rel"=>"tooltip",
                                                "title"=>"Klik untuk Melihat Detail Kantong Darah", 
                ));
            }
        } else{
            $kantong .= "<i class=\"entypo-box\"></i>";
        }
        
        echo $kantong;
    }
    
    /**
     * Pencarian informasi batal donor darah
     * @return \CActiveDataProvider
     */
    public function searchInformasiBatalDonor(){
        $criteria=new CDbCriteria;
        $criteria->join = ' LEFT JOIN pendonor_m ON pendonor_m.pendonor_id = t.pendonor_id ';
        $criteria->addBetweenCondition('DATE(pendonor_m.create_time)', $this->tgl_awal, $this->tgl_akhir);
        $criteria->select = 't.*, pendonor_m.*';
        $criteria->compare('LOWER(pendonor_m.no_pendonor)',strtolower($this->no_pendonor),true);
        $criteria->compare('LOWER(pendonor_m.nama_lengkap)',strtolower($this->nama_lengkap),true);
        $criteria->compare('LOWER(pendonor_m.gol_darah)',strtolower($this->gol_darah),true);
        $criteria->compare('LOWER(pendonor_m.rhesus)',strtolower($this->rhesus),true);
        $criteria->compare('LOWER(pendonor_m.jenis_kelamin)',strtolower($this->jenis_kelamin),true);
        $criteria->compare('LOWER(t.no_formulir)',strtolower($this->no_formulir),true);
        $criteria->compare('LOWER(t.status)',strtolower($this->status),true);
        $criteria->addCondition('t.bataldonordarah IS TRUE');
        $criteria->order = 'pendonor_m.create_time ASC';
        $criteria->addCondition('t.ruangan_rekruitmen_id = '.Yii::app()->user->getState('ruangan_id'));
        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }
    
    /**
     * Filter Tabel Kunjungan
     * @return \CActiveDataProvider
     */
    public function searchTableKunjungan() {
        $criteria = new CDbCriteria;
        $criteria->addBetweenCondition('DATE(waktu_pendaftaran)', $this->tgl_awal, $this->tgl_akhir);
        if(!empty($this->ruangan_rekruitmen_id)){
            $criteria->addInCondition('ruangan_rekruitmen_id',$this->ruangan_rekruitmen_id);
        }
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }
    
    /** 
     * Fungsi untuk generate filter / criteria pada frame grafik
     * $model adalah model yang akan digunakan untuk grafik
     * $type adalah filter akan digunakan sebagai x-axis('data') atau group('tick'), default type sebagai x-axis('data')
     * $addCols variable untuk column tmbahan, typenya mix, diantaranya untuk order dll,
     * 
     * @param type $model
     * @param type $type
     * @param type $addCols
     * @return \CDbCriteria
     */
    public static function criteriaGrafik($model, $type='data', $addCols = array()){
        $criteria = new CDbCriteria;
        
        if ($_GET['BDDaftardonasiT']['tampilGrafik'] == 'ruangan'){
            $criteria->join = 'JOIN ruangan_m ON ruangan_m.ruangan_id = t.ruangan_rekruitmen_id';
            $criteria->select = 'count(daftardonasi_id) as jumlah, ruangan_m.ruangan_nama as '.$type;
            $criteria->group .= 'ruangan_m.ruangan_nama';
        }else if ($_GET['BDDaftardonasiT']['tampilGrafik'] == 'donorke'){
            $criteria->select = "count(daftardonasi_id) as jumlah,"
                                . "(case when pendonorlama_v.count IS NOT null then '>1' else '1x' end) as data";
            $criteria->join = "LEFT JOIN pendonorlama_v ON t.pendonor_id = pendonorlama_v.pendonor_id 
                               LEFT JOIN pendonorbaru_v ON t.pendonor_id = pendonorbaru_v.pendonor_id";
            $criteria->group .= "pendonorlama_v.count";
        }else if ($_GET['BDDaftardonasiT']['tampilGrafik'] == 'jeniskelamin'){
            $criteria->join = 'JOIN pendonor_m ON pendonor_m.pendonor_id = t.pendonor_id';
            $criteria->select = 'count(daftardonasi_id) as jumlah, pendonor_m.jenis_kelamin as '.$type;
            $criteria->group .= 'pendonor_m.jenis_kelamin';
        }else if ($_GET['BDDaftardonasiT']['tampilGrafik'] == 'jenisdonor'){
            $criteria->join = 'LEFT JOIN seleksipendonor_t ON seleksipendonor_t.daftardonasi_id = t.daftardonasi_id';
            $criteria->select = 'count(t.daftardonasi_id) as jumlah, seleksipendonor_t.jenisdonor as '.$type;
            $criteria->group .= 'seleksipendonor_t.jenisdonor';
        }

        if (count($addCols) > 0){
            if (is_array($addCols)){
                foreach ($addCols as $i => $v){
                    $criteria->group .= ','.$v;
                    $criteria->select .= ','.$v.' as '.$i;
                }
            }            
        }

        return $criteria;
    }

    /**
     * Filtering frame grafik laporan kunjungan
     * @return \CActiveDataProvider
     */
    public function searchGrafikKunjungan() {

        $criteria = $this->criteriaGrafik($this);
        $format = new MyFormatter();
        
        $this->tgl_awal = $format->formatDateTimeForDb($this->tgl_awal);
        $this->tgl_akhir = $format->formatDateTimeForDb($this->tgl_akhir);
        $criteria->addBetweenCondition('DATE(waktu_pendaftaran)', $this->tgl_awal, $this->tgl_akhir);
        if(!empty($this->ruangan_rekruitmen_id)){
            $criteria->addInCondition('ruangan_rekruitmen_id',$this->ruangan_rekruitmen_id);
        }
        $criteria->order = "jumlah DESC";
        
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }
}