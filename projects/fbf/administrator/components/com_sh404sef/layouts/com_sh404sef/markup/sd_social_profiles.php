<?php
/**
 * sh404SEF - SEO extension for Joomla!
 *
 * @author      Yannick Gaultier
 * @copyright   (c) Yannick Gaultier - Weeblr llc - 2018
 * @package     sh404SEF
 * @license     http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @version     4.13.2.3783
 * @date        2018-01-25
 */

/**
 * Input:
 *
 * 'entity_type'
 * 'entity_url'
 * 'entity_name'
 * 'profiles'
 */
// Security check to ensure this file is being included by a parent file.
defined('_JEXEC') or die();

$displayData['sameAs'] = array();
foreach ($displayData['profiles'] as $profile)
{
	$displayData['sameAs'][] = $profile;
}
unset($displayData['profiles']);
?>
<!-- Google social profiles markup-->
<script type="application/ld+json">
<?php echo ShlSystem_Convert::jsonEncode($displayData); ?>

</script>
<!-- End of Google social profiles markup-->
