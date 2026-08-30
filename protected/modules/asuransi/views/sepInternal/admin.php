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
	return false;
});
");
?>
<div class="white-container">
    <legend class="rim2">Surat Eligibilitas Peserta <b>(SEP)</b></legend>
    <?php $this->widget('bootstrap.widgets.BootAlert'); ?>

    <?php // echo CHtml::link(Yii::t('mds','{icon} Advanced Search',array('{icon}'=>'<i class="icon-search"></i>')),'#',array('class'=>'search-button btn')); 
    ?>
    <!--<div class="cari-lanjut search-form" style="display:none">-->
    <?php // $this->renderPartial('_search',array(
    //		'model'=>$model,
    //	)); 
    ?>
    <!--</div> search-form -->
    <fieldset class="box search-form">
        <legend class="rim"><i class="icon-white icon-search"></i> Pencarian</legend>
        <?php $this->renderPartial($this->path_view . '_search_sep', array(
            'model' => $model,
        )); ?>
    </fieldset>
    <div class="block-tabel">
        <h6 class="rim2">Tabel Surat Eligibilitas Peserta (SEP)</h6>
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
                'nosep',
                'nokartuasuransi',
                array(
                    'header' => 'Tanggal Rujukan',
                    'type' => 'raw',
                    'value' => 'isset($data->tglrujukan) ? MyFormatter::formatDateTimeForUser($data->tglrujukan) : ""',
                ),
                'norujukan',
                'diagnosaawal',
                //			'ruangan.ruangan_nama',
                'kelasrawat.kelaspelayanan_nama',
                array(
                    'header' => 'Tanggal Pulang',
                    'type' => 'raw',
                    'value' => 'CHtml::link("<i class=icon-pencil-brown></i> ".MyFormatter::formatDateTimeForUser($data->tglpulang), Yii::app()->createUrl("/' . Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/ubahTanggalPulang", array("sep_id"=>$data->sep_id)),
                                        array(
                                        "target"=>"frameUbahTanggalPulang",
                                        "rel"=>"tooltip",
                                        "title"=>"Klik untuk mengubah Tanggal Pulang",
                                        "onclick"=>"$(\'#dialogUbahTanggalPulang\').dialog(\'open\');"))',
                    'htmlOptions' => array('style' => 'text-align:center;'),
                ),
                array(
                    'header' => 'Update SEP',
                    'type' => 'raw',
                    'value' => 'CHtml::link("<i class=icon-form-ubah></i> ", Yii::app()->createUrl("/' . Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/updateSEP", array("sep_id"=>$data->sep_id)),
                                        array(
                                        "target"=>"frameUbahSEP",
                                        "rel"=>"tooltip",
                                        "title"=>"Klik untuk mengubah SEP",
                                        "onclick"=>"$(\'#dialogUbahSEP\').dialog(\'open\');"))',
                    'htmlOptions' => array('style' => 'text-align:center;'),
                ),
                /*
			'ppkrujukan',
			'ppkpelayanan',
			'jnspelayanan',
			'catatansep',
			'create_time',
			'update_time',
			'create_loginpemakai_id',
			'upate_loginpemakai_id',
			'create_ruangan',
			*/
                //			array(
                //				'header'=>'Lihat Laporan',
                //				'type'=>'raw',
                //				'value'=>'CHtml::link("<icon class=\'icon-form-detail\' ></icon> ", Yii::app()->createUrl("/asuransi/Sep/lihatLaporanSEP", array("sep_id"=>$data->sep_id,"frame"=>true)), array("target"=>"frameSEP","rel"=>"tooltip", "title"=>"lihat laporan SEP", "onclick"=>"$(\'#dialogSEP\').dialog(\'open\');"))','htmlOptions'=>array('style'=>'text-align: center; width:40px ')                  
                //			), 
                //			array(
                //				'header'=>Yii::t('zii','View'),
                //				'class'=>'bootstrap.widgets.BootButtonColumn',
                //				'template'=>'{view}',
                //				'buttons'=>array(
                //					'view' => array(),
                //				 ),
                //			),
                //			array(
                //				'header'=>Yii::t('zii','Update'),
                //				'class'=>'bootstrap.widgets.BootButtonColumn',
                //				'template'=>'{update}',
                //				'buttons'=>array(
                //					'update' => array(
                //							'visible'=>'Yii::app()->controller->checkAccess(array("action"=>Params::DEFAULT_UPDATE))',
                //					),
                //				 ),
                //			),
                //			array(
                //				'header'=>Yii::t('zii','Delete'),
                //				'class'=>'bootstrap.widgets.BootButtonColumn',
                //				'template'=>'{remove} {delete}',
                //				'buttons'=>array(
                //					'remove' => array (
                //							'label'=>"<i class='icon-form-silang'></i>",
                //							'options'=>array('title'=>Yii::t('mds','Remove Temporary')),
                //							'url'=>'Yii::app()->createUrl("'.Yii::app()->controller->module->id.'/'.Yii::app()->controller->id.'/nonActive",array("id"=>$data->sep_id))',
                //							'click'=>'function(){nonActive(this);return false;}',
                //							'visible'=>'Yii::app()->controller->checkAccess(array("action"=>"nonActive"))',
                //					),
                //					'delete'=> array(
                //							'visible'=>'Yii::app()->controller->checkAccess(array("action"=>Params::DEFAULT_DELETE))',
                //					),
                //				)
                //			),
                //			array(
                //				'header'=>'Periksa',
                //				'class'=>'bootstrap.widgets.BootButtonColumn',
                //				'template'=>'{remove}',
                //				'buttons'=>array(
                //					'remove' => array (
                //						'label'=>"<i class='icon-form-periksa'></i>",
                //						'options'=>array('title'=>'Klik untuk periksa'),
                //						'url'=>'Yii::app()->createUrl("'.Yii::app()->controller->module->id.'/'.Yii::app()->controller->id.'/periksaSEP",array("id"=>$data->sep_id))',
                //						'click'=>'function(){periksaSEP(this);return false;}',
                //					),
                //				)
                //			),
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
    <?php
    echo CHtml::link(Yii::t('mds', '{icon} Tambah SEP', array('{icon}' => '<i class="icon-plus icon-white"></i>')), $this->createUrl('create', array('modul_id' => Yii::app()->session['modul_id'])), array('class' => 'btn btn-success')) . "&nbsp;";
    echo CHtml::htmlButton(Yii::t('mds', '{icon} PDF', array('{icon}' => '<i class="icon-book icon-white"></i>')), array('class' => 'btn btn-primary', 'type' => 'button', 'onclick' => 'print(\'PDF\')')) . "&nbsp;";
    echo CHtml::htmlButton(Yii::t('mds', '{icon} Excel', array('{icon}' => '<i class="icon-pdf icon-white"></i>')), array('class' => 'btn btn-primary', 'type' => 'button', 'onclick' => 'print(\'EXCEL\')')) . "&nbsp;";
    echo CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), array('class' => 'btn btn-primary', 'type' => 'button', 'onclick' => 'print(\'PRINT\')')) . "&nbsp;";
    $this->widget('UserTips', array('content' => ''));
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
        'width' => 500,
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