</div>
<footer class="container-new-fluid mt-3">
  <div class="container-new">
    <div class="row-new">
      <div class="col-md-4 col-12">
        <h3 class="black">Насчет нас</h3>
        <p class="texto mb-0">Punta Cana Tours принадлежит и управляется компанией Caribbean Dream, туроператором, базирующейся в Пунта-Кана, Доминиканская Республика.</p>
        <a href="/about-us/" class="mt-1 link">Прочитайте больше</a>
      </div>
      <div class="col-md-4 col-12">
        <h3 class="black">гарантия</h3>
        <p class="texto mb-0">Ваше время отпуска ценно, и мы хотим, чтобы вы участвовали во всех веселых турах по Пунта-Кане, которые вы хотите, когда захотите.</p>
        <a href="/guarantee/" class="mt-1 link">Прочитайте больше</a>
      </div>
      <div class="col-md-4 col-12">
        <a href="tel:+18298681353" style="margin:auto;"><img class="img-fluid" style="margin:auto;" src="/img/call-dr-tours.png" alt="Call 1-829-868-1353 Today" /></a>
          <!-- <div class="col-12 mt-3">
            <img class="m-auto img-fluid" src="https://puntacanatours.com/img/credit-cards.png" alt="Paypal Visa Credit Card">
          </div> -->
      </div>
    </div>
  </div>
  <div class="container-new">
    <div class="well-footer">
      <ul class="nav nav-pills footer-links">
          <li><a href="#"><i class="fa fa-copyright"></i> авторское право &copy; <?php echo date('Y');?> </a></li>
          <li><a href="/guarantee/"><i class="fa fa-certificate"></i> Безрисковая гарантия</a></li>
          <li><a href="/sitemap/"><i class="fa fa-road"></i> Карта сайта</a></li>
          <li><a href="#top"><i class="fa fa-arrow-up"></i> Перейти к началу страницы</a></li>
      </ul>
    </div><!-- /well-footer -->
  </div>
</footer>

<!-- Jquery, of course -->
<script src="//puntacanatours-caribbeandream.netdna-ssl.com/js/jquery.js?v=2" type="text/javascript"></script>
  
<!-- Bootstrap -->
<script src="//puntacanatours-caribbeandream.netdna-ssl.com/js/bootstrap.js" type="text/javascript"></script>

<!-- Javascript Effects -->
<!-- <script src="//puntacanatours-caribbeandream.netdna-ssl.com/js/bootstrap-datepicker.js" type="text/javascript"></script><!-- needed for shopping cart -->
<script src="/js/bootstrap-datepicker.js" type="text/javascript"></script><!-- needed for shopping cart -->
<script src="//puntacanatours-caribbeandream.netdna-ssl.com/js/chosen.jquery.min.js" type="text/javascript"></script> <!-- search drop down lists -->
<script src="//puntacanatours-caribbeandream.netdna-ssl.com/js/jquery.fancybox.js" type="text/javascript"></script> <!-- used for galleries -->
<script src="//puntacanatours-caribbeandream.netdna-ssl.com/js/jquery.raty.min.js" type="text/javascript"></script> <!-- star rating for review -->
<script src="//puntacanatours-caribbeandream.netdna-ssl.com/js/jquery.dataTables.min.js" type="text/javascript"></script> <!-- needed for pagination -->

<!-- Required field form helper -->
<script src="//puntacanatours-caribbeandream.netdna-ssl.com/js/required_fields.js" type="text/javascript"></script> 
<script src="/js/modals.js"></script>
<script src="/styles/owl/dist/owl.carousel.min.js"></script>

<?
if(isset($tour_video) && $tour_video != "") 
{
?>
<script> 
function myValidateForm1() {
    var x = document.forms["productForm1"]["product_date"].value;
    if (x == "") {
        alert("Please select the tour date");
        return false;
    }
}
function myValidateForm2() {
    var x = document.forms["productForm2"]["product_date"].value;
    if (x == "") {
        alert("Please select the tour date");
        return false;
    }
}
function myValidateForm3() {
    var x = document.forms["productForm3"]["product_date"].value;
    if (x == "") {
        alert("Please select the tour date");
        return false;
    }
}
function myValidateForm4() {
    var x = document.forms["productForm4"]["product_date"].value;
    if (x == "") {
        alert("Please select the tour date");
        return false;
    }
}


var tag = document.createElement('script'); 
tag.src = "//www.youtube.com/player_api"; 
var firstScriptTag = document.getElementsByTagName('script')[0]; 
firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

var player; 
function onYouTubePlayerAPIReady() { 
player = new YT.Player('player', { 
height: '315', 
width: '560', 
videoId: '<?= $tour_video ?>', 
events: { 
'onReady': onPlayerReady, 
'onStateChange': onPlayerStateChange 
} 
}); 
}

var pauseFlag = false;
function onPlayerReady(event) {
   // do nothing, no tracking needed
}
function onPlayerStateChange(event) {

var videoname = document.getElementById('player').getAttribute( 'name' );
    // track when user clicks to Play
    if (event.data == YT.PlayerState.PLAYING) {
	pauseFlag = true;
//alert('PLAYING '+videoname);
	ga('send', 'event', 'Video', videoname, 'PLAY', getPercentage());
    }
    // track when user clicks to Pause
    if (event.data == YT.PlayerState.PAUSED && pauseFlag) {
	    pauseFlag = false;
//alert('PAUSE '+videoname);
	ga('send', 'event', 'Video', videoname, 'PAUSE', getPercentage());
    }
    // track when video ends
    if (event.data == YT.PlayerState.ENDED) {
//alert('END '+videoname);
	ga('send', 'event', 'Video', videoname, 'ENDED', getPercentage());
    }
}

    function getPercentage()
    {
    var pecentage =((player.getCurrentTime()/player.getDuration())*100).toFixed();
       return pecentage;
	}

</script> 
<?
}
?>

<script type="text/javascript">
$(document).ready(function() {

// fix dropdown menus
$('.dropdown-toggle').dropdown();
  
// Twitter Bootstrap Tooltips	
$("[rel=tooltip]").tooltip();

// Carousel on Fontpage
$('.carousel').carousel();
    
// Fancybox for images
$(".fancybox").fancybox();

// Chosen for modern select box
$(".chosen-select").chosen();

// Star rating system
$('.star').raty({
  readOnly : false,
  score: function() {
    return $(this).attr('data-score');
  }
});
$('.revstar').raty({
  readOnly : true,
  score: function() {
    return $(this).attr('data-score');
  }
});


$('.datepicker').datepicker({
  format: 'mm-dd-yyyy',
    startDate:"+0d",
    todayBtn: false,
    multidate: false,
    autoclose: true,
<?
if(isset($daysOfWeekDisabled))
   {
?>
   daysOfWeekDisabled: "<?= $daysOfWeekDisabled ?>",
<?   
   }
?>	
    todayHighlight: true			
});

$(".datepicker").attr("autocomplete", "off");

$('#example').dataTable( {
        "bPaginate": true,
        "sPaginationType": "full_numbers",
        "bLengthChange": false,
        "bFilter": true,
        "bSort": false,
        "bInfo": false,
        "bAutoWidth": false
    } );


    $(".readonly").keydown(function(e){
        e.preventDefault();
    });

$("form").submit(function(e) {

    var ref = $(this).find("[required]");

    $(ref).each(function(){
        if ( $(this).val() == '' )
        {
            alert("Please fill the required field.");

            $(this).focus();

            e.preventDefault();
            return false;
        }
    });  return true;
});

});	
</script>
<!-- begin olark code -->
<script data-cfasync="false" type='text/javascript'>/*<![CDATA[*/window.olark||(function(c){var f=window,d=document,l=f.location.protocol=="https:"?"https:":"http:",z=c.name,r="load";var nt=function(){
f[z]=function(){
(a.s=a.s||[]).push(arguments)};var a=f[z]._={
},q=c.methods.length;while(q--){(function(n){f[z][n]=function(){
f[z]("call",n,arguments)}})(c.methods[q])}a.l=c.loader;a.i=nt;a.p={
0:+new Date};a.P=function(u){
a.p[u]=new Date-a.p[0]};function s(){
a.P(r);f[z](r)}f.addEventListener?f.addEventListener(r,s,false):f.attachEvent("on"+r,s);var ld=function(){function p(hd){
hd="head";return["<",hd,"></",hd,"><",i,' onl' + 'oad="var d=',g,";d.getElementsByTagName('head')[0].",j,"(d.",h,"('script')).",k,"='",l,"//",a.l,"'",'"',"></",i,">"].join("")}var i="body",m=d[i];if(!m){
return setTimeout(ld,100)}a.P(1);var j="appendChild",h="createElement",k="src",n=d[h]("div"),v=n[j](d[h](z)),b=d[h]("iframe"),g="document",e="domain",o;n.style.display="none";m.insertBefore(n,m.firstChild).id=z;b.frameBorder="0";b.id=z+"-loader";if(/MSIE[ ]+6/.test(navigator.userAgent)){
b.src="javascript:false"}b.allowTransparency="true";v[j](b);try{
b.contentWindow[g].open()}catch(w){
c[e]=d[e];o="javascript:var d="+g+".open();d.domain='"+d.domain+"';";b[k]=o+"void(0);"}try{
var t=b.contentWindow[g];t.write(p());t.close()}catch(x){
b[k]=o+'d.write("'+p().replace(/"/g,String.fromCharCode(92)+'"')+'");d.close();'}a.P(2)};ld()};nt()})({
loader: "static.olark.com/jsclient/loader0.js",name:"olark",methods:["configure","extend","declare","identify"]});
/* custom configuration goes here (www.olark.com/documentation) */
olark.identify('5454-501-10-3463');/*]]>*/</script><noscript><a href="https://www.olark.com/site/5454-501-10-3463/contact" title="Contact us" target="_blank">Questions? Feedback?</a> powered by <a href="http://www.olark.com?welcome" title="Olark live chat software">Olark live chat software</a></noscript>
<!-- end olark code -->
</body>
</html>
<?php
//very end of your page
//$end = microtime(true);
//print "<!-- Page generated in ".round(($end - $start), 4)." seconds -->";
?>


<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-137608233-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-137608233-1');
</script>