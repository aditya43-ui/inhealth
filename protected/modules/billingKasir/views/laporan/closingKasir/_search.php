<div class="search-form">
    <?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
        'action' => Yii::app()->createUrl($this->route),
        'method' => 'get',
        'id' => 'searchLaporan',
        'type' => 'horizontal',
    ));
    ?>
    <div class="row">
        <div class="col-sm-12">
            <?php //$format = new MyFormatter(); 
            ?>
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
            <div class="control-group">
                <?php echo $form->hiddenField($model, 'pegawai_id', array('readonly' => true)); ?>
                <?php echo CHtml::label('Nama Pegawai', 'nama_pegawai', array('class' => 'control-label',)) ?>
                <div class="controls">
                    <?php
                    $this->widget(
                        'MyJuiAutoComplete',
                        array(
                            //'model'=>$model,
                            //'attribute'=>'nama_pegawai',
                            'name' => 'nama_pegawai',
                            'sourceUrl' => Yii::app()->createUrl('ActionAutoComplete/ListKaryawan'),
                            'options' => array(
                                'class' => 'span3',
                                'showAnim' => 'fold',
                                'minLength' => 2,
                                'select' => 'js:function( event, ui ){
                                                $("#BKLaporanclosingkasirV_pegawai_id").val(ui.item.pegawai_id);
                                                $(this).val(ui.item.nama_pegawai);
                                                return false;
                                            }',
                                'focus' => 'js:function( event, ui ) {
                                                $(this).val("");
                                                return false;
                                            }',
                            ),
                            'htmlOptions' => array(
                                'placeholder' => 'Nama Pegawai',
                                'class' => 'span3'
                            ),
                            'tombolDialog' => array(
                                'idDialog' => 'dialogPegawai'
                            ),
                        )
                    );
                    ?>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <?php
            echo CHtml::hiddenField('filter', 'shift_id', array('disabled' => 'disabled')) .
                '<div class="control-group">
                        ' . CHtml::label('Shift', 'shift_id', array('class' => 'control-label')) . ' 
                        <div class="controls">
                            ' . $form->dropDownList($model, 'shift_id', Chtml::listData($model->ShiftItems, 'shift_id', 'shift_nama'), array(
                    'class' => 'form-control', 'multiple' => 'multiple'
                )) . '
                        </div>
                    </div>';
            ?>
        </div>
        <!--<div class="col-sm-6">
            <div class="panel panel-success">
                <div class="panel-heading">
                    <div class="panel-title">
                        Berdasarkan Pegawai Kasir
                    </div>
                </div>
                <div class="panel-body">
                    <div class="control-group">
                        <div class="controls">
                            <?php echo $form->hiddenField($model, 'pegawai_id', array('readonly' => true)); ?>
                            <?php echo CHtml::label('Nama Pegawai', 'nama_pegawai', array('class' => 'control-label', 'style' => 'text-align:center;')) ?>
                            <div class="controls">
                                <?php
                                $this->widget(
                                    'MyJuiAutoComplete',
                                    array(
                                        //'model'=>$model,
                                        //'attribute'=>'nama_pegawai',
                                        'name' => 'nama_pegawai',
                                        'sourceUrl' => Yii::app()->createUrl('ActionAutoComplete/ListKaryawan'),
                                        'options' => array(
                                            'class' => 'span3',
                                            'showAnim' => 'fold',
                                            'minLength' => 2,
                                            'select' => 'js:function( event, ui ){
                                                            $("#BKLaporanclosingkasirV_pegawai_id").val(ui.item.pegawai_id);
                                                            $(this).val(ui.item.nama_pegawai);
                                                            return false;
                                                        }',
                                            'focus' => 'js:function( event, ui ) {
                                                            $(this).val("");
                                                            return false;
                                                        }',
                                        ),
                                        'htmlOptions' => array(
                                            'placeholder' => 'Nama Pegawai',
                                            'class' => 'span3'
                                        ),
                                        'tombolDialog' => array(
                                            'idDialog' => 'dialogPegawai'
                                        ),
                                    )
                                );
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>-->

        <?php /*
	<div class="col-sm-6">
		<div class="control-group">
			<!--fieldset class="box2"-->
				<legend class="rim">Berdasarkan Ruangan <?php echo CHtml::checkBox('cek_ruangan', true, array('onchange'=>'cek_all_ruangan(this)','value'=>'cek_ruangan'));?></legend>
				<div class="row">
				<div class="controls">
					<?php //echo $form->hiddenField($model, 'pegawai_id', array('readonly'=>true)); ?>
					<?php //echo CHtml::label('Nama Dokter', 'nama_dokter', array('class' => 'control-label', 'style'=>'text-align:center;')) ?>
					<div class="controls">
						<?php
						   echo $form->checkBoxList($model, 'create_ruangan', CHtml::listData(RuangankasirV::model()->findAll(), 'ruangan_id', 'ruangan_nama'), array('inline'=>true, 'onkeypress' => "return $(this).focusNextInputField(event)"));
						  ?>
					</div>
					</div>
				</div>
			<!--</fieldset>--> 
		</div>
	</div>
     * 
     */ ?>

        <!--<div class="col-sm-6">
            <div class="control-group">

                <?php
                $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
                    'id' => 'shift',
                    'slide' => true,
                    'content' => array(
                        'content2' => array(
                            'multi' => 'multi',
                            'header' => 'Berdasarkan Shift',
                            'isi' => CHtml::hiddenField('filter', 'shift_id', array('disabled' => 'disabled')) .
                                '<div class="control-group">
                                            ' . CHtml::label('Shift', 'shift_id', array('class' => 'control-label')) . ' 
                                            <div class="controls">
                                                ' . $form->dropDownList($model, 'shift_id', Chtml::listData($model->ShiftItems, 'shift_id', 'shift_nama'), array(
                                    'class' => 'form-control', 'multiple' => 'multiple'
                                )) . '
                                            </div>
                                        </div>',
                            'active' => true,
                        ),
                    ),
                ));
                ?>
            </div>
        </div>-->
    </div>
    <div class="form-actions">
        <?php echo CHtml::htmlButton(
            Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
            array('title' => 'Cari', 'class' => 'btn btn-danger', 'type' => 'submit')
        ); ?>
        <?php echo CHtml::htmlButton(
            Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
            array('title' => 'Ulang', 'class' => 'btn btn-default', 'type' => 'reset', 'onclick' => 'resetForm();')
        ); ?>
        <?php
        //$content = $this->renderPartial('../tips/informasi',array(),true);
        //$this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
        ?>
    </div>
</div>
<?php $this->endWidget(); ?>
<script type="text/javascript">
    function resetForm() {
        window.open("<?php echo $this->createUrl("/" . $this->route); ?>", "_self");
    }

    function cek_all_ruangan(obj) {
        if ($(obj).is(':checked')) {
            $("#searchLaporan").find("input[type=\'checkbox\']").attr("checked", "checked");
        } else {
            $("#searchLaporan").find("input[type=\'checkbox\']").attr("checked", false);
        }
    }
    cek_all_ruangan($('#cek_ruangan'));
</script>
<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogPegawai',
    'options' => array(
        'title' => 'Pencarian Pegawai',
        'autoOpen' => false,
        'modal' => true,
        'width' => 700,
        'height' => 450,
        'resizable' => false,
    ),
));

$modPeg = new PegawairuanganV('search');
$modPeg->unsetAttributes();
$modPeg->ruangan_id = Yii::app()->user->getState('ruangan_id');
if (isset($_GET['PegawairuanganV'])) {
    $modPeg->attributes = $_GET['PegawairuanganV'];
    $modPeg->ruangan_id = Yii::app()->user->getState('ruangan_id');
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'cari-pegawai-m-grid',
    'dataProvider' => $modPeg->search(),
    'filter' => $modPeg,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn_small",
                "id"=>"selectPegawai",
                "onClick"=>"
                    $(\"#BKLaporanclosingkasirV_pegawai_id\").val(\"$data->pegawai_id\");
                    $(\"#nama_pegawai\").val(\"$data->NamaLengkap\");
                    $(\"#dialogPegawai\").dialog(\"close\");
                    return false;"
                )
            )'
        ),
        'nama_pegawai',
        'jeniskelamin',
        'nomorindukpegawai'
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));
$this->endWidget();
?>
<?php $this->renderPartial('_jsFunctions', array('model' => $model)); ?>