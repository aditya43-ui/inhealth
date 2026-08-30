<?php

/**
 * @author          Yusuf Putra Anugrah<yusufputra@.com>
 * @version         2.0.0
 * @documentation   http://kbase..com
 * @issue           RSST-2164
 * - Menambahkan Menu Informasi Daftar Rekam Medis Inaktif
 * -  
 */
?>
<?php
Yii::app()->clientScript->registerScript('search', "
    $('#berkaselektronikrm-r-search').submit(function(){
        $.fn.yiiGridView.update('berkaselektronikrm-r-grid', {
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
            <i class="entypo-info-circled"></i> Informasi <b>Berkas Elektronik RM</b>
        </div>
    </div>
    <div class="panel-body">
        <div class="panel panel-success panel-shadow">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-search"></i> Pencarian
                </div>
            </div>
            <div class="panel-body">
                <?php $this->renderPartial('_search', array('model' => $model,)); ?>
            </div>
        </div>
        <div class="panel panel-success panel-shadow">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Daftar Berkas Elektronik RM</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php
                $this->widget('ext.bootstrap.widgets.BootGridView', array(
                    'id' => 'berkaselektronikrm-r-grid',
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
                            'header' => 'Nama Pasien',
                            'value' => function ($data) {
                                echo $data->nama_pasien;
                            },
                        ),
                        'no_rekam_medik',
                        array(
                            'header' => 'Lihat Detail',
                            'type' => 'raw',
                            'value' => 'CHtml::Link("<i class=\"icon-form-detail\"></i>",Yii::app()->controller->createUrl("InformasiBerkaselektronikrm/detail",array("pasien_id"=>$data->pasien_id,"frame"=>true)),
                                        array("class"=>"", 
                                            "rel"=>"tooltip",
                                            "title"=>"Klik untuk melihat detail Pembayaran Gaji",
                                    ))',
                        )
                    ),
                    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
                ));
                ?>
            </div>
        </div>
        <?php
        $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
        $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
        $url =  Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/delete');
        ?>
    </div>
</div>
<script>
    function inaktifRecord(id, nomor) {
        var id = id;
        var nomor = nomor;
        var url = '<?php echo $url; ?>';
        myConfirm('Apakah Anda akan mengaktifkan kembali dokumen rekam medis no.' + nomor + '?', 'Perhatian!', function(r) {
            if (r) {
                $.post(url, {
                        id: id
                    },
                    function(data) {
                        if (data.status == 'sukses') {
                            $.fn.yiiGridView.update('berkaselektronikrm-r-grid');
                        } else {
                            myAlert('Data gagal dihapus!')
                        }
                    }, "json");
            }
        });
    }
</script>