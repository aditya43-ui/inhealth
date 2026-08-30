<div class="col-sm-6">
   <?php echo $form->dropDownListRow($model,'jenis_denda', LookupM::getItems('nilaidenda'),array('empty' => '-- Pilih --','class' => ' span3')); ?>
   <div class="control-group">
        <label class="control-label">Ketentuan Denda</label>
        <div class="controls">            
            <div class="compose-message-editor">
                <?php 
                    echo $form->textArea($model,'ketentuan_denda',array('class' => 'wysihtml1 form-control', ))
                ?>                        
            </div>
        </div>
    </div>
    
   <div class="control-group">
        <label class="control-label">Pembayaran Ganti Rugi</label>
        <div class="controls">            
            <div class="compose-message-editor">
                <?php 
                    echo $form->textArea($model,'ganti_rugi',array('class' => 'wysihtml1 form-control', ))
                ?>                        
            </div>
        </div>
    </div>
    
    <div class="control-group">
        <label class="control-label">Penyelesaian Perselisihan</label>
        <div class="controls">            
            <div class="compose-message-editor">
                <?php 
                    echo $form->textArea($model,'penyelesaian_perselisihan',array('class' => 'wysihtml1 form-control', ))
                ?>                        
            </div>
        </div>
    </div>
    
</div>

<div class="col-sm-6">       
    <?php echo $form->dropDownListRow($model,'dasar_denda', LookupM::getItems('dasarnilaidenda'),array('empty' => '-- Pilih --','class' => ' span3')); ?>
    <div class="control-group">
        <label class="control-label">Kompensasi</label>
        <div class="controls">            
            <div class="compose-message-editor">
                <?php 
                    echo $form->textArea($model,'kompensasi',array('class' => 'wysihtml1 form-control', ))
                ?>                        
            </div>
        </div>
    </div>
    
    <div class="control-group">
        <label class="control-label">Kahar</label>
        <div class="controls">            
            <div class="compose-message-editor">
                <?php 
                    echo $form->textArea($model,'kahar',array('class' => 'wysihtml1 form-control', ))
                ?>                        
            </div>
        </div>
    </div>
    
    <div class="control-group">
        <label class="control-label">Sanksi</label>
        <div class="controls">            
            <div class="compose-message-editor">
                <?php 
                    echo $form->textArea($model,'sanksi',array('class' => 'wysihtml1 form-control', ))
                ?>                        
            </div>
        </div>
    </div>
</div>