<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="fas fa-layer-group"></i> Pengaturan <b>Bahan Makanan</b>
        </div>
    </div>
    <div class="panel-body">
        <?php //$this->renderPartial('_tabMenu',array()); 
        ?>
        <!--<div class="biru">
        <div class="white">-->
        <?php
        $this->breadcrumbs = array(
            'gzbahanmakanan Ms' => array('index'),
            'Manage',
        );
        $arrMenu = array();
        //                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Bahan Makanan ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) :  '' ;
        //                array_push($arrMenu,array('label'=>Yii::t('mds','List').' Bahan Makanan', 'icon'=>'list', 'url'=>array('index'))) ;
        //                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE))?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' Bahan Makanan', 'icon'=>'file', 'url'=>array('create'))) :  '' ;

        $this->menu = $arrMenu;

        Yii::app()->clientScript->registerScript('search', "
            $('.search-button').click(function(){
                    $('.search-form').toggle();
                $('#BahanmakananM_golbahanmakanan_id').focus();
                    return false;
            });
            $('.search-form form').submit(function(){
                    $.fn.yiiGridView.update('bahan-makanan-m-grid', {
                            data: $(this).serialize()
                    });
                    return false;
            });
            ");
        //var_dump(Yii::app()->user->getFlash('success'));

        $this->widget('bootstrap.widgets.BootAlert'); ?>

        <?php echo CHtml::link(Yii::t('mds', '{icon} Advanced Search', array('{icon}' => '<i class=" icon-accordion icon-white"></i>')), '#', array('class' => 'search-button btn')); ?>
        <div class="cari-lanjut search-form">
            <?php $this->renderPartial('_search', array(
                'model' => $model,
            )); ?>
        </div>
        <!--search-form-->

        <!--<h6>Tabel <b>Bahan Makanan</b></h6>-->
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Bahan Makanan</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php $this->widget('ext.bootstrap.widgets.BootGridView', array(
                    'id' => 'bahan-makanan-m-grid',
                    'dataProvider' => $model->search(),
                    'filter' => $model,
                    'itemsCssClass' => 'table table-striped table-condensed',
                    'template' => "{summary}\n{items}{pager}",
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
                            'name' => 'sumberdanabhn',
                            'filter' => CHtml::dropDownList('BahanmakananM[sumberdanabhn]', $model->sumberdanabhn, CHtml::listData($model->SumberDanaItems, 'lookup_name', 'lookup_value'), array('empty' => '-- Pilih --')),
                            'value' => '$data->sumberdanabhn',
                        ),
                        array(
                            'name' => 'golbahanmakanan_id',
                            'filter' => CHtml::dropDownList('BahanmakananM[golbahanmakanan_id]', $model->golbahanmakanan_id, CHtml::listData($model->getGolBahanMakananItems(), 'golbahanmakanan_id', 'golbahanmakanan_nama'), array('empty' => '-- Pilih --')),
                            'value' => '$data->golbahanmakanan->golbahanmakanan_nama',
                        ),
                        array(
                            'name' => 'jenisbahanmakanan',
                            'filter' => CHtml::dropDownList('BahanmakananM[jenisbahanmakanan]', $model->jenisbahanmakanan, CHtml::listData($model->JenisBahanMakananItems, 'lookup_name', 'lookup_value'), array('empty' => '-- Pilih --')),
                            'value' => '$data->jenisbahanmakanan',
                        ),
                        array(
                            'name' => 'kelbahanmakanan',
                            'filter' => CHtml::dropDownList('BahanmakananM[kelbahanmakanan]', $model->kelbahanmakanan, CHtml::listData($model->KelBahanMakananItems, 'lookup_name', 'lookup_value'), array('empty' => '-- Pilih --')),
                            'value' => '$data->kelbahanmakanan',
                        ),
                        array(
                            'header' => 'Bahan Makanan',
                            'name' => 'namabahanmakanan',
                            'value' => '$data->namabahanmakanan',
                            'filter' => Chtml::activeTextField($model, 'namabahanmakanan', array('class' => 'custom-only'))
                        ),
                        array(
                            'header' => 'Harga Satuan',
                            'value' => 'number_format($data->hargajualbahan)',
                            'htmlOptions' => array('style' => 'text-align: right;'),
                        ),
                        array(
                            'header' => 'Status',
                            'value' => '($data->bahanmakanan_aktif ==TRUE)?"Aktif":"Tidak Aktif"',
                        ),

                        /*
                    'sumberdanabhn',
                    'jenisbahanmakanan',
                    'kelbahanmakanan',
                            'jmlpersediaan',
                            'satuanbahan',
                            'harganettobahan',
                            'hargajualbahan',
                            'discount',
                            'tglkadaluarsabahan',
                            'jmlminimal',
                            */
                        array(
                            'header' => Yii::t('mds', 'View'),
                            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                            'class' => 'bootstrap.widgets.BootButtonColumn',
                            'template' => '{view}',
                            'buttons' => array(
                                'view' => array(
                                    'options' => array('rel' => 'tooltip', 'title' => 'Lihat bahan makanan'),
                                ),
                            ),
                        ),
                        array(
                            'header' => Yii::t('mds', 'Update'),
                            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                            'class' => 'bootstrap.widgets.BootButtonColumn',
                            'template' => '{update}',
                            'buttons' => array(
                                'update' => array(
                                    'options' => array('rel' => 'tooltip', 'title' => 'Ubah bahan makanan'),
                                ),
                            ),
                        ),
                        array(
                            'header' => 'Hapus',
                            'type' => 'raw',
                            //'value'=>'CHtml::link("<i class=\'icon-form-sampah\'></i> ", "javascript:deleteRecord($data->bahanmakanan_id)",array("id"=>"$data->bahanmakanan_id","rel"=>"tooltip","title"=>"Hapus bahan makanan"));',
                            'value' => '($data->bahanmakanan_aktif)?CHtml::link("<i class=\'icon-form-silang\'></i> ","javascript:removeTemporary($data->bahanmakanan_id)",array("id"=>"$data->bahanmakanan_id","rel"=>"tooltip","title"=>"Menonaktifkan Bahan Makanan"))." ".CHtml::link("<i class=\'icon-form-sampah\'></i> ", "javascript:deleteRecord($data->bahanmakanan_id)",array("id"=>"$data->bahanmakanan_id","rel"=>"tooltip","title"=>"Hapus Bahan Makanan")):CHtml::link("<i class=\'icon-form-sampah\'></i> ", "javascript:deleteRecord($data->bahanmakanan_id)",array("id"=>"$data->bahanmakanan_id","rel"=>"tooltip","title"=>"Hapus Bahan Makanan"));',
                            'htmlOptions' => array('style' => 'text-align: center; width: 100px;'),
                        ),
                    ),
                    'afterAjaxUpdate' => 'function(id, data){
                        jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});
                        $("table").find("input[type=text]").each(function(){
                            cekForm(this);
                        });
                        $("table").find("select").each(function(){
                            cekForm(this);
                        });
                        $(".custom-only").keyup(function() {
                            setCustomOnly(this);
                        });
                    }',
                )); ?>
            </div>
        </div>

        <div class="form-actions">
            <?php
            echo CHtml::link(
                Yii::t('mds', '{icon} Tambah Bahan Makanan', array('{icon}' => '<i class="icon-plus icon-white"></i>')),
                $this->createUrl('bahanMakananM/create', array('modul_id' => Yii::app()->session['modul_id'])),
                array('title' => 'Tambah Bahan Makanan', 'class' => 'btn btn-danger',)
            );
            echo CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PRINT\')'));
            echo CHtml::htmlButton(Yii::t('mds', '{icon} PDF', array('{icon}' => '<i class="entypo-book"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PDF\')'));
            echo CHtml::htmlButton(Yii::t('mds', '{icon} Excel', array('{icon}' => '<i class="entypo-doc-text"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'EXCEL\')'));
            $tips = array(
                '0' => 'ubah',
                '1' => 'lihat',
                '2' => 'nonaktif',
                '3' => 'hapus',
                '4' => 'pencarianlanjut',
                '5' => 'cari',
                '6' => 'ulang2',
                '7' => 'masterPDF',
                '8' => 'masterPRINT',
                '9' => 'masterEXCEL',
            );
            $content = $this->renderPartial('sistemAdministrator.views.tips.detailTips', array('tips' => $tips), true);
            $this->widget('UserTips', array('type' => 'admin', 'content' => $content));
            $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
            $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
            $urlPrint =  Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/print');
            $url =  Yii::app()->createAbsoluteUrl($module . '/' . $controller);

            $js = <<< JSCRIPT
        
 function cekForm(obj)
{
    $("#gzbahanmakanan-m-search :input[name='"+ obj.name +"']").val(obj.value);
}             
function print(caraPrint)
{
    window.open("${urlPrint}/"+$('#gzbahanmakanan-m-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
JSCRIPT;
            Yii::app()->clientScript->registerScript('print', $js, CClientScript::POS_HEAD);
            ?>
        </div>

        <script type="text/javascript">
            function removeTemporary(id) {
                var url = '<?php echo $url . "/removeTemporary"; ?>';

                myConfirm('Apakah Anda yakin ingin akan menonaktifkan data ini untuk sementara?', 'Perhatian!',
                    function(r) {
                        if (r) {
                            $.post(url, {
                                    id: id
                                },
                                function(data) {
                                    if (data.status == 'proses_form') {
                                        $.fn.yiiGridView.update('bahan-makanan-m-grid');
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
                myConfirm('Apakah Anda yakin ingin menghapus data ini?', 'Perhatian!',
                    function(r) {
                        if (r) {
                            $.post(url, {
                                    id: id
                                },
                                function(data) {
                                    if (data.status == 'proses_form') {
                                        $.fn.yiiGridView.update('bahan-makanan-m-grid');
                                    } else {
                                        myAlert('Data gagal dihapus karena data digunakan oleh Master Bahan Menu Diet atau Master Zat Bahan Makanan atau Menu Anamesa Diet.');
                                    }
                                }, "json");
                        }
                    });
            }
            $(document).ready(function() {
                $("input[name='BahanmakananM[namabahanmakanan]']").focus();
            });
        </script>
    </div>
</div>