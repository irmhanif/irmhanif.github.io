<?php
/**
 * @version    CVS: 1.0.0
 * @package    Com_Document
 * @author     Subash R <subash.zinavo@gmail.com>
 * @copyright  2019 Subash R
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */
// No direct access
defined('_JEXEC') or die;

JHtml::addIncludePath(JPATH_COMPONENT . '/helpers/html');
JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');
// JHtml::_('formbehavior.chosen', 'select');
JHtml::_('behavior.keepalive');

// Import CSS
$document = JFactory::getDocument();
$document->addStyleSheet(JUri::root() . 'media/com_document/css/form.css');
$db = JFactory::getDbo();

 	$cuid=$this->item->id;
 echo	$t=$this->item->t;
 	
	if($cuid)
	{
		$sql_getdid="SELECT * FROM `#__document_communication` WHERE state=1 AND id=$cuid";
		$db->setQuery($sql_getdid);
		$sql_getdid_res=$db->loadObjectList();
		foreach ($sql_getdid_res as $getdid_det)
		   $user_id=$getdid_det->user_id;
		   $quote=$getdid_det->quote;
		   $t=$getdid_det->t;
	} else {
		$user_id='';
		$quote='';
		$t='';
	}

?>
<script type="text/javascript">
	js = jQuery.noConflict();
	js(document).ready(function () {

	});

	Joomla.submitbutton = function (task) {
		if (task == 'communication.cancel') {
			Joomla.submitform(task, document.getElementById('communication-form'));
		}
		else {

			if (task != 'communication.cancel' && document.formvalidator.isValid(document.id('communication-form'))) {

				Joomla.submitform(task, document.getElementById('communication-form'));
			}
			else {
				alert('<?php echo $this->escape(JText::_('JGLOBAL_VALIDATION_FORM_FAILED')); ?>');
			}
		}
	}
</script>

<form
	action="<?php echo JRoute::_('index.php?option=com_document&layout=edit&id=' . (int) $this->item->id); ?>"
	method="post" enctype="multipart/form-data" name="adminForm" id="communication-form" class="form-validate">

	<div class="form-horizontal">
		<?php echo JHtml::_('bootstrap.startTabSet', 'myTab', array('active' => 'general')); ?>

		<?php echo JHtml::_('bootstrap.addTab', 'myTab', 'general', JText::_('COM_DOCUMENT_TITLE_COMMUNICATION', true)); ?>
		<div class="row-fluid">
			<div class="span10 form-horizontal">
				<fieldset class="adminform">

									<input type="hidden" name="jform[id]" value="<?php echo $this->item->id; ?>" />
				<input type="hidden" name="jform[ordering]" value="<?php echo $this->item->ordering; ?>" />
				<input type="hidden" name="jform[state]" value="<?php echo $this->item->state; ?>" />
				<input type="hidden" name="jform[checked_out]" value="<?php echo $this->item->checked_out; ?>" />
				<input type="hidden" name="jform[checked_out_time]" value="<?php echo $this->item->checked_out_time; ?>" />

				<?php echo $this->form->renderField('created_by'); ?>
				<?php echo $this->form->renderField('modified_by'); ?>
			      <div class="control-group">
					<div class="control-label">
						<label id="jform_user_id-lbl" for="jform_user_id"> User name</label>
					</div>
					<div class="controls">
						<select id="jform_user_id" name="jform[user_id]">
							<option value="" selected="selected">select user</option>
							<?php
							$sql="SELECT * FROM `#__users` WHERE block=0 AND id!=726 AND id IN (SELECT uid FROM `#__semicustomized_order`) || id IN (SELECT uid FROM `#__customized_order`) || id IN (SELECT uid FROM `#__fixed_trip_orders`)";
				        	$db->setQuery($sql);
				        	$alluser_details=$db->loadObjectList();

							foreach ($alluser_details as $alluser_disp) {
								$u_id=$alluser_disp->id;
								$user_name=$alluser_disp->name;
								$user_number=$alluser_disp->username;
								echo '<option value="'.$u_id.'">'.$user_name.'-'.$user_number.'</option>';
								}
							?>
						</select>
					</div>
				</div>
				<input id="jform_t" name="jform[t]" value="<?php echo $t; ?>" type="hidden">
				<?php echo $this->form->renderField('quote'); ?>

				<?php echo $this->form->renderField('title1'); ?>
				<?php echo $this->form->renderField('document1'); ?>

				<?php if (!empty($this->item->document1)) : ?>
					<?php $document1Files = array(); ?>
					<?php foreach ((array)$this->item->document1 as $fileSingle) : ?>
						<?php if (!is_array($fileSingle)) : ?>
							<a href="<?php echo JRoute::_(JUri::root() . 'images/document1' . DIRECTORY_SEPARATOR . $fileSingle, false);?>"><?php echo $fileSingle; ?></a> |
							<?php $document1Files[] = $fileSingle; ?>
						<?php endif; ?>
					<?php endforeach; ?>
					<input type="hidden" name="jform[document1_hidden]" id="jform_document1_hidden" value="<?php echo implode(',', $document1Files); ?>" />
				<?php endif; ?>				<?php echo $this->form->renderField('title2'); ?>
				<?php echo $this->form->renderField('document2'); ?>

				<?php if (!empty($this->item->document2)) : ?>
					<?php $document2Files = array(); ?>
					<?php foreach ((array)$this->item->document2 as $fileSingle) : ?>
						<?php if (!is_array($fileSingle)) : ?>
							<a href="<?php echo JRoute::_(JUri::root() . 'images/document2' . DIRECTORY_SEPARATOR . $fileSingle, false);?>"><?php echo $fileSingle; ?></a> |
							<?php $document2Files[] = $fileSingle; ?>
						<?php endif; ?>
					<?php endforeach; ?>
					<input type="hidden" name="jform[document2_hidden]" id="jform_document2_hidden" value="<?php echo implode(',', $document2Files); ?>" />
				<?php endif; ?>				<?php echo $this->form->renderField('title3'); ?>
				<?php echo $this->form->renderField('document3'); ?>

				<?php if (!empty($this->item->document3)) : ?>
					<?php $document3Files = array(); ?>
					<?php foreach ((array)$this->item->document3 as $fileSingle) : ?>
						<?php if (!is_array($fileSingle)) : ?>
							<a href="<?php echo JRoute::_(JUri::root() . 'images/document3' . DIRECTORY_SEPARATOR . $fileSingle, false);?>"><?php echo $fileSingle; ?></a> |
							<?php $document3Files[] = $fileSingle; ?>
						<?php endif; ?>
					<?php endforeach; ?>
					<input type="hidden" name="jform[document3_hidden]" id="jform_document3_hidden" value="<?php echo implode(',', $document3Files); ?>" />
				<?php endif; ?>				<?php echo $this->form->renderField('title4'); ?>
				<?php echo $this->form->renderField('document4'); ?>

				<?php if (!empty($this->item->document4)) : ?>
					<?php $document4Files = array(); ?>
					<?php foreach ((array)$this->item->document4 as $fileSingle) : ?>
						<?php if (!is_array($fileSingle)) : ?>
							<a href="<?php echo JRoute::_(JUri::root() . 'images/document4' . DIRECTORY_SEPARATOR . $fileSingle, false);?>"><?php echo $fileSingle; ?></a> |
							<?php $document4Files[] = $fileSingle; ?>
						<?php endif; ?>
					<?php endforeach; ?>
					<input type="hidden" name="jform[document4_hidden]" id="jform_document4_hidden" value="<?php echo implode(',', $document4Files); ?>" />
				<?php endif; ?>				<?php echo $this->form->renderField('title5'); ?>
				<?php echo $this->form->renderField('document5'); ?>

				<?php if (!empty($this->item->document5)) : ?>
					<?php $document5Files = array(); ?>
					<?php foreach ((array)$this->item->document5 as $fileSingle) : ?>
						<?php if (!is_array($fileSingle)) : ?>
							<a href="<?php echo JRoute::_(JUri::root() . 'images/document5' . DIRECTORY_SEPARATOR . $fileSingle, false);?>"><?php echo $fileSingle; ?></a> |
							<?php $document5Files[] = $fileSingle; ?>
						<?php endif; ?>
					<?php endforeach; ?>
					<input type="hidden" name="jform[document5_hidden]" id="jform_document5_hidden" value="<?php echo implode(',', $document5Files); ?>" />
				<?php endif; ?>				<?php echo $this->form->renderField('title6'); ?>
				<?php echo $this->form->renderField('document6'); ?>

				<?php if (!empty($this->item->document6)) : ?>
					<?php $document6Files = array(); ?>
					<?php foreach ((array)$this->item->document6 as $fileSingle) : ?>
						<?php if (!is_array($fileSingle)) : ?>
							<a href="<?php echo JRoute::_(JUri::root() . 'images/document6' . DIRECTORY_SEPARATOR . $fileSingle, false);?>"><?php echo $fileSingle; ?></a> |
							<?php $document6Files[] = $fileSingle; ?>
						<?php endif; ?>
					<?php endforeach; ?>
					<input type="hidden" name="jform[document6_hidden]" id="jform_document6_hidden" value="<?php echo implode(',', $document6Files); ?>" />
				<?php endif; ?>				<?php echo $this->form->renderField('title7'); ?>
				<?php echo $this->form->renderField('document7'); ?>

				<?php if (!empty($this->item->document7)) : ?>
					<?php $document7Files = array(); ?>
					<?php foreach ((array)$this->item->document7 as $fileSingle) : ?>
						<?php if (!is_array($fileSingle)) : ?>
							<a href="<?php echo JRoute::_(JUri::root() . 'images/document7' . DIRECTORY_SEPARATOR . $fileSingle, false);?>"><?php echo $fileSingle; ?></a> |
							<?php $document7Files[] = $fileSingle; ?>
						<?php endif; ?>
					<?php endforeach; ?>
					<input type="hidden" name="jform[document7_hidden]" id="jform_document7_hidden" value="<?php echo implode(',', $document7Files); ?>" />
				<?php endif; ?>				<?php echo $this->form->renderField('title8'); ?>
				<?php echo $this->form->renderField('document8'); ?>

				<?php if (!empty($this->item->document8)) : ?>
					<?php $document8Files = array(); ?>
					<?php foreach ((array)$this->item->document8 as $fileSingle) : ?>
						<?php if (!is_array($fileSingle)) : ?>
							<a href="<?php echo JRoute::_(JUri::root() . 'images/document8' . DIRECTORY_SEPARATOR . $fileSingle, false);?>"><?php echo $fileSingle; ?></a> |
							<?php $document8Files[] = $fileSingle; ?>
						<?php endif; ?>
					<?php endforeach; ?>
					<input type="hidden" name="jform[document8_hidden]" id="jform_document8_hidden" value="<?php echo implode(',', $document8Files); ?>" />
				<?php endif; ?>				<?php echo $this->form->renderField('title9'); ?>
				<?php echo $this->form->renderField('document9'); ?>

				<?php if (!empty($this->item->document9)) : ?>
					<?php $document9Files = array(); ?>
					<?php foreach ((array)$this->item->document9 as $fileSingle) : ?>
						<?php if (!is_array($fileSingle)) : ?>
							<a href="<?php echo JRoute::_(JUri::root() . 'images/document9' . DIRECTORY_SEPARATOR . $fileSingle, false);?>"><?php echo $fileSingle; ?></a> |
							<?php $document9Files[] = $fileSingle; ?>
						<?php endif; ?>
					<?php endforeach; ?>
					<input type="hidden" name="jform[document9_hidden]" id="jform_document9_hidden" value="<?php echo implode(',', $document9Files); ?>" />
				<?php endif; ?>				<?php echo $this->form->renderField('title10'); ?>
				<?php echo $this->form->renderField('document10'); ?>

				<?php if (!empty($this->item->document10)) : ?>
					<?php $document10Files = array(); ?>
					<?php foreach ((array)$this->item->document10 as $fileSingle) : ?>
						<?php if (!is_array($fileSingle)) : ?>
							<a href="<?php echo JRoute::_(JUri::root() . 'images/document10' . DIRECTORY_SEPARATOR . $fileSingle, false);?>"><?php echo $fileSingle; ?></a> |
							<?php $document10Files[] = $fileSingle; ?>
						<?php endif; ?>
					<?php endforeach; ?>
					<input type="hidden" name="jform[document10_hidden]" id="jform_document10_hidden" value="<?php echo implode(',', $document10Files); ?>" />
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
   jQuery(document).ready(function(){
       
   		var uid = "<?php echo $user_id; ?>";
   		if(uid!=''){
   		    jQuery.post("index.php?option=com_document&task=communications.documentUpdate&uid="+uid,displayQuote);
   		}
   		
   		jQuery("#jform_user_id").change(function(){
   		    var uid =jQuery(this).val();
			jQuery.post("index.php?option=com_document&task=communications.documentUpdate&uid="+uid,displayQuote);
   		});
   		function displayQuote(stext,status){
	   		if(status=="success"){
		    jQuery("#jform_quote").html(stext);
		    /* selected == to selected */
		    
			  var quote="<?php echo $quote; ?>";
			  var splt_selectitem= quote.split(',');
			  var cnt=splt_selectitem.length;
				for(var i=0;i<cnt;i++) {
					jQuery("#jform_quote option").each(function() {
						var cac=splt_selectitem[i];
						if( jQuery(this).val() == cac ) {
							jQuery(this).attr("selected","selected");
						}
					});
				}
	    	}
   		}

   		/* get type */

   		jQuery("#jform_quote").change(function(){
   		   var label=jQuery('#jform_quote :selected').parent().attr('label');
   		   jQuery("#jform_t").val(label);
   		});

   });
</script>

<script>
	jQuery.noConflict();
	jQuery(document).ready(function(){
	/* selected == to selected */
		var uid="<?php echo $user_id; ?>";
		var splt_selectitem= uid.split(',');
		var cnt=splt_selectitem.length;
		for(var i=0;i<cnt;i++) {
			jQuery("#jform_user_id option").each(function() {
				var cac=splt_selectitem[i];
				if( jQuery(this).val() == cac ) {
					jQuery(this).attr("selected","selected");
				}
			});
		}
	});
</script>

