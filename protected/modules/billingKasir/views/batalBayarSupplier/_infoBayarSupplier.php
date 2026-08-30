<?php $this->widget('bootstrap.widgets.BootAlert'); ?>

<div class="row">
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo $form->labelEx($modBuktiKeluar, 'nokaskeluar', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php
                if (isset($_GET['tandabuktikeluar_id'])) {
                    echo $form->textField($modBuktiKeluar, 'nokaskeluar', array('placeholder' => 'No. Kas Keluar', 'readonly' => true, 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);"));
                } else {
                    $this->widget('MyJuiAutoComplete', array(
                        'name' => 'BKTandabuktikeluarT[nokaskeluar]',
                        'value' => $modBuktiKeluar->nokaskeluar,
                        'source' => 'js: function(request, response) {
									$.ajax({
										url: "' . $this->createUrl('infoBayarSupplier') . '",
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
										$(this).val(ui.item.value);
										return false;
									 }',
                            'select' => 'js:function( event, ui ) {
										isiInfoBayarSupplier(ui.item);
										return false;
									 }',
                        ),
                        'tombolDialog' => array('idDialog' => 'dialogBayarSupplier'),
                        'htmlOptions' => array('class' => 'span3', 'placeholder' => 'No. Kas Keluar',),
                    ));
                }

                ?>
            </div>
        </div>
        <?php echo $form->textFieldRow($modBuktiKeluar, 'tglkaskeluar', array('readonly' => true, 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
        <?php // echo $form->textFieldRow($modBuktiKeluar,'tahun',array('readonly'=>true,'class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>4)); 
        ?>
        <?php echo $form->textFieldRow($modBuktiKeluar, 'carabayarkeluar', array('readonly' => true, 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
        <?php if ($modBuktiKeluar->carabayarkeluar == Params::CARAPEMBAYARAN_TRANSFER) { ?>
            <?php echo $form->textFieldRow($modBuktiKeluar, 'melalubank', array('readonly' => true, 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
            <?php echo $form->textFieldRow($modBuktiKeluar, 'denganrekening', array('readonly' => true, 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
            <?php echo $form->textFieldRow($modBuktiKeluar, 'atasnamarekening', array('readonly' => true, 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
        <?php } ?>

        <?php echo $form->textFieldRow($modBuktiKeluar, 'namapenerima', array('readonly' => true, 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
        <?php echo $form->textAreaRow($modBuktiKeluar, 'alamatpenerima', array('readonly' => true, 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
    </div>
    <div class="col-sm-6">
        <?php echo $form->textFieldRow($modBayarSupplier, 'tglbayarkesupplier', array('readonly' => true, 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
        <?php echo $form->textFieldRow($modBuktiKeluar, 'untukpembayaran', array('readonly' => true, 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
        <?php echo $form->textFieldRow($modBayarSupplier, 'totaltagihan', array('style' => 'text-align:right;', 'readonly' => true, 'class' => 'integer2 span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
        <?php echo $form->textFieldRow($modBayarSupplier, 'jmldibayarkan', array('style' => 'text-align:right;', 'readonly' => true, 'class' => 'integer2 span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
        <?php echo $form->textFieldRow($modBuktiKeluar, 'biayaadministrasi', array('style' => 'text-align:right;', 'readonly' => true, 'class' => 'integer2 span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
        <?php echo $form->textFieldRow($modBuktiKeluar, 'jmlkaskeluar', array('style' => 'text-align:right;', 'readonly' => true, 'class' => 'integer2 span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
        <?php echo $form->textAreaRow($modBuktiKeluar, 'keterangan_pengeluaran', array('readonly' => true, 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
    </div>
</div>

<script type="text/javascript">
    function isiInfoBayarSupplier(data) {
        $('#<?php echo CHtml::activeId($modBuktiKeluar, 'tglkaskeluar'); ?>').val(data.tglkaskeluar);
        $('#<?php echo CHtml::activeId($modBuktiKeluar, 'tahun'); ?>').val(data.tahun);
        $('#<?php echo CHtml::activeId($modBuktiKeluar, 'carabayarkeluar'); ?>').val(data.carabayarkeluar);
        $('#<?php echo CHtml::activeId($modBuktiKeluar, 'melalubank'); ?>').val(data.melalubank);
        $('#<?php echo CHtml::activeId($modBuktiKeluar, 'denganrekening'); ?>').val(data.denganrekening);
        $('#<?php echo CHtml::activeId($modBuktiKeluar, 'atasnamarekening'); ?>').val(data.atasnamarekening);
        $('#<?php echo CHtml::activeId($modBuktiKeluar, 'namapenerima'); ?>').val(data.namapenerima);
        $('#<?php echo CHtml::activeId($modBuktiKeluar, 'alamatpenerima'); ?>').val(data.alamatpenerima);
        $('#<?php echo CHtml::activeId($modBuktiKeluar, 'untukpembayaran'); ?>').val(data.untukpembayaran);
        $('#<?php echo CHtml::activeId($modBuktiKeluar, 'jmlkaskeluar'); ?>').val(data.jmlkaskeluar);
        $('#<?php echo CHtml::activeId($modBuktiKeluar, 'biayaadministrasi'); ?>').val(data.biayaadministrasi);
        $('#<?php echo CHtml::activeId($modBuktiKeluar, 'jmldibayarkan'); ?>').val(data.jmldibayarkan);

        $('#<?php echo CHtml::activeId($modBayarSupplier, 'tglbayarkesupplier'); ?>').val(data.tglbayarkesupplier);
        $('#<?php echo CHtml::activeId($modBayarSupplier, 'totaltagihan'); ?>').val(data.totaltagihan);
        $('#<?php echo CHtml::activeId($modBayarSupplier, 'jmldibayarkan'); ?>').val(data.jmldibayarkan);
        $('#<?php echo CHtml::activeId($modBatalBayar, 'tandabuktikeluar_id'); ?>').val(data.tandabuktikeluar_id);
        $('#<?php echo CHtml::activeId($modBatalBayar, 'bayarkesupplier_id'); ?>').val(data.bayarkesupplier_id);

        $('.currency').each(function() {
            this.value = formatNumber(this.value)
        })
    }

    function cekLogin() {
        $.post('<?php echo $this->createUrl('CekLogin', array('task' => 'Retur')); ?>', $('#formLogin').serialize(), function(data) {
            if (data.error != '')
                myAlert(data.error);
            $('#' + data.cssError).addClass('error');
            if (data.status == 'success') {
                $('#BKBatalBayarSupplierT_user_name_otoritasi').val(data.username);
                $('#BKBatalBayarSupplierT_user_id_otorisasi').val(data.userid);
                $('#loginDialog').dialog('close');
            } else {
                myAlert(data.status);
            }
        }, 'json');
    }

    function cekOtorisasi() {
        if ($('#BKBatalBayarSupplierT_user_name_otoritasi').val() == '' || $('#BKBatalBayarSupplierT_user_id_otorisasi').val() == '') {
            $('#loginDialog').dialog('open');
            return false;
        }

        $('.currency').each(function() {
            this.value = unformatNumber(this.value)
        });
        return true;
    }

    $(document).ready(function() {
        formatNumberSemua();
    });
</script>

<?php
//========= Dialog buat cari data pendaftaran / kunjungan =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogBayarSupplier',
    'options' => array(
        'title' => 'Pencarian Data Bayar Supplier',
        'autoOpen' => false,
        'modal' => true,
        'width' => 1100,
        'height' => 550,
        'resizable' => false,
    ),
));
$modBayarSupplier = new TandabuktikeluarT();
$modBayarSupplier->unsetAttributes();
if (isset($_GET['TandabuktikeluarT'])) {
    $modBayarSupplier->attributes = $_GET['TandabuktikeluarT'];
}

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'datakunjungan-grid',
    'dataProvider' => $modBayarSupplier->searchBayarSupplier(),
    'filter' => $modBayarSupplier,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => function ($data) use (&$sup) {
                $sup = BayarkesupplierT::model()->findByPk($data->bayarkesupplier_id);
                // $data->jmlkaskeluar = MyFormatter::formatNumberForPrint($data->jmlkaskeluar);
                $res = $data->attributes;
                $res['label'] = $data->nokaskeluar . ' - ' . $data->namapenerima;
                $res['value'] = $data->nokaskeluar;
                $res['jmlkaskeluar'] = MyFormatter::formatNumberForPrint($data->jmlkaskeluar);
                $res['tglkaskeluar'] = MyFormatter::formatDateTimeForUser($data->tglkaskeluar);
                if (!empty($sup)) {
                    $res['tglbayarkesupplier'] = MyFormatter::formatDateTimeForUser($sup->tglbayarkesupplier);
                    $res['totaltagihan'] = MyFormatter::formatNumberForPrint($sup->totaltagihan);
                    $res['jmldibayarkan'] = MyFormatter::formatNumberForPrint($sup->jmldibayarkan);
                }
                return CHtml::Link("<i class='icon-form-check'></i>", "javascript:void(0);", array(
                    "class" => "btn-small",
                    "id" => "selectSupplier",
                    "onClick" => "
                                            isiInfoBayarSupplier(" . CJSON::encode($res) . ");
											$('#BKTandabuktikeluarT_nokaskeluar').val('" . $data->nokaskeluar . "');
                                            $('#dialogBayarSupplier').dialog('close');
                                        "
                ));
            },
            /*
						'CHtml::Link("<i class=\"icon-form-check\"></i>","javascript:void(0);",array("class"=>"btn-small", 
                                        "id" => "selectPendaftaran",
                                        "onClick" => "
                                            setKunjungan($data->pendaftaran_id, \"\", \"\", \"\");
                                            $(\"#dialogKunjungan\").dialog(\"close\");
                                        "))',
						 * 
						 */
        ),
        array(
            'header' => 'No. Kas Keluar',
            'name' => 'nokaskeluar',
        ),
        array(
            'name' => 'tglkaskeluar',
            'value' => 'MyFormatter::formatDateTimeForUser($data->tglkaskeluar)',
            'filter' => false,
        ),
        array(
            'name' => 'namapenerima',
        ),
        array(
            'name' => 'carabayarkeluar',
            'filter' => CHtml::activeDropDownList($modBayarSupplier, 'carabayarkeluar', LookupM::getItems('carabayarkeluar'), array('empty' => '-- Pilih --', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")),
        ),
        array(
            'name' => 'jmlkaskeluar',
            'value' => 'MyFormatter::formatNumberForPrint($data->jmlkaskeluar)',
            'filter' => false,
            'htmlOptions' => array('style' => 'text-align: right;'),
        ),

    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
////======= end pendaftaran dialog =============
?>