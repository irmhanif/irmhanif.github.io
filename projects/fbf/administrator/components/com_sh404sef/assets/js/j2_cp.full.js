/**
 * sh404SEF - SEO extension for Joomla!
 *
 * @author      Yannick Gaultier
 * @copyright   (c) Yannick Gaultier - Weeblr llc - 2018
 * @package     sh404SEF
 * @license     http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @version     4.13.2.3783
 * @date    2018-01-25
 */

var shQuickControlNeedsUpdate = false;
var shAnalyticsCompletedRequestsList = {};
var shAnalyticsProgress = null;
var shAnalyticsOptions = null;

function shSetupQuickControl() {
  var url = "index.php?option=com_sh404sef&c=configuration&view=configuration&layout=qcontrol&format=raw&tmpl=component&noMsg=1";
  new Request.HTML({
    url : url,
    method : 'get',
    onSuccess : function(responseTree, responseElements, responseHTML,
        responseJavaScript) {
      shUpdateQuickControl(responseHTML);
    },
    onFailure : function(xhr) {
      shUpdateQuickControl('Server not responding for Quick control');
    }
  }).get();
}

function shUpdateQuickControl(response) {

  document.id('qcontrolcontent').set("html", response);

  shUpdateTooltips();

  setTimeout("document.id('sh-message-box').empty()", 3000);
  setTimeout("document.id('sh-error-box').empty()", 5000);

}

function shUpdateTooltips() {

  $$('.hasTip').each(function(el) {
    var title = el.get('title');
    if (title) {
      var parts = title.split('::', 2);
      el.store('tip:title', parts[0]);
      el.store('tip:text', parts[1]);
    }
  });

  var AnalyticsTooltips = new Tips($$('.hasTip'), {
    maxTitleChars : 50,
    fixed : false
  });
}

function shSetupSecStats(task) {
  task = task ? task : 'showsecstats';
  var url = "index.php?option=com_sh404sef&task=" + task
      + "&layout=secstats&format=raw&tmpl=component&noMsg=1";
  var update = document.id("sh-progress-cpprogress").empty();
  update.set("html", "<div class='sh-ajax-loading'>&nbsp;</div>");
  new Request.HTML({
    url : url,
    method : 'get',
    onSuccess : function(responseTree, responseElements, responseHTML,
        responseJavaScript) {
      update.empty();
      shUpdateSecStats(responseHTML);
    },
    onFailure : function(xhr) {
      update.empty();
      shUpdateSecStats('Server not responding for security stats');
    }
  }).get();
}

function shUpdateSecStats(response) {

  document.id('secstatscontent').set("html", response);
  setTimeout("document.id('sh-message-box').empty()", 3000);
  setTimeout("document.id('sh-error-box').empty()", 5000);

}

function shSetupUpdates(forced) {
  forced = forced ? "forced=1" : 'forced=0';
  var url = "index.php?option=com_sh404sef&task=showupdates&layout=updates&format=raw&tmpl=component&noMsg=1&"
      + forced;
  var update = document.id("sh-progress-cpprogress").empty();
  update.set("html", "<div class='sh-ajax-loading'>&nbsp;</div>");
  new Request.HTML({
    url : url,
    method : 'get',
    onSuccess : function(responseTree, responseElements, responseHTML,
        responseJavaScript) {
      update.empty();
      shUpdateUpdates(responseHTML);
    },
    onFailure : function(xhr) {
      update.empty();
      shUpdateUpdates('Server not responding for Updates check');
    }
  }).get();
}

function shUpdateUpdates(response) {

  document.id('updatescontent').set("html", response);
  setTimeout("document.id('sh-message-box').empty()", 3000);
  setTimeout("document.id('sh-error-box').empty()", 5000);

}

function shAnalyticsRequestCompleted(req) {

  shAnalyticsCompletedRequestsList.set(req, true);
  completed = true;
  shAnalyticsCompletedRequestsList.each(function(value, key) {
    completed = completed && value;
  });
  if (completed) {
    shAnalyticsProgress.empty();
    setTimeout('shRefreshTooltips();', 250);
  }

}

function shRefreshTooltips() {
  
  $$('.hasAnalyticsTip').each(function(el) {
    var title = el.get('title');
    if (title) {
      var parts = title.split('::', 2);
      el.store('tip:title', parts[0]);
      el.store('tip:text', parts[1]);
    }
  });
  var AnalyticsTooltips = new Tips($$('.hasAnalyticsTip'), {
    maxTitleChars : 50,
    fixed : false
  });
}

function shSetupAnalytics(options) {

  shAnalyticsOptions = options || {};

  shAnalyticsProgress = document.id("sh-progress-analyticsprogress");
  shAnalyticsProgress
      .set("html", "<div class='sh-ajax-loading'>&nbsp;</div>");

  var defaultOptions = {
    forced : 0,
    showFilters : 'yes',
    accountId : '',
    groupBy : '',
    startDate : '',
    endDate : '',
    cpWidth : 0,
    report : 'dashboard',
    subrequest : 'visits'
  };

  forced = "forced="
      + (shAnalyticsOptions.forced ? shAnalyticsOptions.forced
          : defaultOptions.forced);

  shAnalyticsOptions.showFilters = shAnalyticsOptions.showFilters ? shAnalyticsOptions.showFilters : defaultOptions.showFilters;
  showFilters = "&showFilters="
      + (shAnalyticsOptions.showFilters ? shAnalyticsOptions.showFilters
          : defaultOptions.showFilters);

  // is account Id selected by user ?
  var accountIdEl = document.id('accountId');
  accountId = accountIdEl ? "&accountId=" + accountIdEl.value
      : defaultOptions.accountId;
  var startDateEl = document.id('startDate');
  startDate = startDateEl ? "&startDate=" + startDateEl.value
      : defaultOptions.startDate;
  var endDateEl = document.id('endDate');
  endDate = endDateEl ? "&endDate=" + endDateEl.value
      : defaultOptions.endDate;
  var reportEl = document.id('report');
  report = "&report=" + (reportEl ? reportEl.value : defaultOptions.report);
  var groupByEl = document.id('groupBy');
  groupBy = "&groupBy="
      + (groupByEl ? groupByEl.value : defaultOptions.groupBy);
  var cpEl = document.id('sh404sef-analytics-wrapper');
  cpWidth = "&cpWidth=" + (cpEl ? cpEl.offsetWidth : defaultOptions.cpWidth);
  shAnalyticsOptions.url = "index.php?option=com_sh404sef&view=analytics&format=raw&tmpl=component&noMsg=1&"
      + forced
      + showFilters
      + report
      + accountId
      + groupBy
      + cpWidth
      + startDate + endDate;

  if (shAnalyticsOptions.showFilters == 'yes') {
    shAnalyticsCompletedRequestsList = new Hash({
      'headers' : false,
      'visits' : false,
      'sources' : false,
      'global' : false,
      'perf' : false,
      'topsocialfb': false,
      'topsocialtweeter': false,
      'topsocialpinterest': false,
      'topsocialplusone': false,
      'topsocialplusonepage': false,
      'top5urls' : false,
      'top5referrers' : false
    });
  } else {
    shAnalyticsCompletedRequestsList = new Hash({
      'headers' : false,
      'visits' : false,
    });
  }

  // don't empty headers!
  shAnalyticsCompletedRequestsList.each(function(value, key) {
    if (key != "headers") {
      try{
      document.id("analyticscontent_" + key).empty();
      } catch (e) {
        //alert(key);
      }
    }
  });

  _shPerformAnalyticsSubRequest('headers');
  _shPerformAnalyticsSubRequest('visits');

  if (shAnalyticsOptions.showFilters == 'yes') {
  for ( var i = 1; i < 11; i++) {
    setTimeout('shContinueAnalytics' + i + '();', 600 * i);
  }

}
}

function shContinueAnalytics1() {

  _shPerformAnalyticsSubRequest('sources');

}

function shContinueAnalytics2() {

  _shPerformAnalyticsSubRequest('global');
}

function shContinueAnalytics3() {

  //_shPerformAnalyticsSubRequest('perf');

}

function shContinueAnalytics4() {

  _shPerformAnalyticsSubRequest('top5urls');

}

function shContinueAnalytics5() {

  _shPerformAnalyticsSubRequest('top5referrers');
}

function shContinueAnalytics6() {

  _shPerformAnalyticsSubRequest('topsocialfb');
}
function shContinueAnalytics7() {

  _shPerformAnalyticsSubRequest('topsocialtweeter');
}
function shContinueAnalytics8() {

  _shPerformAnalyticsSubRequest('topsocialpinterest');
}
function shContinueAnalytics9() {

  _shPerformAnalyticsSubRequest('topsocialplusone');
}
function shContinueAnalytics10() {

  _shPerformAnalyticsSubRequest('topsocialplusonepage');
}

function _shPerformAnalyticsSubRequest(subrequestname) {

  new Request.HTML({
    url : shAnalyticsOptions.url + '&subrequest=' + subrequestname,
    method : 'get',
    onSuccess : function(responseTree, responseElements, responseHTML,
        responseJavaScript) {
      shAnalyticsRequestCompleted(subrequestname);
      shUpdateAnalytics(responseHTML, subrequestname);
    },
    onFailure : function(xhr) {
      shAnalyticsRequestCompleted(subrequestname);
      shUpdateAnalytics('Server not responding for ' + subrequestname, subrequestname);
    }
  }).get();
}

function shUpdateAnalytics(response, subrequest) {

  document.id('analyticscontent_' + subrequest).set("html", response);
  id = document.id('startDate');
  if (id) {
    Calendar.setup({
      inputField : "startDate", // id of the input field
      ifFormat : "%Y-%m-%d", // format of the input field
      button : "startDate_img", // trigger for the calendar (button ID)
      align : "Bl", // alignment (defaults to "Bl")
      singleClick : true
    });
    Calendar.setup({
      inputField : "endDate", // id of the input field
      ifFormat : "%Y-%m-%d", // format of the input field
      button : "endDate_img", // trigger for the calendar (button ID)
      align : "Tl", // alignment (defaults to "Bl")
      singleClick : true
    });
  }
  setTimeout("document.id('sh-message-box').empty()", 3000);
  setTimeout("document.id('sh-error-box').empty()", 5000);

}

function shSubmitQuickControl() {

  var form = document.id('adminForm');

  // Create a progress indicator
  var update = document.id("sh-progress-cpprogress").empty();
  update.set("html", "<div class='sh-ajax-loading'>&nbsp;</div>");
  document.id("sh-error-box").empty();

  // Set the options of the form"s Request handler.
  var onSuccessFn = function(response) {
    var message;
    //alert(response);
    message = "<div id='error-box-content'><ul><li>Sorry, something went wrong on the server while performing this action. Please try again or contact administrator</li></ul></div>";

    // remove progress indicator
    var update = document.id("sh-progress-cpprogress").empty();

    // insert results
    shUpdateQuickControl(response);

  };

  form.set('send', {
    url : 'index.php',
    method : 'post',
    onSuccess : onSuccessFn
  });

  // Send the form.
  form.send();

}
