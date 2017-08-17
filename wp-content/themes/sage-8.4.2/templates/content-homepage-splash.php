<section class="video-hero">
    <div class="text">
        <div class="vertical-center">
            <div class="container">
                <div class="row">
                    <div class="col-sm-10 col-sm-offset-1">
                        <div class="logo-connect-2018" style="margin-bottom:15px;"></div>
                        <h2 class="text-center color-white" style="margin-bottom:30px; line-height: 1.2em;">May 16-18, 2018, Hilton, Austin TX<br>Co-hosted by the City of Austin</h2>
                        <ul class="cta-buttons" style="margin-bottom:15px;">
                            <li><button type="button" class="btn btn-default btn-outline" data-toggle="modal" data-target="#myModal">Save my Seat</button></li>
                            <li><a href="https://www.youtube.com/watch?v=pnhQHbe_QHg" class="btn btn-default btn-outline">Show Me More</a></li>
                        </ul>                        
                        <p class="text-center color-white">Save Your Seat and <strong>save 20%</strong> off your ticket</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="footer">
        <ul>
            <li><a href="http://www3.hilton.com/en/hotels/texas/hilton-austin-AUSCVHH/index.html" target="_blank">Venue</a></li>
            <li><a href="/connect-2017">Last Year's Event</a></li>            
            <li><a href="http://www.austintexas.gov/" target="_blank">City of Austin</a></li>
        </ul>
        <ul>
            <li><a href="https://socrata.com" class="footer-logo-white" target="_blank"></a></li>
        </ul>
    </div>
    <div id="myvideo" class="image" style="background-image:url(/wp-content/uploads/hero-austin.jpg);"></div>
</section>
<?php echo do_shortcode("[youtube-modal]"); ?>
<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content" style="border-radius:0;">
      <div class="modal-header" style="border:0;">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body">
        <div class="padding-30">
            <h3>Save my seat</h3>
            <p>Fill out the form below to save your seat at Socrata Connect and get 20% off your ticket when registration opens.</p>        
            <iframe id="formIframe" style="width: 100%; border: 0;" src="https://go.pardot.com/l/303201/2017-08-15/gfsf" scrolling="no"></iframe>
            <script>iFrameResize({log:true}, '#formIframe')</script>
        </div>
      </div>
    </div>
  </div>
</div>