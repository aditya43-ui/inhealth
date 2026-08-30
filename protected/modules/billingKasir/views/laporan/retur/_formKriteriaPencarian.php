<style>
    td label.checkbox{
        width: 150px;
        display:inline-block;

    }

    .checkbox.inline + .checkbox.inline{
        margin-left: 0;
    }
</style>
<fieldset>
    <!--<legend class="rim"><?php echo  Yii::t('mds','Search Patient') ?></legend>-->
    <legend class="rim">Berdasarkan Tanggal Retur</legend>
    <table style="width: 100%; border: none;">
        <tr>
            <td width="50%">
                <div class="control-group">
                    <?php echo CHtml::label('Tgl. Retur Pelayanan','tglreturpelayanan', array('class'=>'control-label inline')) ?>
                    <div class="controls">
                        <?php   
                                $this->widget('MyDateTimePicker',array(
                                                'model'=>$model,
                                                'attribute'=>'tgl_awal',
                                                'mode'=>'datetime',
                                                'options'=> array(
                                                    'dateFormat'=>Params::DATE_FORMAT,
                                                    'maxDate' => 'd',
                                                ),
                                                'htmlOptions'=>array('class'=>'dtPicker3', 'onkeypress'=>"return $(this).focusNextInputField(event)"
                                                ),
                        )); ?>
                        
                    </div>
                </div>
            </td>
            <td>
                <div class="control-group">
                    <?php echo CHtml::label('Sampai Dengan','sampaiDengan', array('class'=>'control-label inline')) ?>
                    <div class="controls">
                        <?php   
                                $this->widget('MyDateTimePicker',array(
                                                'model'=>$model,
                                                'attribute'=>'tgl_akhir',
                                                'mode'=>'datetime',
                                                'options'=> array(
                                                    'dateFormat'=>Params::DATE_FORMAT,
//                                                    'minDate' => 'd',
                                                ),
                                                'htmlOptions'=>array('class'=>'dtPicker3', 'onkeypress'=>"return $(this).focusNextInputField(event)"
                                                ),
                        )); ?>
                        
                    </div>
                </div>
                <?php echo CHtml::hiddenField('filter_tab', 'all'); ?>
            </td>
        </tr>
        </table>
        <table style="width: 100%; border: none;">
        <legend class="rim">Berdasarkan Ruangan Retur</legend>
        <tr>
            <td>
                <div class="control-group">
                    <?php echo CHtml::label('Ruangan Retur','ruangan_id', array('class'=>'control-label inline')) ?>
                    <div class="controls">
                    <?php
                        echo $form->dropDownList($model, 'ruangan_id', CHtml::listData($model->getRuangankasirItems(), 'ruangan_id', 'ruangan_nama'), array('empty' => '-- Pilih --'));
                    ?>
                    </div>
                </div>
            </td>

        </tr>
    </table>
</fieldset>

<script type="text/javascript">
    function cek_all_ruangan(obj){
        if($(obj).is(':checked')){
            $("#ruangan_tbl").find("input[type=\'checkbox\']").attr("checked", "checked");
        }else{
            $("#ruangan_tbl").find("input[type=\'checkbox\']").attr("checked", false);
        }
    }
    
    function cek_all_penjamin(obj){
        if($(obj).is(':checked')){
            $("#penjamin_tbl").find("input[type=\'checkbox\']").attr("checked", "checked");
        }else{
            $("#penjamin_tbl").find("input[type=\'checkbox\']").attr("checked", false);
        }
    }
</script>