
        <div class="panel panel-primary panel-success">
            <div class="panel-heading">
                        <div class="panel-title">Data Kantong Darah</div>
                    </div>            
            <div class="panel-body">
                <div class="col-sm-6">
                     <div class="control-group">
                        <label class="control-label">Nomor Kantong<span class="required">*</span></label>
                        <div class="controls">
                    <?php   //echo $form->hiddenField($model,'ujikompatibilitas_id',array('class'=>'required')); 
                        $this->widget('MyJuiAutoComplete', array(
                                          //'model'=>$model,
                                          'name'=>'no_kantongdarah',
                                          'source'=>'js: function(request, response) {
                                                         $.ajax({
                                                             url: "'.$this->createUrl('AutocompleteKantongDarah').'",
                                                             dataType: "json",
                                                             data: {
                                                                 term: request.term,
                                                             },
                                                             success: function (data) {
                                                                     response(data);
                                                             }
                                                         })
                                                      }',
                                           'options'=>array(
                                               'showAnim'=>'fold',
                                                 'minLength' => 3,
                                                  'focus'=> 'js:function( event, ui ) {
                                                       $(this).val( "");
                                                       return false;
                                                   }',
                                                 'select'=>'js:function( event, ui ) {
                                                      $(this).val(ui.item.no_kantongdarah);
                                                      cekSudahAda(ui.item.no_kantongdarah,this);
                                                      return false;
                                                  }',
                                          ),
                                          'tombolDialog'=>array('idDialog'=>'dialogKantong','jsFunction' => 'setCeklisKantong();$("#dialogKantong").dialog("open");'),
                                          'htmlOptions'=>array(
                                              'placeholder'=>'Ketik No. Kantong',
                                              //'class'=>'all-caps',
                                              'rel'=>'tooltip',
                                              'title'=>'Ketik no. kantong',
                                              //'onblur' => 'if($(this).val()==""){resetKantong();}',
                                          'onkeyup'=>"return $(this).focusNextInputField(event)",                                    
                                          ),
                                      )); 
                      ?>
                        </div>
                     </div>
                    
                    <!--<div class="control-group">
                        <label class="control-label">Nama Pasien</label>
                        <div class="controls">
                            <?php //echo $form->textField($model, 'nama_pasien',array('readonly'=>true)); ?>
                        </div>
                    </div>
                    
                    <div class="control-group">
                        <label class="control-label">No Rekam Medik</label>
                        <div class="controls">
                            <?php //echo $form->textField($model, 'no_rekam_medik',array('readonly'=>true)); ?>
                        </div>
                    </div>-->
                </div>
                
                <!--<div class="col-sm-6">
                    <div class="control-group">
                        <label class="control-label">Ruangan</label>
                        <div class="controls">
                            <?php //echo $form->textField($model, 'ruangan_nama',array('readonly'=>true)); ?>
                        </div>
                    </div>
                    
                    <div class="control-group">
                        <label class="control-label">Jenis Komponen Darah</label>
                        <div class="controls">
                            <?php //echo $form->textField($model, 'jenis_komponen_darah',array('readonly'=>true)); ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Golongan Darah</label>
                        <div class="controls">
                            <?php //echo $form->textField($model, 'golongan_darah',array('readonly'=>true)); ?>
                        </div>
                    </div>
                </div>-->
                
                <table class="table table-bordered table-striped table-condensed" id="table-detailkantongdarah">
                    <thead>
                        <tr>                  
                            <th>No</th>
                            <th>No. Kantong Darah</th>  
                            <th>Nama Pasien</th>  
                            <th>No. Rekam Medik</th>  
                            <th>Ruangan</th>  
                            <th>Jenis Komponen Darah</th>  
                            <th>Gol Darah/<br> Rhesus</th>            
                            <th>Batal</th>           
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>
<div class="clear"></div>

