<?php
$this->breadcrumbs = array(
    'Assep Ts' => array('index'),
    'Manage',
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('assep-t-grid', {
		data: $(this).serialize()
	});
    setBackgroundTr();
	return false;
});
");
?>
<style>
    .row_abu td {
        /* background-color: yellow !important; */
        background-color: #ebebeb !important;
    }

    .row_putih td {
        /* background-color: red !important; */
        background-color: #fff !important;
        /* color: white; */
    }
</style>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">Approval <b>(SEP)</b></div>
    </div>
    <div class="panel-body">
        <?php $this->widget('bootstrap.widgets.BootAlert'); ?>

        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">Tabel Approval (SEP)</div>
            </div>
            <div class="panel-body">
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
                            'header' => 'Tanggal Pengajuan',
                            'type' => 'raw',
                            'value' => 'isset($data->tanggal_pengajuan) ? MyFormatter::formatDateTimeForUser($data->tanggal_pengajuan) : ""',
                        ),
                        array(
                            'header' => 'Tanggal SEP',
                            'type' => 'raw',
                            'value' => function ($data) {
                                $modSep = SepT::model()->findByAttributes(array(
                                    'nokartuasuransi' => $data->no_kartu_bpjs,
                                    'tglsep' => Myformatter::formatDateTimeForDb($data->tgl_sep)
                                ));
                                if (empty($modSep)) {
                                    return '';
                                } else {
                                    return $modSep->tglsep;
                                }
                            },
                            // 'isset($data->sep->tglsep) ? $data->sep->tglsep : ""',
                            // 'value' => 'isset($data->tgl_sep) ? $data->tgl_sep : ""',
                        ),
                        array(
                            'header' => 'No. SEP',
                            'type' => 'raw',
                            'value' => function ($data) {
                                $modSep = SepT::model()->findByAttributes(array(
                                    'nokartuasuransi' => $data->no_kartu_bpjs,
                                    'tglsep' => Myformatter::formatDateTimeForDb($data->tgl_sep)
                                ));
                                if (empty($modSep)) {
                                    return '';
                                } else {
                                    return $modSep->nosep;
                                }
                            },
                            // 'isset($data->sep->nosep)? $data->sep->nosep : ""',
                        ),
                        array(
                            'header' => 'No. Peserta',
                            'type' => 'raw',
                            'value' => '$data->no_kartu_bpjs',
                        ),
                        array(
                            'header' => 'No. Pendaftaran',
                            'type' => 'raw',
                            'value' => '$data->pendaftaran->no_pendaftaran ?? ""',
                        ),
                        array(
                            'header' => 'No. RM',
                            'type' => 'raw',
                            'value' => '$data->pendaftaran->pasien->no_rekam_medik ?? ""',
                        ),
                        array(
                            'header' => 'Nama Pasien/Peserta',
                            'type' => 'raw',
                            'value' => function($data) {
                                if(!empty($data->pendaftaran->pasien->nama_pasien)) {
                                    echo $data->pendaftaran->pasien->nama_pasien;
                                } else {
                                    echo $data->namapeserta_bpjs;
                                }
                            },
                        ),
                        array(
                            'header' => 'Jenis Pelayanan',
                            'type' => 'raw',
                            'value' => '($data->jenis_pelayanan==2)? "Rawat Jalan" : "Rawat Inap"',
                        ),
                        array(
                            'header' => 'Jenis Pengajuan',
                            'type' => 'raw',
                            'value' =>
                            function ($data) {
                                $modlookup = LookupM::model()->findByAttributes(array(
                                    'lookup_type' => 'jnspengajuan_approvalsep',
                                    'lookup_value' => $data->jnspengajuan_approvalsep,
                                ));
                                if (!empty($modlookup)) {
                                    $str = $modlookup->lookup_name;
                                    if ($data->jnspengajuan_approvalsep == 1) {
                                        $str .= '<span class="sorot_abu">&nbsp;</span>';
                                    } else {
                                        $str .= '<span class="sorot_putih">&nbsp;</span>';
                                    }
                                } else {
                                    $str = '';
                                }

                                return $str;
                            },
                        ),
                        array(
                            'header' => 'Approve',
                            'type' => 'raw',
                            'value' => '($data->is_approval==TRUE)? "Sudah Approve" : CHtml::link("<i class=icon-edit></i> ", Yii::app()->createUrl("/' . Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/Approve", array("id"=>$data->pengajuanapprovalsep_id)),
                                        array(
                                        "target"=>"frameApprove",
                                        "rel"=>"tooltip",
                                        "title"=>"Klik untuk Approve SEP",
                                        "onclick"=>"$(\'#dialogApprove\').dialog(\'open\');"))',
                            'htmlOptions' => array('style' => 'text-align:center;'),
                            'headerHtmlOptions' => array('style' => 'text-align:center;'),
                        ),
                        array(
                            'header' => 'Buat SEP',
                            'type' => 'raw',
                            'value' => function ($data) {
                                $modSep = SepT::model()->findByAttributes(array(
                                    'nokartuasuransi' => $data->no_kartu_bpjs,
                                    'tglsep' => Myformatter::formatDateTimeForDb($data->tgl_sep)
                                ));
                                if (!empty($modSep)) {
                                    return "SEP Sudah Terbuat";
                                } else {
                                    if ($data->is_approval == FALSE) {
                                        return "Belum Approve";
                                    } else {
                                        return CHtml::link(
                                            "<i class=icon-edit></i> ",
                                            Yii::app()->createUrl("/pendaftaranPenjadwalan/sepAsuransi/create", array("pengajuanapprovalsep_id" => $data->pengajuanapprovalsep_id)),
                                            array(
                                                "rel" => "tooltip",
                                                "title" => "Klik untuk Buat SEP"
                                            )
                                        );
                                    }
                                }
                            },
                            // '!empty($data->sep_id)? "SEP Sudah Terbuat" : (($data->is_approval==FALSE) ? "Belum Aprove" : 
                            //         CHtml::link("<i class=icon-edit></i> ", Yii::app()->createUrl("/' . Yii::app()->controller->module->id . '/sep/create", array("pengajuanapprovalsep_id"=>$data->pengajuanapprovalsep_id)),
                            //         array(
                            //         "rel"=>"tooltip",
                            //         "title"=>"Klik untuk Buat SEP"
                            //         )))
                            //         ',
                            'htmlOptions' => array('style' => 'text-align:center;'),
                            'headerHtmlOptions' => array('style' => 'text-align:center;'),
                        ),
                        array(
                            'header' => 'Print SEP',
                            'type' => 'raw',
                            'value' => function ($data) {
                                $modSep = SepT::model()->findByAttributes(array(
                                    'nokartuasuransi' => $data->no_kartu_bpjs,
                                    'tglsep' => Myformatter::formatDateTimeForDb($data->tgl_sep)
                                ));
                                if (empty($modSep)) {
                                    return 'SEP Belum Terbuat';
                                } else {
                                    return CHtml::link(
                                        "<i class=icon-edit></i> ",
                                        "#",
                                        array(
                                            "rel" => "tooltip",
                                            "title" => "Klik untuk Buat SEP",
                                            "onclick" => "lihatSEP($modSep->sep_id);return false;"
                                        )
                                    );
                                }
                            },

                            // '(empty($data->sep_id))? "SEP Belum Terbuat" : CHtml::link("<i class=icon-edit></i> ", "#",
                            //             array(
                            //             "rel"=>"tooltip",
                            //             "title"=>"Klik untuk Buat SEP",
                            //             "onclick"=>"lihatSEP($data->sep_id);return false;"))',
                            'htmlOptions' => array('style' => 'text-align:center;'),
                            'headerHtmlOptions' => array('style' => 'text-align:center;'),
                        ),
                    ),
                    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});
                    sorotTabel();}',
                )); ?>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title"><i class="icon-white icon-search"></i> Pencarian</div>
            </div>
            <div class="panel-body">
                <?php $this->renderPartial('_search', array(
                    'model' => $model,
                )); ?>
            </div>
        </div>

        <?php
        echo CHtml::link(Yii::t('mds', '{icon} Buat Pengajuan Approval', array('{icon}' => '<i class="icon-plus icon-white"></i>')), $this->createUrl('index', array('modul_id' => Yii::app()->session['modul_id'])), array('class' => 'btn btn-success')) . "&nbsp;";
        echo CHtml::htmlButton(Yii::t('mds', '{icon} PDF', array('{icon}' => '<i class="icon-book icon-white"></i>')), array('class' => 'btn btn-primary', 'type' => 'button', 'onclick' => 'print(\'PDF\')')) . "&nbsp;";
        echo CHtml::htmlButton(Yii::t('mds', '{icon} Excel', array('{icon}' => '<i class="icon-pdf icon-white"></i>')), array('class' => 'btn btn-primary', 'type' => 'button', 'onclick' => 'print(\'EXCEL\')')) . "&nbsp;";
        echo CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), array('class' => 'btn btn-primary', 'type' => 'button', 'onclick' => 'print(\'PRINT\')')) . "&nbsp;";
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
<script type="text/javascript">
    $('#assep-t-grid .table > tbody > tr').removeClass('odd even');

    function sorotTabel() {
        $(".sorot_putih").each(function() {
            $(this).parents("tr").addClass("row_putih");
        });
        $(".sorot_abu").each(function() {
            $(this).parents("tr").addClass("row_abu");
        });
    }

    $(document).ready(function() {
        sorotTabel();
    });

    function hapusSEP(obj) {
        var answer = confirm('Yakin akan menghapus data SEP ini?');
        if (answer) {
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
        'height' => 500,
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
        'height' => 470,
        'resizable' => false,
    ),
));
?>
<iframe name='frameSEP' width="100%" height="100%"></iframe>
<?php $this->endWidget(); ?>

<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogApprove',
    'options' => array(
        'title' => 'Approve SEP',
        'autoOpen' => false,
        'modal' => true,
        'width' => 850,
        'height' => 350,
        'resizable' => true,
        'close' => "js:function(){ $.fn.yiiGridView.update('assep-t-grid', {
                            data: $('#assep-t-search').serialize()
                    }); }",
    ),
));
?>
<iframe name='frameApprove' width="100%" height="100%"></iframe>
<?php $this->endWidget(); ?>
<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogCreateSEP',
    'options' => array(
        'title' => 'Buat SEP',
        'autoOpen' => false,
        'modal' => true,
        'width' => 850,
        'height' => 650,
        'resizable' => true,
        'close' => "js:function(){ $.fn.yiiGridView.update('assep-t-grid', {
                            data: $('#assep-t-search').serialize()
                    }); }",
    ),
));
?>
<iframe name='frameCreateSEP' width="100%" height="100%"></iframe>
<?php $this->endWidget(); ?>