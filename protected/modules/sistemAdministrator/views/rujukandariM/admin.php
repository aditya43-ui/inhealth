<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="fas fa-layer-group"></i> Pengaturan <b>Perujuk</b>
        </div>
    </div>
    <div class="panel-body">
        <?php
        $this->breadcrumbs = array(
            'Rujukandari Ms' => array('index'),
            'Manage',
        );

        $arrMenu = array();
        (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ? array_push($arrMenu, array('label' => Yii::t('mds', 'Manage') . ' Daftar Rujukan ', 'header' => true, 'itemOptions' => array('class' => 'heading-master'))) : '';
        //                array_push($arrMenu,array('label'=>Yii::t('mds','List').' Daftar Rujukan', 'icon'=>'list', 'url'=>array('index'))) ;
        //                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' Daftar Rujukan', 'icon'=>'file', 'url'=>array('create'))) :  '' ;

        $this->menu = $arrMenu;

        Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
$('.search-form').toggle();
return false;
});
$('.search-form form').submit(function(){
$.fn.yiiGridView.update('rujukandari-m-grid', {
data: $(this).serialize()
});
return false;
});
");

        $this->widget('bootstrap.widgets.BootAlert');
        ?>
        <?php echo CHtml::link(Yii::t('mds', '{icon} Advanced Search', array('{icon}' => '<i class="icon-white icon-accordion"></i>')), '#', array('class' => 'search-button btn')); ?>
        <div class="cari-lanjut search-form">
            <?php
            $this->renderPartial($this->path_view . '_search', array(
                'model' => $model,
            ));
            ?>
        </div>
        <!--search-form-->

        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Perunjuk</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <!--<h6>Tabel <b>Daftar Rujukan</b></h6>-->
                <?php
                $this->widget('ext.bootstrap.widgets.BootGridView', array(
                    'id' => 'rujukandari-m-grid',
                    'dataProvider' => $model->search(),
                    'filter' => $model,
                    'template' => "{summary}\n{items}\n{pager}",
                    'itemsCssClass' => 'table table-bordered table-striped table-condensed',
                    'columns' => array(
                        ////'rujukandari_id',
                        array(
                            'header' => 'No.',
                            'value' => '$row+1',
                        ),
                        array(
                            'name' => 'asalrujukan_id',
                            'value' => '$data->asalrujukan->asalrujukan_nama',
                            'filter' => CHtml::dropDownList('RujukandariM[asalrujukan_id]', $model->asalrujukan_id, CHtml::listData(AsalrujukanM::model()->findAll('asalrujukan_aktif = TRUE ORDER BY asalrujukan_nama ASC'), 'asalrujukan_id', 'asalrujukan_nama'), array('empty' => '-- Pilih --'))
                            //'filter'=> CHtml::listData(AsalrujukanM::model()->findAll('asalrujukan_aktif = TRUE'),'asalrujukan_id','asalrujukan_nama')
                        ),
                        array(
                            'name' => 'namaperujuk',
                            'value' => '$data->namaperujuk',
                            'filter' => CHtml::activeTextField($model, 'namaperujuk'),
                        ),
                        'spesialis',
                        'alamatlengkap',
                        'notelp',
                        'ppkrujukan',
                        array(
                            'header' => 'Lihat',
                            'class' => 'bootstrap.widgets.BootButtonColumn',
                            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                            'template' => '{view}',
                            'buttons' => array(
                                'view' => array(
                                    'options' => array('rel' => 'tooltip', 'title' => 'Lihat Daftar Rujukan'),
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
                                    'options' => array('rel' => 'tooltip', 'title' => 'Ubah Daftar Rujukan'),
                                    'visible' => 'Yii::app()->controller->checkAccess(array("action"=>Params::DEFAULT_UPDATE))',
                                ),
                            ),
                        ),
                        array(
                            'header' => 'Hapus',
                            'class' => 'bootstrap.widgets.BootButtonColumn',
                            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                            'template' => '{delete}',
                            'buttons' => array(
                                //				'remove' => array (
                                //						'label'=>"<i class='icon-form-silang'></i>",
                                //						'options'=>array('title'=>Yii::t('mds','Remove Temporary')),
                                //						'url'=>'Yii::app()->createUrl("'.Yii::app()->controller->module->id.'/'.Yii::app()->controller->id.'/removeTemporary",array("id"=>$data->rujukandari_id))',
                                //						'click'=>'function(){removeTemporary(this);return false;}',
                                //				),
                                'delete' => array(),
                            )
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
                ));
                ?>
            </div>
        </div>

        <div class="form-actions">
            <?php
            echo CHtml::link(
                Yii::t(
                    'mds',
                    '{icon} Tambah Perujuk',
                    array('{icon}' => '<i class="icon-plus icon-white"></i>')
                ),
                $this->createUrl('create', array('modul_id' => Yii::app()->session['modul_id'])),
                array(
                    'class' => 'btn btn-danger',
                    'title' => 'Tambah petunjuk',
                )
            );
            echo CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PRINT\')'));
            echo CHtml::htmlButton(Yii::t('mds', '{icon} PDF', array('{icon}' => '<i class="entypo-book"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PDF\')'));
            echo CHtml::htmlButton(Yii::t('mds', '{icon} Excel', array('{icon}' => '<i class="entypo-doc-text"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'EXCEL\')'));
            $content = $this->renderPartial($this->path_view . 'tips/tipsAdmin', array(), true);
            $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
            //$this->widget('UserTips',array('type'=>'admin'));
            $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
            $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
            $urlPrint = Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/print');

            $js = <<< JSCRIPT
function cekForm(obj)
{
$("#rujukandari-m-search :input[name='"+ obj.name +"']").val(obj.value);
}
function print(caraPrint)
{
window.open("${urlPrint}/"+$('#rujukandari-m-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
JSCRIPT;
            Yii::app()->clientScript->registerScript('print', $js, CClientScript::POS_HEAD);
            ?>
            <script>
                function removeTemporary(obj) {
                    myConfirm("Anda yakin akan menonaktifkan data ini untuk sementara?", "Perhatian!",
                        function(r) {
                            if (r) {
                                $.ajax({
                                    type: 'GET',
                                    url: obj.href,
                                    data: {}, //
                                    dataType: "json",
                                    success: function(data) {
                                        $.fn.yiiGridView.update('rujukandari-m-grid');
                                        if (data.sukses > 0) {

                                        } else {
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
                $('.filters #RujukandariM_namaperujuk').focus();
            </script>
        </div>
    </div>
</div>