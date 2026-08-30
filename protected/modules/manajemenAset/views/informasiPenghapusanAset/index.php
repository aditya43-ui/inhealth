<?php

/**
 * - digunakan sebagai informasi penghapusan aset
 * @author : Elham Budianto
 * @email : elhambudianto1@gmail.com
 * @wiki : ..
 **/
?>
<?php
Yii::app()->clientScript->registerScript('search', "
    $('#penghapusanaset-r-search').submit(function(){
        $.fn.yiiGridView.update('penghapusanaset-r-grid', {
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
            <i class="entypo-info-circled"></i> Informasi <b>Penghapusan Aset</b>
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
                    <?php $this->renderPartial('_search', array('model' => $model,)); ?>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Penghapusan Aset</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php
                $this->widget('ext.bootstrap.widgets.BootGridView', array(
                    'id' => 'penghapusanaset-r-grid',
                    'dataProvider' => $model->searchInformasi(),
                    'replaceUrl' => true,
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
                            'header' => 'Nomor dan Tanggal Penghapusan',
                            'value' => function ($data) {
                                echo $data->nopenghapusan . '/' . MyFormatter::formatDateTimeForUser($data->tglpenghapusan);
                            },
                        ),
                        array(
                            'header' => 'Cara',
                            'value' => function ($data) {
                                echo $data->carapenghapusan;
                            },
                        ),
                        array(
                            'header' => 'Nomor dan Tanggal SK',
                            'value' => function ($data) {
                                echo $data->no_sk_penghapusan . '/' . MyFormatter::formatDateTimeForUser($data->tgl_sk_penghapusan);
                            },
                        ),
                        array(
                            'header' => 'Keterangan',
                            'value' => function ($data) {
                                echo $data->ket_penghapusan;
                            },
                        ),
                        array(
                            'header' => 'Detil',
                            'type' => 'raw',
                            'value' => function ($data) {
                                return CHtml::link("<i class='entypo-doc-text'></i>", Yii::app()->createUrl('manajemenAset/InformasiPenghapusanAset/detail&id=' . $data->penghapusanaset_id), array("rel" => "tooltip", "title" => "Klik untuk Melihat Detail Penghapusan Aset", "target" => "iframe1", "onclick" => "$('#dialogDetail').dialog('open');"));
                            },
                            'htmlOptions' => array(
                                'style' => 'text-align: center',
                            ),
                        ),
                        array(
                            'header' => 'Batal',
                            'type' => 'raw',
                            'value' => function ($data) {
                                return CHtml::link("<i class='entypo-cancel'></i>", "#", array("rel" => "tooltip", "title" => "Klik untuk Membatalkan Penghapusan Aset", "target" => "iframe1", "onclick" => "batalPenghapusan($data->penghapusanaset_id)"));
                            },
                            'htmlOptions' => array(
                                'style' => 'text-align: center',
                            ),
                        ),
                    ),
                    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
                ));
                ?>
            </div>
        </div>
    </div>
</div>
<?php
// ===========================Dialog Details Work Order=========================================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogDetail',
    // additional javascript options for the dialog plugin
    'options' => array(
        'title' => 'Detail Penghapusan Aset',
        'autoOpen' => false,
        'width' => 1000,
        'height' => 600,
        'resizable' => true,
        'scroll' => false,
        'close' => "js:function(){ $.fn.yiiGridView.update('penghapusanaset-r-grid', {
            data: $('#penghapusanaset-r-search').serialize()
    }); }",
    ),
));
?>
<iframe src="" name="iframe1" style="width:100%; height: 98%;"></iframe>
<?php
$this->endWidget('zii.widgets.jui.CJuiDialog');
//===============================Akhir Dialog Work Order================================
?>
<?php
$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
$module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
$url =  Yii::app()->createAbsoluteUrl($module . '/' . $controller);
?>
<script>
    function batalPenghapusan(id) {
        var id = id;
        var url = '<?php echo $url . "/batalPenghapusan"; ?>';
        myConfirm('Anda yakin untuk Membatalkan Penghapusan Aset?', 'Perhatian!', function(r) {
            if (r) {
                $.post(url, {
                        id: id
                    },
                    function(data) {
                        if (data.status == 'proses_form') {
                            myAlert('Data Penghapusan Aset berhasil Di Batalkan');
                            $.fn.yiiGridView.update('penghapusanaset-r-grid');
                        } else {
                            myAlert('Data Gagal di Ubah');
                        }
                    }, "json");
            }
        });
    }
</script>