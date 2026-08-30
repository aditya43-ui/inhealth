<div class="row">
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo CHtml::label('No Permintaan Pembelian <span class="required">*</span>', '', array('class' => 'control-label required')); ?>
            <?php echo CHtml::activeHiddenField($modUangMuka, 'supplier_id', array('readonly' => true)); ?>
            <?php echo CHtml::activeHiddenField($modUangMuka, 'permintaanpembelian_id', array('readonly' => true)); ?>
            <?php echo CHtml::activeHiddenField($modUangMuka, 'typepermintaan', array('readonly' => true)); ?>
            <div class="controls">
                <?php
                $this->widget('MyJuiAutoComplete', array(
                    'model' => $modPermintaan,
                    'attribute' => 'nopermintaan',
                    'source' => 'js: function(request, response) {
							$.ajax({
								url: "' . Yii::app()->createUrl('keuangan/BayarUangMukaBeli/daftarNoPermintaan') . '",
								dataType: "json",
								data: {
									term: request.term,
								},
								success: function (data) {
									response(data);
								}
							})
						}',
                    'options' => array(
                        'showAnim' => 'fold',
                        'minLength' => 2,
                        'focus' => 'js:function( event, ui ) {
								$(this).val("");
								return false;
							 }',
                        'select' => 'js:function( event, ui ) {
								isiDataSupplier(ui.item);
								return false;
							 }',
                    ),
                    'tombolDialog' => array('idDialog' => 'dialogSupplier'),
                    'htmlOptions' => array(
                        'class' => 'span3', 'rel' => 'tooltip', 'placeholder' => 'No. Permintaan Pembelian'
                    ),
                ));
                ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('Tgl. Permintaan Pembelian', '', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo CHtml::activeTextField($modPermintaan, 'tglpermintaan', array('readonly' => true, 'class' => 'span3')); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('Supplier', '', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo CHtml::activeTextField($modPermintaan, 'supplier_nama', array('readonly' => true, 'class' => 'span3')); ?>
            </div>
        </div>

    </div>
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo CHtml::label('No Referensi', '', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo CHtml::activeTextField($modPermintaan, 'noreferensi', array('readonly' => true, 'class' => 'span3')); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('Keterangan', '', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo CHtml::activeTextArea($modPermintaan, 'keterangan', array('readonly' => true, 'class' => 'span3')); ?>
            </div>

        </div>
        <div class="control-group">
            <?php echo CHtml::label('Total Permintaan Pembelian', '', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo CHtml::activeTextField($modUangMuka, 'totalpo', array('readonly' => true, 'class' => 'span3 integer-decimal')); ?>
            </div>
        </div>
    </div>
</div>

<?php
//========= Dialog buat cari data Alat Kesehatan =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogSupplier',
    'options' => array(
        'title' => 'Data Permintaan Pembelian',
        'autoOpen' => false,
        'modal' => true,
        'width' => 980,
        'height' => 620,
        'resizable' => false,
    ),
));

$modPermintaanToUangMuka = new KUPermintaanpembeliantouangmukaV();
$modPermintaanToUangMuka->unsetAttributes();
$modPermintaanToUangMuka->tglpermintaan = date('m/d/Y') . ' - ' . date('m/d/Y');
if (isset($_GET['KUPermintaanpembeliantouangmukaV'])) {
    $modPermintaanToUangMuka->attributes = $_GET['KUPermintaanpembeliantouangmukaV'];
}

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'supplier-m-grid',
    'dataProvider' => $modPermintaanToUangMuka->searchDialog(),
    'filter' => $modPermintaanToUangMuka,
    'template' => "{summaryNonPage}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(

        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => function ($data) {
                $data->tglpermintaan = MyFormatter::formatDateTimeForUser($data->tglpermintaan);
                $data->tglpermintaanuangmuka = MyFormatter::formatDateTimeForUser($data->tglpermintaanuangmuka);

                $supplierMod = SupplierM::model()->findByPk($data->supplier_id);
                $data->supplier_alamat = (isset($supplierMod) ? $supplierMod->supplier_alamat : "");

                return CHtml::Link("<i class=\"icon-form-check\"></i>", "javascript:void(0);", array(
                    "class" => "btn-small",
                    "id" => "selectObat",
                    "onclick" => 'isiDataSupplier(' . json_encode($data->attributes) . ',"' . date('d M Y', strtotime(MyFormatter::formatDateTimeForDb($data->tglpermintaan))) . '","' . $data->supplier_alamat . '");'
                        . ' $(\'#dialogSupplier\').dialog(\'close\');'
                ));
            },
        ),
        array(
            'header' => 'No. Permintaan',
            'name' => 'nopermintaan',
            'value' => '$data->nopermintaan',
            'filter' => Chtml::activeTextField($modPermintaanToUangMuka, 'nopermintaan')
        ),
        array(
            'header' => 'Tgl. Permintaan',
            'name' => 'tglpermintaan',
            'type' => 'raw',
            'value' => 'MyFormatter::formatDateTimeForUser($data->tglpermintaan)',
            'filter' => CHtml::activeTextField($modPermintaanToUangMuka, 'tglpermintaan', array('class' => 'span3', 'readonly' => true)),
            //                'filter' => CHtml::activeTextField($modPermintaanToUangMuka, 'tglpermintaan', array('class' => 'span3', 'readonly' => true)),
            //                'filter'=>$this->widget('MyDateTimePicker', array(
            //                    'model'=>$modPermintaanToUangMuka,
            //                    'attribute'=>'tglpermintaan',
            //                    'mode' => 'date',
            //                    'htmlOptions' => array(
            //                        'id' => 'datepicker_for_due_date',
            //                        'size' => '10',
            //                        'style'=>'width:80%'
            //                    ),
            //                    'options' => array(  // (#3)
            //                        'dateFormat' => Params::DATE_FORMAT,
            //                        'maxDate' => 'd',
            //                    ),

            //                ),
            //                true),
        ),
        array(
            'header' => 'Supplier',
            'name' => 'supplier_nama',
            'value' => '$data->supplier_nama',
            'filter' => Chtml::activeTextField($modPermintaanToUangMuka, 'supplier_nama')
        ),
        array(
            'header' => 'No. Referensi',
            'name' => 'noreferensi',
            'value' => '$data->noreferensi',
            'filter' => Chtml::activeTextField($modPermintaanToUangMuka, 'noreferensi')
        ),
        array(
            'header' => 'Total Harga',
            'type' => 'raw',
            'value' => '"Rp ". (!empty($data->totalharga)? MyFormatter::formatNumberForPrint($data->totalharga, 2): "-")',
            'filter' => false
        ),
        array(
            'header' => 'Jumlah Permintaan Uang Muka',
            'type' => 'raw',
            'value' => '"Rp ". (!empty($data->jmlpermintaanuangmuka)? MyFormatter::formatNumberForPrint($data->jmlpermintaanuangmuka, 2): "-")',
            'filter' => false
        ),
        array(
            'header' => 'Jumlah Pembayaran',
            'type' => 'raw',
            'value' => '"Rp ". (!empty($data->jumlahuangmuka)? MyFormatter::formatNumberForPrint($data->jumlahuangmuka, 2): "-")',
            'filter' => false
        ),
        array(
            'header' => 'Jumlah Sisa Permintaan Uang Muka',
            'type' => 'raw',
            'value' => '"Rp ". (!empty($data->jmlsisauangmuka)? MyFormatter::formatNumberForPrint($data->jmlsisauangmuka, 2): "-")',
            'filter' => false
        ),

    ),
    'afterAjaxUpdate' => 'function(id, data){
							 jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});
							 $(\'input[name="KUPermintaanpembeliantouangmukaV[tglpermintaan]"]\').daterangepicker({
	 							"maxDate": "' . date('m/d/Y') . '",
	 							"showDropdowns": true,
	 						}, afterPilihTanggal);

					}',
));

$this->endWidget();
?>

<script type="text/javascript">
    function isiDataSupplier(data, tgl, alamat) {
        $('#<?php echo CHtml::activeId($modUangMuka, 'supplier_id'); ?>').val(data.supplier_id);
        $('#<?php echo CHtml::activeId($modUangMuka, 'permintaanpembelian_id'); ?>').val(data.permintaanpembelian_id);
        $('#<?php echo CHtml::activeId($modUangMuka, 'typepermintaan'); ?>').val(data.typepermintaan);
        $('#<?php echo CHtml::activeId($modPermintaan, 'nopermintaan'); ?>').val(data.nopermintaan);
        $('#<?php echo CHtml::activeId($modPermintaan, 'tglpermintaan'); ?>').val(data.tglpermintaan);
        $('#<?php echo CHtml::activeId($modPermintaan, 'supplier_nama'); ?>').val(data.supplier_nama);
        $('#<?php echo CHtml::activeId($modPermintaan, 'noreferensi'); ?>').val(data.noreferensi);
        $('#<?php echo CHtml::activeId($modPermintaan, 'keterangan'); ?>').val(data.keterangan);
        $('#<?php echo CHtml::activeId($modPermintaan, 'tglpermintaanuangmuka'); ?>').val(data.tglpermintaanuangmuka);
        var jmlpermintaan = (data.jmlpermintaanuangmuka - data.jumlahuangmuka);
        $('#<?php echo CHtml::activeId($modPermintaan, 'jmlpermintaanuangmuka'); ?>').val(jmlpermintaan);
        $('#<?php echo CHtml::activeId($modUangMuka, 'totalpo'); ?>').val(data.totalharga);

        $('#<?php echo CHtml::activeId($modUangMuka, 'jumlahuang'); ?>').val(jmlpermintaan);
        console.log(data.tglpouangmuka);
        $('#<?php echo CHtml::activeId($modPermintaan, 'tglpouangmuka'); ?>').val(tgl);
        $('#<?php echo CHtml::activeId($modBuktiKeluar, 'namapenerima'); ?>').val(data.supplier_nama);
        $('#<?php echo CHtml::activeId($modBuktiKeluar, 'alamatpenerima'); ?>').val(alamat);

        getSebagaiPembayaran();
        hitungKasKeluar();

        //    $('.currency').each(function(){this.value = formatNumber(this.value)})
    }

    function afterPilihTanggal(start, end) {
        $.fn.yiiGridView.update('supplier-m-grid', {
            data: $("#supplier-m-grid thead :input").serialize()
        });
    }
    $(document).ready(function() {
        $('input[name="KUPermintaanpembeliantouangmukaV[tglpermintaan]"]').daterangepicker({
            "maxDate": "<?php echo date('m/d/Y') ?>",
            "showDropdowns": true
        }, afterPilihTanggal);
    });
</script>