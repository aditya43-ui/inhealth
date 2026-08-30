
<style>
    @page {

        margin: 0cm 0cm 0cm 0cm;
    }
    @media print {
        html, body {
            padding: 1cm 1cm 1cm 1cm;
            font-family: Arial !important;
            font-size: 12pt !important;
            width: 210mm;
            height: 330mm;
            color-adjust: exact;

        }
        div.footer {
            position: fixed;
            bottom: 0;
            float:left;
        }
        .headrtd{
            background-color:#afdc7e !important;


        }
         .border th, .border td{
        border:1px solid #000;
    }
      
    }
    table.footer {
        position: fixed;
        bottom: 0;

    }
    #spesimentable{
        border: 2px solid black;
        
    }
    
    #antibiotictable{
        border: 2px solid black;
    }
    #identificationtable{
        border: 2px solid black;
    }
    #keterangan{
        border: 2px solid black;
    }
    #id_ast1{
        border: 2px solid black;
    }
    #id_ast2{
        border: 2px solid black;
    }

</style>

<style>
    div{
        font-size: 12pt !important;
        font-family: Arial !important;
    }
    .form-horizontal .control-label{
        font-size: 12pt !important;
        font-family: Arial !important;
    }
/*    mengatur spasi dalam td*/
    table td{
        padding:1px !important;
        vertical-align:top;
        font-size: 12pt !important;
        font-family: Arial !important;
        color:black !important;
    }
    control-group
    .border th, .border td{
        border:1px solid #000;
    }
    .table thead:first-child{
        border-top:1px solid #000;        
    }

    .border {
        box-shadow:none;
        border-spacing:0px;
        padding:0px;
    }
/*    menghilangkan effect margin bottom pada control group*/
    .control-group{
        margin-bottom:0px !important;
        
    }
    .controls{
         margin-top:2px !important;

         
    }
    .alig{
        text-align:left !important;
    }
    .control-label{
        color:black !important;
       
    }
    body{
        -webkit-print-color-adjust: exact;
    }
    div{
        color:black !important;
       
    }
    /*    jika kondisi print wajib*/
    #breakfloat{
       
        overflow: hidden;
        word-wrap: break-word;

        
    }
/*    jika kondisi print wajib*/
    .form-horizontal .controls {
        float:none;
        
    }
    .form-horizontal .control-label {
        padding-right:10px;
    }
    @media all {
        .page-break { display: none; }
    }

    @media print {
        .page-break { display: block; page-break-before: always; }
    }
</style>

<?php
$this->widget('bootstrap.widgets.BootAlert'); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js'); ?>
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
    'id'=>'baserahterima-t-form',
    'enableAjaxValidation'=>false,
    'type'=>'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)', 'onsubmit' => 'return requiredCheck(this);'),
    'focus'=>'#',
)); ?>
<?php $modProfilRs = ProfilrumahsakitM::model()->findByPk(Params::DEFAULT_PROFIL_RUMAH_SAKIT); ?>
    <table width="100%" border="0px" >
            <tr>
                <td width="20%" align="center" >
                    <img src="<?php echo Params::pathImageErrorAdmin()."Jawa_Timur.png"?> " id="headerset" style="max-width: 80px; width:80px;"/>
                </td>
                <td align="center" style="vertical-align:top">
                    <div style="font-size:13pt !important">
                        <?php
                        echo strtoupper($modProfilRs->namakepemilikanrs) . ' ';
                        echo strtoupper($modProfilRs->propinsi->propinsi_nama);
                        ?>
                    </div>
                    <div style="font-size:13pt !important">
                        GEDUNG DIAGNOSTIC CENTER <?php echo strtoupper($modProfilRs->nama_rumahsakit); ?>
                    </div>
                    <div style="font-size:13pt !important">
                        <?php echo $modProfilRs->alamatlokasi_rumahsakit; ?> 
                    </div>
                    <div style="font-size:13pt !important">
                        Telp. (031) 5501525 ext. 1975
                    </div>
                    <div style="font-size:13pt !important">
                        <u>S U R A B A Y A</u>
                    </div>
                </td>
                <td width="20%" align="center">
                    <img src="<?php echo Params::urlProfilRSDirectory().$modProfilRs->logo_rumahsakit ?> " id="headerset2" style="max-width: 80px; width:80px;"/>
                </td>
            </tr>
            <tr>
                <td colspan="3">
                     <hr style="border:1px solid">
                </td> 
            </tr>
            
        </table>
<div style="padding-top: 5px; text-align:center; font-weight:bold">
   HASIL PEMERIKSAAN LABORATORIUM MIKROBIOLOGI KLINIK<br>

</div>
<br>
<div style="font-weight:bold">DATA SPESIMEN</div>
<table width="100%" id="spesimentable">
    <tr>
        <td width="50%">
            <table width="100%">
                <tr>
                    <td width="30%">Spesimen ID</td>
                    <td width="5%">:</td>
                    <td  align="left"><?php 
                    
                            if (!empty($modSpesimen->no_spesimen)) {
                                echo $modSpesimen->no_spesimen;
                            }
                    ?></td>
                </tr>
            </table>
        </td>
        <td width="50%">
            <table width="100%">
                <tr>
                    <td width="40%">Tgl. Pengambilan Spesimen</td>
                    <td width="5%">:</td>
                    <td align="left"><?php 
                    
                           if (!empty($modSpesimen->waktu_pengambilan_spesimen)) {
                                echo $modSpesimen->waktu_pengambilan_spesimen;
                            }
                    ?></td>
                </tr>
            </table>
         

            </div>  
        </td>
    </tr>
    <tr>
        <td>
            <table width="100%">
                <tr>
                    <td width="30%">No Rekam Medik</td>
                    <td width="5%">:</td>
                    <td align="left"><?php 
                    
                           if (!empty($modSpesimen->no_rekam_medik)) {
                                echo $modSpesimen->no_rekam_medik;
                            }
                    ?></td>
                </tr>
            </table>
            
        </td>
        <td>
            <table width="100%">
                <tr>
                    <td width="40%">Jenis Spesimen</td>
                    <td width="5%">:</td>
                    <td ><?php 
                    
                           if (!empty($modSpesimen->jenis_spesimen)) {
                                echo $modSpesimen->jenis_spesimen;
                            }
                    ?></td>
                </tr>
            </table>
            
        </td>
    </tr>
    <tr>
        <td>
            <table width="100%">
                <tr>
                    <td width="30%">Nama Pasien</td>
                    <td width="5%">:</td>
                    <td align="left"><?php 
                    
                           if (!empty($modSpesimen->nama_pasien)) {
                                echo $modSpesimen->nama_pasien;
                            }
                    ?></td>
                </tr>
            </table>
            
        </td>
        <td>
            <table width="100%">
                <tr>
                    <td width="40%">Jenis Pemeriksaan</td>
                    <td width="5%">:</td>
                    <td width=""><?php 
                    
                           if (!empty($modSpesimen->jenis_pemeriksaan)) {
                                echo $modSpesimen->jenis_pemeriksaan;
                            }
                    ?></td>
                </tr>
            </table>
            
        </td>
    </tr>
    <tr>
        <td>
            <table width="100%">
                <tr>
                    <td width="30%">Ruangan Asal</td>
                    <td width="5%">:</td>
                    <td align="left"><?php 
                    
                           if (!empty($modSpesimen->ruangan_asal)) {
                                echo $modSpesimen->ruangan_asal;
                            }
                    ?></td>
                </tr>
            </table>
            
        </td>
        <td>
            <table width="100%">
                <tr>
                    <td width="40%">Status Spesimen</td>
                    <td width="5%">:</td>
                    <td width=""><?php 
                    
                           if (!empty($modSpesimen->status)) {
                                echo $modSpesimen->status;
                            }
                    ?></td>
                </tr>
            </table>
            
        </td>
    </tr>
</table>
<br>

<div style="font-weight:bold">DATA ID/AST</div>
<table width="100%" id="id_ast1">
    <tr>
        <td width="100%"> 
            <div style="font-weight:bold; margin-top:15px; margin-left: 13px;">
                IDENTIFICATION  
            </div>
            <table id="identificationtable" width="97%" style="margin:0px 0px 0px 13px">
                <tr>
                    <td width="30%">Species Name</td>
                    <td>
                        <?php
                        if (!empty($model->species_name)) {
                            echo ' : '.$model->species_name;
                        } else {
                            echo " : ....................................................";
                        }
                        ?>
                    </td>
                </tr>
                <tr>
                    <td>Test Name</td>
                    <td>
                        <?php
                        if (!empty($model->test_name)) {
                            echo ' : '.$model->test_name;
                        } else {
                            echo " : ....................................................";
                        }
                        ?>
                    </td>
                </tr>
                <tr>
                    <td>Panel/Card Name</td>
                    <td>
                        <?php
                        if (!empty($model->panel_nama)) {
                            echo ' : '.$model->panel_nama;
                        } else {
                            echo " : ....................................................";
                        }
                        ?>
                    </td>
                </tr>
            </table>
            <br>

            <div style="font-weight:bold; margin-left: 13px;">
                ANTIBIOTIC SUSCEPTIBILITY TEST  
            </div>
            <?php
            $criteria = new CDbCriteria;
            $modAst = AstM::model()->findAll($criteria);
            $i = 0;
            if (!empty($model->idast_id)) {
                ?>
                <table id="spesimentable" width="97%" cellpadding="10" style="margin:0px 0px 0px 13px">
                    <tr>
                        <?php
                        foreach ($modAst as $daftarast) {
                            if ($i == 0) {
                                echo "<tr>";
                            }
                            ?>

                            <?php
                            foreach ($modDetail as $optDetail) {
                                if($optDetail->is_ceklis == true){
                                    if ($daftarast->ast_id == $optDetail->ast_id) {
                                        ?>
                                        <td><?php echo $daftarast->ast_nama; ?></td>
                                        <td>
                                            <?php
                                            if (!empty($optDetail->hasil)) {
                                                echo ' : '.$optDetail->hasil;
                                            }
                                            ?>
                                        </td>
                                        <?php
                                        $i++;
                                    }
                                    if ($i == 2) {
                                        echo "</tr>";
                                        $i = 0;
                                    }
                                }
                            }
                            ?>

                            <?php
                        }
                        ?>
                    </tr>
                </table>
                <br>
                <div style="font-weight:bold; padding-top:15px; margin-left: 13px;">
                    KETERANGAN 
                </div>
                <table id="spesimentable" width="97%" cellpadding="10" style="margin:0px 0px 15px 13px">
                    <tr>
                        <td>
                            <?php
                            if (!empty($model->keterangan)) {
                                echo $model->keterangan;
                            } else {
                                echo "  ....................................................";
                            }
                            ?>
                        </td>
                    </tr>
                </table>
                <?php
            } else {
                ?>
                <div id="spesimentable" width="97%" cellpadding="10" style="margin:0px 0px 15px 13px">
                    &nbsp;  
                </div>
            <?php } ?>
        </td>
    </tr>
</table>
<div class="page-break"></div>
<?php if(!empty($model2->idast_id)) : ?>
<br>
<div style="font-weight:bold">DATA ID/AST</div>
<table width="100%" id="id_ast2">
    <tr>
        <td width="100%"> 
            <div style="font-weight:bold; margin-top:15px; margin-left: 13px;">
                IDENTIFICATION  
            </div>
            <table id="identificationtable" width="97%" style="margin:0px 0px 0px 13px">
                <tr>
                    <td width="30%">Species Name</td>
                    <td>
                        <?php
                        if (!empty($model2->species_name)) {
                            echo ' : '.$model2->species_name;
                        } else {
                            echo " : ....................................................";
                        }
                        ?>
                    </td>
                </tr>
                <tr>
                    <td>Test Name</td>
                    <td>
                        <?php
                        if (!empty($model2->test_name)) {
                            echo ' : '.$model2->test_name;
                        } else {
                            echo " : ....................................................";
                        }
                        ?>
                    </td>
                </tr>
                <tr>
                    <td>Panel/Card Name</td>
                    <td>
                        <?php
                        if (!empty($model2->panel_nama)) {
                            echo ' : '.$model2->panel_nama;
                        } else {
                            echo " : ....................................................";
                        }
                        ?>
                    </td>
                </tr>
            </table>
            <br>

            <div style="font-weight:bold; margin-left: 13px;">
                ANTIBIOTIC SUSCEPTIBILITY TEST  
            </div>
            <?php
            $criteria = new CDbCriteria;
            $modAst = AstM::model()->findAll($criteria);
            $i = 0;
            if (!empty($model2->idast_id)) {
                ?>
                <table id="spesimentable" width="97%" cellpadding="10" style="margin:0px 0px 0px 13px">
                    
                        <?php
                        foreach ($modAst as $daftarast) {
                            if ($i == 0) {
                                echo "<tr>";
                            }
                            ?>

                            <?php
                            foreach ($modelDetail2 as $optDetail) {
                                if($optDetail->is_ceklis == true){
                                    if ($daftarast->ast_id == $optDetail->ast_id) {
                                        ?>
                                        
                                        <td><?php echo $daftarast->ast_nama; ?></td>
                                        <td>
                                            <?php
                                            if (!empty($optDetail->hasil)) {
                                                echo ' : '.$optDetail->hasil;
                                            }
                                            ?>
                                        </td>
                                        <?php
                                        $i++;
                                    }
                                    if ($i == 2) {
                                        echo "</tr>";
                                        $i = 0;
                                    }
                                }
                            }
                            ?>

                            <?php
                        }
                        ?>
                </table>
                <br>
                <div style="font-weight:bold; padding-top:15px; margin-left: 13px;">
                    KETERANGAN 
                </div>
                <table id="spesimentable" width="97%" cellpadding="10" style="margin:0px 0px 15px 13px">
                    <tr>
                        <td>
                            <?php
                            if (!empty($model2->keterangan)) {
                                echo $model2->keterangan;
                            } else {
                                echo "  ....................................................";
                            }
                            ?>
                        </td>
                    </tr>
                </table>
                <?php
            } else {
                ?>
                <div id="spesimentable" width="97%" cellpadding="10" style="margin:0px 0px 15px 13px">
                    &nbsp;  
                </div>
            <?php } ?>
        </td>
    </tr>
</table>
<br>
<?php endif; ?>
<div style="font-weight:bold">
  PERSON IN CHARGE
</div>
<table id="identificationtable" width="100%">
    <tr>
        <td width="50%">
            <table width="100%">
                <tr>
                    <td width="30%">DPJTM</td>
                    <td width="5%">:</td>
                    <td align="left"><?php 

                           if (!empty($model->verifikator_nama)) {
                                echo $model->verifikator_nama;
                            }
                    ?></td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td width="50%">
            <table width="100%">
                <tr>
                    <td width="30%">NIM/NIP</td>
                    <td width="5%">:</td>
                    <td align="left"><?php 

                           if (!empty($model->verifikator_nim)) {
                                echo $model->verifikator_nim;
                            }
                    ?></td>
                </tr>
            </table>
        </td>
    </tr>
    
</table>
<?php $this->endWidget(); ?>
<?php
if (!isset($_GET['print'])){
    echo CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="icon-print icon-white"></i>')), array('class' => 'btn btn-primary', 'type' => 'button', 'onclick' => 'print()')) . "&nbsp&nbsp";
    echo CHtml::htmlButton(Yii::t('mds', '{icon} PDF', array('{icon}' => '<i class="icon-book icon-white"></i>')), array('class' => 'btn btn-primary', 'type' => 'button', 'onclick' => 'printpdf()')) . "&nbsp&nbsp";
    
    
?>
<br>
<?php   ?>
    <script type='text/javascript'>
    /**
     * print
     */    
    function print(){
        window.open("<?php echo Yii::app()->createUrl("mikrobiologiKlinik/InformasiDaftarSpesimen/Detail", array("id"=>$modSpesimen->spesimen_id,'print'=>"print")) ?>","",'location=_new, width=1024px');
    }
    function printpdf(){
        window.open("<?php echo Yii::app()->createUrl("mikrobiologiKlinik/InformasiDaftarSpesimen/Detail", array("id"=>$modSpesimen->spesimen_id,'print'=>"pdf")) ?>","",'location=_new, width=1024px');
    }
    function printexcel(){
        window.open("<?php echo Yii::app()->createUrl("mikrobiologiKlinik/InformasiDaftarSpesimen/Detail", array("id"=>$modSpesimen->spesimen_id,'print'=>"excel")) ?>","",'location=_new, width=1024px');
    }
    </script>
<?php
}else{
?>  
 <script>

</script>   
<?php
}
?>
    
