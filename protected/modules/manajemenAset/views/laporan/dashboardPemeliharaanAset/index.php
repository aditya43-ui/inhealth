<?php 
/**
 * digunakan untuk pembuatan interface laporan dashboard aset opname
 * RSST-2633
 * @author          M Iqbal Laksana <iqballaksana@.com>
 * @version         2.0.0
 * @link            http://172.9.1.15/simpp/docs/
 *
 */

Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/Chart.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/chartjs-plugin/annotation/chartjs-plugin-annotation.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/chartjs-plugin/labels/chartjs-plugin-labels.js', CClientScript::POS_END);
?>
<style>
    .persen{
        position: absolute;
        right:0;
        margin-right:60px; 
        color:#333;
        font-weight: bold;
    }
    
    .col-md-2{
        width:19.96666667% !important;
    }
</style>

<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title"><i class="glyphicon glyphicon-file"></i> Pemeliharaan Aset</div>
    </div>
    <div class="panel-body">                
                
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title"><i class="entypo-credit-card"></i> Dashboard Pemeliharaan Aset</div>
            </div>
            <div class="panel-body">                
                <?= $this->renderPartial($this->path_view.'dashboardPemeliharaanAset/_tile',array('tile'=>$load['tile']), true); ?>
                 <div class="clear"></div>
                
                <div class="col-sm-6" style="padding-left:3px;padding-right:3px; ">
                    <div class="panel panel-success">
                        <div class="panel-heading">
                            <div class="panel-title"><i class="fas fa-chart-bar"></i> Peralatan Berdasarkan Kondisi</div>
                        </div>
                        <div class="panel-body up">
                            <?php echo $this->renderPartial($this->path_view.'dashboardPemeliharaanAset/grafik/_pie_berdasarkan_kondisi',array()); ?>
                        </div>
                    </div>
                </div>
                
                <div class="col-sm-6" style="padding-right:3px;padding-left:3px;">
                    <div class="panel panel-success">
                            <div class="panel-heading">
                                <div class="panel-title"><i class="fas fa-chart-bar"></i> Peralatan berdasarkan Level Resiko</div>
                            </div>
                            <div class="panel-body up">
                                <?php echo $this->renderPartial($this->path_view.'dashboardPemeliharaanAset/grafik/_pie_berdasarkan_level_resiko',array()); ?>
                            </div>
                        </div>
                </div>
                <div class="clear"></div>                
                <hr/>
                <div class="col-sm-12" style="padding-right:3px;padding-left:3px;">
                    <div class="panel panel-success">
                            <div class="panel-heading">
                                <div class="panel-title"><i class="fas fa-chart-bar"></i> Pemeliharaan Alat</div>
                            </div>
                            <div class="panel-body up">
                                <?php echo $this->renderPartial($this->path_view.'dashboardPemeliharaanAset/grafik/_garis_corrective_preventive',array()); ?>
                            </div>
                        </div>
                </div>
                
                <div class="clear"></div>                               
                <hr/>
                <div class="col-sm-4" style="padding-left:3px;padding-right:3px; ">
                    <div class="panel panel-success">
                        <div class="panel-heading">
                            <div class="panel-title"><i class="entypo-credit-card"></i> Preventive Maintance Bulan Ini</div>
                        </div>
                        <div class="panel-body up">
                            <?php echo $this->renderPartial($this->path_view.'dashboardPemeliharaanAset/tabel/_preventive',array('model'=>$modPrev)); ?>
                        </div>
                    </div>
                </div>                
                <div class="col-sm-4" style="padding-left:3px;padding-right:3px; ">
                    <div class="panel panel-success">
                        <div class="panel-heading">
                            <div class="panel-title"><i class="entypo-credit-card"></i> Status Corrective Maintenance </div>
                        </div>
                        <div class="panel-body up">
                            <?php echo $this->renderPartial($this->path_view.'dashboardPemeliharaanAset/tabel/_corrective',array('model'=>$modCorr)); ?>
                        </div>
                    </div>
                </div> 
                <div class="col-sm-4" style="padding-left:3px;padding-right:3px; ">
                    <div class="panel panel-success">
                        <div class="panel-heading">
                            <div class="panel-title"><i class="entypo-credit-card"></i> Status Work Order </div>
                        </div>
                        <div class="panel-body up">
                            <?php echo $this->renderPartial($this->path_view.'dashboardPemeliharaanAset/tabel/_workorder',array('model'=>$modWo)); ?>
                        </div>
                    </div>
                </div> 
                <div class="clear"></div>
                <?php echo $this->renderPartial($this->path_view.'dashboardPemeliharaanAset/_jsFunctions',array('load'=>$load)) ?>
            </div>
        </div>
    </div>
</div>