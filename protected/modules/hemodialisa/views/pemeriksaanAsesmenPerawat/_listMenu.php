<?php
/**
 * digunakan Hide Asesmen Edukasi, Gizi dan Plan of care di Asesmen Pasien MCU
 * digunakan menambah awal keperawatan pada rawat inap
 * RSST-3092
 * RSST-2793
 * @author          Yusuf Putra Anugrah <yusufputra@.com>
 * @author          Yudhit Widy Wicaksono <yudhitwicaksono@.com>
 * @author          Wahyu Wicaksono <wahyuwicaksono.@gmail.com>
 * @version         2.0.0
 * @link            http://172.9.1.15/simpp/docs/
 * @category        RSST-6922
 * 
 */
    $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
    $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
    $instalasi = Yii::app()->user->getState('instalasi_id');
    
    $arr = array(
        'ases-awalbidan' => '<div class="col-sm-3 garis-tepi hover" onclick="callDialog(this)" ases-judul="Asesmen Awal Kebidanan" ases-src="'.Yii::app()->createUrl('/'.$module.'/asesmenAwalKebidananSubyektif'.$this->init_awalbidan.'/index',array('pendaftaran_id'=>$modPendaftaran->pendaftaran_id,'konsulpoli_id'=>isset($_GET['konsulpoli_id'])?$_GET['konsulpoli_id']:null)).'">
                                <br/>
                                '.CHtml::image(Params::urlIconModulERM() . 'icon-kebidanan.PNG').'
                                <label><h6 style="text-align:center;"><b> RM 05 K Obgin - Asesmen Awal Kebidanan </b></h6></label>
                            </div>',
        'ases-nyeri' => '   <div class="col-sm-3 garis-tepi hover" onclick="callDialog(this)" ases-judul="Asesmen Nyeri" ases-src="'.Yii::app()->createUrl('/'.$module.'/asesmenNyeri'.$this->init.'/index',array('pendaftaran_id'=>$modPendaftaran->pendaftaran_id,'konsulpoli_id'=>isset($_GET['konsulpoli_id'])?$_GET['konsulpoli_id']:null)).'">
                                <br/>
                                '.CHtml::image(Params::urlIconModulERM() . 'icon-nyeri.PNG').'
                               <label><h6 style="text-align:center;"><b> RM 05a - Asesmen Nyeri </b></h6></label>
                            </div>',
        'ases-risikojatuh' => '   <div class="col-sm-3 garis-tepi hover" onclick="callDialog(this)" ases-judul="Asesmen Risiko Jatuh" ases-src="'.Yii::app()->createUrl('/'.$module.'/asesmentResikoJatuh'.$this->init_resiko.'/index',array('id'=>$modPendaftaran->pendaftaran_id,'konsulpoli_id'=>isset($_GET['konsulpoli_id'])?$_GET['konsulpoli_id']:null)).'">
                                <br/>
                                '.CHtml::image(Params::urlIconModulERM() . 'icon-jatuh.PNG').'
                                <label><h6 style="text-align:center;"><b>RM 05B - Asesmen Resiko Jatuh</b></h6></label>
                            </div>',
        'ases-edukasi' => '   <div class="col-sm-3 garis-tepi hover" onclick="callDialog(this)" ases-judul="Asesmen Edukasi" ases-src="'.Yii::app()->createUrl('/'.$module.'/asesmenEdukasi'.$this->init.'/index',array('pendaftaran_id'=>$modPendaftaran->pendaftaran_id,'konsulpoli_id'=>isset($_GET['konsulpoli_id'])?$_GET['konsulpoli_id']:null)).'">
                                <br/>
                                '.CHtml::image(Params::urlIconModulERM() . 'icon-pasien.PNG').'
                                <label><h6 style="text-align:center;"><b>RM 06 - Edukasi Pasien</b></h6></label>
                            </div>',
        'ases-perawatan' => '   <div class="col-sm-3 garis-tepi hover" onclick="callDialog(this)" ases-judul="Plan Of Care" ases-src="'.Yii::app()->createUrl('/'.$module.'/asesmenKeperawatan'.$this->init.'/index',array('id'=>$modPendaftaran->pendaftaran_id,'konsulpoli_id'=>isset($_GET['konsulpoli_id'])?$_GET['konsulpoli_id']:null)).'">
                                <br/>
                                '.CHtml::image(Params::urlIconModulERM() . 'icon-care.PNG').'
                                <label><h6 style="text-align:center;"><b> RM 08a - Plan of Care </b></h6></label>
                            </div>',
        'ases-gizi' => '   <div class="col-sm-3 garis-tepi hover" onclick="callDialog(this);" ases-judul="Asesmen Gizi" ases-src="'.Yii::app()->createUrl('/'.$module.'/asesmenAwalGizi'.$this->init.'/index',array('id'=>$modPendaftaran->pendaftaran_id,'konsulpoli_id'=>isset($_GET['konsulpoli_id'])?$_GET['konsulpoli_id']:null)).'">
                                <br/>
                                '.CHtml::image(Params::urlIconModulERM() . 'icon-gizi.PNG').'
                                <label><h6 style="text-align:center;"><b> RM 05d K - Asesmen Gizi </b></h6></label>
                            </div>',
        'ases-erm-neonatologi' => '<div class="col-sm-3 garis-tepi hover" onclick="callDialog(this);" ases-judul="Asesmen Awal Keperawatan Neonatologi" ases-src="'.Yii::app()->createUrl('/'.$module.'/asesmentNeonatologi'.$this->init.'/index',array('id'=>$modPendaftaran->pendaftaran_id,'konsulpoli_id'=>isset($_GET['konsulpoli_id'])?$_GET['konsulpoli_id']:null)).'">
                                <br/>
                                '.CHtml::image(Params::urlIconModulERM() . 'icon-neonatologi.png').'
                                <label><h6 style="text-align:center;"><b> RM 05 K - Asesmen Neonatologi </b></h6></label>
                            </div>',
        'ases-rehabmedis' => '   <div class="col-sm-3 garis-tepi hover" onclick="alert(\'under construction\');" ases-judul="Asesmen Rehab Medis" ases-src="'.Yii::app()->createUrl('/'.$module.'/asesmentResikoJatuh'.$this->init_resiko.'/index',array('id'=>$modPendaftaran->pendaftaran_id,'konsulpoli_id'=>isset($_GET['konsulpoli_id'])?$_GET['konsulpoli_id']:null)).'">
                                <br/>
                                '.CHtml::image(Params::urlIconModulERM() . 'icon-rehab.PNG').'
                                <label><h6 style="text-align:center;"><b>RM 05 K Rehab - Asesmen Awal Rehabilitasi Medik</b></h6></label>
                            </div>',
        'ases-awal-keperawatan-rj' => '   <div class="col-sm-3 garis-tepi hover" onclick="callDialog(this)" ases-judul="Asesmen Awal Keperawatan RJ" ases-src="'.Yii::app()->createUrl('/'.$module.'/asesmenAwalKeperawatanRawatJalan/index',array('id'=>$modPendaftaran->pendaftaran_id,'konsulpoli_id'=>isset($_GET['konsulpoli_id'])?$_GET['konsulpoli_id']:null)).'">
                                <br/>
                                '.CHtml::image(Params::urlIconModulERM() . 'icon-keperawatan.PNG').'
                                <label><h6 style="text-align:center;"><b>RM 05 - Asesmen Awal Keperawatan RJ</b></h6></label>
                            </div>',
        'ases-awal-keperawatan-gigi' => '   <div class="col-sm-3 garis-tepi hover" onclick="callDialog(this)" ases-judul="Asesmen Awal Keperawatan Gigi dan Mulut" ases-src="'.Yii::app()->createUrl('/'.$module.'/asesmenAwalKeperawatanRawatJalan/index',array('id'=>$modPendaftaran->pendaftaran_id,'konsulpoli_id'=>isset($_GET['konsulpoli_id'])?$_GET['konsulpoli_id']:null)).'">
                                <br/>
                                '.CHtml::image(Params::urlIconModulERM() . 'icon-keperawatan.PNG').'
                                <label><h6 style="text-align:center;"><b>RM 05 - Asesmen Awal Keperawatan RJ</b></h6></label>
                            </div>',
        'ases-awal-keperawatan' => '   <div class="col-sm-3 garis-tepi hover" onclick="callDialog(this)" ases-judul="Asesmen Awal Keperawatan" ases-src="'.Yii::app()->createUrl('/'.$module.'/asesmenAwalKeperawatan'.$this->init.'/index',array('id'=>$modPendaftaran->pendaftaran_id,'konsulpoli_id'=>isset($_GET['konsulpoli_id'])?$_GET['konsulpoli_id']:null)).'">
                                <br/>
                                '.CHtml::image(Params::urlIconModulERM() . 'icon-keperawatan.PNG').'
                                <label><h6 style="text-align:center;"><b>RM 05 - Asesmen Awal Keperawatan</b></h6></label>
                            </div>',
        'ases-ambulans' => '   <div class="col-sm-3 garis-tepi hover" onclick="callDialog(this)" ases-judul="Asesmen Pasien Ambulans" ases-src="'.Yii::app()->createUrl('/'.$module.'/assesmenPasienAmbulans/index',array('pemakaianambulans_id'=>isset($_GET['pemakaianambulans_id'])? $_GET['pemakaianambulans_id'] : null,'pendaftaran_id'=>$modPendaftaran->pendaftaran_id,'konsulpoli_id'=>isset($_GET['konsulpoli_id'])?$_GET['konsulpoli_id']:null)).'">
                                <br/>
                                '.CHtml::image(Params::urlIconModulERM() . 'icon-ambulans.png').'
                                <label><h6 style="text-align:center;"><b>Asesmen Pasien Ambulans</b></h6></label>
                            </div>',
        'ases-awal-keperawatan-jiwa' => '<div class="col-sm-3 garis-tepi hover" onclick="callDialog(this)" ases-judul="Asesmen Awal Keperawatan Gangguan Jiwa" ases-src="'.Yii::app()->createUrl('/'.$module.'/asesmenAwalKeperawatanJiwa'.$this->init.'/index',array('id'=>$modPendaftaran->pendaftaran_id,'konsulpoli_id'=>isset($_GET['konsulpoli_id'])?$_GET['konsulpoli_id']:null)).'">
                                <br/>
                                '.CHtml::image(Params::urlIconModulERM() . 'icon-psikiarti.png').'
                                <label><h6 style="text-align:center;"><b>RM 05k Psikiatri Asesmen Psikiatri</b></h6></label>
                            </div>',
        'ases-awal-igd' => '<div class="col-sm-3 garis-tepi hover" onclick="callDialog(this)" ases-judul="Asesmen Awal Keperawatan IGD" ases-src="'.Yii::app()->createUrl('/'.$module.'/asesmenAwalKeperawatanIGD'.$this->init.'/index',array('id'=>$modPendaftaran->pendaftaran_id,'konsulpoli_id'=>isset($_GET['konsulpoli_id'])?$_GET['konsulpoli_id']:null)).'">
                                <br/>
                                '.CHtml::image(Params::urlIconModulERM() . 'icon-keperawatanigd.png').'
                                <label><h6 style="text-align:center;"><b>RM 05c IGD Asesmen Awal Keperawatan</b></h6></label>
                            </div>',
        'observasi-igd' => '<div class="col-sm-3 garis-tepi hover" onclick="callDialog(this)" ases-judul="Observasi Gawat Darurat" ases-src="'.Yii::app()->createUrl('/'.$module.'/observasiGawatDarurat'.$this->init.'/index',array('id'=>$modPendaftaran->pendaftaran_id,'konsulpoli_id'=>isset($_GET['konsulpoli_id'])?$_GET['konsulpoli_id']:null)).'">
                                <br/>
                                '.CHtml::image(Params::urlIconModulERM() . 'icon-observasiigd.png').'
                                <label><h6 style="text-align:center;"><b>RM 05b Observasi Gawat Darurat </b></h6></label>
                            </div>',

        'ases-awalanak' => '<div class="col-sm-2 garis-tepi hover" onclick="callDialog(this)" ases-judul="Asesmen Awal Keperawatan Anak" ases-src="'.Yii::app()->createUrl('/'.$module.'/asesmenAwalKeperawatanAnak'.$this->init.'/index',array('id'=>$modPendaftaran->pendaftaran_id,'konsulpoli_id'=>isset($_GET['konsulpoli_id'])?$_GET['konsulpoli_id']:null)).'">
                                <br/>
                                '.CHtml::image(Params::urlIconModulDirectory().'thumb.png').'
                                <label><h6 style="text-align:center;"><b>Asesmen Awal Keperawatan Anak</b></h6></label>
                            </div>',

        'skrining'      => '<div class="col-sm-3 garis-tepi hover" style="height:177px" onclick="callDialog(this)" ases-judul="Skrining Suspek Infeksi" ases-src="'.Yii::app()->createUrl('/'.$module.'/SkriningSI'.$this->init.'/dialog',array('id'=>$modPendaftaran->pendaftaran_id,'konsulpoli_id'=>isset($_GET['konsulpoli_id'])?$_GET['konsulpoli_id']:null)).'">
                                <br/>
                                './*CHtml::image(Params::urlIconModulERM() . 'icon-observasiigd.png').*/'
                                <label><h6><b>Skrining Suspek Infeksi IRD </b></h6></label>
                            </div>',
        
        
        
        
        
        'monitoring-pasien-hemodialisa' => '   <div class="col-sm-3 garis-tepi hover" onclick="callLink(this)" ases-judul="Asesmen Edukasi Pasien" ases-src="'.Yii::app()->createUrl('/'.$module.'/monitoringPasienHD/index',array('pendaftaran_id'=>$modPendaftaran->pendaftaran_id,'konsulpoli_id'=>isset($_GET['konsulpoli_id'])?$_GET['konsulpoli_id']:null)).'" style="margin-right: 100px;">
                                <br/>
                                '.CHtml::image(Params::urlIconModulERM() . 'icon-monitoring-hemodialisa.png').'
                               <label><h6 style="text-align:center;"><b> RM 01 HD MONITORING PASIEN HEMODIALISA </b></h6></label>
                            </div>',
        
        'rencana-perawatan-dialisis' => '   <div class="col-sm-3 garis-tepi hover" onclick="setUrl(this)" ases-judul="Asesmen Edukasi Pasien" tab="/'.$module.'/rencanaPerawatanDialisis'.$this->init.'/index&pendaftaran_id='.$modPendaftaran->pendaftaran_id.'&konsulpoli_id='.(isset($_GET['konsulpoli_id'])?$_GET['konsulpoli_id']:null).'" style="margin-right: 100px;">
                                <br/>
                                '.CHtml::image(Params::urlIconModulERM() . 'icon-rencanakeperawatan.png').'
                               <label><h6 style="text-align:center;"><b> RM 05c HD RENCANA PERAWATAN DIALISIS </b></h6></label>
                            </div>',
        
        'ases-edukasi-pasien' => '   <div class="col-sm-3 garis-tepi hover" onclick="setUrl(this)" ases-judul="Asesmen Edukasi Pasien" tab="/'.$module.'/AsesmenEdukasi'.$this->init.'/index&pendaftaran_id='.$modPendaftaran->pendaftaran_id.'&pasienmasukpenunjang_id='.(isset($_GET['pasienmasukpenunjang_id'])?$_GET['pasienmasukpenunjang_id']:null).'">
                                <br/>
                                '.CHtml::image(Params::urlIconModulERM() . 'icon-asesmenedukasi.png').'
                               <label><h6 style="text-align:center;"><b> RM 06 ASESMEN EDUKASI PASIEN </b></h6></label>
                            </div>',
        
        'Perkembangan-terintegrasi-pasien' => '   <div class="col-sm-3 garis-tepi hover" onclick="setUrl(this)" ases-judul="Asesmen Edukasi Pasien" tab="/'.$module.'/AsesmenKeperawatan'.$this->init.'/index&id='.$modPendaftaran->pendaftaran_id.'&konsulpoli_id='.(isset($_GET['konsulpoli_id'])?$_GET['konsulpoli_id']:null).'" style="margin-right: 100px;">
                                <br/>
                                '.CHtml::image(Params::urlIconModulERM() . 'icon-perkembanganintegrasi.png').'
                               <label><h6 style="text-align:center;"><b> RM 08 HD PERKEMBANGAN  TERINTEGRASI PASIEN </b></h6></label>
                            </div>',
        
        'observasi-transfusi-darah' => '   <div class="col-sm-3 garis-tepi hover" onclick="setUrl(this)" ases-judul="Asesmen Edukasi Pasien" tab="/'.$module.'/transfusiDarah'.$this->init.'/index&pendaftaran_id='.$modPendaftaran->pendaftaran_id.'&konsulpoli_id='.(isset($_GET['konsulpoli_id'])?$_GET['konsulpoli_id']:null).'" style="margin-right: 100px;">
                                <br/>
                                '.CHtml::image(Params::urlIconModulERM() . 'icon-transfusi-darah.png').'
                               <label><h6 style="text-align:center;"><b> RM 08I K OBSERVASI TRANSFUSI DARAH </b></h6></label>
                            </div>',
         'surat-traveling' => '   <div class="col-sm-3 garis-tepi hover" onclick="setUrl(this)" ases-judul="Traveling Hemodialisa" tab="/'.$module.'/traveling/index&pendaftaran_id='.$modPendaftaran->pendaftaran_id.'&konsulpoli_id='.(isset($_GET['konsulpoli_id'])?$_GET['konsulpoli_id']:null).'" >
                                <br/>
                                <br/>
                                <br/>
                                <br/>
                                <br/>
                                <br/>
                                <br/>
                                <br/>
                               <label><h6 style="text-align:center;"><b> Traveling Hemodialisa </b></h6></label>
                            </div>',
        

    );

    if ($this->init == 'PS'){
        echo "<div class='row-fluid'>";
        echo $arr['ases-awalbidan'];
        echo $arr['ases-nyeri'];
        echo $arr['ases-risikojatuh'];
        echo $arr['ases-edukasi'];
        echo "</div>";
        echo "<div class='row-fluid'>";
        echo $arr['ases-perawatan'];        
        echo $arr['ases-gizi'];
        echo $arr['ases-erm-neonatologi'];
        echo "</div>";
        echo '<div class="clear"></div>';
       
        
    }elseif ($this->init == 'RI'){
        echo "<div class='row-fluid'>";
        echo $arr['ases-nyeri'];
        echo $arr['ases-risikojatuh'];
        echo $arr['ases-edukasi'];
        echo $arr['ases-perawatan'];   
        echo "</div>";
        echo "<div class='row-fluid'>";
        echo $arr['ases-gizi'];
        echo $arr['ases-erm-neonatologi'];
        echo "</div>";
    
        echo '<div class="clear"></div>';        
    }elseif ($this->init == 'RJ'){
        echo "<div class='row-fluid'>";
        if ($instalasi == Params::INSTALASI_ID_GIGI_MULUT) {
            echo $arr['ases-awal-keperawatan-gigi'];
            } else {
            echo $arr['ases-awal-keperawatan-rj'];
        }
        //echo $arr['ases-awal-keperawatan'];
        echo $arr['ases-edukasi'];    
        echo $arr['ases-perawatan']; 
        echo $arr['ases-nyeri'];
        echo "</div>";
        echo "<div class='row-fluid'>";   
        echo $arr['ases-risikojatuh'];
        echo $arr['ases-gizi'];
        echo $arr['ases-erm-neonatologi'];
        echo "</div>";
        echo '<div class="clear"></div>';        
    }elseif($this->init == 'RD'){
        echo "<div class='row-fluid'>";
        echo $arr['ases-nyeri'];
        echo $arr['ases-risikojatuh'];
        echo $arr['ases-edukasi'];        
        echo $arr['ases-perawatan']; 
//        echo $arr['ases-awal-keperawatan'];
        echo "</div>";
        echo "<div class='row-fluid'>";
        echo $arr['ases-awal-igd']; 
        echo $arr['observasi-igd']; 
        echo $arr['skrining'];
        echo "</div>";
        echo '<div class="clear"></div>';
    }elseif($this->init == 'AM'){
        echo "<div class='row-fluid'>";
        echo $arr['ases-ambulans'];        
        echo $arr['ases-edukasi'];
        echo "</div>";        
        echo '<div class="clear"></div>';
    }else if($this->init == 'MC'){
        echo "<div class='row-fluid'>";
        echo $arr['ases-nyeri'];
        echo $arr['ases-risikojatuh'];
        echo "</div>";    
        //echo $arr['ases-edukasi'];        
        //echo $arr['ases-gizi'];
       //echo $arr['ases-perawatan']; 
        echo '<div class="clear"></div>';
    }elseif($this->init == 'HD'){
        echo "<div class='row-fluid justify-content-center'>";
        echo $arr['monitoring-pasien-hemodialisa'];
        echo $arr['rencana-perawatan-dialisis'];
        echo $arr['ases-edukasi-pasien'];
        echo "</div>"; 
        echo "<div class='row-fluid'>";  
        echo $arr['Perkembangan-terintegrasi-pasien'];
        echo $arr['observasi-transfusi-darah'];
        echo $arr['surat-traveling'];
        echo "</div>"; 
        echo '<div class="clear"></div>';
    }else{
        echo "<div class='row-fluid'>";
        echo $arr['ases-awalanak'];
        echo $arr['ases-awal-keperawatan'];
        echo $arr['ases-nyeri'];
        echo $arr['ases-risikojatuh'];
        echo "</div>"; 
        echo "<div class='row-fluid'>";   
        echo $arr['ases-edukasi'];     
        echo $arr['ases-gizi'];
        echo $arr['ases-perawatan'];
        echo $arr['ases-awal-keperawatan-jiwa'];
        echo "</div>"; 
        echo '<div class="clear"></div>';
    }
?>