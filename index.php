<html> 
  <head> 
    <title>Relations</title>
    <meta name="Author" content="Word Link v 0.004" /> 
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
    <meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
  </head>
  <body>
<?php
  $search_key = $_GET["q"];
?>

<h1>Relations v0.004</h1>
<form action="index.php" method="get">
 <input type="text" name="q" value="<?php echo $search_key ?>">
 <input type="submit" value="search">
</form>

<?php
  $search_key = $_GET["q"];
  $count = 0;
  if(!empty($search_key)){
    $htmlsource = file_get_contents('http://ja.wikipedia.org/wiki/' . $search_key);
    if(preg_match_all('/<a href="\/wiki\/\S+ title="(\S+)">(\S+)<\/a>/i', $htmlsource, $result) !== false){
      for ($i = 0; $i < count($result[0]); $i++) {
        if($result[1][$i] === $result[2][$i] && !stristr($result[1][$i], 'wikipedia') && !stristr($result[1][$i], 'ウィクショナリー')){
           print '<a href="./index.php?q=' . $result[1][$i] . '">' . $result[1][$i] . "</a> ";

           // Search 2nd Relations
           if($count < 2){
             $htmlsource2 = file_get_contents('http://ja.wikipedia.org/wiki/' . $result[1][$i]);
             if(preg_match_all('/<a href="\/wiki\/\S+ title="(\S+)">(\S+)<\/a>/i', $htmlsource2, $result2) !== false){
               for ($i2 = 0; $i2 < count($result2[0]); $i2++) {
                 if($result2[1][$i2] === $result2[2][$i2] && !stristr($result2[1][$i2], 'wikipedia') && !stristr($result2[1][$i2], 'ウィクショナリー')){
                    print ' > <a href="./index.php?q=' . $result2[1][$i2] . '">' . $result2[1][$i2] . "</a>";



                    // Search 3rd Relations
                    if($count < 1){
                      $htmlsource3 = file_get_contents('http://ja.wikipedia.org/wiki/' . $result2[1][$i2]);
                      if(preg_match_all('/<a href="\/wiki\/\S+ title="(\S+)">(\S+)<\/a>/i', $htmlsource3, $result3) !== false){
                        for ($i3 = 0; $i3 < count($result3[0]); $i3++) {
                          if($result3[1][$i3] === $result3[2][$i3] && !stristr($result3[1][$i3], 'wikipedia') && !stristr($result3[1][$i3], 'ウィクショナリー')){
                             print ' > <a href="./index.php?q=' . $result3[1][$i3] . '">' . $result3[1][$i3] . "</a>";
                             break;
                          }
                        }
                      }
                    }
                 break;


                 }
               }
             }
           }
           $count++;
           print '<br>';
        }
      }
    }
    if($count == 0) echo "no data";
  }
?>
</body>
</html> 