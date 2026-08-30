<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <?php if($this->module->id == 'sistemAdministrator') : ?>
		 <i class="fas fa-layer-group"></i> Pengaturan <b>Kamar Ruangan</b>
            <?php else : ?>
                 <i class="fas fa-layer-group"></i><b>Pengaturan Tempat Tidur (Bed)</b>
            <?php endif; ?>
           
        </div>
    </div>
    <div class="panel-body">
        <?php
        $this->breadcrumbs = array(
            'Kamar Ruangan' => array('admin'),
            'Pengaturan',
        );

        $arrMenu = array();
        (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ? array_push($arrMenu, array('label' => Yii::t('mds', 'Manage') . ' Kamar Ruangan ', 'header' => true, 'itemOptions' => array('class' => 'heading-master'))) :  '';
        //                array_push($arrMenu,array('label'=>Yii::t('mds','List').' Kamar Ruangan', 'icon'=>'list', 'url'=>array('index'))) ;
        // (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE))?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' Kamar Ruangan', 'icon'=>'file', 'url'=>array('create'))) :  '' ;

        $this->menu = $arrMenu;

        Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
    $('#SAKamarRuanganM_kelaspelayanan_id').focus();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('sakamar-ruangan-m-grid', {
		data: $(this).serialize()
	});
	return false;
});
");

        $this->widget('bootstrap.widgets.BootAlert'); ?>

        <?php echo CHtml::link(Yii::t('mds', '{icon} Advanced Search', array('{icon}' => '<i class="icon-accordion icon-white"></i>')), '#', array('class' => 'search-button btn')); ?>
        <div class="cari-lanjut search-form">
            <?php $this->renderPartial($this->path_view.'_search', array(
                'model' => $model,
            )); ?>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <?php if($this->module->id == 'sistemAdministrator') : ?>
                    <i class="entypo-credit-card"></i> Tabel <b>Kamar Ruangan</b>
                    <?php else: ?>
                    <i class="entypo-credit-card"></i>Tabel <b>Tempat Tidur (Bed)</b>
                    <?php endif; ?>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php 
                $this->renderPartial($this->path_view.'_table',['model'=>$model]); 
                
                ?>
            </div>
        </div>

        <div class="form-actions">
            <?php
            if($this->module->id == 'sistemAdministrator'){
                echo CHtml::link(Yii::t('mds', '{icon} Tambah Kamar Ruangan', array('{icon}'=>'<i class="entypo-plus"></i>')), $this->createUrl(Yii::app()->controller->id.'/create',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-danger'))."&nbsp&nbsp";
            }else if($this->module->id == 'hemodialisa'){
                echo CHtml::link(Yii::t('mds', '{icon} Tambah Tempat Tidur (Bed)', array('{icon}'=>'<i class="entypo-plus"></i>')), $this->createUrl(Yii::app()->controller->id.'/create',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-danger'))."&nbsp&nbsp";
            }
            echo CHtml::htmlButton(Yii::t('mds', '{icon} PDF', array('{icon}' => '<i class="entypo-book"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PDF\')'));
            echo CHtml::htmlButton(Yii::t('mds', '{icon} Excel', array('{icon}' => '<i class="entypo-doc-text"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'EXCEL\')'));
            echo CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PRINT\')'));
            $content = $this->renderPartial('sistemAdministrator.views/tips/master', array(), true);
            $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));

            $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
            $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
            $urlPrint =  Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/print');
            $url = Yii::app()->createAbsoluteUrl($module . '/' . $controller);

            $js = <<< JSCRIPT
        function cekForm(obj)
{
    $("#sakamar-ruangan-m-grid :input[name='"+ obj.name +"']").val(obj.value);
}
function print(caraPrint)
{
    window.open("${urlPrint}/"+$('#sakamar-ruangan-m-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
JSCRIPT;
            Yii::app()->clientScript->registerScript('print', $js, CClientScript::POS_HEAD);
            ?>
            <script type="text/javascript">
                function removeTemporary(id) {
                    var url = '<?php echo $url . "/removeTemporary"; ?>';
                    var answer = confirm('Yakin akan menonaktifkan data ini untuk sementara?');
                    if (answer) {
                        $.post(url, {
                                id: id
                            },
                            function(data) {
                                if (data.status == 'proses_form') {
                                    $.fn.yiiGridView.update('sakamar-ruangan-m-grid');
                                } else {
                                    myAlert('Data gagal dinonaktifkan!')
                                }
                            }, "json");
                    }
                }

                function deleteRecord(id) {
                    var id = id;
                    var url = '<?php echo $url . "/delete"; ?>';
                    var answer = confirm('Yakin Akan Menghapus Data ini?');
                    if (answer) {
                        $.post(url, {
                                id: id
                            },
                            function(data) {
                                if (data.status == 'proses_form') {
                                    $.fn.yiiGridView.update('sakamar-ruangan-m-grid');
                                } else {
                                    myAlert('Data gagal dihapus!')
                                }
                            }, "json");
                    }
                }
            </script>
        </div>
    </div>
</div>