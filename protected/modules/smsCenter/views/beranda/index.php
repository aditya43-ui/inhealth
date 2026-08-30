<?php 
/**
 * digunakan untuk pembuatan interface beranda penelitian kesehatan
 * RSST-2633
 * @author          Yusuf Putra Anugrah <yusufputra@.com>
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
</style>

<?php echo $this->renderPartial($this->path_view.'_search',array('model'=>$model)); ?>
<div class="clear"></div>
<?php echo $this->renderPartial($this->path_view.'_tile',array()); ?>
<div class="clear"></div>
<div class="row">
<div class="col-md-9">
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title"><b>Latest</b> (Traffic)</div>
    </div>
    <div class="panel-body">
        <?php echo $this->renderPartial($this->path_view.'_table',array()) ?>            
    </div>
</div>
    </div>
<div class="col-md-3">
<?php echo $this->renderPartial($this->path_view.'_tile1',array()); ?>
    </div>

</div>
<p>&nbsp;</p>



