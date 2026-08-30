<div class="panel panel-success kelengkapan_alat" hidden>
    <div class="panel-heading">
        <div class="panel-title">Kelengkapan Alat HD</div>
    </div>
    <div class="panel-body">
        <div class="row-fluid">
            <div class="span12">
                <div class="control-group">
                    <label>
                        <?php if (count($modResephd) > 0) : ?>
                            <?php foreach ($modResephd as $resep) : ?>
                                <?= $form->radioButton($resep, 'resephd_id', array('value' => 'ya', 'uncheckValue' => null, 'onclick' => 'load_resep(' . $resep->resephd_id . ')')); ?> <label><?= $resep->resephd_nama ?></label>
                            <?php endforeach; ?>
                        <?php endif ?>

                    </label>
                </div>
                <table class="table table-striped" id="table-kelengkapanAlat">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Kelengkapan Alat HD</th>
                            <th>Jumlah</th>
                            <th>Aksi <a href="javascript:void(0)" onclick="addRow()"><i class="icon-plus"></i></a></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (count($modAlatBahan) > 0) : $no = 1; ?>
                            <?php foreach ($modAlatBahan as $key => $row) : ?>
                                <tr class="tr-kelengkapanAlat" baris="<?= $key; ?>">
                                    <td class="td-no" baris="<?= $no ?>"><?= $no++; ?></td>
                                    <td>

                                        <?= $form->HiddenField($modKelengkapanAlat, '[' . $key . ']obatalkes_id', array('onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'required', 'value' => $row->obatalkes_id)); ?>
                                        <?= $form->HiddenField($modKelengkapanAlat, '[' . $key . ']resephd_id', array('onkeypress' => "return $(this).focusNextInputField(event)", 'class' => '', 'value' => $row->resephd_id)); ?>
                                        <?= $form->HiddenField($modKelengkapanAlat, '[' . $key . ']resephd_det_id', array('onkeypress' => "return $(this).focusNextInputField(event)", 'class' => '', 'value' => $row->resephd_det_id)); ?>
                                        <?php
                                        $obatalkes = ObatalkesM::model()->findByPk($row->obatalkes_id);
                                        $modKelengkapanAlat->obatalkes_nama = $obatalkes->obatalkes_nama;
                                        ?>
                                        <?php
                                        $this->widget('MyJuiAutoComplete', array(
                                            'model' => $modKelengkapanAlat,
                                            'attribute' => '[' . $key . ']obatalkes_nama',
                                            'source' => 'js: function(request, response) {
                                                    $.ajax({
                                                            url: "' . $this->createUrl('AutoCompletePerawat') . '",
                                                            dataType: "json",
                                                            data: {
                                                                    term: request.term,
                                                                    perawat_id: $("#perawat1_id").val(),
                                                            },
                                                            success: function (data) {
                                                                    response(data);
                                                            }
                                                    })
                                            }',
                                            'options' => array(
                                                'showAnim' => 'fold',
                                                'minLength' => 3,
                                                'focus' => 'js:function( event, ui ) {
                                                            $(this).val( ui.item.label);
                                                            return false;
                                                     }',
                                                'select' => 'js:function( event, ui ) {
                                                            $("#perawat1_id").val(ui.item.perawat1_id); 
                                                            $("#perawat1_nama").val(ui.item.perawat1_nama);
                                                            return false;
                                                    }',
                                            ),
//                                'tombolDialog' => array('idDialog' => 'dialogPerawat1'),
                                            'tombolDialog' => array('idDialog' => 'dialogKelengkapanAlat', 'jsFunction' => 'setRow(this); $("#dialogKelengkapanAlat").dialog("open")'),
                                            'htmlOptions' => array('class' => 'span4 required'),
                                        ));
                                        ?>
                                    </td>
                                    <td><?= $form->textField($modKelengkapanAlat, '[' . $key . ']jumlah', array('onkeypress' => "return $(this).focusNextInputField(event)", 'class' => '', 'value' => $row->qty_reseptur)); ?></td>
                                    <td>
                                        <a href="javascript:void(0)" onclick="hapusBaris(this)"><i class="icon-minus-sign"></i></a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<input type="hidden" id="nourut">
<?php
//========= Dialog buat cari data Alat Kesehatan ala cak lontong (non racik - therapi obat)  =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogKelengkapanAlat',
    'options' => array(
        'title' => 'Data Kelengkapan Alat HD',
        'autoOpen' => false,
        'position' => ['top', 20],
        'modal' => true,
        'width' => 550,
        'height' => 600,
        'resizable' => false,
    ),
));

$modDialog = new ObatalkesM('searchObat');
$modDialog->unsetAttributes();
if (isset($_GET['ObatalkesM'])) {
    $modDialog->attributes = $_GET['ObatalkesM'];
}

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'therapiobat-grid',
    'dataProvider' => $modDialog->searchObat(),
    'filter' => $modDialog,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
                                    "id" => "selectObat",
                                    "onClick" => "
                                                
                                                setKelengkapan(\"$data->obatalkes_id\", \"$data->obatalkes_nama\");
                                                return false;"))',
        ),
        'obatalkes_nama',
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
?>
<script>

    function setKelengkapan(id, nama) {
        let no = $('#nourut').val();
        $('#KelengkapanAlatHdT_' + no + '_obatalkes_id').val(id);
        $('#KelengkapanAlatHdT_' + no + '_obatalkes_nama').val(nama);
        $('#dialogKelengkapanAlat').dialog('close');
    }
</script>