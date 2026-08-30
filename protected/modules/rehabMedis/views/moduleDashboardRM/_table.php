<?php

/**
 * view, yang digunakan untuk menampilkan data dalam bentuk tabel
 * 
 * @package application.modules.rehabMedis
 * @subpackage models
 * @author M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
 * @version     2.0.0 
 * @link    <http://piindonesia.co.id>
 */
?>
<div class="panel panel-default">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="fas fa-chart-pie"></i> Pasien Pemeriksaan Rehabilitasi Medis Terakhir
        </div>
        <div class="panel-options">
            <a data-rel="collapse" href="#">
                <i class="entypo-down-open"></i>
            </a>
            <a data-rel="reload" href="#">
                <i class="entypo-arrows-ccw"></i>
            </a>
        </div>
    </div>
    <div class="panel-body with-table table-responsive">
        <?php

        $this->widget('ext.bootstrap.widgets.BootGridView', array(
            'id' => 'table-grid',
            'dataProvider' => $dataTable->searchDashboardRM(),
            'template' => "{pager}\n{items}",
            'itemsCssClass' => 'table table-striped table-bordered table-condensed table-responsive',
            'columns' => array(
                array(
                    'header' => 'Tgl. Masuk Penunjang',
                    'type' => 'raw',
                    'value' => 'MyFormatter::formatDateTimeForUser($data->tglmasukpenunjang)',
                ),
                'no_masukpenunjang',
                'no_rekam_medik',
                'no_pendaftaran',
                array(
                    'header' => 'Nama Pasien',
                    'type' => 'raw',
                    'value' => '$data->nama_pasien',
                ),
                'umur',
                'jeniskelamin',
            ),
        ));
        ?>
    </div>
</div>

<script type="text/javascript">
    function refreshTable() {
        $.fn.yiiGridView.update('table-grid');
    }
</script>