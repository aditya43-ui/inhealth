<?php Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/js/literallycanvas/css/literallycanvas.css'); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/react/build/react-with-addons.js'); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/literallycanvas/js/literallycanvas-core.min.js'); ?>

<?php
$diag_jiwa = CHtml::listData(DiagnosajiwapasienT::model()->findAllByAttributes(array(
            'askepkesehatanjiwa_id' => $model->askepkesehatanjiwa_id
        )), 'diagnosakesehatanjiwa_id', 'diagnosakesehatanjiwa_id');

$diag_data = array_values($diag_jiwa);
$master_diag = DiagnosakesehatanjiwaM::model()->findAllByAttributes(array(
    'isaktif'=>true
), array(
    'order'=>'jenisdiagnosa, kelompokdiagnosa, urutan',
));
$jenis_diag = CHtml::listData($master_diag, 'diagnosakesehatanjiwa_id', 'jenisdiagnosa');
$kelompok_diag = CHtml::listData($master_diag, 'diagnosakesehatanjiwa_id', 'kelompokdiagnosa');

$res = array();
//vaR_dump($diag_data); die;
foreach ($diag_data as $item) {
    if (empty($res[$jenis_diag[$item]][$kelompok_diag[$item]])) {
        $res[$jenis_diag[$item]][$kelompok_diag[$item]] = array();
    }
    $res[$jenis_diag[$item]][$kelompok_diag[$item]][] = $item;
}

// var_dump($res); die;


$diag_jiwa_det = new DiagnosajiwapasienT;
$diag_jiwa_det->diagnosakesehatanjiwa_id = $res;

?>

<script src="themes/neon/assets/js/jquery.bootstrap.wizard.min.js"></script>
<style type="text/css">
    .form-wizard {
        margin-top: 45px;
    }
    .form-wizard .steps-progress {
        display: block;
        background: #ebebeb;
        width: auto;
        height: 10px;
        margin: 0 70px;
        -webkit-background-clip: padding-box;
        -moz-background-clip: padding;
        background-clip: padding-box;
        -webkit-border-radius: 3px;
        -moz-border-radius: 3px;
        border-radius: 3px;
    }
    .form-wizard .steps-progress .progress-indicator {
        background: #00a651;
        width: 0%;
        height: 10px;
        -webkit-background-clip: padding-box;
        -moz-background-clip: padding;
        background-clip: padding-box;
        -webkit-border-radius: 3px;
        -moz-border-radius: 3px;
        border-radius: 3px;
        -moz-transition: all 300ms ease-in-out;
        -o-transition: all 300ms ease-in-out;
        -webkit-transition: all 300ms ease-in-out;
        transition: all 300ms ease-in-out;
    }
    .form-wizard.no-margin .tab-content {
        margin-left: 0 !important;
        margin-right: 0 !important;
    }
    .form-wizard > ul {
        display: table;
        margin: 0;
        padding: 0;
        list-style: none;
    }
    .form-wizard > ul > li {
        display: table-cell;
        width: 1%;
        text-align: center;
        position: relative;
    }
    .form-wizard > ul > li a {
        position: relative;
        display: block;
        padding-top: 35px;
        font-weight: bold;
        color: #ababab;
        -moz-transition: all 300ms ease-in-out;
        -o-transition: all 300ms ease-in-out;
        -webkit-transition: all 300ms ease-in-out;
        transition: all 300ms ease-in-out;
    }
    .form-wizard > ul > li a span {
        position: absolute;
        display: block;
        background: #ebebeb;
        color: #8e9094;
        line-height: 35px;
        text-align: center;
        margin-top: -57.5px;
        left: 50%;
        margin-left: -17.5px;
        width: 35px;
        height: 35px;
        -webkit-background-clip: padding-box;
        -moz-background-clip: padding;
        background-clip: padding-box;
        -webkit-border-radius: 50%;
        -moz-border-radius: 50%;
        border-radius: 50%;
        -moz-transition: all 300ms ease-in-out;
        -o-transition: all 300ms ease-in-out;
        -webkit-transition: all 300ms ease-in-out;
        transition: all 300ms ease-in-out;
    }
    .form-wizard > ul > li.completed a {
        color: #00a651;
    }
    .form-wizard > ul > li.completed a span {
        background: #00a651;
        color: #fff;
        -moz-box-shadow: 0px 0px 0px 5px #00a651;
        -webkit-box-shadow: 0px 0px 0px 5px #00a651;
        box-shadow: 0px 0px 0px 5px #00a651;
    }
    .form-wizard > ul > li.disabled a {
        color: rgba(142, 144, 148, 0.5);
    }
    .form-wizard > ul > li.disabled a span {
        background: #f5f5f6;
        color: rgba(142, 144, 148, 0.5);
        -moz-box-shadow: 0px 0px 0px 5px #f5f5f6;
        -webkit-box-shadow: 0px 0px 0px 5px #f5f5f6;
        box-shadow: 0px 0px 0px 5px #f5f5f6;
    }
    .form-wizard > ul > li.active a,
    .form-wizard > ul > li.current a {
        color: #c5c5c5;
        font-weight: bold;
        color: #303641;
    }
    .form-wizard > ul > li.active a span,
    .form-wizard > ul > li.current a span {
        background: #c5c5c5;
        background: #fff;
        color: #525252;
        -moz-box-shadow: 0px 0px 0px 5px #ebebeb;
        -webkit-box-shadow: 0px 0px 0px 5px #ebebeb;
        box-shadow: 0px 0px 0px 5px #ebebeb;
    }
    .form-wizard .tab-content {
        margin: 0 52.5px;
        margin-top: 35px;
    }
    .form-wizard .tab-content .pager {
        margin-top: 35px;
    }
    .form-wizard .tab-content .pager .first a {
        margin-right: 10px;
    }
    .form-wizard .tab-content .pager .last a {
        margin-left: 10px;
    }

    .groupUkurans{
        display:inline;
    }

    .fontColor{
        color: black !important;
    }
</style>


<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">Riwayat Pengkajian Keperawatan Kesehatan Jiwa</div>
    </div>
    <div class="panel-body">
        <?php echo $this->renderPartial($this->path_view."riwayat", array(
            'model'=>$model,
        ), true); ?>
    </div>
</div>



<div class="divAlert" id="alert_info"></div>
<?php
$this->widget('bootstrap.widgets.BootAlert');
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'pengkajian-jiwa-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)', 'onsubmit' => 'return requiredCheck(this);'),
    ));

echo $form->hiddenField($model, 'askepkesehatanjiwa_id', array('class'=>'askepkesehatanjiwa_id'));
echo $form->hiddenField($model, 'pendaftaran_id', array('class'=>'pendaftaran_id'));


?>


<div class="row-fluid">
    <div class="col-sm-12">
        <?php // echo CHtml::hiddenField('url', $this->createUrl('', array('pendaftaran_id' => $modPendaftaran->pendaftaran_id)), array('readonly' => TRUE));  ?>
        <div class="form-wizard form-required-wizard" id="rootwizardPengkajian">
            <div class="steps-progress">
                <div class="progress-indicator"></div>
            </div>

            <ul>
                <li class="active">
                    <a href="#wizard_tabdws1" data-toggle="tab"><span>1</span>Data Pengkajian & Informasi Umum</a>
                </li>
                <li>
                    <a href="#wizard_tabdws2" data-toggle="tab"><span>2</span>Keluhan Utama</a>
                </li>
                <li>
                    <a href="#wizard_tabdws3" data-toggle="tab"><span>3</span>Faktor Predisposi</a>
                </li>
                <li>
                    <a href="#wizard_tabdws4" data-toggle="tab"><span>4</span>Faktor Presipitasi</a>
                </li>
                <li>
                    <a href="#wizard_tabdws5" data-toggle="tab"><span>5</span>Fisik</a>
                </li>
                <li>
                    <a href="#wizard_tabdws6" data-toggle="tab"><span>6</span>Sosial-Kultur- Spiritual</a>
                </li>
                <li>
                    <a href="#wizard_tabdws7" data-toggle="tab"><span>7</span>Status Mental : Deskripsi Umum</a>
                </li>
                <li>
                    <a href="#wizard_tabdws8" data-toggle="tab"><span>8</span>Status Mental : Status Emosi & Persepsi</a>
                </li>
                <li>
                    <a href="#wizard_tabdws9" data-toggle="tab"><span>9</span>Status Mental : Proses Pikir dan Sensori & Kognisi</a>
                </li>
                <li>
                    <a href="#wizard_tabdws10" data-toggle="tab"><span>10</span>Mekanisme Koping</a>
                </li>
                <li>
                    <a href="#wizard_tabdws11" data-toggle="tab"><span>11</span>Masalah Psikososial dan Lingkungan</a>
                </li>
                <li>
                    <a href="#wizard_tabdws12" data-toggle="tab"><span>12</span>Kurangnya Pendidikan & Aspek Medis</a>
                </li>
                <li>
                    <a href="#wizard_tabdws13" data-toggle="tab"><span>13</span>Diagnosa Keperawatan</a>
                </li>
            </ul>


            <div class="tab-content">
                <div class="tab-pane active" id="wizard_tabdws1">
                    <?php
                    echo $this->renderPartial($this->path_view . "form.pengkajianUmum", array(
                        'form' => $form, 'pendaftaran' => $pendaftaran, 'pasien' => $pasien, 'model' => $model,
                        ), true);
                    ?>
                </div>
                <div class="tab-pane" id="wizard_tabdws2">
                    <?php
                    echo $this->renderPartial($this->path_view . "form.keluhanUtama", array(
                        'form' => $form, 'pendaftaran' => $pendaftaran, 'pasien' => $pasien, 'model' => $model, 'det' => $diag_jiwa_det,
                        ), true);
                    ?>
                </div>
                <div class="tab-pane" id="wizard_tabdws3">
                    <?php
                    echo $this->renderPartial($this->path_view . "form.predisposisi.index", array(
                        'form' => $form, 'pendaftaran' => $pendaftaran, 'pasien' => $pasien, 'model' => $model, 'diag_jiwa_det' => $diag_jiwa_det,
                        ), true);
                    ?>
                </div>
                <div class="tab-pane" id="wizard_tabdws4">
                    <?php
                    echo $this->renderPartial($this->path_view . "form.presipitasi", array(
                        'form' => $form, 'pendaftaran' => $pendaftaran, 'pasien' => $pasien, 'model' => $model, 'det' => $diag_jiwa_det,
                        ), true);
                    ?>
                </div>
                <div class="tab-pane" id="wizard_tabdws5">
                    <?php
                    echo $this->renderPartial($this->path_view . "form.fisik", array(
                        'form' => $form, 'pendaftaran' => $pendaftaran, 'pasien' => $pasien, 'model' => $model, 'det' => $diag_jiwa_det,
                        ), true);
                    ?>

                </div>
                <div class="tab-pane" id="wizard_tabdws6">
                    <?php
                    echo $this->renderPartial($this->path_view . "form.sosialKulturSpiritual", array(
                        'form' => $form, 'pendaftaran' => $pendaftaran, 'pasien' => $pasien, 'model' => $model, 'det' => $diag_jiwa_det,
                        ), true);
                    ?>

                </div>
                <div class="tab-pane" id="wizard_tabdws7">
                    <?php
                    echo $this->renderPartial($this->path_view . "form.deskirpsiUmum", array(
                        'form' => $form, 'pendaftaran' => $pendaftaran, 'pasien' => $pasien, 'model' => $model, 'det' => $diag_jiwa_det,
                        ), true);
                    ?>

                </div>
                <div class="tab-pane" id="wizard_tabdws8">
                    <?php
                    echo $this->renderPartial($this->path_view . "form.statusEmosi", array(
                        'form' => $form, 'pendaftaran' => $pendaftaran, 'pasien' => $pasien, 'model' => $model, 'det' => $diag_jiwa_det,
                        ), true);
                    ?>

                </div>
                <div class="tab-pane" id="wizard_tabdws9">
                    <?php
                    echo $this->renderPartial($this->path_view . "form.prosesPikir", array(
                        'form' => $form, 'pendaftaran' => $pendaftaran, 'pasien' => $pasien, 'model' => $model, 'det' => $diag_jiwa_det,
                        ), true);
                    ?>

                </div>
                <div class="tab-pane" id="wizard_tabdws10">
                    <?php
                    echo $this->renderPartial($this->path_view . "form.mekanismeKoping", array(
                        'form' => $form, 'pendaftaran' => $pendaftaran, 'pasien' => $pasien, 'model' => $model, 'det' => $diag_jiwa_det,
                        ), true);
                    ?>

                </div>
                <div class="tab-pane" id="wizard_tabdws11">
                    <?php
                    echo $this->renderPartial($this->path_view . "form.psikososialLingkungan", array(
                        'form' => $form, 'pendaftaran' => $pendaftaran, 'pasien' => $pasien, 'model' => $model, 'det' => $diag_jiwa_det,
                        ), true);
                    ?>

                </div>
                <div class="tab-pane" id="wizard_tabdws12">
                    <?php
                    echo $this->renderPartial($this->path_view . "form.kurangPendidikan", array(
                        'form' => $form, 'pendaftaran' => $pendaftaran, 'pasien' => $pasien, 'model' => $model, 'det' => $diag_jiwa_det,
                        ), true);
                    ?>

                </div>
                <div class="tab-pane" id="wizard_tabdws13">
                    <?php
                    echo $this->renderPartial($this->path_view . "form.diagnosaKeperawatan", array(
                        'form' => $form, 'pendaftaran' => $pendaftaran, 'pasien' => $pasien, 'model' => $model, 'det' => $diag_jiwa_det,
                        ), true);
                    ?>

                </div>
                <ul class="pager wizard">
                    <li class="previous" style="background-color: green">
                        <a href="javascript::void(0)" style="background-color: #00a651; color: white;"><i class="entypo-left-open"></i> Previous</a>
                    </li>

                    <li class="next btn_nxt" style="background-color: green">
                        <a href="javascript:void(0)" style="background-color: #00a651; color: white">Next <i class="entypo-right-open"></i></a>
                    </li>
                    
                    <li class="submit btn_nxt" style="background-color: #303641; color: white; float:right;">
                        <a href="javascript:void(0)" style="background-color: #303641; color: white" onclick="submitPengkajianJiwa();">Simpan <i class="entypo-floppy"></i></a>
                    </li>
                    
                    
                </ul>
            </div>

        </div>
    </div>
</div>





<?php $this->endWidget(); ?>




<?php
//========= Dialog buat cari data Pegawai Triase =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogTambahDiagnosa',
    'options' => array(
        'title' => 'Tambah Diagnosa',
        'autoOpen' => false,
        'modal' => true,
        'width' => 400,
        'height' => 300,
        'resizable' => false,
    ),
));

$modForm = new DiagnosakesehatanjiwaM;
?>

<form class="form-horizontal" id="form_tambah_diagnosa">

    <div class="control-group">
        <label class="control-label">Jenis Diagnosa <span class="required">*</span></label>
        <div class="controls">
            <?php
            echo CHtml::activeDropDownList($modForm, 'jenisdiagnosa', LookupM::getItemsUrutan('jenisdiagnosajiwa'), array(
                'empty' => '-- Pilih --', 'class' => 'span3 jenisdiagnosa'
            ));
            ?>
        </div>
    </div>
    <div class="control-group">
        <label class="control-label">Kelompok Diagnosa <span class="required">*</span></label>
        <div class="controls">
            <?php
            echo CHtml::activeDropDownList($modForm, 'kelompokdiagnosa', LookupM::getItemsUrutan('kelompokdiagnosajiwa'), array(
                'empty' => '-- Pilih --', 'class' => 'span3 kelompokdiagnosa'
            ));
            ?>
        </div>
    </div>
    <div class="control-group">
        <label class="control-label">Nama Diagnosa <span class="required">*</span></label>
        <div class="controls">
            <?php
            echo CHtml::activeTextField($modForm, 'diagnosakesehatanjiwa_nama', array(
                'class' => 'span3 diagnosakesehatanjiwa_nama'
            ));
            ?>
        </div>
    </div>

    <div class="form-actions">
        <?php echo CHtml::htmlButton('Simpan', array('class' => 'btn btn-primary', 'onclick' => 'simpanTambahDiagnosa();')); ?>
    </div>

</form>


<?php
$this->endWidget();
?>


<?php
echo $this->renderPartial($this->path_view . "jsFunctions", array(
    'pendaftaran' => $pendaftaran, 'pasien' => $pasien,
    ), true);
?>