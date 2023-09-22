<?php
/**
 * @version    CVS: 1.0.0
 * @package    Com_Semicustomized
 * @author     Subash R <subash.zinavo@gmail.com>
 * @copyright  2018 Subash R
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */
// No direct access
defined('_JEXEC') or die;

JHtml::addIncludePath(JPATH_COMPONENT . '/helpers/html');
JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');
// JHtml::_('formbehavior.chosen', 'select');
JHtml::_('behavior.keepalive');
$db = JFactory::getDbo();

// Import CSS
$document = JFactory::getDocument();
$document->addStyleSheet(JUri::root() . 'media/com_semicustomized/css/form.css');


 	$cuid=$this->item->id;
	if($cuid) 
	{
		$sql_getplaid="SELECT * FROM `#__semicustomized_plan` WHERE state='1' AND id=$cuid";
		$db->setQuery($sql_getplaid);
		$getplaid_res=$db->loadObjectList();

		foreach($getplaid_res as $getplaid_disp) {
			$days1=$getplaid_disp->days1;
			$days2=$getplaid_disp->days2;
			$days3=$getplaid_disp->days3;
			$days4=$getplaid_disp->days4;
			$days5=$getplaid_disp->days5;
			$days6=$getplaid_disp->days6;
			$days7=$getplaid_disp->days7;
			$days8=$getplaid_disp->days8;
			$days9=$getplaid_disp->days9;
			$days10=$getplaid_disp->days10;
			$days11=$getplaid_disp->days11;
			$days12=$getplaid_disp->days12;
			$days13=$getplaid_disp->days13;
			$days14=$getplaid_disp->days14;
			$days15=$getplaid_disp->days15;
			$days16=$getplaid_disp->days16;
			$days17=$getplaid_disp->days17;
			$days18=$getplaid_disp->days18;
			$days19=$getplaid_disp->days19;
			$days20=$getplaid_disp->days20;
		}
		if($days1=='') {
			$days1='';
		} if($days2=='') {
			$days2='';
		} if($days3=='') {
			$days3='';
		} if($days4=='') {
			$days4='';
		} if($days5=='') {
			$days5='';
		} if($days6=='') {
			$days6='';
		} if($days7=='') {
			$days7='';
		} if($days8=='') {
			$days8='';
		} if($days9=='') {
			$days9='';
		} if($days10=='') {
			$days10='';
		} if($days11=='') {
			$days11='';
		} if($days12=='') {
			$days12='';
		} if($days13=='') {
			$days13='';
		} if($days14=='') {
			$days14='';
		} if($days15=='') {
			$days15='';
		} if($days16=='') {
			$days16='';
		} if($days17=='') {
			$days17='';
		} if($days18=='') {
			$days18='';
		} if($days19=='') {
			$days19='';
		} if($days20=='') {
			$days20='';
		}
	} else {
		$days1=$days2=$days3=$days4=$days5=$days6=$days7=$days8=$days9=$days10=$days11=$days12=$days13=$days14=$days15=$days16=$days17=$days18=$days19=$days20='';
	} 

?>

<script type="text/javascript">
	js = jQuery.noConflict();
	js(document).ready(function () {

	});

	Joomla.submitbutton = function (task) {
		if (task == 'plan.cancel') {
			Joomla.submitform(task, document.getElementById('plan-form'));
		}
		else {

			if (task != 'plan.cancel' && document.formvalidator.isValid(document.id('plan-form'))) {

				Joomla.submitform(task, document.getElementById('plan-form'));
			}
			else {
				alert('<?php echo $this->escape(JText::_('JGLOBAL_VALIDATION_FORM_FAILED')); ?>');
			}
		}
	}
</script>

<form
	action="<?php echo JRoute::_('index.php?option=com_semicustomized&layout=edit&id=' . (int) $this->item->id); ?>"
	method="post" enctype="multipart/form-data" name="adminForm" id="plan-form" class="form-validate">

	<div class="form-horizontal">
		<?php echo JHtml::_('bootstrap.startTabSet', 'myTab', array('active' => 'general')); ?>

		<?php echo JHtml::_('bootstrap.addTab', 'myTab', 'general', JText::_('COM_SEMICUSTOMIZED_TITLE_PLAN', true)); ?>
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

			    <?php echo $this->form->renderField('reference'); ?>
				<?php echo $this->form->renderField('title'); ?>
				<?php echo $this->form->renderField('no_of_days_in_plan'); ?>



<?php
$i=1;
for($i=1;$i<=20;$i++)
{
?>
    <div class="control-group">
    <div class="control-label">
        <label id="jform_days1-lbl" class="hasTooltip" for="jform_days<?php echo $i; ?>" title="" data-original-title="<strong>Day <?php echo $i; ?></strong>"> Day <?php echo $i; ?></label>
    </div>
    <div class="controls">
        <select id="jform_days<?php echo $i; ?>" name="jform[days<?php echo $i; ?>]">
            <option value="">Selecct Any One</option>
            <?php
                $sql="SELECT * FROM `#__semicustomized_days` WHERE state='1'";
            	$db->setQuery($sql);
            	$res=$db->loadObjectList();
                foreach($res as $value)
                 {
                	$reference = $value->reference;
                	$id=$value->id;
                         echo '<option value="'.$id.'">'.$reference.'</option>';

                }
            ?>
        </select>
    </div>
</div>
<?php
}
?>

				<?php echo $this->form->renderField('hoteltitle1'); ?>
				<?php echo $this->form->renderField('hotelprice1'); ?>
				<?php echo $this->form->renderField('extraroom1'); ?>
				<?php echo $this->form->renderField('maxroomcapacity'); ?>
				<?php echo $this->form->renderField('hoteltitle2'); ?>
				<?php echo $this->form->renderField('priceperroom2'); ?>
				<?php echo $this->form->renderField('extraroom2'); ?>
				<?php echo $this->form->renderField('maxroomcapacity2'); ?>
				<?php echo $this->form->renderField('hoteltitle3'); ?>
				<?php echo $this->form->renderField('priceperroom3'); ?>
				<?php echo $this->form->renderField('extraroom3'); ?>
				<?php echo $this->form->renderField('maxroomcapacity3'); ?>
				<?php echo $this->form->renderField('transportpricel1'); ?>
				<?php echo $this->form->renderField('transportcapacity1'); ?>
				<?php echo $this->form->renderField('transportprice2'); ?>
				<?php echo $this->form->renderField('transportcapacity2'); ?>
				<?php echo $this->form->renderField('transportprice3'); ?>
				<?php echo $this->form->renderField('transportcapacity3'); ?>
				<?php echo $this->form->renderField('transportprice4'); ?>
				<?php echo $this->form->renderField('transportcapacity4'); ?>
				<?php echo $this->form->renderField('keeperprice1'); ?>
				<?php echo $this->form->renderField('keepercapacity1'); ?>
				<?php echo $this->form->renderField('Keeperprice2'); ?>
				<?php echo $this->form->renderField('keepercapacity2'); ?>
				<?php echo $this->form->renderField('Keeperpriceday3'); ?>
				<?php echo $this->form->renderField('keepercapacity3'); ?>
				<?php echo $this->form->renderField('Keeperpriceday4'); ?>
				<?php echo $this->form->renderField('price_of_leaving'); ?>
				<?php echo $this->form->renderField('keepercapacity4'); ?>
				<?php echo $this->form->renderField('pricetransfer'); ?>
				<?php echo $this->form->renderField('publictransport'); ?>
				<?php echo $this->form->renderField('bookingtotal'); ?>
				<?php echo $this->form->renderField('insurance'); ?>
				<?php echo $this->form->renderField('priceofact'); ?>
				<?php echo $this->form->renderField('inclusion'); ?>
				<?php echo $this->form->renderField('noinclusion'); ?>

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
		var day1="<?php echo $days1; ?>";
		var splt_selectitem= day1.split(',');
		var cnt=splt_selectitem.length;
		for(var i=0;i<cnt;i++) {
			jQuery("#jform_days1 option").each(function() {
				var cac=splt_selectitem[i];
				if( jQuery(this).val() == cac ) {
					jQuery(this).attr("selected","selected");
				}
			});
		}
		
		/* selected == to selected */
		var day2="<?php echo $days2; ?>";
		var splt_selectitem2= day2.split(',');
		var cnt2=splt_selectitem2.length;
		for(var i=0;i<cnt2;i++) {
			jQuery("#jform_days2 option").each(function() {
				var cac=splt_selectitem2[i];
				if( jQuery(this).val() == cac ) {
					jQuery(this).attr("selected","selected");
				}
			});
		}

		
		/* selected == to selected */
		var day3="<?php echo $days3; ?>";
		var splt_selectitem3= day3.split(',');
		var cnt3=splt_selectitem3.length;
		for(var i=0;i<cnt3;i++) {
			jQuery("#jform_days3 option").each(function() {
				var cac=splt_selectitem3[i];
				if( jQuery(this).val() == cac ) {
					jQuery(this).attr("selected","selected");
				}
			});
		}


		/* selected == to selected */
		var day4 ="<?php echo $days4; ?>";
		var splt_selectitem4= day4.split(',');
		var cnt4=splt_selectitem4.length;
		for(var i=0;i<cnt4;i++) {
			jQuery("#jform_days4 option").each(function() {
				var cac=splt_selectitem4[i];
				if( jQuery(this).val() == cac ) {
					jQuery(this).attr("selected","selected");
				}
			});
		}


		/* selected == to selected */
		var day5 ="<?php echo $days5; ?>";
		var splt_selectitem5= day5.split(',');
		var cnt5=splt_selectitem5.length;
		for(var i=0;i<cnt5;i++) {
			jQuery("#jform_days5 option").each(function() {
				var cac=splt_selectitem5[i];
				if( jQuery(this).val() == cac ) {
					jQuery(this).attr("selected","selected");
				}
			});
		}
		
				/* selected == to selected */
		var day6 ="<?php echo $days6; ?>";
		var splt_selectitem6= day6.split(',');
		var cnt6=splt_selectitem6.length;
		for(var i=0;i<cnt6;i++) {
			jQuery("#jform_days6 option").each(function() {
				var cac=splt_selectitem6[i];
				if( jQuery(this).val() == cac ) {
					jQuery(this).attr("selected","selected");
				}
			});
		}
		
						/* selected == to selected */
		var day7 ="<?php echo $days7; ?>";
		var splt_selectitem7= day7.split(',');
		var cnt7=splt_selectitem7.length;
		for(var i=0;i<cnt7;i++) {
			jQuery("#jform_days6 option").each(function() {
				var cac=splt_selectitem6[i];
				if( jQuery(this).val() == cac ) {
					jQuery(this).attr("selected","selected");
				}
			});
		}

    						/* selected == to selected */
		var day8 ="<?php echo $days8; ?>";
		var splt_selectitem8= day8.split(',');
		var cnt8 =splt_selectitem8.length;
		for(var i=0;i<cnt8;i++) {
			jQuery("#jform_days8 option").each(function() {
				var cac=splt_selectitem8[i];
				if( jQuery(this).val() == cac ) {
					jQuery(this).attr("selected","selected");
				}
			});
		}
    						/* selected == to selected */
		var day9 ="<?php echo $days9; ?>";
		var splt_selectitem9= day9.split(',');
		var cnt9 =splt_selectitem9.length;
		for(var i=0;i<cnt9;i++) {
			jQuery("#jform_days9 option").each(function() {
				var cac=splt_selectitem9[i];
				if( jQuery(this).val() == cac ) {
					jQuery(this).attr("selected","selected");
				}
			});
		}	
		
		    						/* selected == to selected */
		var day10 ="<?php echo $days10; ?>";
		var splt_selectitem10= day10.split(',');
		var cnt10 =splt_selectitem10.length;
		for(var i=0;i<cnt10;i++) {
			jQuery("#jform_days10 option").each(function() {
				var cac=splt_selectitem10[i];
				if( jQuery(this).val() == cac ) {
					jQuery(this).attr("selected","selected");
				}
			});
		}	

		    						/* selected == to selected */
		var day11 ="<?php echo $days11; ?>";
		var splt_selectitem10= day11.split(',');
		var cnt11 =splt_selectitem11.length;
		for(var i=0;i<cnt11;i++) {
			jQuery("#jform_days11 option").each(function() {
				var cac=splt_selectitem11[i];
				if( jQuery(this).val() == cac ) {
					jQuery(this).attr("selected","selected");
				}
			});
		}	
		
		
		    						/* selected == to selected */
		var day12 ="<?php echo $days12; ?>";
		var splt_selectitem12= day12.split(',');
		var cnt12 =splt_selectitem12.length;
		for(var i=0;i<cnt12;i++) {
			jQuery("#jform_days12 option").each(function() {
				var cac=splt_selectitem12[i];
				if( jQuery(this).val() == cac ) {
					jQuery(this).attr("selected","selected");
				}
			});
		}	
		
		
		    						/* selected == to selected */
		var day13 ="<?php echo $days13; ?>";
		var splt_selectitem10= day13.split(',');
		var cnt13 =splt_selectitem13.length;
		for(var i=0;i<cnt13;i++) {
			jQuery("#jform_days13 option").each(function() {
				var cac=splt_selectitem13[i];
				if( jQuery(this).val() == cac ) {
					jQuery(this).attr("selected","selected");
				}
			});
		}
		
		
		    						/* selected == to selected */
		var day14 ="<?php echo $days14; ?>";
		var splt_selectitem14= day14.split(',');
		var cnt14 =splt_selectitem14.length;
		for(var i=0;i<cnt14;i++) {
			jQuery("#jform_days14 option").each(function() {
				var cac=splt_selectitem14[i];
				if( jQuery(this).val() == cac ) {
					jQuery(this).attr("selected","selected");
				}
			});
		}
		
		
		    						/* selected == to selected */
		var day15 ="<?php echo $days15; ?>";
		var splt_selectitem15= day15.split(',');
		var cnt15 =splt_selectitem15.length;
		for(var i=0;i<cnt15;i++) {
			jQuery("#jform_days15 option").each(function() {
				var cac=splt_selectitem15[i];
				if( jQuery(this).val() == cac ) {
					jQuery(this).attr("selected","selected");
				}
			});
		}	
		
		
		    						/* selected == to selected */
		var day16 ="<?php echo $days16; ?>";
		var splt_selectitem16= day16.split(',');
		var cnt10 =splt_selectitem16.length;
		for(var i=0;i<cnt16;i++) {
			jQuery("#jform_days16 option").each(function() {
				var cac=splt_selectitem16[i];
				if( jQuery(this).val() == cac ) {
					jQuery(this).attr("selected","selected");
				}
			});
		}
		
		
		    						/* selected == to selected */
		var day17 ="<?php echo $days17; ?>";
		var splt_selectitem10= day17.split(',');
		var cnt17 =splt_selectitem17.length;
		for(var i=0;i<cnt17;i++) {
			jQuery("#jform_days17 option").each(function() {
				var cac=splt_selectitem17[i];
				if( jQuery(this).val() == cac ) {
					jQuery(this).attr("selected","selected");
				}
			});
		}	
		
		
		    						/* selected == to selected */
		var day18 ="<?php echo $days18; ?>";
		var splt_selectitem18= day18.split(',');
		var cnt18 =splt_selectitem18.length;
		for(var i=0;i<cnt18;i++) {
			jQuery("#jform_days18 option").each(function() {
				var cac=splt_selectitem18[i];
				if( jQuery(this).val() == cac ) {
					jQuery(this).attr("selected","selected");
				}
			});
		}	
		
		
       /* selected == to selected */
		var day19 ="<?php echo $days19; ?>";
		var splt_selectitem19= day19.split(',');
		var cnt19 =splt_selectitem19.length;
		for(var i=0;i<cnt19;i++) {
			jQuery("#jform_days19 option").each(function() {
				var cac=splt_selectitem19[i];
				if( jQuery(this).val() == cac ) {
					jQuery(this).attr("selected","selected");
				}
			});
		}	
		
		
		    						/* selected == to selected */
		var day20 ="<?php echo $days20; ?>";
		var splt_selectitem20= day20.split(',');
		var cnt10 =splt_selectitem20.length;
		for(var i=0;i<cnt20;i++) {
			jQuery("#jform_days20 option").each(function() {
				var cac=splt_selectitem20[i];
				if( jQuery(this).val() == cac ) {
					jQuery(this).attr("selected","selected");
				}
			});
		}	
    });
   </script>
