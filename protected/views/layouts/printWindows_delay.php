<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>
<!--        <link rel="stylesheet" type="text/css" href="<?php //echo Yii::app()->request->baseUrl;   ?>/css/print.css" media="print" />
        <link rel="stylesheet" type="text/css" href="<?php //echo Yii::app()->request->baseUrl;   ?>/themes/neon18/assets/css/custom.css" media="print" />-->

        <title><?php echo CHtml::encode($this->pageTitle); ?></title>
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/font.css" media="screen" />
        <style>
          
            @media print {

                html, body {
                  
                   font-family: Calibri !important;
                  
                }
                @font-face {
                    font-family: 'Mistral';
                    font-style: normal;
                    font-weight: normal;
                    src: local('Mistral'), url('<?php echo Yii::app()->request->baseUrl; ?>/css/font/MISTRAL.woff') format('woff');
                }
                @font-face {
                    font-family: 'Calibri';
                    font-style: normal;
                    src: local('Calibri'), url('<?php echo Yii::app()->request->baseUrl; ?>/css/font/Calibri Regular.ttf') format('woff');
                }

                .footer .alamatfooter{
                    font-size:10pt !important;
                    font-family: Calibri !important;
                     color:black !important;
                }
                .footer .mottofooter {
                    font-size:11pt !important;
                    font-family:Mistral !important;
                    color:#00adef !important;
                    
                }
                .content,.content DIV,.content TABLE,.content TBODY,.content TFOOT,.content TR,.content TH,.content TD,.content P{
                    font-size:11pt !important;
                    font-family: Calibri !important;
                     color:black !important;
                }
                .content .judulcontent{
                    font-size:12pt !important;
                    font-family: Calibri !important;
                     color:black !important;
                }
                .footer, .footer-space {
                    height: 2cm;
                }
                
                .header-space{

/*                    height: 2cm;*/
                }
                .header {
                    
/*                    width: 100%;
                    top: 0;*/

                }
                .header .header-space{

/*                    height: 40mm;*/
                }
                .footer {
                    width: 100%;
                    position: fixed;
                    bottom: 0;
                }


            }



        </style>
        <style>
            .footer .alamatfooter{
                font-size:10pt !important;
                font-family: Calibri !important;
                 color:black !important;
            }
            .footer .mottofooter {
                font-size:11pt !important;
                font-family:Mistral !important;
                color:#00adef !important;
                
            }
            .content,.content DIV,.content TABLE,.content TBODY,.content TFOOT,.content TR,.content TH,.content TD,.content P{
                font-size:11pt !important;
                font-family: Calibri !important;
                 color:black !important;
            }
            .content .judulcontent{
                font-size:12pt !important;
                font-family: Calibri !important;
                 color:black !important;
            }
        </style> 

        <script type="text/javascript">
            function chkstate() {
                if (document.readyState == "complete") {
                    window.close()
                } else {
                    setTimeout("chkstate()", 2000)
                }
            }

            function print_win() {
                setTimeout(function() {
                    window.print();
                }, 1000);
                
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
