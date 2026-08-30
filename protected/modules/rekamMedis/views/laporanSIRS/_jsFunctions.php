<?php
$url = Yii::app()->createUrl($this->route);
$urlModule = Yii::app()->createUrl($this->module->id);
$urlGrafik = Yii::app()->createUrl($this->module->id."/".$this->id."/UpdateGrafik");
    $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
    $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
    $urlPrint=  Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/'.Yii::app()->controller->action->id,$_GET);
    $urlPrintKesehatanJiwa=  Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/PrintKegiatanKesehatanJiwa',$_GET);
    $urlPrintKegiatanpelayanan=  Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/PrintKegiatanPelayanan',$_GET);
    $urlPrintKegiatankebidanan = Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/PrintKegiatanKebidanan',$_GET);
    $urlPrintKegiatankb = Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/PrintKegiatanKeluargaBerencana',$_GET);
    $urlPrintKegiatancb = Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/PrintCaraBayar',$_GET);
    $urlPrintKegiatangigi = Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/PrintGigiMulut',$_GET);
    $urlPrintmorbiditasRawatJalan = Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/PrintMorbiditasRawatJalan',$_GET);
    $urlPrinttempatTidurRI = Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/PrintTempatTidurRI',$_GET);
    $urlPrintKunjunganRD = Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/PrintKunjunganRD',$_GET);
    $printPelayananRehabMedik = Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/PrintPelayananRehabMedik',$_GET);
    $printKegiatanPelayananRawatInap = Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/PrintKegiatanPelayananRawatInap',$_GET);
    $printkegiatanRadiologi = Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/PrintKegiatanRadiologi',$_GET);
    $printKegiatanRujukan = Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/PrintKegiatanRujukan',$_GET);
    $printKegiatanPerinatologi = Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/PrintKegiatanPerinatologi',$_GET);
    $printSepuluhBesarPenyakitRawatInap = Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/PrintSepuluhBesarPenyakitRawatInap',$_GET);
    $printkegiatanPembedahan = Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/PrintKegiatanPembedahan',$_GET);
    $printmorbiditasRawatInap = Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/PrintMorbiditasRawatInap',$_GET);
    $printSepuluhBesarPenyakitRawatJalan = Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/PrintSepuluhBesarPenyakitRawatJalan',$_GET);
    $printPemeriksaanLaboratorium = Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/PrintPemeriksaanLaboratorium',$_GET);
    $printKunjunganRawatJalan = Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/PrintKunjunganRawatJalan',$_GET);
    $printKegiatanPelayananKhusus = Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/PrintKegiatanPelayananKhusus',$_GET);
    $printketenagaan = Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/PrintKetenagaan',$_GET);
    $params = Yii::app()->controller->createUrl(Yii::app()->controller->action->id, $_GET);
$js = <<< JS
    ubahJnsPeriode();
        
    function printLaporan_new(params)
{
       window.open("${urlPrint}/"+"&caraPrint="+params,"",'location=_new, width=900px, scrollbars=yes');

    return false;
}
       
    function printLaporan_kesehatanjiwa(params)
{
       window.open("${urlPrintKesehatanJiwa}/"+"&caraPrint="+params,"",'location=_new, width=900px, scrollbars=yes');

    return false;
}
function printLaporan_kegiatanpelayanan(params)
{ 
   window.open("${urlPrintKegiatanpelayanan}/"+"&caraPrint="+params,"",'location=_new, width=900px, scrollbars=yes');

    return false; 
}
function printLaporan_kebidanan(params)
{
    window.open("${urlPrintKegiatankebidanan}/"+"&caraPrint="+params,"",'location=_new, width=900px, scrollbars=yes');
    return false; 
}
function printLaporan_kb(params)
{
    window.open("${urlPrintKegiatankb}/"+"&caraPrint="+params,"",'location=_new, width=900px, scrollbars=yes');
    return false;   
}  
function printLaporan_carabayar(params)
{
    window.open("${urlPrintKegiatancb}/"+"&caraPrint="+params,"",'location=_new, width=900px, scrollbars=yes');
    return false;     
}
function printLaporan_gigimulut(params)
{
    window.open("${urlPrintKegiatangigi}/"+"&caraPrint="+params,"",'location=_new, width=900px, scrollbars=yes');
    return false;     
}
function printLaporan_morbiditasRawatJalan(params)
{
    window.open("${urlPrintmorbiditasRawatJalan}/"+"&caraPrint="+params,"",'location=_new, width=900px, scrollbars=yes');
    return false;   
}
function printLaporan_tempatTidurRI(params)
{
    window.open("${urlPrinttempatTidurRI}/"+"&caraPrint="+params,"",'location=_new, width=900px, scrollbars=yes');
    return false;   
}
function printkunjunganRD(params)
{
    window.open("${urlPrintKunjunganRD}/"+"&caraPrint="+params,"",'location=_new, width=900px, scrollbars=yes');
    return false;      
}
function printPelayananRehabMedik(params)
{
    window.open("${printPelayananRehabMedik}/"+"&caraPrint="+params,"",'location=_new, width=900px, scrollbars=yes');
    return false;       
}
function printKegiatanPelayananRawatInap(params)
{
   window.open("${printKegiatanPelayananRawatInap}/"+"&caraPrint="+params,"",'location=_new, width=900px, scrollbars=yes');
   return false;           
}
function printkegiatanRadiologi(params)
{
   window.open("${printkegiatanRadiologi}/"+"&caraPrint="+params,"",'location=_new, width=900px, scrollbars=yes');
   return false;   
}
function printKegiatanRujukan(params)
{
   window.open("${printKegiatanRujukan}/"+"&caraPrint="+params,"",'location=_new, width=900px, scrollbars=yes');
   return false;    
   
}
function printKegiatanPerinatologi(params)
{
   window.open("${printKegiatanPerinatologi}/"+"&caraPrint="+params,"",'location=_new, width=900px, scrollbars=yes');
   return false;      
}
function printSepuluhBesarPenyakitRawatInap(params)
{
   window.open("${printSepuluhBesarPenyakitRawatInap}/"+"&caraPrint="+params,"",'location=_new, width=900px, scrollbars=yes');
   return false;  
}
function printkegiatanPembedahan(params)
{
   window.open("${printkegiatanPembedahan}/"+"&caraPrint="+params,"",'location=_new, width=900px, scrollbars=yes');
   return false; 
}
function printmorbiditasRawatInap(params)
{
   window.open("${printmorbiditasRawatInap}/"+"&caraPrint="+params,"",'location=_new, width=900px, scrollbars=yes');
   return false;  
}
function printSepuluhBesarPenyakitRawatJalan(params)
{
   window.open("${printSepuluhBesarPenyakitRawatJalan}/"+"&caraPrint="+params,"",'location=_new, width=900px, scrollbars=yes');
   return false;     
}
function printPemeriksaanLaboratorium(params)
{
   window.open("${printPemeriksaanLaboratorium}/"+"&caraPrint="+params,"",'location=_new, width=900px, scrollbars=yes');
   return false;   
}
function printKunjunganRawatJalan(params)
{
  window.open("${printKunjunganRawatJalan}/"+"&caraPrint="+params,"",'location=_new, width=900px, scrollbars=yes');
   return false;        
}
function printKegiatanPelayananKhusus(params)
{
  window.open("${printKegiatanPelayananKhusus}/"+"&caraPrint="+params,"",'location=_new, width=900px, scrollbars=yes');
   return false;
  
}
  function printketenagaan(params)
{
    window.open("${printketenagaan}/"+"&caraPrint="+params,"",'location=_new, width=900px, scrollbars=yes');
   return false;  
}
JS;
    Yii::app()->clientScript->registerScript('print',$js,CClientScript::POS_HEAD);    
Yii::app()->clientScript->registerScript('diagram',$js, CClientScript::POS_READY)
?>
<script type="text/javascript">
    function refreshForm(){
        window.location.href = "<?php echo $url;?>";
    }
    function konfirmasiBatal(){
        var conf = confirm("Apakah Anda akan membatalkan ini?");
        if(conf == true){
            window.location.href = "<?php echo $urlModule;?>&modul_id=39";
        }
    }
    function ubahJnsPeriode(){
        var obj = $("#jns_periode");
        if(obj.val() == 'hari'){
            $('.hari').show();
            $('.bulan').hide();
            $('.tahun').hide();
        }else if(obj.val() == 'bulan'){
            $('.hari').hide();
            $('.bulan').show();
            $('.tahun').hide();
        }else if(obj.val() == 'tahun'){
            $('.hari').hide();
            $('.bulan').hide();
            $('.tahun').show();
        }
    }
    
    
    
</script>