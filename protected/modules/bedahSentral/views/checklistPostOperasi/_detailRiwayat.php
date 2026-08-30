<form class="form-horizontal">
  <div class="row">
    <div class="col-sm-6">
      <div class="control-group ">
          <?php echo CHtml::label('Tanggal','', array('class'=>'control-label')) ?>
          <div class="controls">
            <?php echo CHtml::activeTextField($model,'tanggal_penginputan',array('class'=>'span4','readonly'=>true)); ?>
          </div>
      </div>
      <div class="control-group ">
          <?php echo CHtml::label('Petugas Pengisi','', array('class'=>'control-label')) ?>
          <div class="controls">
            <?php echo CHtml::activeTextField($model,'petugas_pengisi_nama',array('class'=>'span4','readonly'=>true)); ?>
          </div>
      </div>

    </div>
    <div class="col-sm-6">
      <div class="control-group ">
          <?php echo CHtml::label('Dari Ruangan','', array('class'=>'control-label')) ?>
          <div class="controls">
            <?php echo CHtml::activeTextField($model,'ruanganasal_nama',array('class'=>'span4','readonly'=>true)); ?>
          </div>
      </div>
      <div class="control-group ">
          <?php echo CHtml::label('Instalasi Tujuan','', array('class'=>'control-label')) ?>
          <div class="controls">
            <?php echo CHtml::activeTextField($model,'instalasitujuan_nama',array('class'=>'span4','readonly'=>true)); ?>
          </div>
      </div>
      <div class="control-group ">
          <?php echo CHtml::label('Ruangan Tujuan','', array('class'=>'control-label')) ?>
          <div class="controls">
            <?php echo CHtml::activeTextField($model,'ruangantujuan_nama',array('class'=>'span4','readonly'=>true)); ?>
          </div>
      </div>
    </div>
  </div>
  <div class="panel panel-success">
      <div class="panel-heading">
          <div class="panel-title">Serah Terima Pre Operasi</div>
      </div>
      <div class="panel-body" >
        <div class="row">
          <?php
            $modPrepostOperasi = PrepostoperasideskM::model()->findAllByAttributes(array('status'=>true,'parent_id'=>null,'jenischecklist'=>'Post Operasi'),array('order'=>'urutan ASC'));

            if(count($modPrepostOperasi) > 0){
              $nourut = 0;
              $indexTr = 0;
              $indexOp = 0;
              foreach($modPrepostOperasi as $dataPrePostOperasi){
                $nourut += 1;

                $status_pengisian_parent = "";
                $keterangan_parent = "";

                if(!empty($modDetail) > 0){
                  foreach ($modDetail as $oriDet_parent) {
                    if($oriDet_parent->prepostoperasidesk_id == $dataPrePostOperasi->prepostoperasidesk_id){
                        $status_pengisian_parent = $oriDet_parent->status_pengisian;
                        $keterangan_parent = $oriDet->keterangan;
                    }
                  }
                }

                $childrenPrepost = PrepostoperasideskM::model()->findAllByAttributes(array('status'=>true,'parent_id'=>$dataPrePostOperasi->prepostoperasidesk_id),array('order'=>'urutan ASC'));
                if(count($childrenPrepost) > 0){
                ?>
                    <div class="col-sm-12">
                      <div class="control-group">
                          <?php echo CHtml::label($nourut.". ".$dataPrePostOperasi->nama_prepostoperasidesk,'', array('class'=>'control-label', 'style'=>'text-align: left !important;')) ?>
                      </div>
                      <div class="row">
                        <?php
                          $trIndexChild = 0;
                          $nourutStep2 = 0;
                          foreach($childrenPrepost as $children){
                            $trIndexChild += 1;

                            $status_pengisian = "";
                            $keterangan = "";

                            if(!empty($modDetail) > 0){
                              foreach ($modDetail as  $oriDet) {
                                if($oriDet->prepostoperasidesk_id == $children->prepostoperasidesk_id){
                                    $status_pengisian = $oriDet->status_pengisian;
                                    $keterangan = $oriDet->keterangan;
                                }
                              }
                            }


                            if($trIndexChild == 1 || $trIndexChild == 2){
                              $checkPostPreOpChild = PrepostoperasideskM::model()->findByAttributes(array('parent_id'=>$children->prepostoperasidesk_id));

                              $cekChildern = 0;
                              if(!empty($checkPostPreOpChild)){
                                $cekChildern = 1;
                              }

                            ?>
                            <?php if($cekChildern==0){ ?>
                            <div class="col-sm-6">

                              <div class="control-group">
                                  <?php echo CHtml::label(CustomFunction::hurufAlpabetGenerate($nourutStep2).". ".$children->nama_prepostoperasidesk,'', array('class'=>'control-label', 'style'=>'text-align: left; padding-left: 20px; width: 150px; padding-top: 0px !important')) ?>
                                  <div class="controls">
                                    <?php echo CHtml::radioButtonList('PrepostoperasidetailT['.$indexOp.'][status_pengisian]',$status_pengisian,array('Ya'=>'Ya','Tidak'=>'Tidak') , array('disabled'=>true,'class'=>'status_pengisian','onkeyup'=>"return $(this).focusNextInputField(event)",'template'=>'{input}{label}','separator'=>'','labelOptions'=>array('style'=> 'padding-left:5px; width: 30px; float: left;'),'style'=>'float:left;')); ?>
                                     <div style="clear: both;"></div>
                                  </div>
                              </div>
                              <div class="control-group">
                                  <?php echo CHtml::label('Keterangan','', array('class'=>'control-label', 'style'=>'text-align: left; padding-left: 30px')) ?>
                              </div>
                              <div class="control-group">
                                  <div class="controls" style="padding-left: 20px">
                                      <?php echo CHtml::textArea('PrepostoperasidetailT['.$indexOp.'][keterangan]',$keterangan,array('disabled'=>true,'class'=>'span3','onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
                                  </div>
                              </div>

                            </div>
                          <?php }else{ ?>
                            <div class="col-sm-12">
                              <div class="control-group">
                                  <?php echo CHtml::label(CustomFunction::hurufAlpabetGenerate($nourutStep2)." ".$children->nama_prepostoperasidesk,'', array('class'=>'control-label', 'style'=>'text-align: left; padding-left: 20px; width: 150px; padding-top: 0px !important')) ?>
                              </div>
                              <div class="row">
                                <?php
                                  $trIndexChild = 0;
                                  $childrenPrepostStep3 = PrepostoperasideskM::model()->findAllByAttributes(array('status'=>true,'parent_id'=>$children->prepostoperasidesk_id),array('order'=>'urutan ASC'));
                                  foreach($childrenPrepostStep3 as $childrenLast){
                                    $trIndexChild += 1;

                                    $status_pengisianLast = "";
                                    $keteranganLast = "";

                                    if(!empty($modDetail) > 0){
                                      foreach ($modDetail as  $oriDet) {
                                        if($oriDet->prepostoperasidesk_id == $childrenLast->prepostoperasidesk_id){
                                            $status_pengisianLast = $oriDet->status_pengisian;
                                            $keteranganLast = $oriDet->keterangan;
                                        }
                                      }
                                    }

                                    if($trIndexChild == 1 || $trIndexChild == 2){
                                    ?>
                                    <div class="col-sm-6">

                                      <div class="control-group">
                                          <?php echo CHtml::label("<i class='fa fa fa-minus'></i> ".$childrenLast->nama_prepostoperasidesk,'', array('class'=>'control-label', 'style'=>'text-align: left; padding-left: 50px; width: 150px; padding-top: 0px !important')) ?>
                                          <div class="controls">
                                            <?php echo CHtml::radioButtonList('PrepostoperasidetailT['.$indexOp.'][status_pengisian]',$status_pengisianLast,array('Ya'=>'Ya','Tidak'=>'Tidak') , array('disabled'=>true,'class'=>'status_pengisian','onkeyup'=>"return $(this).focusNextInputField(event)",'template'=>'{input}{label}','separator'=>'','labelOptions'=>array('style'=> 'padding-left:5px; width: 30px; float: left;'),'style'=>'float:left;')); ?>
                                             <div style="clear: both;"></div>
                                          </div>
                                      </div>
                                      <div class="control-group">
                                          <?php echo CHtml::label('Keterangan','', array('class'=>'control-label', 'style'=>'text-align: left; padding-left: 50px')) ?>
                                      </div>
                                      <div class="control-group">
                                          <div class="controls" style="padding-left: 50px">
                                              <?php echo CHtml::textArea('PrepostoperasidetailT['.$indexOp.'][keterangan]',$keteranganLast,array('disabled'=>true,'class'=>'span3','onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
                                          </div>
                                      </div>

                                    </div>

                                    <?php
                                    }
                                    if($trIndexChild == 2){
                                      $trIndexChild = 0;
                                      ?>
                                      <div class="clear"></div>
                                      <?php
                                    }
                                    $indexOp = ($indexOp + 1);
                                  }
                                 ?>
                              </div>
                            </div>

                            <?php } ?>

                            <?php
                            }
                            if($trIndexChild == 2){
                              $trIndexChild = 0;
                              ?>
                              <div class="clear"></div>
                              <?php
                            }
                            $indexOp = ($indexOp + 1);
                            $nourutStep2 += 1;
                          }
                         ?>
                       </div>
                    </div>
                    <div class="clear"></div>
                <?php
                }else{
                  $indexTr += 1;

                  if($indexTr == 1 || $indexTr == 2){
                    ?>
                    <div class="col-sm-6">
                    <?php
                  }
                ?>

                  <div class="control-group">
                      <?php echo CHtml::label($nourut.". ".$dataPrePostOperasi->nama_prepostoperasidesk,'', array('class'=>'control-label', 'style'=>'text-align: left; width: 150px; padding-top: 0px !important')) ?>
                      <div class="controls">
                            <?php echo CHtml::radioButtonList('PrepostoperasidetailT['.$indexOp.'][status_pengisian]',$status_pengisian_parent,array('Ya'=>'Ya','Tidak'=>'Tidak') , array('disabled'=>true,'class'=>'status_pengisian','onkeyup'=>"return $(this).focusNextInputField(event)",'template'=>'{input}{label}','separator'=>'','labelOptions'=>array('style'=> 'padding-left:5px; width: 30px; float: left;'),'style'=>'float:left;')); ?>
                            <div style="clear: both;"></div>
                      </div>
                  </div>
                  <div class="control-group">
                      <?php echo CHtml::label('Keterangan','', array('class'=>'control-label', 'style'=>'text-align: left;  padding-left: 30px')) ?>
                  </div>
                  <div class="control-group">
                      <div class="controls" style="padding-left: 20px">
                          <?php echo CHtml::textArea('PrepostoperasidetailT['.$indexOp.'][keterangan]',$keterangan_parent,array('disabled'=>true,'class'=>'span3','onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
                      </div>
                  </div>




                <?php
                if($indexTr == 1 || $indexTr == 2){
                  ?>
                  </div>

                  <?php
                  }
                  if($indexTr == 2){
                    $indexTr=0;
                 ?>
                <div class="clear"></div>
                <?php
              }
              $indexOp = ($indexOp + 1);
                }

              }
            }
           ?>
        </div>
      </div>
  </div>
</form>
