<div class="panel panel-primary panel-gradient">
   <div class="panel-heading">
       <div class="panel-title"><strong>Pemeriksaan Fisik Geriatri</strong></div>
   </div>
    <div class="panel-body">
      <div class="row">
        <div class="col-sm-6">
          <div class="control-group ">
              <?php echo $form->labelEx($modAskepgeriatriT, 'periksafisik_kulit', array('class' => 'control-label','label'=>'Kulit')) ?>
              <div class="controls">
                  <?php echo $form->textArea($modAskepgeriatriT, 'periksafisik_kulit', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
              </div>
          </div>
          <div class="control-group ">
              <?php echo $form->labelEx($modAskepgeriatriT, 'periksafisik_penglihatan', array('class' => 'control-label','label'=>'Penglihatan')) ?>
              <div class="controls">
                  <?php echo $form->textArea($modAskepgeriatriT, 'periksafisik_penglihatan', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
              </div>
          </div>
          <div class="control-group ">
              <?php echo $form->labelEx($modAskepgeriatriT, 'periksafisik_pendengaran', array('class' => 'control-label','label'=>'Pendengaran')) ?>
              <div class="controls">
                  <?php echo $form->textArea($modAskepgeriatriT, 'periksafisik_pendengaran', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
              </div>
          </div>

        </div>
        <div class="col-sm-6">
          <div class="control-group ">
              <?php echo $form->labelEx($modAskepgeriatriT, 'periksafisik_mulutrahang_gigi', array('class' => 'control-label','label'=>'Mulut, Sendi Rahang dan gigi')) ?>
              <div class="controls">
                  <?php echo $form->textArea($modAskepgeriatriT, 'periksafisik_mulutrahang_gigi', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
              </div>
          </div>
          <div class="control-group ">
              <?php echo $form->labelEx($modAskepgeriatriT, 'periksafisik_leher', array('class' => 'control-label','label'=>'Leher')) ?>
              <div class="controls">
                  <?php echo $form->textArea($modAskepgeriatriT, 'periksafisik_leher', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
              </div>
          </div>
          <div class="control-group ">
              <?php echo $form->labelEx($modAskepgeriatriT, 'periksafisik_muskuloskeletal', array('class' => 'control-label','label'=>'Muskuloskeletal')) ?>
              <div class="controls">
                  <?php echo $form->textArea($modAskepgeriatriT, 'periksafisik_muskuloskeletal', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
              </div>
          </div>
        </div>
      </div>
      <hr/>
      <div class="row">
        <div class="col-sm-6">
          <div class="control-group ">
            <div class="controls">
              <span style="color:black"><u>Dada</u></span>
            </div>
          </div>
          <div class="control-group" style="padding-left: 30px">
            <div class="controls">
              <span style="color:black">Jantung :</span>
            </div>
          </div>
          <div class="control-group"  style="padding-left: 60px">
              <?php echo $form->labelEx($modAskepgeriatriT, 'periksafisik_jantung_inspeksi', array('class' => 'control-label','label'=>'Inspeksi')) ?>
              <div class="controls">
                  <?php echo $form->textArea($modAskepgeriatriT, 'periksafisik_jantung_inspeksi', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
              </div>
          </div>
          <div class="control-group"  style="padding-left: 60px">
              <?php echo $form->labelEx($modAskepgeriatriT, 'periksafisik_jantung_palpasi', array('class' => 'control-label','label'=>'Palpasi')) ?>
              <div class="controls">
                  <?php echo $form->textArea($modAskepgeriatriT, 'periksafisik_jantung_palpasi', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
              </div>
          </div>
          <div class="control-group"  style="padding-left: 60px">
              <?php echo $form->labelEx($modAskepgeriatriT, 'periksafisik_jantung_perkusi', array('class' => 'control-label','label'=>'Perkusi')) ?>
              <div class="controls">
                  <?php echo $form->textArea($modAskepgeriatriT, 'periksafisik_jantung_perkusi', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
              </div>
          </div>
          <div class="control-group"  style="padding-left: 60px">
              <?php echo $form->labelEx($modAskepgeriatriT, 'periksafisik_jantung_auskultasi', array('class' => 'control-label','label'=>'Auskultasi')) ?>
              <div class="controls">
                  <?php echo $form->textArea($modAskepgeriatriT, 'periksafisik_jantung_auskultasi', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
              </div>
          </div>

        </div>
        <div class="col-sm-6">
          <div class="control-group ">
            <div class="controls">
              <span style="color:black">&nbsp;</span>
            </div>
          </div>
          <div class="control-group" style="padding-left: 30px">
            <div class="controls">
              <span style="color:black">Paru :</span>
            </div>
          </div>
          <div class="control-group"  style="padding-left: 60px">
              <?php echo $form->labelEx($modAskepgeriatriT, 'periksafisik_paru_inspeksi', array('class' => 'control-label','label'=>'Inspeksi')) ?>
              <div class="controls">
                  <?php echo $form->textArea($modAskepgeriatriT, 'periksafisik_paru_inspeksi', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
              </div>
          </div>
          <div class="control-group"  style="padding-left: 60px">
              <?php echo $form->labelEx($modAskepgeriatriT, 'periksafisik_paru_palpasi', array('class' => 'control-label','label'=>'Palpasi')) ?>
              <div class="controls">
                  <?php echo $form->textArea($modAskepgeriatriT, 'periksafisik_paru_palpasi', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
              </div>
          </div>
          <div class="control-group"  style="padding-left: 60px">
              <?php echo $form->labelEx($modAskepgeriatriT, 'periksafisik_paru_perkusi', array('class' => 'control-label','label'=>'Perkusi')) ?>
              <div class="controls">
                  <?php echo $form->textArea($modAskepgeriatriT, 'periksafisik_paru_perkusi', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
              </div>
          </div>
          <div class="control-group"  style="padding-left: 60px">
              <?php echo $form->labelEx($modAskepgeriatriT, 'periksafisik_paru_auskultasi', array('class' => 'control-label','label'=>'Auskultasi')) ?>
              <div class="controls">
                  <?php echo $form->textArea($modAskepgeriatriT, 'periksafisik_paru_auskultasi', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
              </div>
          </div>
        </div>
      </div>
      <hr/>
      <div class="row">
        <div class="col-sm-6">
          <div class="control-group ">
            <div class="controls">
              <span style="color:black"><u>Abdomen</u></span>
            </div>
          </div>
          <div class="control-group"  style="padding-left: 30px">
              <?php echo $form->labelEx($modAskepgeriatriT, 'periksafisik_abdomen_inspeksi', array('class' => 'control-label','label'=>'Inspeksi')) ?>
              <div class="controls">
                  <?php echo $form->textArea($modAskepgeriatriT, 'periksafisik_abdomen_inspeksi', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
              </div>
          </div>
          <div class="control-group"  style="padding-left: 30px">
              <?php echo $form->labelEx($modAskepgeriatriT, 'periksafisik_abdomen_palpasi', array('class' => 'control-label','label'=>'Palpasi')) ?>
              <div class="controls">
                  <?php echo $form->textArea($modAskepgeriatriT, 'periksafisik_abdomen_palpasi', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
              </div>
          </div>
        </div>
        <div class="col-sm-6">
          <div class="control-group ">
            <div class="controls">
              <span style="color:black">&nbsp;</span>
            </div>
          </div>
          <div class="control-group"  style="padding-left: 30px">
              <?php echo $form->labelEx($modAskepgeriatriT, 'periksafisik_abdomen_perkusi', array('class' => 'control-label','label'=>'Perkusi')) ?>
              <div class="controls">
                  <?php echo $form->textArea($modAskepgeriatriT, 'periksafisik_abdomen_perkusi', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
              </div>
          </div>
          <div class="control-group"  style="padding-left: 30px">
              <?php echo $form->labelEx($modAskepgeriatriT, 'periksafisik_abdomen_auskultasi', array('class' => 'control-label','label'=>'Auskultasi')) ?>
              <div class="controls">
                  <?php echo $form->textArea($modAskepgeriatriT, 'periksafisik_abdomen_auskultasi', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
              </div>
          </div>
        </div>
      </div>
  </div>
</div>
