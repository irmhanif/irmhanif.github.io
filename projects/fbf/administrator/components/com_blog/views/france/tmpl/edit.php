<?php
/**
 * @version    CVS: 1.0.0
 * @package    Com_Blog
 * @author     Subash R <subash.zinavo@gmail.com>
 * @copyright  2018 Subash R
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */
// No direct access
defined('_JEXEC') or die;

JHtml::addIncludePath(JPATH_COMPONENT . '/helpers/html');
JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');
//JHtml::_('formbehavior.chosen', 'select');
JHtml::_('behavior.keepalive');
$db = JFactory::getDbo();
 $thisid=$this->item->id;
 
 if($thisid){
    $fbf_tittle="SELECT category FROM `#__blog_france` WHERE state=1 AND id=$thisid";
    $db->setQuery($fbf_tittle);
    $package=$db->loadResult();
}
else{
    $package='';
}

// Import CSS
$document = JFactory::getDocument();
$document->addStyleSheet(JUri::root() . 'media/com_blog/css/form.css');
$db = JFactory::getDbo();
?>
<script type="text/javascript">
	js = jQuery.noConflict();
	js(document).ready(function () {
		
	});

	Joomla.submitbutton = function (task) {
		if (task == 'france.cancel') {
			Joomla.submitform(task, document.getElementById('france-form'));
		}
		else {
			
			if (task != 'france.cancel' && document.formvalidator.isValid(document.id('france-form'))) {
				
				Joomla.submitform(task, document.getElementById('france-form'));
			}
			else {
				alert('<?php echo $this->escape(JText::_('JGLOBAL_VALIDATION_FORM_FAILED')); ?>');
			}
		}
	}
</script>

<form
	action="<?php echo JRoute::_('index.php?option=com_blog&layout=edit&id=' . (int) $this->item->id); ?>"
	method="post" enctype="multipart/form-data" name="adminForm" id="france-form" class="form-validate">

	<div class="form-horizontal">
		<?php echo JHtml::_('bootstrap.startTabSet', 'myTab', array('active' => 'general')); ?>

		<?php echo JHtml::_('bootstrap.addTab', 'myTab', 'general', JText::_('COM_BLOG_TITLE_FRANCE', true)); ?>
		<div class="row-fluid">
			<div class="span10 form-horizontal">
				<fieldset class="adminform">

									<input type="hidden" name="jform[id]" value="<?php echo $this->item->id; ?>" />
				<input type="hidden" name="jform[ordering]" value="<?php echo $this->item->ordering; ?>" />
				<input type="hidden" name="jform[state]" value="<?php echo $this->item->state; ?>" />
				<input type="hidden" name="jform[checked_out]" value="<?php echo $this->item->checked_out; ?>" />
				<input type="hidden" name="jform[checked_out_time]" value="<?php echo $this->item->checked_out_time; ?>" />

				<?php echo $this->form->renderField('created_by'); ?>
				<?php echo $this->form->renderField('modified_by'); ?>				<?php echo $this->form->renderField('tittle'); ?>
<div class="control-group">
			<div class="control-label"><label id="jform_category-lbl" for="jform_category">
	Category</label>
</div>
		<div class="controls"><select id="jform_category" name="jform[category]">
		
		<option value="">Select category</option>
		<?php
		$sql2="SELECT * FROM `#__blog_category` WHERE state='1'";
		$db->setQuery($sql2);
		$res2=$db->loadObjectList();

		   foreach($res2 as $value)
		        {
			    $category = $value->category;
				$id =$value->id;
				
		 		echo '<option value="'.$id.'">'.$category.'</option>';
		        }
		   ?>

		</select>	
</div>
</div>
				<?php echo $this->form->renderField('short_description'); ?>
				<?php echo $this->form->renderField('description'); ?>
				<?php echo $this->form->renderField('blog_image'); ?>

				<?php if (!empty($this->item->blog_image)) : ?>
					<?php $blog_imageFiles = array(); ?>
					<?php foreach ((array)$this->item->blog_image as $fileSingle) : ?>
						<?php if (!is_array($fileSingle)) : ?>
							<a href="<?php echo JRoute::_(JUri::root() . 'blog_gallery' . DIRECTORY_SEPARATOR . $fileSingle, false);?>"><?php echo $fileSingle; ?></a> | 
							<?php $blog_imageFiles[] = $fileSingle; ?>
						<?php endif; ?>
					<?php endforeach; ?>
					<input type="hidden" name="jform[blog_image_hidden]" id="jform_blog_image_hidden" value="<?php echo implode(',', $blog_imageFiles); ?>" />
				<?php endif; ?>				<?php echo $this->form->renderField('adding_date'); ?>
				<?php echo $this->form->renderField('banner'); ?>

				<?php if (!empty($this->item->banner)) : ?>
					<?php $bannerFiles = array(); ?>
					<?php foreach ((array)$this->item->banner as $fileSingle) : ?>
						<?php if (!is_array($fileSingle)) : ?>
							<a href="<?php echo JRoute::_(JUri::root() . 'blog_banner' . DIRECTORY_SEPARATOR . $fileSingle, false);?>"><?php echo $fileSingle; ?></a> | 
							<?php $bannerFiles[] = $fileSingle; ?>
						<?php endif; ?>
					<?php endforeach; ?>
					<input type="hidden" name="jform[banner_hidden]" id="jform_banner_hidden" value="<?php echo implode(',', $bannerFiles); ?>" />
				<?php endif; ?>

					<?php if ($this->state->params->get('save_history', 1)) : ?>
					<div class="control-group">
						<div class="control-label"><?php echo $this->form->getLabel('version_note'); ?></div>
						<div class="controls"><?php echo $this->form->getInput('version_note'); ?></div>
					</div>
					<?php endif; ?>
				</fieldset>
			</div>
		</div>
		<?php echo JHtml::_('bootstrap.endTab'); ?>

		

		<?php echo JHtml::_('bootstrap.endTabSet'); ?>

		<input type="hidden" name="task" value=""/>
		<?php echo JHtml::_('form.token'); ?>

	</div>
</form>

<script>
jQuery.noConflict();
jQuery(document).ready(function(){

		/* selected == to selected */
		var select_status="<?php echo $package; ?>";
		var splt_selectitem= select_status.split(',');
		var cnt=splt_selectitem.length;
		for(var i=0;i<cnt;i++)
		{
			jQuery("#jform_category option").each(function()
			{
				var cac=splt_selectitem[i];
				if( jQuery(this).val() == cac )
				{
					jQuery(this).attr("selected","selected");
				}
			});
		}
});
		</script>