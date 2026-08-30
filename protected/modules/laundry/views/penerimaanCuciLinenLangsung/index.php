<style>
    tr td .add-on {
        margin: 0 !important;
    }
</style>

<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="fas fa-truck-loading"></i> Transaksi <b>Penerimaan Pencucian Linen Langsung</b>
        </div>
    </div>
    <div class="panel-body">
        <?php
        $this->breadcrumbs = array(
            'Transaksi Penerimaan Pencucian Linen Langsung',
        );
        ?>
        <?php
        if (!empty($_GET['sukses'])) {
        ?>
            <?php echo Yii::app()->user->setFlash('success', "Data Penerimaan Pencucian Linen Langsung berhasil disimpan!");
            $this->widget('bootstrap.widgets.BootAlert'); ?>
        <?php } ?>
        <?php
        $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
            'id' => 'lapenerimaanlinen-t-form',
            'enableAjaxValidation' => false,
            'type' => 'horizontal',
            'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)', 'onsubmit' => 'return requiredCheck(this);unformatNumbers(); '),
            'focus' => '#',
        ));
        ?>

        <!--<p class="help-block"><?php // echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') 
                                    ?></p>-->

        <?php echo $form->errorSummary($model); ?>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="glyphicon glyphicon-file"></i> Data <b>Penerimaan</b>
                </div>
            </div>
            <div class="panel-body">
                <?php
                echo $this->renderPartial($this->path_view . '_formPenerimaan', array(
                    'model' => $model,
                    'form' => $form,
                    'format' => $format,
                    'instalasiTujuans' => $instalasiTujuans,
                    'ruanganTujuans' => $ruanganTujuans,
                ));
                ?>
            </div>
        </div>

        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Data <b>Linen</b>
                </div>
            </div>
            <div class="panel-body" style="overflow-y: auto;">
                <?php
                $this->renderPartial($this->path_view . '_tabelLinen', array(
                    'model' => $model,
                    'form' => $form,
                    'modDetail' => $modDetail,
                    'form' => $form,
                ));
                ?>
            </div>
        </div>

        <div class="form-actions">
            <?php
            $sukses = isset($_GET['sukses']) ? $_GET['sukses'] : null;
            $disableSave = false;
            $disableSave = (!empty($_GET['sukses'])) ? true : (($sukses > 0) ? true : false);
            ?>
            <?php $disablePrint = ($disableSave) ? false : true; ?>
            <?php echo CHtml::htmlButton(
                Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
                array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'submit', 'disabled' => $disableSave)
            ); ?>
            &nbsp;
            <?php echo CHtml::link(
                Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
                $this->createUrl('index'),
                array('title' => 'Ulang', 'class' => 'btn btn-default', 'onclick' => 'if(!confirm("' . Yii::t('mds', 'Apakah Anda akan mengulang input data ?') . '")) return false;')
            );
            ?>
            <?php echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'onclick' => "print('PRINT')", 'disabled' => $disablePrint)); ?>
            <?php $content = $this->renderPartial($this->path_view_tips . 'tips/transaksi1', array(), true);
            $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
            ?>
        </div>
    </div>
</div>
<?php
$this->renderPartial($this->path_view . '_jsFunctions', array(
    'model' => $model,
    'modDetail' => $modDetail,
    'form' => $form,
));
?>
<?php $this->endWidget(); ?>
<script type="text/javascript">
    function print(caraPrint) {
        var penerimaanlinen_id = '<?php echo isset($_GET['penerimaanlinen_id']) ? $_GET['penerimaanlinen_id'] : null; ?>';
        window.open('<?php echo $this->createUrl('print'); ?>&penerimaanlinen_id=' + penerimaanlinen_id + '&caraPrint=' + caraPrint, 'printwin', 'left=100,top=100,width=1000,height=640');
    }
</script>

<?php
//========= Dialog buat cari Nama Linen =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogLinen',
    'options' => array(
        'title' => 'Daftar Linen',
        'autoOpen' => false,
        'modal' => true,
        'width' => 1000,
        'height' => 400,
        'resizable' => true,
    ),
));
echo CHtml::hiddenField('bariske', '', array('readonly' => true,));
$modLinen = new LALinenM('searchDialog');
$modLinen->unsetAttributes();
if (isset($_GET['LALinenM'])) {
    $modLinen->attributes = $_GET['LALinenM'];
}

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'linen-m-grid',
    'dataProvider' => $modLinen->searchDialog(),
    'filter' => $modLinen,
    'template' => "{pager}{summary}\n{items}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
				"id" => "selectLinen",
				"onClick" => "
					submitLinen(\"$data->linen_id\", \"$data->kodelinen\", \"$data->namalinen\");
					$(\'#dialogLinen\').dialog(\'close\');
					return false;"))',
        ),
        array(
            'name' => 'namalinen',
            'type' => 'raw',
            'value' => '$data->namalinen'
        ),
        array(
            'name' => 'kodelinen',
            'type' => 'raw',
            'value' => '$data->kodelinen'
        ),
        array(
            'name' => 'noregisterlinen',
            'type' => 'raw',
            'value' => '$data->noregisterlinen'
        ),
        array(
            'name' => 'tglregisterlinen',
            'header' => 'Tanggal Register',
            'type' => 'raw',
            'value' => 'MyFormatter::formatDateTimeForUser($data->tglregisterlinen)
					.(isset($data->tglregisterlinen) ? "<br>".MyFormatter::formatDateTimeForUser($data->tglregisterlinen) : "")',
            'filter' => false,
        ),
        array(
            'header' => 'Barang',
            'name' => 'barang_nama',
            'type' => 'raw',
            'value' => 'isset($data->barang_kode)?$data->barang->barang_nama:""'
        ),
        array(
            'header' => 'Bahan',
            'name' => 'bahanlinen_nama',
            'type' => 'raw',
            'value' => 'isset($data->bahan)?$data->bahan->bahanlinen_nama:""'
        ),
        array(
            'header' => 'Jenis',
            'name' => 'jenislinen_nama',
            'type' => 'raw',
            'value' => 'isset($data->jenislinen_id)?$data->jenis->jenislinen_nama:""'
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){
		jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});
		jQuery("#' . CHtml::activeId($modLinen, 'tglregisterlinen') . '").datepicker(jQuery.extend({showMonthAfterYear:false}, jQuery.datepicker.regional["id"], {"dateFormat":"dd M yy","maxDate":"d","timeText":"Waktu","hourText":"Jam","minuteText":"Menit","secondText":"Detik","showSecond":true,"timeOnlyTitle":"Pilih Waktu","timeFormat":"hh:mm:ss","changeYear":true,"changeMonth":true,"showAnim":"fold","yearRange":"-80y:+20y"}));
		jQuery("#' . CHtml::activeId($modLinen, 'tglregisterlinen') . '_date").on("click", function(){jQuery("#' . CHtml::activeId($modLinen, 'tglregisterlinen') . '").datepicker("show");});
	}',
));
$this->endWidget();
?>