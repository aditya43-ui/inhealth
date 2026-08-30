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
    }
</script>
<style>
    body, html {
        margin: 0;
    }
</style>
<body style="background-color: #ffffff;" onload="print_win()">

    <div id="wrapper"> <!-- not necessary -->

        <div class="container" id="page">
            <?php echo $content; ?>
        </div>


</body>