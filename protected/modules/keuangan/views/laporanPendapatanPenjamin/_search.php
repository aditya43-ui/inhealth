<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-search"></i> Pencarian
        </div>
    </div>
    <div class="panel-body">
        <div class="search-form">
            <?php
            $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
                'action' => Yii::app()->createUrl($this->route),
                'method' => 'get',
                'type' => 'horizontal',
                'id' => 'searchLaporan',
                'htmlOptions' => array('enctype' => 'multipart/form-data', 'onKeyPress' => 'return disableKeyPress(event)'),
            ));
            ?>
            <style>
                #penjamin label.checkbox {
                    width: 100px;
                    display: inline-block;
                }
            </style>
            <div class="row">
                <div class="col-sm-12">
                    <?php echo CHtml::hiddenField('type', ''); ?>
                    <?php echo CHtml::hiddenField('filter_tab', 'rekap', array()); ?>
                    <div class="control-group">
                        <?php echo $form->hiddenField($model, 'jns_periode', array('class' => 'span2')); ?>
                        <?php echo $form->hiddenField($model, 'bln_awal', array('class' => 'span2')); ?>
                        <?php echo $form->hiddenField($model, 'bln_akhir', array('class' => 'span2')); ?>
                        <?php echo $form->hiddenField($model, 'thn_awal', array('class' => 'span2')); ?>
                        <?php echo $form->hiddenField($model, 'thn_akhir', array('class' => 'span2')); ?>
                        <?php echo CHtml::label("Periode Laporan", 'tgl_rekam', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <div class="daterange daterange-inline add-ranges input-inline span4" data-format="DD MMM YYYY" data-start-date="<?php echo date('d M Y', strtotime($model->tgl_awal)) ?>" data-end-date="<?php echo date('d M Y', strtotime($model->tgl_akhir)) ?>">
                                <i class="entypo-calendar"></i>
                                <span><?php echo date('d M Y', strtotime($model->tgl_awal)) ?> - <?php echo date('d M Y', strtotime($model->tgl_akhir)) ?></span>
                                <?php echo $form->hiddenField($model, 'tgl_awal', array('class' => 'start')) ?>
                                <?php echo $form->hiddenField($model, 'tgl_akhir', array('class' => 'end')) ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <?php
                    echo CHtml::hiddenField('filter', 'carabayar', array('disabled' => 'disabled')) .
                        '<div class="control-group">
                            ' . CHtml::label('Jenis Penjamin', 'carabayar_id', array('class' => 'control-label')) . ' 
                            <div class="controls">
                                ' . $form->dropDownList($model, 'carabayar_id', CHtml::listData(CarabayarM::model()->findAll('carabayar_aktif = true ORDER BY carabayar_nama ASC'), 'carabayar_id', 'carabayar_nama'), array(
                            'class' => 'form-control', 'multiple' => 'multiple'
                        )) . '
                            </div>
                        </div>';
                    ?>
                </div>
                <div class="col-sm-6">
                    <?php
                    echo '<div class="control-group">
                ' . CHtml::label('Penjamin', 'penjamin_id', array('class' => 'control-label')) . ' 
                <div class="controls">												 
                    ' . $form->dropDownList(
                        $model,
                        'penjamin_id',
                        array(),
                        array('class' => 'form-control', 'multiple' => 'multiple')
                    ) . '
                </div>
            </div>';
                    ?>
                </div>
            </div>

            <!--<div class="row">
                <div class="col-sm-6">
                    <?php
                    $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
                        'id' => 'kunjungan',
                        'slide' => true,
                        'content' => array(
                            'content2' => array(
                                'multi' => 'multi',
                                'header' => 'Berdasarkan Jenis Penjamin',
                                'isi' => CHtml::hiddenField('filter', 'carabayar', array('disabled' => 'disabled')) .
                                    '<div class="control-group">
												' . CHtml::label('Jenis Penjamin', 'carabayar_id', array('class' => 'control-label')) . ' 
												<div class="controls">
													' . $form->dropDownList($model, 'carabayar_id', CHtml::listData(CarabayarM::model()->findAll('carabayar_aktif = true ORDER BY carabayar_nama ASC'), 'carabayar_id', 'carabayar_nama'), array(
                                        'class' => 'form-control', 'multiple' => 'multiple'
                                    )) . '
												</div>
											</div>
											<div class="control-group">
												' . CHtml::label('Penjamin', 'penjamin_id', array('class' => 'control-label')) . ' 
												<div class="controls">												 
													' . $form->dropDownList(
                                        $model,
                                        'penjamin_id',
                                        array(),
                                        array('class' => 'form-control', 'multiple' => 'multiple')
                                    ) . '
												</div>
											</div>',
                                'active' => true,
                            ),
                        ),
                        //                                    'htmlOptions'=>array('class'=>'aw',)
                    ));
                    ?>
                </div>
            </div>-->
            <div class="form-actions">
                <?php echo CHtml::htmlButton(
                    Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
                    array('title' => 'Cari', 'class' => 'btn btn-danger', 'type' => 'submit', 'id' => 'btn_simpan')
                );
                ?>
                <?php
                echo CHtml::link(
                    Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
                    Yii::app()->createUrl($this->module->id . '/' . Yii::app()->controller->id . '/' . Yii::app()->controller->action->id . ''),
                    array(
                        'title' => 'Ulang',
                        'class' => 'btn btn-default',
                        'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
                    )
                );
                ?>
            </div>
        </div>
        <?php
        $this->endWidget();
        $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
        $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
        $urlPrintLembarPoli = Yii::app()->createUrl('print/lembarPoliRJ', array('pendaftaran_id' => '')); ?>

        <?php Yii::app()->clientScript->registerScript('cekAll', '
  $("#big").find("input").attr("checked", "checked");
  $("#kelasPelayanan").find("input").attr("checked", "checked");
',  CClientScript::POS_READY);
        ?>
        <?php
        $urlPeriode = Yii::app()->createUrl('actionAjax/GantiPeriode');
        $js = <<< JSCRIPT

function setPeriode(){
    namaPeriode = $('#PeriodeName').val();
    
        $.post('${urlPeriode}',{namaPeriode:namaPeriode},function(data){
            $('#KULaporanrekappendapatanV_tgl_awal').val(data.periodeawal);
            $('#KULaporanrekappendapatanV_tgl_akhir').val(data.periodeakhir);
        },'json');
}
JSCRIPT;
        Yii::app()->clientScript->registerScript('setPeriode', $js, CClientScript::POS_HEAD);
        ?>
        <script>
            function checkPilihan(event) {
                var namaPeriode = $('#PeriodeName').val();

                if (namaPeriode == '') {
                    myAlert('Silakan pilih kategori pencarian!');
                    event.preventDefault();
                    $('#dtPicker3').datepicker("hide");
                    return true;;
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
                ubahJnsPeriode();

                var cara = jQuery('#<?php echo CHtml::activeId($model, 'carabayar_id') ?>');
                var penj = jQuery('#<?php echo CHtml::activeId($model, 'penjamin_id') ?>');

                jQuery(cara).multiselect({
                    includeSelectAllOption: true,
                    buttonClass: "form-control",
                    maxHeight: 300,
                    buttonWidth: '182px',
                    enableCaseInsensitiveFiltering: true,
                    onChange: function(element, checked) {
                        var cara = jQuery('#<?php echo CHtml::activeId($model, 'carabayar_id') ?>');
                        var cara_all = jQuery('#<?php echo CHtml::activeId($model, 'carabayar_id') ?>   option:selected');
                        var penj = jQuery('#<?php echo CHtml::activeId($model, 'penjamin_id') ?>');

                        var brands = cara_all;
                        var selected = [];

                        $(brands).each(function(index, brand) {
                            selected.push($(this).val());
                        });

                        penj.addClass('animation-loading');
                        //alert(selected);

                        jQuery.ajax({
                            type: 'POST',
                            url: '<?php echo $this->createUrl('/ActionDynamic/GetPenjaminByMultiSelect') ?>',
                            dataType: "json",
                            data: {
                                carabayar_id: selected
                            },
                            success: function(data) {

                                if (data.sukses != '1') {

                                    //toastr.error(data.pesan);
                                    penj.addClass('animation-loading');
                                } else {
                                    //alert(data.ruangan);
                                    penj.html(data.penjamin);
                                    penj.multiselect('rebuild');
                                    penj.removeClass('animation-loading');
                                }
                            },
                            error: function(jqXHR, textStatus, errorThrown) {
                                console.log(errorThrown);

                            }
                        });

                    },
                    onSelectAll: function() {
                        var cara = jQuery('#<?php echo CHtml::activeId($model, 'carabayar_id') ?>');
                        var cara_all = jQuery('#<?php echo CHtml::activeId($model, 'carabayar_id') ?>   option:selected');
                        var penj = jQuery('#<?php echo CHtml::activeId($model, 'penjamin_id') ?>');

                        var brands = ins_all;
                        var selected = [];

                        $(brands).each(function(index, brand) {
                            selected.push($(this).val());
                        });

                        penj.addClass('animation-loading');

                        jQuery.ajax({
                            type: 'POST',
                            url: '<?php echo $this->createUrl('/ActionDynamic/GetRuanganByMultiSelect') ?>',
                            dataType: "json",
                            data: {
                                carabayar_id: selected
                            },
                            success: function(data) {

                                if (data.sukses != '1') {

                                    //toastr.error(data.pesan);
                                    penj.addClass('animation-loading');
                                } else {
                                    //alert(data.ruangan);
                                    penj.html(data.penjaminan);
                                    penj.multiselect('rebuild');
                                    penj.removeClass('animation-loading');
                                }
                            },
                            error: function(jqXHR, textStatus, errorThrown) {
                                console.log(errorThrown);

                            }
                        });

                    },
                    onDeselectAll: function() {
                        var cara = jQuery('#<?php echo CHtml::activeId($model, 'carabayar_id') ?>');
                        var cara_all = jQuery('#<?php echo CHtml::activeId($model, 'carabayar_id') ?>   option:selected');
                        var penj = jQuery('#<?php echo CHtml::activeId($model, 'penjamin_id') ?>');

                        var brands = ins_all;
                        var selected = '';


                        penj.addClass('animation-loading');

                        jQuery.ajax({
                            type: 'POST',
                            url: '<?php echo $this->createUrl('/ActionDynamic/GetRuanganByMultiSelect') ?>',
                            dataType: "json",
                            data: {
                                carabayar_id: selected
                            },
                            success: function(data) {

                                if (data.sukses != '1') {

                                    //toastr.error(data.pesan);
                                    penj.addClass('animation-loading');
                                } else {
                                    //alert(data.ruangan);
                                    penj.html(data.penjamin);
                                    penj.multiselect('rebuild');
                                    penj.removeClass('animation-loading');
                                }
                            },
                            error: function(jqXHR, textStatus, errorThrown) {
                                console.log(errorThrown);

                            }
                        });

                    }
                }).hide();

                jQuery(penj).multiselect({
                    includeSelectAllOption: true,
                    buttonClass: "form-control",
                    maxHeight: 300,
                    buttonWidth: '182px',
                    enableCaseInsensitiveFiltering: true
                }).hide();

            });
        </script>
    </div>
</div>