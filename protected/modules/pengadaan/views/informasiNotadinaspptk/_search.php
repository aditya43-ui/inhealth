<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'id' => 'notadinaspptk-v-search',
    'type' => 'horizontal',
        ));
$format = new MyFormatter();
?>
<style>
    .form-horizontal .control-label{
        width: 185px !important;
    }
</style>
<div class="row-fluid">
    <div class="col-sm-6">
        <div class="control-group">		
            <?php echo CHtml::label("Tanggal Nota Dinas", 'periode', array('class' => 'control-label')) ?>
            <div class="controls">
                <div class="daterange daterange-inline input-inline" data-format="MMMM D, YYYY" data-start-date="<?php echo date('F d, Y', strtotime($model->tgl_awal)) ?>" data-end-date="<?php echo date('F d, Y', strtotime($model->tgl_akhir)) ?>">
                    <i class="entypo-calendar"></i>
                    <span ><?php echo date('F d, Y', strtotime($model->tgl_awal)) ?> - <?php echo date('F d, Y', strtotime($model->tgl_akhir)) ?></span>
                    <?php echo $form->hiddenField($model, 'tgl_awal', array('class' => 'start')) ?>
                    <?php echo $form->hiddenField($model, 'tgl_akhir', array('class' => 'end')) ?>
                </div>
            </div>
        </div>
        <div class = "control-group">
            <?php echo Chtml::label("Nomor Transaksi", 'notadinaspptk_nomor', array('class' => 'control-label')) ?>
            <div class = "controls">
                <?php echo $form->textField($model, 'notadinaspptk_nomor', array('class' => 'span3', 'placeholder' => 'Ketik Nomor Transaksi')) ?>
            </div>
        </div>
        <div class = "control-group">
            <?php echo Chtml::label("Nomor Nota Dinas", 'nomor_notadinas', array('class' => 'control-label')) ?>
            <div class = "controls">
                <?php echo $form->textField($model, 'nomor_notadinas', array('class' => 'span3', 'placeholder' => 'Ketik Nomor Nota Dinas')) ?>
            </div>
        </div>
        <div class = "control-group">
            <?php echo Chtml::label("Nama Pekerjaan", 'nama_pekerjaan', array('class' => 'control-label')) ?>
            <div class = "controls">
                <?php echo $form->textField($model, 'nama_pekerjaan', array('class' => 'span3', 'placeholder' => 'Ketik Nama Pekerjaan')) ?>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <?php 
            $disable_pptk = $disable_ppk = $disable_pjk = false;
            $modPPTK = InformasinotadinaspptkV::model()->findAllByAttributes(array('pegpptk_id' => Yii::app()->user->getState('pegawai_id')));
            $modPPK = InformasinotadinaspptkV::model()->findAllByAttributes(array('pegppk_id' => Yii::app()->user->getState('pegawai_id')));
            $modPJK = InformasinotadinaspptkV::model()->findAllByAttributes(array('pegpjk_id' => Yii::app()->user->getState('pegawai_id')));
            
            if (!empty($modPJK)) {
                $disable_pjk = true;
            } else if ($modPPK) {
                $disable_ppk = true;
            } else if ($modPPTK) {
                $disable_pptk = true;
            }    
            
        ?>
        <div class = "control-group">
            <?php echo Chtml::label("Pejabat Pelaksana Teknis Kegiatan", 'pegpptk', array('class' => 'control-label')) ?>
            <div class = "controls">
                <?php echo $form->textField($model, 'pegpptk', array('readonly' => $disable_pptk, 'class' => 'span3', 'placeholder' => 'Ketik Nama Pegawai')) ?>
            </div>
        </div>
        <div class = "control-group">
            <?php echo Chtml::label("Pejabat Pembuat Komitmen", 'pegppk', array('class' => 'control-label')) ?>
            <div class = "controls">
                <?php echo $form->textField($model, 'pegppk', array('readonly' => $disable_ppk, 'class' => 'span3', 'placeholder' => 'Ketik Nama Pegawai')) ?>
            </div>
        </div>
        <div class = "control-group">
            <?php echo Chtml::label("Penanggung Jawab Kegiatan", 'pegpjk', array('class' => 'control-label')) ?>
            <div class = "controls">
                <?php echo $form->textField($model, 'pegpjk', array('readonly' => $disable_pjk, 'class' => 'span3', 'placeholder' => 'Ketik Nama Pegawai')) ?>
            </div>
        </div>
    </div>
</div>

<div class="form-actions">
    <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')), array('class' => 'btn btn-primary', 'type' => 'submit')); ?>
    <?php
    echo CHtml::link(Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')), $this->createUrl($this->id . '/indexPribadi'), array('class' => 'btn btn-danger',
        'onclick'=>'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = "'.$this->createUrl('index').'";}); return false;'))."&nbsp;";
    echo CHtml::htmlButton(Yii::t('mds', '{icon} PDF', array('{icon}' => '<i class="entypo-book"></i>')), array('class' => 'btn btn-primary', 'type' => 'button', 'onclick' => 'print(\'PDF\')')) . "&nbsp&nbsp";
    echo CHtml::htmlButton(Yii::t('mds', '{icon} Excel', array('{icon}' => '<i class="entypo-doc-text"></i>')), array('class' => 'btn btn-primary', 'type' => 'button', 'onclick' => 'print(\'EXCEL\')')) . "&nbsp&nbsp";
    echo CHtml::htmlButton(Yii::t('mds', '{icon} Cetak', array('{icon}' => '<i class="entypo-print"></i>')), array('class' => 'btn btn-primary', 'type' => 'button', 'onclick' => 'print(\'PRINT\')')) . "&nbsp&nbsp";
    ?>
    <?php
    $tips = array(
        '0' => 'tanggal',
        '1' => 'cari',
        '2' => 'ulang'
    );
    $content = $this->renderPartial('sistemAdministrator.views.tips.detailTips', array('tips' => $tips), true);
    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
    ?>
</div>

<?php $this->endWidget(); ?>
