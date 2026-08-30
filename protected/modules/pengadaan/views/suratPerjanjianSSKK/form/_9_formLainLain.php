<div class="col-sm-6">
    <div class="control-group">
        <label class="control-label"> Umur Konstruksi</label>
        <div class="controls">
           <?php echo $form->textField($model,'umur_konstruksi', array('class' => 'numbers-only span3')); ?>  
            <label> tahun </label>
        </div>
    </div>
</div>

<div class="col-sm-6">       
    <div class="control-group">
        <label class="control-label"> Batas Penyerahan Pedoman Pengoperasian</label>
        <div class="controls">
            <?php echo $form->textField($model,'batas_pedoman', array('class' => 'numbers-only span3')); ?>        
            <label> hari </label>
        </div>
    </div>
</div>

<div class="clear"></div>
<hr/>
<div class="col-sm-6">
    <div class="control-group">
        <label class="control-label">Standard</label>
        <div class="controls">            
            <div class="compose-message-editor">
                <?php 
                    echo $form->textArea($model,'standard',array('class' => 'wysihtml1 form-control', ))
                ?>                        
            </div>
        </div>
    </div>
    
    <div class="control-group">
        <label class="control-label">Pengiriman</label>
        <div class="controls">            
            <div class="compose-message-editor">
                <?php 
                    echo $form->textArea($model,'pengiriman',array('class' => 'wysihtml1 form-control', ))
                ?>                        
            </div>
        </div>
    </div>
    
    <div class="control-group">
        <label class="control-label">Asuransi</label>
        <div class="controls">            
            <div class="compose-message-editor">
                <?php 
                    echo $form->textArea($model,'asuransi',array('class' => 'wysihtml1 form-control', ))
                ?>                        
            </div>
        </div>
    </div>
    
    <div class="control-group">
        <label class="control-label">Transportasi</label>
        <div class="controls">            
            <div class="compose-message-editor">
                <?php 
                    echo $form->textArea($model,'transportasi',array('class' => 'wysihtml1 form-control', ))
                ?>                        
            </div>
        </div>
    </div>
    
    <div class="control-group">
        <label class="control-label">Serah Terima</label>
        <div class="controls">            
            <div class="compose-message-editor">
                <?php 
                    echo $form->textArea($model,'serah_terima',array('class' => 'wysihtml1 form-control', ))
                ?>                        
            </div>
        </div>
    </div>
</div>

<div class="col-sm-6">
    <div class="control-group">
        <label class="control-label">Pemeriksaan dan Pengujian</label>
        <div class="controls">            
            <div class="compose-message-editor">
                <?php 
                    echo $form->textArea($model,'pemeriksaan_pengujian',array('class' => 'wysihtml1 form-control', ))
                ?>                        
            </div>
        </div>
    </div>
    
    <div class="control-group">
        <label class="control-label">Incoterms</label>
        <div class="controls">            
            <div class="compose-message-editor">
                <?php 
                    echo $form->textArea($model,'incoterms',array('class' => 'wysihtml1 form-control', ))
                ?>                        
            </div>
        </div>
    </div>
    
    <div class="control-group">
        <label class="control-label">Garansi</label>
        <div class="controls">            
            <div class="compose-message-editor">
                <?php 
                    echo $form->textArea($model,'garansi',array('class' => 'wysihtml1 form-control', ))
                ?>                        
            </div>
        </div>
    </div>
    
    <div class="control-group">
        <label class="control-label">Layanan Tambahan</label>
        <div class="controls">            
            <div class="compose-message-editor">
                <?php 
                    echo $form->textArea($model,'layanan_tambahan',array('class' => 'wysihtml1 form-control', ))
                ?>                        
            </div>
        </div>
    </div>
</div>

<div class="clear"></div>

<div class="col-sm-6">
    <div class="control-group">
        <label class="control-label">Pelaporan</label>
        <div class="controls">            
            <div class="compose-message-editor">
                <?php 
                    echo $form->textArea($model,'pelaporan',array('class' => 'wysihtml1 form-control', ))
                ?>                        
            </div>
        </div>
    </div>
    
    <div class="control-group">
        <label class="control-label">Serah Terima Laporan Akhir</label>
        <div class="controls">            
            <div class="compose-message-editor">
                <?php 
                    echo $form->textArea($model,'laporan_akhir',array('class' => 'wysihtml1 form-control', ))
                ?>                        
            </div>
        </div>
    </div>
</div>

<div class="col-sm-6">
    <div class="control-group">
        <label class="control-label">Pembatasan Penggunaan Dokumen</label>
        <div class="controls">            
            <div class="compose-message-editor">
                <?php 
                    echo $form->textArea($model,'pembatasan_dokumen',array('class' => 'wysihtml1 form-control', ))
                ?>                        
            </div>
        </div>
    </div>
    
    <div class="control-group">
        <label class="control-label">Tanggung Jawab Profesi</label>
        <div class="controls">            
            <div class="compose-message-editor">
                <?php 
                    echo $form->textArea($model,'tanggungjawab_profesi',array('class' => 'wysihtml1 form-control', ))
                ?>                        
            </div>
        </div>
    </div>
</div>