<html>
   <head>
      <title>Searching in the database</title>
      <?php header("Cache-Control: private, max-age=3600");?>
   </head>

   <body>
   <style>
body{ color:white; background-color:gray; text-align:center; padding-top:20%; font-family: Arial, Helvetica, sans-serif;}
</style>
   <h1>This page was served by</h1>
   <h1><?php
      echo gethostname() . PHP_EOL;
   ?></h1>
      <form name="form1" method="get" action="search.php">
          <input type="text" placeholder="type here" name="search" aria-label="Search" required>
          <input type="submit" value="Search" name="submit">
      </form>
   </body>
</html>