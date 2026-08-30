<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="far fa-edit"></i> Pengaturan <b>Diagnosa ICD 10</b>
        </div>
    </div>
    <div class="panel-body">
        <?php
        $this->breadcrumbs = array(
            'Sadiagnosa Ms' => array('index'),
            'Manage',
        );

        $arrMenu = array();
        (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ? array_push($arrMenu, array('label' => Yii::t('mds', 'Manage') . ' Diagnosa ', 'header' => true, 'itemOptions' => array('class' => 'heading-master'))) :  '';
        //                array_push($arrMenu,array('label'=>Yii::t('mds','List').' Diagnosa', 'icon'=>'list', 'url'=>array('index'))) ;
        (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ? array_push($arrMenu, array('label' => Yii::t('mds', 'Create') . ' Diagnosa', 'icon' => 'file', 'url' => array('create'))) :  '';
        //$this->menu=$arrMenu;

        Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
$('.search-form').toggle();
return false;
});
$('.search-form form').submit(function(){
$.fn.yiiGridView.update('sadiagnosa-m-grid', {
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
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Diagnosa ICD 10</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <!--<legend class='rim'>Tabel Diagnosa X</legend>-->
                <?php $this->widget('ext.bootstrap.widgets.BootGridView', array(
                    'id' => 'sadiagnosa-m-grid',
                    'dataProvider' => $model->search(),
                    'filter' => $model,
                    'template' => "{summary}\n{items}{pager}",
                    'itemsCssClass' => 'table table-bordered table-striped datatable',
                    'columns' => array(
                        ////'diagnosa_id',
                        array(
                            'header' => 'No.',
                            'value' => '($this->grid->dataProvider->pagination) ? 
($this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1)
: ($row+1)',
                            'type' => 'raw',
                            'htmlOptions' => array('style' => 'text-align: right;'),
                        ),
                        'diagnosa_kode',
                        'diagnosa_nama',
                        //  array(
                        //    'header' => 'Diagnosa',
                        //  'name' => 'diagnosa_namalainnya',
                        //),
                        'diagnosa_namalainnya',
                        'diagnosa_katakunci',
                        'diagnosa_nourut',
                        array(
                            'header' => 'Status',
                            'value' => '($data->diagnosa_aktif == 1 ) ? "Aktif" : "Tidak Aktif"',
                            'htmlOptions' => array('style' => 'text-align: center; width: 100px;'),
                        ),
                        //                  array(
                        //                        'header'=>'Aktif',
                        //                        'class'=>'CCheckBoxColumn',     
                        //                        'selectableRows'=>0,
                        //                        'id'=>'rows',
                        //                        'checked'=>'$data->diagnosa_aktif',
                        //                ), 
                        /*
'diagnosa_imunisasi',
'diagnosa_aktif',
*/
                        array(
                            'header' => 'Lihat',
                            'class' => 'bootstrap.widgets.BootButtonColumn',
                            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                            'template' => '{view}',
                            'buttons' => array(
                                'view' => array(
                                    'options' => array('rel' => 'tooltip', 'title' => 'Lihat Diagnosa ICD 10'),
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
                                    'options' => array('rel' => 'tooltip', 'title' => 'Ubah Diagnosa ICD 10'),
                                ),
                            ),
                        ),
                        array(
                            'header' => 'Hapus',
                            'class' => 'bootstrap.widgets.BootButtonColumn',
                            'template' => '{remove} {add} {delete}',
                            'htmlOptions' => array('style' => 'text-align: center; width: 100px;'),
                            'buttons' => array(
                                /*'remove' => array (
'label'=>"<i class='icon-form-silang'></i>",
'options'=>array('rel' => 'tooltip' , 'title'=> 'Menonaktifkan Diagnosa ICD X' ),
'url'=>'Yii::app()->createUrl("'.Yii::app()->controller->module->id.'/'.Yii::app()->controller->id.'/removeTemporary",array("id"=>"$data->diagnosa_id"))',
'visible'=>'($data->diagnosa_aktif) ? TRUE : FALSE',
//                                  'click'=>'function(){return confirm("'.Yii::t("mds","Do You want to remove this item temporary?").'");}',
'click'=>'function(){ removeTemporary(this); return false;}',
),*/
                                'remove' => array(
                                    'label' => "<i class='icon-form-silang'></i>",
                                    'options' => array('rel' => 'tooltip', 'title' => 'Menonaktifkan DTD'),
                                    'url' => 'Yii::app()->createUrl("' . Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/removeTemporary",array("id"=>"$data->diagnosa_id"))',
                                    'visible' => '($data->diagnosa_aktif) ? TRUE : FALSE',
                                    'click' => 'function(){ removeTemporary(this); return false;}',
                                ),
                                'add' => array(
                                    'label' => "<i class='entypo-check'></i>",
                                    'options' => array('rel' => 'tooltip', 'title' => 'Mengaktifkan DTD'),
                                    'url' => 'Yii::app()->createUrl("' . Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/removeTemporary",array("id"=>"$data->diagnosa_id", "add"=>1))',
                                    'visible' => '($data->diagnosa_aktif) ? FALSE : TRUE',
                                    'click' => 'function(){ addTemporary(this, 1); return false;}',
                                ),
                                'delete' => array(
                                    //'visible'=>'Yii::app()->controller->checkAccess(array("action"=>Params::DEFAULT_DELETE))',
                                    'options' => array('rel' => 'tooltip', 'title' => 'Hapus Diagnosa ICD 10'),
                                ),
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
                Yii::t('mds', '{icon} Tambah Diagnosa ICD 10', array('{icon}' => '<i class="icon-plus icon-white"></i>')),
                $this->createUrl('create', array('modul_id' => Yii::app()->session['modul_id'])),
                array('title' => 'Tambah diagnosa ICD 10', 'class' => 'btn btn-danger',)
            );
            echo CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PRINT\')'));
            echo CHtml::htmlButton(Yii::t('mds', '{icon} PDF', array('{icon}' => '<i class="entypo-book"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PDF\')'));
            echo CHtml::htmlButton(Yii::t('mds', '{icon} Excel', array('{icon}' => '<i class="entypo-doc-text"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'EXCEL\')'));
            $content = $this->renderPartial($this->path_view . 'tips/tipsAdmin', array(), true);
            $this->widget('UserTips', array('content' => $content));
            $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
            $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
            $urlPrint =  Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/print');

            $js = <<< JSCRIPT
function cekForm(obj){
$("#sadiagnosa-m-search :input[name='"+ obj.name +"']").val(obj.value);
}
function print(caraPrint){
window.open("${urlPrint}/"+$('#sadiagnosa-m-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px, scrollbars=yes');
}
JSCRIPT;
            Yii::app()->clientScript->registerScript('print', $js, CClientScript::POS_HEAD);
            ?>
            <script type="text/javascript">
                function removeTemporary(obj) {
                    var url = $(obj).attr('href');
                    myConfirm("Anda yakin akan menonaktifkan data ini untuk sementara?", "Perhatian!", function(r) {
                        if (r) {
                            $.ajax({
                                type: 'GET',
                                url: url,
                                data: {},
                                dataType: "json",
                                success: function(data) {
                                    if (data.status == 'proses_form') {
                                        $.fn.yiiGridView.update('sadiagnosa-m-grid');
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

                function addTemporary(obj, add) {
                    var url = $(obj).attr('href') + $(add).attr('href');
                    myConfirm("Anda yakin akan mengaktifkan data ini untuk sementara?", "Perhatian!", function(r) {
                        if (r) {
                            $.ajax({
                                type: 'GET',
                                url: url,
                                data: {},
                                dataType: "json",
                                success: function(data) {
                                    if (data.status == 'proses_form') {
                                        $.fn.yiiGridView.update('sadiagnosa-m-grid');
                                    } else {
                                        myAlert('Data Gagal di Aktifkan.')
                                    }
                                },
                                error: function(jqXHR, textStatus, errorThrown) {
                                    console.log(errorThrown);
                                }
                            });
                        }
                    });
                }

                $(document).ready(function() {
                    $('input[name="SADiagnosaM[diagnosa_kode]"]').focus();
                });
            </script>
        </div>
    </div>
</div>