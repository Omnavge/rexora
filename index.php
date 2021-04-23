<?php
    if(isset($_POST['submit'])) {
        $lang=$_POST['lang'];
        $code=$_POST['code'];
        $inp=$_POST['input'];

    $data=array(
	'lang'=>$lang,
	'code'=>$code,
	'input'=>$inp,
	'save'=> false
	);

       $ch=curl_init();
       $url="https://ide.geeksforgeeks.org/main.php";
       curl_setopt($ch,CURLOPT_URL,$url);
       curl_setopt($ch,CURLOPT_POST,true);
       curl_setopt($ch,CURLOPT_POSTFIELDS,http_build_query($data));
       curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
       $out=curl_exec($ch);
       $r=json_decode($out,true);
       $stat=$r['status'];
       if($stat=="SUCCESS"){
          $curr_stat="";
          $output="";
           while($curr_stat!="SUCCESS"){
           $r_p=array(
          'sid'=> $r['sid'],
         'requestType'=>'fetchResults'
           );
            $rr="https://ide.geeksforgeeks.org/submissionResult.php";
                curl_setopt($ch,CURLOPT_URL,$rr);
               curl_setopt($ch,CURLOPT_POST,true);
               curl_setopt($ch,CURLOPT_POSTFIELDS,http_build_query($r_p));
               curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
                $re=curl_exec($ch);
                $curr_stat=json_decode($re,true)['status'];
                $output=$re;
       }
           $result=json_encode($output,true);
           echo "OUTPUT :".$result['output'].", Time :".$result['time']." Memory :".$result['memory'];
       } 
    }

 ?>


<html>
<body style='margin:100px'; background="code.jpg">
<h1 align="center" style="color:Red;"><i> IDE Compiler </i></h1>
 <form action='' method='post'>
 <select name='lang'>
 <option>Python</option>
  <option>C</option>
   <option>C++</option>
    <option>Java</option>
     <option>Php</option>
     </select><br>

             <textarea name='code' style='font-size:20px; height:400px; width:800px' placeholder='Enter your Code'></textarea><br>
             <input type='text' style='font-size:20px;width:200px' placeholder='Input Values' name='input'><br>
             <input type='submit' style='padding:10px' name='submit' value='Run'><br>
      </form>
</body>
</html>
