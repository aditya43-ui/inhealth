<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="fas fa-layer-group"></i> Pengaturan <b>Pekerjaan</b>
        </div>
    </div>
    <div class="panel-body">
        <?php
        $this->breadcrumbs = array(
            'Pppekerjaan Ms' => array('index'),
            'Manage',
        );

        Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
    $('.search-form').toggle();
    $('#" . CHtml::activeId($model, 'pekerjaan_nama') . "').focus();
    return false;
});
$('.search-form form').submit(function(){
    $.fn.yiiGridView.update('pppekerjaan-m-grid', {
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
                    <i class="entypo-credit-card"></i> Tabel <b>Pekerjaan</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <!--<legend class="rim">Tabel Pekerjaan</legend>-->
                <?php
                $this->widget('ext.bootstrap.widgets.BootGridView', array(
                    'id' => 'pppekerjaan-m-grid',
                    'dataProvider' => $model->search(),
                    'filter' => $model,
                    'template' => "{summary}\n{items}{pager}",
                    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
                    'columns' => array(
                        ////'pekerjaan_id',
                        array(
                            'name' => 'pekerjaan_id',
                            'value' => '$data->pekerjaan_id',
                            'filter' => false,
                        ),
                        'pekerjaan_nama',
                        'pekerjaan_namalainnya',
                        array(
                            'header' => 'Status',
                            'name' => 'pekerjaan_aktif',
                            //                    'filter' => array(
                            //                                "0","1"),
                            'filter' => false,
                            'value' => '($data->pekerjaan_aktif == 1 ) ? "Aktif" : "Tidak Aktif"',
                            'htmlOptions' => array('style' => 'text-align: center; width: 100px;'),
                            /*
                                  'name'=>'pekerjaan_aktif',
                                  'header' => 'Status',
                                  'filter'
                                  'value'=>'($data->pekerjaan_aktif == 1 ) ? "Aktif" : "Tidak Aktif"',
                                  'htmlOptions'=>array('style'=>'text-align:center;'),
                                 */
                        ),
                        /*
                                  array(
                                  'name' => 'jeniskelamin',
                                  'filter' => LookupM::getItems('jeniskelamin'),
                                  'value' => '$data->jeniskelamin',
                                  ),

                                 */

                        //'pekerjaan_aktif',
                        //                array(
                        //                        'header'=>'Aktif',
                        //                        'class'=>'CCheckBoxColumn',     
                        //                        'selectableRows'=>0,
                        //                        'id'=>'rows',
                        //                        'checked'=>'$data->pekerjaan_aktif',
                        //                ),
                        array(
                            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                            'header' => 'Lihat',
                            'type' => 'raw',
                            'value' => 'CHtml::Link("<i class=icon-form-lihat></i>",Yii::app()->createUrl("' . Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/view",array("id"=>$data->pekerjaan_id)),
                                 array("class"=>"view",
                                       "rel"=>"tooltip",
                                       "title"=>"Lihat Pekerjaan",
                         ))',
                        ),
                        array(
                            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                            'header' => 'Ubah',
                            'type' => 'raw',
                            'value' => 'CHtml::Link("<i class=icon-form-ubah></i>",Yii::app()->createUrl("' . Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/update",array("id"=>$data->pekerjaan_id)),
                                 array("class"=>"update",
                                       "rel"=>"tooltip",
                                       "title"=>"Ubah Pekerjaan",
                         ))',
                        ),
                        array(
                            'header' => 'Hapus',
                            'type' => 'raw',
                            'value' => '($data->pekerjaan_aktif)?CHtml::link("<i class=\'icon-form-silang\'></i> ","javascript:removeTemporary($data->pekerjaan_id)",array("id"=>"$data->pekerjaan_id","rel"=>"tooltip","title"=>"Menonaktifkan Pekerjaan"))." ".CHtml::link("<i class=\'icon-form-sampah\'></i> ", "javascript:deleteRecord($data->pekerjaan_id)",array("id"=>"$data->pekerjaan_id","rel"=>"tooltip","title"=>"Hapus Pekerjaan")):CHtml::link("<i class=\'icon-form-sampah\'></i> ", "javascript:deleteRecord($data->pekerjaan_id)",array("id"=>"$data->pekerjaan_id","rel"=>"tooltip","title"=>"Hapus Pekerjaan"));',
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
                          <table>
                          <tr>
                          <td width="13%"><?php echo CHtml::link(Yii::t('mds', '{icon} Tambah Pekerjaan', array('{icon}'=>'<i class="icon-plus icon-white"></i>')), $this->createUrl('/pendaftaranPenjadwalan/pekerjaanM/create',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success'));?></td>
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
            echo CHtml::link(Yii::t('mds', '{icon} Tambah Pekerjaan', array('{icon}' => '<i class="icon-plus icon-white"></i>')), $this->createUrl('/pendaftaranPenjadwalan/pekerjaanM/create', array('modul_id' => Yii::app()->session['modul_id'])), array('class' => 'btn btn-danger'));
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
    $("#pppekerjaan-m-search :input[name='"+ obj.name +"']").val(obj.value);
}     
        
function print(caraPrint)
{
    window.open("${urlPrint}/"+$('#pppekerjaan-m-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
JSCRIPT;
            Yii::app()->clientScript->registerScript('print', $js, CClientScript::POS_HEAD);
            ?>
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
                                        $.fn.yiiGridView.update('pppekerjaan-m-grid');
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
                                        $.fn.yiiGridView.update('pppekerjaan-m-grid');
                                    } else {
                                        myAlert('Data gagal dihapus!')
                                    }
                                }, "json");
                        }
                    });
                }
            </script>
        </div>
    </div>
</div>