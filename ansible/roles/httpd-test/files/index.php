<html>
   <head>
      <title>Searching in the database</title>
      
   </head>

   <body>
   <h1>This page was served by</h1>
   <?php
      echo gethostname() . PHP_EOL;
   ?>
      <form name="form1" method="get" action="search.php">
          <input type="text" placeholder="type here" name="search" aria-label="Search" required>
          <input type="submit" value="Search" name="submit">
      </form>
   </body>
</html>