
<style>
    @page {

        margin: 0cm 0cm 0cm 0cm;
    }
    @media print {
        html, body {
            padding: 1cm 1cm 1cm 1cm;
            font-family: Arial !important;
            font-size: 11pt !important;
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
        padding-top: 10px;

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
        font-size: 11pt !important;
        font-family: Arial !important;
    }
    .form-horizontal .control-label{
        font-size: 11pt !important;
        font-family: Arial !important;
    }
    /*    mengatur spasi dalam td*/
    table td{
        padding:1px !important;
        vertical-align:top;
        font-size: 11pt !important;
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
        padding:1% !important;

    }
    .alig{
        text-align:left !important;
        padding:1% !important;

    }
    .control-label{
        color:black !important;
        padding-top:1% !important;
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
</style>

<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>
<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'baserahterima-t-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)', 'onsubmit' => 'return requiredCheck(this);'),
    'focus' => '#',
        ));
?>
<?php $modProfilRs = ProfilrumahsakitM::model()->findByPk(Params::DEFAULT_PROFIL_RUMAH_SAKIT); ?>
<table width="100%" border="0px" >
    <tr>
        <td width="20%" align="center" >
            <img src="<?php echo Params::pathImageErrorAdmin() . "Jawa_Timur.png" ?> " id="headerset" style="max-width: 80px; width:80px;"/>
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
                Telp. <?php echo $modProfilRs->no_telp_profilrs?>
            </div>
        </td>
        <td width="20%" align="center">
            <img src="<?php echo Params::urlProfilRSDirectory() . $modProfilRs->logo_rumahsakit ?> " id="headerset2" style="max-width: 80px; width:80px;"/>
        </td>
    </tr>
    <tr>
        <td colspan="3">
            <hr style="border:1px solid">
        </td> 
    </tr>

</table>
<div style="padding-top: 5px; text-align:center;font-size:12pt !important; ;font-weight:bold">
    HASIL PEMERIKSAAN LABORATORIUM MIKROBIOLOGI KLINIK<br>

</div>
<br>
<div style="font-weight:bold">DATA SPESIMEN</div>
<table width="100%" id="spesimentable" >
    <tr>
        <td width="50%"> 
            <div class="control-group">
                <?php echo CHtml::label('Spesimen ID', '', array('class' => 'control-label alig', 'style' => ' width: 150px;')); ?>
                <?php echo CHtml::label('<span>:</span>', '', array('class' => 'control-label ', 'style' => 'width: 5px;')); ?>
                <div class="controls">
                    <?php
                    if (!empty($modSpesimen->no_spesimen)) {
                        echo "<div id='breakfloat'>" . $modSpesimen->no_spesimen . "</div>";
                    }
                    ?>

                </div>

            </div>
        </td>
        <td width="50%">
            <div class="control-group">
                <?php echo CHtml::label('Tgl. Pengambilan Spesimen', '', array('class' => 'control-label alig', 'style' => 'width: 150px;')); ?>
                <?php echo CHtml::label('<span>:</span>', '', array('class' => 'control-label ', 'style' => 'width: 5px;')); ?>
                <div class="controls">
                    <?php
                    if (!empty($modSpesimen->waktu_pengambilan_spesimen)) {
                        echo "<div id='breakfloat'>" . $modSpesimen->waktu_pengambilan_spesimen . "</div>";
                    }
                    ?>

                </div>

            </div>  
        </td>
    </tr>
    <tr>
        <td>
            <div class="control-group">
                <?php echo CHtml::label('No Rekam Medik', '', array('class' => 'control-label alig', 'style' => 'width: 150px;')); ?>
                <?php echo CHtml::label('<span>:</span>', '', array('class' => 'control-label ', 'style' => 'width: 5px;')); ?>
                <div class="controls">
                    <?php
                    if (!empty($modSpesimen->no_rekam_medik)) {
                        echo "<div id='breakfloat'>" . $modSpesimen->no_rekam_medik . "</div>";
                    }
                    ?>

                </div>

            </div> 
        </td>
        <td>
            <div class="control-group">
                <?php echo CHtml::label('Jenis Spesimen', '', array('class' => 'control-label alig', 'style' => 'width: 150px;')); ?>
                <?php echo CHtml::label('<span>:</span>', '', array('class' => 'control-label ', 'style' => 'width: 5px;')); ?>
                <div class="controls">
                    <?php
                    if (!empty($modSpesimen->jenis_spesimen)) {
                        echo "<div id='breakfloat'>" . $modSpesimen->jenis_spesimen . "</div>";
                    }
                    ?>

                </div>

            </div> 
        </td>
    </tr>
    <tr>
        <td>
            <div class="control-group">
                <?php echo CHtml::label('Nama Pasien', '', array('class' => 'control-label alig', 'style' => 'width: 150px;')); ?>
                <?php echo CHtml::label('<span>:</span>', '', array('class' => 'control-label ', 'style' => 'width: 5px;')); ?>
                <div class="controls">
                    <?php
                    if (!empty($modSpesimen->nama_pasien)) {
                        echo "<div id='breakfloat'>" . $modSpesimen->nama_pasien . "</div>";
                    }
                    ?>

                </div>

            </div> 
        </td>
        <td>
            <div class="control-group">
                <?php echo CHtml::label('Jenis Pemeriksaan', '', array('class' => 'control-label alig', 'style' => 'width: 150px;')); ?>
                <?php echo CHtml::label('<span>:</span>', '', array('class' => 'control-label ', 'style' => 'width: 5px;')); ?>
                <div class="controls">
                    <?php
                    if (!empty($modSpesimen->jenis_pemeriksaan)) {
                        echo "<div id='breakfloat'>" . $modSpesimen->jenis_pemeriksaan . "</div>";
                    }
                    ?>

                </div>

            </div> 
        </td>
    </tr>
    <tr>
        <td>
            <div class="control-group">
                <?php echo CHtml::label('Ruangan Asal', '', array('class' => 'control-label alig', 'style' => 'width: 150px;')); ?>
                <?php echo CHtml::label('<span>:</span>', '', array('class' => 'control-label ', 'style' => 'width: 5px;')); ?>
                <div class="controls">
                    <?php
                    if (!empty($modSpesimen->ruangan_asal)) {
                        echo "<div id='breakfloat'>" . $modSpesimen->ruangan_asal . "</div>";
                    }
                    ?>

                </div>

            </div> 
        </td>
        <td>
            <div class="control-group">
                <?php echo CHtml::label('Status Spesimen', '', array('class' => 'control-label alig', 'style' => 'width: 150px;')); ?>
                <?php echo CHtml::label('<span>:</span>', '', array('class' => 'control-label ', 'style' => 'width: 5px;')); ?>
                <div class="controls">
                    <?php
                    if (!empty($modSpesimen->status)) {

                        echo "<div id='breakfloat'>" . $modSpesimen->status . "</div>";
                    }
                    ?>

                </div>

            </div> 
        </td>
    </tr>
</table>
<br>
<div style="font-weight:bold">DATA ID/AST</div>
<table width="100%" id="id_ast1">
    <tr>
        <td width="100%"> 
            <div style="font-weight:bold; padding-top:15px; padding-left: 13px;">
                IDENTIFICATION  
            </div>
            <table id="identificationtable" width="97%" style="margin:0px 0px 0px 13px">
                <tr>
                    <td>
                        <div class="control-group">
                            <?php echo CHtml::label('Species Name', '', array('class' => 'control-label alig', 'style' => 'width: 150px;')); ?>
                            <?php echo CHtml::label('<span>:</span>', '', array('class' => 'control-label ', 'style' => 'width: 5px;')); ?>
                            <div class="controls">
                                <?php
                                if (!empty($model->species_name)) {
                                    echo $model->species_name;
                                } else {
                                    echo " ....................................................";
                                }
                                ?>

                            </div>

                        </div>  
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="control-group">
                            <?php echo CHtml::label('Test Name', '', array('class' => 'control-label alig', 'style' => 'width: 150px;')); ?>
                            <?php echo CHtml::label('<span>:</span>', '', array('class' => 'control-label ', 'style' => 'width: 5px;')); ?>
                            <div class="controls">
                                <?php
                                if (!empty($model->test_name)) {
                                    echo $model->test_name;
                                } else {
                                    echo "  ....................................................";
                                }
                                ?>

                            </div>

                        </div>  
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="control-group">
                            <?php echo CHtml::label('Panel/Card Name', '', array('class' => 'control-label alig', 'style' => 'width: 150px;')); ?>
                            <?php echo CHtml::label('<span>:</span>', '', array('class' => 'control-label ', 'style' => 'width: 5px;')); ?>
                            <div class="controls">
                                <?php
                                if (!empty($model->panel_nama)) {
                                    echo $model->panel_nama;
                                } else {
                                    echo "  ....................................................";
                                }
                                ?>

                            </div>

                        </div>  
                    </td>
                </tr>
            </table>
            <br>

            <div style="font-weight:bold; padding-left: 13px;">
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
                                        <td> 
                                            <div class="control-group">
                                                <?php echo CHtml::label($daftarast->ast_nama, '', array('class' => 'control-label alig', 'style' => 'width: 150px;')); ?>
                                                <?php echo CHtml::label('<span>:</span>', '', array('class' => 'control-label ', 'style' => 'width: 10px;')); ?>
                                                <div class="controls">
                                                    <?php echo $optDetail->hasil; ?>
                                                </div>
                                            </div>
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
                <div style="font-weight:bold; padding-top:15px; padding-left: 13px;">
                    KETERANGAN 
                </div>
                <table id="spesimentable" width="97%" cellpadding="10" style="margin:0px 0px 15px 13px">
                    <tr>
                        <td>
                            <div class="control-group" style="margin-left: 5px;">
                                <?php
                                if (!empty($model->keterangan)) {
                                    echo $model->keterangan;
                                } else {
                                    echo "  ....................................................";
                                }
                                ?>

                            </div>  
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
<?php if(!empty($model2->idast_id)) : ?>
<br>
<div style="font-weight:bold">DATA ID/AST</div>
<table width="100%" id="id_ast2">
    <tr>
        <td width="100%"> 
            <div style="font-weight:bold; padding-top:15px; padding-left: 13px;">
                IDENTIFICATION  
            </div>
            <table id="identificationtable" width="97%" style="margin:0px 0px 0px 13px">
                <tr>
                    <td>
                        <div class="control-group">
                            <?php echo CHtml::label('Species Name', '', array('class' => 'control-label alig', 'style' => 'width: 150px;')); ?>
                            <?php echo CHtml::label('<span>:</span>', '', array('class' => 'control-label ', 'style' => 'width: 5px;')); ?>
                            <div class="controls">
                                <?php
                                if (!empty($model2->species_name)) {
                                    echo $model2->species_name;
                                } else {
                                    echo " ....................................................";
                                }
                                ?>

                            </div>

                        </div>  
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="control-group">
                            <?php echo CHtml::label('Test Name', '', array('class' => 'control-label alig', 'style' => 'width: 150px;')); ?>
                            <?php echo CHtml::label('<span>:</span>', '', array('class' => 'control-label ', 'style' => 'width: 5px;')); ?>
                            <div class="controls">
                                <?php
                                if (!empty($model2->test_name)) {
                                    echo $model2->test_name;
                                } else {
                                    echo "  ....................................................";
                                }
                                ?>

                            </div>

                        </div>  
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="control-group">
                            <?php echo CHtml::label('Panel/Card Name', '', array('class' => 'control-label alig', 'style' => 'width: 150px;')); ?>
                            <?php echo CHtml::label('<span>:</span>', '', array('class' => 'control-label ', 'style' => 'width: 5px;')); ?>
                            <div class="controls">
                                <?php
                                if (!empty($model2->panel_nama)) {
                                    echo $model2->panel_nama;
                                } else {
                                    echo "  ....................................................";
                                }
                                ?>

                            </div>

                        </div>  
                    </td>
                </tr>
            </table>
            <br>

            <div style="font-weight:bold; padding-left: 13px;">
                ANTIBIOTIC SUSCEPTIBILITY TEST  
            </div>
            <?php
            $criteria = new CDbCriteria;
            $modAst = AstM::model()->findAll($criteria);
            $i = 0;
            if (!empty($model2->idast_id)) {
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
                            foreach ($modelDetail2 as $optDetail) {
                                if($optDetail->is_ceklis == true){
                                    if ($daftarast->ast_id == $optDetail->ast_id) {
                                        ?>
                                        <td> 
                                            <div class="control-group">
                                                <?php echo CHtml::label($daftarast->ast_nama, '', array('class' => 'control-label alig', 'style' => 'width: 150px;')); ?>
                                                <?php echo CHtml::label('<span>:</span>', '', array('class' => 'control-label ', 'style' => 'width: 10px;')); ?>
                                                <div class="controls">
                                                    <?php echo $optDetail->hasil; ?>
                                                </div>
                                            </div>
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
                <div style="font-weight:bold; padding-top:15px; padding-left: 13px;">
                    KETERANGAN 
                </div>
                <table id="spesimentable" width="97%" cellpadding="10" style="margin:0px 0px 15px 13px">
                    <tr>
                        <td>
                            <div class="control-group" style="margin-left: 5px;">
                                <?php
                                if (!empty($model2->keterangan)) {
                                    echo $model2->keterangan;
                                } else {
                                    echo "  ....................................................";
                                }
                                ?>

                            </div>  
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
<?php endif; ?>
<br>
<div style="font-weight:bold">
    PERSON IN CHARGE
</div>
<table id="identificationtable" width="100%">
    <tr>
        <td width="50%">
            <div class="control-group">
                <?php echo CHtml::label('DPJTM', '', array('class' => 'control-label alig', 'style' => 'width: 150px;')); ?>
                <?php echo CHtml::label('<span>:</span>', '', array('class' => 'control-label ', 'style' => 'width: 10px;')); ?>
                <div class="controls">
                    <?php
                    if (!empty($model->verifikator_nama)) {

                        echo "<div id='breakfloat'>" . $model->verifikator_nama . "</div>";
                    } else {
                        echo "  ....................................................";
                    }
                    ?>

                </div>

            </div>
        </td>
    </tr>
    <tr>
        <td width="50%">
            <div class="control-group">
                <?php echo CHtml::label('NIM/NIP', '', array('class' => 'control-label alig', 'style' => 'width: 150px;')); ?>
                <?php echo CHtml::label('<span>:</span>', '', array('class' => 'control-label ', 'style' => 'width: 10px;')); ?>
                <div class="controls">
                    <?php
                    if (!empty($model->verifikator_nim)) {

                        echo "<div id='breakfloat'>" . $model->verifikator_nim . "</div>";
                    } else {
                        echo "  ....................................................";
                    }
                    ?>
                </div>
            </div>
        </td>
    </tr>
</table>
<?php $this->endWidget(); ?>
<?php
if (!isset($_GET['print'])) {
    echo CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="icon-print icon-white"></i>')), array('class' => 'btn btn-primary', 'type' => 'button', 'onclick' => 'print()')) . "&nbsp&nbsp";
    echo CHtml::htmlButton(Yii::t('mds', '{icon} PDF', array('{icon}' => '<i class="icon-book icon-white"></i>')), array('class' => 'btn btn-primary', 'type' => 'button', 'onclick' => 'printpdf()')) . "&nbsp&nbsp";
    ?>
    <br>
    <?php ?>
    <script type='text/javascript'>
        /**
         * print
         */
        function print() {
            window.open("<?php echo Yii::app()->createUrl("mikrobiologiKlinik/InformasiDaftarSpesimen/Detail", array("id" => $modSpesimen->spesimen_id, 'print' => "print")) ?>", "", 'location=_new, width=1024px');
        }
        function printpdf() {
            window.open("<?php echo Yii::app()->createUrl("mikrobiologiKlinik/InformasiDaftarSpesimen/Detail", array("id" => $modSpesimen->spesimen_id, 'print' => "pdf")) ?>", "", 'location=_new, width=1024px');
        }
        function printexcel() {
            window.open("<?php echo Yii::app()->createUrl("mikrobiologiKlinik/InformasiDaftarSpesimen/Detail", array("id" => $modSpesimen->spesimen_id, 'print' => "excel")) ?>", "", 'location=_new, width=1024px');
        }
    </script>
    <?php
} else {
    ?>  
    <script>

    </script>   
    <?php
}
?>
    
