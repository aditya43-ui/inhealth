<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>
<!--        <link rel="stylesheet" type="text/css" href="<?php //echo Yii::app()->request->baseUrl;     ?>/css/print.css" media="print" />
        <link rel="stylesheet" type="text/css" href="<?php //echo Yii::app()->request->baseUrl;     ?>/themes/neon18/assets/css/custom.css" media="print" />-->

        <title><?php echo CHtml::encode($this->pageTitle); ?></title>
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/font.css" media="screen" />
        <style>

            @media print {

                html, body {
                    font-size:11pt !important;
                    font-family: calibri !important;

                }
                @font-face {
                    font-family: 'mistral';
                    font-style: normal;
                    font-weight: normal;
                    src: local('Mistral'), url('<?php echo Yii::app()->request->baseUrl; ?>/css/font/MISTRAL.woff') format('woff');
                }
                @font-face {
                    font-family: 'calbiri';
                    font-style: normal;
                    src: local('Calibri'), url('<?php echo Yii::app()->request->baseUrl; ?>/css/font/Calibri Regular.ttf') format('woff');
                }
                @font-face {
                    font-family: 'calbiri_b';
                    font-style: bold;
                    src: local('CalibriB'), url('<?php echo Yii::app()->request->baseUrl; ?>/css/font/Calibri Bold.TTF') format('woff');
                }

                .footer .alamatfooter{
                    font-size:10pt !important;
                    font-family: calibri !important;
                    color:black !important;
                    text-align:left !important;
                }
                .footer .mottofooter {
                    font-size:11pt !important;
                    font-family:mistral !important;
                    color:#00adef !important;
                    text-align:right !important;

                }
                .content,.content DIV,.content TABLE,.content TBODY,.content TFOOT,.content TR,.content TD,.content P,.content LABEL{
                    font-size:11pt !important;
                    font-family: calibri !important;
                    color:black !important;
                }
                .content TH{
                    font-family: calbiri_b !important;
                }
                .content .judulcontent{
                    font-size:12pt !important;
                    font-family: calbiri_b !important;
                    color:black !important;
                    font-weight:bold !important;
                    text-align:center !important;
                }
                .header .judulcontent{
                    font-size:12pt !important;
                    font-family: calbiri_b !important;
                    color:black !important;
                    font-weight:bold !important;
                    text-align:center !important;
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
                label{
                    font-size:11pt !important;
                }
                .table{
                    width:100%;
                    margin-bottom:10px;
                    box-shadow: none;
                    color:#333;
                }

                .table th,.table td{
                    padding:8px;
                    line-height:18px;
                    text-align:left;
                    vertical-align:top;
                    border-top:1px solid 000;
                }

                .table > tbody > tr > th, .table > tbody > tr > td{
                    border:1px solid #000;
                }

                .border th, .border td{
                    border:1px solid #000;
                    color:#000;
                }
                .table thead:first-child{
                    border:1px solid #000;        
                    color-style:bold;
                }

                thead th{
                    background:none;
                    color:#000;    
                }

                .border {
                    box-shadow:none;
                    border-spacing:0px;
                    padding:0px;
                    border: 1px solid #000;
                }

                .table tbody tr:hover td, .table tbody tr:hover th {
                    background-color: none;
                    border: 1px solid #000;
                }
                .table > thead > tr > th {
                    vertical-align: bottom;
                    border-bottom: 1px solid #000 !important;
                    font-weight: bold;
                    border: 1px solid #000;
                    color:#333;
                }

                .table > thead > tr > th, .table > tbody > tr > th, .table > tfoot > tr > th, .table > thead > tr > td, .table > tbody > tr > td, .table > tfoot > tr > td {	
                    border-top: 1px solid #000 !important;
                }

                .hide-column{
                    display: none
                }




                /** no border **/
                .noborder{
                    width:100%;
                    margin-bottom:10px;
                    box-shadow: none;
                    color:#333;
                    font-size:11px !important;
                }

                .noborder th,.noborder td{
                    padding:8px;
                    line-height:18px;
                    text-align:left;
                    vertical-align:top;
                    border-top:none;
                }

                .paddingtext th,.paddingtext td{
                    padding:8px;
                    line-height: 1.42857143 !important;
                    text-align:left;
                    vertical-align:top;
                    border-top:none;
                }

                .paddingtext2 th,.paddingtext2 td{
                    padding:8px;
                    line-height: 1.42857143 !important;
                    text-align:left;
                    vertical-align:top;
                    border-top:none;
                }
                .noborder > tbody > tr > th, .noborder > tbody > tr > td{
                    border:none;
                }



                element {

                }
                .noborder tbody tr:hover td, .noborder tbody tr:hover th {

                    background-color: none;
                    border: none;

                }

                .table tbody tr:hover td, .table tbody tr:hover th {

                    background-color: none;
                    border: 1px solid #000;

                }

                .noborder thead:first-child{
                    border:none;        
                    color-style:bold;
                }

                thead th{
                    background:none;
                    color:#000;    
                }

                .noborder {
                    box-shadow:none;
                    border-spacing:0px;
                    padding:0px;
                    border: none;
                }

                .noborder tbody tr:hover td, .noborder tbody tr:hover th {
                    background-color: none;
                    border:none;
                }
                .noborder > thead > tr > th {
                    vertical-align: bottom;
                    border-bottom: none;
                    font-weight: bold;
                    border: none;
                    color:#333;
                }

                .noborder > thead > tr > th, .noborder > tbody > tr > th, .noborder > tfoot > tr > th, .noborder > thead > tr > td, .noborder > tbody > tr > td, .noborder > tfoot > tr > td {	
                    border: none !important;
                    line-height: 0.5 !important;
                    font-size: 12px !important;
                }

                .noborder > thead > tr > th > p, .noborder > thead > tr > td > p, .noborder > tbody > tr > th > p, .noborder > tbody > tr > td > p, .noborder > tfoot > tr > td > p, .noborder > tfoot > tr > td > p{
                    margin:-5px;
                }


                .paddingtext > thead > tr > th, .paddingtext > tbody > tr > th, .paddingtext > tfoot > tr > th, .paddingtext > thead > tr > td, .paddingtext > tbody > tr > td, .paddingtext > tfoot > tr > td{
                    line-height: 1.42857143 !important; 
                    font-size:10px !important;   
                    padding:5px 0 0 5px;
                }

                .paddingtext2 > thead > tr > th, .paddingtext2 > tbody > tr > th, .paddingtext2 > tfoot > tr > th, .paddingtext2 > thead > tr > td, .paddingtext2 > tbody > tr > td, .paddingtext2 > tfoot > tr > td{
                    line-height: 1.22857143 !important; 
                    font-size:10px !important;   
                    padding:2px;
                }

                .paddingtext2 > tbody > tr >td > ul{
                    padding: 0;
                    margin: 0 0 0 25px !important;
                }

                .paddingtext2 > tbody > tr >td > ul > li{
                    line-height: 10px;
                }



            }



        </style>
        <style>
            .table{
                width:100%;
                margin-bottom:10px;
                box-shadow: none;
                color:#333;
            }

            .table th,.table td{
                padding:8px;
                line-height:18px;
                text-align:left;
                vertical-align:top;
                border-top:1px solid 000;
            }

            .table > tbody > tr > th, .table > tbody > tr > td{
                border:1px solid #000;
            }

            .border th, .border td{
                border:1px solid #000;
                color:#000;
            }
            .table thead:first-child{
                border:1px solid #000;        
                color-style:bold;
            }

            thead th{
                background:none;
                color:#000;    
            }

            .border {
                box-shadow:none;
                border-spacing:0px;
                padding:0px;
                border: 1px solid #000;
            }

            .table tbody tr:hover td, .table tbody tr:hover th {
                background-color: none;
                border: 1px solid #000;
            }
            .table > thead > tr > th {
                vertical-align: bottom;
                border-bottom: 1px solid #000 !important;
                font-weight: bold;
                border: 1px solid #000;
                color:#333;
            }

            .table > thead > tr > th, .table > tbody > tr > th, .table > tfoot > tr > th, .table > thead > tr > td, .table > tbody > tr > td, .table > tfoot > tr > td {	
                border-top: 1px solid #000 !important;
            }

            .hide-column{
                display: none
            }




            /** no border **/
            .noborder{
                width:100%;
                margin-bottom:10px;
                box-shadow: none;
                color:#333;
                font-size:11px !important;
            }

            .noborder th,.noborder td{
                padding:8px;
                line-height:18px;
                text-align:left;
                vertical-align:top;
                border-top:none;
            }

            .paddingtext th,.paddingtext td{
                padding:8px;
                line-height: 1.42857143 !important;
                text-align:left;
                vertical-align:top;
                border-top:none;
            }

            .paddingtext2 th,.paddingtext2 td{
                padding:8px;
                line-height: 1.42857143 !important;
                text-align:left;
                vertical-align:top;
                border-top:none;
            }
            .noborder > tbody > tr > th, .noborder > tbody > tr > td{
                border:none;
            }



            element {

            }
            .noborder tbody tr:hover td, .noborder tbody tr:hover th {

                background-color: none;
                border: none;

            }

            .table tbody tr:hover td, .table tbody tr:hover th {

                background-color: none;
                border: 1px solid #000;

            }

            .noborder thead:first-child{
                border:none;        
                color-style:bold;
            }

            thead th{
                background:none;
                color:#000;    
            }

            .noborder {
                box-shadow:none;
                border-spacing:0px;
                padding:0px;
                border: none;
            }

            .noborder tbody tr:hover td, .noborder tbody tr:hover th {
                background-color: none;
                border:none;
            }
            .noborder > thead > tr > th {
                vertical-align: bottom;
                border-bottom: none;
                font-weight: bold;
                border: none;
                color:#333;
            }

            .noborder > thead > tr > th, .noborder > tbody > tr > th, .noborder > tfoot > tr > th, .noborder > thead > tr > td, .noborder > tbody > tr > td, .noborder > tfoot > tr > td {	
                border: none !important;
                line-height: 0.5 !important;
                font-size: 12px !important;
            }

            .noborder > thead > tr > th > p, .noborder > thead > tr > td > p, .noborder > tbody > tr > th > p, .noborder > tbody > tr > td > p, .noborder > tfoot > tr > td > p, .noborder > tfoot > tr > td > p{
                margin:-5px;
            }


            .paddingtext > thead > tr > th, .paddingtext > tbody > tr > th, .paddingtext > tfoot > tr > th, .paddingtext > thead > tr > td, .paddingtext > tbody > tr > td, .paddingtext > tfoot > tr > td{
                line-height: 1.42857143 !important; 
                font-size:10px !important;   
                padding:5px 0 0 5px;
            }

            .paddingtext2 > thead > tr > th, .paddingtext2 > tbody > tr > th, .paddingtext2 > tfoot > tr > th, .paddingtext2 > thead > tr > td, .paddingtext2 > tbody > tr > td, .paddingtext2 > tfoot > tr > td{
                line-height: 1.22857143 !important; 
                font-size:10px !important;   
                padding:2px;
            }

            .paddingtext2 > tbody > tr >td > ul{
                padding: 0;
                margin: 0 0 0 25px !important;
            }

            .paddingtext2 > tbody > tr >td > ul > li{
                line-height: 10px;
            }


            .content TH{
                font-family: calbiri_b !important;
            }
            label{
                font-size:11pt !important;
            }
            .footer .alamatfooter{
                font-size:10pt !important;
                font-family: calibri !important;
                color:black !important;
            }
            .footer .mottofooter {
                font-size:11pt !important;
                font-family:mistral !important;
                color:#00adef !important;

            }
            .content,.content DIV,.content TABLE,.content TBODY,.content TFOOT,.content TR,.content TD,.content P{
                font-size:11pt !important;
                font-family: calibri !important;
                color:black !important;
            }
            .content .judulcontent{
                font-size:12pt !important;
                font-family: calbiri_b !important;
                color:black !important;
                font-weight:bold !important;
                text-align:center !important;
            }
            .header .judulcontent{
                font-size:12pt !important;
                font-family: calbiri_b !important;
                color:black !important;
                font-weight:bold !important;
                text-align:center !important;
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
