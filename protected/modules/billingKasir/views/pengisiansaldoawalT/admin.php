<div class='panel panel-gradient'>
    <div class="panel-heading">
        <div class="panel-title">Pengaturan <b>Pengisian Saldo Awal</b></div>
    </div>
    <div class="panel-body">
        <?php
        $this->breadcrumbs = array(
            'SacaraBayar Ms' => array('index'),
            'Manage',
        );

        $arrMenu = array();
        //                array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Cara Pembayaran ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master')));
        //                array_push($arrMenu,array('label'=>Yii::t('mds','List').' Cara Pembayaran', 'icon'=>'list', 'url'=>array('index'))) ;
        //                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' Cara Pembayaran', 'icon'=>'file', 'url'=>array('create'))) :  '' ;

        $this->menu = $arrMenu;


        Yii::app()->clientScript->registerScript('search', "
    $('.search-button').click(function(){
            $('.search-form').toggle();
            return false;
    });
    $('.search-form form').submit(function(){
            $.fn.yiiGridView.update('sacara-bayar-m-grid', {
                    data: $(this).serialize()
            });
            return false;
    });
    ");

        $this->widget('bootstrap.widgets.BootAlert'); ?>
        <?php echo CHtml::link(Yii::t('mds', '{icon} Advanced Search', array('{icon}' => '<i class="icon-accordion icon-white"></i>')), '#', array('class' => 'search-button btn')); ?>
        <p></p>
        <div class="cari-lanjut2 search-form" style="display: none;">
            <?php $this->renderPartial($this->path_view . '_search', array(
                'model' => $model,
            )); ?>
        </div>
        <hr>
        <div class="panel panel-success panel-shadow">
            <div class="panel-heading">
                <div class="panel-title">Tabel <b>Pengisian Saldo Awal</b></div>
            </div>
            <div class="panel-body">

                <?php $this->widget('ext.bootstrap.widgets.BootGridView', array(
                    'id' => 'pengisiansaldoawal-t-grid',
                    'dataProvider' => $model->search(),
                    'filter' => $model,
                    'template' => "{summary}\n{items}\n{pager}",
                    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
                    'columns' => array(
                        ////'carabayar_id',
                        array(
                            'name' => 'pengisiansaldoawal_id',
                            'value' => '$data->pengisiansaldoawal_id',
                            'filter' => false,
                        ),
                        array(
                            'name' => 'tglpengisiansaldo',
                            'value' => '$data->tglpengisiansaldo',
                            'filter' => CHtml::activeTextField($model, 'tglpengisiansaldo'),
                        ),
                        'shift_id',
                        'nilaisaldoawal',
                        // 'pegawai_id',
                        array(
                            'name' => 'pegawai_id',
                            // 'value'=>'$data->pegawai->tglpengisiansaldo',
                            'value' => 'empty($data->pegawai) ? "-" : $data->pegawai->namaLengkap',
                            'filter' => false,
                        ),
                        'create_time',

                        //                array(
                        //                        'header'=>'Aktif',
                        //                        'class'=>'CCheckBoxColumn',     
                        //                        'selectableRows'=>0,
                        //                        'id'=>'rows',
                        //                        'checked'=>'$data->carabayar_aktif',
                        //                ),
                        array(
                            'header' => Yii::t('zii', 'View'),
                            'class' => 'bootstrap.widgets.BootButtonColumn',
                            'template' => '{view}',
                            'buttons' => array(
                                'view' => array(
                                    'options' => array('rel' => 'tooltip', 'title' => 'Lihat Saldo Awal'),
                                ),
                            ),
                        ),
                        array(
                            'header' => Yii::t('zii', 'Update'),
                            'class' => 'bootstrap.widgets.BootButtonColumn',
                            'template' => '{update}',
                            'buttons' => array(
                                'update' => array(
                                    'options' => array('rel' => 'tooltip', 'title' => 'Ubah Saldo Awal'),
                                    'visible' => 'Yii::app()->controller->checkAccess(array("action"=>Params::DEFAULT_UPDATE))',
                                ),
                            ),
                        ),
                        array(
                            'header' => Yii::t('zii', 'Delete'),
                            'class' => 'bootstrap.widgets.BootButtonColumn',
                            'template' => '{delete}',
                            'buttons' => array(
                                'remove' => array(
                                    'label' => "<i class='icon-form-silang'></i>",
                                    'options' => array('title' => Yii::t('mds', 'Remove Temporary')),
                                    'url' => 'Yii::app()->createUrl("' . Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/removeTemporary",array("id"=>$data->pengisiansaldoawal_id))',
                                    'click' => 'function(){removeTemporary(this);return false;}',
                                ),
                                'delete' => array(),
                            )
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
                )); ?>
            </div>
        </div>
    </div>
</div>
<?php
echo CHtml::link(Yii::t('mds', '{icon} Tambah Pengisian Saldo Awal', array('{icon}' => '<i class="icon-plus icon-white"></i>')), $this->createUrl('pengisiansaldoawalT/create', array('modul_id' => Yii::app()->session['modul_id'])), array('class' => 'btn btn-success')) . "&nbsp&nbsp";
echo (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ? CHtml::htmlButton(Yii::t('mds', '{icon} PDF', array('{icon}' => '<i class="icon-book icon-white"></i>')), array('class' => 'btn btn-primary', 'type' => 'button', 'onclick' => 'print(\'PDF\')')) . "&nbsp&nbsp" :  '';
echo (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ? CHtml::htmlButton(Yii::t('mds', '{icon} Excel', array('{icon}' => '<i class="icon-pdf icon-white"></i>')), array('class' => 'btn btn-primary', 'type' => 'button', 'onclick' => 'print(\'EXCEL\')')) . "&nbsp&nbsp" :  '';
echo (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ? CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="icon-print icon-white"></i>')), array('class' => 'btn btn-primary', 'type' => 'button', 'onclick' => 'print(\'PRINT\')')) . "&nbsp&nbsp" :  '';
$content = $this->renderPartial('../tips/master', array(), true);
$this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
$module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
$urlPrint =  Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/print'); //
$url =  Yii::app()->createAbsoluteUrl($module . '/' . $controller);
$js = <<< JSCRIPT
        
         function cekForm(obj)
{
    $("#sajenis-carabayar-m-search     :input[name='"+ obj.name +"']").val(obj.value);
}
    function print(obj)
    {
    window.open("${urlPrint}/"+$('#sajenis-carabayar-m-search').serialize()+"&caraPrint="+obj,"",'location=_new, width=900px');
        
    
    }
JSCRIPT;
Yii::app()->clientScript->registerScript('print', $js, CClientScript::POS_HEAD);
Yii::app()->clientScript->registerScript('alert', $js, CClientScript::POS_BEGIN);
?>
</div>
<script type="text/javascript">
    function removeTemporary(id) {
        var url = '<?php echo $url . "/removeTemporary"; ?>';
        myConfirm("Yakin akan menonaktifkan data ini untuk sementara?", "Perhatian!", function(r) {
            if (r) {
                $.post(url, {
                        id: id
                    },
                    function(data) {
                        if (data.status == 'proses_form') {
                            $.fn.yiiGridView.update('sacara-bayar-m-grid');
                        } else {
                            myAlert('Data Gagal di Nonaktifkan')
                        }
                    }, "json");
            }
        });
    }

    function deleteRecord(id) {
        var id = id;
        var url = '<?php echo $url . "/delete"; ?>';
        myConfirm("Yakin Akan Menghapus Data ini ?", "Perhatian!", function(r) {
            if (r) {
                $.post(url, {
                        id: id
                    },
                    function(data) {
                        if (data.status == 'proses_form') {
                            $.fn.yiiGridView.update('sacara-bayar-m-grid');
                        } else {
                            myAlert('Data Gagal di Hapus')
                        }
                    }, "json");
            }
        });
    }
    $('.filters #SACaraBayarM_carabayar_nama').focus();
</script>