<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/accounting2.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form2.js', CClientScript::POS_END); ?>
<div class="formjenisresep" id="form-nonracikan">
    <div class="panel panel-success panel-shadow">
        <div class="panel-heading">
            <div class="panel-title">Data Obat (Non Racikan) <?php echo CHtml::htmlButton('<i class="icon-refresh icon-white"></i>', array('class' => 'btn btn-danger btn-mini', 'onclick' => 'terapiobat_reset();', 'onkeyup' => "return $(this).focusNextInputField(event)", 'rel' => 'tooltip', 'title' => 'Klik untuk me-refresh form obat non racik')); ?></div>
        </div>
        <div class="panel-body">
            <div class="row-fluid">
                <div class="control-group ">

                    <?php echo CHtml::hiddenField('rke'); ?>
                    <?php echo CHtml::hiddenField('obatalkes_id'); ?>
                    <?php echo CHtml::hiddenField('obatalkes_kode'); ?>
                    <label class="control-label" for="namaObat">Nama Obat</label>
                    <div class="controls">
                        <?php
                        $this->widget('MyJuiAutoComplete', array(
                            'name' => 'namaObatNonRacik',
                            'source' => 'js: function(request, response) {
								$.ajax({
									url: "' . $this->createUrl('AutocompleteObatReseptur') . '",
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
                                'select' => 'js:function( event, ui ) {
									$(this).val( ui.item.label);
									$("#form-nonracikan #obatalkes_id").val(ui.item.obatalkes_id);
									$("#obatalkes_kode").val(ui.item.obatalkes_kode);
									$("#form-nonracikan #signa").val(ui.item.signa);
                                    setObat(ui.item.obatalkes_id);
									return false;
								 }',
                            ),
                            'tombolDialog' => array('idDialog' => 'dialogObat', 'idTombol' => 'tombolDialogOa'),

                            'htmlOptions' => array("class" => "span4", 'onkeypress' => "return $(this).focusNextInputField(event)"),

                        ));
                        ?><br>
                        <?php echo CHtml::textField('obatlain', '', array('readonly' => false, 'class' => 'namaobatlain hidden','placeholder'=>'Silahkan Memasukkan Nama Obat Lain')) ?>
                    </div>
                </div>
                <div class="control-group ">
                    <label class="control-label" for="qty">Jumlah</label>
                    <div class="controls">
                        <?php echo CHtml::textField('qtyNonRacik', '1', array('readonly' => false, 'onblur' => '$("#qty").val(this.value);', 'onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'inputFormTabel span1 numbers-only')) ?>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Frekuensi</label>
                    <div class="controls">

                        <?php //echo CHtml::textField('signa', '', array('onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span4')) 
                        ?>

                        <?php
                        $this->widget('MyJuiAutoComplete', array(
                            'name' => 'signa',
                            'value' => '',
                            'source' => 'js: function(request, response) {
                                        $.ajax({
                                        url: "' . $this->createUrl('getSignaFarmasi') . '",
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
                                'minLength' => 1,
                                'focus' => 'js:function( event, ui ) {
                                            $(this).val( ui.item.value);
                                            return false;
                                        }',
                                'select' => 'js:function( event, ui ) {
                                            $("#signa").val(ui.item.value); 
                                            is_signa_select = true;
                                            return false;
                                        }',
                                'close' => 'js:function(event, ui) {
                                        if (!is_signa_select) {
                                            $(this).val("");
                                        }
                                        is_signa_select = false;
                                    }'
                            ),
                            'htmlOptions' => array(
                                'class' => 'inputFormTabel span2', 'onkeypress' => "return $(this).focusNextInputField(event)", 'id' => 'signa'
                            ),
                        ));
                        ?>
                    </div>
                    <div class="controls">
                        <?php
                        echo CHtml::htmlButton('<i class="icon-plus icon-white"></i>', array(
                            'class' => 'btn btn-green',
                            'onclick' => 'form_tambah_signa();', 'data-toggle' => 'tooltip', 'title' => 'Tambah Signa',
                        ));
                        ?>
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label">Dosis</label>
                    <div class="controls">
                        <?= CHtml::dropDownList('dosisnon', '', LookupM::getItemsUrutan('etiket_1'), ['class' => 'dosis']) ?>
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label">Waktu Pemberian</label>
                    <div class="controls">
                        <?= CHtml::dropDownList('etiketwaktunon', '', LookupM::getItemsUrutan('etiket_2'), ['class' => 'etiketwaktu']) ?>
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label">Keterangan</label>
                    <div class="controls">
                        <?= CHtml::textArea('keterangannon', '', ['class' => 'keterangan']) ?>
                    </div>
                </div>

                <div class="control-group hide">
                    <label class="control-label">Etiket</label>
                    <div class="controls">
                        <?php // echo CHtml::dropDownList('etiketnonracikan', '', LookupM::getItems('etiket'),array('class'=>'span3')); 
                        ?>
                        <?php echo CHtml::dropDownList('etiketnonracikan1', '', LookupM::getItems('etiket_1'), array('style' => 'width:70px;', 'data-toggle' => 'tooltip', 'title' => 'Cara Penggunaan Obat')); ?>
                        <?php echo CHtml::dropDownList('etiketnonracikan2', '', LookupM::getItems('etiket_2'), array('style' => 'width:70px;', 'data-toggle' => 'tooltip', 'title' => 'Cara Penggunaan Obat')); ?>
                        <?php echo CHtml::dropDownList('etiketnonracikan3', '', LookupM::getItems('etiket_3'), array('style' => 'width:70px;', 'data-toggle' => 'tooltip', 'title' => 'Cara Penggunaan Obat')); ?>
                        <?php echo CHtml::dropDownList('etiketnonracikan4', '', LookupM::getItems('etiket_4'), array('style' => 'width:70px;', 'data-toggle' => 'tooltip', 'title' => 'Cara Penggunaan Obat')); ?>
                    </div>
                </div>

                <div class="control-group ">
                    <label class="control-label" for=""></label>
                    <div class="controls">
                        <?php echo CHtml::htmlButton(
                            '<i class="icon-plus icon-white"></i>',
                            array(
                                'onclick' => 'tambahObatNonRacik(this);return false;',
                                'class' => 'btn btn-primary',
                                'onkeypress' => "tambahObatNonRacik(this);return false;",
                                'rel' => "tooltip",
                                'title' => "Klik untuk menambahkan ke tabel resep",
                            )
                        ); ?>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
<div class="formjenisresep" id="form-racikan">
    <div class="panel panel-success panel-shadow">
        <div class="panel-heading">
            <div class="panel-title">Data Obat (Racikan)</div>
        </div>
        <div class="panel-body">
            <div id="formanak">
                <div class="control-group ">
                    <?php echo CHtml::hiddenField('obatalkes_id'); ?>
                    <label class="control-label" for="racikanKe">R ke</label>
                    <div class="controls">
                        <?php echo CHtml::dropDownList('racikanKe', '', CustomFunction::getDaftarAngka(), array('disabled' => false, 'class' => 'inputFormTabel span1', 'onkeypress' => "return $(this).focusNextInputField(event)")) ?>
                        <?php echo CHtml::htmlButton(
                            '<i class="entypo-plus"></i> Racikan Baru',
                            array(
                                'onclick' => 'racikanBaru(this);return false;',
                                'class' => 'btn btn-green',
                                'id' => 'tombolracikanbaru',
                                'onkeypress' => "racikanBaru(this);return false;",
                                'disabled' => true,
                                'rel' => "tooltip",
                                'title' => "Klik untuk input racikan baru",
                            )
                        );
                        ?>
                    </div>
                </div>

                <div class="control-group ">
                    <label class="control-label" for="jmlKemasan">Jumlah Permintaan</label>
                    <div class="controls">
                        <?php echo CHtml::textField('jmlKemasanObat', '', array('onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'inputFormTabel span1  numbers-only', 'style' => 'text-align: right;'))
                        //echo CHtml::textField('qtyRacik', '', array('disabled'=>false,'onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'inputFormTabel span1', 'style'=>'text-align: right;'));                                                
                        ?>
                        <?php echo CHtml::dropDownList('satuansediaan', '', LookupM::getItems(Params::LOOKUPTYPE_SEDIAANOBATRACIKAN), array('class' => 'inputFormTabel span1', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
                        <?php echo CHtml::hiddenField('satuansediaan_text', ''); ?>
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label">Frekuensi</label>
                    <div class="controls">
                        <?php //echo CHtml::textField('signaracikan', '', array('onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span4')) 
                        ?>

                        <?php
                        $this->widget('MyJuiAutoComplete', array(
                            'name' => 'signaracikan',
                            'value' => '',
                            'source' => 'js: function(request, response) {
                                    $.ajax({
                                    url: "' . $this->createUrl('getSignaFarmasi') . '",
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
                                'minLength' => 1,
                                'focus' => 'js:function( event, ui ) {
                                                $(this).val( ui.item.value);
                                                return false;
                                            }',
                                'select' => 'js:function( event, ui ) {
                                                $("#signaracikan").val(ui.item.value); 
                                                is_signa_select = true;
                                                return false;
                                            }',
                                'close' => 'js:function( event, ui ) {
                                            if (!is_signa_select) {
                                                $(this).val("");
                                            }
                                            is_signa_select = false;
                                        return false;
                                    }',

                            ),
                            'htmlOptions' => array(
                                'class' => 'inputFormTabel span2', 'onkeypress' => "return $(this).focusNextInputField(event)", 'id' => 'signaracikan'
                            ),
                        ));
                        ?>
                    </div>
                    <div class="controls">
                        <?php
                        echo CHtml::htmlButton('<i class="icon-plus icon-white"></i>', array(
                            'class' => 'btn btn-green',
                            'onclick' => 'form_tambah_signa();', 'data-toggle' => 'tooltip', 'title' => 'Tambah Signa',
                        ));
                        ?>
                    </div>
                </div>
                <div class="control-group hide">
                    <label class="control-label">Etiket</label>
                    <div class="controls">
                        <?php echo CHtml::dropDownList('etiketracikan1', '', LookupM::getItems('etiket_1'), array('style' => 'width:70px;', 'data-toggle' => 'tooltip', 'title' => 'Cara Penggunaan Obat')); ?>
                        <?php echo CHtml::dropDownList('etiketracikan2', '', LookupM::getItems('etiket_2'), array('style' => 'width:70px;', 'data-toggle' => 'tooltip', 'title' => 'Cara Penggunaan Obat')); ?>
                        <?php echo CHtml::dropDownList('etiketracikan3', '', LookupM::getItems('etiket_3'), array('style' => 'width:70px;', 'data-toggle' => 'tooltip', 'title' => 'Cara Penggunaan Obat')); ?>
                        <?php echo CHtml::dropDownList('etiketracikan4', '', LookupM::getItems('etiket_4'), array('style' => 'width:70px;', 'data-toggle' => 'tooltip', 'title' => 'Cara Penggunaan Obat')); ?>
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label">Dosis</label>
                    <div class="controls">
                        <?= CHtml::dropDownList('dosisracik', '', LookupM::getItemsUrutan('etiket_1'), ['class' => 'dosis']) ?>
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label">Waktu Pemberian</label>
                    <div class="controls">
                        <?= CHtml::dropDownList('etiketwakturacik', '', LookupM::getItemsUrutan('etiket_2'), ['class' => 'etiketwaktu']) ?>
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label">Keterangan</label>
                    <div class="controls">
                        <?= CHtml::textArea('keteranganracik', '', ['class' => 'keterangan']) ?>
                    </div>
                </div>

            </div>
            <fieldset class="well">
                <div class="control-group ">
                    <label class="control-label" for="namaObatRacik">Nama Obat</label>
                    <div class="controls">
                        <?php
                        $this->widget('MyJuiAutoComplete', array(
                            'name' => 'namaObatRacik',
                            'source' => 'js: function(request, response) {
									$.ajax({
										url: "' . $this->createUrl('AutocompleteObatReseptur') . '",
										dataType: "json",
										data: {
											term: request.term,
											ruangantujuan_id: $("#RJResepturT_ruangan_id").val(),
										},
										success: function (data) {
											response(data);
										}
									})
								}',
                            'options' => array(
                                'showAnim' => 'fold',
                                'minLength' => 2,
                                'select' => 'js:function( event, ui ) {
										$(this).val( ui.item.label);
										$("#form-racikan #obatalkes_id").val(ui.item.obatalkes_id);
										$("#obatalkes_kode").val(ui.item.obatalkes_kode);
										$("#form-racikan #kekuatanObat").val(ui.item.kekuatan);
										hitungJumlahObat();
                                        setObat(ui.item.obatalkes_id);
										return false;
									}',
                            ),
                            'htmlOptions' => array("class" => "span3", "rel" => "tooltip", 'disabled' => false, 'onkeypress' => "return $(this).focusNextInputField(event)"),
                            'tombolDialog' => array('idDialog' => 'dialogObatRacikan', 'idTombol' => 'tombolDialogOaRacikan'),
                        ));
                        ?><br>
                        <?php echo CHtml::textField('obatlain', '', array('readonly' => false, 'class' => 'namaobatlain hidden','placeholder'=>'Silahkan Memasukkan Nama Obat Lain')) ?>
                    </div>
                </div>
                <!-- <div class="control-group hide">
					<label class="control-label" for="permintaan">Permintaan Dosis</label>
					<div class="controls">
							<?php // echo CHtml::textField('permintaan', '', array('onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'inputFormTabel span1  float2','onblur'=>'hitungJumlahObat()', 'style'=>'text-align: right;')) 
                            ?>
							<?php //echo CHtml::dropDownList('satuan_permintaandosis', '', LookupM::getItems('satuankekuatan'),array('class'=>'inputFormTabel span1','onkeypress'=>"return $(this).focusNextInputField(event)")); 
                            ?>
							<?php //echo Chtml::button("Pecahan", array('onclick'=>'$("#dialogPecahanDosis").dialog("open");', 'class'=>'btn btn-primary')); 
                            ?>
//
                            <?php //echo CHtml::hiddenField('pembilang'); 
                            ?>
                            <?php //echo CHtml::hiddenField('penyebut'); 
                            ?>
                    </div>

				</div> -->
                <div class="control-group hide">
                    <label class="control-label" for="kekuatanObat">Sediaan</label>
                    <div class="controls">
                        <?php echo CHtml::textField('kekuatanObat', '', array('onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'inputFormTabel span1 float2', "rel" => "tooltip", "title" => "Sediaan diambil dari data obat yang dipilih", 'style' => 'text-align: right;', 'onblur' => 'hitungJumlahObat()')) ?>
                        <span id="satuanKekuatanObat"></span>
                    </div>
                </div>
                <div class="control-group ">
                    <label class="control-label" for="permintaan">Permintaan Dosis</label>
                    <div class="controls">
                        <?php //echo CHtml::textField('permintaan', '', array('onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'inputFormTabel span1', 'onblur' => 'hitungJumlahObat()', 'style' => 'text-align: right;')) ?>
                        <?php echo CHtml::textField('permintaan', '', array('onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'inputFormTabel span1', 'style' => 'text-align: right;')) ?>
                        <?php echo CHtml::dropDownList('satuan_permintaandosis', '', LookupM::getItems('satuankekuatan'), array('class' => 'inputFormTabel span1', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
                        <?php //echo Chtml::button("Pecahan", array('onclick' => '$("#dialogPecahanDosis").dialog("open");', 'class' => 'btn btn-primary')); ?>
                        <?php echo CHtml::hiddenField('pembilang'); ?>
                        <?php echo CHtml::hiddenField('penyebut'); ?>
                    </div>
                </div>
                <div class="control-group " hidden>
                    <label class="control-label" for="qty">Jumlah Obat</label>
                    <div class="controls">
                        <?php echo CHtml::textField('qtyRacik', '', array('readonly' => false, 'onkeyup' => '$("#qty").val($(this).val());', 'onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'float2', "rel" => "tooltip", "title" => "Jumlah Obat = Permintaan Dosis X Jumlah Permintaan / Kekuatan", 'style' => 'width:50px;')) ?>
                    </div>
                </div>
            </fieldset>

            <div class="control-group ">
                <label class="control-label" for=""></label>
                <div class="controls">
                    <?php echo CHtml::htmlButton(
                        '<i class="icon-plus icon-white"></i>',
                        array(
                            'onclick' => 'tambahObatRacik(this);return false;',
                            'class' => 'btn btn-primary',
                            'id' => 'tomboltambahracikan',
                            'onkeypress' => "tambahObatRacik(this);return false;",
                            'rel' => "tooltip",
                            'title' => "Klik untuk menambahkan ke tabel resep",
                            'disabled' => false,
                        )
                    );
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogPecahanDosis',
    'options' => array(
        'title' => 'Pecahan Dosis',
        'autoOpen' => false,
        'modal' => true,
        'minWidth' => 50,
        'minHeight' => 100,
        'resizable' => false,
    ),
)); ?>
<?php echo CHtml::textField('dosis_pembliang', '', array('class' => 'span1 numbers-only', 'style' => 'text-align: right;')) . " / " .
    CHtml::textField('dosis_penyebut', '', array('class' => 'span1 numbers-only', 'style' => 'text-align: right;')) . " "; ?>
<?php echo CHtml::button('OK', array('onclick' => 'hitungPecahanDosisRacikan()', 'class' => 'btn btn-primary')); ?>
<?php $this->endWidget(); ?>


<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogObat',
    'options' => array(
        'title' => 'Daftar Obat Alkes',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'height' => 600,
        'resizable' => false,
    ),
));

$modObatDialog = new GFObatalkesM('searchObatFarmasi');
$modObatDialog->unsetAttributes();
$format = new MyFormatter();
if (isset($_GET['GFObatalkesM'])) {
    $modObatDialog->attributes = $_GET['GFObatalkesM'];
}

$prov = $modObatDialog->searchObatFarmasi();
$prov->sort->defaultOrder = 'obatalkes_nama';

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'obatAlkesDialog-m-grid',
    'dataProvider' => $prov,
    'filter' => $modObatDialog,
    //'template' => "{items}\n{pager}",
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("rel"=>"tooltip","title"=>"Pilih Obat/Alkes","class"=>"btn_small",
                "id"=>"selectObat",
                "onClick"=>"
                            $(\"#form-nonracikan #obatalkes_id\").val(\"$data->obatalkes_id\");
                            $(\"#obatalkes_kode\").val(\"$data->obatalkes_kode\");
                            $(\"#form-nonracikan #namaObatNonRacik\").val(\"$data->obatalkes_nama\");
							$(\"#form-nonracikan #signa\").val(\"$data->signa\");
							$(\"#dialogObat\").dialog(\"close\");
                            setObat(\"$data->obatalkes_id\");
                            return false;
                ",
               ))'
        ),
        'obatalkes_kode',
        'obatalkes_nama',
        array(
            'header' => 'Tanggal Kadaluarsa',
            'name' => 'tglkadaluarsa',
            'filter' => '',
        ),
        array(
            'name' => 'satuankecil.satuankecil_nama',
            'header' => 'Satuan Kecil',
        ),
        array(
            'name' => 'satuanbesar.satuanbesar_nama',
            'header' => 'Satuan Besar',
        ),
        // array(
        //     'header' => 'Stok',
        //     'type' => 'raw',
        //     'value' => '$data->StokObatRuangan." ".$data->satuankecil->satuankecil_nama',
        // ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
?>

<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogObatRacikan',
    'options' => array(
        'title' => 'Daftar Obat Alkes Racikan',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'height' => 600,
        'resizable' => false,
    ),
));

$modObatDialogRacikan = new GFObatalkesM('searchObatFarmasi');
$modObatDialogRacikan->unsetAttributes();
$format = new MyFormatter();
if (isset($_GET['GFObatalkesM']))
    $modObatDialogRacikan->attributes = $_GET['GFObatalkesM'];


$prov = $modObatDialogRacikan->searchObatFarmasi();
$prov->sort->defaultOrder = 'obatalkes_nama';

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'obatAlkesDialogRacikan-m-grid',
    'dataProvider' => $prov,
    'filter' => $modObatDialogRacikan,
    'template' => "{items}\n{pager}",
    //    'template'=>"{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("rel"=>"tooltip","title"=>"Pilih Obat/Alkes","class"=>"btn_small",
                "id"=>"selectObat",
                "onClick"=>"
                           
                            $(\"#form-racikan #obatalkes_id\").val(\"$data->obatalkes_id\");
                            $(\"#obatalkes_kode\").val(\"$data->obatalkes_kode\");
                            $(\"#form-racikan #namaObatRacik\").val(\"$data->obatalkes_nama\");
                            $(\"#form-racikan #kekuatanObat\").val(\"".number_format($data->kekuatan, 2, ",", "")."\");
                            $(\"#dialogObatRacikan\").dialog(\"close\");
                            setObat(\"$data->obatalkes_id\");
                            return false;
                ",
               ))'
        ),
        'obatalkes_kode',
        'obatalkes_nama',
        array(
            'header' => 'Tanggal Kadaluarsa',
            'name' => 'tglkadaluarsa',
            'filter' => '',
        ),
        array(
            'name' => 'satuankecil.satuankecil_nama',
            'header' => 'Satuan Kecil',
        ),
        array(
            'name' => 'satuanbesar.satuanbesar_nama',
            'header' => 'Satuan Besar',
        ),
        // array(
        //     'header' => 'Stok',
        //     'type' => 'raw',
        //     'value' => '$data->StokObatRuangan." ".$data->satuankecil->satuankecil_nama',
        // ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
?>