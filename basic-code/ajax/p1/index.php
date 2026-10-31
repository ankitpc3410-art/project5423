<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <button onclick="showmsg()">click</button>
    <br><br>
    <div id="result">
        
    </div>

    <script>
        function showmsg(){
             const xhttp=new XMLHttpRequest();
            xhttp.onload=function(){
                document.getElementById("result").innerHTML=this.responseText;
            }
            xhttp.open("GET","message.php");
            xhttp.send();
        }
     </script>   

</body>




</html>