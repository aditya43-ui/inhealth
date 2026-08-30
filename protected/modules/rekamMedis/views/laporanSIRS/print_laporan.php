
<?php
    $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm',
        array(
            'id'=>'searchPrint-form',
            'enableAjaxValidation'=>false,
            'type'=>'horizontal',
            'focus'=>'#isPasienLama',
            'htmlOptions'=>array(
                'onKeyPress'=>'return disableKeyPress(event)'
            ),
        )
    );
?>
<style>
    .border th, .border td{
        border:1px solid #000;
    }
    .table thead:first-child{
        border-top:1px solid #000;        
    }

    thead th{
        background:none;
        color:#333;
    }

    .table {
        box-shadow:none;
    }

    .table tbody tr:hover td, .table tbody tr:hover th {
        background-color: none;
    }
    </style>
<?php $data=ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS()); ?>
<?php
    if($caraPrint=='EXCEL')
    {
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'.$title.'-'.date("Y/m/d").'.xls"');
        header('Cache-Control: max-age=0');     
    }
?>
<table  style="width:100%;font-size: 11px;">
    <tbody>
    <tr>
        <td width="5%" style="border-bottom: 3px solid #000000;">
            <img src="<?php echo Yii::app()->request->baseUrl . "/images/bhakti_husada.jpg"; ?>" width="80"/>
        </td>
        <td width="45%"  align="left" VALIGN=MIDDLE style="border-bottom: 3px solid #000000;" colspan="3">
            <?php echo($formulir);?><br><?php echo($title);?></br>
        </td>
        <td width="50%" style="border-bottom: 3px solid #000000;" <?php echo isset($colspan)?"colspan='".$colspan."' align='right'":''; ?> >
            <div style="border:1px solid #AEAEAE;font-size:9px;font-style: italic;border-style: dotted;padding: 10px;">
                Ditjen Bina Upaya Kesehatan<br>
                Kementrian Kesehatan RI
            </div>
        </td>        
    </tr>
    <tr>
        <td>&nbsp;</td>
    </tr>
    </tbody>
</table>
    
<table cellpadding="0" cellspacing="0" width='100%' border="0">
    <tr>
        <td width="49%">
            <table style="width: 100%; border: none;">
                <tr>
                    <td>Kode RS</td>
                    <td <?php echo isset($colspan1)?"colspan='".$colspan1."' ":''; ?> >: <?php echo (isset($data->nokode_rumahsakit) ? $data->nokode_rumahsakit : "-"); ?></td>
                </tr>
                <tr>
                    <td>Nama RS</td>
                    <td <?php echo isset($colspan1)?"colspan='".$colspan1."' ":''; ?> >: <?php echo $data->nama_rumahsakit ?></td>
                </tr>
                <tr>
                    <td>Tahun</td>
                    <td <?php echo isset($colspan1)?"colspan='".$colspan1."' ":''; ?> >: <?=date('Y')?></td>
                </tr>
                <?php if($formulir == 'Formulir RL 1.1'){ ?>
                <tr>
                    <td>Tanggal</td>
                    <td <?php echo isset($colspan1)?"colspan='".$colspan1."' ":''; ?> >: <?= MyFormatter::formatDateTimeId(date('Y-m-d')); ?></td>
                </tr>
                <?php } ?>
            </table>                        
        </td>
     
    </tr>
    <tr>
        <td>&nbsp;</td>
    </tr>
</table>
   

<?=$table;?>
    <?php
        $cekAction=  Yii::app()->controller->action->id;
    ?>
  <?php if($_GET['caraPrint'] == 'Dialog') {?>
     <div class="form-actions">
            <div style="float:left;">
                <?php
                echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="entypo-print"></i>')),array('class'=>'btn btn-info', 'type'=>'button','onclick'=>'printLaporan_new(\'PRINT\')')); 
                echo CHtml::htmlButton(Yii::t('mds','{icon} PDF',array('{icon}'=>'<i class="entypo-book"></i>')),array('class'=>'btn btn-info', 'type'=>'button','onclick'=>'printLaporan_new(\'PDF\')')); 
                echo CHtml::htmlButton(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="entypo-doc-text"></i>')),array('class'=>'btn btn-info', 'type'=>'button','onclick'=>'printLaporan_new(\'EXCEL\')'));
                if($cekAction == 'KegiatanKesehatanJiwa') {
                echo CHtml::htmlButton(Yii::t('mds','{icon} Format Upload',array('{icon}'=>'<i class="icon-pdf icon-white"></i>')),array('class'=>'btn btn-info', 'type'=>'button','onclick'=>'printLaporan_kesehatanjiwa(\'EXCEL\')')); 
                }elseif($cekAction == 'KegiatanPelayananRS'){
                echo CHtml::htmlButton(Yii::t('mds','{icon} Format Upload',array('{icon}'=>'<i class="icon-pdf icon-white"></i>')),array('class'=>'btn btn-info', 'type'=>'button','onclick'=>'printLaporan_kegiatanpelayanan(\'EXCEL\')')); 
                }elseif($cekAction == 'KegiatanKebidanan'){
                echo CHtml::htmlButton(Yii::t('mds','{icon} Format Upload',array('{icon}'=>'<i class="icon-pdf icon-white"></i>')),array('class'=>'btn btn-info', 'type'=>'button','onclick'=>'printLaporan_kebidanan(\'EXCEL\')')); 
                }elseif($cekAction == 'KegiatanKeluargaBerencana'){
                echo CHtml::htmlButton(Yii::t('mds','{icon} Format Upload',array('{icon}'=>'<i class="icon-pdf icon-white"></i>')),array('class'=>'btn btn-info', 'type'=>'button','onclick'=>'printLaporan_kb(\'EXCEL\')')); 
                }elseif($cekAction == 'CaraBayar'){
                echo CHtml::htmlButton(Yii::t('mds','{icon} Format Upload',array('{icon}'=>'<i class="icon-pdf icon-white"></i>')),array('class'=>'btn btn-info', 'type'=>'button','onclick'=>'printLaporan_carabayar(\'EXCEL\')')); 
                }elseif($cekAction == 'gigiMulut'){
                echo CHtml::htmlButton(Yii::t('mds','{icon} Format Upload',array('{icon}'=>'<i class="icon-pdf icon-white"></i>')),array('class'=>'btn btn-info', 'type'=>'button','onclick'=>'printLaporan_gigimulut(\'EXCEL\')')); 
                }elseif($cekAction == 'morbiditasRawatJalan'){
                echo CHtml::htmlButton(Yii::t('mds','{icon} Format Upload',array('{icon}'=>'<i class="icon-pdf icon-white"></i>')),array('class'=>'btn btn-info', 'type'=>'button','onclick'=>'printLaporan_morbiditasRawatJalan(\'EXCEL\')')); 
                }elseif($cekAction == 'tempatTidurRI'){
                echo CHtml::htmlButton(Yii::t('mds','{icon} Format Upload',array('{icon}'=>'<i class="icon-pdf icon-white"></i>')),array('class'=>'btn btn-info', 'type'=>'button','onclick'=>'printLaporan_tempatTidurRI(\'EXCEL\')')); 
                }elseif($cekAction == 'kunjunganRD'){
                echo CHtml::htmlButton(Yii::t('mds','{icon} Format Upload',array('{icon}'=>'<i class="icon-pdf icon-white"></i>')),array('class'=>'btn btn-info', 'type'=>'button','onclick'=>'printkunjunganRD(\'EXCEL\')')); 
                }elseif($cekAction == 'PelayananRehabMedik'){
                echo CHtml::htmlButton(Yii::t('mds','{icon} Format Upload',array('{icon}'=>'<i class="icon-pdf icon-white"></i>')),array('class'=>'btn btn-info', 'type'=>'button','onclick'=>'printPelayananRehabMedik(\'EXCEL\')')); 
                }elseif($cekAction == 'KegiatanPelayananRawatInap'){
                echo CHtml::htmlButton(Yii::t('mds','{icon} Format Upload',array('{icon}'=>'<i class="icon-pdf icon-white"></i>')),array('class'=>'btn btn-info', 'type'=>'button','onclick'=>'printKegiatanPelayananRawatInap(\'EXCEL\')')); 
                }elseif($cekAction == 'kegiatanRadiologi'){
                echo CHtml::htmlButton(Yii::t('mds','{icon} Format Upload',array('{icon}'=>'<i class="icon-pdf icon-white"></i>')),array('class'=>'btn btn-info', 'type'=>'button','onclick'=>'printkegiatanRadiologi(\'EXCEL\')')); 
                }elseif($cekAction == 'KegiatanRujukan'){
                echo CHtml::htmlButton(Yii::t('mds','{icon} Format Upload',array('{icon}'=>'<i class="icon-pdf icon-white"></i>')),array('class'=>'btn btn-info', 'type'=>'button','onclick'=>'printKegiatanRujukan(\'EXCEL\')')); 
                }elseif($cekAction == 'KegiatanPerinatologi'){
                echo CHtml::htmlButton(Yii::t('mds','{icon} Format Upload',array('{icon}'=>'<i class="icon-pdf icon-white"></i>')),array('class'=>'btn btn-info', 'type'=>'button','onclick'=>'printKegiatanPerinatologi(\'EXCEL\')')); 
                }elseif($cekAction == 'SepuluhBesarPenyakitRawatInap'){
                echo CHtml::htmlButton(Yii::t('mds','{icon} Format Upload',array('{icon}'=>'<i class="icon-pdf icon-white"></i>')),array('class'=>'btn btn-info', 'type'=>'button','onclick'=>'printSepuluhBesarPenyakitRawatInap(\'EXCEL\')')); 
                }elseif($cekAction == 'kegiatanPembedahan'){
                echo CHtml::htmlButton(Yii::t('mds','{icon} Format Upload',array('{icon}'=>'<i class="icon-pdf icon-white"></i>')),array('class'=>'btn btn-info', 'type'=>'button','onclick'=>'printkegiatanPembedahan(\'EXCEL\')')); 
                }elseif($cekAction == 'morbiditasRawatInap'){
                echo CHtml::htmlButton(Yii::t('mds','{icon} Format Upload',array('{icon}'=>'<i class="icon-pdf icon-white"></i>')),array('class'=>'btn btn-info', 'type'=>'button','onclick'=>'printmorbiditasRawatInap(\'EXCEL\')')); 
                }elseif($cekAction == 'SepuluhBesarPenyakitRawatJalan'){
                echo CHtml::htmlButton(Yii::t('mds','{icon} Format Upload',array('{icon}'=>'<i class="icon-pdf icon-white"></i>')),array('class'=>'btn btn-info', 'type'=>'button','onclick'=>'printSepuluhBesarPenyakitRawatJalan(\'EXCEL\')')); 
                }elseif($cekAction == 'PemeriksaanLaboratorium'){
                echo CHtml::htmlButton(Yii::t('mds','{icon} Format Upload',array('{icon}'=>'<i class="icon-pdf icon-white"></i>')),array('class'=>'btn btn-info', 'type'=>'button','onclick'=>'printPemeriksaanLaboratorium(\'EXCEL\')'));   
                }elseif($cekAction == 'kunjunganRawatJalan'){
                echo CHtml::htmlButton(Yii::t('mds','{icon} Format Upload',array('{icon}'=>'<i class="icon-pdf icon-white"></i>')),array('class'=>'btn btn-info', 'type'=>'button','onclick'=>'printKunjunganRawatJalan(\'EXCEL\')'));
                }elseif($cekAction == 'KegiatanPelayananKhusus'){
                echo CHtml::htmlButton(Yii::t('mds','{icon} Format Upload',array('{icon}'=>'<i class="icon-pdf icon-white"></i>')),array('class'=>'btn btn-info', 'type'=>'button','onclick'=>'printKegiatanPelayananKhusus(\'EXCEL\')'));
                }elseif($cekAction == 'ketenagaan'){
                echo CHtml::htmlButton(Yii::t('mds','{icon} Format Upload',array('{icon}'=>'<i class="icon-pdf icon-white"></i>')),array('class'=>'btn btn-info', 'type'=>'button','onclick'=>'printketenagaan(\'EXCEL\')'));
                }
                
                ?>
            </div>
          
    </div>
  <?php } ?>
    
    
  <?php $this->renderPartial('_jsFunctions', array());
    
$this->endWidget();
      ?>