<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'catatanedukasi-t-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event);', 'onsubmit' => 'return requiredCheck(this);'),
    'focus' => '#',
        ));
?>

<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/accounting2.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form2.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>

<?php
// if (isset($_GET['sukses'])) {
//     Yii::app()->user->setFlash('success', "Data berhasil disimpan!");
    $this->widget('bootstrap.widgets.BootAlert');
// }
?>
<!--======================================================================-->
<!-- RIWAYAT PELAYANAN PEMBEDAHAN -->
<!--======================================================================-->
<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-user"></i> Riwayat <b>Pelayanan Pembedahan</b>
        </div>
    </div>
    <div class="panel-body">
        <?php
        $this->renderPartial($this->path_view . '_riwayat_pelayanan', array(
            'form' => $form,
            'model' => $model,
            'jenis' => $jenis,
        ));
        ?>
    </div>
</div>
<!--======================================================================-->
<!-- PERSIAPAN PRA BEDAH -->
<!--======================================================================-->
<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-user"></i> Persiapan <b>Pra Bedah</b>
        </div>
    </div>
    <div class="panel-body">
        <?php
        $this->renderPartial($this->path_view . '_persiapan_pra_bedah', array(
            'form' => $form,
            'model' => $model,
            'jenis' => $jenis,
        ));
        ?>
    </div>
</div>
<!--======================================================================-->
<!-- PENANDA LOKASI -->
<!--======================================================================-->
<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-user"></i> Penanda Lokasi</b>
        </div>
    </div>
    <div class="panel-body">
        <?php
        $this->renderPartial($this->path_view . '_penanda_lokasi', array(
            'form' => $form,
            'model' => $model,
            // 'temp_file' => $temp_file,
            'id' => $gambartubuh_id,
            'modAreaOperasi' => $modAreaOperasi,
            'modGambarTubuh' => $modGambarTubuh,
            'modBagianTubuh' => $modBagianTubuh,
            'modAreaDetOp' => $modAreaDetOp,
            'modKunjungan' => $modKunjungan,
            'jenis' => $jenis,
        ));
        ?>
    </div>
</div>
<!--======================================================================-->
<!-- TINDAKAN -->
<!--======================================================================-->
<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-user"></i> Tindakan</b>
        </div>
    </div>
    <div class="panel-body">
        <?php
        $this->renderPartial($this->path_view . '_tindakan', array(
            'form' => $form,
            'model' => $model,
            'tblRencanaOperasi' => $tblRencanaOperasi,
            'jenis' => $jenis,
        ));
        ?>
    </div>
</div>
<!--======================================================================-->
<!-- PEMAKAIAN ALAT -->
<!--======================================================================-->
<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-user"></i> Pemakaian Alat</b>
        </div>
    </div>
    <div class="panel-body">
        <?php
        $this->renderPartial($this->path_view . '_pemakaian_alat', array(
            'form' => $form,
            'model' => $model,
            'jenis' => $jenis,
        ));
        ?>
    </div>
</div>
<div class="form-actions">
    <?php
    echo CHtml::htmlButton(
            $model->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="entypo-check"></i>')) :
                    Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
            array(
                'class' => 'btn btn-danger', 'type' => 'submit',
                'onKeypress' => 'return formSubmit(this,event)',
                'id' => 'btn_simpan', 'onclick' => 'do_upload()',
                'disabled' => $jenis == 'lihat',
            )
    );
    ?>
    <?php
    echo CHtml::link(
            Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
            Yii::app()->createUrl(''),
            array(
                'class' => 'btn btn-default',
                'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;',
                'disabled' => $jenis == 'lihat',
            )
    );
    ?>
</div>

<?php
$this->endWidget('zii.widgets.jui.CJuiDialog');

//========= Dialog buat cari data Alat Kesehatan =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogPerawat',
    'options' => array(
        'title' => 'Daftar Perawat',
        'autoOpen' => false,
        'modal' => true,
        'width' => 980,
        'height' => 600,
        'resizable' => false,
    ),
));

$modPegR = new PegawairuanganV('searchDialogBHP');
$modPegR->unsetAttributes();
if (isset($_GET['PegawairuanganV'])) {
    $modPegR->attributes = $_GET['PegawairuanganV'];
}

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'obatalkes-m-grid',
    'dataProvider' => $modPegR->searchDialogPegRuangan(),
    'filter' => $modPegR,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","javascript:void(0)",array("class"=>"btn-small", 
            "id" => "selectPerawat",
            "onClick" => "
                $(\'.perawat_id\').val($data->pegawai_id);
                $(\'.perawat_nama\').val(\'$data->namaLengkap\');
                $(\'#dialogPerawat\').dialog(\'close\');
                return false;"
                ))',
        ),
        'nomorindukpegawai',
        [
            'header'=>'Nama',
            'name'=>'nama_pegawai',
            'value'=>'$data->namaLengkap'
        ],
        
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();

$instalasi = InstalasiM::model()->findByPk(Yii::app()->user->getState('instalasi_id'));

$ins_exp = explode(" ", $instalasi->instalasi_nama);

?>
<script>
    // (function () {
    //     $(".radioToniket").prop('checked', false);
    // })();

    $('.autoEnable').change(function () {
        var id = $(this).attr('id');
        $("." + id).prop('disabled', true);
        if ($(this).prop('checked')) {
            $("." + id).prop('disabled', false);
        }
    });
    $('.radioToniket').change(function () {
        console.log("mrene");
        $(".jam_pasang_show").show();
        $(".jam_pasang_hide").hide();
        $("#PelayananpembedahanT_torniket_tekanan").prop('disabled', false);
    });

    function renameInputRow(obj_table){
        var row = 0;
        $(obj_table).find("tbody > tr").each(function(){
            $(this).find("#no_urut").val(row+1);
            $(this).find('span[name*="[ii]"]').each(function(){ //element <span>
                var new_name = $(this).attr("name").replace("ii",(row));
                $(this).attr("name",new_name);
            });
            $(this).find('span[name$="[operasi_nama]"]').each(function(){ //element <input>
                var old_name = $(this).attr("name").replace(/]/g,"");
                var old_name_arr = old_name.split("[");
                if(old_name_arr.length == 2){
                    $(this).attr("name","["+row+"]["+old_name_arr[1]+"]");
                }
            });
            $(this).find('input,select,textarea').each(function(){ //element <input>
                var old_name = $(this).attr("name").replace(/]/g,"");
                var old_name_arr = old_name.split("[");
                console.log(old_name, old_name_arr, old_name_arr.length);
                if(old_name_arr.length == 3){
                    $(this).attr("id",old_name_arr[0]+"_"+row+"_"+old_name_arr[2]);
                    $(this).attr("name",old_name_arr[0]+"["+row+"]["+old_name_arr[2]+"]");
                }
                if(old_name_arr.length == 4){
                    $(this).attr("id",old_name_arr[0]+"_" + old_name_arr[1] + "_"+row+"_"+old_name_arr[3]);
                    $(this).attr("name",old_name_arr[0]+"[" + old_name_arr[1] + "]["+row+"]["+old_name_arr[3]+"]");
                }
            });
            row++;
        });
        
    }
    
    function tambahPemakaianBahan(isdialog = undefined) {
        if (isdialog != undefined) {
            var isnonpaket = $("#tipepaket_id :selected").data('isnonpaket');
            $('#dialogPemakaianBahan').dialog('close');
            if (isnonpaket == true) {
                return false;
            }
        }

        $("#tblpemakaianbahan").addClass("animation-loading");
        var isbukanbebanpasien = 0;
        if ($('#isbukanbebanpasien').prop('checked') == true) {
            isbukanbebanpasien = 1;
        }
        // var tipepaket_id = $('#tipepaket_id').val();
        var tipepaket_id = 1;
        var obatalkes_id = $('#obatalkes_id').val();
        var qtypakaibahan = $('#qtypakaibahan').val();
        var isadaoa = false;
        console.log('atas ', tipepaket_id, isadaoa);
        if ($('#obatalkes_id').prop('disabled') == false && obatalkes_id != '') {
            isadaoa = true;
            console.log('if 1 ', tipepaket_id, isadaoa, obatalkes_id);
        } else if ($('#obatalkes_id').prop('disabled') == true) {
            isadaoa = true;
            var isadatipe = false;

            $("#tblpemakaianbahan").find('.trparent').each(function () {
                var idxParent = $(this).attr('idxparent');
                if (tipepaket_id == $(this).find($(this).find('input[name$="[' + idxParent + '][tipepaket_id]"]')).val()) {
                    isadatipe = true;
                    console.log('dalam if 1 ', tipepaket_id, isadaoa);
                }
            });

            if (isadatipe == true) {
                isadaoa = false;
                console.log('dalam if 2 ', tipepaket_id, isadaoa);
            }
            console.log('else if 1 ', tipepaket_id, isadaoa);
        }
        console.log('bawah ', tipepaket_id, isadaoa);
        if (tipepaket_id != '' && isadaoa == true) {
            $.ajax({
                type: 'GET',
                url: '<?php echo $this->createUrl('setLoadBahanMedis'); ?>',
                data: {
                    tipepaket_id: tipepaket_id,
                    isbukanbebanpasien: isbukanbebanpasien,
                    obatalkes_id: obatalkes_id,
                    qtypakaibahan: qtypakaibahan
                },
                dataType: "json",
                success: function (data) {
                    $("#tblpemakaianbahan").append(data.html);
                    generateRowBmhp($("#tblpemakaianbahan"));
                    hitungTotalBmhp();
                    $('#obatalkes_id').val('');
                    $('#obatalkes_nama').val('');
                    $('#qtypakaibahan').val('1');
                    $("#tblpemakaianbahan").removeClass("animation-loading");
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    myAlert("Data Pemakaian Bahan Pasien tidak ditemukan !");
                    $('#obatalkes_id').val('');
                    $('#obatalkes_nama').val('');
                    $('#qtypakaibahan').val('1');
                    $("#tblpemakaianbahan").removeClass("animation-loading");
                }
            });
        } else {
            myAlert("Data Pemakaian Bahan Pasien tidak ditemukan atau sudah ditambahkan!");
            $('#obatalkes_id').val('');
            $('#obatalkes_nama').val('');
            $('#qtypakaibahan').val('1');
            $("#tblpemakaianbahan").removeClass("animation-loading");
    }
    }

    function generateRowBmhp(obj) {
        var nourut = 0;
        for (var i = 0; i < $(obj).find('.nourut').length; i++) {
            var tr = $(obj).find('.nourut').eq(i);
            tr.attr('id', 'Bmhp_' + i + '_nourut');
            tr.attr('name', 'Bmhp[' + i + '][nourut]');
            nourut++;
            tr.val(nourut);
        }

        for (var i = 0; i < $(obj).find('.tgl_pelayanan').length; i++) {
            var tr = $(obj).find('.tgl_pelayanan').eq(i);
            tr.attr('id', 'Bmhp_' + i + '_tgl_pelayanan');
            tr.attr('name', 'Bmhp[' + i + '][tgl_pelayanan]');
            tr.datetimepicker(
                    jQuery.extend(
                            {
                                showMonthAfterYear: false
                            },
                            jQuery.datepicker.regional['id'],
                            {
                                'dateFormat': 'dd M yy',
                                'minDate': 'd',
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

            tr.each(function () {
                var obj = $(this);
                $(this).parent().find(".add-on").click(function () {
                    $(obj).focus();
                });
            });
        }

        for (var i = 0; i < $(obj).find('.tipepaket_id').length; i++) {
            var tr = $(obj).find('.tipepaket_id').eq(i);
            tr.attr('id', 'Bmhp_' + i + '_tipepaket_id');
            tr.attr('name', 'Bmhp[' + i + '][tipepaket_id]');
        }

        for (var i = 0; i < $(obj).find('.tipepaket_nama').length; i++) {
            var tr = $(obj).find('.tipepaket_nama').eq(i);
            tr.attr('id', 'Bmhp_' + i + '_tipepaket_nama');
            tr.attr('name', 'Bmhp[' + i + '][tipepaket_nama]');
        }

        for (var i = 0; i < $(obj).find('.trparent').length; i++) {
            var tr = $(obj).find('.trparent').eq(i);
            tr.attr('id', 'trparent' + i);
            tr.attr('idxparent', i);

            for (var j = 0; j < tr.find('.tblchild_jnsoa').find('.trcld_jnsoa').length; j++) {
                var trc = tr.find('.tblchild_jnsoa').find('.trcld_jnsoa').eq(j);
                trc.attr('id', 'trcld_jnsoa' + i + '_' + j);
                trc.attr('idx', i + '_' + j);
                trc.attr('idxchild', j);
                trc.find('td').removeClass('trcoltd');
                trc.find('td').removeClass('trcoltdwhite');

                if (j % 2 == 0) {
                    trc.find('td').addClass('trcoltdwhite');
                } else {
                    trc.find('td').addClass('trcoltd');
                }

                var trc_chld = tr.find('.tblchild_jnsoa').find('.jenisobatalkes_nama').eq(j);
                trc_chld.attr('id', 'Bmhpchild_' + i + '_' + j + '_jenisobatalkes_nama');
                trc_chld.attr('name', 'Bmhpchild[' + i + '][' + j + '][jenisobatalkes_nama]');
            }

            for (var j = 0; j < tr.find('.tblchild_namaoa').find('.trcld_namaoa').length; j++) {
                var trc = tr.find('.tblchild_namaoa').find('.trcld_namaoa').eq(j);
                trc.attr('id', 'trcld_namaoa' + i + '_' + j);
                trc.attr('idx', i + '_' + j);
                trc.find('td').removeClass('trcoltd');
                trc.find('td').removeClass('trcoltdwhite');

                if (j % 2 == 0) {
                    trc.find('td').addClass('trcoltdwhite');
                } else {
                    trc.find('td').addClass('trcoltd');
                }

                var trc_chld = tr.find('.tblchild_namaoa').find('.obatalkes_id').eq(j);
                trc_chld.attr('id', 'Bmhpchild_' + i + '_' + j + '_obatalkes_id');
                trc_chld.attr('name', 'Bmhpchild[' + i + '][' + j + '][obatalkes_id]');

                var trc_chldoa = tr.find('.tblchild_namaoa').find('.obatalkes_nama').eq(j);
                trc_chldoa.attr('id', 'Bmhpchild_' + i + '_' + j + '_obatalkes_nama');
                trc_chldoa.attr('name', 'Bmhpchild[' + i + '][' + j + '][obatalkes_nama]');
            }

            for (var j = 0; j < tr.find('.tblchild_tglkadaluarsaoa').find('.trcld_tglkadaluarsaoa').length; j++) {
                var trc = tr.find('.tblchild_tglkadaluarsaoa').find('.trcld_tglkadaluarsaoa').eq(j);
                trc.attr('id', 'trcld_tglkadaluarsaoa' + i + '_' + j);
                trc.attr('idx', i + '_' + j);
                trc.find('td').removeClass('trcoltd');
                trc.find('td').removeClass('trcoltdwhite');

                if (j % 2 == 0) {
                    trc.find('td').addClass('trcoltdwhite');
                } else {
                    trc.find('td').addClass('trcoltd');
                }

                var trc_chld = tr.find('.tblchild_tglkadaluarsaoa').find('.tglkadaluarsa').eq(j);
                trc_chld.attr('id', 'Bmhpchild_' + i + '_' + j + '_tglkadaluarsa');
                trc_chld.attr('name', 'Bmhpchild[' + i + '][' + j + '][tglkadaluarsa]');
            }

            for (var j = 0; j < tr.find('.tblchild_hargajualoa').find('.trcld_hargajualoa').length; j++) {
                var trc = tr.find('.tblchild_hargajualoa').find('.trcld_hargajualoa').eq(j);
                trc.attr('id', 'trcld_hargajualoa' + i + '_' + j);
                trc.attr('idx', i + '_' + j);
                trc.find('td').removeClass('trcoltd');
                trc.find('td').removeClass('trcoltdwhite');

                if (j % 2 == 0) {
                    trc.find('td').addClass('trcoltdwhite');
                } else {
                    trc.find('td').addClass('trcoltd');
                }

                var trc_chld = tr.find('.tblchild_hargajualoa').find('.hargajual').eq(j);
                trc_chld.attr('id', 'Bmhpchild_' + i + '_' + j + '_hargajual');
                trc_chld.attr('name', 'Bmhpchild[' + i + '][' + j + '][hargajual]');
            }

            for (var j = 0; j < tr.find('.tblchild_jmloa').find('.trcld_jmloa').length; j++) {
                var trc = tr.find('.tblchild_jmloa').find('.trcld_jmloa').eq(j);
                trc.attr('id', 'trcld_jmloa' + i + '_' + j);
                trc.attr('idx', i + '_' + j);
                trc.find('td').removeClass('trcoltd');
                trc.find('td').removeClass('trcoltdwhite');

                if (j % 2 == 0) {
                    trc.find('td').addClass('trcoltdwhite');
                } else {
                    trc.find('td').addClass('trcoltd');
                }

                var trc_chld = tr.find('.tblchild_jmloa').find('.qty').eq(j);
                trc_chld.attr('id', 'Bmhpchild_' + i + '_' + j + '_qty');
                trc_chld.attr('name', 'Bmhpchild[' + i + '][' + j + '][qty]');
            }

            for (var j = 0; j < tr.find('.tblchild_subtotaloa').find('.trcld_subtotaloa').length; j++) {
                var trc = tr.find('.tblchild_subtotaloa').find('.trcld_subtotaloa').eq(j);
                trc.attr('id', 'trcld_subtotaloa' + i + '_' + j);
                trc.attr('idx', i + '_' + j);
                trc.find('td').removeClass('trcoltd');
                trc.find('td').removeClass('trcoltdwhite');

                if (j % 2 == 0) {
                    trc.find('td').addClass('trcoltdwhite');
                } else {
                    trc.find('td').addClass('trcoltd');
                }

                var trc_chld = tr.find('.tblchild_subtotaloa').find('.subtotal').eq(j);
                trc_chld.attr('id', 'Bmhpchild_' + i + '_' + j + '_subtotal');
                trc_chld.attr('name', 'Bmhpchild[' + i + '][' + j + '][subtotal]');
            }

        }

    }

    function hitungTotalBmhp() {
        unformatNumberSemua();
        var totalAll = 0;

        $('#tblpemakaianbahan').find('.trparent').each(function () {
            var idxParent = $(this).attr('idxparent');

            $('#tblpemakaianbahan').find('.trparent').eq(idxParent).find('.tblchild_jnsoa').find('.trcld_jnsoa').each(function () {
                var idxchild = $(this).attr('idxchild');
                var harga = parseFloat($('#tblpemakaianbahan').find('.trparent').eq(idxParent).find('input[name$="[' + idxParent + '][' + idxchild + '][hargajual]"]').val());
                var qty = parseFloat($('#tblpemakaianbahan').find('.trparent').eq(idxParent).find('input[name$="[' + idxParent + '][' + idxchild + '][qty]"]').val());

                var subtotal = (qty * harga);
                if (subtotal > 0) {
                    subtotal = parseFloat(subtotal.toFixed(2));
                }

                $('#tblpemakaianbahan').find('.trparent').eq(idxParent).find('input[name$="[' + idxParent + '][' + idxchild + '][subtotal]"]').val(subtotal);
                totalAll += subtotal;

            });
        });

        $('#totalbahanmedis').val(totalAll);
        formatNumberSemua();
    }


    function hapusBmhp(obj){
        $(obj).parents('.trparent').detach();
        generateRowBmhp($('#tblpemakaianbahan'));
        hitungTotalBmhp();
        cekForm();
    }

    $(document).ready(function() {

        <?php if(isset($_GET['sukses']) && in_array($instalasi->instalasi_id, array(2, 3, 4))):?>
            window.open('<?php echo Yii::app()->createUrl(strtolower($ins_exp[0]) . ucfirst($ins_exp[1]).'/RekamMedikElektronikPasienRJ/index&pendaftaran_id=' . $_GET['pendaftaran_id'] . '&type=Dokter&active_tab=prabedah'); ?>');
        <?php endif;?>

    });

</script>