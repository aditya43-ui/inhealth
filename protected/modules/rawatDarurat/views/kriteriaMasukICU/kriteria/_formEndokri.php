<div class="row-fluid">
    <div class="col-sm-12">
      <div class="panel panel-success">
          <div class="panel-body">
                <div class="table-responsive" style="overflow-x:auto;">
                    <div class='block-tabel'>
                      <table class="items table table-bordered table-striped table-condensed">
                          <thead>
                              <tr >
                                  <th colspan="3" >Gangguan Sistem Endokri</th>
                              </tr>
                              <tr >
                                  <th>Diagnosis/Kondisi Klinis</th>
                                  <th>Ya</th>
                                  <th>Tidak</th>
                              </tr>
                              
                          </thead>
                          <tr>
                              <th>Ketoasisdosis diabetik dengan komplikasi instabilitas hemodinamik, perubahan status mental, gangguan pernafasan, dan atau asidosis berat </th>
                              <th><?php echo CHtml::activeRadioButton($model,'endokri_isketoasisdosis',array('value'=> '1' ,'class'=>'btn btn-default', 'type'=>'button','onclick'=>"klikBtnMakan_dws(5)",'style'=>'width:100%; height:100%; background-color: #d1d1d1')); ?></th>
                              <th><?php echo CHtml::activeRadioButton($model,'endokri_isketoasisdosis',array('value'=> '0','class'=>'btn btn-default', 'type'=>'button','onclick'=>"klikBtnMakan_dws(5)",'style'=>'width:100%; height:100%; background-color: #d1d1d1')); ?></th>
                                
                    
                          </tr>
                          <tr>
                              <th>Thyroid storm atau koma miksedema dengan instabilitas haemodinami</th>
                              <th><?php echo CHtml::activeRadioButton($model,'endokri_isthyroidstorm',array('value'=> '1' ,'class'=>'btn btn-default', 'type'=>'button','onclick'=>"klikBtnMakan_dws(5)",'style'=>'width:100%; height:100%; background-color: #d1d1d1')); ?></th>
                              <th><?php echo CHtml::activeRadioButton($model,'endokri_isthyroidstorm',array('value'=> '0' ,'class'=>'btn btn-default', 'type'=>'button','onclick'=>"klikBtnMakan_dws(5)",'style'=>'width:100%; height:100%; background-color: #d1d1d1')); ?></th>
                                
                          </tr>
                          <tr>
                              <th>Kondisi hyperosmolar disertai koma dan/ atau instabilitas hemodinamik yang ketat</th>
                              <th><?php echo CHtml::activeRadioButton($model,'endokri_ishyperosmolar',array('value'=> '1' ,'class'=>'btn btn-default', 'type'=>'button','onclick'=>"klikBtnMakan_dws(5)",'style'=>'width:100%; height:100%; background-color: #d1d1d1')); ?></th>
                              <th><?php echo CHtml::activeRadioButton($model,'endokri_ishyperosmolar',array('value'=> '0' ,'class'=>'btn btn-default', 'type'=>'button','onclick'=>"klikBtnMakan_dws(5)",'style'=>'width:100%; height:100%; background-color: #d1d1d1')); ?></th>
                                
                          </tr>
                          <tr>
                              <th>Permasalahan endokrin lainnya seperti krisis adrenal dengan instabilitas hemodinamik</th>
                              <th><?php echo CHtml::activeRadioButton($model,'endokri_ispermasalahanendokrin',array('value'=> '1' ,'class'=>'btn btn-default', 'type'=>'button','onclick'=>"klikBtnMakan_dws(5)",'style'=>'width:100%; height:100%; background-color: #d1d1d1')); ?></th>
                              <th><?php echo CHtml::activeRadioButton($model,'endokri_ispermasalahanendokrin',array('value'=> '0' ,'class'=>'btn btn-default', 'type'=>'button','onclick'=>"klikBtnMakan_dws(5)",'style'=>'width:100%; height:100%; background-color: #d1d1d1')); ?></th>
                                
                          </tr>
                          
                          <tr>
                              <th>Hipofosfatemia disertai kelemahan otot</th>
                              <th><?php echo CHtml::activeRadioButton($model,'endokri_ishipofosfatemia',array('value'=> '1' ,'class'=>'btn btn-default', 'type'=>'button','onclick'=>"klikBtnMakan_dws(5)",'style'=>'width:100%; height:100%; background-color: #d1d1d1')); ?></th>
                              <th><?php echo CHtml::activeRadioButton($model,'endokri_ishipofosfatemia',array('value'=> '0' ,'class'=>'btn btn-default', 'type'=>'button','onclick'=>"klikBtnMakan_dws(5)",'style'=>'width:100%; height:100%; background-color: #d1d1d1')); ?></th>
                                
                          </tr>
                          
                          <tr>
                              <th>Hipo atau hipermagnesemia dengan instabilitas hemodinamik atau disritmi</th>
                              <th><?php echo CHtml::activeRadioButton($model,'endokri_ishipermagnesemia',array('value'=> '1' ,'class'=>'btn btn-default', 'type'=>'button','onclick'=>"klikBtnMakan_dws(5)",'style'=>'width:100%; height:100%; background-color: #d1d1d1')); ?></th>
                              <th><?php echo CHtml::activeRadioButton($model,'endokri_ishipermagnesemia',array('value'=> '0' ,'class'=>'btn btn-default', 'type'=>'button','onclick'=>"klikBtnMakan_dws(5)",'style'=>'width:100%; height:100%; background-color: #d1d1d1')); ?></th>
                                
                          </tr>
                          
                          <tr>
                              <th colspan="2"><b>PARAMETER FISIOLOGIS/LABORATORIUM</b></th>
                              <th> <?php echo "Ya"; ?> </th>
                              <th> <?php echo "Tidak"; ?> </th>
                         
                            </tr>
                          <tr>
                              <th colspan="2">Kalsium serum < 5 mg/dL atau > 12 mg/dL disertai perubahan status mental atau membutuhkan monitoring hemodinamik</th>
                              <th><?php echo CHtml::activeRadioButton($model,'endokri_iskalsiumserum',array('value'=> '1' ,'class'=>'btn btn-default', 'type'=>'button','onclick'=>"klikBtnMakan_dws(5)",'style'=>'width:100%; height:100%; background-color: #d1d1d1')); ?></th>
                              <th><?php echo CHtml::activeRadioButton($model,'endokri_iskalsiumserum',array('value'=> '0' ,'class'=>'btn btn-default', 'type'=>'button','onclick'=>"klikBtnMakan_dws(5)",'style'=>'width:100%; height:100%; background-color: #d1d1d1')); ?></th>
                             
                        </tr>
                        <tr>
                              <th colspan="2">Natrium serum < 110 mEq/L atau >155 mEq/L disertai kejang atau perubahan status mental</th>
                              <th><?php echo CHtml::activeRadioButton($model,'endokri_isnatriumserum',array('value'=> '1' ,'class'=>'btn btn-default', 'type'=>'button','onclick'=>"klikBtnMakan_dws(5)",'style'=>'width:100%; height:100%; background-color: #d1d1d1')); ?></th>
                              <th><?php echo CHtml::activeRadioButton($model,'endokri_isnatriumserum',array('value'=> '0' ,'class'=>'btn btn-default', 'type'=>'button','onclick'=>"klikBtnMakan_dws(5)",'style'=>'width:100%; height:100%; background-color: #d1d1d1')); ?></th>
                                
                             
                        </tr>
                        <tr>
                              <th colspan="2">Kalium serum < 2,5 mEq/L atau > 6.0 mEq/L disertai disritmia atau kelemahan otot</th>
                              <th><?php echo CHtml::activeRadioButton($model,'endokri_iskaliumserum',array('value'=> '1' ,'class'=>'btn btn-default', 'type'=>'button','onclick'=>"klikBtnMakan_dws(5)",'style'=>'width:100%; height:100%; background-color: #d1d1d1')); ?></th>
                              <th><?php echo CHtml::activeRadioButton($model,'endokri_iskaliumserum',array('value'=> '0' ,'class'=>'btn btn-default', 'type'=>'button','onclick'=>"klikBtnMakan_dws(5)",'style'=>'width:100%; height:100%; background-color: #d1d1d1')); ?></th>
                                
                        </tr>
                        <tr>
                              <th colspan="2">Glukosa serum < 60 atau > 300 mg/dL disertai perubahan status mental</th>
                              <th><?php echo CHtml::activeRadioButton($model,'endokri_isglukosaserum',array('value'=> '1' ,'class'=>'btn btn-default', 'type'=>'button','onclick'=>"klikBtnMakan_dws(5)",'style'=>'width:100%; height:100%; background-color: #d1d1d1')); ?></th>
                              <th><?php echo CHtml::activeRadioButton($model,'endokri_isglukosaserum',array('value'=> '0' ,'class'=>'btn btn-default', 'type'=>'button','onclick'=>"klikBtnMakan_dws(5)",'style'=>'width:100%; height:100%; background-color: #d1d1d1')); ?></th>
                                
                        </tr>
                            
                      </table>
                   </div>
                </div>
              </div>
          </div>
      </div>
</div>
