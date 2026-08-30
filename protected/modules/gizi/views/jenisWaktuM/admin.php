<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="fas fa-layer-group"></i> Pengaturan <b>Jenis Waktu</b>
        </div>
    </div>
    <div class="panel-body">
        <?php //$this->renderPartial('_tabMenu',array()); 
        ?>
        <!--<div class="biru">
            <div class="white">-->
        <?php
        $this->breadcrumbs = array(
            'GZjeniswaktu Ms' => array('index'),
            'Manage',
        );
        $arrMenu = array();
        //                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Jenis Waktu ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) :  '' ;
        //                array_push($arrMenu,array('label'=>Yii::t('mds','List').' Jenis Waktu', 'icon'=>'list', 'url'=>array('index'))) ;
        //                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE))?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' Jenis Waktu', 'icon'=>'file', 'url'=>array('create'))) :  '' ;

        $this->menu = $arrMenu;

        Yii::app()->clientScript->registerScript('search', "
            $('.search-button').click(function(){
                    $('.search-form').toggle();
                $('#JenisWaktuM_jeniswaktu_nama').focus();
                    return false;
            });
            $('.search-form form').submit(function(){
                    $.fn.yiiGridView.update('jenis-waktu-m-grid', {
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
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b> Jenis Waktu</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php
                $this->widget('ext.bootstrap.widgets.BootGridView', array(
                    'id' => 'jenis-waktu-m-grid',
                    'dataProvider' => $model->search(),
                    'filter' => $model,
                    'itemsCssClass' => 'table table-condensed table-striped',
                    'template' => "{summary}\n{items}\n{pager}",
                    'columns' => array(
                        array(
                            //'header'=>'ID',
                            //'value'=>'$data->jeniswaktu_id',
                            'header' => 'No.',
                            'value' => '($this->grid->dataProvider->pagination) ? 
                                                ($this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1)
                                                : ($row+1)',
                            'type' => 'raw',
                        ),
                        'jeniswaktu_nama',
                        'jeniswaktu_namalain',
                        array(
                            'header' => 'Jam',
                            'value' => '$data->jeniswaktu_jam',
                            'htmlOptions' => array(
                                'style' => 'text-align: center;',
                            ),
                        ),
                        array(
                            'name'=>'urutan',
                            'filter'=>false,
                        ),
                        array(
                            'header' => 'Status',
                            'value' => '($data->jeniswaktu_aktif == 1 ) ? "Aktif" : "Tidak Aktif"',
                            'htmlOptions' => array('style' => 'text-align: center; width: 100px;'),
                        ),
                        //		array(
                        //                    'header'=>'Aktif',
                        //                    'class'=>'CCheckBoxColumn',
                        //                    'selectableRows'=>0,
                        //                    'id'=>'rows',
                        //                    'checked'=>'$data->jeniswaktu_aktif',
                        //                ),
                        array(
                            'header' => Yii::t('mds', 'View'),
                            'class' => 'bootstrap.widgets.BootButtonColumn',
                            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                            'template' => '{view}',
                            'buttons' => array(
                                'view' => array(
                                    'options' => array('rel' => 'tooltip', 'title' => 'Lihat jenis waktu'),
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
                                    'options' => array('rel' => 'tooltip', 'title' => 'Ubah jenis waktu'),
                                ),
                            ),
                        ),
                        array(
                            'header' => 'Hapus',
                            'type' => 'raw',
                            'value' => '($data->jeniswaktu_aktif)?CHtml::link("<i class=\'icon-form-silang\'></i> ","javascript:removeTemporary($data->jeniswaktu_id)",array("id"=>"$data->jeniswaktu_id","rel"=>"tooltip","title"=>"Menonaktifkan jenis waktu"))." ".CHtml::link("<i class=\'icon-form-sampah\'></i> ", "javascript:deleteRecord($data->jeniswaktu_id)",array("id"=>"$data->jeniswaktu_id","rel"=>"tooltip","title"=>"Hapus jenis waktu")):CHtml::link("<i class=\'icon-form-sampah\'></i> ", "javascript:deleteRecord($data->jeniswaktu_id)",array("id"=>"$data->jeniswaktu_id","rel"=>"tooltip","title"=>"Hapus jenis waktu"));',
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
            </div>
        </div>

        <div class="form-actions">
            <?php
            echo CHtml::link(
                Yii::t('mds', '{icon} Tambah Jenis Waktu', array('{icon}' => '<i class="icon-plus icon-white"></i>')),
                $this->createUrl('jenisWaktuM/create', array('modul_id' => Yii::app()->session['modul_id'])),
                array('title' => 'Tambah jenis waktu', 'class' => 'btn btn-danger',)
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
    $("#gzjeniswaktu-m-search :input[name='"+ obj.name +"']").val(obj.value);
}     
function print(caraPrint)
{
    window.open("${urlPrint}/"+$('#gzjeniswaktu-m-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
JSCRIPT;
            Yii::app()->clientScript->registerScript('print', $js, CClientScript::POS_HEAD);
            ?>
            <!--</div>-->
            <script type="text/javascript">
                function removeTemporary(id) {
                    var url = '<?php echo $url . "/removeTemporary"; ?>';

                    myConfirm('Yakin akan menonaktifkan data ini untuk sementara?', 'Perhatian!',
                        function(r) {
                            if (r) {
                                $.post(url, {
                                        id: id
                                    },
                                    function(data) {
                                        if (data.status == 'proses_form') {
                                            $.fn.yiiGridView.update('jenis-waktu-m-grid');
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
                    myConfirm('Yakin Akan Menghapus Data ini?', 'Perhatian!',
                        function(r) {
                            if (r) {
                                $.post(url, {
                                        id: id
                                    },
                                    function(data) {
                                        if (data.status == 'proses_form') {
                                            $.fn.yiiGridView.update('jenis-waktu-m-grid');
                                        } else {
                                            myAlert('Data gagal dihapus karena data digunakan oleh Master Jadwal Makan.');
                                        }
                                    }, "json");
                            }
                        });
                }
                $(document).ready(function() {
                    $("input[name='JenisWaktuM[jeniswaktu_nama]']").focus();
                });
            </script>
        </div>
    </div>
</div>