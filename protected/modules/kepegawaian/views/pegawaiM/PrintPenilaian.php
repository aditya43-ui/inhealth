<?php 
if($caraPrint=='EXCEL')
    {
        header('Content-Type: application/vnd.ms-excel');
          header('Content-Disposition: attachment;filename="'.$judulLaporan.'-'.date("Y/m/d").'.xls"');
          header('Cache-Control: max-age=0');     
    }
echo $this->renderPartial('application.views.headerReport.headerDefault',array('judulLaporan'=>$judulLaporan));           
?>
<fieldset style="width: 1200px">
    <legend>Data Pegawai</legend>
        <table style="width: 950px" class="table table-striped table-bordered table-condensed">
              <tr>
                     <td rowspan="7" align="center"> 
                         <img src="<?php echo Params::urlPegawaiTumbsDirectory().'kecil_'.$modelpegawai->photopegawai ?> ">     

                    </td>
              </tr>
              <tr>
                      <td width="20%"> 
                           <?php echo CHtml::label($modelpegawai->getAttributeLabel('nama_pegawai'),$modelpegawai->getAttributeLabel('nama_pegawai'));?>
                      </td>
                      <td width="30%" colspan="2">
                            <?php echo CHtml::label($modelpegawai->gelardepan.' '.$modelpegawai->nama_pegawai.' '.$modelpegawai->gelarbelakang->gelarbelakang_nama,  $modelpegawai->gelardepan.' '.$modelpegawai->nama_pegawai.' '.$modelpegawai->gelarbelakang->gelarbelakang_nama);?>                  
                       </td>
                      
                </tr>
                <tr>
                      <td width="20%"> 
                           <?php echo CHtml::label($modelpegawai->getAttributeLabel('kategoripegawaiasal'),$modelpegawai->getAttributeLabel('kategoripegawaiasal'));?>
                      </td>
                      <td width="30%"  colspan="2">
                             <?php echo CHtml::label($modelpegawai->kategoripegawaiasal, $modelpegawai->kategoripegawaiasal);?>                   
                      </td>
                       
                </tr>
                <tr>
                      <td width="20%"> 
                           <?php echo CHtml::label($modelpegawai->getAttributeLabel('kelompokpegawai_id'),$modelpegawai->getAttributeLabel('kelompokpegawai_id'));?>
                      </td>
                      <td width="30%" colspan="2">
                             <?php echo CHtml::label($modelpegawai->kelompokpegawai->kelompokpegawai_nama, $modelpegawai->kelompokpegawai->kelompokpegawai_nama);?>                   
                      </td>
                      
                </tr>
                <tr>
                      <td width="20%"> 
                           <?php echo CHtml::label($modelpegawai->getAttributeLabel('no_taspen'),$modelpegawai->getAttributeLabel('no_taspen'));?>
                      </td>
                      <td width="30%" colspan="2">
                             <?php echo CHtml::label($modelpegawai->no_taspen, $modelpegawai->no_taspen);?>                   
                      </td>
                      
                </tr>
                <tr>
                     <td width="20%"> 
                           <?php echo CHtml::label($modelpegawai->getAttributeLabel('nomorindukpegawai'),$modelpegawai->getAttributeLabel('nomorindukpegawai'));?>
                      </td>
                      <td width="30%" colspan="2">
                             <?php echo CHtml::label( $modelpegawai->nomorindukpegawai, $modelpegawai->nomorindukpegawai);?>                     
                      </td>
                      
                </tr>
                <tr>
                     <td width="20%"> 
                           <?php echo CHtml::label($modelpegawai->getAttributeLabel('no_kartupegawainegerisipil'),$modelpegawai->getAttributeLabel('no_kartupegawainegerisipil'));?>
                      </td>
                      <td width="30%" colspan="2">
                             <?php echo CHtml::label( $modelpegawai->no_kartupegawainegerisipil, $modelpegawai->no_kartupegawainegerisipil);?>                     
                      
                    </td>
                      
               
                    
                </tr>
                <tr>
                      
                    <td width="20%"> 
                           <?php echo CHtml::label($modelpegawai->getAttributeLabel('kategoripegawai'),$modelpegawai->getAttributeLabel('kategoripegawai'));?>
                      </td>
                      <td width="30%">
                             <?php echo CHtml::label( $modelpegawai->kategoripegawai, $modelpegawai->kategoripegawai);?>                     
                      </td>  
                      <td width="20%"> 
                           <?php echo CHtml::label($modelpegawai->getAttributeLabel('warganegara_pegawai'),$modelpegawai->getAttributeLabel('warganegara_pegawai'));?>
                      </td>
                      <td width="30%">
                             <?php echo CHtml::label($modelpegawai->warganegara_pegawai, $modelpegawai->warganegara_pegawai);?>                   
                      </td>
                      
                       
                </tr>
                <tr>
                      <td width="20%"> 
                           <?php echo CHtml::label($modelpegawai->getAttributeLabel('no_karis_karsu'),$modelpegawai->getAttributeLabel('no_karis_karsu'));?>
                      </td>
                      <td width="30%">
                             <?php echo CHtml::label($modelpegawai->no_karis_karsu, $modelpegawai->no_karis_karsu);?>                   
                      </td>
                       <td width="20%"> 
                           <?php echo CHtml::label($modelpegawai->getAttributeLabel('jeniswaktukerja'),$modelpegawai->getAttributeLabel('jeniswaktukerja'));?>
                      </td>
                      <td width="30%">
                             <?php echo CHtml::label( $modelpegawai->jeniswaktukerja, $modelpegawai->jeniswaktukerja);?>                     
                      </td>
                </tr>
                <tr>
                      <td width="20%"> 
                           <?php echo CHtml::label($modelpegawai->getAttributeLabel('pangkat_id'),$modelpegawai->getAttributeLabel('pangkat_id'));?>
                      </td>
                      <td width="30%">
                             <?php echo CHtml::label($modelpegawai->pangkat->pangkat_nama, $modelpegawai->pangkat->pangkat_nama);?>                   
                      </td>
                   
                       <td width="20%"> 
                           <?php echo CHtml::label($modelpegawai->getAttributeLabel('jabatan_id').'/'.$modelpegawai->getAttributeLabel('kelompokjabatan'),$modelpegawai->getAttributeLabel('jabatan_id').'/'.$modelpegawai->getAttributeLabel('kelompokjabatan'));?>
                      </td>
                      <td width="30%">
                             <?php echo CHtml::label( $modelpegawai->jabatan->jabatan_nama.'/'.$modelpegawai->kelompokjabatan, $modelpegawai->jabatan->jabatan_nama.'/'.$modelpegawai->kelompokjabatan);?>                     
                      </td>
                </tr>
               
                <tr>
                      <td width="20%"> 
                           <?php echo CHtml::label($modelpegawai->getAttributeLabel('nama_keluarga'),$modelpegawai->getAttributeLabel('nama_keluarga'));?>
                      </td>
                      <td width="30%">
                             <?php echo CHtml::label($modelpegawai->nama_keluarga, $modelpegawai->nama_keluarga);?>                   
                      </td>
                       <td width="20%"> 
                           <?php echo CHtml::label($modelpegawai->getAttributeLabel('statusperkawinan'),$modelpegawai->getAttributeLabel('statusperkawinan'));?>
                      </td>
                      <td width="30%">
                             <?php echo CHtml::label( $modelpegawai->statusperkawinan, $modelpegawai->statusperkawinan);?>                     
                      </td>
                </tr>
                <tr>
                      <td width="20%"> 
                           <?php echo CHtml::label($modelpegawai->getAttributeLabel('tempatlahir_pegawai'),$modelpegawai->getAttributeLabel('tempatlahir_pegawai'));?>
                      </td>
                      <td width="30%">
                             <?php echo CHtml::label($modelpegawai->tempatlahir_pegawai, $modelpegawai->tempatlahir_pegawai);?>                   
                      </td>
                       <td width="20%"> 
                           <?php echo CHtml::label($modelpegawai->getAttributeLabel('tgl_lahirpegawai'),$modelpegawai->getAttributeLabel('tgl_lahirpegawai'));?>
                      </td>
                      <td width="30%">
                             <?php echo CHtml::label( $modelpegawai->tgl_lahirpegawai, $modelpegawai->tgl_lahirpegawai);?>                     
                      </td>
                </tr>
                 <tr>
                      <td width="20%"> 
                           <?php echo CHtml::label($modelpegawai->getAttributeLabel('agama'),$modelpegawai->getAttributeLabel('agama'));?>
                      </td>
                      <td width="30%">
                             <?php echo CHtml::label($modelpegawai->agama, $modelpegawai->agama);?>                   
                      </td>
                       <td width="20%"> 
                           <?php echo CHtml::label($modelpegawai->getAttributeLabel('suku_id'),$modelpegawai->getAttributeLabel('suku_id'));?>
                      </td>
                      <td width="30%">
                             <?php echo CHtml::label( $modelpegawai->suku->suku_nama,$modelpegawai->suku->suku_nama);?>                     
                      </td>
                </tr>
                <tr>
                      <td width="20%"> 
                           <?php echo CHtml::label($modelpegawai->getAttributeLabel('pendidikan_id'),$modelpegawai->getAttributeLabel('pendidikan_id'));?>
                      </td>
                      <td width="30%">
                             <?php echo CHtml::label($modelpegawai->pendidikan->pendidikan_nama, $modelpegawai->pendidikan->pendidikan_nama);?>                   
                      </td>
                       <td width="20%"> 
                           <?php echo CHtml::label($modelpegawai->getAttributeLabel('pendkualifikasi_id'),$modelpegawai->getAttributeLabel('pendkualifikasi_id'));?>
                      </td>
                      <td width="30%">
                             <?php echo CHtml::label( $modelpegawai->pendkualifikasi->pendkualifikasi_nama, $modelpegawai->pendkualifikasi->pendkualifikasi_nama);?>                     
                      </td>
                </tr>
               
        </table>        
</fieldset>
<fieldset>
    <legend>Penilaian Pegawai</legend>
        <table style="width: 950px" class="table table-striped table-bordered table-condensed">
             <tr>
                   <td width="20%">
                          <?php echo CHtml::label($model->getAttributeLabel('tglpenilaian'),$model->getAttributeLabel('tglpenilaian')); ?>
                   </td>
                   <td width="30%">
                          <?php echo CHtml::label($model->tglpenilaian,$model->tglpenilaian);?>                     
                   </td>
                   
                   <td width="20%">
                          <?php echo CHtml::label($model->getAttributeLabel('kejujuran'),$model->getAttributeLabel('kejujuran')); ?>
                   </td>
                   <td width="30%">
                          <?php echo CHtml::label($model->kejujuran,$model->kejujuran);?>                     
                   </td>
             </tr>
             <tr>
                    <td width="20%">
                         <?php echo CHtml::label($model->getAttributeLabel('periodepenilaian'),$model->getAttributeLabel('periodepenilaian')); ?>
                    </td>
                    <td width="30%"> 
                         <?php echo CHtml::label( $model->periodepenilaian, $model->periodepenilaian);?>                     

                    </td>
                    
                    <td width="20%">
                          <?php echo CHtml::label($model->getAttributeLabel('kerjasama'),$model->getAttributeLabel('kerjasama')); ?>
                   </td>
                   <td width="30%">
                          <?php echo CHtml::label($model->kerjasama,$model->kerjasama);?>                     
                   </td>
             </tr>
              <tr>
                   <td width="20%">
                         <?php echo CHtml::label($model->getAttributeLabel('kesetiaan'),$model->getAttributeLabel('kesetiaan')); ?>
                    </td>
                    <td>
                         <?php echo CHtml::label( $model->kesetiaan, $model->kesetiaan);?>                     

                    </td>
                    
                    <td width="20%">
                          <?php echo CHtml::label($model->getAttributeLabel('prakarsa'),$model->getAttributeLabel('prakarsa')); ?>
                   </td>
                   <td width="30%">
                          <?php echo CHtml::label($model->prakarsa,$model->prakarsa);?>                     
                   </td>
             </tr>
             <tr>
                   <td width="20%">
                         <?php echo CHtml::label($model->getAttributeLabel('prestasikerja'),$model->getAttributeLabel('prestasikerja')); ?>
                    </td>
                    <td width="30%">
                         <?php echo CHtml::label( $model->prestasikerja, $model->prestasikerja);?>                     

                    </td>
                    
                    <td width="20%">
                          <?php echo CHtml::label($model->getAttributeLabel('kepemimpinan'),$model->getAttributeLabel('kepemimpinan')); ?>
                   </td>
                   <td width="30%">
                          <?php echo CHtml::label($model->kepemimpinan,$model->kepemimpinan);?>                     
                   </td>
             </tr>
             <tr>
                     <td width="20%">
                         <?php echo CHtml::label($model->getAttributeLabel('tanggungjawab'),$model->getAttributeLabel('tanggungjawab')); ?>
                    </td>
                    <td width="30%">
                         <?php echo CHtml::label( $model->tanggungjawab, $model->tanggungjawab);?>                     

                    </td>
                    
                    <td width="20%">
                         <?php echo CHtml::label($model->getAttributeLabel('ketaatan'),$model->getAttributeLabel('ketaatan')); ?>
                    </td>
                    <td width="30%">
                         <?php echo CHtml::label( $model->ketaatan, $model->ketaatan);?>                     

                    </td>
                </tr>
                
             <tr>
                   <td width="20%">
                         <?php echo CHtml::label($model->getAttributeLabel('jumlahpenilaian'),$model->getAttributeLabel('jumlahpenilaian')); ?>
                    </td>
                    <td width="30%">
                         <?php echo CHtml::label( $model->jumlahpenilaian, $model->jumlahpenilaian);?>                     

                    </td>
                    
                    <td width="20%">
                         <?php echo CHtml::label($model->getAttributeLabel('nilairatapenilaian'),$model->getAttributeLabel('nilairatapenilaian')); ?>
                    </td>
                    <td width="30%">
                         <?php echo CHtml::label( $model->nilairatapenilaian, $model->nilairatapenilaian);?>                     

                    </td>

            </tr>
            <tr>
                   <td width="20%">
                       
                    </td>
                    <td width="30%">
                       
                    </td>
                    
                    <td width="20%">
                         <?php echo CHtml::label($model->getAttributeLabel('performanceindex'),$model->getAttributeLabel('performanceindex')); ?>
                    </td>
                    <td width="30%">
                         <?php echo CHtml::label( $model->performanceindex, $model->performanceindex);?>                     

                    </td>

            </tr>
                 
             
        </table>
</fieldset>