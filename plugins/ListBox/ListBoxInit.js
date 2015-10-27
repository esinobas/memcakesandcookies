/**
 * Function to init the listboxes in the web
 */

var ListBoxInit = ListBoxInit || {};

ListBoxInit.execute = function(paramSelectedFirstItem){
   
   JSLogger.getInstance().registerLogger("ListBox", JSLogger.levelsE.TRACE);
   JSLogger.getInstance().traceEnter();
   var selectedFirstItem = typeof paramSelectedFirstItem !== 'undefined' ? paramSelectedFirstItem : false; 
   
   $('.ListBoxItem').click(function(){
      JSLogger.getInstance().traceEnter();
      $(this).parent().find('.ListBoxItem').removeClass('ListBoxItemSelected');
      $(this).addClass('ListBoxItemSelected');
      JSLogger.getInstance().traceExit();
   });
   
   if (selectedFirstItem){
      JSLogger.getInstance().trace("The first item must be selected");
      
      
      $('.ListBox').each(function(){
         JSLogger.getInstance().trace("Selecting first element for ListBox [ #" +
               $(this).attr('id') +" ]");
         $(this).find('.ListBoxItem').first().addClass('ListBoxItemSelected');
      
      });
   } 
   JSLogger.getInstance().traceExit();
}