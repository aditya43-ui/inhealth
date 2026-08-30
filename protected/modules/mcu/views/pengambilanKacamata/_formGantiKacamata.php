<div class="col-sm-6">
	<div id="div-duedate">
	<div class="control-group">
		<?php echo $form->labelEx($model, 'duedata_kacamata', array('class' => 'control-label')) ?>
			<div class="controls">
				<?php   
					$model->duedata_kacamata = (!empty($model->duedata_kacamata) ? date("d/m/Y",strtotime($model->duedata_kacamata)) : null);
					$this->widget('MyDateTimePicker',array(
						'model'=>$model,
						'attribute'=>'duedata_kacamata',
						'mode'=>'date',
						'options'=> array(
							'showOn' => false,
							'maxDate' => 'd',
							'yearRange'=> "-150:+0",
							'onkeyup'=>"js:function(){setTglGantiKacamata(this.value);}",
							'onSelect'=>'js:function(){setTglGantiKacamata(this.value);}',
						),
	                    'htmlOptions'=>array('placeholder'=>'00/00/0000','class'=>'dtPicker2 datemask','onblur'=>'setTglGantiKacamata(this.value);','onkeyup'=>"return $(this).focusNextInputField(event)"
						),
				)); ?>
			</div>
	</div>
	</div>
	<?php $model->tglgantikacamata = (!empty($model->tglgantikacamata) ? date("d/m/Y",strtotime($model->tglgantikacamata)) : null); ?>
	<?php echo $form->textFieldRow($model,'tglgantikacamata',array('class'=>'span2 dateemask','placeholder'=>'00/00/0000', 'onkeyup'=>"return $(this).focusNextInputField(event);",'readonly'=>true)); ?>    
</div>
<div class="col-sm-6">	    
    <div class="control-group">
        <?php echo $form->labelEx($model, 'tglpenyerahan', array('class' => 'control-label')) ?>
        <div class="controls">
            <?php   
                $model->tglpenyerahan = (!empty($model->tglpenyerahan) ? date("d/m/Y",strtotime($model->tglpenyerahan)) : null);
                $this->widget('MyDateTimePicker',array(
                    'model'=>$model,
                    'attribute'=>'tglpenyerahan',
                    'mode'=>'date',
                    'options'=> array(
                        'showOn' => false,
                        'maxDate' => 'd',
                        'yearRange'=> "-150:+0",
						'onkeyup'=>"js:function(){setTglGantiKacamata(this.value);}",
						'onSelect'=>'js:function(){setTglGantiKacamata(this.value);}',
                    ),
                    'htmlOptions'=>array('placeholder'=>'00/00/0000','class'=>'dtPicker2 datemask','onblur'=>'setTglGantiKacamata(this.value);','onkeyup'=>"return $(this).focusNextInputField(event)"
                    ),
            )); ?>
        </div>
    </div>
	<?php echo $form->textFieldRow($model,'jumlahharga_km',array('class'=>'span2 integer', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>    
</div>