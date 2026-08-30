<div class="row">
    <div class="col-sm-6">

        <div class="control-group">
            <?php echo CHtml::label("Pegawai Mengetahui <span class='required'>*</span>", 'diketahuiatasan_id', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->hiddenField($model, 'diketahuiatasan_id', array('readonly' => true)); ?>
                <?php
                $this->widget('MyJuiAutoComplete', array(
                    'model' => $model,
                    'attribute' => 'diketahuiatasan_nama',
                    'source' => 'js: function(request, response) {
											   $.ajax({
												   url: "' . $this->createUrl('AutocompletePegawai') . '",
												   dataType: "json",
												   data: {
													   term: request.term,
													   filter:"atasan"
												   },
												   success: function (data) {
														   response(data);
												   }
											   })
											}',
                    'options' => array(
                        'showAnim' => 'fold',
                        'minLength' => 3,
                        'focus' => 'js:function( event, ui ) {
										$("#' . CHtml::activeId($model, 'diketahuiatasan_nama') . '").val( ui.item.label );
										return false;
									}',
                        'select' => 'js:function( event, ui ) {
										$("#' . CHtml::activeId($model, 'diketahuiatasan_id') . '").val( ui.item.value );
										$("#' . CHtml::activeId($model, 'diketahuiatasan_nama') . '").val( ui.item.label );
										return false;
									}',
                    ),
                    'tombolDialog' => array("idDialog" => 'dialog_pegatasan'), //,'jsFunction'=>"setDialog(this);"
                    'htmlOptions' => array('placeholder' => 'Pegawai Mengetahui', 'class' => 'span3 required', 'onkeypress' => "return $(this).focusNextInputField(event)"),
                ));
                ?>
            </div>
        </div>


    </div>
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo CHtml::label("Pegawai Menyetujui <span class='required'>*</span>", 'diketahuikeuangan_id', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->hiddenField($model, 'accdirektur_id', array('readonly' => true)); ?>
                <?php echo $form->textField($model, 'accdirektur_nama', array('readonly' => true, 'class' => 'span3')); ?>
            </div>
        </div>
        <!--<div class="control-group">-->
        <?php // echo CHtml::label("Disetujui Oleh <span class='required'>*</span>",'disetujuioleh_id', array('class' => 'control-label')) 
        ?>
        <!--<div class="controls">-->
        <?php // echo $form->hiddenField($model,'disetujuioleh_id',array('readonly' => true)); 
        ?>
        <?php
        //							$this->widget('MyJuiAutoComplete',array(
        //								'attribute'=>'disetujuioleh_nama',
        //								'model'=>$model,
        //								'source' => 'js: function(request, response) {
        //											   $.ajax({
        //												   url: "' . $this->createUrl('AutocompletePegawai') . '",
        //												   dataType: "json",
        //												   data: {
        //													   term: request.term,
        //													   filter:"keuangan"
        //												   },
        //												   success: function (data) {
        //														   response(data);
        //												   }
        //											   })
        //											}',
        //								'options'=>array(
        //									'showAnim' => 'fold',
        //									'minLength' => 3,
        //									'focus'=>'js:function( event, ui ) {
        //										$("#'.CHtml::activeId($model, 'disetujuioleh_nama').'").val( ui.item.label );
        //										return false;
        //									}',
        //									 'select'=>'js:function( event, ui ) {
        //										$("#'.CHtml::activeId($model, 'disetujuioleh_id').'").val( ui.item.value );
        //										$("#'.CHtml::activeId($model, 'disetujuioleh_nama').'").val( ui.item.label );
        //										return false;
        //									}',															  
        //								),
        //								'htmlOptions'=>array('onkeypress'=>"return $(this).focusNextInputField(event)", 'class'=> 'col-sm-8 required'),
        //								'tombolDialog'=>array('idDialog'=>'dialog_disetujui','idTombol'=>'tombolPegApproved'),
        //							));
        ?>
        <!--</div>-->
        <!--</div>-->

        <!--<div class="control-group" id="form-direktur">-->
        <?php //echo $form->labelEx($model,'accdirektur_id', array('class' => 'control-label')) 
        ?>
        <?php // echo CHtml::label("Direktur <span class='required'>*</span>",'accdirektur_id', array('class' => 'control-label')) 
        ?>
        <!--<div class="controls">-->
        <?php // echo $form->hiddenField($model,'accdirektur_id',array('readonly' => true)); 
        ?>
        <?php
        //							$this->widget('MyJuiAutoComplete',array(
        //								'attribute'=>'accdirektur_nama',
        //								'model'=>$model,
        //								'source' => 'js: function(request, response) {
        //											   $.ajax({
        //												   url: "' . $this->createUrl('AutocompletePegawai') . '",
        //												   dataType: "json",
        //												   data: {
        //													   term: request.term,
        //													   filter:"direktur"
        //												   },
        //												   success: function (data) {
        //														   response(data);
        //												   }
        //											   })
        //											}',
        //								'options'=>array(
        //									'showAnim' => 'fold',
        //									'minLength' => 3,
        //									'focus'=>'js:function( event, ui ) {
        //										$("#'.CHtml::activeId($model, 'accdirektur_nama').'").val( ui.item.label );
        //										return false;
        //									}',
        //									 'select'=>'js:function( event, ui ) {
        //										$("#'.CHtml::activeId($model, 'accdirektur_id').'").val( ui.item.value );
        //										$("#'.CHtml::activeId($model, 'accdirektur_nama').'").val( ui.item.label );
        //										return false;
        //									}',		
        //								),
        //								'htmlOptions'=>array('onkeypress'=>"return $(this).focusNextInputField(event)", 'class'=> 'col-sm-8 required'),
        //								'tombolDialog'=>array('idDialog'=>'dialog_pegacc','idTombol'=>'tombolPegApproved', 'class'=> ''),
        //							));
        ?>
        <!--</div>-->
        <!--</div>-->

        <!--		<div class="control-group" id="form-kabidyanmed">
			<?php //echo $form->labelEx($model,'accdirektur_id', array('class' => 'control-label')) 
            ?>
			<?php // echo CHtml::label("Kabid Yanmed <span class='required'>*</span>",'kabidyanmed_id', array('class' => 'control-label')) 
            ?>
			<div class="controls">
				<?php // echo $form->hiddenField($model,'kabidyanmed_id',array('readonly' => true)); 
                ?>
				<?php
                //							$this->widget('MyJuiAutoComplete',array(
                //								'attribute'=>'kabidyanmed_nama',
                //								'model'=>$model,
                //								'source' => 'js: function(request, response) {
                //											   $.ajax({
                //												   url: "' . $this->createUrl('AutocompletePegawai') . '",
                //												   dataType: "json",
                //												   data: {
                //													   term: request.term,
                //													   filter:"kabidyanmed"
                //												   },
                //												   success: function (data) {
                //														   response(data);
                //												   }
                //											   })
                //											}',
                //								'options'=>array(
                //									'showAnim' => 'fold',
                //									'minLength' => 3,
                //									'focus'=>'js:function( event, ui ) {
                //										$("#'.CHtml::activeId($model, 'kabidyanmed_nama').'").val( ui.item.label );
                //										return false;
                //									}',
                //									 'select'=>'js:function( event, ui ) {
                //										$("#'.CHtml::activeId($model, 'kabidyanmed_id').'").val( ui.item.value );
                //										$("#'.CHtml::activeId($model, 'kabidyanmed_nama').'").val( ui.item.label );
                //										return false;
                //									}',		
                //								),
                //								'htmlOptions'=>array('onkeypress'=>"return $(this).focusNextInputField(event)", 'class'=> 'col-sm-8 required'),
                //								'tombolDialog'=>array('idDialog'=>'dialog_pegkabidyanmed','idTombol'=>'tombolPegKabidYanmed', 'class'=> ''),
                //							));
                ?>
			</div>
		</div>-->

    </div>
</div>

<div class="clear"></div>