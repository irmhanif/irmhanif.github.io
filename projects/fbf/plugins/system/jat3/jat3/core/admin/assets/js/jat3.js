/**
 * ------------------------------------------------------------------------
 * JA T3v2 System Plugin for J3.x
 * ------------------------------------------------------------------------
 * Copyright (C) 2004-2018 J.O.O.M Solutions Co., Ltd. All Rights Reserved.
 * @license - GNU/GPL, http://www.gnu.org/licenses/gpl.html
 * Author: J.O.O.M Solutions Co., Ltd
 * Websites: http://www.joomlart.com - http://www.joomlancers.com
 * ------------------------------------------------------------------------
 */


var JAT3_ADMIN = new Class({

	Implements: Options,

	options: {
		activePopIn: 0
	},

	initialize: function(options) {
		this.setOptions(options);

		$(document.body).addEvent( 'click', function() {
			this.clearData();
		}.bind(this));
		this.initProfiles.delay(1000, this);
		this.initLayoutEvent.delay(1000, this);
	},

	initProfiles: function () {
		//clone working copy for each profile
		for (name in profiles) {
			profile = profiles[name];
			if (!profile.local && !profile.core) continue;
			profile.working = (window.$extend || Object.append)({},profile.local?profile.local:profile.core);
		};

		this.fillData('default', 'jform\\[params\\]');
		this.fillDataGeneral();

		//reupdate
		profiles['default'].working = this.rebuildData('jform\\[params\\]');
		//profiles['generalconfigdata'] = this.rebuildData('jform\\[general\\]');

		//Init profile action
	    var ptitles = $$('#ja-profiles-content .ja-profile-titles li.ja-profile');
	    ptitles.each (function (el) {
			isdefault = el.hasClass('default');
			el.addEvent(
				'click',
				function (){
					this.changeProfile(el, false);
				}.bind(this)
			);
		}, this);

		this.checkModified.periodical(1000, this);
	},

	initLayoutEvent: function(){
		var jalayout = $('ja-layouts-content'),
			jalayoutlayer = $('ja-layout-container'),
			jalayouttable = jalayout.getElement('.ja-layout-titles'),
			janewlayout = jalayout.getElement('.ja-layout-new');
			
		if(jalayouttable){
			jalayouttable.addEvent('click:relay(span)', this.routeLayoutEvent.bind(this));
		}	
		if(janewlayout){
			janewlayout.addEvent('click', function(e){
				e.stop();
				
				this.newLayout(janewlayout);
			}.bind(this));
		}
		
		jalayoutlayer.addEvent('click', function(e){
			e.stop();
		});
		
		$(document.body).addEvent('click', function(e) {
			this.cancelLayout();
		}.bind(this));
	},
	
	checkModified: function () {
		var tab = $('ja-tabswrap').getElement('.ja-tabs-title .active');
		if (!tab) return;
		if (tab.hasClass ('profiles')) {
			working = this.rebuildData('jform\\[params\\]');
			var profile = profiles[this.active_profile];
			if(!profile || (!profile.local && !profile.core)) return;

			var saved = profile.local ? profile.local : profile.core;
			var changed = false;
			var els = this.serializeArray('jform\\[params\\]');

			var working_temp = null;
			var pro_temp = null;

			els.each(function(el){
				var name = this.getName(el, 'jform\\[params\\]');

				if( working[name]!=undefined){
					working_temp = working[name].toString().clean().replace (/(\\n|\n|\t|\r| )/g, '').replace(/; /g, ';');
				}
				if( saved[name]!=undefined){
					pro_temp = saved[name].toString().clean().replace (/(\\n|\n|\t|\r| )/g, '').replace(/; /g, ';');
				}
				if ((saved[name] != undefined || working[name] != undefined) && pro_temp != working_temp) {
					el.getParent().getParent().addClass('changed');
					changed = true;
				} else {
					el.getParent().getParent().removeClass('changed');
				}
			},this);

			var li = $('ja-profiles-content').getElement('.ja-profile-titles .active');
			if (li) {
				if (changed) {
					li.addClass ('changed');
					tab.addClass ('changed');
					if (profile.working) {
                        profile.working = working;
                    }
				} else {
					li.removeClass ('changed');
					if (!$('ja-profiles-content').getElement('.ja-profile-titles .changed')) tab.removeClass ('changed');
				}
			}
		}

		if (tab.hasClass ('general')) {
			//check change for general tab
			var working = this.rebuildData('jform\\[general\\]');
			var saved = profiles['generalconfigdata'];
			var changed = false;
			var els = this.serializeArray('jform\\[general\\]');
			var working_temp = null;
			var pro_temp = null;

			els.each(function(el){
				var name = this.getName(el, 'jform\\[general\\]');
				if( working[name]!=undefined){
					working_temp = working[name].toString().clean().replace (/(\\n|\n|\t|\r| )/g, '').replace(/; /g, ';');
				}
				if( saved[name]!=undefined){
					pro_temp = saved[name].toString().clean().replace (/(\\n|\n|\t|\r| )/g, '').replace(/; /g, ';');
				}
				if ((saved[name] != undefined || working[name] != undefined) && working_temp != pro_temp) {
					el.getParent().getParent().addClass('changed');
					changed = true;
				} else {
					el.getParent().getParent().removeClass('changed');
				}
			},this);
			if (changed) {
				tab.addClass ('changed');
			} else {
				tab.removeClass ('changed');
			}
		}
	},

	checkModifiedAll: function () {
		//check general
		//check change for general tab
		var tab = $('ja-tabswrap').getElement('.ja-tabs-title .general');
		var working = this.rebuildData('jform\\[general\\]');
		var saved = profiles['generalconfigdata'];
		var changed = false;
		var els = this.serializeArray('jform\\[general\\]');
		var working_temp = null;
		var pro_temp = null;
		els.each(function(el){
			var name = this.getName(el, 'jform\\[general\\]');
			if (working[name] != undefined) {
				working_temp = working[name].toString().clean().replace (/(\\n|\n|\t|\r| )/g, '').replace(/; /g, ';');
			}
			if (saved[name] != undefined) {
				pro_temp = saved[name].toString().clean().replace (/(\\n|\n|\t|\r| )/g, '').replace(/; /g, ';');
			}
			if ((saved[name] != undefined || working[name] != undefined) && working_temp != pro_temp) {
				changed = true;
				el.getParent().getParent().addClass('changed');
			} else {
				el.getParent().getParent().removeClass('changed');
			}
		},this);
		if (changed) {
			tab.addClass ('changed');
		} else {
			tab.removeClass ('changed');
		}

		//Check profiles
		var pname = $$('#ja-tabswrap .ja-profile-titles li.ja-profile');
		var els = this.serializeArray('jform\\[params\\]');
		var tab = $('ja-tabswrap').getElement('.ja-tabs-title .profiles');
		pname.each(function(li) {
			var profile = profiles[li.getElement('.ja-profile-title').get('text').toLowerCase().clean()];
			var working = profile.working ? profile.working : null;
			var saved   = profile.local ? profile.local : profile.core;
			var changed = false;

			els.each(function(el){
				var name = this.getName(el, 'jform\\[params\\]');
				if (working[name] != undefined) {
					working_temp = working[name].toString().clean().replace (/(\\n|\n|\t|\r| )/g, '').replace(/; /g, ';');
				}
				if (saved[name] != undefined) {
					pro_temp = saved[name].toString().clean().replace (/(\\n|\n|\t|\r| )/g, '').replace(/; /g, ';');
				}

				if ((saved[name] != undefined || working[name] != undefined) && working_temp != pro_temp) {
					el.getParent().getParent().addClass('changed');
					changed = true;
				} else {
					el.getParent().getParent().removeClass('changed');
				}
			},this);

			if (changed) {
				li.addClass('changed');
				tab.addClass('changed');
			} else {
				li.removeClass ('changed');
				if (!$('ja-profiles-content').getElement('.ja-profile-titles .changed')) tab.removeClass('changed');
			}
		},this);
		/*
		if ($('ja-profiles-content').getElement('.ja-profile-titles .changed')) {
		    tab.addClass ('changed');
		} else {
			tab.removeClass ('changed');
		}
		*/
	},

	saveData: function (obj){
		obj = $(obj);
		/* Rebuild data */

		var url = 'index.php?jat3action=saveData&jat3type=plugin&template='+template+'&id='+styleid;

		if(typeof (document.adminForm['default']) != 'undefined'){
			url += '&default='+document.adminForm['default'].value;
		}
		else{
			url += '&default=0';
		}
		if($('selections')){
			url += '&selections=' + $('selections').getValue();
		}
		var json = {};

		json['generalconfigdata'] = this.rebuildData('jform\\[general\\]');
		json['jform'] = {};
		json['jform']['title'] = document.adminForm.jform_title.value;
		json['jform']['home'] = document.adminForm.jform_home.value;

		var tab = $('ja-tabswrap').getElement('.ja-tabs-title .profiles');
		var name = null;
		if (tab.hasClass ('changed')) {
			profiles[this.active_profile].working = this.rebuildData('jform\\[params\\]');
			var pnames = $$('#ja-profiles-content .ja-profile-titles li.changed');
			if (pnames) {
				json['profiles'] = {};
				pnames.each (function (pname) {
					name = pname.getElement('.ja-profile-title').get('text').toLowerCase();
					json['profiles'][name] = profiles[name].working;
				},this);
			}
		}
		this.submitForm(url, json, obj);
	},


	saveGeneral: function (obj) {
		obj = $(obj);
		/* Rebuild data */
		profiles['general'] = this.rebuildData('jform\\[general\\]');
		//data = profiles['general'].replace (/\n/g, '\\n').replace (/\t/g, '\\t');
		var url = 'index.php?jat3action=saveGeneral&jat3type=plugin&template='+template+'&id='+styleid;
		this.submitForm(url, profiles['general'], obj);
	},


	submitForm: function(link, request, obj, type) {
		if (!requesting) {
			requesting = true;
		} else return;

		obj = $(obj);
		if (obj) obj.addClass('jat3-loading');
		console.log(request);
		var jSonRequest = new Request.JSON( {

			url: link,

			onSuccess: function(result){

				requesting = false;

				if(obj)	obj.removeClass('jat3-loading');
				var contentHTML = '';
				if (result.successful) {
					contentHTML += "<div class=\"success-message\"><span class=\"success-icon\">"+result.successful+"</span></div>";
				}
				if (result.error) {
					contentHTML += "<div class=\"error-message\"><span class=\"error-icon\">"+result.error+"</span></div>";
				}

				this.showMessage(contentHTML);

				// Update status
				if (result.generalconfigdata) {
					profiles.generalconfigdata = request.generalconfigdata;
					var rows = $('pages_profile-ja-list-pageids').rows;
					var item = null;
					for(var i=0; i<rows.length; i++){
						item = $(rows[i]).removeClass('changed');
						
						if(item.hasClass('tchanged')){
							item.removeClass('tchanged').addClass('changed');
						}
					}
				}

				if(result.profile){
					switch (result.type){
						case 'new':{
							profilename = result.profile;
							var item = null;
							var lis = $$('#ja-profiles-content li.ja-profile');
							for(var i=0; i<lis.length; i++){
								item = lis[i];
								if(item.getElement('.ja-profile-title').get('text').toLowerCase().trim()==profilename){
									alert(lg_profile_name_exist.replace('%s', profilename));
									if(!this.saveas){
										return this.newProfile(obj, this.saveas);
									}
									else{
										$('ja-profiles-content').getElement('ul.ja-profile-titles li.default').addClass('active');
									}
									return ;
								}
								else if(item.className.indexOf('active')>-1){
									item.removeClass('active');
								}
							}

							/* add new tab */
							var tab = new Element('li', {
    							'class': 'ja-profile',
    							'events': {
    								'click': function() {
    									this.changeProfile(tab, false);
    								 }.bind(this)
								 }
    						});
							tab.addClass('active');
							tab.inject($('ja-profiles-content').getElement('ul.ja-profile-titles li.ja-profile-new'), 'before');

							var span = new Element('span', {'class':'ja-profile-title'});
							span.set('text',profilename);
							span.inject(tab);

							var span = $('ja-profiles-content').getElement('span.ja-profile-action').clone();
							span.setStyle('display', 'inline');
							span.inject(tab);

							span.addEvent ('click', function (event){
								if(span.getParent().hasClass('active')){
									this.showProfileAction(span);
									$('ja-profile-action').setStyles ({
										'top': event.page.y,
										'left': event.page.x,
										'display': 'inline'
									});
									event.stop();
								}
							}.bind(this));

							this.fillData (profilename, 'jform\\[params\\]');

							/* add new tab */
							li = new Element('li');
							li.inject($('pages_profile-ja-popup-profiles').getElement('ul.ja-popup-profiles'));
							li.innerHTML = '<a onclick="jaclass_pages_profile.select_profile(this);" href="javascript:void(0)">'+result.profile+'</a>'
						}break;

						case 'rename':{
							var lis = $('pages_profile-ja-popup-profiles').getElement('ul.ja-popup-profiles').getChildren();
							lis.each( function (li) {
								if(li.getFirst().get('text').clean()==result.profileolder){
									li.getFirst().set('text',result.profile);
								}
							});

							var span = $('ja-profiles-content').getElement('li.active span.ja-profile-title');
							if(span){
								span.set('text',result.profile);
								this.active_profile = result.profile;
							}


							var lis = $('pages_profile-ja-list-pageids').rows;
							var item = null;
							var ichange = false;
							for(var i=1; i<lis.length; i++){
								item = $(lis[i])
								if(item.getElement('span.profile_text').get('text').clean()==result.profileolder){
									item.getElement('span.profile_text').set('text',result.profile);
									item.addClass('tchanged');
									ichange = true;
								}
							}

							profiles[result.profile] =  profiles[result.profileolder];
				            profiles[result.profileolder] = null;

							jaclass_pages_profile.buildData_of_param();
							
							if(ichange){
								Joomla.submitbutton('style.apply');
							}
						}break;

						case 'delete':{
							$('ja-profiles-content').getElement('li.active').destroy();
							profiles[result.profile] = null;
							var firstitem = $('ja-profiles-content').getElement('.ja-profile');
							firstitem.addClass('active');
							this.active_profile = firstitem.get('text').trim().toLowerCase();
							this.fillData (this.active_profile, 'jform\\[params\\]');

							var lis = $('pages_profile-ja-popup-profiles').getElement('ul.ja-popup-profiles').getChildren();
							lis.each( function (li) {
								if(li.getFirst().get('text').clean()==result.profile){
									li.destroy();
								}
							});

							var lis = $('pages_profile-ja-list-pageids').rows;
							var item = null;
							var ichange = false;
							for(var i=1; i<lis.length; i++){
								item = $(lis[i]);
								if(item.getElement('span.profile_text').get('text').clean()==result.profile){
									item.getElement('span.profile_text').set('text','default');
									item.addClass('tchanged');
									ichange = true;
								}
							}
							jaclass_pages_profile.buildData_of_param();

							$('ja-profile-action').hide();
							
							if(ichange){
								Joomla.submitbutton('style.apply');
							}
							
						}break;

						case 'reset':{
							profiles[result.profile].local = null;
							profiles[result.profile].working = profiles[result.profile].core;
							this.fillData (result.profile, 'jform\\[params\\]');
							$('ja-tabswrap').getElement('li.profiles').removeClass('changed');
						}break;

						default:
							//nothing
					}

				}

				else if(result.layout){
					$('ja-layout-container').hide();

					if(layouts[this.layout]){
						layouts[result.layout] = layouts[this.layout];
					}
					
					this.layout = result.layout;

					switch (result.type){
						case 'new':{
							/* add new tab */
							var lis = $('ja-layouts-content').getElement('.ja-layout-titles').rows;
							var tr = $(lis[1]).clone();
							tr.setProperty('id', 'layout_' + result.layout);
							if(lis.length%2!=0) tr.className = 'row0';
							else tr.className = 'row1';
							tds = tr.getChildren();
							tds[0].set('text',lis.length);
							tds[1].set('text',result.layout);

							tr.inject(lis[lis.length-1], 'after');
							tds[2].set('text','');
							contentHTML = '<span class="edit" data-layout="' + result.layout + '">Edit</span> ';
							contentHTML += '<span class="clone" data-layout="' + result.layout + '">Clone</span> ';
							contentHTML += '<span class="rename" data-layout="' + result.layout + '">Rename</span> ';
							contentHTML += '<span class="delete" data-layout="' + result.layout + '">Delete</span>';
							tds[2].innerHTML = contentHTML;

							/* Add item in profile page */
							var selectors = $$('select.jat3-el-layouts');
							selectors.each(function (select){
								select.options[select.length] = new Option(result.layout, result.layout);
							});

							jatabs.resize();
						}break;

						case 'rename':{
							/*var tr = $('layout_'+result.layoutolder);
							tr.setProperty('id', 'layout_'+result.layout);
							tr.getChildren()[1].set('text',result.layout);

							contentHTML = '<span class="edit" onclick="jat3admin.editLayout(\''+ result.layout +'\')">Edit</span> ';
							contentHTML += '<span class="clone" onclick="jat3admin.saveasLayout(this, \''+ result.layout +'\')">Clone</span> ';
							contentHTML += '<span class="rename" onclick="jat3admin.renameLayout(this, \''+ result.layout +'\')">Rename</span> ';
							contentHTML += '<span class="delete" onclick="jat3admin.deleteLayout(this, \''+ result.layout +'\')">Delete</span>';

							tr.getChildren()[2].innerHTML = contentHTML;

							 Remove item in profile page
							var selectors = $$('select.jat3-el-layouts');
							selectors.getChildren().each(function (select, i){
								select.each(function (op, k){
									if(op.value.clean()==result.layoutolder){
										op.value = result.layout;
										op.text = result.layout;
									}
								})
							});*/
							if(window.location.href.indexOf('#')){
								window.location.href = window.location.href.replace('#', '') + '&tab=layout';
							}
							else{
								window.location.href = window.location.href + '&tab=layout';
							}
						}break;

						case 'delete':{
							/* Remove this row on Layout table*/
							/*layouts[result.layout].core = null;
							layouts[result.layout].local = null;
							$('layout_' + result.layout).destroy();
							jatabs.resize();

							 Remove item in profile page
							var selectors = $$('select.jat3-el-layouts');
							selectors.getChildren().each(function (select, i){
								select.each(function (op, k){
									if(op.value.clean()==result.layout){
										selectors[i].remove(k);
										return;
									}
								});

							});*/
							if(window.location.href.indexOf('#')){
								window.location.href = window.location.href.replace('#', '') + '&tab=layout';
							}
							else{
								window.location.href = window.location.href + '&tab=layout';
							}
						}break;

					}

				}

				if(result.reset && obj){
					obj.hide();
				}

				if (result.profiles) {
					for(p in result.profiles) {
						if (result.profiles[p]) {
							profiles[p].local = request['profiles'][p];
						}
					}
				}

				// Disable Default field if its value is All
				if (result.jform) {
					if (result.jform.home == 2) {
						document.adminForm.jform_home.disabled = true;
					}
				}

				// Remove class "changed" for all element
				var rows = $('jat3-profile-params').getElement('table.paramlist').rows;
				for (var i = 0; i < rows.length; i++) {
					$(rows[i]).removeClass('changed');
				}

				this.checkModifiedAll ();
			}.bind(this)
		}).post(request);

		jatabs.resize();
	},

	showMessage: function(content) {
        if ($('system-message-container')) {
            if(!$('system-message')){
                var msgobj = new Element('div', {'id': 'system-message', 'class':'clearfix'}),
                	placeholder = $('toolbar-box'),
                	rel = 'after';

                if(!placeholder){
                	placeholder = $('system-message-container');
                	rel = '';
                }

                msgobj.inject(placeholder, rel);	
            }
            $('system-message').innerHTML = content;
            if (!this.msgslider) {
                this.msgslider = new Fx.Slide('system-message');
            }
            clearTimeout(this.timer);
            this.msgslider.slideIn.delay(100, this.msgslider, 'vertical');
            this.timer = this.msgslider.slideOut.delay(10000, this.msgslider, 'vertical');
        }
	},

	hideMessage: function() {
		var slider = new Fx.Slide('system-message');
		slider.toggle('vertical');
	},

	/****  Functions of Profile  ----------------------------------------------   ****/
	resetProfile: function(profile){
		if(confirm(lg_confirm_reset_profile)){
			profiles[profile].local = null;
			var url = 'index.php?jat3action=resetProfile&jat3type=plugin&template='+template+'&profile='+profile+'&id='+styleid;
			this.submitForm(url, profiles[profile], null, 'profile');
		}
	},

	deleteProfile: function (profile){
		
		var assigned = false;
		var rows = $('pages_profile-ja-list-pageids').rows;
		for(var i = 1, il = rows.length; i < il; i++){
			if($(rows[i]).getElement('span.profile_text').get('text').clean()==profile){	
				assigned = true;
				break;
			}
		}
		
		if(confirm(assigned ? lg_confirm_delete_profile_assiged : lg_confirm_delete_profile)){
			var url = 'index.php?jat3action=deleteProfile&jat3type=plugin&template='+template+'&profile='+profile+'&id='+styleid;
			this.submitForm(url, {}, null, 'profile');
		}
	},

	renameProfile: function (current_profile){
		var profilename = prompt(lg_confirm_rename_profile + '\n\n' + lg_enter_profile_name , current_profile);
		var item = null;
		if(profilename){
			profilename = profilename.replace(/[^0-9a-zA-Z_-]/g, '').replace(/ /g, '').toLowerCase().trim();
			
			if(profilename==''){
				alert(lg_please_enter_profile_name);
				return this.renameProfile(current_profile);
			}
			else if(current_profile==profilename){
				//nothing
				return;
			}

			var lis = $$('#ja-profiles-content li.ja-profile');
			for(var i=0; i<lis.length; i++){
				item = lis[i];
				if(item.getElement('.ja-profile-title').get('text').toLowerCase().trim()==profilename){
					alert(lg_profile_name_exist.replace('%s', profilename));
					return this.renameProfile(current_profile);
				}
			}

			var url = 'index.php?jat3action=renameProfile&jat3type=plugin&template='+template+'&current_profile='+current_profile+'&new_profile='+profilename+'&id='+styleid;
			this.submitForm(url, profiles[profilename], null, 'profile');
		}
	},

	saveasProfile: function(oldprofilename){
		this.newProfile($('ja-profiles-content').getElement('li.ja-profile-new'), true, oldprofilename+'-copy');
	},

	newProfile: function(obj, saveas, oldprofilename){
		obj = $(obj);
		if(oldprofilename==null) oldprofilename = '';
		var profilename = prompt(lg_enter_profile_name, oldprofilename);

		if(profilename){
			profilename = profilename.replace(/[^0-9a-zA-Z_-]/g, '').replace(/ /g, '').toLowerCase().trim();
			
			if(profilename == ''){
				alert(lg_please_enter_profile_name);
				return this.newProfile(obj, saveas);
			}
			
			var lis = $$('#ja-profiles-content li.ja-profile');
			var item = null;
			for(var i=0; i<lis.length; i++){
				item = lis[i];
				if(item.getElement('.ja-profile-title').get('text').toLowerCase().trim()==profilename){
					alert(lg_profile_name_exist.replace('%s', profilename));
					return this.newProfile(obj, saveas, oldprofilename);
				}
			}

			var url = 'index.php?jat3action=saveProfile&jat3type=plugin&template='+template+'&profile='+profilename+'&id='+styleid;

			if(typeof(document.adminForm['default']) != 'undefined'){
				url += '&default='+document.adminForm['default'].value;
			}
			else{
				url += '&default=0';
			}

			if(saveas){
				this.saveas = true;
				profiles[profilename] = {};
				profiles[profilename].local = this.rebuildData('jform\\[params\\]');
				profiles[profilename].working = profiles[profilename].local;
			}
			else{
				this.saveas = false;
				profiles[profilename] = {};
				profiles[profilename].local = {};
				profiles[profilename].working = {};
			}
			var json = {};
			json.jsondata = profiles[profilename].working;
			this.submitForm(url, json, $('jat3-loading'), 'profile');
		}

	},

	saveProfile: function (obj){
		/* Rebuild data */
		obj = $(obj);
		var lis = $$('#ja-profiles-content .ja-profile-titles')[0].getChildren();
		var pre_Obj = null;
		for(var i=0; i<lis.length; i++){
			item = lis[i];
			if(item.className.indexOf('active')>-1){
				pre_Obj = item;
				break;
			}
		}
		var profile = '';
		if(pre_Obj && pre_Obj.getFirst()){
			profile = pre_Obj.getFirst().get('text').trim().toLowerCase();
			profiles[profile] = this.rebuildData('jform\\[params\\]');
		}
		if(profile==''){
			alert(lg_select_profile);
			return;
		}

		var url = 'index.php?jat3action=saveProfile&jat3type=plugin&template='+template+'&profile='+profile+'&id='+styleid;

		if(typeof(document.adminForm['default']) != 'undefined'){
			url += '&default='+document.adminForm['default'].value;
		}
		else{
			url += '&default=0';
		}
		if($('selections')){
			url += '&selections[]='+$('selections').getValue();
		}

		var json = {};
		json.data = profiles[profile];
		this.submitForm(url, json, obj, 'profile');
	},


	showProfileAction: function(el){
	    var jaProfileAction = $('ja-profile-action');
	    if (jaProfileAction == null) return;

		if(!el.getParent().hasClass('active')){
			jaProfileAction.hide();
			return;
		}
		var profilename = el.getPrevious().get('text').toLowerCase().trim();
		var profile = profiles[profilename];

		jaProfileAction.show();

		jaProfileAction.getElement('li.reset').hide();
		if (isNewFolderStruct) {
		    // Show clone button
		    jaProfileAction.getElement('li.saveas').show();
		    if (!profile.core) {
		        // Show rename & delete button
    		    jaProfileAction.getElement('li.rename').show();
    		    jaProfileAction.getElement('li.delete').show();
		    } else {
				jaProfileAction.getElement('li.rename').hide();
    		    jaProfileAction.getElement('li.delete').hide();
			}
		    // Set click command
		    jaProfileAction.getElement('li.saveas').onclick = function (){
	            jaProfileAction.hide();
	            this.saveasProfile(profilename);
	        }.bind(this);
	        jaProfileAction.getElement('li.rename').onclick = function (){
	            jaProfileAction.hide();
	            this.renameProfile(profilename);
	        }.bind(this);
	        jaProfileAction.getElement('li.reset').onclick = function (){
	            jaProfileAction.hide();
	            this.resetProfile(profilename);
	        }.bind(this);
	        jaProfileAction.getElement('li.delete').onclick = function (){
	            jaProfileAction.hide();
	            this.deleteProfile(profilename);
	        }.bind(this);
		} else {
		    // Hide all button
		    jaProfileAction.getElement('li.saveas').hide();
	        jaProfileAction.getElement('li.rename').hide();
	        jaProfileAction.getElement('li.delete').hide();
		}

		this.options.activePopIn = 1;
	},

	changeProfile: function (obj, isdefault){
		/* Set tab activity */
		var lis = $$('#ja-profiles-content .ja-profile-titles li.ja-profile');
		var pre_Obj = null;
		var item = null;
		for(var i=0; i<lis.length; i++){
			item = lis[i];
			if(item.className.indexOf('active')>-1){
				item.removeClass('active');
				pre_Obj = item;
				break;
			}
		}

		obj.addClass('active');

		/* Rebuild data */
		if(pre_Obj && pre_Obj.getFirst()){
			profiles[pre_Obj.getElement('.ja-profile-title').get('text').trim().toLowerCase()].working = this.rebuildData('jform\\[params\\]');
		}
		this.fillData (obj.getElement('.ja-profile-title').get('text').trim().toLowerCase(), 'jform\\[params\\]');
	},

	/****  Functions of Layout  ----------------------------------------------   ****/
	routeLayoutEvent: function(e, target){
		if(e){
			e.stop();
		}
		
		switch(target.className){
			case 'edit':
				this.editLayout(target.getProperty('data-layout'));
				break;
				
			case 'clone':
				this.saveasLayout(target, target.getProperty('data-layout'));
				break;
				
			case 'rename':
				this.renameLayout(target, target.getProperty('data-layout'));
				break;
				
			case 'delete':
				this.deleteLayout(target, target.getProperty('data-layout'));
				break;
				
			default:
				break;
		}
	},
	
	newLayout: function(obj){
		obj = $(obj);
		$('ja-layout-container').getElement('.layout-name').show();
		$('ja-layout-container').setStyles ({
			'top': window.getHeight()/2 + window.getScroll().y -$('ja-layout-container').getStyle('height').toInt()/2,
			'left': window.getWidth()/2-$('ja-layout-container').getStyle('width').toInt()/2,
			'display': 'block'
		});
		$('content_layout').value = '';
		$('name_layout').value = '';
		$('name_layout').focus();
		this.isnew = true;
	},

	editLayout: function(layout){
		$('ja-layout-container').getElement('.layout-name').hide();
		$('ja-layout-container').setStyles ({
			'top': window.getHeight()/2 + window.getScroll().y -$('ja-layout-container').getStyle('height').toInt()/2,
			'left': window.getWidth()/2-$('ja-layout-container').getStyle('width').toInt()/2,
			'display': 'block'
		});
		$('content_layout').value = layouts[layout].local!=null?layouts[layout].local:layouts[layout].core;
		$('name_layout').value = layout;
		$('content_layout').focus();
		this.layout = layout;
		this.isnew = false;
		this.contentLayout =  $('content_layout').value.clean().toString().replace (/\n/g, '').replace (/\t/g, '').replace (/\r/g, '');
	},

	cancelLayout: function(){
		layout = this.layout;
		
		if((!this.isnew && !this.layout) || $('ja-layout-container').getStyle('display') == 'none'){
			return;
		}
		
		var new_content = $('content_layout').value.clean().toString().replace (/\n/g, '').replace (/\t/g, '').replace (/\r/g, '');

		if( (!this.isnew && new_content!=this.contentLayout.trim()) || (this.isnew && new_content!='')){
			if(confirm(lg_confirm_to_cancel)){
				$('ja-layout-container').hide();
			}
		}
		else{
			$('ja-layout-container').hide();
		}
	},

	resetLayout: function(obj, layout){
		obj = $(obj);
		if(confirm(lg_confirm_reset_layout)){
			layouts[layout].local = null;
			var url = 'index.php?jat3action=resetLayout&jat3type=plugin&template='+template+'&layout='+layout+'&id='+styleid;
			this.submitForm(url, layouts[layout], obj, 'layout');
		}
	},

	deleteLayout: function (obj, layout){
		obj = $(obj);
		if(confirm(lg_confirm_delete_layout)){
			this.layout = layout;
			var url = 'index.php?jat3action=deleteLayout&jat3type=plugin&template='+template+'&layout='+layout+'&id='+styleid;
			this.submitForm(url, layouts[layout], obj, 'layout');
		}
	},

	renameLayout: function (obj, current_layout){
		obj = $(obj);
		var layoutname = prompt( lg_confirm_rename_layout + '\n\n' + lg_enter_layout_name, current_layout);
		var item = null;
		if(layoutname){
			layoutname = layoutname.replace(/[^0-9a-zA-Z_-]/g, '').replace(/ /g, '').toLowerCase();
			if (layoutname == '') {
				alert(lg_please_enter_layout_name);
				return this.renameLayout(obj, current_layout);
			}
			else if(current_layout==layoutname){
				//nothing
				return;
			}

			var lis = $('ja-layouts-content').getElement('.ja-layout-titles').rows;
			for(var i=1; i<lis.length; i++){
				item = $(lis[i]);
				if(item.id.toLowerCase().trim()=='layout_'+layoutname){
					alert(lg_layout_name_exist.replace('%s', layoutname));
					return this.renameLayout(obj, current_layout);
				}
			}
			layouts[layoutname] = layouts[current_layout];

			var url = 'index.php?jat3action=renameLayout&jat3type=plugin&template='+template+'&current_layout='+current_layout+'&new_layout='+layoutname+'&id='+styleid;
			this.submitForm(url, {}, obj, 'layout');
		}
	},

	saveasLayout: function (obj, current_layout){
		obj = $(obj);
		new_layout = current_layout+'-copy';
		var layoutname = prompt(lg_enter_layout_name, new_layout);
		this.isnew = false;
		var item = null;

		if(layoutname){
			layoutname = layoutname.replace(/[^0-9a-zA-Z_-]/g, '').replace(/ /g, '').toLowerCase();
			
			if(layoutname == ''){
				alert(lg_please_enter_layout_name);
				return this.saveasLayout(obj, current_layout);
			}
			
			var lis = $('ja-layouts-content').getElement('.ja-layout-titles').rows;
			for(var i=1; i<lis.length; i++){
				item = $(lis[i]);
				if(item.id.toLowerCase().trim()=='layout_'+layoutname){
					alert(lg_layout_name_exist.replace('%s', layoutname));
					return this.saveasLayout(obj, current_layout);
				}
			}

			layouts[layoutname] = {};
			layouts[layoutname].core = null;

			layoutindex = obj.getParent().getParent().id.substr(7);

			var obj_layout = layouts[layoutindex];
			$('content_layout').value = obj_layout.local!=null?obj_layout.local:obj_layout.core;

			layouts[layoutname].local = $('content_layout').value;

			this.layout = layoutname;
			this.saveLayout(obj);
		}

	},

	saveLayout: function (obj){
		obj = $(obj);
		var layout = '';
		if (!this.isnew) {
			layout = this.layout;
		} else {
			layout = $('name_layout').value;
		}
		layout = layout.clean().replace(/ /g, '').toLowerCase();

		if (layout == '') {
			if (this.isnew) {
				alert(lg_please_enter_layout_name);
				$('name_layout').focus();
			} else {
				alert(lg_select_layout);
			}
			return;
		}

        var content = $('content_layout').value.trim();
        // Check validate data
        var result = this.validateXML(content);
        if (result != null) {
            alert(result);
            return;
        }

		if (this.isnew) {
			var item = null;
			var lis = $('ja-layouts-content').getElement('.ja-layout-titles').rows;
			for(var i=1; i<lis.length; i++){
				item = $(lis[i]);
				if(item.id.toLowerCase().trim()=='layout_'+layout){
					alert(lg_layout_name_exist.replace('%s', layout));
					$('name_layout').focus();
					return ;
				}
			}
		}

		if (this.isnew) {
			this.layout = layout;
			layouts[layout] = {};
			layouts[layout].core = null;
			layouts[layout].local = ' ';
		}

		layouts[layout].local = content;
		var json = {};
		json['data'] = content.replace (/\n/g, '\\n').replace (/\t/g, '\\t').replace (/\r/g, '');

		var url = 'index.php?jat3action=saveLayout&jat3type=plugin&template='+template+'&layout='+layout+'&id='+styleid;
		this.submitForm(url, json, obj, 'layout');
	},

	updateGfont: function(obj, msg) {
		if(!requesting){
			requesting = true;
		} else return;

		if (!confirm(msg)) return;

		obj = $(obj);

		var json = {};
		var link = 'index.php?jat3action=updateGfont&jat3type=plugin&template='+template;

		if (obj) obj.addClass('jat3-loading');
		var jSonRequest = new Request.JSON({
			url: link,
			onFailure: function() {alert('failure');},
			onSuccess: function(result){
				requesting = false;
				if (obj) obj.removeClass('jat3-loading');

				if (result.successful) {
					if (confirm(result.successful)) {
						location.reload();
					}
				}
				else if (result.error) {
					alert(result.error);
				}
			}.bind(this)
		}).post(json);
	},

	rebuildData: function (group){
		var els = this.serializeArray(group);
		var json = {};
		els.each(function(el){
			var rel = el.getProperty('rel');
			var name = this.getName(el, group);
			var cb = $('cb_'+name);

			if( name != '' && ( !cb || ( cb &&  cb.checked==true )) ){
				json[name] = el.getValue(rel).toString().replace (/\n/g, '\\n').replace (/\t/g, '\\t').replace (/\r/g, '');
			}

		}, this);
		return json;
	},

	fillData: function (profile, group){
		this.active_profile = profile;
		var els = this.serializeArray(group);

		if(els.length==0) return;

		if (profiles[profile] == undefined) return;

		var cprofile = profiles[profile].working;
		var dprofile = profiles['default'].working;

		els.each( function(el){
			var name = this.getName(el, group);
			var rel = el.getProperty('rel');
			var el_tr = this.getParentofelement(el);

			if(profile != 'default'){
				/* add checkbox if not default */
				if(!$('cb_' + name) && el_tr){
					var checkbox = new Element('span', {
						'id'	: 'cb_' + name,
						'value'	: '1',
						'class' : 'cb-span',
						'events': {
							'click': function (){
								if(!this.checked){
									el_tr.removeClass('disabled');
									el.enable(rel);
									this.checked = true;
									this.addClass ('cb-span-checked');
								}
								else{
									el_tr.addClass('disabled');
									el.disable(rel);
									this.checked = false;
									this.removeClass ('cb-span-checked');
								}
								// trigger change for jquery chosen select.
								if (typeof jQuery != 'undefined') {
									if (jQuery('#'+el.id).length)
										jQuery('#'+el.id).trigger("liszt:updated");
									jQuery('#'+el.id).trigger('change'); // fix for jquery chosen with jadepend.
								}
							}
						}
					});
					if (el_tr.tagName == 'LI') {
						checkbox.inject(el_tr);
					} else {
						checkbox.inject(el_tr.getLast());
					}
					checkbox.checked = false;
				}
				if ($('cb_' + name)) {
				    // Check is new folder struct
				    if (isNewFolderStruct) {
				        $('cb_' + name).show();
				    } else {
				        $('cb_' + name).hide();
				    }
				}
			} else {
				if ($('cb_' + name)) {
					$('cb_' + name).hide();
					$('cb_' + name).checked = true;
				}
			}
			var value = (cprofile[name] != undefined)?cprofile[name]:((dprofile[name] != undefined)?dprofile[name]:'');

			if (profile == 'default' || cprofile[name] != undefined) {
				el_tr.removeClass('disabled');
				el.enable (rel);
				if ($('cb_' + name)) {
					$('cb_' + name).checked = true;
					$('cb_' + name).addClass ('cb-span-checked');
				}
			} else {
				el_tr.addClass('disabled');
				el.disable (rel);
				if ($('cb_' + name)) {
					$('cb_' + name).checked = false;
					$('cb_' + name).removeClass ('cb-span-checked');
				}
			}
			el.setValue(value, rel);
			// trigger change for jquery chosen select.
			if (typeof jQuery != 'undefined') {
				if (jQuery('#'+el.id).length)
					jQuery('#'+el.id).trigger("liszt:updated");
				jQuery('#'+el.id).trigger('change'); // fix for jquery chosen with jadepend.
			}
			// Disable when use old folder structure
			if (!isNewFolderStruct) {
			    el.disable(rel);
			}
		}, this);
	},

	validateXML: function(txt) {
	    var result = null;

	    if (window.ActiveXObject) { // code for IE
	        var xmlDoc = new ActiveXObject("Microsoft.XMLDOM");
	        xmlDoc.async="false";
	        xmlDoc.loadXML(txt);

	        if (xmlDoc.parseError.errorCode != 0) {
	            //result = "Error Code: " + xmlDoc.parseError.errorCode + "\n";
	            //result = result + "Error Reason: " + xmlDoc.parseError.reason;
	            //result = result + "Error Line: " + xmlDoc.parseError.line;
	            result = lg_invalid_xml_format;
	        }
	    } else if (document.implementation.createDocument) {  // code for Mozilla, Firefox, Opera, etc.
	        var parser = new DOMParser();
	        var xmlDoc = parser.parseFromString(txt,"text/xml");

	        if (xmlDoc.getElementsByTagName("parsererror").length > 0) {
	            //result = xmlDoc.getElementsByTagName("parsererror")[0].get('text');
	            result = lg_invalid_xml_format;
	        }
	    }
	    return result;
	},

	fillDataGeneral: function (){
		var group = 'jform\\[general\\]';
		var els = this.serializeArray(group);
		if(els.length==0) return;

		if (profiles['generalconfigdata'] == undefined) return;
		var data = profiles['generalconfigdata'];

		els.each( function(el){
			var name = this.getName(el, group);
			var value = (data[name] != undefined)?data[name]:((data[name] != undefined)?data[name]:'');

			el.setValue(value);
			// trigger change value for jquery chosen select.
			if (typeof jQuery != 'undefined') {
				if (jQuery('#'+el.id).length)
					jQuery('#'+el.id).trigger("liszt:updated");
			}
		}, this);
	},

	serializeArray: function(group){
		var els = new Array();
		var allelements = $('style-form').elements;

		var k = 0;
		for (i=0;i<allelements.length;i++) {
		    var el = $(allelements[i]);
		    if (el.name && ( el.name.test (group+'\\[.*\\]' || el.name.test (group+'\\[.*\\]\\[\\]'))) ){
		    	els[k] = $(el);
		    	k++;
		    }
		}
		return els;
	},

	getName: function (el, group){
		if (matches = el.name.match(group+'\\[([^\\]]*)\\]')) return matches[1];
		return '';
	},

	getParentofelement: function(el){
		var parent = $(el).getParent();
		if(parent.tagName != 'LI' && parent.tagName != 'TR'){
			return this.getParentofelement(parent);
		}
		else{
			return parent;
		}
	},

	removeTheme: function (obj, theme, template){
		obj = $(obj);
		this.theme_active = theme;

		if(theme=='' || template==''){
			alert(lg_invalid_info);
			return;
		}
		if(confirm(lg_confirm_delete_theme)){
			this.row_active = obj;
			obj.getFirst().src = imgloading;

			var linkurl = 'index.php?jat3action=removeTheme&jat3type=plugin&template='+template+'&theme='+theme+'&id='+styleid;
			new Request({url: linkurl, method:'post', onSuccess:this.updateTheme.bind(this)}).send();
		}
	},

	updateTheme: function (text){
		if (text != '') {
		    var contentHTML = "<div class=\"error-message\"><span class=\"error-icon\">" + text + "</span></div>";
		    this.showMessage(contentHTML);
			this.row_active.getFirst().src = imgdelete;
		} else {
			if(window.location.href.indexOf('#')){
				window.location.href = window.location.href.replace('#', '') + '&tab=theme';
			} else {
				window.location.href = window.location.href + '&tab=theme';
			}
		}
	},

	clearData: function(){
		if (this.options.activePopIn == 1) {
			$('ja-profile-action').hide();
			this.options.activePopIn = 0;
		}
	},

	closeHelp: function(){
		$('jat3-help-content').hide();
	},

	showHelp: function(obj){
		obj = $(obj);
		if(obj.getStyle('display')=='none'){
			obj.show();
		}
		else{
			obj.hide();
		}
		jatabs.resize();
	},

	controlHelp: function(){
		/*New Wrap help*/
		var helpwrap = $('jat3-help-content');
		if(helpwrap==null){
			helpwrap = new Element('div', {'id':'jat3-help-content', 'class':'ja-tool-tip right tool'}).inject($(document.body));
		}

		var wrap = $('style-form').getElement('fieldset.adminform');

		helpwrap.setStyle('width', (wrap ? wrap.offsetWidth : Math.floor($(window).getWidth() * 40 / 100)) +10 );
		helpwrap.setStyle('height', $(document.body).getSize().y);


		/*New Wrap content help*/
		var helpwrapcontent = $('jat3-help-content-wrap');
		helpwrapcontent.inject($('jat3-help-content'));


		/*New Button help*/
		var bthelp = new Element('div', {
			'id': 'ja-icon-help',
			'class': $('ja-tabswrap').getElement('ul.ja-tabs-title li.active span').className,
			'events': {
				'click': function(){
					if (helpwrap.getStyle('display')!='none') {
						helpwrap.hide();
					} else {
						helpwrap.show();
						helpwrapcontent.getElement('div.tool-text').innerHTML = $('ja-tabswrap').getElement('ul.ja-tabs-title li.active').getElement('div.ja-subcontent-help').innerHTML;
						window.fireEvent('resize');
					}
				}
			}
		});

		bthelp.inject($('ja-tabswrapmain'), 'before');
		bthelp.innerHTML = '<a href="javascript:void(0)" title="Help">Help</a>';

		$$('#ja-tabswrap ul.ja-tabs-title li').each(function(el){
			el.addEvent('click', function(){
				if (!el.hasClass('help-support')) {
					bthelp.show();
					bthelp.className = el.getElement('span').className;
					helpwrapcontent.className = el.getElement('span').className;
					helpwrapcontent.getElement('div.tool-text').innerHTML = el.getElement('div.ja-subcontent-help').innerHTML;
					window.fireEvent('resize');
				}
				else {
					helpwrap.hide();
					bthelp.hide();
				}
			})
		});

		window.addEvent('resize', function(){this.resizeHelp()}.bind(this));
	},

	resizeHelp: function(){
		var wrap = $('style-form').getElement('div.width-60');
		var helpwrapcontent = $('jat3-help-content-wrap');//alert($('style-form').getElement('div.width-40').offsetLeft)
		var bleft = $('style-form').getElement('div.width-40');

		helpwrapcontent.setStyle('width', bleft ? bleft.offsetLeft : Math.floor($(window).getWidth() * 40 / 100));
		helpwrapcontent.setStyle('top', 165);
		helpwrapcontent.setStyle('left', 10);
		helpwrapcontent.className = $('ja-tabswrap').getElement('ul.ja-tabs-title li.active span').className;

		helpwrapcontent.getElement('div.tool-text').setStyle('max-height', window.getSize().y-$('jat3-help-content-wrap').offsetTop-90);

		if (helpwrapcontent.offsetHeight > window.getSize().y - helpwrapcontent.offsetTop - 40) {
			helpwrapcontent.getElement('div.tool-text').setStyle('overflow-y', 'scroll');
		} else {
			helpwrapcontent.getElement('div.tool-text').setStyle('overflow-y', 'hidden');
		}

	},

	convertFolder: function() {
	    // Filter double request
	    if (requesting) {
	        return;
	    }
		// Confirm to convert folder
		if (!confirm(lg_confirm_convert_folder)) return;
		// Show loading
        $('convert-message').getElement('a').setStyles({
            'background-image' : 'url(' + imgloading + ')',
            'background-repeat': 'no-repeat'
        });
        requesting = true;
	    // Request
	    var link = 'index.php?jat3action=convertFolder&jat3type=plugin&template='+template+'&id='+styleid;
	    new Request.JSON({
	        url: link,
	        onSuccess: function(res, responseText) {
				requesting = false;
	            $('convert-message').getElement('a').setStyle('background-image', 'none');

	            if (res.error) {
	                $('convert-message').innerHTML = res.error;
	            } else if (res.success) {
	                $('convert-message').innerHTML = res.success + lg_convert_folder_success;

					(function(){
						window.location.reload(true);
					}).delay(5000);

	            }
	        },
	        onFailure: function(xhr) {
	            requesting = false;
	            $('convert-message').getElement('a').setStyle('background-image', 'none');
	        }
	    }).send();
	}
});

Element.implement ({

	getType: function() {
		var tag = this.tagName.toLowerCase();
		switch (tag) {
			case 'select':
			case 'textarea':
				return tag;
			case 'input':
				if(this.type && ( this.type=='text' || this.type=='password' || this.type=='hidden')){
					return this.type;
				}
				else{
					return  document.getElementsByName(this.name)[0].type;
				}
			default:
				return '';
		}
	},
	show: function(){
		if(this.getStyle('display') == 'none'){
			this.setStyle('display', 'block');
		}
	},
	hide: function(){
		this.setStyle('display', 'none');
	},
	disable: function (rel){
		if(rel!='null' && typeOf(window[rel+'_disable'])=='function'){
			window[rel+'_disable'](this.id);
		}
		else{
			switch (this.getType().toLowerCase()) {
				case 'submit':
				case 'hidden':
				case 'password':
				case 'text':
				case 'textarea':
				case 'select':
					this.disabled = true;
					break;
				case 'checkbox':
				case 'radio':
					fields = document.getElementsByName(this.name);
					(Array.each || window.$each)(fields, function(option){
						option.disabled = true;
					});

			}
		}
	},

	enable: function (rel){
		if(rel!='null' && typeOf(window[rel+'_enable'])=='function'){
			window[rel+'_enable'](this.id);
		}
		else{
			switch (this.getType().toLowerCase()) {
				case 'submit':
				case 'hidden':
				case 'password':
				case 'text':
				case 'textarea':
				case 'select':
					this.disabled = false;
					break;
				case 'checkbox':
				case 'radio':
					fields = document.getElementsByName(this.name);
					(Array.each || window.$each)(fields, function(option){
						option.disabled = false;
					});

			}
		}
	},

	setValue : function(newValue, rel) {
		if(rel!='null' && typeOf(window[rel+'_setValue'])=='function'){
			window[rel+'_setValue'](this.id, newValue);
		}
		else{

			switch (this.getType().toLowerCase()) {
				case 'submit':
				case 'hidden':
				case 'password':
				case 'text':
				case 'textarea':
					this.value=newValue;
					break;
				case 'checkbox':
					this.setInputCheckbox(newValue);
					break;
				case 'radio':
					this.setInputRadio(newValue);
					break;
				case 'select':
					this.setSelect(newValue);
					break;
			}
			this.fireEvent('change');
			this.fireEvent('click');
		}
	},

	getValue: function (rel){
		if(rel!='null' && typeOf(window[rel+'_getValue'])=='function'){
			return window[rel+'_getValue'](this.id);
		}
		else{

			switch (this.getType().toLowerCase()) {
				case 'submit':
				case 'hidden':
				case 'password':
				case 'text':
				case 'textarea':
					return this.value;
				case 'checkbox':
					return this.getInputCheckbox();
				case 'radio':
					return this.getInputRadio();
				case 'select':
					return this.getSelect();
			}

			return false;
		}
	},

	setInputCheckbox : function( newValue) {
		fields = document.getElementsByName(this.name);
		arr_value = fields.length>1?newValue.split(','):new Array(newValue);

		for(var i=0; i<fields.length; i++){
			var option = fields[i];
			option.checked = false;
			if(arr_value.contains(option.value)){
				option.checked = true;
			}
		}
	},

	setInputRadio : function( newValue) {
		fields = document.getElementsByName(this.name);

		for(var i=0; i<fields.length; i++){
			var option = fields[i];
			option.checked = false;
			if(option.value==newValue){
				option.checked = true;
			}
		}
	},

	setSelect : function(newValue) {
		arr_value = this.multiple? newValue.split(','):new Array(newValue+"");
		var selected = false;

		for(var i=0; i<this.options.length; i++){
			var option = this.options[i];
			option.selected = false;
			if (arr_value.contains (option.value)) {
				option.selected = true;
				selected = true;
			}
		}

		if(!selected){
			this.options[0].selected = true;
		}
	},

	getInputCheckbox : function() {
		var values = [];
		fields = document.getElementsByName(this.name);
		for(var i=0; i<fields.length; i++){
			var option = fields[i];
			if (option.checked) values.push(Array.pick([option.value, option.text]));
		}
		return values;
	},

	getInputRadio : function( ) {
		var values = [];
		fields = document.getElementsByName(this.name);
		(Array.each || window.$each)(fields, function(option){
			if (option.checked) values.push(Array.pick([option.value, option.text]));
		});
		return values;
	},

	getSelect : function() {
		var values = [];
		for(var i=0; i<this.options.length; i++){
			var option = this.options[i];
			if (option.selected) values.push(Array.pick([option.value, option.text]));
		}
		return (this.multiple) ? values : values[0];
	}
});