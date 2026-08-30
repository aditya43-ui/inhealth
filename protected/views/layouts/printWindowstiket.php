<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/print.css" media="print" />
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/themes/neon18/assets/css/custom.css" media="print" />
         <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/font.css" media="screen" />
	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
        <style>
            @media print {
                
                html, body {
                  
                   font-family: Calibri !important;
                  
                }
                @font-face {
                    font-family: 'mistral';
                    font-style: normal;
                    font-weight: normal;
                    src: local('Mistral'), url('<?php echo Yii::app()->request->baseUrl; ?>/css/font/MISTRAL.woff') format('woff');
                }
                @font-face {
                    font-family: 'calibri';
                    font-style: normal;
                    src: local('Calibri'), url('<?php echo Yii::app()->request->baseUrl; ?>/css/font/Calibri Regular.ttf') format('woff');
                }
                 @font-face {
                    font-family: 'calibri_b';
                    font-style: bold;
                    src: local('CalibriB'), url('<?php echo Yii::app()->request->baseUrl; ?>/css/font/Calibri Bold.TTF') format('woff');
                }
                  .footer .alamatfooter{
                    font-size:8pt !important;
                    font-family: calibri !important;
                     color:black !important;
                       text-align:left !important;
                }
                .footer .mottofooter {
                    font-size:9pt !important;
                    font-family:mistral !important;
                    color:#00adef !important;
                    text-align:right !important;
                    
                    
                }
            }
            
                   .footer .alamatfooter{
                    font-size:8pt !important;
                    font-family: calibri !important;
                     color:black !important;
                       text-align:left !important;
                }
                .footer .mottofooter {
                    font-size:9pt !important;
                    font-family:mistral !important;
                    color:#00adef !important;
                    text-align:right !important;
                    
                    
                }
		<!-- 
		BODY,DIV,TABLE,TBODY,TFOOT,TR,TH,TD,P { font-family:"Calibri";  }
		THEAD { font-family:"Calibri";  }
		 -->
		.line-words{
			text-decoration: line-through;
		}
                
               
	</style>
        
        <script type="text/javascript">
            function chkstate(){
            if(document.readyState=="complete"){
                window.close()
            }
            else{
                setTimeout("chkstate()",2000)
            }
            }

            function print_win(){
                window.print();
//                chkstate();
            }
        </script>
       
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>

<body style="background-color: #ffffff;" onload="print_win()">

 <div id="wrapper"> <!-- not necessary -->
        
<div class="container" id="page">
	<?php echo $content; ?>    
</div>
   

</body>
</html>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/themes/neon/assets/js/raphael-min.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/themes/neon/assets/js/morris.min.js"></script>
