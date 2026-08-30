<fieldset>
    <legend><?php echo CHtml::checkBox('isRiwayatKelahiran',false,array('onClick'=>'slideDataKehamilan()')) ?>Data Pemeriksaan Kehamilan</legend>
     <div id="divDataKehamilan" style="display: none;">   
    <table>
        <tr>
            <td>
                    <?php echo $form->labelEx($modPeriksaKehamilan,'pegawai_id', array('class'=>'control-label')) ?>
                    <div class="controls">  
                        <?php echo CHtml::label($modPeriksaKehamilan->pegawai->nama_pegawai, $modPeriksaKehamilan->pegawai->nama_pegawai);?>
                    </div>
                    <?php echo $form->labelEx($modPeriksaKehamilan,'bidan_id', array('class'=>'control-label')) ?>
                    <div class="controls">  
                        <?php echo CHtml::label($modPeriksaKehamilan->bidan->nama_pegawai, $modPeriksaKehamilan->bidan->nama_pegawai);?>
                    </div>

                    <?php echo $form->labelEx($modPeriksaKehamilan,'tglpemeriksaaan', array('class'=>'control-label')) ?>               
                    <div class="controls">  
                        <?php echo CHtml::label($modPeriksaKehamilan->tglpemeriksaaan, $modPeriksaKehamilan->tglpemeriksaaan);?>
                    </div>
                
                    <?php echo $form->labelEx($modPeriksaKehamilan,'tglkehamilan', array('class'=>'control-label')) ?>               
                    <div class="controls">  
                        <?php echo CHtml::label($modPeriksaKehamilan->tglkehamilan, $modPeriksaKehamilan->tglkehamilan);?>
                    </div>
                
                    <?php echo $form->labelEx($modPeriksaKehamilan,'tglakhirmenstruasi', array('class'=>'control-label')) ?>               
                    <div class="controls">  
                        <?php echo CHtml::label($modPeriksaKehamilan->tglakhirmenstruasi, $modPeriksaKehamilan->tglakhirmenstruasi);?>
                    </div>
                
                    <?php echo $form->labelEx($modPeriksaKehamilan,'tglperkiraankelahiran', array('class'=>'control-label')) ?>               
                    <div class="controls">  
                        <?php echo CHtml::label($modPeriksaKehamilan->tglperkiraankelahiran, $modPeriksaKehamilan->tglperkiraankelahiran);?>
                    </div>
                    
                    <?php echo $form->labelEx($modPeriksaKehamilan,'gravida', array('class'=>'control-label')) ?>               
                    <div class="controls">  
                        <?php echo CHtml::label($modPeriksaKehamilan->gravida, $modPeriksaKehamilan->gravida);?>
                    </div>
                
                    <?php echo $form->labelEx($modPeriksaKehamilan,'posisijanin', array('class'=>'control-label')) ?>               
                    <div class="controls">  
                        <?php echo CHtml::label($modPeriksaKehamilan->posisijanin, $modPeriksaKehamilan->posisijanin);?>
                    </div>
                    
                    <?php echo $form->labelEx($modPeriksaKehamilan,'jmlpartusimaturus', array('class'=>'control-label')) ?>               
                    <div class="controls">  
                        <?php echo CHtml::label($modPeriksaKehamilan->jmlpartusimaturus, $modPeriksaKehamilan->jmlpartusimaturus);?>
                    </div>
                
                    <?php echo $form->labelEx($modPeriksaKehamilan,'jmlpartusmaturus', array('class'=>'control-label')) ?>               
                    <div class="controls">  
                        <?php echo CHtml::label($modPeriksaKehamilan->jmlpartusmaturus, $modPeriksaKehamilan->jmlpartusmaturus);?>
                    </div>
                
                    <?php echo $form->labelEx($modPeriksaKehamilan,'jmlpartuspostmaturus', array('class'=>'control-label')) ?>               
                    <div class="controls">  
                        <?php echo CHtml::label($modPeriksaKehamilan->jmlpartuspostmaturus, $modPeriksaKehamilan->jmlpartuspostmaturus);?>
                    </div>
                    
                    <?php echo $form->labelEx($modPeriksaKehamilan,'jmlabortus', array('class'=>'control-label')) ?>               
                    <div class="controls">  
                        <?php echo CHtml::label($modPeriksaKehamilan->jmlabortus, $modPeriksaKehamilan->jmlabortus);?>
                    </div>      
            </td>
            <td>
                    
              
                        <?php echo $form->LabelEx($modPeriksaKehamilan,'tb_cm',array('class'=>'control-label','style'=>'width:75px'));?>
                        <?php echo $form->LabelEx($modPeriksaKehamilan,'bb_gram',array('class'=>'control-label','style'=>'width:80px'));?>
                        <div class="controls">
                            <?php echo CHtml::label($modPeriksaKehamilan->tb_cm.'&nbsp;&nbsp;'.$modPeriksaKehamilan->bb_gram.'&nbsp;&nbsp;Cm / Gram', $modPeriksaKehamilan->tb_cm.$modPeriksaKehamilan->bb_gram.'&nbsp;&nbsp;Cm / Gram',array('class'=>'span2'));?>
                        </div>
 
                
                    <?php echo $form->labelEx($modPeriksaKehamilan,'masagestasike', array('class'=>'control-label')) ?>               
                    <div class="controls">  
                        <?php echo CHtml::label($modPeriksaKehamilan->masagestasike.'&nbsp;&nbsp;Minggu', $modPeriksaKehamilan->masagestasike.'&nbsp;&nbsp;Minggu');?>
                    </div>
                    
                    <?php echo $form->labelEx($modPeriksaKehamilan,'keadaanibuhamil', array('class'=>'control-label')) ?>               
                    <div class="controls">  
                        <?php echo CHtml::label($modPeriksaKehamilan->keadaanibuhamil, $modPeriksaKehamilan->keadaanibuhamil);?>
                    </div>
                    
                    <?php echo $form->labelEx($modPeriksaKehamilan,'keadaanjanin', array('class'=>'control-label')) ?>               
                    <div class="controls">  
                        <?php echo CHtml::label($modPeriksaKehamilan->keadaanjanin, $modPeriksaKehamilan->keadaanjanin);?>
                    </div>
                
                    <?php echo $form->labelEx($modPeriksaKehamilan,'catatankehamilan', array('class'=>'control-label')) ?>               
                    <div class="controls">  
                        <?php echo CHtml::label($modPeriksaKehamilan->catatankehamilan, $modPeriksaKehamilan->catatankehamilan);?>
                    </div>
                    
                    <?php echo $form->labelEx($modPeriksaKehamilan,'filefotousg', array('class'=>'control-label')) ?>               
                    <div class="controls">  
                           <div id="divTombolLihat" align="left">
                                <?php echo CHtml::htmlButton(Yii::t('mds','Lihat Foto',array('{icon}'=>'<i class="entypo-check"></i>')),
                                                        array('class' => 'btn btn-danger', 'type'=>'button', 'onclick'=>'lihatFoto()')); ?>
                            </div>
                            <div id="divTombolTutup" style="display: none;" align="left">
                                <?php echo CHtml::htmlButton(Yii::t('mds','Tutup Foto',array('{icon}'=>'<i class="entypo-check"></i>')),
                                                        array('class' => 'btn btn-danger', 'type'=>'button', 'onclick'=>'lihatFoto()')); ?>
                            </div> 
                             <div id="divFoto" style="display: none;" align="left">
                                <?php
                                    if(!empty($modPeriksaKehamilan->filefotousg)){
                                        echo "<img id=\"img_prev\" src=\"".Params::urlUSGTumbsDirectory().'kecil_'.$modPeriksaKehamilan->filefotousg."\" title=\"Klik untuk Memperbesar Gambar\" onclick=\"$('#dialogFoto').dialog('open');\">";
                                    }else{
                                        echo "<img id=\"img_prev\" src=\"".Params::urlUSGDirectory()."no_photo.jpeg\">";
                                    }
                                 ?>
                             </div>
                
            </td>
        </tr>
    </table>
    </div>     
</fieldset>
