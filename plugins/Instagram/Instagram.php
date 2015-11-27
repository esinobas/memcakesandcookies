<?php
   /**
    * This file contais a static class to access to the Instagram photos
    */

   if ( ! strpos(get_include_path(), dirname(__FILE__))){
      set_include_path( get_include_path() . PATH_SEPARATOR . dirname(__FILE__));
   }
   
   include_once 'LoggerMgr/LoggerMgr.php';
   
   class Instagram{
      
      /**
       * Private variables
       */
      static private $loggerM = null;
      
      const ACCESS_TOKEN_C = "183366596.f1f9d9d.bfa6d4ea8ad64f9b922009a1f27e5992";
      
      
      /**
       * Private functions
       */
      
      /**
       * Returns the logger (log4php) for write the log
       */
      static private function getLogger(){
         
         if (!isset(self::$loggerM)){
            self::$loggerM = LoggerMgr::Instance()->getLogger(__CLASS__);
         }
         return self::$loggerM;
      }
      
      
      static public function getLastImages($theUserName, $numImages){
         self::getLogger()->trace("Enter");
         self::getLogger()->trace("Get the last [ " . $numImages .
                 " ] most recent images from the UserId [ ".$theUserName . " ]");
         
         $urlApiInstagram = "https://api.instagram.com/v1/users/search?q=$theUserName&access_token=".Instagram::ACCESS_TOKEN_C;
         
         self::getLogger()->trace("Instagram URL [ $urlApiInstagram ]");
         
         $response = file_get_contents($urlApiInstagram);
         self::getLogger()->trace("User Response [ $response ]");
         $jsonUser = json_decode($response)->data[0];
         self::getLogger()->trace("User Data [ ". json_encode($jsonUser)." ]");
         $userId = $jsonUser->id;
         self::getLogger()->trace("UserId [ $userId ]");
         
         $urlApiInstagram = "https://api.instagram.com/v1/users/$userId/media/recent/?access_token=".
                     Instagram::ACCESS_TOKEN_C . "&count=$numImages";
         self::getLogger()->trace("Get media Instagram URL [ $urlApiInstagram ]");
         $response = file_get_contents($urlApiInstagram);
         self::getLogger()->trace("Media response[ $response ]");
         $jsonMedia = json_decode($response)->data;
         self::getLogger()->trace("Media Data [ ". json_encode($jsonMedia)." ]");
         
         $returnData = array();
         
         foreach(array_keys($jsonMedia) as $idx){
            $jsonMediaData = $jsonMedia[$idx];
            self::getLogger()->trace("\n[ $idx ] -> [ " . json_encode($jsonMediaData). " ]\n");
            
            $mediaThumbnail = $jsonMediaData->images->thumbnail->url;
            self::getLogger()->trace("[ $idx ] thumbmail [ " . $mediaThumbnail . " ]");
            
            $medialink = $jsonMediaData->link;
            
            self::getLogger()->trace(" [ $idx ] link [ " . $medialink . " ]");
            
            $urlApiInstagram = "http://api.instagram.com/oembed?url=$medialink";
            self::getLogger()->trace("Get embed media from Instagram URL [ $urlApiInstagram ]");
            $response = file_get_contents($urlApiInstagram);
            self::getLogger()->trace("Media response[ $response ]");
            $mediaEmbed = json_decode($response)->html;
            self::getLogger()->trace("Media Embed [ $mediaEmbed ]");
            
            $mediaInfo = array();
            $mediaInfo['Thumbnail'] = $mediaThumbnail;
            $mediaInfo['Embed'] = $mediaEmbed;
            
            self::getLogger()->trace("\nAdding media info [$idx] => [ " . json_encode($mediaInfo) ." ]\n");
            $strIdx = strval($idx);
            //self::getLogger()->trace("strIdx [ $strIdx ]");
            $returnData[$strIdx] = $mediaInfo;
         }
         
         self::getLogger()->trace("\nReturn the following media info [ " . json_encode($returnData) ." ]\n");
         self::getLogger()->trace("Exit");
         return json_encode($returnData);
      }
   }
?>