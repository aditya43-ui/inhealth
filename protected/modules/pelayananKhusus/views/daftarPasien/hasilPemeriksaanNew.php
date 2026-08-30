<?php  ?>
<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'hasilpmeriksaan-rehabMedis-form',
	'enableAjaxValidation'=>false,
        'enableClientValidation'=>false,
        'type'=>'horizontal',
        'focus'=>'#',
        'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)'),
));
?>
<?php 
	if(isset($_GET['sukses'])){
		Yii::app()->user->setFlash('success', "Data hasil pemeriksaan berhasil disimpan!");
		$this->widget('bootstrap.widgets.BootAlert');
	}
?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            Hasil Pemeriksaan
        </div>
    </div>
    <div class="panel-body">
    <?php
        $this->widget('bootstrap.widgets.BootAlert');
        $this->renderPartial('_formDataPasien',array('modPasienPenunjang'=>$modPasienPenunjang));
    ?>
    <table width="100%"  id="tblFormHasilPemeriksaanRE" class="table table-bordered table-condensed">
        <thead>
            <tr style="font-size:11pt">
                <!--<th>No. Urut Jadwal</th>-->
                <th>Tindakan</th>
                <th>Problematik Fisioterapi</th>
                <th>Dosis Tindakan/ Keterangan</th>
                <th>Evaluasi</th>
                <th>Peralatan Yang Digunakan</th>
                <th>&nbsp;</th>
            </tr>
        </thead>
        <?php foreach ($modHasilPemeriksaanrm as $i => $hasilpemeriksaan)  : 
            
                if (empty($hasilpemeriksaan->hasilpemeriksaanrm)){
                    $hasilpemeriksaan->hasilpemeriksaanrm = ""
                            . "<table width='100%'>"
                            . "     <tr>"
                            . "         <td>Impairment</td><td width='50%'></td>"
                            . "     </tr>"
                            . "     <tr>"
                            . "         <td>Functional Limitation</td><td></td>"
                            . "     </tr>"
                            . "     <tr>"
                            . "         <td>Disability</td><td></td>"
                            . "     </tr>"
                            . "     <tr>"
                            . "         <td>Syndroma</td><td></td>"
                            . "     </tr>"
                            . "</table>";
                }                
            ?>
        
            <tr id="jadwal_<?php echo $i; ?>">
<!--                <td>
					<?php // echo $jadwalKunjungan->nourutjadwal; ?>
				</td>-->
				<td style="font-size:11pt">
					<?php
					echo TindakanrmM::model()->with('jenistindakanrm')->findByPk($hasilpemeriksaan->tindakanrm_id)->jenistindakanrm->jenistindakanrm_nama.'</br>';
					echo '<b>'.TindakanrmM::model()->with('jenistindakanrm')->findByPk($hasilpemeriksaan->tindakanrm_id)->tindakanrm_nama.'</b></br>';
					?>
				</td>
				<td>
					<?php
					echo CHtml::hiddenField('HasilpemeriksaanrmT[hasilpemeriksaanrm_id][]',$hasilpemeriksaan->hasilpemeriksaanrm_id);
//                    echo CHtml::textArea('hasilpemeriksaanrm[hasilpemeriksaanrm][]',$hasilpemeriksaan->hasilpemeriksaanrm).'</br></br>';
					$this->widget('ext.redactorjs.Redactor',array('model'=>$hasilpemeriksaan,'attribute'=>'['.$i.']hasilpemeriksaanrm','name'=>'HasilpemeriksaanrmT_'.$i.'hasilpemeriksaanrm','toolbar'=>'mini','height'=>'200px'));
					?>
				</td>
				<td>
					<?php
//                    echo CHtml::textArea('hasilpemeriksaanrm[keteranganhasilrm][]',$hasilpemeriksaan->keteranganhasilrm).'</br></br>';  
					$this->widget('ext.redactorjs.Redactor',array('model'=>$hasilpemeriksaan,'attribute'=>'['.$i.']keteranganhasilrm','name'=>'HasilpemeriksaanrmT_'.$i.'keteranganhasilrm','toolbar'=>'mini','height'=>'200px'));
					?>
				</td>
				<td>
					<?php
//                    echo CHtml::textArea('hasilpemeriksaanrm[peralatandigunakan][]',$hasilpemeriksaan->peralatandigunakan).'</br></br>'; 
					$this->widget('ext.redactorjs.Redactor',array('model'=>$hasilpemeriksaan,'attribute'=>'['.$i.']evaluasi','name'=>'HasilpemeriksaanrmT_'.$i.'evaluasi','toolbar'=>'mini','height'=>'200px'));
					?>
				</td>
                <td>
                    <?php 
                    $hasilpemeriksaan->peralatandigunakan = CJSON::decode($hasilpemeriksaan->peralatandigunakan); 
                    $listPeralatan = LookupM::getItemsUrutan('peralatanfisioterapi');
                    
                    $listRes = array();
                    foreach($listPeralatan as $idx => $val) {
                        if (empty($idx)) {
                            continue;
                        }
                        
                        $listRes[$idx] = $val;
                    }
                    
                    
                    
                    ?>
                    <?php echo CHtml::activecheckBoxList($hasilpemeriksaan, '['.$i.']peralatandigunakan', $listRes, array('uncheckValue'=>null, 'onkeyup' => "return $(this).focusNextInputField(event);", "class"=>"", "onclick"=>"")); ?>
				</td>
			</tr>
        <?php endforeach; ?>
    </table>
    <div class='form-actions'>
         <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),
            array('class'=>'btn btn-primary', 'type'=>'submit', 
            'onKeypress'=>'return formSubmit(this,event)',
            'id'=>'btn_simpan',)); ?>
        
         <?php echo CHtml::link(Yii::t('mds','{icon} Kembali',array('{icon}'=>'<i class="icon-ban-circle icon-white"></i>')), 
            $this->createUrl('index'),
            array('class'=>'btn btn-danger',
                  'onclick'=>'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'));  ?>
        
        <?php
        if($caraPrint != 'PRINT'){
            echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}'=>'<i class="entypo-print"></i>')), '#', array('class'=>'btn btn-info', 'onclick'=>'print(\'PRINT\');')); 
        }
        ?>
    </div>
    <?php $this->endWidget(); ?>
</div>
</div>
<?php
$urlPrint=  Yii::app()->createAbsoluteUrl($this->module->id.'/'.$this->id.'/HasilPeriksaPrint', array("pendaftaran_id"=>$modPasienPenunjang->pendaftaran_id,"pasien_id"=>$modPasienPenunjang->pasien_id,"pasienmasukpenunjang_id"=>$modPasienPenunjang->pasienmasukpenunjang_id));
$js = <<< JSCRIPT
function print(caraPrint)
{
    if(caraPrint == 'PRINT'){
    window.open("${urlPrint}&caraPrint="+caraPrint,"",'location=_new, width=1024px');
    }
}
JSCRIPT;
Yii::app()->clientScript->registerScript('print',$js,  CClientScript::POS_HEAD);
?>
