<!DOCTYPE html>
<html>
<head>
  <title>Course Table</title>

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js">
</script>

<script>

var planID = 0;
var modeID = 0;

$(document).ready(function() {
    var _bCleared = false;
    $('form textarea').each(function()
    {
        var _oSelf = $(this);

        _oSelf.data('bCleared', false);
        _oSelf.focus(function()
        {
            if (!_oSelf.data('bCleared'))
            {
                _oSelf.val('');
                _oSelf.data('bCleared', true);
            }
        });
    });
});

$(document).ready(function()
{
	window.setInterval(function()
	{	
		$.ajax
		({
			type: "POST",
			url: "ajax_chat.php",
			data: dataString,
			cache: false,
			success: function(html)
			{
				$(".table").html(html);
			} 
		});

	}, 10000); //Timer interval for refreshes

});

$(document).ready(function()
{
	$(".plan").change(function()
	{
		
		document.getElementById('id').value = $(this).val();
	
		$.ajax
		({
			type: "POST",
			url: "ajax_chat.php",
			data: dataString,
			cache: false,
			success: function(html)
			{
				$(".table").html(html);
			} 
		});

	});

});




</script>

</head>

<body>

<h1>Chat Test</h1>

<p>This page should allow pseudo-realtime chatting</p>

<form name = "chat"> 
<?php


	//populate Plan select
	
        $plan = 'select DISTINCT id, first, last from course';

        $planResult = $db->query($departmentQuery);
        $numPlan = $planResult->num_rows;

        for($i = 0; $i < $numPlans; $i++)
        {
                $thesePlans[$i] = $departmentPlans->fetch_assoc();
        }

        echo "<b>Plan:</b> <select name = 'plan' class = 'plan'>";
	echo "<option value = '0'>--Select Department--</option>";
        for ($i = 0; $i < $numPlans; $i++)
        {
        echo "<option value = '".$thesePlans[$i]['id']."'> ".$thesePlans[$i]['first'].$thesePlans[$i]['last']."</option>";
        }
        echo "</select>";
		
		echo "<input type = 'hidden' name = 'id' class = 'id' value = "0">;
		
?>
</form>
<div class = "table">
</div>



<?php $db->close(); ?>
</body>
</html>

