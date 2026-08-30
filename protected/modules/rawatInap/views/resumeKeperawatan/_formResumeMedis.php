<style>
.control-group label {
    display: block;
    float: left;
    width: 100%;
}
</style>

<?php echo CHtml::hiddenField('resumeperawat_id', $modResumeKeperawatan->resumeperawat_id); ?>
<div class="col-sm-6 ">
    <div class="panel panel-success">
        <div class="panel-heading">
            <div class="panel-title">
                <i class="far fa-edit"></i> <b>Keadaan Saat Masuk</b>
            </div>
        </div>
        <div class="panel-body">
            <div class="control-group">
                <?php echo CHtml::label("Keluhan", '', array('class' => 'label3')); ?>
                <div class="controls">
                    <?php $this->widget('ext.redactorjs.Redactor', array('model' => $modResumeKeperawatan, 'attribute' => 'keluhansaatmasuk', 'toolbar' => 'mini', 'height' => '160px')) ?>
                </div>
            </div>
            <div class="control-group">
                <?php echo CHtml::label("Diagnosa Awal :", '', array('class' => 'label3')); ?>
                <div class="controls">
                    <?php echo CHtml::hiddenField('diagnosaawal_id', $modResumeKeperawatan->diagnosaawal_id); ?>
                    <?php if (isset($_GET['pendaftaran_id'])) { ?>
                        <span color="#0A2474"><b>
                                <div id="diagnosaawal"><?php echo $modResumeKeperawatan->diagnosaawal_nama; ?></div>
                            </b></span>
                    <?php } else { ?>
                        <span color="#0A2474"><b>
                                <div id="diagnosaawal"></div>
                            </b></span>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
    <div class="panel panel-success">
        <div class="panel-heading">
            <div class="panel-title">
                <i class="far fa-edit"></i> <b>Keadaan Selama di Rawat</b>
            </div>
        </div>
        <div class="panel-body">
            <div class="control-group">
                <?php echo CHtml::label("Diagnosa keperawatan yang teratasi", '', array('class' => 'label3')); ?>
                <div class="controls">
                    <?php $this->widget('ext.redactorjs.Redactor', array('model' => $modResumeKeperawatan, 'attribute' => 'diagkeprwtdiatasi', 'toolbar' => 'mini', 'height' => '100px')) ?>
                </div>
            </div>
            <div class="control-group">
                <?php echo CHtml::label("Tindakan", '', array('class' => 'label3')); ?>
                <div class="controls">
                    <?php $this->widget('ext.redactorjs.Redactor', array('model' => $modResumeKeperawatan, 'attribute' => 'tindakankeprwatan', 'toolbar' => 'mini', 'height' => '100px')) ?>
                </div>
            </div>
            <div class="control-group">
                <?php echo CHtml::label("Diagnosa keperawatan yang belum teratasi", '', array('class' => 'label3')); ?>
                <div class="controls">
                    <?php $this->widget('ext.redactorjs.Redactor', array('model' => $modResumeKeperawatan, 'attribute' => 'diagkeprwtblmteratasi', 'toolbar' => 'mini', 'height' => '100px')) ?>
                </div>
            </div>
        </div>
    </div>
    <div class="panel panel-success">
        <div class="panel-heading">
            <div class="panel-title">
                <i class="far fa-edit"></i> <b>Hasil Pemeriksaan Terakhir</b>
            </div>
        </div>
        <div class="panel-body">
            <div class="control-group">
                <?php echo CHtml::label("Laboratorium", '', array('class' => 'label3')); ?>
                <div class="controls">
                    <?php $this->widget('ext.redactorjs.Redactor', array('model' => $modResumeKeperawatan, 'attribute' => 'hasikperiksalab', 'toolbar' => 'mini', 'height' => '100px')) ?>
                </div>
            </div>
            <div class="control-group">
                <?php echo CHtml::label("Radiologi", '', array('class' => 'label3')); ?>
                <div class="controls">
                    <?php $this->widget('ext.redactorjs.Redactor', array('model' => $modResumeKeperawatan, 'attribute' => 'hasilperiksarad', 'toolbar' => 'mini', 'height' => '100px')) ?>
                </div>
            </div>
            <div class="control-group">
                <?php echo CHtml::label("Lain-lain", '', array('class' => 'label3')); ?>
                <div class="controls">
                    <?php $this->widget('ext.redactorjs.Redactor', array('model' => $modResumeKeperawatan, 'attribute' => 'hasilperiksalainlain', 'toolbar' => 'mini', 'height' => '100px')) ?>
                </div>
            </div>
        </div>
    </div>
    <div class="panel panel-success">
        <div class="panel-heading">
            <div class="panel-title">
                <i class="far fa-edit"></i> <b>Keadaan Saat Keluar</b>
            </div>
        </div>
        <div class="panel-body">
            <div class="control-group">
                <?php echo CHtml::label("Keadaan Umum", '', array('class' => 'label3')); ?>
                <div class="controls">
                    <?php $this->widget('ext.redactorjs.Redactor', array('model' => $modResumeKeperawatan, 'attribute' => 'keadaanumumkeluar', 'toolbar' => 'mini', 'height' => '160px')) ?>
                </div>
            </div>
            <div class="control-group">
                <?php echo CHtml::label("Diagnosa Utama :", '', array('class' => 'label3')); ?>
                <div class="controls">
                    <?php echo CHtml::hiddenField('diagnosautama_id', $modResumeKeperawatan->diagnosautama_id); ?>
                    <?php if (isset($_GET['pendaftaran_id'])) { ?>
                        <span color="#0A2474"><b>
                                <div id="diagnosautama"><?php echo $modResumeKeperawatan->diagnosautama_nama; ?></div>
                            </b></span>
                    <?php } else { ?>
                        <span color="#0A2474"><b>
                                <div id="diagnosautama"></div>
                            </b></span>
                    <?php } ?>
                </div>
            </div>
            <div class="control-group" hidden="true">
                <?php echo CHtml::label("Diagnosa Tambahan :", '', array('class' => 'control-label')); ?>
                <div class="controls diagnosatambahan">
                    <?php echo CHtml::hiddenField('diagnosasekunder1_id', $modResumeKeperawatan->diagnosasekunder1_id); ?>
                    <?php echo CHtml::hiddenField('diagnosasekunder2_id', $modResumeKeperawatan->diagnosasekunder2_id); ?>
                    <?php echo CHtml::hiddenField('diagnosasekunder3_id', $modResumeKeperawatan->diagnosasekunder3_id); ?>
                    <?php if (isset($_GET['pendaftaran_id'])) { ?>
                        <span color="#0A2474"><b>
                                <div id="diagnosatambahan1"><?php echo $modResumeKeperawatan->diagnosasekunder1_nama; ?></div>
                            </b></span>
                        <span color="#0A2474"><b>
                                <div id="diagnosatambahan2"><?php echo $modResumeKeperawatan->diagnosasekunder2_nama; ?></div>
                            </b></span>
                        <span color="#0A2474"><b>
                                <div id="diagnosatambahan3"><?php echo $modResumeKeperawatan->diagnosasekunder3_nama; ?></div>
                            </b></span>
                    <?php } else { ?>
                        <span color="#0A2474"><b>
                                <div id="diagnosatambahan1"></div>
                            </b></span>
                        <span color="#0A2474"><b>
                                <div id="diagnosatambahan2"></div>
                            </b></span>
                        <span color="#0A2474"><b>
                                <div id="diagnosatambahan3"></div>
                            </b></span>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>

    <!--<div class="control-group">
            <?php // echo CHtml::label("Gizi Diet", '', array('class'=>'label3')); 
            ?>
            <div class="controls">
                            <?php // $this->widget('ext.redactorjs.Redactor',array('model'=>$modResumeKeperawatan,'attribute'=>'hasilperiksadiet','toolbar'=>'mini','height'=>'140px')) 
                            ?>
                    </div>
            </div>-->
    <!--<div class="control-group">
            <?php // echo CHtml::label("Rehab Medis", '', array('class'=>'label3')); 
            ?>
            <div class="controls">
                            <?php // $this->widget('ext.redactorjs.Redactor',array('model'=>$modResumeKeperawatan,'attribute'=>'hasilperiksarehabmedis','toolbar'=>'mini','height'=>'140px')) 
                            ?>
                    </div>
            </div>-->
</div>
<div class="col-sm-6">
    <div class="panel panel-success">
        <div class="panel-heading">
            <div class="panel-title">
                <i class="far fa-edit"></i> <b>Tanda Vital</b>
            </div>
        </div>
        <div class="panel-body">
            <div class="control-group">
                <?php echo CHtml::label("Suhu", '', array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php echo CHtml::textField('suhu_saatkeluar', $modResumeKeperawatan->suhu_saatkeluar, array('placeholder' => 'Suhu tubuh', 'class' => 'span1 numbers-only', 'onblur' => '', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                    &nbsp; &#186C
                </div>
            </div>
            <div class="control-group">
                <?php echo CHtml::label("Nadi", '', array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php echo CHtml::textField('nadi_saatkeluar', $modResumeKeperawatan->nadi_saatkeluar, array('placeholder' => 'Denyut Nadi', 'class' => 'span1 numbers-only', 'onblur' => '', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                    &nbsp; x/Mnt
                </div>
            </div>
            <div class="control-group">
                <?php echo CHtml::label("Tensi", '', array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php echo CHtml::textField('tensi_saatkeluar', $modResumeKeperawatan->tensi_saatkeluar, array('placeholder' => '000 / 000', 'class' => 'span2 ', 'onblur' => '', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                    &nbsp; mmHg
                </div>
            </div>
            <div class="control-group">
                <?php echo CHtml::label("Nafas ", '', array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php echo CHtml::textField('nafas_saatkeluar', $modResumeKeperawatan->nafas_saatkeluar, array('placeholder' => 'Tensi', 'class' => 'span1 ', 'onblur' => '', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                    &nbsp; x/Mnt
                </div>
            </div>
            <div class="control-group">
                <?php echo CHtml::label("Obat Lanjutan", '', array('class' => 'label3')); ?>
                <div class="controls">
                    <?php $this->widget('ext.redactorjs.Redactor', array('model' => $modResumeKeperawatan, 'attribute' => 'terapilanjutan', 'toolbar' => 'mini', 'height' => '160px')) ?>
                </div>
            </div>
        </div>
    </div>
    <div class="panel panel-success">
        <div class="panel-heading">
            <div class="panel-title">
                <i class="far fa-edit"></i> <b>Nasihat</b>
            </div>
        </div>
        <div class="panel-body">
            <div class="control-group">
                <?php echo CHtml::label("Diit &nbsp;&nbsp;&nbsp;", '', array('class' => 'label3')); ?>
                <div class="controls">
                    <?php $this->widget('ext.redactorjs.Redactor', array('model' => $modResumeKeperawatan, 'attribute' => 'nasehat_diit', 'toolbar' => 'mini', 'height' => '100px')) ?>
                </div>
            </div>
            <div class="control-group">
                <?php echo CHtml::label("Mobilisasi", '', array('class' => 'label3')); ?>
                <div class="controls">
                    <?php $this->widget('ext.redactorjs.Redactor', array('model' => $modResumeKeperawatan, 'attribute' => 'nasehat_mobilisasi', 'toolbar' => 'mini', 'height' => '100px')) ?>
                </div>
            </div>
            <div class="control-group">
                <?php echo CHtml::label("Eliminasi", '', array('class' => 'label3')); ?>
                <div class="controls">
                    <?php $this->widget('ext.redactorjs.Redactor', array('model' => $modResumeKeperawatan, 'attribute' => 'nasehat_eliminasi', 'toolbar' => 'mini', 'height' => '100px')) ?>
                </div>
            </div>
            <div class="control-group">
                <?php echo CHtml::label("Kontrol", '', array('class' => 'label3')); ?>
                <div class="controls">
                    <?php $this->widget('ext.redactorjs.Redactor', array('model' => $modResumeKeperawatan, 'attribute' => 'nasehat_kontrol', 'toolbar' => 'mini', 'height' => '100px')) ?>
                </div>
            </div>
            <div class="control-group">
                <?php echo CHtml::label("Cara Keluar", '', array('class' => 'label3')); ?>
                <div class="controls">
                    <?php $this->widget('ext.redactorjs.Redactor', array('model' => $modResumeKeperawatan, 'attribute' => 'carakeluar', 'toolbar' => 'mini', 'height' => '100px')) ?>
                </div>
            </div>
            <div class="control-group">
                <?php echo CHtml::label("Tgl. Kontrol &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;", '', array('class' => 'label3')); ?>
                <div class="controls">
                    <?php $this->widget('MyDateTimePicker', array(
                        'model' => $modResumeKeperawatan,
                        'attribute' => 'tglkontrol',
                        'mode' => 'date',
                        'options' => array(
                            'dateFormat' => Params::DATE_FORMAT,
                            'minDate' => 'd',
                        ),
                        'htmlOptions' => array('readonly' => true, 'class' => 'span3 dtPicker3'),
                    )); ?>
                </div>
            </div>
        </div>
    </div>

</div>
<?php echo CHtml::hiddenField('tglmasukrs', $modResumeKeperawatan->tglmasukrs); ?>
<?php echo CHtml::hiddenField('tglkeluarrs', $modResumeKeperawatan->tglkeluarrs); ?>
<?php echo CHtml::hiddenField('ruanganakhir_id', $modResumeKeperawatan->ruanganakhir_id); ?>
<?php echo CHtml::hiddenField('kelaspelayanan_id', $modResumeKeperawatan->kelaspelayanan_id); ?>
<?php echo CHtml::hiddenField('pegawai_id', $modResumeKeperawatan->pegawai_id); ?>