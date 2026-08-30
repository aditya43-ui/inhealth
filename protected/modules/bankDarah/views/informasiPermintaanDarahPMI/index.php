<?php
$this->breadcrumbs = array(
    'Informasi Permintaan Darah',
);

if (isset($_GET['sukses'])) {
    Yii::app()->user->setFlash('success', "Data berhasil disimpan!");
}

$this->widget('bootstrap.widgets.BootAlert');
?>

<?php
/**
 * @author Aida Rahmawati <aidarahmawati@.com>
 */
Yii::app()->clientScript->registerScript('search', "
    $('.search-button').click(function(){
            $('.search-form').toggle();
            return false;
    });
    $('#permintaanpmi-r-search').submit(function(){
            $.fn.yiiGridView.update('permintaanpmi-r-grid', {
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
            <i class="entypo-info-circled"></i> Informasi <b>Permintaan Darah</b>
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
                <?php $this->renderPartial($this->path_view . '_search', array('model' => $model,)); ?>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Permintaan Darah</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php
                $this->widget('ext.bootstrap.widgets.BootGridView', array(
                    'id' => 'permintaanpmi-r-grid',
                    'dataProvider' => $model->searchInformasi(),
                    'columns' => array(
                        array(
                            'header' => 'No.',
                            'value' => '($this->grid->dataProvider->pagination) ? 
                                                    ($this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1)
                                                    : ($row+1)',
                            'type' => 'raw',
                            'htmlOptions' => array(
                                'style' => 'text-align:left;'
                            ),
                        ),
                        array(
                            'header' => 'Tanggal Permintaan Darah',
                            'value' => function ($data) {
                                return MyFormatter::formatDateTimeForUser($data->tgl_permintaan);
                            }
                        ),
                        array(
                            'header' => 'No. Permintaan',
                            'value' => '$data->no_permintaan',
                        ),
                        array(
                            'header' => 'Petugas',
                            'value' => '$data->nama_pegawai',
                        ),
                        array(
                            'header' => 'Status Permintaan',
                            'value' => function ($data) {
                                if (!empty($data->penerimaandarahpmi_id)) {
                                    echo "Sudah Diterima";
                                } else {
                                    echo "Belum Diterima";
                                }
                            }
                        ),
                        array(
                            'header' => 'Penerimaan Darah',
                            'type' => 'raw',
                            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                            'value' => function ($data) {
                                if (empty($data->penerimaandarahpmi_id)) {
                                    return CHtml::link("<i class='icon-form-ubah'></i>", Yii::app()->createUrl('bankDarah/penerimaanDarahPMI/index&permintaandarahpmi_id=' . $data->permintaandarahpmi_id . '&iframe=1'), array("rel" => "tooltip", "title" => "Klik untuk menambahkan Penerimaan Darah dari PMI"));
                                } else {
                                    return CHtml::link(
                                        "<i class='icon-form-ubah'></i>",
                                        Yii::app()->createUrl('bankDarah/InformasiPermintaanDarahPMI/detail&permintaandarahpmi_id=' . $data->permintaandarahpmi_id),
                                        array(
                                            'class' => 'hover',
                                            "rel" => "tooltip",
                                            "target" => "iframeDetail",
                                            "onclick" => "$('#dialogDetail').dialog('open');",
                                            "title" => "Klik untuk Melihat Detail Penerimaan Darah PMI"
                                        )
                                    );
                                }
                            }
                        ),
                        array(
                            'header' => 'Batal Permintaan',
                            'type' => 'raw',
                            'value' => function ($data) {
                                if ($data->isbatal == true) {
                                    echo " ";
                                } else {
                                    if (!empty($data->penerimaandarahpmi_id)) {
                                        echo " ";
                                    } else {
                                        return CHtml::link("<i class='icon-form-silang'></i> ", "javascript:removeTemporary($data->permintaandarahpmi_id)", array("id" => "$data->permintaandarahpmi_id", "rel" => "tooltip", "title" => "Membatalkan Permintaan Darah"));
                                    }
                                }
                            },
                            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                        )

                    ),
                    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"}'
                        . ');'
                        . ' }',
                ));

                $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
                $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
                $urlPrint =  Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/print');
                $url = Yii::app()->createAbsoluteUrl($module . '/' . $controller);
                ?>
            </div>
        </div>
    </div>
</div>

<?php
// ===========================Dialog Details Penerimaan Darah=========================================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogDetail',
    // additional javascript options for the dialog plugin
    'options' => array(
        'title' => 'Detail Penerimaan Darah ke PMI',
        'autoOpen' => false,
        'width' => 1000,
        'height' => 500,
        'resizable' => true,
        'scroll' => false,
    ),
));
?>
<iframe src="" name="iframeDetail" style="width:100%; height: 98%;"></iframe>
<?php
$this->endWidget('zii.widgets.jui.CJuiDialog');
//===============================Akhir Dialog Penerimaan Darah================================
?>
<script>
    console.log('<?php echo $url ?>');

    function removeTemporary(id) {
        var url = '<?php echo $url . "/removeTemporary"; ?>';
        myConfirm('Apakah Anda yakin untuk membatalkan permintaan darah ini?', 'Perhatian!', function(r) {
            if (r) {
                $.post(url, {
                        id: id
                    },
                    function(data) {
                        if (data.status == 'proses_form') {
                            $.fn.yiiGridView.update('permintaanpmi-r-grid');
                        } else {
                            myAlert('Permintaan Gagal Dibatalkan');
                        }
                    }, "json");
            }
        });
    }
</script>