<?php
$myicon = new MyIcon();
$this->breadcrumbs = array(
    'Periksa Pasien Rujukan Ms' => array('index'),
    'Manage',
);
$this->widget('bootstrap.widgets.BootAlert');
?>
<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'periksarujukan-hd-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)', 'onsubmit' => 'return requiredCheck(this)'),
        ));
?>

<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">Pendaftaran Hemodialisa</div>
        <?php if (!empty($_GET['pendaftaran_id'])) { ?>
            <span style="float:right; padding: 10px">
                <?php echo CHtml::link(Yii::t('mds', '{icon} Kembali', array('{icon}' => '<i class="entypo-back"></i>')), $this->createUrl('pasienRujukan/Index', array()), array('class' => 'btn btn-sm btn-danger')); ?>
            </span>
        <?php } ?>
    </div>
    <div class="panel-body">
        <?php $this->renderPartial('_dataPasien', ['modPasienrujukan' => $modPasienrujukan, 'modPendaftaran' => $modPendaftaran, 'modPasien' => $modPasien, 'model' => $model]); ?>
        <?php $this->renderPartial('_dataKunjungan', ['modPendaftaran' => $modPendaftaran, 'modPasien' => $modPasien, 'model' => $model, 'modJadwalhemodialisa' => $modJadwalhemodialisa, 'form' => $form, 'modPasienrujukan' => $modPasienrujukan,]); ?>
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
                        echo CHtml::link(Yii::t('mds', '{icon} Cetak Karcis', array('{icon}' => '<i class="icon-print icon-white"></i>')), 'javascript:void(0);', array('class' => 'btn btn-success',
                            'onclick' => "print(" . $_GET['pasienkirimkeunitlain_id'] . ",'');return false")) . "&nbsp;";
                    } else {
                        echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="'.$myicon::getIcons('simpan').'"></i>')), array('class' => (isset($_GET['sukses'])) ? 'btn btn-danger' : 'btn btn-danger submit', 'id' => 'btn_submit', 'onclick' => 'cekInsert();', 'onKeypress' => 'cekInsert();', 'disabled' => (isset($_GET['sukses'])) ? true : false)) . "&nbsp";
                        echo CHtml::link(Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="'.$myicon::getIcons('ulang').'"></i>')), $this->createUrl($this->id . '/index&pendaftaran_id=' . $_GET['pendaftaran_id']), array(
                            'class' => 'btn btn-default',
                            'onclick' => 'myConfirm("Apakah anda ingin mengulang ini ?","Perhatian!",function(r){if(r) window.location = "' . $this->createUrl($this->id . '/index&pendaftaran_id=' . $_GET['pendaftaran_id']) . '";}); return false;'
                        )) . "&nbsp";
                        echo CHtml::htmlButton(Yii::t('mds', '{icon} Cetak Karcis', array('{icon}' => '<i class="icon-print icon-white"></i>')), array('class' => 'btn btn-success', 'type' => 'button', 'disabled' => 'disabled')) . "&nbsp";
                    }
                    ?>

                </div>
            </div>
        </div>
    </div>
</div>

<?php $this->endWidget(); ?>
<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogDPJP',
    'options' => array(
        'title' => 'Pencarian DPJP',
        'autoOpen' => false,
        'modal' => true,
        'width' => 960,
        'height' => 480,
        'resizable' => false,
    ),
));
$modCariDokter = new PegawairuanganV('searchDialogPegRuangan');
$modCariDokter->unsetAttributes();
if (isset($_GET['PegawairuanganV'])) {
    $modCariDokter->attributes = $_GET['PegawairuanganV'];
    isset($_GET['PegawairuanganV']['ruangan_id']) ? $modCariDokter->ruangan_id = $_GET['PegawairuanganV']['ruangan_id'] : '';
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'dpjp-v-grid',
    'dataProvider' => $modCariDokter->searchDialogPegRuangan(),
    'filter' => $modCariDokter,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","javascript:void(0);",array("class"=>"btn-small", 
                                        "id" => "selectDPJP",
                                        "onClick" => "
                                            $(\"#' . CHtml::activeId($model, 'pegawaikonsul_id') . '\").val($data->pegawai_id);
                                            $(\"#' . CHtml::activeId($model, 'nama_pegawai') . '\").val(\"$data->NamaLengkap\");                                            
                                            $(\"#dialogDPJP\").dialog(\"close\");
                                        "))',
        ),
        'gelardepan',
        array(
            'header' => 'Nama Pegawai',
            'value' => '$data->nama_pegawai',
            'filter' => CHtml::activeHiddenField($modCariDokter, 'ruangan_id', array('readonly' => true)) . "" . CHtml::activeTextField($modCariDokter, 'nama_pegawai', array()),
            'htmlOptions' => array('style' => 'text-align:left;'),
        ),
        'gelarbelakang_nama',
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));
$this->endWidget();
?>
<script>
    function cekInsert()
    {
        $('#periksarujukan-hd-form').submit();
    }
    
    function hariBaru(){
        var tanggal = $('#JadwalhemodialisaT_jadwalhemodialisa_tgl_ke').val();
        if(tanggal != ''){
            $.post("<?php echo $this->createUrl('GetHari'); ?>",{tanggal: tanggal},
            function(data){
                    $('#JadwalhemodialisaT_jadwalhemodialisa_hari').val(data.hari); 
            },"json");
        }
    }
    
    function setDropdownDokter(ruangan_id)
    {
        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('SetDropdownDokter'); ?>',
            data: {ruangan_id: ruangan_id}, //
            dataType: "json",
            success: function (data) {
                $("#<?php echo CHtml::activeId($model, "pegawai_id"); ?>").html(data.listDokter);
                $("#<?php echo CHtml::activeId($model, "ppjp_id"); ?>").html(data.listPPJP);
                cekPilihSatu($("#<?php echo CHtml::activeId($model, "pegawai_id"); ?>"));

                //untuk kebutuhanset load dpjp skdp bpjs
                $("#kode_spesialis").val(data.kode_bpjs);
                $("#dpjs_is_load").val('');
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
    }

    function setDropdownJeniskasuspenyakit(ruangan_id)
    {
        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('SetDropdownJeniskasuspenyakit'); ?>',
            data: {ruangan_id: ruangan_id}, //
            dataType: "json",
            success: function (data) {
                $("#<?php echo CHtml::activeId($model, "jeniskasuspenyakit_id"); ?>").html(data.listKasuspenyakit);
                cekPilihSatu($("#<?php echo CHtml::activeId($model, "jeniskasuspenyakit_id"); ?>"));
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
    }

    function cekPilihSatu(obj) {
        // console.log($(obj).find('option').length);
        if ($(obj).find('option').length == 2) {
            $(obj).val($(obj).find('option').eq(1).val());
            $(obj).change();
        }
        if ($(obj).find('option').length == 1) {
            $(obj).change();
        }
    }

    function setDropDownKelasPelayanan(ruangan_id)
    {
        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('SetDropdownKelasPelayananRI'); ?>',
            data: {ruangan_id: ruangan_id}, //
            dataType: "json",
            success: function (data) {
                $("#<?php echo CHtml::activeId($model, "kelaspelayanan_id"); ?>").html(data.listKelas);
                $("#<?php echo CHtml::activeId($model, "kelaspelayanan_id"); ?>").val(<?php echo Params::KELASPELAYANAN_ID_KELAS_II; ?>);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
    }

    function updateKamarByKelasLantai(status)
    {
<?php $url = $this->createUrl('GetKamarKosongByKelasLantai', array('encode' => false, 'namaModel' => 'PPPendaftaranT')); ?>
        var idRuangan = $('#<?php echo CHtml::activeId($model, 'ruangan_id') ?>').val();
        var kelaspelayanan_id = $('#<?php echo CHtml::activeId($model, 'kelaspelayanan_id') ?>').val();
        var lantai_hd = $('#<?php echo CHtml::activeId($model, 'lantai_hd') ?>').val();
        jQuery.ajax({'type': 'POST',
            'url': '<?php echo $url ?>',
            'cache': false,
            'data': {ruangan_id: idRuangan, kelaspelayanan_id: kelaspelayanan_id, lantai_hd: lantai_hd, is_status: status},
            'success': function (html) {
                jQuery("#<?php echo CHtml::activeId($model, 'kamarruangan_id') ?>").html(html)
            }
        });
    }
    function print(id)
    {
        window.open('<?php echo $this->createUrl('printKarcisHD'); ?>&konsulpoli_id='+id,'printwin','left=100,top=100,width=640,height=640');
    }
</script>