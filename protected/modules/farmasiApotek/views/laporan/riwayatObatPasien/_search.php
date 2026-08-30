<?php

/**
 * form pencarian laporan riwayat obat pasien
 * 
 * @author M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
 * @version     2.0.0
 * @link    <http://172.9.1.15/simpp/docs/>
 * @link    <http://piindonesia.co.id>
 */
?>
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
    <div class="row">
        <div class="col-sm-6">
            <div class="control-group">
                <?php echo CHtml::label("No Rekam Medik", 'no_rekam_medik', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php echo CHtml::hiddenField('type', ''); ?>
                    <?php
                    echo $form->hiddenField($model, 'pasien_id');

                    $this->widget('MyJuiAutoComplete', array(
                        'attribute' => 'no_rekam_medik',
                        'model' => $model,
                        'source' => 'js: function(request, response) {
						$.ajax({
							url: "' . $this->createUrl('/ActionAutoComplete/PasienAll') . '",
							dataType: "json",
							data: {
								term: request.term,
								tipe:"rm"
							},
							success: function (data) {
								response(data);
							}
						})
					}',
                        'options' => array(
                            'showAnim' => 'fold',
                            'minLength' => 2,
                            'focus' => 'js:function( event, ui ) {
							$(this).val( ui.item.label);
							return false;
						}',
                            'select' => 'js:function( event, ui ) {
							$(this).val(ui.item.value);
							$("#' . CHtml::activeId($model, 'nama_pasien') . '").val(ui.item.nama_pasien);
							$("#' . CHtml::activeId($model, 'pasien_id') . '").val(ui.item.value);							
                                                        $("#' . CHtml::activeId($model, 'no_rekam_medik') . '").val(ui.item.no_rekam_medik);							
							return false;
						}',
                        ),
                        'htmlOptions' => array(
                            'onkeyup' => "return $(this).focusNextInputField(event)",
                            'placeholder' => 'No. Rekam Medik',
                        ),
                    ));
                    ?>
                    <?php //echo $form->textFieldRow($model,'no_rekam_medik', array('maxlength' => 6,'class'=>'numbers-only')) 
                    ?>
                </div>
            </div>

            <div class="control-group">
                <?php echo CHtml::label("Nama Pasien", 'no_rekam_medik', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php
                    $this->widget('MyJuiAutoComplete', array(
                        'attribute' => 'nama_pasien',
                        'model' => $model,
                        'source' => 'js: function(request, response) {
						$.ajax({
							url: "' . $this->createUrl('/ActionAutoComplete/PasienAll') . '",
							dataType: "json",
							data: {
								term: request.term,
								tipe:"nama"
							},
							success: function (data) {
								response(data);
							}
						})
					}',
                        'options' => array(
                            'showAnim' => 'fold',
                            'minLength' => 2,
                            'focus' => 'js:function( event, ui ) {
							$(this).val( ui.item.label);
							return false;
						}',
                            'select' => 'js:function( event, ui ) {
							$(this).val(ui.item.value);
							$("#' . CHtml::activeId($model, 'no_rekam_medik') . '").val(ui.item.no_rekam_medik);
							$("#' . CHtml::activeId($model, 'pasien_id') . '").val(ui.item.pasien_id);							
                                                        $("#' . CHtml::activeId($model, 'nama_pasien') . '").val(ui.item.nama_pasien);							
							return false;
						}',
                        ),
                        'htmlOptions' => array(
                            'onkeyup' => "return $(this).focusNextInputField(event)",
                            'placeholder' => 'Nama Pasien',
                            'showAnim' => 'fold',
                            'minLength' => 2,
                            'focus' => 'js:function( event, ui ) {
							$(this).val( ui.item.label);
							return false;
						}',
                            'select' => 'js:function( event, ui ) {
							return false;
						}',
                        ),
                    ));
                    ?>
                    <?php //echo $form->textFieldRow($model,'nama_pasien', array('maxlength' => 50,'class'=>'hurufs-only')) 
                    ?>
                </div>
            </div>
        </div>

        <div class="col-sm-6">
            <?php
            echo CHtml::hiddenField('filter', 'jenisobat', array('disabled' => 'disabled')) .
                '<div class="control-group">
                    ' . CHtml::label('Jenis Obat', 'jenisobat', array('class' => 'control-label')) . ' 
                    <div class="controls">
                        ' . $form->dropDownList($model, 'jenisobatalkes_id', CHtml::listData(JenisobatalkesM::model()->ItemsFarmasi, 'jenisobatalkes_id', 'jenisobatalkes_nama'), array(
                    'class' => 'form-control', 'multiple' => 'multiple'
                )) . '
                    </div>
                </div>';

            // $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
            //     'id' => 'jenisobat',
            //     'slide' => true,
            //     'content' => array(
            //         'content2' => array(
            //             'multi' => 'multi',
            //             'header' => 'Berdasarkan Jenis Obat',
            //             'isi' => CHtml::hiddenField('filter', 'jenisobat', array('disabled' => 'disabled')) .
            //                 '<div class="control-group">
            //                         ' . CHtml::label('Jenis Obat', 'jenisobat', array('class' => 'control-label')) . ' 
            //                         <div class="controls">
            //                             ' . $form->dropDownList($model, 'jenisobatalkes_id', CHtml::listData(JenisobatalkesM::model()->ItemsFarmasi, 'jenisobatalkes_id', 'jenisobatalkes_nama'), array(
            //                     'class' => 'form-control', 'multiple' => 'multiple'
            //                 )) . '
            //                         </div>
            //                     </div>',
            //             'active' => true,
            //         ),
            //     ),
            // ));
            ?>
            <?php
                $instalasi = InstalasiM::model()->findAllByAttributes(array(
                    'instalasi_id' => array(2, 3, 4),
                ));
                echo $form->dropDownListRow($model, 'instalasiterakhir_id', CHtml::listData($instalasi, 'instalasi_id', 'instalasi_nama'), array(
                    'empty' => '-- Pilih --',
                    'class' => 'form-control',
                    ),);
            ?>
        </div>
        <?php /*
        <div class="col-sm-12">
            <?php echo CHtml::hiddenField('type', ''); ?>
            <div class="control-group">
                <?php echo $form->hiddenField($model,'jns_periode', array('class'=>'span2')); ?>
                <?php echo $form->hiddenField($model,'bln_awal', array('class'=>'span2')); ?>
                <?php echo $form->hiddenField($model,'bln_akhir', array('class'=>'span2')); ?>
                <?php echo $form->hiddenField($model,'thn_awal', array('class'=>'span2')); ?>
                <?php echo $form->hiddenField($model,'thn_akhir', array('class'=>'span2')); ?>
                <?php echo CHtml::label("Periode Laporan",'tgl_rekam', array('class' => 'control-label')) ?>
                <div class="controls">
                    <div class="daterange daterange-inline add-ranges input-inline span4" data-format="DD MMM YYYY" data-start-date="<?php echo date('d M Y', strtotime($model->tgl_awal)) ?>" data-end-date="<?php echo date('d M Y', strtotime($model->tgl_akhir)) ?>">
                        <i class="entypo-calendar"></i>
                        <span ><?php echo date('d M Y', strtotime($model->tgl_awal)) ?> - <?php echo date('d M Y', strtotime($model->tgl_akhir)) ?></span>
                        <?php echo $form->hiddenField($model,'tgl_awal', array('class' => 'start')) ?>
                        <?php echo $form->hiddenField($model,'tgl_akhir', array('class' => 'end')) ?>
                    </div>
                </div>
            </div>
        </div>
        */ ?>
    </div>
    <div class="form-actions">
        <?php
        echo CHtml::htmlButton(
            Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
            array('title' => 'Cari', 'class' => 'btn btn-danger', 'type' => 'submit', 'id' => 'btn_simpan')
        );
        echo CHtml::htmlButton(
            Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
            array('title' => 'Ulang', 'class' => 'btn btn-default', 'onKeypress' => 'return formSubmit(this,event)', 'type' => 'reset')
        );
        ?>
    </div>
    <?php //$this->widget('UserTips', array('type' => 'create')); 
    ?>
</div>
<?php
$this->endWidget();
?>

<?php
$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
$module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai

Yii::app()->clientScript->registerScript('reloadPage', '
    function konfirmasi(){
        window.location.href="' . Yii::app()->createUrl($module . '/' . $controller . '/LaporanLembarResepLuar', array('modul_id' => Yii::app()->session['modul_id'])) . '";
    }', CClientScript::POS_HEAD); ?>

<script>
    $(document).ready(function() {
        dropMulti("<?php echo CHtml::activeId($model, 'jenisobatalkes_id') ?>");
    });
</script>