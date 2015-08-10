<!DOCTYPE html>
<html>
<meta http-equiv="Content-Type" content="textml; charset=utf-8" />
<body>
<h1>获得服务器更新</h1>
<div id="result"></div>

<script>
if(typeof(EventSource)!=="undefined")
  {//如果浏览器支持此技术， 则执行：
  var source=new EventSource("request_msg.php");
  source.onmessage=function(event)
    {
    document.getElementById("result").innerHTML+=event.data + "<br />";
    };
  }
else
  {//如果浏览器不支持此技术， 则执行
  document.getElementById("result").innerHTML="Sorry, your browser does not support server-sent events...";
  }
</script>

</body>
<ml>
