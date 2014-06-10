<?php
    
   include_once ($_SERVER['DOCUMENT_ROOT'].'/php/log4php/Logger.php');
   
   abstract class AbstractImageGD{

      /**
       * Property where is saved the original path file.
       */
      public $pathM;
      /**
       * Property where is saved the original and file name
       */
      protected $fileM;     
      /**
       * Property where is saved the source image
       */
      protected  $imageM = null;
      
      /**
       * 
       */
      protected $loggerM = null;
      
                 
      //Abstract methods
      /**
       * Method that creates the image from a image type file
       */   
      abstract protected function loadImage();
      /**
       * Method that write the image in a file
       *
       * @param theFile: The path and file of the target image file
       */
      abstract protected function writeImage($theImage, $theFile);
      
      /**
       * Constructor
       *
       * @param thePath: The image path
       * @param theFile: The file image
       */
      function __construct($thePath, $theFile){
          
          $this->pathM = $thePath;            
          $this->fileM = $theFile;
          $this->loggerM = Logger::getLogger(__CLASS__);
          
      }
      /**
       * Destructor
       */
      function __destruct(){
      
      }
      
      /**
       * Function that convert an image in its thumbnail
       *
       * @param theTargetPath: The target file path
       * @param theThumbWidth: The thumbnail width. Default 102
       * @param theThumHeight: The thumbnail height. Default 76
       * @param theThumbPrefix: The thumbnail prefix file name. Default "Thumb_"
       */
       public function converToThumbnail( $theTargetPath
                                         ,$theThumbWidth = 102
                                         ,$theThumHeight = 76
                                         ,$theThumPrefix = 'Thumb_'
                                         ,$sizeInName = false){
         
          $this->loggerM->trace("Enter");
          
          $this->loggerM->trace("Create thumbnail with :\n".
                                    "Path[ " . $theTargetPath ." ]\n".
                                    "Width [ " .$theThumbWidth . " ] px\n".
                                    "Height [ " . $theThumHeight ." ] px\n".
                                     "Thumbnail prefix [ " . $theThumPrefix . " ]");
         //Set mask to can set permission at the directory and the files
         $oldMask = umask(0);
         if (!is_dir($theTargetPath)){
            $this->loggerM->debug("The directory [ " . $theTargetPath .
            " ] doesn't exist. It is created");
            $re = mkdir($theTargetPath, 0777);
         }
            $this->loggerM->trace("Get the real size from image [ ".
                   $this->pathM."/".$this->fileM . "]");
            $imageWidth = imagesx($this->imageM);
            $imageHeight = imagesy($this->imageM);
            
            $this->loggerM->trace("Real width [ $imageWidth ]. Real height [ $imageHeight ]");
            $widthFactor = 1;
            $heightFactor = 1;
            if ($theThumbWidth < $imageWidth){
               $widthFactor =  $theThumbWidth / $imageWidth;
            }
         
            if (($imageHeight*$widthFactor) > $theThumHeight){
               $heightFactor =  $theThumHeight / ($imageHeight*$widthFactor);
            }
            $this->loggerM->trace("factor width [ $widthFactor ]. factor height [ $heightFactor ]");
            
            //Calculate the new width and height
            $thumbnailWidth = $imageWidth * $widthFactor * $heightFactor;
            $thumbnailHeight = $imageHeight * $widthFactor * $heightFactor;     
     
         $fileName = $theTargetPath.'/'.$theThumPrefix;
         
         
         if ( ! $sizeInName){
            $fileName = $fileName.$this->fileM;
         }else{
            $ext = pathinfo($this->fileM, PATHINFO_EXTENSION);
            $name =  pathinfo($this->fileM,PATHINFO_FILENAME);
            
            $fileName = $fileName.$name.'_['.intval($thumbnailWidth).'x'.intval($thumbnailHeight).'].'.$ext;
         }
         $this->loggerM->trace("Check if the image [ ". $fileName ." ] now exists");
         
         if (! is_file($fileName)){
            
            $this->loggerM->debug("The image [ ". $fileName ." ] doesn't exists, creating it");
            $targetImage = imagecreatetruecolor($thumbnailWidth, $thumbnailHeight);
            imagecopyresampled($targetImage        // target Image
                               ,$this->imageM      //source image
                               , 0                 // $dst_x, 
                               , 0                 //$dst_y,
                               , 0                 // $src_x, 
                               , 0                 //$src_y, 
                               , $thumbnailWidth   //$dst_w
                               , $thumbnailHeight  //$dst_h
                               , $imageWidth       //$src_w
                               , $imageHeight      //$src_h
                               );
            $this->writeImage($targetImage, $fileName);
            
         }
      
         umask($oldMask);   
         $this->loggerM->trace("Return file name [ $fileName ]");
         $this->loggerM->trace("Exit");
         return  $fileName;   
      }
      
   }

?>