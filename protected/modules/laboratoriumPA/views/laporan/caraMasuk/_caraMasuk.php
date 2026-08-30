<?php $this->Widget('ext.bootstrap.widgets.BootAccordion',array(
                                    'id'=>'bag',
                                    'slide'=>false,
//                                    'parent'=>false,
//                                    'disabled'=>true,
//                                    'accordion'=>false, //default
                                    'content'=>array(
                                        'content3'=>array(
                                            'header'=>''.CHtml::checkBox('filter[]', false, array('value'=>'NON_RUJUKAN')).' Berdasarkan Non Rujukan',
                                        ),
                                        'content4'=>array(
                                            'header'=>''.CHtml::checkBox('filter[]', false , array('value'=>Params::STATUSPERIKSA_RUJUKAN)).' Berdasarkan Rujukan',
                                            'isi'=>'<table><tr><td>'.$form->checkBoxList($model, 'asalrujukan_id', CHtml::listData(AsalrujukanM::model()->findAll('asalrujukan_aktif = true'),'asalrujukan_id','asalrujukan_nama')).'</td></tr></table>',
                                            'active'=>true, 
                                        ),
                                        
                                    ),
                                    
//                                    'htmlOptions'=>array('class'=>'aw',)
                            )); ?>