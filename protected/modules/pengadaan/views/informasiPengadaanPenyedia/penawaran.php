<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/accounting2.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form2.js', CClientScript::POS_END); ?>
<?php
$this->renderPartial($this->path_view . 'detail', array(
    'model' => $model,
    'modRencana' => $modRencana,
    'modJenisPengadaan' => $modJenisPengadaan,
    'modJenis' => $modJenis,
    'modDokumen' => $modDokumen));
?>
<div class="panel panel-success">
    <div class="panel panel-heading">
        <div class="panel-title"> <b> Penawaran Penyedia </b> </div>
    </div>
    <div class="panel-body">
        <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
        <?php
        $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
            'id' => 'penawaran-t-form',
            'enableAjaxValidation' => false,
            'type' => 'horizontal',
            'htmlOptions' => array(
                'enctype' => 'multipart/form-data',
                'onKeyPress' => 'return disableKeyPress(event)',
                'onsubmit' => 'return requiredCheck(this);'
            ),
        ));
        ?>
        <div class="col-md-6">
            <div class="control-group">
                <?php echo CHtml::label("Penyedia", 'Penyedia', array('class' => 'control-label')) ?>
                <div class = "controls">
                    <?php echo $form->textField($modPenyedia, 'penyedia_nama', array('readonly' => true, 'class' => 'span4', 'placeholder' => 'Ketik Nomor Kantong Darah')) ?>
                </div>
            </div>
            <div class="control-group">
                <?php echo CHtml::label("Alamat Penyedia", 'Alamat Penyedia', array('class' => 'control-label')) ?>
                <div class = "controls">
                    <?php echo $form->textArea($modPenyedia, 'penyedia_alamat', array('readonly' => true, 'class' => 'span4', 'placeholder' => 'Ketik Nomor Kantong Darah')) ?>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="control-group">
                <?php echo CHtml::label("Direktur", 'Direktur', array('class' => 'control-label')) ?>
                <div class = "controls">
                    <?php echo $form->textField($modPenyedia, 'penyedia_direktur', array('readonly' => true, 'class' => 'span4')) ?>
                </div>
            </div>
        </div>
        <div class="clear"></div>
        <hr>
        <div class="col-md-6">
            <div class="control-group">
                <?php echo CHtml::label("Tanggal Penawaran <span class='required'>*</span>", 'penawaranpenyedia_tanggal', array('class' => 'control-label required')) ?>
                <div class = "controls">
                    <?php
                    $this->widget('MyDateTimePicker', array(
                        'model' => $modPenawaran,
                        'attribute' => 'penawaranpenyedia_tanggal',
                        'mode' => 'datetime',
                        'options' => array(
                            'dateFormat' => Params::DATE_FORMAT,
                            'maxDate' => 'd',
                        ),
                        'htmlOptions' => array('readonly' => true, 'class' => 'span4 dtPicker3', 'onkeypress' => "return $(this).focusNextInputField(event)",),
                    ));
                    ?>
                </div>
            </div>
            <div class="control-group">
                <?php echo CHtml::label("Nomor Surat Penawaran <span class='required'>*</span>", 'penawaranpenyedia_nomor', array('class' => 'control-label required')) ?>
                <div class = "controls">
                    <?php echo $form->textField($modPenawaran, 'penawaranpenyedia_nomorsurat', array('class' => 'span4')) ?>
                </div>
            </div>
            <div class="control-group">
                <?php echo CHtml::label("File Surat Penawaran", 'penawaranpenyedia_file', array('class' => 'control-label')) ?>
                <div class = "controls">
                    <?php echo $form->fileField($modPenawaran,'penawaranpenyedia_file',array('Hint'=>'Isi Jika Akan Menambahkan File lampiran')); ?>
                    <p style="color: red">Hanya file dengan ekstensi PDF, Max 3Mb.</p>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="control-group">
                <?php echo CHtml::label("Total Harga yang ditawarkan (Rp) <span class='required'>*</span>", 'penawaranpenyedia_harga', array('class' => 'control-label required')) ?>
                <div class = "controls">
                    <?php echo $form->textField($modPenawaran, 'penawaranpenyedia_harga', array('class' => 'span4 integer2')) ?>
                </div>
            </div>
            <div class="control-group">
                <?php echo CHtml::label("Keterangan", 'penawaranpenyedia_keterangan', array('class' => 'control-label')) ?>
                <div class = "controls">
                    <?php echo $form->textArea($modPenawaran, 'penawaranpenyedia_keterangan', array('class' => 'span4')) ?>
                </div>
            </div>
        </div>
        <div class="clear"></div>
        <hr>
        <div class="row-fluid">
            <div class="form-actions">
                <?php
                if (!isset($_GET['sukses'])) {
                    echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="icon-ok icon-white"></i>')), array('class' => (isset($_GET['sukses'])) ? 'btn btn-primary' : 'btn btn-primary submit', 'type' => 'submit', 'onclick' => 'formSubmit(this,event);', 'onkeypress' => 'formSubmit(this,event);'));
                    echo "&nbsp;";
                    
                    echo CHtml::link(Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="icon-refresh icon-white"></i>')), $_SERVER['REQUEST_URI'], array('class' => 'btn btn-danger',
                    'onclick' => 'return refreshForm(this);'));
                    echo "&nbsp;";
                } else {
                    echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="icon-ok icon-white"></i>')), array('class' => 'btn btn-primary', 'type' => 'submit', 'onclick' => 'formSubmit(this,event);', 'onkeypress' => 'formSubmit(this,event);', 'disabled' => true));
                    echo "&nbsp;";
                    
                    echo CHtml::link(Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="icon-refresh icon-white"></i>')), $_SERVER['REQUEST_URI'], array('class' => 'btn btn-danger', 'disabled' => true,
                    'onclick' => 'return refreshForm(this);'));
                    echo "&nbsp;";
                }
                ?>
            </div>
        </div>
        <?php $this->endWidget(); ?>
    </div>
</div>
<?php
$this->renderPartial($this->path_view . '_jsFunction', array(
    'model' => $model,
));
?>