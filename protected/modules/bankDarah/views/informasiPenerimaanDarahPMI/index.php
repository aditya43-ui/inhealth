<?php
$this->breadcrumbs = array(
    'Informasi Penerimaan Kantong Darah dari PMI',
);

if (isset($_GET['sukses'])) {
    Yii::app()->user->setFlash('success', "Data berhasil disimpan!");
}

$this->widget('bootstrap.widgets.BootAlert');
?>
<?php
Yii::app()->clientScript->registerScript('search', "
    $('#penerimaandarah-r-search').submit(function(){
        $.fn.yiiGridView.update('penerimaandarah-r-grid', {
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
            <i class="entypo-info-circled"></i> Informasi <b>Penerimaan Kantong Darah dari PMI</b>
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
                    <i class="entypo-credit-card"></i> Tabel <b>Penerimaan Kantong Darah dari PMI</b>
                </div>
            </div>
            <div class="panel-body table-responsive" id="tabel_informasi">
                <?php
                $this->widget('ext.bootstrap.widgets.BootGridView', array(
                    'id' => 'penerimaandarah-r-grid',
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
                        ),
                        array(
                            'header' => 'Tgl. Penerimaan Darah',
                            'value' => function ($data) {
                                echo MyFormatter::formatDateTimeForUser($data->tgl_penerimaan);
                            },
                        ),
                        array(
                            'header' => 'No. Penerimaan',
                            'value' => function ($data) {
                                echo $data->no_penerimaan;
                            },
                        ),
                        array(
                            'header' => 'Petugas Penerima',
                            'value' => function ($data) {
                                $pegawai = "";
                                if (!empty($data->petugas_penerima_id)) {
                                    $pegawai = PegawaiM::model()->findByPk($data->petugas_penerima_id)->namaLengkap;
                                }
                                return $pegawai;
                            },
                        ),
                        array(
                            'header' => 'Petugas Mengetahui',
                            'value' => function ($data) {
                                $pegawai = "";
                                if (!empty($data->petugas_mengetahui_id)) {
                                    $pegawai = PegawaiM::model()->findByPk($data->petugas_mengetahui_id)->namaLengkap;
                                }
                                return $pegawai;
                            },
                        ),
                        array(
                            'header' => 'Detail Penerimaan',
                            'type' => 'raw',
                            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                            'value' => function ($data) {
                                if ($data->is_detailpenerimaan) {
                                    return CHtml::Link(
                                        "<span style='font-size:17px;color:green'><i class='" . MyIcon::getIcons('list') . "'></i></span>",
                                        $this->createUrl("DetailPenerimaanDarahPMI/index", array("penerimaandarahpmi_id" => $data->penerimaandarahpmi_id, "frame" => 1, 'sukses' => 1)),
                                        array(
                                            "class" => "",
                                            "target" => "frameDetail",
                                            "onclick" => "$('#dialogDetail').dialog('open');",
                                            "rel" => "tooltip",
                                            "title" => "Detail sudah dilakukan",
                                        )
                                    );
                                } else {
                                    return CHtml::Link(
                                        "<span style='font-size:17px'><i class='" . MyIcon::getIcons('list2') . "'></i></span>",
                                        $this->createUrl("DetailPenerimaanDarahPMI/index", array("penerimaandarahpmi_id" => $data->penerimaandarahpmi_id, "detil" => 1)),
                                        array(
                                            "class" => "",
                                            "rel" => "tooltip",
                                            "title" => "Transaksi detail penerimaan",
                                        )
                                    );
                                }
                            },
                        ),
                        /*array(
                            'header'=>'Masukan Stok',
                            'type'=>'raw',
                            'htmlOptions'=>array('style'=>'text-align:center;'),
                            'value'=>function($data){
                                if($data->is_detailpenerimaan){
                                    return CHtml::Link("<span style='font-size:17px;color:green'><i class='".MyIcon::getIcons('pengaturan')."'></i></span>",$this->createUrl("MasukStokDarahPMI/index",array("penerimaandarahpmi_id"=>$data->penerimaandarahpmi_id)),
                                        array("class"=>"", 
                                            "target"=>"frameStok",
                                            "onclick"=>"$('#dialogStok').dialog('open');",
                                            "rel"=>"tooltip",
                                            "title"=>"Transaksi masuk stok darah",
                                    ));
                                }else{
                                    return CHtml::Link("<span style='font-size:17px;color:orange'><i class='".MyIcon::getIcons('pengaturan')."'></i></span>", "#",
                                        array("class"=>"", 
                                            "onclick"=>"myAlert('Anda belum melakukan transaksi detail penerimaan kantong darah');return false;",
                                            "rel"=>"tooltip",
                                            "title"=>"Transaksi Detail belum dilakukan",
                                    ));
                                }
                            },
                        ),*/
                        array(
                            'header' => 'Batal Terima',
                            'type' => 'raw',
                            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                            'value' => function ($data) {
                                if ($data->is_detailpenerimaan) {
                                    return CHtml::Link(
                                        "<span style='font-size:17px;color:green'><i class='" . MyIcon::getIcons('batal') . "'></i></span>",
                                        "#",
                                        array(
                                            "class" => "",
                                            "onclick" => "myAlert('Batal tidak dapat dilakukan, Detail penerimaan darah sudah dilakukan');return false;",
                                            "rel" => "tooltip",
                                            "title" => "Sudah dilakukan detail",
                                        )
                                    );
                                } else {
                                    return CHtml::Link(
                                        "<span style='font-size:17px;color:red'><i class='" . MyIcon::getIcons('batal') . "'></i></span>",
                                        "#",
                                        array(
                                            "class" => "",
                                            "onclick" => "batalPenerimaan(" . $data->penerimaandarahpmi_id . ");return false;",
                                            "rel" => "tooltip",
                                            "title" => "Batal penerimaan",
                                        )
                                    );
                                }
                            },
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
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogDetail',
    'options' => array(
        'title' => 'Detail Penerimaan Darah dari UTD PMI',
        'autoOpen' => false,
        'width' => 1000,
        'height' => 500,
        'resizable' => true,
        'scroll' => false,
        'close' => "js:function(){ $.fn.yiiGridView.update('penerimaandarah-r-grid', {
            data: $('#penerimaandarah-r-search').serialize()
    }); }",
    ),
));
?>
<iframe src="" name="frameDetail" style="width: 100%; height: 98%; border: none;"></iframe>
<?php
$this->endWidget('zii.widgets.jui.CJuiDialog');
?>
<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogStok',
    'options' => array(
        'title' => 'Masukan Stok Kantong Darah dari PMI',
        'autoOpen' => false,
        'width' => 1000,
        'height' => 500,
        'resizable' => true,
        'scroll' => false,
        'close' => "js:function(){ $.fn.yiiGridView.update('penerimaandarah-r-grid', {
            data: $('#penerimaandarah-r-search').serialize()
    }); }",
    ),
));
?>
<iframe src="" name="frameStok" style="width:100%; height: 98%;"></iframe>
<?php
$this->endWidget('zii.widgets.jui.CJuiDialog');
?>

<script>
    function batalPenerimaan(penerimaandarahpmi_id) {
        myConfirm('Anda yakin untuk membatalkan penerimaan ini?', 'Perhatian!', function(r) {
            if (r) {
                $("#tabel_informasi").addClass("animation-loading");
                $.ajax({
                    type: 'POST',
                    url: '<?php echo $this->createUrl('BatalPenerimaan'); ?>',
                    data: {
                        penerimaandarahpmi_id: penerimaandarahpmi_id
                    },
                    dataType: "json",
                    success: function(data) {
                        $("#tabel_informasi").removeClass("animation-loading");
                        if (data.sukses == 1) {
                            $.fn.yiiGridView.update('penerimaandarah-r-grid');
                        } else {
                            myAlert("Batal gagal dilakukan");
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        myAlert("Batal gagal dilakukan");
                        $("#tabel_informasi").removeClass("animation-loading");
                    }
                });
            }
        });
    }
</script>