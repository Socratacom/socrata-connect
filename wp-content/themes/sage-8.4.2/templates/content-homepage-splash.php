<section class="video-hero">
    <div class="text">
        <div class="vertical-center">
            <div class="container">
                <div class="row">
                    <div class="col-sm-10 col-sm-offset-1">
                        <div class="logo-connect-2018"></div>
                        <h2 class="text-center color-white">May 16-18, 2018, Austin Hilton, Austin TX</h2>
                        <p class="lead text-center color-white">Save Your Seat and <strong>save 20%</strong> off your ticket</p>
                        <ul class="cta-buttons">
                            <li><a href="#" class="btn btn-default btn-outline">Save my Seat</a></li>
                            <li><a href="https://www.youtube.com/watch?v=pnhQHbe_QHg" class="btn btn-default btn-outline">Watch Video</a></li>

                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="footer">
        <ul>
            <li><a href="http://www3.hilton.com/en/hotels/texas/hilton-austin-AUSCVHH/index.html" target="_blank">Venue</a></li>
            <li><a href="/connect-2017">Last Year's Event</a></li>
        </ul>
        <p class="text-center margin-bottom-0"><a href="https://socrata.com" class="footer-logo" target="_blank"></a></p>
    </div>
    <div id="myvideo" class="image" style="background-image:url(/wp-content/uploads/home-cover.jpg);"></div>
    <div id="video" class="player" data-property="{videoURL:'pnhQHbe_QHg',containment:'#myvideo', showControls:false, autoPlay:true, loop:true, mute:true, startAt:17, stopAt:26, opacity:1, addRaster:true, quality:'default'}"></div>
    <script>jQuery(function(e){e("#video").YTPlayer()});</script>
</section>
<?php echo do_shortcode("[youtube-modal]"); ?>