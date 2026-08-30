<div class="search-form">
    <?php
    $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
        'action' => Yii::app()->createUrl($this->route),
        'method' => 'get',
        'id' => 'pencarian-form',
        'type' => 'horizontal',
    ));
    ?>
    <div class="row">
        <div class="col-sm-6">
            <div class="control-group">
                <?php echo CHtml::label('Tgl. Pembersihan ', '', array('class' => 'control-label inline')) ?>
                <div class="controls">
                    <div class="daterange daterange-inline input-inline span4" data-format="DD MMM YYYY" data-start-date="<?php echo date('d M Y', strtotime($modPembersihanSearch->tgl_awal)) ?>" data-end-date="<?php echo date('d M Y', strtotime($modPembersihanSearch->tgl_akhir)) ?>">
                        <i class="entypo-calendar"></i>
                        <span><?php echo date('d M Y', strtotime($modPembersihanSearch->tgl_awal)) ?> - <?php echo date('d M Y', strtotime($modPembersihanSearch->tgl_akhir)) ?></span>
                        <?php echo $form->hiddenField($modPembersihanSearch, 'tgl_awal', array('class' => 'start')) ?>
                        <?php echo $form->hiddenField($modPembersihanSearch, 'tgl_akhir', array('class' => 'end')) ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
        </div>
    </div>
    <div class="form-actions">
        <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')), array('class' => 'btn btn-danger', 'type' => 'button', 'onkeypress' => 'searchPembersihan();', 'onclick' => 'searchPembersihan()')); ?>
        <?php
        echo CHtml::link(Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')), $this->createUrl($this->id . '/index'), array(
            'class' => 'btn btn-default',
            'onclick' => 'return refreshForm(this);'
        ));
        ?>
    </div>
    <?php $this->endWidget(); ?>
</div>
<?php
//========= Dialog buat cari data Peralatan =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogPeralatan',
    'options' => array(
        'title' => 'Pencarian Peralatan',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'height' => 500,
        'resizable' => false,
    ),
));
$modPeralatan = new PeralatansterilisasiM('searchDialog');
$modPeralatan->unsetAttributes();
if (isset($_GET['PeralatansterilisasiM'])) {
    $modPeralatan->attributes = $_GET['PeralatansterilisasiM'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'barang-m-grid',
    'dataProvider' => $modPeralatan->searchDialog(),
    'filter' => $modPeralatan,
    'template' => "{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","",array("class"=>"btn-small", 
				"href"=>"",
				"id" => "selectObat",
				"onClick" => "
						$(\"#dialogPeralatan\").dialog(\"close\"); 
						 return false;
					"))',
        ),
        array(
            'header' => 'Peralatan Sterilisasi',
            'name' => 'peralatansterilisasi_nama',
            'type' => 'raw',
            'value' => '$data->peralatansterilisasi_nama',
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){
	jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));
$this->endWidget();
//========= end Peralatan dialog =============================
?>