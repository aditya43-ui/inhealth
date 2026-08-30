<?php
/**
* - digunakan sebagai format dasar hasil pemeriksan Foto THORAX PA
* 
* @author       M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
* @website      <piindonesia.co.id>
 *@wiki         <https://piiproject.atlassian.net/wiki/display/MDO>
*/

?>
<table width="100%"  id="tblFormHasilPemeriksaanRad" class="table table-bordered table-striped table-condensed">
        <thead>
            <tr>
                <th><div style="text-align: center; font-size: 11pt;"><?php echo CHtml::link("<i class='".MyIcon::getIcons('cetak')."'></i> Cetak",'javascript:;',array('rel'=>'tooltip','title'=>'Klik button/ikon ini, jika Anda ingin mencetak hasil pemeriksaan ini ', 'data-html'=>true,'onclick' => 'printPemeriksaaRad('.$hasil->hasilpemeriksaanrad_id.',\'PRINT\')', 'class' => 'btn btn-info', 'style'=>'color:#fff !important;')); ?></div></th>
                <th colspan="5"><div style="text-align: center; font-size: 11pt;"><a href="javascript:void(0);" onclick="ambilReferensi(<?php echo $hasil->pemeriksaanrad_id; ?>,<?php echo $i; ?>);return false;" rel="tooltip" title="Klik untuk hasil Referensi"><?php echo $hasil->pemeriksaanrad->jenispemeriksaanrad->jenispemeriksaanrad_nama; ?> : <?php echo $hasil->pemeriksaanrad->pemeriksaanrad_nama; ?></a></div></th>
            </tr>
        </thead>
        <tr>
            <td>&nbsp;</td>
            <td style="text-align:center;"><b><h4>Hasil Expertize</h4></b></td>
        </tr>
        <tr>
            <td style="font-size:10pt;vertical-align:middle;text-align: center">
                <?php echo CHtml::activeHiddenField($hasil, "[$i]hasilpemeriksaanrad_id", array('readonly'=>true)); ?>
                <?php echo CHtml::css('ul.redactor_toolbar{z-index:10;}'); ?>
                <b>Cor</b>
            </td>
            <td id="kolHasil_<?php echo $i;?>" style="text-align:center;">
                <?php // echo CHtml::activeTextArea($hasil, "[$i]hasilexpertise", array('rows'=>3, 'style'=>'width:750px; font-size:11pt;', 'onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
                <?php
                    $hasil->hasilexpertise = explode('{{pisah}}',$hasil->hasilexpertise);
    //            echo $i;                
                if ($i == 0) {                    
                    $this->widget('ext.redactorjs.Redactor',array('model'=>$hasil,  'id'=> 'ROHasilPemeriksaanRadT_'.$i.'_cor_hasilexpertise','attribute'=>'['.$i.']hasilexpertise[0]','name'=>'ROHasilPemeriksaanRadT_'.$i.'_hasilexpertise','toolbar'=>'mini','height'=>'300px'));
                } else {
                   $this->widget('ext.redactorjs.Redactor',array('model'=>$hasil,'id'=> 'ROHasilPemeriksaanRadT_'.$i.'_cor_hasilexpertise','attribute'=>'['.$i.']hasilexpertise[0]','name'=>'ROHasilPemeriksaanRadT_'.$i.'_hasilexpertise','toolbar'=>'mini','height'=>'300px'));
                }
                 ?>
            </td>
            <!--<td rowspan="2" style="text-align:center; vertical-align: middle;"><?php //echo CHtml::button('Referensi', array('onclick'=>"ambilReferensi($hasil->pemeriksaanrad_id,$i);return false;",'class'=>'btn btn-info','disabled'=>false, 'onkeypress'=>"return $(this).focusNextInputField(event)")); ?></td>-->
        </tr>
        <tr>
            <td style="font-size:10pt;vertical-align:middle;text-align: center">               
                <?php echo CHtml::css('ul.redactor_toolbar{z-index:10;}'); ?>
                <b>Pulmo</b>
            </td>
            <td id="kolHasil_<?php echo $i;?>" style="text-align:center;">
               <?php               
                if ($i == 0) {
                    $this->widget('ext.redactorjs.Redactor',array('id'=> 'ROHasilPemeriksaanRadT_'.$i.'_pulmo_hasilexpertise','model'=>$hasil,'attribute'=>'['.$i.']hasilexpertise[1]','name'=>'ROHasilPemeriksaanRadT_'.$i.'_hasilexpertise','toolbar'=>'mini','height'=>'300px'));
                } else {
                   $this->widget('ext.redactorjs.Redactor',array('id'=> 'ROHasilPemeriksaanRadT_'.$i.'_pulmo_hasilexpertise','model'=>$hasil,'attribute'=>'['.$i.']hasilexpertise[1]','name'=>'ROHasilPemeriksaanRadT_'.$i.'_hasilexpertise','toolbar'=>'mini','height'=>'300px'));
                }
                 ?>
            </td>            
        </tr>         
        <!--<tr>
            <td style="font-size:10pt; ">Kesan</td>
            <td id="kolKesan_<?php echo $i;?>" style="text-align:center;">: 
                <?php // echo CHtml::activeTextArea($hasil, "[$i]kesan_hasilrad", array('rows'=>3, 'style'=>'width:750px; font-size:11pt;', 'onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
                <?php $this->widget('ext.redactorjs.Redactor',array('model'=>$hasil,'attribute'=>'['.$i.']kesan_hasilrad','name'=>'ROHasilPemeriksaanRadT_'.$i.'_kesan_hasilrad','toolbar'=>'mini','height'=>'300px')) ?>
            </td>
        </tr>-->
        <tr>
            <td style="font-size:10pt;vertical-align:middle;text-align: center">Kesimpulan</td>
            <td id="kolKesimpulan_<?php echo $i;?>" style="text-align:center;">: 
                <?php // echo CHtml::activeTextArea($hasil, "[$i]kesimpulan_hasilrad", array('rows'=>3, 'style'=>'width:750px; font-size:11pt;', 'onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
                <?php $this->widget('ext.redactorjs.Redactor',array('model'=>$hasil,'attribute'=>'['.$i.']kesimpulan_hasilrad','name'=>'ROHasilPemeriksaanRadT_'.$i.'_kesimpulan_hasilrad','toolbar'=>'mini','height'=>'300px')) ?>
            </td>
        </tr>
    </table>