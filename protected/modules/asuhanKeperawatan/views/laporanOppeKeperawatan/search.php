<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'type' => 'horizontal',
    'id' => 'searchLaporan',
));
?>

<style>
    
</style>
<div class="row">
    <div class="col-sm-6">
        <div class="control-group">
            <label class="control-label">Periode Laporan</label>
            <div class="controls">
                <?php echo CHtml::hiddenField('type', ''); ?>
                <?php
                $this->widget('MyMonthPicker', array(
                    'model' => $model,
                    'attribute' => 'tgl_awal',
                    'options' => array(
                        'dateFormat' => Params::MONTH_FORMAT,
                        'maxDate' => 'd',
                    ),
                    'htmlOptions' => array(
                        'class' => 'span2',
                        'readonly' => true,
                        'onkeypress' => "return $(this).focusNextInputField(event)"
                    ),
                ));
                ?>
            </div>
            <div class="controls">
                <label>Hingga Bulan :</label>
            </div>
            <div class="controls">
                <?php
                $this->widget('MyMonthPicker', array(
                    'model' => $model,
                    'attribute' => 'tgl_akhir',
                    'options' => array(
                        'dateFormat' => Params::MONTH_FORMAT,
                        'maxDate' => 'd',
                    ),
                    'htmlOptions' => array(
                        'class' => 'span2',
                        'readonly' => true,
                        'onkeypress' => "return $(this).focusNextInputField(event)"
                    ),
                ));
                ?>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo CHtml::label('Indikator OPPE', 'golongan_indikator', array('class' => 'control-label')); ?>
            <div class="controls">
            <?php echo $form->dropDownList($model, 'golongan_indikator', Chtml::listData(IndikatoroppekeperawatanM::model()->findAllByAttributes(array('is_aktif' => true,), array('order' => 'nama_indikator')), 'indikatoroppekeperawatan_id', 'nama_indikator'), array('class' => 'form-control', 'multiple' => 'multiple')); ?>
            </div>
        </div>
        <!-- <div id='searching'>
            <?php
            // $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
            //     'id' => 'indikator',
            //     'content' => array(
            //         'content1' => array(
            //             'multi' => 'multi',
            //             'header' => 'Berdasarkan Indikator Kinerja',
            //             'isi' => CHtml::hiddenField('filter', 'wilayah') .
            //                 '<div class="control-group">
            //             ' . CHtml::label('Indikator OPPE', '', array('class' => 'control-label')) . ' 
            //             <div class="controls">
            //                 ' . $form->dropDownList($model, 'golongan_indikator', Chtml::listData(IndikatoroppekeperawatanM::model()->findAllByAttributes(array('is_aktif' => true,), array('order' => 'nama_indikator')), 'indikatoroppekeperawatan_id', 'nama_indikator'), array('class' => 'form-control', 'multiple' => 'multiple')) . '
            //                 </div>
            //             </div>',
            //             'active' => true,
            //         ),
            //     ),
            // ));
            ?>

        </div> -->
    </div>
    <div class="col-sm-6">
        <div id='searching'>
            <?php
            $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
                'id' => 'pengunjung',
                'content' => array(
                    'content3' => array(
                        'header' => 'Berdasarkan Unit Kerja / Perawat ',
                        'isi' => $this->renderPartial('_dialogUnit', array('model' => $model, 'form' => $form), true),
                        'active' => true,
                    ),
                ),
            ));
            ?>
        </div>
    </div>
</div>
<div class="form-actions">
    <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
        array('title' => 'Cari', 'class' => 'btn btn-primary', 'type' => 'submit')
    );
    ?>

    <?php
    echo CHtml::link(
        Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
        Yii::app()->createUrl($this->module->id . '/' . Yii::app()->controller->id . '/' . Yii::app()->controller->action->id . ''),
        array(
            'title' => 'Ulang',
            'class' => 'btn btn-danger',
            'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = "' . Yii::app()->createUrl($this->module->id . '/' . Yii::app()->controller->id . '/' . Yii::app()->controller->action->id . '') . '";}); return false;'
        )
    );
    ?>
</div>
<?php
$this->endWidget();
?>

<?php
$this->renderPartial('_jsFunctions', array('model' => $model));
?>

<script>
    function setPerawat() {
        $("#ASLaporanoppekeperawatanV_pegawai_id").val('');
        $("#ASLaporanoppekeperawatanV_nama_perawat").val('');
        var ada = $('#ASLaporanoppekeperawatanV_jenis_0');
        var tidak_ada = $('#ASLaporanoppekeperawatanV_jenis_1');
        var dlg = '';
        if (ada.is(" :checked")) {
            document.getElementById("ASLaporanoppekeperawatanV_nama_perawat").placeholder = "Ketik Nama Unit Kerja";
        } else if (tidak_ada.is(" :checked")) {
            document.getElementById("ASLaporanoppekeperawatanV_nama_perawat").placeholder = "Ketik Nama Perawat";
        } else {
            document.getElementById("ASLaporanoppekeperawatanV_nama_perawat").placeholder = "";
        }

        var url = '';
        if (ada.is(" :checked")) {
            url = '<?php echo $this->createUrl('autocompleteUnitKerja'); ?>';
        } else if (tidak_ada.is(" :checked")) {
            url = '<?php echo $this->createUrl('getPegawai'); ?>';
        }

        $("#<?php echo CHtml::activeId($model, 'nama_perawat') ?>").autocomplete({
            'showAnim': 'fold',
            'minLength': 3,
            'focus': function(event, ui) {
                $(this).val(ui.item.label);
                return false;
            },
            'select': function(event, ui) {
                setAuto(ui.item);
                return false;
            },
            'source': function(request, response) {
                $.ajax({
                    url: url,
                    dataType: "json",
                    data: {
                        term: request.term,
                        jenis_output: 'temp'
                    },
                    success: function(data) {
                        response(data);
                    }
                });
            }

        });
    }

    function setAuto(data) {
        $("#ASLaporanoppekeperawatanV_pegawai_id").val(data.value);
        $("#ASLaporanoppekeperawatanV_nama_perawat").val(data.label);
    }

    function setJenis() {
        var ada = $('#ASLaporanoppekeperawatanV_jenis_0');
        var tidak_ada = $('#ASLaporanoppekeperawatanV_jenis_1');
        var dlg = '';
        if (ada.is(" :checked")) {
            dlg = 'dialogUnitKerja';
        } else if (tidak_ada.is(" :checked")) {
            dlg = 'dialogPerawat';
        } else {
            dlg = '';
        }
        console.log('dlg', dlg);
        $("#" + dlg).dialog('open');
    }

    $(document).ready(function() {
        // setJenis();
    });
</script>

<?php
/* ========= Dialog buat cari Kantong Darah ========================= */

$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogPerawat',
    'options' => array(
        'title' => 'Daftar Perawat',
        'autoOpen' => false,
        'modal' => true,
        'width' => 600,
        'height' => 500,
        'resizable' => false,
    ),
));

$modPegawai = new ASPegawaiM('searchDialog');
$modPegawai->unsetAttributes();
if (isset($_GET['ASPegawaiM'])) {
    $modPegawai->attributes = $_GET['ASPegawaiM'];
    $modPegawai->jabatan_nama = !empty($_GET['ASPegawaiM']['jabatan_nama']) ? $_GET['ASPegawaiM']['jabatan_nama'] : "";
}

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'barang-m-grid',
    'dataProvider' => $modPegawai->searchDialogPerawat(),
    'filter' => $modPegawai,
    'template' => "{summary}\n{items}{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => function ($data) {
                return CHtml::Link("<span style='font-size:20px;'><i class='" . MyIcon::getIcons('simpan') . "'></i></span>", "javascript:void(0)", array(
                    "class" => "btn-small",
                    "id" => "selectBarang",
                    "onClick" => "$('#ASLaporanoppekeperawatanV_pegawai_id').val('" . $data['pegawai_id'] . "');  
                                          $('#ASLaporanoppekeperawatanV_nama_perawat').val('" . $data['nama_pegawai'] . "');                                                        
                                          $('#dialogPerawat').dialog('close');
                                          return false;"
                ));
            },
        ),
        array(
            'header' => 'NIP',
            'name' => 'nomorindukpegawai'
        ),
        array(
            'header' => 'Nama Perawat',
            'name' => 'nama_pegawai'
        ),
        array(
            'header' => 'Jabatan',
            'name' => 'jabatan_nama'
        ),
        array(
            'header' => 'Unit Kerja',
            'name' => 'namaunitkerja'
        )
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));
$this->endWidget();

$this->beginWidget(
    'zii.widgets.jui.CJuiDialog',
    array(
        'id' => 'dialogUnitKerja',
        'options' => array(
            'title' => 'Pencarian Unit Kerja',
            'autoOpen' => false,
            'width' => 760,
            'height' => 500,
            'resizable' => true,
        ),
    )
);

$modUnitPPk = new UnitkerjaM('search');

if (isset($_GET['UnitkerjaM'])) {
    $modUnitPPk->attributes = $_GET['UnitkerjaM'];
    $modUnitPPk->instalasi_nama = isset($_GET['UnitkerjaM']['instalasi_nama']) ? $_GET['UnitkerjaM']['instalasi_nama'] : null;
}

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'dialog-unitkerja-grid',
    'dataProvider' => $modUnitPPk->search(),
    'filter' => $modUnitPPk,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => function ($data) {
                return CHtml::Link("<span style='font-size:20px;'><i class='" . MyIcon::getIcons('simpan') . "'></i></span>", "javascript:void(0)", array(
                    "class" => "btn-small",
                    "id" => "selectBarang",
                    "onClick" => "$('#ASLaporanoppekeperawatanV_pegawai_id').val('" . $data['unitkerja_id'] . "');  
                                                      $('#ASLaporanoppekeperawatanV_nama_perawat').val('" . $data['namaunitkerja'] . "');                                                        
                                                      $('#dialogUnitKerja').dialog('close');
                                                      return false;"
                ));
            },
        ),
        array(
            'header' => 'Nama Unit Kerja',
            'name' => 'namaunitkerja',
            'value' => function ($data) {
                return $data->namaunitkerja;
            }
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget('zii.widgets.jui.CJuiDialog');
?>