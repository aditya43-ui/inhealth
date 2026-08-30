<?php
/**
 * view utama untuk menampilkan interface menu tabulasi partograf
 * issue RSST-1589, RSST-2474
 * 
 * @author M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
 * @version     2.0.0
 * @link    <http://172.9.1.15/simpp/docs/>
 * @link    <http://piindonesia.co.id>
 */
?>
<style>
    #aturspan .span2{
        
    }
</style>

<div class="row">

<div id="panel-partograf" hidden>
<?php echo $this->renderPartial($this->path_view.'partograf._formDataPartograf',array('model'=>$modPartograf, 'form'=>$form)); ?>

<?php echo $this->renderPartial($this->path_view.'partograf._monitoringPartograf',array('model'=>$modPartograf)); ?>

<?php echo $this->renderPartial($this->path_view.'partograf._formKontrolPartograf',array('model'=>$modPartografDet,'form'=>$form)); ?>
    
<?php echo $this->renderPartial($this->path_view.'partograf._tabelKontrol',array('getPartoDet'=>$getPartoDet)); ?>

<?php echo $this->renderPartial($this->path_view.'partograf._formLainLain',array('model'=>$modPartografLain,'form'=>$form)); ?>
    
<?php echo $this->renderPartial($this->path_view.'partograf._tabelLainLain',array('getPartoLain' => $getPartoLain)); ?>
    
<?php echo $this->renderPartial($this->path_view.'partograf._jsFunctions',array('modDet'=>$modPartografDet,'modPartograf'=>$modPartograf,'modPartoLain'=>$modPartografLain,'form'=>$form)); ?>
    
<?php echo $this->renderPartial($this->path_view.'partograf._dialog',array()); ?>
</div>
