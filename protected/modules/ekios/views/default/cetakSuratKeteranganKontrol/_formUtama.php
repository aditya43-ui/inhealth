<style>
    .form_utama {
        text-align: center;
    }

    .form_utama .form_main {
        display: inline-block;
    }
</style>
<div class="form_panel form_utama">
    <div class="form_main">
        <div class="control-group">
            <?php echo CHtml::label("No. Rekam Medik", "", array("class"=>"control-label")); ?>
            <div class="controls">
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            </div>
            <div class="controls">
                <?php 
                    echo CHtml::textField('input_no_kartu', null, array('class'=>'input_no_kartu'));
                ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label("Tanggal SRK", "", array("class"=>"control-label")); ?>
            <div class="controls">
                <?php echo CHtml::radioButton('caraAmbilTanggal', true, array('class'=>'srk', 'onclick' => 'cekSrk(this);')); ?>
            </div>
            <div class="controls">
                <?php
                    echo CHtml::textField('tanggal_srk', null, array('class'=>'tanggal_srk'));
                ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label("Tanggal Rencana Kontrol", "", array("class"=>"control-label")); ?>
            <div class="controls">
                <?php echo CHtml::radioButton('caraAmbilTanggal', false, array('class' => 'rencanaKontrol', 'onclick' => 'cekRencanaKontrol(this);')); ?>
            </div>
            <div class="controls">
                <?php
                    $this->widget('MyDateTimePicker', array(
                        'id' => 'tanggal_rencana_kontrol',
                        'name' => 'tanggal_rencana_kontrol',
                        'mode' => 'date',
                        'options' => array(
                            'dateFormat' => Params::DATE_FORMAT,
                        ),
                        'htmlOptions' => array(
                            'onkeypress' => "return $(this).focusNextInputField(event)",
                            'class'=>'span3',
                            'disabled'=>true,
                        ),
                    ));
                ?>
            </div>
        </div>
        <div class="form-action">
            <?php
                echo CHtml::htmlButton("<i class=\"icon-search icon-white\"></i> Cari", array(
                    "onclick"=>"setPemeriksaanPertama(1);",
                    "class"=>"btn btn-success"
                ));
$urlPrintBpjs = $this->createUrl('PrintRencanaKontrolBpjs');
$js = <<< JSCRIPT
function printBpjs(caraPrint, pendaftaran_id)
{
    window.open("${urlPrintBpjs}"+$('#sanapza-m-search').serialize()+"&caraPrint="+caraPrint+"&pendaftaran_id="+pendaftaran_id,'location=_new, width=900px');
}
JSCRIPT;
Yii::app()->clientScript->registerScript('print',$js,CClientScript::POS_HEAD);
?>
        </div>
    </div>
</div>
<script>
    function cekSrk(obj) {
        if($(obj).is(":checked")){
            $("#tanggal_srk").val('<?php echo MyFormatter::formatDateTimeForUser(date("Y-m-d")); ?>');
            $("#tanggal_srk").attr('disabled', false);
            $("#tanggal_rencana_kontrol").attr('disabled', true);
            $("#tanggal_rencana_kontrol").val("");
        }
    }
    function cekRencanaKontrol(obj) {
        if($(obj).is(":checked")){
            $("#tanggal_rencana_kontrol").val('<?php echo MyFormatter::formatDateTimeForUser(date("Y-m-d")); ?>');
            $("#tanggal_srk").attr('disabled', true);
            $("#tanggal_rencana_kontrol").attr('disabled', false);
            $("#tanggal_srk").val("");
        }
    }
    function setPemeriksaanPertama(tipe) {
        var nomor = $("#input_no_kartu").val();
        var tanggal_srk = $("#tanggal_srk").val();
        var tanggal_rencana_kontrol = $("#tanggal_rencana_kontrol").val();
        if(tanggal_srk != ""){
           $.post('<?php echo $this->createUrl('GetPasienDariNomorPesertaNIK'); ?>', {
                nomor:nomor,
                tanggal_srk:tanggal_srk
            }, function(data) {
                if (data.ok == 0) {
                    myAlert(data.msg);
                } else {
                    printBpjsSrk(data.pendaftaran_id, 'PRINT', tanggal_srk);
                }
                console.log(data);
            }, 'json'); 
        }else if(tanggal_rencana_kontrol != ""){
            $.post('<?php echo $this->createUrl('GetPasienDariNomorPesertaNIK'); ?>', {
                nomor:nomor,
                tanggal_rencana_kontrol:tanggal_rencana_kontrol
            }, function(data) {
                if (data.ok == 0) {
                    myAlert(data.msg);
                } else {
                    printBpjsTanggalRencanaKontrol(data.pendaftaran_id, 'PRINT', tanggal_rencana_kontrol);
                }
                console.log(data);
            }, 'json');
        }else{
            myAlert("Mohon isi pilih Tanggal");
        }
    }
    
    function printBpjsSrk(pendaftaran_id, caraPrint, tanggal_srk) {
        window.open('<?php echo $this->createUrl('printRencanaKontrolSrk'); ?>&pendaftaran_id='+pendaftaran_id+'&caraPrint='+caraPrint+'&tanggal_srk='+tanggal_srk,'printwin','left=100,top=100,width=1000,height=640');
    }
    
    function printBpjsTanggalRencanaKontrol(pendaftaran_id, caraPrint, tanggal_rencana_kontrol) {
        window.open('<?php echo $this->createUrl('printRencanaKontrol'); ?>&pendaftaran_id='+pendaftaran_id+'&caraPrint='+caraPrint+'&tanggal_rencana_kontrol='+tanggal_rencana_kontrol,'printwin','left=100,top=100,width=1000,height=640');
    }

    function ketikNomor(e) {
        
        if (e.keyCode == 13) {
            e.preventDefault();
            setPemeriksaanPertama(1);
        }
        console.log(e.keyCode);
    }

    $(document).ready(function() {
        $("#input_no_kartu").on('keydown', ketikNomor);
        cekSrk($(".srk"));
    });

</script>