<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'sapemeriksaanlab-m-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event);', 'onsubmit' => 'return requiredCheck(this);'),
    'focus' => '#' . CHtml::activeId($model, 'pemeriksaanlab_urutan'),
));
?>

<div class="row">
    <!--<p class="help-block"><?php // echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') 
                                ?></p>-->
    <?php echo $form->errorSummary($model); ?>
    <div class="col-sm-6">
        <?php echo $form->textFieldRow($model, 'pemeriksaanlab_urutan', array('class' => 'span3 integer', 'onkeyup' => "return $(this).focusNextInputField(event);", 'placeholder' => 'Urutan')); ?>
        <?php echo $form->dropDownListRow($model, 'jenispemeriksaanlab_kelompok', CHtml::listData(LookupM::model()->findAllByAttributes(array('lookup_type' => 'jenispemeriksaanlab_kelompok')), 'lookup_value', 'lookup_value'), array('class' => 'span3 jenispemeriksaanlab_kelompok', 'onkeypress' => "return $(this).focusNextInputField(event)", 'empty' => '-- Pilih --')); ?>
        <?php echo $form->dropDownListRow($model, 'jenispemeriksaanlab_id', CHtml::listData(JenispemeriksaanlabM::model()->findAll(array('order' => 'jenispemeriksaanlab_urutan', 'condition' => 'jenispemeriksaanlab_aktif = true'), 'jenispemeriksaanlab_aktif = true'), 'jenispemeriksaanlab_id', 'jenispemeriksaanlab_nama'), array('empty' => '-- Pilih --', 'class' => 'span3 jenispemeriksaanlab_id', 'onkeyup' => "return $(this).focusNextInputField(event);", 'onchange' => 'setJenisPemeriksaanLab()')); ?>
        <?php //echo $form->dropDownListRow($model, 'jenispemeriksaanlab_id', CHtml::listData(JenispemeriksaanlabM::model()->findAll(array('order' => 'jenispemeriksaanlab_urutan', 'condition' => 'jenispemeriksaanlab_aktif = true'), 'jenispemeriksaanlab_aktif = true'), 'jenispemeriksaanlab_id', 'jenispemeriksaanlab_nama'), array('empty' => '-- Pilih --', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
        <div class="control-group">
            <?php echo $form->labelEx($model, 'Tindakan / Pemeriksaan <span class="required">*</span>', array('class' => 'control-label required')); ?>
            <div class="controls">
                <?php echo $form->hiddenField($model, 'daftartindakan_id'); ?>
                <?php
                $model->daftartindakan_nama = !empty($model->daftartindakan_id) ? $model->daftartindakan->daftartindakan_nama : " ";
                $this->widget('MyJuiAutoComplete', array(
                    'model' => $model,
                    'name' => 'daftartindakan_nama',
                    //'value'=>$model,
                    'attribute' => 'daftartindakan_nama',
                    'source' => 'js: function(request, response) {
								$.ajax({
									url: "' . $this->createUrl('AutocompleteTindakan') . '",
									dataType: "json",
									data: {
										term: request.term,
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
									$("#' . CHtml::activeId($model, 'daftartindakan_id') . '").val(ui.item.daftartindakan_id);
									$("#daftartindakan_nama").val(ui.item.daftartindakan_nama);
									return false;
								}',
                    ),
                    //											'htmlOptions'=>array(
                    //												'onkeypress'=>"return $(this).focusNextInputField(event)",
                    //												
                    //											),
                    'tombolDialog' => array('idDialog' => 'dialogTindakan'),
                    'htmlOptions' => array('placeholder' => 'Tindakan / Pemeriksaan', 'rel' => 'tooltip', 'onkeyup' => "return $(this).focusNextInputField(event)", 'class' => 'span3'),
                ));
                ?>
            </div>
        </div>

        <div class="control-group">
            <?php echo CHtml::label("", 'pemeriksaanlab_aktif', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->checkBox($model, 'pemeriksaanlab_aktif', array('id' => 'aktif')); ?> <label for="aktif">Aktif</label>
                <?php echo $form->checkBox($model, 'isdouble', array('id' => 'isdouble')); ?> <label for="isdouble">is double</label>
                <br>
                <?php if(Yii::app()->user->getState('ruangan_id') == Params::RUANGAN_ID_LAB_MIKROBIOLOGI) : ?>
                    <?php echo $form->checkBox($model, 'is_programhiv', array('id' => 'is_programhiv')); ?> <label for="is_programhiv">Program HIV</label>
                    <?php echo $form->checkBox($model, 'is_programtbc', array('id' => 'is_programtbc')); ?> <label for="is_programtbc">Program TBC</label>
                <?php endif ?>
            </div>
        </div>

    </div>
    <div class="col-sm-6">
        <?php echo $form->textFieldRow($model, 'pemeriksaanlab_kode', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 10, 'placeholder' => 'Kode')); ?>
        <?php echo $form->dropDownListRow($model, 'samplelab_id', CHtml::listData(SamplelabM::model()->findAllByAttributes(array('samplelab_aktif' => true)), 'samplelab_id', 'samplelab_nama'), array('class' => 'span3 samplelab_id', 'onkeypress' => "return $(this).focusNextInputField(event)", 'empty' => '-- Pilih --')); ?>
        <?php echo $form->textFieldRow($model, 'pemeriksaanlab_nama', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 500, 'placeholder' => 'Nama Pemeriksaan')); ?>
        <?php 
        // echo $model->formathasilperiksa;
        echo $form->textFieldRow($model, 'pemeriksaanlab_namalainnya', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 500, 'placeholder' => 'Nama Lainnya')); ?>
        <?php echo $form->dropDownListRow($model, 'subjenis_pemeriksaanlab_id', CHtml::listData(SubjenisPemeriksaanlabM::model()->findAllByAttributes(array('subjenis_aktif' => true)), 'subjenis_pemeriksaanlab_id', 'subjenis_pl_nama'), array('class' => 'span3 subjenis', 'onkeypress' => "return $(this).focusNextInputField(event)", 'empty' => '-- Pilih --')); ?>
        <div class="control-group">
            <?php echo $form->labelEx($model, 'kode_unik', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php
                $this->widget('MyJuiAutoComplete', array(
                    'model' => $model,
                    'name' => 'kode_unik',
                    //'value'=>$model,
                    'attribute' => 'kode_unik',
                    'source' => 'js: function(request, response) {
								$.ajax({
									url: "' . $this->createUrl('AutocompleteKodeUnik') . '",
									dataType: "json",
									data: {
										term: request.term,
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
									$("#' . CHtml::activeId($model, 'kode_unik') . '").val(ui.item.kode_unik);
									return false;
								}',
                    ),
                    // 'tombolDialog' => array('idDialog' => 'dialogTindakan'),
                    'htmlOptions' => array('placeholder' => 'Kode Unik', 'rel' => 'tooltip', 'onkeyup' => "return $(this).focusNextInputField(event)", 'class' => 'span3'),
                ));
                ?>
            </div>
        </div>
    
    </div>
    <?php
        $jenis = JenispemeriksaanlabM::model()->findByPk($model->jenispemeriksaanlab_id);
        if(!empty($jenis->jenispemeriksaanlab_kelompok)){
        if(strtoupper($jenis->jenispemeriksaanlab_kelompok) == 'PATOLOGI ANATOMI' || $jenis->jenispemeriksaanlab_kelompok == 'Patologi Anatomi'){
        ?>
            <div class="col-sm-6" id="per" style="display:inline;">
                <?php
                    echo $form->dropDownListRow($model, 'formathasilperiksa', ['umum' => 'UMUM', 'khusus' => 'KHUSUS'], array('id'=> 'per','class' => 'span4', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 1)); 
                ?> 
            </div>
        <?php
        }} else {
            ?>
            <div class="col-sm-6" id="per" style="display:none;">
                <?php
                    echo $form->dropDownListRow($model, 'formathasilperiksa', ['umum' => 'UMUM', 'khusus' => 'KHUSUS'], array('id'=> 'per','class' => 'span4', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 1)); 
                ?> 
            </div>
        <?php
        }
    ?>
</div>

<div class="form-actions">
    <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
        array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)', 'title' => 'Simpan')
    ); ?>
    <?php
    echo CHtml::link(
        Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
        $this->createUrl('create'),
        array(
            'class' => 'btn btn-default',
            'title' => 'Ulang',
            'onclick' => 'return refreshForm(this);'
        )
    );
    ?>
    <?php //echo CHtml::link(Yii::t('mds','{icon} Pengaturan Pemeriksaan Lab',array('{icon}'=>'<i class="icon-folder-open icon-white"></i>')),$this->createUrl('admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class' => 'btn btn-danger',)); 
    ?>
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Pengaturan Pemeriksaan', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')),
        $this->createUrl('admin', array('modul_id' => Yii::app()->session['modul_id'])),
        array('class' => 'btn btn-success',)
    ); ?>
    <?php
    $content = $this->renderPartial($this->path_view . 'tips/tipsCreate', array(), true);
    $this->widget('UserTips', array('type' => 'create', 'content' => $content));
    ?>
</div>

<?php $this->endWidget(); ?>

<?php
//========= Dialog buat cari data Bidang =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogTindakan',
    'options' => array(
        'title' => 'Daftar Tindakan',
        'autoOpen' => false,
        'modal' => true,
        'width' => 1000,
        'height' => 480,
        'resizable' => true,
    ),
));

$modTindakan = new SADaftarTindakanM('search');
$modTindakan->unsetAttributes();
if (isset($_GET['SADaftarTindakanM'])) {
    $modTindakan->attributes = $_GET['SADaftarTindakanM'];
    $modTindakan->daftartindakan_nama = $_GET['SADaftarTindakanM']['daftartindakan_nama'];
}

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'sainstalasi-m-grid',
    'dataProvider' => $modTindakan->searchDialog(),
    'filter' => $modTindakan,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>",
							"#",
							array(
								"class"=>"btn-small", 
								"id" => "selectTindakan",
								"onClick" => "
								$(\"#' . CHtml::activeId($model, 'daftartindakan_id') . '\").val(\'$data->daftartindakan_id\');
								$(\"#daftartindakan_nama\").val(\'$data->daftartindakan_nama\');
								$(\'#dialogTindakan\').dialog(\'close\');return false;"))'
        ),
        'kategoritindakan_nama',
        'kelompoktindakan_nama',
        'daftartindakan_kode',
        'daftartindakan_nama',

    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
?>
<?php
// if(!empty($model->jenispemeriksaanlab_id)){
?>
<script type="text/javascript">
    function setJenisPemeriksaanLab() {
        var jenispemeriksaanlab_id = $('.jenispemeriksaanlab_id').val();

        if(jenispemeriksaanlab_id == null){
            jenispemeriksaanlab_id = '';
        }
        $.ajax({
            type:'POST',
            url:'<?php echo $this->createUrl('SetJenisKelompok'); ?>',
            data: {jenispemeriksaanlab_id: jenispemeriksaanlab_id},
            dataType: "json",
            success:function(data){
                if(data.pesan != ''){
                    myAlert(data.pesan);
                }
                
                if (data.form == 'PATOLOGI ANATOMI') {
                    document.getElementById("per").style.display = "inline";
                }else{
                    document.getElementById("per").style.display = "none";
                }
            },
            error: function (jqXHR, textStatus, errorThrown) { myAlert("Data tidak ditaaaaemukan!");}
        });
    }
    $(document).ready(function() {
        multi();
    });
    function multi(){
        var kelompoklab  = jQuery('.jenispemeriksaanlab_kelompok');
        var samplelab  = jQuery('.samplelab_id');
        var jenislab  = jQuery('.jenispemeriksaanlab_id');

        jQuery(kelompoklab).multiselect({
                includeSelectAllOption: true,
                buttonClass: "form-control",
                maxHeight: 300,
                buttonWidth: '182px',
                enableCaseInsensitiveFiltering: true,
        }).hide();
        
        jQuery(samplelab).multiselect({
                includeSelectAllOption: true,
                buttonClass: "form-control",
                maxHeight: 300,
                buttonWidth: '182px',
                enableCaseInsensitiveFiltering: true,
        }).hide();

        jQuery(jenislab).multiselect({
                includeSelectAllOption: true,
                buttonClass: "form-control",
                maxHeight: 300,
                buttonWidth: '182px',
                enableCaseInsensitiveFiltering: true,
        }).hide();
    }
</script>
<?php //} ?>