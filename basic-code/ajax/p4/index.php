<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h2>AJAX SKILLMANTHAN</h2>
    <button onclick="showMessage()">click</button>
    <h3 id="result"></h3>
    <script>
        function showMessage(){
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