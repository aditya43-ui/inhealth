<?php

/**
 * digunakan sebagai halaman utama 
 * 
 * @author          Yusuf Putra Anugrah <yusufputra@.com>
 * @version         2.0.0
 * @link            .com
 * 
 */
$this->breadcrumbs = array(
    'Laporan Pemakaian Obat'
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#Grafik').attr('src','').css('height','0px');
	if ($('#" . CHtml::activeId($model, 'tabmenu') . "').val() == 'pakai-obat'){
		$('#tableLaporanPakaiObat').addClass('animation-loading');
		$.fn.yiiGridView.update('tableLaporanPakaiObat', {
			data: $(this).serialize()
		});
	}else{
		$('#tableLaporanRekapPakaiObat').addClass('animation-loading');
		$.fn.yiiGridView.update('tableLaporanRekapPakaiObat', {
			data: $(this).serialize()
		});
	}
	//$('#tableLaporan').addClass('animation-loading');
	
	return false;
});
");

?>

<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-newspaper"></i> Laporan <b>Pemakaian Obat</b>
        </div>
    </div>
    <div class="panel-body">
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-search"></i> Pencarian
                </div>
            </div>
            <div class="panel-body">
                <!--fieldset class="box search-form"-->
                <?php $this->renderPartial($this->path_view_gudang . 'pemakaianObat._searchV2', array(
                    'model' => $model,
                )); ?>
                <!--</fieldset>-->
                <!--search-form-->

            </div>
        </div>
        <?php
        $this->widget('bootstrap.widgets.BootMenu', array(
            'type' => 'tabs',
            'stacked' => false,
            'htmlOptions' => array('id' => 'tabmenu-lap'),
            'items' => array(
                array('label' => 'Pemakaian Obat', 'url' => 'javascript:tab("pakai-obat");', 'itemOptions' => array("index" => 'pakai-obat'), 'active' => true,),
                array('label' => 'Rekap Pemakaian Obat', 'url' => 'javascript:tab("rekap-pakai-obat");', 'itemOptions' => array("index" => 'rekap-pakai-obat')),
            ),
        ))
        ?>
        <div class="panel panel-success" id="lap-pemakaian-obat">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Pemakaian Obat</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php $this->renderPartial($this->path_view_gudang . 'pemakaianObat._table', array('model' => $model)); ?>
            </div>
        </div>

        <div class="panel panel-success" id="lap-rekap-pemakaian-obat" style="display:none;">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Rekapitulasi Pemakaian Obat</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php $this->renderPartial($this->path_view_gudang . 'pemakaianObat._tableRekap', array('model' => $model)); ?>
            </div>
        </div>

        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-chart-pie"></i> Grafik
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php $this->renderPartial($this->path_view_gudang . '_tab'); ?>
                <iframe class="biru" src="" id="Grafik" width="100%" height='0' onload="javascript:resizeIframe(this);"></iframe>
            </div>
        </div>

        <?php //echo CHtml::link(Yii::t('mds','{icon} Advanced Search',array('{icon}'=>'<i class="entypo-search"></i>')),'#',array('class'=>'search-button btn')); 
        ?>
        <?php
        //        echo CHtml::htmlButton(Yii::t('mds','{icon} PDF',array('{icon}'=>'<i class="entypo-book"></i>')),array('class' => 'btn btn-danger', 'type'=>'button','onclick'=>'print(\'PDF\')')); 
        //        echo CHtml::htmlButton(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="entypo-doc-text"></i>')),array('class' => 'btn btn-danger', 'type'=>'button','onclick'=>'print(\'EXCEL\')')); 
        //        echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="entypo-print"></i>')),array('class' => 'btn btn-info', 'type'=>'button','onclick'=>'print(\'PRINT\')')); 
        //        echo CHtml::htmlButton(Yii::t('mds','{icon} Grafik',array('{icon}'=>'<i class="entypo-chart-area"></i>')),array('class' => 'btn btn-danger', 'type'=>'button','onclick'=>'$("#Grafik")[0].contentWindow.test();
        //')); 
        $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
        $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
        $urlPrint =  Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/printPemakaianObat');
        $url = Yii::app()->createUrl($module . '/' . $controller . '/FrameGrafikPemakaianObat&id=1');
        $this->renderPartial($this->path_view_gudang . '_footer', array('urlPrint' => $urlPrint, 'url' => $url)); ?>
        <?php $this->renderPartial($this->path_view_gudang . '_jsFunctions', array('model' => $model)); ?>
    </div>
</div>

<script>
    function tab(index) {
        $(this).hide();
        $('#Grafik').attr('src', '').css('height', '0px');
        if (index == 'pakai-obat') {
            $("#<?php echo CHtml::activeId($model, 'tabmenu') ?>").val("pakai-obat");
            $("#lap-pemakaian-obat").show();
            $("#lap-rekap-pemakaian-obat").hide();

            $("#cari-pakaiobat").show();
            $("#cari-rekappakaiobat").hide();

            //$("#search-laporan").trigger('submit');
            $('#tableLaporanPakaiObat').addClass('animation-loading');
            $.fn.yiiGridView.update('tableLaporanPakaiObat', {
                data: $("#search-laporan").serialize()
            });
            //return false;

        } else if (index == 'rekap-pakai-obat') {
            $("#<?php echo CHtml::activeId($model, 'tabmenu') ?>").val("rekap-pakai-obat");
            $("#lap-pemakaian-obat").hide();
            $("#lap-rekap-pemakaian-obat").show();

            $("#cari-pakaiobat").hide();
            $("#cari-rekappakaiobat").show();

            //$("#search-laporan").trigger('submit');

            $('#tableLaporanRekapPakaiObat').addClass('animation-loading');
            $.fn.yiiGridView.update('tableLaporanRekapPakaiObat', {
                data: $("#search-laporan").serialize()
            });
            //return false;
        }
    }

    $(document).ready(function() {
        $("#tabmenu-lap").children("li").children("a").click(function() {
            $("#tabmenu-lap").children("li").attr('class', '');
            $(this).parents("li").attr('class', 'active');
            $(".icon-pencil").remove();
            //$(this).append("  <li class='<?php echo MyIcon::getIcons('ubah') ?>'></li>");
        });
        //tab('<?php //echo $model->tabmenu 
                ?>');
    });
</script>