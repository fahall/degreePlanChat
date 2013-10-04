<?php
//Open DB connection

$db = new mysqli("pascal.uww.edu", "dpuser", "sh33ph3ad", "dpdatabase_dev");
if (mysqli_connect_errno())
{
      echo 'Error: could not connect.';
      exit;
}

$thisId = $_POST['id'];	//The plan id
$thisMode = $_POST['mode'];
$thisUser = $_POST['user'];


//This function prints the comments from the database
if($thisId && $thisMode == 1)
{
	//We will get the plan id? Maybe we should use course/user? 
	//First implementation only accepts plan. 
	$id=$thisId;
	
	//We get comments related to this course/plan/user
	//Each comment needs:
		//Author
		//Recipient
		//Date - We will sort messages by Date/Time
		//Message
		//Hidden? If a message is 'deleted' by a user, we will mark it as hidden. 
	$sql=$db->query("select user.first, user.last, plan_comment.date_time, plan_comment.comment from plan_comment, user where user.id = plan_comment.plan_id");
	
	//Move our messages into an a array
	$num_comments = $sql->num_rows;
	for($i = 0; $i < $num_comments; $i++)
	{
		$comments[$i] = $sql->fetch_assoc();
	}
	
	//Print "Messages relating to: " and the plan/course/user ID. (or maybe a nickname)
	echo "Comments on plan: $thisId <br/>";
	
	//Print each unhidden message in the following form:
		//Author
		//Date & Timestamp
		//Message
	//Messages should be printed with an option to hide if author = currentUser. 
	for($i = 0; $i < $num_depts; $i++)
	{
	$author=$comments[$i]['user.first'].$comments[$i]['user.last'];
	$date = $comments[$i]['plan_comment.date_time'];
	$comment=$comments[$i]['name'];
	
	echo "<b> $author <b>: $comment | Posted: $date <br/><br/>";
	}
	
	//The form will have a text area for submitting new messages. 
}

//This mode adds messages to the database
else if($thisId && $thisMode == 2)
{
	$thisMessage = $_POST['message'];
	
	$sql=$db->query("insert into plan_comment (id, plan_id, from, comment, seen, date_time) VALUES (NULL, '$thisId', '$thisUser', '$thisMessage', '0', '".now()."')");
	
}
?>
