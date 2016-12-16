<footer class="section-padding">
  <div class="container">
  	<div class="row">
  		<div class="col-sm-12">
  			<p class="text-center margin-bottom-0"><a href="https://socrata.com" class="footer-logo" target="_blank"></a></p>
  			<p class="text-center"><small>&copy; <?php echo date("Y");?> Socrata. All rights reserved.</small></p>
  			<h4 class="text-center text-uppercase">#socrataconnect</h4>
  		</div>
  	</div>    
  </div>
</footer>
<script>
    var menuRight = document.getElementById( 'side-panel' ),
        body = document.body;           
    showRight.onclick = function() {
        classie.toggle( this, 'active' );
        classie.toggle( menuRight, 'cbp-spmenu-open' );
        disableOther( 'showRight' );
    };
    function disableOther( button ) {
        if( button !== 'showRight' ) {
            classie.toggle( showRight, 'disabled' );
        }
    }
</script>
