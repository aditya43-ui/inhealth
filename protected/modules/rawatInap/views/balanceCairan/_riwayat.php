<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">Riwayat</div>
    </div>
    <div class="panel-body">
      <?php
      $modRiwayat = new BalancecairanT();
      $modRiwayat->pasienadmisi_id = $modPendaftaran->pasienadmisi_id;

      $this->widget('ext.bootstrap.widgets.HeaderGroupGridViewNonRp', array(
          'id' => 'riwayatbalancecairan-grid',
          'dataProvider' => $modRiwayat->searchRiwayat(),
          'template' => "{summary}\n{items}\n{pager}",
          'mergeColumns'=>array('tanggal_pencatatan'),
          'itemsCssClass' => 'table table-bordered table-striped table-condensed',
          'columns' => array(
            array(
                'header' => 'No',
                'type' => 'raw',
                'value' => '$row+1',
            ),
            array(
                'header' => 'Tanggal Pencatatan',
                'type' => 'raw',
                'name'=>'tanggal_pencatatan',
                'value' => 'MyFormatter::formatDateTimeForUser(date("Y-m-d",strtotime($data->tanggal_pencatatan)))',
            ),
            array(
                'header' => 'Jam Pencatatan',
                'type' => 'raw',
                'value' => 'date("H:i:s",strtotime($data->tanggal_pencatatan))',
            ),
            array(
                'header' => 'Petugas Pengisi',
                'type' => 'raw',
                'value' => '$data->petugasPengisi->namaLengkap',
            ),
            array(
                'header' => 'Ruangan',
                'type' => 'raw',
                'value' => function ($data){
                    $ruangan = RuanganM::model()->findByPk($data->create_ruangan_id);
                    return (!empty($ruangan)?$ruangan->ruangan_nama:"");
                  },
            ),
            array(
                'header' => 'Riwayat Cairan Masuk',
                'type' => 'raw',
                'value' => function($data){
                  return CHtml::link(
                        '<icon class="icon-form-detail"></icon>', Yii::app()->controller->createUrl("riwayat", array("pasienadmisi_id"=>$data->pasienadmisi_id,"balancecairan_id"=>$data->balancecairan_id,"type"=>'cairanmasuk')),
                        array(
                            "target"=>"iframeCairanMasuk",
                            "onclick"=>"$('#dialogCairanMasuk').dialog('open');",
                            "rel"=>"tooltip",
                            "title"=>"Klik untuk Melihat Detail Cairan Masuk",

                        ));
                },
                'htmlOptions'=>array('style'=>'text-align: center;')
            ),
            array(
                'header' => 'Riwayat Cairan Keluar',
                'type' => 'raw',
                'value' => function($data){
                  return CHtml::link(
                        '<icon class="icon-form-detail"></icon>', Yii::app()->controller->createUrl("riwayat", array("pasienadmisi_id"=>$data->pasienadmisi_id,"balancecairan_id"=>$data->balancecairan_id,"type"=>'cairankeluar')),
                        array(
                            "target"=>"iframeCairanKeluar",
                            "onclick"=>"$('#dialogCairanKeluar').dialog('open');",
                            "rel"=>"tooltip",
                            "title"=>"Klik untuk Melihat Detail Cairan Keluar",

                        ));
                },
                'htmlOptions'=>array('style'=>'text-align: center;')
            ),
            array(
                'header' => 'Riwayat Oksigen',
                'type' => 'raw',
                'value' => function($data){
                      return CHtml::link(
                            '<icon class="icon-form-detail"></icon>', Yii::app()->controller->createUrl("riwayat", array("pasienadmisi_id"=>$data->pasienadmisi_id,"balancecairan_id"=>$data->balancecairan_id,"type"=>'oksigen')),
                            array(
                                "target"=>"iframeOksigen",
                                "onclick"=>"$('#dialogOksigen').dialog('open');",
                                "rel"=>"tooltip",
                                "title"=>"Klik untuk Melihat Detail Oksigen",

                            ));
                },
                'htmlOptions'=>array('style'=>'text-align: center;')
            ),
            array(
                'header' => 'Riwayat Diet',
                'type' => 'raw',
                'value' => function($data){
                  return CHtml::link(
                        '<icon class="icon-form-detail"></icon>', Yii::app()->controller->createUrl("riwayat", array("pasienadmisi_id"=>$data->pasienadmisi_id,"balancecairan_id"=>$data->balancecairan_id,"type"=>'diet')),
                        array(
                            "target"=>"iframeDiet",
                            "onclick"=>"$('#dialogDiet').dialog('open');",
                            "rel"=>"tooltip",
                            "title"=>"Klik untuk Melihat Detail Diet",

                        ));
                },
                'htmlOptions'=>array('style'=>'text-align: center;')
            ),
            array(
                'header' => 'Riwayat Program Infus',
                'type' => 'raw',
                'value' => function($data){
                  return CHtml::link(
                        '<icon class="icon-form-detail"></icon>', Yii::app()->controller->createUrl("riwayat", array("pasienadmisi_id"=>$data->pasienadmisi_id,"balancecairan_id"=>$data->balancecairan_id,"type"=>'programinfus')),
                        array(
                            "target"=>"iframeProgramInfus",
                            "onclick"=>"$('#dialogProgramInfus').dialog('open');",
                            "rel"=>"tooltip",
                            "title"=>"Klik untuk Melihat Detail Program Infus",

                        ));
                },
                'htmlOptions'=>array('style'=>'text-align: center;')
            ),
            array(
                'header'=>'Ubah',
                'type'=>'raw',
                'value'=>function($data) {
                    return CHtml::link('<i class="entypo-pencil" style="font-size: 14pt"></i>', Yii::app()->controller->createUrl('index', array(
                        'pendaftaran_id'=>$data->pasienadmisi->pendaftaran_id,
                        'pasienadmisi_id'=>$data->pasienadmisi_id,
                        'balancecairan_id'=>$data->balancecairan_id, 
                        'type'=> $_GET['type'],
                        'frame'=> $_GET['frame']
                    )));
                },
                'htmlOptions'=>array(
                    'style'=>'text-align: center;',
                )
            ),
            array(
                'header'=>'Hapus',
                'type'=>'raw',
                'value'=>function($data) {
                    return CHtml::link('<i class="entypo-trash" style="font-size: 14pt"></i>', 'javascript:void(0)', array(
                        'onclick'=>'hapusRiwayat('.$data->balancecairan_id.'); return false'
                    ));
                },
                'htmlOptions'=>array(
                    'style'=>'text-align: center;',
                )
            ),
            array(
                'header'=>'Balance Cairan',
                'type'=>'raw',
                'name'=>'tanggal_pencatatan',
                'value'=>function($data) {
                  $checkPerhitungan = PerhitunganbalancecairanT::model()->findByAttributes(array('pasienadmisi_id'=>$data->pasienadmisi_id,'balancecairan_tanggal'=>date('Y-m-d',strtotime(MyFormatter::formatDateTimeForDb($data->tanggal_pencatatan)))));
                    return CHtml::link('<i class="entypo-pencil" style="font-size: 14pt"></i> <br/> Hitung Balance Cairan', Yii::app()->controller->createUrl('perhitunganBalanceCairan', array(
                        'pasienadmisi_id'=>$data->pasienadmisi_id,
                        'tanggal_pencatatan'=>date('Y-m-d',strtotime(MyFormatter::formatDateTimeForDb($data->tanggal_pencatatan))), 
                        'type'=> $_GET['type'],
                        'frame'=> $_GET['frame']
                    ))) .'<br/>'. (!empty($checkPerhitungan)? CHtml::link(
                          '<icon class="icon-form-detail"></icon> <br/> Balance Cairan 24 Jam', Yii::app()->controller->createUrl("detailPerhitunganCairan", array("perhitunganbalancecairan_id"=>$checkPerhitungan->perhitunganbalancecairan_id)),
                          array(
                              "target"=>"iframeBalanceCairan",
                              "onclick"=>"$('#dialogBalanceCairan').dialog('open');",
                              "rel"=>"tooltip",
                              "title"=>"Klik untuk Melihat Detail Balance Cairan 24 Jam",

                          )):"");
                },
                'htmlOptions'=>array(
                    'style'=>'text-align: center;',
                )
            ),
            array(
                'header'=>'Cetak',
                'type'=>'raw',
                'name'=>'tanggal_pencatatan',
                'value'=>function($data) {
                  return CHtml::link('<i class="icon-print"></i>', 'javascript:void(0)', array(
                    'onclick'=>'print('.$data->pasienadmisi_id.',"'.date('Y-m-d',strtotime(MyFormatter::formatDateTimeForDb($data->tanggal_pencatatan))).'"); return false'
                ));
                },
                'htmlOptions'=>array(
                    'style'=>'text-align: center;',
                )
            ),
          ),
          'afterAjaxUpdate' => 'function(id, data){
      			jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});
      			}',
      ));
      ?>
    </div>
</div>

<?php
    $this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
        'id' => 'dialogCairanMasuk',
        'options' => array(
            'title' => 'Detail Cairan Masuk',
            'autoOpen' => false,
            'modal' => true,
            'zIndex'=>1002,
            'width' => 800,
            'height' => 500,
            'resizable' => true
        ),
    ));
    ?>
    <iframe name='iframeCairanMasuk' width="100%" height="100%"></iframe>
<?php $this->endWidget(); ?>

<?php
    $this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
        'id' => 'dialogCairanKeluar',
        'options' => array(
            'title' => 'Detail Cairan Keluar',
            'autoOpen' => false,
            'modal' => true,
            'zIndex'=>1002,
            'width' => 800,
            'height' => 500,
            'resizable' => true
        ),
    ));
    ?>
    <iframe name='iframeCairanKeluar' width="100%" height="100%"></iframe>
<?php $this->endWidget(); ?>

<?php
    $this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
        'id' => 'dialogOksigen',
        'options' => array(
            'title' => 'Detail Oksigen',
            'autoOpen' => false,
            'modal' => true,
            'zIndex'=>1002,
            'width' => 800,
            'height' => 500,
            'resizable' => true
        ),
    ));
    ?>
    <iframe name='iframeOksigen' width="100%" height="100%"></iframe>
<?php $this->endWidget(); ?>

<?php
    $this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
        'id' => 'dialogDiet',
        'options' => array(
            'title' => 'Detail Diet',
            'autoOpen' => false,
            'modal' => true,
            'zIndex'=>1002,
            'width' => 800,
            'height' => 500,
            'resizable' => true
        ),
    ));
    ?>
    <iframe name='iframeDiet' width="100%" height="100%"></iframe>
<?php $this->endWidget(); ?>

<?php
    $this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
        'id' => 'dialogProgramInfus',
        'options' => array(
            'title' => 'Detail Program Infus',
            'autoOpen' => false,
            'modal' => true,
            'zIndex'=>1002,
            'width' => 800,
            'height' => 500,
            'resizable' => true
        ),
    ));
    ?>
    <iframe name='iframeProgramInfus' width="100%" height="100%"></iframe>
<?php $this->endWidget(); ?>

<?php
    $this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
        'id' => 'dialogBalanceCairan',
        'options' => array(
            'title' => 'Detail Balance Cairan 24 Jam Pasien',
            'autoOpen' => false,
            'modal' => true,
            'zIndex'=>1002,
            'width' => 900,
            'height' => 500,
            'resizable' => true
        ),
    ));
    ?>
    <iframe name='iframeBalanceCairan' width="100%" height="100%"></iframe>
<?php $this->endWidget(); ?>
