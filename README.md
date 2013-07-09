parseCSV
=====

A function that parses CSV Information. Written in PHP.

Features:
------------------------------------------------------------------------
- light and simple  (aprox 44 lines of relevant code)
- full multibyte support, no fear of special chars
- freely choosable field delimiter, record delimiter and enclosure strings
  I say strings because you can have delimiters and enclosures with multiple chars if you like
- conforms to RFC4180(http://tools.ietf.org/html/rfc4180)
- supports mixed CSV styles, as in enclosed and not enclosed at the same time:
  `apple,"orange",banana`
- also deals with slithly quirky CSV data like: `apple,o"ran"ge,banana`
  where enclosed and non-enclosed data is mixed in one field or `apple,orange,"banana`
  here the last quote is not closed
  
Examples:
------------------------------------------------------------------------
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
      [0] => array('Joe said: "I like Trains", before he went home','orange','banana'),
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
