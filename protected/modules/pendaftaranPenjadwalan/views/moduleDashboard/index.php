<table class="row box dashboard">
    <tr>
        <td width=50%>
            <div class="row">
                <fieldset class="well">
                    <?php $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
                        'id' => 'profile',
                        'content' => array(
                            'content-profile' => array(
                                'header' => '<b><i class="icon-user icon-white"></i> Profile</b>',
                                'isi' => $this->renderPartial('_infoUser', array('modPemakai' => $modPemakai, 'modPegawai' => $modPegawai, 'modRuanganPegawai' => $modRuanganPegawai), true),
                                'active' => false,
                            ),
                        ),
                    )); ?>
                </fieldset>
            </div>
            <div class="row">
                <fieldset class="well">
                    <?php echo CHtml::link('<i class="entypo-arrows-ccw"></i>', 'javascript:void(0);',  array('rel' => 'tooltip', 'title' => 'Refresh', 'class' => 'refresh-mask', 'onclick' => "setStatistik()")); ?>
                    <?php $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
                        'id' => 'statistik',
                        'content' => array(
                            'content-statistik' => array(
                                'header' => '<b style="margin-left:30px"><i class="icon-user icon-white"></i> Statistik Hari Ini</b>',
                                'isi' => '<iframe src="" id="ifstatistik" width="100%" height="100%" onresize="javascript:resizeIframe(this);" onload="javascript:resizeIframe(this);"></iframe> ',
                                'active' => true,
                            ),
                        ),
                    )); ?>
                </fieldset>
            </div>

            <!--		DIHIDE SEMENTARA MENUNGGU ANALISIS DAN DATABASE
                <div class="row">
			<fieldset class="well">
			<?php
            //			$this->Widget('ext.bootstrap.widgets.BootAccordion',array(
            //				        'id'=>'catatan',
            //				        'content'=>array(
            //				            'content-catatan'=>array(
            //				                'header'=>'<b><i class="icon-file icon-white"></i> Catatan</b>',
            //				                'isi'=>$this->renderPartial('_catatan',array(),true),
            //				                'active'=>true,
            //				                ),   
            //				            ),
            //			)); 
            ?>
			</fieldset>
		</div>
		<div class="row">
			<fieldset class="well">
			<?php
            //                        $this->Widget('ext.bootstrap.widgets.BootAccordion',array(
            //			                    'id'=>'kotakmasuk',
            //			                    'content'=>array(
            //			                        'content-kotakmasuk'=>array(
            //			                            'header'=>'<b><i class="icon-envelope icon-white"></i> Kotak Masuk</b>',
            //			                            'isi'=>$this->renderPartial('_kotakMasuk',array(),true),
            //			                            'active'=>true,
            //			                            ),   
            //			                        ),
            //			)); 
            ?>      
			</fieldset>
		</div>
-->
            <div class="row">
                <fieldset class="well">
                    <?php echo CHtml::link('<i class="entypo-arrows-ccw"></i>', 'javascript:void(0);',  array('rel' => 'tooltip', 'title' => 'Refresh', 'class' => 'refresh-mask', 'onclick' => "refresh('todolist')")); ?>
                    <?php
                    $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
                        'id' => 'todolist',
                        'content' => array(
                            'content-todolist' => array(
                                'header' => '<b style="margin-left:30px"><i class="icon-list icon-white"></i> To Do List</b>',
                                'isi' => $this->renderPartial('_todolist', array('dataProviderTodolist' => $dataProviderTodolist, 'modTodolist' => $modTodolist), true),
                                'active' => true,
                            ),
                        ),
                    )); ?>
                    <?php // echo CHtml::htmlButton(Yii::t('mds','{icon} Tambah To Do List',array('{icon}'=>'<i class="icon-plus icon-white"></i>')),array('title'=>'Klik untuk menampilkan form antrian','rel'=>'tooltip','class'=>'btn btn-success', 'style'=>'margin-left:20px', 'onclick'=>'$("#dialog-ubah-todolist").dialog("open");refreshFormTodolist();')); 
                    ?>
                </fieldset>

            </div>

        </td>
        <td>
            <div class="row">
                <fieldset class="well">
                    <?php $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
                        'id' => 'shortcut',
                        'content' => array(
                            'content-shortcut' => array(
                                'header' => '<b><i class="icon-th-large icon-white"></i> Shortcut</b>',
                                'isi' => $this->renderPartial('_shortcutMenu', array('modMenu' => $modMenu), true),
                                'active' => true,
                            ),
                        ),
                    )); ?>
                </fieldset>
            </div>
            <div class="row">
                <fieldset class="well">
                    <?php echo CHtml::link('<i class="entypo-arrows-ccw"></i>', 'javascript:void(0);',  array('rel' => 'tooltip', 'title' => 'Refresh', 'class' => 'refresh-mask', 'onclick' => 'refresh("pengumuman")')); ?>
                    <?php
                    $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
                        'id' => 'pengumuman',
                        'content' => array(
                            'content-pengumuman' => array(
                                'header' => '<b style="margin-left:30px"><i class="icon-list icon-white"></i> Pengumuman</b>',
                                'isi' => $this->renderPartial('_pengumuman', array('dataProvider' => $dataProviderPengumuman), true),
                                'active' => true,
                            ),
                        ),
                    )); ?>
                </fieldset>
            </div>

            <div class="row">
                <fieldset class="well">
                    <?php echo CHtml::link('<i class="entypo-arrows-ccw"></i>', 'javascript:void(0);',  array('rel' => 'tooltip', 'title' => 'Refresh', 'class' => 'refresh-mask', 'onclick' => "setKalender()")); ?>
                    <?php
                    $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
                        'id' => 'kalender',
                        'content' => array(
                            'content-kalender' => array(
                                'header' => '<b style="margin-left:30px"><i class="entypo-calendar icon-white"></i> Kalender</b>',
                                'isi' => '<iframe src="" id="ifkalender" width="100%" height="100%" onresize="javascript:resizeIframe(this);" onload="javascript:resizeIframe(this);"></iframe> ',
                                'active' => true,
                            ),
                        ),
                    )); ?>
                </fieldset>
            </div>

        </td>

    </tr>
</table>

<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialog-ubah-todolist',
    'options' => array(
        'title' => 'To Do List',
        'autoOpen' => false,
        'width' => 600,
        'resizable' => false,
    ),
));
?>
<div class="dialog-content">
    <?php echo $this->renderPartial('_formTodolist', array('modTodolist' => $modTodolist)); ?>
</div>

<div style="text-align: center;">
    <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Simpan', array('{icon}' => '<i class="entypo-check"></i>')), array('class' => 'btn  btn-warning', 'onclick' => 'updateTodolist();')); ?>
    <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-cancel"></i>')), array('class' => 'btn btn-danger', 'onclick' => '$(\'#dialog-ubah-todolist\').dialog(\'close\')')); ?>
</div>
<?php $this->endWidget(); ?>

<?php echo $this->renderPartial('_jsFunctionsTodolist', array('modTodolist' => $modTodolist)); ?>
<?php echo $this->renderPartial('_jsFunctions', array('modPemakai' => $modPemakai, 'modPegawai' => $modPegawai, 'modRuanganPegawai' => $modRuanganPegawai)); ?>