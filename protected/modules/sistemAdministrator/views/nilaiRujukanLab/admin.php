<?php
$this->breadcrumbs = array(
    'Sanilairujukan Ms' => array('index'),
    'Manage',
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('sanilairujukan-m-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<!--<legend class="rim2">Pengaturan Nilai Rujukan (Referensi) Lab</legend>-->
<?php $this->widget('bootstrap.widgets.BootAlert'); ?>

<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="fas fa-layer-group"></i> Pengaturan <b>Nilai Rujukan (Referensi)</b>
        </div>
    </div>
    <div class="panel-body">
        <?php echo CHtml::link(Yii::t('mds', '{icon} Advanced Search', array('{icon}' => '<i class="icon-accordion icon-white"></i>')), '#', array('class' => 'search-button btn')); ?>
        <div class="cari-lanjut search-form">
            <?php $this->renderPartial($this->path_view . '_search', array(
                'model' => $model,
            )); ?>
        </div>

        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Nilai Rujukan (Referensi)</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php $this->widget('ext.bootstrap.widgets.BootGridView', array(
                    'id' => 'sanilairujukan-m-grid',
                    'dataProvider' => $model->search(),
                    'filter' => $model,
                    'template' => "{summary}\n{items}\n{pager}",
                    'itemsCssClass' => 'table table-bordered table-striped table-condensed',
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
                            'name' => 'kelkumurhasillab_id',
                            'type' => 'raw',
                            'value' => 'isset($data->kelkumurhasillab->kelkumurhasillabnama) ? $data->kelkumurhasillab->kelkumurhasillabnama : "-"',
                            'filter' =>  CHtml::dropDownList('SANilairujukanM[kelkumurhasillab_id]', $model->kelkumurhasillab_id, CHtml::listData(KelkumurhasillabM::model()->findAll(array('order' => 'kelkumurhasillab_urutan'), 'kelkumurhasillab_aktif = true'), 'kelkumurhasillab_id', 'kelkumurhasillabnama'), array('empty' => '-- Pilih --')),
                        ),
                        array(
                            'name' => 'nilairujukan_jeniskelamin',
                            'type' => 'raw',
                            'value' => '$data->nilairujukan_jeniskelamin',
                            'filter' => CHtml::dropDownList('SANilairujukanM[nilairujukan_jeniskelamin]', $model->nilairujukan_jeniskelamin, LookupM::getItems('jeniskelamin'), array('empty' => '-- Pilih --')),
                        ),
                        'kelompokdet',
                        'namapemeriksaandet',
                        array(
                            'name' => 'nilairujukan_nama',
                            'type' => 'raw',
                            'value' => '$data->NilaiRujukan',
                            //'filter'=> CHtml::dropDownList('SANilairujukanM[nilairujukan_nama]',$model->nilairujukan_nama,LookupM::getItems('nilairujukan_nama'), array('empty'=>'-- Pilih --')),//,
                        ),
                        'nilairujukan_min',
                        'nilairujukan_max',
                        array(
                            'name' => 'nilairujukan_satuan',
                            'type' => 'raw',
                            'value' => '$data->NilaiSatuan',
                            'filter' => CHtml::dropDownList('SANilairujukanM[nilairujukan_satuan]', $model->nilairujukan_satuan, LookupM::getItems('satuanhasillab'), array('empty' => '-- Pilih --')), //,
                        ),
                        'nilairujukan_metode',
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
                                'update' => array(),
                            ),
                        ),
                        array(
                            'header' => 'Hapus',
                            'class' => 'bootstrap.widgets.BootButtonColumn',
                            'template' => '{remove} {add} {delete}',
                            'buttons' => array(
                                'remove' => array(
                                    'label' => "<i class='icon-form-silang'></i>",
                                    'options' => array('title' => Yii::t('mds', 'Remove Temporary')),
                                    'url' => 'Yii::app()->createUrl("' . Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/nonActive",array("id"=>$data->nilairujukan_id))',
                                    'click' => 'function(){nonActive(this);return false;}',
                                    'visible' => '$data->nilairujukan_aktif',
                                ),
                                'add' => array(
                                    'label' => "<i class='icon-form-check'></i>",
                                    'options' => array('title' => Yii::t('mds', 'Active Temporary')),
                                    'url' => 'Yii::app()->createUrl("' . Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/nonActive",array("id"=>$data->nilairujukan_id))',
                                    'visible' => '($data->nilairujukan_aktif) ? FALSE : TRUE',
                                    'click' => 'function(){active(this,1);return false;}',
                                ),
                                'delete' => array(),

                            ),
                            'htmlOptions' => array('style' => 'text-align: center; width: 100px;'),
                        ),
                    ),
                    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
                )); ?>
            </div>
        </div>

        <div class="form-actions">
            <?php
            //echo CHtml::link(Yii::t('mds','{icon} Tambah Nilai Rujukan (Referensi) Lab',array('{icon}'=>'<i class="icon-plus icon-white"></i>')),$this->createUrl('create',array('modul_id'=> Yii::app()->session['modul_id'])), array('class' => 'btn btn-danger',)); 
            echo CHtml::link(
                Yii::t('mds', '{icon} Tambah Nilai Rujukan (Referensi)', array('{icon}' => '<i class="icon-plus icon-white"></i>')),
                $this->createUrl('create', array('modul_id' => Yii::app()->session['modul_id'])),
                array('class' => 'btn btn-danger', 'title' => 'Tambah Nilai Rujukan (Referensi)')
            );
            echo CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PRINT\')'));
            echo CHtml::htmlButton(Yii::t('mds', '{icon} PDF', array('{icon}' => '<i class="entypo-book"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PDF\')'));
            echo CHtml::htmlButton(Yii::t('mds', '{icon} Excel', array('{icon}' => '<i class="entypo-doc-text"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'EXCEL\')'));
            $content = $this->renderPartial($this->path_view . 'tips/tipsAdmin', array(), true);
            $this->widget('UserTips', array('content' => $content));
            $urlPrint = $this->createUrl('print');
            $js = <<< JSCRIPT
					function print(caraPrint){
						window.open("${urlPrint}/"+$('#sanilairujukan-m-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
					}
JSCRIPT;
            Yii::app()->clientScript->registerScript('print', $js, CClientScript::POS_HEAD);
            ?>
        </div>
    </div>
</div>

<script type="text/javascript">
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
                            $.fn.yiiGridView.update('sanilairujukan-m-grid');
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

    function active(obj, add) {
        myConfirm("Anda yakin akan mengaktifkan data ini untuk sementara?", "Perhatian!",
            function(r) {
                if (r) {
                    $.ajax({
                        type: 'GET',
                        url: obj.href,
                        data: {
                            add: add
                        }, //
                        dataType: "json",
                        success: function(data) {
                            $.fn.yiiGridView.update('sanilairujukan-m-grid');
                            if (data.sukses > 0) {} else {
                                myAlert('Data gagal diaktifkan!');
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
</script>