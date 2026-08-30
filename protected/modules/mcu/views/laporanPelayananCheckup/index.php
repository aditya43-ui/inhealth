<?php

/**
 * digunakan untuk modul portal rs informasi STR dan SIP
 * RSST-2875
 * @author          Yusuf Putra Anugrah <yusufputra@.com>
 * @version         2.0.0
 * @link            http://172.9.1.15/simpp/docs/
 *
 */
$this->breadcrumbs = array(
    'Laporan Pelayanan Checkup',
);

Yii::app()->clientScript->registerScript('search', "
    $('#str-r-search').submit(function(){
        $.fn.yiiGridView.update('str-r-grid', {
            data: $(this).serialize()
        });
        return false;
    });
");
$this->widget('bootstrap.widgets.BootAlert');
?>

<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-newspaper"></i> Laporan <b>Pelayanan Checkup</b>
        </div>
    </div>
    <div class="panel-body">
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-search"></i> Pencarian
                </div>
            </div>
            <div class="panel-body">
                <fieldset class="">
                    <?php
                    $this->renderPartial('_search', array(
                        'model' => $model,
                    ));
                    ?>
                </fieldset>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Pelayanan Checkup</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php
                $tmp = "<div id='head'></div>";
                $this->widget('ext.bootstrap.widgets.BootGridView', array(
                    'id' => 'str-r-grid',
                    'dataProvider' => $model->searchLaporan(),
                    'replaceUrl' => false,
                    'template' => "{summary}\n{items}\n{pager}",
                    'itemsCssClass' => 'table table-bordered table-striped table-condensed',
                    'columns' => array(
                        array(
                            'header' => 'No.',
                            'value' => '($this->grid->dataProvider->pagination) ? 
                                                    ($this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1)
                                                    : ($row+1)',
                            'type' => 'raw',
                            'htmlOptions' => array('style' => 'text-align:left;'),
                        ),
                        array(
                            'header' => 'Tanggal Pendaftaran/No. Pendaftaran',
                            'type' => 'raw',
                            'value' => function ($data) {
                                return MyFormatter::formatDateTimeForUser($data->tgl_pendaftaran) . "</br>" . $data->no_pendaftaran;
                            },
                        ),
                        array(
                            'header' => 'No. Rekam Medik',
                            'type' => 'raw',
                            'value' => function ($data) {
                                echo $data->no_rekam_medik;
                            },
                        ),
                        array(
                            'header' => 'Nama Pasien',
                            'type' => 'raw',
                            'value' => function ($data) {
                                echo $data->nama_pasien;
                            },
                        ),
                        array(
                            'header' => 'Alamat Pasien',
                            'type' => 'raw',
                            'value' => function ($data) {
                                echo $data->alamat_pasien;
                            },
                        ),
                        array(
                            'header' => 'Umur',
                            'type' => 'raw',
                            'value' => function ($data) {
                                if (!empty($data->pasien_id)) {
                                    $pasien = PasienM::model()->findByPk($data->pasien_id);
                                    $tgl = $pasien->tanggal_lahir;
                                    $umur = CustomFunction::getUmur($tgl);
                                    $data = explode(" ", $umur);
                                    return $data[0] . " Thn";
                                } else {
                                    return "0 Thn";
                                }
                            },
                        ),
                        array(
                            'header' => 'Keperluan Checkup',
                            'type' => 'raw',
                            'value' => function ($data) {
                                echo $data->keterangan;
                            },
                        ),
                    ),
                    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
                ));
                ?>
            </div>
        </div>

        <div class="form-actions">
            <?php
            $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
            $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
            $urlPrint =  Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/PrintLaporanPelayanan');
            $this->renderPartial($this->path_view . '_footer', array('urlPrint' => $urlPrint,));
            ?>
        </div>
    </div>
</div>

<script>
    /**
     * digunakan untuk memlih informasi yang di select
     * @param {type} obj mengambil atribute pada selector
     * @returns {undefined}
     */
    function cekform() {
        $.fn.yiiGridView.update('str-r-grid', {
            data: $('#str-r-search').serialize()
        });
    }
</script>
<script type="text/javascript">
    /**
     * difunakan untuk ubah header
     * @returns {undefined}
     */
    function ubahHeader() {
        // find baris kolom 
        if ($('.data1').prop('checked') == true) {
            var nilai = $('.data1').attr('value');
            $("#head").html("Nomor " + nilai);
        }
        if ($('.data2').prop('checked') == true) {
            var nilai = $('.data2').attr('value');
            $("#head").html("Nomor " + nilai);
        }
    }
    $(document).ready(function() {
        ubahHeader();
    });
</script>