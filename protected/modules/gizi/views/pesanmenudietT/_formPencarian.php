<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'id' => 'daftarPasien-form',
    'type' => 'horizontal',
    'focus' => '#' . CHtml::activeId($modelRawatInap, 'no_pendaftaran'),
    'htmlOptions' => array(),
)); ?>

<div class="row">
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo CHtml::label("Tgl. Masuk", 'tgl_pendaftaran', array('class' => 'control-label')) ?>
            <div class="controls">
                <div class="daterange daterange-inline input-inline span4" data-format="D MMMM YYYY" data-start-date="<?php echo date('d F Y', strtotime($modelRawatInap->tgl_awal)) ?>" data-end-date="<?php echo date('d F Y', strtotime($modelRawatInap->tgl_akhir)) ?>">
                    <i class="entypo-calendar"></i>
                    <span><?php echo date('d F Y', strtotime($modelRawatInap->tgl_awal)) ?> - <?php echo date('d F Y', strtotime($modelRawatInap->tgl_akhir)) ?></span>
                    <?php echo $form->hiddenField($modelRawatInap, 'tgl_awal', array('class' => 'start')) ?>
                    <?php echo $form->hiddenField($modelRawatInap, 'tgl_akhir', array('class' => 'end')) ?>
                </div>
            </div>
        </div>


        <div class="control-group">
            <?php echo Chtml::label("Nama Pasien", 'nama_pasien', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textField($modelRawatInap, 'nama_pasien', array('class' => 'span4 angkahuruf-only', 'maxlength' => 20, 'autofocus' => true, 'placeholder' => 'Nama Pasien')); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo Chtml::label("No Rekam Medik", 'no_rekam_medik', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textField($modelRawatInap, 'no_rekam_medik', array('class' => 'span4 angkahuruf-only', 'maxlength' => 20, 'autofocus' => true, 'placeholder' => 'No Rekam Medis')); ?>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <?php
        if (Yii::app()->user->getState('ruangan_id') == Params::RUANGAN_ID_GIZI) {
            echo $form->dropDownListRow(
                $modelRawatInap,
                'instalasi_id',
                Chtml::listData(InstalasiM::model()->findAll("instalasi_aktif = TRUE ORDER BY instalasi_nama ASC"), 'instalasi_id', 'instalasi_nama'),
                array(
                    'class' => 'span4', 'empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)",
                    'ajax' => array(
                        'type' => 'POST',
                        'url' => $this->createUrl('/ActionDynamic/GetRuanganDariInstalasi', array('encode' => false, 'namaModel' => get_class($modelRawatInap))),
                        'update' => "#" . CHtml::activeId($modelRawatInap, 'ruangan_id'),
                    )
                )
            );

        ?>
            <?php echo $form->dropDownListRow($modelRawatInap, 'ruangan_id', CHtml::listData(RuanganM::model()->findAll(" ruangan_aktif = TRUE ORDER BY ruangan_nama ASC "), 'ruangan_id', 'ruangan_nama'), array('empty' => '-- Pilih --', 'class' => 'span4')); ?>
        <?php

            //echo $form->dropDownListRow($modelRawatInap,'ruangan_id', CHtml::listData(RuanganM::model()->findAll('ruangan_aktif = true ORDER BY ruangan_nama ASC'), 'ruangan_id', 'ruangan_nama'),array('empty'=>'-- Pilih --','class'=>'span4', 'maxlength'=>20)); 
        } ?>

        <!--<div class ="control-group">-->
        <?php // echo Chtml::label("Jenis Pesanan", 'jenispesanmenu', array('class'=>'control-label')) 
        ?>
        <!--<div class="controls">-->
        <?php // echo $form->dropDownList($modelRawatInap,'jenispesanmenu', LookupM::getItems('jenispesanmenu'),array('empty'=>'-- Pilih --','class'=>'span4', 'maxlength'=>20)); 
        ?>
        <!--</div>-->
        <!--</div>-->


        <?php // echo $form->dropDownListRow($modelRawatInap, 'status_terima', Params::getStatusTerima(), array('class' => 'span4', 'empty' => '-- Pilih --')) 
        ?>
        <?php //echo $form->dropDownListRow($modelRawatInap,'sumberdanabhn', LookupM::getItems('sumberdanabahan'),array('empty'=>'-- Pilih --')); 
        ?>
    </div>
</div>


<div class="form-actions">
    <?php
    echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
        array('title' => 'Cari', 'class' => 'btn btn-danger', 'type' => 'submit', 'id' => 'btn_simpan')
    );
    echo CHtml::hiddenField('pendaftaran_id');
    echo CHtml::hiddenField('pasien_id');
    ?>
    <?php

    $back_url = Yii::app()->createUrl($this->module->id . '/' . Yii::app()->controller->id . '/' . Yii::app()->controller->action->id . '');
    echo CHtml::link(
        Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
        Yii::app()->createUrl($this->module->id . '/' . Yii::app()->controller->id . '/' . Yii::app()->controller->action->id . ''),
        array(
            'title' => 'Ulang',
            'class' => 'btn btn-default',
            'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = "' . $back_url . '";}); return false;'
        )
    ); ?>
    <?php
    // $content = $this->renderPartial('./tips/informasi', array(), true);
    // $this->widget('UserTips', array('type' => 'admin', 'content' => $content));
    ?>
</div>

<!--fieldset class="box"-->
<?php $this->endWidget(); ?>
<!--</fieldset>-->
<script>
    // document.getElementById('RIInfopasienmasukkamarV_tgl_awal_date').setAttribute("style","display:none;");
    // document.getElementById('RIInfopasienmasukkamarV_tgl_akhir_date').setAttribute("style","display:none;");
    function cekTanggal() {

        var checklist = $('#RIInfopasienmasukkamarV_ceklis');
        var pilih = checklist.attr('checked');
        if (pilih) {
            document.getElementById('RIInfopasienmasukkamarV_tgl_awal_date').setAttribute("style", "display:block;");
            document.getElementById('RIInfopasienmasukkamarV_tgl_akhir_date').setAttribute("style", "display:block;");
        } else {
            document.getElementById('RIInfopasienmasukkamarV_tgl_awal_date').setAttribute("style", "display:none;");
            document.getElementById('RIInfopasienmasukkamarV_tgl_akhir_date').setAttribute("style", "display:none;");
        }
    }
</script>