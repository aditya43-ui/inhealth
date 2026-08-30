<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="fas fa-layer-group"></i> Pengaturan <b>Formula Obat Kronis</b>
        </div>
    </div>
    <?php
    if (isset($_GET['sukses'])) {
        Yii::app()->user->setFlash('success', '<b>Berhasil </b> Data berhasil disimpan');
    }
    $this->widget('bootstrap.widgets.BootAlert');
    ?>
    <div class="panel-body">
        <?php
        $this->breadcrumbs = array(
            'Pengaturan Formula Obat Kronis',
        );

        $arrMenu = array();
        //                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Kasus Penyakit Obat ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) :  '' ;
        //array_push($arrMenu,array('label'=>Yii::t('mds','List').' SANapzaM', 'icon'=>'list', 'url'=>array('index'))) ;
        //                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' Kasus Penyakit Obat', 'icon'=>'file', 'url'=>array('create'))) :  '' ;

        $this->menu = $arrMenu;

        Yii::app()->clientScript->registerScript('search', "
                    $('.search-button').click(function(){
                            $('.search-form').toggle();
                        $('#KasuspenyakitobatM_jeniskasuspenyakit_id').focus();
                            return false;
                    });
                    $('.search-form form').submit(function(){
                            $.fn.yiiGridView.update('rjkasuspenyakitobat-m-grid', {
                                    data: $(this).serialize()
                            });
                            return false;
                    });
                    ");
        $this->widget('bootstrap.widgets.BootAlert');
        ?>
        <?php echo CHtml::link(Yii::t('mds', '{icon} Advanced Search', array('{icon}' => '<i class="icon-accordion icon-white"></i>')), '#', array('class' => 'search-button btn')); ?>
        <div class="cari-lanjut search-form">
            <?php $this->renderPartial('_search', array('model' => $model)); ?>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Formula Obat Kronis</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php
                $this->widget('ext.bootstrap.widgets.BootGroupGridView', array(
                    'id' => 'rjkasuspenyakitobat-m-grid',
                    'dataProvider' => $model->search(),
                    'enableSorting' => true,
                    'filter' => $model,
                    'template' => "{summary}\n{items}\n{pager}",
                    'itemsCssClass' => 'table table-bordered table-striped table-condensed',
//                    'mergeColumns' => 'jumlahobat',
                    'columns' => array(
                        array(
                            'header' => 'No',
                            'type' => 'raw',
                            'value' => '$row+1',
                            'htmlOptions' => array('style' => 'text-align:right;'),
                        ),
                        array(
                            'name' => 'jumlahobat',
                            'header' => 'Jumlah Obat',
                            'value' => '$data->jumlahobat',
                            'htmlOptions' => array('style' => 'text-align:right;'),
                        ),
                        array(
                            'name' => 'jumlahobat_minimal',
                            'header' => 'Jumlah Obat Minimal <br> (Ina-CBGs)',
                            'value' => '$data->jumlahobat_minimal',
                            'htmlOptions' => array('style' => 'text-align:right;'),
                        ),
                        array(
                            'name' => 'jumlahobat_maksimal',
                            'header' => 'Jumlah Obat Maksimal <br> (fre for service)',
                            'value' => '$data->jumlahobat_maksimal',
                            'htmlOptions' => array('style' => 'text-align:right;'),
                        ),
                        array(
                            'name' => 'is_aktif',
                            'header' => 'Aktif',
                            'filter' => false,
                            'value' => '($data->is_aktif == 1 ) ? "Aktif" : "Tidak Aktif"',
                        ),
                        array(
                            'header' => 'Lihat',
                            'class' => 'ext.bootstrap.widgets.BootButtonColumn',
                            'template' => '{view}',
                            'buttons' => array(
                                'view' => array(
                                    'url' => 'Yii::app()->createUrl("' . Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/View",array("id"=>"$data->formulaobatkronis_id"))',
                                ),
                            ),
                            'htmlOptions' => array('style' => 'text-align:center; width:100px'),
                        ),
                        array(
                            'header' => 'Ubah',
                            'class' => 'ext.bootsrap.widgets.BootButtonColumn',
                            'template' => '{update}',
                            'buttons' => array(
                                'update' => array(
                                    'url' => 'Yii::app()->createUrl("' . Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/Update",array("id"=>"$data->formulaobatkronis_id"))',
                                ),
                            ),
                            'htmlOptions' => array('style' => 'text-align:center; width:100px'),
                        ),
                        array(
                            'header' => 'Hapus',
                            'type' => 'raw',
                            'value' => '($data->is_aktif)?CHtml::link("<i class=\'icon-form-silang\'></i> ","javascript:removeTemporary($data->formulaobatkronis_id)",array("id"=>"$data->formulaobatkronis_id","rel"=>"tooltip","title"=>"Menonaktifkan Formula Obat Kronis"))." ".CHtml::link("<i class=\'icon-form-sampah\'></i> ", "javascript:deleteRecord($data->formulaobatkronis_id)",array("id"=>"$data->formulaobatkronis_id","rel"=>"tooltip","title"=>"Hapus Formula Obat Kronis")):CHtml::link("<i class=\'icon-form-sampah\'></i> ", "javascript:deleteRecord($data->formulaobatkronis_id)",array("id"=>"$data->formulaobatkronis_id","rel"=>"tooltip","title"=>"Hapus Formula Obat Kronis"));',
                            'htmlOptions' => array('style' => 'text-align:center; width:100px'),
                            'visible' => ((Params::cekAkses(Yii::app()->user->getState('peranpengguna_id'))) ? true : false)
                        )
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
                        Yii::t('mds', '{icon} Tambah Formula Obat Kronis', array('{icon}' => '<i class="icon-plus icon-white"></i>')),
                        $this->createUrl('formulaObatKronis/create', array('modul_id' => Yii::app()->session['modul_id'])),
                        array('title' => 'Tambah Formula Obat Kronis', 'class' => 'btn btn-danger',)
                );
                echo CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PRINT\')'));
                echo CHtml::htmlButton(Yii::t('mds', '{icon} PDF', array('{icon}' => '<i class="entypo-book"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PDF\')'));
                echo CHtml::htmlButton(Yii::t('mds', '{icon} Excel', array('{icon}' => '<i class="entypo-doc-text"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'EXCEL\')'));
                $content = $this->renderPartial('../tips/master2', array(), true);
                $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
                $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
                $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
                $urlPrint = Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/print');
                $url = Yii::app()->createAbsoluteUrl($module . '/' . $controller);

                $js = <<< JSCRIPT
                    function cekForm(obj){
                        $("#rjkasuspenyakitobat-m-search :input[name='"+obj.name+"']").val(obj.value);
                    }
                    function print(caraPrint){
                        window.open("${urlPrint}/"+$('#rjkasuspenyakitobat-m-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
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
        myConfirm("Anda yakin akan menonaktifkan data ini untuk sementara?", 'Perhatian!', function (r) {
            if (r) {
                $.post(url, {
                    id: id
                },
                        function (data) {
                            if (data.status == 'proses_form') {
                                $.fn.yiiGridView.update('rjkasuspenyakitobat-m-grid');
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
        myConfirm("Yakin Akan Menghapus Data ini?", 'Perhatian!', function (r) {
            if (r) {
                $.post(url, {
                    id: id
                },
                        function (data) {
                            if (data.status == 'proses_form') {
                                $.fn.yiiGridView.update('rjkasuspenyakitobat-m-grid');
                            } else {
                                myAlert(data.pesan);
                            }
                        }, "json");
            }
        });
    }
    $('.filters #LoginpemakaiK_nama_pemakai').focus();

    function clearFrameSrc() {
        $('#grid-klon').attr('src', '');
    }

    function dialog_kertas() {
        $('#grid-klon').dialog('open');
    }
</script>