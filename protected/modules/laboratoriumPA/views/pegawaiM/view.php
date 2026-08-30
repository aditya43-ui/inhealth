<style>
    .fieldtd
    {
        font-size:12px;
    }
    
    .a{
        background: #ffffff;
        width: 100%;
        margin-top: 5px;
        margin-bottom: 10px;
        font-size: 11px;
        box-shadow: 0px 0px 3px #AAA7A7;
        -webkit-border-radius: 5px;
        -moz-border-radius: 5px;
        border-radius: 5px;
    }
</style>
<?php
    $format = new MyFormatter;
?>
<div class="white-container">
    <legend class="rim2">Profil <b>User</b></legend>
        <?php
    $this->widget('bootstrap.widgets.BootAlert'); ?>
                                                       
<div class="row-fluid">    
<fieldset class = "box" style = "border:none;">                   
    <div class="span12">
        <div class="span11">                               
            <table class = "a table-condensed" style = "background:none;box-shadow:none;"> 
                    <tr valign = "middle">
                        <td rowspan = "5" width="20%" >
                            <p><br></p>
                             <?php 
                            $url_photopegawai = (!empty($model->photopegawai) ? Params::urlPegawaiTumbsDirectory()."kecil_".$model->photopegawai : Params::urlPegawaiDirectory()."no_photo.jpeg");
                        ?>
                          <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 200px; line-height: 20px;"><img style = "width:200px;height:200px;" src="<?php echo $url_photopegawai; ?>" /></div>
                        </td>
                    </tr>
                    <tr>
                        <td colspan = "4"> 
                            <fieldset class = "box" style = "border:none;">
                                <legend class = "rim">Data pribadi</legend>
                                 <table class = "a table-condensed" style = "background:none;box-shadow:none;"> 
                                    <tr>
                                        <td> 
                                            <?php echo CHtml::label('<b>'.$model->getAttributeLabel('unit_perusahaan').'</b>',$model->getAttributeLabel('unit_perusahaan'), array('class'=>'fieldtd'));?>
                                        </td>
                                        <td>
                                            <?php echo $model->unit_perusahaan;?>
                                        </td>  
                                        <td> 
                                                <?php echo CHtml::label('<b>'.$model->getAttributeLabel('jeniskelamin').'</b>','', array('class'=>'fieldtd'));?>
                                        </td>
                                        <td>
                                            <?php echo $model->jeniskelamin;?>
                                        </td> 
                                    </tr>                                                                           
                                    <tr>
                                        <td> 
                                            <?php echo CHtml::label('<b>'.$model->getAttributeLabel('nomorindukpegawai').'</b>',$model->getAttributeLabel('nomorindukpegawai'), array('class'=>'fieldtd'));?>
                                        </td>
                                        <td>
                                            <?php echo $model->nomorindukpegawai;?>
                                        </td>   
                                         <td> 
                                            <?php echo CHtml::label('<b>Golongan Darah / Rhesus</b>','', array('class'=>'fieldtd'));?>
                                        </td>
                                        <td>
                                            <?php echo $model->golongandarah.' / '.$model->rhesus;?>
                                        </td> 
                                    </tr>                                     
                                    <tr>
                                        <td > 
                                            <?php echo CHtml::label('<b>No. Identitas</b>',$model->getAttributeLabel('jenisidentitas'), array('class'=>'fieldtd'));?>
                                        </td>
                                        <td>
                                            <?php echo $model->jenisidentitas.' - '.$model->noidentitas;?>
                                        </td>   
                                        <td> 
                                               <?php echo CHtml::label('<b>'.$model->getAttributeLabel('agama').'</b>','', array('class'=>'fieldtd'));?>
                                        </td>
                                        <td>
                                            <?php echo $model->agama;?>
                                        </td>  
                                    </tr>
                                    <tr>
                                        <td> 
                                            <?php echo CHtml::label('<b>'.$model->getAttributeLabel('nama_pegawai').'</b>',$model->getAttributeLabel('nama_rumahsakit'), array('class'=>'fieldtd'));?>
                                        </td>
                                        <td>
                                            <?php echo CHtml::label($model->gelardepan.' '.$model->nama_pegawai.' '.(isset($model->gelarbelakang_id)?$model->gelarbelakang->gelarbelakang_nama:""),$model->gelardepan.' '.$model->nama_pegawai.' '.(isset($model->gelarbelakang_id)?$model->gelarbelakang->gelarbelakang_nama:""));?>
                                        </td>  
                                         <td> 
                                            <?php echo CHtml::label('<b>'.$model->getAttributeLabel('suku_id').'</b>','', array('class'=>'fieldtd'));?>
                                        </td>
                                        <td>
                                            <?php echo $model->getSukuNama();?>
                                        </td>   
                                    </tr>   
                                    <tr>
                                        <td> 
                                            <?php echo CHtml::label('<b>'.$model->getAttributeLabel('nama_keluarga').'</b>','', array('class'=>'fieldtd'));?>
                                        </td>
                                        <td>
                                            <?php echo $model->nama_keluarga;?>
                                        </td>
                                        <td> 
                                            <?php echo CHtml::label('<b>'.$model->getAttributeLabel('warganegara_pegawai').'</b>','', array('class'=>'fieldtd'));?>
                                        </td>
                                        <td >
                                            <?php echo $model->warganegara_pegawai;?>
                                        </td>   
                                    </tr>  
                                    <tr>
                                        <td> 
                                            <?php echo CHtml::label('<b>'.$model->getAttributeLabel('tempatlahir_pegawai').'</b>','', array('class'=>'fieldtd'));?>
                                        </td>
                                        <td>
                                            <?php echo $model->tempatlahir_pegawai;?>
                                        </td>  
                                        <td > 
                                            <?php echo CHtml::label('<b>'.$model->getAttributeLabel('statusperkawinan').'</b>','', array('class'=>'fieldtd'));?>
                                        </td>
                                        <td>
                                            <?php echo $model->statusperkawinan;?>
                                        </td>   
                                    </tr> 
                                    <tr>
                                        <td> 
                                            <?php echo CHtml::label('<b>'.$model->getAttributeLabel('tgl_lahirpegawai').'</b>','', array('class'=>'fieldtd'));?>
                                        </td>
                                        <td >
                                            <?php echo $format->formatDateTimeForUser($model->tgl_lahirpegawai);?>
                                        </td>                                                                         
                                    </tr> 
                                </table>
                            </fieldset>
                        </td>                        
                    </tr> 
                   
            </table>           
        </div>   
    </div>
    <div class="span9">  
            <div class="span5" style = "width:50%">
            <fieldset class = "box" style = "border:none;background:none;">
                    <legend class = "rim">Alamat / Kontak</legend>
                    <table class = "a table-condensed" style = "background:none;box-shadow:none;"> 
                            <tr>
                                <td width="20%"> 
                                    <?php echo CHtml::label('<b>'.$model->getAttributeLabel('alamat_pegawai').'</b>',$model->getAttributeLabel('unit_perusahaan'));?>
                                </td>
                                <td width="30%">
                                    <?php echo $model->alamat_pegawai;?>
                                </td>   
                            </tr>                                                                           
                            <tr>
                                    <td width="20%"> 
                                        <?php echo CHtml::label('<b>'.$model->getAttributeLabel('propinsi_id').'</b>',$model->getAttributeLabel('nomorindukpegawai'));?>
                                    </td>
                                    <td width="30%">
                                        <?php echo isset($model->propinsi_id)?$model->propinsi->propinsi_nama:"";?>
                                    </td>   
                            </tr> 
                             <tr>
                                    <td width="20%"> 
                                        <?php echo CHtml::label('<b>'.$model->getAttributeLabel('kabupaten_id').'</b>',$model->getAttributeLabel('nomorindukpegawai'));?>
                                    </td>
                                    <td width="30%">
                                        <?php echo isset($model->kabupaten_id)?$model->kabupaten->kabupaten_nama:"";?>
                                    </td>   
                            </tr> 
                             <tr>
                                    <td width="20%"> 
                                        <?php echo CHtml::label('<b>'.$model->getAttributeLabel('kecamatan_id').'</b>',$model->getAttributeLabel('nomorindukpegawai'));?>
                                    </td>
                                    <td width="30%">
                                        <?php echo isset($model->kecamatan_id)?$model->kecamatan->kecamatan_nama:"";?>
                                    </td>   
                            </tr> 
                             <tr>
                                    <td width="20%"> 
                                        <?php echo CHtml::label('<b>'.$model->getAttributeLabel('kelurahan_id').'</b>',$model->getAttributeLabel('nomorindukpegawai'));?>
                                    </td>
                                    <td width="30%">
                                        <?php echo isset($model->kelurahan_id)?$model->kelurahan->kelurahan_nama:"";?>
                                    </td>   
                            </tr> 
                            <tr>
                                <td width="20%"> 
                                    <?php echo CHtml::label('<b>'.$model->getAttributeLabel('garis_latitude').'</b>',$model->getAttributeLabel('unit_perusahaan'));?>
                                </td>
                                <td width="30%">
                                    <?php echo $model->garis_latitude;?>
                                </td>   
                            </tr> 
                            <tr>
                                <td width="20%"> 
                                    <?php echo CHtml::label('<b>'.$model->getAttributeLabel('garis_longitude').'</b>',$model->getAttributeLabel('unit_perusahaan'));?>
                                </td>
                                <td width="30%">
                                    <?php echo $model->garis_longitude;?>
                                </td>   
                            </tr> 
                            <tr>
                                <td width="20%"> 
                                    <?php echo CHtml::label('<b>No. Telp / Hp</b>',$model->getAttributeLabel('unit_perusahaan'));?>
                                </td>
                                <td width="30%">
                                    <?php echo $model->notelp_pegawai.' / '.$model->nomobile_pegawai;?>
                                </td>   
                            </tr> 
                            <tr>
                                <td width="20%"> 
                                    <?php echo CHtml::label('<b>'.$model->getAttributeLabel('alamatemail').'</b>',$model->getAttributeLabel('unit_perusahaan'));?>
                                </td>
                                <td width="30%">
                                    <?php echo $model->alamatemail;?>
                                </td>   
                            </tr> 
                    </table>
            </fieldset>
             </div> 
             <div class = "span5"  style = "width:48%">
                <p></p>
                <fieldset class = "box" style = "border:none;background:none;">
                    <legend class = "rim">Data Lain - Lain</legend>
                    <table class = "a table-condensed" style = "background:none;box-shadow:none;"> 
                            
                            <tr>
                                <td width="20%"> 
                                    <?php echo CHtml::label('<b>'.$model->getAttributeLabel('statuskepemilikanrumah_id').'</b>',$model->getAttributeLabel('unit_perusahaan'));?>
                                </td>
                                <td width="30%">
                                    <?php echo isset($model->statuskepemilikanrumah_id)?$model->statuskepemilikanrumah->statuskepemilikanrumah_nama:"";?>
                                </td>   
                            </tr>                                                                                                      
                            <tr>
                                <td width="20%"> 
                                    <?php echo CHtml::label('<b>'.$model->getAttributeLabel('kemampuanbahasa').'</b>',$model->getAttributeLabel('unit_perusahaan'));?>
                                </td>
                                <td width="30%">
                                    <?php echo $model->kemampuanbahasa;?>
                                </td>   
                            </tr>   
                            <tr>
                                <td width="20%"> 
                                    <?php echo CHtml::label('<b>'.$model->getAttributeLabel('warnakulit').'</b>',$model->getAttributeLabel('unit_perusahaan'));?>
                                </td>
                                <td width="30%">
                                    <?php echo $model->warnakulit;?>
                                </td>   
                            </tr>  
                            <tr>
                                <td> 
                                    <?php echo CHtml::label('<b>Tinggi</b>','');?>
                                </td>
                                <td>
                                    <?php echo (isset($model->tinggibadan))?$model->tinggibadan.' cm':'';?>
                                </td>   
                            </tr>
                            <tr>
                                <td> 
                                    <?php echo CHtml::label('<b>Berat</b>','');?>
                                </td>
                                <td>
                                     <?php echo (isset($model->beratbadan))?$model->beratbadan.' kg':'';?>
                                </td>   
                            </tr>
                    </table>
                </fieldset>
            </div> 
            <div class="span12">
                <div class="span5" style = "width:50%">
                <fieldset class = "box" style = "border:none;background:none;">
                    <legend class = "rim">Data User</legend>
                    <table class = "a table-condensed" style = "background:none;box-shadow:none;"> 
                             <tr>                                                    
                                <td width="20%">
                                    <?php echo CHtml::label('<b>Nama Pemakai</b>','nama_pemakai'); ?>
                                </td>
                                <td width="30%">
                                    <?php
                                         $loginpemakai=LoginpemakaiK::model()->find("pegawai_id='$model->pegawai_id'");
                                         echo $loginpemakai->nama_pemakai;
                                    ?>
                                </td>                               
                            </tr>
                                <tr>
                                    <td width="20%">
                                          <?php echo CHtml::label('<b>Terakhir Login</b>','terakhir login'); ?>
                                    </td>
                                    <td width="30%">
                                          <?php echo $format->formatDateTimeForUser($loginpemakai->lastlogin); ?>
                                    </td>                                    
                                </tr>
                                <tr>
                                    <td width="20%">
                                        <?php echo CHtml::label('<b>Tanggal Pembuatan</b>','tanggal pembuatan'); ?>
                                    </td>
                                    <td width="30%">
                                        <?php $format->formatDateTimeForUser($loginpemakai->tglpembuatanlogin); ?>
                                    </td>
                                </tr>
                                <tr>                                    
                                   <td width="20%">
                                       <?php echo CHtml::label('<b>Tanggal Update</b>','tanggal update'); ?>
                                   </td>

                                   <td width="30%">
                                        <?php echo $format->formatDateTimeForUser($loginpemakai->tglupdatelogin); ?>                          
                                   </td>
                                </tr>
                    </table>                    
                </fieldset>
                </div>
                <div class="span5" style = "width:48%">
                <fieldset class = "box" style = "border:none;background:none;">
                    <legend class = "rim">Akses SIMRS</legend>
                    <table class = "a table-condensed" style = "background:none;box-shadow:none;"> 
                             <tr>                                                                                    
                                <td width="20%"> 
                                    <?php echo CHtml::label('<b>Akses Ruangan</b>',$model->getAttributeLabel('ruangan'));?>
                               </td>
                               <td width="30%"> 
                                   <?php //$this->renderPartial('_ruanganPegawai',array('pegawai_id'=>$model->pegawai_id))?>
                                   <?php         
                                            $modRuang= $model->getAksesRuangan();
                                            if(COUNT($modRuang)>0)
                                                {   
                                                    echo "<ul>"; 
                                                    foreach($modRuang as $i=>$tampilDataR)
                                                    {
                                                        echo "<li>".$tampilDataR->ruangan->ruangan_nama.'</li>';
                                                    }
                                                    echo "</ul>";
                                                }
                                            else
                                                {
                                                    echo Yii::t('zii','Not set');
                                                }   
                                        ?>
                               </td>
                            </tr>
                                <tr>                                   
                                    <td width="20%"> 
                                    <?php echo CHtml::label('<b>Akses Modul</b>',$model->getAttributeLabel('ruangan'));?>
                                    </td>
                                    <td width="30%"> 
                                        <?php
                                            $modModul= $model->getAksesModul();
                                            if(COUNT($modModul)>0)
                                                {   
                                                    echo "<ul>"; 
                                                    foreach($modModul as $i=>$tampilData)
                                                    {
                                                        echo "<li>".$tampilData->modul->modul_nama.'</li>';
                                                    }
                                                    echo "</ul>";
                                                }
                                            else
                                                {
                                                    echo Yii::t('zii','Not set');
                                                }   
                                        ?>
                                    </td>
                                </tr>                               
                    </table>                    
                </fieldset>
                </div>
             </div> 
        </div>
        <div class = "span4" style = "width:40%">
                <fieldset class = "box" style = "border:none;">
                    <legend class = "rim">Data Kepegawaian</legend>
                    <table class = "a table-condensed" style = "background:none;box-shadow:none;"> 
                            <tr>
                                <td width="20%"> 
                                    <?php echo CHtml::label('<b>'.$model->getAttributeLabel('golonganpegawai_id').'</b>',$model->getAttributeLabel('unit_perusahaan'));?>
                                </td>
                                <td width="30%">
                                    <?php echo isset($model->golonganpegawai_id)?$model->golonganpegawai->golonganpegawai_nama:"";?>
                                </td>   
                            </tr>                                                                           
                            <tr>
                                <td width="20%"> 
                                    <?php echo CHtml::label('<b>'.$model->getAttributeLabel('jabatan_id').'</b>',$model->getAttributeLabel('unit_perusahaan'));?>
                                </td>
                                <td width="30%">
                                    <?php echo isset($model->jabatan_id)?$model->jabatan->jabatan_nama:"";?>
                                </td>   
                            </tr> 
                            <tr>
                                <td width="20%"> 
                                    <?php echo CHtml::label('<b>'.$model->getAttributeLabel('pangkat_id').'</b>',$model->getAttributeLabel('unit_perusahaan'));?>
                                </td>
                                <td width="30%">
                                    <?php echo isset($model->pangkat_id)?$model->pangkat->pangkat_nama:"";?>
                                </td>   
                            </tr>
                            <tr>
                                <td width="20%"> 
                                    <?php echo CHtml::label('<b>'.$model->getAttributeLabel('kelompokpegawai_id').'</b>',$model->getAttributeLabel('unit_perusahaan'));?>
                                </td>
                                <td width="30%">
                                    <?php echo isset($model->kelompokpegawai_id)?$model->kelompokpegawai->kelompokpegawai_nama:"";?>
                                </td>   
                            </tr>
                            <tr>
                                <td width="20%"> 
                                    <?php echo CHtml::label('<b>'.$model->getAttributeLabel('jenistenagamedis_id').'</b>',$model->getAttributeLabel('unit_perusahaan'));?>
                                </td>
                                <td width="30%">
                                    <?php echo isset($model->jenistenagamedis_id)?$model->jenistenagamedis->jenistenagamedis_nama:"";?>
                                </td>   
                            </tr>
                            <tr>
                                <td width="20%"> 
                                    <?php echo CHtml::label('<b>'.$model->getAttributeLabel('kategoripegawai').'</b>',$model->getAttributeLabel('unit_perusahaan'));?>
                                </td>
                                <td width="30%">
                                    <?php echo $model->kategoripegawai;?>
                                </td>   
                            </tr>
                            <tr>
                                <td width="20%"> 
                                    <?php echo CHtml::label('<b>'.$model->getAttributeLabel('kategoripegawaiasal').'</b>',$model->getAttributeLabel('unit_perusahaan'));?>
                                </td>
                                <td width="30%">
                                    <?php echo $model->kategoripegawaiasal;?>
                                </td>   
                            </tr>
                            <tr>
                                <td width="20%"> 
                                    <?php echo CHtml::label('<b>'.$model->getAttributeLabel('kelompokjabatan').'</b>',$model->getAttributeLabel('unit_perusahaan'));?>
                                </td>
                                <td width="30%">
                                    <?php echo $model->kelompokjabatan;?>
                                </td>   
                            </tr>
                            <tr>
                                <td width="20%"> 
                                    <?php echo CHtml::label('<b>'.$model->getAttributeLabel('jeniswaktukerja').'</b>',$model->getAttributeLabel('unit_perusahaan'));?>
                                </td>
                                <td width="30%">
                                    <?php echo $model->jeniswaktukerja;?>
                                </td>   
                            </tr>
                            <tr>
                                <td width="20%"> 
                                    <?php echo CHtml::label('<b>'.$model->getAttributeLabel('pendidikan_id').'</b>',$model->getAttributeLabel('unit_perusahaan'));?>
                                </td>
                                <td width="30%">
                                    <?php echo isset($model->pendidikan_id)?$model->pendidikan->pendidikan_nama:"";?>
                                </td>   
                            </tr>
                            <tr>
                                <td width="20%"> 
                                    <?php echo CHtml::label('<b>'.$model->getAttributeLabel('pendkualifikasi_id').'</b>',$model->getAttributeLabel('unit_perusahaan'));?>
                                </td>
                                <td width="30%">
                                    <?php echo isset($model->pendkualifikasi_id)?$model->pendkualifikasi->pendkualifikasi_nama:"";?>
                                </td>   
                            </tr>
                            <tr>
                                <td width="20%"> 
                                    <?php echo CHtml::label('<b>'.$model->getAttributeLabel('tglditerima').'</b>',$model->getAttributeLabel('unit_perusahaan'));?>
                                </td>
                                <td width="30%">
                                    <?php echo $format->formatDateTimeForUser($model->tglditerima);?>
                                </td>   
                            </tr>
                            <tr>
                                <td width="20%"> 
                                    <?php echo CHtml::label('<b>'.$model->getAttributeLabel('surattandaregistrasi').'</b>',$model->getAttributeLabel('unit_perusahaan'));?>
                                </td>
                                <td width="30%">
                                    <?php echo $model->surattandaregistrasi;?>
                                </td>   
                            </tr> 
                            <tr>
                                <td width="20%"> 
                                    <?php echo CHtml::label('<b>'.$model->getAttributeLabel('suratizinpraktek').'</b>',$model->getAttributeLabel('suratizinpraktek'));?>
                                </td>
                                <td width="30%">
                                    <?php echo $model->suratizinpraktek;?>
                                </td>   
                            </tr> 
                            <tr>
                                <td width="20%"> 
                                    <?php echo CHtml::label('<b>'.$model->getAttributeLabel('npwp').'</b>',$model->getAttributeLabel('npwp'));?>
                                </td>
                                <td width="30%">
                                    <?php echo $model->npwp;?>
                                </td>   
                            </tr> 
                            <tr>
                                <td width="20%"> 
                                    <?php echo CHtml::label('<b>'.$model->getAttributeLabel('no_rekening').'</b>',$model->getAttributeLabel('no_rekening'));?>
                                </td>
                                <td width="30%">
                                    <?php echo $model->no_rekening;?>
                                </td>   
                            </tr> 
                            <tr>
                                <td width="20%"> 
                                    <?php echo CHtml::label('<b>'.$model->getAttributeLabel('bank_no_rekening').'</b>',$model->getAttributeLabel('bank_no_rekening'));?>
                                </td>
                                <td width="30%">
                                    <?php echo $model->bank_no_rekening;?>
                                </td>   
                            </tr> 
                            <tr>
                                <td width="20%"> 
                                    <?php echo CHtml::label('<b>'.$model->getAttributeLabel('gajipokok').'</b>',$model->getAttributeLabel('gajipokok'));?>
                                </td>
                                <td width="30%">
                                    <?php echo 'Rp'.number_format($model->gajipokok,0,'','.');?>
                                </td>   
                            </tr>
                    </table>
            </fieldset>   
        </div>
    </div>
  <?php echo CHtml::link(Yii::t('mds','{icon} Ubah',array('{icon}'=>'<i class="icon-pencil icon-white"></i>')),$this->createUrl('update',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success')); ?>
    <?php $this->widget('UserTips',array('type'=>'view'));?>
</div>                                                       
<!--                </tr>
                <tr>
                      <td width="20%"> 
                           <?php // echo CHtml::label($model->getAttributeLabel('no_taspen'),$model->getAttributeLabel('no_taspen'));?>
                      </td>
                      <td width="30%" colspan="2">
                             <?php // echo CHtml::label($model->no_taspen, $model->no_taspen);?>                   
                      </td>
                </tr>
                <tr>
                     <td width="20%"> 
                           <?php // echo CHtml::label($model->getAttributeLabel('nomorindukpegawai'),$model->getAttributeLabel('nomorindukpegawai'));?>
                      </td>
                      <td width="30%" colspan="2">
                             <?php // echo CHtml::label( $model->nomorindukpegawai, $model->nomorindukpegawai);?>                     
                      </td>
                </tr>
                <tr>
                     <td width="20%"> 
                           <?php // echo CHtml::label($model->getAttributeLabel('no_kartupegawainegerisipil'),$model->getAttributeLabel('no_kartupegawainegerisipil'));?>
                      </td>
                      <td width="30%" colspan="2">
                             <?php // echo CHtml::label( $model->no_kartupegawainegerisipil, $model->no_kartupegawainegerisipil);?>                     
                      
                      </td>
                </tr>
                <tr>
                    <td width="20%"> 
                           <?php // echo CHtml::label($model->getAttributeLabel('kategoripegawai'),$model->getAttributeLabel('kategoripegawai'));?>
                      </td>
                      <td width="30%">
                             <?php // echo CHtml::label( $model->kategoripegawai, $model->kategoripegawai);?>                     
                      </td>  
                      <td width="20%"> 
                           <?php // echo CHtml::label($model->getAttributeLabel('warganegara_pegawai'),$model->getAttributeLabel('warganegara_pegawai'));?>
                      </td>
                      <td width="30%">
                             <?php // echo CHtml::label($model->warganegara_pegawai, $model->warganegara_pegawai);?>                   
                      </td>
    
                </tr>
                <tr>
                      <td width="20%"> 
                           <?php // echo CHtml::label($model->getAttributeLabel('no_karis_karsu'),$model->getAttributeLabel('no_karis_karsu'));?>
                      </td>
                      <td width="30%">
                             <?php // echo CHtml::label($model->no_karis_karsu, $model->no_karis_karsu);?>                   
                      </td>
                       <td width="20%"> 
                           <?php // echo CHtml::label($model->getAttributeLabel('jeniswaktukerja'),$model->getAttributeLabel('jeniswaktukerja'));?>
                      </td>
                      <td width="30%">
                             <?php // echo CHtml::label( $model->jeniswaktukerja, $model->jeniswaktukerja);?>                     
                      </td>
                </tr>
                <tr>
                      <td width="20%"> 
                           <?php // echo CHtml::label($model->getAttributeLabel('pangkat_id'),$model->getAttributeLabel('pangkat_id'));?>
                      </td>
                      <td width="30%">
                             <?php // echo CHtml::label($model->pangkat->pangkat_nama, $model->pangkat->pangkat_nama);?>                   
                      </td>
                   
                       <td width="20%"> 
                           <?php // echo CHtml::label($model->getAttributeLabel('jabatan_id').'/'.$model->getAttributeLabel('kelompokjabatan'),$model->getAttributeLabel('jabatan_id').'/'.$model->getAttributeLabel('kelompokjabatan'));?>
                      </td>
                      <td width="30%">
                             <?php // echo CHtml::label( $model->jabatan->jabatan_nama.'/'.$model->kelompokjabatan, $model->jabatan->jabatan_nama.'/'.$model->kelompokjabatan);?>                     
                      </td>
                </tr>
                <tr>
                      <td width="20%"> 
                           <?php // echo CHtml::label($model->getAttributeLabel('nama_keluarga'),$model->getAttributeLabel('nama_keluarga'));?>
                      </td>
                      <td width="30%">
                             <?php // echo CHtml::label($model->nama_keluarga, $model->nama_keluarga);?>                   
                      </td>
                       <td width="20%"> 
                           <?php // echo CHtml::label($model->getAttributeLabel('statusperkawinan'),$model->getAttributeLabel('statusperkawinan'));?>
                      </td>
                      <td width="30%">
                             <?php // echo CHtml::label( $model->statusperkawinan, $model->statusperkawinan);?>                     
                      </td>
                </tr>
                <tr>
                      <td width="20%"> 
                           <?php // echo CHtml::label($model->getAttributeLabel('tempatlahir_pegawai'),$model->getAttributeLabel('tempatlahir_pegawai'));?>
                      </td>
                      <td width="30%">
                             <?php // echo CHtml::label($model->tempatlahir_pegawai, $model->tempatlahir_pegawai);?>                   
                      </td>
                       <td width="20%"> 
                           <?php // echo CHtml::label($model->getAttributeLabel('tgl_lahirpegawai'),$model->getAttributeLabel('tgl_lahirpegawai'));?>
                      </td>
                      <td width="30%">
                             <?php // echo CHtml::label( $model->tgl_lahirpegawai, $model->tgl_lahirpegawai);?>                     
                      </td>
                </tr>
                       <td width="20%"> 
                           <?php // echo CHtml::label($model->getAttributeLabel('suku_id'),$model->getAttributeLabel('suku_id'));?>
                      </td>
                      <td width="30%">
                             <?php // echo CHtml::label( $model->suku->suku_nama,$model->suku->suku_nama);?>                     
                      </td>
                <tr>
                      <td width="20%"> 
                           <?php // echo CHtml::label($model->getAttributeLabel('pendidikan_id'),$model->getAttributeLabel('pendidikan_id'));?>
                      </td>
                      <td width="30%">
                             <?php // echo CHtml::label($model->pendidikan->pendidikan_nama, $model->pendidikan->pendidikan_nama);?>                   
                      </td>
                       <td width="20%"> 
                           <?php // echo CHtml::label($model->getAttributeLabel('pendkualifikasi_id'),$model->getAttributeLabel('pendkualifikasi_id'));?>
                      </td>
                      <td width="30%">
                             <?php // echo CHtml::label( $model->pendkualifikasi->pendkualifikasi_nama, $model->pendkualifikasi->pendkualifikasi_nama);?>                     
                      </td>
                </tr>
               
                <tr>
                      <td width="20%"> 
                           <?php // echo CHtml::label($model->getAttributeLabel('golongandarah').'/'.$model->getAttributeLabel('rhesus'),$model->getAttributeLabel('golongandarah').'/'.$model->getAttributeLabel('rhesus'));?>
                      </td>
                      <td width="30%">
                             <?php // echo CHtml::label($model->golongandarah.'/'.$model->rhesus, $model->golongandarah.'/'.$model->rhesus);?>    
                      </td>
                       <td width="20%"> 
                           <?php // echo CHtml::label($model->getAttributeLabel('jeniskelamin'),$model->getAttributeLabel('jeniskelamin'));?>
                      </td>
                      <td width="30%">
                             <?php // echo CHtml::label( $model->jeniskelamin, $model->jeniskelamin);?>                     
                      </td>
                </tr>
        </table>        
</fieldset>-->
<!--
<fieldset>
    <legend>Contact Person</legend>
        <table style="width: 950px" class="table table-striped table-bordered table-condensed">
             <tr>
                   <td rowspan="4">
                         <?php // echo CHtml::label($model->getAttributeLabel('alamat_pegawai'),$model->getAttributeLabel('alamat_pegawai'));?>
                   </td>
                   <td rowspan="4">
                         <?php // echo CHtml::label( $model->alamat_pegawai, $model->alamat_pegawai);?>                     
                   </td>
                   <td>
                          <?php // echo CHtml::label($model->getAttributeLabel('propinsi_id'),$model->getAttributeLabel('propinsi_id'));?>
                   </td>
                   <td>
                          <?php // echo CHtml::label( $model->propinsi->propinsi_nama,$model->propinsi->propinsi_nama);?>                     
                   </td>
             </tr>
             <tr>
                   <td>
                         <?php // echo CHtml::label($model->getAttributeLabel('kabupaten_id'),$model->getAttributeLabel('kabupaten_id'));?>
                    </td>
                    <td>
                         <?php // echo CHtml::label( $model->kabupaten->kabupaten_nama, $model->kabupaten->kabupaten_nama);?>                     

                    </td>
             </tr>
              <tr>
                   <td>
                         <?php // echo CHtml::label($model->getAttributeLabel('kecamatan_id'),$model->getAttributeLabel('kecamatan_id'));?>
                    </td>
                    <td>
                         <?php // echo CHtml::label( $model->kecamatan->kecamatan_nama, $model->kecamatan->kecamatan_nama);?>                     

                    </td>
             </tr>
             <tr>
                   <td>
                         <?php // echo CHtml::label($model->getAttributeLabel('kelurahan_id'),$model->getAttributeLabel('kelurahan_id'));?>
                    </td>
                    <td>
                         <?php // echo CHtml::label( $model->kelurahan->kelurahan_nama, $model->kelurahan->kelurahan_nama);?>                     

                    </td>
             </tr>
             <tr>
                      <td width="20%"> 
                           <?php // echo CHtml::label($model->getAttributeLabel('notelp_pegawai'),$model->getAttributeLabel('notelp_pegawai'));?>
                      </td>
                      <td width="30%">
                             <?php // echo CHtml::label($model->notelp_pegawai, $model->notelp_pegawai);?>    

                      </td>
                       <td width="20%"> 
                           <?php // echo CHtml::label($model->getAttributeLabel('nomobile_pegawai'),$model->getAttributeLabel('nomobile_pegawai'));?>
                      </td>
                      <td width="30%">
                             <?php // echo CHtml::label( $model->nomobile_pegawai, $model->nomobile_pegawai);?>                     
                      </td>
                </tr>
                 <tr>
                      <td width="20%"> 
                           <?php // echo CHtml::label($model->getAttributeLabel('alamatemail'),$model->getAttributeLabel('alamatemail'));?>
                      </td>
                      <td width="30%" colspan="3">
                             <?php // echo CHtml::label($model->alamatemail, $model->alamatemail);?>    

                      </td>
                      
                </tr>
-->                 
      
             
  
