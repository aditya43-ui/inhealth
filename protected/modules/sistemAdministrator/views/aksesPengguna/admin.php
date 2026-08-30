<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="fas fa-cogs"></i> Pengaturan <b>Akses Pemakai</b>
        </div>
    </div>
    <div class="panel-body">
        <?php
        $this->breadcrumbs = array(
            'saaksespengguna Ks' => array('index'),
            'Manage',
        );

        Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('saaksespengguna-k-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
        $this->widget('bootstrap.widgets.BootAlert'); ?>
        <?php echo CHtml::link(Yii::t('mds', '{icon} Advanced Search', array('{icon}' => '<i class="icon-accordion icon-white"></i>')), '#', array('class' => 'search-button btn')); ?>
        <div class="cari-lanjut search-form">
            <?php $this->renderPartial('_search', array(
                'model' => $model,
            )); ?>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Akses Pemakai</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <!--<legend class="rim">Pengaturan Akses Pemakai</legend>-->
                <?php $this->widget('ext.bootstrap.widgets.BootGroupGridView', array(
                    'id' => 'saaksespengguna-k-grid',
                  'mergeColumns' => array('loginpemakai.nama_pemakai','loginpemakai.nama_pegawai', 'peranpengguna.peranpenggunanama'),
                    'dataProvider' => $model->search(),
                    'template' => "{summary}\n{items}\n{pager}",
                    'itemsCssClass' => 'table table-bordered table-striped datatable',
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
                            'name' => 'loginpemakai.nama_pemakai',
                            'value' => 'empty($data->loginpemakai_id)?"-":$data->loginpemakai->nama_pemakai',
                            'filter' => false,
                        ),
                        array(
                            'name' => 'loginpemakai.nama_pegawai',
                            'value' => 'empty($data->loginpemakai_id)?"-":$data->loginpemakai->pegawai->nama_pegawai',
                            'filter' => false,
                        ),
                        array(
                            'name' => 'peranpengguna.peranpenggunanama',
                            'value' => 'empty($data->peranpengguna)?"-":$data->peranpengguna->peranpenggunanama',
                            'filter' => false,
                        ),
                        array(
                            'header' => 'Tugas',
                            'name' => 'tugas_nama',
                            'value' => '$data->tugas_nama',
                            'filter' => false,
                        ),
                        array(
                            'header' => 'Lihat',
                            'class' => 'bootstrap.widgets.BootButtonColumn',
                            'template' => '{view}',
                            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                            'buttons' => array(
                                'view' => array(
                                    'label' => "<i class='entypo-eye'></i>",
                                    'options' => array('title' => Yii::t('mds', 'Lihat')),
                                    'url' => 'Yii::app()->createUrl("' . Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/view",array("id"=>"$data->aksespengguna_id"))',
                                ),
                            ),
                        ),
                        array(
                            'header' => 'Ubah',
                            'class' => 'bootstrap.widgets.BootButtonColumn',
                            'template' => '{update}',
                            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                            'buttons' => array(
                                'update' => array(
                                    'label' => "<i class='entypo-pencil'></i>",
                                    'options' => array('title' => Yii::t('mds', 'Ubah')),
                                    'url' => 'Yii::app()->createUrl("' . Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/update",array("id"=>"$data->aksespengguna_id"))',
                                ),
                            ),
                        ),
                        array(
                            'header' => 'Hapus',
                            'class' => 'bootstrap.widgets.BootButtonColumn',
                            'template' => '{delete}',
                            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                            'buttons' => array(
                                'delete' => array(
                                    'label' => "<i class='icon-form-silang'></i>",
                                    'options' => array('title' => Yii::t('mds', 'Hapus')),
                                    'url' => 'Yii::app()->createUrl("' . Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/delete",array("id"=>"$data->aksespengguna_id"))',
                                    'click' => 'function(){return confirm("' . Yii::t("mds", "Anda yakin akan menghapus data ini?") . '");}',
                                ),
                            )
                        ),
                    ),
                    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
                )); ?>
            </div>
        </div>

        <div class="form-actions">
            <?php
            echo CHtml::link(
                Yii::t('mds', '{icon} Tambah Akses Pemakai', array('{icon}' => '<i class="icon-plus icon-white"></i>')),
                $this->createUrl($this->id . '/create', array('modul_id' => Yii::app()->session['modul_id'])),
                array('title' => 'Tambah akses pemakai', 'class' => 'btn btn-danger',)
            );
            echo CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PRINT\')'));
            echo CHtml::htmlButton(Yii::t('mds', '{icon} PDF', array('{icon}' => '<i class="entypo-book"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PDF\')'));
            echo CHtml::htmlButton(Yii::t('mds', '{icon} Excel', array('{icon}' => '<i class="entypo-doc-text"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'EXCEL\')'));
            $content = $this->renderPartial('../tips/master2', array(), true);
            $this->widget('UserTips', array('type' => 'admin', 'content' => $content));
            ?>
            <?php
            $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
            $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
            $urlPrint =  Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/print');

            $js = <<< JSCRIPT
function print(caraPrint)
{
    window.open("${urlPrint}/"+$('#saaksespengguna-k-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
JSCRIPT;
            Yii::app()->clientScript->registerScript('print', $js, CClientScript::POS_HEAD);
            ?>
        </div>
    </div>
</div>