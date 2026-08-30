<div class="panel panel-default">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="fas fa-chart-pie"></i> Penerimaan Hari Ini
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
            'id' => 'informasipenerimaanperalatanlinen-grid',
            'dataProvider' => $dataTable->searchInformasiDashboard(),
            'template' => "{items}",
            'itemsCssClass' => 'table table-striped table-bordered table-condensed',
            'columns' => array(
                array(
                    'header' => 'No. Penerimaan',
                    'type' => 'raw',
                    'value' => '$data->pesanperlinensteril_no',
                ),
                array(
                    'header' => 'Tanggal Penerimaan',
                    'type' => 'raw',
                    'value' => 'MyFormatter::formatDateTimeForUser($data->pesanperlinensteril_tgl)',
                ),
                //				array(
                //					'header'=>'Instalasi',
                //					'type'=>'raw',
                //					'value'=>'$data->ruangan->instalasi->instalasi_nama',
                //				),
                //				array(
                //					'header'=>'Ruangan',
                //					'type'=>'raw',
                //					'value'=>'$data->ruangan->ruangan_nama',
                //				),
                array(
                    'header' => 'Keterangan',
                    'type' => 'raw',
                    'value' => '$data->pesanperlinensteril_ket',
                ),
                //				array(
                //					'header'=>'Pegawai Pengirim',
                //					'name'=>'pegawaimenerima_nama',
                //					'type'=>'raw',
                //					'value'=>'$data->pegawaiMenerima->NamaLengkap',
                //				),
                //				array(
                //					'header'=>'Lihat Detail',
                //					'type'=>'raw',
                //					'value'=>'CHtml::link("<i class=\'icon-form-lihat\'></i> ",  Yii::app()->controller->createUrl("/sterilisasi/informasiPenerimaanPeralatanLinenSteril/detail",array("terimaperlinensteril_id"=>$data->terimaperlinensteril_id)),array("target"=>"frameDetail","rel"=>"tooltip","title"=>"Klik untuk Detail Sterilisasi Linen Linen", "onclick"=>"window.parent.$(\'#dialogDetail\').dialog(\'open\')"));',    'htmlOptions'=>array('style'=>'text-align: center; width:40px')
                //                        
                //                                    ),
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