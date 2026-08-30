<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'id' => 'pembayaran-t-search',
    'type' => 'horizontal',
    //	'focus'=>'#'.CHtml::activeId($modBayar,'nobuktibayar'),
)); ?>
<div class="row">
    <div class="col-sm-12">
        <div class="control-group">
            <?php echo CHtml::label("Tgl. Kas Keluar", 'tgluangmuka', array('class' => 'control-label')) ?>
            <div class="controls">
                <div class="daterange daterange-inline input-inline span4" data-format="DD MMM YYYY" data-start-date="<?php echo date('d M Y', strtotime($modBayar->tgl_awal)) ?>" data-end-date="<?php echo date('d M Y', strtotime($modBayar->tgl_akhir)) ?>">
                    <i class="entypo-calendar"></i>
                    <span><?php echo date('d M Y', strtotime($modBayar->tgl_awal)) ?> - <?php echo date('d M Y', strtotime($modBayar->tgl_akhir)) ?></span>
                    <?php echo $form->hiddenField($modBayar, 'tgl_awal', array('class' => 'start')) ?>
                    <?php echo $form->hiddenField($modBayar, 'tgl_akhir', array('class' => 'end')) ?>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo CHtml::label('No. Kas Keluar', 'nokaskeluar', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textField($modBayar, 'nokaskeluar', array('placeholder' => 'No. Kas Keluar', 'class' => 'span4')); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('No Permintaan', 'nopermintaan', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textField($modBayar, 'nopermintaanpembelian', array('placeholder' => 'No Permintaan', 'class' => 'span4')); ?>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo CHtml::label('Jenis Uang Muka Pembelian', 'supplier_jenis', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->dropDownList($modBayar, 'supplier_jenis', LookupM::getItems('jenissupplier'), array('placeholder' => 'Supplier', 'empty' => '-- Pilih --')) ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('Supplier', 'supplier_id', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->hiddenField($modBayar, 'supplier_id', array('class' => 'span4')); ?>
                <?php
                $this->widget('MyJuiAutoComplete', array(
                    'model' => $modBayar,
                    'attribute' => 'supplier_nama',
                    'sourceUrl' => Yii::app()->createUrl('/keuangan/InfoBayarUangMukaBeli/getSupplierData'),
                    'options' => array(
                        'showAnim' => 'fold',
                        'minLength' => 2,
                        'select' => 'js:function( event, ui ) {
                                                $("#' . CHtml::activeId($modBayar, 'supplier_nama') . '").val(ui.item.supplier_nama); 
                                                $("#' . CHtml::activeId($modBayar, 'supplier_id') . '").val(ui.item.supplier_id);   
                                        }',
                    ),
                    'htmlOptions' => array(
                        'placeholder' => 'Supplier',
                        'onkeypress' => "$(this).focusNextInputField(event)", 'class' => '', 'readonly' => FALSE
                    ),
                    //                                'tombolDialog' => array('idDialog' => 'dialogSupplier'),
                    'tombolDialog' => false,
                ));
                ?>
            </div>
        </div>
    </div>
</div>
<div class="form-actions">
    <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
        array('title' => 'Cari', 'class' => 'btn btn-danger', 'type' => 'submit')
    ); ?>
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
        $this->createUrl($this->id . '/index'),
        array(
            'title' => 'Ulang',
            'class' => 'btn btn-default',
            'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
        )
    ); ?>
    <?php
    $tips = array(
        '1' => 'cari',
        '2' => 'ulang2',
        '0' => 'tanggal',
    );
    $content = $this->renderPartial('sistemAdministrator.views.tips.detailTips', array('tips' => $tips), true);
    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
    ?>
</div>
<?php $this->endWidget(); ?>
<?php
//========= Dialog buat Permintaan Kebutuhan obatAlkes =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogSupplier',
    'options' => array(
        'title' => 'Pencarian Supplier',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'height' => 500,
        'resizable' => false,
    ),
));
$modSupplier = new KUSupplierM;
if (isset($_GET['KUSupplierM'])) {
    $modSupplier->attributes = $_GET['KUSupplierM'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'permintaan-m-grid',
    'dataProvider' => $modSupplier->searchDialog(),
    'filter' => $modSupplier,
    'template' => "{summary}\n{items}{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","javascript:void(0);",array("class"=>"btn-small", 
                                    "id" => "selectPasien",
                                    "onClick" => "
                                                  $(\"#' . CHtml::activeId($modBayar, 'supplier_id') . '\").val(\"$data->supplier_id\");
                                                  $(\"#' . CHtml::activeId($modBayar, 'supplier_nama') . '\").val(\"$data->supplier_nama\");
                                                  $(\"#dialogSupplier\").dialog(\"close\");    
                                        "))',
        ),
        'supplier_kode',
        'supplier_nama',
    ),
    'afterAjaxUpdate' => 'function(id, data){
            $("#testing").datepicker(jQuery.extend({showMonthAfterYear:false}, jQuery.datepicker.regional["id"], {"dateFormat":"dd M yy","timeText":"Waktu","hourText":"Jam","minuteText":"Menit","secondText":"Detik","showSecond":true,"timeOnlyTitle":"Pilih Waktu","timeFormat":"hh:mm:ss","changeYear":true,"changeMonth":true,"showAnim":"fold","yearRange":"-80y:+20y"}));
            jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));
$this->endWidget();
//========= end Permintaan dialog =============================
?>