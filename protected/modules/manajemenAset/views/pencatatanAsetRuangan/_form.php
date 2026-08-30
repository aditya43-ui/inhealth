
<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
	'id' => 'guinvperalatan-t-form',
	'enableAjaxValidation' => false,
	'type' => 'horizontal',
	'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)', 'onsubmit' => 'return requiredCheck(this);','onkeyup'=>(!isset($_GET['sukses'])) ? 'cekDisabled(this);' : '','onclick'=>(!isset($_GET['sukses']))? 'cekDisabled(this);' : ''),
	'focus' => '#',
		));
?>

<?php echo $form->errorSummary($model); ?>   
<p class="help-block" style="color:#333;"><?php echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') ?></p>

<?php $this->renderPartial('_dataBarang', array('modBarang' => $modBarang, 'model' => $model, 'modelDetail' => $modelDetail, 'jenisAset'=>'"'. ParamsConst::KODE_GOLONGAN_MESIN_ALAT.'"')); ?>
	<div class="panel panel-primary panel-success">
            <div class="panel-heading">
                <div class="panel-title">											
                    <i class="glyphicon glyphicon-file"></i> Data Inventarisasi Peralatan dan Mesin																	
                </div>
            </div>
            <div class="panel-body">
                <div class="row-fluid">
                    <div class="span6">
                        
                        <?php echo $form->hiddenField($model, 'barang_id',['class'=>'barang_id']); ?>
                        <?php echo $form->hiddenField($model, 'terimapersdetail_id'); ?>
                        <?php echo $form->hiddenField($model, 'barang_nama', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                        
                        <div class="control-group ">
                            <?php echo $form->labelEx($model, 'pemilikbarang_id', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php echo $form->dropDownList($model, 'pemilikbarang_id', CHtml::listData(PemilikbarangM::model()->findAll("pemilikbarang_aktif = true"), 'pemilikbarang_id', 'pemilikbarang_nama'), array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)", 'empty' => '-- Pilih --')); ?>
                            </div>
                        </div>
                        <div class="control-group ">
                            <?php echo $form->labelEx($model, 'asalaset_id', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php echo $form->dropDownList($model, 'asalaset_id', CHtml::listData(AsalasetM::model()->findAll(" asalaset_aktif = true "), 'asalaset_id', 'asalaset_nama'), array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)", 'empty' => '-- Pilih --')); ?>
                            </div>
                        </div>
                        <div class="control-group ">
                            <?php echo $form->labelEx($model, 'lokasi_id', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php echo $form->dropDownList($model, 'lokasi_id', CHtml::listData(LokasiasetM::model()->findAll(" lokasiaset_aktif = TRUE ORDER BY lokasiaset_namalokasi ASC "), 'lokasi_id', 'lokasiaset_namalokasi'), array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)", 'empty' => '-- Pilih --')); ?>
                            </div>
                        </div>
                        <div class="control-group ">
                            <?php echo $form->labelEx($model, 'cara_perolehan', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php echo $form->dropDownList($model, 'cara_perolehan', LookupM::getItemsUrutan('cara_perolehan'), array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)", 'empty' => '-- Pilih --')); ?>
                            </div>
                        </div>
                        <div class="control-group ">
                            <?php echo $form->labelEx($model, 'tanggal_perolehan', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php
                                $this->widget('MyDateTimePicker', array(
                                    'model' => $model,
                                    'attribute' => 'tanggal_perolehan',
                                    'mode' => 'date',
                                    'options' => array(
                                        'dateFormat' => Params::DATE_FORMAT,
                                        'maxDate' => 'd',
                                        'onSelect' => 'js:function(){setTahun(this)}'
                                    ),
                                    'htmlOptions' => array('readonly' => true, 'class' => 'span3 dtPicker3', 'onkeypress' => "return $(this).focusNextInputField(event)",
                                    ),
                                ));
                                ?>
                                <?php echo $form->error($model, 'invperalatan_tglguna'); ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">Nomor Dokumen Perolehan</label>
                            <div class="controls">
                                <?php echo $form->textField($model, 'nomor_kontrak', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50));?>
                            </div>
                        </div>
                        <div class="control-group ">
                            <label class="control-label">Sumber Dana</label>
                            <div class="controls">
                                <?php echo $form->dropDownList($model, 'sumberdana', CHtml::listData(SumberdanaM::model()->findAll("sumberdana_aktif = TRUE"), 'sumberdana_nama', 'sumberdana_nama'), array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)", 'empty' => '-- Pilih --')); ?>
                            </div>
                        </div>
                        
                        <div class="control-group ">
                            <?php echo $form->labelEx($model, 'invperalatan_thnpembelian', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php echo $form->textField($model, 'invperalatan_thnpembelian', array('class' => 'span1 numbersOnly invperalatan_thnpembelian', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 5)); ?>
                            </div>
                        </div>
                        <div class="control-group ">
                            <?php echo $form->labelEx($model, 'invperalatan_tglguna', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php
                                $this->widget('MyDateTimePicker', array(
                                    'model' => $model,
                                    'attribute' => 'invperalatan_tglguna',
                                    'mode' => 'date',
                                    'options' => array(
                                        'dateFormat' => Params::DATE_FORMAT,
                                        'maxDate' => 'd',
                                    ),
                                    'htmlOptions' => array('readonly' => true, 'class' => 'span3 dtPicker3', 'onkeypress' => "return $(this).focusNextInputField(event)",
                                    ),
                                ));
                                ?>
                                <?php echo $form->error($model, 'invperalatan_tglguna'); ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo CHtml::label('Tipe/Model','',array('class'=>'control-label')); ?>
                            <div class="controls">
                               <?php echo $form->textField($model, 'peralatan_model', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?> 
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo CHtml::label('Manufacturer','',array('class'=>'control-label')); ?>
                            <div class="controls">
                              <?php echo $form->textField($model, 'peralatan_manufacturer', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>    
                            </div>
                        </div>
                    </div>
                    <div class="span6">
                        <div class="control-group ">
                            <?php echo $form->labelEx($model, 'invperalatan_merk', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php echo $form->textField($model, 'invperalatan_merk', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
                            </div>
                        </div>
                        <div class="control-group ">
                            <?php echo $form->labelEx($model, 'invperalatan_ukuran', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php echo $form->textField($model, 'invperalatan_ukuran', array('class' => 'span1 numbersOnly', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
                            </div>
                        </div>
                        <div class="control-group ">
                            <?php echo $form->labelEx($model, 'invperalatan_bahan', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php echo $form->textField($model, 'invperalatan_bahan', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
                            </div>
                        </div>
                        <div class="control-group ">
                            <?php echo $form->labelEx($model, 'invperalatan_harga', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php echo $form->textField($model, 'invperalatan_harga', array('class' => 'span2 numbersOnly', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                            </div>
                        </div>
                        <div class="control-group ">
                            <?php echo $form->labelEx($model, 'invperalatan_kapasitasrata', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php echo $form->textField($model, 'invperalatan_kapasitasrata', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 10)); ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo CHtml::label("",'invperalatan_ijinoperasional', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php echo $form->checkBox($model,'invperalatan_ijinoperasional',array('checked'=>'invperalatan_ijinoperasional')); ?>
                                <?php echo $form->labelEx($model,'invperalatan_ijinoperasional');?>
                            </div>				
                        </div>
                        
                        <div class="control-group ">
                            <?php echo CHtml::label('Garansi Habis','',array('class'=>'control-label')); ?>
                            <div class="controls">
                            <?php
                            $this->widget('MyDateTimePicker', array(
                                'model' => $model,
                                'attribute' => 'peralatan_garansihabis',
                                'mode' => 'date',
                                'options' => array(
                                    'dateFormat' => Params::DATE_FORMAT,
                                    
                                ),
                                'htmlOptions' => array('readonly' => true, 'class' => 'dtPicker3', 'onkeypress' => "return $(this).focusNextInputField(event)",'style'=>'width:204px;'
                                ),
                            ));
                            ?>
                            </div>
                        </div>  
                        <div class="control-group">
                            <?php echo CHtml::label('Daya LIstrik','',array('class'=>'control-label')); ?>
                            <div class="controls">
                             <?php echo $form->textField($model, 'peralatan_dayalistrik', array('class' => 'span3 integer', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>    
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="detail_inv">
                    
                </div>
        </div>

</div>
<div class="form-actions">
    <?php
    echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="entypo-check"></i>')) :
                                    Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('class' =>(isset($_GET['sukses']))? 'btn btn-danger' : 'btn btn-danger submit', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)','disabled'=>(isset($_GET['sukses']))? true : false));
    ?>
    <?php
    echo CHtml::link(Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')), $this->createUrl($this->module->id . '/Create'), array('class' => 'btn btn-default',
            'onclick' => 'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r) {if(r) window.location = "' . $this->createUrl('Create') . '";} ); return false;'));
    ?>
    &nbsp;
    <?php $content = $this->renderPartial('tips/transaksi', array(), true);
    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
    ?>
</div>

<?php $this->endWidget(); ?>
<?php
$js = <<< JS
$('.numbersOnly').keyup(function() {
var d = $(this).attr('numeric');
var value = $(this).val();
var orignalValue = value;
value = value.replace(/[0-9]*/g, "");
var msg = "Only Integer Values allowed.";

if (d == 'decimal') {
value = value.replace(/\./, "");
msg = "Only Numeric Values allowed.";
}

if (value != '') {
orignalValue = orignalValue.replace(/([^0-9].*)/g, "")
$(this).val(orignalValue);
}
});
JS;
Yii::app()->clientScript->registerScript('numberOnly', $js, CClientScript::POS_READY);
?>

<script>
    var setTahun = (obj) => {        
        let val = $(obj).val();        
        let pecah = val.split(" ");                
        
        $(".invperalatan_thnpembelian").val(pecah[2]);
    }
    
    var enableKode = (obj) => {
        var cek = $(obj).prop('checked');
        
        $(obj).parents(".list-data").find('.kode_aset').attr('readonly',true);
        if (cek)
            $(obj).parents(".list-data").find('.kode_aset').removeAttr('readonly');        
    }
    
    function setKodeRegister(barang_id) {
        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('GetkodeRegister'); ?>',
            data: {barang_id: barang_id}, 
            dataType: "json",
            success: function (data) {
                    $('#MAInvperalatanT_invperalatan_noregister').val(data.value);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                    console.log(errorThrown);
            }
        });
    }
        
    function setDetailInvAlat(obj){
                
        var jumlah = $("#<?php echo CHtml::activeId($modBarang,'jmlterima'); ?>").val();
        var barang_id = $(".barang_id").val();
        
        if (jumlah < 1){
            toastr.error("Jumlah Aset, tidak boleh 0","Perhatian!");
            return false;
        }
        
        if (barang_id == ''){
            $(obj).val(0);
            toastr.error("Aset belum dipilih","Perhatian!");
            return false;
        }
        
        var subsub = $("#MABarangM_subsubkelompok_nama").val()
        
        if (subsub == ''){
            toastr.error("Sub sub kelompok tidak ditemukan","Perhatian!");
            return false;
        }
                
                
        setDetail(jumlah, barang_id);        
                
    }
    
    var setDetail = (jumlah, barang_id) => {
        $.ajax({
            type: 'GET',
            url: '<?php echo $this->createUrl('LoadDetailInvAlat'); ?>',
            data: {
                jumlah: jumlah,
                barang_id: barang_id
            },
            dataType: "json",
            success: function (data) {
                $('.detail_inv').html(data.rows);                
                $("#<?php echo CHtml::activeId($modBarang,'register_awal'); ?>").val(data.awal);
                $("#<?php echo CHtml::activeId($modBarang,'register_akhir'); ?>").val(data.akhir);
                renameAsetDetail();
                
                $("#temp_barang_id").val(barang_id);
                $("#temp_barang_nama").val(data.barang_nama);
                $("#temp_jmlterima").val(jumlah);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                    console.log(errorThrown);
            }
        });
    }
    
    function cekKodeAset(obj){
        var barang_id = $('#MAInvperalatanT_barang_id').val();
        var noregister = $('#MAInvperalatanT_invperalatan_noregister').val();
        var kode = $(obj).val();
        var jml_duplikat = 0;
        $('.kode_aset').each(function(){
            if($(this).val() != ''){
                if($(obj).val() == $(this).val()){
                    jml_duplikat++;
                }
                if(jml_duplikat >= 2){
                    myAlert("Kode yang dimasukan sudah digunakan");
                    $(obj).val('');
                    return false;
                }
            }
        });  
        if(jml_duplikat < 2){
            $.ajax({
                type: 'GET',
                url: '<?php echo $this->createUrl('CekKodeAset'); ?>',
                data: {barang_id: barang_id,noregister: noregister,kode: kode},
                dataType: "json",
                success: function (data) {
                    if(data.status != 'OK'){
                        myAlert("Kode yang dimasukan sudah digunakan");
                        $(obj).val('');
                        return false;
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                        console.log(errorThrown);
                }
            });
        }
    }
    
    function renameAsetDetail(){
        var x = 1;
        $('.urutan_aset_det').each(function(){
            $(this).html(x);
            x++;
        });
    }
       
        
    $( document ).ready(function(){
        cekDisabled($('#guinvperalatan-t-form'));
        <?php if (isset($_GET['sukses'])) { ?>
            $("input, select, textarea").attr('disabled', true);
        <?php } ?>
    });
</script>