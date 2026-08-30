<?php
$this->breadcrumbs = array(
    'Informasi Pemesanan Barang',
);
?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-info-circled"></i> Informasi <b>Pemesanan Barang</b>
            <span class="pull-right">
                <a href="<?= !empty($linkHalaman) ? $linkHalaman : '#'; ?>" class="btn btn-default" target="_blank">
                    <i class="fas fa-external-link-alt"></i> Ke Halaman Transaksi
                </a>
            </span>
        </div>
    </div>
    <div class="panel-body">
        <?php
        Yii::app()->clientScript->registerScript('search', "
    $('.search-button').click(function(){
		$('.search-form').toggle();
		return false;
    });
    $('.search-form form').submit(function(){
		$.fn.yiiGridView.update('gupesanbarang-t-grid', {
			data: $(this).serialize()
		});
		return false;
    });
    ");
        $this->widget('bootstrap.widgets.BootAlert'); ?>
        <?php $this->renderPartial('gudangUmum.views.pesanbarangT._search', array('model' => $model, 'format' => $format)); ?>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Pemesanan Barang</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php echo $this->renderPartial('gudangUmum.views.pesanbarangT._table', array('model' => $model)); ?>
            </div>
        </div>
        <?php //echo CHtml::link(Yii::t('mds','{icon} Advanced Search',array('{icon}'=>'<i class="entypo-search"></i>')),'#',array('class'=>'search-button btn')); 
        ?>
        <?php
        $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
        $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
        $urlPrint =  Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/print');
        $url =  Yii::app()->createAbsoluteUrl($module . '/' . $controller);
        $js = <<< JSCRIPT
function cekForm(obj)
{
    $("#gupesanbarang-t-search :input[name='"+ obj.name +"']").val(obj.value);
}
function print(caraPrint)
{
    window.open("${urlPrint}/"+$('#gupesanbarang-t-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
JSCRIPT;
        Yii::app()->clientScript->registerScript('print', $js, CClientScript::POS_HEAD);
        ?>
        <?php
        //========= Dialog untuk Melihat detail Pengajuan Bahan Makanan =========================
        $this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
            'id' => 'dialogDetail',
            'options' => array(
                'title' => 'Detail Pemesanan Barang',
                'autoOpen' => false,
                'modal' => true,
                'width' => 750,
                'resizable' => true,
            ),
        ));
        echo '<iframe src="" name="iframeDetail" width="100%" id="iframeDetail" marginheight="0" frameborder="0" onLoad="autoResizeIframe(this,\'iframeDetail\')"></iframe>';
        $this->endWidget();
        ?>
        <?php
        //========= Dialog untuk Melihat detail Pengajuan Bahan Makanan =========================
        $this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
            'id' => 'dialogDetailMutasi',
            'options' => array(
                'title' => 'Detail Mutasi Barang',
                'autoOpen' => false,
                'modal' => true,
                'width' => 750,
                'resizable' => true,
            ),
        ));
        echo '<iframe src="" name="frameDetailMutasi" width="100%" id="iframeDetail" marginheight="0" frameborder="0" onLoad="autoResizeIframe(this,\'iframeDetail\')"></iframe>';
        $this->endWidget();
        ?>
    </div>
    <script>
        // untuk me-resize ukuran dalog box
        function resetIframe(obj) {
            obj.style.height = 10 + 'px';
        }

        function autoResizeIframe(obj, id) {
            var frameObj = document.getElementById(id);
            resetIframe(frameObj);
            obj.style.height = (obj.contentWindow.document.body.scrollHeight) + 'px';
        }
    </script>
</div>