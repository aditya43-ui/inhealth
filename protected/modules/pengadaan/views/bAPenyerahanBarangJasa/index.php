<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
<?php 
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form2.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/accounting2.js', CClientScript::POS_END);    
?>
<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'bapenyerahanbarang-t-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('enctype' => 'multipart/form-data', 'onKeyPress' => 'return disableKeyPress(event)', 'onsubmit' => 'return requiredCheck(this);'),
    'focus' => '#',
        ));
?>

<div class="panel-group joined" id="accordion-khp"> 
    <div class="panel panel-success"> 
        <div class="panel-heading"> 
            <h4 class="panel-title" style="background-color: #a6db9c"> 
                <a data-toggle="collapse" data-parent="#accordion-khp" href="#riwayat" aria-expanded="true" class="">
                    Riwayat Berita Acara Penyerahan Barang dan Jasa
                </a> 
            </h4> 
        </div> 
        <div id="riwayat" class="panel-collapse collapse" aria-expanded="false" style=""> 
            <div class="panel-body" style="background-color: #fff">
                <?php echo $this->renderPartial('_riwayat', array('model' => $model, 'form' => $form), true); ?>
            </div> 
        </div> 
    </div> 
    <div class="panel panel-success"> 
        <div class="panel-heading"> 
            <h4 class="panel-title" style="background-color: #b0eaa5"> 
                <a data-toggle="collapse" data-parent="#accordion-khp" href="#transaksi" class="" aria-expanded="false">
                    Berita Acara Penyerahan Barang dan Jasa
                </a> 
            </h4> 
        </div> 
        <div id="transaksi" class="panel-collapse collapse in" aria-expanded="true"> 
            <div class="panel-body" style="background-color: #fff">
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <div class="panel-title"> <b> Berita Acara Penyerahan Barang dan Jasa</b> </div>
                    </div>
                    <div class="panel-body">
                        <?php $this->renderPartial('_formPenyerahan', array('model' => $model, 'form' => $form)) ?>
                    </div>
                </div>

                <div class="panel panel-success">
                    <div class="panel-heading">
                        <div class="panel-title"> <b> Lampiran </b> </div>
                    </div>
                    <div class="panel-body">
                        <?php $this->renderPartial('_formLampiran', array('model' => $model, 'modRincian' => $modRincian,'modDetail' => $modDetail, 'form' => $form, 'modSurat' => $modSurat)) ?>
                    </div>
                </div>
                <div class="row-fluid">
                    <div class="form-actions">
                        <?php
                        ?>
                    </div>
                </div>
                <br>
                <div class="row-fluid">
                    <div class="form-actions">
                        <?php
                        $cekbapenyerahan = BapenyerahanbarangjasaT::model()->findAllByAttributes(array('suratperjanjiankerja_id' => $_GET['suratperjanjiankerja_id']));
                        $jumlahpemeriksaan = count($cekbapenyerahan) + 1;

                        $cekTermin = SuratperjanjiankerjaterminT::model()->findAllByAttributes(array('suratperjanjiankerja_id' => $_GET['suratperjanjiankerja_id']));
                        if(!empty($cekTermin)){
                            $jumlahTermin = count($cekTermin);
                        }else{
                            $jumlahTermin = 1;
                        }
                        if ($jumlahpemeriksaan > $jumlahTermin && empty($_GET['bapenyerahanbarangjasa_id'])) {
                            echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('class' => 'btn btn-danger', 'type' => 'submit', 'onclick' => 'formSubmit(this,event);', 'onkeypress' => 'formSubmit(this,event);', 'disabled' => true));
                            echo "&nbsp;";
                        } else {
                            if (!isset($_GET['sukses'])) {
                                echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('class' => 'btn btn-danger', 'type' => 'submit'));
                                echo "&nbsp;";
                            } else {
                                echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('class' => 'btn btn-danger', 'type' => 'submit', 'onclick' => 'formSubmit(this,event);', 'onkeypress' => 'formSubmit(this,event);', 'disabled' => true));
                                echo "&nbsp;";
                            }
                        }
                        echo CHtml::link(Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')), $this->createUrl($this->id . '/index', array('suratperjanjiankerja_id' => $_GET['suratperjanjiankerja_id'])), array('class' => 'btn btn-default', 'onclick' => 'return refreshForm(this);'));
                        echo "&nbsp;";
//                        if (empty($model->bapenyerahanbarangjasa_id)) {
//                            echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="icon-print icon-white"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'disabled' => 'true'));
//                            echo "&nbsp;";
//                        } else {
//                            echo CHtml::htmlButton(Yii::t('mds', '{icon} Cetak', array('{icon}' => '<i class="icon-print icon-white"></i>')), array('class' => 'btn btn-primary-blue', 'disabled' => false, 'type' => 'button', 'onclick' => 'print(\'PRINT\')'));
//                            echo "&nbsp;";
//                        }
                        ?>
                    </div>
                </div>
            </div> 
        </div> 
    </div> 
</div>

<?php 
$this->endWidget(); 

$urlGetRiwayat = $this->createUrl('GetRiwayat');
$suratperjanjiankerja_id = $_GET['suratperjanjiankerja_id'];
?>
<?php
// ===========================Dialog Penelitian=========================================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogRiwayat',
    // additional javascript options for the dialog plugin
    'options' => array(
        'title' => 'Detail Penyerahan Barang dan Jasa',
        'autoOpen' => false,
        'width' => 1050,
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

    function cekRiwayat(obj) {
        var suratperjanjiankerja_id = <?php echo $suratperjanjiankerja_id ?>;
        if (suratperjanjiankerja_id !== "") {
            $.post("<?php echo $urlGetRiwayat ?>", {suratperjanjiankerja_id: suratperjanjiankerja_id, },
                    function (data) {
                        $("#tableRiwayat").children("tbody").append(data.tr);
                    }, "json");
        } else {
            myAlert("Silahkan pilih data Surat Perjanjian Kerja !");
        }
        return false;

    }

    function print() {
        window.open('<?php echo $this->createUrl('print', array('id' => $model->bapenyerahanbarangjasa_id)); ?>', 'printwin', 'left=100,top=100,width=640,height=480');
    }

    $(document).ready(function () {
        $('.integer-decimal').each(function(){
           $(this).val(formatThousandDecimal(parseFloat($(this).val())));
       });
        cekRiwayat();
        setValidasiCekDisabled($("#bapenyerahanbarang-t-form"), function () {
            return true;
        });

    });
    
    document.getElementById("BapenyerahanbarangjasaT_dokumen_pendukung").onchange = function () {
        if (this.files[0].size > 5000000) {
            toastr.error('Ukuran maksimal dokumen 5mb');
            $("#BapenyerahanbarangjasaT_dokumen_pendukung").attr("src", "blank");
            $('#BapenyerahanbarangjasaT_dokumen_pendukung').wrap('<form>').closest('form').get(0).reset();
            $('#BapenyerahanbarangjasaT_dokumen_pendukung').unwrap();
            return false;
        }
    }
</script>



