<style>
    #ruangan label {
        width: 200px;
        display: inline-block;
    }

    .radio input[type="radio"],
    .checkbox input[type="checkbox"] {
        float: none;
        margin-left: -18px;
    }

    input.multiselect-search {
        /*width:100px;*/
    }

    .btn-group .btn {
        position: relative;
        float: none;
    }

    .collapse.in,
    .collapse {
        z-index: 0;

    }

    .caret {
        margin: 6px;
    }
</style>
<script type="text/javascript">
    function reseting() {
        setTimeout(function() {
            $.fn.yiiGridView.update('lapegawai-m-grid', {
                data: $('#lapegawai-m-search').serialize()
            });
        }, 1000);

    }
</script>
<?php
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/js/bootstrap-multiselect/css/bootstrap-multiselect.css');
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/bootstrap-multiselect/js/bootstrap-multiselect.js', CClientScript::POS_END);

?>
<fieldset class="">

    <?php
    $form = $this->beginWidget(
        'ext.bootstrap.widgets.BootActiveForm',
        array(
            'action' => Yii::app()->createUrl($this->route),
            'method' => 'get',
            'id' => 'lapegawai-m-search',
            'type' => 'horizontal',
            'focus' => '#' . CHtml::activeId($model, 'nomorindukpegawai'),
        )
    );
    ?>
    <div class="row">
        <div class="col-sm-6">
            <div class="control-group">
                <?php echo CHtml::label("Periode Laporan", 'tglpresensi', array('class' => 'control-label')) ?>
                <div class="controls">
                    <div class="daterange daterange-inline add-ranges input-inline span4" data-format="DD MMM YYYY" data-start-date="<?php echo date('d M Y', strtotime($model->tglpresensi)) ?>" data-end-date="<?php echo date('d M Y', strtotime($model->tglpresensi_akhir)) ?>">
                        <i class="entypo-calendar"></i>
                        <span><?php echo date('d M Y', strtotime($model->tglpresensi)) ?> - <?php echo date('d M Y', strtotime($model->tglpresensi_akhir)) ?></span>
                        <?php echo $form->hiddenField($model, 'tglpresensi', array('class' => 'start')) ?>
                        <?php echo $form->hiddenField($model, 'tglpresensi_akhir', array('class' => 'end')) ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="clear"></div>

        <div class="col-sm-6">
            <?php echo $form->textFieldRow($model, 'nomorindukpegawai', array('placeholder' => 'NIP', 'class' => 'span3', 'maxlength' => 30)); ?>

            <?php echo $form->textFieldRow($model, 'nama_pegawai', array('placeholder' => 'Nama Pegawai', 'class' => 'span3', 'maxlength' => 50)); ?>
        </div>
        <div class="col-sm-6">
            <?php echo $form->dropDownListRow($model, 'kelompokpegawai_id', CHtml::listData(KelompokpegawaiM::model()->findAll('kelompokpegawai_aktif = true ORDER BY kelompokpegawai_nama ASC'), 'kelompokpegawai_id', 'kelompokpegawai_nama'), array('class' => 'span3', 'empty' => '-- Pilih --', 'ajax' => array(
                'type' => 'POST',
                'url' =>  CController::createUrl('/ActionDynamic/AllPegawai'),
                'success' => 'function(data) {updatePegawai(data);}'
            ))); ?>
            <?php echo $form->dropDownListRow($model, 'jabatan_id', CHtml::listData(JabatanM::model()->findAll('jabatan_aktif = true ORDER BY jabatan_nama ASC'), 'jabatan_id', 'jabatan_nama'), array(
                'class' => 'span3', 'maxlength' => 50, 'empty' => '-- Pilih --',
                'ajax' => array(
                    'type' => 'POST',
                    'url' =>  CController::createUrl('/ActionDynamic/AllPegawai'),
                    'success' => 'function(data) {updatePegawai(data);}'
                )
            )); ?>

            <?php /*echo $form->dropDownListRow($model,'ruangan_id',CHtml::listData(RuanganM::model()->findAll('ruangan_aktif = true ORDER BY ruangan_nama ASC'), 'ruangan_id', 'ruangan_nama'),array(
                'class'=>'span3',
                'maxlength'=>50, 
                'empty'=>'-- Pilih --',
                'ajax'=>array(
                    'type'=>'POST',
                    'url'=>  CController::createUrl('/ActionDynamic/AllPegawai'),
                    'success'=>'function(data) {updatePegawai(data);}')
                )
            );*/ ?>

        </div>
    </div>

    <div class="form-actions">
        <?php
        echo CHtml::htmlButton(
            Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
            array('title' => 'Cari', 'class' => 'btn btn-danger', 'type' => 'submit')
        );
        // echo CHtml::link(
        //     Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
        //     $this->createUrl('Laporan/LaporanPegawai'),
        //     array('title' => 'Ulang', 'class' => 'btn btn-default')
        // );
        // 
        ?>
        <?php echo CHtml::htmlButton(
            Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
            array(
                'title' => 'Ulang', 'class' => 'btn btn-default', 'type' => 'reset',
                'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
            )
        ); ?>
    </div>
    <?php $this->endWidget(); ?>
</fieldset>
<?php
Yii::app()->clientScript->registerScript('search', "
$('#lapegawai-m-search').submit(function(){
    $.fn.yiiGridView.update('lapegawai-m-grid', {
            data: $(this).serialize()
    });
    return false;
});
");
?>

<script>
    $(document).ready(function() {
        jQuery("#PegawaiM_pegawai_id").multiselect({
            includeSelectAllOption: true,
            buttonClass: "btn-dropdown",
            maxHeight: 300,
            buttonWidth: '140px',
            enableCaseInsensitiveFiltering: true,
        }).hide();
    });

    function updatePegawai(data) {

        $('#PegawaiM_pegawai_id').html(data);
        $('#PegawaiM_pegawai_id').multiselect('rebuild');
        jQuery("#PegawaiM_pegawai_id").multiselect({
            includeSelectAllOption: true,
            buttonClass: "btn-dropdown",
            maxHeight: 300,
            buttonWidth: '140px',
            enableCaseInsensitiveFiltering: true,
        }).hide();
    }
</script>