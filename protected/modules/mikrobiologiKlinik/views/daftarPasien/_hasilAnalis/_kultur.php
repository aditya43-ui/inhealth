<style>
.judul-ab {
    font-weight: bold;
}

.inp-ab {
    margin-left: 20px;
}

.space-ab1 {
    margin-left: 20px;
    margin-right: 20px;
}

.space-ab2 {
    margin-left: 20px;
    margin-right: 20px;
}
</style>
<?php
    // var_dump($kultur); die;
?>
<!-- <?php //echo $form->errorSummary($kultur); ?> -->


<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="fas fa-book"></i> &nbsp;<b>Pemeriksaan Kultur</b>
            <?php //echo $form->hiddenField($kultur, 'pemeriksaankultur_id', array('class' => '', 'onkeypress' => "return $(this).focusNextInputField(event)", 'readonly' => true)); ?>
        </div>
    </div>
    <div class="panel-body" id="">
        <div class="row row-fluid">
            <div class="col-sm-6">
                <div class="control-group">
                    <label class="control-label">Dokter 1 <span class="required">*</span></label>
                    <div class="controls">
                        <?php
                            echo $form->dropDownList($kultur, 'pegawai_id', CHtml::listData(PegawairuanganV::model()->findAll(' ruangan_id = 1131 and kelompokpegawai_id = 1 '), 'pegawai_id', 'namaLengkap'), array(
                                'empty' => '-- Pilih --', 'class' => 'span4 required',
                            ));
                        ?>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Dokter 2</label>
                    <div class="controls">
                        <?php
                            echo $form->dropDownList($kultur, 'dpjp_id', CHtml::listData(PegawairuanganV::model()->findAll(' ruangan_id = 1131 and kelompokpegawai_id = 1 '), 'pegawai_id', 'namaLengkap'), array(
                                'empty' => '-- Pilih --', 'class' => 'span4',
                            ));
                        ?>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Analis</label>
                    <div class="controls">
                        <?php
                            echo $form->dropDownList($kultur, 'perawat_id', CHtml::listData(PegawairuanganV::model()->findAll(' ruangan_id = 1131 and kelompokpegawai_id in (2, 20) '), 'pegawai_id', 'namaLengkap'), array(
                                'empty' => '-- Pilih --', 'class' => 'span4',
                            ));
                        ?>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="control-group">
                    <label class="control-label">Tanggal Pemeriksaan <span class="required">*</span></label>
                    <div class="controls">
                        <?php
                    
                            $this->widget('MyDateTimePicker', array(
                                'model' => $kultur,
                                'attribute' => 'tgl_pemeriksaan',
                                'mode' => 'datetime',
                                'options' => array(
                                    'dateFormat' => Params::DATE_FORMAT,
                                ),
                                'htmlOptions' => array('class' => 'dtPicker3 span3 required', 'onkeypress' => "return $(this).focusNextInputField(event)"
                                ),
                            ));

                        ?>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Jenis Pemeriksaan </label>
                    <div class="controls">
                        <?php echo $form->textField($kultur, 'jenis_pemeriksaan', array('readonly' => true, 'class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="row row-fluid">
            <div class="col-sm-6">
                <div class="panel panel-gradient">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <b>Sediaan Langsung</b>
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="control-group">
                            <label class="control-label">Sediaan Garam </label><br>
                        </div>
                        <div class="control-group">
                            <label class="control-label">Sel Epitel </label>
                            <div class="controls">
                                <?php echo $form->dropDownList($kultur,'sel_epitel_kultur', LookupM::getItems('mikro_sel_epitel'),array('class'=>'span3', 'empty'=>'-- Pilih --')); ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">Sel Radang </label>
                            <div class="controls">
                                <?php echo $form->dropDownList($kultur,'sel_radang_kultur', LookupM::getItems('mikro_sel_radang'),array('class'=>'span3', 'empty'=>'-- Pilih --')); ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">Mikroorganisme </label>
                            <div class="controls">
                                <?php echo $form->dropDownList($kultur,'mikroorganisme', LookupM::getItems('mikro_mikroorganisme'),array('class'=>'span3', 'empty'=>'-- Pilih --')); ?>
                            </div>
                        </div>
                        <div class="control-group ">
                            <label class="control-label">&emsp; </label>
                            <div class="controls">
                                <?php echo $form->textArea($kultur, 'mikroorganisme_ket', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 500)); ?>
                                <?php
                                    echo CHtml::htmlButton('<i class="icon-plus-sign icon-white"></i> <i class="icon-white icon-chevron-right"></i>', array('class' => 'btn btn-primary', 'onclick' => "$('#dialogMikroorganismeKet').dialog('open');",
                                      'id' => 'btnAddMikroorganismeKet', 'onkeypress' => "return $(this).focusNextInputField(event)",
                                      'rel' => 'tooltip', 'title' => 'Klik untuk menambah keterangan mikroorganisme'))
                                ?>
                                <?php echo $form->error($kultur, 'mikroorganisme_ket'); ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">Pewarnaan Ziehn Nielsen </label>
                            <div class="controls">
                                <?php echo $form->dropDownList($kultur,'ziehlnielsen_kultur', LookupM::getItems('mikro_nielsen'),array('class'=>'span3', 'empty'=>'-- Pilih --')); ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">Pewarnaan KOH </label>
                            <div class="controls">
                                <?php echo $form->dropDownList($kultur,'koh_kultur', LookupM::getItems('mikro_koh'),array('class'=>'span3', 'empty'=>'-- Pilih --')); ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">Pewarnaan Niesser </label>
                            <div class="controls">
                                <?php echo $form->dropDownList($kultur,'niesser_kultur', LookupM::getItems('mikro_niesser'),array('class'=>'span3', 'empty'=>'-- Pilih --')); ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">Pewarnaan Negatif </label>
                            <div class="controls">
                                <?php echo $form->dropDownList($kultur,'negatif_kultur', LookupM::getItems('mikro_negatif'),array('class'=>'span3', 'empty'=>'-- Pilih --')); ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">Pewarnaan Spora </label>
                            <div class="controls">
                                <?php echo $form->dropDownList($kultur,'spora_kultur', LookupM::getItems('mikro_spora'),array('class'=>'span3', 'empty'=>'-- Pilih --')); ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">Pewarnaan Giemsa </label>
                            <div class="controls">
                                <?php echo $form->dropDownList($kultur,'giemsa_kultur', LookupM::getItems('mikro_giemsa'),array('class'=>'span3', 'empty'=>'-- Pilih --')); ?>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="panel panel-gradient" style="width: 104%;">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <b>Biakan Kultur</b>
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="control-group">
                            <label class="control-label">Biakan Kultur </label>
                            <div class="controls">
                                <?php echo $form->dropDownList($kultur,'biakan_kultur', LookupM::getItems('mikro_biakan'),array('class'=>'span3', 'empty'=>'-- Pilih --')); ?>
                            </div>
                        </div>
                        <div class="control-group ">
                            <label class="control-label">&nbsp;</label>

                            <div class="controls">
                                <?php echo $form->textArea($kultur, 'biakan_kultur_ket', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 500)); ?>
                                <?php
                                    echo CHtml::htmlButton('<i class="icon-plus-sign icon-white"></i> <i class="icon-white icon-chevron-right"></i>', array('class' => 'btn btn-primary', 'onclick' => "$('#dialogBiakan').dialog('open');",
                                      'id' => 'btnAddMikroorganisme', 'onkeypress' => "return $(this).focusNextInputField(event)",
                                      'rel' => 'tooltip', 'title' => 'Klik untuk menambah keterangan biakan kultur'))
                                ?>
                                <?php echo $form->error($kultur, 'biakan_kultur_ket'); ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="panel panel-gradient" style="width: 104%;">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <b>Saran / Expertise</b>
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="control-group">
                            <label class="control-label">Saran / Expertise</label>
                            <div class="controls">
                                <?php $this->widget('ext.redactorjs.Redactor', array('model' => $kultur, 'attribute' => 'saran_kultur', 'toolbar' => 'mini', 'height' => '200px')) ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="panel panel-gradient">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="fas fa-book"></i> &nbsp;<b>Tes Kepekaan Antibiotika</b>
                </div>
            </div>
            <div class="panel-body" id="">
                <div class="row row-fluid">
                    <div class="col-sm-6">
                        <table style="width: 75%;">
                            <tr>
                                <td style="width: 50%;"><label class="judul-ab">A. PENICILIN & DERIVATNYA</label></td>
                                <td style="width: 24%;">
                                    <center><label class="judul-ab">1</center></label>
                                </td>
                                <td style="width: 2%;">
                                    <center><label class="judul-ab">&emsp;</center></label>
                                </td>
                                <td style="width: 24%;">
                                    <center><label class="judul-ab">2</center></label>
                                </td>
                            </tr>
                            <tr>
                            <?php

                                $amoxycilin1 = null; $amoxycilin2 = null;

                                if(!empty($kultur->amoxycilin)) {
                                    $amoxycilin = explode(' / ', $kultur->amoxycilin);
                                    $amoxycilin1 = $amoxycilin[0];
                                    $amoxycilin2 = $amoxycilin[1];
                                }

                            ?>
                                <td style="width: 50%;"><label class="input-ab">&emsp;&emsp;&emsp;Amoxycilin</label>
                                </td>
                                <td style="width: 25%;">
                                    <center><label
                                            class="input-ab"><?= CHtml::dropDownList('PemeriksaankulturT[amoxycilin1]', $amoxycilin1, LookupM::getItems('antibiotika_jenisobat'), array('empty' => ' - ', 'class' => 'span2 ab ab1', 'onkeyup' => "return $(this).focusNextInputField(event)",)); ?>
                                    </center></label>
                                </td>
                                <td>&emsp;<?php echo $form->hiddenField($kultur, 'amoxycilin', array('class' => 'simpan', 'onkeypress' => "return $(this).focusNextInputField(event)", 'readonly' => true)); ?>
                                </td>
                                <td style="width: 25%;">
                                    <center><label
                                            class="input-ab"><?= CHtml::dropDownList('PemeriksaankulturT[amoxycilin2]', $amoxycilin2, LookupM::getItems('antibiotika_jenisobat'), array('empty' => ' - ', 'class' => 'span2 ab ab2', 'onkeyup' => "return $(this).focusNextInputField(event)",)); ?>
                                    </center></label>
                                </td>
                            </tr>
                            <tr>
                            <?php

                                $clavulanic1 = null; $clavulanic2 = null;
                                                                
                                if(!empty($kultur->clavulanic)) {
                                    $clavulanic = explode(' / ', $kultur->clavulanic);
                                    $clavulanic1 = $clavulanic[0];
                                    $clavulanic2 = $clavulanic[1];
                                }

                            ?>
                                <td style="width: 50%;"><label class="input-ab">&emsp;&emsp;&emsp;Amoxycilin &
                                        Clavulanic Acid</label></td>
                                <td style="width: 25%;">
                                    <center><label
                                            class="input-ab"><?= CHtml::dropDownList('PemeriksaankulturT[clavulanic1]', $clavulanic1, LookupM::getItems('antibiotika_jenisobat'), array('empty' => ' - ', 'class' => 'span2 ab ab1', 'onkeyup' => "return $(this).focusNextInputField(event)",)); ?>
                                    </center></label>
                                </td>
                                <td>&emsp;<?php echo $form->hiddenField($kultur, 'clavulanic', array('class' => 'simpan', 'onkeypress' => "return $(this).focusNextInputField(event)", 'readonly' => true)); ?>
                                </td>
                                <td style="width: 25%;">
                                    <center><label
                                            class="input-ab"><?= CHtml::dropDownList('PemeriksaankulturT[clavulanic2]', $clavulanic2, LookupM::getItems('antibiotika_jenisobat'), array('empty' => ' - ', 'class' => 'span2 ab ab2', 'onkeyup' => "return $(this).focusNextInputField(event)",)); ?>
                                    </center></label>
                                </td>
                            </tr>
                            <tr>
                            <?php

                                $ampicillin1 = null; $ampicillin2 = null;

                                if(!empty($kultur->ampicillin)) {
                                    $ampicillin = explode(' / ', $kultur->ampicillin);
                                    $ampicillin1 = $ampicillin[0];
                                    $ampicillin2 = $ampicillin[1];
                                }

                            ?>
                                <td style="width: 50%;"><label class="input-ab">&emsp;&emsp;&emsp;Ampicillin</label>
                                </td>
                                <td style="width: 25%;">
                                    <center><label
                                            class="input-ab"><?= CHtml::dropDownList('PemeriksaankulturT[ampicillin1]', $ampicillin1, LookupM::getItems('antibiotika_jenisobat'), array('empty' => ' - ', 'class' => 'span2 ab ab1', 'onkeyup' => "return $(this).focusNextInputField(event)",)); ?>
                                    </center></label>
                                </td>
                                <td>&emsp;<?php echo $form->hiddenField($kultur, 'ampicillin', array('class' => 'simpan', 'onkeypress' => "return $(this).focusNextInputField(event)", 'readonly' => true)); ?>
                                </td>
                                <td style="width: 25%;">
                                    <center><label
                                            class="input-ab"><?= CHtml::dropDownList('PemeriksaankulturT[ampicillin2]', $ampicillin2, LookupM::getItems('antibiotika_jenisobat'), array('empty' => ' - ', 'class' => 'span2 ab ab2', 'onkeyup' => "return $(this).focusNextInputField(event)",)); ?>
                                    </center></label>
                                </td>
                            </tr>
                            <tr>
                                 <?php

                                      $sulbactam1 = null; $sulbactam2 = null;

                                      if(!empty($kultur->sulbactam)) {
                                          $sulbactam = explode(' / ', $kultur->sulbactam);
                                          $sulbactam1 = $sulbactam[0];
                                          $sulbactam2 = $sulbactam[1];
                                      }

                                 ?>
                                <td style="width: 50%;"><label class="input-ab">&emsp;&emsp;&emsp;Ampicillin &
                                        Sulbact</label></td>
                                <td style="width: 25%;">
                                    <center><label
                                            class="input-ab"><?= CHtml::dropDownList('PemeriksaankulturT[sulbactam1]', $sulbactam1, LookupM::getItems('antibiotika_jenisobat'), array('empty' => ' - ', 'class' => 'span2 ab ab1', 'onkeyup' => "return $(this).focusNextInputField(event)",)); ?>
                                    </center></label>
                                </td>
                                <td>&emsp;<?php echo $form->hiddenField($kultur, 'sulbactam', array('class' => 'simpan', 'onkeypress' => "return $(this).focusNextInputField(event)", 'readonly' => true)); ?>
                                </td>
                                <td style="width: 25%;">
                                    <center><label
                                            class="input-ab"><?= CHtml::dropDownList('PemeriksaankulturT[sulbactam2]', $sulbactam2, LookupM::getItems('antibiotika_jenisobat'), array('empty' => ' - ', 'class' => 'span2 ab ab2', 'onkeyup' => "return $(this).focusNextInputField(event)",)); ?>
                                    </center></label>
                                </td>
                            </tr>
                            <tr>
                            <?php

                            $benzylpenicillin1 = null; $benzylpenicillin2 = null;

                            if(!empty($kultur->benzylpenicillin)) {
                                $benzylpenicillin = explode(' / ', $kultur->benzylpenicillin);
                                $benzylpenicillin1 = $benzylpenicillin[0];
                                $benzylpenicillin2 = $benzylpenicillin[1];
                            }

                            ?>
                                <td style="width: 50%;"><label
                                        class="input-ab">&emsp;&emsp;&emsp;Benzylpenicillin</label></td>
                                <td style="width: 25%;">
                                    <center><label
                                            class="input-ab"><?= CHtml::dropDownList('PemeriksaankulturT[benzylpenicillin1]', $benzylpenicillin1, LookupM::getItems('antibiotika_jenisobat'), array('empty' => ' - ', 'class' => 'span2 ab ab1', 'onkeyup' => "return $(this).focusNextInputField(event)",)); ?>
                                    </center></label>
                                </td>
                                <td>&emsp;<?php echo $form->hiddenField($kultur, 'benzylpenicillin', array('class' => 'simpan', 'onkeypress' => "return $(this).focusNextInputField(event)", 'readonly' => true)); ?>
                                </td>
                                <td style="width: 25%;">
                                    <center><label
                                            class="input-ab"><?= CHtml::dropDownList('PemeriksaankulturT[benzylpenicillin2]', $benzylpenicillin2, LookupM::getItems('antibiotika_jenisobat'), array('empty' => ' - ', 'class' => 'span2 ab ab2', 'onkeyup' => "return $(this).focusNextInputField(event)",)); ?>
                                    </center></label>
                                </td>
                            </tr>
                            <tr>
                            <?php

                                $piperacillin1 = null; $piperacillin2 = null;

                                if(!empty($kultur->piperacillin)) {
                                    $piperacillin = explode(' / ', $kultur->piperacillin);
                                    $piperacillin1 = $piperacillin[0];
                                    $piperacillin2 = $piperacillin[1];
                                }

                            ?>
                                <td style="width: 50%;"><label
                                        class="input-ab">&emsp;&emsp;&emsp;Piperacillin/Tazobactam</label></td>
                                <td style="width: 25%;">
                                    <center><label
                                            class="input-ab"><?= CHtml::dropDownList('PemeriksaankulturT[piperacillin1]', $piperacillin1, LookupM::getItems('antibiotika_jenisobat'), array('empty' => ' - ', 'class' => 'span2 ab ab1', 'onkeyup' => "return $(this).focusNextInputField(event)",)); ?>
                                    </center></label>
                                </td>
                                <td>&emsp;<?php echo $form->hiddenField($kultur, 'piperacillin', array('class' => 'simpan', 'onkeypress' => "return $(this).focusNextInputField(event)", 'readonly' => true)); ?>
                                </td>
                                <td style="width: 25%;">
                                    <center><label
                                            class="input-ab"><?= CHtml::dropDownList('PemeriksaankulturT[piperacillin2]', $piperacillin2, LookupM::getItems('antibiotika_jenisobat'), array('empty' => ' - ', 'class' => 'span2 ab ab2', 'onkeyup' => "return $(this).focusNextInputField(event)",)); ?>
                                    </center></label>
                                </td>
                            </tr>
                            <tr>
                            <?php

                                $cloxacillin1 = null; $cloxacillin2 = null;

                                if(!empty($kultur->cloxacillin)) {
                                    $cloxacillin = explode(' / ', $kultur->cloxacillin);
                                    $cloxacillin1 = $cloxacillin[0];
                                    $cloxacillin2 = $cloxacillin[1];
                                }
                            
                            ?>
                                <td style="width: 50%;"><label class="input-ab">&emsp;&emsp;&emsp;Cloxacillin</label>
                                </td>
                                <td style="width: 25%;">
                                    <center><label
                                            class="input-ab"><?= CHtml::dropDownList('PemeriksaankulturT[cloxacillin1]', $cloxacillin1, LookupM::getItems('antibiotika_jenisobat'), array('empty' => ' - ', 'class' => 'span2 ab ab1', 'onkeyup' => "return $(this).focusNextInputField(event)",)); ?>
                                    </center></label>
                                </td>
                                <td>&emsp;<?php echo $form->hiddenField($kultur, 'cloxacillin', array('class' => 'simpan', 'onkeypress' => "return $(this).focusNextInputField(event)", 'readonly' => true)); ?>
                                </td>
                                <td style="width: 25%;">
                                    <center><label
                                            class="input-ab"><?= CHtml::dropDownList('PemeriksaankulturT[cloxacillin2]', $cloxacillin2, LookupM::getItems('antibiotika_jenisobat'), array('empty' => ' - ', 'class' => 'span2 ab ab2', 'onkeyup' => "return $(this).focusNextInputField(event)",)); ?>
                                    </center></label>
                                </td>
                            </tr>
                            <tr>
                            <?php

                                $fosfomycin1 = null; $fosfomycin2 = null;

                                if(!empty($kultur->fosfomycin)) {
                                    $fosfomycin = explode(' / ', $kultur->fosfomycin);
                                    $fosfomycin1 = $fosfomycin[0];
                                    $fosfomycin2 = $fosfomycin[1];
                                }

                            ?>
                                <td style="width: 50%;"><label class="judul-ab">B. FOSFOMYCIN</label>
                                </td>
                                <td style="width: 25%;">
                                    <center><label
                                            class="input-ab"><?= CHtml::dropDownList('PemeriksaankulturT[fosfomycin1]', $fosfomycin1, LookupM::getItems('antibiotika_jenisobat'), array('empty' => ' - ', 'class' => 'span2 ab ab1', 'onkeyup' => "return $(this).focusNextInputField(event)",)); ?>
                                    </center></label>
                                </td>
                                <td>&emsp;<?php echo $form->hiddenField($kultur, 'fosfomycin', array('class' => 'simpan', 'onkeypress' => "return $(this).focusNextInputField(event)", 'readonly' => true)); ?>
                                </td>
                                <td style="width: 25%;">
                                    <center><label
                                            class="input-ab"><?= CHtml::dropDownList('PemeriksaankulturT[fosfomycin2]', $fosfomycin2, LookupM::getItems('antibiotika_jenisobat'), array('empty' => ' - ', 'class' => 'span2 ab ab2', 'onkeyup' => "return $(this).focusNextInputField(event)",)); ?>
                                    </center></label>
                                </td>
                            </tr>
                            <tr>
                                <td style="width: 50%;"><label class="judul-ab">C. AMINOGLYCOSIDES</label></td>
                                <td style="width: 24%;">
                                    <center><label class="judul-ab"></center></label>
                                </td>
                                <td style="width: 2%;">
                                    <center><label class="judul-ab">&emsp;</center></label>
                                </td>
                                <td style="width: 24%;">
                                    <center><label class="judul-ab"></center></label>
                                </td>
                            </tr>
                            <tr>
                            <?php

                                $gentamicin1 = null; $gentamicin2 = null;

                                if(!empty($kultur->gentamicin)) {
                                    $gentamicin = explode(' / ', $kultur->gentamicin);
                                    $gentamicin1 = $gentamicin[0];
                                    $gentamicin2 = $gentamicin[1];
                                }

                            ?>
                                <td style="width: 50%;"><label class="input-ab">&emsp;&emsp;&emsp;Gentamicin</label>
                                </td>
                                <td style="width: 25%;">
                                    <center><label
                                            class="input-ab"><?= CHtml::dropDownList('PemeriksaankulturT[gentamicin1]', $gentamicin1, LookupM::getItems('antibiotika_jenisobat'), array('empty' => ' - ', 'class' => 'span2 ab ab1', 'onkeyup' => "return $(this).focusNextInputField(event)",)); ?>
                                    </center></label>
                                </td>
                                <td>&emsp;<?php echo $form->hiddenField($kultur, 'gentamicin', array('class' => 'simpan', 'onkeypress' => "return $(this).focusNextInputField(event)", 'readonly' => true)); ?>
                                </td>
                                <td style="width: 25%;">
                                    <center><label
                                            class="input-ab"><?= CHtml::dropDownList('PemeriksaankulturT[gentamicin2]', $gentamicin2, LookupM::getItems('antibiotika_jenisobat'), array('empty' => ' - ', 'class' => 'span2 ab ab2', 'onkeyup' => "return $(this).focusNextInputField(event)",)); ?>
                                    </center></label>
                                </td>
                            </tr>
                            <tr>
                            <?php

                            $netilmicin1 = null; $netilmicin2 = null;

                            if(!empty($kultur->netilmicin)) {
                                $netilmicin = explode(' / ', $kultur->netilmicin);
                                $netilmicin1 = $netilmicin[0];
                                $netilmicin2 = $netilmicin[1];
                            }

                            ?>
                                <td style="width: 50%;"><label class="input-ab">&emsp;&emsp;&emsp;Netilmicin</label>
                                </td>
                                <td style="width: 25%;">
                                    <center><label
                                            class="input-ab"><?= CHtml::dropDownList('PemeriksaankulturT[netilmicin1]', $netilmicin1, LookupM::getItems('antibiotika_jenisobat'), array('empty' => ' - ', 'class' => 'span2 ab ab1', 'onkeyup' => "return $(this).focusNextInputField(event)",)); ?>
                                    </center></label>
                                </td>
                                <td>&emsp;<?php echo $form->hiddenField($kultur, 'netilmicin', array('class' => 'simpan', 'onkeypress' => "return $(this).focusNextInputField(event)", 'readonly' => true)); ?>
                                </td>
                                <td style="width: 25%;">
                                    <center><label
                                            class="input-ab"><?= CHtml::dropDownList('PemeriksaankulturT[netilmicin2]', $netilmicin2, LookupM::getItems('antibiotika_jenisobat'), array('empty' => ' - ', 'class' => 'span2 ab ab2', 'onkeyup' => "return $(this).focusNextInputField(event)",)); ?>
                                    </center></label>
                                </td>
                            </tr>
                            <tr>
                            <?php

                                $amikacin1 = null; $amikacin2 = null;

                                if(!empty($kultur->amikacin)) {
                                    $amikacin = explode(' / ', $kultur->amikacin);
                                    $amikacin1 = $amikacin[0];
                                    $amikacin2 = $amikacin[1];
                                }
                            ?>
                                <td style="width: 50%;"><label class="input-ab">&emsp;&emsp;&emsp;Amikacin</label>
                                </td>
                                <td style="width: 25%;">
                                    <center><label
                                            class="input-ab"><?= CHtml::dropDownList('PemeriksaankulturT[amikacin1]', $amikacin1, LookupM::getItems('antibiotika_jenisobat'), array('empty' => ' - ', 'class' => 'span2 ab ab1', 'onkeyup' => "return $(this).focusNextInputField(event)",)); ?>
                                    </center></label>
                                </td>
                                <td>&emsp;<?php echo $form->hiddenField($kultur, 'amikacin', array('class' => 'simpan', 'onkeypress' => "return $(this).focusNextInputField(event)", 'readonly' => true)); ?>
                                </td>
                                <td style="width: 25%;">
                                    <center><label
                                            class="input-ab"><?= CHtml::dropDownList('PemeriksaankulturT[amikacin2]', $amikacin2, LookupM::getItems('antibiotika_jenisobat'), array('empty' => ' - ', 'class' => 'span2 ab ab2', 'onkeyup' => "return $(this).focusNextInputField(event)",)); ?>
                                    </center></label>
                                </td>
                            </tr>
                            <tr>
                                <td style="width: 50%;"><label class="judul-ab">D. FLUOROQUINOLON</label></td>
                                <td style="width: 24%;">
                                    <center><label class="judul-ab"></center></label>
                                </td>
                                <td style="width: 2%;">
                                    <center><label class="judul-ab">&emsp;</center></label>
                                </td>
                                <td style="width: 24%;">
                                    <center><label class="judul-ab"></center></label>
                                </td>
                            </tr>
                            <tr>
                            <?php

                            $ciprofloxacin1 = null; $ciprofloxacin2 = null;

                            if(!empty($kultur->ciprofloxacin)) {
                                $ciprofloxacin = explode(' / ', $kultur->ciprofloxacin);
                                $ciprofloxacin1 = $ciprofloxacin[0];
                                $ciprofloxacin2 = $ciprofloxacin[1];
                            }

                            ?>
                                <td style="width: 50%;"><label class="input-ab">&emsp;&emsp;&emsp;Ciprofloxacin</label>
                                </td>
                                <td style="width: 25%;">
                                    <center><label
                                            class="input-ab"><?= CHtml::dropDownList('PemeriksaankulturT[ciprofloxacin1]', $ciprofloxacin1, LookupM::getItems('antibiotika_jenisobat'), array('empty' => ' - ', 'class' => 'span2 ab ab1', 'onkeyup' => "return $(this).focusNextInputField(event)",)); ?>
                                    </center></label>
                                </td>
                                <td>&emsp;<?php echo $form->hiddenField($kultur, 'ciprofloxacin', array('class' => 'simpan', 'onkeypress' => "return $(this).focusNextInputField(event)", 'readonly' => true)); ?>
                                </td>
                                <td style="width: 25%;">
                                    <center><label
                                            class="input-ab"><?= CHtml::dropDownList('PemeriksaankulturT[ciprofloxacin2]', $ciprofloxacin2, LookupM::getItems('antibiotika_jenisobat'), array('empty' => ' - ', 'class' => 'span2 ab ab2', 'onkeyup' => "return $(this).focusNextInputField(event)",)); ?>
                                    </center></label>
                                </td>
                            </tr>
                            <tr>
                            <?php

                                $ofloxacin1 = null; $ofloxacin2 = null;

                                if(!empty($kultur->ofloxacin)) {
                                    $ofloxacin = explode(' / ', $kultur->ofloxacin);
                                    $ofloxacin1 = $ofloxacin[0];
                                    $ofloxacin2 = $ofloxacin[1];
                                }

                            ?>
                                <td style="width: 50%;"><label class="input-ab">&emsp;&emsp;&emsp;Ofloxacin</label>
                                </td>
                                <td style="width: 25%;">
                                    <center><label
                                            class="input-ab"><?= CHtml::dropDownList('PemeriksaankulturT[ofloxacin1]', $ofloxacin1, LookupM::getItems('antibiotika_jenisobat'), array('empty' => ' - ', 'class' => 'span2 ab ab1', 'onkeyup' => "return $(this).focusNextInputField(event)",)); ?>
                                    </center></label>
                                </td>
                                <td>&emsp;<?php echo $form->hiddenField($kultur, 'ofloxacin', array('class' => 'simpan', 'onkeypress' => "return $(this).focusNextInputField(event)", 'readonly' => true)); ?>
                                </td>
                                <td style="width: 25%;">
                                    <center><label
                                            class="input-ab"><?= CHtml::dropDownList('PemeriksaankulturT[ofloxacin2]', $ofloxacin2, LookupM::getItems('antibiotika_jenisobat'), array('empty' => ' - ', 'class' => 'span2 ab ab2', 'onkeyup' => "return $(this).focusNextInputField(event)",)); ?>
                                    </center></label>
                                </td>
                            </tr>
                            <tr>
                            <?php

                                $levofloxacin1 = null; $levofloxacin2 = null;

                                if(!empty($kultur->levofloxacin)) {
                                    $levofloxacin = explode(' / ', $kultur->levofloxacin);
                                    $levofloxacin1 = $levofloxacin[0];
                                    $levofloxacin2 = $levofloxacin[1];
                                }

                            ?>
                                <td style="width: 50%;"><label class="input-ab">&emsp;&emsp;&emsp;Levofloxacin</label>
                                </td>
                                <td style="width: 25%;">
                                    <center><label
                                            class="input-ab"><?= CHtml::dropDownList('PemeriksaankulturT[levofloxacin1]', $levofloxacin1, LookupM::getItems('antibiotika_jenisobat'), array('empty' => ' - ', 'class' => 'span2 ab ab1', 'onkeyup' => "return $(this).focusNextInputField(event)",)); ?>
                                    </center></label>
                                </td>
                                <td>&emsp;<?php echo $form->hiddenField($kultur, 'levofloxacin', array('class' => 'simpan', 'onkeypress' => "return $(this).focusNextInputField(event)", 'readonly' => true)); ?>
                                </td>
                                <td style="width: 25%;">
                                    <center><label
                                            class="input-ab"><?= CHtml::dropDownList('PemeriksaankulturT[levofloxacin2]', $levofloxacin2, LookupM::getItems('antibiotika_jenisobat'), array('empty' => ' - ', 'class' => 'span2 ab ab2', 'onkeyup' => "return $(this).focusNextInputField(event)",)); ?>
                                    </center></label>
                                </td>
                            </tr>
                            <tr>
                            <?php

                                $moxifloxacin1 = null; $moxifloxacin2 = null;

                                if(!empty($kultur->moxifloxacin)) {
                                    $moxifloxacin = explode(' / ', $kultur->moxifloxacin);
                                    $moxifloxacin1 = $moxifloxacin[0];
                                    $moxifloxacin2 = $moxifloxacin[1];
                                }

                            ?>
                                <td style="width: 50%;"><label class="input-ab">&emsp;&emsp;&emsp;Moxifloxacin</label>
                                </td>
                                <td style="width: 25%;">
                                    <center><label
                                            class="input-ab"><?= CHtml::dropDownList('PemeriksaankulturT[moxifloxacin1]', $moxifloxacin1, LookupM::getItems('antibiotika_jenisobat'), array('empty' => ' - ', 'class' => 'span2 ab ab1', 'onkeyup' => "return $(this).focusNextInputField(event)",)); ?>
                                    </center></label>
                                </td>
                                <td>&emsp;<?php echo $form->hiddenField($kultur, 'moxifloxacin', array('class' => 'simpan', 'onkeypress' => "return $(this).focusNextInputField(event)", 'readonly' => true)); ?>
                                </td>
                                <td style="width: 25%;">
                                    <center><label
                                            class="input-ab"><?= CHtml::dropDownList('PemeriksaankulturT[moxifloxacin2]', $moxifloxacin2, LookupM::getItems('antibiotika_jenisobat'), array('empty' => ' - ', 'class' => 'span2 ab ab2', 'onkeyup' => "return $(this).focusNextInputField(event)",)); ?>
                                    </center></label>
                                </td>
                            </tr>
                            <tr>
                                <td style="width: 50%;"><label class="judul-ab">E. TETRACYLINE</label></td>
                                <td style="width: 24%;">
                                    <center><label class="judul-ab"></center></label>
                                </td>
                                <td style="width: 2%;">
                                    <center><label class="judul-ab">&emsp;</center></label>
                                </td>
                                <td style="width: 24%;">
                                    <center><label class="judul-ab"></center></label>
                                </td>
                            </tr>
                            <tr>
                            <?php

                                $tetracycline1 = null; $tetracycline2 = null;

                                if(!empty($kultur->tetracycline)) {
                                    $tetracycline = explode(' / ', $kultur->tetracycline);
                                    $tetracycline1 = $tetracycline[0];
                                    $tetracycline2 = $tetracycline[1];
                                }

                            ?>
                                <td style="width: 50%;"><label class="input-ab">&emsp;&emsp;&emsp;Tetracycline</label>
                                </td>
                                <td style="width: 25%;">
                                    <center><label
                                            class="input-ab"><?= CHtml::dropDownList('PemeriksaankulturT[tetracycline1]', $tetracycline1, LookupM::getItems('antibiotika_jenisobat'), array('empty' => ' - ', 'class' => 'span2 ab ab1', 'onkeyup' => "return $(this).focusNextInputField(event)",)); ?>
                                    </center></label>
                                </td>
                                <td>&emsp;<?php echo $form->hiddenField($kultur, 'tetracycline', array('class' => 'simpan', 'onkeypress' => "return $(this).focusNextInputField(event)", 'readonly' => true)); ?>
                                </td>
                                <td style="width: 25%;">
                                    <center><label
                                            class="input-ab"><?= CHtml::dropDownList('PemeriksaankulturT[tetracycline2]', $tetracycline2, LookupM::getItems('antibiotika_jenisobat'), array('empty' => ' - ', 'class' => 'span2 ab ab2', 'onkeyup' => "return $(this).focusNextInputField(event)",)); ?>
                                    </center></label>
                                </td>
                            </tr>
                            <tr>
                            <?php

                                $doxycycline1 = null; $doxycycline2 = null;

                                if(!empty($kultur->doxycycline)) {
                                    $doxycycline = explode(' / ', $kultur->doxycycline);
                                    $doxycycline1 = $doxycycline[0];
                                    $doxycycline2 = $doxycycline[1];
                                }

                            ?>
                                <td style="width: 50%;"><label class="input-ab">&emsp;&emsp;&emsp;Doxycycline</label>
                                </td>
                                <td style="width: 25%;">
                                    <center><label
                                            class="input-ab"><?= CHtml::dropDownList('PemeriksaankulturT[doxycycline1]', $doxycycline1, LookupM::getItems('antibiotika_jenisobat'), array('empty' => ' - ', 'class' => 'span2 ab ab1', 'onkeyup' => "return $(this).focusNextInputField(event)",)); ?>
                                    </center></label>
                                </td>
                                <td>&emsp;<?php echo $form->hiddenField($kultur, 'doxycycline', array('class' => 'simpan', 'onkeypress' => "return $(this).focusNextInputField(event)", 'readonly' => true)); ?>
                                </td>
                                <td style="width: 25%;">
                                    <center><label
                                            class="input-ab"><?= CHtml::dropDownList('PemeriksaankulturT[doxycycline2]', $doxycycline2, LookupM::getItems('antibiotika_jenisobat'), array('empty' => ' - ', 'class' => 'span2 ab ab2', 'onkeyup' => "return $(this).focusNextInputField(event)",)); ?>
                                    </center></label>
                                </td>
                            </tr>
                            <tr>
                                <td style="width: 50%;"><label class="judul-ab">F. CEPHALOSPHORIN</label></td>
                                <td style="width: 24%;">
                                    <center><label class="judul-ab"></center></label>
                                </td>
                                <td style="width: 2%;">
                                    <center><label class="judul-ab">&emsp;</center></label>
                                </td>
                                <td style="width: 24%;">
                                    <center><label class="judul-ab"></center></label>
                                </td>
                            </tr>
                            <tr>
                            <?php

                                $cefepime1 = null; $cefepime2 = null;

                                if(!empty($kultur->cefepime)) {
                                    $cefepime = explode(' / ', $kultur->cefepime);
                                    $cefepime1 = $cefepime[0];
                                    $cefepime2 = $cefepime[1];
                                }

                            ?>
                                <td style="width: 50%;"><label class="input-ab">&emsp;&emsp;&emsp;Cefepime</label>
                                </td>
                                <td style="width: 25%;">
                                    <center><label
                                            class="input-ab"><?= CHtml::dropDownList('PemeriksaankulturT[cefepime1]', $cefepime1, LookupM::getItems('antibiotika_jenisobat'), array('empty' => ' - ', 'class' => 'span2 ab ab1', 'onkeyup' => "return $(this).focusNextInputField(event)",)); ?>
                                    </center></label>
                                </td>
                                <td>&emsp;<?php echo $form->hiddenField($kultur, 'cefepime', array('class' => 'simpan', 'onkeypress' => "return $(this).focusNextInputField(event)", 'readonly' => true)); ?>
                                </td>
                                <td style="width: 25%;">
                                    <center><label
                                            class="input-ab"><?= CHtml::dropDownList('PemeriksaankulturT[cefepime2]', $cefepime2, LookupM::getItems('antibiotika_jenisobat'), array('empty' => ' - ', 'class' => 'span2 ab ab2', 'onkeyup' => "return $(this).focusNextInputField(event)",)); ?>
                                    </center></label>
                                </td>
                            </tr>
                            <tr>
                            <?php

                                $cefpirome1 = null; $cefpirome2 = null;

                                if(!empty($kultur->cefpirome)) {
                                    $cefpirome = explode(' / ', $kultur->cefpirome);
                                    $cefpirome1 = $cefpirome[0];
                                    $cefpirome2 = $cefpirome[1];
                                }

                            ?>
                                <td style="width: 50%;"><label class="input-ab">&emsp;&emsp;&emsp;Cefpirome</label>
                                </td>
                                <td style="width: 25%;">
                                    <center><label
                                            class="input-ab"><?= CHtml::dropDownList('PemeriksaankulturT[cefpirome1]', $cefpirome1, LookupM::getItems('antibiotika_jenisobat'), array('empty' => ' - ', 'class' => 'span2 ab ab1', 'onkeyup' => "return $(this).focusNextInputField(event)",)); ?>
                                    </center></label>
                                </td>
                                <td>&emsp;<?php echo $form->hiddenField($kultur, 'cefpirome', array('class' => 'simpan', 'onkeypress' => "return $(this).focusNextInputField(event)", 'readonly' => true)); ?>
                                </td>
                                <td style="width: 25%;">
                                    <center><label
                                            class="input-ab"><?= CHtml::dropDownList('PemeriksaankulturT[cefpirome2]', $cefpirome2, LookupM::getItems('antibiotika_jenisobat'), array('empty' => ' - ', 'class' => 'span2 ab ab2', 'onkeyup' => "return $(this).focusNextInputField(event)",)); ?>
                                    </center></label>
                                </td>
                            </tr>
                            <tr>
                            <?php

                                $cefoperazone1 = null; $cefoperazone2 = null;

                                if(!empty($kultur->cefoperazone)) {
                                    $cefoperazone = explode(' / ', $kultur->cefoperazone);
                                    $cefoperazone1 = $cefoperazone[0];
                                    $cefoperazone2 = $cefoperazone[1];
                                }

                            ?>
                                <td style="width: 50%;"><label class="input-ab">&emsp;&emsp;&emsp;Cefoperazone</label>
                                </td>
                                <td style="width: 25%;">
                                    <center><label
                                            class="input-ab"><?= CHtml::dropDownList('PemeriksaankulturT[cefoperazone1]', $cefoperazone1, LookupM::getItems('antibiotika_jenisobat'), array('empty' => ' - ', 'class' => 'span2 ab ab1', 'onkeyup' => "return $(this).focusNextInputField(event)",)); ?>
                                    </center></label>
                                </td>
                                <td>&emsp;<?php echo $form->hiddenField($kultur, 'cefoperazone', array('class' => 'simpan', 'onkeypress' => "return $(this).focusNextInputField(event)", 'readonly' => true)); ?>
                                </td>
                                <td style="width: 25%;">
                                    <center><label
                                            class="input-ab"><?= CHtml::dropDownList('PemeriksaankulturT[cefoperazone2]', $cefoperazone2, LookupM::getItems('antibiotika_jenisobat'), array('empty' => ' - ', 'class' => 'span2 ab ab2', 'onkeyup' => "return $(this).focusNextInputField(event)",)); ?>
                                    </center></label>
                                </td>
                            </tr>
                            <tr>
                            <?php

                                $cefoperazone_sulbactam1 = null; $cefoperazone_sulbactam2 = null;

                                if(!empty($kultur->cefoperazone_sulbactam)) {
                                    $cefoperazone_sulbactam = explode(' / ', $kultur->cefoperazone_sulbactam);
                                    $cefoperazone_sulbactam1 = $cefoperazone_sulbactam[0];
                                    $cefoperazone_sulbactam2 = $cefoperazone_sulbactam[1];
                                }

                            ?>
                                <td style="width: 50%;"><label
                                        class="input-ab">&emsp;&emsp;&emsp;Cefoperazone/Sulbactam</label>
                                </td>
                                <td style="width: 25%;">
                                    <center><label
                                            class="input-ab"><?= CHtml::dropDownList('PemeriksaankulturT[cefoperazone_sulbactam1]', $cefoperazone_sulbactam1, LookupM::getItems('antibiotika_jenisobat'), array('empty' => ' - ', 'class' => 'span2 ab ab1', 'onkeyup' => "return $(this).focusNextInputField(event)",)); ?>
                                    </center></label>
                                </td>
                                <td>&emsp;<?php echo $form->hiddenField($kultur, 'cefoperazone_sulbactam', array('class' => 'simpan', 'onkeypress' => "return $(this).focusNextInputField(event)", 'readonly' => true)); ?>
                                </td>
                                <td style="width: 25%;">
                                    <center><label
                                            class="input-ab"><?= CHtml::dropDownList('PemeriksaankulturT[cefoperazone_sulbactam2]', $cefoperazone_sulbactam2, LookupM::getItems('antibiotika_jenisobat'), array('empty' => ' - ', 'class' => 'span2 ab ab2', 'onkeyup' => "return $(this).focusNextInputField(event)",)); ?>
                                    </center></label>
                                </td>
                            </tr>
                            <tr>
                            <?php

                                $cefditoren1 = null; $cefditoren2 = null;

                                if(!empty($kultur->cefditoren)) {
                                    $cefditoren = explode(' / ', $kultur->cefditoren);
                                    $cefditoren1 = $cefditoren[0];
                                    $cefditoren2 = $cefditoren[1];
                                }

                            ?>
                                <td style="width: 50%;"><label class="input-ab">&emsp;&emsp;&emsp;Cefditoren</label>
                                </td>
                                <td style="width: 25%;">
                                    <center><label
                                            class="input-ab"><?= CHtml::dropDownList('PemeriksaankulturT[cefditoren1]', $cefditoren1, LookupM::getItems('antibiotika_jenisobat'), array('empty' => ' - ', 'class' => 'span2 ab ab1', 'onkeyup' => "return $(this).focusNextInputField(event)",)); ?>
                                    </center></label>
                                </td>
                                <td>&emsp;<?php echo $form->hiddenField($kultur, 'cefditoren', array('class' => 'simpan', 'onkeypress' => "return $(this).focusNextInputField(event)", 'readonly' => true)); ?>
                                </td>
                                <td style="width: 25%;">
                                    <center><label
                                            class="input-ab"><?= CHtml::dropDownList('PemeriksaankulturT[cefditoren2]', $cefditoren2, LookupM::getItems('antibiotika_jenisobat'), array('empty' => ' - ', 'class' => 'span2 ab ab2', 'onkeyup' => "return $(this).focusNextInputField(event)",)); ?>
                                    </center></label>
                                </td>
                            </tr>
                            <tr>
                            <?php

                                $cefadroxil1 = null; $cefadroxil2 = null;
                                                            
                                if(!empty($kultur->cefadroxil)) {
                                    $cefadroxil = explode(' / ', $kultur->cefadroxil);
                                    $cefadroxil1 = $cefadroxil[0];
                                    $cefadroxil2 = $cefadroxil[1];
                                }
                                
                                ?>
                                <td style="width: 50%;"><label class="input-ab">&emsp;&emsp;&emsp;Cefadroxil</label>
                                </td>
                                <td style="width: 25%;">
                                    <center><label
                                            class="input-ab"><?= CHtml::dropDownList('PemeriksaankulturT[cefadroxil1]', $cefadroxil1, LookupM::getItems('antibiotika_jenisobat'), array('empty' => ' - ', 'class' => 'span2 ab ab1', 'onkeyup' => "return $(this).focusNextInputField(event)",)); ?>
                                    </center></label>
                                </td>
                                <td>&emsp;<?php echo $form->hiddenField($kultur, 'cefadroxil', array('class' => 'simpan', 'onkeypress' => "return $(this).focusNextInputField(event)", 'readonly' => true)); ?>
                                </td>
                                <td style="width: 25%;">
                                    <center><label
                                            class="input-ab"><?= CHtml::dropDownList('PemeriksaankulturT[cefadroxil2]', $cefadroxil2, LookupM::getItems('antibiotika_jenisobat'), array('empty' => ' - ', 'class' => 'span2 ab ab2', 'onkeyup' => "return $(this).focusNextInputField(event)",)); ?>
                                    </center></label>
                                </td>
                            </tr>
                            <tr>
                            <?php

                                $cefotaxim1 = null; $cefotaxim2 = null;

                                if(!empty($kultur->cefotaxim)) {
                                    $cefotaxim = explode(' / ', $kultur->cefotaxim);
                                    $cefotaxim1 = $cefotaxim[0];
                                    $cefotaxim2 = $cefotaxim[1];
                                }

                                ?>

                                <td style="width: 50%;"><label class="input-ab">&emsp;&emsp;&emsp;Cefotaxim</label>
                                </td>
                                <td style="width: 25%;">
                                    <center><label
                                            class="input-ab"><?= CHtml::dropDownList('PemeriksaankulturT[cefotaxim1]', $cefotaxim1, LookupM::getItems('antibiotika_jenisobat'), array('empty' => ' - ', 'class' => 'span2 ab ab1', 'onkeyup' => "return $(this).focusNextInputField(event)",)); ?>
                                    </center></label>
                                </td>
                                <td>&emsp;<?php echo $form->hiddenField($kultur, 'cefotaxim', array('class' => 'simpan', 'onkeypress' => "return $(this).focusNextInputField(event)", 'readonly' => true)); ?>
                                </td>
                                <td style="width: 25%;">
                                    <center><label
                                            class="input-ab"><?= CHtml::dropDownList('PemeriksaankulturT[cefotaxim2]', $cefotaxim2, LookupM::getItems('antibiotika_jenisobat'), array('empty' => ' - ', 'class' => 'span2 ab ab2', 'onkeyup' => "return $(this).focusNextInputField(event)",)); ?>
                                    </center></label>
                                </td>
                            </tr>
                            <tr>
                            <?php

                                $ceftriaxone1 = null; $ceftriaxone2 = null;

                                if(!empty($kultur->ceftriaxone)) {
                                    $ceftriaxone = explode(' / ', $kultur->ceftriaxone);
                                    $ceftriaxone1 = $ceftriaxone[0];
                                    $ceftriaxone2 = $ceftriaxone[1];
                                }

                                ?>
                                <td style="width: 50%;"><label class="input-ab">&emsp;&emsp;&emsp;Ceftriaxone</label>
                                </td>
                                <td style="width: 25%;">
                                    <center><label
                                            class="input-ab"><?= CHtml::dropDownList('PemeriksaankulturT[ceftriaxone1]', $ceftriaxone1, LookupM::getItems('antibiotika_jenisobat'), array('empty' => ' - ', 'class' => 'span2 ab ab1', 'onkeyup' => "return $(this).focusNextInputField(event)",)); ?>
                                    </center></label>
                                </td>
                                <td>&emsp;<?php echo $form->hiddenField($kultur, 'ceftriaxone', array('class' => 'simpan', 'onkeypress' => "return $(this).focusNextInputField(event)", 'readonly' => true)); ?>
                                </td>
                                <td style="width: 25%;">
                                    <center><label
                                            class="input-ab"><?= CHtml::dropDownList('PemeriksaankulturT[ceftriaxone2]', $ceftriaxone2, LookupM::getItems('antibiotika_jenisobat'), array('empty' => ' - ', 'class' => 'span2 ab ab2', 'onkeyup' => "return $(this).focusNextInputField(event)",)); ?>
                                    </center></label>
                                </td>
                            </tr>
                            <tr>
                            <?php

                                $cefuroxime1 = null; $cefuroxime2 = null;

                                if(!empty($kultur->cefuroxime)) {
                                    $cefuroxime = explode(' / ', $kultur->cefuroxime);
                                    $cefuroxime1 = $cefuroxime[0];
                                    $cefuroxime2 = $cefuroxime[1];
                                }

                                ?>
                                <td style="width: 50%;"><label class="input-ab">&emsp;&emsp;&emsp;Cefuroxime</label>
                                </td>
                                <td style="width: 25%;">
                                    <center><label
                                            class="input-ab"><?= CHtml::dropDownList('PemeriksaankulturT[cefuroxime1]', $cefuroxime1, LookupM::getItems('antibiotika_jenisobat'), array('empty' => ' - ', 'class' => 'span2 ab ab1', 'onkeyup' => "return $(this).focusNextInputField(event)",)); ?>
                                    </center></label>
                                </td>
                                <td>&emsp;<?php echo $form->hiddenField($kultur, 'cefuroxime', array('class' => 'simpan', 'onkeypress' => "return $(this).focusNextInputField(event)", 'readonly' => true)); ?>
                                </td>
                                <td style="width: 25%;">
                                    <center><label
                                            class="input-ab"><?= CHtml::dropDownList('PemeriksaankulturT[cefuroxime2]', $cefuroxime2, LookupM::getItems('antibiotika_jenisobat'), array('empty' => ' - ', 'class' => 'span2 ab ab2', 'onkeyup' => "return $(this).focusNextInputField(event)",)); ?>
                                    </center></label>
                                </td>
                            </tr>
                            <tr>
                            <?php

                                $cefradine1 = null; $cefradine2 = null;

                                if(!empty($kultur->cefradine)) {
                                    $cefradine = explode(' / ', $kultur->cefradine);
                                    $cefradine1 = $cefradine[0];
                                    $cefradine2 = $cefradine[1];
                                }

                                ?>
                                <td style="width: 50%;"><label class="input-ab">&emsp;&emsp;&emsp;Cefradine</label>
                                </td>
                                <td style="width: 25%;">
                                    <center><label
                                            class="input-ab"><?= CHtml::dropDownList('PemeriksaankulturT[cefradine1]', $cefradine1, LookupM::getItems('antibiotika_jenisobat'), array('empty' => ' - ', 'class' => 'span2 ab ab1', 'onkeyup' => "return $(this).focusNextInputField(event)",)); ?>
                                    </center></label>
                                </td>
                                <td>&emsp;<?php echo $form->hiddenField($kultur, 'cefradine', array('class' => 'simpan', 'onkeypress' => "return $(this).focusNextInputField(event)", 'readonly' => true)); ?>
                                </td>
                                <td style="width: 25%;">
                                    <center><label
                                            class="input-ab"><?= CHtml::dropDownList('PemeriksaankulturT[cefradine2]', $cefradine2, LookupM::getItems('antibiotika_jenisobat'), array('empty' => ' - ', 'class' => 'span2 ab ab2', 'onkeyup' => "return $(this).focusNextInputField(event)",)); ?>
                                    </center></label>
                                </td>
                            </tr>
                            <tr>
                            <?php

                                $cefalexin1 = null; $cefalexin2 = null;

                                if(!empty($kultur->cefalexin)) {
                                    $cefalexin = explode(' / ', $kultur->cefalexin);
                                    $cefalexin1 = $cefalexin[0];
                                    $cefalexin2 = $cefalexin[1];
                                }

                                ?>
                                <td style="width: 50%;"><label class="input-ab">&emsp;&emsp;&emsp;Cefalexin</label>
                                </td>
                                <td style="width: 25%;">
                                    <center><label
                                            class="input-ab"><?= CHtml::dropDownList('PemeriksaankulturT[cefalexin1]', $cefalexin1, LookupM::getItems('antibiotika_jenisobat'), array('empty' => ' - ', 'class' => 'span2 ab ab1', 'onkeyup' => "return $(this).focusNextInputField(event)",)); ?>
                                    </center></label>
                                </td>
                                <td>&emsp;<?php echo $form->hiddenField($kultur, 'cefalexin', array('class' => 'simpan', 'onkeypress' => "return $(this).focusNextInputField(event)", 'readonly' => true)); ?>
                                </td>
                                <td style="width: 25%;">
                                    <center><label
                                            class="input-ab"><?= CHtml::dropDownList('PemeriksaankulturT[cefalexin2]', $cefalexin2, LookupM::getItems('antibiotika_jenisobat'), array('empty' => ' - ', 'class' => 'span2 ab ab2', 'onkeyup' => "return $(this).focusNextInputField(event)",)); ?>
                                    </center></label>
                                </td>
                            </tr>
                            <tr>
                            <?php

                                $cefazoline1 = null; $cefazoline2 = null;

                                if(!empty($kultur->cefazoline)) {
                                    $cefazoline = explode(' / ', $kultur->cefazoline);
                                    $cefazoline1 = $cefazoline[0];
                                    $cefazoline2 = $cefazoline[1];
                                }

                                ?>
                                <td style="width: 50%;"><label class="input-ab">&emsp;&emsp;&emsp;Cefazoline</label>
                                </td>
                                <td style="width: 25%;">
                                    <center><label
                                            class="input-ab"><?= CHtml::dropDownList('PemeriksaankulturT[cefazoline1]', $cefazoline1, LookupM::getItems('antibiotika_jenisobat'), array('empty' => ' - ', 'class' => 'span2 ab ab1', 'onkeyup' => "return $(this).focusNextInputField(event)",)); ?>
                                    </center></label>
                                </td>
                                <td>&emsp;<?php echo $form->hiddenField($kultur, 'cefazoline', array('class' => 'simpan', 'onkeypress' => "return $(this).focusNextInputField(event)", 'readonly' => true)); ?>
                                </td>
                                <td style="width: 25%;">
                                    <center><label
                                            class="input-ab"><?= CHtml::dropDownList('PemeriksaankulturT[cefazoline2]', $cefazoline2, LookupM::getItems('antibiotika_jenisobat'), array('empty' => ' - ', 'class' => 'span2 ab ab2', 'onkeyup' => "return $(this).focusNextInputField(event)",)); ?>
                                    </center></label>
                                </td>
                            </tr>
                            <tr>
                            <?php

                                $cefixime1 = null; $cefixime2 = null;

                                if(!empty($kultur->cefixime)) {
                                    $cefixime = explode(' / ', $kultur->cefixime);
                                    $cefixime1 = $cefixime[0];
                                    $cefixime2 = $cefixime[1];
                                }

                                ?>
                                <td style="width: 50%;"><label class="input-ab">&emsp;&emsp;&emsp;Cefixime</label>
                                </td>
                                <td style="width: 25%;">
                                    <center><label
                                            class="input-ab"><?= CHtml::dropDownList('PemeriksaankulturT[cefixime1]', $cefixime1, LookupM::getItems('antibiotika_jenisobat'), array('empty' => ' - ', 'class' => 'span2 ab ab1', 'onkeyup' => "return $(this).focusNextInputField(event)",)); ?>
                                    </center></label>
                                </td>
                                <td>&emsp;<?php echo $form->hiddenField($kultur, 'cefixime', array('class' => 'simpan', 'onkeypress' => "return $(this).focusNextInputField(event)", 'readonly' => true)); ?>
                                </td>
                                <td style="width: 25%;">
                                    <center><label
                                            class="input-ab"><?= CHtml::dropDownList('PemeriksaankulturT[cefixime2]', $cefixime2, LookupM::getItems('antibiotika_jenisobat'), array('empty' => ' - ', 'class' => 'span2 ab ab2', 'onkeyup' => "return $(this).focusNextInputField(event)",)); ?>
                                    </center></label>
                                </td>
                            </tr>
                            <tr>
                            <?php

                                $ceftazidime1 = null; $ceftazidime2 = null;

                                if(!empty($kultur->ceftazidime)) {
                                    $ceftazidime = explode(' / ', $kultur->ceftazidime);
                                    $ceftazidime1 = $ceftazidime[0];
                                    $ceftazidime2 = $ceftazidime[1];
                                }

                                ?>
                                <td style="width: 50%;"><label class="input-ab">&emsp;&emsp;&emsp;Ceftazidime</label>
                                </td>
                                <td style="width: 25%;">
                                    <center><label
                                            class="input-ab"><?= CHtml::dropDownList('PemeriksaankulturT[ceftazidime1]', $ceftazidime1, LookupM::getItems('antibiotika_jenisobat'), array('empty' => ' - ', 'class' => 'span2 ab ab1', 'onkeyup' => "return $(this).focusNextInputField(event)",)); ?>
                                    </center></label>
                                </td>
                                <td>&emsp;<?php echo $form->hiddenField($kultur, 'ceftazidime', array('class' => 'simpan', 'onkeypress' => "return $(this).focusNextInputField(event)", 'readonly' => true)); ?>
                                </td>
                                <td style="width: 25%;">
                                    <center><label
                                            class="input-ab"><?= CHtml::dropDownList('PemeriksaankulturT[ceftazidime2]', $ceftazidime2, LookupM::getItems('antibiotika_jenisobat'), array('empty' => ' - ', 'class' => 'span2 ab ab2', 'onkeyup' => "return $(this).focusNextInputField(event)",)); ?>
                                    </center></label>
                                </td>
                            </tr>
                            <tr>
                            <?php

                                $ceftizoxime1 = null; $ceftizoxime2 = null;

                                if(!empty($kultur->ceftizoxime)) {
                                    $ceftizoxime = explode(' / ', $kultur->ceftizoxime);
                                    $ceftizoxime1 = $ceftizoxime[0];
                                    $ceftizoxime2 = $ceftizoxime[1];
                                }

                                ?>
                                <td style="width: 50%;"><label class="input-ab">&emsp;&emsp;&emsp;Ceftizoxime</label>
                                </td>
                                <td style="width: 25%;">
                                    <center><label
                                            class="input-ab"><?= CHtml::dropDownList('PemeriksaankulturT[ceftizoxime1]', $ceftizoxime1, LookupM::getItems('antibiotika_jenisobat'), array('empty' => ' - ', 'class' => 'span2 ab ab1', 'onkeyup' => "return $(this).focusNextInputField(event)",)); ?>
                                    </center></label>
                                </td>
                                <td>&emsp;<?php echo $form->hiddenField($kultur, 'ceftizoxime', array('class' => 'simpan', 'onkeypress' => "return $(this).focusNextInputField(event)", 'readonly' => true)); ?>
                                </td>
                                <td style="width: 25%;">
                                    <center><label
                                            class="input-ab"><?= CHtml::dropDownList('PemeriksaankulturT[ceftizoxime2]', $ceftizoxime2, LookupM::getItems('antibiotika_jenisobat'), array('empty' => ' - ', 'class' => 'span2 ab ab2', 'onkeyup' => "return $(this).focusNextInputField(event)",)); ?>
                                    </center></label>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-sm-6">
                        <table style="width: 75%;">
                            <tr>
                                <td style="width: 50%;"><label class="judul-ab">G. CARBAPENEM</label></td>
                                <td style="width: 24%;">
                                    <center><label class="judul-ab">1</center></label>
                                </td>
                                <td style="width: 2%;">
                                    <center><label class="judul-ab">&emsp;</center></label>
                                </td>
                                <td style="width: 24%;">
                                    <center><label class="judul-ab">2</center></label>
                                </td>
                            </tr>
                            <tr>
                            <?php

                                $meropenem1 = null; $meropenem2 = null;

                                if(!empty($kultur->meropenem)) {
                                    $meropenem = explode(' / ', $kultur->meropenem);
                                    $meropenem1 = $meropenem[0];
                                    $meropenem2 = $meropenem[1];
                                }

                                ?>
                                <td style="width: 50%;"><label class="input-ab">&emsp;&emsp;&emsp;Meropenem</label>
                                </td>
                                <td style="width: 25%;">
                                    <center><label
                                            class="input-ab"><?= CHtml::dropDownList('PemeriksaankulturT[meropenem1]', $meropenem1, LookupM::getItems('antibiotika_jenisobat'), array('empty' => ' - ', 'class' => 'span2 ab ab1', 'onkeyup' => "return $(this).focusNextInputField(event)",)); ?>
                                    </center></label>
                                </td>
                                <td>&emsp;<?php echo $form->hiddenField($kultur, 'meropenem', array('class' => 'simpan', 'onkeypress' => "return $(this).focusNextInputField(event)", 'readonly' => true)); ?>
                                </td>
                                <td style="width: 25%;">
                                    <center><label
                                            class="input-ab"><?= CHtml::dropDownList('PemeriksaankulturT[meropenem2]', $meropenem2, LookupM::getItems('antibiotika_jenisobat'), array('empty' => ' - ', 'class' => 'span2 ab ab2', 'onkeyup' => "return $(this).focusNextInputField(event)",)); ?>
                                    </center></label>
                                </td>
                            </tr>
                            <tr>
                            <?php

                                $imipenem1 = null; $imipenem2 = null;

                                if(!empty($kultur->imipenem)) {
                                    $imipenem = explode(' / ', $kultur->imipenem);
                                    $imipenem1 = $imipenem[0];
                                    $imipenem2 = $imipenem[1];
                                }

                                ?>
                                <td style="width: 50%;"><label class="input-ab">&emsp;&emsp;&emsp;Imipenem</label>
                                </td>
                                <td style="width: 25%;">
                                    <center><label
                                            class="input-ab"><?= CHtml::dropDownList('PemeriksaankulturT[imipenem1]', $imipenem1, LookupM::getItems('antibiotika_jenisobat'), array('empty' => ' - ', 'class' => 'span2 ab ab1', 'onkeyup' => "return $(this).focusNextInputField(event)",)); ?>
                                    </center></label>
                                </td>
                                <td>&emsp;<?php echo $form->hiddenField($kultur, 'imipenem', array('class' => 'simpan', 'onkeypress' => "return $(this).focusNextInputField(event)", 'readonly' => true)); ?>
                                </td>
                                <td style="width: 25%;">
                                    <center><label
                                            class="input-ab"><?= CHtml::dropDownList('PemeriksaankulturT[imipenem2]', $imipenem2, LookupM::getItems('antibiotika_jenisobat'), array('empty' => ' - ', 'class' => 'span2 ab ab2', 'onkeyup' => "return $(this).focusNextInputField(event)",)); ?>
                                    </center></label>
                                </td>
                            </tr>
                            <tr>
                            <?php

                                $doripenem1 = null; $doripenem2 = null;

                                if(!empty($kultur->doripenem)) {
                                    $doripenem = explode(' / ', $kultur->doripenem);
                                    $doripenem1 = $doripenem[0];
                                    $doripenem2 = $doripenem[1];
                                }

                                ?>
                                <td style="width: 50%;"><label class="input-ab">&emsp;&emsp;&emsp;Doripenem</label>
                                </td>
                                <td style="width: 25%;">
                                    <center><label
                                            class="input-ab"><?= CHtml::dropDownList('PemeriksaankulturT[doripenem1]', $doripenem1, LookupM::getItems('antibiotika_jenisobat'), array('empty' => ' - ', 'class' => 'span2 ab ab1', 'onkeyup' => "return $(this).focusNextInputField(event)",)); ?>
                                    </center></label>
                                </td>
                                <td>&emsp;<?php echo $form->hiddenField($kultur, 'doripenem', array('class' => 'simpan', 'onkeypress' => "return $(this).focusNextInputField(event)", 'readonly' => true)); ?>
                                </td>
                                <td style="width: 25%;">
                                    <center><label
                                            class="input-ab"><?= CHtml::dropDownList('PemeriksaankulturT[doripenem2]', $doripenem2, LookupM::getItems('antibiotika_jenisobat'), array('empty' => ' - ', 'class' => 'span2 ab ab2', 'onkeyup' => "return $(this).focusNextInputField(event)",)); ?>
                                    </center></label>
                                </td>
                            </tr>
                            <tr>
                            <?php

                                $ertapenem1 = null; $ertapenem2 = null;

                                if(!empty($kultur->ertapenem)) {
                                    $ertapenem = explode(' / ', $kultur->ertapenem);
                                    $ertapenem1 = $ertapenem[0];
                                    $ertapenem2 = $ertapenem[1];
                                }

                                ?>
                                <td style="width: 50%;"><label class="input-ab">&emsp;&emsp;&emsp;Ertapenem</label>
                                </td>
                                <td style="width: 25%;">
                                    <center><label
                                            class="input-ab"><?= CHtml::dropDownList('PemeriksaankulturT[ertapenem1]', $ertapenem1, LookupM::getItems('antibiotika_jenisobat'), array('empty' => ' - ', 'class' => 'span2 ab ab1', 'onkeyup' => "return $(this).focusNextInputField(event)",)); ?>
                                    </center></label>
                                </td>
                                <td>&emsp;<?php echo $form->hiddenField($kultur, 'ertapenem', array('class' => 'simpan', 'onkeypress' => "return $(this).focusNextInputField(event)", 'readonly' => true)); ?>
                                </td>
                                <td style="width: 25%;">
                                    <center><label
                                            class="input-ab"><?= CHtml::dropDownList('PemeriksaankulturT[ertapenem2]', $ertapenem2, LookupM::getItems('antibiotika_jenisobat'), array('empty' => ' - ', 'class' => 'span2 ab ab2', 'onkeyup' => "return $(this).focusNextInputField(event)",)); ?>
                                    </center></label>
                                </td>
                            </tr>
                            <tr>
                            <?php

                                $metronidazole1 = null; $metronidazole2 = null;

                                if(!empty($kultur->metronidazole)) {
                                    $metronidazole = explode(' / ', $kultur->metronidazole);
                                    $metronidazole1 = $metronidazole[0];
                                    $metronidazole2 = $metronidazole[1];
                                }

                                ?>
                                <td style="width: 50%;"><label class="judul-ab">H. METRONIDAZOLE</label></td>
                                <td style="width: 25%;">
                                    <center><label
                                            class="input-ab"><?= CHtml::dropDownList('PemeriksaankulturT[metronidazole1]', $metronidazole1, LookupM::getItems('antibiotika_jenisobat'), array('empty' => ' - ', 'class' => 'span2 ab ab1', 'onkeyup' => "return $(this).focusNextInputField(event)",)); ?>
                                    </center></label>
                                </td>
                                <td>&emsp;<?php echo $form->hiddenField($kultur, 'metronidazole', array('class' => 'simpan', 'onkeypress' => "return $(this).focusNextInputField(event)", 'readonly' => true)); ?>
                                </td>
                                <td style="width: 25%;">
                                    <center><label
                                            class="input-ab"><?= CHtml::dropDownList('PemeriksaankulturT[metronidazole2]', $metronidazole2, LookupM::getItems('antibiotika_jenisobat'), array('empty' => ' - ', 'class' => 'span2 ab ab2', 'onkeyup' => "return $(this).focusNextInputField(event)",)); ?>
                                    </center></label>
                                </td>
                            </tr>
                            <tr>
                                <td style="width: 50%;"><label class="judul-ab">I. MACROLIDES</label></td>
                                <td style="width: 24%;">
                                    <center><label class="judul-ab"></center></label>
                                </td>
                                <td style="width: 2%;">
                                    <center><label class="judul-ab">&emsp;</center></label>
                                </td>
                                <td style="width: 24%;">
                                    <center><label class="judul-ab"></center></label>
                                </td>
                            </tr>
                            <tr>
                            <?php

                                $erythromycin1 = null; $erythromycin2 = null;

                                if(!empty($kultur->erythromycin)) {
                                    $erythromycin = explode(' / ', $kultur->erythromycin);
                                    $erythromycin1 = $erythromycin[0];
                                    $erythromycin2 = $erythromycin[1];
                                }

                                ?>
                                <td style="width: 50%;"><label class="input-ab">&emsp;&emsp;&emsp;Erythromycin</label>
                                </td>
                                <td style="width: 25%;">
                                    <center><label
                                            class="input-ab"><?= CHtml::dropDownList('PemeriksaankulturT[erythromycin1]', $erythromycin1, LookupM::getItems('antibiotika_jenisobat'), array('empty' => ' - ', 'class' => 'span2 ab ab1', 'onkeyup' => "return $(this).focusNextInputField(event)",)); ?>
                                    </center></label>
                                </td>
                                <td>&emsp;<?php echo $form->hiddenField($kultur, 'erythromycin', array('class' => 'simpan', 'onkeypress' => "return $(this).focusNextInputField(event)", 'readonly' => true)); ?>
                                </td>
                                <td style="width: 25%;">
                                    <center><label
                                            class="input-ab"><?= CHtml::dropDownList('PemeriksaankulturT[erythromycin2]', $erythromycin2, LookupM::getItems('antibiotika_jenisobat'), array('empty' => ' - ', 'class' => 'span2 ab ab2', 'onkeyup' => "return $(this).focusNextInputField(event)",)); ?>
                                    </center></label>
                                </td>
                            </tr>
                            <tr>
                            <?php

                                $lincomycin1 = null; $lincomycin2 = null;

                                if(!empty($kultur->lincomycin)) {
                                    $lincomycin = explode(' / ', $kultur->lincomycin);
                                    $lincomycin1 = $lincomycin[0];
                                    $lincomycin2 = $lincomycin[1];
                                }

                                ?>

                                <td style="width: 50%;"><label class="input-ab">&emsp;&emsp;&emsp;Lincomycin</label>
                                </td>
                                <td style="width: 25%;">
                                    <center><label
                                            class="input-ab"><?= CHtml::dropDownList('PemeriksaankulturT[lincomycin1]', $lincomycin1, LookupM::getItems('antibiotika_jenisobat'), array('empty' => ' - ', 'class' => 'span2 ab ab1', 'onkeyup' => "return $(this).focusNextInputField(event)",)); ?>
                                    </center></label>
                                </td>
                                <td>&emsp;<?php echo $form->hiddenField($kultur, 'lincomycin', array('class' => 'simpan', 'onkeypress' => "return $(this).focusNextInputField(event)", 'readonly' => true)); ?>
                                </td>
                                <td style="width: 25%;">
                                    <center><label
                                            class="input-ab"><?= CHtml::dropDownList('PemeriksaankulturT[lincomycin2]', $lincomycin2, LookupM::getItems('antibiotika_jenisobat'), array('empty' => ' - ', 'class' => 'span2 ab ab2', 'onkeyup' => "return $(this).focusNextInputField(event)",)); ?>
                                    </center></label>
                                </td>
                            </tr>
                            <tr>
                            <?php

                                $clindamycin1 = null; $clindamycin2 = null;

                                if(!empty($kultur->clindamycin)) {
                                    $clindamycin = explode(' / ', $kultur->clindamycin);
                                    $clindamycin1 = $clindamycin[0];
                                    $clindamycin2 = $clindamycin[1];
                                }

                                ?>
                                <td style="width: 50%;"><label class="input-ab">&emsp;&emsp;&emsp;Clindamycin</label>
                                </td>
                                <td style="width: 25%;">
                                    <center><label
                                            class="input-ab"><?= CHtml::dropDownList('PemeriksaankulturT[clindamycin1]', $clindamycin1, LookupM::getItems('antibiotika_jenisobat'), array('empty' => ' - ', 'class' => 'span2 ab ab1', 'onkeyup' => "return $(this).focusNextInputField(event)",)); ?>
                                    </center></label>
                                </td>
                                <td>&emsp;<?php echo $form->hiddenField($kultur, 'clindamycin', array('class' => 'simpan', 'onkeypress' => "return $(this).focusNextInputField(event)", 'readonly' => true)); ?>
                                </td>
                                <td style="width: 25%;">
                                    <center><label
                                            class="input-ab"><?= CHtml::dropDownList('PemeriksaankulturT[clindamycin2]', $clindamycin2, LookupM::getItems('antibiotika_jenisobat'), array('empty' => ' - ', 'class' => 'span2 ab ab2', 'onkeyup' => "return $(this).focusNextInputField(event)",)); ?>
                                    </center></label>
                                </td>
                            </tr>
                            <tr>
                            <?php

                                $czithromycin1 = null; $czithromycin2 = null;

                                if(!empty($kultur->czithromycin)) {
                                    $czithromycin = explode(' / ', $kultur->czithromycin);
                                    $czithromycin1 = $czithromycin[0];
                                    $czithromycin2 = $czithromycin[1];
                                }

                                ?>
                                <td style="width: 50%;"><label class="input-ab">&emsp;&emsp;&emsp;Azithromycin</label>
                                </td>
                                <td style="width: 25%;">
                                    <center><label
                                            class="input-ab"><?= CHtml::dropDownList('PemeriksaankulturT[czithromycin1]', $czithromycin1, LookupM::getItems('antibiotika_jenisobat'), array('empty' => ' - ', 'class' => 'span2 ab ab1', 'onkeyup' => "return $(this).focusNextInputField(event)",)); ?>
                                    </center></label>
                                </td>
                                <td>&emsp;<?php echo $form->hiddenField($kultur, 'czithromycin', array('class' => 'simpan', 'onkeypress' => "return $(this).focusNextInputField(event)", 'readonly' => true)); ?>
                                </td>
                                <td style="width: 25%;">
                                    <center><label
                                            class="input-ab"><?= CHtml::dropDownList('PemeriksaankulturT[czithromycin2]', $czithromycin2, LookupM::getItems('antibiotika_jenisobat'), array('empty' => ' - ', 'class' => 'span2 ab ab2', 'onkeyup' => "return $(this).focusNextInputField(event)",)); ?>
                                    </center></label>
                                </td>
                            </tr>
                            <tr>
                            <?php

                                $clarithromycin1 = null; $clarithromycin2 = null;

                                if(!empty($kultur->clarithromycin)) {
                                    $clarithromycin = explode(' / ', $kultur->clarithromycin);
                                    $clarithromycin1 = $clarithromycin[0];
                                    $clarithromycin2 = $clarithromycin[1];
                                }

                                ?>
                                <td style="width: 50%;"><label class="input-ab">&emsp;&emsp;&emsp;Clarithromycin</label>
                                </td>
                                <td style="width: 25%;">
                                    <center><label
                                            class="input-ab"><?= CHtml::dropDownList('PemeriksaankulturT[clarithromycin1]', $clarithromycin1, LookupM::getItems('antibiotika_jenisobat'), array('empty' => ' - ', 'class' => 'span2 ab ab1', 'onkeyup' => "return $(this).focusNextInputField(event)",)); ?>
                                    </center></label>
                                </td>
                                <td>&emsp;<?php echo $form->hiddenField($kultur, 'clarithromycin', array('class' => 'simpan', 'onkeypress' => "return $(this).focusNextInputField(event)", 'readonly' => true)); ?>
                                </td>
                                <td style="width: 25%;">
                                    <center><label
                                            class="input-ab"><?= CHtml::dropDownList('PemeriksaankulturT[clarithromycin2]', $clarithromycin2, LookupM::getItems('antibiotika_jenisobat'), array('empty' => ' - ', 'class' => 'span2 ab ab2', 'onkeyup' => "return $(this).focusNextInputField(event)",)); ?>
                                    </center></label>
                                </td>
                            </tr>
                            <tr>
                            <?php

                                $tobramycin1 = null; $tobramycin2 = null;

                                if(!empty($kultur->tobramycin)) {
                                    $tobramycin = explode(' / ', $kultur->tobramycin);
                                    $tobramycin1 = $tobramycin[0];
                                    $tobramycin2 = $tobramycin[1];
                                }

                                ?>
                                <td style="width: 50%;"><label class="input-ab">&emsp;&emsp;&emsp;Tobramycin</label>
                                </td>
                                <td style="width: 25%;">
                                    <center><label
                                            class="input-ab"><?= CHtml::dropDownList('PemeriksaankulturT[tobramycin1]', $tobramycin1, LookupM::getItems('antibiotika_jenisobat'), array('empty' => ' - ', 'class' => 'span2 ab ab1', 'onkeyup' => "return $(this).focusNextInputField(event)",)); ?>
                                    </center></label>
                                </td>
                                <td>&emsp;<?php echo $form->hiddenField($kultur, 'tobramycin', array('class' => 'simpan', 'onkeypress' => "return $(this).focusNextInputField(event)", 'readonly' => true)); ?>
                                </td>
                                <td style="width: 25%;">
                                    <center><label
                                            class="input-ab"><?= CHtml::dropDownList('PemeriksaankulturT[tobramycin2]', $tobramycin2, LookupM::getItems('antibiotika_jenisobat'), array('empty' => ' - ', 'class' => 'span2 ab ab2', 'onkeyup' => "return $(this).focusNextInputField(event)",)); ?>
                                    </center></label>
                                </td>
                            </tr>
                            <tr>
                                <td style="width: 50%;"><label class="judul-ab">J. LAIN-LAIN</label></td>
                                <td style="width: 24%;">
                                    <center><label class="judul-ab"></center></label>
                                </td>
                                <td style="width: 2%;">
                                    <center><label class="judul-ab">&emsp;</center></label>
                                </td>
                                <td style="width: 24%;">
                                    <center><label class="judul-ab"></center></label>
                                </td>
                            </tr>
                            <tr>
                            <?php

                                $chloramphenicol1 = null; $chloramphenicol2 = null;

                                if(!empty($kultur->chloramphenicol)) {
                                    $chloramphenicol = explode(' / ', $kultur->chloramphenicol);
                                    $chloramphenicol1 = $chloramphenicol[0];
                                    $chloramphenicol2 = $chloramphenicol[1];
                                }

                                ?>
                                <td style="width: 50%;"><label
                                        class="input-ab">&emsp;&emsp;&emsp;Chloramphenicol</label></td>
                                <td style="width: 25%;">
                                    <center><label
                                            class="input-ab"><?= CHtml::dropDownList('PemeriksaankulturT[chloramphenicol1]', $chloramphenicol1, LookupM::getItems('antibiotika_jenisobat'), array('empty' => ' - ', 'class' => 'span2 ab ab1', 'onkeyup' => "return $(this).focusNextInputField(event)",)); ?>
                                    </center></label>
                                </td>
                                <td>&emsp;<?php echo $form->hiddenField($kultur, 'chloramphenicol', array('class' => 'simpan', 'onkeypress' => "return $(this).focusNextInputField(event)", 'readonly' => true)); ?>
                                </td>
                                <td style="width: 25%;">
                                    <center><label
                                            class="input-ab"><?= CHtml::dropDownList('PemeriksaankulturT[chloramphenicol2]', $chloramphenicol2, LookupM::getItems('antibiotika_jenisobat'), array('empty' => ' - ', 'class' => 'span2 ab ab2', 'onkeyup' => "return $(this).focusNextInputField(event)",)); ?>
                                    </center></label>
                                </td>
                            </tr>
                            <tr>
                            <?php

                                $nalidixid1 = null; $nalidixid2 = null;

                                if(!empty($kultur->nalidixid)) {
                                    $nalidixid = explode(' / ', $kultur->nalidixid);
                                    $nalidixid1 = $nalidixid[0];
                                    $nalidixid2 = $nalidixid[1];
                                }

                                ?>
                                <td style="width: 50%;"><label class="input-ab">&emsp;&emsp;&emsp;Nalidixid Acid</label>
                                </td>
                                <td style="width: 25%;">
                                    <center><label
                                            class="input-ab"><?= CHtml::dropDownList('PemeriksaankulturT[nalidixid1]', $nalidixid1, LookupM::getItems('antibiotika_jenisobat'), array('empty' => ' - ', 'class' => 'span2 ab ab1', 'onkeyup' => "return $(this).focusNextInputField(event)",)); ?>
                                    </center></label>
                                </td>
                                <td>&emsp;<?php echo $form->hiddenField($kultur, 'nalidixid', array('class' => 'simpan', 'onkeypress' => "return $(this).focusNextInputField(event)", 'readonly' => true)); ?>
                                </td>
                                <td style="width: 25%;">
                                    <center><label
                                            class="input-ab"><?= CHtml::dropDownList('PemeriksaankulturT[nalidixid2]', $nalidixid2, LookupM::getItems('antibiotika_jenisobat'), array('empty' => ' - ', 'class' => 'span2 ab ab2', 'onkeyup' => "return $(this).focusNextInputField(event)",)); ?>
                                    </center></label>
                                </td>
                            </tr>
                            <tr>
                            <?php

                                $nitrofurantoin1 = null; $nitrofurantoin2 = null;

                                if(!empty($kultur->nitrofurantoin)) {
                                    $nitrofurantoin = explode(' / ', $kultur->nitrofurantoin);
                                    $nitrofurantoin1 = $nitrofurantoin[0];
                                    $nitrofurantoin2 = $nitrofurantoin[1];
                                }

                                ?>
                                <td style="width: 50%;"><label class="input-ab">&emsp;&emsp;&emsp;Nitrofurantoin</label>
                                </td>
                                <td style="width: 25%;">
                                    <center><label
                                            class="input-ab"><?= CHtml::dropDownList('PemeriksaankulturT[nitrofurantoin1]', $nitrofurantoin1, LookupM::getItems('antibiotika_jenisobat'), array('empty' => ' - ', 'class' => 'span2 ab ab1', 'onkeyup' => "return $(this).focusNextInputField(event)",)); ?>
                                    </center></label>
                                </td>
                                <td>&emsp;<?php echo $form->hiddenField($kultur, 'nitrofurantoin', array('class' => 'simpan', 'onkeypress' => "return $(this).focusNextInputField(event)", 'readonly' => true)); ?>
                                </td>
                                <td style="width: 25%;">
                                    <center><label
                                            class="input-ab"><?= CHtml::dropDownList('PemeriksaankulturT[nitrofurantoin2]', $nitrofurantoin2, LookupM::getItems('antibiotika_jenisobat'), array('empty' => ' - ', 'class' => 'span2 ab ab2', 'onkeyup' => "return $(this).focusNextInputField(event)",)); ?>
                                    </center></label>
                                </td>
                            </tr>
                            <tr>
                            <?php

                                $colistine1 = null; $colistine2 = null;

                                if(!empty($kultur->colistine)) {
                                    $colistine = explode(' / ', $kultur->colistine);
                                    $colistine1 = $colistine[0];
                                    $colistine2 = $colistine[1];
                                }

                            ?>
                                <td style="width: 50%;"><label class="input-ab">&emsp;&emsp;&emsp;Colistine</label>
                                </td>
                                <td style="width: 25%;">
                                    <center><label
                                            class="input-ab"><?= CHtml::dropDownList('PemeriksaankulturT[colistine1]', $colistine1, LookupM::getItems('antibiotika_jenisobat'), array('empty' => ' - ', 'class' => 'span2 ab ab1', 'onkeyup' => "return $(this).focusNextInputField(event)",)); ?>
                                    </center></label>
                                </td>
                                <td>&emsp;<?php echo $form->hiddenField($kultur, 'colistine', array('class' => 'simpan', 'onkeypress' => "return $(this).focusNextInputField(event)", 'readonly' => true)); ?>
                                </td>
                                <td style="width: 25%;">
                                    <center><label
                                            class="input-ab"><?= CHtml::dropDownList('PemeriksaankulturT[colistine2]', $colistine2, LookupM::getItems('antibiotika_jenisobat'), array('empty' => ' - ', 'class' => 'span2 ab ab2', 'onkeyup' => "return $(this).focusNextInputField(event)",)); ?>
                                    </center></label>
                                </td>
                            </tr>
                            <tr>
                            <?php

                            $trimoxazole1 = null; $trimoxazole2 = null;

                            if(!empty($kultur->trimoxazole)) {
                                $trimoxazole = explode(' / ', $kultur->trimoxazole);
                                $trimoxazole1 = $trimoxazole[0];
                                $trimoxazole2 = $trimoxazole[1];
                            }

                            ?>
                                <td style="width: 50%;"><label class="input-ab">&emsp;&emsp;&emsp;Co-trimoxazole</label>
                                </td>
                                <td style="width: 25%;">
                                    <center><label
                                            class="input-ab"><?= CHtml::dropDownList('PemeriksaankulturT[trimoxazole1]', $trimoxazole1, LookupM::getItems('antibiotika_jenisobat'), array('empty' => ' - ', 'class' => 'span2 ab ab1', 'onkeyup' => "return $(this).focusNextInputField(event)",)); ?>
                                    </center></label>
                                </td>
                                <td>&emsp;<?php echo $form->hiddenField($kultur, 'trimoxazole', array('class' => 'simpan', 'onkeypress' => "return $(this).focusNextInputField(event)", 'readonly' => true)); ?>
                                </td>
                                <td style="width: 25%;">
                                    <center><label
                                            class="input-ab"><?= CHtml::dropDownList('PemeriksaankulturT[trimoxazole2]', $trimoxazole2, LookupM::getItems('antibiotika_jenisobat'), array('empty' => ' - ', 'class' => 'span2 ab ab2', 'onkeyup' => "return $(this).focusNextInputField(event)",)); ?>
                                    </center></label>
                                </td>
                            </tr>
                            <tr>
                            <?php

                                $vancomycin1 = null; $vancomycin2 = null;
                                                        
                                if(!empty($kultur->vancomycin)) {
                                    $vancomycin = explode(' / ', $kultur->vancomycin);
                                    $vancomycin1 = $vancomycin[0];
                                    $vancomycin2 = $vancomycin[1];
                                }
                                
                                ?>
                                <td style="width: 50%;"><label class="input-ab">&emsp;&emsp;&emsp;Vancomycin</label>
                                </td>
                                <td style="width: 25%;">
                                    <center><label
                                            class="input-ab"><?= CHtml::dropDownList('PemeriksaankulturT[vancomycin1]', $vancomycin1, LookupM::getItems('antibiotika_jenisobat'), array('empty' => ' - ', 'class' => 'span2 ab ab1', 'onkeyup' => "return $(this).focusNextInputField(event)",)); ?>
                                    </center></label>
                                </td>
                                <td>&emsp;<?php echo $form->hiddenField($kultur, 'vancomycin', array('class' => 'simpan', 'onkeypress' => "return $(this).focusNextInputField(event)", 'readonly' => true)); ?>
                                </td>
                                <td style="width: 25%;">
                                    <center><label
                                            class="input-ab"><?= CHtml::dropDownList('PemeriksaankulturT[vancomycin2]', $vancomycin2, LookupM::getItems('antibiotika_jenisobat'), array('empty' => ' - ', 'class' => 'span2 ab ab2', 'onkeyup' => "return $(this).focusNextInputField(event)",)); ?>
                                    </center></label>
                                </td>
                            </tr>
                            <tr>
                            <?php

                                $linezolid1 = null; $linezolid2 = null;

                                if(!empty($kultur->linezolid)) {
                                    $linezolid = explode(' / ', $kultur->linezolid);
                                    $linezolid1 = $linezolid[0];
                                    $linezolid2 = $linezolid[1];
                                }

                                ?>
                                <td style="width: 50%;"><label class="input-ab">&emsp;&emsp;&emsp;Linezolid</label></td>
                                <td style="width: 25%;">
                                    <center><label
                                            class="input-ab"><?= CHtml::dropDownList('PemeriksaankulturT[linezolid1]', $linezolid1, LookupM::getItems('antibiotika_jenisobat'), array('empty' => ' - ', 'class' => 'span2 ab ab1', 'onkeyup' => "return $(this).focusNextInputField(event)",)); ?>
                                    </center></label>
                                </td>
                                <td>&emsp;<?php echo $form->hiddenField($kultur, 'linezolid', array('class' => 'simpan', 'onkeypress' => "return $(this).focusNextInputField(event)", 'readonly' => true)); ?>
                                </td>
                                <td style="width: 25%;">
                                    <center><label
                                            class="input-ab"><?= CHtml::dropDownList('PemeriksaankulturT[linezolid2]', $linezolid2, LookupM::getItems('antibiotika_jenisobat'), array('empty' => ' - ', 'class' => 'span2 ab ab2', 'onkeyup' => "return $(this).focusNextInputField(event)",)); ?>
                                    </center></label>
                                </td>
                            </tr>
                            <tr>
                            <?php

                                $tigecycline1 = null; $tigecycline2 = null;

                                if(!empty($kultur->tigecycline)) {
                                    $tigecycline = explode(' / ', $kultur->tigecycline);
                                    $tigecycline1 = $tigecycline[0];
                                    $tigecycline2 = $tigecycline[1];
                                }

                                ?>
                                <td style="width: 50%;"><label class="input-ab">&emsp;&emsp;&emsp;Tigecycline</label>
                                </td>
                                <td style="width: 25%;">
                                    <center><label
                                            class="input-ab"><?= CHtml::dropDownList('PemeriksaankulturT[tigecycline1]', $tigecycline1, LookupM::getItems('antibiotika_jenisobat'), array('empty' => ' - ', 'class' => 'span2 ab ab1', 'onkeyup' => "return $(this).focusNextInputField(event)",)); ?>
                                    </center></label>
                                </td>
                                <td>&emsp;<?php echo $form->hiddenField($kultur, 'tigecycline', array('class' => 'simpan', 'onkeypress' => "return $(this).focusNextInputField(event)", 'readonly' => true)); ?>
                                </td>
                                <td style="width: 25%;">
                                    <center><label
                                            class="input-ab"><?= CHtml::dropDownList('PemeriksaankulturT[tigecycline2]', $tigecycline2, LookupM::getItems('antibiotika_jenisobat'), array('empty' => ' - ', 'class' => 'span2 ab ab2', 'onkeyup' => "return $(this).focusNextInputField(event)",)); ?>
                                    </center></label>
                                </td>
                            </tr>
                            <tr>
                            <?php

                            $rifampicin1 = null; $rifampicin2 = null;

                            if(!empty($kultur->rifampicin)) {
                                $rifampicin = explode(' / ', $kultur->rifampicin);
                                $rifampicin1 = $rifampicin[0];
                                $rifampicin2 = $rifampicin[1];
                            }

                            ?>
                                <td style="width: 50%;"><label class="input-ab">&emsp;&emsp;&emsp;Rifampicin</label>
                                </td>
                                <td style="width: 25%;">
                                    <center><label
                                            class="input-ab"><?= CHtml::dropDownList('PemeriksaankulturT[rifampicin1]', $rifampicin1, LookupM::getItems('antibiotika_jenisobat'), array('empty' => ' - ', 'class' => 'span2 ab ab1', 'onkeyup' => "return $(this).focusNextInputField(event)",)); ?>
                                    </center></label>
                                </td>
                                <td>&emsp;<?php echo $form->hiddenField($kultur, 'rifampicin', array('class' => 'simpan', 'onkeypress' => "return $(this).focusNextInputField(event)", 'readonly' => true)); ?>
                                </td>
                                <td style="width: 25%;">
                                    <center><label
                                            class="input-ab"><?= CHtml::dropDownList('PemeriksaankulturT[rifampicin2]', $rifampicin2, LookupM::getItems('antibiotika_jenisobat'), array('empty' => ' - ', 'class' => 'span2 ab ab2', 'onkeyup' => "return $(this).focusNextInputField(event)",)); ?>
                                    </center></label>
                                </td>
                            </tr>
                            <tr>
                                <td style="width: 50%;"><label class="judul-ab">K. ANTIFUNGAL</label></td>
                                <td style="width: 24%;">
                                    <center><label class="judul-ab"></center></label>
                                </td>
                                <td style="width: 2%;">
                                    <center><label class="judul-ab">&emsp;</center></label>
                                </td>
                                <td style="width: 24%;">
                                    <center><label class="judul-ab"></center></label>
                                </td>
                            </tr>
                            <tr>
                            <?php

                                $fluconazole1 = null; $fluconazole2 = null;

                                if(!empty($kultur->fluconazole)) {
                                    $fluconazole = explode(' / ', $kultur->fluconazole);
                                    $fluconazole1 = $fluconazole[0];
                                    $fluconazole2 = $fluconazole[1];
                                }

                                ?>
                                <td style="width: 50%;"><label class="input-ab">&emsp;&emsp;&emsp;Fluconazole</label>
                                </td>
                                <td style="width: 25%;">
                                    <center><label
                                            class="input-ab"><?= CHtml::dropDownList('PemeriksaankulturT[fluconazole1]', $fluconazole1, LookupM::getItems('antibiotika_jenisobat'), array('empty' => ' - ', 'class' => 'span2 ab ab1', 'onkeyup' => "return $(this).focusNextInputField(event)",)); ?>
                                    </center></label>
                                </td>
                                <td>&emsp;<?php echo $form->hiddenField($kultur, 'fluconazole', array('class' => 'simpan', 'onkeypress' => "return $(this).focusNextInputField(event)", 'readonly' => true)); ?>
                                </td>
                                <td style="width: 25%;">
                                    <center><label
                                            class="input-ab"><?= CHtml::dropDownList('PemeriksaankulturT[fluconazole2]', $fluconazole2, LookupM::getItems('antibiotika_jenisobat'), array('empty' => ' - ', 'class' => 'span2 ab ab2', 'onkeyup' => "return $(this).focusNextInputField(event)",)); ?>
                                    </center></label>
                                </td>
                            </tr>
                            <tr>
                            <?php

                                $voriconazole1 = null; $voriconazole2 = null;

                                if(!empty($kultur->voriconazole)) {
                                    $voriconazole = explode(' / ', $kultur->voriconazole);
                                    $voriconazole1 = $voriconazole[0];
                                    $voriconazole2 = $voriconazole[1];
                                }

                                ?>
                                <td style="width: 50%;"><label class="input-ab">&emsp;&emsp;&emsp;Voriconazole</label>
                                </td>
                                <td style="width: 25%;">
                                    <center><label
                                            class="input-ab"><?= CHtml::dropDownList('PemeriksaankulturT[voriconazole1]', $voriconazole1, LookupM::getItems('antibiotika_jenisobat'), array('empty' => ' - ', 'class' => 'span2 ab ab1', 'onkeyup' => "return $(this).focusNextInputField(event)",)); ?>
                                    </center></label>
                                </td>
                                <td>&emsp;<?php echo $form->hiddenField($kultur, 'voriconazole', array('class' => 'simpan', 'onkeypress' => "return $(this).focusNextInputField(event)", 'readonly' => true)); ?>
                                </td>
                                <td style="width: 25%;">
                                    <center><label
                                            class="input-ab"><?= CHtml::dropDownList('PemeriksaankulturT[voriconazole2]', $voriconazole2, LookupM::getItems('antibiotika_jenisobat'), array('empty' => ' - ', 'class' => 'span2 ab ab2', 'onkeyup' => "return $(this).focusNextInputField(event)",)); ?>
                                    </center></label>
                                </td>
                            </tr>
                            <tr>
                            <?php

                                $micafungin1 = null; $micafungin2 = null;

                                if(!empty($kultur->micafungin)) {
                                    $micafungin = explode(' / ', $kultur->micafungin);
                                    $micafungin1 = $micafungin[0];
                                    $micafungin2 = $micafungin[1];
                                }

                                ?>
                                <td style="width: 50%;"><label class="input-ab">&emsp;&emsp;&emsp;Micafungin</label>
                                </td>
                                <td style="width: 25%;">
                                    <center><label
                                            class="input-ab"><?= CHtml::dropDownList('PemeriksaankulturT[micafungin1]', $micafungin1, LookupM::getItems('antibiotika_jenisobat'), array('empty' => ' - ', 'class' => 'span2 ab ab1', 'onkeyup' => "return $(this).focusNextInputField(event)",)); ?>
                                    </center></label>
                                </td>
                                <td>&emsp;<?php echo $form->hiddenField($kultur, 'micafungin', array('class' => 'simpan', 'onkeypress' => "return $(this).focusNextInputField(event)", 'readonly' => true)); ?>
                                </td>
                                <td style="width: 25%;">
                                    <center><label
                                            class="input-ab"><?= CHtml::dropDownList('PemeriksaankulturT[micafungin2]', $micafungin2, LookupM::getItems('antibiotika_jenisobat'), array('empty' => ' - ', 'class' => 'span2 ab ab2', 'onkeyup' => "return $(this).focusNextInputField(event)",)); ?>
                                    </center></label>
                                </td>
                            </tr>
                            <tr>
                            <?php

                                $amphothericin1 = null; $amphothericin2 = null;

                                if(!empty($kultur->amphothericin)) {
                                    $amphothericin = explode(' / ', $kultur->amphothericin);
                                    $amphothericin1 = $amphothericin[0];
                                    $amphothericin2 = $amphothericin[1];
                                }

                                ?>
                                <td style="width: 50%;"><label class="input-ab">&emsp;&emsp;&emsp;Amphothericin
                                        B</label></td>
                                <td style="width: 25%;">
                                    <center><label
                                            class="input-ab"><?= CHtml::dropDownList('PemeriksaankulturT[amphothericin1]', $amphothericin1, LookupM::getItems('antibiotika_jenisobat'), array('empty' => ' - ', 'class' => 'span2 ab ab1', 'onkeyup' => "return $(this).focusNextInputField(event)",)); ?>
                                    </center></label>
                                </td>
                                <td>&emsp;<?php echo $form->hiddenField($kultur, 'amphothericin', array('class' => 'simpan', 'onkeypress' => "return $(this).focusNextInputField(event)", 'readonly' => true)); ?>
                                </td>
                                <td style="width: 25%;">
                                    <center><label
                                            class="input-ab"><?= CHtml::dropDownList('PemeriksaankulturT[amphothericin2]', $amphothericin2, LookupM::getItems('antibiotika_jenisobat'), array('empty' => ' - ', 'class' => 'span2 ab ab2', 'onkeyup' => "return $(this).focusNextInputField(event)",)); ?>
                                    </center></label>
                                </td>
                            </tr>
                            <tr>
                            <?php

                                $caspofungin1 = null; $caspofungin2 = null;

                                if(!empty($kultur->caspofungin)) {
                                    $caspofungin = explode(' / ', $kultur->caspofungin);
                                    $caspofungin1 = $caspofungin[0];
                                    $caspofungin2 = $caspofungin[1];
                                }

                                ?>
                                <td style="width: 50%;"><label class="input-ab">&emsp;&emsp;&emsp;Caspofungin</label>
                                </td>
                                <td style="width: 25%;">
                                    <center><label
                                            class="input-ab"><?= CHtml::dropDownList('PemeriksaankulturT[caspofungin1]', $caspofungin1, LookupM::getItems('antibiotika_jenisobat'), array('empty' => ' - ', 'class' => 'span2 ab ab1', 'onkeyup' => "return $(this).focusNextInputField(event)",)); ?>
                                    </center></label>
                                </td>
                                <td>&emsp;<?php echo $form->hiddenField($kultur, 'caspofungin', array('class' => 'simpan', 'onkeypress' => "return $(this).focusNextInputField(event)", 'readonly' => true)); ?>
                                </td>
                                <td style="width: 25%;">
                                    <center><label
                                            class="input-ab"><?= CHtml::dropDownList('PemeriksaankulturT[caspofungin2]', $caspofungin2, LookupM::getItems('antibiotika_jenisobat'), array('empty' => ' - ', 'class' => 'span2 ab ab2', 'onkeyup' => "return $(this).focusNextInputField(event)",)); ?>
                                    </center></label>
                                </td>
                            </tr>
                            <tr>
                            <?php

                                $flucytosine1 = null; $flucytosine2 = null;

                                if(!empty($kultur->flucytosine)) {
                                    $flucytosine = explode(' / ', $kultur->flucytosine);
                                    $flucytosine1 = $flucytosine[0];
                                    $flucytosine2 = $flucytosine[1];
                                }

                                ?>
                                <td style="width: 50%;"><label class="input-ab">&emsp;&emsp;&emsp;Flucytosine</label>
                                </td>
                                <td style="width: 25%;">
                                    <center><label
                                            class="input-ab"><?= CHtml::dropDownList('PemeriksaankulturT[flucytosine1]', $flucytosine1, LookupM::getItems('antibiotika_jenisobat'), array('empty' => ' - ', 'class' => 'span2 ab ab1', 'onkeyup' => "return $(this).focusNextInputField(event)",)); ?>
                                    </center></label>
                                </td>
                                <td>&emsp;<?php echo $form->hiddenField($kultur, 'flucytosine', array('class' => 'simpan', 'onkeypress' => "return $(this).focusNextInputField(event)", 'readonly' => true)); ?>
                                </td>
                                <td style="width: 25%;">
                                    <center><label
                                            class="input-ab"><?= CHtml::dropDownList('PemeriksaankulturT[flucytosine2]', $flucytosine2, LookupM::getItems('antibiotika_jenisobat'), array('empty' => ' - ', 'class' => 'span2 ab ab2', 'onkeyup' => "return $(this).focusNextInputField(event)",)); ?>
                                    </center></label>
                                </td>
                            </tr>


                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row-fluid">
    <div class="form-actions">
        <?php

            if (!isset($_GET['sukses'])) {
                echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('class' => 'btn btn-danger', 'type' => 'submit'));
                echo "&nbsp;";
            } else {
                echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('class' => 'btn btn-danger', 'type' => 'submit', 'onclick' => 'formSubmit(this,event);', 'onkeypress' => 'formSubmit(this,event);', 'disabled' => true));
                echo "&nbsp;";
            }       
                
            if (!isset($_GET['pemeriksaankultur_id'])) {
                echo CHtml::link(Yii::t('mds', '{icon} Print Kultur', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('disabled' => true, 'class' => 'btn btn-info', 'onclick' => "return false"));
            } else {
                echo CHtml::link(Yii::t('mds', '{icon} Print Kultur', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'onclick' => "printKultur();return false"));
            }
            
                $content = $this->renderPartial('akuntansi.views.tips.tipsaddedit3a', array(), true);
                $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
                
    
?>
    </div>
</div>




<?php

/** =============== TIM MEDIS ===================== * */
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogMikroorganismeKet',
    'options' => array(
        'title' => 'Pencarian Hasil Pemeriksaan Mikroorganisme',
        'autoOpen' => false,
        'width' => 490,
        'height' => 600,
        'resizable' => true,
    ),
        )
);

$format = new MyFormatter();
$modMikro = new HasilpemeriksaanmikroM('search');
$modMikro->unsetAttributes();
if (isset($_GET['HasilpemeriksaanmikroM'])) {
    $modMikro->attributes = $_GET['HasilpemeriksaanmikroM'];
}

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'dialog-dpjp-m-grid',
    'dataProvider' => $modMikro->search(),
    'filter' => $modMikro,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => function($data) {
                return CHtml::Link('<i class="icon-form-check"></i>', "#", array("class" => "btn-small",
                            "onclick" => " setKetMikro(\"" . $data->hasilpemeriksaan . "\"); return false; "));
            },
        ),
        array(
            'header' => 'Kelompok Mikroorganisme',
            //'name'=>'nama_pegawai',
            'filter' => CHtml::activeTextField($modMikro, 'kelompok_mikroorganisme', array('class' => 'span3')),
            'value' => '$data->kelompok_mikroorganisme',
        ),
        array(
            'header' => 'Hasil Pemeriksaan',
            //'name'=>'nama_pegawai',
            'filter' => CHtml::activeTextField($modMikro, 'hasilpemeriksaan', array('class' => 'span3')),
            'value' => '$data->hasilpemeriksaan',
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget('zii.widgets.jui.CJuiDialog');
//=============================== END TIM MEDIS =======================================

?>

<?php

/** =============== TIM MEDIS ===================== * */
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogBiakan',
    'options' => array(
        'title' => 'Pencarian Hasil Pemeriksaan Mikroorganisme',
        'autoOpen' => false,
        'width' => 490,
        'height' => 600,
        'resizable' => true,
    ),
        )
);

$format = new MyFormatter();
$modBiakan = new MikroorganismeM('search');
$modBiakan->unsetAttributes();
if (isset($_GET['MikroorganismeM'])) {
    $modBiakan->attributes = $_GET['MikroorganismeM'];
}

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'dialog-biakan-grid',
    'dataProvider' => $modBiakan->search(),
    'filter' => $modBiakan,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => function($data) {
                return CHtml::Link('<i class="icon-form-check"></i>', "#", array("class" => "btn-small",
                            "onclick" => " setBiakan(\"" . $data->nama_mikroorganisme . "\"); return false; "));
            },
        ),
        array(
            'header' => 'Kelompok Mikroorganisme',
            //'name'=>'nama_pegawai',
            'filter' => CHtml::activeTextField($modBiakan, 'kelompok_mikroorganisme', array('class' => 'span3')),
            'value' => '$data->kelompok_mikroorganisme',
        ),
        array(
            'header' => 'Nama Mikroorganisme',
            //'name'=>'nama_pegawai',
            'filter' => CHtml::activeTextField($modBiakan, 'nama_mikroorganisme', array('class' => 'span3')),
            'value' => '$data->nama_mikroorganisme',
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget('zii.widgets.jui.CJuiDialog');
//=============================== END TIM MEDIS =======================================

?>


<script>
function setKetMikro(ket) {

    var isi = $('#<?= CHtml::activeId($kultur, 'mikroorganisme_ket') ?>').val();

    console.log('isi ket : ' + isi);

    if (isi == "") {
        console.log('ket 1' + ket);
        $('#<?= CHtml::activeId($kultur, 'mikroorganisme_ket') ?>').val(ket);
    } else {
        console.log('ket 2' + ket);
        var isi_arr = isi.split(', ');

        console.log('isi arr: ' + isi_arr);
        isi_arr.push(ket);
        console.log('isi arr push: ' + isi_arr);

        var isi_join = isi_arr.join(', ');
        $('#<?= CHtml::activeId($kultur, 'mikroorganisme_ket') ?>').val(isi_join);
    }

    $('#dialogMikroorganismeKet').dialog('close');

}

function setBiakan(ket) {

    var isi = $('#<?= CHtml::activeId($kultur, 'biakan_kultur_ket') ?>').val();

    console.log('isi ket b : ' + isi);
    console.log('isi ket b2 : ' + ket);


    if (isi == "") {
        $('#<?= CHtml::activeId($kultur, 'biakan_kultur_ket') ?>').val(ket);
    } else {
        var isi_arr = isi.split(', ');
        isi_arr.push(ket);
        var isi_join = isi_arr.join(', ');
        $('#<?= CHtml::activeId($kultur, 'biakan_kultur_ket') ?>').val(isi_join);
    }

    $('#dialogBiakan').dialog('close');
}

function printKultur() {
    window.open(
        '<?php echo $this->createUrl('/mikrobiologiKlinik/daftarPasien/printKultur', array('pemeriksaankultur_id' => $kultur->pemeriksaankultur_id)); ?>',
        'printwin', 'left=100,top=100,width=640,height=480');
}

$('.ab').change(function() {

    var ab1 = $(this).closest('tr').find('.ab1').val();
    var ab2 = $(this).closest('tr').find('.ab2').val();

    if (ab1 === '') {
        ab1 = "-";
    }

    if (ab2 === '') {
        ab2 = "-";
    }

    $(this).closest('tr').find('.simpan').val(ab1 + " / " + ab2);

});
</script>