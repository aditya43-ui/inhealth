<?php $this->widget('bootstrap.widgets.BootAlert'); ?> 

<table class="table table-condensed">
    <tr>
        <td>
            <?php //echo CHtml::activeLabel($modPasien, 'no_rekam_medik',array('class'=>'control-label')); ?>
            <label class="control-label no_rek">No. Pendaftaran</label>
        </td>
        <td>
            <?php //echo CHtml::textField('ASPasienM[no_rekam_medik]', $modPasien->no_rekam_medik, array('readonly'=>true)); ?>
            <?php
            if (!empty($modPendaftaran->no_pendaftaran)) {
                echo CHtml::textField('ASPendaftaranT[no_pendaftaran]', $modPendaftaran->no_pendaftaran, array('readonly' => true));
            } else {
                echo CHtml::hiddenField('ASPendaftaranT[pendaftaran_id]', $modPendaftaran->pendaftaran_id, array('readonly' => true));
                echo CHtml::hiddenField('ASPendaftaranT[pasien_id]', $modPendaftaran->pasien_id, array('readonly' => true));
                $this->widget('MyJuiAutoComplete', array(
                    'name' => 'ASPendaftaranT[no_pendaftaran]',
                    'value' => $modPendaftaran->no_pendaftaran,
                    'source' => 'js: function(request, response) {
                                                   $.ajax({
                                                       url: "' . $this->createUrl('Autocompletenopendaftaran') . '",
                                                       dataType: "json",
                                                       data: {
                                                           term: request.term,
                                                           instalasiId: $("#ASPendaftaranT_instalasi_id").val(),
                                                       },
                                                       success: function (data) {
                                                               response(data);
															   
                                                       }
                                                   })
                                                }',
                    'options' => array(
                        'showAnim' => 'fold',
                        'minLength' => 3,
                        'focus' => 'js:function( event, ui ) {
                                                $(this).val(ui.item.value);
                                                return false;
                                            }',
                        'select' => 'js:function( event, ui ) {
                                            cekPendaftaran(ui.item.pendaftaran_id);
                                            return false;
                                            }',
                    ),
                    'tombolDialog' => array('idDialog' => 'dialogPasien', 'idTombol' => 'tombolPasienDialog'),
                    'htmlOptions' => array('class' => 'span3',
                        'placeholder' => 'No. Pendaftaran', 'onkeypress' => "return $(this).focusNextInputField(event)"),
                ));
            }
            ?>
        </td>
        <td><?php echo CHtml::activeLabel($modPasien, 'jeniskelamin', array('class' => 'control-label')); ?></td>
        <td><?php echo CHtml::textField('ASPasienM[jeniskelamin]', $modPasien->jeniskelamin, array('readonly' => true)); ?></td>  

    </tr>
    <tr>
        <td><?php echo CHtml::activeLabel($modPendaftaran, 'tgl_pendaftaran', array('class' => 'control-label')); ?></td>
        <td><?php echo CHtml::textField('ASPendaftaranT[tgl_pendaftaran]', $modPendaftaran->tgl_pendaftaran, array('readonly' => true)); ?></td>

        <td><?php echo CHtml::label('Pekerjaan', 'pekerjaan_nama', array('class' => 'control-label')); ?></td>
    </tr>
    <tr>
        <td><?php echo CHtml::activeLabel($modPasien, 'no_rekam_medik', array('class' => 'control-label ')); ?></td>
        <td><?php
            //echo CHtml::textField('ASPasienM[nama_pasien]', $modPasien->nama_pasien, array('readonly'=>true)); 
            $this->widget('MyJuiAutoComplete', array(
                'name' => 'ASPasienM[no_rekam_medik]',
                'value' => $modPasien->no_rekam_medik,
                'source' => 'js: function(request, response) {
                                                          $.ajax({
                                                              url: "' . $this->createUrl('Autocompletenorekammedik') . '",
                                                              dataType: "json",
                                                              data: {
                                                                  daftarpasien:true,
                                                                  term: request.term,
                                                              },
                                                              success: function (data) {
                                                                response(data);
                                                              }
                                                          })
                                                       }',
                'options' => array(
                    'showAnim' => 'fold',
                    'minLength' => 3,
                    'focus' => 'js:function( event, ui ) {
                                                       $(this).val(ui.item.value);
                                                       return false;
                                                   }',
                    'select' => 'js:function( event, ui ) {
                                    cekPendaftaran(ui.item.pendaftaran_id);
                                            return false;
                                                   }',
                ),
            ));
            ?></td>

        <td><?php echo CHtml::label('Pendidikan', 'pendidikan_nama', array('class' => 'control-label')); ?></td>
        <td><?php echo CHtml::textField('ASPasienM[pendidikan_nama]', isset($modPasien->pendidikan->pendidikan_nama) ? $modPasien->pendidikan->pendidikan_nama : '-', array('readonly' => true)); ?></td>
    </tr>
    <tr>
        <td><?php echo CHtml::activeLabel($modPasien, 'nama_pasien', array('class' => 'control-label ')); ?></td>
        <td><?php
            //echo CHtml::textField('ASPasienM[nama_pasien]', $modPasien->nama_pasien, array('readonly'=>true)); 
            $this->widget('MyJuiAutoComplete', array(
                'name' => 'ASPasienM[nama_pasien]',
                'value' => $modPasien->nama_pasien,
                'source' => 'js: function(request, response) {
                                                          $.ajax({
                                                              url: "' . $this->createUrl('Autocompletenamapasien') . '",
                                                              dataType: "json",
                                                              data: {
                                                                  daftarpasien:true,
                                                                  term: request.term,
                                                              },
                                                              success: function (data) {
                                                                      response(data);
                                                              }
                                                          })
                                                       }',
                'options' => array(
                    'showAnim' => 'fold',
                    'minLength' => 3,
                    'focus' => 'js:function( event, ui ) {
                                                       $(this).val(ui.item.value);
                                                       return false;
                                                   }',
                    'select' => 'js:function( event, ui ) {
                                        cekPendaftaran(ui.item.pendaftaran_id);
                                            return false;
                                                   }',
                ),
            ));
            ?></td>

        <td><?php echo CHtml::activeLabel($modPasien, 'alamat_pasien', array('class' => 'control-label')); ?></td>
        <td><?php echo CHtml::textArea('ASPasienM[alamat_pasien]', isset($modPasien->alamat_pasien) ? $modPasien->alamat_pasien : '-', array('readonly' => true)); ?></td>

    </tr>
    <tr>
        <td><?php echo CHtml::activeLabel($modPasien, 'umur', array('class' => 'control-label')); ?></td>
        <td><?php echo CHtml::textField('ASPendaftaranT[umur]', isset($modPasien->umur) ? $modPasien->umur : '-', array('readonly' => true)); ?></td>
    </tr>
    <tr>
        <td></td>
        <td></td>

        <td><?php echo CHtml::activeLabel($modPasien, 'statusperkawinan', array('class' => 'control-label')); ?></td>
        <td><?php echo CHtml::textField('ASPendaftaranT[statusperkawinan]', isset($modPendaftaran->statusperkawinan) ? $modPendaftaran->statusperkawinan : '-', array('readonly' => true)); ?></td>
    </tr>
    <tr>
        <td><?php echo CHtml::activeLabel($modPasien, 'agama', array('class' => 'control-label')); ?></td>
        <td><?php echo CHtml::textField('ASPasienM[agama]', $modPasien->jeniskelamin, array('readonly' => true)); ?></td>  
        <td><?php echo CHtml::activeLabel($modPendaftaran, 'ruangan_id', array('class' => 'control-label')); ?></td>
        <td><?php echo CHtml::textField('ASPendaftaranT[ruangan_nama]', isset($modPendaftaran->ruangan->ruangan_nama) ? $modPendaftaran->ruangan->ruangan_nama : '-', array('readonly' => true)); ?></td>
    </tr>
    <tr>
        <td><?php echo CHtml::label('Kelas Pelayanan', 'kelaspelayanan_nama', array('class' => 'control-label')); ?></td>
        <td><?php echo CHtml::textField('ASPendaftaranT[kelaspelayanan_nama]', isset($modPendaftaran->kelaspelayanan->kelaspelayanan_nama) ? $modPendaftaran->kelaspelayanan->kelaspelayanan_nama : '-', array('readonly' => true)); ?></td>
        <td><?php echo CHtml::label('No Kamar / No. Bed', 'no_kamarbed', array('class' => 'control-label')); ?></td>
        <td><?php echo CHtml::textField('ASPendaftaranT[no_kamarbed]', isset($modPendaftaran->kamarruangan_nokamar) ? $modPendaftaran->kamarruangan_nokamar : '' . '/' . isset($modPendaftaran->kamarruangan_nobed) ? $modPendaftaran->kamarruangan_nobed : '', array('readonly' => true)); ?></td>
    </tr>
</table>

<?php
//========= Dialog buat cari data pendaftaran =========================

$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogPasien',
    'options' => array(
        'title' => 'Pencarian Data Pasien',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'height' => 420,
        'resizable' => false,
    ),
));
$modDialogKunjungan = new ASPasienM('searchDialogKunjungan');
$modDialogKunjungan->unsetAttributes();
$modDialogKunjungan->tgl_pendaftaran = date('m/d/Y') . ' - ' . date('m/d/Y');
if (isset($_GET['ASPasienM'])) {
    $modDialogKunjungan->attributes = $_GET['ASPasienM'];
    $modDialogKunjungan->instalasi_id = isset($_GET['ASPasienM']['instalasi_id']) ? $_GET['ASPasienM']['instalasi_id'] : '';
    $modDialogKunjungan->no_pendaftaran = isset($_GET['ASPasienM']['no_pendaftaran']) ? $_GET['ASPasienM']['no_pendaftaran'] : '';
    $modDialogKunjungan->tgl_pendaftaran = isset($_GET['ASPasienM']['tgl_pendaftaran']) ? $_GET['ASPasienM']['tgl_pendaftaran'] : '';
    $modDialogKunjungan->instalasi_id = isset($_GET['ASPasienM']['instalasi_id']) ? $_GET['ASPasienM']['instalasi_id'] : '';
    $modDialogKunjungan->instalasi_nama = isset($_GET['ASPasienM']['instalasi_nama']) ? $_GET['ASPasienM']['instalasi_nama'] : '';
    $modDialogKunjungan->carabayar_id = isset($_GET['ASPasienM']['carabayar_id']) ? $_GET['ASPasienM']['carabayar_id'] : '';
    $modDialogKunjungan->carabayar_nama = isset($_GET['ASPasienM']['carabayar_nama']) ? $_GET['ASPasienM']['carabayar_nama'] : '';
    $modDialogKunjungan->ruangan_id = isset($_GET['ASPasienM']['ruangan_id']) ? $_GET['ASPasienM']['ruangan_id'] : '';
    $modDialogKunjungan->ruangan_nama = isset($_GET['ASPasienM']['ruangan_nama']) ? $_GET['ASPasienM']['ruangan_nama'] : '';
}

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'pendaftaran-t-grid',
    'dataProvider' => $modDialogKunjungan->searchDialogKunjungan(),
    'filter' => $modDialogKunjungan,
    'template' => "{summaryNonPage}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","javascript:void(0);",array("class"=>"btn-small", 
                                        "id" => "selectPendaftaran",
                                        "onClick" => "
                                            $(\"#dialogPasien\").dialog(\"close\");
											cekPendaftaran(\"$data->pendaftaran_id\");
                                        "))',
        ),
        array(
            'name' => 'no_rekam_medik',
            'type' => 'raw',
            'value' => '$data->no_rekam_medik',
        ),
        array(
            'name' => 'nama_pasien',
            'type' => 'raw',
            'value' => '$data->nama_pasien',
        ),
        array(
            'name' => 'jeniskelamin',
            'value' => '$data->jeniskelamin',
            'filter' => LookupM::model()->getItems('jeniskelamin'),
        ),
        'no_pendaftaran',
        array(
            'header' => 'Tanggal Pendaftaran / Masuk Kamar',
            'type' => 'raw',
            'value' => 'MyFormatter::formatDateTimeForUser($data->tgl_pendaftaran)
					.(isset($data->tglmasukkamar) ? "<br>".MyFormatter::formatDateTimeForUser($data->tglmasukkamar) : "")',
            'filter' =>
            CHtml::activeTextField($modDialogKunjungan, 'tgl_pendaftaran', array('class' => 'span3', 'readonly' => true)),
        /* $this->widget('MyDateTimePicker', array(
          'model' => $modDialogKunjungan,
          'attribute' => 'tgl_pendaftaran',
          'mode' => 'date', //date / datetime
          'gridFilter' => true,
          'options' => array(
          'dateFormat' => Params::DATE_FORMAT,
          'maxDate'=>'d',
          ),
          'htmlOptions' => array('readonly' => true, 'class' => "span2",
          'onkeypress' => "return $(this).focusNextInputField(event)"),
          ),true), */
        ),
        array(
            'name' => 'instalasi_nama',
            'type' => 'raw',
            'filter' => CHtml::activeDropDownList($modDialogKunjungan, 'instalasi_id', CHtml::listData(InstalasiM::model()->findAll('instalasi_aktif=TRUE'), 'instalasi_id', 'instalasi_nama'), array('empty' => '-- Pilih --', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event)"))
        ),
        array(
            'name' => 'ruangan_nama',
            'type' => 'raw',
            'filter' => CHtml::activeDropDownList($modDialogKunjungan, 'ruangan_id', CHtml::listData(RuanganM::model()->findAll('ruangan_aktif=TRUE'), 'ruangan_id', 'ruangan_nama'), array('empty' => '-- Pilih --', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event)"))
        ),
        array(
            'name' => 'carabayar_nama',
            'type' => 'raw',
            'value' => '$data->carabayar_nama',
            'filter' => CHtml::activeDropDownList($modDialogKunjungan, 'carabayar_id', CHtml::listData(CarabayarM::model()->findAll('carabayar_aktif=TRUE'), 'carabayar_id', 'carabayar_nama'), array('empty' => '-- Pilih --', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event)"))
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){
			jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});
//			jQuery("#' . CHtml::activeId($modDialogKunjungan, 'tgl_pendaftaran') . '").datepicker(jQuery.extend({showMonthAfterYear:false}, jQuery.datepicker.regional["id"], {"dateFormat":"dd M yy","maxDate":"d","timeText":"Waktu","hourText":"Jam","minuteText":"Menit","secondText":"Detik","showSecond":true,"timeOnlyTitle":"Pilih Waktu","timeFormat":"hh:mm:ss","changeYear":true,"changeMonth":true,"showAnim":"fold","yearRange":"-80y:+20y"}));
//			jQuery("#' . CHtml::activeId($modDialogKunjungan, 'tgl_pendaftaran') . '_date").on("click", function(){jQuery("#' . CHtml::activeId($modDialogKunjungan, 'tgl_pendaftaran') . '").datepicker("show");});
                        jQuery("#' . CHtml::activeId($modDialogKunjungan, 'tgl_pendaftaran') . '").daterangepicker({
                            "maxDate": "' . date('m/d/Y') . '",
                            "showDropdowns": true,
                        });
		}',
));

$this->endWidget();
////======= end pendaftaran dialog =============
?>
<script>
    $(document).ready(function () {
        $('input[name="ASPasienM[tgl_pendaftaran]"]').daterangepicker({
            "maxDate": "<?php echo date('m/d/Y') ?>",
            "showDropdowns": true,
        });
    });
</script>