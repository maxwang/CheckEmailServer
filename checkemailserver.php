	<?php
	
	private static function check_email_server($email_server)
	{
		$result = getmxrr($email_server,$mxhosts);
		if($result) return $result;
		
		$result = checkdnsrr($email_server,'SOA');
		
		if(!$result) return $result;
		
		$result = checkdnsrr($email_server,'A');
		
		if(!$result) return $result;
		
		$connection = @fsockopen($email_server,25,$error_no,$error_message,2);
		if(is_resource($connection))
		{
			//send helo
			
			//
			fputs($connection, "HELO ".$email_server."\r\n");
			$response = fgets($connection, 4096);
			$result = true;
			fclose($connection);	
		}
		else
		{
			$result = false;	
		}
		
		return $result;	
	}