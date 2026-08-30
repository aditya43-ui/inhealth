<?php
$this->breadcrumbs = array(
    'Kantong Darah HD',
);
$myicon = new MyIcon();

?>
<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'kantongdarahhd-t-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
//        'focus'=>'#namaObatNonRacik',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)', 'onsubmit' => 'return requiredCheck(this);'),
        ));
?>

<?php
$this->Widget('ext.bootstrap.widgets.BootAccordion', array(
    'id' => 'list-rujukankeluar',
    'content' => array(
        'content-detailpasien' => array(
            'header' => CHtml::htmlButton("<i class='icon-minus icon-white'></i>", array('class' => 'btn btn-primary btn-mini', 'onclick' => '', 'onkeyup' => "return $(this).focusNextInputField(event)", 'rel' => 'tooltip', 'title' => 'Klik untuk tampilkan Riwayat Data Kantong Darah')) . '<b> Riwayat Kantong Darah</b>',
            'isi' => $this->renderPartial($this->path_view . '_listHD', array(
                'model' => $model,
                'modPendaftaran' => $modPendaftaran,
                'modPasien' => $modPasien,
                'loadRiwayat' => $loadRiwayat,
                    ), true),
            'active' => true,
        ),
    ),
));
?>
<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">Data Kantong Darah</div>
    </div>
    <div class="panel-body">
<?php
$this->widget('bootstrap.widgets.BootAlert');
?>
        <div class="row-fluid">
            <div class="span12">
                <div class="row-fluid">
                    <div class="span6">
                        <div class="control-group ">
                                <?php echo CHtml::label('Tanggal darah diterima di ruang rawat', 'tanggal', array('class' => 'control-label required')) ?>
                            <div class="controls">
                                <?php
                                $this->widget('MyDateTimePicker', array(
                                    'model' => $model,
                                    'attribute' => 'waktu_darah_diterima',
                                    'mode' => 'datetime',
                                    'options' => array(
                                        'dateFormat' => Params::DATE_FORMAT,
                                        'maxDate' => 'd',
                                        'yearRange' => "-60:+0",
                                    ),
                                    'htmlOptions' => array('readonly' => true, 'class' => 'dtPicker3 span3', 'onkeypress' => "return $(this).focusNextInputField(event)"
                                    ),
                                ));
                                ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">Suhu cool box</label>
                            <div class="controls">
<?= $form->textField($model, 'suhu_coolbox', array('onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span3 float')); ?> <label>&#8451;</label>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">Nama DPJP</label>
                            <div class="controls">
<?= $form->hiddenField($model, 'pegawai_id', array('onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span3')); ?>
<?= $form->textField($model, 'nama_pegawai', array('onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span3', 'disabled' => true)); ?>
                            </div>
                        </div>
                    </div>
                    <div class="span6">
                        <div class="control-group ">
                                    <?php echo CHtml::label('Obat-obat yang diberikan sebelum transfusi', 'obat-obat', array('class' => 'control-label')) ?>
                                    <?php echo CHtml::hiddenField('obat_id', '', array('readonly' => true, )); ?>
                            <div class="controls">
                                    <?= CHtml::textField('nama_obat', '', array('onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span3')); ?> 
                            </div>
                            <div class="controls">
                                <?=
                                    CHtml::link('<span style="font-size:20px"><i class="fa fa-plus"></i></span>', 'javascript:void(0);', array('class' => '',
                                        'onclick' => "addObat();return false", 'style' => 'margin-left:10px;')) . "&nbsp;";
                                    ?>
                            </div>
                        </div>
                        <table id="tbl-obat" width="100%">
                            <tbody>
                                        <?php if (count($loadObat) > 0) : ?>
                                            <?php foreach ($loadObat as $i => $load) : ?>     
                                                <?= $this->renderPartial('_addObat',['modObat'=>$load, 'key'=>$i], true); ?>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="span12 overflow-x">
                        <table class="table table-striped" id="tbl-kantongdarah">
                            <tr>
                                <th>No. Kantong Darah</th>
                                <th>Jenis Darah</th>
                                <th>Volume Darah (ml)</th>
                                <th>Petugas Transfusi</th>
                                <th>Petugas Verifikasi</th>
                                <th style="text-align: center;"> <a href="javascript:void(0)" onclick="AddRow()"><span style="font-size:20px"><i class="fa fa-plus"></i></span></a></th>
                            </tr>
                            <tbody>
                                        <?php if (count($modKantongDarah) > 0) : ?>
                                            <?php foreach ($modKantongDarah as $row => $value) : ?>
                                        <tr class="tr-kantong" baris="<?= $row; ?>">
                                            <td>
                                                <?= CHtml::activeTextField($modDetail, '[' . $row . ']no_kantongdarah', array('readonly' => true, 'class' => 'span3', 'value' => $value->no_kantongdarah)); ?>
                                            </td>
                                            <td>
                                                <?php
                                                $jenisKomponen = JeniskomponendarahM::model()->find("LOWER(jeniskomponenedarah_nama) = LOWER('" . $value->namakomponendrh . "')");
                                                ?>
                                                <?= $form->HiddenField($modDetail, '[' . $row . ']jeniskomponendarah_id', array('onkeypress' => "return $(this).focusNextInputField(event)", 'class' => '', 'value' => $jenisKomponen->jeniskomponendarah_id)); ?>
                                                <?= CHtml::activeTextField($modDetail, '[' . $row . ']jeniskomponendarah_nama', array('disabled' => true, 'class' => 'span2', 'value' => $jenisKomponen->jeniskomponenedarah_nama)); ?>
                                            </td>
                                            <td>
                                                <?php $volume = $value->volume; ?>
                                                <?= CHtml::activeTextField($modDetail, '[' . $row . ']volume_darah', array('readonly' => true, 'class' => 'span1', 'value' => $value->volume)); ?>
                                            </td>
                                            <td>
                                                <?= $form->HiddenField($modDetail, '[' . $row . ']petugas_transfusi_id', array('onkeypress' => "return $(this).focusNextInputField(event)", 'class' => '', 'value' => (!empty($value->petugas_transfusi_id)) ? $value->petugas_transfusi_id : "")); ?>
                                                <?php
                                                $this->widget('MyJuiAutoComplete', array(
                                                    'model' => $modDetail,
                                                    'attribute' => '[' . $row . ']petugas_transfusi_nama',
                                                    'source' => 'js: function(request, response) {
                                                            $.ajax({
                                                                    url: "' . $this->createUrl('AutoCompletePerawat') . '",
                                                                    dataType: "json",
                                                                    data: {
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
                                                                    $(this).val( ui.item.label);
                                                                    return false;
                                                             }',
                                                        'select' => 'js:function( event, ui ) {
                                                                    $("#perawat1_id").val(ui.item.perawat1_id); 
                                                                    $("#perawat1_nama").val(ui.item.perawat1_nama);
                                                                    return false;
                                                            }',
                                                    ),
                                                    //                                'tombolDialog' => array('idDialog' => 'dialogPerawat1'),
                                                    'tombolDialog' => array('idDialog' => 'dialogTransfusi', 'jsFunction' => 'setTransfusi(this); $("#dialogTransfusi").dialog("open")'),
                                                    'htmlOptions' => array('class' => 'span4', 'value' => (!empty($value->petugas_transfusi_nama) ? $value->petugas_transfusi_nama : "")),
                                                ));
                                                ?>
                                            </td>
                                            <td>
                                                <?= $form->HiddenField($modDetail, '[' . $row . ']petugas_verifikasi_id', array('onkeypress' => "return $(this).focusNextInputField(event)", 'class' => '', 'value' => (!empty($value->petugas_verifikasi_id)) ? $value->petugas_verifikasi_id : "")); ?>
                                                <?php
                                                $this->widget('MyJuiAutoComplete', array(
                                                    'model' => $modDetail,
                                                    'attribute' => '[' . $row . ']petugas_verifikasi_nama',
                                                    'source' => 'js: function(request, response) {
                                                            $.ajax({
                                                                    url: "' . $this->createUrl('AutoCompletePerawat') . '",
                                                                    dataType: "json",
                                                                    data: {
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
                                                                    $(this).val( ui.item.label);
                                                                    return false;
                                                             }',
                                                        'select' => 'js:function( event, ui ) {
                                                                    $("#perawat1_id").val(ui.item.perawat1_id); 
                                                                    $("#perawat1_nama").val(ui.item.perawat1_nama);
                                                                    return false;
                                                            }',
                                                    ),
                                                    //                                'tombolDialog' => array('idDialog' => 'dialogPerawat1'),
                                                    'tombolDialog' => array('idDialog' => 'dialogVerifikasi', 'jsFunction' => 'setVerifikasi(this); $("#dialogVerifikasi").dialog("open")'),
                                                    'htmlOptions' => array('class' => 'span4', 'value' => (!empty($value->petugas_verifikasi_nama) ? $value->petugas_verifikasi_nama : "")),
                                                ));
                                                ?>
                                            </td>
                                            <td>
                                        <?php echo CHtml::link(Yii::t('mds', '{icon}', array('{icon}' => '<i class="icon-trash"></i>')), 'javascript:void(0);', array('class' => '', 'onclick' => "batalKantongDarah(this);return false")) . "&nbsp;"; ?>
                                            </td>
                                        </tr>
    <?php endforeach; ?>
<?php endif; ?>
                            </tbody>

                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row-fluid">
    <div class="span12">
        <div class="form-actions">

            <?php
            if (isset($_GET['sukses'])) {
                echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="'.$myicon::getIcons('simpan').'"></i>')), array('class' => 'btn btn-danger', 'id' => 'btn_submit', 'disabled' => true)) . "&nbsp";
                echo CHtml::link(Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="'.$myicon::getIcons('ulang').'"></i>')), $this->createUrl($this->id . '/index&pendaftaran_id=' . $_GET['pendaftaran_id']), array(
                    'class' => 'btn btn-default',
                    'onclick' => 'myConfirm("Apakah anda ingin mengulang ini ?","Perhatian!",function(r){if(r) window.location = "' . $this->createUrl($this->id . '/index&pendaftaran_id=' . $_GET['pendaftaran_id']) . '";}); return false;'
                )) . "&nbsp";
                echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="icon-print icon-white"></i>')), 'javascript:void(0);', array('class' => 'btn btn-success',
                    'onclick' => "print(" . $modPendaftaran->pendaftaran_id . ",'');return false")) . "&nbsp;";
            } else {
                echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="'.$myicon::getIcons('simpan').'"></i>')), array('class' => (isset($_GET['sukses'])) ? 'btn btn-danger' : 'btn btn-danger submit', 'id' => 'btn_submit', 'onclick' => 'cekInsert();', 'onKeypress' => 'cekInsert();', 'disabled' => (isset($_GET['sukses'])) ? true : false)) . "&nbsp";
                echo CHtml::link(Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="'.$myicon::getIcons('ulang').'"></i>')), $this->createUrl($this->id . '/index&pendaftaran_id=' . $_GET['pendaftaran_id']), array(
                    'class' => 'btn btn-default',
                    'onclick' => 'myConfirm("Apakah anda ingin mengulang ini ?","Perhatian!",function(r){if(r) window.location = "' . $this->createUrl($this->id . '/index&pendaftaran_id=' . $_GET['pendaftaran_id']) . '";}); return false;'
                )) . "&nbsp";
                echo CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="icon-print icon-white"></i>')), array('class' => 'btn btn-success', 'type' => 'button', 'disabled' => 'disabled')) . "&nbsp";
            }
            ?>

        </div>
    </div>
</div>


<?php $this->endWidget(); ?>

<input type="hidden" id="nourut">
<?php
//========= Dialog buat cari data Alat Kesehatan ala cak lontong (non racik - therapi obat)  =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogTransfusi',
    'options' => array(
        'title' => 'Data Transfusi',
        'autoOpen' => false,
        'position' => ['top', 20],
        'modal' => true,
        'width' => 550,
        'height' => 600,
        'resizable' => false,
    ),
));

$modPegawai = new PegawairuanganV('searchDialogPegRuangan');
$modPegawai->unsetAttributes();
if (isset($_GET['PegawairuanganV'])) {
    $modPegawai->attributes = $_GET['PegawairuanganV'];
}

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'therapiobat-grid',
    'dataProvider' => $modPegawai->searchDialogPegRuangan(),
    'filter' => $modPegawai,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
                                    "id" => "selectObat",
                                    "onClick" => "
                                                
                                                setDataTransfusi(\"$data->pegawai_id\", \"$data->nama_pegawai\");
                                                return false;"))',
        ),
        'nama_pegawai',
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
?>

<?php
//========= Dialog buat cari data Alat Kesehatan ala cak lontong (non racik - therapi obat)  =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogVerifikasi',
    'options' => array(
        'title' => 'Data Verifikasi',
        'autoOpen' => false,
        'position' => ['top', 20],
        'modal' => true,
        'width' => 550,
        'height' => 600,
        'resizable' => false,
    ),
));

$modPegawai = new PegawairuanganV('searchDialogPegRuangan');
$modPegawai->unsetAttributes();
if (isset($_GET['PegawairuanganV'])) {
    $modPegawai->attributes = $_GET['PegawairuanganV'];
}

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'therapiobat-grid',
    'dataProvider' => $modPegawai->searchDialogPegRuangan(),
    'filter' => $modPegawai,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
                                    "id" => "selectObat",
                                    "onClick" => "
                                                
                                                setDataVerifikasi(\"$data->pegawai_id\", \"$data->nama_pegawai\");
                                                return false;"))',
        ),
        'nama_pegawai',
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
?>

<script>
    $(document).ready(function () {
        // disable form ketika mode "lihat"
<?php if (isset($_GET['mode'])) { ?>
            $("#kantongdarahhd-t-form").find('input,select,textarea, button').each(function () {
                $(this).attr('disabled', true);
            });
<?php } ?>
    })

    function cekInsert() {
        $('#kantongdarahhd-t-form').submit();

    }
    function addObat() {
        var key = $('.tr-obat:last').attr('baris');
        if (key == null) {
            var key = 0;
        }
        var keyNew = parseInt(key) + 1;
        var nama_obat = $('#nama_obat').val();
        if (nama_obat == "") {
            alert('isi nama obat dahulu');
            return false;
        } else {
            $.ajax({
                url: '<?= $this->createUrl('addObat'); ?>',
                dataType: 'json',
                type: 'post',
                data: {nama_obat: nama_obat, key: keyNew},
                success: function (data) {
                    $('#tbl-obat > tbody').append(data.form);
                    renameInputRowObatAlkes($('#tbl-obat'));
                    $('#nama_obat').val('');
                }
            })
        }
    }
    function AddRow() {
        var key = $('.tr-kantong:last').attr("baris");
        if (key == null) {
            var key = 0;
        }
        var keyNew = parseInt(key) + 1;
//        console.log(key);return false;
        $.ajax({
            url: '<?= $this->createUrl("addRow"); ?>',
            dataType: 'json',
            type: 'post',
            data: {key: keyNew},
            success: function (data) {
                $('#tbl-kantongdarah > tbody > tr:last').after(data.form);
            }
        })
    }

    function renameInputRowObatAlkes(obj_table) {
        var row = 0;
        $(obj_table).find("tbody > tr").each(function () {
            $(this).find("#no_urut").val(row + 1);
            $(this).find('span').each(function () { //element <input>
                if (typeof $(this).attr("name") !== 'undefined'){
                    var old_name = $(this).attr("name").replace(/]/g, "");
                    var old_name_arr = old_name.split("[");
                    if (old_name_arr.length == 3) {
                        $(this).attr("name", "[" + row + "][" + old_name_arr[2] + "]");
                    }
                }
            });
            $(this).find('input,select,textarea').each(function () { //element <input>
                var old_name = $(this).attr("name").replace(/]/g, "");
                var old_name_arr = old_name.split("[");
                if (old_name_arr.length == 3) {
                    $(this).attr("id", old_name_arr[0] + "_" + row + "_" + old_name_arr[2]);
                    $(this).attr("name", old_name_arr[0] + "[" + row + "][" + old_name_arr[2] + "]");
                }
            });
            row++;
        });

//        $("#RJResepturT_noresep").blur();
    }

    function batalObat(obj) {
        $(obj).parents("tr").detach();
        renameInputRowObatAlkes($('#tbl-obat'));
    }

    function setTransfusi(obj) {
        let no = $(obj).parents("tr").attr('baris')

        $("#nourut").val(no);
    }

    function setDataTransfusi(id, nama) {
        let no = $('#nourut').val();
//        KantongTransfusiDarahDetT_0_petugas_transfusi_nama
        $('#KantongTransfusiDarahDetT_' + no + '_petugas_transfusi_id').val(id);
        $('#KantongTransfusiDarahDetT_' + no + '_petugas_transfusi_nama').val(nama);
        $('#dialogTransfusi').dialog('close');
    }

    function setVerifikasi(obj) {
        let no = $(obj).parents("tr").attr('baris');

        $("#nourut").val(no);
    }

    function setDataVerifikasi(id, nama) {
        let no = $('#nourut').val();
//        KantongTransfusiDarahDetT_0_petugas_transfusi_nama
        $('#KantongTransfusiDarahDetT_' + no + '_petugas_verifikasi_id').val(id);
        $('#KantongTransfusiDarahDetT_' + no + '_petugas_verifikasi_nama').val(nama);
        $('#dialogVerifikasi').dialog('close');
    }

    function batalKantongDarah(obj) {
        myConfirm('Apakah anda yakin menghapus data ini ?', 'Perhatian!', function (r) {
            if (r) {
                $(obj).parents("tr").detach();
                renameInputRowObatAlkes($('#tbl-kantongdarah'));
            }
        })

    }

    function hapusRiwayat(id) {
        myConfirm('Apakah anda yakin menghapus data ini ?', 'Perhatian!', function (r) {
            if (r) {
                $.ajax({
                    url: '<?= $this->createUrl('hapusRiwayat') ?>',
                    dataType: 'json',
                    type: 'post',
                    data: {id: id},
                    success: function (data) {
                        if (data.sukses == 1) {
                            toastr.success(data.pesan, 'Perhatian!');
                            location.href = "<?= $this->createUrl('index&pendaftaran_id=') . $_GET['pendaftaran_id'] ?>";
                        } else {
                            toastr.error(data.pesan, 'Perhatian!');
                        }
                    }
                })
            }
        })
    }

    function print(pendaftaran_id, kantongdarahid)
    {
        window.open('<?php echo $this->createUrl('printRiwayat'); ?>&kantongdarahid=' + kantongdarahid + '&id=' + pendaftaran_id, 'printwin', 'left=100,top=100,width=640,height=640');
    }


</script>