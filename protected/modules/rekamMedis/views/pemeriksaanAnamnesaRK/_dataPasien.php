<?php 
$this->widget('bootstrap.widgets.BootAlert'); 
$modPendaftaran->tgl_pendaftaran = '';//MyFormatter::formatDateTImeForUser($modPendaftaran->tgl_pendaftaran);
$modPasien->nama_pasien = '';//$modPasien->namadepan.$modPasien->nama_pasien;
?>
<?php

?>
<fieldset class="box" id="form-datakunjungan">    
    <table style="width: 100%; border: none;">
        <tr>
            <td>
                <?php echo CHtml::activeLabel($modPendaftaran, 'no_pendaftaran',array('class'=>'control-label')); ?></td>
            <td> 
                <?php echo  CHtml::activeHiddenField($modPendaftaran, 'pendaftaran_id',array('class'=>'control-label')); ?>
                <?php echo  CHtml::activeHiddenField($modPendaftaran, 'no_pendaftaran',array('class'=>'control-label')); ?>
                <?php 
                $this->widget('MyJuiAutoComplete', array(
                                'name'=>'no_pendaftaran',
                                'attribute'=>$modPendaftaran,
                                'source'=>'js: function(request, response) {
                                               $.ajax({
                                                   url: "'.$this->createUrl('AutocompleteKunjungan').'",
                                                   dataType: "json",
                                                   data: {
                                                       no_pendaftaran: request.term,
                                                       ruangan_id: $("#ruangan_id").val(),
                                                   },
                                                   success: function (data) {
                                                           response(data);
                                                   }
                                               })
                                            }',
                                 'options'=>array(
                                       'minLength' => 4,
                                        'focus'=> 'js:function( event, ui ) {
                                             $(this).val( "");
                                             return false;
                                         }',
                                       'select'=>'js:function( event, ui ) {
                                            $(this).val( ui.item.nama_pasien);
                                            setKunjungan(ui.item.pendaftaran_id);
                                            return false;
                                        }',
                                ),
                                'tombolDialog'=>array('idDialog'=>'dialogKunjungan'),
                                'htmlOptions'=>array('placeholder'=>'No. Pendaftaran','class'=>'all-caps','rel'=>'tooltip','title'=>'No. Pendaftaran',
                                    'onkeyup'=>"return $(this).focusNextInputField(event)",                                    
                                    ),
                            )); 
            ?></td>            
            
            <td><?php echo CHtml::activeLabel($modPasien, 'no_rekam_medik',array('class'=>'control-label')); ?></td>
            <td>
                <?php 
                $this->widget('MyJuiAutoComplete', array(
                                'name'=>'no_rekam_medik',
                                'attribute'=>$modPasien,
                                'source'=>'js: function(request, response) {
                                               $.ajax({
                                                   url: "'.$this->createUrl('AutocompleteKunjungan').'",
                                                   dataType: "json",
                                                   data: {
                                                       no_rekam_medik: request.term,
                                                       ruangan_id: $("#ruangan_id").val(),
                                                   },
                                                   success: function (data) {
                                                           response(data);
                                                   }
                                               })
                                            }',
                                 'options'=>array(
                                       'minLength' => 4,
                                        'focus'=> 'js:function( event, ui ) {
                                             $(this).val( "");
                                             return false;
                                         }',
                                       'select'=>'js:function( event, ui ) {
                                            $(this).val( ui.item.no_rekam_medik);
                                            setKunjungan(ui.item.pendaftaran_id);
                                            return false;
                                        }',
                                ),
                              //  'tombolDialog'=>array('idDialog'=>'dialogKunjungan'),
                                'htmlOptions'=>array('placeholder'=>'No. Pendaftaran','class'=>'all-caps','rel'=>'tooltip','title'=>'No. Pendaftaran',
                                    'onkeyup'=>"return $(this).focusNextInputField(event)",                                    
                                    ),
                            )); 
            ?>
            </td>
            <td rowspan="4">
                <?php 
                    if(!empty($modPasien->photopasien)){
                        echo CHtml::image(Params::urlPhotoPasienDirectory().$modPasien->photopasien, 'Foto pasien', array('width'=>120));
                    } else {
                        echo CHtml::image(Params::urlPhotoPasienDirectory().'no_photo.jpeg', 'Foto pasien', array('width'=>120));
                    }
                ?> 
            </td>
        </tr>
        <tr>
            <td><?php echo CHtml::activeLabel($modPendaftaran, 'tgl_pendaftaran',array('class'=>'control-label')); ?>                
            </td>
            <td><?php echo CHtml::activeTextField($modPendaftaran, 'tgl_pendaftaran', array('readonly'=>true)); ?></td>
            
            <td><?php echo CHtml::activeLabel($modPasien, 'nama_pasien',array('class'=>'control-label')); ?></td>
            <td>
                 <?php 
                $this->widget('MyJuiAutoComplete', array(
                                'name'=>'nama_pasien',
                                'attribute'=>$modPasien,
                                'source'=>'js: function(request, response) {
                                               $.ajax({
                                                   url: "'.$this->createUrl('AutocompleteKunjungan').'",
                                                   dataType: "json",
                                                   data: {
                                                       nama_pasien: request.term,
                                                       ruangan_id: $("#ruangan_id").val(),
                                                   },
                                                   success: function (data) {
                                                           response(data);
                                                   }
                                               })
                                            }',
                                 'options'=>array(
                                       'minLength' => 4,
                                        'focus'=> 'js:function( event, ui ) {
                                             $(this).val( "");
                                             return false;
                                         }',
                                       'select'=>'js:function( event, ui ) {
                                            $(this).val( ui.item.no_pendaftaran);
                                            setKunjungan(ui.item.pendaftaran_id);
                                            return false;
                                        }',
                                ),
                              //  'tombolDialog'=>array('idDialog'=>'dialogKunjungan'),
                                'htmlOptions'=>array('placeholder'=>'No. Pendaftaran','class'=>'all-caps','rel'=>'tooltip','title'=>'No. Pendaftaran',
                                    'onkeyup'=>"return $(this).focusNextInputField(event)",                                    
                                    ),
                            )); 
            ?>
            </td>
        </tr>
        <tr>
            <td><?php echo CHtml::activeLabel($modPendaftaran, 'umur',array('class'=>'control-label')); ?></td>
            <td><?php echo CHtml::activeTextField($modPendaftaran, 'umur', array('readonly'=>true)); ?></td>
            
            <td><?php echo CHtml::activeLabel($modPasien, 'jeniskelamin',array('class'=>'control-label')); ?></td>
            <td><?php echo CHtml::activeTextField($modPasien, 'jeniskelamin', array('readonly'=>true)); ?></td>
        </tr>
        <tr>
            <td><?php echo CHtml::activeLabel($modPendaftaran, 'jeniskasuspenyakit_id',array('class'=>'control-label')); ?></td>
            <td>
                <?php echo CHtml::activeTextField($modPendaftaran, 'jeniskasuspenyakit_nama', array('readonly'=>true)); ?>
                <?php echo CHtml::activeHiddenField($modPendaftaran, 'kelaspelayanan_id', array('readonly'=>true)); ?>
                <?php echo CHtml::activeHiddenField($modPendaftaran, 'carabayar_id', array('readonly'=>true)); ?>
            </td>
            
            <td><?php echo CHtml::activeLabel($modPendaftaran, 'cara bayar',array('class'=>'control-label')); ?></td>
            <td><?php echo CHtml::activeTextField($modPendaftaran, 'carabayar_nama', array('readonly'=>true)); ?></td>
        </tr>
        <tr>
            <td><?php echo CHtml::activeLabel($modPendaftaran, 'dokter_pemeriksa', array('class'=>'control-label')); ?></td>
            <td><?php echo CHtml::activeTextField($modPendaftaran, 'namaLengkap', array('readonly'=>true)); ?></td>

            <td><?php echo CHtml::activeLabel($modPendaftaran, 'penjamin', array('class'=>'control-label')); ?></td>
            <td><?php echo CHtml::activeTextField($modPendaftaran, 'penjamin_nama', array('readonly'=>true)); ?></td>
        </tr>

    </table>
</fieldset>
<div class="isContent">
<style>
    .table thead tr th{
        vertical-align: middle;
    }
</style>

<fieldset>
<!--<legend class="accord1" style="width:460px;"><?php // echo CHtml::checkBox('cekRiwayatPasien',false, array('onclick'=>'cekRiwayat(this);','onkeypress'=>"return $(this).focusNextInputField(event)")) ?> Riwayat Pasien </legend>
    <div id="divRiwayatPasien" class="control-group">
        <iframe src="" id="riwayatPasien" width="100%" height="100%">
        </iframe>        
    </div>-->
<?php /*$this->Widget('ext.bootstrap.widgets.BootAccordion',array(
	'id'=>'form-riwayat',
	'content'=>array(
		'content-detailpasien'=>array(
			'header'=>CHtml::htmlButton("<i class='icon-minus icon-white'></i>",array('class'=>'btn btn-primary btn-mini','onclick'=>'','onkeyup'=>"return $(this).focusNextInputField(event)",'rel'=>'tooltip','title'=>'Klik untuk tampilkan riwayat pasien')).'<b>Riwayat Pasien</b>',
			'isi'=>'<iframe src="" id="riwayatPasien" style="width:100%; height: 98%;"></iframe>',
			'active'=>false,
			),   
		),
)); */ ?>
</fieldset>

</div>
<?php

?>

<?php
//========= Dialog Detail Hasil Pemeriksaaan Lab =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogDetailHasilLab',
    'options' => array(
        'title' => 'Data Hasil Pemeriksaan',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'height' => 500,
        'resizable' => false,
    ),
));
?>
<iframe src="" name="pesan" style="width: 100%; height: 98%;"></iframe>
<?php
$this->endWidget();
//=======================================================================
?>

<?php
//========= Dialog Detail Tindakan, Terapi dan Pemakaian Bahan =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogDetailData',
    'options' => array(
        'title' => 'Detail Data',
        'autoOpen' => false,
        'modal' => true,
        'width' => 600,
        'height' => 500,
        'resizable' => false,
    ),
));
?>
<iframe src="" name="detailDialog" style="width: 100%; height: 98%;"></iframe>
<?php
$this->endWidget();
?>

<?php 
//========= Dialog buat cari data pendaftaran / kunjungan =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'dialogKunjungan',
    'options'=>array(
        'title'=>'Pencarian Data Kunjungan Pasien ',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>980,
        'height'=>480,
        'resizable'=>false,
    ),
));
    $modDialogKunjungan = new RKPendaftaranT('searchDialogKunjungan');
    $modDialogKunjungan->unsetAttributes();
    //$modDialogKunjungan->ruangan_id = Yii::app()->user->getState('ruangan_id');
    if(isset($_GET['RKPendaftaranT'])) {
        $modDialogKunjungan->attributes = $_GET['RKPendaftaranT'];
        $modDialogKunjungan->no_rekam_medik = $_GET['RKPendaftaranT']['no_rekam_medik'];
        $modDialogKunjungan->nama_pasien = $_GET['RKPendaftaranT']['nama_pasien'];
        $modDialogKunjungan->jeniskelamin = $_GET['RKPendaftaranT']['jeniskelamin'];
    }

    $this->widget('ext.bootstrap.widgets.BootGridView',array(
            'id'=>'datakunjungan-grid',
            'dataProvider'=>$modDialogKunjungan->searchDialogKunjungan(),
            'filter'=>$modDialogKunjungan,
            'template'=>"{summary}\n{items}\n{pager}",
            'itemsCssClass'=>'table table-striped table-bordered table-condensed',
            'columns'=>array(
                    array(
                        'header'=>'Pilih',
                        'type'=>'raw',
                        'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","javascript:void(0);",array("class"=>"btn-small", 
                                        "id" => "selectKunjungan",
                                        "onClick" => "
                                            setKunjungan($data->pendaftaran_id);
                                            $(\"#dialogKunjungan\").dialog(\"close\");
                                        "))',
                    ),                    
                    array(
                        'name'=>'tgl_pendaftaran',
                        'type'=>'raw',
                        'value'=>'MyFormatter::formatDateTimeForUser($data->tgl_pendaftaran)',
                        'filter'=> false,
                    ),
                    array(
                        'header' => 'No. Pendaftaran',
                        'name' => 'no_pendaftaran',
                        'value' => '$data->no_pendaftaran',
                    ),                    
                    array(
                        'header' => 'No. Rekam Medik',
                        'name' => 'no_rekam_medik',
                        'value' => '$data->pasien->no_rekam_medik',
                    ),                    
                    array(
                        'name'=>'nama_pasien',
                        'value'=>'$data->pasien->namadepan." ".$data->pasien->nama_pasien',
                    ), 
                    array(
                        'header' => 'Jenis Kelamin',
                        'name' => 'jeniskelamin',
                        'value' => '$data->pasien->jeniskelamin',
                        'type'=>'raw',
                        'filter'=> CHtml::dropDownList('RKPendaftaranT[jeniskelamin]',$modDialogKunjungan->jeniskelamin,LookupM::model()->getItems('jeniskelamin'),array('empty'=>'-- Pilih --')),
                    ),
                    // 'instalasi_nama',
                    // 'ruangan_nama',
                    array(
                        'name'=>'carabayar_id',
                        'type'=>'raw',
                        'value'=>'$data->carabayar->carabayar_nama',
                        'filter'=> CHtml::dropDownList('RKPendaftaranT[carabayar_id]',$modDialogKunjungan->carabayar_id,CHtml::listData(CarabayarM::model()->findAll("carabayar_aktif = TRUE ORDER BY carabayar_nama ASC"),'carabayar_id','carabayar_nama'),array('empty'=>'-- Pilih --')),
                    ),

            ),
            'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
    ));

$this->endWidget();
////======= end pendaftaran dialog =============
?>
