<?php $this->widget('bootstrap.widgets.BootAlert'); ?>

<style>
    table>td>input {
        margin-top: 5px;
    }

    tr td .add-on {
        margin: 0 !important;
    }
</style>

<fieldset id="fieldsetRekamMedik">
    <form id="form-rekam-medik">
        <table style="width: 100%; border: none;">
            <tr>
                <td><?php echo CHtml::activeLabel($modPendaftaran, 'tgl_pendaftaran', array('class' => 'control-label')); ?></td>
                <td><?php echo CHtml::hiddenField('RKPendaftaranT[pendaftaran_id]', '', array('readonly' => true, 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
                    <?php echo CHtml::hiddenField('RKPendaftaranT[pasienadmisi_id]', '', array('readonly' => true, 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
                    <?php echo CHtml::hiddenField('RKPendaftaranT[instalasi_id]', '', array('readonly' => true, 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
                    <?php echo CHtml::hiddenField('RKPendaftaranT[caramasuk_id]', '', array('readonly' => true, 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
                    <?php echo CHtml::textField('RKPendaftaranT[tgl_pendaftaran]', '', array('readonly' => true, 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
                </td>

                <td>
                    <?php //echo CHtml::activeLabel($modPasien, 'no_rekam_medik',array('class'=>'control-label')); 
                    ?>
                    <div class="control-label">No. Rekam Medik <span class="required">*</span><label for="noRekamMedik" class="no_rek"></label></div>
                </td>
                <td>
                    <?php if (!empty($modPasien->no_rekam_medik)) {
                        echo CHtml::textField('RKPasienM[no_rekam_medik]', $modPasien->no_rekam_medik, array('readonly' => true));
                    } else {
                        $this->widget('MyJuiAutoComplete', array(
                            'name' => 'RKPasienM[no_rekam_medik]',
                            'value' => $modPasien->no_rekam_medik,
                            'source' => 'js: function(request, response) {
                                           $.ajax({
                                               url: "' . $this->createUrl('daftarPasien') . '",
                                               dataType: "json",
                                               data: {
                                                   term: request.term,
                                                   instalasiId: $("#RKPendaftaranT_instalasi_id").val(),
                                               },
                                               success: function (data) {
                                                       response(data);
                                               }
                                           })
                                        }',
                            'options' => array(
                                'showAnim' => 'fold',
                                'minLength' => 2,
                                'focus' => 'js:function( event, ui ) {
                                        $(this).val(ui.item.value);
                                        
                                        return false;
                                    }',
                                'select' => 'js:function( event, ui ) {
                                        isiDataPasien(ui.item);
                                        return false;
                                    }',
                            ),
                            //'tombolDialog'=>array('idDialog'=>'dialogPasien','idTombol'=>'tombolPasienDialog'),
                            'htmlOptions' => array('class' => 'span3 required', 'placeholder' => 'No. Rekam Medik'),
                        ));
                    }
                    ?>
                </td>

                <td rowspan="6">
                    <?php
                    if (!empty($modPasien->photopasien)) {
                        echo CHtml::image(Params::urlPhotoPasienDirectory() . $modPasien->photopasien, 'Foto pasien', array('width' => 120));
                    } else {
                        echo CHtml::image(Params::urlPhotoPasienDirectory() . 'no_photo.jpeg', 'Foto pasien', array('width' => 120));
                    }
                    ?>
                </td>
            </tr>
            <tr>
                <td><?php echo CHtml::activeLabel($modPendaftaran, 'no_pendaftaran', array('class' => 'control-label')); ?></td>
                <td><?php echo CHtml::textField('RKPendaftaranT[no_pendaftaran]', '', array('readonly' => true, 'onkeypress' => "return $(this).focusNextInputField(event)")); ?></td>

                <td>
                    <?php //echo CHtml::activeLabel($modPasien, 'no_rekam_medik',array('class'=>'control-label')); 
                    ?>
                    <div class="control-label">Nama Pasien <span class="required">*</span><label class="no_rek" for="namaPasien"></label></div>
                </td>
                <td>
                    <?php
                    if (!empty($modPasien->pasien_id)) {
                        echo CHtml::textField('RKPasienM[nama_pasien]', $modPasien->nama_pasien, array('readonly' => true));
                    } else {
                        $this->widget('MyJuiAutoComplete', array(
                            'name' => 'RKPasienM[nama_pasien]',
                            'value' => $modPasien->nama_pasien,
                            'source' => 'js: function(request, response) {
                                           $.ajax({
                                               url: "' . $this->createUrl('daftarPasien') . '",
                                               dataType: "json",
                                               data: {
                                                   term2: request.term,
                                                   instalasiId: $("#RKPendaftaranT_instalasi_id").val(),
                                               },
                                               success: function (data) {
                                                       response(data);
                                               }
                                           })
                                        }',
                            'options' => array(
                                'showAnim' => 'fold',
                                'minLength' => 2,
                                'focus' => 'js:function( event, ui ) {
                                        $(this).val(ui.item.value);

                                        return false;
                                    }',
                                'select' => 'js:function( event, ui ) {
                                        isiDataPasien(ui.item);
                                        return false;
                                    }',
                            ),
                            //'tombolDialog'=>array('idDialog'=>'dialogPasien','idTombol'=>'tombolPasienDialog'),
                            'htmlOptions' => array('class' => 'span3 required ', 'placeholder' => 'Nama Pasien'),
                        ));
                    }
                    ?>
                </td>
            </tr>
            <tr>
                <td><?php echo CHtml::activeLabel($modPendaftaran, 'umur', array('class' => 'control-label')); ?></td>
                <td><?php echo CHtml::textField('RKPendaftaranT[umur]', '', array('readonly' => true, 'onkeypress' => "return $(this).focusNextInputField(event)")); ?></td>

                <td><?php echo CHtml::activeLabel($modPasien, 'jeniskelamin', array('class' => 'control-label')); ?></td>
                <td><?php echo CHtml::textField('RKPasienM[jeniskelamin]', $modPasien->jeniskelamin, array('readonly' => true, 'onkeypress' => "return $(this).focusNextInputField(event)")); ?></td>
            </tr>
            <tr>
                <td><?php echo CHtml::activeLabel($modPendaftaran, 'jeniskasuspenyakit_id', array('class' => 'control-label')); ?></td>
                <td><?php echo CHtml::textField('RKPendaftaranT[jeniskasuspenyakit_nama]', ((isset($modPendaftaran->kasuspenyakit->jeniskasuspenyakit_nama)) ? $modPendaftaran->kasuspenyakit->jeniskasuspenyakit_nama : ''), array('readonly' => true)); ?>

                <td><?php echo CHtml::activeLabel($modPasien, 'nama_bin', array('class' => 'control-label')); ?></td>
                <td><?php echo CHtml::textField('RKPasienM[nama_bin]', $modPasien->nama_bin, array('readonly' => true, 'onkeypress' => "return $(this).focusNextInputField(event)")); ?></td>
            </tr>
            <tr>
                <td>
                    <?php echo CHtml::activeLabel($modPendaftaran, 'carabayar_id', array('class' => 'control-label')) ?>
                </td>
                <td>
                    <?php echo CHtml::textField('RKPendaftaranT[carabayar_nama]', (isset($modPendaftaran->carabayar->carabayar_nama) ? $modPendaftaran->carabayar->carabayar_nama : ""), array('readonly' => true)); ?>
                    <?php echo CHtml::hiddenField('RKPendaftaranT[carabayar_id]', $modPendaftaran->carabayar_id, array('readonly' => true)); ?>
                </td>

                <td>
                    <?php echo CHtml::activeLabel($modPendaftaran, 'penjamin_id', array('class' => 'control-label')) ?>
                </td>
                <td>
                    <?php echo CHtml::textField('RKPendaftaranT[penjamin_nama]', (isset($modPendaftaran->penjamin->penjamin_nama) ? $modPendaftaran->penjamin->penjamin_nama : ""), array('readonly' => true)); ?>
                    <?php echo CHtml::hiddenField('RKPendaftaranT[penjamin_id]', $modPendaftaran->penjamin_id, array('readonly' => true)); ?>
                    <?php echo CHtml::hiddenField('RKPendaftaranT[kelaspelayanan_id]', ((isset($modPendaftaran->kelaspelayanan_id)) ? $modPendaftaran->kelaspelayanan_id : ''), array('readonly' => true)); ?></td>
                </td>
            </tr>
            <tr>
                <td><?php echo CHtml::activeLabel($modPendaftaran, 'ruangan_id', array('class' => 'control-label')); ?></td>
                <td><?php echo CHtml::textField('RKPendaftaranT[ruangan_nama]', ((isset($modPendaftaran->ruangan->ruangan_nama)) ? $modPendaftaran->ruangan->ruangan_nama : ''), array('readonly' => true, 'onkeypress' => "return $(this).focusNextInputField(event)")); ?></td>

                <td></td>
                <td></td>
            </tr>
        </table>
    </form>
</fieldset>

<?php
//========= Dialog buat cari data pendaftaran =========================

$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogPasien',
    'options' => array(
        'title' => 'Pencarian Data Pasien',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'height' => 540,
        'resizable' => false,
    ),
));
$format = new MyFormatter();
$modDialogPasien = new RKPasienM('searchPasien');
$modDialogPasien->unsetAttributes();
if (isset($_GET['RKPasienM'])) {
    $modDialogPasien->attributes = $_GET['RKPasienM'];
    $modDialogPasien->instalasi_id = $_GET['RKPasienM']['instalasi_id'];
    $modDialogPasien->no_pendaftaran = $_GET['RKPasienM']['no_pendaftaran'];
    //    $modDialogPasien->tgl_pendaftaran_cari = $_GET['RKPasienM']['tgl_pendaftaran_cari'];
    $modDialogPasien->instalasi_nama = $_GET['RKPasienM']['instalasi_nama'];
    $modDialogPasien->carabayar_nama = $_GET['RKPasienM']['carabayar_nama'];
    $modDialogPasien->ruangan_nama = $_GET['RKPasienM']['ruangan_nama'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'pendaftaran-t-grid',
    'dataProvider' => $modDialogPasien->searchPasien(),
    'filter' => $modDialogPasien,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'filter' =>
            CHtml::activeHiddenField($modDialogPasien, 'instalasi_id', array()),
            'value' => 'CHtml::Link("<i class=\"icon-check\"></i>","javascript:void(0);",array("class"=>"btn-small", 
                                    "id" => "selectPendaftaran",
                                    "onClick" => "
                                        loadPasien(".$data->no_rekam_medik.");
                                        $(\"#dialogPasien\").dialog(\"close\");
                                        
                                        tab = $(\".active\").length;
                                        if(tab > 1){
                                            setTab($(\".active\"));
                                        }
                                    "))',
        ),
        array(
            'name' => 'no_rekam_medik',
            'type' => 'raw',
        ),
        array(
            'name' => 'nama_pasien',
            'type' => 'raw',
        ),
        'jeniskelamin',
        'no_pendaftaran',
        array(
            'name' => 'tgl_pendaftaran',
            'filter' =>
            CHtml::activeTextField($modDialogPasien, 'tgl_pendaftaran_cari', array('placeholder' => 'contoh: 15 Jan 2013')),
        ),
        array(
            'name' => 'instalasi_nama',
            'type' => 'raw',
        ),
        array(
            'name' => 'ruangan_nama',
            'type' => 'raw',
        ),
        array(
            'name' => 'carabayar_nama',
            'type' => 'raw',
        ),

    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
//========= end pendaftaran dialog =============================

$urlPasien = Yii::app()->createUrl('rekamMedis/SuratKeterangan/daftarPasien');
?>

<script type="text/javascript">
    function isiDataPasien(data) {
        console.log(data)
        $("#RKPendaftaranT_tgl_pendaftaran").val(data.tgl_pendaftaran);
        $("#RKPendaftaranT_no_pendaftaran").val(data.no_pendaftaran);
        $("#RKPendaftaranT_umur").val(data.umur);
        $("#RKPendaftaranT_jeniskasuspenyakit_nama").val(data.jeniskasuspenyakit_nama);
        $("#RKPendaftaranT_instalasi_id").val(data.instalasi_id);
        $("#RKPendaftaranT_instalasi_nama").val(data.namainstalasi);
        $("#RKPendaftaranT_ruangan_nama").val(data.namaruangan);
        $("#RKPendaftaranT_pendaftaran_id").val(data.pendaftaran_id);
        $("#RKPendaftaranT_carabayar_id").val(data.carabayar_id);
        $("#RKPendaftaranT_penjamin_id").val(data.penjamin_id);
        $("#RKPendaftaranT_kelaspelayanan_id").val(data.kelaspelayanan_id);
        $("#RKPendaftaranT_pendaftaran_id").val(data.pendaftaran_id);
        $("#RKPendaftaranT_pasienadmisi_id").val(data.pasienadmisi_id);
        $("#RKPendaftaranT_caramasuk_id").val(data.caramasuk_id);

        $("#RKPasienM_jeniskelamin").val(data.jeniskelamin);
        $("#RKPasienM_no_rekam_medik").val(data.no_rekam_medik);
        $("#RKPasienM_nama_pasien").val(data.namapasien);
        $("#RKPasienM_nama_bin").val(data.namabin);
        $("#RKPendaftaranT_carabayar_nama").val(data.carabayar_nama);
        $("#RKPendaftaranT_penjamin_nama").val(data.penjamin_nama);

        cekTabulasi();
    }

    function loadPasien(rm) {
        $.ajax({
            url: "<?php echo $urlPasien; ?>",
            dataType: "json",
            data: {
                term: rm,
                instalasiId: $("#RKPendaftaranT_instalasi_id").val(),
            },
            success: function(data) {
                isiDataPasien(data[0]);
            }
        })
    }

    function cekTabulasi() {
        var tab = $("#menuBoot").find(".active").length;

        if (tab > 1) {
            setTab($(".active"));
        } else {
            setTab($("#menuBoot").find("#default-tab"));
        }
    }

    function refreshDialogPendaftaran() {
        var instalasiId = $("#RKPendaftaranT_instalasi_id").val();
        var no_pendaftaran = $("#RKPendaftaranT_no_pendaftaran").val();
        var tgl_pendaftaran_cari = $("#RKPendaftaranT_tgl_pendaftaran_cari").val();
        var instalasiNama = $("#RKPendaftaranT_instalasi_id option:selected").text();
        var carabayar_nama = $("#RKPendaftaranT_carabayar_nama").text();
        var ruangan_nama = $("#RKPendaftaranT_ruangan_nama").text();

        $.fn.yiiGridView.update('pendaftaran-t-grid', {
            data: {
                "RKPasienM[instalasi_id]": instalasiId,
                "RKPasienM[instalasi_nama]": instalasiNama,
                "RKPasienM[no_pendaftaran]": no_pendaftaran,
                "RKPasienM[tgl_pendaftaran_cari]": tgl_pendaftaran_cari,
                "RKPasienM[carabayar_nama]": carabayar_nama,
                "RKPasienM[ruangan_nama]": ruangan_nama,
            }
        });
    }
</script>