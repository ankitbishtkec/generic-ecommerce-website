<?php 

// SpringEdge Send SMS class File 
/*
 * USE:
 *  
    include 'sendsms.php';
    $sendsms=new sendsms("http://alerts.springedge.com/api/"
                      , "1i6xxxxxxxxxxxxxx", "BUxxxx");
    $sendsms->send_sms("99xxxxxxxx", "hello"
                      , "", "xml");
 */

class sendsms
{
 	private $api_url;
 	private $apikey;
 	private $senderid;

	function __construct($url,$apikey,$senderid)
	{
		$this->api_url = $url;
		$this->apikey = $apikey;
		$this->senderid = $senderid;
	}
	/**
	 * function to send sms
	 * 
	 */
	function send_sms($to,$message,$dlr_url,$type="xml")
	{
		return $this->process_sms($to,$message,$dlr_url,$type="xml",$time="null",$unicode="null");
	}
	/**
	 * function to schedule sms
	 * 
	 */
	function schedule_sms($to,$message,$dlr_url,$type="xml",$time)
	{ 
		return $this->process_sms($to,$message,$dlr_url,$type="xml",$time,$unicode='');
	}
	/**
	 * function to send unicode message
	 */
	function unicode_sms($to,$message,$dlr_url,$type="xml",$unicode)
	{  
		return $this->process_sms($to,$message,$dlr_url,$type="xml",$time='',$unicode);
	}
	/**
	 * function to send out sms
	 * @param string_type $to : is mobile number where message needs to be send
	 * @param string_type $message :it is message content
	 * @param string_type $dlr_url: it is used for delivering report to client
	 * @param string_type $type: type in which report is delivered
	 * @return output		$this->api=$apiurl;
	 */
	function  process_sms($to,$message,$dlr_url="",$type="xml",$time='',$unicode='')
	{  
		$message=urlencode($message);
		$this->to=$to;
		$to=substr($to,-10) ;
		$arrayto=array("9", "8" ,"7");
		$to_check=substr($to,0,1);
	
	 if(in_array($to_check, $arrayto))
	 	$this->to=$to;
	 else //echo "invalid number";
	 	Yii::ankFileSave( "invalid number=>".$to);

	if($time=='null')
		$time='';
	else
		$time="&time=$time";
	if($unicode=='null')
		$unicode='';
	else
		$unicode="&unicode=$unicode";	
		
	 	$url="$this->api_url/web2sms.php?workingkey=$this->apikey&sender=$this->senderid&to=$to&message=$message&type=$type&dlr_url=$dlr_url$time$unicode";

	 	return $this->execute($url);
	}
	/**
	 * function to check message delivery status
	 * string_type $mid : it is message id 
	 */
	function messagedelivery_status($mid)
	{
		$url="$this->start$this->api_url/status.php?workingkey=$this->apikey&messageid=$mid";
		return $this->execute($url);
	}
	/**
	 * function to check group message delivery
	 *  string_type $gid: it is group id
	 */
	function groupdelivery_status($gid)
	{
		$url="$this->start$this->api_url/groupstatus.php?workingkey=$this->apikey&messagegid=$gid";
		return $this->execute($url);		
	}
	/**
	 * function to request to clent url
	 */
	function execute($url)
	{
                //echo $url;
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$output = curl_exec($ch);
		curl_close($ch);
		
                if(!$output){
                    $output = file_get_contents($url);
                }
              //echo $output;
		return $output;
		
	}    
}
?>
