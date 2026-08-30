<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-search"></i> Pencarian
        </div>
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="col-sm-12">
                <div class="control-group">
                    <?php echo CHtml::label("Tgl. Faktur <span class='required'>*</span>", '', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php
                        $model->tgl_awal = date('Y-m-d');
                        $model->tgl_akhir = date('Y-m-d');
                        ?>
                        <div class="daterange daterange-inline input-inline span4" data-format="DD MMM YYYY" data-start-date="<?php echo date('d M Y', strtotime($model->tgl_awal)) ?>" data-end-date="<?php echo date('d M Y', strtotime($model->tgl_akhir)) ?>">
                            <i class="entypo-calendar"></i>
                            <span><?php echo date('d M Y', strtotime($model->tgl_awal)) ?> - <?php echo date('d M Y', strtotime($model->tgl_akhir)) ?></span>
                            <?php echo CHtml::hiddenField('tgl_awal', $model->tgl_awal, array('class' => 'start')) ?>
                            <?php echo CHtml::hiddenField('tgl_akhir', $model->tgl_akhir, array('class' => 'end')) ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="control-group">
                    <?php echo CHtml::label("Supplier <span class='required'>*</span>", '', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo CHtml::hiddenField('supplier_id') ?>
                        <?php
                        $this->widget('MyJuiAutoComplete', array(
                            'name' => 'supplier_nama',
                            'source' => 'js: function(request, response) {
                                                $.ajax({
                                                    url: "' . $this->createUrl('AutocompleteMasterSupplier') . '",
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
                                             $("#supplier_id").val(ui.item.supplier_id);
                                             $("#jenissupplier").val(ui.item.supplier_jenis);
                                             $("#' . CHtml::activeId($modBuktiKeluar, 'namapenerima') . '").val(ui.item.supplier_nama);
                                             $("#' . CHtml::activeId($modBuktiKeluar, 'alamatpenerima') . '").val(ui.item.supplier_alamat);
                                             return false;
                                         }',
                            ),
                            'htmlOptions' => array('placeholder' => 'Supplier', 'class' => 'span4'),
                            'tombolDialog' => array('idDialog' => 'dialogSupplier',),
                        ));
                        ?>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="control-group">
                    <?php echo CHtml::label("Jenis Supplier", '', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo CHtml::textField('jenissupplier', '', array('class' => 'span4', 'readonly' => true)); ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-actions">
            <?php echo CHtml::htmlButton(
                Yii::t('mds', '{icon} Cari', array('{icon}' => '<i class="entypo-search"></i>')),
                array('title' => 'Cari', 'class' => 'btn btn-primary', 'type' => 'button', 'onclick' => 'loadDataFaktur();')
            ); ?>
        </div>
    </div>
</div>
<?php
//========= Dialog buat cari data Rek Kredit =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogSupplier',
    'options' => array(
        'title' => 'Daftar Supplier',
        'autoOpen' => false,
        'modal' => true,
        'width' => 600,
        'height' => 400,
        'resizable' => false,
    ),
));
$modSupplier = new SupplierM();
$modSupplier->unsetAttributes();
if (isset($_GET['SupplierM'])) {
    $modSupplier->attributes = $_GET['SupplierM'];
}
$this->widget('ext.bootstrap.widgets.HeaderGroupGridView', array(
    'id' => 'supplier-m-grid',
    //'ajaxUrl'=>Yii::app()->createUrl('actionAjax/CariDataPasien'),
    'dataProvider' => $modSupplier->searchDialog(),
    'filter' => $modSupplier,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small",
				"id" => "selectRekDebit",
				"onClick" =>"
					$(\"#supplier_id\").val(\"$data->supplier_id\");
          $(\"#supplier_nama\").val(\"$data->supplier_nama\");
					$(\"#jenissupplier\").val(\"$data->supplier_jenis\");
          $(\"#' . CHtml::activeId($modBuktiKeluar, 'namapenerima') . '\").val(\"$data->supplier_nama\");
          $(\"#' . CHtml::activeId($modBuktiKeluar, 'alamatpenerima') . '\").val(\"$data->supplier_alamat\");
					$(\"#dialogSupplier\").dialog(\"close\");
					return false;
			"))',
        ),
        array(
            'header' => 'No.',
            'value' => '$this->grid->dataProvider->Pagination->CurrentPage*$this->grid->dataProvider->pagination->pageSize+$row+1',
        ),
        array(
            'header' => 'Kode Supplier',
            'name' => 'supplier_kode',
            'value' => '$data->supplier_kode',
        ),
        array(
            'header' => 'Nama Supplier',
            'name' => 'supplier_nama',
            'value' => '$data->supplier_nama',
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));
$this->endWidget();
//========= end Rek Kredit dialog =============================
?>