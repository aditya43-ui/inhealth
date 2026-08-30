<head>
    <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/themes/neon/assets/css/font-icons/entypo/css/entypo.css">        
    <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/themes/neon/assets/css/font-icons/font-awesome/css/font-awesome.css">
</head>
<style>
    @page {

        margin-top:0;
        margin-bottom:0;
        margin-left:0;
        margin-right:0;
    }

    @media print {
        tr.page-break  { height:100%; page-break-after: always; }
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
        .header-space{

            height: 1cm;
        }
        .footer-space {
            height: 1cm;
        }   
        div.footer {
            position: fixed;
            bottom: 0;
            float:left;
        }
        .headrtd{
            background-color:#afdc7e !important;


        }

        .footer {
            width: 100%;
            position: fixed;
            bottom: 0;
        }
        #pageFooter:after {
            counter-increment: page;
            content: counter(page);
        }
        .footer{
        height: 40mm;
    }
    #setheader{
        margin-top:-2cm;
      }
    .ttd {
            page-break-inside: avoid;
        }
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
    table li{
        font-size: 12pt !important;
        font-family: Arial !important;
        color:black !important;
    }
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
        text-align:right;

    }
    .control-label .fa{
        padding-top:3px;
        padding-right:3px;


    }
    .controls .fa{
        padding-top:4px;

    }
    body{
        -webkit-print-color-adjust: exact;
    }
    td {
        font-family: "Arial";
        color: black;
        font-size:12pt;
    }
    th {
        font-family: "Arial";
        color: black;
        font-size:12pt;
    }
    p {
        font-family: "Arial", Times, serif;
        font-size:12pt;
    }
    h4 {
        font-family: "Arial", Times, serif;
        font-size:14pt;
    }
    #judul{
        font-size:14pt;
    }
    u {
        font-family: "Arial", Times, serif;
        font-size:12pt;
    }

    .tabel-pemenang{
        color: black;
        font-family: Arial;
        font-size: 12pt;
    }
    .garis {
        border-top: 3px double black;
    }

    blockquote {
        text-align: center;
        border: none;
    }

</style>
</head>
<body>

    <?php
    $format = new MyFormatter;
    ?>
    <table width="100%" style="" id="setheader" >

        <thead>
            <tr>
                <td colspan="3">
                    <div class="header-space">

                    </div>  
                    
                </td>
            </tr>
        </thead>
        <tbody>
            <tr class=''>
                <td>
                    <div class="content"><?php
                        $this->renderPartial('tabel_Print', array('model' => $model, 'modSurat' => $modSurat
                        ));
                        ?>
                    </div>

                </td></tr>

        </tbody>
        <tfoot>
            <tr>
                <td colspan="3">
                    <div class="footer-space">

                    </div>  
                    
                </td>
            </tr>
        </tfoot>
    </table>
    
</body>
</html>
<script>
$( document ).ready(function() {
     $("h3").css("text-align"," center");
     $("h3").css("font-size","12pt");
     $("table tbody").find("table").attr("border", "0");
     $("#settable").attr("border", "1");
     $("table tbody").find("table td").css("vertical-align", "top");
});
</script>