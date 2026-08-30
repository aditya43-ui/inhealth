<?php
$this->breadcrumbs = array(
    'Penjamin Pasien',
);

$arrMenu = array();
//                array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Penjamin Pasien ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master')));
//                array_push($arrMenu,array('label'=>Yii::t('mds','List').' Penjamin Pasien', 'icon'=>'list', 'url'=>array('index'))) ;
//                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' Penjamin Pasien', 'icon'=>'file', 'url'=>array('create'))) :  '' ;

$this->menu = $arrMenu;

Yii::app()->clientScript->registerScript('search', "
    $('.search-button').click(function(){
            $('.search-form').toggle();
            return false;
    });
    $('.search-form form').submit(function(){
            $.fn.yiiGridView.update('sapenjamin-pasien-m-grid', {
                    data: $(this).serialize()
            });
            return false;
    });
    ");
?>

<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="fas fa-layer-group"></i> Pengaturan <b>Penjamin Pasien</b>
        </div>
    </div>
    <div class="panel-body">
        <?php $this->widget('bootstrap.widgets.BootAlert'); ?>

        <?php echo CHtml::link(Yii::t('mds', '{icon} Advanced Search', array('{icon}' => '<i class="icon-accordion icon-white"></i>')), '#', array('class' => 'search-button btn')); ?>
        <div class="cari-lanjut search-form">
            <?php
            $this->renderPartial($this->path_view . '_search', array(
                'model' => $model,
            ));
            ?>
        </div>
        <!--search-form-->

        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Penjamin Pasien</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <!--<h6>Tabel <b>Penjamin Pasien</b></h6>-->
                <?php
                $this->widget('ext.bootstrap.widgets.HeaderGroupGridViewNonRp', array(
                    'id' => 'sapenjamin-pasien-m-grid',
                    'dataProvider' => $model->search(),
                    'mergeHeaders' => array(
                        array(
                            'name' => '<p style="margin: 0; text-align: center;">Keringanan</p>',
                            'start' => 7,
                            'end' => 11,
                        ),
                    ),
                    'filter' => $model,
                    'template' => "{summary}\n{items}\n{pager}",
                    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
                    'columns' => array(
                        ////'penjamin_id',
                        array(
                            'header' => 'No.',
                            'type' => 'raw',
                            'value' => '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1',
                        ),
                        array(
                            'name' => 'carabayar_id',
                            'filter' => CHtml::dropDownList('SAPenjaminPasienM[carabayar_id]', $model->carabayar_id, CHtml::listData($model->CaraBayarItems, 'carabayar_id', 'carabayar_nama'), array('empty' => '-- Pilih --')),
                            'value' => '$data->carabayar->carabayar_nama',
                            'type' => 'raw',
                        ),
                        'penjamin_nama',
                        'penjamin_nomobile',
                        array(
                            'header' => 'Lama Jatuh Tempo (Hari)',
                            'type' => 'raw',
                            'value' => '$data->lama_tempo',
                            'htmlOptions' => array('style' => 'text-align: center;'),
                        ),
                        array(
                            'header' => 'Logo',
                            'type' => 'raw',
                            'filter' => false,
                            'value' => 'CHtml::link("$data->path_logoasuransi", "javascript:printLogo(\'$data->penjamin_id\');",array("rel"=>"tooltip","rel"=>"tooltip","title"=>"Klik untuk Melihat Gambar"))',
                            //                            'value' => '$data->path_logoasuransi',
                        ),
                        array(
                            'header' => 'Lampiran File PKS',
                            'type' => 'raw',
                            'filter' => false,
                            'value' => 'CHtml::link("$data->lampiranpks", "javascript:printPdf(\'$data->penjamin_id\');",array("rel"=>"tooltip","rel"=>"tooltip","title"=>"Klik untuk Melihat File"))',
                            //                            'value' => '$data->lampiranpks',
                        ),
                        array(
                            'header' => 'Tagihan (%)',
                            'type' => 'raw',
                            'value' => 'number_format($data->diskon_tagihan,2,",",".")',
                            'headerHtmlOptions' => array('colspan' => '5', 'style' => 'text-align:center;'),
                        ),
                        array(
                            'header' => 'Klaim (%)',
                            'type' => 'raw',
                            'value' => 'number_format($data->diskon_klaim,2,",",".")',
                            //                            'headerHtmlOptions'=>array('style'=>'display:none'),
                        ),
                        array(
                            'header' => 'RJ (%)',
                            'type' => 'raw',
                            'value' => 'number_format($data->diskon_rj,2,",",".")',
                            //                            'headerHtmlOptions'=>array('style'=>'display:none'),
                        ),
                        array(
                            'header' => 'RI (%)',
                            'type' => 'raw',
                            'value' => 'number_format($data->diskon_ri,2,",",".")',
                            //                            'headerHtmlOptions'=>array('style'=>'display:none'),
                        ),
                        array(
                            'header' => 'RD (%)',
                            'type' => 'raw',
                            'value' => 'number_format($data->diskon_rd,2,",",".")',
                            //                            'headerHtmlOptions'=>array('style'=>'display:none'),
                        ),
                        array(
                            'header' => 'Biaya Administrasi (%)',
                            'value' => 'number_format($data->biaya_administrasi,2,",",".")',
                            'type' => 'raw',
                            // 'htmlOptions'=>array('style'=>'text-align:center;'),
                        ),
                        array(
                            'header' => 'Status',
                            'value' => '($data->penjamin_aktif == 1 ) ? "Aktif" : "Tidak Aktif"',
                            'htmlOptions' => array('style' => 'text-align: center; width: 100px;'),
                        ),
                        array(
                            'header' => 'Lihat',
                            'class' => 'bootstrap.widgets.BootButtonColumn',
                            'htmlOptions' => array('style' => 'text-align:center; width:60px;'),
                            'template' => '{view}',
                            'buttons' => array(
                                'view' => array(
                                    'options' => array('rel' => 'tooltip', 'title' => 'Lihat Penjamin Pasien'),
                                ),
                            ),
                        ),
                        array(
                            'header' => 'Ubah',
                            'class' => 'bootstrap.widgets.BootButtonColumn',
                            'htmlOptions' => array('style' => 'text-align:center; width:60px;'),
                            'template' => '{update}',
                            'buttons' => array(
                                'update' => array(
                                    'options' => array('rel' => 'tooltip', 'title' => 'Ubah Penjamin Pasien'),
                                    // 'visible'=>'Yii::app()->controller->checkAccess(array("action"=>Params::DEFAULT_UPDATE))',
                                ),
                            ),
                        ),
                        array(
                            'header' => 'Hapus',
                            'type' => 'raw',
                            'value' => '($data->penjamin_aktif)?CHtml::link("<i class=\'icon-form-silang\'></i> ","javascript:removeTemporary($data->penjamin_id)",array("id"=>"$data->penjamin_id","rel"=>"tooltip","title"=>"Menonaktifkan Penjamin Pasien"))." ".CHtml::link("<i class=\'icon-form-sampah\'></i> ", "javascript:deleteRecord($data->penjamin_id)",array("id"=>"$data->penjamin_id","rel"=>"tooltip","title"=>"Hapus Penjamin Pasien")):CHtml::link("<i class=\'icon-form-sampah\'></i> ", "javascript:deleteRecord($data->penjamin_id)",array("id"=>"$data->penjamin_id","rel"=>"tooltip","title"=>"Hapus Penjamin Pasien"));',
                            'htmlOptions' => array('style' => 'text-align:center; width:100px;'),
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
                Yii::t('mds', '{icon} Tambah Penjamin Pasien', array('{icon}' => '<i class="icon-plus icon-white"></i>')),
                $this->createUrl('create', array('modul_id' => Yii::app()->session['modul_id'])),
                array('title' => 'Tambah penjamin pasien', 'class' => 'btn btn-danger',)
            );
            echo CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PRINT\')'));
            echo CHtml::htmlButton(Yii::t('mds', '{icon} PDF', array('{icon}' => '<i class="entypo-book"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PDF\')'));
            echo CHtml::htmlButton(Yii::t('mds', '{icon} Excel', array('{icon}' => '<i class="entypo-doc-text"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'EXCEL\')'));
            $content = $this->renderPartial($this->tips . 'tips/master', array(), true);
            $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
            $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
            $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
            $urlPrint = Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/print'); //
            $url = Yii::app()->createAbsoluteUrl($module . '/' . $controller);
            $urlPrintLogo = Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/PrintLampiranLogo');
            $urlPrintPdf = Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/PrintLampiranPdf');

            $js = <<< JSCRIPT
          function cekForm(obj)
{
    $("#sapenjamin-pasien-m-search     :input[name='"+ obj.name +"']").val(obj.value);
}
    function print(obj)
    {
    window.open("${urlPrint}/"+$('#sapenjamin-pasien-m-search').serialize()+"&caraPrint="+obj,"",'location=_new, width=900px');
    }
    function printLogo(penjamin_id)
    {
    window.open("${urlPrintLogo}&penjamin_id="+penjamin_id,"",'location=_new, width=900px');
    }
    function printPdf(penjamin_id)
    {
    window.open("${urlPrintPdf}&penjamin_id="+penjamin_id,"",'location=_new, width=900px');
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
                            $.fn.yiiGridView.update('sapenjamin-pasien-m-grid');
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
                            $.fn.yiiGridView.update('sapenjamin-pasien-m-grid');
                        } else {
                            myAlert('Data gagal dihapus!')
                        }
                    }, "json");
            }
        });
    }
</script>