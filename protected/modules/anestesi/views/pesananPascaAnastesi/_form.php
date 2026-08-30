<div class="col-sm-6">
    <div class="control-group">
        <?php echo CHtml::label('Diagnosis Pasca Anastesi','',array('class'=>'control-label')); ?>
        <div class="controls">
            <?php echo CHtml::textField('diagnosis',$diagnosis,array('readonly'=>true))?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label('1. Infus','',array('class'=>'control-label')); ?>        
        <div class="controls">
            <?php echo $form->textArea($model,'infus',array()); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label('2. Puasa sampai dengan','',array('class'=>'control-label')); ?>        
        <div class="controls">
             <?php
                $this->widget('MyDateTimePicker', array(
                    'model' => $model,
                    'attribute' => 'puasa',
                    'mode' => 'date',
                    'options' => array(
                        'dateFormat' => Params::DATE_FORMAT,
                    ),
                    'htmlOptions' => array('class' => ' span3 required', 'onkeypress' => "return $(this).focusNextInputField(event)", 'style' => 'width:180px;'
                    ),
                ));
                ?>
        </div>
    </div>
     <div class="control-group">
        <?php echo CHtml::label('Minum','',array('class'=>'control-label')); ?>        
        <div class="controls">
             <?php echo $form->textField($model,'minum',array('class' => 'span2')); ?>
            <label>Jam</label>
        </div>
        <div class="controls">
            <?php
                $this->widget('MyDateTimePicker', array(
                    'model' => $model,
                    'attribute' => 'jam_minum',
                    'mode' => 'time',
                    'options' => array(
                        'dateFormat' => Params::TIME_FORMAT,
                    ),
                    'htmlOptions' => array('class' => 'span1', 'onkeypress' => "return $(this).focusNextInputField(event)", 'style' => 'width:100px;'
                    ),
                ));
                ?>     
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label('Makan','',array('class'=>'control-label')); ?>        
        <div class="controls">
             <?php echo $form->textField($model,'makan',array('class' => 'span2')); ?>
            <label>Jam</label>
        </div>
        <div class="controls">
            <?php
                $this->widget('MyDateTimePicker', array(
                    'model' => $model,
                    'attribute' => 'jam_makan',
                    'mode' => 'time',
                    'options' => array(
                        'dateFormat' => Params::TIME_FORMAT,
                    ),
                    'htmlOptions' => array('class' => 'span1', 'onkeypress' => "return $(this).focusNextInputField(event)", 'style' => 'width:100px;'
                    ),
                ));
                ?>     
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label('Bila','',array('class'=>'control-label')); ?>        
        <div class="controls">
             <?php echo $form->textField($model,'bila',array('class' => 'span4')); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label('3. Observasi','',array('class'=>'control-label')); ?>        
        <div class="controls">
        </div>
    </div>
     <div class="control-group">
        <?php echo CHtml::label('Tensi','',array('class'=>'control-label')); ?>        
        <div class="controls">
             <?php echo $form->textField($model,'tensi_sistolik',array('class' => 'numbers-only span2')); ?>
            <label>/</label>
        </div>
        <div class="controls">
             <?php echo $form->textField($model,'tensi_diastolik',array('class' => 'numbers-only span2')); ?>
            <label>mmHg</label>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label('Nadi','',array('class'=>'control-label')); ?>        
        <div class="controls">
             <?php echo $form->textField($model,'nadi',array('class' => 'numbers-only span4')); ?>
            <label>x/menit</label>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label('Kesadaran','',array('class'=>'control-label')); ?>        
        <div class="controls">
             <?php echo $form->textField($model,'kesadaran',array('class' => 'span4')); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label('Produksi Urine','',array('class'=>'control-label')); ?>        
        <div class="controls">
             <?php echo $form->textField($model,'produksi_urine',array('class' => 'span4')); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label('Perfusi','',array('class'=>'control-label')); ?>        
        <div class="controls">
             <?php echo $form->textField($model,'perfusi',array('class' => 'span4')); ?>
        </div>
    </div>
    
</div>
<div class="col-sm-6">
    <div class="control-group">
        <?php echo CHtml::label('4. Terapi','',array('class'=>'control-label')); ?>
        <div class="controls">
            <table id="table-terapi">
                <tbody>
                  <?php echo $this->renderPartial($this->path_view.'_rowTerapi',array(
                      'form'=>$form,
                      'modTerapi'=>$modTerapi,
                      'arrTerapi'=>$arrTerapi,
                  )); ?>
                </tbody>
            </table>
        </div>
    </div>
    
    <div class="control-group">
        <?php echo CHtml::label('5. Lain-lain','',array('class'=>'control-label')); ?>
        <div class="controls">
            <?php echo $form->textArea($model,'lain_lain'); ?>
        </div>
    </div>
</div>

<script>
    
    renameInput($("#table-terapi")); 
    
    function tambahBaris(){
        var row = '<?php echo CJSON::encode($this->renderPartial($this->path_view.'_rowTerapi',array(
            'form'=>$form,
            'modTerapi'=>$modTerapi,
            'arrTerapi'=>array()),true));?>';
        $('#table-terapi').append(row);        
        renameInput($("#table-terapi"));    
    }    
    
    function renameInput(obj_table){
        var row = 0;
        $(obj_table).find("tbody > tr").each(function(){
            $(this).find('.no_urut').html(row+1);
            $(this).attr('data-row',row);
            $(this).find('.add-on').each(function(){ //element <input>
                var old_name = $(this).attr("id");
                if (typeof old_name !== 'undefined'){
                    var old_name_arr = old_name.split("_");

                    if(old_name_arr.length == 4){
                        $(this).attr("id",old_name_arr[0]+"_"+row+"_"+old_name_arr[2]+"_"+old_name_arr[3]);

                    }
                }
            });
            $(this).find('input,select,textarea').each(function(){ //element <input>
                var old_name = $(this).attr("name").replace(/]/g,"");
                var old_name_arr = old_name.split("[");
                if(old_name_arr.length == 3){
                    $(this).attr("id",old_name_arr[0]+"_"+row+"_"+old_name_arr[2]);
                    $(this).attr("name",old_name_arr[0]+"["+row+"]["+old_name_arr[2]+"]");
                }
            });
            row++;
        });

        row = 0;
        $(obj_table).find('tbody > tr').each(function(){
            if (row == 0){
                $(this).find('.tambah').attr('style','display:block;border-radius:100%;padding:0px;');
                $(this).find('.hapus').attr('style','display:none;border-radius:100%;padding:0px;');
            }else if(row >= 1){
                $(this).find('.tambah').attr('style','display:none;border-radius:100%;padding:0px;');
                $(this).find('.hapus').attr('style','display:block;border-radius:100%;padding:0px;');
            }
            row++;
        })
    }
    
      function hapusBaris(obj){
        myConfirm("Apakah Anda yakin, ingin menghapus data ini ?","Perhatian !",function(r){
            if (r){
                $(obj).parents("tr").remove();
                renameInput($("#table-terapi"));    
             
            }
        });
    }
</script>