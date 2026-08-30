<div class="white-container">
    <legend class="rim2">Pengaturan <b>Alternatif Diagnosa</b></legend>
    <?php
    $this->breadcrumbs = array(
        'Bataskarakteristik Ms' => array('index'),
        'Manage',
    );

    Yii::app()->clientScript->registerScript('search', "
    $('.search-button').click(function(){
            $('.search-form').toggle();
            return false;
    });
    $('.search-form form').submit(function(){
            $.fn.yiiGridView.update('bataskarakteristik-m-grid', {
                    data: $(this).serialize()
            });
            return false;
    });
    ");
    ?>
    <?php echo CHtml::link(Yii::t('mds', '{icon} Advanced Search', array('{icon}' => '<i class="icon-accordion icon-white"></i>')), '#', array('class' => 'search-button btn')); ?>
    <div class="cari-lanjut search-form">
        <?php
        $this->renderPartial($this->path_view . '_search', array(
            'model' => $model,
        ));
        ?>
    </div>
    <div class='block-tabel'>
        <h6>Tabel <b>Alternatif Diagnosa</b></h6>

        <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
        <?php
        $this->widget('ext.bootstrap.widgets.BootGridView', array(
            'id' => 'bataskarakteristik-m-grid',
            'dataProvider' => $model->search(),
            'filter' => $model,
            'template' => "{summary}\n{items}\n{pager}",
            'itemsCssClass' => 'table table-striped table-bordered table-condensed',
            'columns' => array(
                array(
                    'header' => 'ID',
                    'value' => '$data->alternatifdx_id',
                ),
                array(
                    'header' => 'Diagnosa Keperawatan',
                    'name' => 'diagnosakep_nama',
                    'value' => 'isset($data->diagnosakep->diagnosakep_nama) ? $data->diagnosakep->diagnosakep_nama : " - "',
                ),
                array(
                    'header' => 'Alternatif Diagnosa',
                    'name' => 'alternatifdx_nama',
                    'value' => 'isset($data->alternatifdx_nama) ? $data->alternatifdx_nama : " - "',
                ),
                array(
                    'header' => 'Status',
                    'value' => '($data->alternatifdx_aktif == true ? \'Aktif\': \'Tidak Aktif\')',
                    'htmlOptions' => array('style' => 'text-align: center; width: 100px;'),
                    'filter' => CHtml::dropDownList(
                        'aktif',
                        $model->aktif,
                        array(
                            '1' => 'Aktif',
                            '0' => 'Tidak Aktif',
                        ),
                        array('empty' => '-- Pilih --')
                    )
                ),
                array(
                    'header' => 'Lihat',
                    'class' => 'bootstrap.widgets.BootButtonColumn',
                    'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                    'template' => '{view}',
                    'buttons' => array(
                        'view' => array(
                            'url' => 'Yii::app()->createUrl("' . Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/view",array("id"=>$data->alternatifdx_id))',
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
                            'url' => 'Yii::app()->createUrl("' . Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/update",array("id"=>$data->alternatifdx_id))',
                        ),
                    ),
                ),
                array(
                    'header' => 'Hapus',
                    'type' => 'raw',
                    'value' => '($data->alternatifdx_aktif)?CHtml::link("<i class=\'icon-form-silang\'></i> ","javascript:removeTemporary($data->alternatifdx_id)",array("id"=>"$data->alternatifdx_id","rel"=>"tooltip","title"=>"Menonaktifkan Alternatif Diagnosa"))." ".CHtml::link("<i class=\'icon-form-sampah\'></i> ", "javascript:deleteRecord($data->alternatifdx_id)",array("id"=>"$data->alternatifdx_id","rel"=>"tooltip","title"=>"Hapus Alternatif Diagnosa")):CHtml::link("<i class=\'icon-trash\'></i> ", "javascript:deleteRecord($data->alternatifdx_id)",array("id"=>"$data->alternatifdx_id","rel"=>"tooltip","title"=>"Hapus Alternatif Diagnosa"));',
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
        ));
        ?>
    </div>
    <?php
    echo CHtml::link(
        Yii::t('mds', '{icon} Tambah Alternatif Diagnosa', array('{icon}' => '<i class="icon-plus icon-white"></i>')),
        $this->createUrl(Yii::app()->controller->id . '/create', array('modul_id' => Yii::app()->session['modul_id'])),
        array('title' => 'Tambah alternatif diagnosa', 'class' => 'btn btn-danger',)
    );
    echo CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PRINT\')'));
    echo CHtml::htmlButton(Yii::t('mds', '{icon} PDF', array('{icon}' => '<i class="entypo-book"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PDF\')'));
    echo CHtml::htmlButton(Yii::t('mds', '{icon} Excel', array('{icon}' => '<i class="entypo-doc-text"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'EXCEL\')'));
    $content = $this->renderPartial('sistemAdministrator.views/tips/master', array(), true);
    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
    $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
    $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
    $urlPrint = Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/print');
    $url =  Yii::app()->createAbsoluteUrl($module . '/' . $controller);

    $js = <<< JSCRIPT
         function cekForm(obj)
{
    $("#bataskarakteristik-k-search :input[name='"+ obj.name +"']").val(obj.value);
}
function print(caraPrint)
{
    window.open("${urlPrint}/"+$('#bataskarakteristik-k-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
JSCRIPT;
    Yii::app()->clientScript->registerScript('print', $js, CClientScript::POS_HEAD);
    ?>
</div>
<script>
    function removeTemporary(id) {
        var url = '<?php echo $url . "/removeTemporary"; ?>';
        myConfirm("Anda yakin akan menonaktifkan data ini untuk sementara?", "Perhatian!", function(r) {
            if (r) {
                $.post(url, {
                        id: id
                    },
                    function(data) {
                        if (data.status == 'proses_form') {
                            $.fn.yiiGridView.update('bataskarakteristik-m-grid');
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
                            $.fn.yiiGridView.update('bataskarakteristik-m-grid');
                        } else {
                            myAlert('Data gagal dihapus!')
                        }
                    }, "json");
            }
        });
    }

    $(document).ready(function() {
        $("input[name='SAAlternatifdxM[alternatifdx_nama]']").focus();
    });
</script>