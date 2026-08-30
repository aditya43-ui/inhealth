<?php 
if($caraPrint=='EXCEL')
{
	header('Content-Type: application/vnd.ms-excel');
	  header('Content-Disposition: attachment;filename="'.$judulLaporan.'-'.date("Y/m/d").'.xls"');
	  header('Cache-Control: max-age=0');     
}
if($caraPrint){
	echo $this->renderPartial('application.views.headerReport.headerDefault',array('judulLaporan'=>$judulLaporan));           
}
?>
<div class="block-tabel">
    <h6>Data <b>Pegawai</b></h6>
        <table style="width: 100%" class="table table-striped table-bordered table-condensed">
              <tr>
                     <td rowspan="7" align="center"> 
                         <img src="<?php echo Params::urlPegawaiTumbsDirectory().'kecil_'.$modPegawai->photopegawai ?> ">     

                    </td>
              </tr>
              <tr>
                      <td width="20%"> 
                           <?php echo CHtml::label($modPegawai->getAttributeLabel('nama_pegawai'),$modPegawai->getAttributeLabel('nama_pegawai'));?>
                      </td>
                      <td width="30%" colspan="2">
                            <?php echo (!empty($modPegawai->gelardepan) && !empty($modPegawai->gelarbelakang_id) ? CHtml::label($modPegawai->gelardepan.' '.$modPegawai->nama_pegawai.' '.$modPegawai->gelarbelakang->gelarbelakang_nama,  $modPegawai->gelardepan.' '.$modPegawai->nama_pegawai.' '.$modPegawai->gelarbelakang->gelarbelakang_nama):$modPegawai->nama_pegawai);?>                  
                       </td>
                      
                </tr>
                <tr>
                      <td width="20%"> 
                           <?php echo CHtml::label($modPegawai->getAttributeLabel('kategoripegawaiasal'),$modPegawai->getAttributeLabel('kategoripegawaiasal'));?>
                      </td>
                      <td width="30%"  colspan="2">
                             <?php echo CHtml::label($modPegawai->kategoripegawaiasal, $modPegawai->kategoripegawaiasal);?>                   
                      </td>
                       
                </tr>
                <tr>
                      <td width="20%"> 
                           <?php echo CHtml::label($modPegawai->getAttributeLabel('kelompokpegawai_id'),$modPegawai->getAttributeLabel('kelompokpegawai_id'));?>
                      </td>
                      <td width="30%" colspan="2">
                             <?php echo (!empty($modPegawai->kelompokpegawai_id) ? CHtml::label($modPegawai->kelompokpegawai->kelompokpegawai_nama, $modPegawai->kelompokpegawai->kelompokpegawai_nama):"");?>                   
                      </td>
                      
                </tr>
                <tr>
                      <td width="20%"> 
                           <?php echo CHtml::label($modPegawai->getAttributeLabel('no_taspen'),$modPegawai->getAttributeLabel('no_taspen'));?>
                      </td>
                      <td width="30%" colspan="2">
                             <?php echo CHtml::label($modPegawai->no_taspen, $modPegawai->no_taspen);?>                   
                      </td>
                      
                </tr>
                <tr>
                     <td width="20%"> 
                           <?php echo CHtml::label($modPegawai->getAttributeLabel('nomorindukpegawai'),$modPegawai->getAttributeLabel('nomorindukpegawai'));?>
                      </td>
                      <td width="30%" colspan="2">
                             <?php echo CHtml::label( $modPegawai->nomorindukpegawai, $modPegawai->nomorindukpegawai);?>                     
                      </td>
                      
                </tr>
                <tr>
                     <td width="20%"> 
                           <?php echo CHtml::label($modPegawai->getAttributeLabel('no_kartupegawainegerisipil'),$modPegawai->getAttributeLabel('no_kartupegawainegerisipil'));?>
                      </td>
                      <td width="30%" colspan="2">
                             <?php echo CHtml::label( $modPegawai->no_kartupegawainegerisipil, $modPegawai->no_kartupegawainegerisipil);?>                     
                      
                    </td>
                      
               
                    
                </tr>
                <tr>
                      
                    <td width="20%"> 
                           <?php echo CHtml::label($modPegawai->getAttributeLabel('kategoripegawai'),$modPegawai->getAttributeLabel('kategoripegawai'));?>
                      </td>
                      <td width="30%">
                             <?php echo CHtml::label( $modPegawai->kategoripegawai, $modPegawai->kategoripegawai);?>                     
                      </td>  
                      <td width="20%"> 
                           <?php echo CHtml::label($modPegawai->getAttributeLabel('warganegara_pegawai'),$modPegawai->getAttributeLabel('warganegara_pegawai'));?>
                      </td>
                      <td width="30%">
                             <?php echo CHtml::label($modPegawai->warganegara_pegawai, $modPegawai->warganegara_pegawai);?>                   
                      </td>
                      
                       
                </tr>
                <tr>
                      <td width="20%"> 
                           <?php echo CHtml::label($modPegawai->getAttributeLabel('no_karis_karsu'),$modPegawai->getAttributeLabel('no_karis_karsu'));?>
                      </td>
                      <td width="30%">
                             <?php echo CHtml::label($modPegawai->no_karis_karsu, $modPegawai->no_karis_karsu);?>                   
                      </td>
                       <td width="20%"> 
                           <?php echo CHtml::label($modPegawai->getAttributeLabel('jeniswaktukerja'),$modPegawai->getAttributeLabel('jeniswaktukerja'));?>
                      </td>
                      <td width="30%">
                             <?php echo CHtml::label( $modPegawai->jeniswaktukerja, $modPegawai->jeniswaktukerja);?>                     
                      </td>
                </tr>
                <tr>
                      <td width="20%"> 
                           <?php echo CHtml::label($modPegawai->getAttributeLabel('pangkat_id'),$modPegawai->getAttributeLabel('pangkat_id'));?>
                      </td>
                      <td width="30%">
                             <?php echo (!empty($modPegawai->pangkat_id) ? CHtml::label($modPegawai->pangkat->pangkat_nama, $modPegawai->pangkat->pangkat_nama):"");?>                   
                      </td>
                   
                       <td width="20%"> 
                           <?php echo CHtml::label($modPegawai->getAttributeLabel('jabatan_id').'/'.$modPegawai->getAttributeLabel('kelompokjabatan'),$modPegawai->getAttributeLabel('jabatan_id').'/'.$modPegawai->getAttributeLabel('kelompokjabatan'));?>
                      </td>
                      <td width="30%">
                             <?php echo (!empty($modPegawai->jabatan_id) ? CHtml::label($modPegawai->jabatan->jabatan_nama.'/'.$modPegawai->kelompokjabatan, $modPegawai->jabatan->jabatan_nama.'/'.$modPegawai->kelompokjabatan):"");?>                     
                      </td>
                </tr>
               
                <tr>
                      <td width="20%"> 
                           <?php echo CHtml::label($modPegawai->getAttributeLabel('nama_keluarga'),$modPegawai->getAttributeLabel('nama_keluarga'));?>
                      </td>
                      <td width="30%">
                             <?php echo CHtml::label($modPegawai->nama_keluarga, $modPegawai->nama_keluarga);?>                   
                      </td>
                       <td width="20%"> 
                           <?php echo CHtml::label($modPegawai->getAttributeLabel('statusperkawinan'),$modPegawai->getAttributeLabel('statusperkawinan'));?>
                      </td>
                      <td width="30%">
                             <?php echo CHtml::label( $modPegawai->statusperkawinan, $modPegawai->statusperkawinan);?>                     
                      </td>
                </tr>
                <tr>
                      <td width="20%"> 
                           <?php echo CHtml::label($modPegawai->getAttributeLabel('tempatlahir_pegawai'),$modPegawai->getAttributeLabel('tempatlahir_pegawai'));?>
                      </td>
                      <td width="30%">
                             <?php echo CHtml::label($modPegawai->tempatlahir_pegawai, $modPegawai->tempatlahir_pegawai);?>                   
                      </td>
                       <td width="20%"> 
                           <?php echo CHtml::label($modPegawai->getAttributeLabel('tgl_lahirpegawai'),$modPegawai->getAttributeLabel('tgl_lahirpegawai'));?>
                      </td>
                      <td width="30%">
                             <?php echo CHtml::label( $modPegawai->tgl_lahirpegawai, $modPegawai->tgl_lahirpegawai);?>                     
                      </td>
                </tr>
                 <tr>
                      <td width="20%"> 
                           <?php echo CHtml::label($modPegawai->getAttributeLabel('agama'),$modPegawai->getAttributeLabel('agama'));?>
                      </td>
                      <td width="30%">
                             <?php echo CHtml::label($modPegawai->agama, $modPegawai->agama);?>                   
                      </td>
                       <td width="20%"> 
                           <?php echo CHtml::label($modPegawai->getAttributeLabel('suku_id'),$modPegawai->getAttributeLabel('suku_id'));?>
                      </td>
                      <td width="30%">
                             <?php echo (!empty($modPegawai->suku_id) ? CHtml::label($modPegawai->suku->suku_nama,$modPegawai->suku->suku_nama):"");?>                     
                      </td>
                </tr>
                <tr>
                      <td width="20%"> 
                           <?php echo CHtml::label($modPegawai->getAttributeLabel('pendidikan_id'),$modPegawai->getAttributeLabel('pendidikan_id'));?>
                      </td>
                      <td width="30%">
                             <?php echo (!empty($modPegawai->pendidikan_id) ? CHtml::label($modPegawai->pendidikan->pendidikan_nama, $modPegawai->pendidikan->pendidikan_nama):"");?>                   
                      </td>
                       <td width="20%"> 
                           <?php echo CHtml::label($modPegawai->getAttributeLabel('pendkualifikasi_id'),$modPegawai->getAttributeLabel('pendkualifikasi_id'));?>
                      </td>
                      <td width="30%">
                             <?php echo (!empty($modPegawai->pendkualifikasi_id) ? CHtml::label($modPegawai->pendkualifikasi->pendkualifikasi_nama, $modPegawai->pendkualifikasi->pendkualifikasi_nama):"");?>                     
                      </td>
                </tr>
               
        </table>        
</div>
<div class="block-tabel">
    <h6>Tabel <b>Pengangkatan TPHL</b></h6>
        <table style="width: 100%" class="table table-striped table-bordered table-condensed">
             <tr>
                   <td width="20%">
                          <?php echo CHtml::label($model->getAttributeLabel('pengangkatantphl_noperjanjian'),$model->getAttributeLabel('pengangkatantphl_noperjanjian')); ?>
                   </td>
                   <td width="30%">
                          <?php echo CHtml::label($model->pengangkatantphl_noperjanjian,$model->pengangkatantphl_noperjanjian);?>                     
                   </td>
                   
                   <td width="20%">
                          <?php echo CHtml::label($model->getAttributeLabel('pengangkatantphl_tmt'),$model->getAttributeLabel('pengangkatantphl_tmt')); ?>
                   </td>
                   <td width="30%">
                          <?php echo CHtml::label($model->pengangkatantphl_tmt,$model->pengangkatantphl_tmt);?>                     
                   </td>
             </tr>
             <tr>
                    <td width="20%">
                         <?php echo CHtml::label($model->getAttributeLabel('pengangkatantphl_tugaspekerjaan'),$model->getAttributeLabel('pengangkatantphl_tugaspekerjaan')); ?>
                    </td>
                    <td width="30%"> 
                         <?php echo CHtml::label( $model->pengangkatantphl_tugaspekerjaan, $model->pengangkatantphl_tugaspekerjaan);?>                     

                    </td>
                    
                    <td width="20%">
                          <?php echo CHtml::label($model->getAttributeLabel('pengangkatantphl_nosk'),$model->getAttributeLabel('pengangkatantphl_nosk')); ?>
                   </td>
                   <td width="30%">
                          <?php echo CHtml::label($model->pengangkatantphl_nosk,$model->pengangkatantphl_nosk);?>                     
                   </td>
             </tr>
              <tr>
                   <td width="20%">
                         <?php echo CHtml::label($model->getAttributeLabel('pengangkatantphl_tglsk'),$model->getAttributeLabel('pengangkatantphl_tglsk')); ?>
                    </td>
                    <td>
                         <?php echo CHtml::label( $model->pengangkatantphl_tglsk, $model->pengangkatantphl_tglsk);?>                     

                    </td>
                    
                    <td width="20%">
                          <?php echo CHtml::label($model->getAttributeLabel('pengangkatantphl_tmtsk'),$model->getAttributeLabel('pengangkatantphl_tmtsk')); ?>
                   </td>
                   <td width="30%">
                          <?php echo CHtml::label($model->pengangkatantphl_tmtsk,$model->pengangkatantphl_tmtsk);?>                     
                   </td>
             </tr>
             <tr>
                   <td width="20%">
                         <?php echo CHtml::label($model->getAttributeLabel('pengangkatantphl_noskterakir'),$model->getAttributeLabel('pengangkatantphl_noskterakhir')); ?>
                    </td>
                    <td width="30%">
                         <?php echo CHtml::label( $model->pengangkatantphl_noskterakhir, $model->pengangkatantphl_noskterakhir);?>                     

                    </td>
                    
                    <td width="20%">
                          <?php echo CHtml::label($model->getAttributeLabel('pengangkatantphl_keterangan'),$model->getAttributeLabel('pengangkatantphl_keterangan')); ?>
                   </td>
                   <td width="30%">
                          <?php echo CHtml::label($model->pengangkatantphl_keterangan,$model->pengangkatantphl_keterangan);?>                     
                   </td>
             </tr>
        </table>
</div>
<?php if(!isset($caraPrint)){ ?>
<div class="form-actions">
        <?php 
		echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="entypo-print"></i>')),array('class'=>'btn btn-info', 'type'=>'button','onclick'=>'print(\'PRINT\')')); 
		echo CHtml::htmlButton(Yii::t('mds','{icon} PDF',array('{icon}'=>'<i class="entypo-book"></i>')),array('class'=>'btn btn-info', 'type'=>'button','onclick'=>'print(\'PDF\')')); 
        echo CHtml::htmlButton(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="entypo-doc-text"></i>')),array('class'=>'btn btn-info', 'type'=>'button','onclick'=>'print(\'EXCEL\')')); 
		$content = $this->renderPartial('../tips/master',array(),true);
		$this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
		?>	
	</div>
    <?php 
        $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
        $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
        $urlPrint=  Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/Detail&pengangkatantphl_id='.$model->pengangkatantphl_id.'&pegawai_id='.$modPegawai->pegawai_id);

$js = <<< JSCRIPT
function print(caraPrint)
{
    window.open("${urlPrint}"+$('#kppengangkatantphl-t-form').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
}   
JSCRIPT;
Yii::app()->clientScript->registerScript('print',$js,CClientScript::POS_HEAD);  

?>
<?php } ?>