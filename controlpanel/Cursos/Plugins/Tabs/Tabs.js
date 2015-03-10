/**
 * File with the function for setup the tabs are in a web page.
 * The function formmates the tabs in a web page.
 * The function is loaded when the page has been loaded and adds the 
 * functionality to all the tabs in the page web
 */

JSLogger.getInstance().registerLogger("Tabs",JSLogger.levelsE.TRACE);

$(function(){
   JSLogger.getInstance().traceEnter();
   $('.class-tabs').each(function(theIndex){
      JSLogger.getInstance().traceEnter();
      JSLogger.getInstance().trace("Hide all tabs from Tabs [ " + theIndex + " ]");
      $(this).find('.class-tab').hide();
      $(this).find('ul.title-tab li').removeClass('active');
      JSLogger.getInstance().trace("Show the first tab from Tabs [ " + theIndex + " ]");
      $(this).find('.class-tab:first').show();
      JSLogger.getInstance().trace("Add the click event to tab from Tabs [ " + theIndex + " ]");
      var localTabs = $(this);
      $(this).find('ul.title-tab li:first').addClass('active');
      $(this).find('ul.title-tab li').click(function(){
         JSLogger.getInstance().traceEnter();
         var activeTab = $(this).find('a').attr('href');
         JSLogger.getInstance().trace("Active tab [ " + activeTab +" ]");
         localTabs.find('.class-tab').hide();
         localTabs.find('ul.title-tab li').removeClass('active');
         $(activeTab).show();
         $(this).addClass('active');
         JSLogger.getInstance().traceExit();
      });
      
      JSLogger.getInstance().traceExit();
   });
   JSLogger.getInstance().traceExit();
}
)