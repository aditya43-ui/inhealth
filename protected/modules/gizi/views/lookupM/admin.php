<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">

            <?php
            if ($model->lookup_type == 'jenisbahanmakanan') :
                echo "<i class='fas fa-box'></i> Pengaturan <b>Jenis Bahan Makanan</b>";
                $tambah = CHtml::link(Yii::t('mds', '{icon} Tambah Jenis Bahan Makanan', array('{icon}' => '<i class="icon-plus icon-white"></i>')), $this->createUrl('/gizi/JenisBahanMakanan/create', array('modul_id' => Yii::app()->session['modul_id'])), array('class' => 'btn btn-danger',));
            else :
                echo "<i class='fas fa-box'></i> Pengaturan <b>Kelompok Bahan Makanan</b>";
                $tambah = CHtml::link(Yii::t('mds', '{icon} Tambah Kelompok Bahan Makanan', array('{icon}' => '<i class="icon-plus icon-white"></i>')), $this->createUrl('/gizi/KelompokBahanMakanan/create', array('modul_id' => Yii::app()->session['modul_id'])), array('class' => 'btn btn-danger',));
            endif;
            ?>
        </div>
    </div>
    <div class="panel-body">
        <?php // $this->renderPartial($this->path_view.'_tabMenu',array()); 
        ?>

        <?php
        $this->breadcrumbs = array(
            'Lookup Ms' => array('index'),
            'Manage',
        );

        $this->menu = array(
            //        array('label'=>Yii::t('mds','Manage').' Satuan Barang ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master')),
            //	array('label'=>Yii::t('mds','List').' Lookup', 'icon'=>'list', 'url'=>array('index')),
            //	array('label'=>Yii::t('mds','Create').' Satuan Barang', 'icon'=>'file', 'url'=>array('create')),
        );

        Yii::app()->clientScript->registerScript('search', "
            $('.search-button').click(function(){
                    $('.search-form').toggle();
                $('#GZLookupM_lookup_type').focus();
                    return false;
            });
            $('.search-form form').submit(function(){
                    $.fn.yiiGridView.update('gzlookup-m-grid', {
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
            $this->renderPartial($this->path_view . '_search', array(
                'model' => $model,
            ));
            ?>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <?php
                    if ($model->lookup_type == 'jenisbahanmakanan') :
                        echo "<i class='entypo-credit-card'></i> Tabel <b>Jenis Bahan Makanan</b>";
                        $tambah = CHtml::link(
                            Yii::t('mds', '{icon} Tambah Jenis Bahan Makanan', array('{icon}' => '<i class="icon-plus icon-white"></i>')),
                            $this->createUrl('/gizi/JenisBahanMakanan/create', array('modul_id' => Yii::app()->session['modul_id'])),
                            array('title' => 'Tambah Jenis Bahan Makanan', 'class' => 'btn btn-danger',)
                        );
                    else :
                        echo "<i class='entypo-credit-card'></i> Tabel <b>Kelompok Bahan Makanan</b>";
                        $tambah = CHtml::link(
                            Yii::t('mds', '{icon} Tambah Kelompok Bahan Makanan', array('{icon}' => '<i class="icon-plus icon-white"></i>')),
                            $this->createUrl('/gizi/KelompokBahanMakanan/create', array('modul_id' => Yii::app()->session['modul_id'])),
                            array('title' => 'Tambah Kelompok Bahan Makanan', 'class' => 'btn btn-danger',)
                        );
                    endif;
                    ?>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <!--<h6>Tabel <b>Satuan Barang</b></h6>-->
                <?php //echo CHtml::dropDownList('agama', '', LookupM::getItems('agama')); 
                ?>
                <?php
                $this->widget('ext.bootstrap.widgets.BootGridView', array(
                    'id' => 'gzlookup-m-grid',
                    'dataProvider' => $model->searchAdmin(),
                    'filter' => $model,
                    'template' => "{summary}\n{items}\n{pager}",
                    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
                    'columns' => array(
                        ////'lookup_id',
                        array(
                            'header' => 'No.',
                            'value' => '($this->grid->dataProvider->pagination) ? 
                  ($this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1)
                  : ($row+1)',
                            'type' => 'raw',
                            'htmlOptions' => array('style' => 'text-align: right;'),
                        ),
                        //'lookup_type',
                        array(
                            'header' => 'Type',
                            'value' => '$data->lookup_type',
                            //'filter'=> CHtml::dropDownList('SALookupM[lookup_type]',$model->lookup_type,CHtml::listData(LookupM::getItems('satuanbarang'), 'lookup_type', 'lookup_type'), array('empty'=>'-- Pilih --')),
                        ),
                        array(
                            'header' => 'Lookup Name',
                            'name' => 'lookup_name',
                            'value' => '$data->lookup_name',
                            'filter' => CHtml::activeTextField($model, 'lookup_name'),
                        ),
                        'lookup_value',
                        'lookup_kode',
                        'lookup_urutan',
                        array(
                            'header' => 'Status',
                            'value' => '($data->lookup_aktif == 1 ) ? "Aktif" : "Tidak Aktif"',
                            'htmlOptions' => array('style' => 'text-align: center; width: 100px;'),
                        ),
                        //'lookup_aktif',
                        //                array(
                        //                        'header'=>'Aktif',
                        //                        'class'=>'CCheckBoxColumn',     
                        //                        'selectableRows'=>0,
                        //                        'id'=>'rows',
                        //                        'checked'=>'$data->lookup_aktif',
                        //                ),
                        array(
                            'header' => 'Lihat',
                            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                            'class' => 'bootstrap.widgets.BootButtonColumn',
                            'template' => '{view}',
                        ),
                        array(
                            'header' => 'Ubah',
                            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                            'class' => 'bootstrap.widgets.BootButtonColumn',
                            'template' => '{update}',
                        ),
                        array(
                            'header' => 'Hapus',
                            'type' => 'raw',
                            'value' => '($data->lookup_aktif)?CHtml::link("<i class=\'icon-form-silang\'></i> ","javascript:removeTemporary($data->lookup_id)",array("id"=>"$data->lookup_id","rel"=>"tooltip","title"=>"Menonaktifkan"))." ".CHtml::link("<i class=\'icon-form-sampah\'></i> ", "javascript:deleteRecord($data->lookup_id)",array("id"=>"$data->lookup_id","rel"=>"tooltip","title"=>"Hapus")):CHtml::link("<i class=\'icon-form-sampah\'></i> ", "javascript:deleteRecord($data->lookup_id)",array("id"=>"$data->lookup_id","rel"=>"tooltip","title"=>"Hapus"));',
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
            echo $tambah;
            echo CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PRINT\')'));
            echo CHtml::htmlButton(Yii::t('mds', '{icon} PDF', array('{icon}' => '<i class="entypo-book"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PDF\')'));
            echo CHtml::htmlButton(Yii::t('mds', '{icon} Excel', array('{icon}' => '<i class="entypo-doc-text"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'EXCEL\')'));
            $content = $this->renderPartial($this->path_tips . 'master', array(), true);
            $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
            $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
            $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
            $urlPrint = Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/print');
            $url = Yii::app()->createAbsoluteUrl($module . '/' . $controller);

            $js = <<< JSCRIPT
        function cekForm(obj)
{
    $("#gzkonfigfarmasi-k-search :input[name='"+ obj.name +"']").val(obj.value);
}
function print(caraPrint)
{
    window.open("${urlPrint}/"+$('#gzkonfigfarmasi-k-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
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
        myConfirm('Yakin akan menonaktifkan data ini untuk sementara?', 'Perhatian!', function(r) {
            if (r) {
                $.post(url, {
                        id: id
                    },
                    function(data) {
                        if (data.status == 'proses_form') {
                            $.fn.yiiGridView.update('gzlookup-m-grid');
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
        myConfirm('Yakin Akan Menghapus Data ini?', 'Perhatian!', function(r) {
            if (r) {
                $.post(url, {
                        id: id
                    },
                    function(data) {
                        if (data.status == 'proses_form') {
                            $.fn.yiiGridView.update('gzlookup-m-grid');
                        } else {
                            myAlert('Data gagal dihapus!')
                        }
                    }, "json");
            }
        });
    }
    $('.filters #GZLookupM_lookup_name').focus();
</script>