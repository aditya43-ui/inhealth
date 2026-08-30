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
        <div class="panel-title"><i class="glyphicon glyphicon-file"></i> Aset Opname</div>
    </div>
    <div class="panel-body">
        
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title"><i class="entypo-search"></i> Periode</div>
            </div>
            <div class="panel-body">
                <?php echo $this->renderPartial($this->path_view.'dashboardAsetOpname/_search',array('model'=>$model)); ?>
            </div>
        </div>
                
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title"><i class="entypo-credit-card"></i> Laporan Aset Opname</div>
            </div>
            <div class="panel-body">                
                <?= $this->renderPartial($this->path_view.'dashboardAsetOpname/_tile',array(), true); ?>
                <div class="clear"></div>
                <hr/>
                
                <div class="col-sm-6" style="padding-left:3px;padding-right:3px; ">
                    <div class="panel panel-success">
                            <div class="panel-heading">
                                <div class="panel-title"><i class="entypo-credit-card"></i> 10 Lokasi dengan nilai aset terbesar</div>
                            </div>
                            <div class="panel-body up">
                                <?php echo $this->renderPartial($this->path_view.'dashboardAsetOpname/grafik/_bar_10_aset_terbesar',array('model'=>$model)); ?>
                            </div>
                        </div>
                </div>
                
                 <div class="col-sm-6" style="padding-right:3px;padding-left:3px;">
                    <div class="panel panel-success">
                            <div class="panel-heading">
                                <div class="panel-title"><i class="entypo-credit-card"></i> 10 Lokasi dengan jumlah aset terbanyak</div>
                            </div>
                            <div class="panel-body up">
                                <?php echo $this->renderPartial($this->path_view.'dashboardAsetOpname/grafik/_bar_10_aset_terbanyak',array('model'=>$model)); ?>
                            </div>
                        </div>
                </div>
                <div class="clear"></div>
                <hr/>
                <div class="col-sm-7" style="padding-left:3px;padding-right:3px; ">
                    <div class="panel panel-success">
                        <div class="panel-heading">
                            <div class="panel-title"><i class="fas fa-chart-bar"></i> Hasil Aset Opname berdasarkan Keadaan Aset</div>
                        </div>
                        <div class="panel-body up">
                            <?php echo $this->renderPartial($this->path_view.'dashboardAsetOpname/grafik/_pie_hasil_aset_opname',array('model'=>$model)); ?>
                        </div>
                    </div>
                </div>
                <div class="col-sm-5" style="padding-left:3px;padding-right:3px; ">
                    <div class="panel panel-success">
                        <div class="panel-heading">
                            <div class="panel-title"><i class="entypo-credit-card"></i> 10 Inventarisasi Peralatan Baru</div>
                        </div>
                        <div class="panel-body up">
                            <?php echo $this->renderPartial($this->path_view.'dashboardAsetOpname/_tabel',array('model'=>$modInv)); ?>
                        </div>
                    </div>
                </div>                
                <div class="clear"></div>
                <hr/>
                <?php echo $this->renderPartial($this->path_view.'dashboardAsetOpname/_jsFunctions',array('model'=>$model)) ?>
            </div>
        </div>
    </div>
</div>