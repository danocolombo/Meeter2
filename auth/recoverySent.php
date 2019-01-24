<?php 
$email = $_GET['em'];
?><!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Meeter Web Application</title>
</head>
<body>
<p>If there is an account associated with '<?php $email?>', you'll receive an email with a link to create a new password.</p>
<p>If you don't see this email in your inbox within 15 minutes, look for it in your junk mail folder. If you it there, 
please mark the email as Not Junk and add @recovery.help to your address book.
</p>
</body>
</html>