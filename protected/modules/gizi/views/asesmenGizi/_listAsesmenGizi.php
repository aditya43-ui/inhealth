<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="glyphicon glyphicon-file"></i> Riwayat Asesmen Gizi
        </div>
    </div>
    <div class="panel-body">
        <?php
        $model = new AsesmengiziT();
        $model->unsetAttributes();
        $model->pendaftaran_id = $pendaftaran_id;
        $model->pasienmasukpenunjang_id = $pasienmasukpenunjang_id;
        // $model->create_ruangan = Yii::app()->user->getState('ruangan_id');

        $prov = $model->search();
        $prov->pagination->pageSize = 5;
        $prov->sort->defaultOrder = 'create_time desc';


        $this->widget('ext.bootstrap.widgets.BootGridView', array(
            'id' => 'daftar-asesmen-grid',
            'dataProvider' => $prov,
            'template' => "{summary}\n{items}\n{pager}",
            'itemsCssClass' => 'table table-bordered table-striped table-condensed',
            'columns' => array(
                array(
                    'header' => 'Tgl. Asesmen',
                    'name' => 'tgl_konsultasi',
                    'value' => 'MyFormatter::formatDateTimeForUser($data->tgl_konsultasi);'
                ),
                /*
                array(
                    'header'=>'No. '.$jenis,
                    'name'=>'tglpersetujuan',
                    'value'=>'MyFormatter::formatDateTimeForUser($data->tglpersetujuan);'
                ),
                 * 
                 */
                array(
                    'header' => 'Detail',
                    'type' => 'raw',
                    'value' => function ($data) {
                        return CHtml::link('<i class="icon-form-detail"></i>', $this->createUrl('detail', array(
                            'asesmengizi_id' => $data->asesmengizi_id,
                        )), array('rel' => 'tooltip', 'title' => 'Detail Asesmen Gizi'));
                    },
                    'htmlOptions' => array(
                        'style' => 'text-align: center;',
                    )
                ),
                array(
                    'header' => 'Batal',
                    'type' => 'raw',
                    'value' => function ($data) {
                        return CHtml::link('<i class="icon-form-silang"></i>', '#', array('rel' => 'tooltip', 'title' => 'Batal Asesmen Gizi', 'onclick' => 'hapusAsesmen(' . $data->asesmengizi_id . ');'));
                    },
                    'htmlOptions' => array(
                        'style' => 'text-align: center;',
                    )
                )
            ),
            'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
        ));
        ?>

<script>
    function hapusAsesmen(id) {
        myConfirm("Anda yakin untuk menghapus asesmen gizi ini?", "Peringatan", function(r) {
            if (r) {
                $.post('<?php echo $this->createUrl('hapus'); ?>', {
                    id: id
                }, function(data) {
                    $.fn.yiiGridView.update('daftar-asesmen-grid');
                    myAlert("Data asesmen gizi berhasil dihapus");
                });
            }
        });
    }
</script>