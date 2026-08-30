<?php
$this->breadcrumbs = array(
    'Tindakan',
);
$this->widget('bootstrap.widgets.BootAlert');
?>

<style>
    .integer,
    .integer2,
    .currency {
        text-align: right;
    }
</style>

<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'rjtindakan-pelayanan-t-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'focus' => '#',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)'),
)); ?>
<div class="formInputTab">
    <div style="max-height: 400px; overflow-y: scroll;">
        <?php
        if (!empty($modViewTindakans)) {
            $this->renderPartial('_listTindakanPasien', array(
                'modTindakans' => $modViewTindakans,
                'modViewBmhp' => $modViewBmhp,
                'removeButton' => true
            ));
        }
        ?>
    </div>
    <p class="help-block"><?php //echo Yii::t('mds','Fields with <span class="required">*</span> are required.') 
                            ?></p>

    <?php echo $form->dropDownListRow(
        $modTindakan,
        '[0]tipepaket_id',
        Chtml::listData($modTindakan->getTipePaketItems($modAdmisi->carabayar_id, $modAdmisi->penjamin_id), 'tipepaket_id', 'tipepaket_nama'),
        array(
            'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);",
            'onchange' => 'loadTindakanPaket(this.value,"' . $modAdmisi->kelaspelayanan_id . '","' . $modPendaftaran->kelompokumur_id . '")'
        )
    ); ?>
    <?php
    echo CHtml::hiddenField('tipepaket_id', '', array());
    echo CHtml::hiddenField('kelaspelayanan_id', $modAdmisi->kelaspelayanan_id, array());
    echo CHtml::hiddenField('penjamin_id', $modAdmisi->penjamin_id, array());
    echo CHtml::hiddenField('deposit', $modDeposit, array());
    ?>

    <div class="panel panel-success">
        <div class="panel-heading">
            <div class="panel-title">
                <i class="entypo-credit-card"></i> Tabel <b>Tindakan</b>
            </div>
        </div>
        <div class="panel-body table-responsive">
            <table class="items table table-striped table-bordered table-condensed" id="tblInputTindakan">
                <thead>
                    <tr>
                        <th rowspan="2">&nbsp;</th>
                        <th>Kategori Tindakan</th>
                        <th rowspan="2">Uraian Tindakan</th>
                        <th rowspan="2">Tarif Satuan</th>
                        <th rowspan="2">Jumlah</th>
                        <!--<th rowspan="2">Tarif Satuan</th>-->
                        <!--<th rowspan="2">Jumlah Tindakan</th>-->
                        <th rowspan="2">Satuan<br>Tindakan</th>
                        <th rowspan="2">Cyto </th>
                        <th rowspan="2">Tarif Cyto</th>
                        <th rowspan="2">Jumlah Tarif</th>
                    </tr>
                    <tr>
                        <th>Tanggal Tindakan</th>
                    </tr>
                </thead>
                <?php
                $trTindakan = $this->renderPartial('_rowTindakanPasien', array('modTindakan' => $modTindakan, 'modTindakans' => $modTindakans), true);
                echo $trTindakan;
                ?>
            </table>
        </div>
    </div>
    <div hidden>
        <b>Total Nominal Tarif : </b>
        <?php echo CHtml::textField("totalTarif", 0, array('readonly' => true, 'class' => 'inputFormTabel integer')); ?>
    </div>
    <hr>
    <?php echo $form->errorSummary($modTindakan); ?>

    <div class="panel panel-success">
        <div class="panel-heading">
            <div class="panel-title">
                <i class="entypo-credit-card"></i> Tabel <b>Pemakaian Alat Medis</b>
            </div>
        </div>
        <div class="panel-body table-responsive">
            <?php $this->renderPartial('_formPemakaianBahanAlatMedis', array()); ?>
        </div>
    </div>

    <div class="form-actions">
        <?php echo CHtml::htmlButton(
            Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
            array('title' => 'Simpan', 'class' => 'btn btn-danger', 'id' => 'btn_submit', 'type' => 'button', 'onKeypress' => 'cekInput();', 'onClick' => 'cekInput();')
        ); ?>
        <?php
        echo CHtml::link(
            Yii::t(
                'mds',
                '{icon} Print',
                array('{icon}' => '<i class="entypo-print"></i>')
            ),
            'javascript:void(0);',
            array(
                'class' => 'btn btn-info',
                'onclick' => "print(" . $modPendaftaran->pendaftaran_id . ");return false"
            )
        );
        ?>
        <?php
        echo CHtml::link(
            Yii::t(
                'mds',
                '{icon} Edukasi Transfusi',
                array('{icon}' => '<i class="' . MyIcon::getIcons('approve') . '"></i>')
            ),
            'javascript:void(0);',
            array(
                'class' => 'btn btn-primary',
                'onclick' => "$('#dialog-edukasi-transfusi').dialog('open');return false"
            )
        );
        ?>
    </div>

</div>

<?php $this->endWidget(); ?>

<?php $this->renderPartial('_dialogPemeriksa', array('modTindakan' => $modTindakan)); ?>
<?php $this->renderPartial('_dialogPemeriksaLengkap', array('modTindakan' => $modTindakan)); ?>
<?php $this->renderPartial('_dialogEdukasiTransfusi', array('modPendaftaran' => $modPendaftaran)); ?>

<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogDeposit',
    'options' => array(
        'title' => 'Status Deposit Pasien',
        'autoOpen' => false,
        'modal' => true,
        'width' => 950,
        'height' => 550,
        'resizable' => false,
    ),
));
?>
<?php
if (!empty($modBayarUangMuka)) {
    $this->renderPartial('_dialogDeposit', array('modPendaftaran' => $modPendaftaran, 'modPasien' => $modPasien, 'modBayarUangMuka' => $modBayarUangMuka, 'jmluangmuka', $modDeposit));
}
?>
<?php $this->endWidget('zii.widgets.jui.CJuiDialog'); ?>

<script type="text/javascript">
    function print(pendaftaran_id) {
        window.open('<?php echo $this->createUrl('printTindakan'); ?>&id=' + pendaftaran_id, 'printwin', 'left=100,top=100,width=640,height=640');
    }
    // the subviews rendered with placeholders
    var trTindakan = new String(<?php echo CJSON::encode($this->renderPartial('_rowTindakanPasien', array('modTindakan' => $modTindakan, 'removeButton' => true), true)); ?>);
    var trTindakanFirst = new String(<?php echo CJSON::encode($this->renderPartial('_rowTindakanPasien', array('modTindakan' => $modTindakan, 'removeButton' => false), true)); ?>);

    function addRowTindakan(obj) {
        $(obj).parents('table').children('tbody').append(trTindakan.replace());
        <?php
        $attributes = $modTindakan->attributeNames();
        foreach ($attributes as $i => $attribute) {
            echo "renameInput('PITindakanPelayananT','$attribute');";
        }
        ?>
        renameInput('PITindakanPelayananT', 'daftartindakanNama');
        renameInput('PITindakanPelayananT', 'kategoriTindakanNama');
        renameInput('PITindakanPelayananT', 'persenCyto');
        renameInput('PITindakanPelayananT', 'jumlahTarif');
        renameInput('PITindakanPelayananT', 'tgl_tindakan');

        $('#tblInputTindakan tbody').each(function() {
            jQuery('input[name$="[tgl_tindakan]"]').datetimepicker(
                jQuery.extend({
                        showMonthAfterYear: false
                    },
                    jQuery.datepicker.regional['id'], {
                        'dateFormat': 'dd M yy',
                        'maxDate': 'd',
                        'timeText': 'Waktu',
                        'hourText': 'Jam',
                        'minuteText': 'Menit',
                        'secondText': 'Detik',
                        'showSecond': true,
                        'timeOnlyTitle': 'Pilih Waktu',
                        'timeFormat': 'hh:mm:ss',
                        'changeYear': true,
                        'changeMonth': true,
                        'showAnim': 'fold',
                        'yearRange': '-80y:+20y'
                    }
                )
            );
        });

        jQuery('<?php echo Params::TOOLTIP_SELECTOR; ?>').tooltip({
            "placement": "<?php echo Params::TOOLTIP_PLACEMENT; ?>"
        });
        jQuery('input[name$="[daftartindakanNama]"]').autocomplete({
            'showAnim': 'fold',
            'minLength': 2,
            'focus': function(event, ui) {
                $(this).val(ui.item.label);
                return false;
            },
            'select': function(event, ui) {
                setTindakan(this, ui.item);
                return false;
            },
            'source': function(request, response) {
                $.ajax({
                    url: "<?php echo Yii::app()->createUrl('perawatanIntensif/tindakanTPI/DaftarTindakan'); ?>",
                    dataType: "json",
                    data: {
                        term: request.term,
                        tipepaket_id: $("#PITindakanPelayananT_0_tipepaket_id").val(),
                        kelaspelayanan_id: $("#kelaspelayanan_id").val(),
                        penjamin_id: $("#penjamin_id").val(),
                    },
                    success: function(data) {
                        response(data);
                    }
                })
            }
        });
        jQuery('#tblInputTindakan tr:last .tanggal').datetimepicker(jQuery.extend({
            showMonthAfterYear: false
        }, jQuery.datepicker.regional['id'], {
            'dateFormat': 'dd M yy',
            'maxDate': 'd',
            'timeText': 'Waktu',
            'hourText': 'Jam',
            'minuteText': 'Menit',
            'secondText': 'Detik',
            'showSecond': true,
            'timeOnlyTitle': 'Pilih Waktu',
            'timeFormat': 'hh:mm:ss',
            'changeYear': true,
            'changeMonth': true,
            'showAnim': 'fold',
            'yearRange': '-80y:+20y'
        }));
    }

    function batalTindakan(obj) {
        myConfirm("Apakah Anda yakin akan membatalkan tindakan?", "Perhatian!", function(r) {
            if (r) {
                $(obj).parents('tr').next('tr').detach();
                $(obj).parents('tr').detach();

                <?php
                foreach ($attributes as $i => $attribute) {
                    echo "renameInput('PITindakanPelayananT','$attribute');";
                }
                ?>
                renameInput('PITindakanPelayananT', 'daftartindakanNama');
                renameInput('PITindakanPelayananT', 'kategoriTindakanNama');
                renameInput('PITindakanPelayananT', 'persenCyto');
                renameInput('PITindakanPelayananT', 'jumlahTarif');
                renameInput('PITindakanPelayananT', 'tgl_tindakan');
                hitungTotalTarif();
            }
        });
    }

    function deleteTindakan(obj, idTindakanpelayanan) {
        myConfirm("Apakah Anda yakin akan menghapus tindakan?", "Perhatian!", function(r) {
            if (r) {
                $.post('<?php echo $this->createUrl('ajaxDeleteTindakanPelayanan') ?>', {
                    idTindakanpelayanan: idTindakanpelayanan
                }, function(data) {
                    if (data.success && data.pesan == 'berhasil') {
                        window.parent.myAlert('Data berhasil dihapus.');
                        $(obj).parent().parent().detach();
                    } else if (data.pesan == 'gagal') {
                        window.parent.myAlert('Tindakan sudah dibayarkan');
                    } else {
                        window.parent.myAlert('Data Gagal dihapus');
                    }
                }, 'json');
            }
        });
    }

    function renameListTindakan(modelName, attributeName) {
        var trLength = $('#tblInputTindakan tr').length;
        var i = -1;
        $('#tblInputTindakan tr').each(function() {
            if ($(this).has('input[name$="[tarif_satuan]"]').length) {
                i++;
            }
            $(this).find('input[name$="[' + attributeName + ']"]').attr('name', modelName + '[' + i + '][' + attributeName + ']');
            $(this).find('input[name$="[' + attributeName + ']"]').attr('id', modelName + '_' + i + '_' + attributeName + '');
            $(this).find('select[name$="[' + attributeName + ']"]').attr('name', modelName + '[' + i + '][' + attributeName + ']');
            $(this).find('select[name$="[' + attributeName + ']"]').attr('id', modelName + '_' + i + '_' + attributeName + '');
            $(this).find('input[name^="daftartindakanNama["]').attr('name', 'daftartindakanNama[' + i + ']');
            $(this).find('input[name^="daftartindakanNama["]').attr('id', 'daftartindakanNama_' + i + '');
            $(this).find('a[id^="btnAddDokter_"]').attr('id', 'btnAddDokter_' + i + '');
        });
    }

    function renameInput(modelName, attributeName) {
        var trLength = $('#tblInputTindakan tr').length;
        var i = -1;
        $('#tblInputTindakan tr').each(function() {
            if ($(this).has('input[name$="[daftartindakan_id]"]').length) {
                i++;
            }
            $(this).find('input[name$="[' + attributeName + ']"]').attr('name', modelName + '[' + i + '][' + attributeName + ']');
            $(this).find('input[name$="[' + attributeName + ']"]').attr('id', modelName + '_' + i + '_' + attributeName + '');
            $(this).find('select[name$="[' + attributeName + ']"]').attr('name', modelName + '[' + i + '][' + attributeName + ']');
            $(this).find('select[name$="[' + attributeName + ']"]').attr('id', modelName + '_' + i + '_' + attributeName + '');
            $(this).find('input[name^="daftartindakanNama["]').attr('name', 'daftartindakanNama[' + i + ']');
            $(this).find('input[name^="daftartindakanNama["]').attr('id', 'daftartindakanNama_' + i + '');
            $(this).find('a[id^="btnAddDokter_"]').attr('id', 'btnAddDokter_' + i + '');
            $(this).find('div[id^="tampilanDokterPemeriksa_"]').attr('id', 'tampilanDokterPemeriksa_' + i + '');
            $(this).find('div[id^="tampilanDokterPemeriksa2_"]').attr('id', 'tampilanDokterPemeriksa2_' + i + '');
            $(this).find('div[id^="tampilanDokterDelegasi_"]').attr('id', 'tampilanDokterDelegasi_' + i + '');
            $(this).find('div[id^="tampilanBidan_"]').attr('id', 'tampilanBidan_' + i + '');
            $(this).find('div[id^="tampilanSuster_"]').attr('id', 'tampilanSuster_' + i + '');
            $(this).find('div[id^="tampilanPerawat1_"]').attr('id', 'tampilanPerawat1_' + i + '');
            $(this).find('div[id^="tampilanPerawat2_"]').attr('id', 'tampilanPerawat2_' + i + '');
            $(this).find('input[id="row"]').attr('value', i);
            $(this).find('input[id="row"]').val(i);
            $(this).find('input[name^="tgl_tindakan["]').attr('name', 'tgl_tindakan[' + i + ']');
            $(this).find('input[name^="tgl_tindakan["]').attr('id', 'tgl_tindakan_' + i + '');
            // jQuery('input[name$="[daftartindakanNama]"]').datetimepicker(jQuery.extend({showMonthAfterYear:false}, jQuery.datepicker.regional['id'], {'dateFormat':'dd M yy','maxDate':'d','timeText':'Waktu','hourText':'Jam','minuteText':'Menit','secondText':'Detik','showSecond':true,'timeOnlyTitle':'Pilih Waktu','timeFormat':'hh:mm:ss','changeYear':true,'changeMonth':true,'showAnim':'fold','yearRange':'-80y:+20y'}));
            jQuery('input[name^="tgl_tindakan["]').datetimepicker(jQuery.extend({
                showMonthAfterYear: false
            }, jQuery.datepicker.regional['id'], {
                'dateFormat': 'dd M yy',
                'maxDate': 'd',
                'timeText': 'Waktu',
                'hourText': 'Jam',
                'minuteText': 'Menit',
                'secondText': 'Detik',
                'showSecond': true,
                'timeOnlyTitle': 'Pilih Waktu',
                'timeFormat': 'hh:mm:ss',
                'changeYear': true,
                'changeMonth': true,
                'showAnim': 'fold',
                'yearRange': '-80y:+20y'
            }));

        });
    }

    function renameInputPemakaianBahanAlatMedis(modelName, attributeName) {
        var trLength = $('#tblInputPemakaianBahan tr.pemakaian_alat').length;
        var i = -1;
        $('#tblInputPemakaianBahan tr.pemakaian_alat').each(function() {
            i++;
            $(this).find('input[name$="[' + attributeName + ']"]').attr('name', modelName + '[' + i + '][' + attributeName + ']');
            $(this).find('input[name$="[' + attributeName + ']"]').attr('id', modelName + '_' + i + '_' + attributeName + '');
            $(this).find('select[name$="[' + attributeName + ']"]').attr('name', modelName + '[' + i + '][' + attributeName + ']');
            $(this).find('select[name$="[' + attributeName + ']"]').attr('id', modelName + '_' + i + '_' + attributeName + '');
            $(this).find('input[id="row"]').attr('value', i);
            $(this).find('input[id="row"]').val(i);
        });
    }
    // addDokter = tidak digunakan -> diganti dengan addDokterLengkap
    function addDokter(obj) {
        $('#dialogPemeriksa').dialog('open');
        $('#dialogPemeriksa #rowTindakan').val($(obj).attr('id'));
    }

    function addDokterLengkap(obj) {
        $('#dialogPemeriksaLengkap').dialog('open');
        $('#dialogPemeriksaLengkap #rowTindakan').val($(obj).parent().find('input[id="row"]').val());

        var row = $('#dialogPemeriksaLengkap #rowTindakan').val();
        var dokterpemeriksa1 = $('#tampilanDokterPemeriksa_' + row).html();
        var dokterpemeriksa2 = $('#tampilanDokterPemeriksa2_' + row).html();
        //var dokteranastesi = $('#tampilanDokterAnastesi_'+row).html();
        var perawat_id = $('#tampilanPerawat1_' + row).html();
        var perawat2_id = $('#tampilanPerawat2_' + row).html();
        var bidan_id = $('#tampilanBidan_' + row).html();
        //var supir_id = $('#tampilanSupir_'+row).html();

        if (dokterpemeriksa1.indexOf(":") != -1) dokterpemeriksa1 = dokterpemeriksa1.split(":")[1].trim();
        if (dokterpemeriksa2.indexOf(":") != -1) dokterpemeriksa2 = dokterpemeriksa2.split(":")[1].trim();
        //if (dokteranastesi.indexOf(":") != -1) dokteranastesi = dokteranastesi.split(":")[1].trim();
        if (perawat_id.indexOf(":") != -1) perawat_id = perawat_id.split(":")[1].trim();
        if (perawat2_id.indexOf(":") != -1) perawat2_id = perawat2_id.split(":")[1].trim();
        if (bidan_id.indexOf(":") != -1) bidan_id = bidan_id.split(":")[1].trim();
        //if (supir_id.indexOf(":") != -1) supir_id = supir_id.split(":")[1].trim();

        $('#dialogPemeriksaLengkap #dokterpemeriksa1_id').val(dokterpemeriksa1);
        $('#dialogPemeriksaLengkap #dokterpemeriksa2_id').val(dokterpemeriksa2);
        //$('#dialogPemeriksaLengkap #dokteranastesi_id').val(dokteranastesi);
        $('#dialogPemeriksaLengkap #perawat_id').val(perawat_id);
        $('#dialogPemeriksaLengkap #perawat2_id').val(perawat2_id);
        $('#dialogPemeriksaLengkap #bidan_id').val(bidan_id);
        //$('#dialogPemeriksaLengkap #supir_id').val(supir_id);

    }

    function setDefaultDokterPemeriksa1() {
        var dokterId = <?php echo (empty($modTindakan->dokterpemeriksa1_id)) ? "" : $modTindakan->dokterpemeriksa1_id; ?>;
        var dokterNama = "<?php echo (empty($modTindakan->dokterpemeriksa1_id)) ? "" : $modTindakan->dokterpemeriksa1Nama ?>";
        if (dokterId != "") {
            $('#dialogPemeriksaLengkap #dokterpemeriksa1_id').val(dokterNama);
        }
    }
    setDefaultDokterPemeriksa1();

    function setDokterPemeriksa1(item) {
        var row = $('#dialogPemeriksaLengkap #rowTindakan').val();
        $('#PITindakanPelayananT_' + row + '_dokterpemeriksa1_id').val(item.pegawai_id);
        $('#tampilanDokterPemeriksa_' + row).html("Dokter Pemeriksa : " + item.nama_pegawai);
    }

    function updateDokterPemeriksa1(value) {
        if (value == '') {
            var row = $('#dialogPemeriksaLengkap #rowTindakan').val();
            $('#PITindakanPelayananT_' + row + '_dokterpemeriksa1_id').val('');
            $('#tampilanDokterPemeriksa_' + row).html('');
        }
    }

    function setDokterPemeriksa2(value) {
        var row = $('#dialogPemeriksaLengkap #rowTindakan').val();
        $('#PITindakanPelayananT_' + row + '_dokterpemeriksa2_id').val(value.pegawai_id);
        $('#tampilanDokterPemeriksa2_' + row).html("Dokter Pemeriksa 2: " + value.nama_pegawai);
    }

    function updateDokterPemeriksa2(value) {
        if (value == '') {
            var row = $('#dialogPemeriksaLengkap #rowTindakan').val();
            $('#PITindakanPelayananT_' + row + '_dokterpemeriksa2_id').val('');
            $('#tampilanDokterPemeriksa2_' + row).html('');
        }
    }

    // function setDokterPendamping(item)
    // {
    //     var idBtnAddDokter = $('#dialogPemeriksaLengkap #rowTindakan').val();
    //     $('#'+idBtnAddDokter).parents('td').find('input[name$="[dokterpendamping_id]"]').val(item.pegawai_id);
    // }

    // function setDokterAnastesi(item)
    // {
    //     var idBtnAddDokter = $('#dialogPemeriksaLengkap #rowTindakan').val();
    //     $('#'+idBtnAddDokter).parents('td').find('input[name$="[dokteranastesi_id]"]').val(item.pegawai_id);
    // }

    function setDokterDelegasi(item) {
        var row = $('#dialogPemeriksaLengkap #rowTindakan').val();
        $('#PITindakanPelayananT_' + row + '_dokterdelegasi_id').val(item.pegawai_id);
        $('#tampilanDokterDelegasi_' + row).html("Dokter : " + item.nama_pegawai);
    }

    function updateDokterDelegasi(value) {
        if (value == '') {
            var row = $('#dialogPemeriksaLengkap #rowTindakan').val();
            $('#PITindakanPelayananT_' + row + '_dokterdelegasi_id').val('');
            $('#tampilanDokterDelegasi_' + row).html('');
        }
    }

    function setBidan(item) {
        var row = $('#dialogPemeriksaLengkap #rowTindakan').val();
        $('#PITindakanPelayananT_' + row + '_bidan_id').val(item.pegawai_id);
        $('#tampilanBidan_' + row).html("Perawat 3 : " + item.nama_pegawai);
    }

    function updateBidan(value) {
        if (value == '') {
            var row = $('#dialogPemeriksaLengkap #rowTindakan').val();
            $('#PITindakanPelayananT_' + row + '_bidan_id').val('');
            $('#tampilanBidan_' + row).html('');
        }
    }

    function setSuster(item) {
        var row = $('#dialogPemeriksaLengkap #rowTindakan').val();
        $('#PITindakanPelayananT_' + row + '_suster_id').val(item.pegawai_id);
        $('#tampilanSuster_' + row).html("Paramedis 2 : " + item.nama_pegawai);
    }

    function updateSuster(value) {
        if (value == '') {
            var row = $('#dialogPemeriksaLengkap #rowTindakan').val();
            $('#PITindakanPelayananT_' + row + '_suster_id').val('');
            $('#tampilanSuster_' + row).html('');
        }
    }

    function setPerawat(item) {
        var row = $('#dialogPemeriksaLengkap #rowTindakan').val();
        $('#PITindakanPelayananT_' + row + '_perawat_id').val(item.pegawai_id);
        $('#tampilanPerawat1_' + row).html("Perawat 1 : " + item.nama_pegawai);
    }

    function updatePerawat(value) {
        if (value == '') {
            var row = $('#dialogPemeriksaLengkap #rowTindakan').val();
            $('#PITindakanPelayananT_' + row + '_perawat_id').val('');
            $('#tampilanPerawat1_' + row).html('');
        }
    }

    function setPerawat2(value) {
        var row = $('#dialogPemeriksaLengkap #rowTindakan').val();
        $('#PITindakanPelayananT_' + row + '_perawat2_id').val(value.pegawai_id);
        $('#tampilanPerawat2_' + row).html("Perawat 2 : " + value.nama_pegawai);
    }

    function updatePerawat2(value) {
        if (value == '') {
            var row = $('#dialogPemeriksaLengkap #rowTindakan').val();
            $('#PITindakanPelayananT_' + row + '_perawat2_id').val('');
            $('#tampilanPerawat2_' + row).html('');
        }
    }

    function setDokterPemeriksaSemua() {
        var row = $('#dialogPemeriksaLengkap #rowTindakan').val();

        var dokterdelegasi_idX = $("#dokterdelegasi_idX").val();
        var dokterdelegasi_id = $("#dokterdelegasi_id").val();
        $('#RITindakanPelayananT_' + row + '_dokterdelegasi_id').val(dokterdelegasi_idX);
        $('#tampilanDokterDelegasi_' + row).html("Dokter : " + dokterdelegasi_id);

        var bidan_id = $("#bidan_id").val();
        var bidan_idX = $("#bidan_idX").val();
        $('#RITindakanPelayananT_' + row + '_bidan_id').val(bidan_idX);
        $('#tampilanBidan_' + row).html("Paramedis 1 : " + bidan_id);

        var perawat_id = $("#perawat_id").val();
        var perawat_idX = $("#perawat_idX").val();
        $('#RITindakanPelayananT_' + row + '_suster_id').val(perawat_idX);
        $('#tampilanSuster_' + row).html("Paramedis 2 : " + perawat_id);

        var suster_id = $("#suster_id").val();
        var suster_idX = $("#suster_idX").val();
        $('#RITindakanPelayananT_' + row + '_perawat_id').val(suster_idX);
        $('#tampilanPerawat_' + row).html("Paramedis 3 : " + suster_id);
    }

    function setTindakan(obj, item) {
        var hargaTindakan = unformatNumber(item.harga_tariftindakan);
        var subsidiAsuransi = unformatNumber(item.subsidiasuransi);
        var subsidiPemerintah = unformatNumber(item.subsidipemerintah);
        var subsidiRumahsakit = unformatNumber(item.subsidirumahsakit);
        if (isNaN(subsidiAsuransi)) subsidiAsuransi = 0;
        if (isNaN(subsidiPemerintah)) subsidiPemerintah = 0;
        if (isNaN(subsidiRumahsakit)) subsidiRumahsakit = 0;
        $(obj).parents('tr').find('input[name$="[kategoriTindakanNama]"]').val(item.kategoritindakan_nama);
        $(obj).parents('tr').find('input[name$="[daftartindakan_id]"]').val(item.daftartindakan_id);
        $(obj).parents('tr').find('input[name$="[tarif_satuan]"]').val(formatNumber(item.harga_tariftindakan));
        $(obj).parents('tr').find('input[name$="[qty_tindakan]"]').val('1');
        $(obj).parents('tr').find('input[name$="[persenCyto]"]').val(formatNumber(item.persencyto_tind));
        $(obj).parents('tr').find('input[name$="[jumlahTarif]"]').val(formatNumber(item.harga_tariftindakan));
        $(obj).parents('tr').find('input[name$="[subsidiasuransi_tindakan]"]').val(formatNumber(item.subsidiasuransi));
        $(obj).parents('tr').find('input[name$="[subsidipemerintah_tindakan]"]').val(formatNumber(item.subsidipemerintah));
        $(obj).parents('tr').find('input[name$="[subsisidirumahsakit_tindakan]"]').val(formatNumber(item.subsidirumahsakit));
        $(obj).parents('tr').find('input[name$="[iurbiaya_tindakan]"]').val(formatNumber(hargaTindakan - (subsidiAsuransi + subsidiPemerintah + subsidiRumahsakit)));
        //$(obj).parents('tr').find('input[name$="[iurbiaya_tindakan]"]').val(item.iurbiaya);
        tambahTindakanPemakaianBahan(item.daftartindakan_id, item.label);

        //var tombolAddDokter = $(obj).parents('tr').next().find('a');
        //DIDISABLE KARENA DEFAULT SUDAH DOKTER SAAT PENDAFTARAN >>> addDokter(tombolAddDokter);
        // inputBMHP(item.daftartindakan_id, $("#PIPendaftaranT_kelompokumur_id").val());
        hitungTotalTarif();
    }

    function tambahTindakanPemakaianBahan(value, label) {
        if ($("#daftartindakanPemakaianBahan option[value='" + value + "']").length == 0) {
            $('#daftartindakanPemakaianBahan').append('<option value="' + value + '">' + label + '</option>');
        }
    }

    function loadTindakanPaket(tipepaket_id, kelaspelayanan_id, kelompokumur_id) {
        //window.parent.myAlert(tipepaket_id);
        //var idNonPaket = <?php echo Params::TIPEPAKET_ID_NONPAKET; ?>; 

        $.post('<?php echo Yii::app()->createUrl('perawatanIntensif/tindakanTPI/loadFormTindakanPaket') ?>', {
            tipepaket_id: tipepaket_id,
            kelaspelayanan_id: kelaspelayanan_id,
            kelompokumur_id: kelompokumur_id
        }, function(data) {
            if (data.form == '')
                $('#tblInputTindakan > tbody').html(trTindakanFirst.replace());
            else
                $('#tblInputTindakan > tbody').html(data.form);

            $("#tblInputTindakan > tbody .integer").maskMoney({
                "symbol": "",
                "defaultZero": true,
                "allowZero": true,
                "decimal": ".",
                "thousands": ",",
                "precision": 0
            });
            $('.integer').each(function() {
                this.value = formatNumber(this.value)
            });

            $('#tblInputPaketBhp > tbody').html(data.formPaketBmhp);
            $('#totHargaBmhp').val(formatNumber(data.totHargaBmhp));
            $('#tblInputPemakaianBahan > tbody').html('');
            $('#daftartindakanPemakaianBahan').html(data.optionDaftarttindakan);

            jQuery('<?php echo Params::TOOLTIP_SELECTOR; ?>').tooltip({
                "placement": "<?php echo Params::TOOLTIP_PLACEMENT; ?>"
            });
            jQuery('input[name$="[daftartindakanNama]"]').autocomplete({
                'showAnim': 'fold',
                'minLength': 2,
                'focus': function(event, ui) {
                    $(this).val(ui.item.label);
                    return false;
                },
                'select': function(event, ui) {
                    setTindakan(this, ui.item);
                    return false;
                },
                'source': function(request, response) {
                    $.ajax({
                        url: "<?php echo Yii::app()->createUrl('perawatanIntensif/tindakanTPI/DaftarTindakan'); ?>",
                        dataType: "json",
                        data: {
                            term: request.term,
                            tipepaket_id: $("#PITindakanPelayananT_0_tipepaket_id").val(),
                            kelaspelayanan_id: $("#kelaspelayanan_id").val(),
                        },
                        success: function(data) {
                            response(data);
                        }
                    })
                }
            });
            jQuery('input[name$="[tgl_tindakan]"]').datetimepicker(jQuery.extend({
                showMonthAfterYear: false
            }, jQuery.datepicker.regional['id'], {
                'dateFormat': 'dd M yy',
                'maxDate': 'd',
                'timeText': 'Waktu',
                'hourText': 'Jam',
                'minuteText': 'Menit',
                'secondText': 'Detik',
                'showSecond': true,
                'timeOnlyTitle': 'Pilih Waktu',
                'timeFormat': 'hh:mm:ss',
                'changeYear': true,
                'changeMonth': true,
                'showAnim': 'fold',
                'yearRange': '-80y:+20y'
            }));
        }, 'json');

    }

    function hitungCyto(obj) {
        var tarifSatuan = unformatNumber($(obj).parents("#tblInputTindakan tr").find('input[name$="[tarif_satuan]"]').val());
        var qty = unformatNumber($(obj).parents("#tblInputTindakan tr").find('input[name$="[qty_tindakan]"]').val());
        var persenCyto = unformatNumber($(obj).parents("#tblInputTindakan tr").find('input[name$="[persenCyto]"]').val());
        var cyto = unformatNumber($(obj).parents("#tblInputTindakan tr").find('select[name$="[cyto_tindakan]"]').val());
        if (cyto == '0')
            persenCyto = 0;
        var tarifCyto = qty * tarifSatuan * persenCyto / 100;
        var subTotal = tarifSatuan * qty + tarifCyto;
        $(obj).parents("#tblInputTindakan tr").find('input[name$="[tarifcyto_tindakan]"]').val(formatNumber(tarifCyto));
        $(obj).parents("#tblInputTindakan tr").find('input[name$="[jumlahTarif]"]').val(formatNumber(subTotal));
        hitungTotal();
        hitungTotalTarif();
    }

    function hitungSubtotal(obj) {
        var tarifSatuan = unformatNumber($(obj).parents("#tblInputTindakan tr").find('input[name$="[tarif_satuan]"]').val());
        var qty = unformatNumber($(obj).parents("#tblInputTindakan tr").find('input[name$="[qty_tindakan]"]').val());
        var persenCyto = unformatNumber($(obj).parents("#tblInputTindakan tr").find('input[name$="[persenCyto]"]').val());
        var cyto = unformatNumber($(obj).parents("#tblInputTindakan tr").find('select[name$="[cyto_tindakan]"]').val());
        if (cyto == '0')
            persenCyto = 0;
        var tarifCyto = qty * tarifSatuan * persenCyto / 100;
        var subTotal = tarifSatuan * qty + tarifCyto;
        $(obj).parents("#tblInputTindakan tr").find('input[name$="[tarifcyto_tindakan]"]').val(formatNumber(tarifCyto));
        $(obj).parents("#tblInputTindakan tr").find('input[name$="[jumlahTarif]"]').val(formatNumber(subTotal));
        hitungTotal();
        hitungTotalTarif();
    }

    function hitungTotalTarif() {
        var totalTarif = 0;
        $('#tblInputTindakan > tbody > tr').each(function() {
            totalTarif += unformatNumber($(this).find('input[name*="[jumlahTarif]"]').val());
        });
        $('#totalTarif').val(formatNumber(totalTarif));
    }

    function testUpdateStok(qty, obatalkes_id) {
        $.post('<?php echo $this->createUrl('updateStok') ?>', {
            qty: qty,
            obatalkes_id: obatalkes_id
        }, function(data) {
            window.parent.myAlert(data.input);
        }, 'json');
    }

    function cekInput() {
        var kosong = 0;
        var deposit = $('#deposit').val();
        var totTarif = unformatNumber($('#totalTarif').val());
        var totPemakaianBahan = unformatNumber($('#totPemakaianBahan').val());
        var totHargaBmhp = unformatNumber($('#totHargaBmhp').val());
        var total = totPemakaianBahan + totHargaBmhp + totTarif;

        $('.integer').each(function() {
            this.value = unformatNumber(this.value)
        });
        $('.number').each(function() {
            this.value = unformatNumber(this.value)
        });
        $('#tblInputTindakan').find('[name*="daftartindakan_id"]').each(function() {
            if ($(this).val() == "") {
                kosong++;
            }
        });
        if (kosong == 0) {
            //        return true;  
        } else {
            window.parent.myAlert('Isi dulu uraian tindakan!');
            return false;
        }
        hitungTotalTarif();
        if (deposit == "") {
            //		 window.parent.myConfirm("Pasien Belum Melakukan Deposit!","Perhatian!",function(r) {
            //			if(r){	
            //				// notifikasi
            //				var totalTarif =  $('#totalTarif').val();
            //				var params = [];
            //				params = {instalasi_id:<?php // echo Yii::app()->user->getState("instalasi_id"); 
                                                        ?>, modul_id:19, judulnotifikasi:'Deposit Tidak Mencukupi', isinotifikasi:'<?php echo $modPasien->nama_pasien ?> / <?php echo $modPasien->no_rekam_medik;
                                                                                                                                                                            echo "-";
                                                                                                                                                                            echo $modPendaftaran->no_pendaftaran; ?> diruangan <?php echo $modPendaftaran->ruangan->ruangan_nama ?> tidak mencukupi. Total  Deposit = Rp <?php // echo isset($modDeposit)? MyFormatter::formatUang($modDeposit) : 0; 
                                                                                                                                                                                                                                                                                                                            ?>. Total Tagihan = Rp ' + totalTarif + '. Silakan hubungi kasir'};
            //				simpanNotifikasi(params);
            simpanTransaksi();
            //			}
            //		});
        } else {
            if (deposit < total) {
                var pendaftaran_id = <?php echo $_GET['pendaftaran_id']; ?>;

                $.ajax({
                    type: 'POST',
                    url: "<?php echo $this->createUrl('cekDeposit'); ?>",
                    dataType: "json",
                    data: {
                        pendaftaran_id: pendaftaran_id
                    },
                    success: function(data) {
                        if (data.tglperjanjian == null) {
                            $('#dialogDeposit').dialog("open");
                            window.parent.myAlert("Uang deposit pasien tidak mencukupi, Buat tanggal perjanjian terlebih dahulu");
                        } else {
                            $.ajax({
                                type: 'POST',
                                url: "<?php echo $this->createUrl('cekTanggalPerjanjian'); ?>",
                                dataType: "json",
                                data: {
                                    bayaruangmuka_id: data.bayaruangmuka_id
                                },
                                success: function(data) {
                                    if (data == true) {
                                        simpanTransaksi();
                                    } else {
                                        $('#dialogDeposit').dialog("open");
                                        window.parent.myAlert("Uang deposit pasien tidak mencukupi , Perbaharui tanggal perjanjian terlebih dahulu");
                                    }
                                }
                            });
                        }
                    }
                });
            } else {
                simpanTransaksi();
            }
        }
    }

    function simpanTransaksi() {
        disableOnSubmit('#btn_submit');
        $('#rjtindakan-pelayanan-t-form').submit();
    }

    function simpanDeposit() {
        var bayaruangmuka_id = $("#<?php echo CHtml::activeId($modBayarUangMuka, 'bayaruangmuka_id'); ?>").val();
        var tglperjanjian = $("#<?php echo CHtml::activeId($modBayarUangMuka, 'tglperjanjian'); ?>").val();
        var ketperjanjian = $("#<?php echo CHtml::activeId($modBayarUangMuka, 'keterangan_perjanjian'); ?>").val();
        if ((tglperjanjian != '') && (ketperjanjian != '')) {
            $('#btn_savedeposit').addClass('animation-loading-1');
            $.ajax({
                type: 'POST',
                url: "<?php echo $this->createUrl('UpdateDepositPasien'); ?>",
                dataType: "json",
                data: {
                    bayaruangmuka_id: bayaruangmuka_id,
                    tglperjanjian: tglperjanjian,
                    ketperjanjian: ketperjanjian
                },
                success: function(data) {
                    if (data == true) {
                        window.parent.myAlert("Berhasil disimpan! untuk melanjutkan klik 'Lanjutkan' ");
                        $('#btn_savedeposit').attr('disabled', true);
                        $('#btn_lanjutdeposit').attr('disabled', false);
                        $("#<?php echo CHtml::activeId($modBayarUangMuka, 'tglperjanjian'); ?>").attr('disabled', true);
                        $("#<?php echo CHtml::activeId($modBayarUangMuka, 'keterangan_perjanjian'); ?>").attr('disabled', true);
                    } else {
                        window.parent.myAlert("Gagal disimpan");
                    }
                    $('#btn_savedeposit').removeClass('animation-loading-1');
                }
            });
        } else {
            window.parent.myAlert('Tanggal Perjanjian dan Keterangan Perjanjian tidak boleh kosong');
        }
    }

    function setDialog(obj) {
        $("#dialogpemeriksaan-m-grid").find("tr").removeClass("yellow_background");
        var tipepaket_id = $("#<?php echo CHtml::activeId($modTindakan, '[0]tipepaket_id'); ?>").val();
        var kelaspelayanan_id = $('#kelaspelayanan_id').val();
        var penjamin_id = <?php echo $modAdmisi->penjamin_id; ?>;
        var jenistarif_id = <?php echo $modJenisTarif->jenistarif_id; ?>;
        var jenistarif_nama = "<?php echo "Daftar Tindakan - " . $modJenisTarif->jenistarif->jenistarif_nama; ?>";
        //    $.get('<?php echo Yii::app()->createUrl($this->route, array('pendaftaran_id' => $modPendaftaran->pendaftaran_id)); ?>',{'set_tindakan':1,tipepaket_id: tipepaket_id, kelaspelayanan_id:kelaspelayanan_id},function(data){
        //        $("#tableDaftarTindakanPaket").html(data);
        //    });
        $('#tipepaket_id').val(tipepaket_id);
        $('#kelaspelayanan_id').val(kelaspelayanan_id);
        $.fn.yiiGridView.update('giladiagnosa-m-grid2', {
            data: {
                "PIPaketpelayananV[kelaspelayanan_id]": kelaspelayanan_id,
                "PIPaketpelayananV[tipepaket_id]": tipepaket_id,
                "PIPaketpelayananV[penjamin_id]": penjamin_id,
                "PIPaketpelayananV[jenistarif_id]": jenistarif_id,
            }
        });
        $("#ui-dialog-title-dialogDaftarTindakanPaket").html(jenistarif_nama);
        parent = $(obj).parents(".input-append").find("input").attr("id");
        dialog = "#dialogDaftarTindakanPaket";
        $(dialog).attr("parent-dialog", parent);
        $(dialog).dialog("open");
    }

    function setTindakanAuto(kelaspelayanan_id, daftartindakan_id) {
        tipepaket_id = $("#<?php echo CHtml::activeId($modTindakan, '[0]tipepaket_id'); ?>").val();
        kelaspelayanan_id = $('#kelaspelayanan_id').val();
        penjamin_id = $('#penjamin_id').val();
        daftartindakan_id = daftartindakan_id;
        dialog = "#dialogDaftarTindakanPaket";
        /*
        if(idDlg != null)
        {
            dialog = idDlg;
        }
        */
        parent = $(dialog).attr("parent-dialog");
        obj = $("#" + parent);
        $.get('<?php echo Yii::app()->createUrl('perawatanIntensif/tindakanTPI/daftarTindakan'); ?>', {
            tipepaket_id: tipepaket_id,
            kelaspelayanan_id: kelaspelayanan_id,
            daftartindakan_id: daftartindakan_id,
            penjamin_id: penjamin_id
        }, function(data) {
            $(obj).val(data[0].kategoritindakan_nama);
            $(obj).val(data[0].daftartindakan_nama);
            setTindakan(obj, data[0]);
        }, "json");
        $(dialog).dialog("close");

    }

    function cekInputQty(obj) {
        if ($(obj).val() == 0) {
            $(obj).val(1);
        }
    }
</script>
<?php
//========= Dialog buat daftar tindakan  =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogDaftarTindakanPaket',
    'options' => array(
        'title' => 'Daftar Tindakan',
        'autoOpen' => false,
        'modal' => true,
        'width' => 800,
        'height' => 440,
        'resizable' => false,
    ),
));

echo '<div id="tableDaftarTindakanPaket"></div>';
$this->renderPartial('_daftarTindakanPaket');

$this->endWidget('zii.widgets.jui.CJuiDialog');
//========= end daftar tindakan =============================
?>
<div style='display:none;'>
    <?php
    $this->widget('MyDateTimePicker', array(
        'name' => 'testingkktest',
        'mode' => 'datetime',
        'options' => array(
            'dateFormat' => Params::DATE_FORMAT,
            'maxDate' => 'd',
        ),
        'htmlOptions' => array(
            'readonly' => true,
            'onkeypress' => "return $(this).focusNextInputField(event)", 'id' => 'PITindakanPelayananT_0_tgl_tindakan'
        ),
    ));
    ?>
</div>