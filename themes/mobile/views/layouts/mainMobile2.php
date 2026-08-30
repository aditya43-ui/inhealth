<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language  " content="en" />
        <?php Yii::app()->clientScript->registerMetaTag('width=device-width, initial-scale=1.0', 'viewport'); ?>

	<!-- blueprint CSS framework -->
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/screen.css" media="screen, projection" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/print.css" media="print" />
<!--	[if lt IE 8]>
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ie.css" media="screen, projection" />
	<![endif]-->

	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/form.css" />
	
    <link rel="shortcut icon" href="<?php echo Yii::app()->baseUrl;?>/images/icon/favicon.png"/>
	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
        
        <script>
            function updateClock ( )
            {
                var currentTime = new Date ( );
                var currentHours = currentTime.getHours ( );
                var currentMinutes = currentTime.getMinutes ( );
                var currentSeconds = currentTime.getSeconds ( );
                
                // Pad the minutes and seconds with leading zeros, if required
                currentMinutes = ( currentMinutes < 10 ? "0" : "" ) + currentMinutes;
                currentSeconds = ( currentSeconds < 10 ? "0" : "" ) + currentSeconds;
                
                // Choose either "AM" or "PM" as appropriate
                var timeOfDay = ( currentHours < 12 ) ? "AM" : "PM";
                
                // Convert the hours component to 12-hour format if needed
                currentHours = ( currentHours > 12 ) ? currentHours - 12 : currentHours;
                
                // Convert an hours component of "0" to "12"
                currentHours = ( currentHours == 0 ) ? 12 : currentHours;
                
                // Compose the string for display
                var currentTimeString = currentHours + ":" + currentMinutes + ":" + currentSeconds + " " + timeOfDay;
                
                $("#clock").html(currentTimeString);
                
            }
            
            $(document).ready(function()
            {
                setInterval('updateClock()', 1000);
            });
        </script>
        <style>
            .container{
                width:80%;
            }
            .form-actions{
                width:90%;
            }
            
            .navbar{
                width:100%;
            }
            .span-25{
                width:100% !important;
                margin-left: 0px !important;
            }
            textarea, select, .uneditable-input, table .span3, table .span2{
                width:100% !important;
            }
            table .span1, .dtPicker3{
                width:40% !important;
                display:inline;
            }
            legend.rim, legend.rim2{
                width:80%;
                font-size: 14px;
                background-repeat: no-repeat !important;
            }
            .navbar-static .navbar-inner{
                padding:0px;
            }
            #clock{
                margin-right:20px;
            }
            
            </style>
<!--            <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl.'/css/responsive.css' ?>" />-->
<!--            <link rel="stylesheet" type="text/css" href="<?php Yii::app()->clientScript->registerCssFile(Yii::app()->getBaseUrl().'/css/bootstrap-responsive.min.css'); ?>" />-->
</head>

<body>

       <?php       
            
            $this->widget('bootstrap.widgets.BootNavbar', array(
            'fixed'=>false,
            //'brand'=>Yii::app()->name,
            'brand'=>'<img src="images/home.png" class="navbar-image marginMin"/>',
            'brandUrl'=>'',
            'collapse'=>false, // requires bootstrap-responsive.css
            'fluid'=>false,
            'items'=>
               
                array(
                    
                    //'<a href="" class="navbar-link"><img class="navbar-image marginplus" src="http://localhost/simrs/images/icon_modul/1333096830_image.png"></a>',
                    //empty($namaInstalasi)? "":  '<span class="btn btn-info">'.$namaInstalasi.'</span>',
//                        '<form class="navbar-search pull-left" action=""><input type="text" class="search-query span2" placeholder="Search"></form>',
                    
                    '<span id="clock" class="pull-right navbar-text-baru"></span>',
            ),
        )); ?> 
<div class="container" id="page">

<!--	<div id="header">
		<div id="logo"><?php echo CHtml::encode(Yii::app()->name); ?></div>
	</div> header -->

	<div id="mainmenu">
		<?php 
//                $this->widget('zii.widgets.CMenu',array(
//			'items'=>array(
//				array('label'=>'Home', 'url'=>array('/site/index')),
//				array('label'=>'About', 'url'=>array('/site/page', 'view'=>'about')),
//				array('label'=>'Contact', 'url'=>array('/site/contact')),
//				array('label'=>'Login', 'url'=>array('/site/login'), 'visible'=>Yii::app()->user->isGuest),
//				array('label'=>'Logout ('.Yii::app()->user->name.')', 'url'=>array('/site/logout'), 'visible'=>!Yii::app()->user->isGuest)
//			),
//		)); ?>
	</div><!-- mainmenu -->
        
<!--        <div class="span-25">
	<?php if(isset($this->breadcrumbs)){
            $this->widget('bootstrap.widgets.BootBreadcrumbs', array(
                        'links'=>$this->breadcrumbs,
                    )); // breadcrumbs 
        }
        ?>
        </div>-->
        <div class="span-25">
        <?php
        if(isset($this->menu)){
            $this->widget('bootstrap.widgets.BootMenu', array(
                'type'=>'pills', // '', 'tabs', 'pills' (or 'list')
                'stacked'=>false, // whether this is a stacked menu
                'items'=>$this->menu,
            ));
        } ?>
        </div>
        
        <?php //echo '<pre>'.print_r($menu,1).'</pre>'; ?>
        <?php //echo '<pre>'.print_r($this->arrMenuModul,1).'</pre>'; ?>
	<div id="content" class="span-25">
            <?php echo $content; ?>
        </div><!-- content -->

	<div class="clear"></div>

	<div id="footer">
		Copyright &copy; <?php echo date('Y'); ?> by Innova Hospital.
		<?php //echo Yii::powered(); ?>
	</div><!-- footer -->

</div><!-- page -->

</body>
</html>
<?php
$js = <<< JSCRIPT
    function dialog_kertas()
        {
        $('#ubah_kertas').dialog('open');
        
        }
    function simpan_kertas()
        {
            ukuranKertas = $('#ukuranKertas').val();
            posisiKertas = $('#posisiKertas').val();
            posisiNama = $('#posisiKertas :selected').html();
            $.post("index.php?r=site/setKertas",{ukuranKertas:ukuranKertas,posisiKertas:posisiKertas,posisiNama:posisiNama },function(data){
                alert(data.pesan);
                 $('#ubah_kertas').dialog('close');
                
        return false;
    },"json");
        }
JSCRIPT;

Yii::app()->clientScript->registerScript('jsPendaftaran',$js, CClientScript::POS_HEAD);

$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id'=>'ubah_kertas',
    'options'=>array(
        'title'=>'Ubah Ukuran dan Posisi Kertas',
        'autoOpen'=>false,
        'width'=>450,
        'height'=>300,
        'modal'=>'true',
        'hide'=>'explode',
        'resizelable'=>false,
    ),
));

//$form=$this->beginWidget('CActiveForm', array(
//	'id'=>'setting-print-form',
//        'enableAjaxValidation'=>false,
//        'action'=>'/simrs/index.php?r=site/setKertas',
//        'htmlOptions'=>array('class'=>'form-horizontal'),
//));
?>
<div class="control-group">
    <?php echo CHtml::label('Ukuran Kertas', 'print_ukuranKertas', array('class'=>'control-label')); ?>
    <div class="controls">
        <?php echo CHtml::dropDownList('ukuranKertas', Yii::app()->user->getState('ukuran_kertas'), CustomFunction::getUkuranKertas(), array('class'=>'span3')); ?>
    </div>
</div>

<div class="control-group">
    <?php echo CHtml::label('Posisi Kertas', 'print_posisiKertas', array('class'=>'control-label')); ?>
    <div class="controls">
        <?php echo CHtml::dropDownList('posisiKertas', Yii::app()->user->getState('posisi_kertas'), CustomFunction::getPosisiKertas(), array('class'=>'span3')); ?>
    </div>
</div>
<div class="form-actions">
        <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),
                        array('class'=>'btn btn-primary', 'type'=>'button', 'name'=>'btn_simpan','onclick'=>'simpan_kertas()')); ?>
        <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Cancel',array('{icon}'=>'<i class="icon-ban-circle icon-white"></i>')),
                        array('class'=>'btn btn-danger', 'type'=>'button', 'name'=>'btn_batal','onclick'=>'$(\'#ubah_kertas\').dialog(\'close\')')); ?>                
         
</div>
<?php //$this->endWidget(); ?>    
<?php $this->endWidget('zii.widgets.jui.CJuiDialog');?>
