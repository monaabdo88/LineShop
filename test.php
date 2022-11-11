<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>jQuery exzoom: Product Carousel Example</title>
<link href="https://www.jqueryscript.net/css/jquerysctipttop.css" rel="stylesheet" type="text/css">
    <!--<script src="js/jquery-1.9.1.min.js"></script>-->
    <link href="https://www.jqueryscript.net/demo/Product-Carousel-Magnifying-Effect-exzoom/jquery.exzoom.css" rel="stylesheet" type="text/css"/>
    <style>
    .hidden { display: none; }
</style>
</head>

<body>
<div id="jquery-script-menu">
<div class="jquery-script-center">
<ul>
<li><a href="https://www.jqueryscript.net/slider/Product-Carousel-Magnifying-Effect-exzoom.html">Download This Plugin</a></li>
<li><a href="https://www.jqueryscript.net/">Back To jQueryScript.Net</a></li>
</ul>
<div class="jquery-script-ads"><script type="text/javascript"><!--
google_ad_client = "ca-pub-2783044520727903";
/* jQuery_demo */
google_ad_slot = "2780937993";
google_ad_width = 728;
google_ad_height = 90;
//-->
</script>
<script type="text/javascript"
src="https://pagead2.googlesyndication.com/pagead/show_ads.js">
</script></div>
<div class="jquery-script-clear"></div>
</div>
</div>
<div class="container">
<h1>jQuery exzoom: Product Carousel Example</h1>
<div class="exzoom hidden" id="exzoom">
    <div class="exzoom_img_box">
        <ul class='exzoom_img_ul'>
            <li><img src="https://picsum.photos/270/270/?random"/></li>
            <li><img src="https://picsum.photos/320/320/?random"/></li>
            <li><img src="https://picsum.photos/600/600/?random"/></li>
            <li><img src="https://picsum.photos/500/500/?random"/></li>
            <li><img src="https://picsum.photos/700/700/?random"/></li>
            <li><img src="https://picsum.photos/310/310/?random"/></li>
            <li><img src="https://picsum.photos/410/410/?random"/></li>
            <li><img src="https://picsum.photos/400/400/?random"/></li>
        </ul>
    </div>
    <div class="exzoom_nav"></div>
    <p class="exzoom_btn">
        <a href="javascript:void(0);" class="exzoom_prev_btn"> < </a>
        <a href="javascript:void(0);" class="exzoom_next_btn"> > </a>
    </p>
</div>
</div>
<script src="https://code.jquery.com/jquery-1.12.4.min.js" integrity="sha384-nvAa0+6Qg9clwYCGGPpDQLVpLNn0fRaROjHqs13t4Ggj3Ez50XnGQqc/r8MhnRDZ" crossorigin="anonymous"></script>
    <script src="https://unpkg.com/imagesloaded@4/imagesloaded.pkgd.min.js"></script>
    <script src="https://www.jqueryscript.net/demo/Product-Carousel-Magnifying-Effect-exzoom/jquery.exzoom.js"></script>
    
<script type="text/javascript">

    $('.container').imagesLoaded( function() {
  $("#exzoom").exzoom({
        autoPlay: false,
    });
  $("#exzoom").removeClass('hidden')
});

</script>

</body>
</html>
