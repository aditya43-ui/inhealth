<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="far fa-edit"></i> Cara Keluar
        </div>
    </div>
    <div class="panel-body">
        <?php
        $this->breadcrumbs = array(
            'Rdcara Keluar Ms' => array('index'),
            'Manage',
        );

        $arrMenu = array();
        (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ? array_push($arrMenu, array('label' => Yii::t('mds', 'Manage') . ' Cara Keluar ', 'header' => true, 'itemOptions' => array('class' => 'heading-master'))) :  '';

        // (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' Cara Keluar', 'icon'=>'file', 'url'=>array('create'))) :  '' ;

        $this->menu = $arrMenu;

        Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
		$('.search-form').toggle();
	$('#SACaraKeluarM_lookup_name').focus();
		return false;
});
$('.search-form form').submit(function(){
		$.fn.yiiGridView.update('rdcara-keluar-m-grid', {
				data: $(this).serialize()
		});
		return false;
});
");

        $this->widget('bootstrap.widgets.BootAlert'); ?>
        <?php echo CHtml::link(Yii::t('mds', '{icon} Advanced Search', array('{icon}' => '<i class="icon-accordion icon-white"></i>')), '#', array('class' => 'search-button btn')); ?>
        <div class="cari-lanjut search-form">
            <?php $this->renderPartial($this->path_view . '_search', array(
                'model' => $model,
            )); ?>
        </div>
        <!--search-form-->
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Cara Keluar</b>
                </div>
            </div>
            <div class="panel-body">
                <!--<h6>Tabel <b>Cara Keluar</b></h6>-->
                <?php $this->widget('ext.bootstrap.widgets.BootGridView', array(
                    'id' => 'rdcara-keluar-m-grid',
                    'dataProvider' => $model->searchCaraKeluar(),
                    'filter' => $model,
                    'template' => "{summary}\n{items}\n{pager}",
                    'itemsCssClass' => 'table table-striped table-condensed',
                    'columns' => array(
                        ////'lookup_id',
                        array(
                            'name' => 'lookup_id',
                            'value' => '$data->lookup_id',
                            'filter' => false,
                        ),
                        'lookup_name',
                        'lookup_urutan',
                        'lookup_kode',
                        array(
                            'header' => 'Status',
                            'value' => '($data->lookup_aktif == 1 ) ? "Aktif" : "Tidak Aktif"',
                            'htmlOptions' => array('style' => 'text-align: center; width: 100px;'),
                        ),
                        array(
                            'header' => 'Lihat',
                            'class' => 'bootstrap.widgets.BootButtonColumn',
                            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                            'template' => '{view}',
                            'buttons' => array(
                                'view' => array(
                                    'options' => array('title' => 'Lihat cara keluar'),
                                ),
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
                                    'options' => array('title' => 'Ubah cara keluar'),
                                ),
                            ),
                        ),
                        array(
                            'header' => 'Hapus',
                            'class' => 'bootstrap.widgets.BootButtonColumn',
                            'htmlOptions' => array('style' => 'text-align: center; width: 100px;'),
                            'template' => '{remove} {add} {delete}',
                            'buttons' => array(
                                'remove' => array(
                                    'label' => "<i class='icon-form-silang'></i>",
                                    'options' => array('title' => Yii::t('mds', 'Remove Temporary')),
                                    'url' => 'Yii::app()->createUrl("' . Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/nonActive",array("id"=>$data->lookup_id))',
                                    'click' => 'function(){nonActive(this);return false;}',
                                    'visible' => '(($data->lookup_aktif)? TRUE : FALSE)'
                                ),
                                'add' => array(
                                    'label' => "<i class='icon-form-check'></i>",
                                    'options' => array('title' => Yii::t('mds', 'Add Temporary')),
                                    'url' => 'Yii::app()->createUrl("' . Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/active",array("id"=>$data->lookup_id))',
                                    'click' => 'function(){active(this);return false;}',
                                    'visible' => '(($data->lookup_aktif)? FALSE : TRUE)'
                                ),
                                'delete' => array(),
                            )
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
            echo CHtml::link(
                Yii::t('mds', '{icon} Tambah Cara Keluar', array('{icon}' => '<i class="icon-plus icon-white"></i>')),
                Yii::app()->createUrl($this->module->id . '/' . Yii::app()->controller->id . '/create'),
                array('title' => 'Tambah cara keluar', 'class' => 'btn btn-danger',)
            );
            echo CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PRINT\')'));
            echo CHtml::htmlButton(Yii::t('mds', '{icon} PDF', array('{icon}' => '<i class="entypo-book"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PDF\')'));
            echo CHtml::htmlButton(Yii::t('mds', '{icon} Excel', array('{icon}' => '<i class="entypo-doc-text"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'EXCEL\')'));
            $content = $this->renderPartial($this->path_view . 'tips/master', array(), true);
            $this->widget('UserTips', array('type' => 'create', 'content' => $content));
            $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
            $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
            $urlPrint =  Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/print');
            $url =  Yii::app()->createAbsoluteUrl($module . '/' . $controller);

            $js = <<< JSCRIPT
        function cekForm(obj)
{
    $("#rdcara-keluar-m-search :input[name='"+ obj.name +"']").val(obj.value);
}
function print(caraPrint)
{
    window.open("${urlPrint}/"+$('#rdcara-keluar-m-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
JSCRIPT;
            Yii::app()->clientScript->registerScript('print', $js, CClientScript::POS_HEAD);
            ?>
            <!--</div>-->
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
                                        $.fn.yiiGridView.update('rdcara-keluar-m-grid');
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
                                        $.fn.yiiGridView.update('rdcara-keluar-m-grid');
                                        if (data.sukses > 0) {} else {
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
                $(document).ready(function() {
                    $('input[name="SACaraKeluarM[lookup_name]"]').focus();
                })
            </script>
        </div>
    </div>
</div>