<?php
  /* Author: Kai Middleton <kai@middleton.de>
   * Name: parsecsv
   * Version: 1.0
   * USAGE:
   *   $csvdata = 'Happy,"Kai says,""Fluff is great""",Joe"';
   *   $dataArray = parseCSV($csvdata);
   *   print_r($dataArray); // returns array( [0] => array('Happy','Kais says, "Fluff is great",'Joe') );
   */
function parseCSV($string,$delimiter=',',$enclosure='"',$delimiter2="\n"){
  $s = $string;  $d = $delimiter;  $e = $enclosure; $d2 = $delimiter2;
  $dLen = mb_strlen($d);  $eLen = mb_strlen($e);  $d2Len = mb_strlen($d2);
  $nE;  $nD;   $nD2; // next enclosure/delimiter/delimiter2
  $nEs;  $nDEs; // next enclosure stop  and next double enclosure stop
  $b = ''; // block aKa one field
  $rC = 0; // row count
  $r = array(); // return array
  $cut = 0; // place to cut off the string
  
  while(mb_strlen($s)>0){
    $nE = (mb_strpos($s,$e) !== false)?mb_strpos($s,$e):mb_strlen($s);
    $nD = (mb_strpos($s,$d) !== false)?mb_strpos($s,$d):mb_strlen($s);
    $nD2 =(mb_strpos($s,$d2) !== false)?mb_strpos($s,$d2):mb_strlen($s);
    
    if($nE === 0){
      $nEs = -$eLen;
      do{
        $nEs = $nEs + ($eLen*2);
        $nDEs = mb_strpos($s,$e.$e,($nEs));
        $nEs = mb_strpos($s,$e,($nEs));
      } while(($nEs === $nDEs) && $nEs);
      if(! $nEs){ $nEs = mb_strlen($s); $s .= $e; }
      $cut = $nEs+$eLen;
      // simulating a multibyte version of str_replace
      $b.= implode($e, mb_split(preg_quote($e.$e), mb_substr($s,$eLen,($nEs-$eLen))));
    }
    elseif($nD === 0){
      $cut = $dLen;
      $r[$rC][] = $b; $b = '';
    }
    elseif($nD2 === 0){
      $cut = $d2Len;
      $r[$rC][] = $b; $b = '';
      $rC++;
    }
    else{
      $cut = min($nE,$nD,$nD2);
      $b .= mb_substr($s,0,$cut);
    }
    $s = mb_substr($s,$cut);
  }
  $r[$rC][] = $b;
  return $r;
}
