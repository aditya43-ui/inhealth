<?php
$this->breadcrumbs = array(
    'Pajak' => array('index'),
    'Manage',
);
?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="glyphicon glyphicon-file"></i> Pengaturan <b>Master Pajak</b>
        </div>
    </div>
    <div class="panel-body">
        <?php

        Yii::app()->clientScript->registerScript('search', "
        $('.search-button').click(function(){
                $('.search-form').toggle();
                return false;
        });
        $('.search-form form').submit(function(){
                $.fn.yiiGridView.update('pajak-m-grid', {
                        data: $(this).serialize()
                });
                return false;
        });
        ");
        $this->widget('bootstrap.widgets.BootAlert');
        ?>
        <?php echo CHtml::link(Yii::t('mds', '{icon} Advanced Search', array('{icon}' => '<i class="icon-white icon-accordion"></i>')), '#', array('class' => 'search-button btn')); ?>
        <div class="cari-lanjut search-form">
            <?php $this->renderPartial($this->path_view . '_search', array(
                'model' => $model,
            )); ?>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Pajak</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php $this->widget('ext.bootstrap.widgets.BootGridView', array(
                    'id' => 'pajak-m-grid',
                    'dataProvider' => $model->searchMaster(),
                    'filter' => $model,
                    'template' => "{summary}\n{items}\n{pager}",
                    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
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
                            'header' => 'Nama Pajak',
                            'name' => 'pajak_nama',
                            'value' => '$data->pajak_nama',
                        ),
                        array(
                            'header' => 'Nama Lain Pajak',
                            'name' => 'pajak_namalain',
                            'value' => '$data->pajak_namalain',
                        ),
                        array(
                            'header' => 'Nama Rekening',
                            'name' => 'rekening5_nama',
                            'value' => '(isset($data->rekening5)?$data->rekening5->nmrekening5:"")',
                        ),
                        array(
                            'header' => 'Keterangan',
                            'name' => 'keterangan',
                            'value' => '$data->keterangan',
                        ),
                        array(
                            'header' => 'Status',
                            'htmlOptions' => array('style' => 'text-align: center; width: 100px;'),
                            'value' => '($data->pajak_aktif == true ? \'Aktif\': \'Tidak Aktif\')'
                        ),
                        array(
                            'header' => 'Lihat',
                            'class' => 'bootstrap.widgets.BootButtonColumn',
                            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                            'template' => '{view}',
                            'buttons' => array(
                                'view' => array(
                                    'url' => 'Yii::app()->createUrl("' . Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/view",array("id"=>"$data->pajak_id","tab"=>"' . (isset($_GET['tab']) ? $_GET['tab'] : '') . '"))',
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
                                    'url' => 'Yii::app()->createUrl("' . Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/update",array("id"=>"$data->pajak_id","tab"=>"' . (isset($_GET['tab']) ? $_GET['tab'] : '') . '"))',
                                ),
                            ),
                        ),
                        array(
                            'header' => 'Hapus',
                            'type' => 'raw',
                            'value' => '($data->pajak_aktif)?CHtml::link("<i class=\'' . MyIcon::getIcons('batal') . '\'></i> ","javascript:removeTemporary($data->pajak_id)",array("id"=>"$data->pajak_id","rel"=>"tooltip","title"=>"Menonaktifkan"))." ".CHtml::link("<i class=\'' . MyIcon::getIcons('hapus') . '\'></i> ", "javascript:deleteRecord($data->pajak_id)",array("id"=>"$data->pajak_id","rel"=>"tooltip","title"=>"Hapus")):CHtml::link("<i class=\'' . MyIcon::getIcons('hapus') . '\'></i> ", "javascript:deleteRecord($data->pajak_id)",array("id"=>"$data->pajak_id","rel"=>"tooltip","title"=>"Hapus"));',
                            'htmlOptions' => array('style' => 'text-align: center; width: 100px;'),
                        ),
                        //                                array(
                        //                                        'header'=>Yii::t('zii','Delete'),
                        //                                        'class'=>'bootstrap.widgets.BootButtonColumn',
                        //                                        'template'=>'{remove} {delete}',
                        //                                        'buttons'=>array(
                        //                                                'remove' => array (
                        //                                                                'label'=>"<i class='icon-form-silang'></i>",
                        //                                                                'options'=>array('title'=>Yii::t('mds','Remove Temporary')),
                        //                                                                'url'=>'Yii::app()->createUrl("'.Yii::app()->controller->module->id.'/'.Yii::app()->controller->id.'/nonActive",array("id"=>$data->pajak_id))',
                        //                                                                'click'=>'function(){nonActive(this);return false;}',
                        //                                                                'visible'=>'Yii::app()->controller->checkAccess(array("action"=>"nonActive"))',
                        //                                                ),
                        //                                                'delete'=> array(
                        //                                                                'visible'=>'Yii::app()->controller->checkAccess(array("action"=>Params::DEFAULT_DELETE))',
                        //                                                ),
                        //                                        )
                        //                                ),
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

        <div class="form-actions">
            <?php
            echo CHtml::link(
                Yii::t('mds', '{icon} Tambah Master Pajak', array('{icon}' => '<i class="' . MyIcon::getIcons('tambah-baris') . '"></i>')),
                $this->createUrl('create', array('modul_id' => Yii::app()->session['modul_id'], 'tab' => isset($_GET['tab']) ? $_GET['tab'] : '')),
                array('title' => 'Tambah master pajak', 'class' => 'btn btn-danger')
            );
            echo CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PRINT\')'));
            echo CHtml::htmlButton(Yii::t('mds', '{icon} PDF', array('{icon}' => '<i class="entypo-book"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PDF\')'));
            echo CHtml::htmlButton(Yii::t('mds', '{icon} Excel', array('{icon}' => '<i class="entypo-doc-text"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'EXCEL\')'));
            $content = $this->renderPartial($this->path_view . '/tips/master', array(), true);
            $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
            $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
            $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
            $urlPrint = $this->createUrl('print');
            $url =  Yii::app()->createAbsoluteUrl($module . '/' . $controller);

            $js = <<< JSCRIPT
function cekForm(obj)
{
    $("#pajak-m-search :input[name='"+ obj.name +"']").val(obj.value);
}
function print(caraPrint)
{
    window.open("${urlPrint}/"+$('#pajak-m-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
JSCRIPT;
            Yii::app()->clientScript->registerScript('print', $js, CClientScript::POS_HEAD);
            ?>
        </div>
    </div>
</div>

<script type="text/javascript">
    function removeTemporary(id) {
        var url = '<?php echo $url . "/NonActive"; ?>';
        myConfirm("Apakah Anda yakin ingin menonaktifkan data ini untuk sementara?", 'Perhatian!', function(r) {
            if (r) {
                $.post(url, {
                        id: id
                    },
                    function(data) {
                        if (data.sukses > 0) {
                            myAlert('Data Berhasil Di Non Aktifkan');
                            $.fn.yiiGridView.update('pajak-m-grid');
                        } else {
                            myAlert('Data gagal dinonaktifkan!');
                        }
                    }, "json");
            }
        });
    }

    function deleteRecord(id) {
        var id = id;
        var url = '<?php echo $url . "/delete"; ?>';
        myConfirm("Apakah Akan yakin ingin menghapus item ini?", 'Perhatian!', function(r) {
            if (r) {
                $.post(url, {
                        id: id
                    },
                    function(data) {
                        if (data.warning) {
                            myAlert(data.pesan);
                        } else {
                            if (data.status == 'proses_form') {
                                myAlert('Data Berhasil Di Hapus');
                                $.fn.yiiGridView.update('pajak-m-grid');
                            } else {
                                myAlert('Data gagal dihapus!');
                            }
                        }
                    }, "json");
            }
        });
    }
</script>