parseCSV
=====

A function that parses CSV Information. Written in PHP.  
Jump to:  
[Features](#features)  
[Behaviour](#behaviour)  
[Usage](#usage)  
[Examples](#examples)  
[Requirements](#requirements)

Features:
------------------------------------------------------------------------
- light and simple  (approx. 44 lines of relevant code)
- full multibyte support, no fear of special chars
- freely choosable field delimiter, record delimiter and enclosure strings
  I say strings because you can have delimiters and enclosures with multiple chars if you like
- supports mixed CSV styles, as in enclosed and not enclosed at the same time:
  `apple,"orange",banana`
- also deals with slithly quirky CSV data like: `apple,o"ran"ge,banana`
  where enclosed and non-enclosed data is mixed in one field or `apple,orange,"banana`
  here the last quote is not closed

Behaviour
------------------------------------------------------------------------
- if you want to use your enclosure string inside an enclosed string you
  simply repeat it twice to escape it: (example with double quote as enclosure string)  
  `"Kai said ""I like Trains"", when he came home"`  
  parses to  
  `array( [0] => array('Kai said "I like Trains", when he came home'))`  
  This may seem strange, but that is what is defined by the [RFC4180](http://tools.ietf.org/html/rfc4180) standard
  and most widely supported.
- field delimiter, enclosure and the rekord delimiter can all de userdefined
  and can all be any string you like, meaning you are NOT limited to one character
  
Usage
------------------------------------------------------------------------
####Parse String

    <?php
      include_once('function.parsecsv.php');
      $csvdata = 'apple,orange,banana'."\n".
                 'tiger,horse,mouse';
      $dataArray = parseCSV($csvdata);
      print_r($dataArray);
      
####Parse String with own delimiters and enclosure
the letters `frog` as field delimiter, single quotes(`'`) as enclosure and hash(`#`) as line delimiter

    <?php
      include_once('function.parsecsv.php');
      $csvdata = "applefrog'orange'frog'banana'#".
                 "tigerfrog'horsefroghair'frogmouse";
      $dataArray = parseCSV($csvdata,'frog',"'",'#');
      print_r($dataArray);

####Parse File (whole)
    
    <?php
      include_once('function.parsecsv.php');
      $file = 'myEpicData.csv';
      $csvdata = file_get_contents($file)
      $dataArray = parseCSV($csvdata);
      print_r($dataArray);
      
####Parse File (line-by-line)

    <?php
      include_once('function.parsecsv.php');
      $file = 'myEpicData.csv';
      $dataArray = array();
      $file = fopen($file, "r") or exit('Unable to open file!');
      while(!feof($file)){
        $dataArray = parseCSV(fgets($file));
      }
      fclose($file);

Examples:
------------------------------------------------------------------------
Note: all these examples use the default delimiters and enclosure strings
which are:  
Field delimiter: ','  - a comma  
Record delimiter: "\n" - a new line  
Enclosure string: '"' - a double quote  


####Example 1

standard unenclosed CSV data

    apple,orange,banana
    tiger,horse,mouse
    
parses to  

    array(
      [0] => array('apple','orange','banana'),
      [1] => array('tiger','horse','mouse')
    )

####Example 2

standard enclosed and unenclosed CSV data

    "I like people, trains and fish",orange,"banana"
    "I like apple, mice and tables","horse",mouse

parses to  

    array(
      [0] => array('I like people, trains and fish','orange','banana'),
      [1] => array('I like apple, mice and tables','horse','mouse')
    )

####Example 3

standard enclosed and unenclosed CSV data with quotes in data

    "Joe said: ""I like Trains"", before he went home",orange,"banana"
    "I like apple, mice and tables","horse",mouse

parses to  

    array(
      [0] => array('Joe said: "I like Trains"', before he went home','orange','banana'),
      [1] => array('I like apple, mice and tables','horse','mouse')
    )
  
####Example 4

quirky CSV data with mixed unenclosed and enclosed parts in one field

    apple,or"an"ge,ban"ana"
    tiger,h"ors"e,mouse
    
parses to  

    array(
      [0] => array('apple','orange','banana'),
      [1] => array('tiger','horse','mouse')
    )

####Example 5

quirky CSV data with missing ending enclosure

    "apple","orange","banana"
    "tiger","horse,mouse

parses to  

    array(
      [0] => array('apple','orange','banana'),
      [1] => array('tiger','horse,mouse')
    )

Requirements:
------------------------------------------------------------------------
####PHP-Version
You need at least **PHP Version 4.2.0** or higher.

####PHP functions used
- `implode()` - PHP4, PHP5
- `mb_split()` - PHP4 >= 4.2.0, PHP5
- `mb_strlen()` - PHP4 >= 4.0.6, PHP5
- `mb_strpos()` - PHP4 >= 4.0.6, PHP5
- `mb_substr()` - PHP4 >= 4.0.6, PHP5
- `min()` - PHP4, PHP5
- `preg_quote()` - PHP4, PHP5
