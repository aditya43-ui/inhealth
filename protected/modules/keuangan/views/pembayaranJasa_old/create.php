<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js'); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/accounting.js'); ?>
<?php
$this->widget('application.extensions.moneymask.MMask',array(
    'element'=>'.currency',
    'config'=>array(
        'defaultZero'=>true,
        'allowZero'=>true,
        'precision'=>0,
    )
));
?>
<div class="white-container">
    <?php
    $this->breadcrumbs=array(
        'Pembayaran Jasa',
    );
    ?>
    <legend class="rim2">Transaksi <b>Pembayaran Jasa Dokter</b></legend>
    <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
    <?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
        'id'=>'kupembayaranjasa-t-form',
        'enableAjaxValidation'=>false,
            'type'=>'horizontal',
            'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)', 
                // 'onsubmit'=>'unformatNumbers();'
                'onsubmit'=>'return requiredCheck(this);'
                ),
            'focus'=>'#KUPembayaranjasaT_pilihDokter',
    )); ?>
<?php echo $form->errorSummary($model); ?>
<?php
if(isset($_GET['sukses'])){
	Yii::app()->user->setFlash('success', "Data berhasil disimpan!");
}   
$this->widget('bootstrap.widgets.BootAlert'); ?>
<?php echo $this->renderPartial('_formCari', array('form'=>$form, 'model'=>$model)); ?>
	
<fieldset class="box">
	<div class="block-tabel">
		<h6>Tabel <b>Daftar Jasa</b></h6>
		<?php echo $this->renderPartial('_formDetail', array('form'=>$form, 'model'=>$model, 'modDetails'=>$modDetails, 'dataDetails'=>$dataDetails)); ?>
	</div>
</fieldset>

<fieldset class="box">
	<legend class="rim">Data Pembayaran</legend>
	<?php echo $this->renderPartial('_form', array('form'=>$form, 'model'=>$model)); ?>
</fieldset>

<div class="form-actions">
        <?php
        if(isset($_GET['id'])){
            $disabledSimpan = 'disabled';
            $disabledPrint = '';
        }else{
            $disabledSimpan = '';
            $disabledPrint = 'disabled';
        }
        ?>
        <?php echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds','{icon} Create',array('{icon}'=>'<i class="entypo-check"></i>')) : 
                                             Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="entypo-check"></i>')),
                        array('class' => 'btn btn-danger', 
                        'type'=>'submit', 
                        'onKeypress'=>'return formSubmit(this,event)', 
//                        'onClick'=>'onClickSubmit();return false;',
                        'disabled'=>$disabledSimpan)); ?>
        <?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')), 
                $this->createUrl('create'), 
                array('class' => 'btn btn-default',
                      'onclick'=>'return refreshForm(this);')); ?>
        <?php 
            echo CHtml::link(
                Yii::t('mds', '{icon} Print', array('{icon}'=>'<i class="entypo-print"></i>')), 
                "#", 
                array(
                    'class'=>'btn btn-info',
                    'onclick'=>"print('PRINT'); return false",
                    'disabled'=>$disabledPrint,
                )
            ); 
        ?>
        <?php  
            $content = $this->renderPartial('tips',array(),true);
            $this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
        ?>
</div>
<?php $this->endWidget(); ?>
<script>
function pilihDokter(){
    var pilih = $("#KUPembayaranjasaT_pilihDokter");
    if(pilih.val() == "rujukan"){
        $("#formRujukan").show();
        $("#formTglPenunjangAwal").show();
        $("#formTglPenunjangAkhir").show();
        $("#formDokter").find('input').each(function(){
            $(this).val("");
        });
        $("#formTglPendaftaranAwal").find('input').each(function(){
            $(this).val("");
        });
        $("#formTglPendaftaranAkhir").find('input').each(function(){
            $(this).val("");
        });
        $("#formDokter").hide();
        $("#formTglPendaftaranAwal").hide();
        $("#formTglPendaftaranAkhir").hide();
    }else{
        $("#formDokter").show();
        $("#formTglPendaftaranAwal").show();
        $("#formTglPendaftaranAkhir").show();
        $("#formRujukan").find('input').each(function(){
            $(this).val("");
        });
        $("#formTglPenunjangAwal").find('input').each(function(){
            $(this).val("");
        });
        $("#formTglPenunjangAkhir").find('input').each(function(){
            $(this).val("");
        });
        $("#formRujukan").hide();
        $("#formTglPenunjangAwal").hide();
        $("#formTglPenunjangAkhir").hide();
    }
    bersihTabelDetail();
    bersihFormPembayaran();
}
pilihDokter(); //default
function addDetail(){
    var rujukandari_id = $('#KUPembayaranjasaT_rujukandari_id').val();
    var pegawai_id = $('#KUPembayaranjasaT_pegawai_id').val();
    var tgl_awalPenunjang = $('#KUPembayaranjasaT_tgl_awalPenunjang').val();
    var tgl_akhirPenunjang = $('#KUPembayaranjasaT_tgl_akhirPenunjang').val();
    var tgl_awalPendaftaran = $('#KUPembayaranjasaT_tgl_awalPendaftaran').val();
    var tgl_akhirPendaftaran = $('#KUPembayaranjasaT_tgl_akhirPendaftaran').val();
    var komponentarifIds = {};
    var i = 0;
    $('#checkBoxList').find('input').each(function(){
        if($(this).is(':checked')){
            komponentarifIds[i] = $(this).val();
            i ++;
        }
    });
    if(tgl_awalPenunjang.length > 0 && tgl_akhirPenunjang.length > 0 && i > 0){
        var tgl_awal = tgl_awalPenunjang;
        var tgl_akhir = tgl_akhirPenunjang;
    }else if(tgl_awalPendaftaran.length > 0 && tgl_akhirPendaftaran.length > 0){
        var tgl_awal = tgl_awalPendaftaran;
        var tgl_akhir = tgl_akhirPendaftaran;
    }else{
        alert ("Silakan isi form dengan benar ! Rujukan / Dokter, Tanggal dan Komponen Tarif wajib diisi!");
        return false;
    }
    bersihTabelDetail();
    bersihFormPembayaran();
    $('#tabelDetail').addClass('animation-loading');
    $.post("<?php echo $this->createUrl('addDetailPembayaranJasa'); ?>", {
        rujukandari_id:rujukandari_id, 
        pegawai_id: pegawai_id, 
        tgl_awal:tgl_awal, 
        tgl_akhir:tgl_akhir, 
        komponentarifId:komponentarifIds},
        function(data){
            if (data.tr == ""){
                myAlert('Data tidak ditemukan!');				
            }else{
                $('#tabelDetail tbody').append(data.tr);
                $("#tabelDetail tbody tr .integer").each(function(){
                    $(this).maskMoney({"defaultZero":true,"allowZero":true,"decimal":"","thousands":",","precision":0,"symbol":null});
                });    
                formatNumbers();
                hitungSemua();
            }
			$('#tabelDetail').removeClass('animation-loading');
        }, "json");
    return false;
}
function formatNumbers(){
    $('.integer').each(function(){this.value = formatNumber(this.value)});
}
formatNumbers();
function unformatNumbers(){
    $('.integer').each(function(){this.value = unformatNumber(this.value)});
}
function bersihTabelDetail(){
    $('#tabelDetail tbody').html("");
}
function bersihFormPembayaran(){
    $('#formPembayaran .integer').each(function(){
        $(this).val(0);
    });
}
function hitungSemua(){
    unformatNumbers();
    var totTarif = 0;
    var totJasa = 0;
    var totBayar = 0;
    var totSisa = 0;
    $('#tabelDetail tbody tr').each(function(){
        if($(this).find('input[name$="[pilihDetail]"]').is(":checked")){ //hitung yang dicheck aja
            var jmltarif = unformatNumber(parseFloat($(this).find('input[name$="[jumahtarif]"]').val()));
            var jmljasa = unformatNumber(parseFloat($(this).find('input[name$="[jumlahjasa]"]').val()));
            var jmlbayar = unformatNumber(parseFloat($(this).find('input[name$="[jumlahbayar]"]').val()));
            var jmlsisa = unformatNumber(parseFloat(jmljasa - jmlbayar));
            if(jmlsisa <= 0 ){
                jmlsisa = 0;
            }
            $(this).find('input[name$="[sisajasa]"]').val(jmlsisa);
            totTarif += jmltarif;
            totJasa += jmljasa;
            totBayar += jmlbayar;
            totSisa += jmlsisa;
        }
    });
    $("#KUPembayaranjasaT_totaltarif").val(totTarif);
    $("#KUPembayaranjasaT_totaljasa").val(totJasa);
    $("#KUPembayaranjasaT_totalbayarjasa").val(totBayar);
    $("#KUPembayaranjasaT_totalsisajasa").val(totSisa);
    formatNumbers();
}
function checkAll(obj){
    if($(obj).is(':checked')){
        $('#tabelDetail tbody tr').each(function(){
            $(this).find('input[name$="[pilihDetail]"]').each(function(){$(this).attr('checked',true)});
            $(this).find('input[name$="[pilihDetail]"]').each(function(){$(this).val(1)});
        });
    }else{
        $('#tabelDetail tbody tr').each(function(){
            $(this).find('input[name$="[pilihDetail]"]').each(function(){$(this).removeAttr('checked')});
            $(this).find('input[name$="[pilihDetail]"]').each(function(){$(this).val("")});
        });
    }
    hitungSemua();
}
function checkIni(obj){
    if($(obj).is(':checked')){
        $(obj).parent().find('input[name$="[pilihDetail]"]').each(function(){$(this).attr('checked',true)});
        $(obj).parent().find('input[name$="[pilihDetail]"]').each(function(){$(this).val(1)});
    }else{
        $(obj).parent().find('input[name$="[pilihDetail]"]').each(function(){$(this).removeAttr('checked')});
        $(obj).parent().find('input[name$="[pilihDetail]"]').each(function(){$(this).val("")});
        $('#pilihSemua').removeAttr('checked');
    }
    hitungSemua();
}

function print(caraPrint) 
{
    <?php if (!empty($model->pembayaranjasa_id)){?>
        window.open('<?php echo $this->createUrl('Print', array('id'=>$model->pembayaranjasa_id)); ?>'+'&caraPrint=' + caraPrint,'printwin','left=100,top=100,width=980,height=400,scrollbars=1');
    <?php } ?>
}

function onClickSubmit()
{
    if(requiredCheck($("form"))){
		cekInput();
    }
}

function simpanProses()
{
    $("#kupembayaranjasa-t-form").submit();
}

function cekInput()
{
    
    if($('#KUPembayaranjasaT_totaltarif').val() == 0){
        myAlert('Belum ada data pembayaran');
        return false;
    }
    else{
        $("#kupembayaranjasa-t-form").submit();
    }
}

</script>