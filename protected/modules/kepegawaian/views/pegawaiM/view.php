<fieldset style="width: 1200px">
    <legend>Data Pegawai</legend>
        <table style="width: 950px" class="table table-striped table-bordered table-condensed">
              <tr>
                     <td rowspan="7" align="center"> 
                         <img src="<?php echo Params::urlPegawaiTumbsDirectory().'kecil_'.$model->photopegawai ?> ">     

                    </td>
              </tr>
              <tr>
                      <td width="20%"> 
                           <?php echo CHtml::label($model->getAttributeLabel('nama_pegawai'),$model->getAttributeLabel('nama_rumahsakit'));?>
                      </td>
                      <td width="30%" colspan="2">
                            <?php echo CHtml::label($model->gelardepan.' '.$model->nama_pegawai.' '.$model->gelarbelakang->gelarbelakang_nama,  $model->gelardepan.' '.$model->nama_pegawai.' '.$model->gelarbelakang->gelarbelakang_nama);?>                  
                       </td>
                      
                </tr>
                <tr>
                      <td width="20%"> 
                           <?php echo CHtml::label($model->getAttributeLabel('kategoripegawaiasal'),$model->getAttributeLabel('kategoripegawaiasal'));?>
                      </td>
                      <td width="30%"  colspan="2">
                             <?php echo CHtml::label($model->kategoripegawaiasal, $model->kategoripegawaiasal);?>                   
                      </td>
                       
                </tr>
                <tr>
                      <td width="20%"> 
                           <?php echo CHtml::label($model->getAttributeLabel('kelompokpegawai_id'),$model->getAttributeLabel('kelompokpegawai_id'));?>
                      </td>
                      <td width="30%" colspan="2">
                             <?php echo CHtml::label($model->kelompokpegawai->kelompokpegawai_nama, $model->kelompokpegawai->kelompokpegawai_nama);?>                   
                      </td>
                      
                </tr>
                <tr>
                      <td width="20%"> 
                           <?php echo CHtml::label($model->getAttributeLabel('no_taspen'),$model->getAttributeLabel('no_taspen'));?>
                      </td>
                      <td width="30%" colspan="2">
                             <?php echo CHtml::label($model->no_taspen, $model->no_taspen);?>                   
                      </td>
                      
                </tr>
                <tr>
                     <td width="20%"> 
                           <?php echo CHtml::label($model->getAttributeLabel('nomorindukpegawai'),$model->getAttributeLabel('nomorindukpegawai'));?>
                      </td>
                      <td width="30%" colspan="2">
                             <?php echo CHtml::label( $model->nomorindukpegawai, $model->nomorindukpegawai);?>                     
                      </td>
                      
                </tr>
                <tr>
                     <td width="20%"> 
                           <?php echo CHtml::label($model->getAttributeLabel('no_kartupegawainegerisipil'),$model->getAttributeLabel('no_kartupegawainegerisipil'));?>
                      </td>
                      <td width="30%" colspan="2">
                             <?php echo CHtml::label( $model->no_kartupegawainegerisipil, $model->no_kartupegawainegerisipil);?>                     
                      
                    </td>
                      
               
                    
                </tr>
                <tr>
                      
                    <td width="20%"> 
                           <?php echo CHtml::label($model->getAttributeLabel('kategoripegawai'),$model->getAttributeLabel('kategoripegawai'));?>
                      </td>
                      <td width="30%">
                             <?php echo CHtml::label( $model->kategoripegawai, $model->kategoripegawai);?>                     
                      </td>  
                      <td width="20%"> 
                           <?php echo CHtml::label($model->getAttributeLabel('warganegara_pegawai'),$model->getAttributeLabel('warganegara_pegawai'));?>
                      </td>
                      <td width="30%">
                             <?php echo CHtml::label($model->warganegara_pegawai, $model->warganegara_pegawai);?>                   
                      </td>
                      
                       
                </tr>
                <tr>
                      <td width="20%"> 
                           <?php echo CHtml::label($model->getAttributeLabel('no_karis_karsu'),$model->getAttributeLabel('no_karis_karsu'));?>
                      </td>
                      <td width="30%">
                             <?php echo CHtml::label($model->no_karis_karsu, $model->no_karis_karsu);?>                   
                      </td>
                       <td width="20%"> 
                           <?php echo CHtml::label($model->getAttributeLabel('jeniswaktukerja'),$model->getAttributeLabel('jeniswaktukerja'));?>
                      </td>
                      <td width="30%">
                             <?php echo CHtml::label( $model->jeniswaktukerja, $model->jeniswaktukerja);?>                     
                      </td>
                </tr>
                <tr>
                      <td width="20%"> 
                           <?php echo CHtml::label($model->getAttributeLabel('pangkat_id'),$model->getAttributeLabel('pangkat_id'));?>
                      </td>
                      <td width="30%">
                             <?php echo CHtml::label($model->pangkat->pangkat_nama, $model->pangkat->pangkat_nama);?>                   
                      </td>
                   
                       <td width="20%"> 
                           <?php echo CHtml::label($model->getAttributeLabel('jabatan_id').'/'.$model->getAttributeLabel('kelompokjabatan'),$model->getAttributeLabel('jabatan_id').'/'.$model->getAttributeLabel('kelompokjabatan'));?>
                      </td>
                      <td width="30%">
                             <?php echo CHtml::label( $model->jabatan->jabatan_nama.'/'.$model->kelompokjabatan, $model->jabatan->jabatan_nama.'/'.$model->kelompokjabatan);?>                     
                      </td>
                </tr>
                <tr>
                      <td width="20%"> 
                           <?php echo CHtml::label($model->getAttributeLabel('ruangan'),$model->getAttributeLabel('ruangan'));?>
                      </td>
                      <td colspan="3"> 
                          <?php $this->renderPartial($this->path_view.'_ruanganPegawai',array('pegawai_id'=>$model->pegawai_id))?>                      </td>
                </tr>
                <tr>
                      <td width="20%"> 
                           <?php echo CHtml::label($model->getAttributeLabel('nama_keluarga'),$model->getAttributeLabel('nama_keluarga'));?>
                      </td>
                      <td width="30%">
                             <?php echo CHtml::label($model->nama_keluarga, $model->nama_keluarga);?>                   
                      </td>
                       <td width="20%"> 
                           <?php echo CHtml::label($model->getAttributeLabel('statusperkawinan'),$model->getAttributeLabel('statusperkawinan'));?>
                      </td>
                      <td width="30%">
                             <?php echo CHtml::label( $model->statusperkawinan, $model->statusperkawinan);?>                     
                      </td>
                </tr>
                <tr>
                      <td width="20%"> 
                           <?php echo CHtml::label($model->getAttributeLabel('tempatlahir_pegawai'),$model->getAttributeLabel('tempatlahir_pegawai'));?>
                      </td>
                      <td width="30%">
                             <?php echo CHtml::label($model->tempatlahir_pegawai, $model->tempatlahir_pegawai);?>                   
                      </td>
                       <td width="20%"> 
                           <?php echo CHtml::label($model->getAttributeLabel('tgl_lahirpegawai'),$model->getAttributeLabel('tgl_lahirpegawai'));?>
                      </td>
                      <td width="30%">
                             <?php echo CHtml::label( $model->tgl_lahirpegawai, $model->tgl_lahirpegawai);?>                     
                      </td>
                </tr>
                 <tr>
                      <td width="20%"> 
                           <?php echo CHtml::label($model->getAttributeLabel('agama'),$model->getAttributeLabel('agama'));?>
                      </td>
                      <td width="30%">
                             <?php echo CHtml::label($model->agama, $model->agama);?>                   
                      </td>
                       <td width="20%"> 
                           <?php echo CHtml::label($model->getAttributeLabel('suku_id'),$model->getAttributeLabel('suku_id'));?>
                      </td>
                      <td width="30%">
                             <?php echo CHtml::label( $model->suku->suku_nama,$model->suku->suku_nama);?>                     
                      </td>
                </tr>
                <tr>
                      <td width="20%"> 
                           <?php echo CHtml::label($model->getAttributeLabel('pendidikan_id'),$model->getAttributeLabel('pendidikan_id'));?>
                      </td>
                      <td width="30%">
                             <?php echo CHtml::label($model->pendidikan->pendidikan_nama, $model->pendidikan->pendidikan_nama);?>                   
                      </td>
                       <td width="20%"> 
                           <?php echo CHtml::label($model->getAttributeLabel('pendkualifikasi_id'),$model->getAttributeLabel('pendkualifikasi_id'));?>
                      </td>
                      <td width="30%">
                             <?php echo CHtml::label( $model->pendkualifikasi->pendkualifikasi_nama, $model->pendkualifikasi->pendkualifikasi_nama);?>                     
                      </td>
                </tr>
               
                <tr>
                      <td width="20%"> 
                           <?php echo CHtml::label($model->getAttributeLabel('golongandarah').'/'.$model->getAttributeLabel('rhesus'),$model->getAttributeLabel('golongandarah').'/'.$model->getAttributeLabel('rhesus'));?>
                      </td>
                      <td width="30%">
                             <?php echo CHtml::label($model->golongandarah.'/'.$model->rhesus, $model->golongandarah.'/'.$model->rhesus);?>    
                      </td>
                       <td width="20%"> 
                           <?php echo CHtml::label($model->getAttributeLabel('jeniskelamin'),$model->getAttributeLabel('jeniskelamin'));?>
                      </td>
                      <td width="30%">
                             <?php echo CHtml::label( $model->jeniskelamin, $model->jeniskelamin);?>                     
                      </td>
                </tr>
        </table>        
</fieldset>
<fieldset>
    <legend>Contact Person</legend>
        <table style="width: 950px" class="table table-striped table-bordered table-condensed">
             <tr>
                   <td rowspan="4">
                         <?php echo CHtml::label($model->getAttributeLabel('alamat_pegawai'),$model->getAttributeLabel('alamat_pegawai'));?>
                   </td>
                   <td rowspan="4">
                         <?php echo CHtml::label( $model->alamat_pegawai, $model->alamat_pegawai);?>                     
                   </td>
                   <td>
                          <?php echo CHtml::label($model->getAttributeLabel('propinsi_id'),$model->getAttributeLabel('propinsi_id'));?>
                   </td>
                   <td>
                          <?php echo CHtml::label( $model->propinsi->propinsi_nama,$model->propinsi->propinsi_nama);?>                     
                   </td>
             </tr>
             <tr>
                   <td>
                         <?php echo CHtml::label($model->getAttributeLabel('kabupaten_id'),$model->getAttributeLabel('kabupaten_id'));?>
                    </td>
                    <td>
                         <?php echo CHtml::label( $model->kabupaten->kabupaten_nama, $model->kabupaten->kabupaten_nama);?>                     

                    </td>
             </tr>
              <tr>
                   <td>
                         <?php echo CHtml::label($model->getAttributeLabel('kecamatan_id'),$model->getAttributeLabel('kecamatan_id'));?>
                    </td>
                    <td>
                         <?php echo CHtml::label( $model->kecamatan->kecamatan_nama, $model->kecamatan->kecamatan_nama);?>                     

                    </td>
             </tr>
             <tr>
                   <td>
                         <?php echo CHtml::label($model->getAttributeLabel('kelurahan_id'),$model->getAttributeLabel('kelurahan_id'));?>
                    </td>
                    <td>
                         <?php echo CHtml::label( $model->kelurahan->kelurahan_nama, $model->kelurahan->kelurahan_nama);?>                     

                    </td>
             </tr>
             <tr>
                      <td width="20%"> 
                           <?php echo CHtml::label($model->getAttributeLabel('notelp_pegawai'),$model->getAttributeLabel('notelp_pegawai'));?>
                      </td>
                      <td width="30%">
                             <?php echo CHtml::label($model->notelp_pegawai, $model->notelp_pegawai);?>    

                      </td>
                       <td width="20%"> 
                           <?php echo CHtml::label($model->getAttributeLabel('nomobile_pegawai'),$model->getAttributeLabel('nomobile_pegawai'));?>
                      </td>
                      <td width="30%">
                             <?php echo CHtml::label( $model->nomobile_pegawai, $model->nomobile_pegawai);?>                     
                      </td>
                </tr>
                 <tr>
                      <td width="20%"> 
                           <?php echo CHtml::label($model->getAttributeLabel('alamatemail'),$model->getAttributeLabel('alamatemail'));?>
                      </td>
                      <td width="30%" colspan="3">
                             <?php echo CHtml::label($model->alamatemail, $model->alamatemail);?>    

                      </td>
                      
                </tr>
                 
             
        </table>
</fieldset>
<?php
$this->widget('bootstrap.widgets.BootAlert'); ?>

<?php $this->widget('UserTips',array('type'=>'view'));?>