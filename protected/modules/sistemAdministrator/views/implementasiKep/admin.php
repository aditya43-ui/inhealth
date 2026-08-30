 <div class="panel panel-gradient">
     <div class="panel-heading">
         <div class="panel-title">
             <i class="fas fa-layer-group"></i> Pengaturan <b>SIKI</b>
         </div>
     </div>
     <div class="panel-body">
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
	$.fn.yiiGridView.update('implementasi-m-grid', {
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
         <div class="panel panel-success">
             <div class="panel-heading">
                 <div class="panel-title">
                     <i class="entypo-credit-card"></i> Tabel <b>SIKI</b>
                 </div>
             </div>
             <div class="panel-body table-responsive">
                 <?php
                    if (isset($_GET['sukses'])) {
                        Yii::app()->user->setFlash('success', '<b>Berhasil!</b> Data berhasil disimpan.');
                    }
                    ?>
                 <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
                 <?php
                    $this->widget('ext.bootstrap.widgets.BootGridView', array(
                        'id' => 'implementasi-m-grid',
                        'dataProvider' => $model->search(),
                        'replaceUrl' => true,
                        'filter' => $model,
                        'template' => "{summary}\n{items}\n{pager}",
                        'itemsCssClass' => 'table table-striped table-bordered table-condensed',
                        'columns' => array(
                            array(
                                'header' => 'Intervensi Keperawatan',
                                'name' => 'jenisintervensi_id',
                                'value' => 'isset($data->implementasikep->jenisintervensi->jenisintervensi_nama) ? $data->implementasikep->jenisintervensi->jenisintervensi_nama : " - "',
                                'filter' => Chtml::activeDropDownList($model, 'jenisintervensi_id', Chtml::listData(JenisintervensiM::model()->findAll("jenisintervensi_aktif = TRUE ORDER BY jenisintervensi_nama ASC"), 'jenisintervensi_id', 'jenisintervensi_nama'), array('empty' => '-- Pilih --'))
                            ),
                            array(
                                'header' => 'Jenis Tindakan Intervensi',
                                'name' => 'jenistindakan',
                                'value' => 'isset($data->implementasikep->jenistindakan) ? $data->implementasikep->jenistindakan : " - "',
                                'filter' => Chtml::activeDropDownList($model, 'jenistindakan', LookupM::getItems('jenistindakanintervensi'), array('empty' => '-- Pilih --'))
                            ),
                            array(
                                'header' => 'Indikator',
                                'name' => 'indikatorimplkepdet_indikator',
                                'value' => 'isset($data->indikatorimplkepdet_indikator) ? $data->indikatorimplkepdet_indikator : " - "',
                            ),
                            array(
                                'header' => 'Status',
                                'htmlOptions' => array('style' => 'text-align: center; width: 100px;'),
                                'value' => '($data->indikatorimplkepdet_aktif == true ? \'Aktif\': \'Tidak Aktif\')',

                            ),
                            array(
                                'header' => 'Lihat',
                                'class' => 'bootstrap.widgets.BootButtonColumn',
                                'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                                'template' => '{view}',
                                'buttons' => array(
                                    'view' => array(
                                        'url' => 'Yii::app()->createUrl("' . Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/view",array("id"=>$data->implementasikep_id))',
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
                                        'url' => 'Yii::app()->createUrl("' . Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/update",array("id"=>$data->implementasikep_id))',
                                    ),
                                ),
                            ),
                            array(
                                'header' => 'Hapus',
                                'type' => 'raw',
                                'value' => function ($data) {
                                    if ($data->indikatorimplkepdet_aktif == true) {
                                        echo CHtml::link("<i class='icon-form-silang'></i> ", "javascript:removeTemporary($data->indikatorimplkepdet_id)", array("id" => "$data->indikatorimplkepdet_id", "rel" => "tooltip", "title" => "Menonaktifkan Implementasi")) . ' ' . CHtml::link("<i style='font-size: 14px;' class='icon-form-sampah'></i>", "javascript:deleteRecord($data->indikatorimplkepdet_id)", array("id" => "$data->indikatorimplkepdet_id", "title" => "Hapus Implementasi"));
                                    } else {
                                        echo CHtml::link("<i class='glyphicon glyphicon-check'></i> ", "javascript:aktifkan($data->indikatorimplkepdet_id)", array("id" => "$data->indikatorimplkepdet_id", "title" => "Mengaktifkan Implementasi")) . ' ' . CHtml::link("<i style='font-size: 14px;' class='icon-form-sampah'></i>", "javascript:deleteRecord($data->indikatorimplkepdet_id)", array("id" => "$data->indikatorimplkepdet_id", "title" => "Hapus Implementasi"));
                                    }
                                },
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
         </div>

         <div class="form-actions">
             <?php
                echo CHtml::link(
                    Yii::t('mds', '{icon} Tambah SIKI', array('{icon}' => '<i class="icon-plus icon-white"></i>')),
                    $this->createUrl(Yii::app()->controller->id . '/create', array('modul_id' => Yii::app()->session['modul_id'])),
                    array('title' => 'Tambah SIKI', 'class' => 'btn btn-danger')
                );
                echo CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PRINT\')'));
                echo CHtml::htmlButton(Yii::t('mds', '{icon} PDF', array('{icon}' => '<i class="entypo-book"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PDF\')'));
                echo CHtml::htmlButton(Yii::t('mds', '{icon} Excel', array('{icon}' => '<i class="entypo-doc-text"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'EXCEL\')'));
                $tips = array(
                    '0' => 'lihat',
                    '1' => 'ubah',
                    '2' => 'nonaktif',
                    '3' => 'hapus',
                    '4' => 'masterPDF',
                    '5' => 'masterEXCEL',
                    '6' => 'masterPRINT',
                    '7' => 'pencarianlanjut',
                    '8' => 'cari2',
                );
                $content = $this->renderPartial('sistemAdministrator.views.tips.detailTips', array('tips' => $tips), true);
                $this->widget('UserTips', array('content' => $content));
                $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
                $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
                $urlPrint = Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/print');
                $url =  Yii::app()->createAbsoluteUrl($module . '/' . $controller);

                $js = <<< JSCRIPT
         function cekForm(obj)
{
    $("#implementasi-k-search :input[name='"+ obj.name +"']").val(obj.value);
}
function print(caraPrint)
{
    window.open("${urlPrint}/"+$('#implementasi-k-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
JSCRIPT;
                Yii::app()->clientScript->registerScript('print', $js, CClientScript::POS_HEAD);
                ?>
         </div>
     </div>
 </div>

 <script>
     function removeTemporary(id) {
         var url = '<?php echo $url . "/removeTemporary"; ?>';
         myConfirm('Yakin akan menonaktifkan data ini untuk sementara?', 'Perhatian!', function(r) {
             if (r) {
                 $.post(url, {
                         id: id
                     },
                     function(data) {
                         if (data.status == 'proses_form') {
                             $.fn.yiiGridView.update('implementasi-m-grid');
                         } else {
                             myAlert('Data gagal dinonaktifkan!')
                         }
                     }, "json");
             }
         });
     }

     function aktifkan(id) {
         var url = '<?php echo $url . "/aktifkan"; ?>';
         myConfirm('Yakin akan menonaktifkan data ini untuk sementara?', 'Perhatian!', function(r) {
             if (r) {
                 $.post(url, {
                         id: id
                     },
                     function(data) {
                         if (data.status == 'proses_form') {
                             $.fn.yiiGridView.update('implementasi-m-grid');
                         } else {
                             myAlert('Data Gagal di Aktifkan')
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
                             $.fn.yiiGridView.update('implementasi-m-grid');
                         } else {
                             myAlert('Data gagal dihapus!')
                         }
                     }, "json");
             }
         });
     }

     $(document).ready(function() {
         $("input[name='SAFaktorrisikodetM[faktorrisiko_nama]']").focus();
     });
 </script>