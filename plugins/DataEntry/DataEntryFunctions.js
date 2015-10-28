/**
 * File that contains the funtions that allow access to the data values of
 * a data entry form or window
 */

var DataEntryFunctions = DataEntryFunctions || {};

/**
 * Private constantes
 */
const dataEntryRowClass_C = '.DataEntryRow';
const dataEntryLabelClass_C = '.DataEntryLabel';
const dataEntryValueClass_C =  '.DataEntryValue';

/**
 * Private variables
 */

/**
 * Object that allows trace the flow
 */
JSLogger.getInstance().registerLogger("DataEntryFunctions", JSLogger.levelsE.TRACE);

/**
 * Get all values of the html container and they are returned in a json object
 * 
 * @param theHtmlId: The html object identificator for access to its input objects
 *                   and get their values.
 * @return: A JSON object with the values of all form or window inputs.
 */
 
DataEntryFunctions.getValues = function(theHtmlId){
   
   JSLogger.getInstance().traceEnter();
   JSLogger.getInstance().trace("The html object is [ " + theHtmlId +" ]");
   JSLogger.getInstance().trace("The object has [ " +
                     $(theHtmlId).find(dataEntryRowClass_C).size() +
                     " ] values");
   $(theHtmlId).find(dataEntryRowClass_C).each(function(theIndex){
         JSLogger.getInstance().trace("The Index each commnad [ " + theIndex + " ]");
         var label = $(this).find(dataEntryLabelClass_C).attr('id');
         var value = $(this).find(dataEntryValueClass_C).find('input').val();
         JSLogger.getInstance().trace("Label [ " + label + " ]. Value [ " +
                                       value +" ]");
      }
   );
   JSLogger.getInstance().traceExit();
}