<tr>
    <td>
		<?php echo CHtml::hiddenField('no_urut',0,array('readonly'=>true,'class'=>'span2 integer', 'style'=>'width:20px;')); ?>
		Db
    </td>
    <td>
		<?php echo CHtml::activeTextField($modHearingTest,'tkn_500',array('readonly'=>false,'class'=>'span2')); ?>
    </td>
    <td>
        <?php echo CHtml::activeTextField($modHearingTest,'tkn_1k',array('readonly'=>false,'class'=>'span2')); ?>
    </td>
    <td>
        <?php echo CHtml::activeTextField($modHearingTest,'tkn_2k',array('readonly'=>false,'class'=>'span2')); ?>
	</td>
    <td>
        <?php echo CHtml::activeTextField($modHearingTest,'tkn_3k',array('readonly'=>false,'class'=>'span2')); ?>
	</td>
    <td>
        <?php echo CHtml::activeTextField($modHearingTest,'tkn_4k',array('readonly'=>false,'class'=>'span2')); ?>
	</td>
    <td>
        <?php echo CHtml::activeTextField($modHearingTest,'tkn_6k',array('readonly'=>false,'class'=>'span2')); ?>
	</td>
    <td>
        <?php echo CHtml::activeTextField($modHearingTest,'tkn_8k',array('readonly'=>false,'class'=>'span2')); ?>
	</td>
    <td>
        <?php
			if(!empty($modHearingTest->hearingtest_id)){
				echo CHtml::link(Yii::t('mds','{icon}',array('{icon}'=>'<i class="icon-form-lihat"></i>')), 
				$this->createUrl($this->id.'/grafikTelingaKanan&hearingtest_id='.$modHearingTest->hearingtest_id.'&pendaftaran_id='.$modHearingTest->pendaftaran_id), 
				array('class'=>'',"target"=>"frameTelingaKanan","onclick"=>"$('#diagramTelingaKanan').dialog('open');"));
			}else{
				echo "-";
			}
		?>
	</td>
</tr>