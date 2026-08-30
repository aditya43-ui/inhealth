<?php
$this->breadcrumbs = array(
    'Penerimaan Umum' => array('admin'),
);

$arrMenu = array();
//                array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Penerimaan Umum ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master')));
//                array_push($arrMenu,array('label'=>Yii::t('mds','List').' Jenis Kelas', 'icon'=>'list', 'url'=>array('index'))) ;
// (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' Jenis Kelas', 'icon'=>'file', 'url'=>array('create'))) :  '' ;

$this->menu = $arrMenu;

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
		$('.search-form').toggle();
	$('#KUJenispenerimaanM_jenispenerimaan_nama').focus();
		return false;
});
$('.search-form form').submit(function(){
		$.fn.yiiGridView.update('kujenis-penerimaan-m-grid', {
				data: $(this).serialize()
		});
		return false;
});
");

$this->widget('bootstrap.widgets.BootAlert'); ?>

<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="fas fa-layer-group"></i> Pengaturan <b>Penerimaan Umum</b>
        </div>
    </div>
    <div class="panel-body">
        <?php echo CHtml::link(Yii::t('mds', '{icon} Advanced Search', array('{icon}' => '<i class="icon-accordion icon-white"></i>')), '#', array('class' => 'search-button btn')); ?>
        <div class="cari-lanjut search-form">
            <?php $this->renderPartial('_search', array('model' => $model)); ?>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Penerimaan Umum</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php $this->widget('ext.bootstrap.widgets.BootGridView', array(
                    'id' => 'kujenis-penerimaan-m-grid',
                    'dataProvider' => $model->search(),
                    'filter' => $model,
                    'template' => "{summary}\n{items}\n{pager}",
                    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
                    'columns' => array(
                        array(
                            'header' => 'ID',
                            'value' => '$data->jenispenerimaan_id',
                        ),
                        array(
                            'name' => 'jenispenerimaan_kode',
                            'value' => '$data->jenispenerimaan_kode',
                            'filter' => Chtml::activeTextField($model, 'jenispenerimaan_kode', array('class' => 'angkahuruf-only'))
                        ),
                        array(
                            'name' => 'jenispenerimaan_nama',
                            'value' => '$data->jenispenerimaan_nama',
                            'filter' => Chtml::activeTextField($model, 'jenispenerimaan_nama', array('class' => 'hurufs-only'))
                        ),
                        array(
                            'name' => 'jenispenerimaan_namalain',
                            'value' => '$data->jenispenerimaan_namalain',
                            'filter' => Chtml::activeTextField($model, 'jenispenerimaan_namalain', array('class' => 'hurufs-only'))
                        ),
                        array(
                            'header' => 'PPh 23 (%)',
                            'name' => 'persenpph_23',
                            'value' => 'str_replace(".", ",", $data->persenpph_23);',
                            'filter' => false,
                            'htmlOptions' => array('style' => 'text-align: right'),
                        ),/*
                                array(
                                    'header'=>'PPh Final (%)',
                                    'name'=>'persenpph_22',
                                    'value'=>'str_replace(".", ",", $data->persenpph_22);',
                                    'filter'=>false,
                                    'htmlOptions'=>array('style'=>'text-align: right'),
                                ),
                                 * 
                                 */
                        array(
                            'header' => 'Status',
                            'value' => '($data->jenispenerimaan_aktif == 1 ) ? "Aktif" : "Tidak Aktif"',
                            'htmlOptions' => array('style' => 'text-align: center; width: 100px;'),
                        ),
                        array(
                            'header' => 'Lihat',
                            'class' => 'bootstrap.widgets.BootButtonColumn',
                            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                            'template' => '{view}',
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
                            'type' => 'raw',
                            'value' => '($data->jenispenerimaan_aktif)?CHtml::link("<i class=\'icon-form-silang\'></i> ","javascript:removeTemporary($data->jenispenerimaan_id)",array("id"=>"$data->jenispenerimaan_id","rel"=>"tooltip","title"=>"Menonaktifkan"))." ".CHtml::link("<i class=\'icon-form-sampah\'></i> ", "javascript:deleteRecord($data->jenispenerimaan_id)",array("id"=>"$data->jenispenerimaan_id","rel"=>"tooltip","title"=>"Hapus")):CHtml::link("<i class=\'icon-form-sampah\'></i> ", "javascript:deleteRecord($data->jenispenerimaan_id)",array("id"=>"$data->jenispenerimaan_id","rel"=>"tooltip","title"=>"Hapus"));',
                            'htmlOptions' => array('style' => 'text-align: center; width: 100px;'),
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
								$(".angkahuruf-only").keyup(function() {
									setAngkaHurufsOnly(this);
								});
								$(".hurufs-only").keyup(function() {
									 setHurufsOnly(this);                    
								});
							}',
                )); ?>
            </div>
        </div>

        <div class="form-actions">
            <?php
            echo CHtml::link(
                Yii::t('mds', '{icon} Tambah Penerimaan Umum', array('{icon}' => '<i class="icon-plus icon-white"></i>')),
                $this->createUrl('JenisPenerimaanM/create', array('modul_id' => Yii::app()->session['modul_id'])),
                array('title' => 'Tambah penerimaan umum', 'class' => 'btn btn-danger',)
            );
            echo CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PRINT\')'));
            echo CHtml::htmlButton(Yii::t('mds', '{icon} PDF', array('{icon}' => '<i class="entypo-book"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PDF\')'));
            echo CHtml::htmlButton(Yii::t('mds', '{icon} Excel', array('{icon}' => '<i class="entypo-doc-text"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'EXCEL\')'));
            $content = $this->renderPartial('../tips/master', array(), true);
            $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
            $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
            $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
            $urlPrint =  Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/print');
            $url = Yii::app()->createAbsoluteUrl($module . '/' . $controller);

            $js = <<< JSCRIPT
				function cekForm(obj){
					$("#kujenis-penerimaan-m-search :input[name='"+ obj.name +"']").val(obj.value);
				}
				function print(obj){
					window.open("${urlPrint}/"+$('#kujenis-penerimaan-m-search').serialize()+"&caraPrint="+obj,"",'location=_new, width=900px');
				}
JSCRIPT;
            Yii::app()->clientScript->registerScript('print', $js, CClientScript::POS_HEAD);
            ?>
        </div>
    </div>
</div>

<script type="text/javascript">
    function removeTemporary(id) {
        var url = '<?php echo $url . "/removeTemporary"; ?>';
        myConfirm("Apakah Anda yakin ingin menonaktifkan data ini untuk sementara?", 'Perhatian!', function(r) {
            if (r) {
                $.post(url, {
                        id: id
                    },
                    function(data) {
                        if (data.status == 'proses_form') {
                            $.fn.yiiGridView.update('kujenis-penerimaan-m-grid');
                        } else {
                            myAlert('Data gagal dinonaktifkan!')
                        }
                    }, "json");
            }
        });
    }

    function deleteRecord(id) {
        var id = id;
        var url = '<?php echo $url . "/delete"; ?>';
        myConfirm("Apakah Anda yakin ingin Menghapus data ini?", 'Perhatian!', function(r) {
            if (r) {
                $.post(url, {
                        id: id
                    },
                    function(data) {
                        if (data.warning) {
                            myAlert(data.pesan);
                        } else {
                            if (data.status == 'proses_form') {
                                $.fn.yiiGridView.update('kujenis-penerimaan-m-grid');
                            } else {
                                myAlert('Data gagal dihapus!')
                            }
                        }
                    }, "json");
            }
        });
    }
</script>