<?php
//========= Dialog buat cari data pemeriksa =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogPemeriksaLengkap',
    'options' => array(
        'title' => 'Petugas',
        'autoOpen' => false,
        'modal' => true,
        'width' => 800,
        'height' => 500,
        'resizable' => false,
        'close' => "js:function(){ cekPerawat(); }",

    ),
));
?>

<div class="col-sm-6">
    <?php echo CHtml::hiddenField('baris', '', array('id' => 'rowTindakan', 'readonly' => true)) ?>
    <?php echo CHtml::hiddenField('kelTin', '', array('id' => 'rowKelompokTindakan', 'readonly' => true)) ?>
    <div class="control-group">
        <?php echo CHtml::activeLabel($modTindakan, 'Dokter 1 <span class="required">*</span>'); ?>
        <div class="controls">
            <?php $this->widget('MyJuiAutoComplete', array(
                'name' => 'dokterpemeriksa1_id',
                'value' => '',
                'sourceUrl' => Yii::app()->createUrl('rawatInap/tindakanTRI/GetDokter'),
                'options' => array(
                    'showAnim' => 'fold',
                    'minLength' => 4,
                    'focus' => 'js:function( event, ui ) {
                                $("#dokterpemeriksa1_id").val( ui.item.label);
                                return false;
                            }',
                    'select' => 'js:function( event, ui ) {
                                setPilihDokter(1, "autocomplete");
                                pilihDokter(ui.item.pegawai_id);
                                return false;
                            }',

                ),
                'tombolDialog' => array("idDialog" => 'dialogDokter', 'jsFunction' => "setPilihDokter(1);"),
                'htmlOptions' => array(
                    'onblur' => 'if(this.value === ""){ $("#dokterpemeriksa1_id").val(""); updateDokterPemeriksa1(this.value);}',
                    'onkeypress' => "return $(this).focusNextInputField(event);"
                ),
            )); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::activeLabel($modTindakan, 'Dokter 2'); ?>
        <div class="controls">
            <?php $this->widget('MyJuiAutoComplete', array(
                'name' => 'dokterpemeriksa2_id',
                'value' => '',
                'sourceUrl' => Yii::app()->createUrl('rawatInap/tindakanTRI/GetDokter'),
                'options' => array(
                    'showAnim' => 'fold',
                    'minLength' => 4,
                    'focus' => 'js:function( event, ui ) {
                                $("#dokterpemeriksa2_id").val( ui.item.label);
                                return false;
                            }',
                    'select' => 'js:function( event, ui ) {
                                setPilihDokter(2, "autocomplete");
                                pilihDokter(ui.item.pegawai_id);
                                return false;
                            }',

                ),
                'tombolDialog' => array("idDialog" => 'dialogDokter', 'jsFunction' => "setPilihDokter(2);"),
                'htmlOptions' => array(
                    'onblur' => 'if(this.value === ""){ $("#dokterpemeriksa2_id").val(""); updateDokterPemeriksa2(this.value);}',
                    'onkeypress' => "return $(this).focusNextInputField(event);"
                ),
            )); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::activeLabel($modTindakan, 'dokter 3'); ?>
        <div class="controls">
            <?php $this->widget('MyJuiAutoComplete', array(
                'name' => 'dokterdelegasi_id',
                'value' => '',
                'sourceUrl' => Yii::app()->createUrl('rawatInap/tindakanTRI/GetDokter'),
                'options' => array(
                    'showAnim' => 'fold',
                    'minLength' => 4,
                    'focus' => 'js:function( event, ui ) {
                                $("#dokterdelegasi_id").val( ui.item.label);
                                return false;
                            }',
                    'select' => 'js:function( event, ui ) {
                                setPilihDokter(3, "autocomplete");
                                pilihDokter(ui.item.pegawai_id);
                                return false;
                            }',
                ),
                'tombolDialog' => array("idDialog" => 'dialogDokter', 'jsFunction' => "setPilihDokter(3);"),
                'htmlOptions' => array(
                    'onblur' => 'if(this.value === ""){ $("#dokterdelegasi_id").val(""); updateDokterDelegasi(this.value);}',
                    'onkeypress' => "return $(this).focusNextInputField(event)"
                ),
            )); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::activeLabel($modTindakan, 'dokter 4'); ?>
        <div class="controls">
            <?php $this->widget('MyJuiAutoComplete', array(
                'name' => 'dokterpendamping_id',
                'value' => '',
                'sourceUrl' => Yii::app()->createUrl('rawatInap/tindakanTRI/GetDokter'),
                'options' => array(
                    'showAnim' => 'fold',
                    'minLength' => 4,
                    'focus' => 'js:function( event, ui ) {
                                $("#dokterpendamping_id").val( ui.item.label);
                                return false;
                            }',
                    'select' => 'js:function( event, ui ) {
                                setPilihDokter(5, "autocomplete");
                                pilihDokter(ui.item.pegawai_id);
                                return false;
                            }',

                ),
                'tombolDialog' => array("idDialog" => 'dialogDokter', 'jsFunction' => "setPilihDokter(5);"),
                'htmlOptions' => array(
                    'onblur' => 'if(this.value === "") $("#dokterpendamping_id").val(""); ',
                    'onkeypress' => "return $(this).focusNextInputField(event)"
                ),
            )); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::activeLabel($modTindakan, 'dokter 5'); ?>
        <div class="controls">
            <?php $this->widget('MyJuiAutoComplete', array(
                'name' => 'dokteranastesi_id',
                'value' => '',
                'sourceUrl' => Yii::app()->createUrl('rawatJalan/tindakan/GetDokterPerawat'),
                'options' => array(
                    'showAnim' => 'fold',
                    'minLength' => 4,
                    'focus' => 'js:function( event, ui ) {
                                $("#dokteranastesi_id").val( ui.item.label);
                                return false;
                            }',
                    'select' => 'js:function( event, ui ) {
                                setPilihDokterPerawat(4, "autocomplete");
                                pilihDokter(ui.item.pegawai_id);
                                return false;
                            }',

                ),
                'tombolDialog' => array("idDialog" => 'dialogDokter', 'jsFunction' => "setPilihDokterPerawat(4);"),
                'htmlOptions' => array(
                    'onblur' => 'if(this.value === "") $("#dokteranastesi_id").val(""); ',
                    'onkeypress' => "return $(this).focusNextInputField(event)"
                ),
            )); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::activeLabel($modTindakan, 'dokter 6'); ?>
        <div class="controls">
            <?php $this->widget('MyJuiAutoComplete', array(
                'name' => 'dokter6',
                'value' => '',
                'sourceUrl' => Yii::app()->createUrl('rawatInap/tindakanTRI/GetDokter'),
                'options' => array(
                    'showAnim' => 'fold',
                    'minLength' => 4,
                    'focus' => 'js:function( event, ui ) {
                                return false;
                            }',
                    'select' => 'js:function( event, ui ) {
                                setPilihDokter(6, "autocomplete");
                                pilihDokter(ui.item.pegawai_id);
                                return false;
                            }',

                ),
                'tombolDialog' => array("idDialog" => 'dialogDokter', 'jsFunction' => "setPilihDokter(6);"),
                'htmlOptions' => array(
                    'onblur' => 'if(this.value === "") $("#dokteranastesi_id").val(""); ',
                    'onkeypress' => "return $(this).focusNextInputField(event)"
                ),
            )); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::activeLabel($modTindakan, 'dokter 7'); ?>
        <div class="controls">
            <?php $this->widget('MyJuiAutoComplete', array(
                'name' => 'dokter7',
                'value' => '',
                'sourceUrl' => Yii::app()->createUrl('rawatInap/tindakanTRI/GetDokter'),
                'options' => array(
                    'showAnim' => 'fold',
                    'minLength' => 4,
                    'focus' => 'js:function( event, ui ) {
                                return false;
                            }',
                    'select' => 'js:function( event, ui ) {
                                setPilihDokter(7, "autocomplete");
                                pilihDokter(ui.item.pegawai_id);
                                return false;
                            }',

                ),
                'tombolDialog' => array("idDialog" => 'dialogDokter', 'jsFunction' => "setPilihDokter(7);"),
                'htmlOptions' => array(
                    'onblur' => 'if(this.value === "") $("#dokteranastesi_id").val(""); ',
                    'onkeypress' => "return $(this).focusNextInputField(event)"
                ),
            )); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::activeLabel($modTindakan, 'dokter 8'); ?>
        <div class="controls">
            <?php $this->widget('MyJuiAutoComplete', array(
                'name' => 'dokter8',
                'value' => '',
                'sourceUrl' => Yii::app()->createUrl('rawatInap/tindakanTRI/GetDokter'),
                'options' => array(
                    'showAnim' => 'fold',
                    'minLength' => 4,
                    'focus' => 'js:function( event, ui ) {
                                return false;
                            }',
                    'select' => 'js:function( event, ui ) {
                                setPilihDokter(8, "autocomplete");
                                pilihDokter(ui.item.pegawai_id);
                                return false;
                            }',

                ),
                'tombolDialog' => array("idDialog" => 'dialogDokter', 'jsFunction' => "setPilihDokter(8);"),
                'htmlOptions' => array(
                    'onblur' => 'if(this.value === "") $("#dokteranastesi_id").val(""); ',
                    'onkeypress' => "return $(this).focusNextInputField(event)"
                ),
            )); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::activeLabel($modTindakan, 'dokter 9'); ?>
        <div class="controls">
            <?php $this->widget('MyJuiAutoComplete', array(
                'name' => 'dokter9',
                'value' => '',
                'sourceUrl' => Yii::app()->createUrl('rawatInap/tindakanTRI/GetDokter'),
                'options' => array(
                    'showAnim' => 'fold',
                    'minLength' => 4,
                    'focus' => 'js:function( event, ui ) {
                               
                                return false;
                            }',
                    'select' => 'js:function( event, ui ) {
                                setPilihDokter(9, "autocomplete");
                                pilihDokter(ui.item.pegawai_id);
                                return false;
                            }',

                ),
                'tombolDialog' => array("idDialog" => 'dialogDokter', 'jsFunction' => "setPilihDokter(9);"),
                'htmlOptions' => array(
                    'onblur' => 'if(this.value === "") $("#dokteranastesi_id").val(""); ',
                    'onkeypress' => "return $(this).focusNextInputField(event)"
                ),
            )); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::activeLabel($modTindakan, 'dokter 10'); ?>
        <div class="controls">
            <?php $this->widget('MyJuiAutoComplete', array(
                'name' => 'dokter10',
                'value' => '',
                'sourceUrl' => Yii::app()->createUrl('rawatInap/tindakanTRI/GetDokter'),
                'options' => array(
                    'showAnim' => 'fold',
                    'minLength' => 4,
                    'focus' => 'js:function( event, ui ) {
                                setPilihDokter(10, "autocomplete");
                                pilihDokter(ui.item.pegawai_id);
                                return false;
                            }',
                    'select' => 'js:function( event, ui ) {
                                setDokterAnastesi(ui.item);
                                return false;
                            }',

                ),
                'tombolDialog' => array("idDialog" => 'dialogDokter', 'jsFunction' => "setPilihDokter(10);"),
                'htmlOptions' => array(
                    'onblur' => 'if(this.value === "") $("#dokteranastesi_id").val(""); ',
                    'onkeypress' => "return $(this).focusNextInputField(event)"
                ),
            )); ?>
        </div>
    </div>


</div>
<div class="col-sm-6">
    <div class="control-group">
        <?php echo CHtml::activeLabel($modTindakan, 'Perawat / Bidan'); ?>
        <div class="controls">
            <?php $this->widget('MyJuiAutoComplete', array(
                'name' => 'perawat_id',
                'value' => '',
                'sourceUrl' => Yii::app()->createUrl('rawatInap/tindakanTRI/GetPerawat'),
                'options' => array(
                    'showAnim' => 'fold',
                    'minLength' => 4,
                    'focus' => 'js:function( event, ui ) {
                                $("#perawat_id").val( ui.item.label);
                                return false;
                            }',
                    'select' => 'js:function( event, ui ) {
                                setPilihPerawat(1, "autocomplete");     
                                pilihPerawat(ui.item.pegawai_id);
                                return false;
                            }',

                ),
                'tombolDialog' => array("idDialog" => 'dialogPerawat', 'jsFunction' => "setPilihPerawat(1);"),
                'htmlOptions' => array(
                    'onblur' => 'if(this.value === ""){ $("#perawat_id").val(""); updatePerawat(this.value);}',
                    'onkeypress' => "return $(this).focusNextInputField(event)"
                ),
            )); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::activeLabel($modTindakan, 'Perawat / Bidan'); ?>
        <div class="controls">
            <?php $this->widget('MyJuiAutoComplete', array(
                'name' => 'perawat2_id',
                'value' => '',
                'sourceUrl' => Yii::app()->createUrl('rawatInap/tindakanTRI/GetPerawat'),
                'options' => array(
                    'showAnim' => 'fold',
                    'minLength' => 4,
                    'focus' => 'js:function( event, ui ) {
                                $("#perawat2_id").val( ui.item.label);
                                return false;
                            }',
                    'select' => 'js:function( event, ui ) {
                                setPilihPerawat(2, "autocomplete");     
                                pilihPerawat(ui.item.pegawai_id);
                                return false;
                            }',

                ),
                'tombolDialog' => array("idDialog" => 'dialogPerawat', 'jsFunction' => "setPilihPerawat(2);"),
                'htmlOptions' => array(
                    'onblur' => 'if(this.value === ""){ $("#perawat2_id").val(""); updateSuster(this.value); }',
                    'onkeypress' => "return $(this).focusNextInputField(event)"
                ),
            )); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::activeLabel($modTindakan, 'Perawat / Bidan'); ?>
        <div class="controls">
            <?php $this->widget('MyJuiAutoComplete', array(
                'name' => 'bidan_id',
                'value' => '',
                'sourceUrl' => Yii::app()->createUrl('rawatInap/tindakanTRI/getBidan'),
                'options' => array(
                    'showAnim' => 'fold',
                    'minLength' => 4,
                    'focus' => 'js:function( event, ui ) {
                                $("#bidan_id").val( ui.item.label);
                                return false;
                            }',
                    'select' => 'js:function( event, ui ) {
                                setPilihBidan(1, "autocomplete");     
                                pilihBidan(ui.item.pegawai_id);
                                return false;
                            }',

                ),
                'tombolDialog' => array("idDialog" => 'dialogBidan', 'jsFunction' => "setPilihBidan(1);"),
                'htmlOptions' => array(
                    'onblur' => 'if(this.value === "") {$("#bidan_id").val(""); updatePerawat(this.value);}',
                    'onkeypress' => "return $(this).focusNextInputField(event)"
                ),
            )); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::activeLabel($modTindakan, 'Perawat / Bidan'); ?>
        <div class="controls">
            <?php $this->widget('MyJuiAutoComplete', array(
                'name' => 'bidan2_id',
                'value' => '',
                'sourceUrl' => Yii::app()->createUrl('rawatInap/tindakanTRI/getBidan'),
                'options' => array(
                    'showAnim' => 'fold',
                    'minLength' => 4,
                    'focus' => 'js:function( event, ui ) {
										$("#bidan2_id").val( ui.item.label);
										return false;
									}',
                    'select' => 'js:function( event, ui ) {
                                        setPilihBidan(2, "autocomplete");     
                                        pilihBidan(ui.item.pegawai_id);
										return false;
									}',

                ),
                'tombolDialog' => array("idDialog" => 'dialogBidan', 'jsFunction' => "setPilihBidan(2);"),
                'htmlOptions' => array(
                    'onblur' => 'if(this.value === "") {$("#bidan2_id").val(""); updatePerawat(this.value);}',
                    'onkeypress' => "return $(this).focusNextInputField(event)"
                ),
            )); ?>
        </div>
    </div>


    <div class="control-group">
        <?php echo CHtml::activeLabel($modTindakan, 'bidan3_id', array('label' => 'Perawat / Bidan')); ?>
        <div class="controls">
            <?php $this->widget('MyJuiAutoComplete', array(
                'name' => 'bidan3_id',
                'value' => '',
                'sourceUrl' => Yii::app()->createUrl('rawatInap/tindakanTRI/getBidan'),
                'options' => array(
                    'showAnim' => 'fold',
                    'minLength' => 2,
                    'focus' => 'js:function( event, ui ) {
                                $("#bidan3_id").val( ui.item.label);
                                return false;
                            }',
                    'select' => 'js:function( event, ui ) {
                                setPilihBidan(3, "autocomplete");     
                                pilihBidan(ui.item.pegawai_id);
                                return false;
                            }',

                ),
                'tombolDialog' => array("idDialog" => 'dialogBidan', 'jsFunction' => "setPilihBidan(3);"),
                'htmlOptions' => array(
                    'onblur' => 'if(this.value === "") {$("#bidan3_id").val(""); updatePerawat(this.value);}',
                    'onkeypress' => "return $(this).focusNextInputField(event)"
                ),
            )); ?>
        </div>
    </div>
</div>

<div class="clear">
    <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Ok', array('{icon}' => '<i class="entypo-check"></i>')),
        array(
            'class' => 'btn btn-danger', 'onKeypress' => 'return formSubmit(this,event)',
            'onclick' => '$("#dokterpemeriksa1_id").val() !== "" ? $("#dialogPemeriksaLengkap").dialog("close") : myAlert("Dokter 1 belum diisi"); uncheckedValue()'
        )
    ); ?>
</div>
<?php

$this->endWidget();
//========= end pemeriksa dialog =============================
?>

<?php
//========= Dialog buat cari dokter =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogDokter',
    'options' => array(
        'title' => 'Data Dokter',
        'autoOpen' => false,
        'modal' => true,
        'width' => 500,
        'height' => 500,
        'resizable' => false,
    ),
));

$datDokter = new DokterV();

if (Yii::app()->user->getState('dokterruangan')) {
    $datDokter->ruangan_id = Yii::app()->user->getState('ruangan_id');
}

if (isset($_GET['DokterV'])) {
    $datDokter->attributes = $_GET['DokterV'];
}

$provider = $datDokter->search();
$provider->criteria->group = $provider->criteria->select = 'pegawai_id, gelardepan, nama_pegawai, gelarbelakang_nama';

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'dokter-v-grid2',
    'dataProvider' => $provider,
    'filter' => $datDokter,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","javascript:void(0);",array("class"=>"btn-small", 
                                    "id" => "selectDokter",
                                    "onClick" => "pilihDokter(".$data->pegawai_id."); return false;"))',
            //'filter'=>CHtml::activeHiddenField($modTindakan,'tipepaket_id').CHtml::activeHiddenField($modTindakan,'kelaspelayanan_id').CHtml::activeHiddenField($modTindakan,'penjamin_id').CHtml::activeHiddenField($modTindakan,'jenistarif_id'),
        ),
        array(
            'name' => 'nama_pegawai',
            'value' => '$data->namaLengkap',
            'type' => 'raw',
            //                        'filter'=>CHtml::activeHiddenField($modTindakan,'tipepaket_id'),
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
//========= end data dokter =============================

?>


<?php
//========= Dialog buat cari dokter =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogPerawat',
    'options' => array(
        'title' => 'Data Perawat',
        'autoOpen' => false,
        'modal' => true,
        'width' => 500,
        'height' => 500,
        'resizable' => false,
    ),
));

$datPerawat = new PegawaiV();
$datPerawat->unsetAttributes();
$datPerawat->kelompokpegawai_id = Params::KELOMPOKPEGAWAI_ID_TENAGA_KEPERAWATAN;
if (isset($_GET['PegawaiV'])) {
    $datPerawat->attributes = $_GET['PegawaiV'];
}
$provider = $datPerawat->search();
$provider->criteria->group = $provider->criteria->select = 'pegawai_id, gelardepan, nama_pegawai, gelarbelakang_nama';

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'perawat-v-grid2',
    'dataProvider' => $provider,
    'filter' => $datPerawat,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","javascript:void(0);",array("class"=>"btn-small", 
                                    "id" => "selectPerawat",
                                    "onClick" => "pilihPerawat(".$data->pegawai_id."); return false;"))',
            //'filter'=>CHtml::activeHiddenField($modTindakan,'tipepaket_id').CHtml::activeHiddenField($modTindakan,'kelaspelayanan_id').CHtml::activeHiddenField($modTindakan,'penjamin_id').CHtml::activeHiddenField($modTindakan,'jenistarif_id'),
        ),
        array(
            'name' => 'nama_pegawai',
            'value' => '$data->namaLengkap',
            'type' => 'raw',
            //                        'filter'=>CHtml::activeHiddenField($modTindakan,'tipepaket_id'),
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
//========= end data dokter =============================

?>

<?php
//========= Dialog buat cari dokter =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogDokterPerawat',
    'options' => array(
        'title' => 'Data Dokter & Perawat',
        'autoOpen' => false,
        'modal' => true,
        'width' => 500,
        'height' => 500,
        'resizable' => false,
    ),
));

$datPerawat = new PegawaiV();
$datPerawat->unsetAttributes();
$datPerawat->kelompokpegawai_id = array(Params::KELOMPOKPEGAWAI_ID_TENAGA_KEPERAWATAN, Params::KELOMPOKPEGAWAI_ID_TENAGA_MEDIK, Params::KELOMPOKPEGAWAI_ID_BIDAN);
if (isset($_GET['PegawaiV'])) {
    $datPerawat->attributes = $_GET['PegawaiV'];
}
$provider = $datPerawat->search();
$provider->criteria->group = $provider->criteria->select = 'pegawai_id, gelardepan, nama_pegawai, gelarbelakang_nama';

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'dokterperawat-v-grid2',
    'dataProvider' => $provider,
    'filter' => $datPerawat,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","javascript:void(0);",array("class"=>"btn-small", 
                                    "id" => "selectPerawat",
                                    "onClick" => "pilihDokter(".$data->pegawai_id."); return false;"))',
            //'filter'=>CHtml::activeHiddenField($modTindakan,'tipepaket_id').CHtml::activeHiddenField($modTindakan,'kelaspelayanan_id').CHtml::activeHiddenField($modTindakan,'penjamin_id').CHtml::activeHiddenField($modTindakan,'jenistarif_id'),
        ),
        array(
            'name' => 'nama_pegawai',
            'value' => '$data->namaLengkap',
            'type' => 'raw',
            //                        'filter'=>CHtml::activeHiddenField($modTindakan,'tipepaket_id'),
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
//========= end data dokter =============================

?>

<?php
//========= Dialog buat cari dokter =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogBidan',
    'options' => array(
        'title' => 'Data Bidan',
        'autoOpen' => false,
        'modal' => true,
        'width' => 500,
        'height' => 500,
        'resizable' => false,
    ),
));

$datPerawat = new PegawaiV();
$datPerawat->unsetAttributes();
$datPerawat->kelompokpegawai_id = [Params::KELOMPOKPEGAWAI_ID_TENAGA_KEPERAWATAN, 20];
$datPerawat->jabatan_id = Params::JABATAN_ID_BIDAN;
if (isset($_GET['PegawaiV'])) {
    $datPerawat->attributes = $_GET['PegawaiV'];
}
$provider = $datPerawat->search();
$provider->criteria->group = $provider->criteria->select = 'pegawai_id, gelardepan, nama_pegawai, gelarbelakang_nama';

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'bidan-v-grid2',
    'dataProvider' => $provider,
    'filter' => $datPerawat,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","javascript:void(0);",array("class"=>"btn-small", 
                                    "id" => "selectPerawat",
                                    "onClick" => "pilihBidan(".$data->pegawai_id."); return false;"))',
            //'filter'=>CHtml::activeHiddenField($modTindakan,'tipepaket_id').CHtml::activeHiddenField($modTindakan,'kelaspelayanan_id').CHtml::activeHiddenField($modTindakan,'penjamin_id').CHtml::activeHiddenField($modTindakan,'jenistarif_id'),
        ),
        array(
            'name' => 'nama_pegawai',
            'value' => '$data->namaLengkap',
            'type' => 'raw',
            //                        'filter'=>CHtml::activeHiddenField($modTindakan,'tipepaket_id'),
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
//========= end data dokter =============================

?>

<?php
//========= Dialog buat cari supir =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogSupir',
    'options' => array(
        'title' => 'Pencarian Supir',
        'autoOpen' => false,
        'modal' => true,
        'width' => 500,
        'height' => 500,
        'resizable' => false,
    ),
));

$dtSupir = new PegawaiV();
$dtSupir->unsetAttributes();
//  $datPerawat->kelompokpegawai_id = Params::KELOMPOKPEGAWAI_ID_TENAGA_KEPERAWATAN;
$dtSupir->jabatan_id = Params::getPegSupirByJab();
if (isset($_GET['PegawaiV'])) {
    $dtSupir->attributes = $_GET['PegawaiV'];
}
$provider = $dtSupir->search();
$provider->criteria->group = $provider->criteria->select = 'pegawai_id, gelardepan, nama_pegawai, gelarbelakang_nama';

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'supir-v-grid2',
    'dataProvider' => $provider,
    'filter' => $dtSupir,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","javascript:void(0);",array("class"=>"btn-small", 
                                    "id" => "selectSupir",
                                    "onClick" => "pilihSupir(".$data->pegawai_id."); return false;"))',
            //'filter'=>CHtml::activeHiddenField($modTindakan,'tipepaket_id').CHtml::activeHiddenField($modTindakan,'kelaspelayanan_id').CHtml::activeHiddenField($modTindakan,'penjamin_id').CHtml::activeHiddenField($modTindakan,'jenistarif_id'),
        ),
        array(
            'name' => 'nama_pegawai',
            'value' => '$data->namaLengkap',
            'type' => 'raw',
            //                        'filter'=>CHtml::activeHiddenField($modTindakan,'tipepaket_id'),
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
//========= end data supir =============================

?>

<script>
    var idPilihDokter = 0;
    var idPilihPerawat = 0;
    var idPilihSupir = 0;
    var idPilihBidan = 0;

    function setPilihDokter(val, type) {
        idPilihDokter = val;
        if(type != 'autocomplete') {
            $("#dialogDokter").dialog('open');
        }
    }

    function setPilihDokterPerawat(val, type) {
        idPilihDokter = val;
        if(type != 'autocomplete') {
            $("#dialogDokterPerawat").dialog('open');
        }
    }

    function setPilihBidan(id, type) {
        idPilihBidan = id;
        if(type != 'autocomplete') {
            $("#dialogBidan").dialog('open');
        }
    }

    function pilihDokter(id) {
        $("#dialogDokter").dialog('close');
        $("#dialogDokterPerawat").dialog('close');

        var url = "<?php echo Yii::app()->createUrl('rawatJalan/tindakan/GetDokter'); ?>";
        if (idPilihDokter == 4) {
            url = "<?php echo Yii::app()->createUrl('rawatJalan/tindakan/GetDokterPerawat'); ?>";
        }

        $.post(url, {
            id: id
        }, function(data) {
            var res = data[0];
            console.log(idPilihDokter, 'ini id pilih dokter');

            //untuk dokter yang terchecklist
            var is_checked = $("#is_checked").val();
            console.log(is_checked, 'ini is checked')
            if (is_checked == 1) {
                var row_total = $('input[id="row"]');
                var count = row_total.length;
                for (let i = 0; i < count; i++) {
                    const checkbox = `RJTindakanPelayananT_${i}_checklist:checked`;
                    var isChecked = $('#' + checkbox).val();
                    if (isChecked) {
                        switch (idPilihDokter) {
                            case 1:
                                setDokterPemeriksa1(res, i);
                                $("#dokterpemeriksa1_id").val(res.label);
                                break;
                            case 2:
                                setDokterPemeriksa2(res, i);
                                $("#dokterpemeriksa2_id").val(res.label);
                                break;
                            case 3:
                                setDokterDelegasi(res, i);
                                $("#dokterdelegasi_id").val(res.label);
                                break;
                            case 4:
                                setDokterAnastesi(res, i);
                                $("#dokteranastesi_id").val(res.label);
                                break;
                            case 5:
                                setDokterPendamping(res, i);
                                $("#dokterpendamping_id").val(res.label);
                                break;
                            case 6:
                                setDokter6sampai10(res, 'dokter6', idPilihDokter, i);
                                $("#dokter6").val(res.label);
                                break;
                            case 7:
                                setDokter6sampai10(res, 'dokter7', idPilihDokter, i);
                                $("#dokter7").val(res.label);
                                break;
                            case 8:
                                setDokter6sampai10(res, 'dokter8', idPilihDokter, i);
                                $("#dokter8").val(res.label);
                                break;
                            case 9:
                                setDokter6sampai10(res, 'dokter9', idPilihDokter, i);
                                $("#dokter9").val(res.label);
                                break;
                            case 10:
                                setDokter6sampai10(res, 'dokter10', idPilihDokter, i);
                                $("#dokter10").val(res.label);
                                break;
                        }
                    }
                }
            } else {
                console.log(data, 'ini data')
                switch (idPilihDokter) {
                    case 1:
                        setDokterPemeriksa1(res);
                        $("#dokterpemeriksa1_id").val(res.label);
                        break;
                    case 2:
                        setDokterPemeriksa2(res);
                        $("#dokterpemeriksa2_id").val(res.label);
                        break;
                    case 3:
                        setDokterDelegasi(res);
                        $("#dokterdelegasi_id").val(res.label);
                        break;
                    case 4:
                        setDokterAnastesi(res);
                        $("#dokteranastesi_id").val(res.label);
                        break;
                    case 5:
                        setDokterPendamping(res);
                        $("#dokterpendamping_id").val(res.label);
                        break;
                    case 6:
                        setDokter6sampai10(res, 'dokter6', idPilihDokter);
                        $("#dokter6").val(res.label);
                        break;
                    case 7:
                        setDokter6sampai10(res, 'dokter7', idPilihDokter);
                        $("#dokter7").val(res.label);
                        break;
                    case 8:
                        setDokter6sampai10(res, 'dokter8', idPilihDokter);
                        $("#dokter8").val(res.label);
                        break;
                    case 9:
                        setDokter6sampai10(res, 'dokter9', idPilihDokter);
                        $("#dokter9").val(res.label);
                        break;
                    case 10:
                        setDokter6sampai10(res, 'dokter10', idPilihDokter);
                        $("#dokter10").val(res.label);
                        break;
                }
            }
        }, 'json');
    }

    function setPilihPerawat(val, type) {
        idPilihPerawat = val;
        if(type != 'autocomplete') {
            $("#dialogPerawat").dialog('open');
        }
    }

    function pilihPerawat(id) {
        $("#dialogPerawat").dialog('close');
        $.post("<?php echo Yii::app()->createUrl('rawatJalan/tindakan/getPerawat'); ?>", {
            id: id
        }, function(data) {
            var res = data[0];

            console.log(idPilihPerawat);

            var is_checked = $("#is_checked").val();
            if (is_checked == 1) {
                var row_total = $('input[id="row"]');
                var count = row_total.length;
                for (let i = 0; i < count; i++) {
                    const checkbox = `RJTindakanPelayananT_${i}_checklist:checked`;
                    var isChecked = $('#' + checkbox).val();
                    if (isChecked) {
                        switch (idPilihPerawat) {
                            case 1:
                                setPerawat(res, i);
                                $("#perawat_id").val(res.label);
                                break;
                            case 2:
                                setPerawat2(res, i);
                                $("#perawat2_id").val(res.label);
                                break;
                        }
                    }

                }
            } else {
                switch (idPilihPerawat) {
                    case 1:
                        setPerawat(res);
                        $("#perawat_id").val(res.label);
                        break;
                    case 2:
                        setPerawat2(res);
                        $("#perawat2_id").val(res.label);
                        break;
                }
            }
        }, 'json');
    }

    function pilihBidan(id) {
        $("#dialogBidan").dialog('close');
        $.post("<?php echo Yii::app()->createUrl('rawatJalan/tindakan/getBidan'); ?>", {
            id: id
        }, function(data) {
            var res = data[0];

            console.log(idPilihBidan);

            var is_checked = $("#is_checked").val();
            if (is_checked == 1) {
                var row_total = $('input[id="row"]');
                var count = row_total.length;
                for (let i = 0; i < count; i++) {
                    const checkbox = `RJTindakanPelayananT_${i}_checklist:checked`;
                    var isChecked = $('#' + checkbox).val();
                    if (isChecked) {
                        switch (idPilihBidan) {
                            case 1:
                                setBidan(res, i);
                                $("#bidan_id").val(res.label);
                                break;
                            case 2:
                                setBidan2(res, i);
                                $("#bidan2_id").val(res.label);
                                break;
                            case 3:
                                setBidan3(res, i);
                                $("#bidan3_id").val(res.label);
                                break;
                        }
                    }

                }
            } else {
                switch (idPilihBidan) {
                    case 1:
                        setBidan(res);
                        $("#bidan_id").val(res.label);
                        break;
                    case 2:
                        setBidan2(res);
                        $("#bidan2_id").val(res.label);
                        break;
                    case 3:
                        setBidan3(res);
                        $("#bidan3_id").val(res.label);
                        break;
                }
            }



            // setBidan(res);
            // $("#bidan_id").val(res.label);
        }, 'json');
    }

    /** awal --- fungsi untuk set and get data supir**/
    function setPilihSupir(val) {
        idPilihSupir = val;
        $("#dialogSupir").dialog('open');
    }

    function pilihSupir(id) {
        $("#dialogSupir").dialog('close');
        $.post("<?php echo Yii::app()->createUrl('/ActionAutoComplete/getSupir'); ?>", {
            id: id
        }, function(data) {
            var res = data[0];

            var is_checked = $("#is_checked").val();
            if (is_checked) {
                var row_total = $('input[id="row"]');
                var count = row_total.length;
                for (let i = 0; i < count; i++) {
                    const checkbox = `RJTindakanPelayananT_${i}_checklist:checked`;
                    var isChecked = $('#' + checkbox).val();
                    if (isChecked) {
                        setSupir(res, i);
                        $("#supir_id").val(res.label);
                    }

                }
            } else {
                setSupir(res);
                $("#supir_id").val(res.label);
            }



        }, 'json');
    }
    /** akhir --- fungsi untuk set and get data supir**/

    function cekPerawat() {
        var no = $("#dialogPemeriksaLengkap #rowTindakan").val();
        var kelompoktindakan_id = $('#RJTindakanPelayananT_' + no + '_keltindakanid').val();

        var perawat = $('#RJTindakanPelayananT_' + no + '_perawat_id').val();
        // var perawat2 = $('#RJTindakanPelayananT_'+no+'_perawat2_id').val();

        if (kelompoktindakan_id == <?php echo Params::KELOMPOKTINDAKAN_ID_AMBULANS ?>) {
            $("#perawat_id").attr('style', '');
            // $("#perawat2_id").attr('style','');

            if (perawat == '') {
                $("#perawat_id").attr('style', 'border:1px solid red;');
            }
            /*
            if (perawat2 == ''){
            	$("#perawat2_id").attr('style','border:1px solid red;');		
            }
            */

            if (perawat == '' //|| perawat2 == ''
            ) {
                alert("Data perawat belum diisi atau belum di pilih ");
                $("#dialogPemeriksaLengkap").dialog('open');
            }
        }
    }
</script>