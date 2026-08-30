<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/accounting2.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form2.js', CClientScript::POS_END); ?>


<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'bapemnelianlangsung-m-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('enctype' => 'multipart/form-data', 'onKeyPress' => 'return disableKeyPress(event)', 'onsubmit' => 'return requiredCheck(this);'),
    'focus' => '#',
        ));
?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">Transaksi <strong>Evaluasi Penawaran</strong></div>
    </div>
    <div class="panel-body">
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title"><span class='judul'>Data <b> Pembukaan Penawaran </b></span></div>
            </div>
            <div class="panel-body">
                <?php $this->renderPartial('_formPenawaran', array('model' => $model, 'modPersiapanPengadaan' => $modPersiapanPengadaan, 'form' => $form)); ?>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title"><span class='judul'>Lampiran <b> Evaluasi Penawaran </b></span></div>
            </div>
            <div class="panel-body">
                <?php
                        if (!empty($model->evaluasipenawaran_id)) {
                            $this->renderPartial('_ubahlampiran', array('model' => $model, 'modPersiapanPengadaan' => $modPersiapanPengadaan, 'modelDetail' => $modelDetail, 'form' => $form));
                        } else {
                            $this->renderPartial('_lampiran', array('model' => $model, 'modPersiapanPengadaan' => $modPersiapanPengadaan, 'modelDetail' => $modelDetail, 'form' => $form));
                        }
                ?>
                <br>
            </div>
        </div>
        <br>
        <div class="row-fluid">
            <div class="form-actions">
                <?php
                $cekSPK = SuratperjanjiankerjaT::model()->findByAttributes(array('persiapanpengadaan_id' => $_GET['id'], 'isbatal' => false, 'isaddendum' => true));
                if (!empty($cekSPK)) {
                    echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('class' => 'btn btn-primary', 'type' => 'submit', 'onclick' => 'formSubmit(this,event);', 'onkeypress' => 'formSubmit(this,event);', 'disabled' => true));
                    echo "&nbsp;";
                } else {
                    if (!isset($_GET['sukses'])) {
                        $cekInfoUmum = InfoumumpengadaanT::model()->findByAttributes(array('persiapanpengadaan_id' => $_GET['id'], 'isbatal' => false, 'isaddendum' => true));
                        if(!empty($cekInfoUmum)){
                            echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="icon-ok icon-white"></i>')), array('class' => 'btn btn-primary', 'type' => 'submit'));
                            echo "&nbsp;";
                        }else{
                            echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="icon-ok icon-white"></i>')), array('class' => 'btn btn-primary', 'type' => 'button', 'disabled' => true));
                            echo "&nbsp;";
                        }
                    } else {
                        $cekInfoUmum = InfoumumpengadaanT::model()->findByAttributes(array('persiapanpengadaan_id' => $_GET['id'], 'isbatal' => false, 'isaddendum' => true));
                        if(!empty($cekInfoUmum)){
                            echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="icon-ok icon-white"></i>')), array('class' => 'btn btn-primary', 'type' => 'submit'));
                            echo "&nbsp;";
                        }else{
                            echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="icon-ok icon-white"></i>')), array('class' => 'btn btn-primary', 'type' => 'button', 'disabled' => true));
                            echo "&nbsp;";
                        }
                    }
                }

                echo CHtml::link(Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="icon-refresh icon-white"></i>')), $this->createUrl($this->id . '/index', array('id' => $modPersiapanPengadaan->persiapanpengadaan_id)), array('class' => 'btn btn-danger', 'onclick' => 'return refreshForm(this);'));
                echo "&nbsp;";
                if (empty($model->evaluasipenawaran_id)) {
                    echo CHtml::link(Yii::t('mds', '{icon} Cetak', array('{icon}' => '<i class="icon-print icon-white"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'disabled' => 'true'));
                    echo "&nbsp;";
                    echo CHtml::link(Yii::t('mds', '{icon} Cetak Lampiran', array('{icon}' => '<i class="icon-print icon-white"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'disabled' => 'true'));
                    echo "&nbsp;";
                } else {
                    echo CHtml::link(Yii::t('mds', '{icon} Cetak', array('{icon}' => '<i class="icon-print icon-white"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'onclick' => "print()"));
                    echo "&nbsp;";
                    echo CHtml::link(Yii::t('mds', '{icon} Cetak Lampiran', array('{icon}' => '<i class="icon-print icon-white"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'onclick' => "printLampiran()"));
                    echo "&nbsp;";
                }
                ?>
            </div>
        </div>
    </div>
</div>
<?php
$cekInfoUmum = InfoumumpengadaanT::model()->findByAttributes(array('persiapanpengadaan_id' => $_GET['id'], 'isbatal' => false, 'isaddendum' => true));
                        
$this->endWidget();

$cekJumlah = LookupM::model()->findAll("lookup_type = 'dokumenpemeriksaanadministratif'");

$urlGetRiwayat = $this->createUrl('GetRiwayat');
$suratperjanjiankerja_id = $_GET['id'];

if (!empty($_GET['evaluasipenawaran_id'])) {
    $update = 'iya';
    $evaluasipenawaran_id = $_GET['evaluasipenawaran_id'];
} else {
    $update = 'tidak';
}

$evaluasipenawaran_id = $model->evaluasipenawaran_id;
?>

<?php
// ===========================Dialog Penelitian=========================================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogRiwayat',
    // additional javascript options for the dialog plugin
    'options' => array(
        'title' => 'Detail Pemeriksaan Administratif PJPHP',
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
    function print() {
        window.open('<?php echo $this->createUrl('print', array('id' => $model->evaluasipenawaran_id)); ?>', 'printwin', 'left=100,top=100,width=640,height=480');
    }
    function printLampiran() {
        window.open('<?php echo $this->createUrl('printLampiran', array('id' => $model->evaluasipenawaran_id)); ?>', 'printwin', 'left=100,top=100,width=640,height=480');
    }

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


    function setValidasi(obj, jenis) {
        var total = $(obj).parents('table').find('.'+jenis).length;
        var jumlah = $(obj).parents('table').find('.'+jenis+':checked').length;
        
        if (jumlah == total) {
            $("#EvaluasipenawaranT_"+jenis).val('Memenuhi Syarat');
        } else {
            $("#EvaluasipenawaranT_"+jenis).val('Tidak Memenuhi Syarat');
        }
                
        var totalsemua = $(obj).parents('table').find('.cekLengkap').length;
        var jumlahsemua = $(obj).parents('table').find('.cekLengkap:checked').length;
        
        if (jumlahsemua == totalsemua) {
            $("#EvaluasipenawaranT_keterangan").val('Memenuhi Syarat');
        } else {
            $("#EvaluasipenawaranT_keterangan").val('Tidak Memenuhi Syarat');
        }
    }

    $(document).ready(function () {
        cekRiwayat();
//        setValidasi();
<?php if (isset($_GET['sukses'])) { ?>
            $('input').attr('readonly', true);
            $('textarea').attr('readonly', true);
            $('.add-on').hide();
<?php } ?>
    <?php if(empty($cekInfoUmum)){ ?>
        myAlert('Pilih penyedia dan pejabat pengadaan pada tab Informasi Umum');
    <?php } ?>
    });

    document.getElementById("EvaluasipenawaranT_dokumen_pendukung").onchange = function () {
        if(this.files[0].size>5000000){
            window.parent.toastr.error('Ukuran maksimal dokumen 5mb');
            $("#EvaluasipenawaranT_dokumen_pendukung").attr("src","blank");
            $('#EvaluasipenawaranT_dokumen_pendukung').wrap('<form>').closest('form').get(0).reset();
            $('#EvaluasipenawaranT_dokumen_pendukung').unwrap();     
            return false;
        }
        if(this.files[0].type.indexOf("pdf")==-1){
            window.parent.toastr.error("Tipe file harus PDF");
            $("#EvaluasipenawaranT_dokumen_pendukung").attr("src","blank");
            $('#EvaluasipenawaranT_dokumen_pendukung').wrap('<form>').closest('form').get(0).reset();
            $('#EvaluasipenawaranT_dokumen_pendukung').unwrap();         
            return false;
        }   
    };
</script>