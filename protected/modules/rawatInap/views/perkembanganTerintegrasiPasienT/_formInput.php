<div class="col-sm-12 clear">
    <div class="panel panel-primary panel-success">
        <div class="panel-heading">
            <div class="panel-title">S = SUBYEKTIF</div>
        </div>
        <div class="panel-body" id="sub">
            <?php
            //digunakan untuk load data pada hemodialisa
            if (isset($_GET['data']['subyektif'])){
                $model->subyektif = $_GET['data']['subyektif'];
            }
            echo $form->hiddenField($model, 'perkembangan_terintegrasi_pasien_id', array());
            echo $form->hiddenField($model, 'proses', array());
            echo $form->textArea($model, 'subyektif', array('class' => 'form-control ckeditor'));

//               
//                $this->widget('ext.redactorjs.Redactor',array('model'=>$model,'attribute'=>'subyektif', 'toolbar'=>'mini','height'=>'100px')) 
            ?>
        </div>
    </div>
</div>
<div class="col-sm-12 clear">
    <div class="panel panel-primary panel-success">
        <div class="panel-heading">
            <div class="panel-title">O = OBYEKTIF</div>
        </div>
        <div class="panel-body">
            <?php

                //digunakan untuk load data pada modul hemodialisa
                if(isset($_GET['data']['blood_flow'])){
                    $str = "";
//                    $str .= "<p>";
                    $str .= "Blood Flow : ".$_GET['data']['blood_flow']." ml/menit&#13;";                    
                    $str .= "Tekanan Darah : ".$_GET['data']['tensi_sis']."/".$_GET['data']['tensi_dia']." mmHg&#13;";
                    $str .= "Nadi : ".$_GET['data']['nadi']." x/menit&#13;";
                    $str .= "Suhu : ".$_GET['data']['suhu']." C&#13;";
                    $str .= "Respirasi : ".$_GET['data']['respirasi']." x/menit";                                        
//                    $str .= "<p>";
                    
                    $model->obyektif = trim($str);
                    
                    $modMonitoringIntraHd = new MonitoringIntraHdT();
                }
            ?>
            <textarea  cols='70' rows='5' name="<?= CHtml::activeName($model, 'obyektif') ?>" id="<?= CHtml::activeId($model, 'obyektif') ?>" class="form-control ckeditor"><?= trim($model->obyektif) ?></textarea>
            <?php
//            echo $form->textArea($model, 'obyektif', array('class' => 'form-control ckeditor'));

//            $this->widget('ext.redactorjs.Redactor',array('model'=>$model,'attribute'=>'obyektif', 'toolbar'=>'mini','height'=>'100px', 'value'=>'coba' )) 
            ?>
        </div>
    </div>
</div>
<div class="col-sm-12 clear">
    <div class="panel panel-primary panel-success">
        <div class="panel-heading">
            <div class="panel-title">A = ASESMEN</div>
        </div>
        <div class="panel-body">
            <?php
            //digunakan untuk load data pada modul hemodialisa
            if (isset($_GET['data']['subyektif'])){
                    $model->asesmen = $_GET['data']['subyektif'];
            }
//            $this->widget('ext.redactorjs.Redactor',array('model'=>$model,'attribute'=>'asesmen', 'toolbar'=>'mini','height'=>'100px'))

            echo $form->textArea($model, 'asesmen', array('class' => 'form-control ckeditor'));
            ?>
        </div>
    </div>
</div>
<div class="redactor">
    <div class="col-sm-12 clear">
        <div class="panel panel-primary panel-success">
            <div class="panel-heading">
                <div class="panel-title">P = PERENCANAAN</div>
            </div>
            <div class="panel-body">
                <?php
                echo $form->textArea($model, 'perencanaan', array('class' => 'form-control ckeditor'));

// $this->widget('ext.redactorjs.Redactor',array('model'=>$model,'attribute'=>'perencanaan', 'toolbar'=>'mini','height'=>'100px')) 
                ?>
            </div>
        </div>
    </div>
    <div class="col-sm-12 clear">
        <div class="panel panel-primary panel-success">
            <div class="panel-heading">
                <div class="panel-title">I = INSTRUKSI (DOKTER) &nbsp;&nbsp;&nbsp; I = INTERVENSI - IMPLEMENTASI (KEPERAWATAN/KETERAPIAN FISIK/TENAGA GIZI/APOTEKER)</div>
            </div>
            <div class="panel-body">
                <?php
                //digunakan untuk load data pada modul hemodialisa
                if(isset($_GET['data']['penyulit_hd_id'])){
                    if($_GET['data']['penyulit_hd_id'] == 3){
                        $penyulit = PenyulitHdM::model()->findByPk($_GET['data']['penyulit_hd_id']);
                        $model->instruksi = $penyulit->penyulit_hd_nama;
                    }                                                
                }

                echo $form->textArea($model, 'instruksi', array('class' => 'form-control ckeditor'));

//                $this->widget('ext.redactorjs.Redactor',array('model'=>$model,'attribute'=>'instruksi', 'toolbar'=>'mini','height'=>'100px')) 
                ?>

                <?php
                if (isset($_GET['data']['penyulit_hd_id'])) {
                    if ($_GET['data']['penyulit_hd_id'] == 3) {
                        ?>
                        <div class="control-group" style="padding-top: 20px;">
                            <label class="control-label">Alasan Clothing</label>
                            <div class="controls" style="width: 80%">
                                <?php echo CHtml::activeTextField($model, 'alasan_clokting', ['style' => 'width: 100% !important']) ?>
                            </div>
                        </div>
                        <?php
                    }
                }
                ?>

                <?php
                if (isset($_GET['transfusi'])) {
                    if (isset($_GET['sukses'])) {
                        
                    } else {
                        if ($this->init == 'HD') {
                            $id = $_GET['pendaftaran_id'];
                            echo "<br>";
                            echo CHtml::link(Yii::t('mds', '{icon} Stop Tindakan Dialisis', array('{icon}' => '<i class="icon-remove"></i>')), 'javascript:void(0);', array('class' => 'btn btn-danger', 'onclick' => "stopTindakanDialisis($id);return false", 'id' => 'btn-stop-tindakan-dialisis')) . "&nbsp;";
                        }
                    }
//                        if(isset($_GET['sukses'])){ 
//                            $perkembangan_id = isset($_GET['perkembangan_terintegrasi_pasien_id']) ? $_GET['perkembangan_terintegrasi_pasien_id'] : '';
//                            echo CHtml::link(Yii::t('mds', '{icon} Print Form Clothing', array('{icon}'=>'<i class="icon-print"></i>')), 'javascript:void(0);', array('class'=>'btn btn-info','onclick'=>"printFormClothing($perkembangan_id);return false", 'id'=>'btn-print-form-clothing'))."&nbsp;";
//                
//                        }else{
//                            echo CHtml::link(Yii::t('mds', '{icon} Print Form Clothing', array('{icon}'=>'<i class="icon-print"></i>')), 'javascript:void(0);', array('class'=>'btn btn-info', 'disabled'=>true, 'id'=>'btn-print-form-clothing'))."&nbsp;";
//                        }
                }
                ?>
            </div>
        </div>
    </div>
</div>