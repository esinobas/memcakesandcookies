
/**
 * File with the function for setup the vertical tabs are in a web page.
 * The function formates the tabs in a web page.
 * The function is loaded when the page has been loaded and adds the 
 * functionality to all the tabs in the page web
 * 
 * Uses:
 * <div class="Vertical-Tabs">
 *    <ul class="Title-Tabs">
 *       <li><a href="#Tab-number1">title tab number 1</a></li>
 *       ...
 *       <li><a href="#Tab-numberN">title tab number N</a></li>
 *    </ul>
 *    <div class="Vertical-Tab" id="Tab-number1">
 *        Tab-number 1 content
 *    </div>
 *    ...
 *    <div class="Vertical-Tab" id="Tab-numberN">
 *        Tab-number N content
 *    </div>
 *  </div>
 *  
 *  Add in the html source the following command:
 *  
 */

JSLogger.getInstance().registerLogger("Vertical-Tabs",JSLogger.levelsE.TRACE);

$(function(){
   JSLogger.getInstance().traceEnter();
   $('.Vertical-Tabs').each(function(theIndex){
      JSLogger.getInstance().traceEnter();
      JSLogger.getInstance().trace("Hide all tabs from Tabs [ " + theIndex + " ]");
      $(this).find('.Vertical-Tab').hide();
      $(this).find('.Title-Tabs ul li').removeClass('active');
      JSLogger.getInstance().trace("Show the first tab from Tabs [ " + theIndex + " ]");
      $(this).find('.Vertical-Tab:first').show();
      JSLogger.getInstance().trace("Add the click event to tab from Tabs [ " + theIndex + " ]");
      
      //Get the max length of all tabs titles
      var maxLength = 0;
      $(this).find('.Title-Tabs ul li').each(function(theIndex){
         JSLogger.getInstance().traceEnter();
         JSLogger.getInstance().trace("The Index [ " + theIndex +" ]");
         $(this).addClass('active');
         JSLogger.getInstance().trace("Width Index [ " + theIndex +" ]. [ "+ 
               $(this).css('width')+" ]");
         
         if (maxLength < parseInt($(this).css('width'))){
            JSLogger.getInstance().trace("Change maxLength [ "+ maxLength + " -> " +
                  parseInt($(this).css('width')) + " ]");
            maxLength = parseInt($(this).css('width'));
         }
         $(this).removeClass('active');
         JSLogger.getInstance().traceExit();
      });
      
      JSLogger.getInstance().trace("Max width [ " + maxLength + "px ]");
      $(this).find('.Title-Tabs ul li').css('width', maxLength + "px");
      
      var localTabs = $(this);
      $(this).find('.Title-Tabs ul li:first').addClass('active');
      $(this).find('.Title-Tabs ul li').click(function(){
         JSLogger.getInstance().traceEnter();
         var activeTab = $(this).find('a').attr('href');
         JSLogger.getInstance().trace("Active tab [ " + activeTab +" ]");
         localTabs.find('.Vertical-Tab').hide();
         localTabs.find('.Title-Tabs ul li').removeClass('active');
         $(activeTab).show();
         $(this).addClass('active');
         JSLogger.getInstance().traceExit();
      });
      
      JSLogger.getInstance().traceExit();
   });
   JSLogger.getInstance().traceExit();
}
)