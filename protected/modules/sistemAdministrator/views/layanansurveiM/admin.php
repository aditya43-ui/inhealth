<?php
$this->breadcrumbs = array(
    'Layanansurvei Ms' => array('index'),
    'Manage',
);

$this->menu = array(
    array('label' => 'List LayanansurveiM', 'url' => array('index')),
    array('label' => 'Create LayanansurveiM', 'url' => array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('layanansurvei-m-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="glyphicon glyphicon-briefcase"></i> Pengaturan <b>Layanan Survei</b>
        </div>
    </div>
    <div class="panel-body">
        <?php $this->widget('bootstrap.widgets.BootAlert'); ?>

        <?php echo CHtml::link(Yii::t('mds', '{icon} Advanced Search', array('{icon}' => '<i class="icon-accordion icon-white"></i>')), '#', array('class' => 'search-button btn')); ?>
        <div class="cari-lanjut search-form">
            <?php
            $this->renderPartial('_search', array(
                'model' => $model,
            ));
            ?>
        </div>
        <!--search-form-->

        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Layanan Survei</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php $this->widget('ext.bootstrap.widgets.BootGridView', array(
                    'id' => 'layanansurvei-m-grid',
                    'dataProvider' => $model->search(),
                    'filter' => $model,
                    'template' => "{summary}\n{items}\n{pager}",
                    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
                    'columns' => array(
                        array(
                            'header' => 'No.',
                            'value' => '$row+1',
                        ),
                        array(
                            'header' => 'Nama Instalasi',
                            'type' => 'raw',
                            'name' => 'instalasi_id',
                            'value' => function ($data) {
                                $modul = InstalasiM::model()->findByPk($data->instalasi_id);
                                if (empty($modul)) return "Tidak diset";
                                return $modul->instalasi_nama;
                            },
                            'filter' => Chtml::activeDropDownList($model, 'instalasi_id', Chtml::listData(InstalasiM::model()->findAll(" instalasi_aktif = TRUE ORDER BY instalasi_nama ASC "), 'instalasi_id', 'instalasi_nama'), array('empty' => '-- Pilih --')),
                        ),

                        array(
                            'header' => 'Nama Ruangan',
                            'name' => 'ruangan_id',
                            'type' => 'raw',
                            'value' => function ($data) {
                                $modul = RuanganM::model()->findByPk($data->ruangan_id);
                                if (empty($modul)) return "Tidak diset";
                                return $modul->ruangan_nama;
                            },
                            'filter' => Chtml::activeDropDownList($model, 'ruangan_id', Chtml::listData(RuanganM::model()->findAll("ruangan_aktif = TRUE ORDER BY ruangan_nama ASC "), 'ruangan_id', 'ruangan_nama'), array('empty' => '-- Pilih --')),
                        ),
                        'layanansurvei_nama',

                        /*
                            'layanansurvei_aktif',
                            */
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
                                    //'visible'=>'Yii::app()->controller->checkAccess(array("action"=>Params::DEFAULT_UPDATE))',
                                ),
                            ),
                        ),
                        array(
                            'header' => 'Hapus',
                            'class' => 'bootstrap.widgets.BootButtonColumn',
                            'htmlOptions' => array('style' => 'text-align: center; width: 100px;'),
                            'template' => '{remove} {delete}',
                            'buttons' => array(

                                'remove' => array(
                                    'label' => "<i class='icon-form-silang'></i>",
                                    'options' => array('title' => Yii::t('mds', 'Remove Temporary')),
                                    'url' => 'Yii::app()->createUrl("' . Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/removeTemporary",array("id"=>$data->layanansurvei_id))',
                                    'click' => 'function(){removeTemporary(this);return false;}',
                                ),
                                'delete' => array(),
                            )
                        ),
                    ),
                )); ?>
            </div>
        </div>

        <div class="form-actions">
            <?php
            echo CHtml::link(
                Yii::t('mds', '{icon} Tambah Layanan Survei', array('{icon}' => '<i class="icon-plus icon-white"></i>')),
                $this->createUrl('layanansurveiM/create', array('modul_id' => Yii::app()->session['modul_id'])),
                array('title' => 'Tambah layanan survei', 'class' => 'btn btn-danger',)
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
          function cekForm(obj)
{
    $("#layanansurvei-m-search :input[name='"+ obj.name +"']").val(obj.value);
}
function print(caraPrint)
{
    window.open("${urlPrint}/"+$('#layanansurvei-m-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
JSCRIPT;
            Yii::app()->clientScript->registerScript('print', $js, CClientScript::POS_HEAD);
            ?>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $("input[name='LayanansurveiM[layanansurvei_nama]']").focus();

    });

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
                            $.fn.yiiGridView.update('layanansurvei-m-grid');
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
</script>