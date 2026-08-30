<?php $linkHalaman = CustomFunction::getUrlByMenuID(3538); ?>
<?php
$this->breadcrumbs = array(
    'Pengajuan Perubahan Harga Obat dan Alkes',
);
?>
<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'pengajuanhargaobat-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)', 'onsubmit' => 'return requiredCheck(this);'),
));
?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="glyphicon glyphicon-briefcase"></i> Transaksi <b>Pengajuan Perubahan Harga Obat dan Alkes </b>
            <span class="pull-right">
                <a href="<?= !empty($linkHalaman) ? $linkHalaman : '#'; ?>" class="btn btn-default" target="_blank">
                    <i class="fas fa-external-link-alt"></i> Ke Halaman Transaksi
                </a>
            </span>
        </div>
    </div>
    <div class="panel-body">
        <?php
        if (isset($_GET['sukses'])) {
            Yii::app()->user->setFlash('success', "Data Pengajuan Perubahan Harga Obat dan Alkes berhasil disimpan!");
        }
        ?>
        <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="glyphicon glyphicon-file"></i> Data <b>Pengajuan Perubahan Harga</b>
                </div>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="control-group">
                            <div class="control-group">
                                <?php echo $form->labelEx($model, 'nopengajuanhargaoa', array('class' => 'control-label')) ?>
                                <div class="controls">
                                    <?php echo $form->textField($model, 'nopengajuanhargaoa', array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event)")); ?>
                                </div>
                            </div>
                        </div>
                        <div class="control-group">
                            <div class="control-group">
                                <?php echo $form->labelEx($model, 'tglpengajuanhargaoa', array('class' => 'control-label')) ?>
                                <div class="controls">
                                    <?php echo $form->textField($model, 'tglpengajuanhargaoa', array('readonly' => true, 'class' => 'span3 realtime', 'onkeyup' => "return $(this).focusNextInputField(event)")); ?>
                                </div>
                            </div>
                        </div>
                        <div class="control-group">
                            <div class="control-group">
                                <?php echo $form->labelEx($model, 'ketpengajuan', array('class' => 'control-label')) ?>
                                <div class="controls">
                                    <?php echo $form->textArea($model, 'ketpengajuan', array('placeholder' => 'Keterangan Pengajuan', 'class' => 'span3')); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="control-group">
                            <div class="control-group">
                                <?php echo $form->labelEx($model, 'pegawai_id', array('class' => 'control-label')) ?>
                                <div class="controls">
                                    <?php echo $form->hiddenField($model, 'pegawai_id', array('readonly' => true, 'class' => 'span3')); ?>
                                    <?php echo $form->textField($model, 'pegawai_nama', array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event)")); ?>
                                </div>
                            </div>
                        </div>
                        <div class="control-group">
                            <div class="control-group">
                                <?php echo $form->labelEx($model, 'pegawaimengetahui_id', array('class' => 'control-label')) ?>
                                <div class="controls">
                                    <?php echo $form->hiddenField($model, 'pegawaimengetahui_id', array('readonly' => true, 'class' => 'span3')); ?>
                                    <?php echo $form->textField($model, 'pegawaimengetahui_nama', array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event)")); ?>
                                </div>
                            </div>
                        </div>
                        <div class="control-group">
                            <div class="control-group">
                                <?php echo $form->labelEx($model, 'pegawaimenyetujui_id', array('class' => 'control-label')) ?>
                                <div class="controls">
                                    <?php echo $form->hiddenField($model, 'pegawaimenyetujui_id', array('readonly' => true, 'class' => 'span3')); ?>
                                    <?php echo $form->textField($model, 'pegawaimenyetujui_nama', array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event)")); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="far fa-plus-square"></i> Tambah <b>Obat dan Alkes</b>
                </div>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="control-group">
                            <?php echo CHtml::label('Nama Obat dan Alkes', 'obatalkes_nama', array('class' => 'control-label')); ?>
                            <div class="controls">
                                <?php echo CHtml::hiddenField('obatalkes_id', '', array('onkeyup' => "return $(this).focusNextInputField(event)",)); ?>
                                <?php
                                $this->widget('MyJuiAutoComplete', array(
                                    'name' => 'obatalkes_nama',
                                    'source' => 'js: function(request, response) {
                                                            $.ajax({
                                                                    url: "' . $this->createUrl('AutocompleteObatAlkes') . '",
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
                                                                    $(this).val(ui.item.value);
                                                                    $("#obatalkes_id").val(ui.item.obatalkes_id);
                                                                    $("#obatalkes_nama").val(ui.item.obatalkes_nama);
                                                                    return false;
                                                            }',
                                    ),
                                    'htmlOptions' => array(
                                        'class' => '',
                                        'onkeyup' => "return $(this).focusNextInputField(event)",
                                        'onblur' => 'if(this.value === "") $("#obatalkes_id").val(""); '
                                    ),
                                    'tombolDialog' => array('idDialog' => 'dialogObatAlkes'),
                                ));
                                ?>
                            </div>
                            <div class="controls">
                                <?php echo CHtml::htmlButton(
                                    '<i class="icon-plus icon-white"></i>',
                                    array(
                                        'onclick' => 'tambahObatAlkes();return false;',
                                        'class' => 'btn btn-danger',
                                        'onkeyup' => "tambahObatAlkes();",
                                        'rel' => "tooltip",
                                        'title' => "Klik untuk menambahkan Obat dan Alkes"
                                    )
                                ); ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <i class="entypo-credit-card"></i> Tabel <b>Perubahan Harga</b>
                        </div>
                    </div>
                    <div class="panel-body table-responsive">
                        <table class="items table table-bordered table-striped table-condensed" id="table-obatalkespasien">
                            <thead>
                                <tr>
                                    <th rowspan="2">No.</th>
                                    <th rowspan="2">Jenis</th>
                                    <th rowspan="2">Nama Obat</th>
                                    <th rowspan="2">Satuan</th>
                                    <th colspan="6" style="text-align: center">Lama</th>
                                    <th colspan="6" style="text-align: center">Baru</th>
                                    <th rowspan="2">Alasan Perubahan <span style="color:red">*</span></th>
                                    <th rowspan="2">Batal</th>
                                </tr>
                                <tr>
                                    <th>Harga Netto</th>
                                    <th>Keringanan</th>
                                    <th>PPN</th>
                                    <th>HPP</th>
                                    <th>Margin (%)</th>
                                    <th>Harga Jual</th>
                                    <th>Harga Netto</th>
                                    <th>Keringanan</th>
                                    <th>PPN</th>
                                    <th>HPP</th>
                                    <th>Margin (%)</th>
                                    <th>Harga Jual</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if (count((array)$modDetails) > 0) {
                                    foreach ($modDetails as $i => $dataDetail) {
                                        $modObatAlkes = ObatalkesM::model()->findByPk($dataDetail->obatalkes_id);
                                        //                                                            $modPermintaanPembelianDetail->jmlpermintaan = number_format($modPermintaanPembelianDetail->jmlpermintaan,2,",",".");
                                        echo $this->renderPartial($this->path_view . '_rowPerubahanHarga', array('modDetail' => $dataDetail, 'modObatAlkes' => $modObatAlkes));
                                    }
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="form-actions">
        <?php
        if (!isset($_GET['sukses'])) {
            echo CHtml::htmlButton(
                Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
                array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'button', 'onclick' => 'cekObat();', 'onkeypress' => 'cekObat();')
            );
        } else {
            echo CHtml::htmlButton(
                Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
                array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'submit', 'onclick' => 'formSubmit(this,event);', 'onkeypress' => 'formSubmit(this,event);', 'disabled' => true)
            );
        }
        echo CHtml::link(
            Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
            $this->createUrl($this->id . '/index'),
            array(
                'title' => 'Ulang',
                'class' => 'btn btn-default',
                'onclick' => 'return refreshForm(this);'
            )
        );
        if (!isset($_GET['sukses'])) {
            echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'disabled' => 'true'));
        } else {
            echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'onclick' => "print('PRINT')"));
        }
        $content = $this->renderPartial($this->path_view . 'tips/tipsPermintaanPembelian', array(), true);
        $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
        ?>
    </div>
</div>
<?php $this->endWidget(); ?>
<?php $this->renderPartial($this->path_view . '_jsFunctions', array('model' => $model)); ?>
<?php
//========= Dialog buat cari data Alat Kesehatan =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogObatAlkes',
    'options' => array(
        'title' => 'Master Obat dan Alkes',
        'autoOpen' => false,
        'modal' => true,
        'width' => 980,
        'height' => 500,
        'resizable' => false,
    ),
));
$modObatAlkes = new GFObatalkesM('searchDialog');
$modObatAlkes->unsetAttributes();
if (isset($_GET['GFObatalkesM'])) {
    $modObatAlkes->attributes = $_GET['GFObatalkesM'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'obatalkes-m-grid',
    'dataProvider' => $modObatAlkes->searchDialog(),
    'filter' => $modObatAlkes,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
                                    "id" => "selectObat",
                                    "onClick" => "
                                        $(\'#obatalkes_id\').val($data->obatalkes_id);
                                        $(\'#obatalkes_nama\').val(\'$data->obatalkes_nama\');
                                        $(\'#dialogObatAlkes\').dialog(\'close\');
                                        return false;"
                                        ))',
        ),
        array(
            'header' => 'Jenis',
            'name' => 'jenisobatalkes_id',
            'type' => 'raw',
            'value' => '(!empty($data->jenisobatalkes_id) ? $data->jenisobatalkes->jenisobatalkes_nama : "")',
            'filter' => CHtml::dropDownList('GFObatalkesM[jenisobatalkes_id]', $modObatAlkes->jenisobatalkes_id, CHtml::listData($modObatAlkes->getJenisObatAlkesItems(), 'jenisobatalkes_id', 'jenisobatalkes_nama'), array('empty' => '-- Pilih --'))
        ),
        array(
            'header' => 'Kategori',
            'name' => 'obatalkes_kategori',
            'value' => '$data->obatalkes_kategori',
            'filter' => CHtml::dropDownList('GFObatalkesM[obatalkes_kategori]', $modObatAlkes->obatalkes_kategori, LookupM::getItems('obatalkes_kategori'), array('empty' => '-- Pilih --'))
        ),
        array(
            'header' => 'Golongan',
            'name' => 'obatalkes_golongan',
            'value' => '$data->obatalkes_golongan',
            'filter' => CHtml::dropDownList('GFObatalkesM[obatalkes_golongan]', $modObatAlkes->obatalkes_golongan, LookupM::getItems('obatalkes_golongan'), array('empty' => '-- Pilih --'))
        ),
        'obatalkes_nama',
        array(
            'name' => 'satuankecil_id',
            'type' => 'raw',
            'value' => '$data->satuankecil->satuankecil_nama',
            'filter' => CHtml::dropDownList('GFObatalkesM[satuankecil_id]', $modObatAlkes->satuankecil_id, CHtml::listData($modObatAlkes->getSatuanKecilItems(), 'satuankecil_id', 'satuankecil_nama'), array('empty' => '-- Pilih --'))
        ),
        array(
            'name' => 'hargajual',
            'type' => 'raw',
            'value' => '"Rp ".MyFormatter::formatNumberForPrint($data->hargajual)',
            'filter' => false,
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));
$this->endWidget('zii.widgets.jui.CJuiDialog');
?>