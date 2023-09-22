<?php
/**
 * @version    CVS: 1.0.0
 * @package    Com_Fixed_orders
 * @author     Mohamed Idris <idriswan@gmail.com>
 * @copyright  2019 Mohamed Idris
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
		$user = JFactory::getUser();
	 	$user_id = $user->get('id');
// Import CSS
$document = JFactory::getDocument();
$document->addStyleSheet(JUri::root() . 'media/com_fixed_orders/css/form.css');
$thisid=$this->item->id;
if($thisid) {
    $sql_getplaid="SELECT trip FROM `#__fixed_bc_orders` WHERE state=1 AND id=$thisid";
		$db->setQuery($sql_getplaid);
		$tripvalue=$db->loadResult();
} else {
    $tripvalue='';
}
?>
<script type="text/javascript">
    js = jQuery.noConflict();
    js(document).ready(function() {

    });

    Joomla.submitbutton = function(task) {
        if (task == 'bcorder.cancel') {
            Joomla.submitform(task, document.getElementById('bcorder-form'));
        } else {

            if (task != 'bcorder.cancel' && document.formvalidator.isValid(document.id('bcorder-form'))) {

                Joomla.submitform(task, document.getElementById('bcorder-form'));
            } else {
                alert('<?php echo $this->escape(JText::_('JGLOBAL_VALIDATION_FORM_FAILED')); ?>');
            }
        }
    }

</script>

<form action="<?php echo JRoute::_('index.php?option=com_fixed_orders&layout=edit&id=' . (int) $this->item->id); ?>" method="post" enctype="multipart/form-data" name="adminForm" id="bcorder-form" class="form-validate">

    <div class="form-horizontal">
        <?php echo JHtml::_('bootstrap.startTabSet', 'myTab', array('active' => 'general')); ?>

        <?php echo JHtml::_('bootstrap.addTab', 'myTab', 'general', JText::_('COM_FIXED_ORDERS_TITLE_BCORDER', true)); ?>
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
                        <div class="control-label"><label id="jform_trip-lbl" for="jform_trip">
                                Trip</label>
                        </div>
                        <div class="controls"><select id="jform_trip" name="jform[trip]" >
                            
                            <?php
                            
                            $cat = "SELECT * FROM `#__create_trip` WHERE state=1";
    $db->setQuery($cat);
    $datae = $db->loadObjectList();

                            foreach($datae as $date) {
                                $trip_id=$date->id;
                                $trip_title=$date->title;
                                $date1=$date->date_of_departure1;
                                $date2=$date->date_of_departure2;
                                $date3=$date->date_of_departure3;
                                $date4=$date->date_of_departure4;
                                $date5=$date->date_of_departure5;
                                $date6=$date->date_of_departure6;
                                
                                
                                echo '<optgroup label="' . $trip_title . '">';
                                if($date1!='0000-00-00'){
                               echo '<option value="' . $trip_id . '#'.$date1.'">' . $date1 . '</option>';
                                }
                                if($date2!='0000-00-00'){
                                echo '<option value="' . $trip_id . '#'.$date2.'">' . $date2 . '</option>';
                                }
                                if($date3!='0000-00-00'){
                                echo '<option value="' . $trip_id . '#'.$date3.'">' . $date3 . '</option>';
                                    }
                                if($date4!='0000-00-00'){
                                echo '<option value="' . $trip_id . '#'.$date4.'">' . $date4 . '</option>';
                                    }
                                if($date5!='0000-00-00'){
                                echo '<option value="' . $trip_id . '#'.$date5.'">' . $date5 . '</option>';
                                    }
                                if($date6!='0000-00-00'){
                                echo '<option value="' . $trip_id . '#'.$date6.'">' . $date6 . '</option>';
                                    }
                                
                                }
                                    ?>
                            </select>
                            
                        </div>
                    </div>



                  <!--  <div class="control-group">
                        <div class="control-label"><label id="jform_date-lbl" for="jform_date">
                                Date</label>
                        </div>
                        <div class="controls"><select id="jform_date" name="jform[date]" >
                                <option value="2">2</option>
                            </select>
                            
                        </div>
                    </div>-->
                    <?php echo $this->form->renderField('seat'); ?>


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

        <input type="hidden" name="task" value="" />
        <?php echo JHtml::_('form.token'); ?>

    </div>
</form>
<script>
    jQuery.noConflict();
jQuery(document).ready(function(){

		/* selected == to selected */
		var select_status="<?php echo $tripvalue; ?>";
		var splt_selectitem= select_status.split(',');
		var cnt=splt_selectitem.length;
		for(var i=0;i<cnt;i++)
		{
			jQuery("#jform_trip option").each(function()
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
