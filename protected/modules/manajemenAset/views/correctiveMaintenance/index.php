<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'correctiveMaintenance-t-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)', 'onsubmit' => 'return requiredCheck(this);', 'onclick' => 'cekDisabled(this);',),
    'focus' => '#',
        ));
?>

<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title"><i class="glyphicon glyphicon-briefcase"></i> Pemeliharaan Aset - Corrective Maintenance</div>
    </div>
    <div class="panel-body">

        <p class="help-block" style="color:#333;"><?php echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') ?></p>
        <?php echo $form->errorSummary($model); ?>
        <?php $this->renderPartial($this->path_view . '_dataPegawai', array('form' => $form, 'model' => $model)); ?>
        <div class="panel panel-primary panel-success">
            <div class="panel-heading">
                <div class="panel-title">											
                    <i class="glyphicon glyphicon-file"></i> Corrective Maintenance																	
                </div>
            </div>
            <div class="panel-body">
                <div class="row-fluid">
                    <div class="col-sm-6">
                        
                        <div class="control-group required">        
                            <label class="control-label">Lokasi Aset<span class="required">*</span></label>
                            <div class="controls">
                                <?php                                     
                                    echo $form->hiddenField($model, 'lokasi_id',['class'=>'required lokasi_id']);                                 
                                    $this->widget('MyJuiAutoComplete', array(
                                        'model' => $model,                                        
                                        'attribute' => 'lokasiaset_namalokasi',
                                        'source' => 'js: function(request, response) {
                                            $.ajax({
                                                url: "' . $this->createUrl('/actionAutoComplete/GetLokasiAset') . '",
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
                                                    setRuangan(ui.item)
                                                    return false;
                                            }',
                                        ),
                                        'htmlOptions' => array(
                                            'onkeypress' => "return $(this).focusNextInputField(event)",
                                            'placeholder' => "Ketik Lokasi Aset ",
                                            'class' => 'span3 lokasiaset_namalokasi required',
                                            'onblur'=>'if(this.value==""){$(".lokasi_id").val("")}'
                                        ),
                                        'tombolDialog' => array('idDialog' => 'dialogLokasi','jsFunction'=>'$("#dialogLokasi").dialog("open");'),    
                                    ));
                                ?>
                            </div>
                        </div>
                        
                        <div class="control-group ">
                            <?php echo CHtml::label('Tanggal Permintaan', 'tglpermintaan', array('class' => 'control-label')); ?>
                            <div class="controls">
                                <?php
                                $model->korektifmainten_tgl = MyFormatter::formatDateTimeForUser($model->korektifmainten_tgl);
                                $this->widget('MyDateTimePicker', array(
                                    'model' => $model,
                                    'attribute' => 'korektifmainten_tgl',
                                    'mode' => 'date',
                                    'options' => array(
                                        'dateFormat' => Params::DATE_FORMAT,
                                    ),
                                    'htmlOptions' => array('readonly' => true, 'class' => 'dtPicker3', 'onkeypress' => "return $(this).focusNextInputField(event)", 'style' => 'width:204px;'
                                    ),
                                ));
                                ?>
                                <?php echo $form->error($model, 'korektifmainten_tgl'); ?>
                            </div>
                        </div>   
                        <div class="control-group">
                            <?php echo CHtml::label('Jenis Peralatan <span class="required">*</span>', '', array('class' => 'control-label')); ?>
                            <div class="controls">
                                <?php
                                $this->widget('MyJuiAutoComplete', array(
                                    'name' => 'invperalatan_namabrg',
                                    'sourceUrl' => Yii::app()->createUrl('ActionAutoComplete/Pegawairiwayat'),
                                    'value' => $model->invperalatan_namabrg,
                                    'options' => array(                                       
                                        'showAnim' => 'fold',
                                        'minLength' => 3,
                                        'focus' => 'js:function( event, ui ) {                                               
                                                $("#invperalatan_namabrg").val( ui.item.invperalatan_namabrg );
                                                $(".lokasiaset_namalokasi").val(ui.item.lokasiaset_namalokasi);
                                                $(".lokasi_id").val(ui.item.lokasi_id);
                                                return false;
                                            }',
                                        'select' => 'js:function( event, ui ) {
                                                $("#invperalatan_id").val( ui.item.value );
                                                return false;
                                            }',
                                    ),
                                    'htmlOptions' => array('onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span3 required'),
                                    'tombolDialog' => array('idDialog' => 'dialoginvperalatanjnsperalatan','jsFunction'=>'$("#dialoginvperalatanjnsperalatan").dialog("open");refreshJenisPeralatan();'),
                                ));
                                ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo CHtml::label('Nomor Aset <span class="required">*</span>', '', array('class' => 'control-label')); ?>
                            <div class="controls">
                                <?php echo $form->hiddenField($model, 'invperalatan_id', array('readonly' => true, 'id' => 'invperalatan_id')) ?>
                                <?php echo $form->hiddenField($model, 'invperalatan_keadaan', array('readonly' => true, 'id' => 'invperalatan_keadaan')) ?>
                                <?php
                                $this->widget('MyJuiAutoComplete', array(
                                    'name' => 'invperalatan_kode',
                                    'value' => $model->invperalatan_kode,
                                    'sourceUrl' => Yii::app()->createUrl('ActionAutoComplete/Pegawairiwayat'),
                                    'options' => array(
                                        'showAnim' => 'fold',
                                        'minLength' => 3,
                                        'focus' => 'js:function( event, ui ) {                                               
                                                $("#invperalatan_kode").val( ui.item.invperalatan_kode );
                                                return false;
                                            }',
                                        'select' => 'js:function( event, ui ) {
                                                $("#invperalatan_id").val( ui.item.value );
                                                $(".lokasiaset_namalokasi").val(ui.item.lokasiaset_namalokasi);
                                                $(".lokasi_id").val(ui.item.lokasi_id);
                                                return false;
                                            }',
                                    ),
                                    'htmlOptions' => array('onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span3 required'),
                                    'tombolDialog' => array('idDialog' => 'dialoginvperalatan','jsFunction'=>'$("#dialoginvperalatan").dialog("open");refreshNoAset();'),
                                ));
                                ?>
                            </div>
                        </div>
                        
                        
                    </div>
                    <div class="col-sm-6">
                        <div class="control-group">
                            <?php echo CHtml::label('Keterangan', '', array('class' => 'control-label')); ?>
                            <div class="controls">
                                <?php echo $form->textArea($model, 'korektifmainten_ket', array('placeholder' => 'Keterangan', 'rows' => 3, 'cols' => 50, 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                            </div>
                        </div>                        
                    </div>
                </div>

            </div>
        </div>
        <div class="form-actions">
            <?php
            echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="entypo-check"></i>')) :
                            Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('class' => (isset($_GET['sukses'])) ? 'btn btn-danger' : 'btn btn-danger submit', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)', 'disabled' => (isset($_GET['sukses'])) ? true : false));
            ?>
            <?php
            echo CHtml::link(Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')), $this->createUrl($this->module->id . '/Index'), array('class' => 'btn btn-default',
                'onclick' => 'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r) {if(r) window.location = "' . $this->createUrl('Index') . '";} ); return false;'));
            ?>

            <?php
            $tips = array(
                '0' => 'simpan',
                '1' => 'ulang',
            );
            $content = $this->renderPartial('sistemAdministrator.views.tips.detailTips', array('tips' => $tips), true);
            $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
            ?>
        </div>
    </div>


</div>
<?php $this->endWidget(); ?>
<?php 
$this->renderPartial($this->path_view . '_jsFunctions', array('model' => $model)); 

$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'dialogLokasi',
    'options'=>array(
        'title'=>'Daftar Lokasi Aset',
        'autoOpen'=>false,
        //'position'=>['top',20] ,
        'modal'=>true,
        'width'=>550,
        'height'=>600,
        'resizable'=>false,
    ),
));

$this->renderPartial($this->path_view . 'grid._lokasi', array('model' => $model)); 


$this->endWidget();

?>


<?php
/* dialog untuk no. aset */
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialoginvperalatan',
    'options' => array(
        'title' => 'No Aset',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'height' => 600,
        'resizable' => false,
    ),
));

$this->renderPartial($this->path_view . 'grid._no_aset', array('model' => $model)); 

$this->endWidget();
?>

<?php
/* dialog untuk jenis peralatan */
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialoginvperalatanjnsperalatan',
    'options' => array(
        'title' => 'Jenis Peralatan',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'height' => 600,
        'resizable' => false,
    ),
));

$this->renderPartial($this->path_view . 'grid._jenis_peralatan', array('model' => $model)); 

$this->endWidget();
?>
<script type="text/javascript">
    
    var refreshJenisPeralatan = () => {
        
        var lokasi_id = $(".lokasi_id").val();
        var def = 'kosong';
        if (lokasi_id != ''){
            def = '';
        }
        
        $.fn.yiiGridView.update('dialoginvperalatanjnsperalatan-m-grid', {
            data: {
                'MAInvperalatanT[lokasi_id]': lokasi_id,
                'MAInvperalatanT[default]': def
            }
	});
        
    }
    
    var refreshNoAset = () => {
        
        var lokasi_id = $(".lokasi_id").val();
        var def = 'kosong';
        if (lokasi_id != ''){
            def = '';
        }
        
        $.fn.yiiGridView.update('dialoginvperalatan-m-grid', {
            data: {
                'MAInvperalatanT[lokasi_id]': lokasi_id,
                'MAInvperalatanT[default]': def
            }
	});
    }
    
    $(document).ready(function () {

        $('form').bind('click keyup select change', function (event) {
            cekDisabled(this);
        });
        $(document).on('click keyup select change', function () {
            cekDisabled('form');
        });
        cekDisabled('form');
    });
</script>
