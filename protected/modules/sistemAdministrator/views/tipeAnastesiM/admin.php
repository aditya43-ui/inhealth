<div class="white-container">
    <legend class="rim2">Pengaturan <b>Tipe Anastesi</b></legend>
    <?php
    $this->breadcrumbs = array(
        'Satipeanastesi Ms' => array('index'),
        'Manage',
    );

    $arrMenu = array();
    (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ? array_push($arrMenu, array('label' => Yii::t('mds', 'Manage') . ' Tipe Anastesi ', 'header' => true, 'itemOptions' => array('class' => 'heading-master'))) :  '';

    $this->menu = $arrMenu;

    Yii::app()->clientScript->registerScript('search', "
	$('.search-button').click(function(){
		$('.search-form').toggle();
			
		return false;
	});
	$('.search-form form').submit(function(){
		$.fn.yiiGridView.update('tipeanastesi-m-grid', {
			data: $(this).serialize()
		});
		return false;
	});
	");

    $this->widget('bootstrap.widgets.BootAlert');
    ?>
    <?php echo CHtml::link(Yii::t('mds', '{icon} Advanced Search', array('{icon}' => '<i class="icon-accordion icon-white"></i>')), '#', array('class' => 'search-button btn')); ?>
    <div class="cari-lanjut search-form">
        <?php $this->renderPartial($this->path_view . '_search', array('model' => $model)); ?>
    </div>
    <div class="panel panel-success">
        <div class="panel-heading">
            <div class="panel-title">
                <i class="entypo-credit-card"></i> Tabel <b>Tipe Anastesi</b>
            </div>
        </div>
        <div class="panel-body table-responsive">
            <?php $this->widget('ext.bootstrap.widgets.BootGridView', array(
                'id' => 'tipeanastesi-m-grid',
                'dataProvider' => $model->search(),
                'filter' => $model,
                'itemsCssClass' => 'table table-striped table-bordered table-condensed',
                'template' => "{summary}\n{items}\n{pager}",
                'columns' => array(
                    array(
                        'header' => 'No.',
                        'value' => '($this->grid->dataProvider->pagination) ? ($this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1) : ($row+1)',
                    ),
                    // array(
                    // 	'name'=>'anastesi_id',
                    // 	'value'=>'$data->anastesi_id',
                    // ),
                    array(
                        'name' => 'typeanastesi_nama',
                        'value' => '$data->typeanastesi_nama',
                    ),
                    array(
                        'name' => 'typeanastesi_namalain',
                        'value' => '$data->typeanastesi_namalain',
                    ),
                    array(
                        'header' => Yii::t('zii', 'View'),
                        'class' => 'bootstrap.widgets.BootButtonColumn',
                        'template' => '{view}',
                        'buttons' => array(
                            'view' => array(
                                'options' => array('rel' => 'tooltip', 'title' => 'Lihat detail'),
                            ),
                        ),
                    ),
                    array(
                        'header' => Yii::t('zii', 'Update'),
                        'class' => 'bootstrap.widgets.BootButtonColumn',
                        'template' => '{update}',
                        'buttons' => array(
                            'update' => array(
                                //'visible'=>'Yii::app()->controller->checkAccess(array("action"=>Params::DEFAULT_UPDATE))',
                                'options' => array('rel' => 'tooltip', 'title' => 'Ubah detail operasi'),
                            ),
                        ),
                    ),
                    array(
                        'header' => 'Hapus',
                        'type' => 'raw',
                        'value' => '($data->typeanastesi_aktif)?CHtml::link("<i class=\'icon-form-silang\'></i> ","javascript:removeTemporary($data->typeanastesi_id)",array("id"=>"$data->typeanastesi_id","rel"=>"tooltip","title"=>"Menonaktifkan detail operasi"))." ".CHtml::link("<i class=\'icon-form-sampah\'></i> ", "javascript:deleteRecord($data->typeanastesi_id)",array("id"=>"$data->typeanastesi_id","rel"=>"tooltip","title"=>"Hapus detail operasi")):CHtml::link("<i class=\'icon-form-sampah\'></i> ", "javascript:deleteRecord($data->typeanastesi_id)",array("id"=>"$data->typeanastesi_id","rel"=>"tooltip","title"=>"Hapus detail operasi"));',
                        'htmlOptions' => array('style' => 'text-align: center; width: 100px;'),
                    ),
                ),
                'afterAjaxUpdate' => 'function(id, data){
						jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});
						$("table").find("input[type=text]").each(function(){
							cekForm(this);
						})
						$("table").find("select").each(function(){
							cekForm(this);
						})
					}',
            )); ?>
        </div>
    </div>
    <?php
    echo CHtml::link(Yii::t('mds', '{icon} Tambah Tipe Anastesi', array('{icon}' => '<i class="icon-plus icon-white"></i>')), $this->createUrl('/sistemAdministrator/tipeAnastesiM/create', array('modul_id' => Yii::app()->session['modul_id'])), array('class' => 'btn btn-danger',));
    echo CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PRINT\')'));
    echo CHtml::htmlButton(Yii::t('mds', '{icon} PDF', array('{icon}' => '<i class="entypo-book"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PDF\')'));
    echo CHtml::htmlButton(Yii::t('mds', '{icon} Excel', array('{icon}' => '<i class="entypo-doc-text"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'EXCEL\')'));
    $content = $this->renderPartial('../tips/master', array(), true);
    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
    $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
    $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
    $urlPrint =  Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/print');
    $url =  Yii::app()->createAbsoluteUrl($module . '/' . $controller);

    $js = <<< JSCRIPT
          function cekForm(obj)
{
    $("#satipeanastesi-m-search :input[name='"+ obj.name +"']").val(obj.value);
}
function print(caraPrint)
{
    window.open("${urlPrint}/"+$('#satipeanastesi-m-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
JSCRIPT;
    Yii::app()->clientScript->registerScript('print', $js, CClientScript::POS_HEAD);
    ?>
</div>
<script type="text/javascript">
    function removeTemporary(id) {
        var url = '<?php echo $url . "/removeTemporary"; ?>';
        myConfirm("Anda yakin akan menonaktifkan data ini untuk sementara?", "Perhatian!", function(r) {
            if (r) {
                $.post(url, {
                        id: id
                    },
                    function(data) {
                        if (data.status == 'proses_form') {
                            $.fn.yiiGridView.update('tipeanastesi-m-grid');
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
        myConfirm("Yakin Akan Menghapus Data ini?", "Perhatian!", function(r) {
            if (r) {
                $.post(url, {
                        id: id
                    },
                    function(data) {
                        if (data.status == 'proses_form') {
                            $.fn.yiiGridView.update('tipeanastesi-m-grid');
                        } else {
                            myAlert('Data gagal dihapus!')
                        }
                    }, "json");
            }
        });
    }
</script>