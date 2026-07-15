<?php   
   //Remote
   
    //  define("SERVER","localhost");
    //  define("USER","faisalfr_fast_drop_2026");
    //  define("DATABASE","faisalfr_fast_drop_2026");
    //  define("PASSWORD","fast_drop_2026");

   //local
     define("SERVER","localhost");
     define("USER","root");
     define("DATABASE","fast_drop_2026");
     define("PASSWORD","");

    $db=new mysqli(SERVER,USER,PASSWORD,DATABASE);
    $tx="";
  

?>