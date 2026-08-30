<legend class="rim2">Laporan Pasien Sudah Pulang</legend>

<?php
$this->breadcrumbs = array(
    'Pasien Sudah Pulang' => array('/billingKasir/Laporan/pasienSudahPulang'),
    'PasienKarcis',
); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>
<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'caripasien-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'focus' => '#',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)'),
));

Yii::app()->clientScript->registerScript('cariPasien', "
$('#caripasien-form').submit(function(){
 $('#semua_pencarianpasien_grid').addClass('animation-loading');
	$.fn.yiiGridView.update('semua_pencarianpasien_grid', {
            data: $(this).serialize()
	});
	$.fn.yiiGridView.update('penjamin_pencarianpasien_grid', {
            data: $(this).serialize()
	});
	$.fn.yiiGridView.update('umum_pencarianpasien_grid', {
            data: $(this).serialize()
	});
	return false;
});
");
?>
<?php echo $this->renderPartial('pasienSudahPulang/_formKriteriaPencarian', array('model' => $model, 'form' => $form), true); ?>
<div class="form-actions">
    <div style="float:left;margin-right:6px;">
        <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')), array('class' => 'btn btn-danger', 'type' => 'submit')); ?>
        <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')), array('class' => 'btn btn-default', 'type' => 'reset', 'onClick' => 'onReset()')); ?>
    </div>
    <div style="float:left;">
        <?php
        $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
        $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai    
        $urlPrint =  Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/printPasienPulang');
        $this->widget('bootstrap.widgets.BootButtonGroup', array(
            'type' => 'primary',
            'buttons' => array(
                array('label' => 'Print', 'icon' => 'entypo-print', 'url' => $urlPrint, 'htmlOptions' => array('onclick' => 'print(\'PRINT\');return false;')),
                array(
                    'label' => '',
                    'items' => array(
                        array('label' => 'PDF', 'icon' => 'icon-book', 'url' => $urlPrint, 'itemOptions' => array('onclick' => 'print(\'PDF\');return false;')),
                        array('label' => 'Excel', 'icon' => 'icon-pdf', 'url' => $urlPrint, 'itemOptions' => array('onclick' => 'print(\'EXCEL\');return false;')),
                    )
                ),
            ),
        ));

        $js = <<< JSCRIPT
function print(caraPrint)
{
    window.open("${urlPrint}/&"+$('#caripasien-form').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
JSCRIPT;
        Yii::app()->clientScript->registerScript('print', $js, CClientScript::POS_HEAD);
        ?>
    </div>
    <div style="clear:both;"></div>
</div>

<?php
//            $this->widget('bootstrap.widgets.BootMenu',array(
//                'type'=>'tabs',
//                'stacked'=>false,
//                'htmlOptions'=>array('id'=>'tabmenu'),
//                'items'=>array(
//                    array('label'=>'All','url'=>'javascript:tab(0);','active'=>true),
//                    array('label'=>'P3','url'=>'javascript:tab(1);', 'itemOptions'=>array("index"=>1)),
//                    array('label'=>'Umum','url'=>'javascript:tab(2);', 'itemOptions'=>array("index"=>2)),
//                ),
//            ))
//        
?>
<div id="div_semua">
    <legend class="rim">Informasi Pasien Sudah Pulang</legend>
    <div>
        <?php
        $this->widget('ext.bootstrap.widgets.HeaderGroupGridView', array(
            'id' => 'semua_pencarianpasien_grid',
            'dataProvider' => $model->searchPasienSudahPulang(),
            'template' => "{summary}\n{items}\n{pager}",
            'itemsCssClass' => 'table table-striped table-bordered table-condensed',
            'columns' => array(
                array(
                    'header' => 'Tgl. Masuk',
                    'name' => 'tgl_pendaftaran',
                    'type' => 'raw',
                    'value' => '$data->tgl_pendaftaran',
                    'footerHtmlOptions' => array('colspan' => 9, 'style' => 'text-align:right;font-weight:bold;'),
                    'footer' => 'Jumlah Total',

                ),
                array(
                    'header' => 'Tgl. Keluar',
                    'name' => 'tglpulang',
                    'type' => 'raw',
                    'value' => '$data->tglpulang',
                ),
                array(
                    'header' => 'No. Rekam Medik',
                    'name' => 'no_rekam_medik',
                    'type' => 'raw',
                    'value' => '$data->no_rekam_medik',
                ),
                array(
                    'header' => 'No. Pasien',
                    'name' => 'pasien_id',
                    'type' => 'raw',
                    'value' => '$data->pasien_id',
                ),
                array(
                    'header' => 'Nama / Alias',
                    'name' => 'pasien_id',
                    'type' => 'raw',
                    'value' => '$data->namadepan." ".$data->nama_pasien ." / ".$data->nama_bin',

                ),
                array(
                    'header' => 'Jenis Penjamin',
                    'name' => 'carabayar_nama',
                    'type' => 'raw',
                    'value' => '$data->carabayar_nama',
                ),
                array(
                    'header' => 'Penjamin',
                    'name' => 'penjamin_nama',
                    'type' => 'raw',
                    'value' => '$data->penjamin_nama',
                ),
                array(
                    'header' => 'Unit Pelayanan',
                    'name' => 'ruangan_nama',
                    'type' => 'raw',
                    'value' => '$data->ruangan_nama',
                    'footerHtmlOptions' => array('style' => 'text-align:right;font-weight:bold;'),
                    // 'footer'=>'',
                ),
                array(
                    'header' => 'Status Pembayaran',
                    //  'name'=>'ruangan_nama',
                    'type' => 'raw',
                    'value' => '$data->status',

                    //   'value' => array($data, "status"),
                    'footerHtmlOptions' => array('style' => 'text-align:right;font-weight:bold;'),
                    // 'footer'=>'',
                ),
                array(
                    'header' => 'Jumlah Tagihan (Rp)',
                    'name' => 'tarif_tindakan',
                    'type' => 'raw',
                    //'value'=>'$data->tarif_tindakan',
                    'value' => 'number_format($data->tarif_tindakan)',
                    'htmlOptions' => array('style' => 'text-align:right;'),
                    'footerHtmlOptions' => array('style' => 'text-align:right;font-weight:bold;'),
                    'footer' => 'sum(tarif_tindakan)',
                ),
                array(
                    'header' => 'Tanggungan Pasien (Rp)',
                    'name' => 'iurbiaya_tindakan',
                    'type' => 'raw',
                    //'value'=>'$data->iurbiaya_tindakan',
                    'value' => 'number_format($data->iurbiaya_tindakan)',
                    'htmlOptions' => array('style' => 'text-align:right;'),
                    'footerHtmlOptions' => array('style' => 'text-align:right;font-weight:bold;'),
                    'footer' => 'sum(iurbiaya_tindakan)',

                ),
                array(
                    'header' => 'Tanggungan Asuransi (Rp)',
                    'name' => 'subsidiasuransi_tindakan',
                    'type' => 'raw',
                    //'value'=>'$data->subsidiasuransi_tindakan',
                    'value' => 'number_format($data->subsidiasuransi_tindakan)',
                    'htmlOptions' => array('style' => 'text-align:right;'),
                    'footerHtmlOptions' => array('style' => 'text-align:right;font-weight:bold;'),
                    'footer' => 'sum(subsidiasuransi_tindakan)',
                ),


                //                           
            ),
            'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
        ));
        ?>
    </div>
</div>

<div id="div_penjamin">
    <legend class="rim">Informasi Pasien Sudah Keluar - P3</legend>
    <div style="width:970px;overflow-x:scroll">
        <?php
        $this->widget('ext.bootstrap.widgets.BootGridView', array(
            'id' => 'penjamin_pencarianpasien_grid',
            'dataProvider' => $model->searchPasienBerdasarkanPenjamin(),
            'template' => "{summary}\n{items}\n{pager}",
            'itemsCssClass' => 'table table-striped table-bordered table-condensed',
            'columns' => array(
                array(
                    'header' => 'Tgl. Masuk',
                    'name' => 'tgl_pendaftaran',
                    'type' => 'raw',
                    'value' => '$data->tgl_pendaftaran',
                    'footerHtmlOptions' => array('colspan' => 7, 'style' => 'text-align:right;font-weight:bold;'),
                    'footer' => 'Jumlah Total',

                ),
                array(
                    'header' => 'Tgl. Keluar',
                    'name' => 'tglpulang',
                    'type' => 'raw',
                    'value' => '$data->tglpulang',
                ),
                array(
                    'header' => 'No. Rekam Medik',
                    'name' => 'no_rekam_medik',
                    'type' => 'raw',
                    'value' => '$data->no_rekam_medik',
                ),
                array(
                    'header' => 'No. Pasien',
                    'name' => 'pasien_id',
                    'type' => 'raw',
                    'value' => '$data->pasien_id',
                ),
                array(
                    'header' => 'Nama',
                    'name' => 'pasien_id',
                    'type' => 'raw',
                    'value' => '$data->namadepan." ".$data->nama_pasien ." / ".$data->nama_bin',

                ),
                array(
                    'header' => 'Jenis Penjamin',
                    'name' => 'carabayar_nama',
                    'type' => 'raw',
                    'value' => '$data->carabayar_nama',
                ),
                array(
                    'header' => 'Penjamin',
                    'name' => 'penjamin_nama',
                    'type' => 'raw',
                    'value' => '$data->penjamin_nama',
                ),
                array(
                    'header' => 'Tanggungan Pasien (Rp)',
                    'name' => 'iurbiaya_tindakan',
                    'type' => 'raw',
                    //'value'=>'$data->iurbiaya_tindakan',
                    'value' => 'number_format($data->iurbiaya_tindakan)',
                    'htmlOptions' => array('style' => 'text-align:right;'),
                    'footerHtmlOptions' => array('style' => 'text-align:right;font-weight:bold;'),
                    'footer' => 'sum(iurbiaya_tindakan)',

                ),
                array(
                    'header' => 'Tanggungan Asuransi (Rp)',
                    'name' => 'subsidiasuransi_tindakan',
                    'type' => 'raw',
                    //'value'=>'$data->subsidiasuransi_tindakan',
                    'value' => 'number_format($data->subsidiasuransi_tindakan)',
                    'htmlOptions' => array('style' => 'text-align:right;'),
                    'footerHtmlOptions' => array('style' => 'text-align:right;font-weight:bold;'),
                    'footer' => 'sum(subsidiasuransi_tindakan)',
                ),
                array(
                    'header' => 'Jumlah Tagihan (Rp)',
                    'name' => 'tarif_tindakan',
                    'type' => 'raw',
                    //'value'=>'$data->tarif_tindakan',
                    'value' => 'number_format($data->tarif_tindakan)',
                    'htmlOptions' => array('style' => 'text-align:right;'),
                    'footerHtmlOptions' => array('style' => 'text-align:right;font-weight:bold;'),
                    'footer' => 'sum(tarif_tindakan)',
                ),
                array(
                    'header' => 'Unit Pelayanan',
                    'name' => 'ruangan_nama',
                    'type' => 'raw',
                    'value' => '$data->ruangan_nama',
                    'footerHtmlOptions' => array('style' => 'text-align:right;font-weight:bold;'),
                    'footer' => '',
                ),
                //                           

            ),
            'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
        ));
        ?>
    </div>
</div>

<div id="div_umum">
    <legend class="rim">Informasi Pasien Sudah Keluar - Umum</legend>
    <div style="width:970px;overflow-x:scroll">
        <?php
        $this->widget('ext.bootstrap.widgets.BootGridView', array(
            'id' => 'umum_pencarianpasien_grid',
            'dataProvider' => $model->searchPasienBerdasarkanUmum(),
            'template' => "{summary}\n{items}\n{pager}",
            'itemsCssClass' => 'table table-striped table-bordered table-condensed',
            'columns' => array(
                array(
                    'header' => 'Tgl. Masuk',
                    'name' => 'tgl_pendaftaran',
                    'type' => 'raw',
                    'value' => '$data->tgl_pendaftaran',
                    'footerHtmlOptions' => array('colspan' => 7, 'style' => 'text-align:right;font-weight:bold;'),
                    'footer' => 'Jumlah Total',

                ),
                array(
                    'header' => 'Tgl. Keluar',
                    'name' => 'tglpulang',
                    'type' => 'raw',
                    'value' => '$data->tglpulang',
                ),
                array(
                    'header' => 'No. Rekam Medik',
                    'name' => 'no_rekam_medik',
                    'type' => 'raw',
                    'value' => '$data->no_rekam_medik',
                ),
                array(
                    'header' => 'No. Pasien',
                    'name' => 'pasien_id',
                    'type' => 'raw',
                    'value' => '$data->pasien_id',
                ),
                array(
                    'header' => 'Nama',
                    'name' => 'pasien_id',
                    'type' => 'raw',
                    'value' => '$data->namadepan." ".$data->nama_pasien ." / ".$data->nama_bin',

                ),
                array(
                    'header' => 'Jenis Penjamin',
                    'name' => 'carabayar_nama',
                    'type' => 'raw',
                    'value' => '$data->carabayar_nama',
                ),
                array(
                    'header' => 'Penjamin',
                    'name' => 'penjamin_nama',
                    'type' => 'raw',
                    'value' => '$data->penjamin_nama',
                ),
                array(
                    'header' => 'Tanggungan Pasien (Rp)',
                    'name' => 'iurbiaya_tindakan',
                    'type' => 'raw',
                    //'value'=>'$data->iurbiaya_tindakan',
                    'value' => 'number_format($data->iurbiaya_tindakan)',
                    'htmlOptions' => array('style' => 'text-align:right;'),
                    'footerHtmlOptions' => array('style' => 'text-align:right;font-weight:bold;'),
                    'footer' => 'sum(iurbiaya_tindakan)',

                ),
                array(
                    'header' => 'Tanggungan Asuransi (Rp)',
                    'name' => 'subsidiasuransi_tindakan',
                    'type' => 'raw',
                    //'value'=>'$data->subsidiasuransi_tindakan',
                    'value' => 'number_format($data->subsidiasuransi_tindakan)',
                    'htmlOptions' => array('style' => 'text-align:right;'),
                    'footerHtmlOptions' => array('style' => 'text-align:right;font-weight:bold;'),
                    'footer' => 'sum(subsidiasuransi_tindakan)',
                ),
                array(
                    'header' => 'Jml Tagihan (Rp)',
                    'name' => 'tarif_tindakan',
                    'type' => 'raw',
                    //'value'=>'$data->tarif_tindakan',
                    'value' => 'number_format($data->tarif_tindakan)',
                    'htmlOptions' => array('style' => 'text-align:right;'),
                    'footerHtmlOptions' => array('style' => 'text-align:right;font-weight:bold;'),
                    'footer' => 'sum(tarif_tindakan)',
                ),
                array(
                    'header' => 'Unit Pelayanan',
                    'name' => 'ruangan_nama',
                    'type' => 'raw',
                    'value' => '$data->ruangan_nama',
                    'footerHtmlOptions' => array('style' => 'text-align:right;font-weight:bold;'),
                    'footer' => '',
                ),
                //                           
            ),
            'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
        ));
        ?>
    </div>
</div>

<?php $this->endWidget(); ?>
<?php
$js = <<< JS
    $(document).ready(function() {
        $("#tabmenu").children("li").children("a").click(function() {
            $("#tabmenu").children("li").attr('class','');
            $(this).parents("li").attr('class','active');
            $(".icon-pencil").remove();
            // $(this).append("<li class='icon-pencil icon-white' style='float:left'></li>");
        });
        
        $("#div_semua").show();
        $("#div_penjamin").hide();
        $("#div_umum").hide();
    });

    function tab(index){
        $(this).hide();
        if (index==0){
            $("#filter_tab").val('all');
            $("#div_semua").show();
            $("#div_penjamin").hide();
            $("#div_umum").hide();        
        } else if (index==1){
            $("#filter_tab").val('p3');
            $("#div_semua").hide();
            $("#div_penjamin").show();
            $("#div_umum").hide();
        } else if (index==2){
            $("#filter_tab").val('umum');
            $("#div_semua").hide();
            $("#div_penjamin").hide();
            $("#div_umum").show();        
        }
   }
function onReset()
{
    setTimeout(
        function(){
            $.fn.yiiGridView.update('semua_pencarianpasien_grid', {
                data: $("#caripasien-form").serialize()
            });
            $.fn.yiiGridView.update('penjamin_pencarianpasien_grid', {
                data: $("#caripasien-form").serialize()
            });
            $.fn.yiiGridView.update('umum_pencarianpasien_grid', {
                data: $("#caripasien-form").serialize()
            });        
        }, 2000
    );
    return false;
}   
JS;
Yii::app()->clientScript->registerScript('pencatatanriwayat', $js, CClientScript::POS_HEAD);
?>