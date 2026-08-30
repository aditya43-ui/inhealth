<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'stokobatalkes-search',
                'type'=>'horizontal',
)); ?>

<legend class="rim">Pencarian</legend>
                <div class="control-group ">
                    <table>
                        <tr>
                            <td>
                                <?php echo $form->dropDownListRow($model,'ruangan_id',CHtml::listData($model->getRuanganItems(),'ruangan_id','ruangan_nama'),array('empty'=>'-- Pilih --', 'onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'span2')); ?>
                                <?php echo $form->dropDownListRow($model,'jenisobatalkes_id',CHtml::listData($model->getJenisobatalkesItems(),'jenisobatalkes_id','jenisobatalkes_nama'),array('class'=>'span2','empty'=>'-- Pilih --')); ?>
                                <?php echo $form->dropDownListRow($model,'obatalkes_golongan',LookupM::getItems('obatalkes_golongan'),array('empty'=>'-- Pilih --', 'onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'span2')); ?>
                            </td>
                            <td>
                                <?php echo $form->dropDownListRow($model,'sumberdana_id',CHtml::listData($model->getSumberdanaItems(),'sumberdana_id','sumberdana_nama'),array('class'=>'span2','empty'=>'-- Pilih --')); ?>
                                <?php echo $form->textFieldRow($model,'obatalkes_kode',array('class'=>'span3')); ?>
                                <?php echo $form->textFieldRow($model,'obatalkes_nama',array('class'=>'span3')); ?>
                            </td>
                        </tr>
                    </table>
                    </div>

	<div class="form-actions">
                    <?php
                        echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="entypo-search"></i>')),array('class'=>'btn btn-danger', 'type'=>'submit'));
                        echo CHtml::link(Yii::t('mds','{icon} Cancel',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
                                                Yii::app()->createUrl($this->route), 
                                                array('class'=>'btn btn-danger',
                                                      'onclick'=>'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;')); 
//                 $content = $this->renderPartial($this->path_view.'../tips/informasi',array(),true);
//                      $this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
                    ?>
	</div>

<?php $this->endWidget(); ?>
