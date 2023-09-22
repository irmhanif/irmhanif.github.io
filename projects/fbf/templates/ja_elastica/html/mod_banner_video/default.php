<?php
/**
 * @copyright	Copyright (c) 2018 mod_. All rights reserved.
 * @license		http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

// no direct access
defined('_JEXEC') or die;
?>

<style>
  .video-parent-class {
    margin: 0 auto;
}
.pause-play-img {
            position: absolute;
            z-index: 99;
            left: 50%;
            display: none;
            opacity: 0.4;
            width: 64px;
        }

        .video-parent-class:hover img.pause-play-img {
            display: block;
        }

        .video-parent-class {
            position: relative;
        }

        /*Floating CSS Start*/

        @keyframes fade-in-up {
            0% {
                opacity: 0;
            }
            100% {
                transform: translateY(0);
                opacity: 1;
            }
        }

        .stuck {
            position: fixed;
            bottom: 20px;
            right: 20px;
            transform: translateY(100%);
            width: 260px;
            height: 145px;
            animation: fade-in-up .25s ease forwards;
            z-index: 999;
        }

        /*Floating CSS End*/
p.scrolldown {
    width: 200px;
    font-size: 20px;
    font-weight: bold;
    text-align: center;
    border: 1px solid;
    background: #ff7037;
    position: fixed;
    right: 75px;
    color: #fff;
    -webkit-animation-name: example; /* Safari 4.0 - 8.0 */
    -webkit-animation-duration: 4s; /* Safari 4.0 - 8.0 */
    animation-name: example;
    animation-duration: 2s;
}
.container-fluid {
    width: 100%;
}
.col-md-12 {
    padding-left: 0;
}
.col-md-4 {
    /* border: 1px solid; */
    padding: 13px;
    margin: 1%;
    height: 230px;
    width: 30%;
    max-width: 30%;
}
.first .col-md-4{
  background: #a72727;
}
.second .col-md-4{
  background: #313192;
}
.third .col-md-4{
 background: #31926a;
}
.fourth .col-md-4{
 background: #839231;
} 

.video-parent-class {
	width: 100% !important;
	float: left;
}
.container-fluid {
	padding-right: 0px !important;
	padding-left: 0px !important;
	margin-right: auto;
	margin-left: auto;
}
  </style>
  
		<div class="banner_video">
      <video width="100%" autoplay>
				 <source src="images/banner3.mp4" type="video/mp4" /></video></div>
			</video>
		</div>
		<!--<div class="banner-above1"><img class="imge-arc" src="images/animaa.png" /></div>-->

  <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js'></script>

  

    <script>
	var plugin_url = "https://plugins.svn.wordpress.org/play-pause-button-for-video/trunk";
  jQuery(document).ready(function() {
                if (jQuery("video").length > 0) {
                  jQuery("video").wrap("<div class='video-parent-class'></div>");
                  /*Add image just before to vedio  */
                    jQuery("<img class='pause-play-img' src='" + plugin_url + "/img/img01.png' >").insertBefore("video");
    jQuery("video").each(function(index) {
        /*vedio parent div height width code*/
                        var vedio_width = jQuery(this).width();
                        var vedio_height = jQuery(this).height();
                        jQuery(".video-parent-class").css({
                            "width": vedio_width + "px",
                            "height": vedio_height + "px"
                        });

                        /*Pause Play image, middle width in vedio code*/
                        var half_width_vedio = vedio_width / 2;
                        var middle_object_width = half_width_vedio - 32;
                        jQuery(".pause-play-img").css({
                            "left": middle_object_width + "px"
                        });

                        /*Pause Play image middle height in vedio code*/
                        var half_height_vedio = vedio_height / 2;
                        var middle_object_heigh = half_height_vedio - 32;
                        jQuery(".pause-play-img").css({
                            "top": middle_object_heigh + "px"
                        });

                        /*Pause play and image src change code*/
                        jQuery(this).on("click", function() {
                            if (this.paused) {
                                this.play();
                                jQuery(this).prev().attr("src", plugin_url + "/img/img02.png");
                            } else {
                                this.pause();
                                jQuery(this).prev().attr("src", plugin_url + "/img/img01.png");
                            }
                        });


                        /*pause play image click vedio on off functionlity code*/
                        jQuery(this).prev().on("click", function() {
                            var myVideo = jQuery(this).next()[0];
                            if (myVideo.paused) {

                                myVideo.play();
                                jQuery(this).attr("src", plugin_url + "/img/img02.png");
                            } else {

                                myVideo.pause();
                                jQuery(this).attr("src", plugin_url + "/img/img01.png");
                            }
                        });
                        /*Floating js for HTML Video Start*/
        var windows = jQuery(window);
                        var videoWrap = jQuery(this).parent();
                        var video = jQuery(this);
                        var videoHeight = video.outerHeight();
                        var videoElement = video.get(0);
                        windows.on('scroll', function() {
                            var windowScrollTop = windows.scrollTop();
                            var videoBottom = videoHeight + videoWrap.offset().top;
                            //alert(videoBottom);
                            
                                if ((windowScrollTop > videoBottom)) {
                                  if (!videoElement.paused) {
                                      videoWrap.height(videoHeight);
                                      video.addClass('stuck');
                                      if (video.hasClass('stuck')) {
                                        video.attr("controls","1");
                                      }
                                      video.prev().attr("src", plugin_url + "/img/img02.png");
                          jQuery(".scrolldown").css({"display": "none"});          
                                  }
                                  else {
                                      videoWrap.height('auto');
                                      video.removeClass('stuck');
                                      video.removeAttr('controls');
                                      if (videoElement.paused) {
                                        video.prev().attr("src", plugin_url + "/img/img01.png");
                                      }
                                  }

                                } 
                                else {
                                    videoWrap.height('auto');
                                    video.removeClass('stuck');
                                    video.removeAttr('controls');
                                }
                            
                        });
                         /*Floating js for HTML Video End*/
    });
    /*After end vedio change image*/
                    var video = document.getElementsByTagName('video')[0];

                    video.onended = function(e) {
                        jQuery(".pause-play-img").attr("src", plugin_url + "/img/img01.png");
                    };
  }
  });
	</script>