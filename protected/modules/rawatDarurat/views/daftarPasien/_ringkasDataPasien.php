<?php 

$this->widget('bootstrap.widgets.BootAlert'); 
$modPendaftaran->tgl_pendaftaran = MyFormatter::formatDateTimeForUser($modPendaftaran->tgl_pendaftaran);
$modPasien->nama_pasien = $modPasien->namadepan.$modPasien->nama_pasien;

?>

<div class="col-sm-6">
	<div class="control-group">
		<?php echo CHtml::activeLabel($modPendaftaran, 'tgl_pendaftaran',array('class'=>'control-label')); ?>
		<div class="controls">
			<?php echo CHtml::activeTextField($modPendaftaran,'tgl_pendaftaran', array('readonly'=>true, 'onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
            <?php echo CHtml::activeHiddenField($modPendaftaran, 'pendaftaran_id',  array('readonly'=>true, 'onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
		</div>
	</div>
	<div class="control-group">
		<?php echo CHtml::activeLabel($modPendaftaran, 'no_pendaftaran',array('class'=>'control-label')); ?>
		<div class="controls">
			<?php echo CHtml::activeTextField($modPendaftaran,'no_pendaftaran', array('readonly'=>true, 'onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
		</div>
	</div>
	<div class="control-group">
		<?php echo CHtml::activeLabel($modPendaftaran, 'umur',array('class'=>'control-label')); ?>
		<div class="controls">
			<?php echo CHtml::activeTextField($modPendaftaran, 'umur', array('readonly'=>true, 'onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
		</div>
	</div>
	<div class="control-group">
		<?php echo CHtml::activeLabel($modPendaftaran, 'jeniskasuspenyakit_id',array('class'=>'control-label')); ?>
		<div class="controls">
			<?php echo CHtml::textField('jeniskasuspenyakit_nama', empty($modPendaftaran->jeniskasuspenyakit_id) ? "-":$modPendaftaran->jeniskasuspenyakit->jeniskasuspenyakit_nama,array('readonly'=>true)); ?>
		</div>
	</div>
	<div class="control-group">
		<?php echo CHtml::activeLabel($modPendaftaran, 'instalasi_id',array('class'=>'control-label')); ?>
		<div class="controls">
			<?php echo CHtml::textField('instalasi_nama', empty($modPendaftaran->instalasi_id) ? "-" : $modPendaftaran->instalasi->instalasi_nama,array('readonly'=>true)); ?>
            <?php echo CHtml::activeHiddenField($modPendaftaran, 'instalasi_id',  array('readonly'=>true, 'onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
		</div>
	</div>
	<div class="control-group">
		<?php echo CHtml::activeLabel($modPendaftaran, 'ruangan_id',array('class'=>'control-label')); ?>
		<div class="controls">
			<?php echo CHtml::textField('ruangan_nama', ((empty($modPendaftaran->ruangan->ruangan_nama)) ? "-" : $modPendaftaran->ruangan->ruangan_nama), array('readonly'=>true, 'onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
			<?php echo CHtml::activeHiddenField($modPendaftaran, 'ruangan_id',array('readonly'=>true, 'onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
		</div>
	</div>
</div>
<div class="col-sm-6">
	<div class="control-group">
		<div class="control-label">   <label class="no_rek" for="noRekamMedik">No. Rekam Medik</label></div>
		<div class="controls">
			<?php if (!empty($modPasien->no_rekam_medik)) { 
                    echo CHtml::activeTextField($modPasien,'no_rekam_medik', array('readonly'=>true));
                    }else{
                        echo CHtml::activeHiddenField($modPasien, 'pasien_id',  array('readonly'=>true, 'onkeypress'=>"return $(this).focusNextInputField(event)"));
                        $this->widget('MyJuiAutoComplete', array(
                            'model'=>$modPasien,
                            'attribute'=>'no_rekam_medik',
                            'source'=>'js: function(request, response) {
                                           $.ajax({
                                               url: "'.Yii::app()->createUrl('ActionAutoComplete/NoRmPasienRawatDarurat').'",
                                               dataType: "json",
                                               data: {
                                                   term: request.term,
                                                   
                                               },
                                               success: function (data) {
                                                       response(data);
                                               }
                                           })
                                        }',
                             'options'=>array(
                                   'showAnim'=>'fold',
                                   'minLength' => 2,
                                   'focus'=> 'js:function( event, ui ) {
                                        $(this).val(ui.item.value);
                                        
                                        return false;
                                    }',
                                   'select'=>'js:function( event, ui ) {
                                        isiDataPasien(ui.item);
                                        $("#RDPasienPulangT_lamarawat").val(ui.item.lama_rawat);
                                        return false;
                                    }',
                            ),
                            'tombolDialog'=>array('idDialog'=>'dialogPendaftaran','idTombol'=>'tombolPasienDialog'),
                            'htmlOptions'=>array('class'=>'span2', 'placeholder'=>'No. Rekam Medik','onkeypress'=>"return $(this).focusNextInputField(event)"),
                        )); 
                    }
                ?>
		</div>
	</div>
	<div class="control-group">
		<div class="control-label">   <label class="no_rek" for="namaPasien">Nama Pasien</label></div>
		<div class="controls">
			<?php 
                    if (!empty($modPasien->pasien_id)) { 
                        echo CHtml::activeTextField($modPasien, 'nama_pasien', array('readonly'=>true));
                    }else{
                    $this->widget('MyJuiAutoComplete', array(
                                    'model'=>$modPasien,
                                    'attribute'=>'nama_pasien',
                                    'source'=>'js: function(request, response) {
                                                   $.ajax({
                                                       url: "'.Yii::app()->createUrl('ActionAutoComplete/NamaPasienRawatDarurat').'",
                                                       dataType: "json",
                                                       data: {
                                                           term: request.term,
                                                           
                                                       },
                                                       success: function (data) {
                                                               response(data);
                                                       }
                                                   })
                                                }',
                                     'options'=>array(
                                           'showAnim'=>'fold',
                                           'minLength' => 2,
                                           'focus'=> 'js:function( event, ui ) {
                                                $(this).val(ui.item.value);
                                                return false;
                                            }',
                                           'select'=>'js:function( event, ui ) {
                                                isiDataPasien(ui.item);
                                                $("#RDPasienM_no_rekam_medik").val(ui.item.no_rekam_medik);
                                                $("#PasienpulangT_lamarawat").val(ui.item.lama_rawat);
                                                return false;
                                            }',
                                    ),
                                    'htmlOptions'=>array('class'=>'span3', 'placeholder'=>'Nama Pasien','style'=>'width:200px;','onkeypress'=>"return $(this).focusNextInputField(event)"),
                                )); 
                    }
                ?>
		</div>
	</div>
	<div class="control-group">
		<?php echo CHtml::activeLabel($modPasien, 'jeniskelamin',array('class'=>'control-label')); ?>
		<div class="controls">
			<?php echo CHtml::activeTextField($modPasien,'jeniskelamin', array('readonly'=>true, 'onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
		</div>
	</div>
	<div class="control-group">
		<?php echo CHtml::activeLabel($modPasien, 'nama_bin',array('class'=>'control-label')); ?>
		<div class="controls">
			<?php echo CHtml::activeTextField($modPasien, 'nama_bin', array('readonly'=>true, 'onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
		</div>
	</div>
	<div class="control-group">
		<?php echo CHtml::activeLabel($modPendaftaran, 'carabayar_id',array('class'=>'control-label')) ?>
		<div class="controls">
			<?php echo CHtml::textField('carabayar_nama', empty($modPendaftaran->carabayar_id) ? "-" : $modPendaftaran->carabayar->carabayar_nama, array('readonly'=>true)); ?>
			<?php echo CHtml::activeHiddenField($modPendaftaran, 'carabayar_id', array('readonly'=>true)); ?>
		</div>
	</div>
	<div class="control-group">
		<?php echo CHtml::activeLabel($modPendaftaran, 'penjamin_id',array('class'=>'control-label')) ?>
		<div class="controls">
			<?php echo CHtml::textField('penjamin_nama', (empty($modPendaftaran->penjamin->penjamin_nama) ? "-" : $modPendaftaran->penjamin->penjamin_nama), array('readonly'=>true)); ?>
			<?php echo CHtml::activeHiddenField($modPendaftaran, 'penjamin_id', array('readonly'=>true)); ?>
			<?php echo CHtml::activeHiddenField($modPendaftaran, 'kelaspelayanan_id', array('readonly'=>true)); ?>
		</div>
	</div>
    <?php if (Yii::app()->user->getState('isbridging') == true && $modPendaftaran->carabayar_id == Params::CARABAYAR_ID_BPJS): ?>
    <div class="control-group">
		<?php echo CHtml::label('No. SEP', '',array('class'=>'control-label')) ?>
		<div class="controls">
			<?php 
            $sep = SepT::model()->findByPk($modPendaftaran->sep_id);
            $no_sep = "";
            if (!empty($sep)) {
                $no_sep = $sep->nosep;
            }
            echo CHtml::textField('no_sep', $no_sep, array('readonly'=>true));   ?>
		</div>
	</div>
    <?php endif; ?>
</div>

<div class="clearfix"></div>

<?php 
//========= Dialog buat cari data pendaftaran =========================

$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'dialogPendaftaran',
    'options'=>array(
        'title'=>'Pencarian Data Pasien',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>900,
        'height'=>540,
        'resizable'=>false,
    ),
));
$format = new MyFormatter();
$modPendaftaran = new RDPendaftaranT('searchPasienRD');
$modPendaftaran->unsetAttributes();
if(isset($_GET['RDPendaftaranT'])) {
    $modPendaftaran->attributes = $_GET['RDPendaftaranT'];
    $modPendaftaran->noRm = $_GET['RDPendaftaranT']['noRm'];
    $modPendaftaran->namaPasien = $_GET['RDPendaftaranT']['namaPasien'];
    $modPendaftaran->tgl_pendaftaran_cari = $_GET['RDPendaftaranT']['tgl_pendaftaran_cari'];
    $modPendaftaran->namaInstalasi = $_GET['RDPendaftaranT']['namaInstalasi'];
    $modPendaftaran->namaRuangan = $_GET['RDPendaftaranT']['namaRuangan'];
    $modPendaftaran->namaCarabayar = $_GET['RDPendaftaranT']['namaCarabayar'];
}
$this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'pendaftaran-t-grid',
	'dataProvider'=>$modPendaftaran->searchPasienRD(),
	'filter'=>$modPendaftaran,
        'template'=>"{summary}\n{items}\n{pager}",
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
                array(
                    'header'=>'Pilih',
                    'type'=>'raw',
                    'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","javascript:void(0);",array("class"=>"btn-small", 
                                    "id" => "selectPendaftaran",
                                    "onClick" => "
                                        $(\"#dialogPendaftaran\").dialog(\"close\");
                                        $(\"#RDPendaftaranT_tgl_pendaftaran\").val(\"$data->tgl_pendaftaran\");
                                        $(\"#RDPendaftaranT_no_pendaftaran\").val(\"$data->no_pendaftaran\");
                                        $(\"#RDPendaftaranT_umur\").val(\"$data->umur\");
                                        $(\"#RDPendaftaranT_pendaftaran_id\").val(\"$data->pendaftaran_id\");
                                        $(\"#PasienpulangT_pendaftaran_id\").val(\"$data->pendaftaran_id\");
                                        $(\"#RDPendaftaranT_carabayar_id\").val(\"$data->carabayar_id\");
                                        $(\"#RDPendaftaranT_penjamin_id\").val(\"$data->penjamin_id\");
                                        $(\"#RDPendaftaranT_kelaspelayanan_id\").val(\"$data->kelaspelayanan_id\");
                                        $(\"#RDPasienM_pasien_id\").val(\"$data->pasien_id\");
                                        $(\"#PasienpulangT_pasien_id\").val(\"$data->pasien_id\");
                                        $(\"#RDPasienM_jeniskelamin\").val(\"$data->PasienJenisKelamin\");
                                        $(\"#RDPasienM_no_rekam_medik\").val(\"$data->PasienNoRm\");
                                        $(\"#RDPasienM_nama_pasien\").val(\"$data->PasienNama\");
                                        $(\"#RDPasienM_nama_bin\").val(\"$data->PasienAlias\");
                                        $(\"#carabayar_nama\").val(\"$data->CarabayarNama\");
                                        $(\"#penjamin_nama\").val(\"$data->PenjaminNama\");
                                        $(\"#jeniskasuspenyakit_nama\").val(\"$data->JenisKasusPenyakitNama\");
                                        $(\"#instalasi_nama\").val(\"$data->InstalasiNama\");
                                        $(\"#ruangan_nama\").val(\"$data->RuanganNama\");
                                        $(\"#PasienpulangT_lamarawat\").val(\"$data->LamaRawat\");
                                    "))',
                ),
                array(
                    'name'=>'pasien.no_rekam_medik',
                    'type'=>'raw',
                    'filter'=>  CHtml::activeTextField($modPendaftaran, 'noRm'),
                ),
                array(
                    'name'=>'pasien.nama_pasien',
                    'type'=>'raw',
                    'filter'=>  CHtml::activeTextField($modPendaftaran, 'namaPasien'),
                ),
                'pasien.jeniskelamin',
                'no_pendaftaran',
                array(
                    'name'=>'tgl_pendaftaran',
                    'filter'=> 
                    CHtml::activeTextField($modPendaftaran, 'tgl_pendaftaran_cari', array('placeholder'=>'contoh: 15 Jan 2013')),
                ),
                array(
                    'header'=>'Jenis Penjamin',
                    'name'=>'carabayar.carabayar_nama',
                    'type'=>'raw',
                    'filter'=>  CHtml::activeTextField($modPendaftaran, 'namaCarabayar'),
                ),
                array(
               //'statusperiksa',
           'name'=>'statusperiksa',
            'type'=>'raw',
           // 'filter'=>  CHtml::listData(RDPendaftaranT ::model()->findAll(),'statusperiksa','statusperiksa'),
//             'value'=>'statusperiksa',
                    ),
                
                
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
));

$this->endWidget();

//========= end pendaftaran dialog =============================    
?>

<script type="text/javascript">
function isiDataPasien(data)
{
    $("#RDPendaftaranT_tgl_pendaftaran").val(data.tgl_pendaftaran);
    $("#RDPendaftaranT_no_pendaftaran").val(data.no_pendaftaran);
    $("#RDPendaftaranT_umur").val(data.umur);
    $("#RDPendaftaranT_pendaftaran_id").val(data.pendaftaran_id);
    $("#PasienpulangT_pendaftaran_id").val(data.pendaftaran_id);
    $("#RDPendaftaranT_carabayar_id").val(data.carabayar_id);
    $("#RDPendaftaranT_penjamin_id").val(data.penjamin_id);
    $("#RDPendaftaranT_kelaspelayanan_id").val(data.kelaspelayanan_id);
    $("#PasienpulangT_pasien_id").val(data.pasien_id);
    $("#RDPasienM_pasien_id").val(data.pasien_id);
    $("#RDPasienM_jeniskelamin").val(data.jeniskelamin);
    $("#RDPasienM_nama_pasien").val(data.namapasien);
    $("#RDPasienM_nama_bin").val(data.namabin);
    $("#jeniskasuspenyakit_nama").val(data.jeniskasuspenyakit);
    $("#instalasi_nama").val(data.namainstalasi);
    $("#ruangan_nama").val(data.namaruangan);
    $("#carabayar_nama").val(data.carabayar_nama);
    $("#penjamin_nama").val(data.penjamin_nama);
}

</script>