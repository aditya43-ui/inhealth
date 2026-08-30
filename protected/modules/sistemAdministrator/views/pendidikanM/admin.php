<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="fas fa-layer-group"></i> Pengaturan <b>Pendidikan</b>
        </div>
    </div>
    <div class="panel-body">
        <?php
        $this->breadcrumbs = array(
            'Sapendidikan Ms' => array('index'),
            'Manage',
        );

        $arrMenu = array();
        //                array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Pendidikan ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master')));
        //                array_push($arrMenu,array('label'=>Yii::t('mds','List').' Pendidikan', 'icon'=>'list', 'url'=>array('index'))) ;
        //                array_push($arrMenu,array('label'=>Yii::t('mds','Create').' Pendidikan', 'icon'=>'file', 'url'=>array('create')));

        $this->menu = $arrMenu;

        Yii::app()->clientScript->registerScript('search', "
    $('.search-button').click(function(){
            $('.search-form').toggle();
      $('#SAPendidikanM_pendidikan_nama').focus();
            return false;
    });
    $('.search-form form').submit(function(){
            $.fn.yiiGridView.update('sapendidikan-m-grid', {
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

                <?php
                $this->widget('ext.bootstrap.widgets.BootGridView', array(
                    'id' => 'sapendidikan-m-grid',
                    'dataProvider' => $model->search(),
                    'filter' => $model,
                    'template' => "{summary}\n{items}\n{pager}",
                    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
                    'columns' => array(
                        ////'pendidikan_id',
                        array(
                            'name' => 'pendidikan_id',
                            'value' => '$data->pendidikan_id',
                            'filter' => false,
                        ),
                        array(
                            'name' => 'pendidikan_nama',
                            'value' => '$data->pendidikan_nama',
                            'filter' => CHtml::activeTextField($model, 'pendidikan_nama'),
                        ),
                        'pendidikan_namalainnya',
                        array(
                            'name' => 'pendidikan_urutan',
                            'value' => '$data->pendidikan_urutan',
                            'filter' => CHtml::activeTextField($model, 'pendidikan_urutan', array('class' => 'numbers-only')),
                        ),
                        array(
                            'header' => 'Status',
                            'value' => '($data->pendidikan_aktif == 1 ) ? "Aktif" : "Tidak Aktif"',
                            'htmlOptions' => array('style' => 'text-align: center; width: 100px;'),
                        ),
                        ////                 array(
                        ////                        'header'=>'Aktif',
                        ////                        'class'=>'CCheckBoxColumn',     
                        ////                        'selectableRows'=>0,
                        ////                        'id'=>'rows',
                        ////                        'checked'=>'$data->pendidikan_aktif',
                        ////                ),
                        array(
                            'header' => 'Lihat',
                            'class' => 'bootstrap.widgets.BootButtonColumn',
                            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                            'template' => '{view}',
                            'buttons' => array(
                                'view' => array(
                                    'options' => array('rel' => 'tooltip', 'title' => 'Lihat Pendidikan'),
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
                                    'options' => array('rel' => 'tooltip', 'title' => 'Ubah Pendidikan'),
                                    //                                            'visible'=>'Yii::app()->controller->checkAccess(array("action"=>Params::DEFAULT_UPDATE))',
                                ),
                            ),
                        ),
                        array(
                            'header' => 'Hapus',
                            'type' => 'raw',
                            'value' => '($data->pendidikan_aktif)?CHtml::link("<i class=\'icon-form-silang\'></i> ","javascript:removeTemporary($data->pendidikan_id)",array("id"=>"$data->pendidikan_id","rel"=>"tooltip","title"=>"Menonaktifkan Pendidikan"))." ".CHtml::link("<i class=\'icon-form-sampah\'></i> ", "javascript:deleteRecord($data->pendidikan_id)",array("id"=>"$data->pendidikan_id","rel"=>"tooltip","title"=>"Hapus Pendidikan")):CHtml::link("<i class=\'icon-form-sampah\'></i> ", "javascript:deleteRecord($data->pendidikan_id)",array("id"=>"$data->pendidikan_id","rel"=>"tooltip","title"=>"Hapus Pendidikan"));',
                            'htmlOptions' => array('style' => 'text-align: center; width: 100px;'),
                        ),
                        //		array(
                        //                        'header'=>'Hapus',
                        //			'class'=>'bootstrap.widgets.BootButtonColumn',
                        //                        'template'=>'{remove}{delete}',
                        //                        'buttons'=>array(
                        //                               'remove' => array(
                        //                                                 'label'=>"<i class='icon-form-silang'></i>",
                        //                                                 'options'=>array('title'=>Yii::t('mds','Remove Temporary')),
                        //                                                 'url'=>'Yii::app()->createUrl("'.Yii::app()->controller->module->id.'/'.Yii::app()->controller->id.'/removeTemporary",array("id"=>"$data->pendidikan_id"))',
                        //                                                 'visible'=>'($data->pendidikan_aktif && Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE) ? true: false)',
                        //                                                 'click'=>'function(){return confirm("'.Yii::t("mds","Do You want to remove this item temporary?").'");}',
                        //                                                 ),
                        //                                'delete'=> array(
                        //                                                  'visible'=>'Yii::app()->controller->checkAccess(array("action"=>Params::DEFAULT_DELETE))',
                        //                                                 ),
                        //                                         )          
                        //		      ),
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
                Yii::t('mds', '{icon} Tambah Pendidikan', array('{icon}' => '<i class="icon-plus icon-white"></i>')),
                $this->createUrl('/sistemAdministrator/pendidikanM/create', array('modul_id' => Yii::app()->session['modul_id'])),
                array('title' => 'Tambah pendidikan', 'class' => 'btn btn-danger',)
            );
            echo CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PRINT\')'));
            echo CHtml::htmlButton(Yii::t('mds', '{icon} PDF', array('{icon}' => '<i class="entypo-book"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PDF\')'));
            echo CHtml::htmlButton(Yii::t('mds', '{icon} Excel', array('{icon}' => '<i class="entypo-doc-text"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'EXCEL\')'));
            $content = $this->renderPartial('../tips/master', array(), true);
            $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
            $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
            $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
            $urlPrint = Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/print'); //
            $url = Yii::app()->createAbsoluteUrl($module . '/' . $controller);

            // 
            //JSCRIPT;
            //Yii::app()->clientScript->registerScript('alert',$js,CClientScript::POS_BEGIN);

            $js = <<< JSCRIPT
         function cekForm(obj)
{
    $("#sajenis-pendidikan-m-search :input[name='"+ obj.name +"']").val(obj.value);
}
    function print(obj)
    {
    window.open("${urlPrint}/"+$('#sajenis-pendidikan-m-search').serialize()+"&caraPrint="+obj,"",'location=_new, width=900px');
        
    
    }
JSCRIPT;
            Yii::app()->clientScript->registerScript('print', $js, CClientScript::POS_HEAD);
            ?>
        </div>

        <script type="text/javascript">
            function removeTemporary(id) {
                var url = '<?php echo $url . "/removeTemporary"; ?>';
                myConfirm("Anda yakin akan menonaktifkan data ini untuk sementara?", 'Perhatian!', function(r) {
                    if (r) {
                        $.post(url, {
                                id: id
                            },
                            function(data) {
                                if (data.status == 'proses_form') {
                                    $.fn.yiiGridView.update('sapendidikan-m-grid');
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
                myConfirm("Yakin Akan Menghapus Data ini?", 'Perhatian!', function(r) {
                    if (r) {
                        $.post(url, {
                                id: id
                            },
                            function(data) {
                                if (data.status == 'proses_form') {
                                    $.fn.yiiGridView.update('sapendidikan-m-grid');
                                } else {
                                    myAlert('Data gagal dihapus!')
                                }
                            }, "json");
                    }
                });
            }
            $('.filters #SAPendidikanM_pendidikan_nama').focus();
        </script>
    </div>
</div>