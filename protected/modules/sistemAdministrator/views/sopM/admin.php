<?php
$this->breadcrumbs = array(
    'SOP' => array('admin'),
    'Manage',
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('sop-m-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="fas fa-layer-group"></i> Pengaturan <b>SOP</b>
        </div>
    </div>
    <div class="panel-body">
        <?php
        $this->widget('bootstrap.widgets.BootAlert');
        ?>

        <?php echo CHtml::link(Yii::t('mds', '{icon} Advanced Search', array('{icon}' => '<i class="icon-accordion icon-white"></i>')), '#', array('class' => 'search-button btn')); ?>

        <div class="cari-lanjut search-form">
            <?php
            $this->renderPartial($this->path_view . '_search', array(
                'model' => $model,
            ));
            ?>

        </div>

        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Standar Operasional Prosedur (SOP)</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php
                $this->widget('ext.bootstrap.widgets.BootGridView', array(
                    'id' => 'sop-m-grid',
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
                            'htmlOptions' => array('style' => 'text-align: right;'),
                        ),
                        array(
                            'name' => 'instalasi_id',
                            'type' => 'raw',
                            'value' => '$data->instalasi->instalasi_nama',
                            'filter' => Chtml::activeDropDownList($model, 'instalasi_id', CHtml::listData(InstalasiM::model()->findAll('instalasi_aktif = true order by instalasi_nama ASC'), 'instalasi_id', 'instalasi_nama'), array('empty' => '-- Pilih --')),
                        ),
                        array(
                            'header' => 'No. Dokumen',
                            'name' => 'sop_nodokumen',
                            'filter' => Chtml::activeTextField($model, 'sop_nodokumen', array('class' => 'numbers-only'))
                        ),
                        array(
                            'header' => 'Tanggal Terbit',
                            'value' => 'MyFormatter::formatDateTimeForUser($data->sop_tglterbit)',
                            'filter' => false
                        ),
                        array(
                            'header' => 'No. Revisi',
                            'name' => 'sop_norevisi',
                            'filter' => Chtml::activeTextField($model, 'sop_norevisi', array('class' => 'numbers-only'))
                        ),
                        array(
                            'header' => 'Tanggal Revisi',
                            'value' => 'MyFormatter::formatDateTimeForUser($data->sop_tglrevisi)',
                            'filter' => false
                        ),
                        array(
                            'header' => 'Nama Sop',
                            'name' => 'sop_nama',
                            'filter' => Chtml::activeTextField($model, 'sop_nama', array('class' => 'numbers-only'))
                        ),
                        array(
                            'name' => 'pegawai_id',
                            'type' => 'raw',
                            'value' => '!empty($data->pegawai)?$data->pegawai->namaLengkap:""',
                            'filter' => Chtml::activeDropDownList($model, 'pegawai_id', CHtml::listData(PegawaiM::model()->findAll('pegawai_aktif = true order by nama_pegawai ASC'), 'pegawai_id', 'namaLengkap'), array('empty' => '-- Pilih --')),
                        ),
                        array(
                            'header' => 'Status',
                            'value' => '($data->sop_aktif == true ? \'Aktif\': \'Tidak Aktif\')',
                            'htmlOptions' => array('style' => 'text-align: center; width: 100px;'),
                        ),
                        array(
                            'header' => 'Lihat',
                            'class' => 'bootstrap.widgets.BootButtonColumn',
                            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                            'template' => '{view}',
                            'buttons' => array(
                                'view' => array(),
                            ),
                        ),
                        array(
                            'header' => 'Ubah',
                            'class' => 'bootstrap.widgets.BootButtonColumn',
                            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                            'template' => '{update}',
                            'buttons' => array(
                                'update' => array(
                                    'visible' => 'Yii::app()->controller->checkAccess(array("action"=>Params::DEFAULT_UPDATE))',
                                ),
                            ),
                        ),
                        array(
                            'header' => 'Hapus',
                            'class' => 'bootstrap.widgets.BootButtonColumn',
                            'htmlOptions' => array('style' => 'text-align: center; width: 100px;'),
                            'template' => '{remove}{add}{delete}',
                            'buttons' => array(
                                'remove' => array(
                                    'label' => "<i class='icon-form-silang'></i>",
                                    'options' => array('title' => Yii::t('mds', 'Remove Temporary')),
                                    'url' => 'Yii::app()->createUrl("' . Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/nonActive",array("id"=>$data->sop_id))',
                                    'click' => 'function(){nonActive(this);return false;}',
                                    'visible' => 'Yii::app()->controller->checkAccess(array("action"=>"nonActive"))',
                                ),
                                'add' => array(
                                    'label' => "<i class='icon-form-check'></i>",
                                    'options' => array('title' => Yii::t('mds', 'Add Temporary')),
                                    'url' => 'Yii::app()->createUrl("' . Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/active",array("id"=>$data->sop_id))',
                                    'click' => 'function(){active(this);return false;}',
                                    'visible' => '(($data->sop_aktif) ? FALSE : TRUE)',
                                ),
                                'delete' => array(
                                    'visible' => 'Yii::app()->controller->checkAccess(array("action"=>Params::DEFAULT_DELETE))',
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
                $(".kode-alatmedis").keyup(function() {
                    setKodeAlatMedis(this);
                });
                $(".hurufs-only").keyup(function() {
                    setHurufsOnly(this);
                });
            }',
                ));
                ?>
            </div>
        </div>

        <div class="form-actions">
            <?php
            echo CHtml::link(Yii::t('mds', '{icon} Tambah SOP', array('{icon}' => '<i class="icon-plus icon-white"></i>')), $this->createUrl('create', array('modul_id' => Yii::app()->session['modul_id'])), array('class' => 'btn btn-danger',));
            // echo CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PRINT\')'));
            // echo CHtml::htmlButton(Yii::t('mds', '{icon} PDF', array('{icon}' => '<i class="entypo-book"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PDF\')'));
            // echo CHtml::htmlButton(Yii::t('mds', '{icon} Excel', array('{icon}' => '<i class="entypo-doc-text"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'EXCEL\')'));
            $content = $this->renderPartial('sistemAdministrator.views.tips.master', array(), true);
            $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));

            $urlPrint = $this->createUrl('print');

            $js = <<< JSCRIPT
function print(caraPrint)
{
    window.open("${urlPrint}/"+$('#sop-m-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
JSCRIPT;
            Yii::app()->clientScript->registerScript('print', $js, CClientScript::POS_HEAD);
            ?>
        </div>
    </div>
</div>

<script type="text/javascript">
    function cekForm(obj) {
        $("#sop-m-search :input[name='" + obj.name + "']").val(obj.value);
    }

    function nonActive(obj) {
        myConfirm("Anda yakin akan menonaktifkan data ini untuk sementara?", "Perhatian!",
            function(r) {
                if (r) {
                    $.ajax({
                        type: 'GET',
                        url: obj.href,
                        data: {}, //
                        dataType: "json",
                        success: function(data) {
                            $.fn.yiiGridView.update('sop-m-grid');
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

    function active(obj) {
        myConfirm("Anda yakin akan mengaktifkan data ini untuk sementara?", "Perhatian!",
            function(r) {
                if (r) {
                    $.ajax({
                        type: 'GET',
                        url: obj.href,
                        data: {}, //
                        dataType: "json",
                        success: function(data) {
                            $.fn.yiiGridView.update('sop-m-grid');
                            if (data.sukses > 0) {
                                myAlert('Data berhasil diaktifkan!');
                            } else {
                                myAlert('Data gagal diaktifkan!');
                            }
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
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