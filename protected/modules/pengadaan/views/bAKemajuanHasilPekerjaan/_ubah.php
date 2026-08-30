<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>
<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'bapemnelianlangsung-m-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('enctype' => 'multipart/form-data','onKeyPress' => 'return disableKeyPress(event)', 'onsubmit' => 'return requiredCheck(this);'),
    'focus' => '#',
        ));
?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title"><span class='judul'>Ubah Berita Acara Kemajuan Hasil Pekerjaan</span></div>
    </div>
    <div class="panel-body">
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title"><span class='judul'>Berita Acara Kemajuan Hasil Pekerjaan</span></div>
            </div>
            <div class="panel-body">
                <?php $this->renderPartial('_formKemajuanHasilPekerjaan', array('model' => $model, 'modSPK' => $modSPK, 'form' => $form)); ?>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title"><span class='judul'>Lampiran</span></div>
            </div>
            <div class="panel-body">
                <?php $this->renderPartial('_formLampiran2', array('model' => $model, 'modSPK' => $modSPK, 'modelDetail' => $modelDetail, 'modSPKRincian' => $modSPKRincian, 'form' => $form)); ?>
            </div>
        </div>
        <div class="form-actions">
            <?php
            if (!isset($_GET['sukses'])) {
                echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('class' => 'btn btn-primary', 'type' => 'submit'));
                echo "&nbsp;";
            } else {
                echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('class' => 'btn btn-primary', 'type' => 'submit', 'onclick' => 'formSubmit(this,event);', 'onkeypress' => 'formSubmit(this,event);', 'disabled' => true));
                echo "&nbsp;";
            }
            echo CHtml::link(Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')), $this->createUrl($this->id . '/ubah', array('id'=>$model->bakemajuanhasilpekerjaan_id,'suratperjanjiankerja_id' => $modSPK->suratperjanjiankerja_id)), array('class' => 'btn btn-danger', 'onclick' => 'return refreshForm(this);'));
            echo "&nbsp;";
            echo CHtml::link(Yii::t('mds', '{icon} Kembali', array('{icon}' => '<i class="entypo-back"></i>')), $this->createUrl($this->id . '/index', array('suratperjanjiankerja_id' => $modSPK->suratperjanjiankerja_id)), array('class' => 'btn btn-success'));
            ?>
        </div>
    </div>
</div>
<?php
$this->endWidget();

$urlGetKHP = $this->createUrl('GetKHP');
$suratperjanjiankerja_id = $_GET['suratperjanjiankerja_id'];
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
    
    function setSupplier(data) {
        $("#BakemajuanhasilpekerjaanT_direktur").val(data.direktursupplier);
        $("#BakemajuanhasilpekerjaanT_alamat_penyedia").val(data.supplier_alamat);
    }

    function cekRiwayat(obj) {
        var suratperjanjiankerja_id = <?php echo $suratperjanjiankerja_id ?>;
        if (suratperjanjiankerja_id !== "") {
            $.post("<?php echo $urlGetKHP ?>", {suratperjanjiankerja_id: suratperjanjiankerja_id, },
                    function (data) {
                        $("#tableKHP").children("tbody").append(data.tr);
                    }, "json");
        } else {
            myAlert("Silahkan pilih data Surat Perjanjian Kerja !");
        }
        return false;

    }

    $(document).ready(function () {
        cekRiwayat();
<?php if (isset($_GET['sukses'])) { ?>
            $('input').attr('readonly', true);
            $('.add-on').hide();
<?php } ?>
    });
</script>