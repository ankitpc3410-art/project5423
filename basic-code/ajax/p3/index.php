<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h2>Students Registration</h2>
    <input type="text" id="name" placeholder="Enter Name">
    <button onclick="saveStudent()">Register</button>
    <h3 id="message"></h3>
    <script>
        function saveStudent(){
            let student=document.getElementById("name").value;
            const xhttp= new XMLHttpRequest();
            xhttp.onload=function(){
                document.getElementById("message").innerHTML=this.responseText;

            }
            xhttp.open("POST","insert.php");
            xhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
            xhttp.send("name=" +student);
        }

        </script>


</body>
</html>