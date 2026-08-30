<?php
$this->breadcrumbs = array(
    'Jenis Form Det' => array('index'),
    'Kelola',
);

Yii::app()->clientScript->registerScript('searchForm', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('sajenisformdetlab-m-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
$module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
$url = Yii::app()->createAbsoluteUrl($module . '/' . $controller);
?>
<!--<legend class="rim">Pengaturan Jenis Pemeriksaan Lab</legend>-->
<?php $this->widget('bootstrap.widgets.BootAlert'); ?>

<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="fas fa-layer-group"></i> Pengaturan <b>Jenis Form Detail</b>
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
                    <i class="entypo-credit-card"></i> Tabel <b>Jenis Form Detail</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php $this->widget('ext.bootstrap.widgets.BootGridView', array(
                    'id' => 'sajenisformdetlab-m-grid',
                    'dataProvider' => $model->searchForm(),
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
                            'htmlOptions' => array('style' => 'text-align: right; width: 20px;'),
                        ),
            
                        array(
                            'header' => 'Kelompok Pemeriksaan Lab',
                            'value' => '$data->jenispemeriksaanlab_kelompok',
                            'htmlOptions' => array('style' => 'text-align: center; width: 200px;'),
                            'filter' => Chtml::activeDropDownList($model, 'jenispemeriksaanlab_kelompok', LookupM::getItemsUrutan('jenispemeriksaanlab_kelompok'), array('empty'=>'-- Pilih --', 'class' => 'custom-only')),
                        ),
                        array(
                            'header' => 'Jenis Pemeriksaan Lab',
                            'value' =>'$data->jenispemeriksaanlab_nama',
                            'htmlOptions' => array('style' => 'text-align: center; width: 200px;'),
                            'filter' => Chtml::activeTextField($model, 'jenispemeriksaanlab_nama', array('class' => 'custom-only')),
                        ),
                        array(
                            'header' => 'Kode Pemeriksaan Lab',
                            'value' => '$data->pemeriksaanlab_kode',
                            'htmlOptions' => array('style' => 'text-align: center; width: 100px;'),
                            'filter' => Chtml::activeTextField($model, 'pemeriksaanlab_kode', array('class' => 'custom-only')),
                            
                        ),
                        array(
                            'header' => 'Nama Pemeriksaan Lab',
                            'value' => '$data->pemeriksaanlab_nama',
                            'htmlOptions' => array(),
                            'filter' => Chtml::activeTextField($model, 'pemeriksaanlab_nama', array('class' => 'custom-only')),
                     
                        ),
                        
                        array(
                            'header' => 'Nama Jenis Form',
                            'value' => '$data->jenisform_nama',
                            'htmlOptions' => array('style' => 'text-align: center; width: 200px;'),
                            'filter' => Chtml::activeDropDownList($model, 'jenisform_id', CHtml::listData(JenisformM::model()->findAll('jenisform_aktif = true order by jenisform_nama'), 'jenisform_id', 'jenisform_nama'), array('empty'=>'-- Pilih --','class' => 'custom-only')),
                            
                        ), /*
                        array(
                            'header' => 'Lihat',
                            'class' => 'bootstrap.widgets.BootButtonColumn',
                            'htmlOptions' => array('style' => 'text-align: center; width: 50px;'),
                            'template' => '{view}',
                            'buttons' => array(
                                'view' => array(),
                            ),
                        ), /*
                        array(
                            'header' => 'Ubah',
                            'class' => 'bootstrap.widgets.BootButtonColumn',
                            'htmlOptions' => array('style' => 'text-align: center; width: 50px;'),
                            'template' => '{update}',
                            'buttons' => array(
                                'update' => array(),
                            ),
                        ), */
                        array(
                            'header' => 'Hapus',
                            'type' => 'raw',
                            'value' => 'CHtml::link("<i class=\'icon-form-sampah\'></i> ", "javascript:deleteRecord(".$data->formlab_id.")",array("id"=>"$data->formlab_id","rel"=>"tooltip","title"=>"Hapus"));',
                            'htmlOptions' => array('style' => 'text-align: center; width: 100px;'),
                        ),
                    ),
                    'afterAjaxUpdate' => 'function(id, data){
								 jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});
								 $("table").find("input[type=text]").each(function(){
									 cekForm(this);
								 })
							 }',
                )); ?>
            </div>
        </div>

        <div class="form-actions">
            <?php
            //echo CHtml::link(Yii::t('mds','{icon} Tambah Jenis Pemeriksaan Lab',array('{icon}'=>'<i class="icon-plus icon-white"></i>')),$this->createUrl('create',array('modul_id'=> Yii::app()->session['modul_id'])), array('class' => 'btn btn-danger',)); 
            echo CHtml::link(
                Yii::t('mds', '{icon} Tambah Jenis Form Detail', array('{icon}' => '<i class="icon-plus icon-white"></i>')),
                $this->createUrl('create', array('modul_id' => Yii::app()->session['modul_id'])),
                array('class' => 'btn btn-danger', 'title' => 'Tambah Jenis Form Detail')
            );
            echo CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PRINT\')'));
            echo CHtml::htmlButton(Yii::t('mds', '{icon} PDF', array('{icon}' => '<i class="entypo-book"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PDF\')'));
            echo CHtml::htmlButton(Yii::t('mds', '{icon} Excel', array('{icon}' => '<i class="entypo-doc-text"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'EXCEL\')'));
            $content = $this->renderPartial($this->path_view . 'tips/tipsAdmin', array(), true);
            $this->widget('UserTips', array('content' => $content));
            $urlPrint = $this->createUrl('print');
            $js = <<< JSCRIPT
					function cekForm(obj){
						$("#sajenisformdetlab-m-search :input[name='"+ obj.name +"']").val(obj.value);
					}     
					function print(caraPrint){
						window.open("${urlPrint}/"+$('#sajenisformdetlab-m-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
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
                            $.fn.yiiGridView.update('sajenisformdetlab-m-grid');
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
                            $.fn.yiiGridView.update('sajenisformdetlab-m-grid');
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

    function deleteRecord(id) {
            var id = id;
            var url = '<?php echo $url . "/delete"; ?>';
            myConfirm("Yakin Akan Menghapus Data ini?", "Perhatian!", function(r) {
                if (r) {
                    $.post(url, {
                            id: id
                        },
                        function(data) {
                            if (data.status == 'proses_form') {
                                $.fn.yiiGridView.update('sajenisformdetlab-m-grid');
                            } else {
                                myAlert('Data gagal dihapus!')
                            }
                        }, "json");
                }
            });
    }
</script>