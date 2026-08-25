<?php ?>
<html>
    <head>
        <title>Div flutuante centro da tela.</title>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
        <style type="text/css">
            .arrastavel{
                position:relative;
                border:1px solid #000;
                cursor: pointer;
            }
        </style>
        <script type="text/javascript">
            var ie = document.all;
            var nn6 = document.getElementById && !document.all;
            var isdrag = false;
            var x, y;
            var dobj;
            function movemouse(e) {
                if (isdrag) {
                    dobj.style.left = nn6 ? tx + e.clientX - x : tx + event.clientX - x;
                    dobj.style.top = nn6 ? ty + e.clientY - y : ty + event.clientY - y;
                    return false;
                }
            }
            function selectmouse(e) {
                var fobj = nn6 ? e.target : event.srcElement;
                var topelement = nn6 ? "HTML" : "BODY";
                while (fobj.tagName != topelement && fobj.className != "arrastavel") {
                    fobj = nn6 ? fobj.parentNode : fobj.parentElement;
                }
                if (fobj.className == "arrastavel") {
                    isdrag = true;
                    dobj = fobj;
                    tx = parseInt(dobj.style.left + 0);
                    ty = parseInt(dobj.style.top + 0);
                    x = nn6 ? e.clientX : event.clientX;
                    y = nn6 ? e.clientY : event.clientY;
                    document.onmousemove = movemouse;
                    return false;
                }
            }
            document.onmousedown = selectmouse;
            document.onmouseup = new Function("isdrag=false");
        </script>
    </head>
    <!--o elemento BODY por padrão tem posição relativa-->
    <body>
        <div class="arrastavel" style="color: black; width: auto; height:100px;">conteudo movel</div>
    </body>
</html>