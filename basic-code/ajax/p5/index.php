<html>
<head>
    <title>AJAX Student Registration</title>
    <style>
        body {
            font-family: Arial;
            background: #f2f5ff;
        }
        .container {
            width: 450px;
            margin: 50px auto;
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 5px 20px #ccc;
        }
        h2 {
            text-align: center;
            color: #4338ca;
        }
        input {
            width: 100%;
            padding: 12px;
            margin: 8px 0 15px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 7px;
        }
        button {
            width: 100%;
            padding: 12px;
            background: #4338ca;
            color: white;
            border: 0;
            border-radius: 7px;
            font-size: 16px;
            cursor: pointer;
        }
        #msg {
            margin-top: 15px;
            text-align: center;
            font-weight: bold;
            color: green;
        }
        #records {
            margin-top: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        th, td {
            border: 1px solid #ccc;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Student Registration</h2>

    <input type="text" id="name" placeholder="Enter Name">
    <input type="email" id="email" placeholder="Enter Email">
    <input type="text" id="mobile" placeholder="Enter Mobile">

    <button onclick="saveStudent()">Register Student</button>

    <div id="msg"></div>
    <div id="records"></div>
</div>

<script>
function saveStudent() {
    let name = document.getElementById("name").value;
    let email = document.getElementById("email").value;
    let mobile = document.getElementById("mobile").value;

    if (name == "") { alert("Please Enter a Name"); return; }
    if (email == "") { alert("Please Enter an Email"); return; }
    if (mobile == "") { alert("Please Enter a Mobile"); return; }

    const xhttp = new XMLHttpRequest();
    xhttp.onload = function() {
        document.getElementById("msg").innerHTML = this.responseText;
        document.getElementById("name").value = "";
        document.getElementById("email").value = "";
        document.getElementById("mobile").value = "";
        fetchStudent(); // Data insert hone ke baad list refresh hogi
    }
    xhttp.open("POST", "insert.php");
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send(
        "name=" + encodeURIComponent(name) +
        "&email=" + encodeURIComponent(email) +
        "&mobile=" + encodeURIComponent(mobile)
    );
}

function fetchStudent() {
    const xhttp = new XMLHttpRequest();
    xhttp.onload = function() {
        document.getElementById("records").innerHTML = this.responseText;
    }
    xhttp.open("GET", "fetch.php"); // Corrected syntax and lowercase filename
    xhttp.send();
}

// Page load hote hi list dikhane ke liye
fetchStudent();
</script>

</body>
</html>
