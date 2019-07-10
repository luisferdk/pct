<p>&nbsp;</p>
<footer class="container">

</footer><!-- /container -->

<!-- Jquery, of course -->
<script src="/js/jquery.js?v=2" type="text/javascript"></script>
  
<!-- Bootstrap -->
<script src="/js/bootstrap.js" type="text/javascript"></script>

<!-- Javascript Effects -->
<script src="/js/bootstrap-datepicker.js" type="text/javascript"></script><!-- needed for shopping cart -->
<script src="/js/chosen.jquery.min.js" type="text/javascript"></script> <!-- search drop down lists -->

<!-- Required field form helper -->
<script src="/js/required_fields.js" type="text/javascript"></script> 

<script type="text/javascript">
$(document).ready(function() {
  
// Twitter Bootstrap Tooltips	
$("[rel=tooltip]").tooltip();

// Chosen for modern select box
$(".chosen-select").chosen();

$('.datepicker').datepicker({
  autoclose : true,
    startDate:"+1d",
    todayBtn: true,
    multidate: false,
    todayHighlight: true,			
  format: 'mm-dd-yyyy'
    });

});

    $(".readonly").keydown(function(e){
        e.preventDefault();
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