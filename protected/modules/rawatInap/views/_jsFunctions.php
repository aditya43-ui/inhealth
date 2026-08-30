<script>
// untuk me-resize ukuran dalog box
    function resetIframe(obj) {
        obj.style.height = 10 + 'px';
    }
    function autoResizeIframe(obj,id){
            var frameObj = document.getElementById(id);
            resetIframe(frameObj);
            obj.style.height = (obj.contentWindow.document.body.scrollHeight) + 'px';
    }    
</script>