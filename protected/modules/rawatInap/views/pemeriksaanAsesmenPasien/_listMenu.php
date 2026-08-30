<?php
/**
 * digunakan Hide Asesmen Edukasi, Gizi dan Plan of care di Asesmen Pasien MCU
 * digunakan menambah awal keperawatan pada rawat inap
 * RSST-3092
 * RSST-2793
 * @author          Yusuf Putra Anugrah <yusufputra@.com>
 * @version         2.0.0
 * @link            http://172.9.1.15/simpp/docs/
 * 
 */
    $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
    $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai

    $arr = array(
        'ases-awalbidan' => '<div class="col-sm-2 garis-tepi hover" onclick="callDialog(this)" ases-judul="Asesmen Awal Kebidanan" ases-src="'.Yii::app()->createUrl('/'.$module.'/asesmenAwalKebidananSubyektif'.$this->init_awalbidan.'/index',array('pendaftaran_id'=>$modPendaftaran->pendaftaran_id)).'">
                                <br>
                                '.CHtml::image(Params::urlIconERMDirectory().'icon-kebidanan.PNG').'
                                <label><h6 style="text-align:center;"><b>Asesmen Awal Kebidanan</b></h6></label>
                            </div>',
        'ases-nyeri' => '   <div class="col-sm-2 garis-tepi hover" onclick="callDialog(this)" ases-judul="Asesmen Nyeri" ases-src="'.Yii::app()->createUrl('/'.$module.'/asesmenNyeri'.$this->init.'/index',array('pendaftaran_id'=>$modPendaftaran->pendaftaran_id)).'">
                                <br>
                                '.CHtml::image(Params::urlIconERMDirectory().'icon-nyeri.PNG').'
                                <label><h6 style="text-align:center;"><b>Asesmen Nyeri</b></h6></label>
                            </div>',
        'ases-risikojatuh' => '   <div class="col-sm-2 garis-tepi hover" onclick="callDialog(this)" ases-judul="Asesmen Risiko Jatuh" ases-src="'.Yii::app()->createUrl('/'.$module.'/asesmentResikoJatuh'.$this->init_resiko.'/index',array('id'=>$modPendaftaran->pendaftaran_id)).'">
                                <br>
                                '.CHtml::image(Params::urlIconERMDirectory().'icon-jatuh.PNG').'
                                <label><h6 style="text-align:center;"><b>Asesmen Risiko Jatuh</b></h6></label>
                            </div>',
        'ases-edukasi' => '   <div class="col-sm-2 garis-tepi hover" onclick="callDialog(this)" ases-judul="Asesmen Edukasi" ases-src="'.Yii::app()->createUrl('/'.$module.'/asesmenEdukasi'.$this->init.'/index',array('pendaftaran_id'=>$modPendaftaran->pendaftaran_id)).'">
                                <br>
                                '.CHtml::image(Params::urlIconERMDirectory().'icon-pasien.PNG').'
                                <label><h6 style="text-align:center;"><b>Asesmen Edukasi</b></h6></label>
                            </div>',
        'ases-perawatan' => '   <div class="col-sm-2 garis-tepi hover" onclick="callDialog(this)" ases-judul="Plan Of Care" ases-src="'.Yii::app()->createUrl('/'.$module.'/asesmenKeperawatan'.$this->init.'/index',array('id'=>$modPendaftaran->pendaftaran_id)).'">
                                <br>
                                '.CHtml::image(Params::urlIconERMDirectory().'icon-care.PNG').'
                                <label><h6 style="text-align:center;"><b>Plan Of Care</b></h6></label>
                            </div>',
        'ases-gizi' => '   <div class="col-sm-2 garis-tepi hover" onclick="callDialog(this);" ases-judul="Asesmen Gizi" ases-src="'.Yii::app()->createUrl('/'.$module.'/asesmenAwalGizi'.$this->init.'/index',array('id'=>$modPendaftaran->pendaftaran_id)).'">
                                <br>
                                '.CHtml::image(Params::urlIconERMDirectory().'icon-gizi.PNG').'
                                <label><h6 style="text-align:center;"><b>Asesmen Gizi</b></h6></label>
                            </div>',
        'ases-rehabmedis' => '   <div class="col-sm-2 garis-tepi hover" onclick="alert(\'under construction\');" ases-judul="Asesmen Rehab Medis" ases-src="'.Yii::app()->createUrl('/'.$module.'/asesmentResikoJatuh'.$this->init_resiko.'/index',array('id'=>$modPendaftaran->pendaftaran_id)).'">
                                <br>
                                '.CHtml::image(Params::urlIconERMDirectory().'icon-rehab.PNG').'
                                <label><h6 style="text-align:center;"><b>Asesmen Rehab Medis</b></h6></label>
                            </div>',
        'ases-awal-keperawatan' => '   <div class="col-sm-2 garis-tepi hover" onclick="callDialog(this)" ases-judul="Asesmen Awal Keperawatan" ases-src="'.Yii::app()->createUrl('/'.$module.'/asesmenAwalKeperawatan'.$this->init.'/index',array('id'=>$modPendaftaran->pendaftaran_id)).'">
                                <br>
                                '.CHtml::image(Params::urlIconERMDirectory().'icon-keperawatan.PNG').'
                                <label><h6 style="text-align:center;"><b>Asesmen Awal Keperawatan</b></h6></label>
                            </div>',
        'ases-ambulans' => '   <div class="col-sm-2 garis-tepi hover" onclick="callDialog(this)" ases-judul="Asesmen Pasien Ambulans" ases-src="'.Yii::app()->createUrl('/'.$module.'/assesmenPasienAmbulans/index',array('pemakaianambulans_id'=>isset($_GET['pemakaianambulans_id'])? $_GET['pemakaianambulans_id'] : null,'pendaftaran_id'=>$modPendaftaran->pendaftaran_id,)).'">
                                <br>
                                '.CHtml::image(Params::urlIconERMDirectory().'icon-ambulans.png').'
                                <label><h6 style="text-align:center;"><b>Asesmen Pasien Ambulans</b></h6></label>
                            </div>',
        'ases-awal-keperawatan-jiwa' => '<div class="col-sm-2 garis-tepi hover" onclick="callDialog(this)" ases-judul="Asesmen Awal Keperawatan Gangguan Jiwa" ases-src="'.Yii::app()->createUrl('/'.$module.'/asesmenAwalKeperawatanJiwa'.$this->init.'/index',array('id'=>$modPendaftaran->pendaftaran_id)).'">
                                <br>
                                '.CHtml::image(Params::urlIconERMDirectory().'icon-psikiarti.png').'
                                <label><h6 style="text-align:center;"><b>Asesmen Psikiatri</b></h6></label>
                            </div>',
        

    );

    if ($this->init == 'PS'){
        echo $arr['ases-awalbidan'];
        echo $arr['ases-nyeri'];
        echo $arr['ases-risikojatuh'];
        echo $arr['ases-edukasi'];
        echo $arr['ases-perawatan'];        
        echo $arr['ases-gizi'];
        echo '<div class="clear"></div>';
       
        
    }elseif ($this->init == 'RI'){
        echo $arr['ases-nyeri'];
        echo $arr['ases-risikojatuh'];
        echo $arr['ases-edukasi'];
        echo $arr['ases-perawatan'];        
        echo $arr['ases-gizi'];
    
        echo '<div class="clear"></div>';        
    }elseif ($this->init == 'RJ'){
        //echo $arr['ases-awal-keperawatan'];
        //echo $arr['ases-edukasi'];    
        //echo $arr['ases-perawatan'];    
        //echo $arr['ases-gizi'];
        echo $arr['ases-nyeri'];
        echo $arr['ases-risikojatuh'];
     
        echo '<div class="clear"></div>';        
    }elseif($this->init == 'RD'){
        echo $arr['ases-nyeri'];
        echo $arr['ases-risikojatuh'];
        echo $arr['ases-edukasi'];        
        echo $arr['ases-awal-keperawatan'];
         echo $arr['ases-perawatan']; 
        echo '<div class="clear"></div>';
    }elseif($this->init == 'AM'){
        echo $arr['ases-ambulans'];        
        echo $arr['ases-edukasi'];        
        echo '<div class="clear"></div>';
    }else if($this->init == 'MC'){
        echo $arr['ases-nyeri'];
        echo $arr['ases-risikojatuh'];
        //echo $arr['ases-edukasi'];        
        //echo $arr['ases-gizi'];
       //echo $arr['ases-perawatan']; 
        echo '<div class="clear"></div>';
    }else{
        echo $arr['ases-nyeri'];
        echo $arr['ases-risikojatuh'];
        echo $arr['ases-edukasi'];        
        echo $arr['ases-gizi'];
       echo $arr['ases-perawatan'];
       echo $arr['ases-awal-keperawatan'];
       echo $arr['ases-awal-keperawatan-jiwa'];
        echo '<div class="clear"></div>';
    }
