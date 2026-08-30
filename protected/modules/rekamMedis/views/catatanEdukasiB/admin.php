<?php
$this->breadcrumbs = array(
    'Master Edukasi B' => array('admin'),
    'Manage',
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('#edukasib-m-search').submit(function(){
	$.fn.yiiGridView.update('edukasib-m-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-gradient">
            <div class="panel-heading">
                <div class="panel-title">Master <strong>Edukasi B</strong></div>
            </div>
            <div class="panel-body">

                <?php
                if (!empty($_GET['sukses'])) {
                    $this->widget('bootstrap.widgets.BootAlert');
                    Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
                }
                ?>
                <div class="row-fluid">
                <?php echo CHtml::link(Yii::t('mds', '{icon} Advanced Search', array('{icon}' => '<i class="entypo-search"></i>')), '#', array('class' => 'search-button btn')); ?>
                </div>
                <div class="cari-lanjut2 search-form" style="display:none">
                    <?php
                    $this->renderPartial($this->path_view . '_search', array(
                        'model' => $model,
                    ));
                    ?>

                </div>

                <div class="panel panel-success">
                    <div class="panel-heading">
                        <div class="panel-title">Table <strong>Checklist Edukasi B</strong></div>
                    </div>
                    <div class="panel-body" style="overflow-x: scroll">
                        <?php
                        $this->widget('ext.bootstrap.widgets.BootGridView', array(
                            'id' => 'edukasib-m-grid',
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
                                    'name' => 'nama_edukasi',
                                    'type' => 'raw',
                                    'value' => '$data->nama_edukasi',
                                ),
                                array(
                                    'name' => 'isi_edukasi',
                                    'type' => 'raw',
                                    'value' => '$data->isi_edukasi',
                                ),
                                array(
                                    'header' => 'Status',
                                    'value' => '($data->status == true ? \'Aktif\': \'Tidak Aktif\')'
                                ),
                                array(
                                    'header' => Yii::t('zii', 'View'),
                                    'class' => 'bootstrap.widgets.BootButtonColumn',
                                    'template' => '{view}',
                                    'buttons' => array(
                                        'view' => array(),
                                    ),
                                ),
                                array(
                                    'header' => Yii::t('zii', 'Update'),
                                    'class' => 'bootstrap.widgets.BootButtonColumn',
                                    'template' => '{update}',
                                    'buttons' => array(
                                        'update' => array(
                                            // 'visible' => 'Yii::app()->controller->checkAccess(array("action"=>Params::DEFAULT_UPDATE))',
                                        ),
                                    ),
                                ),
                                array(
                                    'header' => Yii::t('zii', 'Delete'),
                                    'class' => 'bootstrap.widgets.BootButtonColumn',
                                    'htmlOptions' => array('style' => 'width:80px;'),
                                    'template' => '{remove} {add} {delete}',
                                    'buttons' => array(
                                        'remove' => array(
                                            'label' => "<i class='glyphicon glyphicon-remove'></i>",
                                            'options' => array('title' => Yii::t('mds', 'Menonaktifkan Edukasi B')),
                                            'url' => 'Yii::app()->createUrl("' . Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/nonActive",array("id"=>$data->catatanedukasib_id))',
                                            'click' => 'function(){nonActive(this);return false;}',
                                            'visible' => '(($data->status==false) ? FALSE : TRUE)',
                                            // 'visible' => 'Yii::app()->controller->checkAccess(array("action"=>"nonActive"))',
                                        ),
                                        'add' => array(
                                            'label' => "<i class='icon-form-check'></i>",
                                            'options' => array('title' => Yii::t('mds', 'Mengaktifkan Edukasi B')),
                                            'url' => 'Yii::app()->createUrl("' . Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/active",array("id"=>$data->catatanedukasib_id))',
                                            'click' => 'function(){active(this);return false;}',
                                            'visible' => '(($data->status) ? FALSE : TRUE)',
                                        ),
                                        'delete' => array(
                                            // 'visible' => 'Yii::app()->controller->checkAccess(array("action"=>Params::DEFAULT_DELETE))',
                                        ),
                                    )
                                ),
                            ),
                            'afterAjaxUpdate' => 'function(id, data){
                jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});
                $("table").find("input[type=text]").each(function(){
                    cekForm(this);
                });
                 $("table").find("select").each(function(){
                    cekForm(this);
                });
            }',
                        ));
                        ?>
                        <!--</div>-->
                        <?php
                        echo CHtml::link(Yii::t('mds', '{icon} Tambah', array('{icon}' => '<i class="icon-plus icon-white"></i>')), $this->createUrl('create', array('modul_id' => Yii::app()->session['modul_id'])), array('class' => 'btn btn-success')) . "&nbsp&nbsp";
                        echo CHtml::htmlButton(Yii::t('mds', '{icon} PDF', array('{icon}' => '<i class="icon-book icon-white"></i>')), array('class' => 'btn btn-primary', 'type' => 'button', 'onclick' => 'print(\'PDF\')')) . "&nbsp&nbsp";
                        echo CHtml::htmlButton(Yii::t('mds', '{icon} Excel', array('{icon}' => '<i class="icon-pdf icon-white"></i>')), array('class' => 'btn btn-primary', 'type' => 'button', 'onclick' => 'print(\'EXCEL\')')) . "&nbsp&nbsp";
                        echo CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), array('class' => 'btn btn-primary', 'type' => 'button', 'onclick' => 'print(\'PRINT\')')) . "&nbsp&nbsp";
                        $content = $this->renderPartial('sistemAdministrator.views.tips.master', array(), true);
                        $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));

                        $urlPrint = $this->createUrl('print');

                        $js = <<< JSCRIPT
function print(caraPrint)
{
    window.open("${urlPrint}/"+$('#edukasib-m-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
JSCRIPT;
                        Yii::app()->clientScript->registerScript('print', $js, CClientScript::POS_HEAD);
                        ?></div>
                </div>
            </div>
        </div>
        <script type="text/javascript">
            function cekForm(obj)
            {
                $("#edukasib-m-search :input[name='" + obj.name + "']").val(obj.value);
            }

            function nonActive(obj) {
                myConfirm("Yakin akan menonaktifkan data ini untuk sementara?", "Perhatian!",
                        function (r) {
                            if (r) {
                                $.ajax({
                                    type: 'GET',
                                    url: obj.href,
                                    data: {}, //
                                    dataType: "json",
                                    success: function (data) {
                                        $.fn.yiiGridView.update('edukasib-m-grid');
                                        if (data.sukses > 0) {
                                        } else {
                                            myAlert('Data gagal dinonaktifkan!');
                                        }
                                    },
                                    error: function (jqXHR, textStatus, errorThrown) {
                                        myAlert('Data gagal dinonaktifkan!');
                                        console.log(errorThrown);
                                    }
                                });
                            }
                        }
                );
                return false;
            }

            function active(obj) {
                myConfirm("Yakin akan mengaktifkan data ini untuk sementara?", "Perhatian!",
                        function (r) {
                            if (r) {
                                $.ajax({
                                    type: 'GET',
                                    url: obj.href,
                                    data: {}, //
                                    dataType: "json",
                                    success: function (data) {
                                        $.fn.yiiGridView.update('edukasib-m-grid');
                                        if (data.sukses > 0) {
                                            myAlert('Data berhasil diaktifkan!');
                                        } else {
                                            myAlert('Data gagal diaktifkan!');
                                        }
                                    },
                                    error: function (jqXHR, textStatus, errorThrown) {
                                        myAlert('Data gagal diaktifkan!');
                                        console.log(errorThrown);
                                    }
                                });
                            }
                        }
                );
                return false;
            }
        </script>
