<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-info-circled"></i> Pengaturan <b>Komponen Jasa</b>
        </div>
    </div>
    <div class="panel-body">
        <?php
        $this->breadcrumbs = array(
            'Komponenjasa Ms' => array('index'),
            'Manage',
        );

        $arrMenu = array();
        (Yii::app()->user->checkAccess('Admin')) ? array_push($arrMenu, array('label' => Yii::t('mds', 'Manage') . ' Komponen Jasa  ', 'header' => true, 'itemOptions' => array('class' => 'heading-master'))) :  '';
        //                array_push($arrMenu,array('label'=>Yii::t('mds','List').' Gelar Belakang', 'icon'=>'list', 'url'=>array('index'))) ;
        (Yii::app()->user->checkAccess('Create')) ? array_push($arrMenu, array('label' => Yii::t('mds', 'Create') . ' Komponen Jasa ', 'icon' => 'file', 'url' => array('create'))) :  '';

        $this->menu = $arrMenu;

        Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('komponenjasa-m-grid', {
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
        <!--search-form-->

        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Komponen Jasa</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php $this->widget('ext.bootstrap.widgets.BootGridView', array(
                    'id' => 'komponenjasa-m-grid',
                    'dataProvider' => $model->search(),
                    'filter' => $model,
                    'template' => "{summary}\n{items}\n{pager}",
                    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
                    'columns' => array(
                        ////'komponenjasa_id',
                        array(
                            'header' => 'ID',
                            //'name'=>'komponenjasa_id',
                            'value' => '$data->komponenjasa_id',
                            'filter' => false,
                        ),
                        array(
                            'header' => 'Komponen Tarif',
                            'name' => 'komponentarif_id',
                            'value' => 'isset($data->komponentarif_id)?$data->komponentarif->komponentarif_nama:""',
                            'filter' => CHtml::activeDropDownList($model, 'komponentarif_id', CHtml::listData($model->getKomponentarifItems(), 'komponentarif_id', 'komponentarif_nama'), array('empty' => '-- Pilih --'))
                        ),
                        array(
                            'header' => 'Jenis Tarif',
                            'name' => 'jenistarif_id',
                            'value' => 'isset($data->jenistarif_id)?$data->jenistarif->jenistarif_nama:""',
                            'filter' => CHtml::activeDropDownList($model, 'jenistarif_id', CHtml::listData($model->getJenistarifItems(), 'jenistarif_id', 'jenistarif_nama'), array('empty' => '-- Pilih --'))
                        ),
                        array(
                            'header' => 'Jenis Penjamin',
                            'name' => 'carabayar_id',
                            'value' => 'isset($data->carabayar_id)?$data->carabayar->carabayar_nama:""',
                            'filter' => CHtml::activeDropDownList($model, 'carabayar_id', CHtml::listData($model->getCarabayarItems(), 'carabayar_id', 'carabayar_nama'), array('empty' => '-- Pilih --'))
                        ),
                        array(
                            'header' => 'Kelompok Tindakan',
                            'name' => 'kelompoktindakan_id',
                            'value' => 'isset($data->kelompoktindakan_id)?$data->kelompoktindakan->kelompoktindakan_nama:""',
                            'filter' => CHtml::activeDropDownList($model, 'kelompoktindakan_id', CHtml::listData($model->getKelompoktindakanItems(), 'kelompoktindakan_id', 'kelompoktindakan_nama'), array('empty' => '-- Pilih --'))
                        ),
                        array(
                            'header' => 'Ruangan',
                            'name' => 'ruangan_id',
                            'value' => 'isset($data->ruangan_id)?$data->ruangan->ruangan_nama:""',
                            'filter' => CHtml::activeDropDownList($model, 'ruangan_id', CHtml::listData($model->getRuanganItems(), 'ruangan_id', 'ruangan_nama'), array('empty' => '-- Pilih --'))
                        ),
                        'komponenjasa_kode',
                        'komponenjasa_nama',
                        'komponenjasa_singkatan',
                        'besaranjasa',
                        'potongan',
                        'jasadireksi',
                        'kuebesar',
                        'jasadokter',
                        'jasaparamedis',
                        'jasaunit',
                        'jasabalanceins',
                        'jasaemergency',
                        'biayaumum',
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
                            'class' => 'bootstrap.widgets.BootButtonColumn',
                            'template' => '{remove} {delete}',
                            'htmlOptions' => array('style' => 'text-align: center; width: 100px;'),
                            'buttons' => array(
                                'remove' => array(
                                    'label' => "<i class='icon-form-silang'></i>",
                                    'options' => array('title' => Yii::t('mds', 'Remove Temporary')),
                                    'url' => 'Yii::app()->createUrl("' . Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/removeTemporary",array("id"=>"$data->komponenjasa_id"))',
                                    'visible' => '($data->komponenjasa_aktif) ? TRUE : FALSE',
                                    'click' => 'function(){ removeTemporary(this); return false;}',
                                ),
                                'delete' => array(
                                    'visible' => 'Yii::app()->controller->checkAccess(array("action"=>Params::DEFAULT_DELETE))',
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
                Yii::t('mds', '{icon} Tambah Komponen Jasa', array('{icon}' => '<i class="icon-plus icon-white"></i>')),
                $this->createUrl('create', array('modul_id' => Yii::app()->session['modul_id'])),
                array('title' => 'Tambah komponen jasa', 'class' => 'btn btn-danger',)
            );
            echo CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PRINT\')'));
            echo CHtml::htmlButton(Yii::t('mds', '{icon} PDF', array('{icon}' => '<i class="entypo-book"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PDF\')'));
            echo CHtml::htmlButton(Yii::t('mds', '{icon} Excel', array('{icon}' => '<i class="entypo-doc-text"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'EXCEL\')'));
            $content = $this->renderPartial('../tips/master', array(), true);
            $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
            $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
            $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
            $urlPrint =  Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/print');

            $js = <<< JSCRIPT
function print(caraPrint)
{
    window.open("${urlPrint}/"+$('#komponenjasa-m-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
JSCRIPT;
            Yii::app()->clientScript->registerScript('print', $js, CClientScript::POS_HEAD);
            ?>
        </div>
    </div>
</div>

<script type="text/javascript">
    function removeTemporary(obj) {
        var url = $(obj).attr('href');
        myConfirm("Apakah Anda yakin ingin menonaktifkan data ini untuk sementara?", "Perhatian!", function(r) {
            if (r) {
                $.ajax({
                    type: 'GET',
                    url: url,
                    data: {},
                    dataType: "json",
                    success: function(data) {
                        if (data.status == 'proses_form') {
                            $.fn.yiiGridView.update('komponenjasa-m-grid');
                        } else {
                            myAlert('Data gagal dinonaktifkan!.')
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log(errorThrown);
                    }
                });
            }
        });
    }
</script>