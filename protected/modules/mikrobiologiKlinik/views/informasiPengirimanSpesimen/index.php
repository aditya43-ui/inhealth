<?php
/**
 * @author Aida Rahmawati <aidarahmawati@.com>
 */
Yii::app()->clientScript->registerScript('search', "
    $('.search-button').click(function(){
            $('.search-form').toggle();
            return false;
    });
    $('#pengiriman-spesimen-r-search').submit(function(){
            $.fn.yiiGridView.update('pengirimanspesimen-r-grid', {
                    data: $(this).serialize()
            });
            return false;
    });
    ");

$this->widget('bootstrap.widgets.BootAlert');
?>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-primary panel-gradient">
            <div class="panel-heading">
                <div class="panel-title">Informasi <strong> Pengiriman Spesimen </strong></div>
            </div>
            <div class="panel-body">
                <div class="panel panel-success panel-shadow">
                    <div class="panel-heading">
                        <div class="panel-title">Tabel <strong> Pengiriman Spesimen </strong></div>
                    </div>
                    <div class="panel-body overflow-x" >
                        <?php
                        $this->widget('ext.bootstrap.widgets.BootGridView', array(
                            'id' => 'pengirimanspesimen-r-grid',
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
                                    'header' => 'Waktu Pengiriman',
                                    'value' => function($data) {
                                        echo MyFormatter::formatDateTimeForUser($data->tglkirimspesimen);
                                    }
                                ),
                                array(
                                    'header' => 'No. Pengiriman',
                                    'name' => 'no_kirimspesimen'
                                ),
                                array(
                                    'header' => 'Petugas Pengiriman',
                                    'value' => function($data) {
                                        $ruangan = PegawaiM::model()->findByPk($data->petugaskirim_id);
                                        echo $ruangan->namaLengkap;
                                    }
                                ),
                                array(
                                    'header' => 'Spesimen ID',
                                    'name' => 'no_spesimen'
                                ),
                                array(
                                    'header' => 'Nama Pasien',
                                    'name' => 'nama_pasien'
                                ),
                                array(
                                    'header' => 'No RM',
                                    'name' => 'no_rekam_medik'
                                ),
                                array(
                                    'header' => 'Ruangan Asal',
                                    'name' => 'ruangan_nama'
                                ),
                                array(
                                    'header' => 'Jenis Spesimen',
                                    'name' => 'samplelab_nama',
                                ),
                                array(
                                    'header' => 'Jenis Pemeriksaan',
                                    'name' => 'daftartindakan_nama',
                                ),
                                array(
                                    'header' => 'Status Pengiriman',
                                    'name' => 'status',
                                    'htmlOptions' => array(
                                        'style' => 'text-align: center',
                                    ),
                                ),
                                array(
                                    'header' => 'Batal',
                                    'type' => 'raw',
                                    'value' => function($data) {
                                        if ($data->status == 'Sudah Diterima') {
                                            echo CHtml::link('<i style="font-size:17px" class="glyphicon glyphicon-remove"></i>', '#', array(
                                                'width' => '23px',
                                                'height' => '23px',
                                                'rel' => 'tooltip',
                                                'data-placement' => 'left',
                                                'title' => 'Klik untuk membatalkan pengiriman',
                                                'onclick' => 'myAlert("Tidak dapat membatalkan pengiriman karena spesimen sudah diterima. "); return false;'
                                            ));
                                        } else {
                                            echo CHtml::link('<i style="font-size:17px; color: #CA3433;" class="glyphicon glyphicon-remove" color="red"></i>', '#', array(
                                                'width' => '23px',
                                                'height' => '23px',
                                                'rel' => 'tooltip',
                                                'data-placement' => 'left',
                                                'title' => 'Klik untuk membatalkan pengiriman',
                                                'onclick' => 'batalKirim(this, ' . $data->pengirimanspesimendet_id . '); return false;'
                                            ));
                                        }
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
                <div class="panel panel-success panel-shadow">
                    <div class="panel-heading">
                        <div class="panel-title"><i class="entypo-search"></i> <b> Pencarian </b></div>
                    </div>
                    <div class="panel-body">
                        <fieldset class="">
                            <?php
                            $this->renderPartial('search', array(
                                'model' => $model,
                            ));
                            ?>
                        </fieldset>
                    </div>
                </div>	
            </div>
        </div>
    </div>
</div>
<?php
$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
$module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
$url = Yii::app()->createAbsoluteUrl($module . '/' . $controller);
$urlPrint = Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/print');
$js = <<< JSCRIPT
        function cekForm(obj){
                $("#informasiae-r-search :input[name='"+ obj.name +"']").val(obj.value);
        }
        function print(caraPrint){
                window.open("${urlPrint}/"+$('#informasiae-r-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
        }
JSCRIPT;
Yii::app()->clientScript->registerScript('print', $js, CClientScript::POS_HEAD);

// ===========================Dialog Penelitian=========================================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialog1',
    // additional javascript options for the dialog plugin
    'options' => array(
        'title' => 'Detail Pengiriman Spesimen',
        'autoOpen' => false,
        'width' => 1100,
        'height' => 600,
        'resizable' => true,
        'scroll' => false,
    ),
));
?>
<iframe src="" name="frame1" width="100%" height="100%">
</iframe>
<?php
$this->endWidget('zii.widgets.jui.CJuiDialog');
//===============================Akhir Dialog Work Order================================
?>
<?php
// ===========================Dialog Penelitian=========================================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialog2',
    // additional javascript options for the dialog plugin
    'options' => array(
        'title' => 'Detail Penerimaan Spesimen',
        'autoOpen' => false,
        'width' => 1100,
        'height' => 600,
        'resizable' => true,
        'scroll' => false,
    ),
));
?>
<iframe src="" name="frame2" width="100%" height="100%">
</iframe>
<?php
$this->endWidget('zii.widgets.jui.CJuiDialog');
//===============================Akhir Dialog Work Order================================
?>

<script>
    function batalKirim(obj, id) {
        myConfirm('Apakah anda yakin untuk membatalkan pengiriman spesimen ini?', 'Perhatian!', function (r) {
            if (r) {
                $.post('<?php echo $this->createUrl('batalKirim'); ?>', {id: id}, function (data) {
                    if (data.ok == 1) {
                        myAlert(data.msg);
                        $.fn.yiiGridView.update('pengirimanspesimen-r-grid');
                    } else {
                        myAlert(data.msg);
                    }
                }, 'json');
            }
        });
    }
</script>