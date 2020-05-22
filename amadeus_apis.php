$wsdl='<ns1:xxxxxx>  
</ns1:xxxxxx>';	
$nonceBase=$this->generateSomewhatRandomString();
$userId='XXXXXXXX';
$officeId='XXXXXXXXX';
$Pass=base64_encode('XXXXXXXX');
$messageId=$this->generateGuid();
 $password = base64_decode($Pass);
            $creation = new \DateTime('now', new \DateTimeZone('UTC'));
            $t = microtime(true);
            $micro = sprintf("%03d", ($t - floor($t)) * 1000);
            $creationString = $this->createDateTimeStringForAuth($creation, $micro);
			$messageNonce = $this->generateUniqueNonce($nonceBase, $creationString);
            $encodedNonce = base64_encode($messageNonce);
            $digest = $this->generatePasswordDigest($password, $creationString, $messageNonce);

 $SOAP_API_URL='https://nodeD2.test.webservices.amadeus.com/XXXXXXXXXXX';
$action='http://webservices.amadeus.com/XXXXXXXXXX';
$actionLast='XXXXXXXXXX';	
			$soapXML='<?xml version="1.0"?>
<SOAP-ENV:Envelope xmlns:SOAP-ENV="http://schemas.xmlsoap.org/soap/envelope/" xmlns:ns1="http://xml.amadeus.com/'.$actionLast.'" xmlns:ns2="http://www.w3.org/2005/08/addressing" xmlns:ns3="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wsswssecurity-secext-1.0.xsd" xmlns:ns5="http://xml.amadeus.com/2010/06/Security_v1"><SOAP-ENV:Header><ns2:MessageID>'.$messageId.'</ns2:MessageID><ns2:Action>'.$action.'</ns2:Action><ns2:To>https://nodeD2.test.webservices.amadeus.com/1ASIWQTC1QI</ns2:To><oas:Security xmlns:oas="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd"><oas:UsernameToken xmlns:oas1="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-utility-1.0.xsd" Id="UsernameToken-1"><oas:Username>'.$userId.'</oas:Username><oas:Nonce EncodingType="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-soap-message-security-1.0#Base64Binary">'.$encodedNonce.'</oas:Nonce><oas:Password Type="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-username-token-profile-1.0#PasswordDigest">'.$digest.'</oas:Password><oas1:Created>'.$creationString.'</oas1:Created></oas:UsernameToken></oas:Security><ns5:AMA_SecurityHostedUser><ns5:UserID POS_Type="1" PseudoCityCode="'.$officeId.'" AgentDutyCode="SU" RequestorType="U"/></ns5:AMA_SecurityHostedUser></SOAP-ENV:Header><SOAP-ENV:Body>'.$wsdl.'</SOAP-ENV:Body></SOAP-ENV:Envelope>
';

$soapUser=$userId;
$soapPassword=$Pass;
$headers = [
        "Content-type: application/xml",
        'SOAPAction: "' . $action . '"'
    ];
	 $ch = curl_init();
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_URL,$SOAP_API_URL);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLINFO_HEADER_OUT, 1);
    curl_setopt($ch, CURLOPT_TIMEOUT, 60);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
	curl_setopt($ch, CURLOPT_USERPWD, $soapUser.":".$soapPassword);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $soapXML);
    $data = curl_exec($ch);
$your_xml_response = html_entity_decode($data);
$clean_xml = str_ireplace(['SOAP-ENV:', 'SOAP:', 'awsse:', 'wsa:'], '', $your_xml_response);
$clean_xml = str_ireplace(['&'], '&amp;', $clean_xml);
$Results = simplexml_load_string($clean_xml);
