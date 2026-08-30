<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/accounting2.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form2.js', CClientScript::POS_END); ?>


<!--fieldset-->
    <?php //Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>
    <?php
        if(isset($_GET['sukses'])){
            Yii::app()->user->setFlash('success','<strong>Berhasil!</strong> Data berhasil disimpan.');
        }

    $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
        'id' => 'gupembelianbarang-t-form',
        'enableAjaxValidation' => false,
        'type' => 'horizontal',
        'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)', 'onsubmit' => 'return requiredCheck(this);'),
        'focus' => '#',
    ));

    echo CHtml::hiddenField('data_dihapus');

    ?>
    <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
<div class="row-fluid">
    <div class="col-sm-12">
         <p class="help-block"><?php echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') ?></p>
        <?php echo $form->errorSummary($model); ?>

         <div class="panel panel-success panel-shadow">
            <div class="panel-heading">
                <div class="panel-title">Data Rencana Kebutuhan</div>
            </div>
            <div class="panel-body">
                <div class="row-fluid">
                    <div class="col-sm-6">
                        <div class="control-group ">
                            <?php echo $form->label($renc, 'renkebbarang_no', array('class' => 'control-label')); ?>
                            <div class="controls">
                                <?php echo $form->hiddenField($model, 'renkebbarang_id'); ?>
                                <?php echo $form->textField($renc, 'renkebbarang_no', array('readonly' => TRUE, 'class'=>'span3')); ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo $form->label($renc, 'renkebbarang_tgl', array('class' => 'control-label')); ?>
                            <div class="controls">
                                <?php echo $form->textField($renc, 'renkebbarang_tgl', array('readonly' => TRUE, 'class'=>'span3')); ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="control-group">
                            <?php echo CHtml::label("Sumber Dana", '', array('class' => 'control-label')); ?>
                            <div class="controls">
                                <?php echo $form->hiddenField($model, 'sumberdana_id'); ?>
                                <?php echo $form->textField($model, 'sumberdana_nama', array('class'=>'span3','readonly' => TRUE)); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

         <div class="panel panel-success panel-shadow">
            <div class="panel-heading">
                <div class="panel-title">Data Permintaan Pembelian</div>
            </div>
            <div class="panel-body">
                <div class="row-fluid">
                    <div class="col-sm-6">
                        <?php echo $form->textFieldRow($model, 'nopembelian', array('readonly' => true, 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
                        <div class="control-group ">
                            <?php echo $form->labelEx($model, 'tglpembelian', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php
                                $this->widget('MyDateTimePicker', array(
                                        'model' => $model,
                                        'attribute' => 'tglpembelian',
                                        'mode' => 'datetime',
                                        'options' => array(
                                                'dateFormat' => Params::DATE_FORMAT,
                                                'maxDate' => 'd',
                                        ),
                                        'htmlOptions' => array('readonly' => true, 'class' => 'dtPicker3 span3', 'onkeypress' => "return $(this).focusNextInputField(event)",),
                                ));
                                ?>
                                <?php echo $form->error($model, 'tglpembelian'); ?>
                            </div>
                        </div>
                        <?php echo $form->dropDownListRow($model, 'supplier_id', CHtml::listData(SupplierM::model()->getSupplierUmumItems(), 'supplier_id', 'supplier_nama'), array('empty' => '-- Pilih --', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                        <div class="control-group ">
                            <?php echo $form->labelEx($model, 'tgldikirim', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php
                                $this->widget('MyDateTimePicker', array(
                                        'model' => $model,
                                        'attribute' => 'tgldikirim',
                                        'mode' => 'datetime',
                                        'options' => array(
                                                'dateFormat' => Params::DATE_FORMAT,
                                                'minDate' => 'd',
                                        ),
                                        'htmlOptions' => array('readonly' => true, 'class' => 'dtPicker3 span3', 'onkeypress' => "return $(this).focusNextInputField(event)",),
                                ));
                                ?>
                                <?php echo $form->error($model, 'tgldikirim'); ?>
                            </div>
                        </div>
                        <?php echo $form->textAreaRow($model, 'alamatpengirim', array('class' => 'span3')); ?>
                        <?php echo $form->textFieldRow($model, 'noreferensi', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
                    </div>
                    <div class="col-sm-6">
                        <div class="control-group">
                            <?php echo CHtml::label("Jenis PPh","pajak_id",array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php echo $form->dropDownList($model,'pajak_id',
                                        CHtml::listData(PajakM::model()->findAll('pajak_aktif = true AND ispajakpegawai = false AND isppnkeluaran = false ORDER BY pajak_nama ASC'), 'pajak_id', 'pajak_nama'),
                                        array('class'=>'span2', 'onkeyup'=>"return $(this).focusNextInputField(event)",
                                        'empty'=>'-- Pilih --',)); ?>
                            </div>
                        </div>
                        <?php echo $form->textAreaRow($model, 'keterangan', array('class' => 'span3')); ?>
                        <div class="control-group ">
                                <?php echo $form->labelEx($model, 'peg_pemesanan_id', array('class' => 'control-label')); ?>
                            <div class="controls">
                                <?php echo $form->hiddenField($model, 'peg_pemesanan_id'); ?>
                                <?php echo $form->textField($model, 'peg_pemesan_nama', array('class'=>'span3', 'readonly'=>TRUE)); ?>
                            </div>
                        </div>
                        <div class="control-group ">
                            <?php echo Chtml::label("Manajer Umum <font style='color:red'>*</font>", '', array('class' => 'control-label')); ?>
                            <div class="controls">
                                <?php echo $form->hiddenField($model, 'peg_mengetahui_umum_id'); ?>
                                <?php echo $form->textField($model, 'peg_mengetahui_umum_nama', array('class'=>'span3', 'readonly'=>TRUE)); ?>
                            </div>
                        </div>
                        <div class="control-group ">
                            <?php echo Chtml::label("Manajer Keuangan <font style='color:red'>*</font>", 'peg_mengetahui_id', array('class' => 'control-label')); ?>
                            <div class="controls">
                                <?php echo $form->hiddenField($model, 'peg_mengetahui_id'); ?>
                                <?php echo $form->textField($model, 'peg_mengetahui_nama', array('class'=>'span3', 'readonly'=>TRUE)); ?>
                                <?php echo $form->error($model, 'peg_mengetahui_id'); ?>
                            </div>
                        </div>
                        <div class="control-group ">
                            <?php echo Chtml::label("Direktur <font style='color:red'>*</font>", 'peg_menyetujui_id', array('class' => 'control-label')); ?>
                            <div class="controls">
                                <?php echo $form->hiddenField($model, 'peg_menyetujui_id'); ?>
                                <?php echo $form->textField($model, 'peg_menyetujui_nama', array('class'=>'span3', 'readonly'=>TRUE)); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php echo $form->hiddenField($model, 'is_uangmukapembelian', array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event)")); ?>
        <?php $this->Widget('ext.bootstrap.widgets.BootAccordion',array(
            'id'=>'form-uangmukapembelian',
            'content'=>array(
                'content-uangmukapembelian'=>array(
                    'header'=>CHtml::htmlButton("<i class='icon-minus icon-white'></i>",array('class'=>'btn btn-primary btn-mini','onclick'=>'','onkeyup'=>"return $(this).focusNextInputField(event)",'rel'=>'tooltip','title'=>'Klik untuk tampilkan form Permintaan Uang Muka Pembelian')).'<b> Data Permintaan Uang Muka Pembelian</b>',
                    'isi'=>$this->renderPartial($this->path_view.'_formUangMuka',array(
                        'form'=>$form,
                        'model'=>$model,
                    ),true),
                    'active'=>$model->is_uangmukapembelian,
                ),
            ),
        )); ?>

        <div class="panel panel-success panel-shadow">
            <div class="panel-heading">
                <div class="panel-title">Tabel Permintaan <strong>Pembelian Barang</strong></div>
            </div>
            <div class="panel-body">
                <?php
                    if (isset($modDetails)) {
                        echo $form->errorSummary($modDetails);
                    }
                ?>
                <?php // $this->renderPartial($this->path_view.'_formDetailBarang', array('model' => $model, 'form' => $form)); ?>
                <?php $this->renderPartial($this->path_view.'_tableDetailBarang', array('model' => $model, 'form' => $form, 'modDetails' => $modDetails)); ?>
            </div>
        </div>

        <div class="form-actions">
            <?php
                if(isset($_GET['sukses'])){
                    echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','disabled'=>true));
                }else{
                    echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),array('class'=>'btn btn-primary btn_submit', 'type'=>'button','onclick'=>'cekValidasi()'));
                }
            ?>
            <?php
            echo CHtml::link(Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="icon-refresh icon-white"></i>')), $this->createUrl($this->module->id . '/Index'), array('class' => 'btn btn-danger',
                'onclick' => 'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r) {if(r) window.location = "' . $this->createUrl('Index') . '";} ); return false;'));
            ?>
            <?php
                if(isset($_GET['sukses'])){
                        echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}'=>'<i class="icon-print icon-white"></i>')), 'javascript:void(0);', array('class'=>'btn btn-info', 'onclick'=>"print('PRINT')",'disabled'=>false));
                }else{
                        echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}'=>'<i class="icon-print icon-white"></i>')), 'javascript:void(0);', array('class'=>'btn btn-info','disabled'=>true));
                }
            ?>
            <?php
            $content = $this->renderPartial('pengadaan.views.tips/transaksi4', array(), true);
            $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
            ?>
        </div>
    </div>
</div>

<?php $this->endWidget(); ?>

<?php
//========= Dialog buat cari Rencana Pembelian Barang =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogRencana',
    'options' => array(
        'title' => 'Daftar Rencana Pembelian Barang',
        'autoOpen' => false,
        'modal' => true,
        'width' => 750,
        'height' => 600,
        'resizable' => false,
    ),
));

$modrencana=new ADInformasirenkebbarangV;
$format = new MyFormatter();


if(isset($_GET['ADInformasirenkebbarangV'])){
	$modrencana->attributes=$_GET['ADInformasirenkebbarangV'];
}

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'rencana-m-grid',
    'dataProvider' => $modrencana->searchInformasiDialog(),
    'filter' => $modrencana,
    'template'=>"{summary}\n{items}\n{pager}",
    'itemsCssClass'=>'table table-striped table-bordered table-condensed',
    'columns' => array(
        ////'pegawai_id',
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small",
                                    "id" => "selectBahan",
                                    "onClick" => "
									loadRencana(".$data->renkebbarang_id.");
									$(\"#dialogRencana\").dialog(\"close\");
                                    return false;"))',
        ),
        array(
			'header'=>'Tanggal Rencana',
			'type'=>'raw',
			'value'=>'MyFormatter::formatDateTimeForUser($data->renkebbarang_tgl)',
                         'filter'=>$this->widget('MyDateTimePicker', array(
                                'model'=>$modrencana,
                                'attribute'=>'renkebbarang_tgl',
                                'mode' => 'date',
                                //'language' => 'ja',
                                // 'i18nScriptFile' => 'jquery.ui.datepicker-ja.js', (#2)
                                'htmlOptions' => array(
                                    'id' => 'datepicker_for_due_date',
                                    'size' => '10',
                                    'style'=>'width:80%'
                                ),
                                'options' => array(  // (#3)
                                    'dateFormat' => Params::DATE_FORMAT,
                                    'maxDate' => 'd',
                                ),
                            ),
                            true),
		),
                array(
                    'header' => 'No Rencana',
                    'name' => 'renkebbarang_no',
                    'filter' => Chtml::activeTextField($modrencana, 'renkebbarang_no', array('class' => 'alphanumeric-only'))
                ),
                array(
                    'header' => 'Recomended Order(RO)',
                    'name' => 'ro_barang_bulan',
                    'filter' => Chtml::activeTextField($modrencana, 'ro_barang_bulan', array('class' => 'numbers-only'))
                ),
		array(
			'header'=>'Pegawai Mengetahui',
			'type'=>'raw',
			'value'=>'ADInformasirenkebbarangV::pegawaimengetahui($data->pegmengetahui_id)',
		),
		array(
			'header'=>'Pegawai Menyetujui',
			'type'=>'raw',
			'value'=>'ADInformasirenkebbarangV::pegawaimengetahui($data->pegmenyetujui_id)',
		),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});'
    . 'reinstallDatePicker();'
    . '$(".alphanumeric-only").keyup(function() {
        setAlphaNumericOnly(this);
        });
        $(".numbers-only").keyup(function() {
        setNumbersOnly(this);
        });
    }',
));

$this->endWidget();
Yii::app()->clientScript->registerScript('re-install-date-picker', "
function reinstallDatePicker(id, data) {
    $('#datepicker_for_due_date').datepicker(jQuery.extend({showMonthAfterYear:false},jQuery.datepicker.regional['id'],{'dateFormat':'".Params::DATE_FORMAT."','changeMonth':true, 'changeYear':true,'maxDate':'d'}));
}
");
?>


<?php
//========= Dialog buat cari Bahan Diet =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogPegawai',
    'options' => array(
        'title' => 'Daftar Pegawai',
        'autoOpen' => false,
        'modal' => true,
        'width' => 750,
        'height' => 600,
        'resizable' => false,
    ),
));

$modPegawai = new PegawairuanganV('search');
$modPegawai->unsetAttributes();
$modPegawai->ruangan_id = Yii::app()->user->getState('ruangan_id');
//$modPegawai->ruangan_id = 0;
if (isset($_GET['PegawairuanganV'])){
    $modPegawai->attributes = $_GET['PegawairuanganV'];
    $modPegawai->ruangan_id = Yii::app()->user->getState('ruangan_id');
}

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'pegawai-m-grid',
    'dataProvider' => $modPegawai->search(),
    'filter' => $modPegawai,
    'template'=>"{summary}\n{items}\n{pager}",
    'itemsCssClass'=>'table table-striped table-bordered table-condensed',
    'columns' => array(
        ////'pegawai_id',
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small",
                                    "id" => "selectBahan",
                                    "onClick" => "
                                    var parent = $(\"#dialogPegawai\").attr(\"parentclick\");
                                    $(\"#\"+parent+\"\").val($data->pegawai_id);
                                    $(\"#\"+parent+\"\").parents(\".controls\").find(\".namaPegawai\").val(\"$data->nama_pegawai\");
                                    $(\'#dialogPegawai\').dialog(\'close\');
                                    return false;"))',
        ),
        array(
            'header' => 'NIP',
            'name' => 'nomorindukpegawai',
            'value' => '$data->nomorindukpegawai',
            'filter' => Chtml::activeTextField($modPegawai, 'nomorindukpegawai', array('class'=>'numbers-only'))
        ),
        array(
            'header' => 'Nama Pegawai',
            'name' => 'nama_pegawai',
            'value' => '$data->namaLengkap',
            'filter' => Chtml::activeTextField($modPegawai, 'nama_pegawai', array('class'=>'hurufs-only'))
        ),
        array(
            'header' => 'Jabatan',
            'name' => 'jabatan_id',
            'value' => function ($data){
                $p = JabatanM::model()->findByPk($data->jabatan_id);

                if (!empty($p)){
                    return $p->jabatan_nama;
                }else{
                    return '-';
                }
            },
            'filter' => Chtml::activeDropDownList($modPegawai, 'jabatan_id', Chtml::listData(JabatanM::model()->findAll("jabatan_aktif = TRUE ORDER BY jabatan_nama ASC"),'jabatan_id','jabatan_nama') ,array('empty'=>'-- Pilih --'))
        ),

    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});'
    . '$(".numbers-only").keyup(function() {
        setNumbersOnly(this);
        });
        $(".hurufs-only").keyup(function() {
        setHurufsOnly(this);
        });'
    . '}',
));

$this->endWidget();
?>
<?php
$this->widget('application.extensions.moneymask.MMask', array(
    'element' => '.numbersOnly',
    'config' => array(
        'defaultZero' => true,
        'allowZero' => true,
        'decimal' => ',',
        'thousands' => '',
        'precision' => 0,
    )
));
?>

<script type="text/javascript">

function loadRencana(id)
{
	$.post('<?php echo $this->createUrl("loadRencana") ?>', {
		id: id,
	}, function(data) {
		$("#ADPembelianbarangT_renkebbarang_id").val(data.rencana.renkebbarang_id);
		$("#RenkebbarangT_renkebbarang_no").val(data.rencana.renkebbarang_no);
		$("#RenkebbarangT_renkebbarang_tgl").val(data.rencana.renkebbarang_tgl);

		$("#tableDetailBarang tbody").html(data.html);
                hitungAllTotal();
		$("#tableDetailBarang tbody .numbersOnly").maskMoney(
			{"symbol":"","defaultZero":true,"allowZero":true,"decimal":",","thousands":"","precision":0}
		);
		$("#tableDetailBarang tbody .integer2").maskMoney(
			{"symbol":"","defaultZero":true,"allowZero":true,"decimal":",","thousands":".","precision":0}
		);
		rename();
		clear();
	}, "json");
}

 function hitungAllTotal(){
     unformatNumberSemua();
     var total = 0;
     $('#tableDetailBarang tbody tr').each(function(){
        var satuan = parseFloat($(this).find(".satuan").val());
        var ppn = parseInt($(this).find(".ppn").val());
        var jml = parseFloat($(this).find(".qty").val());
        var persendiskon = parseFloat($(this).find(".persendiscount").val());
        var persenpph = parseFloat($(this).find(".persenpph").val());

        var hargajml = (satuan * jml);
        if (hargajml > 0){
            // hargajml = parseFloat(hargajml.toFixed(2));
            hargajml = (hargajml * 100).toFixed(0) / 100;
        }

         var jmldiskon = ((hargajml * persendiskon)/100);
         if (jmldiskon > 0){
            jmldiskon = (jmldiskon * 100).toFixed(0) / 100;
            // jmldiskon = parseFloat(jmldiskon.toFixed(2));
        }

        var jmlppn = (((hargajml - jmldiskon) * ppn)/100);
        
         if (jmlppn > 0){
            
            // jmlppn = parseFloat(jmlppn.toFixed(2));
            jmlppn = (jmlppn * 100).toFixed(0) / 100;
        }

         var jmlpph = (((hargajml - jmldiskon) * persenpph)/100);
         if (jmlpph > 0){
            // jmlpph = parseFloat(jmlpph.toFixed(2));
            jmlpph = (jmlpph * 100).toFixed(0) / 100;
        }
        var subtotal = (hargajml - jmldiskon + jmlppn - jmlpph);
         if (subtotal > 0){
            // subtotal = parseFloat(subtotal.toFixed(2));
            subtotal = (subtotal * 100).toFixed(0) / 100;
        }
        $(this).find(".hpp").val(subtotal);
        $(this).find(".ppn_nilai").val(jmlppn);
        $(this).find(".jmldiscount").val(jmldiskon);
        $(this).find(".jmlpph").val(jmlpph);
        $(this).find(".beli").val(subtotal);
         total += subtotal;
    });
    $('#total').val(total);
    formatNumberSemua();
    checkuangmuka();
 }

 function checkuangmuka(){
     unformatNumberSemua();
     var uangmuka = parseFloat($('#<?php echo CHtml::activeId($model, 'jmlpermintaanuangmuka'); ?>').val());
     var total = parseFloat($('#total').val());

     if(uangmuka > total){
         myAlert("Jumlah Uang Muka Tidak Boleh Lebih Besar dari Total Permintaan Pembelian Barang");
         $('#<?php echo CHtml::activeId($model, 'jmlpermintaanuangmuka'); ?>').val(0);
     }
     formatNumberSemua();
 }

function cekValidasi(){

    if ($("#tableDetailBarang tbody tr").length == 0) {
            myAlert("Data Tabel Permintaan Pembelian Barang belum diisi");
            return false;
    }

    var cekpph = 0;

    if (!requiredCheck($('form'))) return false;

    $("#tableDetailBarang tbody tr").each(function() {
        unformatNumberSemua();
        var persenpph  = parseFloat($(this).find('.persenpph').val());
        if(persenpph > 0){
            cekpph += 1;
        }else{
            if(cekpph > 1){
                cekpph -= 1;
            }
        }
        formatNumberSemua();
    });

    if(cekpph > 0){
        if($('#<?php echo CHtml::activeId($model, 'pajak_id'); ?>').val() == ''){
             myAlert("Jenis PPh harus diisi ");
            return false;
        }
    }

    $('.integer-decimal, .integer2, float2').each(function(){
       $(this).val(unformatNumber($(this).val()));
   });
   
    $(".btn_submit").prop("disabled", true);
    $("#gupembelianbarang-t-form").submit();


    return false;
}

function print(caraPrint)
{
    var id = '<?php echo (!empty($model->pembelianbarang_id)) ? $model->pembelianbarang_id : null; ?>';
    window.open('<?php echo $this->createUrl('print'); ?>&id='+id+'&caraPrint='+caraPrint,'printwin','left=100,top=100,width=1000,height=640');
}

$(document).ready(function () {
<?php
if (isset($model->pembelianbarang_id)) {

    ?>
            var params = [];
            params = {instalasi_id:<?php echo Yii::app()->user->getState("instalasi_id"); ?>, modul_id:<?php echo Params::MODUL_ID_AKUNTANSI ?>, judulnotifikasi: 'Permintaan Pembelian Barang', isinotifikasi: 'Telah dilakukan permintaan pembelian barang dengan <?php echo $model->nopembelian ?> pada <?php echo $model->tglpembelian ?>'}; // 16
            insert_notifikasi(params);
    <?php
}
?>
        hitungAllTotal();
    $('#form-uangmukapembelian > div > .accordion-heading').click(function () {
        var is_uangmukapembelian = $("#<?php echo CHtml::activeId($model, 'is_uangmukapembelian'); ?>");
        if (is_uangmukapembelian.val() > 0) { //hide
            is_uangmukapembelian.val(0);
        } else {//show
            is_uangmukapembelian.val(1);
        }
    });
});
</script>
