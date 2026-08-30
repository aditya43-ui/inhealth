<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-search"></i> Pencarian
        </div>
    </div>

    <style>
        .form-horizontal .radio>label,
        .form-horizontal .checkbox>label {
            float: left !important;
            margin-left: 5px !important;
            padding: 0 !important;
        }

        .form-horizontal .radio>input,
        .form-horizontal .checkbox>input {
            float: left !important;
            margin-top: 2px !important;
        }
    </style>

    <div class="panel-body box">
        <div class="search-form">
            <?php
            $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
                'action' => Yii::app()->createUrl($this->route),
                'method' => 'get',
                'type' => 'horizontal',
                'id' => 'laporan-search',
                'htmlOptions' => array('enctype' => 'multipart/form-data', 'onKeyPress' => 'return disableKeyPress(event)'),
            ));
            ?>
            <style>
                #penjamin label.checkbox {
                    width: 200px;
                    display: inline-block;
                }

                label.checkbox,
                label.radio {
                    width: 260px;
                    display: inline-block;
                }
            </style>

            <div class="row">
                <div class="col-sm-6">
                    <div class="control-group">
                        <?php echo $form->hiddenField($model, 'jns_periode', array('class' => 'span2')); ?>
                        <?php echo $form->hiddenField($model, 'bln_awal', array('class' => 'span2')); ?>
                        <?php echo $form->hiddenField($model, 'bln_akhir', array('class' => 'span2')); ?>
                        <?php echo $form->hiddenField($model, 'thn_awal', array('class' => 'span2')); ?>
                        <?php echo $form->hiddenField($model, 'thn_akhir', array('class' => 'span2')); ?>
                        <?php echo CHtml::label("Periode Laporan", 'dari_tanggal', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <div class="daterange daterange-inline add-ranges input-inline span4" data-format="DD MMM YYYY" data-start-date="<?php echo date('d M Y', strtotime($model->tgl_awal)) ?>" data-end-date="<?php echo date('d M Y', strtotime($model->tgl_akhir)) ?>">
                                <i class="entypo-calendar"></i>
                                <span><?php echo date('d M Y', strtotime($model->tgl_awal)) ?> - <?php echo date('d M Y', strtotime($model->tgl_akhir)) ?></span>
                                <?php echo $form->hiddenField($model, 'tgl_awal', array('class' => 'start')) ?>
                                <?php echo $form->hiddenField($model, 'tgl_akhir', array('class' => 'end')) ?>
                            </div>
                        </div>
                    </div>

                    <div class="control-group">
                        <?php echo Chtml::label("No. Faktur", 'nofaktur', array('class' => 'control-label')); ?>
                        <div class="controls">
                            <?php echo $form->textField($model, 'nofaktur', array('class' => 'span4', 'placeholder' => 'No. Faktur',)) ?>
                        </div>
                    </div>

                    <?php
                    echo CHtml::hiddenField('filter', 'instalasi_id', array('disabled' => 'disabled')) .
                        '<div class="control-group">
                    ' . CHtml::label('Instalasi', 'instalasi_id', array('class' => 'control-label')) . ' 
                    <div class="controls">
                        ' . $form->dropDownList($model, 'instalasi_id', CHtml::listData(InstalasiM::model()->findAll('instalasi_aktif = true ORDER BY instalasi_nama ASC'), 'instalasi_id', 'instalasi_nama'), array(
                            'class' => 'form-control', 'multiple' => 'multiple'
                        )) . '
                    </div>
                </div>
                <div class="control-group">
                    ' . CHtml::label('Ruangan', 'ruangan_id', array('class' => 'control-label')) . ' 
                    <div class="controls">												 
                        ' . $form->dropDownList(
                            $model,
                            'ruangan_id',
                            array(),
                            array('class' => 'form-control', 'multiple' => 'multiple')
                        ) . '
                    </div>
                </div>';
                    ?>
                </div>
                <!--<div class="col-sm-6">
                    <div id='searching'>
                        <?php
                        $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
                            'id' => 'instalasi',
                            'slide' => true,
                            'content' => array(
                                'content3' => array(
                                    'multi' => 'multi',
                                    'header' => 'Berdasarkan Instalasi dan Ruangan',
                                    'isi' => CHtml::hiddenField('filter', 'instalasi_id', array('disabled' => 'disabled')) .
                                        '<div class="control-group">
										' . CHtml::label('Instalasi', 'instalasi_id', array('class' => 'control-label')) . ' 
										<div class="controls">
											' . $form->dropDownList($model, 'instalasi_id', CHtml::listData(InstalasiM::model()->findAll('instalasi_aktif = true ORDER BY instalasi_nama ASC'), 'instalasi_id', 'instalasi_nama'), array(
                                            'class' => 'form-control', 'multiple' => 'multiple'
                                        )) . '
										</div>
									</div>
									<div class="control-group">
										' . CHtml::label('Ruangan', 'ruangan_id', array('class' => 'control-label')) . ' 
										<div class="controls">												 
											' . $form->dropDownList(
                                            $model,
                                            'ruangan_id',
                                            array(),
                                            array('class' => 'form-control', 'multiple' => 'multiple')
                                        ) . '
										</div>
									</div>',
                                    'active' => true,
                                ),
                            ),
                        ));
                        ?>
                    </div>
                </div>-->
                <div class="col-sm-6">
                    <div id='searching'>
                        <fieldset>
                            <?php
                            $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
                                'id' => 'kunjungan',
                                'slide' => true,
                                'content' => array(
                                    'content1' => array(
                                        'header' => 'Berdasarkan Supplier',
                                        'isi' => '  <table><tr></tr></table>
                                            <table class="supplier">                                            
                                            <tr>
                                                    <td><div class="controls">' . CHtml::hiddenField('filter', 'supplier') .
                                            CHtml::checkBox('pilihSemua', true, array('onclick' => 'checkAllSupplier();')) . '<label><b>Pilih Semua</b></label>
                                                            <div id="checkBoxSupplier">
                                                                ' . $form->checkBoxList($model, 'supplier_id', CHtml::listData(SupplierM::model()->getSupplierUmumItems(), 'supplier_id', 'supplier_nama'), array('class' => 'suplier')) . '<br>
                                                            </div>                
                                                        </div>
                                                    </td>
                                            </tr>
                                            </table>',
                                        'active' => false,
                                    ),
                                ),
                                //                                    'htmlOptions'=>array('class'=>'aw',)
                            ));
                            ?>
                        </fieldset>
                    </div>
                </div>
            </div>

            <div class="form-actions">
                <?php
                echo CHtml::htmlButton(
                    Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
                    array(
                        'title' => 'Cari',
                        'class' => 'btn btn-danger',
                        'type' => 'submit', 'id' => 'btn_simpan'
                    )
                );
                ?>
                <?php
                echo CHtml::link(
                    Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
                    Yii::app()->createUrl($this->module->id . '/' . Yii::app()->controller->id . '/' . Yii::app()->controller->action->id . ''),
                    array(
                        'title' => 'Ulang',
                        'class' => 'btn btn-default',
                        'onclick' => 'myConfirm("Apakah Anda yakin ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
                    )
                );
                ?>
            </div>

        </div>
    </div>
</div>
<?php
$this->endWidget();
$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
$module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
?>

<?php Yii::app()->clientScript->registerScript('cekAll', '
  $("#big").find("input").attr("checked", "checked");
  $("#supplier").find("input").attr("checked", "checked");
 
', CClientScript::POS_READY);
?>
<?php
$urlPeriode = Yii::app()->createUrl('actionAjax/GantiPeriode');
$js = <<< JSCRIPT

function setPeriode(){
    namaPeriode = $('#PeriodeName').val();
    
        $.post('${urlPeriode}',{namaPeriode:namaPeriode},function(data){
            $('#GZLaporanmakanangiziV_tgl_awal').val(data.periodeawal);
            $('#GZLaporanmakanangiziV_tgl_akhir').val(data.periodeakhir);
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

    function checkAll() {
        if ($('#checkAllRuangan').is(':checked')) {
            $('#laporan-search input[name*="ruangan_id"]').each(function() {
                $(this).attr('checked', true);
            });
        } else {
            $('#laporan-search input[name*="ruangan_id"]').each(function() {
                $(this).removeAttr('checked');
            });
        }
    }

    function checkAllSupplier() {
        if ($('#pilihSemua').is(':checked')) {
            $('#checkBoxSupplier').each(function() {
                $(this).find('input').attr('checked', true);
            });
        } else {
            $('#checkBoxSupplier').each(function() {
                $(this).find('input').removeAttr('checked');
            });
        }
    }
    checkAll();
    checkAllSupplier();
</script>