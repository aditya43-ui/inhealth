<?php
$this->breadcrumbs = array(
    'Surat Eligibilitas Peserta (SEP)',
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('#assep-t-search').submit(function(){
	$.fn.yiiGridView.update('assep-t-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="glyphicon glyphicon-briefcase"></i> <b>Surat Eligibilitas Peserta (SEP)</b>
        </div>
    </div>
    <div class="panel-body">

        <?php $this->widget('bootstrap.widgets.BootAlert'); ?>

        <?php // echo CHtml::link(Yii::t('mds','{icon} Advanced Search',array('{icon}'=>'<i class="icon-search"></i>')),'#',array('class'=>'search-button btn')); 
        ?>
        <!--<div class="cari-lanjut search-form" style="display:none">-->
        <?php // $this->renderPartial('_search',array(
        //		'model'=>$model,
        //	)); 
        ?>
        <!--</div> search-form -->
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-search"></i> Pencarian
                </div>
            </div>
            <div class="panel-body">
                <?php $this->renderPartial('_search_sep', array(
                    'model' => $model,
                )); ?>
            </div>
        </div>

        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel Surat Eligibilitas Peserta (SEP)
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php $this->widget('ext.bootstrap.widgets.BootGridView', array(
                    'id' => 'assep-t-grid',
                    'dataProvider' => $model->search(),
                    'filter' => $model,
                    'template' => "{summary}\n{items}\n{pager}",
                    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
                    'columns' => array(
                        array(
                            'header' => 'No.',
                            'value' => '($this->grid->dataProvider->pagination) ? 
                                                ($this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1)
                                                : ($row+1)',
                            'type' => 'raw',
                            'htmlOptions' => array('style' => 'text-align:right;'),
                        ),
                        array(
                            'header' => 'Tanggal SEP',
                            'type' => 'raw',
                            'value' => 'isset($data->tglsep) ? MyFormatter::formatDateTimeForUser($data->tglsep) : ""',
                        ),
                        array(
                            'header' => 'No. SEP',
                            'type' => 'raw',
                            'value' => '$data->nosep',
                        ),
                        array(
                            'header' => 'No. Peserta',
                            'type' => 'raw',
                            'value' => '$data->nokartuasuransi',
                        ),
                        array(
                            'header' => 'No. Pendaftaran',
                            'type' => 'raw',
                            'value' => '$data->no_pendaftaran',
                        ),
                        array(
                            'header' => 'No. RM',
                            'type' => 'raw',
                            'value' => '$data->no_rekam_medik',
                        ),
                        array(
                            'header' => 'Nama Pasien/Peserta',
                            'type' => 'raw',
                            'value' => '$data->nama_pasien',
                        ),
                        array(
                            'header' => 'Jenis Pelayanan',
                            'type' => 'raw',
                            'value' => '($data->jnspelayanan==2)? "Rawat Jalan" : "Rawat Inap"',
                        ),
                        array(
                            'header' => 'Laka Lantas',
                            'type' => 'raw',
                            'value' => '($data->lakalantas==1)? "YA" : "TIDAK"',
                        ),
                        array(
                            'header' => 'Lihat',
                            'type' => 'raw',
                            'value' => 'CHtml::link("<i class=icon-form-view></i> ", "#",
                                        array(
                                        "rel"=>"tooltip",
                                        "title"=>"Klik untuk melihat SEP",
                                        "onclick"=>"lihatSEP($data->sep_id);return false;"))',
                            'htmlOptions' => array('style' => 'text-align:center;'),
                        ),
                        array(
                            'header' => 'Update SEP',
                            'type' => 'raw',
                            'value' => 'CHtml::link("<i class=icon-form-ubah></i> ", Yii::app()->createUrl("/' . Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/updateSEP", array("sep_id"=>$data->sep_id,"no_rekam_medik"=>$data->no_rekam_medik)),
                                        array(
                                        "target"=>"frameUbahSEP",
                                        "rel"=>"tooltip",
                                        "title"=>"Klik untuk mengubah SEP",
                                        "onclick"=>"$(\'#dialogUbahSEP\').dialog(\'open\');"))',
                            'htmlOptions' => array('style' => 'text-align:center;'),
                        ),
                        array(
                            'header' => 'Update Tanggal Pulang',
                            'type' => 'raw',
                            'value' => 'CHtml::link("<i class=icon-form-ubah></i> ", Yii::app()->createUrl("/' . Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/UpdateTglPulang", array("sep_id"=>$data->sep_id,"no_rekam_medik"=>$data->no_rekam_medik)),
                                        array(
                                        "target"=>"frameUbahTanggalPulang",
                                        "rel"=>"tooltip",
                                        "title"=>"Klik untuk mengubah Tanggal Pulang",
                                        "onclick"=>"$(\'#dialogUbahTanggalPulang\').dialog(\'open\');"))',
                            'htmlOptions' => array('style' => 'text-align:center;'),
                        ),
                        array(
                            'header' => Yii::t('zii', 'Delete'),
                            'class' => 'bootstrap.widgets.BootButtonColumn',
                            'template' => '{delete}',
                            'buttons' => array(
                                'delete' => array(
                                    'label' => "<i class='icon-form-trash'></i>",
                                    'options' => array('title' => 'Klik untuk menghapus data SEP'),
                                    'url' => 'Yii::app()->createUrl("' . Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/hapusSEP",array("id"=>$data->sep_id))',
                                    'click' => 'function(){hapusSEP(this);return false;}',
                                ),
                            )
                        ),
                    ),
                    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
                )); ?>
            </div>
        </div>

        <div class="form-actions">
            <?php
            echo CHtml::link(
                Yii::t('mds', '{icon} Tambah SEP', array('{icon}' => '<i class="icon-plus icon-white"></i>')),
                $this->createUrl('create', array('modul_id' => Yii::app()->session['modul_id'])),
                array('title' => 'Tambah SEP', 'class' => 'btn btn-danger')
            ) . "&nbsp;";
            echo CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PRINT\')')) . "&nbsp;";
            echo CHtml::htmlButton(Yii::t('mds', '{icon} PDF', array('{icon}' => '<i class="icon-book icon-white"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PDF\')')) . "&nbsp;";
            echo CHtml::htmlButton(Yii::t('mds', '{icon} Excel', array('{icon}' => '<i class="icon-pdf icon-white"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'EXCEL\')')) . "&nbsp;";
            $content = $this->renderPartial('../tips/tips', array(), true);
            $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
            $urlPrint = $this->createUrl('print');

            $js = <<< JSCRIPT
function print(caraPrint)
{
    window.open("${urlPrint}/"+$('#assep-t-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
JSCRIPT;
            Yii::app()->clientScript->registerScript('print', $js, CClientScript::POS_HEAD);
            ?>
        </div>
    </div>
</div>

<script type="text/javascript">
    function nonActive(obj) {
        myConfirm("Yakin akan menonaktifkan data ini untuk sementara?", "Perhatian!",
            function(r) {
                if (r) {
                    $.ajax({
                        type: 'GET',
                        url: obj.href,
                        data: {}, //
                        dataType: "json",
                        success: function(data) {
                            $.fn.yiiGridView.update('assep-t-grid');
                            if (data.sukses > 0) {} else {
                                myAlert('Data gagal dinonaktifkan!');
                            }
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            myAlert('Data gagal dinonaktifkan!');
                            console.log(errorThrown);
                        }
                    });
                }
            }
        );
        return false;
    }

    function hapusSEP(obj) {
        myConfirm("Yakin akan menghapus data SEP ini?", "Perhatian!",
            function(r) {
                if (r) {
                    $("#assep-t-grid").addClass("animation-loading");
                    $.ajax({
                        type: 'GET',
                        url: obj.href,
                        data: {}, //
                        dataType: "json",
                        success: function(data) {
                            $.fn.yiiGridView.update('assep-t-grid');
                            if (data.sukses > 0) {
                                myAlert(data.status);
                            } else {
                                myAlert(data.status);
                            }
                            $("#assep-t-grid").removeClass("animation-loading");
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            myAlert(data.status);
                            console.log(errorThrown);
                            $("#assep-t-grid").removeClass("animation-loading");
                        }
                    });
                }
            }
        );
        return false;
    }

    function periksaSEP(obj) {
        myConfirm("Yakin akan melakukan Periksa SEP?", "Perhatian!",
            function(r) {
                if (r) {
                    $.ajax({
                        type: 'GET',
                        url: obj.href,
                        data: {}, //
                        dataType: "json",
                        success: function(data) {
                            $.fn.yiiGridView.update('assep-t-grid');
                            if (data.sukses > 0) {
                                myAlert(data.status);
                            } else {
                                myAlert(data.status);
                            }
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            myAlert(data.status);
                            console.log(errorThrown);
                        }
                    });
                }
            }
        );
        return false;
    }

    function lihatSEP(sep_id) {
        window.open('<?php echo $this->createUrl('printSep'); ?>&sep_id=' + sep_id, 'printwin', 'left=100,top=100,width=860,height=480');
    }
</script>
<?php
// Dialog untuk ubah tanggal pulang =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogUbahTanggalPulang',
    'options' => array(
        'title' => 'Ubah Tanggal Pulang',
        'autoOpen' => false,
        'modal' => true,
        'zIndex' => 1002,
        'width' => 900,
        'height' => 400,
        'resizable' => true,
        'close' => "js:function(){ $.fn.yiiGridView.update('assep-t-grid', {
						data: $('#assep-t-search').serialize()
					}); }",
    ),
));
?>
<iframe name='frameUbahTanggalPulang' width="100%" height="100%"></iframe>
<?php $this->endWidget(); ?>
<?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogSEP',
    'options' => array(
        'title' => 'Laporan SEP',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'height' => 550,
        'resizable' => false,
    ),
));
?>
<iframe name='frameSEP' width="100%" height="100%"></iframe>
<?php $this->endWidget(); ?>

<?php
// Dialog untuk ubah tanggal pulang =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogUbahSEP',
    'options' => array(
        'title' => 'Ubah Data SEP',
        'autoOpen' => false,
        'modal' => true,
        'zIndex' => 1002,
        'width' => 900,
        'height' => 600,
        'resizable' => true,
        'close' => "js:function(){ $.fn.yiiGridView.update('assep-t-grid', {
                            data: $('#assep-t-search').serialize()
                    }); }",
    ),
));
?>
<iframe name='frameUbahSEP' width="100%" height="100%"></iframe>
<?php $this->endWidget(); ?>