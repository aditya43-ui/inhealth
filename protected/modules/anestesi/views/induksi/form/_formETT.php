<?php
/** 
 * form peminjam
 * 
 * @author      M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
 * @version     2.0.0
 * @link      <http://piindonesia.co.id>
 * @link      <http://172.9.1.15/simpp/docs/>
 */
?>

<div class="control-group">
    
    <div class="controls">
        <label><b>ETT</b></label>
    </div>
</div>

<div class="control-group">
    <div class="controls">
        <?php echo CHtml::activeCheckBox($model, 'ett_regular', array('class'=>'parent-check','kel-data'=>'ett')) ?>
        <label>Reguler</label>
    </div>   
     <div class="controls">
        <?php echo CHtml::activeCheckBox($model, 'ett_reinforced', array('class'=>'parent-check','kel-data'=>'ett')) ?>
        <label>Reinforced</label>
    </div> 
    <div class="controls">
        <?php echo CHtml::activeCheckBox($model, 'ett_preformed', array('class'=>'parent-check','kel-data'=>'ett')) ?>
        <label>Preformed</label>
    </div> 
    <div class="controls">
        <?php echo CHtml::activeCheckBox($model, 'ett_doublelumen', array('class'=>'parent-check','kel-data'=>'ett')) ?>
        <label>Double Lumen</label>
    </div> 
</div>

<div style="padding-left:20px;">   
    <div class="control-group" style="border:#333 1px solid;width:60%;padding:10px;">    
        <div class="control-group">
            <div class="controls">
                <label>Ukuran</label>
            </div>
            <div class="controls">
                <?php echo CHtml::activeTextField($model, 'ett_ukuran', array('readonly'=>true,'class'=>'span2 numbers-only ett')) ?>
            </div>
        </div>
        <div class="control-group">
            <div class="controls">
                <label>Cuff</label>
            </div>
            <div class="controls">
                &nbsp;&nbsp;&nbsp;&nbsp;
                <?php echo CHtml::activeTextField($model, 'ett_cuff', array('readonly'=>true,'class'=>'span2 numbers-only ett')) ?>
                <label>ml</label>
            </div>
        </div>
        <div class="control-group">
            <div class="controls">
                <?php echo CHtml::activeCheckBox($model, 'ett_oral', array('class'=>' ett', 'disabled'=>true)) ?>
                <label>Oral</label>
            </div>
             <div class="controls">
                <?php echo CHtml::activeCheckBox($model, 'ett_nasal', array('class'=>' ett', 'disabled'=>true)) ?>
                <label>Nasal</label>
            </div>
        </div>
        <div class="control-group">
            <div class="controls">
                <label>Upaya</label>
            </div>
            <div class="controls">
                &nbsp;
                <?php echo CHtml::activeTextField($model, 'ett_upaya', array('readonly'=>true,'class'=>'numbers-only span2  ett')) ?>
            </div>
            <div class="controls">
                <label>X</label>
            </div>
        </div>
    </div>
</div>


<div class="control-group">
    <div class="controls">
        <?php echo CHtml::activeCheckBox($model, 'ett_co2', array()) ?>
        <label>ETT CO<sub>2</sub></label>
    </div>   
    <div class="controls">
        <?php echo CHtml::activeCheckBox($model, 'ett_fixasi', array('class'=>'fixasi')) ?>
        <label>Fixasi</label>
    </div>   
    <div class="controls">
        <?php echo CHtml::activeTextField($model, 'ett_fixasi_keterangan', array('class' => 'numbers-only fixasi-ket','style'=>'width:80px;', 'readonly'=> true)) ?> <label>cm</label>       
    </div>   
     <div class="controls">
        <?php echo CHtml::activeCheckBox($model, 'ett_tampon', array()) ?>
        <label>Tampon</label>
    </div>   
    <div class="controls">
        <?php echo CHtml::activeCheckBox($model, 'ett_ngtogt', array()) ?>
        <label>NGT / OGT</label>
    </div>   
</div>



<!-- start detail -->


<!-- end detail -->
<?php
    echo "<table class='parent' style='margin-bottom:10px;' width='' id='". str_replace(' ','_',strtolower(Params::INDUKSI_DET_LOKASI_INPUT))."'>";
    if (!empty($load[Params::INDUKSI_DET_LOKASI_INPUT]['det'])){
        $i = 0;
        foreach ($load[Params::INDUKSI_DET_LOKASI_INPUT]['det'] as $det){
            $modDet->kelompokinduksi = $det['kelompok'];
            $modDet->ukuran = $det['ukuran'];
            $modDet->keterangan = $det['keterangan'];
            $modDet->praanestesi_induksidet_id = $det['id'];
            $this->renderPartial($this->path_view.'form/_rowDet',array('model'=>$modDet,'i'=>$i,'multiple'=>'yes'));
            $i++;
        }
    }else{
        $modDet = new ATPraanestesiInduksidetT;
        $modDet->kelompokinduksi = Params::INDUKSI_DET_LOKASI_INPUT;
        $this->renderPartial($this->path_view.'form/_rowDet',array('model'=>$modDet,'i'=>0,'multiple'=>'yes'));
    }
    echo "</table>";
    
    echo "<table class='parent'  style='margin-bottom:10px;' width='' id='". str_replace(' ','_',strtolower(Params::INDUKSI_DET_TEMPAT_CVC))."'>";
    if (!empty($load[Params::INDUKSI_DET_TEMPAT_CVC]['det'])){
        $i = 0;
        foreach ($load[Params::INDUKSI_DET_TEMPAT_CVC]['det'] as $det){
            $modDet->kelompokinduksi = $det['kelompok'];
            $modDet->ukuran = $det['ukuran'];
            $modDet->keterangan = $det['keterangan'];
            $modDet->praanestesi_induksidet_id = $det['id'];
            $this->renderPartial($this->path_view.'form/_rowDet',array('model'=>$modDet,'i'=>$i,'multiple'=>'yes'));
            $i++;
        }
    }else{
        $modDet = new ATPraanestesiInduksidetT;
        $modDet->kelompokinduksi = Params::INDUKSI_DET_TEMPAT_CVC;
        $this->renderPartial($this->path_view.'form/_rowDet',array('model'=>$modDet,'i'=>0,'multiple'=>'yes'));
    }
    echo "</table>";
    
    echo "<table class='parent'  style='margin-bottom:10px;' width='' id='". str_replace(' ','_',strtolower(Params::INDUKSI_DET_TEMPAT_ARTERI_LINE))."'>";
    if (!empty($load[Params::INDUKSI_DET_TEMPAT_ARTERI_LINE]['det'])){
        $i = 0;
        foreach ($load[Params::INDUKSI_DET_TEMPAT_ARTERI_LINE]['det'] as  $det){
            $modDet->kelompokinduksi = $det['kelompok'];
            $modDet->ukuran = $det['ukuran'];
            $modDet->keterangan = $det['keterangan'];
            $modDet->praanestesi_induksidet_id = $det['id'];
            $this->renderPartial($this->path_view.'form/_rowDet',array('model'=>$modDet,'i'=>$i,'multiple'=>'no'));
            $i++;
        }
    }else{
        //$modDet = new ATPraanestesiInduksidetT;
        $modDet->kelompokinduksi = Params::INDUKSI_DET_TEMPAT_ARTERI_LINE;
        $this->renderPartial($this->path_view.'form/_rowDet',array('model'=>$modDet,'i'=>0,'multiple'=>'no'));
    }   
    echo "</table>";
?>

<table id="tabel-hapus" class="hide">
    <tbody>
    </tbody>
</table>

<div class="control-group">
    <label class="control-label" style="padding-left:10px;">Tempat Kateter Arteri Pulmonal</label>
    <div class="controls">
        <?php echo CHtml::activeTextField($model, 'lokasikateterarteri', array('class'=>'span3')) ?>
    </div>
</div>


<div class="control-group">
    <div class="controls">
        <label>Posisi</label>
    </div>
    <div class="controls">        
        <?php echo CHtml::activeCheckBox($model, 'posisi_induksi_supine',array()) ?>
        <label>Supine</label>
    </div>    
     <div class="controls">      
         &nbsp;&nbsp;&nbsp;&nbsp;
        <?php echo CHtml::activeCheckBox($model, 'posisi_induksi_prone',array()) ?>
        <label>Prone</label>
    </div>
     <div class="controls">        
         &nbsp;&nbsp;&nbsp;
        <?php echo CHtml::activeCheckBox($model, 'posisi_induksi_tredelenburg',array()) ?>
        <label>Tredelenburg</label>
    </div>     
</div>
<div class="control-group">
    <div class="controls">
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        &nbsp;&nbsp;&nbsp;&nbsp;        
    </div>
    <div class="controls">        
        <?php echo CHtml::activeCheckBox($model, 'posisi_induksi_lithotomy',array()) ?>
        <label>Lithotomy</label>
    </div>    
     <div class="controls">        
        <?php echo CHtml::activeCheckBox($model, 'posisi_induksi_lateral',array()) ?>
        <label>Lateral</label>
    </div>
    <div class="controls">  
        &nbsp;&nbsp;
         <?php echo CHtml::activeCheckBox($model, 'posisi_induksi_lainnya',array('class'=>'adaket')) ?>
        <label>Lainnya</label>
    </div>     
    <div class="controls">        
        <?php echo CHtml::activeTextField($model, 'posisi_induksi_lainnya_keterangan',array('readonly' => true,'class' => 'span2 lainlain')) ?>
    </div>   
</div>