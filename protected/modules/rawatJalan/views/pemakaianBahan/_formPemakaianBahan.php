<div class="row" id="form_pilih_obat">
    <div class="col-sm-6">
        <div class="control-group">
            <label class="control-label" for="namaObat">Nama Obat Alkes</label>
            <div class="controls">
                <?php echo CHtml::hiddenField('url', $this->createUrl('', array('pendaftaran_id' => $modPendaftaran->pendaftaran_id)), array('readonly' => TRUE)); ?>
                <?php echo CHtml::hiddenField('berubah', '', array('readonly' => TRUE)); ?>
                <?php echo CHtml::hiddenField('obatalkes_id'); ?>
                <?php echo CHtml::hiddenField('obatalkes_kode'); ?>
                <?php echo CHtml::hiddenField('qty_stok'); ?>
                <?php echo CHtml::hiddenField('satuankecil_id'); ?>
                <?php echo CHtml::hiddenField('satuankecil_nama'); ?>
                <?php echo CHtml::hiddenField('hargajual'); ?>
                <?php echo CHtml::hiddenField('harganetto'); ?>
                <?php echo CHtml::hiddenField('obatalkes_nama'); ?>
                <?php echo CHtml::hiddenField('sumberdana_id'); ?>
                <?php
                $this->widget('MyJuiAutoComplete', array(
                    'name' => 'namaObatNonRacik',
                    'source' => 'js: function(request, response) {
                            $.ajax({
                               url: "' . $this->createUrl('AutocompleteObatAlkes') . '",
                               dataType: "json",
                               data: {
                                    term: request.term,
                                    sumberdana_id: $("#sumberdana_id").val(),
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
                                $(this).val( ui.item.label);
                                return false;
                            }',
                        'select' => 'js:function( event, ui ) {
                                $(this).val(ui.item.value);
                                $("#obatalkes_id").val(ui.item.obatalkes_id);
                                $("#obatalkes_kode").val(ui.item.obatalkes_kode);
                                $("#qty_stok").val(ui.item.qty_stok);
                                $("#satuankecil_id").val(ui.item.satuankecil_id);
                                $("#satuankecil_nama").val(ui.item.satuankecil_nama);
                                $("#hargajual").val(ui.item.hargajual);
                                $("#harganetto").val(ui.item.harganetto);
                                $("#obatalkes_nama").val(ui.item.obatalkes_nama);
                                $("#namaObatNonRacik").val(ui.item.obatalkes_nama);
                                $("#sumberdana_id").val(ui.item.sumberdana_id);
                                return false;
                            }',
                    ),
                    'htmlOptions' => array(
                        'placeholder' => 'Nama Obat & Kesehatan',
                        'onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span3'
                    ),
                    'tombolDialog' => array('idDialog' => 'dialogAlkes'),
                ));
                ?>
                <!--</div>-->
                <?php //echo CHtml::link('<i class="entypo-search"></i>', '#', array('class' => 'btn btn-danger','onclick'=>'$("#dialogAlkes").dialog("open");return false;')); 
                ?>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="control-group">
            <label class="control-label" for="jumlah">Jumlah</label>
            <div class="controls">
                <?php echo CHtml::textField('qty_input', MyFormatter::formatNumberForPrint(1,2), array('readonly' => false, 'onblur' => '$("#qty").val(this.value);totalKonversi();', 'onkeyup' => "return $(this).focusNextInputField(event)", 'class' => 'span1 integer-decimal')) ?>
                / <?php echo CHtml::textField('jmlkemasan', MyFormatter::formatNumberForPrint(1,2), array('readonly' => true, 'onblur' => '$("#jmlkemasan").val(this.value);', 'onkeyup' => "return $(this).focusNextInputField(event)", 'class' => 'span1 integer-decimal', 'readonly' => true, 'style' => 'text-align: right;')) ?> <span id="satuanterkecil_nama"></span> =
                <?php echo CHtml::textField('konversi', MyFormatter::formatNumberForPrint(1,2), array('readonly' => true, 'onblur' => '$("#konversi").val(this.value);', 'onkeyup' => "return $(this).focusNextInputField(event); totalJumlah();", 'class' => 'span2 integer-decimal', 'style' => 'text-align:right;')) ?> <span id="satuankecil_nama"></span>
                <?php echo CHtml::htmlButton(
                    '<i class="icon-plus icon-white"></i>',
                    array(
                        'onclick' => 'inputPemakaianBahan(this);return false;',
                        'class' => 'btn btn-primary',
                        'onkeyup' => "inputPemakaianBahan(this);",
                        'rel' => "tooltip",
                        'title' => "Klik untuk menambahkan BHP",
                    )
                ); ?>
            </div>
        </div>
    </div>
</div>

<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-credit-card"></i> Tabel <storng>Obat &amp; Kesehatan</storng>
        </div>
    </div>
    <div class="panel-body table-responsive">
        <!--<legend>
                <?php //echo CHtml::dropDownList('daftartindakanPemakaianBahan', '',array()) 
                ?>
                <?php //echo CHtml::link('<i class="icon-plus icon-white"></i>', '#', array('class' => 'btn btn-danger','onclick'=>'$("#dialogAlkes").dialog("open");return false;')); 
                ?>
                Pemakaian Bahan
            </legend>-->
        <table class="items table table-bordered table-striped table-condensed" id="tblInputPemakaianBahan">
            <thead>
                <tr>
                    <th>&nbsp;</th>
                    <th>Bahan Obat & Kesehatan</th>
                    <th style="text-align:right;">Harga</th>
                    <th>Jumlah</th>
                    <!--<th>Sub Total</th>-->
                    <th>&nbsp;</th>
                </tr>
            </thead>
            <tbody>

            </tbody>
        </table>
        <div hidden>
            <!--<b>Total Pemakaian Bahan : </b>-->
            <b>Total & Jumlah Pemakaian Bahan : </b>
            <?php //echo CHtml::textField("totPemakaianBahan", 0,array('readonly'=>true,'class'=>'inputFormTabel integer')); 
            ?>
            <?php echo CHtml::textField("totQtyPemakaianBahan", 0, array('readonly' => true, 'class' => 'inputFormTabel integer')); ?>
        </div>
    </div>
</div>

<?php
//========= Dialog buat cari data Alat Kesehatan =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogAlkes',
    'options' => array(
        'title' => 'Obat Alkes',
        'autoOpen' => false,
        'modal' => true,
        'width' => 750,
        'height' => 600,
        'resizable' => false,
    ),
));

$moObatAlkes = new RJObatAlkesM('search');
$moObatAlkes->unsetAttributes();
// $moObatAlkes->jenisobatalkes_id = Params::JENISOBATALKES_ID_BHP;
if (isset($_GET['RJObatAlkesM'])) {
    $moObatAlkes->attributes = $_GET['RJObatAlkesM'];
}

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'rjobat-alkes-m-grid',
    'dataProvider' => $moObatAlkes->searchObatFarmasi(),
    'filter' => $moObatAlkes,
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
						$(\'#obatalkes_kode\').val(\'$data->obatalkes_kode\');
						$(\'#qty_stok\').val(".MyFormatter::formatNumberForPrint(StokobatalkesT::getJumlahStok($data->obatalkes_id, Yii::app()->user->getState(\'ruangan_id\')),2).");
						$(\'#satuankecil_id\').val($data->satuankecil_id);
						$(\'#satuankecil_nama\').val(\'$data->SatuanKecilNama\');
						$(\'#hargajual\').val($data->hargajual);
						$(\'#harganetto\').val($data->harganetto);
						$(\'#obatalkes_nama\').val(\'$data->obatalkes_nama\');
						$(\'#namaObatNonRacik\').val(\'$data->obatalkes_nama\');
						$(\'#sumberdana_id\').val(\'$data->sumberdana_id\');
                        $(\"#qty_input\").val(\"".MyFormatter::formatNumberForPrint((empty($data->kemasanterkecil) ? 1 : $data->kemasanterkecil),2)."\");
                        $(\"#jmlkemasan\").val(\"".MyFormatter::formatNumberForPrint((empty($data->kemasanterkecil) ? 1 : $data->kemasanterkecil),2)."\");
                        setSatuanObat(\"$data->obatalkes_id\");
                        totalKonversi();
                        cekstokRuangan();
						$(\'#dialogAlkes\').dialog(\'close\');
						return false;"
						))',
            //							"onClick" => "inputPemakaianBahan($data->obatalkes_id);$(\'#dialogAlkes\').dialog(\'close\');return false;"))',
        ),
        'obatalkes_kategori',
        array(
            'header' => 'BMHP',
            'name' => 'obatalkes_nama',
        ),
        // 'obatalkes_golongan',
        array(
            'header' => 'Satuan Kecil',
            'name' => 'satuankecilNama',
            'value' => '$data->satuankecil->satuankecil_nama',
            'filter'=>CHtml::activeDropDownList($moObatAlkes,'satuankecil_id', CHtml::listData(SatuankecilM::model()->findAll('satuankecil_aktif = true order by satuankecil_nama ASC'),'satuankecil_id','satuankecil_nama'),array('empty'=>'-- Pilih --'))
        ),
        array(
            'header' => 'Sumber Dana',
            'name' => 'sumberdanaNama',
            'value' => '$data->sumberdana->sumberdana_nama',
        ),
        array(
            'header' => 'Jumlah Stok',
            'type' => 'raw',
            'value' => 'MyFormatter::formatNumberForPrint(StokobatalkesT::getJumlahStok($data->obatalkes_id, Yii::app()->user->getState("ruangan_id")),2)',
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
?>