<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="fas fa-layer-group"></i> Pengaturan <b>Pendidikan</b>
        </div>
    </div>
    <div class="panel-body">
        <?php // $this->renderPartial('_tab'); 
        ?>
        <?php
        $this->breadcrumbs = array(
            'Pppendidikan Ms' => array('index'),
            'Manage',
        );

        Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
    $('#PPPendidikanM_pendidikan_nama').focus();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('pppendidikan-m-grid', {
		data: $(this).serialize()
	});
	return false;
});
");

        $this->widget('bootstrap.widgets.BootAlert');
        ?>
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
                    <i class="entypo-credit-card"></i> Tabel <b>Pendidikan</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <!--<legend class="rim">Table Pendidikan</legend>-->
                <?php
                $this->widget('ext.bootstrap.widgets.BootGridView', array(
                    'id' => 'pppendidikan-m-grid',
                    'dataProvider' => $model->search(),
                    'filter' => $model,
                    'template' => "{summary}\n{items}{pager}",
                    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
                    'columns' => array(
                        ////'pendidikan_id',
                        array(
                            'name' => 'pendidikan_id',
                            'value' => '$data->pendidikan_id',
                            'filter' => false,
                        ),
                        'pendidikan_nama',
                        'pendidikan_namalainnya',
                        array(
                            'header' => 'Status',
                            'value' => '($data->pendidikan_aktif == 1 ) ? "Aktif" : "Tidak Aktif"',
                            'htmlOptions' => array('style' => 'text-align: center; width: 100px;'),
                        ),
                        array(
                            'header' => 'Lihat',
                            'type' => 'raw',
                            'value' => 'CHtml::Link("<i class=icon-form-lihat></i>",Yii::app()->createUrl("' . Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/view",array("id"=>$data->pendidikan_id)),
                                 array("class"=>"view",
                                       "rel"=>"tooltip",
                                       "title"=>"Lihat Pendidikan",
                         ))',
                            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                        ),
                        array(
                            'header' => 'Ubah',
                            'type' => 'raw',
                            'value' => 'CHtml::Link("<i class=icon-form-ubah></i>",Yii::app()->createUrl("' . Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/update",array("id"=>$data->pendidikan_id)),
                                 array("class"=>"update",
                                       "rel"=>"tooltip",
                                       "title"=>"Ubah Pendidikan",
                         ))',
                            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                        ),
                        array(
                            'header' => 'Hapus',
                            'type' => 'raw',
                            'value' => '($data->pendidikan_aktif)?CHtml::link("<i class=\'icon-form-silang\'></i> ","javascript:removeTemporary($data->pendidikan_id)",array("id"=>"$data->pendidikan_id","rel"=>"tooltip","title"=>"Menonaktifkan Pendidikan"))." ".CHtml::link("<i class=\'icon-form-sampah\'></i> ", "javascript:deleteRecord($data->pendidikan_id)",array("id"=>"$data->pendidikan_id","rel"=>"tooltip","title"=>"Hapus Pendidikan")):CHtml::link("<i class=\'entypo-trash\'></i> ", "javascript:deleteRecord($data->pendidikan_id)",array("id"=>"$data->pendidikan_id","rel"=>"tooltip","title"=>"Hapus Pendidikan"));',
                            'htmlOptions' => array('style' => 'text-align: center; width: 100px;'),
                        ),
                    ),
                    'afterAjaxUpdate' => 'function(id, data){
            jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});
            $("table").find("input[type=text]").each(function(){
                cekForm(this);
            })
        }',
                ));
                ?>

                <?php /*
                          //Apabila menggunakan tombol "Print" jenis Button Group
                          <table>
                          <tr>
                          <td width="13%"><?php echo CHtml::link(Yii::t('mds', '{icon} Tambah Pendidikan', array('{icon}'=>'<i class="icon-plus icon-white"></i>')), $this->createUrl('/pendaftaranPenjadwalan/pendidikanM/create',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success'));?></td>
                          <td width="8%"><?php $this->widget('bootstrap.widgets.BootButtonGroup', array(
                          'type'=>'info', // '', 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
                          'buttons'=>array(
                          array('label'=>'Print', 'icon'=>'entypo-print', 'url'=>'#', 'htmlOptions'=>array('onclick'=>'print(\'PRINT\')')),
                          array('label'=>'', 'items'=>array(
                          array('label'=>'PDF', 'icon'=>'icon-book', 'url'=>'', 'itemOptions'=>array('onclick'=>'print(\'PDF\')')),
                          array('label'=>'Excel','icon'=>'icon-pdf', 'url'=>'', 'itemOptions'=>array('onclick'=>'print(\'EXCEL\')')),
                          array('label'=>'Grafik','icon'=>'entypo-print', 'url'=>'', 'itemOptions'=>array('onclick'=>'print(\'GRAFIK\')')),
                          )),
                          ),
                          //        'htmlOptions'=>array('class'=>'btn')
                          ));?>
                          </td>
                          <td><?php $content = $this->renderPartial('../tips/master',array(),true);
                          $this->widget('UserTips',array('type'=>'transaksi','content'=>$content));
                          $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
                          $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
                          $urlPrint=  Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/print');
                          $url=  Yii::app()->createAbsoluteUrl($module.'/'.$controller); ?>   </td>
                          </tr>
                          </table>
                         */ ?>
            </div>
        </div>

        <div class="form-actions">
            <?php
            echo CHtml::link(
                Yii::t('mds', '{icon} Tambah Pendidikan', array('{icon}' => '<i class="icon-plus icon-white"></i>')),
                $this->createUrl('/pendaftaranPenjadwalan/pendidikanM/create', array('modul_id' => Yii::app()->session['modul_id'])),
                array('title' => 'Tambah pendidikan', 'class' => 'btn btn-danger')
            );
            echo CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PRINT\')'));
            echo CHtml::htmlButton(Yii::t('mds', '{icon} PDF', array('{icon}' => '<i class="entypo-book"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PDF\')'));
            echo CHtml::htmlButton(Yii::t('mds', '{icon} Excel', array('{icon}' => '<i class="entypo-doc-text"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'EXCEL\')'));
            $content = $this->renderPartial('../tips/master', array(), true);
            $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
            $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
            $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
            $urlPrint = Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/print');
            $url = Yii::app()->createAbsoluteUrl($module . '/' . $controller);

            $js = <<< JSCRIPT
          function cekForm(obj)
{
    $("#pppendidikan-m-search :input[name='"+ obj.name +"']").val(obj.value);
}     
        
function print(caraPrint)
{
    window.open("${urlPrint}/"+$('#pppendidikan-m-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
JSCRIPT;
            Yii::app()->clientScript->registerScript('print', $js, CClientScript::POS_HEAD);
            ?>
        </div>
    </div>
</div>

<script type="text/javascript">
    function removeTemporary(id) {
        var url = '<?php echo $url . "/removeTemporary"; ?>';
        myConfirm("Anda yakin akan menonaktifkan data ini untuk sementara?", "Perhatian!", function(r) {
            if (r) {
                $.post(url, {
                        id: id
                    },
                    function(data) {
                        if (data.status == 'proses_form') {
                            $.fn.yiiGridView.update('pppendidikan-m-grid');
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
                            $.fn.yiiGridView.update('pppendidikan-m-grid');
                        } else {
                            myAlert('Data gagal dihapus!')
                        }
                    }, "json");
            }
        });
    }
</script>