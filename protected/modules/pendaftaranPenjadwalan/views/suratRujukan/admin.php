<?php
$this->breadcrumbs = array(
    'Surat Rujukan (BPJS)' => array('index'),
    'Manage',
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('#rujukan-t-search').submit(function(){
	$.fn.yiiGridView.update('rujukan-t-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">Surat Rujukan <b>(BPJS)</b></div>
    </div>
    <div class="panel-body">

        <?php $this->widget('bootstrap.widgets.BootAlert'); ?>

        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">Tabel Surat Rujukan (SEP)</div>
            </div>
            <div class="panel-body">
                <?php $this->widget('ext.bootstrap.widgets.BootGridView', array(
                    'id' => 'rujukan-t-grid',
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
                            'header' => 'Tanggal Dirujuk',
                            'type' => 'raw',
                            'value' => 'isset($data->tgldirujuk) ? MyFormatter::formatDateTimeForUser($data->tgldirujuk) : ""',
                        ),
                        array(
                            'header' => 'Tanggal Rencana Kunjungan',
                            'type' => 'raw',
                            'value' => 'isset($data->tglrencanakunjungan_bpjs) ? MyFormatter::formatDateTimeForUser($data->tglrencanakunjungan_bpjs) : ""',
                        ),
                        array(
                            'header' => 'No. Rujukan',
                            'type' => 'raw',
                            'value' => '$data->nosuratrujukan',
                        ),
                        array(
                            'header' => 'No. SEP',
                            'type' => 'raw',
                            'value' => '$data->nosuratrujukan',
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
                            'value' => '($data->jenispelayanan_bpjs==2)? "Rawat Jalan" : "Rawat Inap"',
                        ),
                        array(
                            'header' => 'Lihat',
                            'type' => 'raw',
                            'value' => 'CHtml::link("<i class=icon-form-view></i> ", "#",
                                        array(
                                        "rel"=>"tooltip",
                                        "title"=>"Klik untuk melihat Rujukan",
                                        "onclick"=>"lihatRujukan($data->pasiendirujukkeluar_id);return false;"))',
                            'htmlOptions' => array('style' => 'text-align:center;'),
                        ),
                        array(
                            'header' => 'Update Rujukan',
                            'type' => 'raw',
                            'value' => 'CHtml::link("<i class=icon-form-ubah></i> ", Yii::app()->createUrl("/' . Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/update", array("id"=>$data->pasiendirujukkeluar_id)),
                                        array(
                                        "target"=>"frameUbahRujukan",
                                        "rel"=>"tooltip",
                                        "title"=>"Klik untuk mengubah Rujukan",
                                        "onclick"=>"$(\'#dialogUbahRujukan\').dialog(\'open\');"))',
                            'htmlOptions' => array('style' => 'text-align:center;'),
                        ),
                        array(
                            'header' => Yii::t('zii', 'Delete'),
                            'class' => 'bootstrap.widgets.BootButtonColumn',
                            'template' => '{delete}',
                            'buttons' => array(
                                'delete' => array(
                                    'label' => "<i class='icon-form-trash'></i>",
                                    'options' => array('title' => 'Klik untuk menghapus data Rujukan'),
                                    'url' => 'Yii::app()->createUrl("' . Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/hapusRujukan",array("id"=>$data->pasiendirujukkeluar_id))',
                                    'click' => 'function(){hapusRujukan(this);return false;}',
                                ),
                            )
                        ),
                    ),
                    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
                )); ?>
            </div>
        </div>
        <?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
            'action' => Yii::app()->createUrl($this->route),
            'method' => 'get',
            'id' => 'rujukan-t-search',
            'type' => 'horizontal',
        )); ?>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title"><i class="icon-white icon-search"></i> Pencarian</div>
            </div>
            <div class="panel-body">
                <div class="row-fluid">
                    <div class="span6">
                        <div class="control-group">
                            <?php echo CHtml::label('Tanggal Rencana Kunjungan', '', array('class' => 'control-label')); ?>
                            <div class="controls">
                                <div class="daterange daterange-inline input-inline span4" data-format="D MMMM, YYYY" data-start-date="<?php echo date('d M Y', strtotime($model->tgl_awal)) ?>" data-end-date="<?php echo date('d M Y', strtotime($model->tgl_akhir)) ?>">
                                    <i class="entypo-calendar"></i>
                                    <span><?php echo date('d M Y', strtotime($model->tgl_awal)) ?> - <?php echo date('d M Y', strtotime($model->tgl_akhir)) ?></span>
                                    <?php echo $form->hiddenField($model, 'tgl_awal', array('class' => 'start')) ?>
                                    <?php echo $form->hiddenField($model, 'tgl_akhir', array('class' => 'end')) ?>
                                </div>
                            </div>
                        </div>

                        <div class="control-group">
                            <?php echo CHtml::label('No. Rujukan', '', array('class' => 'control-label')); ?>
                            <div class="controls">
                                <?php echo $form->textField($model, 'nosuratrujukan', array('class' => 'span3', 'maxlength' => 100)); ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo CHtml::label('No. SEP', '', array('class' => 'control-label')); ?>
                            <div class="controls">
                                <?php echo $form->textField($model, 'nosep', array('class' => 'span3', 'maxlength' => 100)); ?>
                            </div>
                        </div>

                    </div>
                    <div class="span6">
                        <div class="control-group">
                            <?php echo CHtml::label('No. Asuransi', '', array('class' => 'control-label')); ?>
                            <div class="controls">
                                <?php echo $form->textField($model, 'nokartuasuransi', array('class' => 'span3', 'maxlength' => 100)); ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo CHtml::label('No. RM', '', array('class' => 'control-label')); ?>
                            <div class="controls">
                                <?php echo $form->textField($model, 'no_rekam_medik', array('class' => 'span3', 'maxlength' => 100)); ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo CHtml::label('Nama Pasien', '', array('class' => 'control-label')); ?>
                            <div class="controls">
                                <?php echo $form->textField($model, 'nama_pasien', array('class' => 'span3', 'maxlength' => 100)); ?>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <div class="form-actions">
            <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')), array('class' => 'btn btn-primary', 'type' => 'submit')); ?>
            <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-search"></i>')), array('class' => 'btn btn-danger', 'type' => 'reset')); ?>
        </div>

        <?php $this->endWidget(); ?>
        <?php
        echo CHtml::link(Yii::t('mds', '{icon} Tambah Rujukan', array('{icon}' => '<i class="icon-plus icon-white"></i>')), $this->createUrl('index', array('modul_id' => Yii::app()->session['modul_id'])), array('class' => 'btn btn-success')) . "&nbsp;";
        echo CHtml::htmlButton(Yii::t('mds', '{icon} PDF', array('{icon}' => '<i class="icon-book icon-white"></i>')), array('class' => 'btn btn-primary', 'type' => 'button', 'onclick' => 'print(\'PDF\')')) . "&nbsp;";
        echo CHtml::htmlButton(Yii::t('mds', '{icon} Excel', array('{icon}' => '<i class="icon-pdf icon-white"></i>')), array('class' => 'btn btn-primary', 'type' => 'button', 'onclick' => 'print(\'EXCEL\')')) . "&nbsp;";
        echo CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), array('class' => 'btn btn-primary', 'type' => 'button', 'onclick' => 'print(\'PRINT\')')) . "&nbsp;";
        $urlPrint = $this->createUrl('print');

        $js = <<< JSCRIPT
function print(caraPrint)
{
    window.open("${urlPrint}/"+$('#rujukan-t-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
JSCRIPT;
        Yii::app()->clientScript->registerScript('print', $js, CClientScript::POS_HEAD);
        ?>
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
                            $.fn.yiiGridView.update('rujukan-t-grid');
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

    function hapusRujukan(obj) {
        myConfirm("Yakin akan menghapus data Rujukan ini?", "Perhatian!",
            function(r) {
                if (r) {
                    $.ajax({
                        type: 'GET',
                        url: obj.href,
                        data: {}, //
                        dataType: "json",
                        success: function(data) {
                            $.fn.yiiGridView.update('rujukan-t-grid');
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

    function lihatRujukan(pasiendirujukkeluar_id) {
        window.open('<?php echo $this->createUrl('PrintRujukan'); ?>&id=' + pasiendirujukkeluar_id, 'printwin', 'left=100,top=100,width=860,height=480');
    }
</script>
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
    'id' => 'dialogUbahRujukan',
    'options' => array(
        'title' => 'Ubah Data Rujukan',
        'autoOpen' => false,
        'modal' => true,
        'zIndex' => 1002,
        'width' => 900,
        'height' => 600,
        'resizable' => true,
        'close' => "js:function(){ $.fn.yiiGridView.update('rujukan-t-grid', {
                            data: $('#rujukan-t-search').serialize()
                    }); }",
    ),
));
?>
<iframe name='frameUbahRujukan' width="100%" height="100%"></iframe>
<?php $this->endWidget(); ?>