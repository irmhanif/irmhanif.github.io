<?php
/**
 * @copyright	Copyright (c) 2019 mod. All rights reserved.
 * @license		http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

// no direct access
defined('_JEXEC') or die;
$db = JFactory::getDbo();
?>
<script src="addons/owl/jquery.min.js"></script>
<script src="addons/owl/owl.carousel.js"></script>
<div id="para-sec">
    <div class="moduletable-partn">
        <div class="parnt_pagetravel">
            <h1><a href="/why-us.html">Our Partners</a></h1>
            <div class="partn_img1">
                <ul class="owl-carouseb">
                    <?php
                    $query = "SELECT * FROM `#__partners` WHERE state=1";
                    $db->setQuery($query);
                    $re = $db->loadObjectList();
                    foreach ($re as $res) {
                        $logo = $res->logo;
                        echo '<li><img class="partner_im" src="' . JURI::root() . 'partners/' . $logo . '"></li>';
                    }
                    ?>

                </ul>
            </div>
 <?php
                    $query = "SELECT COUNT(id) FROM `#__media_coverage` WHERE state=1";
                    $db->setQuery($query);
                    $res = $db->loadResult();
            if($res!=0) {
                    ?>
            <h1><a href="/why-us.html">Media Coverage</a></h1>
            <div class="partn_img1">
                <ul class="owl-carouseb">
                    <?php
                    $query = "SELECT * FROM `#__media_coverage` WHERE state=1";
                    $db->setQuery($query);
                    $re = $db->loadObjectList();
                    foreach ($re as $res) {
                        $image = $res->image;
                        $link = $res->link;
                        echo '<li><a target="_blank" href="' . $link . '"><img class="media_cov" src="' . JURI::root() . 'Cover Image/' . $image . '"></a></li>';
                    }
                    ?>
                </ul>
            </div>
            <?php 
            }
            ?>
            <h1><a href="/travel-stories.html">Travel Stories</a></h1>
            <div class="partn_img1">
                <?php
                $sqlc = "SELECT * FROM `#__customer_rev1ews`  WHERE state=1 AND test=1 ORDER BY id DESC";
                $db->setQuery($sqlc);
                $users_detailc = $db->loadObjectList();

                foreach ($users_detailc as $key => $user_dispc) {
                    $username = $user_dispc->uid;
                    $created_by = $user_dispc->created_by;
                    $reviewtext = $user_dispc->reviewtext;
                    $image = $user_dispc->image;
                    $tittle = $user_dispc->tittle;
                    $author_name = $user_dispc->author_name;
                    echo '<div class="rev_sbox">
                            <div class="reb_box">
                                <span class="re_ti"><span class="wer_ti">' . $tittle . '</span><span class="aur_name"> - ' . $author_name . '</span></span>
                                
                                <span class="rev_img">';
                    if ($created_by == 726) {
                        echo '<img src="' . JURI::root() . 'review_gallery/' . $image . '">';
                    } else {
                        echo '<img src="' . JURI::root() . 'review/' . $username . '/' . $image . '">';
                    }
                    $reviewtext= implode(' ', array_slice(explode(' ', $reviewtext), 0, 32))."\n";
                    $reviewtext = "$reviewtext ...";
                    echo '</span>
                    <div class="bl_bo_re">
                    <div class="revw_txt">' . $reviewtext . '</div>
                                <div><span class="wer_ti">' . $tittle . '</span>
                                <span class="aur_name"> - ' . $author_name . '</span></div>
                            </div>
                        </div>
                        </div>';
                }
                ?>
            </div>
        </div>
    </div>
</div>

<script>
var firstjq = jQuery.noConflict();
firstjq(document).ready(function() {
    var owl = firstjq('.owl-carouseb');
    owl.owlCarousel({
        items: 1,
        margin: 10,
        autoplay: true,
        autoPlay: 4000, //Set AutoPlay to 3 seconds
        dots: false,
        autoplayTimeout: 4000,
        autoplayHoverPause: true,
        loop: true,
        responsive: {
            300: {
                items: 1,
            },
            320: {
                items: 1,
            },
            480: {
                items: 1,
            },
            720: {
                items: 3,
            },
            1000: {
                items: 3,
            }
        }
    });
});
</script>