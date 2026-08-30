<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
<i class="entypo-search"></i> Pencarian</div>
    </div>
    <div class="panel-body">
        <div class="search-form">
            <?php
            $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
                'action' => Yii::app()->createUrl($this->route),
                'method' => 'get',
                'type' => 'horizontal',
                'id' => 'searchLaporan',
                'htmlOptions' => array('enctype' => 'multipart/form-data', 'onKeyPress' => 'return disableKeyPress(event)'),
            ));
            ?>

            <style>
                #penjamin label.checkbox {
                    width: 100px;
                    display: inline-block;
                }
        
                label.checkbox,
                label.radio {
                    width: 200px;
                    display: inline-block;
                }
        
                .form-horizontal .radio>label,
                .form-horizontal .checkbox>label {
                    float: left !important;
                    max-width: 150px;
                    margin-left: 5px !important;
                    padding: 0 !important;
                }
        
                .form-horizontal .radio>input,
                .form-horizontal .checkbox>input {
                    float: left !important;
                    margin-top: 2px !important;
                }
            </style>
        
            <div class="row">
                <div class="col-sm-12">
                    <?php //$format = new MyFormatter(); 
                    ?>
                    <?php echo CHtml::hiddenField('type', ''); ?>
                    <div class="control-group">
                        <?php echo $form->hiddenField($model, 'jns_periode', array('class' => 'span2')); ?>
                        <?php echo $form->hiddenField($model, 'bln_awal', array('class' => 'span2')); ?>
                        <?php echo $form->hiddenField($model, 'bln_akhir', array('class' => 'span2')); ?>
                        <?php echo $form->hiddenField($model, 'thn_awal', array('class' => 'span2')); ?>
                        <?php echo $form->hiddenField($model, 'thn_akhir', array('class' => 'span2')); ?>
                        <?php echo CHtml::label("Periode Laporan", 'tgl_rekam', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <div class="daterange daterange-inline add-ranges input-inline span4" data-format="DD MMM YYYY" data-start-date="<?php echo date('d M Y', strtotime($model->tgl_awal)) ?>" data-end-date="<?php echo date('d M Y', strtotime($model->tgl_akhir)) ?>">
                                <i class="entypo-calendar"></i>
                                <span><?php echo date('d M Y', strtotime($model->tgl_awal)) ?> - <?php echo date('d M Y', strtotime($model->tgl_akhir)) ?></span>
                                <?php echo $form->hiddenField($model, 'tgl_awal', array('class' => 'start')) ?>
                                <?php echo $form->hiddenField($model, 'tgl_akhir', array('class' => 'end')) ?>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6">
                    <div class="control-group">
                        <label class="control-label">Rujukan</label>
                        <div class="controls">
                            <?php echo $form->checkBoxList($model, 'asalrujukan_id', CHtml::listData(AsalrujukanM::model()->findAll('asalrujukan_aktif = true'), 'asalrujukan_id', 'asalrujukan_nama')); ?>
                        </div>
                    </div>

                    <!--<div class="panel panel-success">
                        <div class="panel-heading">
                            <div class="panel-title">
                                <i class="glyphicon glyphicon-file"></i> Berdasarkan Rujukan
                            </div>
                        </div>
                        <div class="panel-body">
                            <?php echo $form->checkBoxList($model, 'asalrujukan_id', CHtml::listData(AsalrujukanM::model()->findAll('asalrujukan_aktif = true'), 'asalrujukan_id', 'asalrujukan_nama')); ?>
                        </div>
                    </div>-->
                </div>

                <div class="col-sm-6">
                    <div class="control-group">
                        <label class="control-label">Filter</label>
                        <div class="controls">
                            <?php $model->pilihan = 'instalasi'; ?>
                            <?php echo $form->radioButtonList($model, 'pilihan', $model->pilihanGrafik()); ?>
                        </div>
                    </div>

                    <!--<div class="panel panel-success">
                        <div class="panel-heading">
                            <div class="panel-title">
                                <i class="glyphicon glyphicon-file"></i> Opsi Grafik
                            </div>
                        </div>
                        <div class="panel-body">
                            <?php $model->pilihan = 'instalasi'; ?>
                            <?php echo $form->radioButtonList($model, 'pilihan', $model->pilihanGrafik()); ?>
                        </div>
                    </div>-->
                </div>

                <div class="clear"></div>

                <div class="col-sm-12">
                    <div class="panel panel-success">
                        <div class="panel-heading">
                            <div class="panel-title">
                                <i class="glyphicon glyphicon-file"></i> Berdasarkan Asal Instalasi
                            </div>
                        </div>
                        <div class="panel-body">
                            <?php echo $form->checkBoxList($model, 'ruanganasal_id', CHtml::listData(RuanganM::model()->findAll('ruangan_aktif = true'), 'ruangan_id', 'ruangan_nama')); ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-actions" style="margin-top: 17px !important;">
                <?php
                echo CHtml::htmlButton(
                    Yii::t(
                        'mds',
                        '{icon} Search',
                        array('{icon}' => '<i class="entypo-search"></i>')
                    ),
                    array('title' => 'Cari', 'class' => 'btn btn-danger', 'type' => 'submit', 'id' => 'btn_simpan')
                );
                ?>

                <?php
                echo CHtml::link(
                    Yii::t(
                        'mds',
                        '{icon} Reset',
                        array('{icon}' => '<i class="entypo-arrows-ccw"></i>')
                    ),
                    Yii::app()->createUrl($this->module->id . '/' . Yii::app()->controller->id . '/' . Yii::app()->controller->action->id . ''),
                    array(
                        'title' => 'Ulang',
                        'class' => 'btn btn-default',
                        'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
                    )
                );
                ?>
            </div>
            <?php //$this->widget('UserTips', array('type' => 'create')); 
            ?>
        </div>
        <?php
        $this->endWidget();
        $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
        $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
        ?>
        <?php Yii::app()->clientScript->registerScript('cekAll', '
  $("#content4").find("input[type=\'checkbox\']").attr("checked", "checked");
',  CClientScript::POS_READY);
        ?>

        <?php //Yii::app()->clientScript->registerScript('onclickButton','
        //  var tampilGrafik = "<div class=\"tampilGrafik\" style=\"display:inline-block\"> <i class=\"icon-arrow-right icon-white\"></i> Grafik</div>";
        //  $(".accordion-heading a.accordion-toggle").click(function(){
        //            $(this).parents(".accordion").find("div.tampilGrafik").remove();
        //            $(this).parents(".accordion-group").has(".accordion-body.in").length ? "" : $(this).append(tampilGrafik);
        //            
        //            
        //  });
        //',  CClientScript::POS_READY);
        ?>
    </div>
</div>