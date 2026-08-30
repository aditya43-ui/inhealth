<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>
<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'bapemnelianlangsung-m-form',
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
                    Riwayat Berita Acara Pemeriksaan Administratif PjPHP
                </a> 
            </h4> 
        </div> 
        <div id="riwayat" class="panel-collapse collapse" aria-expanded="false" style=""> 
            <div class="panel-body" style="background-color: #fff">
                <?php echo $this->renderPartial('_riwayat', array('model' => $model, 'modSPK' => $modSPK, 'modelDetail' => $modelDetail, 'form' => $form), true); ?>
            </div> 
        </div> 
    </div> 
    <div class="panel panel-success"> 
        <div class="panel-heading"> 
            <h4 class="panel-title" style="background-color: #b0eaa5"> 
                <a data-toggle="collapse" data-parent="#accordion-khp" href="#transaksi" class="" aria-expanded="false">
                    Berita Acara Pemeriksaan Administratif PjPHP
                </a> 
            </h4> 
        </div> 
        <div id="transaksi" class="panel-collapse collapse in" aria-expanded="true"> 
            <div class="panel-body" style="background-color: #fff">
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <div class="panel-title"><span class='judul'>Berita Acara Pemeriksaan Administratif PjPHP</span></div>
                    </div>
                    <div class="panel-body">
                        <?php $this->renderPartial('_formPemeriksaan', array('model' => $model, 'modSPK' => $modSPK, 'form' => $form)); ?>
                    </div>
                </div>
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <div class="panel-title"><span class='judul'>Pemeriksaan Administratif</span></div>
                    </div>
                    <div class="panel-body">
                        <?php
                        if (!empty($model->bapemeriksaanadmpjphp_id)) {
                            $this->renderPartial('_ubahtabelPemeriksaanAdm', array('model' => $model, 'modSPK' => $modSPK, 'modelDetail' => $modelDetail, 'form' => $form));
                        } else {
                            $this->renderPartial('_tabelPemeriksaanAdm', array('model' => $model, 'modSPK' => $modSPK, 'modelDetail' => $modelDetail, 'form' => $form));
                        }
                        ?>
                        <br>
                        <?php echo $form->textFieldRow($model, 'pemeriksaan_hasil', array('readonly' => true, 'class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                    </div>
                </div>
                <br>
                <div class="row-fluid">
                    <div class="form-actions">
                        <?php
                        $cekpemeriksaanpjphp = BapemeriksaanadmpjphpT::model()->findAllByAttributes(array('suratperjanjiankerja_id' => $_GET['suratperjanjiankerja_id']));
                        $jumlahpemeriksaan = count($cekpemeriksaanpjphp) + 1;

                        $cekTermin = SuratperjanjiankerjaterminT::model()->findAllByAttributes(array('suratperjanjiankerja_id' => $_GET['suratperjanjiankerja_id']));
                        $jumlahTermin = count($cekTermin);
                        if ($modSPK->nilaikontrak > 200000000) {
                            echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('class' => 'btn btn-danger', 'type' => 'button', 'disabled' => true));
                            echo "&nbsp;";
                        } else {
                            if ($modSPK->istermin == true) {
                                if ($jumlahpemeriksaan > $jumlahTermin && empty($_GET['bapemeriksaanadmpjphp_id'])) {
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
                            } else {
                                if ($jumlahpemeriksaan > 1 && empty($_GET['bapemeriksaanadmpjphp_id'])) {
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
                            }
                        }
                        echo CHtml::link(Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')), $this->createUrl($this->id . '/index', array('suratperjanjiankerja_id' => $modSPK->suratperjanjiankerja_id)), array('class' => 'btn btn-default', 'onclick' => 'return refreshForm(this);'));
                        echo "&nbsp;";
//                                if (empty($model->bapemeriksaanadmpjphp_id)) {
//                                    echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="icon-print icon-white"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'disabled' => 'true'));
//                                    echo "&nbsp;";
//                                } else {
//                                    echo CHtml::htmlButton(Yii::t('mds', '{icon} Cetak', array('{icon}' => '<i class="icon-print icon-white"></i>')), array('class' => 'btn btn-primary-blue', 'disabled' => false, 'type' => 'button', 'onclick' => 'print(\'PRINT\')'));
//                                    echo "&nbsp;";
//                                }
                        ?>
                    </div>
                </div>
            </div> 
        </div> 
    </div> 
</div>
<?php
$this->endWidget();

$cekJumlah = LookupM::model()->findAll("lookup_type = 'dokumenpemeriksaanadministratif'");

$urlGetRiwayat = $this->createUrl('GetRiwayat');
$suratperjanjiankerja_id = $_GET['suratperjanjiankerja_id'];

if (!empty($_GET['bapemeriksaanadmpjphp_id'])) {
    $update = 'iya';
    $bapemeriksaanadmpjphp_id = $_GET['bapemeriksaanadmpjphp_id'];
} else {
    $update = 'tidak';
}

$bapemeriksaanadmpjphp_id = $model->bapemeriksaanadmpjphp_id;
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
        window.open('<?php echo $this->createUrl('print', array('id' => $model->bapemeriksaanadmpjphp_id)); ?>', 'printwin', 'left=100,top=100,width=640,height=480');
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


    function setValidasi(obj, id) {
        var total = <?php echo count($cekJumlah) ?>;
        var jumlah = 0;
        $(obj).parents('table').find('input:radio[class="cekLengkap"]:checked').each(function () {
            if ($(this).val() == 1) {
                jumlah++;
            }
        });

        if (jumlah == total) {
            $("#BapemeriksaanadmpjphpT_pemeriksaan_hasil").val('Lengkap Sesuai');
        } else {
            $("#BapemeriksaanadmpjphpT_pemeriksaan_hasil").val('Lengkap Tidak Sesuai/Tidak Lengkap');
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
        var nilaikontrak = <?php echo $modSPK->nilaikontrak ?>;
        if (nilaikontrak > 200000000) {
            myAlert("Pengadaan ini diperiksa oleh PPHP gunakan transaksi BA Pemeriksaan Administratif PPHP");
        }
    });
    
    document.getElementById("BapemeriksaanadmpjphpT_dokumen_pendukung").onchange = function () {
        if (this.files[0].size > 5000000) {
            toastr.error('Ukuran maksimal dokumen 5mb');
            $("#BapemeriksaanadmpjphpT_dokumen_pendukung").attr("src", "blank");
            $('#BapemeriksaanadmpjphpT_dokumen_pendukung').wrap('<form>').closest('form').get(0).reset();
            $('#BapemeriksaanadmpjphpT_dokumen_pendukung').unwrap();
            return false;
        }
    }
</script>