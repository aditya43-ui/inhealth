<?php 

/**
 * Form Tabulasi Preventive Maintenance.
 * 
 * @author Deni Hamdani <denihamdani@piindonesia.co.id>
 */

$form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'prevmainten-t-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal',
	'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event);', 'onsubmit'=>'return requiredCheck(this);'),
	'focus'=>'#',
)); ?>

<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
<div class="control-group">
    <?php echo $form->labelEx($model, 'tglprevmainten', array('class'=>'control-label', 'label'=>'Tgl. Mulai')); ?>
    <div class="controls">
        <?php
        $this->widget('MyDateTimePicker', array(
                        'model' => $model,
                        'attribute' => 'tglprevmainten', 
                        'mode'=>'date',
                        'options'=>array(
                            'dateFormat' => Params::DATE_FORMAT,
                        ),
                        'htmlOptions' => array(
                        'class' => "span3 required",
                        'onkeypress' => "return $(this).focusNextInputField(event)"),
                    )); 
        ?>
    </div>
</div>
<div class="control-group">
    <?php echo CHtml::label('Frekuensi <span class="required">*</span>','frekuensi_inspeksi', array('class'=>'span2 control-label')) ?>
    <div id="fp" class="controls">
        <?php echo $form->dropDownList($model,'frekuansi_prev',CHtml::listData(LookupM::model()->findAllByAttributes(array('lookup_type'=>"frekuensi_inspeksi")),'lookup_value','lookup_name'),array('empty'=>'-- Pilih --', 'readonly' => false ,'class'=>'span2 required','onkeypress'=>'return $(this).focusNextInputField(event)')); ?>
        <?php echo $form->textField($model,'frekuensi_jml_prev',array('style'=>'text-align: right;','class'=>'span1 numbers-only','onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>20)); ?>
        <?php echo $form->dropDownList($model,'frekuensi_sat_prev',CHtml::listData(LookupM::model()->findAllByAttributes(array('lookup_type'=>"satuanumum")),'lookup_value','lookup_name'),array('empty'=>'-- Pilih --','class'=>'span2 required','onkeypress'=>'return $(this).focusNextInputField(event)')); ?>
    </div>
</div>
<hr/>
<div class="control-group">
    <?php echo CHtml::label('IPM Checklist <span class="required">*</span>','ipmchecklist_id', array('class'=>'control-label')) ?>
    <div class="controls col-sm-8">
        <?php

        $ceklis = IpmchecklistM::model()->findAll(array(
            'condition'=>"ipm_aktif = true and ipm_jenis <> '".ParamsConst::IPM_JENIS_NON_IPM."'",
            'select'=>'ipm_jenis',
            'group'=>'ipm_jenis',
        ));
        
        //$cek = new IpmchecklistM;
        //$cek->ipm_jenis = Params::IPM_JENIS_NON_IPM;
        
        //$ceklis[] = $cek;

        $non_ipm = isset($list_ipm['NON IPM CHECKLIST'])?$list_ipm['NON IPM CHECKLIST']:null;        
        if (!empty($non_ipm)){
            unset($list_ipm['NON IPM CHECKLIST']);
        }
        $ipm = $list_ipm;
        
        foreach ($ceklis as $item) {
            $clist = CHtml::listData(IpmchecklistM::model()->findAllByAttributes(
                array('ipm_jenis'=>$item->ipm_jenis)
            ),'ipmchecklist_id','ipm_listnama');

            echo '<div style="font-weight: bold">'.$item->ipm_jenis.'</div>';


            foreach ($clist as $ipm_id => $cek) {                
                $model->ipmchecklist_id = !empty($ipm[$item->ipm_jenis][$ipm_id])?true:false;
                echo '<div class="col-sm-6">';
                echo $form->checkbox($model, '[detail]['.$ipm_id.']ipmchecklist_id', array(
                    'uncheckValue'=>0,
                    'class'=>'ipm_ceklis',
                    'onclick'=>'$("#PrevmaintenT_ipmchecklist_list_prev").blur();',
                ))." ".CHtml::label($cek, '');
                echo '</div>';
            }
            echo '<div class="clear"></div>';

        }

           //  die;
        ?>


    </div>
</div>
<div class="control-group">
    <?php 
    $model->ipmchecklist_list_prev = false;

    echo CHtml::label('Checklist ','ipmchecklist_list_prev', array('class'=>'control-label')) ?>
    <div class="controls">
    <?php echo $form->textField($model,'ipmchecklist_list_prev', array('class' => 'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
        <?php
            echo CHtml::htmlButton('<i class="entypo-plus"></i>', 
                array('onclick' => 'inputCheklis();return false;',
                    'class' => 'btn btn-primary',
                    'onkeypress' => "return $(this).focusNextInputField(event)",
                    'rel' => "tooltip",
                    'title' => "Klik untuk menambahkan Checklist",));
        ?>
    <div id="divTabelCeklis">
        <table id="tabel-ceklis">
            <thead>
                <th style="display: none"> Nama Ceklis</th>
                <th style="display: none"> Batal </th>
            </thead>
            <tbody> 
                <?php
                
                    
                    if (!empty($non_ipm)){
                        unset($list_ipm['NON IPM CHECKLIST']);
                        $ipm = $list_ipm;
                    }
                                    
                    if (!empty($non_ipm)){
                        foreach($non_ipm as $det){
                            $modPrev = new PreventifmaintenM;                            
                            $modPrev->ipmchecklist_list = $det;
                            
                            echo $this->renderPartial('_rowCeklis',['model'=>$modPrev], true);
                        }
                    }
                ?>
            </tbody>
        </table>
    </div>
    </div>

</div>
<div class="form-actions">
    <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="entypo-check"></i>')),array('class'=>'btn btn-danger submit', 'type'=>'submit', 'onKeypress'=>'return formSubmit(this,event)')); ?>
</div>

<?php $this->endWidget(); ?>


<?php echo $this->renderPartial('_tabPrev', array(
    'model'=>$model,
), true); ?>


<script>
    function inputCheklis(){
        var ceklis_id = $('#PrevmaintenT_ipmchecklist_list_id').val();
        var ceklis = $('#PrevmaintenT_ipmchecklist_list_prev').val();
        if (ceklis != '') {
            $.ajax({
                type: 'POST', 
                url: '<?php echo $this->createUrl('setFormCeklis')?>',
                data: {ceklis_id:ceklis_id,ceklis:ceklis},
                dataType: "json", 
                success:function(data){
                    if (data.pesan !== "") {
                        myAlert(data.pesan);
                        return false; 
                    }
                    $('#tabel-ceklis tbody').append(data.form);
                    $('#tabel-ceklis tbody ceklis:last-child').val(ceklis);
                    $('#PrevmaintenT_ipmchecklist_list_prev').val(null);
                }, 
                error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
            });
        } else {
            myAlert("Silahkan isi ceklis terlebih dahulu!");
        }
    }
    
    function hapus(obj)
    {
        myConfirm("Apakah anda akan menghapus checklist ini?","Perhatian!",function(r) {
            if(r){
                $(obj).parent().parent().remove();
                            renameInputRow($("#table-ceklis"));
            }
        });
    }
    
    $(document).ready(function() {
        setValidasiCekDisabled($("#prevmainten-t-form"), function() {
            if ($(".ipm_ceklis:checked").length == 0) {
                return false;
            }
            return true;
        });
    });

</script>