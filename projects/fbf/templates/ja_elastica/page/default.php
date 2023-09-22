<?php
defined('_JEXEC') or die;

$id = JRequest::getVar('Itemid');

if($id=='101') {
    $addclass="homepage";
} else {
    $addclass="innerpage";
}
?>


<?php if ($this->isIE() && ($this->isRTL())) { ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<?php } else { ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php } ?>

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $this->language; ?>" lang="<?php echo $this->language; ?>">

    <head>
        
<script>
    (function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
    new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
    j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
    'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
    })(window,document,'script','dataLayer','GTM-TL74BB4');
</script>

    
    
    <?php //gen head base on theme info
    $this->showBlock ('head');
    ?>

    <?php
    $blocks = T3Common::node_children($this->getBlocksXML ('head'), 'block');
    foreach ($blocks as $block) :
        $this->showBlock ($block);
    endforeach;
    ?>

    <?php echo $this->showBlock ('css') ?>

</head>

  <link href="https://fonts.googleapis.com/css?family=Lato:300" rel="stylesheet"> 
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
  <script  src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script  src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>

<body id="bd" class="<?php if (!T3Common::mobile_device_detect()):?>bd<?php echo $id ;?><?php endif;?> <?php echo $this->getBodyClass(); echo $addclass?>" >
    
<a name="Top" id="Top"></a>
<div id="ja-wrapper">

	<?php
	$blks = &$this->getBlocksXML ('top');
	$blocks = &T3Common::node_children($blks, 'block');
	foreach ($blocks as $block) :
			$this->showBlock ($block);
	endforeach;
	?>
<?php if ($this->countModules( 'banner-section' )) : ?>
                        <div id="banner-section">
                        <jdoc:include type="modules" name="banner-section" style="xhtml" />
                        </div>
                        <?php endif; ?>
<?php if ($this->countModules( 'whytravel-section' )) : ?>
                        <div id="whytravel-section">
                        <jdoc:include type="modules" name="whytravel-section" style="xhtml" />
                        </div>
                        <?php endif; ?>
<?php if ($this->countModules( 'abt_home' )) : ?>
                        <div id="abt_home">
                        <jdoc:include type="modules" name="abt_home" style="xhtml" />
                        </div>
                        <?php endif; ?>
<?php if ($this->countModules( 'trip-section' )) : ?>
                        <div id="trip-section">
                        <jdoc:include type="modules" name="trip-section" style="xhtml" />
                        </div>
                        <?php endif; ?>

	<!-- MAIN CONTAINER -->
	<div id="ja-container" class="wrap <?php echo $this->getColumnWidth('cls_w')?$this->getColumnWidth('cls_w'):'ja-mf'; ?> clearfix">
		<div id="ja-main-wrap" class="main clearfix">
			<div id="ja-main" class="clearfix">
				<?php if (!$this->getParam ('hide_content_block', 0)): ?>
					<div id="ja-content" class="ja-content ja-masonry">
						<?php
						//content-top
						if($this->hasBlock('content-top')) :
						$block = &$this->getBlockXML ('content-top');
						?>
						<div id="ja-content-top" class="ja-content-top clearfix">
							<?php $this->showBlock ($block); ?>
						</div>
						<?php endif; ?>
					
						<div id="ja-content-main" class="ja-content-main clearfix">
							<?php echo $this->loadBlock ('message') ?>
							<?php echo $this->showBlock ('content') ?>
						</div>
						
						<?php
						//content-bottom
						if($this->hasBlock('content-bottom')) :
						$block = &$this->getBlockXML ('content-bottom');
						?>
						<div id="ja-content-bottom" class="ja-content-bottom clearfix">
							<?php $this->showBlock ($block); ?>
						</div>
						<?php endif; ?>
						
					</div>
				<?php endif ?>
				<?php if ($this->hasBlock('right1')):
					$block = &$this->getBlockXML('right1');
					?>
					
						<?php $this->showBlock ($block); ?>
					
				<?php endif ?>
			</div>
			<?php if ($this->hasBlock('right2')):
				$block = &$this->getBlockXML('right2');
				?>
					<?php $this->showBlock ($block); ?>
			<?php endif ?>			
		</div>
	</div>
    <!-- //MAIN CONTAINER -->

    <?php
    $blks = &$this->getBlocksXML ('bottom');
    $blocks = &T3Common::node_children($blks, 'block');
    foreach ($blocks as $block) :
        if (T3Common::getBrowserSortName() == 'ie' && T3Common::getBrowserMajorVersion() == 7) echo "<br class=\"clearfix\"/>";
        $this->showBlock ($block);
    endforeach;
    ?>

</div>

<?php if ($this->isIE6()) : ?>
    <?php $this->showBlock('ie6/ie6warning') ?>
<?php endif; ?>

<?php $this->showBlock('debug') ?>


<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-TL74BB4"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->

</body>

</html>
