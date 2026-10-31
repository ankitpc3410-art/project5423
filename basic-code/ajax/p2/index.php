<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h2>Seatch Students</h2>
    <input type="text" id="studentName" placeholder="Enter Name">
    <button onclick="SearchStudent()">Search </button>
    <h3 id="result"></h3>
    <script>
            function SearchStudent(){
                let name=document.getElementById("studentName").value;
                const xhttp=new XMLHttpRequest();
                xhttp.onload=function(){
                    document.getElementById("result").innerHTML=this.responseText;

                }
                xhttp.open("GET","search.php?name="+name);
                xhttp.send();
            }

        </script>
</body>
</html>