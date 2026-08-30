<div class="panel panel-darkk">
    <span class="group-title">
        B5 Pencernaan dan Nutrisi
    </span>
    <div class="panel-body">        
        
        <div class="control-group defekasi_tidakada">
            <label class="control-label">Masalah Defekasi</label>
            <div class="controls">
                <?php echo $form->checkBox($model,'nutrisi_defekasi_tidakada',array('class'=>'defekasi_tidakada', 'onclick'=>'validasiDefekasiTidak("1")')); ?> <label>Tidak Ada</label>
            </div>                        
        </div>
        
        <div class="nutrisi_defekasi_ada">
            <div class="control-group">
                <label class="control-label"><span class="defekasi_ada">Masalah Defekasi</span></label>
                <div class="controls">
                    <?php echo $form->checkBox($model,'nutrisi_defekasi_ada',array('class'=>'nutrisi_defekasi_ada', 'onclick'=>'validasiDefekasiAda("1")')); ?> <label>Ada :</label>
                </div>                        
                <div class="controls">

                </div>      
                <div class="defekasi_ada">
                    <div class="controls">
                        <?php echo $form->checkBox($model,'nutrisi_defekasi_ada_stoma',array('class'=>'defekasi_ada')); ?> <label>Stoma</label>
                    </div>  
                    <div class="controls">
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    </div>  
                    <div class="controls">
                        <?php echo $form->checkBox($model,'nutrisi_defekasi_ada_atresiaani',array('class'=>'defekasi_ada')); ?> <label>Atresia Ani</label>
                    </div> 
                </div>
                 
            </div>
            <div class="control-group defekasi_ada">
                <label class="control-label"></label>            
                <div class="controls">
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                </div>             
                <div class="controls">
                    <?php echo $form->checkBox($model,'nutrisi_defekasi_ada_konstipasi',array('class'=>'defekasi_ada')); ?> <label>Konstipasi</label>
                </div>                
                <div class="controls">
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                </div>
                <div class="controls">
                    <?php echo $form->checkBox($model,'nutrisi_defekasi_ada_diare',array('class'=>'defekasi_ada')); ?> <label>Diare</label>
                </div>  
            </div>

            <div class="control-group defekasi_ada">
                <label class="control-label"></label>            
                <div class="controls">
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                </div>             
                <div class="controls">
                    <?php echo $form->checkBox($model,'nutrisi_defekasi_ada_inkontinensia',array('class'=>'defekasi_ada')); ?> <label>Inkontinensia Alvi</label>
                </div>                        
            </div>
        </div>
        
        
        <table class="table table-bordered table-striped ">
            <thead>
                <tr>
                    <th colspan="2">Status Gizi/Nutisi</td>                    
                    <th>Penilaian</th>
                </tr>
                <tr class="even">
                    <td>1.</td>
                    <td><label>Pasien Kehilangan berat badan 5%</label></td>
                    <td style="text-align:left;">
                        <div class="control-group">                                   
                            <div class="controls">
                                <?php echo $form->checkBox($model,'nutrisi_status_beratbadanhilang_ya',array('class'=>'nutrisi_status', 'onclick'=>'cekNutrisiStatus()')); ?> <label>Ya</label>
                            </div>             
                            <div class="controls">
                                <?php echo $form->checkBox($model,'nutrisi_status_beratbadanhilang_tidak',array()); ?> <label>Tidak</label>
                            </div>                        
                        </div>
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td><label>dalam waktu 3 bulan terakhir?</label></td>
                    <td style="text-align:left;">
                       
                    </td>
                </tr>
                <tr class="even">
                    <td>2.</td>
                    <td><label>Asupan makan pasien kurang</label></td>
                    <td style="text-align:left;">
                        <div class="control-group">                                   
                            <div class="controls">
                                <?php echo $form->checkBox($model,'nutrisi_status_asupankurang_ya',array('class'=>'nutrisi_status', 'onclick'=>'cekNutrisiStatus()')); ?> <label>Ya</label>
                            </div>             
                            <div class="controls">
                                <?php echo $form->checkBox($model,'nutrisi_status_asupankuran_tidak',array()); ?> <label>Tidak</label>
                            </div>                        
                        </div>
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td><label>dalam 1 minggu terakhir?</label></td>
                    <td style="text-align:left;">
                       
                    </td>
                </tr>
                <tr class="even">
                    <td>3.</td>
                    <td><label>Pasien menderita penyakit yang berat?</label></td>
                    <td style="text-align:left;">
                        <div class="control-group">                                   
                            <div class="controls">
                                <?php echo $form->checkBox($model,'nutrisi_status_deritapenyakit_ya',array('class'=>'nutrisi_status', 'onclick'=>'cekNutrisiStatus()')); ?> <label>Ya</label>
                            </div>             
                            <div class="controls">
                                <?php echo $form->checkBox($model,'nutrisi_status_deritapenyakit_tidak',array()); ?> <label>Tidak</label>
                            </div>                        
                        </div>
                    </td>
                </tr>                
            </thead>
        </table>
        
        <div class="col-sm-12" style="background:#ffe599;border:1px solid #333;display: none;" id="notif_nutrisi">
            <label>
            Perhatian : Pelu dilakukan konsultasi di poli gizi untuk <br/>
            dilakukan asesmen awal gizi RM05d K
            </label>
        </div>
    </div>
</div>