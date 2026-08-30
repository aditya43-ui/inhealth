<fieldset class='box'>
            <legend class='rim'>Referensi Hasil</legend>
            <?php //$modReferensiHasil = ReferensihasilradM ::model()->findByAttributes(array('refhasilrad_id'=>$model->refhasilrad_id)); ?>
            <table width='100%' class="table-condensed">
                <tr>
                    <td><?php echo CHtml::css('ul.redactor_toolbar{z-index:10;}'); ?>
                        <?php echo $form->HiddenField($modReferensiHasil,'pemeriksaanrad_id',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                        <?php echo $form->textFieldRow($modReferensiHasil,'refhasilrad_kode',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>10)); ?>
                        <div class="control-label">Hasil</div>
                    <div class="controls">
                    <?php $this->widget('ext.redactorjs.Redactor',array('model'=>$modReferensiHasil,'attribute'=>'refhasilrad_hasil','name'=>'ReferensiHasilRadM[refhasilrad_hasil]','toolbar'=>'mini','height'=>'100px')) ?>
                    </div>
                    </td>
                        <td>
                            <div class="control-label">Kesimpulan</div>
                    <div class="controls">
                    <?php $this->widget('ext.redactorjs.Redactor',array('model'=>$modReferensiHasil,'attribute'=>'refhasilrad_kesimpulan','name'=>'ReferensiHasilRadM[refhasilrad_kesimpulan]','toolbar'=>'mini','height'=>'100px')) ?>
                    
                    </div>
                        
                        </td>
                </tr>
                <tr>
                    <td>
                        <div class="control-label">Kesan</div>
                    <div class="controls">
                    <?php $this->widget('ext.redactorjs.Redactor',array('model'=>$modReferensiHasil,'attribute'=>'refhasilrad_kesan','name'=>'ReferensiHasilRadM[refhasilrad_kesan]','toolbar'=>'mini','height'=>'100px')) ?>
                    
                    </div>
                        </td>
                        <td>
                            <div class="control-label">Keterangan</div>
                    <div class="controls">
                    <?php $this->widget('ext.redactorjs.Redactor',array('model'=>$modReferensiHasil,'attribute'=>'refhasilrad_keterangan','name'=>'ReferensiHasilRadM[refhasilrad_keterangan]','toolbar'=>'mini','height'=>'100px')) ?>
                    </div>
                        
                        
                    </td>
                    <td>
                        
                        
                        <?php //echo $form->checkBoxRow($modReferensiHasil,'refhasilrad_aktif', array('onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                    </td>
                </tr>
            </table>
        </fieldset>