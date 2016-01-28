<?php 
      $size = iterator_count(new DirectoryIterator('sync/'));
      echo ($size-2);
?>	