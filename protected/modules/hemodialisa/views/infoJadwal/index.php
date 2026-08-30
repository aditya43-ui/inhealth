<?php
Yii::app()->clientScript->registerScript('search', "
    $('#infojadwal-m-search').submit(function(){
        $.fn.yiiGridView.update('infojadwal-m-grid', {
            data: $(this).serialize()
        });
        return false;
    });
");
$this->widget('bootstrap.widgets.BootAlert');
?>
<style>
    .button-status {
        margin-right: 8px;
    }
    .badge-status {
        position: relative;
        top: 8px;
        left: 8px;
    }

    .badge-status-jmlPanggil{
        position: relative;
        top: 8px;
        left: 10px;
        z-index: 10;
    }
    .button-status {
        min-width: 150px;
    }
    .btn-status {
        min-width: 150px;
    }
</style>
<!--div class="white-container"-->
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-gradient">
            <div class="panel-heading">
                <div class="panel-title">Informasi <strong>Jadwal Pasien Hemodialisa</strong></div>
            </div>
            <div class="panel-body">
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <div class="panel-title">Tabel <strong>Jadwal Pasien Hemodialisa</strong></div>
                    </div>
                    <div class="panel-body table-responsive">
                        <div class="block-tabel">
                            <?php
                            $this->widget('bootstrap.widgets.BootAlert');
                            $this->widget('ext.bootstrap.widgets.BootGridView', array(
                                'id' => 'infojadwal-m-grid',
                                'dataProvider' => $dataProvider,
                                'replaceUrl' => true,
                                'template' => "{summary}\n{items}\n{pager}",
                                'itemsCssClass' => 'table table-bordered table-striped table-condensed',
                                'columns' => array(
                                    array(
                                        'header' => 'Hari / Tanggal',
                                        'value' => '$data->jadwalhemodialisa_hari ." / ". MyFormatter::formatDateTimeForUser($data->jadwalhemodialisa_tgl_ke)',
                                    ),
                                    array(
                                        'header' => 'Shift',
                                        'value' => '$data->shift_hd_nama'
                                    ),
                                    array(
                                        'header' => 'No.RM',
                                        'value' => '$data->no_rekam_medik'
                                    ),
                                    'no_rekam_medik',
                                    array(
                                        'header' => 'Nama Pasien',
                                        'value' => '$data->nama_pasien',
                                    ),
                                    array(
                                        'header' => 'Jenis Kelamin',
                                        'value' => '$data->jeniskelamin',
                                    ),
                                    array(
                                        'header' => 'Umur',
                                        'value' => function($data) {
                                            $datetime1 = new Datetime();
                                            $datetime2 = new Datetime($data->tanggal_lahir);
                                            $interval = $datetime1->diff($datetime2);
                                            $elapsed = $interval->format('%y tahun %m bulan %a hari');
                                            echo $elapsed;
                                        },
                                    ),
                                    array(
                                        'header' => 'No. Handphone',
                                        'value' => '$data->no_mobile_pasien',
                                    ),
                                    array(
                                        'header' => 'Alamat',
                                        'value' => '$data->alamat_pasien',
                                    ),
                                    array(
                                        'header' => 'Ubah',
                                        'type' => 'raw',
                                        'value' => function($data) {
//                                            return CHtml::Link("<i class='icon-pencil'></i>", Yii::app()->controller->createUrl("update", array("jadwalhemodialisa_id" => $data->jadwalhemodialisa_id)), array("class" => "icon-pencil",
//                                                        "id" => "selectJadwalHemodialisa",
//                                                        "rel" => "tooltip",
//                                                        "title" => "Klik untuk ubah Jadwal Hemodialisa",
//                                            ));
                                            return CHtml::Link("<span style='font-size:15px; color: #0B6623'><i class='icon-pencil'></i></span>", Yii::app()->controller->createUrl("update", array("jadwalhemodialisa_id" => $data->jadwalhemodialisa_id, "frame" => 1, "popup" => "true")), array("class" => "",
                                                        "target" => "iframePengambilanHasil",
                                                        "onclick" => "$(\"#dialogPengambilanHasil\").dialog(\"open\");",
                                                        "rel" => "tooltip",
                                                        "title" => "Klik untuk ubah Jadwal Hemodialisa",
                                            ));
                                        },
                                        'htmlOptions' => array('style' => 'text-align:center;'),
                                    ),
                                    array(
                                        'header' => 'Batal',
                                        'type' => 'raw',
                                        'value' => function($data) {
                                            return CHtml::link("<i class='icon-form-silang'></i>", "javascript:batalperiksa(" . $data->jadwalhemodialisa_id . ")", array("id" => $data->jadwalhemodialisa_id, "rel" => "tooltip", "title" => "Klik untuk membatalkan jadwal hemodialisis", "data-placement" => "left"));
                                        },
                                        'htmlOptions' => array('style' => 'text-align: center; width:40px'),
                                    ),
                                ),
                                'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
                            ));
                            ?>
                        </div>
                    </div>
                </div>								
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <div class="panel-title"><i class="icon-search"></i> Pencarian</div>
                    </div>
                    <div class="panel-body">
                        <?php $this->renderPartial('_formSearch', array('model' => $model)); ?>
                        <?php
                        $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
                            'id' => 'dialogKonfirm',
                            'options' => array(
                                'title' => '',
                                'autoOpen' => false,
                                'modal' => true,
                                'width' => 300,
                                'resizable' => false,
                            ),
                        ));
                        ?>
                        <div class="divForForm"></div>
                        <?php $this->endWidget(); ?>
                    </div>
                </div>								
            </div>
        </div>
    </div>
</div>
<?php
// Dialog untuk Pengambilan Hasil =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogPengambilanHasil',
    'options' => array(
        'title' => 'Ubah Jadwal Pasien Hemodialisa',
        'autoOpen' => false,
        'modal' => true,
        'minWidth' => 550,
        'minHeight' => 200,
        'resizable' => true,
        'close' => "js:function(){ $.fn.yiiGridView.update('daftarpasien-v-grid'); }",
    ),
));
?>
<iframe src="" name="iframePengambilanHasil" width="100%" height="300">
</iframe>

<?php
$this->endWidget();
//========= end Pengambilan Hasil =============================
?>

<?php //echo $this->renderPartial('_jsFunctions', array()); ?>

<script type="text/javascript">
// document.getElementById('tgl_awal_date').setAttribute("style","display:none;");
// document.getElementById('tgl_akhir_date').setAttribute("style","display:none;");
    function cekTanggal() {

        var checklist = $('#cbTglMasuk');
        var pilih = checklist.attr('checked');
        if (pilih) {
            document.getElementById('tgl_awal_date').setAttribute("style", "display:block;");
            document.getElementById('tgl_akhir_date').setAttribute("style", "display:block;");
        } else {
            document.getElementById('tgl_awal_date').setAttribute("style", "display:none;");
            document.getElementById('tgl_akhir_date').setAttribute("style", "display:none;");
        }
    }

    function batalperiksa(id)
    {
        myConfirm("Apakah Anda yakin akan membatalkan Jadwal Pasien Hemodialisa ini?", "Perhatian!", function (r) {
            if (r) {
                $.post('<?php echo Yii::app()->createUrl(Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/' . 'batalJadwal') ?>', {id: id},
                        function (data) {
                            if (data.status == 'ok') {
                                myAlert(data.pesan);
                                $.fn.yiiGridView.update('infojadwal-m-grid', {
                                    data: $('#search-infojadwal-form').serialize()
                                });
                                return false;

                            }else{
                                myAlert(data.pesan);
                                return false;
                            }
                        }, 'json'
                        );
            }
        });
    }

    function setRuangan(data) {
        $("#<?php CHtml::activeId($model, "ruangan_nama") ?>").html(data);
        var ruanganAsal = jQuery('#<?php echo CHtml::activeId($model, 'ruangan_nama') ?>');
        jQuery(ruanganAsal).multiselect({
            includeSelectAllOption: true,
            buttonClass: "form-control",
            maxHeight: 300,
            buttonWidth: '150px',
            enableCaseInsensitiveFiltering: true
        }).hide();
    }




</script>
<?php
$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
$module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
$url = Yii::app()->createAbsoluteUrl($module . '/' . $controller);
$urlPrint = Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/print');
$js = <<< JSCRIPT
    function cekForm(obj){
        $("#search-infojadwal-form :input[name='"+ obj.name +"']").val(obj.value);
    }
    function print(caraPrint){
        window.open("${urlPrint}/"+$('#infojadwal-m-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
    }
JSCRIPT;
Yii::app()->clientScript->registerScript('print', $js, CClientScript::POS_HEAD);
?>