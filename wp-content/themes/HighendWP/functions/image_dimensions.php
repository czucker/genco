<?php
function get_image_dimensions($orientation = "landscape", $ratio = "ratio1", $width = 600) {
  $height = 0;
  switch ( $ratio ) {

    case "ratio1":
      if ( $orientation == "portrait")
        $height = (int) (( $width / 9 ) * 16);
      else
        $height = (int) (( $width / 16 ) * 9);
    break;

    case "ratio2":
      if ( $orientation == "portrait")
        $height = (int) (( $width / 3 ) * 4);
      else
        $height = (int) (( $width / 4 ) * 3);
    break;
    
    case "ratio3";
      $height = (int) ( $width );
    break;
    
    case "ratio4":
      if ( $orientation == "portrait")
        $height = (int) (( $width / 2 ) * 3);
      else
        $height = (int) (( $width / 3 ) * 2);
    break;
    
    case "ratio5":
      if ( $orientation == "portrait")
        $height = (int) (( $width ) * 3);
      else
        $height = (int) (( $width / 3 ));
    break;
  }
  
  return array ( 'width' => $width, 'height' => $height );
}
?>