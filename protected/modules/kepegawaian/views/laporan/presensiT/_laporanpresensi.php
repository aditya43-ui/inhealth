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
        width: 100px;
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
<?php
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/js/bootstrap-multiselect/css/bootstrap-multiselect.css');
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/bootstrap-multiselect/js/bootstrap-multiselect.js', CClientScript::POS_END);

?>
<!--div class="white-container"-->

<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-newspaper"></i> Laporan <b>Presensi</b>
        </div>
    </div>
    <div class="panel-body">
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-search"></i> Pencarian
                </div>
            </div>
            <div class="panel-body">
                <fieldset class="">
                    <?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
                        'action' => Yii::app()->createUrl($this->route),
                        'method' => 'get',
                        'id' => 'laporan-search',
                        'type' => 'horizontal',
                        'focus' => '#' . CHtml::activeId($model, 'nama_pegawai'),
                    )); ?>
                    <div class="row">
                        <div class="col-sm-6">
                            <?php /*
                                    <div class="control-group">
                                        <?php echo $form->labelEx($model, 'tglpresensi', array('class' => 'control-label')); ?>
                                        <div class="controls">
                                        <?php $this->widget('MyDateTimePicker',array(
                                            'model'=>$model,
                                            'attribute'=>'tglpresensi',
                                            'mode'=>'date',
                                            'options'=> array(
                                                'dateFormat'=>Params::DATE_FORMAT,
                                            ),
                                            'htmlOptions'=>array('readonly'=>true,
                                                'onkeypress'=>"return $(this).focusNextInputField(event)",
                                                'class'=>'span4 dtPicker3',
                                            ),
                                        )); ?> 
                                        </div>
                                    </div>
									 * 
									 */ ?>
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
                        <div class="col-sm-6">
                            <?php /*
                                    <div class="control-group">
                                        <?php echo $form->labelEx($model, 'tglpresensi_akhir', array('class' => 'control-label')); ?>
                                        <div class="controls">
                                            <?php $this->widget('MyDateTimePicker',array(
                                                'model'=>$model,
                                                'attribute'=>'tglpresensi_akhir',
                                                'mode'=>'date',
                                                'options'=> array(
                                                    'dateFormat'=>Params::DATE_FORMAT,
                                                    'changeYear'=>true,
                                                    'changeMonth'=>true,
                                                    'yearRange'=>'-70y:+4y',
                                                    'maxDate'=>'d',
                                                    'showAnim'=>'fold',
                                                    'timeText'=>'Waktu',
                                                    'hourText'=>'Jam',
                                                    'minuteText'=>'Menit',
                                                    'secondText'=>'Detik',
                                                    'showSecond'=>true,
                                                    'timeFormat'=>'hh:mm:ss',

                                                ),
                                                'htmlOptions'=>array('readonly'=>true,
                                                    'onkeypress'=>"return $(this).focusNextInputField(event)",
                                                    'class'=>'span4 dtPicker3',
                                                 ),
                                            )); ?> 
                                        </div>
                                    </div> 
									 * 
									 */ ?>
                            <?php //echo $form->textFieldRow($model,'nama_pegawai',array('class'=>'span4','maxlength'=>30)); 
                            ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <?php echo $form->textFieldRow($model, 'no_fingerprint', array('placeholder' => 'No Finger Print', 'class' => 'span4', 'maxlength' => 30)); ?>

                            <?php echo $form->textFieldRow($model, 'nama_pegawai', array('placeholder' => 'Nama Pegawai', 'class' => 'span4', 'maxlength' => 30)); ?>

                            <div class="control-group">
                                <?php echo CHtml::label("Shift Kerja", 'shift', array('class' => 'control-label')); ?>
                                <div class="controls">
                                    <?php
                                    echo $form->dropDownList(
                                        $model,
                                        'shift_id',
                                        CHtml::listData(ShiftM::model()->findAll("shift_aktif = TRUE ORDER BY shift_nama ASC "), 'shift_id', 'shiftJam'),
                                        array(
                                            'onkeypress' => "return $(this).focusNextInputField(event)", 'multiple' => 'multiple',
                                        )
                                    );
                                    ?>
                                </div>
                            </div>

                            <div class="control-group">
                                <?php echo CHtml::label("Jabatan", 'shift', array('class' => 'control-label')); ?>
                                <div class="controls">
                                    <?php
                                    echo $form->dropDownList(
                                        $model,
                                        'jabatan_id',
                                        CHtml::listData(JabatanM::model()->findAll("jabatan_aktif = TRUE ORDER BY jabatan_nama ASC "), 'jabatan_id', 'jabatan_nama'),
                                        array(
                                            'onkeypress' => "return $(this).focusNextInputField(event)", 'multiple' => 'multiple',
                                        )
                                    );
                                    ?>
                                </div>
                            </div>
                            <div class="control-group">
                                <?php echo CHtml::label("Instalasi", 'instalasi', array('class' => 'control-label')); ?>
                                <div class="controls">
                                    <?php
                                    echo $form->dropDownList(
                                        $model,
                                        'instalasi_id',
                                        CHtml::listData(InstalasiM::model()->findAll(" instalasi_aktif = TRUE ORDER BY instalasi_nama ASC "), 'instalasi_id', 'instalasi_nama'),
                                        array(
                                            'onkeypress' => "return $(this).focusNextInputField(event)", 'multiple' => 'multiple',
                                        )
                                    );
                                    ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">

                            <div class="control-group">
                                <?php echo CHtml::label("Ruangan", 'ruangan', array('class' => 'control-label')); ?>
                                <div class="controls">
                                    <?php
                                    echo $form->dropDownList(
                                        $model,
                                        'ruangan_id',
                                        array(),
                                        array(
                                            'onkeypress' => "return $(this).focusNextInputField(event)", 'multiple' => 'multiple',
                                        )
                                    );
                                    ?>
                                </div>
                            </div>

                            <?php
                            echo $form->dropDownListRow(
                                $model,
                                'kategoripegawai',
                                LookupM::model()->GetItems('kategoripegawai'),
                                array(
                                    'onkeypress' => "return $(this).focusNextInputField(event)", 'multiple' => 'multiple',
                                )
                            );
                            ?>

                            <div class="control-group">
                                <?php echo CHtml::label("Kelompok Pegawai", 'kelompokpegawai', array('class' => 'control-label')); ?>
                                <div class="controls">
                                    <?php
                                    echo $form->dropDownList(
                                        $model,
                                        'kelompokpegawai_id',
                                        CHtml::listData(KelompokpegawaiM::model()->getNonDokter(), 'kelompokpegawai_id', 'kelompokpegawai_nama'),
                                        array(
                                            'onkeypress' => "return $(this).focusNextInputField(event)", 'multiple' => 'multiple',
                                        )
                                    );
                                    ?>
                                </div>
                            </div>

                            <div class="control-group">
                                <?php echo CHtml::label("Status Kehadiran", 'statuskehadiran_id', array('class' => 'control-label')); ?>
                                <div class="controls">
                                    <?php echo $form->dropDownList($model, 'statuskehadiran_id', CHtml::listData(
                                        StatuskehadiranM::model()->findAllByAttributes(array(
                                            'statuskehadiran_aktif' => true,
                                        ), array(
                                            'order' => 'statuskehadiran_nama',
                                        )),
                                        'statuskehadiran_id',
                                        'statuskehadiran_nama'
                                    ), array(
                                        'multiple' => 'multiple'
                                    )); // 'multiple'=>'multiple' 
                                    ?>
                                </div>
                            </div>

                            <div class="control-group">
                                <?php echo CHtml::label("Status Scan", 'shift_id', array('class' => 'control-label')); ?>
                                <div class="controls">
                                    <?php echo $form->dropDownList($model, 'statusscan', Params::getDropStatusScan(), array(
                                        'class' => 'span2', 'multiple' => 'multiple'
                                    )); // 'multiple'=>'multiple' 
                                    ?>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="form-actions">
                        <?php echo CHtml::htmlButton(
                            Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
                            array('title' => 'Cari', 'class' => 'btn btn-danger', 'type' => 'submit')
                        ); ?>
                        <!-- <?php echo CHtml::link(
                            Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
                            $this->createUrl('Laporan/LaporanPresensi'),
                            array('title' => 'Ulang', 'class' => 'btn btn-default')
                        ); ?> -->
                        <?php echo CHtml::htmlButton(
                            Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
                            array(
                                'title' => 'Ulang', 'class' => 'btn btn-default', 'type' => 'reset',
                                'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
                            )
                        ); ?>
                    </div>
                </fieldset>
                <?php
                $this->endWidget();
                ?>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Presensi</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php $this->renderPartial('presensiT/laporanBaru', array('model' => $model)); ?>
            </div>
        </div>
        <?php
        $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
        $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
        $urlPrint =  Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/PrintLaporanPresensi');
        $url = '';
        $this->renderPartial('_footerPresensi', array('urlPrint' => $urlPrint, 'url' => $url));
        ?>
    </div>
</div>
</div>

<!--/div-->
<script type="text/javascript">
    function checkAll() {
        if ($("#checkAllRuangan").is(':checked')) {
            $("#ruangan").find("input[type=\'checkbox\']").attr("checked", "checked");
        } else {
            $("#ruangan").find("input[type=\'checkbox\']").attr("checked", false);
        }

    }

    function ubahJnsPeriode() {
        var obj = $("#<?php echo CHtml::activeId($model, 'jns_periode') ?>");
        if (obj.val() == 'hari') {
            $('.hari').show();
            $('.bulan').hide();
            $('.tahun').hide();
        } else if (obj.val() == 'bulan') {
            $('.hari').hide();
            $('.bulan').show();
            $('.tahun').hide();
        } else if (obj.val() == 'tahun') {
            $('.hari').hide();
            $('.bulan').hide();
            $('.tahun').show();
        }
    }

    $(document).ready(function() {
        var ins = jQuery('#<?php echo CHtml::activeId($model, 'instalasi_id') ?>');
        var ru = jQuery('#<?php echo CHtml::activeId($model, 'ruangan_id') ?>');
        var shift_id = jQuery('#<?php echo CHtml::activeId($model, 'shift_id') ?>');
        var jab = jQuery('#<?php echo CHtml::activeId($model, 'jabatan_id') ?>');
        var kategoripegawai = jQuery('#<?php echo CHtml::activeId($model, 'kategoripegawai') ?>');
        var kelompokpegawai_id = jQuery('#<?php echo CHtml::activeId($model, 'kelompokpegawai_id') ?>');
        var statusscan = jQuery('#<?php echo CHtml::activeId($model, 'statusscan') ?>');
        var statuskehadiran_id = jQuery('#<?php echo CHtml::activeId($model, 'statuskehadiran_id') ?>');

        jQuery(ins).multiselect({
            includeSelectAllOption: true,
            buttonClass: "form-control",
            maxHeight: 300,
            buttonWidth: '182px',
            enableCaseInsensitiveFiltering: true,
            onChange: function(element, checked) {
                var ins = jQuery('#<?php echo CHtml::activeId($model, 'instalasi_id') ?>');
                var ins_all = jQuery('#<?php echo CHtml::activeId($model, 'instalasi_id') ?>   option:selected');
                var ru = jQuery('#<?php echo CHtml::activeId($model, 'ruangan_id') ?>');

                var brands = ins_all;
                var selected = [];

                $(brands).each(function(index, brand) {
                    selected.push($(this).val());
                });

                ru.addClass('animation-loading');
                //alert(selected);

                jQuery.ajax({
                    type: 'POST',
                    url: '<?php echo $this->createUrl('/ActionDynamic/GetRuanganByMultiSelect') ?>',
                    dataType: "json",
                    data: {
                        instalasi_id: selected
                    },
                    success: function(data) {

                        if (data.sukses != '1') {

                            //toastr.error(data.pesan);
                            ru.addClass('animation-loading');
                        } else {
                            //alert(data.ruangan);
                            ru.html(data.ruangan);
                            ru.multiselect('rebuild');
                            ru.removeClass('animation-loading');
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log(errorThrown);

                    }
                });

            },
            onSelectAll: function() {
                var ins = jQuery('#<?php echo CHtml::activeId($model, 'instalasi_id') ?>');
                var ins_all = jQuery('#<?php echo CHtml::activeId($model, 'instalasi_id') ?>   option:selected');
                var ru = jQuery('#<?php echo CHtml::activeId($model, 'ruangan_id') ?>');

                var brands = ins_all;
                var selected = [];

                $(brands).each(function(index, brand) {
                    selected.push($(this).val());
                });

                ru.addClass('animation-loading');

                jQuery.ajax({
                    type: 'POST',
                    url: '<?php echo $this->createUrl('/ActionDynamic/GetRuanganByMultiSelect') ?>',
                    dataType: "json",
                    data: {
                        instalasi_id: selected
                    },
                    success: function(data) {

                        if (data.sukses != '1') {

                            //toastr.error(data.pesan);
                            ru.addClass('animation-loading');
                        } else {
                            //alert(data.ruangan);
                            ru.html(data.ruangan);
                            ru.multiselect('rebuild');
                            ru.removeClass('animation-loading');
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log(errorThrown);

                    }
                });

            },
            onDeselectAll: function() {
                var ins = jQuery('#<?php echo CHtml::activeId($model, 'instalasi_id') ?>');
                var ins_all = jQuery('#<?php echo CHtml::activeId($model, 'instalasi_id') ?>   option:selected');
                var ru = jQuery('#<?php echo CHtml::activeId($model, 'ruangan_id') ?>');

                var brands = ins_all;
                var selected = '';


                ru.addClass('animation-loading');

                jQuery.ajax({
                    type: 'POST',
                    url: '<?php echo $this->createUrl('/ActionDynamic/GetRuanganByMultiSelect') ?>',
                    dataType: "json",
                    data: {
                        instalasi_id: selected
                    },
                    success: function(data) {

                        if (data.sukses != '1') {

                            //toastr.error(data.pesan);
                            ru.addClass('animation-loading');
                        } else {
                            //alert(data.ruangan);
                            ru.html(data.ruangan);
                            ru.multiselect('rebuild');
                            ru.removeClass('animation-loading');
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log(errorThrown);

                    }
                });

            }
        }).hide();

        jQuery(ru).multiselect({
            includeSelectAllOption: true,
            buttonClass: "form-control",
            maxHeight: 300,
            buttonWidth: '182px',
            enableCaseInsensitiveFiltering: true
        }).hide();

        jQuery(shift_id).multiselect({
            includeSelectAllOption: true,
            buttonClass: "form-control",
            maxHeight: 300,
            buttonWidth: '182px',
            enableCaseInsensitiveFiltering: true
        }).hide();

        jQuery(jab).multiselect({
            includeSelectAllOption: true,
            buttonClass: "form-control",
            maxHeight: 300,
            buttonWidth: '182px',
            enableCaseInsensitiveFiltering: true
        }).hide();

        jQuery(kategoripegawai).multiselect({
            includeSelectAllOption: true,
            buttonClass: "form-control",
            maxHeight: 300,
            buttonWidth: '182px',
            enableCaseInsensitiveFiltering: true
        }).hide();

        jQuery(kelompokpegawai_id).multiselect({
            includeSelectAllOption: true,
            buttonClass: "form-control",
            maxHeight: 300,
            buttonWidth: '182px',
            enableCaseInsensitiveFiltering: true
        }).hide();

        jQuery(statuskehadiran_id).multiselect({
            includeSelectAllOption: true,
            buttonClass: "form-control",
            maxHeight: 300,
            buttonWidth: '182px',
            enableCaseInsensitiveFiltering: true
        }).hide();

        jQuery(statusscan).multiselect({
            includeSelectAllOption: true,
            buttonClass: "form-control",
            maxHeight: 300,
            buttonWidth: '182px',
            enableCaseInsensitiveFiltering: true
        }).hide();
    });
</script>