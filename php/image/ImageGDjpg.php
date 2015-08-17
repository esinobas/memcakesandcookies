<?php
   include_once 'image/AbstractImageGD.php';

  class ImageGDjpg extends AbstractImageGD{


     /**
      * Constructor
      *
      * @param thePath: The image file path
      * @param theFile: The image file
      */
     function __construct($thePath,$theFile){
         
         parent::__construct($thePath,$theFile);
         $this->loadImage();
     }
     
     /**
      * Destructor
      */
     function __destruct(){
     }
     
     /**
       * Method that creates the image from a image type file
       */   
      protected function loadImage(){
          
          $file = $this->pathM.'/'.$this->fileM;
          $this->imageM = imagecreatefromjpeg($file);
          
        
      }
      /**
       * Method that write the image in a file
       *
       * @param theFile: The path and file of the target image file
       */
      public function writeImage($theImage, $theFile){
        
         imagejpeg($theImage, $theFile);
      }   
  }
?>