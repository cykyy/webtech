
<!DOCTYPE html>
<html>
  <body>
<?php 
    include "nav.php";

?>
    <!-- [SEARCH FORM] -->
    <form method="post" action="controller/findProduct.php">
      <h1>SEARCH FOR PRODUCT</h1>
      <input type="text" name="p_name" />
      <input type="submit" name="findproduct" value="Search"/>
    </form>


 
  </body>
</html>