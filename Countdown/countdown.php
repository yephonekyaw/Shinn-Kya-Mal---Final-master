<!-- <p> The download will begin in <span id="countdowntimer">120 </span> Seconds</p>

<script type="text/javascript">
    var timeleft = 120;
    var expiredTime = setInterval(function(){
    timeleft--;
    document.getElementById("countdowntimer").textContent = timeleft;
    if(timeleft <= 0)
        clearInterval(expiredTime);
    },1000);
</script> -->


<!DOCTYPE html>
<html>
	<head>
		<title>Countdown</title>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		 
		<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" rel="stylesheet">
		<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/css/bootstrap-datepicker.min.css" rel="stylesheet">
		
		<script src="http://code.jquery.com/jquery-1.11.3.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/js/bootstrap-datepicker.min.js"></script>
		
		<script type="text/javascript">
			
			$(document).ready(function(e)
			{
				// initalize datepicker (https://github.com/eternicode/bootstrap-datepicker)
				$('#datepicker').datepicker(
				{
					orientation: "top auto",
					autoclose: true
				});
			});
			
		</script>
		
	</head>
	<body>
		
		<div class="container" style="margin-top: 50px">
	
			<form method="post" action="countdown.php">
			
				<div class="form-group">
					<label>Event Name:</label>
					<input name="event" type="text" class="form-control" />
				</div>
			    
			    <div class="form-group">
				    <label>Date of Event:</label>
				    <input id="datepicker" name="date" type="text" class="form-control" />
			    </div>
	
			    <input name="submit" type="submit" value="Calculate Days" class="btn btn-primary" />
			
			</form>
		
		</div>

	</body>
</html>