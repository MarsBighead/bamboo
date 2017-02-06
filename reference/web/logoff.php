<?php 
session_start();
//session_unregister("username");
//session_unregister("userid");
//session_unregister("role");
session_unset();
session_destroy();
session_start();
header("location:index.php");
exit;
?>
<script language="javascript">
history.go(-1);
</script>
