<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="fas fa-cogs"></i> Pengaturan <b>Modul</b>
        </div>
    </div>
    <div class="panel-body">
        <?php
        $this->breadcrumbs = array(
            'Modul' => array('admin'),
            'Pengaturan',
        );

        $this->menu = array(
            //        array('label'=>Yii::t('mds','Manage').' Modul ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master')),
            //	array('label'=>Yii::t('mds','List').' Modul', 'icon'=>'list', 'url'=>array('index')),
            //	array('label'=>Yii::t('mds','Create').' Modul', 'icon'=>'file', 'url'=>array('create')),
        );

        Yii::app()->clientScript->registerScript('search', "
    $('.search-button').click(function(){
            $('.search-form').toggle();
            return false;
    });
    $('.search-form form').submit(function(){
            $.fn.yiiGridView.update('samodul-k-grid', {
                    data: $(this).serialize()
            });
            return false;
    });
    ");

        $this->widget('bootstrap.widgets.BootAlert'); ?>
        <?php echo CHtml::link(Yii::t('mds', '{icon} Advanced Search', array('{icon}' => '<i class="icon-accordion icon-white"></i>')), '#', array('class' => 'search-button btn')); ?>
        <div class="cari-lanjut search-form" style="display:none;padding:10px;border:1px solid #bdedbc;">
            <?php $this->renderPartial('_search', array(
                'model' => $model,
            )); ?>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Modul</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php $this->widget('ext.bootstrap.widgets.BootGridView', array(
                    'id' => 'samodul-k-grid',
                    'overflowx' => true,
                    'dataProvider' => $model->search(),
                    //'filter'=>$model,
                    'template' => "{summary}\n{items}\n{pager}",
                    'itemsCssClass' => 'table table-bordered table-striped datatable',
                    'columns' => array(
                        array(
                            'header' => 'No.',
                            'value' => '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1'
                        ),
                        'modul_id',
                        array(
                            'name' => 'modul_kategori',
                            'filter' => LookupM::getItems('kategorimodul'),
                            'value' => '$data->modul_kategori',
                        ),
                        array(
                            'name' => 'kelompokmodul_id',
                            'filter' =>  CHtml::listData($model->getKelompokModulItems(), 'kelompokmodul_id', 'kelompokmodul_nama'),
                            'value' => '$data->kelompokmodul->kelompokmodul_nama',
                        ),
                        array(
                            'header' => 'Icon',
                            'type' => 'raw',
                            'htmlOptions' => array('style' => 'text-align: center; width: 60px;',),
                            'value' => 'CHtml::image(Params::urlIconModulThumbsDirectory().$data->icon_modul, "Icon ".$data->modul_nama, array());',
                        ),
                        'modul_nama',
                        'modul_namalainnya',
                        'modul_key',
                        'url_modul',
                        'modul_fungsi',
                        'tglrevisimodul',
                        'modul_urutan',
                        /*
						'tglupdatemodul',
						'modul_key',
						'modul_aktif',
						*/
                        array(
                            'header' => 'Status',
                            'value' => '($data->modul_aktif == 1 ) ? "Aktif" : "Tidak Aktif"',
                            'htmlOptions' => array('style' => 'text-align: center; width: 100px;'),
                        ),
                        //                array(
                        //                        'header'=>'Aktif',
                        //                        'class'=>  'CCheckBoxColumn',
                        //                        'selectableRows'=>0,
                        //                        'checked'=>'$data->modul_aktif',
                        //                ),
                        array(
                            'header' => 'Lihat',
                            'class' => 'bootstrap.widgets.BootButtonColumn',
                            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                            'template' => '{view}',
                            'htmlOptions' => array('style' => 'text-align: center; width: 60px;',),
                        ),
                        array(
                            'header' => 'Ubah',
                            'class' => 'bootstrap.widgets.BootButtonColumn',
                            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                            'template' => '{update}',
                            'htmlOptions' => array('style' => 'text-align: center; width: 60px;',),
                        ),
                        array(
                            'header' => 'Hapus',
                            'type' => 'raw',
                            'value' => '($data->modul_aktif)?CHtml::link("<i class=\'icon-form-silang\'></i> ","javascript:removeTemporary($data->modul_id)",array("id"=>"$data->modul_id","rel"=>"tooltip","title"=>"Menonaktifkan"))." ".CHtml::link("<i class=\'icon-form-sampah\'></i> ", "javascript:deleteRecord($data->modul_id)",array("id"=>"$data->modul_id","rel"=>"tooltip","title"=>"Hapus")):CHtml::link("<i class=\'icon-form-sampah\'></i> ", "javascript:deleteRecord($data->modul_id)",array("id"=>"$data->modul_id","rel"=>"tooltip","title"=>"Hapus"));',
                            'htmlOptions' => array('style' => 'text-align: center; width: 100px;'),
                        ),
                        //		array(
                        //                        'header'=>Yii::t('zii','Delete'),
                        //			'class'=>'bootstrap.widgets.BootButtonColumn',
                        //                        'template'=>'{remove} {delete}',
                        //                        'buttons'=>array(
                        //                            'remove' => array
                        //                            (
                        //                                'label'=>"<i class='icon-form-silang'></i>",
                        //                                'options'=>array('title'=>Yii::t('mds','Remove Temporary')),
                        //                                'url'=>'Yii::app()->createUrl("sistemAdministrator/modulK/removeTemporary",array("id"=>"$data->modul_id"))',
                        //                                'visible'=>'$data->modul_aktif',
                        //                                'click'=>'function(){return confirm("'.Yii::t("mds","Do You want to remove this item temporary?").'");}',
                        //                            ),
                        //                        )
                        //		),
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
                Yii::t('mds', '{icon} Tambah Modul', array('{icon}' => '<i class="icon-plus icon-white"></i>')),
                $this->createUrl(Yii::app()->controller->id . '/create', array('modul_id' => Yii::app()->session['modul_id'])),
                array('title' => 'Tambah modul', 'class' => 'btn btn-danger',)
            );
            echo CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PRINT\')'));
            echo CHtml::htmlButton(Yii::t('mds', '{icon} PDF', array('{icon}' => '<i class="entypo-book"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PDF\')'));
            echo CHtml::htmlButton(Yii::t('mds', '{icon} Excel', array('{icon}' => '<i class="entypo-doc-text"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'EXCEL\')'));
            $content = $this->renderPartial('../tips/master', array(), true);
            $this->widget('UserTips', array('type' => 'admin', 'content' => $content));
            $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
            $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
            $urlPrint =  Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/print');
            $url = Yii::app()->createAbsoluteUrl($module . '/' . $controller);

            $js = <<< JSCRIPT
          function cekForm(obj)
{
    $("#sakelompok-menu-k-search :input[name='"+ obj.name +"']").val(obj.value);
}
function print(caraPrint)
{
    window.open("${urlPrint}/"+$('#sakelompok-menu-k-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
JSCRIPT;
            Yii::app()->clientScript->registerScript('print', $js, CClientScript::POS_HEAD);
            ?>
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
                                $.fn.yiiGridView.update('samodul-k-grid');
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
                                $.fn.yiiGridView.update('samodul-k-grid');
                            } else {
                                myAlert('Data gagal dihapus!')
                            }
                        }, "json");
                }
            });
        }
    </script>
    <script type="text/javascript">
        //    function removeTemporary(id){
        //        var url = '<?php // echo $url."/removeTemporary"; 
                                ?>';
        //        var answer = confirm('Yakin akan menonaktifkan data ini untuk sementara?');
        //            if (answer){
        //                 $.post(url, {id: id},
        //                     function(data){
        //                        if(data.status == 'proses_form'){
        //                                $.fn.yiiGridView.update('sakonfigfarmasi-k-grid');
        //                            }else{
        //                                myAlert('Data gagal dinonaktifkan!')
        //                            }
        //                },"json");
        //           }
        //    }
        //    
        //    function deleteRecord(id){
        //        var id = id;
        //        var url = '<?php // echo $url."/delete"; 
                                ?>';
        //        var answer = confirm('Yakin Akan Menghapus Data ini?');
        //            if (answer){
        //                 $.post(url, {id: id},
        //                     function(data){
        //                        if(data.status == 'proses_form'){
        //                                $.fn.yiiGridView.update('sakonfigfarmasi-k-grid');
        //                            }else{
        //                                myAlert('Data gagal dihapus!')
        //                            }
        //                },"json");
        //           }
        //    }
        $(document).ready(function() {
            $("input[name='SAModulK[modul_nama]']").focus();
        });
    </script>
</div>