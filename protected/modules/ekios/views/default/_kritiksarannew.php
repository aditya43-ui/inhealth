<!DOCTYPE html>
<html>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<?php $this->widget('bootstrap.widgets.BootAlert'); ?>

<style>
    /*       awal css rating*/
    .fa-star {
        color: gold;
    }

    .rate-area {
        float: left;
        border-style: none;
    }

    .rate-area:not(:checked)>input {
        position: absolute;
        top: -9999px;
        clip: rect(0, 0, 0, 0);
    }

    .rate-area:not(:checked)>label {
        float: right;
        width: 24px;
        padding: 0 .24px;
        overflow: hidden;
        white-space: nowrap;
        cursor: pointer;
        font-size: 24px;
        line-height: 1.2;
        color: lightgrey;
        text-shadow: 1px 1px #bbb;
    }

    .rate-area:not(:checked)>label:before {
        content: '★ ';
    }

    .rate-area>input:checked~label {
        color: gold;
        text-shadow: 1px 1px #c60;
        font-size: 24px !important;
    }

    .rate-area:not(:checked)>label:hover,
    .rate-area:not(:checked)>label:hover~label {
        color: gold;
    }

    .rate-area>input:checked+label:hover,
    .rate-area>input:checked+label:hover~label,
    .rate-area>input:checked~label:hover,
    .rate-area>input:checked~label:hover~label,
    .rate-area>label:hover~input:checked~label {
        color: gold;
        text-shadow: 1px 1px goldenrod;
    }

    .rate-area>label:active {
        position: relative;
        top: 2px;
        left: 2px;
    }

    /*       akhir css rating*/
    .wizard {
        margin: 20px auto;
        background: #fff;
    }

    .wizard .nav-tabs {
        position: relative;
        margin: 40px auto;
        margin-bottom: 0;
        border-bottom-color: #e0e0e0;
    }

    .wizard>div.wizard-inner {
        position: relative;
    }

    .connecting-line {
        height: 2px;
        background: #e0e0e0;
        position: absolute;
        width: 80%;
        margin: 0 auto;
        left: 0;
        right: 0;
        top: 50%;
        z-index: 1;
    }

    .wizard .nav-tabs>li.active>a,
    .wizard .nav-tabs>li.active>a:hover,
    .wizard .nav-tabs>li.active>a:focus {
        color: #555555;
        cursor: default;
        border: 0;
        border-bottom-color: transparent;
    }

    span.round-tab {
        width: 70px;
        height: 70px;
        line-height: 70px;
        display: inline-block;
        border-radius: 100px;
        background: #fff;
        border: 2px solid #e0e0e0;
        z-index: 2;
        position: absolute;
        left: 0;
        text-align: center;
        font-size: 25px;
    }

    span.round-tab i {
        color: #555555;
    }

    .wizard li.active span.round-tab {
        background: #fff;
        border: 2px solid #5bc0de;

    }

    .wizard li.active span.round-tab i {
        color: #5bc0de;
    }

    span.round-tab:hover {
        color: #333;
        border: 2px solid #333;
    }

    .wizard .nav-tabs>li {
        width: 25%;
    }

    .wizard li:after {
        content: " ";
        position: absolute;
        left: 46%;
        opacity: 0;
        margin: 0 auto;
        bottom: 0px;
        border: 5px solid transparent;
        border-bottom-color: #5bc0de;
        transition: 0.1s ease-in-out;
    }

    .wizard li.active:after {
        content: " ";
        position: absolute;
        left: 46%;
        opacity: 1;
        margin: 0 auto;
        bottom: 0px;
        border: 10px solid transparent;
        border-bottom-color: #5bc0de;
    }

    .wizard .nav-tabs>li a {
        width: 70px;
        height: 70px;
        margin: 20px auto;
        border-radius: 100%;
        padding: 0;
    }

    .wizard .nav-tabs>li a:hover {
        background: transparent;
    }

    .wizard .tab-pane {
        position: relative;
        /*padding-top: 50px;*/
    }

    .wizard h3 {
        margin-top: 0;
    }

    #setpad {
        margin: 15px;
    }

    .form-horizontal .controls {
        margin-left: 0 !important;
    }

    .form-horizontal .control-label {
        text-align: left !important;
    }

    .panel-success>.panel-heading {
        color: white;
        background-color: #c42196;
        border-color: #768086;
    }

    .panel-success {
        border-color: #768086;
    }

    .btn-primary {
        background-color: #57a595;
    }

    body {
        color: #000000;
    }

    ul {
        margin: 0;
    }

    .row {
        margin-left: 15px;
        margin-right: 15px;
    }
</style>

<body>

    <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>
    <?php
    $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
        'action' => Yii::app()->createUrl('ekios/Default/SimpanKritikSaran'),
        'method' => 'post',
        'id' => 'ppbuat-janji-poli-t-form',
        'enableAjaxValidation' => false,
        'type' => 'horizontal',
        'htmlOptions' => array('id' => 'regForm', 'onKeyPress' => 'return disableKeyPress(event)', ''),
        //'focus'=>'#',
    ));
    ?>
    <?php
    $modPasien = new PPPasienM();
    ?>
    <div class="container">
        <?php
        if (isset($_GET['success']) && $_GET['success'] == 1) {
            // var_dump('asf;sfhkjsahfjksdf');
            echo Yii::app()->user->setFlash('success', "Data sukses disimpan!");
        }
        ?>
        <h1 align="center"><b>KRITIK & SARAN</b></h1>
        <br>
        <hr/>
        <div class="row">
            <section>
                <div class="wizard">
                    <div class="wizard-inner">

                        <!--                <div class="connecting-line"></div>-->
                        <ul class="nav nav-tabs" role="tablist" hidden="true">

                            <li role="presentation" class="active">
                                <a href="#step1" data-toggle="tab" aria-controls="step1" role="tab" title="Step 1">
                                    <span class="round-tab">
                                        <i class="glyphicon glyphicon-folder-open"></i>
                                    </span>
                                </a>
                            </li>

                            <li role="presentation" class="disabled">
                                <a href="#step2" data-toggle="tab" aria-controls="step2" role="tab" title="Step 2">
                                    <span class="round-tab">
                                        <i class="glyphicon glyphicon-pencil"></i>
                                    </span>
                                </a>
                            </li>
                            <li role="presentation" class="disabled">
                                <a href="#step3" data-toggle="tab" aria-controls="step3" role="tab" title="Step 3">
                                    <span class="round-tab">
                                        <i class="glyphicon glyphicon-picture"></i>
                                    </span>
                                </a>
                            </li>

                            <li role="presentation" class="disabled">
                                <a href="#step4" data-toggle="tab" aria-controls="step4" role="tab" title="Step 4">
                                    <span class="round-tab">
                                        <i class="glyphicon glyphicon-picture"></i>
                                    </span>
                                </a>
                            </li>
                            <li role="presentation" class="disabled">
                                <a href="#step5" data-toggle="tab" aria-controls="step5" role="tab" title="Step 5">
                                    <span class="round-tab">
                                        <i class="glyphicon glyphicon-picture"></i>
                                    </span>
                                </a>
                            </li>
                            <li role="presentation" class="disabled">
                                <a href="#step6" data-toggle="tab" aria-controls="step6" role="tab" title="Step 5">
                                    <span class="round-tab">
                                        <i class="glyphicon glyphicon-picture"></i>
                                    </span>
                                </a>
                            </li>
                            <li role="presentation" class="disabled">
                                <a href="#step7" data-toggle="tab" aria-controls="step7" role="tab" title="Step 5">
                                    <span class="round-tab">
                                        <i class="glyphicon glyphicon-picture"></i>
                                    </span>
                                </a>
                            </li>
                            <li role="presentation" class="disabled">
                                <a href="#complete" data-toggle="tab" aria-controls="complete" role="tab" title="Complete">
                                    <span class="round-tab">
                                        <i class="glyphicon glyphicon-ok"></i>
                                    </span>
                                </a>
                            </li>
                        </ul>
                    </div>


                    <div class="tab-content">
                        <div class="tab-pane active" role="tabpanel" id="step1">
                            <!-- 
                                                                <input type="hidden"  id="statuspasien" />
                                                                <div id="">
                                                                    <div style="text-align:center">
                                                                        <h1>Kritik Dan Saran</h1>
                                                                    </div>
                                                                    <div class="row" id="setpad">
                                                                        <div class="col-xs-12" id="setpad" align="center">
                                <?php echo $form->textField($modPasien, 'no_rekam_medik', array('placeholder' => 'Nomer Rekam Medik', 'onChange' => "return cek_data()", 'onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span12',)); ?>
                                                                        </div>
                                                                        <div class="col-xs-12" id="setpad" align="center">
                                                                            <div style="position:relative;height:50px">
                                                                                <div style="position:absolute;top: 50%;left: 50%;transform: translate(-50%, -50%);">
                                <?php
                                $this->widget('MyDateTimePicker', array(
                                    'model' => $modPasien,
                                    'attribute' => 'tanggal_lahir',
                                    'mode' => 'date',
                                    'options' => array(
                                        'dateFormat' => Params::DATE_FORMAT,
                                        'maxDate' => 'd',
                                        //
                                        // 'onkeypress' => "js:function(){getUmurP(this);}",
                                        // 'onSelect' => 'js:function(){getUmurP(this);}',
                                    ),
                                    'htmlOptions' => array(
                                        'placeholder' => 'Tanggal Lahir', 'readonly' => true, 'id' => 'picker', 'style' => '', 'class' => 'dtPicker3 span12', 'onkeypress' => "return $(this).focusNextInputField(event)"
                                    ),
                                ));
                                ?>
                                <?php echo $form->error($modPasien, 'tanggal lahir'); ?>
                                                                                </div>
                                                                                </div>
                                                                            </div>
                                                                    </div>
                                
                                
                                
                                
                                                                </div>
                                                                <ul class="list-inline pull-right">
                                
                                                                    <li><button type="button" class="btn btn-primary " onclick="nextTabLog();"><i class="glyphicon glyphicon-search"></i> Cari</button></li>
                                                                </ul> -->


                            </div>                            
                        <div class="tab-pane" role="tabpanel" id="step2">
                            
                            <div class="row">                               
                                <div class="col-xs-12">
                                    <div class="control-group">
                                        <label class="control-label">Tanggal Rekam Medik</label>
                                        <div class="controls">
                                            <?php
                                            $this->widget('MyDateTimePicker', array(
                                                'model' => $model,
                                                'attribute' => 'tgl_rekam_medik',
                                                'mode' => 'date',
                                                'options' => array(
                                                    'dateFormat' => Params::DATE_FORMAT,
                                                    'maxDate' => 'd',
                                                    //
                                                    'onkeypress' => "js:function(){getUmurP(this);}",
                                                    'onSelect' => 'js:function(){getUmurP(this);}',
                                                ),
                                                'htmlOptions' => array(
                                                    'placeholder' => 'Tanggal Rekam Medik', 'readonly' => true, 'id' => 'picker', 'style' => '', 'class' => 'dtPicker3 span3', 'onkeypress' => "return $(this).focusNextInputField(event)"
                                                ),
                                            ));
                                            ?>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <div class="controls">
                                            <?php echo $form->textFieldRow($model, 'nama_pasien', array('class' => 'span3', 'required' => 'required', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <div class="controls">
                                            <?php echo $form->textFieldRow($model, 'email', array('class' => 'span3', 'required' => 'required', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>

                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <div class="controls">
                                            <?php echo $form->radioButtonListInlineRow($model, 'jeniskelamin', LookupM::getItems('jeniskelamin'), array('onkeyup' => "return $(this).focusNextInputField(event)")); ?>

                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <div class="controls">
                                            <?php echo $form->textFieldRow($model, 'no_mobile', array('class' => 'span3', 'type' => 'number', 'required' => 'required', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>

                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <div class="controls">
                                            <?php echo $form->textFieldRow($model, 'no_rekam_medik', array('class' => 'span3', 'required' => 'required', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>

                                        </div>
                                    </div>

                                </div>
                                <br>
                                <div class="col-xs-12">
                                    <div class="row" style="background-color:#8d8c8b;border-radius:5px">
                                        <div class="col-xs-12">
                                            <table width="100%">
                                                <tr>
                                                    <td>
                                                        <ul>
                                                            <ol>
                                                                <b> Beri tanda (v) pada pilihan Anda </b>
                                                            </ol>
                                                            <ol>
                                                                Mohon untuk tidak diisi apabila tidak berhubungan dengan unit tersebut
                                                            </ol>



                                                            <ol>
                                                                Please Rate your experience by giving check merk (v)
                                                            </ol>
                                                            <ol>
                                                                Please ignore the question(s if you dont't experience the service)
                                                            </ol>
                                                        </ul>
                                                    </td>

                                                    <td>
                                                        <table width="100%">
                                                            <tr>
                                                                <td>
                                                                    <ul>
                                                                        <ol>&nbsp;</ol>
                                                                        <ol>
                                                                            <i class="fa fa-star"></i><i class="fa fa-star"></i>
                                                                            <i class="fa fa-star"></i><i class="fa fa-star"></i>
                                                                        </ol>

                                                                        <ol>
                                                                            <i class="fa fa-star"></i><i class="fa fa-star"></i>
                                                                            <i class="fa fa-star"></i>
                                                                        </ol>

                                                                        <ol>

                                                                            <i class="fa fa-star"></i><i class="fa fa-star"></i>
                                                                        </ol>
                                                                        <ol>
                                                                            <i class="fa fa-star"></i>
                                                                        </ol>
                                                                    </ul>
                                                                </td>
                                                                <td>
                                                                    <ul>
                                                                        <ol> <b> Tingkat Penilaian </b> </ol>
                                                                        <ol>
                                                                            4 : Sangat Baik /Excellent </ol>
                                                                        <ol>
                                                                            3 : Baik / Great </ol>
                                                                        <ol> 2 : Kurang /Less </ol>
                                                                        <ol> 1 : Sangat Kurang / Very less </ol>
                                                                    </ul>
                                                                </td>
                                                            </tr>
                                                        </table>

                                                    </td>
                                                </tr>
                                                <tr>

                                                </tr>
                                            </table>
                                            <?php echo $form->hiddenField($model, 'pendaftaran_id', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 20)); ?>
                                            <?php echo $form->hiddenField($model, 'pasien_id', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 20)); ?>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="panel panel-primary">
                                        <div class="panel-heading">
                                            <div class="panel-title">AKSES / ACCESSSIBILITY</div>
                                        </div>
                                        <div class="panel-body">

                                            <table width="100%" class="tab1">

                                                <tr>
                                                    <th>Pertanyaan</th>
                                                    <th>Penilaian</th>

                                                </tr>
                                                <?php
                                                $i = 1;

                                                foreach ($modkritik as $rowkritik) {
                                                ?>

                                                    <?php
                                                    if ($rowkritik->label_soal == Params::AKSES_ACCESSSIBILITY) {
                                                    ?>

                                                        <tr>
                                                            <td width="80%"><?php echo $i ?>. <?php echo $rowkritik->soal ?>
                                                                <?php echo $form->hiddenField($modelDetail, '[' . $i . ']kritikdansaran_id', array('value' => $rowkritik->kritikdansaran_id, 'class' => 'setep1')); ?>
                                                            </td>
                                                            <td width="20%">
                                                                <ul class="rate-area">

                                                                    <?php
                                                                    echo $form->radioButton($modelDetail, '[' . $i . ']jawaban_soal', array(
                                                                        'value' => 4,
                                                                        'uncheckValue' => null,
                                                                        'id' => 'FeedbackdetT_' . $i . '_jawaban_soal_4'
                                                                    ));
                                                                    ?>
                                                                    <label for="FeedbackdetT_<?php echo $i ?>_jawaban_soal_4" title="Amazing">4 stars</label>
                                                                    <?php
                                                                    echo $form->radioButton($modelDetail, '[' . $i . ']jawaban_soal', array(
                                                                        'value' => 3,
                                                                        'uncheckValue' => null,
                                                                        'id' => 'FeedbackdetT_' . $i . '_jawaban_soal_3'
                                                                    ));
                                                                    ?>
                                                                    <label for="FeedbackdetT_<?php echo $i ?>_jawaban_soal_3" title="Amazing">3 stars</label>
                                                                    <?php
                                                                    echo $form->radioButton($modelDetail, '[' . $i . ']jawaban_soal', array(
                                                                        'value' => 2,
                                                                        'uncheckValue' => null,
                                                                        'id' => 'FeedbackdetT_' . $i . '_jawaban_soal_2'
                                                                    ));
                                                                    ?>
                                                                    <label for="FeedbackdetT_<?php echo $i ?>_jawaban_soal_2" title="Amazing">2 stars</label>
                                                                    <?php
                                                                    echo $form->radioButton($modelDetail, '[' . $i . ']jawaban_soal', array(
                                                                        'value' => 1,
                                                                        'uncheckValue' => null,
                                                                        'id' => 'FeedbackdetT_' . $i . '_jawaban_soal_1'
                                                                    ));
                                                                    ?>
                                                                    <label for="FeedbackdetT_<?php echo $i ?>_jawaban_soal_1" title="Amazing">1 stars</label>

                                                                </ul>
                                                            </td>


                                                        </tr>

                                                <?php
                                                        $i++;
                                                    }
                                                }
                                                ?>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <ul class="list-inline pull-left">
                                <li><button type="button" class="btn btn-default prev-step">Kembali</button></li>

                            </ul>
                            <ul class="list-inline pull-right">

                                <li><button type="button" class="btn btn-primary next-step">Lanjut</button></li>
                            </ul>
                        </div>
                        <div class="tab-pane" role="tabpanel" id="step3">
                            
                            <div class="row">
                                <div class="col-xs-12">
                                    <div class="panel panel-primary">
                                        <div class="panel-heading">
                                            <div class="panel-title">RESERVASI / RESERVATION</div>
                                        </div>
                                        <div class="panel-body">
                                            <table width="100%" class="tab2">

                                                <tr>
                                                    <th>Pertanyaan</th>
                                                    <th>Penilaian</th>
                                                </tr>
                                                <?php
                                                foreach ($modkritik as $rowkritik) {
                                                    if ($rowkritik->label_soal == Params::RESERVASI_RESERVATION) {
                                                ?>

                                                        <tr>
                                                            <td width="80%"><?php echo $i ?>. <?php echo $rowkritik->soal ?>
                                                                <?php echo $form->hiddenField($modelDetail, '[' . $i . ']kritikdansaran_id', array('value' => $rowkritik->kritikdansaran_id, 'class' => 'setep2')); ?>
                                                            </td>
                                                            <td width="20%">
                                                                <ul class="rate-area">

                                                                    <?php
                                                                    echo $form->radioButton($modelDetail, '[' . $i . ']jawaban_soal', array(
                                                                        'value' => 4,
                                                                        'uncheckValue' => null,
                                                                        'id' => 'FeedbackdetT_' . $i . '_jawaban_soal_4'
                                                                    ));
                                                                    ?>
                                                                    <label for="FeedbackdetT_<?php echo $i ?>_jawaban_soal_4" title="Amazing">4 stars</label>
                                                                    <?php
                                                                    echo $form->radioButton($modelDetail, '[' . $i . ']jawaban_soal', array(
                                                                        'value' => 3,
                                                                        'uncheckValue' => null,
                                                                        'id' => 'FeedbackdetT_' . $i . '_jawaban_soal_3'
                                                                    ));
                                                                    ?>
                                                                    <label for="FeedbackdetT_<?php echo $i ?>_jawaban_soal_3" title="Amazing">3 stars</label>
                                                                    <?php
                                                                    echo $form->radioButton($modelDetail, '[' . $i . ']jawaban_soal', array(
                                                                        'value' => 2,
                                                                        'uncheckValue' => null,
                                                                        'id' => 'FeedbackdetT_' . $i . '_jawaban_soal_2'
                                                                    ));
                                                                    ?>
                                                                    <label for="FeedbackdetT_<?php echo $i ?>_jawaban_soal_2" title="Amazing">2 stars</label>
                                                                    <?php
                                                                    echo $form->radioButton($modelDetail, '[' . $i . ']jawaban_soal', array(
                                                                        'value' => 1,
                                                                        'uncheckValue' => null,
                                                                        'id' => 'FeedbackdetT_' . $i . '_jawaban_soal_1'
                                                                    ));
                                                                    ?>
                                                                    <label for="FeedbackdetT_<?php echo $i ?>_jawaban_soal_1" title="Amazing">1 stars</label>

                                                                </ul>
                                                            </td>


                                                        </tr>

                                                <?php
                                                        $i++;
                                                    }
                                                }
                                                ?>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <ul class="list-inline pull-left">
                                <li><button type="button" class="btn btn-default prev-step">Kembali</button></li>

                            </ul>
                            <ul class="list-inline pull-right">

                                <li><button type="button" class="btn btn-primary next-step">Lanjut</button></li>
                            </ul>
                        </div>

                        <div class="tab-pane" role="tabpanel" id="step4">
                            
                            <div class="row">
                                <div class="col-xs-12">
                                    <div class="panel panel-primary">
                                        <div class="panel-heading">
                                            <div class="panel-title">DOKTER ANDA / YOUR DOCTOR</div>
                                        </div>
                                        <div class="panel-body">
                                            <table width="100%" class="tab3">

                                                <tr>
                                                    <th>Pertanyaan</th>
                                                    <th>Penilaian</th>
                                                </tr>
                                                <?php
                                                foreach ($modkritik as $rowkritik) {
                                                    if ($rowkritik->label_soal == Params::DOKTER_DOCTOR) {
                                                ?>

                                                        <tr>
                                                            <td width="80%"><?php echo $i ?>. <?php echo $rowkritik->soal ?>
                                                                <?php echo $form->hiddenField($modelDetail, '[' . $i . ']kritikdansaran_id', array('value' => $rowkritik->kritikdansaran_id, 'class' => 'setep3')); ?>
                                                            </td>
                                                            <td width="20%">
                                                                <ul class="rate-area">

                                                                    <?php
                                                                    echo $form->radioButton($modelDetail, '[' . $i . ']jawaban_soal', array(
                                                                        'value' => 4,
                                                                        'uncheckValue' => null,
                                                                        'id' => 'FeedbackdetT_' . $i . '_jawaban_soal_4'
                                                                    ));
                                                                    ?>
                                                                    <label for="FeedbackdetT_<?php echo $i ?>_jawaban_soal_4" title="Amazing">4 stars</label>
                                                                    <?php
                                                                    echo $form->radioButton($modelDetail, '[' . $i . ']jawaban_soal', array(
                                                                        'value' => 3,
                                                                        'uncheckValue' => null,
                                                                        'id' => 'FeedbackdetT_' . $i . '_jawaban_soal_3'
                                                                    ));
                                                                    ?>
                                                                    <label for="FeedbackdetT_<?php echo $i ?>_jawaban_soal_3" title="Amazing">3 stars</label>
                                                                    <?php
                                                                    echo $form->radioButton($modelDetail, '[' . $i . ']jawaban_soal', array(
                                                                        'value' => 2,
                                                                        'uncheckValue' => null,
                                                                        'id' => 'FeedbackdetT_' . $i . '_jawaban_soal_2'
                                                                    ));
                                                                    ?>
                                                                    <label for="FeedbackdetT_<?php echo $i ?>_jawaban_soal_2" title="Amazing">2 stars</label>
                                                                    <?php
                                                                    echo $form->radioButton($modelDetail, '[' . $i . ']jawaban_soal', array(
                                                                        'value' => 1,
                                                                        'uncheckValue' => null,
                                                                        'id' => 'FeedbackdetT_' . $i . '_jawaban_soal_1'
                                                                    ));
                                                                    ?>
                                                                    <label for="FeedbackdetT_<?php echo $i ?>_jawaban_soal_1" title="Amazing">1 stars</label>

                                                                </ul>
                                                            </td>


                                                        </tr>

                                                <?php
                                                        $i++;
                                                    }
                                                }
                                                ?>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <ul class="list-inline pull-left">
                                <li><button type="button" class="btn btn-default prev-step">Kembali</button></li>

                            </ul>
                            <ul class="list-inline pull-right">

                                <li><button type="button" class="btn btn-primary next-step">Lanjut</button></li>
                            </ul>


                        </div>

                        <div class="tab-pane" role="tabpanel" id="step5">
                            

                            <div class="row">
                                <div class="col-xs-12">
                                    <div class="panel panel-primary">
                                        <div class="panel-heading">
                                            <div class="panel-title">KASIR / CASHIER</div>
                                        </div>
                                        <div class="panel-body">
                                            <table width="100%" class="tab4">

                                                <tr>
                                                    <th>Pertanyaan</th>
                                                    <th>Penilaian</th>
                                                </tr>
                                                <?php
                                                foreach ($modkritik as $rowkritik) {
                                                    if ($rowkritik->label_soal == Params::KASIE_CASHIER) {
                                                ?>
                                                        <tr id='stepone'>
                                                            <td width="80%"><?php echo $i ?>. <?php echo $rowkritik->soal ?>
                                                                <?php echo $form->hiddenField($modelDetail, '[' . $i . ']kritikdansaran_id', array('value' => $rowkritik->kritikdansaran_id, 'class' => 'setep4')); ?>
                                                            </td>
                                                            <td width="20%">
                                                                <ul class="rate-area">

                                                                    <?php
                                                                    echo $form->radioButton($modelDetail, '[' . $i . ']jawaban_soal', array(
                                                                        'value' => 4,
                                                                        'uncheckValue' => null,
                                                                        'id' => 'FeedbackdetT_' . $i . '_jawaban_soal_4'
                                                                    ));
                                                                    ?>
                                                                    <label for="FeedbackdetT_<?php echo $i ?>_jawaban_soal_4" title="Amazing">4 stars</label>
                                                                    <?php
                                                                    echo $form->radioButton($modelDetail, '[' . $i . ']jawaban_soal', array(
                                                                        'value' => 3,
                                                                        'uncheckValue' => null,
                                                                        'id' => 'FeedbackdetT_' . $i . '_jawaban_soal_3'
                                                                    ));
                                                                    ?>
                                                                    <label for="FeedbackdetT_<?php echo $i ?>_jawaban_soal_3" title="Amazing">3 stars</label>
                                                                    <?php
                                                                    echo $form->radioButton($modelDetail, '[' . $i . ']jawaban_soal', array(
                                                                        'value' => 2,
                                                                        'uncheckValue' => null,
                                                                        'id' => 'FeedbackdetT_' . $i . '_jawaban_soal_2'
                                                                    ));
                                                                    ?>
                                                                    <label for="FeedbackdetT_<?php echo $i ?>_jawaban_soal_2" title="Amazing">2 stars</label>
                                                                    <?php
                                                                    echo $form->radioButton($modelDetail, '[' . $i . ']jawaban_soal', array(
                                                                        'value' => 1,
                                                                        'uncheckValue' => null,
                                                                        'id' => 'FeedbackdetT_' . $i . '_jawaban_soal_1'
                                                                    ));
                                                                    ?>
                                                                    <label for="FeedbackdetT_<?php echo $i ?>_jawaban_soal_1" title="Amazing">1 stars</label>

                                                                </ul>
                                                            </td>


                                                        </tr>


                                                <?php
                                                        $i++;
                                                    }
                                                }
                                                ?>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <ul class="list-inline pull-left">
                                <li><button type="button" class="btn btn-default prev-step">Kembali</button></li>

                            </ul>
                            <ul class="list-inline pull-right">

                                <li><button type="button" class="btn btn-primary next-step">Lanjut</button></li>
                            </ul>
                        </div>

                        <div class="tab-pane" role="tabpanel" id="step6">
                            

                            <div class="row">
                                <div class="col-xs-12">
                                    <div class="panel panel-primary">
                                        <div class="panel-heading">
                                            <div class="panel-title">FARMASI / PHARMACY</div>
                                        </div>
                                        <div class="panel-body">
                                            <table width="100%" class="tab5">

                                                <tr>
                                                    <th>Pertanyaan</th>
                                                    <th>Penilaian</th>
                                                </tr>
                                                <?php
                                                foreach ($modkritik as $rowkritik) {
                                                    if ($rowkritik->label_soal == Params::FARMASI_PHARMACY) {
                                                ?>

                                                        <tr>
                                                            <td width="80%"><?php echo $i ?>. <?php echo $rowkritik->soal ?>
                                                                <?php echo $form->hiddenField($modelDetail, '[' . $i . ']kritikdansaran_id', array('value' => $rowkritik->kritikdansaran_id, 'class' => 'setep5')); ?>
                                                            </td>
                                                            <td width="20%">
                                                                <ul class="rate-area">

                                                                    <?php
                                                                    echo $form->radioButton($modelDetail, '[' . $i . ']jawaban_soal', array(
                                                                        'value' => 4,
                                                                        'uncheckValue' => null,
                                                                        'id' => 'FeedbackdetT_' . $i . '_jawaban_soal_4'
                                                                    ));
                                                                    ?>
                                                                    <label for="FeedbackdetT_<?php echo $i ?>_jawaban_soal_4" title="Amazing">4 stars</label>
                                                                    <?php
                                                                    echo $form->radioButton($modelDetail, '[' . $i . ']jawaban_soal', array(
                                                                        'value' => 3,
                                                                        'uncheckValue' => null,
                                                                        'id' => 'FeedbackdetT_' . $i . '_jawaban_soal_3'
                                                                    ));
                                                                    ?>
                                                                    <label for="FeedbackdetT_<?php echo $i ?>_jawaban_soal_3" title="Amazing">3 stars</label>
                                                                    <?php
                                                                    echo $form->radioButton($modelDetail, '[' . $i . ']jawaban_soal', array(
                                                                        'value' => 2,
                                                                        'uncheckValue' => null,
                                                                        'id' => 'FeedbackdetT_' . $i . '_jawaban_soal_2'
                                                                    ));
                                                                    ?>
                                                                    <label for="FeedbackdetT_<?php echo $i ?>_jawaban_soal_2" title="Amazing">2 stars</label>
                                                                    <?php
                                                                    echo $form->radioButton($modelDetail, '[' . $i . ']jawaban_soal', array(
                                                                        'value' => 1,
                                                                        'uncheckValue' => null,
                                                                        'id' => 'FeedbackdetT_' . $i . '_jawaban_soal_1'
                                                                    ));
                                                                    ?>
                                                                    <label for="FeedbackdetT_<?php echo $i ?>_jawaban_soal_1" title="Amazing">1 stars</label>

                                                                </ul>
                                                            </td>


                                                        </tr>

                                                <?php
                                                        $i++;
                                                    }
                                                }
                                                ?>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <ul class="list-inline pull-left">
                                <li><button type="button" class="btn btn-default prev-step">Kembali</button></li>

                            </ul>
                            <ul class="list-inline pull-right">

                                <li><button type="button" class="btn btn-primary next-step">Lanjut</button></li>
                            </ul>
                        </div>

                        <div class="tab-pane" role="tabpanel" id="step7">
                            

                            <div class="row">
                                <div class="col-xs-12">
                                    <div class="panel panel-primary">
                                        <div class="panel-heading">
                                            <div class="panel-title">LINGKUNGAN & FASILITAS GEDUNG / BUILDING FACILITIES & ENVIRONMENT</div>
                                        </div>
                                        <div class="panel-body">
                                            <table width="100%" class="tab6">

                                                <tr>
                                                    <th>Pertanyaan</th>
                                                    <th>Penilaian</th>
                                                </tr>
                                                <?php
                                                foreach ($modkritik as $rowkritik) {
                                                    if ($rowkritik->label_soal == Params::LINGKUNGAN_ENVIRONMENT) {
                                                ?>

                                                        <tr>
                                                            <td width="80%"><?php echo $i ?>. <?php echo $rowkritik->soal ?>
                                                                <?php echo $form->hiddenField($modelDetail, '[' . $i . ']kritikdansaran_id', array('value' => $rowkritik->kritikdansaran_id, 'class' => 'setep6')); ?>
                                                            </td>
                                                            <td width="20%">
                                                                <ul class="rate-area">

                                                                    <?php
                                                                    echo $form->radioButton($modelDetail, '[' . $i . ']jawaban_soal', array(
                                                                        'value' => 4,
                                                                        'uncheckValue' => null,
                                                                        'id' => 'FeedbackdetT_' . $i . '_jawaban_soal_4'
                                                                    ));
                                                                    ?>
                                                                    <label for="FeedbackdetT_<?php echo $i ?>_jawaban_soal_4" title="Amazing">4 stars</label>
                                                                    <?php
                                                                    echo $form->radioButton($modelDetail, '[' . $i . ']jawaban_soal', array(
                                                                        'value' => 3,
                                                                        'uncheckValue' => null,
                                                                        'id' => 'FeedbackdetT_' . $i . '_jawaban_soal_3'
                                                                    ));
                                                                    ?>
                                                                    <label for="FeedbackdetT_<?php echo $i ?>_jawaban_soal_3" title="Amazing">3 stars</label>
                                                                    <?php
                                                                    echo $form->radioButton($modelDetail, '[' . $i . ']jawaban_soal', array(
                                                                        'value' => 2,
                                                                        'uncheckValue' => null,
                                                                        'id' => 'FeedbackdetT_' . $i . '_jawaban_soal_2'
                                                                    ));
                                                                    ?>
                                                                    <label for="FeedbackdetT_<?php echo $i ?>_jawaban_soal_2" title="Amazing">2 stars</label>
                                                                    <?php
                                                                    echo $form->radioButton($modelDetail, '[' . $i . ']jawaban_soal', array(
                                                                        'value' => 1,
                                                                        'uncheckValue' => null,
                                                                        'id' => 'FeedbackdetT_' . $i . '_jawaban_soal_1'
                                                                    ));
                                                                    ?>
                                                                    <label for="FeedbackdetT_<?php echo $i ?>_jawaban_soal_1" title="Amazing">1 stars</label>

                                                                </ul>
                                                            </td>


                                                        </tr>

                                                <?php
                                                        $i++;
                                                    }
                                                }
                                                ?>
                                            </table>

                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-10">
                                            <label style="text-align: justify">
                                                Apakah Anda akan merekomendasikan OMDC Dental Clinic kepada teman/keluarga yang memerlukan layanan?

                                                Are you willing to recommend OMDC Dental Clinic to friends or family in need of health treatment or core?

                                                Mohon penjelasan bila jawaban Anda TIDAK / Kindly provide explanation if your respond is "NO"
                                            </label>
                                        </div>
                                        <div class="col-xs-2">
                                            <div class='control-group'>
                                                <label>Ya </label>
                                                <div class="controls">
                                                    <?php
                                                    echo $form->radioButton($model, 'rekomendasi_status', array(
                                                        'value' => 1,
                                                        'class' => 'ya_status',
                                                    ));
                                                    ?>
                                                </div>
                                            </div>
                                            <div class='control-group'>
                                                <label>Tidak </label>
                                                <div class="controls">
                                                    <?php
                                                    echo $form->radioButton($model, 'rekomendasi_status', array(
                                                        'value' => 0,
                                                        'class' => 'tidak_status',
                                                    ));
                                                    ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class='control-group rekomendasi_teks'>

                                        <div class="controls">

                                            <?php echo $form->textArea($model, 'tidakrekomendasi_deskripsi', array('rows' => 3, 'cols' => 100, 'class' => 'span6 ', 'onkeypress' => "return $(this).focusNextInputField(event);", 'placeholder' => '')); ?>
                                        </div>
                                    </div>

                                    <?php echo $form->labelEx($model, 'sarandankritik', array('class' => 'control-label', 'style' => 'width:100%')) ?>
                                    <div class='control-group'>

                                        <div class="controls">

                                            <?php echo $form->textArea($model, 'sarandankritik', array('rows' => 3, 'cols' => 100, 'class' => 'span6', 'onkeypress' => "return $(this).focusNextInputField(event);", 'placeholder' => 'saran dan kritik')); ?>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <ul class="list-inline pull-left">
                                <li><button type="button" class="btn btn-default prev-step">Kembali</button></li>

                            </ul>
                            <ul class="list-inline pull-right">

                                <li><button type="submit" class="btn btn-primary">Simpan</button></li>
                            </ul>

                        </div>
                        <div class="tab-pane" role="tabpanel" id="complete">
                            <h3>Complete</h3>
                            <p>You have successfully completed all steps.</p>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <?php $this->endWidget(); ?>
                </div>
            </section>
        </div>
    </div>
    <script type='text/javascript'>
        //             $('#FeedbackT_rekomendasi_status').change(function() { 
        //               if($(".tidak_status").is(":checked")) {
        //                    alert("show");
        //                    $(".rekomendasi_teks").show(); 
        //               }else if($("ya_status").is(":checked")) {
        //                    $(".rekomendasi_teks").hide();        
        //                     alert("hide");        
        //               }
        //               });

        $('.tidak_status').change(function() {
            if (this.checked) {

                $(".rekomendasi_teks").show();
            }

        });

        $('.ya_status').change(function() {
            if (this.checked) {
                $(".rekomendasi_teks").hide();
                $("#FeedbackT_tidakrekomendasi_deskripsi").val("");


            }

        });

        $(document).ready(function() {
            $("#picker_date").hide();
            $(".rekomendasi_teks").hide();
            $('.tidak_status').attr('checked', false);
            $('.ya_status').attr('checked', false);



            $(".next-step").click(function(e) {
                var $active = $('.wizard .nav-tabs li.active');

                var idsetep = $active.find('a[aria-controls]').attr('aria-controls');

                if (idsetep == 'step2') {
                    if ($('table.tab1 input:radio:checked').length < ($('table.tab1 tr').length - 1)) {
                        myAlert('Data tidak boleh kosong')
                        return
                    }
                }

                if (idsetep == 'step3') {
                    if ($('table.tab2 input:radio:checked').length < ($('table.tab2 tr').length - 1)) {
                        myAlert('Data tidak boleh kosong')
                        return
                    }
                }

                if (idsetep == 'step4') {
                    if ($('table.tab3 input:radio:checked').length < ($('table.tab3 tr').length - 1)) {
                        myAlert('Data tidak boleh kosong')
                        return
                    }
                }

                if (idsetep == 'step5') {
                    if ($('table.tab4 input:radio:checked').length < ($('table.tab4 tr').length - 1)) {
                        myAlert('Data tidak boleh kosong')
                        return
                    }
                }

                if (idsetep == 'step6') {
                    if ($('table.tab5 input:radio:checked').length < ($('table.tab5 tr').length - 1)) {
                        myAlert('Data tidak boleh kosong')
                        return
                    }
                }
                if (idsetep == 'step7') {
                    if ($('table.tab4 input:radio:checked').length < ($('table.tab4 tr').length - 1)) {
                        myAlert('Data tidak boleh kosong')
                        return
                    }
                }

                var $active = $('.wizard .nav-tabs li.active');
                var idsetep = $active.find('a[aria-controls]').attr('aria-controls');
                // console.log(idsetep)
                if (requiredCheck($("#" + idsetep))) {
                    nextTab($active);
                }


            });
            $(".prev-step").click(function(e) {

                var $active = $('.wizard .nav-tabs li.active');
                prevTab($active);

            });
        });

        function validateStep1() {
            var count = $('.table1').length
            $('.tab1 tr input[type=radio]').each(function() {
                console.log(count)
                if ($(':checked').length < count) {
                    var $active = $('.wizard .nav-tabs li.active');
                    $active.next().addClass('disabled');
                    return
                }
                //  alert($(this).attr('checked'));
            });

        }

        function validateStep2() {
            var count = $('.table2').length
            $('#tab2 tr input[type=radio]').each(function() {
                // console.log()
                if ($(':checked').length < count) {
                    // alert('Data harus dilengkapi')
                    return
                }
                //  alert($(this).attr('checked'));
            });

        }

        function validateStep3() {
            var count = $('.table3').length
            $('#tab3 tr input[type=radio]').each(function() {
                // console.log()
                if ($(':checked').length < count) {
                    // alert('Data harus dilengkapi')
                    return
                }
                //  alert($(this).attr('checked'));
            });

        }

        function validateStep4() {
            var count = $('.table4').length
            $('#tab4 tr input[type=radio]').each(function() {
                // console.log()
                if ($(':checked').length < count) {
                    // alert('Data harus dilengkapi')
                    return
                }
                //  alert($(this).attr('checked'));
            });

        }

        function validateStep5() {
            var count = $('.table5').length
            $('#tab5 tr input[type=radio]').each(function() {
                // console.log()
                if ($(':checked').length < count) {
                    // alert('Data harus dilengkapi')
                    return
                }
                //  alert($(this).attr('checked'));
            });

        }

        function validateStep6() {
            var count = $('.table6').length
            $('#tab6 tr input[type=radio]').each(function() {
                // console.log()
                if ($(':checked').length < count) {
                    // alert('Data harus dilengkapi')
                    return
                }
                //  alert($(this).attr('checked'));
            });

        }


        function setPasien(status) {
            $('#statuspasien').val("");
            $('#statuspasien').val(status);
            var $active = $('.wizard .nav-tabs li.active');
            $active.next().removeClass('disabled');
            nextTab($active);
        }

        function nextTab(elem) {
            $(elem).next().find('a[data-toggle="tab"]').click();
            // $(this).scrollTop(0);

        }

        function prevTab(elem) {
            $(elem).prev().find('a[data-toggle="tab"]').click();
            // $(this).scrollTop(0);

        }


        function nextTabLog(elem) {

            var norekam = $('#PPPasienM_no_rekam_medik').val();
            var tgllahir = $('#picker').val();

            var statusaksi = false;


            $.ajax({
                type: 'POST',
                url: '<?php echo Yii::app()->createUrl('/ekios/Default/ValidasiUtama') ?>',
                data: {
                    norekam: norekam,
                    tgllahir: tgllahir
                },
                dataType: "json",
                success: function(data) {
                    //alert(data.jenisidentitas);
                    console.log(data);
                    if (data.status != false) {
                        // console.log("berhasil");
                        <?php echo Yii::app()->user->setFlash('success', "Data berhasil disimpan"); ?>
                        var $active = $('.wizard .nav-tabs li.active');
                        $active.next().removeClass('disabled');
                        $("#no_rekam_medik").html(data.no_rekam_medik);
                        $("#tgl_rekam_medik").html(data.tgl_rekam_medik);
                        $("#nama_pasien").html(data.nama_pasien);
                        $("#tgl_lahir").html(data.tanggal_lahir);
                        $("#no_mobile").html(data.no_mobile_pasien);
                        $("#jeniskelamin").html(data.jeniskelamin);
                        $("#FeedbackT_pasien_id").val(data.pasien_id);
                        $("#FeedbackT_pendaftaran_id").val(data.pendaftaran_id);
                        nextTab($active);

                    } else {
                        alert("Data Yang Anda Cari Be?r=sistemAdministrator&modul_id=1um Terdaftar ");
                        <?php echo Yii::app()->user->setFlash('error', "Data gagal disimpan"); ?>

                        return false;
                    }
                }
            });


            console.log(statusaksi);

        }

        $(document).ready(function() {
            var $active = $('.wizard .nav-tabs li.active');
            $active.next().removeClass('disabled');
            nextTab($active)
            $("a[href='#bottom']").click(function() {
                $("html, body").animate({
                    scrollTop: $(document).height()
                }, "slow");
                return false;
            });
        })
    </script>
</body>

</html>