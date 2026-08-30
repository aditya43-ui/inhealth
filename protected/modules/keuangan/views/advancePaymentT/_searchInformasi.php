<div class="row">
    <div class="col-sm-12">
        <?php echo $form->dropDownListRow($model, 'profilrs_id', CHtml::listData(ProfilrumahsakitM::model()->findAll(), 'profilrs_id', 'nama_rumahsakit'), array('multiple' => 'multiple',)) ?>
    </div>
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo CHtml::label("Tgl.Pengajuan", 'tglpengajuan', array('class' => 'control-label')) ?>
            <div class="controls">
                <div class="daterange daterange-inline add-ranges input-inline span4" data-format="DD MMMM YYYY" data-start-date="<?php echo date('d F Y', strtotime($model->tgl_awal)) ?>" data-end-date="<?php echo date('d F Y', strtotime($model->tgl_akhir)) ?>">
                    <i class="entypo-calendar"></i>
                    <span><?php echo date('d F Y', strtotime($model->tgl_awal)) ?> - <?php echo date('d F Y', strtotime($model->tgl_akhir)) ?></span>
                    <?php echo $form->hiddenField($model, 'tgl_awal', array('class' => 'start')) ?>
                    <?php echo $form->hiddenField($model, 'tgl_akhir', array('class' => 'end')) ?>
                </div>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label(CHtml::activeCheckBox($model, 'ceklis') . "Tgl. Kas Keluar", 'tglkaskeluar', array('class' => 'control-label')) ?>
            <div class="controls">
                <div class="daterange daterange-inline add-ranges input-inline span4" data-format="DD MMMM YYYY" data-start-date="<?php echo date('d F Y', strtotime($model->tgl_awal2)) ?>" data-end-date="<?php echo date('d F Y', strtotime($model->tgl_akhir2)) ?>">
                    <i class="entypo-calendar"></i>
                    <span><?php echo date('d F Y', strtotime($model->tgl_awal2)) ?> - <?php echo date('d F Y', strtotime($model->tgl_akhir2)) ?></span>
                    <?php echo $form->hiddenField($model, 'tgl_awal2', array('class' => 'start')) ?>
                    <?php echo $form->hiddenField($model, 'tgl_akhir2', array('class' => 'end')) ?>
                </div>
            </div>
        </div>
        <div class="control-group">
            <?php echo Chtml::label("No. Pengajuan", 'nopengajuan', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->textField($model, 'nopengajuan', array('placeholder' => 'No. Pengajuan', 'class' => 'span4',)) ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo Chtml::label("No. Kas Keluar", 'nokaskeluar', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->textField($model, 'nokaskeluar', array('placeholder' => 'No. Kas Keluar', 'class' => 'span4',)) ?>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <?php //echo $form->dropDownListRow($model,'jenistransaksi',LookupM::getItems('advancepayment'),array('empty' => 'Pilih')) 
        ?>
        <?php echo $form->textFieldRow($model, 'nodokumen', array('placeholder' => 'No. Dokumen', 'class' => 'span4',)) ?>
        <?php echo $form->textFieldRow($model, 'noanggaran', array('placeholder' => 'No. Anggaran', 'class' => 'span4',)) ?>
        <div class="control-group">
            <?php echo Chtml::label("Status Advance Payment", 'statusadvancepayment', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->dropDownList($model, 'statusadvancepayment', array('LUNAS' => 'Lunas', 'BELUM LUNAS' => 'Belum Lunas'), array('empty' => 'Pilih', 'class' => 'span4',)) ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo Chtml::label("Status Pembatalan", 'statusbatal', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->dropDownList($model, 'statusbatal', array('BELUM DIBATALKAN' => 'Belum Dibatalkan', 'SUDAH DIBATALKAN' => 'Sudah Dibatalkan'), array('empty' => 'Pilih', 'class' => 'span4',)) ?>
            </div>
        </div>
    </div>
</div>
<div class="form-actions">
    <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')), array('class' => 'btn btn-danger', 'type' => 'submit')); ?>
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
        $this->createUrl($this->id . '/informasi'),
        array(
            'class' => 'btn btn-default',
            'onclick' => 'myConfirm("Apakah anda ingin mengulang ini ?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
        )
    ); ?>
    <?php
    // $content = $this->renderPartial('keuangan.views/tips/informasi',array(),true);
    // $this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
    ?>
</div>
<script>
    var profil = jQuery('#<?php echo CHtml::activeId($model, 'profilrs_id') ?>');
    $(document).ready(function() {
        jQuery(profil).multiselect({
            includeSelectAllOption: true,
            buttonClass: "form-control",
            maxHeight: 300,
            buttonWidth: '250px',
            enableCaseInsensitiveFiltering: true
        }).hide();
    });
</script>