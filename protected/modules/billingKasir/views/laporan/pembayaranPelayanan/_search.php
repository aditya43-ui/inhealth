<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'type' => 'horizontal',
    'id' => 'searchLaporan',
    'focus' => '#BKLaporanpembayaranpelayananV_carabayar_id',
    'htmlOptions' => array('enctype' => 'multipart/form-data', 'onKeyPress' => 'return disableKeyPress(event)'),
));
?>
<style>
    td label.checkbox {
        width: 300px;
        display: inline-block;

    }

    .checkbox.inline+.checkbox.inline {
        width: 300px;
        display: inline-block;
    }
</style>
<div class="row">
    <div class="col-sm-12">
        <?php echo CHtml::hiddenField('type', ''); ?>
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
                            ' . $form->dropDownList($model, 'carabayar_id', CHtml::listData(CarabayarM::model()->findAll('carabayar_aktif = true'), 'carabayar_id', 'carabayar_nama'), array(
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
        <div class="control-group">
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
												' . $form->dropDownList($model, 'carabayar_id', CHtml::listData(CarabayarM::model()->findAll('carabayar_aktif = true'), 'carabayar_id', 'carabayar_nama'), array(
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
    </div>
    <div class="col-sm-6">
        <div class="control-group">
            <div id='searching'>
                <fieldset class="box2">
                <legend class="rim">Berdasarkan Ruangan Kasir &nbsp;<?php echo CHtml::checkBox('cek_ruangan', true, array('onchange' => 'cek_all_ruangan(this)', 'value' => 'cek_ruangan')); ?></legend>
                <?php echo '<table id="ruangan_tbl">
						<tr>
							<td>' .
                    $form->checkBoxList($model, 'ruangan_id', CHtml::listData(RuangankasirV::model()->findAll(), 'ruangan_id', 'ruangan_nama'), array('inline' => true, 'onkeypress' => "return $(this).focusNextInputField(event)")) . '
							</td>
						</tr>
					</table>'; ?>
                </fieldset>
            </div>
        </div>
    </div>
</div>-->

<!--table width="100%" border="0">
        <tr>
            <td>
                <fieldset class="box2">
                    <legend class="rim">Berdasarkan Jenis Penjamin </legend>                 
                        <?php //echo '<table id="penjamin_tbl">
                        //                            <tr>
                        //                                <td>'.CHtml::hiddenField('filter', 'carabayar', array('disabled'=>'disabled')).'<label>Cara&nbsp;Bayar</label></td>
                        //                                <td>'.$form->dropDownList($model, 'carabayar_id', CHtml::listData(CarabayarM::model()->findAll('carabayar_aktif = true'), 'carabayar_id', 'carabayar_nama'), array('empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)",
                        //                                    'ajax' => array('type' => 'POST',
                        //                                        'url' => $this->createUrl('GetPenjaminPasienForCheckBox', array('encode' => false, 'namaModel' => ''.$model->getNamaModel().'')),
                        //                                        'update' => '#penjamin',  //selector to update
                        //                                    ),
                        //                                )) . '
                        //                                </td>
                        //                            </tr>
                        //                            <tr>
                        //                                <td>
                        //                                    <label>Penjamin</label></td>
                        //                                <td>
                        //                                    <div id="penjamin">
                        //                                        <label> Data tidak ditemukan.</label>
                        //                                    </div>
                        //                                </td>
                        //                            </tr>
                        //                        </table>'; 
                        ?>
                </fieldset>
            </td>
            <td-->
<!--div id='searching'>
                    <fieldset class="box2">
                        <legend class="rim">Berdasarkan Ruangan Kasir &nbsp;<?php echo CHtml::checkBox('cek_ruangan', true, array('onchange' => 'cek_all_ruangan(this)', 'value' => 'cek_ruangan')); ?></legend>
                        <?php //echo '<table id="ruangan_tbl">
                        //                            <tr>
                        //                                <td>'.
                        //                                $form->checkBoxList($model, 'ruangan_id', CHtml::listData(RuangankasirV::model()->findAll(), 'ruangan_id', 'ruangan_nama'), array('inline'=>true, 'onkeypress' => "return $(this).focusNextInputField(event)")).'
                        //                                </td>
                        //                            </tr>
                        //                        </table>'; 
                        ?>
                    </fieldset>
                </div>
            </td>
        </tr>
    </table-->

<div class="form-actions">
    <?php
    echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
        array('title' => 'Cari', 'class' => 'btn btn-danger', 'type' => 'submit', 'id' => 'btn_simpan')
    );
    ?>
    <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
        array('title' => 'Ulang', 'class' => 'btn btn-default', 'onclick' => 'konfirmasi()')
    ); ?>
</div>
<?php //$this->widget('UserTips', array('type' => 'create')); 
?>
<?php
$this->endWidget();
$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
$module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
$urlPrintLembarPoli = Yii::app()->createUrl('print/lembarPoliRJ', array('pendaftaran_id' => ''));
?>

<?php Yii::app()->clientScript->registerScript('cekAll', '
  $("#big").find("input").attr("checked", "checked");
  $("#kelasPelayanan").find("input").attr("checked", "checked");
',  CClientScript::POS_READY);
?>

<?php Yii::app()->clientScript->registerScript('reloadPage', '
function konfirmasi(){
    myConfirm("Apakah Anda ingin me-refresh halaman?","Perhatian!",
    function(r){
        if(r){
            window.location.href="' . Yii::app()->createUrl($module . '/' . $controller . '/LaporanCaraBayar', array('modul_id' => Yii::app()->session['modul_id'])) . '";
        }
    }); 
}', CClientScript::POS_HEAD); ?>
<script type="text/javascript">
    function cek_all_ruangan(obj) {
        if ($(obj).is(':checked')) {
            $("#ruangan_tbl").find("input[type=\'checkbox\']").attr("checked", "checked");
        } else {
            $("#ruangan_tbl").find("input[type=\'checkbox\']").attr("checked", false);
        }
    }

    function cek_all_penjamin(obj) {
        if ($(obj).is(':checked')) {
            $("#penjamin_tbl").find("input[type=\'checkbox\']").attr("checked", "checked");
        } else {
            $("#penjamin_tbl").find("input[type=\'checkbox\']").attr("checked", false);
        }
    }

    function checkAll() {
        if ($("#checkAllCaraBayar").is(":checked")) {
            $('#penjamin input[name*="penjamin_id"]').each(function() {
                $(this).attr('checked', true);
            })
            //        myAlert('Checked');
        } else {
            $('#penjamin input[name*="penjamin_id"]').each(function() {
                $(this).removeAttr('checked');
            })
        }
    }
</script>
<?php $this->renderPartial('_jsFunctions', array('model' => $model)); ?>