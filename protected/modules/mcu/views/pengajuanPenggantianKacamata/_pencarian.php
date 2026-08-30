<div class="search-form">
    <?php
    $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
        'action' => Yii::app()->createUrl($this->route),
        'method' => 'get',
        'id' => 'pencariankacamata-form',
        'type' => 'horizontal',
    ));
    ?>
    <div class="row">
        <!--<div class="col-sm-6">
        <div class="control-group">
			<label class='control-label'>Tgl. Ganti Kacamata</label>
			<div class="controls">
				<?php
                //					$modGantiKacamata->tgl_awal = isset($modGantiKacamata->tgl_awal) ? MyFormatter::formatDateTimeForUser($modGantiKacamata->tgl_awal) : date('d M Y');
                //					$this->widget('MyDateTimePicker',array(
                //						'model'=>$modGantiKacamata,
                //						'attribute'=>'tgl_awal',
                //						'mode'=>'date',
                //						'options'=> array(
                //							'dateFormat'=>Params::DATE_FORMAT,
                //							'maxDate' => 'd',
                //						),
                //						'htmlOptions'=>array('readonly'=>true,'class'=>'dtPicker3'),
                //					)); 
                ?>
			</div>
		</div>
    </div>
    <div class="col-sm-6">
		<div class="control-group">
			<label class='control-label'>Sampai Dengan</label>
			<div class="controls">
				<?php
                //					$modGantiKacamata->tgl_akhir = isset($modGantiKacamata->tgl_akhir) ? MyFormatter::formatDateTimeForUser($modGantiKacamata->tgl_akhir) : date('d M Y');
                //					$this->widget('MyDateTimePicker',array(
                //						'model'=>$modGantiKacamata,
                //						'attribute'=>'tgl_akhir',
                //						'mode'=>'date',
                //						'options'=> array(
                //							'dateFormat'=>Params::DATE_FORMAT,
                //							'maxDate' => 'd',
                //						),
                //						'htmlOptions'=>array('readonly'=>true,'class'=>'dtPicker3'),
                //					)); 
                ?>
			</div>
		</div>
    </div>-->
        <div class="col-sm-6">
            <!--<div class="col-sm-6">-->
            <br>
            <div class="control-group">
                <?php echo CHtml::label("Tgl. Ganti Kacamata", 'tgl_rekam', array('class' => 'control-label')) ?>
                <div class="controls">
                    <div class="daterange daterange-inline input-inline span4" data-format="DD MMM YYYY" data-start-date="<?php echo date('d M Y', strtotime($modGantiKacamata->tgl_awal)) ?>" data-end-date="<?php echo date('d M Y', strtotime($modGantiKacamata->tgl_akhir)) ?>">
                        <i class="entypo-calendar"></i>
                        <span><?php echo date('d M Y', strtotime($modGantiKacamata->tgl_awal)) ?> - <?php echo date('d M Y', strtotime($modGantiKacamata->tgl_akhir)) ?></span>
                        <?php echo $form->hiddenField($modGantiKacamata, 'tgl_awal', array('class' => 'start')) ?>
                        <?php echo $form->hiddenField($modGantiKacamata, 'tgl_akhir', array('class' => 'end')) ?>
                    </div>
                </div>
            </div>
            <!--</div>-->
        </div>
        <div class="clear"></div>
        <div class="form-actions">
            <?php echo CHtml::htmlButton(
                Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
                array('title' => 'Cari', 'class' => 'btn btn-danger', 'type' => 'submit')
            ); ?>
        </div>
    </div>
    <?php $this->endWidget(); ?>
</div>