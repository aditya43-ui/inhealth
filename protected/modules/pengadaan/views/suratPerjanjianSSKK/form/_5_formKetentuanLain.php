<div class="col-sm-6">
    <div class="control-group">
        <label class="control-label">Tindakan mensyaratkan persetujuan PPK</label>
        <div class="controls">            
            <div class="compose-message-editor">
                <?php 
                    echo $form->textArea($model,'tindakan_accppk',array('class' => 'wysihtml1 form-control', ))
                ?>                        
            </div>
        </div>
    </div>
    
    <div class="control-group">
        <label class="control-label">Kepemilikan Dokumen</label>
        <div class="controls">
            <div class="compose-message-editor">
                <?php 
                    echo $form->textArea($model,'kepemilikan_dokumen',array('class' => 'wysihtml1 form-control', ))
                ?>                        
            </div>
        </div>
    </div>
</div>

<div class="col-sm-6">
     <div class="control-group">
        <label class="control-label">Fasilitas</label>
        <div class="controls">
            <div class="compose-message-editor">
                <?php 
                    echo $form->textArea($model,'fasilitas',array('class' => 'wysihtml1 form-control', ))
                ?>                        
            </div>
        </div>
    </div>
</div>
