
<?php
//Fichero que cotiene funciona para manipular directorios y ficheros

/**
 * Function that returns the files that are in a directory
 *
 * @param theDirectory: The directory that is scanned
 * @return: An array with the files that are contained in a directory.
 */
function getDirectoryFiles($theDirectory){
   
   $files = scandir($theDirectory);
      
   $arrayFiles =  array();
   $idx = 0;   
   
   foreach($files as $file){
     	$filePath = $theDirectory."/".$file;
   	  if (is_file($filePath)){
         $arrayFiles[$idx] = $file;
         $idx ++;
      }
   }
   return $arrayFiles;
   
}

/**
 * Function that returns the directories that are in of a directory
 *
 * @param theDirectory: The directory that is scanned
 *
 * @return: An array with the directory that are in the directory param
 */
function getDirectories($theDirectory){

   $directories = scandir($theDirectory);
   
   $arrayDirectories = array();
   $idx = 0;
   foreach($directories as $directory){
   
      $dirPath = $theDirectory."/".$directory;
      if (is_dir($dirPath)){
         $arrayDirectories[$idx]= $directory;
         $idx ++;      	
      	}   	
   	}	
   	return $arrayDirectories;
}
 
/**
 * Function that returns the files that are in a directory and filtered by its extension
 *
 * @param theDirectory: The directory for scan
 * @param theExtesionsArray: Array where are saved the extensions for filter
 *
 * @return An array with the files that are in the directory and filter by the extensions
 */

function getDirectoryFilesFilterExtension($theDirectory, $theExtensionsArray){
	
	$files = scandir($theDirectory);
	$arrayFiles = array();
	$idx = 0;	
	foreach($files as $file){
		
	   if (is_file($theDirectory."/".$file)){
         $theFileExtension = pathinfo($theDirectory."/".strtolower($file), PATHINFO_EXTENSION);
         if (in_array(strtolower($theFileExtension), $theExtensionsArray)){
            $arrayFiles[$idx] = $file;
            $idx ++;   
         }	   
	   }	
	}
	return $arrayFiles;
	
}

/**
  * Function for order a files array by timestamp (Date/Time)
  *
  * @param theDirectory: The directory where the files are saved
  * @param theFiles: Array with the files to order
  * @param theSortType: The order type to order the files. Possible values: ascending, descending.
  *  Default value: ascending
  * 
  * @return: An array with the ordered files
  */
function orderFilesByTimestamp($theDirectory, $theFiles, $theSortType = 'ascending'){

   $arrayAux = array();
   $idx = 0;
   
   foreach($theFiles as $file){
      $fileTimestamp = filemtime($theDirectory."/".$file);
      $arrayAux[$idx] = array("file" => $file,
                             "timestamp" => $fileTimestamp);
         
      $idx ++;   
   }
  
   usort($arrayAux, create_function('$fileA, $fileB', 
      'return strcmp($fileA["timestamp"],$fileB["timestamp"]);'));
   
   if (strtolower($theSortType) == 'descending'){
      krsort($arrayAux);   
   }
   
   $returnArray = array();
   $idx = 0;
   foreach($arrayAux as $orderedFile){
      $returnArray[$idx] = $orderedFile["file"];
      $idx ++;   
   }
   
   return $returnArray;
   
}

//quitar esta funcion
//@param theFiles: array que contiene los ficheros que se quieren mostrar
function showFiles($theFiles){
	echo "<p>La lista de ficheros es:</p>";
	$lista = "<ul>\n";
	foreach($theFiles as $file){
		$lista .= "<li>$file</li>\n";
	}
   $lista .= "</ul>\n";
   echo $lista;	
}
?>