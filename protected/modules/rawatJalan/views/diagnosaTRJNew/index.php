<style>
    .sorot {
        background-color: yellow !important;
    }

    body {
        overflow-x: visible;
        min-height: 650px;
    }
</style>
<?php

$pg_login = PegawaiM::model()->findByPk(Yii::app()->user->getState('pegawai_id'));
$pg_loginpps = PpdsM::model()->findByPk(Yii::app()->user->getState('ppds_id'));

$modul_id = Yii::app()->user->getState('modul_id');
// $readonly = $pg_login->kelompokpegawai_id == 2 && $modul_id != 7;
if(!empty($pg_login->kelompokpegawai_id)){
    $readonly = $pg_login->kelompokpegawai_id == 2 && $modul_id != 7;
}
if (!empty($pg_loginpps->kelompokpegawai_id)){
    $readonly = $pg_loginpps->kelompokpegawai_id == 2 && $modul_id != 7;

}
$hide = $readonly ? " hide" : "";
$hidden = $readonly ? " hidden" : "";

?>
<script type="text/javascript">
    var id_diagnosax = new Array();
</script>
<div class="row">
    <div class="col-sm-12">
        <?php
        // if (!empty($this->modSMS)) {
        $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
            'id' => 'list-penjualanresep',
            'content' => array(
                'content-list-penjualanresep' => array(
                    'header' => '<b>Riwayat Diagnosa</b>',
                    'isi' => $this->renderPartial($this->path_view . "_gridRiwayatDiagnosa", array(
                        'modDiagnosa' => $modDiagnosa,
                        'model' => $model,
                        'modPendaftaran' => $modPendaftaran,
                        'modUraian' => $modUraian,
                        'path_view' => $path_view,
                        'modAdmisi' => $modAdmisi,
                        'modRiwayat' => $modRiwayat
                    ), true),
                    'active' => true,
                ),
            ),
        ));
        // }
        ?>
    </div>
</div>
<?php
$this->breadcrumbs = array(
    'Verifikasi Diagnosis',
);
//$this->renderPartial($path_view . '_formDataPasien',array('modPendaftaran'=>$modPendaftaran));
?>
<div <?=$hidden?>>
<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm',

    array(
        'id' => 'uraian-diagnosax-form',
        'enableAjaxValidation' => false,
        'type' => 'horizontal',
        'htmlOptions' => array(
            'onKeyPress' => 'return disableKeyPress(event)'
        ),
        'focus' => '#',
    )
);
$this->widget('bootstrap.widgets.BootAlert');
$this->renderPartial(
    $path_view . '_gridDiagnosaICDX',
    array(
        'form' => $form,
        'modDiagnosa' => $modDiagnosa,
        'model' => $model,
        'modPendaftaran' => $modPendaftaran,
        'modUraian' => $modUraian,
        'path_view' => $path_view,
        'modAdmisi' => $modAdmisi,
    )
);
?>
<br>
<?php
$this->renderPartial(
    $path_view . '_gridDiagnosaICDIX',
    array(
        'form' => $form,
        'modDiagnosaix' => $modDiagnosaix,
        'model' => $model_ix,
        'modPendaftaran' => $modPendaftaran,
        'modUraian' => $modUraianIx,
        'path_view' => $path_view,
        'modAdmisi' => $modAdmisi,
    )
);
?>

<div class="form-actions">
    <?php
    if ($instalasi == Params::INSTALASI_ID_RJ) {
        $action = ((Yii::app()->controller->module->id == 'rekamMedis') ? "InfoPasienRJ" : "InfoKunjunganRJ");
        $url = $this->createUrl('/' . Yii::app()->controller->module->id . '/' . $action . '/Index');
    } else if ($instalasi == Params::INSTALASI_ID_RD) {
        $action = ((Yii::app()->controller->module->id == 'rekamMedis') ? "InfoPasienRD" : "InfoKunjunganRJ");
        $url = $this->createUrl('/' . Yii::app()->controller->module->id . '/' . $action . '/Index');
    } else if ($instalasi == Params::INSTALASI_ID_RI) {
        $action = ((Yii::app()->controller->module->id == 'rekamMedis') ? "InfoPasienRI" : "InfoKunjunganRJ");
        $url = $this->createUrl('/' . Yii::app()->controller->module->id . '/' . $action . '/Index');
    }

    if (!(!in_array(Yii::app()->user->getState('pegawai_id'), array(1, 1028)) && Yii::app()->user->getState('kelompokpegawai_id') == Params::KELOMPOKPEGAWAI_ID_TENAGA_KEPERAWATAN)) {
        echo CHtml::htmlButton(Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="entypo-check"></i>')), array('class' => 'btn btn-danger btn-save', 'type' => 'button', 'onclick' => 'animation(this, event)')) . ' &nbsp; ';
        if (@$_GET['frame'] != 1) {

            $modDaftar = PendaftaranT::model()->findByPk($modPendaftaran->pendaftaran_id, array('select' => 'pasienadmisi_id'));
            echo CHtml::link(Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')), $this->createUrl('index', array('pendaftaran_id' => $modPendaftaran->pendaftaran_id, 'pasienadmisi_id' => $modDaftar->pasienadmisi_id)), array('class' => 'btn btn-default'));
            //            echo CHtml::htmlButton(Yii::t('mds','{icon} Back',array('{icon}'=>'<i class="entypo-cancel"></i>')),
            //                array('class'=>'btn btn-primary-blue','onKeypress'=>'return formSubmit(this,event)',
            //                    'onclick'=>'$("#iframeVerifikasiDiagnosa").attr("src",$(this).attr("href")); window.parent.$("#dialogVerifikasiDiagnosa").dialog("close");return false;'));
        }
    }

    ?>
</div>
</div>

<?php
$this->endWidget();
?>
<script>
    function animation(obj, event){
        $('.form-actions').addClass('animation-loading');
        $('.btn').attr('disabled', true);
        if(requiredCheck($('#uraian-diagnosax-form'))) {
            $('#uraian-diagnosax-form').submit();
        }
    }
    function print(caraPrint, idReseptur) {
        var pendaftaran_id = '<?php echo isset($_GET["pendaftaran_id"]) ? $_GET["pendaftaran_id"] : null ?>';
        window.open('<?php echo $this->createUrl('print'); ?>&id=' + pendaftaran_id + '&caraPrint=' + caraPrint, 'printwin', 'left=100,top=100,width=1000,height=640');
    }

    function validasiDiagnosa() {
        var pendaftaran_id = "<?php echo isset($_GET['pendaftaran_id']) ? $_GET['pendaftaran_id'] : 0  ?>"
        var url = "<?php echo Yii::app()->createUrl('rawatJalan/diagnosaTRJNew/validasiDiagnosa'); ?>"
        $.post(url, {
            pendaftaran_id: pendaftaran_id,
        }, function(data) {
            console.log(data);
            if (data.is_verifikasi == 1) {
                myAlert('Data Diagnosa Sudah diverifikasi.<br>')
                $('.btn-save').attr('disabled', 'true');
            }


        }, 'json');
    }

    function multi() {

        var pegawai_id_load = jQuery('.pegawai_id_load');

        jQuery(pegawai_id_load).multiselect({
            includeSelectAllOption: true,
            buttonClass: "form-control",
            maxHeight: 300,
            buttonWidth: '240px',
            enableCaseInsensitiveFiltering: true,
        }).hide();
    }


    $(document).ready(function() {
        if (typeof parent.cekPeriksaPasien != "undefined") {
            parent.cekPeriksaPasien();
        }
        validasiDiagnosa();
        multi();
    });
</script>