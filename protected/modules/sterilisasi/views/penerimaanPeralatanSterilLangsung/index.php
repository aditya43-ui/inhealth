<?php $linkHalaman = CustomFunction::getUrlByMenuID(3012); ?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="fas fa-people-carry"></i> Transaksi <b>Penerimaan Sterilisasi Langsung</b>
            <span class="pull-right">
                <a href="<?= !empty($linkHalaman) ? $linkHalaman : '#'; ?>" class="btn btn-default" target="_blank">
                    <i class="fas fa-external-link-alt"></i> Ke Halaman Informasi
                </a>
            </span>
        </div>
    </div>
    <div class="panel-body">
        <?php
        $this->breadcrumbs = array(
            'Penerimaan Sterilisasi Langsung' => array('index'),
            'Create',
        );
        if (!empty($_GET['sukses'])) {
            Yii::app()->user->setFlash('success', "Data  " . $model->penerimaansterilisasi_no . " berhasil disimpan!");
        }
        $this->widget('bootstrap.widgets.BootAlert'); ?>
        <?php
        if (!empty($_GET['sukses'])) {
        ?>
            <?php echo Yii::app()->user->setFlash('success', "Data Penerimaan Peralatan Steril Langsung berhasil disimpan!");
            $this->widget('bootstrap.widgets.BootAlert'); ?>
        <?php } ?>
        <?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
            'id' => 'cspenerimaanperalatansteril-t-form',
            'enableAjaxValidation' => false,
            'type' => 'horizontal',
            'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)'),
            'focus' => '#' . CHtml::activeId($model, 'penerimaansterilisasi_ket'),
        )); ?>
        <!--<p class="help-block"><?php // echo Yii::t('mds','Fields with <span class="required">*</span> are required.') 
                                    ?></p>-->
        <?php echo $form->errorSummary($model); ?>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="glyphicon glyphicon-file"></i> Data <b>Penerimaan</b>
                </div>
            </div>
            <div class="panel-body">
                <?php $this->renderPartial($this->path_view . '_formPenerimaan', array(
                    'model' => $model,
                    'form' => $form,
                    'instalasiTujuans' => $instalasiTujuans,
                    'ruanganTujuans' => $ruanganTujuans,
                    'format' => $format,
                )); ?>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Peralatan</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php $this->renderPartial($this->path_view . '_formPeralatanLinen', array(
                    'modDetail' => $modDetail,
                    'form' => $form,
                )); ?>
                <?php $this->renderPartial($this->path_view . '_tablePengajuan', array(
                    'modDetail' => $modDetail,
                    'form' => $form,
                )); ?>
            </div>
        </div>
        <div class="form-actions">
            <?php
            $sukses = isset($_GET['sukses']) ? $_GET['sukses'] : null;
            $disableSave = false;
            $disableSave = (!empty($_GET['id'])) ? true : (($sukses > 0) ? true : false);
            ?>
            <?php $disablePrint = ($disableSave) ? false : true; ?>
            <?php echo CHtml::htmlButton(
                Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
                array('title' => 'Simpan', 'class' => (isset($_GET['sukses'])) ? 'btn btn-danger' : 'btn btn-danger submit', 'type' => 'submit', 'disabled' => (isset($_GET['sukses'])) ? true : false)
            ); ?>
            <?php echo CHtml::link(
                Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
                $this->createUrl($this->id . '/index'),
                array(
                    'title' => 'Ulang',
                    'class' => 'btn btn-default',
                    'onclick' => 'return refreshForm(this);'
                )
            ) . "&nbsp"; ?>
            <?php echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'onclick' => "print('PRINT')", 'disabled' => $disablePrint)); ?>
            <?php $content = $this->renderPartial($this->path_tips . 'tips/transaksi1', array(), true);
            $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content)); ?>
        </div>
    </div>
</div>
<?php $this->renderPartial($this->path_view . '_jsFunctions', array(
    'model' => $model,
    'modDetail' => $modDetail,
    'form' => $form,
)); ?>
<?php $this->renderPartial($this->path_view . '_dialog', array('model' => $model)); ?>
<?php $this->endWidget(); ?>
<?php
/*
//========= Dialog buat cari Peralatan  =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogPeralatann',
    'options' => array(
        'title' => 'Daftar Peralatan',
        'autoOpen' => false,
        'modal' => true,
        'width' => 700,
        'height' => 400,
        'resizable' => false,
    ),
));
echo CHtml::hiddenField('bariske', '', array('readonly'=>true,));
$modPeralatan = new STBarangV('searchDialog');
$modPeralatan->unsetAttributes();
if (isset($_GET['STBarangV'])){
    $modPeralatan->attributes = $_GET['STBarangV'];
}
$this->widget('ext.bootstrap.widgets.BootGridView',array(
    'id'=>'barang-v-grid',
    'dataProvider'=>$modPeralatan->searchDialog(),
    'filter'=>$modPeralatan,
  'template'=>"{summary}\n{items}\n{pager}",
  'itemsCssClass'=>'table table-striped table-bordered table-condensed',
    'columns'=>array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
			"id" => "selectRegister",
			"onClick" => "
			  submitBarang(\"$data->barang_id\", \"$data->barang_nama\");
			  $(\'#dialogPeralatan\').dialog(\'close\');
			  return false;"))',
        ),
		array(
		  'name'=>'barang_type',
		  'type'=>'raw',
		  'value'=>'$data->barang_type'
		),
		array(
		  'name'=>'barang_kode',
		  'type'=>'raw',
		  'value'=>'$data->barang_kode'
		),  
		array(
		  'name'=>'barang_nama',
		  'type'=>'raw',
		  'value'=>'$data->barang_nama'
		),
		array(
		  'name'=>'golongan_nama',
		  'type'=>'raw',
		  'value'=>'$data->golongan_nama'
		),
    ),
  'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
));
$this->endWidget();
 * 
 */
?>