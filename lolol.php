
<?
/*
(C) NOmeR1
*/
?>
<title>Sender Anonym Email :: FLoodeR :: SpameR</title>
<?
//
error_reporting (0);
if(!set_time_limit(0)) {
$limit = false;
} else {
set_time_limit(0);
ignore_user_abort(1);
$limit = true;
}
$log = 'log.txt'; // Файл лога

ini_set('max_execution_time', '0');

?>
set_time_limit(0) = <?if($limit)echo('<font color=Green>On</font>');else
echo('<font color=Red>Off</font> (Время работы ограничено текущими настройками сервера)');?><br>
<?
$ip = getenv('REMOTE_ADDR');
if($_GET['mail'] == '1' || $_GET['mail'] == '2' || $_GET['mail'] == '3')
{

$_POST['to'] = stripslashes($_POST['to']);
$_POST['msg'] = stripslashes($_POST['msg']);
$_POST['from'] = stripslashes($_POST['from']);
$_POST['subject'] = stripslashes($_POST['subject']);

if($_POST['to'] && $_POST['msg'] && $_POST['from'] && $_POST['tipe'])
{
$headers = "MIME-Version: 1.0\r\n";
$headers .= "Content-type: text/".$_POST['tipe']."; charset=windows-1251\r\n";
$headers .= "From: ".$_POST['from']."\n";
if($_GET['mail'] == '1')
{
mail($_POST['to'], $_POST['subject'], $_POST['msg'], $headers) or die('Не возможно отправить сообщение');
}
elseif($_GET['mail'] == '2')
{
$_POST['to'] = explode("\n",$_POST['to']);
foreach($_POST['to'] as $poluchatels)
{
mail($poluchatels, $_POST['subject'], $_POST['msg'], $headers) or die('Не возможно отправить сообщение');
}
}
elseif($_GET['mail'] == '3')
{
if(preg_match('/[0-9]+/',$_POST['kol']))
{
for($i=0;$i<$_POST['kol'];$i++)
{
mail($_POST['to'], $_POST['subject'], $_POST['msg'], $headers) or die('Не возможно отправить сообщение');
sleep(1);
}
}
else
{
echo('Неверно введено (или не введено) кол-во сообщений');
}
}
$f = fopen($log,'a');
fwrite($f,'Отправелено сообщение &'.$_POST['msg'].'& с темой "'.$_POST['subject'].'" для "'.$_POST['to'].'" с IP - "'.$ip."\"\r\n");
fclose($f);
echo('<center><b><font color="green">Сообщение успешно отправлено</font></b></center>');
}
else
{
?>
<form style="width:350px" method='post'>
<?
if($_GET['mail'] == '1' || $_GET['mail'] == '3')
{
echo("Получатель &nbsp;<input type='text'name='to'><br>");
}
?>
Отправитель <input type='text' name='from'><br>
Тема сообщ. &nbsp;<input type='text' name='subject'><br>
<?
if($_GET['mail'] == '3')
{
echo("Кол-во сообщений <input type='text' name='kol'><br>");
}
?>
<br>
htm -&gt; <input type='radio' checked='checked' tabindex='1' name='tipe' value='html'> :: <input type='radio' name='tipe' value='plain'>&lt;- text<br>
<?
if($_GET['mail'] == '2')
{
echo("Получатели<br><textarea name='to' rows='10' cols='30'>admin@admin.ru
admin@mail.ru
tiger@ya.ru</textarea>");
}
?>
<br>Сообщение<br>
<textarea name='msg' rows='10' cols='30'></textarea><br><br><input type='submit'>
</form>
<?
}
} else {
?><br>
<a href='<?=$_SERVER['PHP_SELF']?>?mail=1'>Отправить простое сообщение</a><br>
<a href='<?=$_SERVER['PHP_SELF']?>?mail=2'>Наспамить</a><br>
<a href='<?=$_SERVER['PHP_SELF']?>?mail=3'>Налудить</a><br>
<?
}
?> 
