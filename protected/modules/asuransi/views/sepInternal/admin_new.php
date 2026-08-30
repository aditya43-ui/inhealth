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
            <i class="glyphicon glyphicon-briefcase"></i> <b>SEP Rujukan Internal</b>
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
                <?php $this->renderPartial($this->path_view . '_search_sep', array(
                    'model' => $model,
                )); ?>
            </div>
        </div>

        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel SEP Rujukan Internal
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
                            'header' => 'No. Rujukan Internal/ No. SEP Rujukan',
                            'type' => 'raw',
                            'value' => '$data->nosurat_rujukaninternal." / ".$data->nosep',
                        ),
                        array(
                            'header' => 'Tanggal Rujukan Internal',
                            'type' => 'raw',
                            'value' => '(isset($data->tglkonsulpoli) ? MyFormatter::formatDateTimeForUser($data->tglkonsulpoli) : "")',
                        ),
                        array(
                            'header' => 'No. Sep / Tanggal SEP',
                            'type' => 'raw',
                            'value' => '$data->nosep_utama." / ".(isset($data->tglsep_utama) ? MyFormatter::formatDateTimeForUser($data->tglsep_utama) : "")',
                        ),
                        array(
                            'header' => 'No. Peserta',
                            'type' => 'raw',
                            'value' => '$data->nokartuasuransi',
                        ),
                        array(
                            'header' => 'No. Pendaftaran / No. Rekam Medik',
                            'type' => 'raw',
                            'value' => '$data->no_pendaftaran." / ".$data->no_rekam_medik',
                        ),
                        array(
                            'header' => 'Nama Pasien (Peserta)',
                            'type' => 'raw',
                            'value' => '$data->nama_pasien',
                        ),
                        array(
                            'header' => 'Dokter DPJP Tujuan',
                            'type' => 'raw',
                            'value' => function($data) {
                                return $data->gelardepan.$data->nama_pegawai.", ".$data->gelarbelakang_nama;
                            }
                        ),
                        array(
                            'header' => 'Ruangan Asal',
                            'type' => 'raw',
                            'value' => '$data->ruanganasal_nama',
                        ),
                        array(
                            'header' => 'Ruangan Tujuan',
                            'type' => 'raw',
                            'value' => '$data->ruangantujuan_nama',
                        ),
                        array(
                            'header' => 'Ruangan Tujuan',
                            'type' => 'raw',
                            'value' => '($data->lakalantas==1)? "YA" : "TIDAK"',
                        ),
                        array(
                            'header' => 'Diagnosa',
                            'type' => 'raw',
                            'value' => '$data->nama_diagnosaawal',
                        ),
                        array(
                            'header' => 'Buat Rujukan',
                            'type' => 'raw',
                            'value' => function($data) {
                                return !empty($data->nosurat_rujukaninternal) ? "" : CHtml::link("<i class=\"icon-form-ubah\"></i> ", Yii::app()->controller->createUrl("create", array("pendaftaran_id"=>$data->pendaftaran_id, "konsulpoli_id"=>$data->konsulpoli_id)),
                                array(
                                "rel"=>"tooltip",
                                "title"=>"Klik untuk membuat SEP Rujukan Internal"));
                            },
                            'htmlOptions' => array('style' => 'text-align:center;'),
                        ),
                        array(
                            'header' => 'Cetak',
                            'type' => 'raw',
                            'value' => function($data) {
                                if (empty($data->nosurat_rujukaninternal)) {
                                    return "";
                                }
                                return CHtml::link('<i class="icon-form-print"></i>', '#', array(
                                    'onclick'=>'printSEP('.$data->sep_id.');return false',
                                ));
                            },
                            'htmlOptions' => array('style' => 'text-align:center;'),
                        ),
                        array(
                            'header' => 'Hapus',
                            'type' => 'raw',
                            'value' => function($data) {
                                if (empty($data->nosurat_rujukaninternal)) {
                                    return "";
                                }
                                return CHtml::link('<i class="icon-form-sampah"></i>', Yii::app()->createUrl(Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . "/hapusSEP",array("id"=>$data->sep_id)), array(
                                    'onclick'=>'hapusSEP(this);return false;',
                                ));
                            },
                            'htmlOptions' => array('style' => 'text-align:center;'),
                        ),
                    ),
                    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
                )); ?>
            </div>
        </div>

        <div class="form-actions">
            <?php
           
            echo CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PRINT\')')) . "&nbsp;";
            echo CHtml::htmlButton(Yii::t('mds', '{icon} PDF', array('{icon}' => '<i class="icon-book icon-white"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PDF\')')) . "&nbsp;";
            echo CHtml::htmlButton(Yii::t('mds', '{icon} Excel', array('{icon}' => '<i class="icon-pdf icon-white"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'EXCEL\')')) . "&nbsp;";
            $content = $this->renderPartial($this->path_view_tips . 'tips3', array(), true);
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
    function printSEP(id) {
        window.open('<?php echo $this->createUrl('printSep'); ?>&sep_id=' + id, 'printwin', 'left=100,top=100,width=860,height=480');
    }
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