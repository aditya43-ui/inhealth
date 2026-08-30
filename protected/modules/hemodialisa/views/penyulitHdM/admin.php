<?php
$this->breadcrumbs = array(
    'Penyulit' => array('admin'),
    'Pengaturan',
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('penyulit-hd-m-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<div class="panel panel-gradient">  
    <div class="panel-heading">
        <div class="panel-title">Master <b>Penyulit HD</b></div>				
    </div> 
    <div class="panel-body">
        <?php echo CHtml::link('Pencarian lanjut', '#', array('class' => 'search-button btn')); ?>
        <div class="cari-lanjut search-form" style="display:none">
            <?php
            $this->renderPartial('_search', array(
                'model' => $model,
            ));
            ?>
        </div><!-- search-form --><br><br>

        <div class="panel panel-success"> 
            <div class="panel-heading">  
                <div class="panel-title">Tabel <b>Penyulit HD</b></div>
            </div>   
            <div style="margin: 10px 20px;">
                <?php
                $this->widget('ext.bootstrap.widgets.BootGridView', array(
                    'id' => 'penyulit-hd-m-grid',
                    'dataProvider' => $model->search(),
                    'filter' => $model,
                    'template' => "{summary}\n{items}\n{pager}",
                    'itemsCssClass' => 'table table-striped table-condensed',
                    'columns' => array(
                        array(
                            'header' => 'No.',
                            'value' => '($this->grid->dataProvider->pagination) ? 
						($this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1)
						: ($row+1)',
                            'type' => 'raw',
                            'htmlOptions' => array('style' => 'text-align:right; width: 50px;'),
                        ),
                        'penyulit_hd_nama',
                        'penyulit_hd_namalainnya',
                        array(
                            'header' => Yii::t('zii', 'View'),
                            'class' => 'bootstrap.widgets.BootButtonColumn',
                            'template' => '{view}',
                            'buttons' => array(
                                'view' => array(
                                    'options' => array('title' => 'Lihat Penyulit HD'),
                                ),
                            ),
                            'htmlOptions' => array('style' => 'text-align: center; width:50px'),
                        ),
                        array(
                            'header' => Yii::t('zii', 'Update'),
                            'class' => 'bootstrap.widgets.BootButtonColumn',
                            'template' => '{update}',
                            'buttons' => array(
                                'update' => array
                                    (
                                    //'visible' => 'Yii::app()->controller->checkAccess(array("action"=>Params::DEFAULT_UPDATE))',
                                    'options' => array('title' => 'Ubah Penyulit HD'),
                                ),
                            ),
                            'htmlOptions' => array('style' => 'text-align: center; width:50px'),
                        ),
                        array(
                            'header' => Yii::t('zii', 'Delete'),
                            'class' => 'bootstrap.widgets.BootButtonColumn',
                            'template' => '{delete}',
                            'buttons' => array(
                                'delete' => array(
                                    'label' => "<i class='glyphicon glyphicon-ok'></i> ",
                                    'options' => array('title' => Yii::t('mds', 'Hapus')),
                                    'url' => 'Yii::app()->createUrl("' . Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/delete",array("id"=>$data->penyulit_hd_id))',
                                    'click' => 'function(){deleteRecord(this);return false;}',
                                //'visible' => 'Yii::app()->controller->checkAccess(array("action"=>Params::DEFAULT_DELETE))',
                                ),
                            ),
                            'htmlOptions' => array('style' => 'text-align: center; width:50px'),
                        ),
                    ),
                ));

                $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
                $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
                $url = Yii::app()->createAbsoluteUrl($module . '/' . $controller);
                ?>
            </div>
            <div style="margin: 20px;">
                <?php
                echo CHtml::link(Yii::t('mds', '{icon} Tambah Penyulit HD', array('{icon}' => '<i class="icon-plus icon-white"></i>')), $this->createUrl('create', array('modul_id' => Yii::app()->session['modul_id'])), array('class' => 'btn btn-danger')) . "&nbsp&nbsp";
                echo CHtml::htmlButton(Yii::t('mds', '{icon} PDF', array('{icon}' => '<i class="icon-book icon-white"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PDF\')')) . "&nbsp&nbsp";
                echo CHtml::htmlButton(Yii::t('mds', '{icon} Excel', array('{icon}' => '<i class="icon-pdf icon-white"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'EXCEL\')')) . "&nbsp&nbsp";
                echo CHtml::htmlButton(Yii::t('mds', '{icon} Cetak', array('{icon}' => '<i class="icon-print icon-white"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PRINT\')')) . "&nbsp&nbsp";
                $content = $this->renderPartial('hemodialisa.views.tips.master', array(), true);
                $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
                $urlPrint = $this->createUrl('print');

                $js = <<< JSCRIPT
function print(caraPrint)
{
    window.open("${urlPrint}/"+$('#resephd-m-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
JSCRIPT;
                Yii::app()->clientScript->registerScript('print', $js, CClientScript::POS_HEAD);
                ?>

            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    function removeTemporary(id) {
        var url = '<?php echo $url . "/removeTemporary"; ?>';
        myConfirm("Yakin akan menonaktifkan data ini untuk sementara?", "Perhatian!", function (r) {
            if (r) {
                $.post(url, {id: id},
                        function (data) {
                            if (data.status == 'proses_form') {
                                $.fn.yiiGridView.update('penyulit-hd-m-grid');
                            } else {
                                myAlert('Data Gagal di Nonaktifkan')
                            }
                        }, "json");
            }
        });
    }

//    function deleteRecord(id) {
//        var id = id;
//        var url = '<?php echo $url . "/delete"; ?>';
//        myConfirm("Apakah anda yakin akan Menghapus data ini?", "Perhatian!", function (r) {
//            //myAlert('Data gagal dihapus karena data digunakan oleh Master Kecamatan.');
//            if (r) {
//                          //  myAlert('Data gagal dihapus karena data digunakan oleh Master Kecamatan.');
//                $.post(url, {id: id},
//                        function (data) {
//                            if (data.status == 'proses_form') {                                // myAlert('Data gagal dihapus karena data digunakan oleh Master Kecamatan.2');
//                                $.fn.yiiGridView.update('penyulit-hd-m-grid');
//                            } else {
//                                myAlert('Data gagal dihapus karena data digunakan oleh Master Kecamatan.');
//                            }
//                        }, "json");
//            }
//        });
//    }
    function deleteRecord(obj) {
        myConfirm("Apakah anda yakin akan menghapus data ini?", "Perhatian!",
                function (r) {
                    if (r) {
                        $.ajax({
                            type: 'GET',
                            url: obj.href,
                            data: {}, //
                            dataType: "json",
                            success: function (data) {
                                $.fn.yiiGridView.update('penyulit-hd-m-grid');
                                if (data.sukses > 0) {
                                   // myAlert('Data Berhasil Disimpan');

                                } else {
                                    myAlert('Data tidak dapat dihapus karena sudah digunakan di transaksi lain.');
                                }
                            },
                            error: function (jqXHR, textStatus, errorThrown) {
                                myAlert('Data tidak dapat dihapus karena sudah digunakan di transaksi lain.');
                                console.log(errorThrown);
                            }
                        });
                    }
                }
        );
        return false;
    }
</script>
