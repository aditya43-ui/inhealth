<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'penjualanresep-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    //        'focus'=>'#FAPendaftaranT_instalas    i_id',
    'htmlOptions' => array(
        'onKeyPress' => 'return disableKeyPress(event)',
        'onsubmit' => 'return cekInput();'
    ),
)); ?>
<fieldset id="form-infodokter">
    <legend class="rim">Data Pasien
        <span class='tombol' style='display:none;'><?php echo CHtml::htmlButton('<i class="entypo-arrows-ccw"></i>', array('class' => 'btn btn-default btn-mini', 'onclick' => 'setInfoDokterReset();', 'onkeyup' => "return $(this).focusNextInputField(event)", 'rel' => 'tooltip', 'title' => 'Klik untuk mengulang data kunjungan')); ?></span>
    </legend>
    <div class="row box">
        <div class="span12">
            <?php echo $form->hiddenField($modPendaftaran, 'is_pasien', array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event)")); ?>
            <?php $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
                'id' => 'form-pasien',
                'content' => array(
                    'content-pasien' => array(
                        'header' => '<b>Data Pasien</b>',
                        'isi' => $this->renderPartial($this->path_view . '_formDataPasien', array(
                            'form' => $form,
                            'modPendaftaran' => $modPendaftaran,
                            'modPasien' => $modPasien,
                        ), true),
                        'active' => $modPendaftaran->is_pasien,
                    ),
                ),
            )); ?>
        </div>
    </div>
</fieldset>
<?php $this->endWidget(); ?>
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
$modDialogPasien = new FAPasienM('searchPasienRumahsakitV');
$modDialogPasien->unsetAttributes();
if (isset($_GET['FAPasienM'])) {
    $modDialogPasien->attributes = $_GET['FAPasienM'];
    $modDialogPasien->idInstalasi = (isset($_GET['FAPasienM']['idInstalasi']) ? $_GET['FAPasienM']['idInstalasi'] : null);
    $modDialogPasien->no_pendaftaran = (isset($_GET['FAPasienM']['no_pendaftaran']) ? $_GET['FAPasienM']['no_pendaftaran'] : "");
    $modDialogPasien->tgl_pendaftaran_cari = (isset($_GET['FAPasienM']['tgl_pendaftaran_cari']) ? $_GET['FAPasienM']['tgl_pendaftaran_cari'] : "");
    $modDialogPasien->instalasi_nama = (isset($_GET['FAPasienM']['instalasi_nama']) ? $_GET['FAPasienM']['instalasi_nama'] : "");
    $modDialogPasien->carabayar_nama = (isset($_GET['FAPasienM']['carabayar_nama']) ? $_GET['FAPasienM']['carabayar_nama'] : "");
    $modDialogPasien->ruangan_nama = (isset($_GET['FAPasienM']['ruangan_nama']) ? $_GET['FAPasienM']['ruangan_nama'] : "");
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'pendaftaran-t-grid',
    'dataProvider' => $modDialogPasien->searchPasienRumahsakitV(),
    'filter' => $modDialogPasien,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","javascript:void(0);",array("class"=>"btn-small", 
                                    "id" => "selectPendaftaran",
                                    "onClick" => "
                                        $(\"#dialogPasien\").dialog(\"close\");

                                        $(\"#FAPendaftaranT_tgl_pendaftaran\").val(\"$data->tgl_pendaftaran\");
                                        $(\"#FAPendaftaranT_no_pendaftaran\").val(\"$data->no_pendaftaran\");
                                        $(\"#FAPendaftaranT_umur\").val(\"$data->umur\");
                                        $(\"#FAPendaftaranT_jeniskasuspenyakit_nama\").val(\"$data->jeniskasuspenyakit_nama\");
                                        $(\"#FAPendaftaranT_instalasi_id\").val(\"$data->instalasi_id\");
                                        $(\"#FAPendaftaranT_instalasi_nama\").val(\"$data->instalasi_nama\");
                                        $(\"#FAPendaftaranT_ruangan_nama\").val(\"$data->ruangan_nama\");
                                        $(\"#FAPendaftaranT_pendaftaran_id\").val(\"$data->pendaftaran_id\");
                                        $(\"#FAPendaftaranT_carabayar_id\").val(\"$data->carabayar_id\");
                                        $(\"#FAPendaftaranT_penjamin_id\").val(\"$data->penjamin_id\");
                                        $(\"#FAPendaftaranT_kelaspelayanan_id\").val(\"$data->kelaspelayanan_id\");

                                        $(\"#FAPasienM_jeniskelamin\").val(\"$data->jeniskelamin\");
                                        $(\"#FAPasienM_no_rekam_medik\").val(\"$data->no_rekam_medik\");
                                        $(\"#FAPasienM_nama_pasien\").val(\"$data->nama_pasien\");
                                        $(\"#FAPasienM_nama_bin\").val(\"$data->nama_bin\");
                                        $(\"#FAPendaftaranT_carabayar_nama\").val(\"$data->carabayar_nama\");
                                        $(\"#FAPendaftaranT_penjamin_nama\").val(\"$data->penjamin_nama\");

                                        $(\"#makstanggpel\").val(\"$data->Makstanggpel\");
                                        $(\"#subsidirspersen\").val(\"$data->Subsidirumahsakitoa\");
                                        $(\"#subsidipemerintahpersen\").val(\"$data->Subsidipemerintahoa\");
                                        $(\"#subsidiasuransipersen\").val(\"$data->Subsidiasuransioa\");
                                        $(\"#iurbiayapersen\").val(\"$data->Iurbiayaoa\");

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
            //                    POSISI DATE PICKER BUGS
            //                    $this->widget('MyDateTimePicker',array(
            //                            'model'=>$modDialogPasien,
            //                            'attribute'=>'tgl_pendaftaran_cari',
            //                            'mode'=>'date',
            //                            'options'=> array(
            //                                'dateFormat'=>Params::DATE_FORMAT,
            //                            ),
            //                            'htmlOptions'=>array('readonly'=>true,'onkeypress'=>"return $(this).focusNextInputField(event)"
            //                            ),
            //                    )),
        ),
        array(
            'name' => 'instalasi_nama',
            'type' => 'raw',
            'filter' =>
            CHtml::activeHiddenField($modDialogPasien, 'idInstalasi', array()) . CHtml::activeTextField($modDialogPasien, 'instalasi_nama', array()),
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
?>

<script type="text/javascript">
    function isiDataPasien(data) {
        $("#FAPendaftaranT_tgl_pendaftaran").val(data.tgl_pendaftaran);
        $("#FAPendaftaranT_no_pendaftaran").val(data.no_pendaftaran);
        $("#FAPendaftaranT_umur").val(data.umur);
        $("#FAPendaftaranT_jeniskasuspenyakit_nama").val(data.jeniskasuspenyakit);
        $("#FAPendaftaranT_instalasi_id").val(data.instalasi_id);
        $("#FAPendaftaranT_instalasi_nama").val(data.namainstalasi);
        $("#FAPendaftaranT_ruangan_nama").val(data.namaruangan);
        $("#FAPendaftaranT_pendaftaran_id").val(data.pendaftaran_id);
        $("#FAPendaftaranT_carabayar_id").val(data.carabayar_id);
        $("#FAPendaftaranT_penjamin_id").val(data.penjamin_id);
        $("#FAPendaftaranT_kelaspelayanan_id").val(data.kelaspelayanan_id);

        $("#FAPasienM_jeniskelamin").val(data.jeniskelamin);
        $("#FAPasienM_nama_pasien").val(data.namapasien);
        $("#FAPasienM_nama_bin").val(data.namabin);
        $("#FAPendaftaranT_carabayar_nama").val(data.carabayar_nama);
        $("#FAPendaftaranT_penjamin_nama").val(data.penjamin_nama);

        $("#makstanggpel").val(data.makstanggpel);
        $("#subsidirspersen").val(data.subsidirumahsakitoa);
        $("#subsidipemerintahpersen").val(data.subsidipemerintahoa);
        $("#subsidiasuransipersen").val(data.subsidiasuransioa);
        $("#iurbiayapersen").val(data.iurbiayaoa);

        //    $("#FAResepturT_pegawai_id").val(data.pegawai_id);
        //    $("#FAResepturT_dokter").val(data.pegawai_nama);

    }

    function refreshDialogPendaftaran() {
        var instalasiId = $("#FAPendaftaranT_instalasi_id").val();
        var instalasiNama = $("#FAPendaftaranT_instalasi_id option:selected").text();
        $.fn.yiiGridView.update('pendaftaran-t-grid', {
            data: {
                "FAPasienM[idInstalasi]": instalasiId,
                "FAPasienM[instalasi_nama]": instalasiNama,
            }
        });
    }

    function cekInstalasi() {
        var instalasiId = $("#FAPendaftaranT_instalasi_id").val();
        if (instalasiId.length > 0) {
            $('#dialogPasien').dialog('open');
            return true;
        } else {
            myAlert("Silakan pilih instalasi ! ");
            $("#FAPendaftaranT_instalasi_id").focus();
            return false;
        }
    }
</script>