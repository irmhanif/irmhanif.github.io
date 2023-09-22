<?php
defined('_JEXEC') or die('Restricted access');
$db=JFactory::getDBO();

$_SESSION['trip'] = 'fixed_trip';
$comingsoon='images/cmsoon.png';
	?>
<div class="get_inspration fixed">
    <h1 class="h1class">Explore By Date</h1>
    <div class="inspiration_detail">
		<?php
		$sql="SELECT * FROM `#__create_trip` WHERE state='1'";
		$db->setQuery($sql);
		$dates=$db->loadObjectList();
		
		foreach($dates as $event_disp) {
			$id=$event_disp->id;
			$type=$event_disp->type;
			$date1=$event_disp->date_of_departure1;
			$date2=$event_disp->date_of_departure2;
			$date3=$event_disp->date_of_departure3;
			$date4=$event_disp->date_of_departure4;
			$date5=$event_disp->date_of_departure5;
			$date6=$event_disp->date_of_departure6;

			$tempvar1=$id.'>'.$date1.'>'.$type;
			$tempvar2=$id.'>'.$date2.'>'.$type;
			$tempvar3=$id.'>'.$date3.'>'.$type;
			$tempvar4=$id.'>'.$date4.'>'.$type;
			$tempvar5=$id.'>'.$date5.'>'.$type;
			$tempvar6=$id.'>'.$date6.'>'.$type;
			$m1 = $date1;
			$m2 = $date2;
			$m3 = $date3;
			$m4 = $date4;
			$m5 = $date5;
			$m6 = $date6;

			$mnt = array($m1,$m2,$m3,$m4,$m5,$m6);
			$mntt = array($tempvar1,$tempvar2,$tempvar3,$tempvar4,$tempvar5,$tempvar6);

			foreach (array_keys($mnt, '0000-00-00') as $key) {
				unset($mnt[$key]);
			}

			$arr = implode(",", $mntt);
			$arr = explode(",", $arr);
			
			foreach ($mntt as  $value) {
				$valueid = $value;
				$arr = explode(">", $value);

				$arr = $arr[1];
			
				if($arr!='0000-00-00') {
				
				$thismonth = date('m', strtotime($arr));
				
				if($thismonth == "01") {
					$month1[] = $valueid;
				}
				if ($thismonth == "02") {
					$month2[] = $valueid;
				}
				if($thismonth == "03") {
					$month3[] = $valueid;
				}
				if($thismonth == "05") {
					$month5[] = $valueid;
				}
				if($thismonth == "07") {
					$month7[] = $valueid;
				}
				if($thismonth == "09") {
					$month9[] = $valueid;
				}
				if($thismonth == "11") {
					$month11[] = $valueid;
			
				}

				if ($thismonth == "04") {
					$month4[] = $valueid;
						
				}
				if ($thismonth == "06") {
					$month6[] = $valueid;
				}
				if ($thismonth == "08") {
					$month8[] = $valueid;

					
				}
				if ($thismonth == "10") {
					$month10[] = $valueid;
											
				}
				if ($thismonth == "12") {
					$month12[] = $valueid;
				}
			}}
		}
		$sqlz1="SELECT * FROM `#__create_trip` WHERE state='1'";
		$db->setQuery($sqlz1);
		$avilmonths=$db->loadObjectList();
		foreach($dates as $event_disp) {
			$datez[]=$event_disp->date_of_departure1;
			$datez[].=$event_disp->date_of_departure2;
			$datez[].=$event_disp->date_of_departure3;
			$datez[].=$event_disp->date_of_departure4;
			$datez[].=$event_disp->date_of_departure5;
			$datez[].=$event_disp->date_of_departure6;
		}
		$array_without_0 = array_diff($datez, array('0000-00-00'));
		foreach($array_without_0 as $alldates) {
			$avmonths[] = (date('m', strtotime($alldates)));
		}
		$allmnthsarr= array('01', '02', '03','04', '05', '06','07', '08', '09','10', '11', '12');
		$resultz=array_diff($allmnthsarr,$avmonths);
		$removeid = $removeid2 = $removeid3 = $removeid4 = $removeid5 = $removeid6 = $removeid7 = $removeid8 = $removeid9 = $removeid10 = $removeid11 = $removeid12 = '';
		foreach($resultz as $unavilablemnths) {
			$unavilablemnthsz[]=$unavilablemnths;
		}
		foreach($unavilablemnthsz as $mnthloop) {
			if($mnthloop=='01'){
				$removeid='1';
			}
		}
		foreach($unavilablemnthsz as $mnthloop2) {
			if($mnthloop2=='02') {
				$removeid2='2';
			}
		}
		foreach($unavilablemnthsz as $mnthloop3) {
			if($mnthloop3=='03') {
				$removeid3='3';
			}
		}
		foreach($unavilablemnthsz as $mnthloop4) {
			if($mnthloop4=='04') {
				$removeid4='4';
			}
		}
		foreach($unavilablemnthsz as $mnthloop5) {
			if($mnthloop5=='05') {
				$removeid5='5';
			}
		}
		foreach($unavilablemnthsz as $mnthloop6) {
			if($mnthloop6=='06') {
				$removeid6='6';
			}
		}
		foreach($unavilablemnthsz as $mnthloop7) {
			if($mnthloop7=='07'){
				$removeid7='7';
			}
		}
		foreach($unavilablemnthsz as $mnthloop8) {
			if($mnthloop8=='08') {
				$removeid8='8';
			}
		}
		foreach($unavilablemnthsz as $mnthloop9) {
			if($mnthloop9=='09') {
				$removeid9='9';
			}
		}
		foreach($unavilablemnthsz as $mnthloop10) {
			if($mnthloop10=='10') {
				$removeid10='10';
			}
		}
		foreach($unavilablemnthsz as $mnthloop11) {
			if($mnthloop11=='11') {
				$removeid11='11';
			}
		}
		foreach($unavilablemnthsz as $mnthloop12) {
			if($mnthloop12=='12') {
				$removeid12='12';
			}
		}
		$removeids = array($removeid,$removeid2,$removeid3,$removeid4,$removeid5,$removeid6,$removeid7,$removeid8,$removeid9,$removeid10,$removeid11,$removeid12);
		$stringid = implode(',', $removeids);
		$arrayid = explode(',', $stringid);
		// $duplicate =array_unique( array_diff_assoc( $arrayid, array_unique( $arrayid ) ) );

		$duplicate=array_values(array_diff($arrayid,array("","")));


		$unavail = implode(',', $duplicate);

		?>
        <div class="owl-carousel">
			<?php
			if($unavail != "") {
				$sql="SELECT * FROM `#__date_category` WHERE state=1 ";
			} else {
				$sql="SELECT * FROM `#__date_category` WHERE state=1";
			}
			$db->setQuery($sql);
			$event_detail=$db->loadObjectList();
			foreach($event_detail as $event_disp)
			{
				$id=$event_disp->id;
				$place_name=$event_disp->title;
				$place_image=$event_disp->picture;
				$pro_img = JURI::root().'date_category/'.$place_image;
				$start_date=$event_disp->start_date;
				$smm = date('m', strtotime($start_date));
				$end_date=$event_disp->end_date;
				$emm = date('m', strtotime($end_date));

				echo ' <div class="item fixed">

         <div class="dispim1">
          <img class=disimg src="'.$pro_img.'" alt="" />
          <span class="eventtittle eventtittle1" style="text-transform:Capitalize;">
          <label>'.$place_name.'</label>
          <p>';
				if ($id == 1) {
				    if(isset($month1)) {
					foreach ($month1 as $month) {
						$month = explode(">", $month);
						$type = $month[2];
						$did = $month[0];
						$date = $month[1];
						$fdate = date('d M Y', (strtotime($date)));
						$typename = "SELECT title FROM `#__type_category` WHERE state='1' AND id = '$type'";
						$db->setQuery($typename);
						$typen = $db->loadResult();
						if ($date != '0000-00-00') {
							$length1[]=($date);
						}
					}
					if ($date != '0000-00-00') {
						$len=count($length1);
						if($len==1) {
							foreach ($month1 as $month) {
								$month    = explode(">", $month);
								$type     = $month[2];
								$did      = $month[0];
								$date     = $month[1];
								$fdate    = date('d M Y', (strtotime($date)));
								$typename = "SELECT title FROM `#__type_category` WHERE state='1' AND id = '$type'";
								$db->setQuery($typename);
								$typen = $db->loadResult();
								echo '<a class="eventlink singlelinkf" href="' . JURI::root() . 'index.php?option=com_fixed_trip&view=create_trip&id=' . $did . '&date=' . $date . '&type=' . $type . '">' . $fdate . ' | ' . $typen . '</a>';
								echo '<a class="dummieslinkfixe" href="' . JURI::root() . 'index.php?option=com_fixed_trip&view=create_trip&id=' . $did . '&date=' . $date . '&type=' . $type . '"><span></span></a>';
							}
						} else {
							foreach ($month1 as $month) {
								$month    = explode(">", $month);
								$type     = $month[2];
								$did      = $month[0];
								$date     = $month[1];
								$fdate    = date('d M Y', (strtotime($date)));
								$typename = "SELECT title FROM `#__type_category` WHERE state='1' AND id = '$type'";
								$db->setQuery($typename);
								$typen = $db->loadResult();
								echo '<a class="eventlink multilink" href="' . JURI::root() . 'index.php?option=com_fixed_trip&view=create_trip&id=' . $did . '&date=' . $date . '&type=' . $type . '">' . $fdate . ' | ' . $typen . '</a>';
							}
						}
					}
                    } else {
                        echo '<span class="eventlink multilink comingsoon">Coming Soon</span>';
                    }
				}
				if ($id == 2) {
				    if(isset($month2)) {
					foreach ($month2 as $month) {
						$month = explode(">", $month);
						$type = $month[2];
						$did = $month[0];
						$date = $month[1];
						$fdate = date('d M Y', (strtotime($date)));
						$typename = "SELECT title FROM `#__type_category` WHERE state='1' AND id = '$type'";
						$db->setQuery($typename);
						$typen = $db->loadResult();
						if ($date != '0000-00-00') {
							$length2[]=($date);
						}
					}
					if ($date != '0000-00-00') {
						$len=count($length2);
						if($len==1) {
							foreach ($month2 as $month) {
								$month    = explode(">", $month);
								$type     = $month[2];
								$did      = $month[0];
								$date     = $month[1];
								$fdate    = date('d M Y', (strtotime($date)));
								$typename = "SELECT title FROM `#__type_category` WHERE state='1' AND id = '$type'";
								$db->setQuery($typename);
								$typen = $db->loadResult();
								echo '<a class="eventlink singlelinkf" href="' . JURI::root() . 'index.php?option=com_fixed_trip&view=create_trip&id=' . $did . '&date=' . $date . '&type=' . $type . '">' . $fdate . ' | ' . $typen . '</a>';
								echo '<a class="dummieslinkfixe" href="' . JURI::root() . 'index.php?option=com_fixed_trip&view=create_trip&id=' . $did . '&date=' . $date . '&type=' . $type . '"><span></span></a>';
							}
						} else {
							foreach ($month2 as $month) {
								$month    = explode(">", $month);
								$type     = $month[2];
								$did      = $month[0];
								$date     = $month[1];
								$fdate    = date('d M Y', (strtotime($date)));
								$typename = "SELECT title FROM `#__type_category` WHERE state='1' AND id = '$type'";
								$db->setQuery($typename);
								$typen = $db->loadResult();
								echo '<a class="eventlink multilink" href="' . JURI::root() . 'index.php?option=com_fixed_trip&view=create_trip&id=' . $did . '&date=' . $date . '&type=' . $type . '">' . $fdate . ' | ' . $typen . '</a>';
							}
						}
					}
                    } else {
                        echo '<span class="eventlink multilink comingsoon">Coming Soon</span>';
                    }
				}
				if ($id == 3) {
				    if(isset($month3)) {
					foreach ($month3 as $month) {
						$month = explode(">", $month);
						$type = $month[2];
						$did = $month[0];
						$date = $month[1];
						$fdate = date('d M Y', (strtotime($date)));
						$typename = "SELECT title FROM `#__type_category` WHERE state='1' AND id = '$type'";
						$db->setQuery($typename);
						$typen = $db->loadResult();
						if ($date != '0000-00-00') {
							$length3[]=($date);
						}
					}
					if ($date != '0000-00-00') {
						$len=count($length3);
						if($len==1) {
							foreach ($month3 as $month) {
								$month    = explode(">", $month);
								$type     = $month[2];
								$did      = $month[0];
								$date     = $month[1];
								$fdate    = date('d M Y', (strtotime($date)));
								$typename = "SELECT title FROM `#__type_category` WHERE state='1' AND id = '$type'";
								$db->setQuery($typename);
								$typen = $db->loadResult();
								echo '<a class="eventlink singlelinkf" href="' . JURI::root() . 'index.php?option=com_fixed_trip&view=create_trip&id=' . $did . '&date=' . $date . '&type=' . $type . '">' . $fdate . ' | ' . $typen . '</a>';
								echo '<a class="dummieslinkfixe" href="' . JURI::root() . 'index.php?option=com_fixed_trip&view=create_trip&id=' . $did . '&date=' . $date . '&type=' . $type . '"><span></span></a>';
							}
						} else {
							foreach ($month3 as $month) {
								$month    = explode(">", $month);
								$type     = $month[2];
								$did      = $month[0];
								$date     = $month[1];
								$fdate    = date('d M Y', (strtotime($date)));
								$typename = "SELECT title FROM `#__type_category` WHERE state='1' AND id = '$type'";
								$db->setQuery($typename);
								$typen = $db->loadResult();
								echo '<a class="eventlink multilink" href="' . JURI::root() . 'index.php?option=com_fixed_trip&view=create_trip&id=' . $did . '&date=' . $date . '&type=' . $type . '">' . $fdate . ' | ' . $typen . '</a>';
							}
						}
					}
                    } else {
                        echo '<span class="eventlink multilink comingsoon">Coming Soon</span>';
                    }
				}
				if ($id == 4) {
				    if(isset($month4)) {
					foreach ($month4 as $month) {
						$month = explode(">", $month);
						$type = $month[2];
						$did = $month[0];
						$date = $month[1];
						$fdate = date('d M Y', (strtotime($date)));
						$typename = "SELECT title FROM `#__type_category` WHERE state='1' AND id = '$type'";
						$db->setQuery($typename);
						$typen = $db->loadResult();
						if ($date != '0000-00-00') {
							$length4[]=($date);
						}
					}
					if ($date != '0000-00-00') {
						$len=count($length4);
						if($len==1) {
							foreach ($month4 as $month) {
								$month    = explode(">", $month);
								$type     = $month[2];
								$did      = $month[0];
								$date     = $month[1];
								$fdate    = date('d M Y', (strtotime($date)));
								$typename = "SELECT title FROM `#__type_category` WHERE state='1' AND id = '$type'";
								$db->setQuery($typename);
								$typen = $db->loadResult();
								echo '<a class="eventlink singlelinkf" href="' . JURI::root() . 'index.php?option=com_fixed_trip&view=create_trip&id=' . $did . '&date=' . $date . '&type=' . $type . '">' . $fdate . ' | ' . $typen . '</a>';
								echo '<a class="dummieslinkfixe" href="' . JURI::root() . 'index.php?option=com_fixed_trip&view=create_trip&id=' . $did . '&date=' . $date . '&type=' . $type . '"><span></span></a>';
							}
						} else {
							foreach ($month4 as $month) {
								$month    = explode(">", $month);
								$type     = $month[2];
								$did      = $month[0];
								$date     = $month[1];
								$fdate    = date('d M Y', (strtotime($date)));
								$typename = "SELECT title FROM `#__type_category` WHERE state='1' AND id = '$type'";
								$db->setQuery($typename);
								$typen = $db->loadResult();
								echo '<a class="eventlink multilink" href="' . JURI::root() . 'index.php?option=com_fixed_trip&view=create_trip&id=' . $did . '&date=' . $date . '&type=' . $type . '">' . $fdate . ' | ' . $typen . '</a>';
							}
						}
					}
                    } else {
                        echo '<span class="eventlink multilink comingsoon">Coming Soon</span>';
                    }
				}
				if ($id == 5) {
				    if(isset($month5)) {
					foreach ($month5 as $month) {
						$month = explode(">", $month);
						$type = $month[2];
						$did = $month[0];
						$date = $month[1];
						$fdate = date('d M Y', (strtotime($date)));
						$typename = "SELECT title FROM `#__type_category` WHERE state='1' AND id = '$type'";
						$db->setQuery($typename);
						$typen = $db->loadResult();
						if ($date != '0000-00-00') {
							$length5[]=($date);
						}
					}
					if ($date != '0000-00-00') {
						$len=count($length5);
						if($len==1) {
							foreach ($month5 as $month) {
								$month    = explode(">", $month);
								$type     = $month[2];
								$did      = $month[0];
								$date     = $month[1];
								$fdate    = date('d M Y', (strtotime($date)));
								$typename = "SELECT title FROM `#__type_category` WHERE state='1' AND id = '$type'";
								$db->setQuery($typename);
								$typen = $db->loadResult();
								echo '<a class="eventlink singlelinkf" href="' . JURI::root() . 'index.php?option=com_fixed_trip&view=create_trip&id=' . $did . '&date=' . $date . '&type=' . $type . '">' . $fdate . ' | ' . $typen . '</a>';
								echo '<a class="dummieslinkfixe" href="' . JURI::root() . 'index.php?option=com_fixed_trip&view=create_trip&id=' . $did . '&date=' . $date . '&type=' . $type . '"><span></span></a>';
							}
						} else {
							foreach ($month5 as $month) {
								$month    = explode(">", $month);
								$type     = $month[2];
								$did      = $month[0];
								$date     = $month[1];
								$fdate    = date('d M Y', (strtotime($date)));
								$typename = "SELECT title FROM `#__type_category` WHERE state='1' AND id = '$type'";
								$db->setQuery($typename);
								$typen = $db->loadResult();
								echo '<a class="eventlink multilink" href="' . JURI::root() . 'index.php?option=com_fixed_trip&view=create_trip&id=' . $did . '&date=' . $date . '&type=' . $type . '">' . $fdate . ' | ' . $typen . '</a>';
							}
						}
					}
                    } else {
                        echo '<span class="eventlink multilink comingsoon">Coming Soon</span>';
                    }
				}
				if ($id == 6) {
				    if(isset($month6)) {
					foreach ($month6 as $month) {
						$month = explode(">", $month);
						$type = $month[2];
						$did = $month[0];
						$date = $month[1];
						$fdate = date('d M Y', (strtotime($date)));
						$typename = "SELECT title FROM `#__type_category` WHERE state='1' AND id = '$type'";
						$db->setQuery($typename);
						$typen = $db->loadResult();
						if ($date != '0000-00-00') {
							$length6[]=($date);
						}
					}
					if ($date != '0000-00-00') {
						$len=count($length6);
						if($len==1) {
							foreach ($month6 as $month) {
								$month    = explode(">", $month);
								$type     = $month[2];
								$did      = $month[0];
								$date     = $month[1];
								$fdate    = date('d M Y', (strtotime($date)));
								$typename = "SELECT title FROM `#__type_category` WHERE state='1' AND id = '$type'";
								$db->setQuery($typename);
								$typen = $db->loadResult();
								echo '<a class="eventlink singlelinkf" href="' . JURI::root() . 'index.php?option=com_fixed_trip&view=create_trip&id=' . $did . '&date=' . $date . '&type=' . $type . '">' . $fdate . ' | ' . $typen . '</a>';
								echo '<a class="dummieslinkfixe" href="' . JURI::root() . 'index.php?option=com_fixed_trip&view=create_trip&id=' . $did . '&date=' . $date . '&type=' . $type . '"><span></span></a>';
							}
						} else {
							foreach ($month6 as $month) {
								$month    = explode(">", $month);
								$type     = $month[2];
								$did      = $month[0];
								$date     = $month[1];
								$fdate    = date('d M Y', (strtotime($date)));
								$typename = "SELECT title FROM `#__type_category` WHERE state='1' AND id = '$type'";
								$db->setQuery($typename);
								$typen = $db->loadResult();
								echo '<a class="eventlink multilink" href="' . JURI::root() . 'index.php?option=com_fixed_trip&view=create_trip&id=' . $did . '&date=' . $date . '&type=' . $type . '">' . $fdate . ' | ' . $typen . '</a>';
							}
						}
					}
                    } else {
                        echo '<span class="eventlink multilink comingsoon">Coming Soon</span>';
                    }
				}
				if ($id == 7) {
				    if(isset($month7)) {
					foreach ($month7 as $month) {
						$month = explode(">", $month);
						$type = $month[2];
						$did = $month[0];
						$date = $month[1];
						$fdate = date('d M Y', (strtotime($date)));
						$typename = "SELECT title FROM `#__type_category` WHERE state='1' AND id = '$type'";
						$db->setQuery($typename);
						$typen = $db->loadResult();
						if ($date != '0000-00-00') {
							$length7[]=($date);
						}
					}
					if ($date != '0000-00-00') {
						$len=count($length7);
						if($len==1) {
							foreach ($month7 as $month) {
								$month    = explode(">", $month);
								$type     = $month[2];
								$did      = $month[0];
								$date     = $month[1];
								$fdate    = date('d M Y', (strtotime($date)));
								$typename = "SELECT title FROM `#__type_category` WHERE state='1' AND id = '$type'";
								$db->setQuery($typename);
								$typen = $db->loadResult();
								echo '<a class="eventlink singlelinkf" href="' . JURI::root() . 'index.php?option=com_fixed_trip&view=create_trip&id=' . $did . '&date=' . $date . '&type=' . $type . '">' . $fdate . ' | ' . $typen . '</a>';
								echo '<a class="dummieslinkfixe" href="' . JURI::root() . 'index.php?option=com_fixed_trip&view=create_trip&id=' . $did . '&date=' . $date . '&type=' . $type . '"><span></span></a>';
							}
						} else {
							foreach ($month7 as $month) {
								$month    = explode(">", $month);
								$type     = $month[2];
								$did      = $month[0];
								$date     = $month[1];
								$fdate    = date('d M Y', (strtotime($date)));
								$typename = "SELECT title FROM `#__type_category` WHERE state='1' AND id = '$type'";
								$db->setQuery($typename);
								$typen = $db->loadResult();
								echo '<a class="eventlink multilink" href="' . JURI::root() . 'index.php?option=com_fixed_trip&view=create_trip&id=' . $did . '&date=' . $date . '&type=' . $type . '">' . $fdate . ' | ' . $typen . '</a>';
							}
						}
					}
                    } else {
                        echo '<span class="eventlink multilink comingsoon">Coming Soon</span>';
                    }
				}
				if ($id == 8) {
				    if(isset($month8)) {
					foreach ($month8 as $month) {
						$month = explode(">", $month);
						$type = $month[2];
						$did = $month[0];
						$date = $month[1];
						$fdate = date('d M Y', (strtotime($date)));
						$typename = "SELECT title FROM `#__type_category` WHERE state='1' AND id = '$type'";
						$db->setQuery($typename);
						$typen = $db->loadResult();
						if ($date != '0000-00-00') {
							$length8[]=($date);
						}
					}
					if ($date != '0000-00-00') {
					    $len=count($length8);
					    if($len==2) {
					        foreach ($month8 as $month) {
					            $month    = explode(">", $month);
					            $type     = $month[2];
					            $did      = $month[0];
					            $date     = $month[1];
					            $fdate    = date('d M Y', (strtotime($date)));
					            $typename = "SELECT title FROM `#__type_category` WHERE state='1' AND id = '$type'";
					            $db->setQuery($typename);
					            $typen = $db->loadResult();
					            echo '<a class="eventlink singlelinkf" href="' . JURI::root() . 'index.php?option=com_fixed_trip&view=create_trip&id=' . $did . '&date=' . $date . '&type=' . $type . '">' . $fdate . ' | ' . $typen . '</a>';
					            echo '<a class="dummieslinkfixe" href="' . JURI::root() . 'index.php?option=com_fixed_trip&view=create_trip&id=' . $did . '&date=' . $date . '&type=' . $type . '"><span></span></a>';
					        }
					    } else {
					        foreach ($month8 as $month) {
					            $month    = explode(">", $month);
					            $type     = $month[2];
					            $did      = $month[0];
					            $date     = $month[1];
					            $fdate    = date('d M Y', (strtotime($date)));
					            $typename = "SELECT title FROM `#__type_category` WHERE state='1' AND id = '$type'";
					            $db->setQuery($typename);
					            $typen = $db->loadResult();

                                echo '<a class="eventlink multilink" href="' . JURI::root() . 'index.php?option=com_fixed_trip&view=create_trip&id=' . $did . '&date=' . $date . '&type=' . $type . '">' . $fdate . ' | ' . $typen . '</a>';
					        }
					    }
					}
                    } else {
                        echo '<span class="eventlink multilink comingsoon">Coming Soon</span>';
                    }
				}
				if ($id == 9) {
				    if(isset($month9)) {
					foreach ($month9 as $month) {
						$month = explode(">", $month);
						$type = $month[2];
						$did = $month[0];
						$date = $month[1];
						$fdate = date('d M Y', (strtotime($date)));
						$typename = "SELECT title FROM `#__type_category` WHERE state='1' AND id = '$type'";
						$db->setQuery($typename);
						$typen = $db->loadResult();
						if ($date != '0000-00-00') {
							$length9[]=($date);
						}
					}
					if ($date != '0000-00-00') {
						$len=count($length9);

						if($len==1) {
							foreach ($month9 as $month) {
								$month    = explode(">", $month);
								$type     = $month[2];
								$did      = $month[0];
								$date     = $month[1];
								$fdate    = date('d M Y', (strtotime($date)));
								$typename = "SELECT title FROM `#__type_category` WHERE state='1' AND id = '$type'";
								$db->setQuery($typename);
								$typen = $db->loadResult();
								echo '<a class="eventlink singlelinkf" href="' . JURI::root() . 'index.php?option=com_fixed_trip&view=create_trip&id=' . $did . '&date=' . $date . '&type=' . $type . '">' . $fdate . ' | ' . $typen . '</a>';
								echo '<a class="dummieslinkfixe" href="' . JURI::root() . 'index.php?option=com_fixed_trip&view=create_trip&id=' . $did . '&date=' . $date . '&type=' . $type . '"><span></span></a>';
							}
						} else {
							foreach ($month9 as $month) {
								$month    = explode(">", $month);
								$type     = $month[2];
								$did      = $month[0];
								$date     = $month[1];
								$fdate    = date('d M Y', (strtotime($date)));
								$typename = "SELECT title FROM `#__type_category` WHERE state='1' AND id = '$type'";
								$db->setQuery($typename);
								$typen = $db->loadResult();
								echo '<a class="eventlink multilink" href="' . JURI::root() . 'index.php?option=com_fixed_trip&view=create_trip&id=' . $did . '&date=' . $date . '&type=' . $type . '">' . $fdate . ' | ' . $typen . '</a>';
							}
						}
					}
                    } else {
                        echo '<span class="eventlink multilink comingsoon">Coming Soon</span>';
                    }
				}
				if ($id == 10) {
				    if(isset($month10)) {
					foreach ($month10 as $month) {
						$month = explode(">", $month);
						$type = $month[2];
						$did = $month[0];
						$date = $month[1];
						$fdate = date('d M Y', (strtotime($date)));
						$typename = "SELECT title FROM `#__type_category` WHERE state='1' AND id = '$type'";
						$db->setQuery($typename);
						$typen = $db->loadResult();
						if ($date != '0000-00-00') {
							$length10[]=($date);
						}
					}
					if ($date != '0000-00-00') {
						$len=count($length10);
						if($len==1) {
							foreach ($month10 as $month) {
								$month    = explode(">", $month);
								$type     = $month[2];
								$did      = $month[0];
								$date     = $month[1];
								$fdate    = date('d M Y', (strtotime($date)));
								$typename = "SELECT title FROM `#__type_category` WHERE state='1' AND id = '$type'";
								$db->setQuery($typename);
								$typen = $db->loadResult();
								echo '<a class="eventlink singlelinkf" href="' . JURI::root() . 'index.php?option=com_fixed_trip&view=create_trip&id=' . $did . '&date=' . $date . '&type=' . $type . '">' . $fdate . ' | ' . $typen . '</a>';
								echo '<a class="dummieslinkfixe" href="' . JURI::root() . 'index.php?option=com_fixed_trip&view=create_trip&id=' . $did . '&date=' . $date . '&type=' . $type . '"><span></span></a>';
							}
						} else {
							foreach ($month10 as $month) {
								$month    = explode(">", $month);
								$type     = $month[2];
								$did      = $month[0];
								$date     = $month[1];
								$fdate    = date('d M Y', (strtotime($date)));
								$typename = "SELECT title FROM `#__type_category` WHERE state='1' AND id = '$type'";
								$db->setQuery($typename);
								$typen = $db->loadResult();
								echo '<a class="eventlink multilink" href="' . JURI::root() . 'index.php?option=com_fixed_trip&view=create_trip&id=' . $did . '&date=' . $date . '&type=' . $type . '">' . $fdate . ' | ' . $typen . '</a>';
							}
						}
					}
                    } else {
                        echo '<span class="eventlink multilink comingsoon">Coming Soon</span>';
                    }
				}
				if ($id == 11) {
				    
                    if(isset($month11)) {
                        foreach ($month11 as $month) {
						$month = explode(">", $month);
						$type = $month[2];
						$did = $month[0];
						$date = $month[1];
						$fdate = date('d M Y', (strtotime($date)));
						$typename = "SELECT title FROM `#__type_category` WHERE state='1' AND id = '$type'";
						$db->setQuery($typename);
						$typen = $db->loadResult();
						if ($date != '0000-00-00') {
							$length11[]=($date);
						}
					}
					if ($date != '0000-00-00') {
						$len=count($length11);
						if($len==1) {
							foreach ($month11 as $month) {
								$month    = explode(">", $month);
								$type     = $month[2];
								$did      = $month[0];
								$date     = $month[1];
								$fdate    = date('d M Y', (strtotime($date)));
								$typename = "SELECT title FROM `#__type_category` WHERE state='1' AND id = '$type'";
								$db->setQuery($typename);
								$typen = $db->loadResult();
								echo '<a class="eventlink singlelinkf" href="' . JURI::root() . 'index.php?option=com_fixed_trip&view=create_trip&id=' . $did . '&date=' . $date . '&type=' . $type . '">' . $fdate . ' | ' . $typen . '</a>';
								echo '<a class="dummieslinkfixe" href="' . JURI::root() . 'index.php?option=com_fixed_trip&view=create_trip&id=' . $did . '&date=' . $date . '&type=' . $type . '"><span></span></a>';
							}
						} else {
							foreach ($month11 as $month) {
								$month    = explode(">", $month);
								$type     = $month[2];
								$did      = $month[0];
								$date     = $month[1];
								$fdate    = date('d M Y', (strtotime($date)));
								$typename = "SELECT title FROM `#__type_category` WHERE state='1' AND id = '$type'";
								$db->setQuery($typename);
								$typen = $db->loadResult();
								echo '<a class="eventlink multilink" href="' . JURI::root() . 'index.php?option=com_fixed_trip&view=create_trip&id=' . $did . '&date=' . $date . '&type=' . $type . '">' . $fdate . ' | ' . $typen . '</a>';
							}
						}
					}
					} else {
                        echo '<span class="eventlink multilink comingsoon">Coming Soon</span>';
					}
				}

				if ($id == 12) {
				    if(isset($month12)) {
					foreach ($month12 as $month) {
						$month = explode(">", $month);

						$type = $month[2];
						$did = $month[0];
						$date = $month[1];
						$fdate = date('d M Y', (strtotime($date)));
						$typename = "SELECT title FROM `#__type_category` WHERE state='1' AND id = '$type'";
						$db->setQuery($typename);
						$typen = $db->loadResult();
						if ($date != '0000-00-00') {
							$length12[]=($date);
						}

					}
					if ($date != '0000-00-00') {
                        if(isset($length12)) {

						$len=count($length12);
						if($len=='') {
                            echo '<a class="eventlink singlelinkf" href="javascript:void(0);">Coming Soon</a>';
                        }else if($len==1) {
							foreach ($month12 as $month) {
								$month    = explode(">", $month);
								$type     = $month[2];
								$did      = $month[0];
								$date     = $month[1];
								$fdate    = date('d M Y', (strtotime($date)));
								$typename = "SELECT title FROM `#__type_category` WHERE state='1' AND id = '$type'";
								$db->setQuery($typename);
								$typen = $db->loadResult();
								echo '<a class="eventlink singlelinkf" href="' . JURI::root() . 'index.php?option=com_fixed_trip&view=create_trip&id=' . $did . '&date=' . $date . '&type=' . $type . '">' . $fdate . ' | ' . $typen . '</a>';
								echo '<a class="dummieslinkfixe" href="' . JURI::root() . 'index.php?option=com_fixed_trip&view=create_trip&id=' . $did . '&date=' . $date . '&type=' . $type . '"><span></span></a>';
							}
						} else {
							foreach ($month12 as $month) {
								$month    = explode(">", $month);
								$type     = $month[2];
								$did      = $month[0];
								$date     = $month[1];
								$fdate    = date('d M Y', (strtotime($date)));
								$typename = "SELECT title FROM `#__type_category` WHERE state='1' AND id = '$type'";
								$db->setQuery($typename);
								$typen = $db->loadResult();
								echo '<a class="eventlink multilink" href="' . JURI::root() . 'index.php?option=com_fixed_trip&view=create_trip&id=' . $did . '&date=' . $date . '&type=' . $type . '">' . $fdate . ' | ' . $typen . '</a>';
							}
						}
					}
					}
				}
				    else {
                        echo '<span class="eventlink multilink comingsoon">Coming Soon</span>';

                    }

				}





				echo '
    </p>   </span> </div>
      </div>';



			}

			?>

        </div>
    </div>
</div>

<script>/********************product slider****************************/
    var jq = jQuery.noConflict();
    var count=jq(".dispim1 img.disimg").length;
    if(count==3) {
        slc=3;
    } else if(count == 2) {
        slc=2;
    } else if(count == 1) {
        slc=1;
    } else {
        slc=4;
    }

    jq(document).ready(function() {
        var owl = firstjq('.owl-carousel');
        owl.owlCarousel({
            items: 4,
            margin: 20,
            autoplay: false,
            autoPlay: 4000, //Set AutoPlay to 3 seconds
            dots: false,
            autoplayTimeout: 4000,
            autoplayHoverPause: true,
            loop: false,
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
                    items: 2,
                },
                980: {
                    items: 3,
                },
                1000: {
                    items: slc,
                }
            }
        });
    });
    /********************product slider end****************************/
</script>


