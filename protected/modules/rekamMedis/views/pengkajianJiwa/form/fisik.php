<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">Fisik</div>
    </div>
    <div class="panel-body">
        <br/>
        <div class="panel panel-darkk">
            <span class="group-title">
                Tanda Vital
            </span>
            <div class="panel-body">
                <div class="row-fluid">
                    <div class="col-sm-6">
                        <div class="control-group">
                            <?php echo $form->labelEx($model, 'td_systolic', array('class'=>'control-label')); ?>
                            <div class="controls">
                                <?php echo $form->textField($model, 'td_systolic', array('class'=>'span1 numbers-only')); ?>
                                <label>/</label>
                                <?php echo $form->textField($model, 'td_diastolic', array('class'=>'span1 numbers-only')); ?>
                                <label>mmHg</label>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo $form->labelEx($model, 'nadi', array('class'=>'control-label')); ?>
                            <div class="controls">
                                <?php echo $form->textField($model, 'nadi', array('class'=>'span1 numbers-only')); ?>
                                <label>x/menit</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="control-group">
                            <?php echo $form->labelEx($model, 'pernapasan', array('class'=>'control-label')); ?>
                            <div class="controls">
                                <?php echo $form->textField($model, 'pernapasan', array('class'=>'span1 numbers-only')); ?>
                                <label>x/menit</label>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo $form->labelEx($model, 'suhutubuh', array('class'=>'control-label')); ?>
                            <div class="controls">
                                <?php echo $form->textField($model, 'suhutubuh', array('class'=>'span1 float2')); ?>
                                <label>&deg;C</label>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
        <br/>
        <div class="panel panel-darkk">
            <span class="group-title">
                Ukur
            </span>
            <div class="panel-body">
                <div class="row-fluid">
                    <div class="col-sm-6">
                        <div class="control-group">
                            <?php echo $form->labelEx($model, 'tinggibadan', array('class'=>'control-label')); ?>
                            <div class="controls">
                                <?php echo $form->textField($model, 'tinggibadan', array('class'=>'span1 numbers-only')); ?>
                                <label>cm</label>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo $form->labelEx($model, 'beratbadan', array('class'=>'control-label')); ?>
                            <div class="controls">
                                <?php echo $form->textField($model, 'beratbadan', array('class'=>'span1 numbers-only')); ?>
                                <label>Kg</label>
                            </div>
                        </div>
                        
                    </div>
                    <div class="col-sm-6">
                        <?php echo $form->radioButtonListRow($model, 'hasilukur_bbtb', array(
                            'Turun'=>'Turun', 'Naik'=>'Naik',
                        )); ?>
                    </div>
                </div>
            </div>
        </div>
        <br/>
        <div class="panel panel-darkk">
            <span class="group-title">
                Keluhan Fisik
            </span>
            <div class="panel-body">
                <div class="control-group">
                    <?php echo $form->labelEx($model, 'keluhanfisik_status', array('class'=>'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->radioButtonList($model, 'keluhanfisik_status', array(
                            'Tidak'=>'Tidak', 'Ya'=>'Ya',
                        ), array(
                            'uncheckValue'=>null, 'class'=>'keluhanfisik_status',
                        )); ?>
                        <?php echo $form->textAreaRow($model, 'keluhanfisik_penjelasan', array(
                            'rows'=>3, 'class'=>'keluhanfisik_penjelasan'
                        )); ?>
                    </div>
                </div>
            </div>
        </div>
        <br/>
        <div class="panel panel-darkk">
            <span class="group-title">
                Diagnosa Keperawatan
            </span>
            <div class="panel-body">
                <?php $this->widget('ext.redactorjs.Redactor',array('model'=>$model, 'attribute'=>'fisik_diagnosakeperawatan', 'toolbar'=>'mini','height'=>'100px')) ?>
            </div>
        </div>
        <br/>
        <div class="control-group">
            <?php echo $form->labelEx($det, 'diagnosakesehatanjiwa_id', array('class'=>'control-label', 'label'=>'Diagnosa Fisik')); ?>
            <div class="controls">
                <div id="panel_diagnosafisik">
                    <?php echo $form->checkBoxList($det, 'diagnosakesehatanjiwa_id[diagnosa_fisik][diagnosa_fisik]', CHtml::listData(DiagnosakesehatanjiwaM::model()->findAllByAttributes(array(
                        'isaktif'=>true, 'jenisdiagnosa' => 'diagnosa_fisik', 'kelompokdiagnosa' => 'diagnosa_fisik',
                    ), array('order'=>'diagnosakesehatanjiwa_id')), 'diagnosakesehatanjiwa_id', 'diagnosakesehatanjiwa_nama'), array('uncheckValue'=>null)); ?>
                </div>
                <?php echo CHtml::htmlButton('+ Tambah Diagnosa', array(
                    'class'=>'btn btn-success', 'onclick'=>"dialogTambahDiagnosa('panel_diagnosafisik', 'diagnosa_fisik', 'diagnosa_fisik');"
                )); ?>
            </div>
        </div>
        
    </div>
</div>

<script>
    
    function cekCeklisKeluhanFisik() {
        if ($(".keluhanfisik_status:checked").val() == "Ya") {
            $(".keluhanfisik_penjelasan").attr("readonly", false);
        } else {
            $(".keluhanfisik_penjelasan").attr("readonly", true).val("");
        }
    }
    
    $(document).ready(function() {
        $(".keluhanfisik_status").on("click", cekCeklisKeluhanFisik);
        cekCeklisKeluhanFisik();
    });
    
    
</script>
