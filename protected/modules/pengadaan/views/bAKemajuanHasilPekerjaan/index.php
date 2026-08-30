<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
<?php 
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form2.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/accounting2.js', CClientScript::POS_END); 
?>
<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'bapemnelianlangsung-m-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('enctype' => 'multipart/form-data','onKeyPress' => 'return disableKeyPress(event)', 'onsubmit' => 'return requiredCheck(this);'),
    'focus' => '#',
        ));
?>
<div style="min-height: 950px !important">
    <div class="panel-group joined" id="accordion-khp"> 
        <div class="panel panel-success"> 
            <div class="panel-heading"> 
                <h4 class="panel-title" style="background-color: #a6db9c"> 
                    <a data-toggle="collapse" data-parent="#accordion-khp" href="#riwayat" aria-expanded="true" class="">
                        Riwayat Berita Acara Kemajuan Hasil Pekerjaan
                    </a> 
                </h4> 
            </div> 
            <div id="riwayat" class="panel-collapse collapse" aria-expanded="false" style=""> 
                <div class="panel-body" style="background-color: #fff">
                    <?php echo $this->renderPartial('_riwayat', array('model' => $model, 'modSPK' => $modSPK, 'modelDetail' => $modelDetail, 'modSPKRincian' => $modSPKRincian, 'form' => $form), true); ?>
                </div> 
            </div> 
        </div> 
    </div>
    <div class="panel-body" style="background-color: #fff">
    <?php echo $this->renderPartial('_formTransaksi', array('model' => $model, 'modSPK' => $modSPK, 'modelDetail' => $modelDetail, 'modSPKRincian' => $modSPKRincian, 'form' => $form), true); ?>
    <br>
    <div class="row-fluid">
        <div class="form-actions">
            <?php
            if ($model->termin_terminke > $model->termin_jumlah) {
                echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('class' => 'btn btn-danger', 'type' => 'submit', 'onclick' => 'formSubmit(this,event);', 'onkeypress' => 'formSubmit(this,event);', 'disabled' => true));
            } else if (!isset ($_GET['sukses'])) {
                echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('class' => 'btn btn-danger', 'type' => 'submit'));
            } else {
                echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('class' => 'btn btn-danger', 'type' => 'submit', 'onclick' => 'formSubmit(this,event);', 'onkeypress' => 'formSubmit(this,event);', 'disabled' => true));   
            }
            echo "&nbsp;";
            echo CHtml::link(Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')), $this->createUrl($this->id . '/index', array('suratperjanjiankerja_id' => $modSPK->suratperjanjiankerja_id)), array('class' => 'btn btn-default', 'onclick' => 'return refreshForm(this);'));
            echo "&nbsp;";
            ?>
            </div>
        </div>
    </div>
</div>
<?php 
$this->endWidget(); 

$urlGetKHP = $this->createUrl('GetKHP');
$suratperjanjiankerja_id = $_GET['suratperjanjiankerja_id'];
?>

<?php
// ===========================Dialog Detail Kemajuan Hasil Pekerjaan =========================================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
'id'=>'dialogKemajuan',
    // additional javascript options for the dialog plugin
    'options'=>array(
    'title'=>'Detail Kemajuan Hasil Pekerjaan',
    'autoOpen'=>false,
    'width'=>1000,
    'height'=>500,
    'resizable'=>true,
    'scroll'=>false    
     ),
));
?>
<iframe src="" name="frameKemajuan" width="100%" height="100%">
</iframe>

<?php $this->endWidget('zii.widgets.jui.CJuiDialog'); ?>

<?php
// ===========================Dialog Penelitian=========================================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogRiwayat',
    // additional javascript options for the dialog plugin
    'options' => array(
        'title' => 'Detail Kemajuan Hasil Pekerjaan',
        'autoOpen' => false,
        'width' => 1000,
        'height' => 750,
        'resizable' => true,
        'scroll' => false,
    ),
));
?>
<iframe src="" name="iframe1" width="100%" height="100%">
</iframe>
<?php
$this->endWidget('zii.widgets.jui.CJuiDialog');
//===============================Akhir Dialog Work Order================================
?>
<script>
    
    document.getElementById("BakemajuanhasilpekerjaanT_dokumen_pendukung").onchange = function () {
        if (this.files[0].size > 5000000) {
            toastr.error('Ukuran maksimal dokumen 5mb');
            $("#BakemajuanhasilpekerjaanT_dokumen_pendukung").attr("src", "blank");
            $('#BakemajuanhasilpekerjaanT_dokumen_pendukung').wrap('<form>').closest('form').get(0).reset();
            $('#BakemajuanhasilpekerjaanT_dokumen_pendukung').unwrap();
            return false;
        }
    };
    
    function callDialog(){
        $("#dialogKemajuan").dialog('open');
    }
    function setSupplier(data) {
        $("#BakemajuanhasilpekerjaanT_direktur").val(data.direktursupplier);
        $("#BakemajuanhasilpekerjaanT_alamat_penyedia").val(data.supplier_alamat);
    }
    
    function cekRiwayat(obj) {
        var suratperjanjiankerja_id = <?php echo $suratperjanjiankerja_id ?>;
        if (suratperjanjiankerja_id !== "") {
            $.post("<?php echo $urlGetKHP ?>", {suratperjanjiankerja_id:suratperjanjiankerja_id,},
            function(data){
                $("#tableKHP").children("tbody").append(data.tr);
            }, "json");
        } else {
            myAlert("Silahkan pilih data Surat Perjanjian Kerja !");
        }
        return false;

    }
    
    $(document).ready(function () {
        $('.integer-decimal').each(function(){
           $(this).val(formatThousandDecimal(parseFloat($(this).val())));
       });
        cekRiwayat();
<?php if (isset($_GET['sukses'])) { ?>
            $('input').attr('readonly', true);
            $('.add-on').hide();
<?php } ?>
    });
</script>
