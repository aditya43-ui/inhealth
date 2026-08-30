<script type="text/javascript">
    function cek() {
        var nama = $('#KomentarS_namakomentar').val();
        var instanasi = $('#KomentarS_instanasi').val();
        var deskripsi = $('#KomentarS_deskripsikomentat').val();
        if (nama == null || nama == '') {
            myAlert('Nama Harus Diisi');
            return false;
        } else if (instanasi == null || instanasi == '') {
            myAlert('Instansi Harus Diisi');
            return false;
        } else if (deskripsi == null || deskripsi == '') {
            myAlert('Kritik Saran Harus Diisi');
            return false;
        } else {
            return true;
        }

    }
</script>

<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>

<link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/kiosk/keyboard.css" type="text/css" />
<script type="text/javascript" src="<?php //echo Yii::app()->request->baseUrl; 
                                    ?>/js/ekios/jquery.keyboard.js"></script>
<script type="text/javascript" src="<?php //echo Yii::app()->request->baseUrl; 
                                    ?>/js/ekios/jquery.mousewheel.js"></script>

<script>
    $(function() {
        $('#KomentarS_namakomentar').keyboard();
        $('#KomentarS_instanasi').keyboard();
        $('#KomentarS_emailkomentar').keyboard();
        $('#KomentarS_websitekomentar').keyboard();
        $('#KomentarS_deskripsikomentat').keyboard();
    });
</script>

<div class="block-kioskmodule" id="kritiksaran" name="kritiksaran">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <div class="panel-title">Kritik Dan Saran</div>
                </div>
                <div class="panel-body">


                    <div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-primary panel-gradient">
                                <div class="panel-heading">

                                </div>
                                <div class="panel-body">

                                    <?php
                                    //CHtml::link($text, $url, $htmlOptions)
                                    $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
                                        'action' => Yii::app()->createUrl('ekios/Default/SimpanKomentar'),
                                        'method' => 'post',
                                        'id' => 'kritiksaran-form',
                                        'type' => 'horizontal',
                                        'htmlOptions' => array('enctype' => 'multipart/form-data', 'onKeyPress' => 'return disableKeyPress(event)', 'onsubmit' => 'return cek()'),

                                    )); ?>

                                    <table>
                                        <tr>
                                            <td>

                                                <div class="control-group">
                                                    <label class="control-label">Nama</label>
                                                    <div class="controls">
                                                        <?php echo $form->textField($model, 'namakomentar', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)", 'maxlength' => 50)); ?>
                                                    </div>
                                                </div>

                                                <div class="control-group">
                                                    <label class="control-label">Instansi</label>
                                                    <div class="controls">
                                                        <?php echo $form->textField($model, 'instanasi', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)", 'maxlength' => 50)); ?>
                                                    </div>
                                                </div>

                                            </td>
                                            <td>

                                                <div class="control-group">
                                                    <label class="control-label">Email</label>
                                                    <div class="controls">
                                                        <?php echo $form->textField($model, 'emailkomentar', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)", 'maxlength' => 50)); ?>
                                                    </div>
                                                </div>

                                                <div class="control-group">
                                                    <label class="control-label">Website</label>
                                                    <div class="controls">
                                                        <?php echo $form->textField($model, 'websitekomentar', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)", 'maxlength' => 50)); ?>
                                                    </div>
                                                </div>

                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2">
                                                <div class="control-group">
                                                    <label class="control-label">Kritik / Saran</label>
                                                    <div class="controls">
                                                        <?php echo $form->textArea($model, 'deskripsikomentat', array('onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'commentkritik')); ?>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2">

                                            </td>
                                        </tr>
                                    </table>

                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="form-actions">
                        <?php echo CHtml::htmlButton(
                            Yii::t('mds', '{icon} Kirim', array('{icon}' => '<i class="entypo-floppy"></i>')),
                            array('class' => 'btn btn-info', 'type' => 'submit', 'id' => 'btn_simpan')
                        );
                        ?>
                        <a href="index.php?r=ekios" class="btn btn-primary">
                            <i class="icon-refresh icon-white"></i>
                            Batal
                        </a>

                    </div>
                    <?php
                    $this->endWidget();
                    //========= end Lihat Hasil =============================
                    ?>
                </div>
            </div>
        </div>

    </div>
</div>