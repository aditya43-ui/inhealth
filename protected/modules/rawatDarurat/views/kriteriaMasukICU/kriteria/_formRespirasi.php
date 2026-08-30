<div class="row-fluid">
    <div class="col-sm-12">
      <div class="panel panel-success">
          <div class="panel-body">
                <div class="table-responsive" style="overflow-x:auto;">
                    <div class='block-tabel'>
                      <table class="items table table-bordered table-striped table-condensed" >
                         <thead>
                              <tr >
                                  <th colspan="3" >Gangguan Sistem Respirasi</th>
                              </tr>
                              <tr >
                                  <th>Diagnosis/Kondisi Klinis</th>
                                  <th>Ya</th>
                                  <th>Tidak</th>
                              </tr>
                              
                          </thead>
                          <tr>
                              <th>Gagal pernafasan akut yang membutuhkan bantuan ventilator </th>
                              <th><?php echo CHtml::activeRadioButton($model,'respirasi_isgagalpernafasan',array('value'=> '1' ,'class'=>'btn btn-default', 'type'=>'button','onclick'=>"klikBtnMakan_dws(5)",'style'=>'width:100%; height:100%; background-color: #d1d1d1')); ?></th>
                              <th><?php echo CHtml::activeRadioButton($model,'respirasi_isgagalpernafasan',array('value'=> '0' ,'class'=>'btn btn-default', 'type'=>'button','onclick'=>"klikBtnMakan_dws(5)",'style'=>'width:100%; height:100%; background-color: #d1d1d1')); ?></th>
                         
                          </tr>
                           <tr>
                              <th>Emboli paru disertai instabilitas haemodinami</th>
                              <th><?php echo CHtml::activeRadioButton($model,'respirasi_isemboliparu',array('value'=> '1' ,'class'=>'btn btn-default', 'type'=>'button','onclick'=>"klikBtnMakan_dws(5)",'style'=>'width:100%; height:100%; background-color: #d1d1d1')); ?></th>
                              <th><?php echo CHtml::activeRadioButton($model,'respirasi_isemboliparu',array('value'=> '0' ,'class'=>'btn btn-default', 'type'=>'button','onclick'=>"klikBtnMakan_dws(5)",'style'=>'width:100%; height:100%; background-color: #d1d1d1')); ?></th>
                           </tr>
                           <tr>
                              <th>Pasien ruang perawatan High Care Unit yang menunjukan perburukan fungsi pernafasan</th>
                              <th><?php echo CHtml::activeRadioButton($model,'respirasi_isburukpernapasan',array('value'=> '1' ,'class'=>'btn btn-default', 'type'=>'button','onclick'=>"klikBtnMakan_dws(5)",'style'=>'width:100%; height:100%; background-color: #d1d1d1')); ?></th>
                              <th><?php echo CHtml::activeRadioButton($model,'respirasi_isburukpernapasan',array('value'=> '0' ,'class'=>'btn btn-default', 'type'=>'button','onclick'=>"klikBtnMakan_dws(5)",'style'=>'width:100%; height:100%; background-color: #d1d1d1')); ?></th>
                           </tr>
                           <tr>
                              <th>Hemoptisis massif</th>
                              <th><?php echo CHtml::activeRadioButton($model,'respirasi_ishemoptisis',array('value'=> '1' , 'class'=>'btn btn-default', 'type'=>'button','onclick'=>"klikBtnMakan_dws(5)",'style'=>'width:100%; height:100%; background-color: #d1d1d1')); ?></th>
                              <th><?php echo CHtml::activeRadioButton($model,'respirasi_ishemoptisis',array('value'=> '0', 'class'=>'btn btn-default', 'type'=>'button','onclick'=>"klikBtnMakan_dws(5)",'style'=>'width:100%; height:100%; background-color: #d1d1d1')); ?></th>
                           </tr>
                           <tr>
                              <th>Gagal nafas yang membutuhkan intubasi dan ventilator</th>
                              <th><?php echo CHtml::activeRadioButton($model,'respirasi_isgagalnapas',array('value'=> '1' ,'class'=>'btn btn-default', 'type'=>'button','onclick'=>"klikBtnMakan_dws(5)",'style'=>'width:100%; height:100%; background-color: #d1d1d1')); ?></th>
                              <th><?php echo CHtml::activeRadioButton($model,'respirasi_isgagalnapas',array('value'=> '0' ,'class'=>'btn btn-default', 'type'=>'button','onclick'=>"klikBtnMakan_dws(5)",'style'=>'width:100%; height:100%; background-color: #d1d1d1')); ?></th>
                    
                           </tr>
                           <tr>
                              <th>Ventilasi atau oksigenasi yang bergantung pada ventilator mekanik</th>
                              <th><?php echo CHtml::activeRadioButton($model,'respirasi_isventilasi',array('value'=> '1' ,'class'=>'btn btn-default', 'type'=>'button','onclick'=>"klikBtnMakan_dws(5)",'style'=>'width:100%; height:100%; background-color: #d1d1d1')); ?></th>
                              <th><?php echo CHtml::activeRadioButton($model,'respirasi_isventilasi',array('value'=> '0' ,'class'=>'btn btn-default', 'type'=>'button','onclick'=>"klikBtnMakan_dws(5)",'style'=>'width:100%; height:100%; background-color: #d1d1d1')); ?></th>
                            
                           </tr>
                           <tr>
                              <th>Obstruksi Jalan nafas akut atau yang baru terjadi atau gangguan refleks perlindungan jalan nafas akut </th>
                              <th><?php echo CHtml::activeRadioButton($model,'respirasi_isobstruksi',array('value'=> '1' ,'class'=>'btn btn-default', 'type'=>'button','onclick'=>"klikBtnMakan_dws(5)",'style'=>'width:100%; height:100%; background-color: #d1d1d1')); ?></th>
                              <th><?php echo CHtml::activeRadioButton($model,'respirasi_isobstruksi',array('value'=> '0' ,'class'=>'btn btn-default', 'type'=>'button','onclick'=>"klikBtnMakan_dws(5)",'style'=>'width:100%; height:100%; background-color: #d1d1d1')); ?></th>
                             
                           </tr>
                          <tr>
                              <th colspan="2"><b>PARAMETER FISIOLOGIS/LABORATORIUM</b></th>
                              <th> <?php echo "Ya"; ?> </th>
                              <th> <?php echo "Tidak"; ?> </th>
                         
                            </tr>
                          <tr>
                              <th colspan="2">Laju pernafas >30 atau < 8 x/menit,retraksi/penggunaan otot nafas tambahan,dan/ atau pola pernafasan yang tidak stabil (misal pernafasan (Cheyne Stokes) </th>
                              <th><?php echo CHtml::activeRadioButton($model,'respirasi_islajupernapasan',array('value'=> '1' ,'class'=>'btn btn-default', 'type'=>'button','onclick'=>"klikBtnMakan_dws(5)",'style'=>'width:100%; height:100%; background-color: #d1d1d1')); ?></th>
                              <th><?php echo CHtml::activeRadioButton($model,'respirasi_islajupernapasan',array('value'=> '0' ,'class'=>'btn btn-default', 'type'=>'button','onclick'=>"klikBtnMakan_dws(5)",'style'=>'width:100%; height:100%; background-color: #d1d1d1')); ?></th>
                           
                        </tr>
                        <tr>
                              <th colspan="2">PaO2 < 60 mmHg atau SaO2 < 90% dan sudah dilakukan terapi oksigen </th>
                              <th><?php echo CHtml::activeRadioButton($model,'respirasi_isterapioksigen',array('value'=> '1' ,'class'=>'btn btn-default', 'type'=>'button','onclick'=>"klikBtnMakan_dws(5)",'style'=>'width:100%; height:100%; background-color: #d1d1d1')); ?></th>
                              <th><?php echo CHtml::activeRadioButton($model,'respirasi_isterapioksigen',array('value'=> '0' ,'class'=>'btn btn-default', 'type'=>'button','onclick'=>"klikBtnMakan_dws(5)",'style'=>'width:100%; height:100%; background-color: #d1d1d1')); ?></th>
                              
                        </tr>
                        <tr>
                              <th colspan="2">PaCO2 > 60 mmHg dan pH < 7,1 atau pH > 7,7 dengan instabilitas hemodinamik </th>
                              <th><?php echo CHtml::activeRadioButton($model,'respirasi_isinstabilitas',array('value'=> '1' ,'class'=>'btn btn-default', 'type'=>'button','onclick'=>"klikBtnMakan_dws(5)",'style'=>'width:100%; height:100%; background-color: #d1d1d1')); ?></th>
                              <th><?php echo CHtml::activeRadioButton($model,'respirasi_isinstabilitas',array('value'=> '0' ,'class'=>'btn btn-default', 'type'=>'button','onclick'=>"klikBtnMakan_dws(5)",'style'=>'width:100%; height:100%; background-color: #d1d1d1')); ?></th>
                             
                        </tr>
                        <tr>
                              <th colspan="2">Pertimbangan bahwa intubasi endoktrakeal dibutuhkan dalam waktu 4 - 8 jam kemudian </th>
                              <th><?php echo CHtml::activeRadioButton($model,'respirasi_isintubasi',array('value'=> '1' ,'class'=>'btn btn-default', 'type'=>'button','onclick'=>"klikBtnMakan_dws(5)",'style'=>'width:100%; height:100%; background-color: #d1d1d1')); ?></th>
                              <th><?php echo CHtml::activeRadioButton($model,'respirasi_isintubasi',array('value'=> '0' ,'class'=>'btn btn-default', 'type'=>'button','onclick'=>"klikBtnMakan_dws(5)",'style'=>'width:100%; height:100%; background-color: #d1d1d1')); ?></th>
                             
                        </tr>
                          
                      </table>
                   </div>
                </div>
              </div>
          </div>
      </div>
</div>
