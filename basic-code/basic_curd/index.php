<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Contact Us</title>

    <!-- <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            background: #f4f7fb;
        }

        /* Navbar */
        .navbar {
            width: 100%;
            background: #0d6efd;
            padding: 18px 8%;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            color: white;
            font-size: 26px;
            font-weight: bold;
        }

        .navbar a {
            color: white;
            text-decoration: none;
            margin-left: 25px;
            font-size: 16px;
        }

        .navbar a:hover {
            color: #dbeafe;
        }

        /* Hero */
        .hero {
            text-align: center;
            padding: 70px 20px 40px;
        }

        .hero h1 {
            font-size: 42px;
            color: #222;
            margin-bottom: 12px;
        }

        .hero p {
            color: #666;
            font-size: 18px;
        }

        /* Form */
        .form-container {
            width: 90%;
            max-width: 500px;
            margin: 30px auto 70px;
            background: white;
            padding: 35px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }

        .form-container h2 {
            text-align: center;
            margin-bottom: 25px;
            color: #222;
        }

        .form-group {
            margin-bottom: 18px;
        }

        .form-group label {
            display: block;
            margin-bottom: 7px;
            font-weight: bold;
            color: #333;
        }

        .form-group input {
            width: 100%;
            padding: 13px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 16px;
            outline: none;
        }

        .form-group input:focus {
            border-color: #0d6efd;
        }

        .btn {
            width: 100%;
            padding: 14px;
            border: none;
            border-radius: 8px;
            background: #0d6efd;
            color: white;
            font-size: 17px;
            cursor: pointer;
        }

        .btn:hover {
            background: #0b5ed7;
        }

        /* Footer */
        footer {
            background: #111827;
            color: white;
            text-align: center;
            padding: 25px;
        }

        /* Mobile */
        @media (max-width: 600px) {

            .navbar {
                padding: 15px 5%;
            }

            .navbar a {
                margin-left: 10px;
                font-size: 14px;
            }

            .logo {
                font-size: 21px;
            }

            .hero h1 {
                font-size: 32px;
            }

            .form-container {
                padding: 25px;
            }
        }
    </style> -->
</head>

<body>

    <!-- Navbar
    <nav class="navbar">
        <div class="logo">Form</div>

        <div>
            <a href="#">Home</a>
            <a href="#">About</a>
            <a href="#">Contact</a>
        </div>
    </nav> -->


    <!-- Hero Section
    <section class="hero">
        <h1>Contact Us</h1>
        <p>Fill the form and submit your details</p>
    </section> -->


    <!-- Registration Form -->
    <!-- <div class="form-container"> -->

        <h2>Registration Form</h2>

        <form action="db.php" method="POST">

            <!-- <div class="form-group"> -->
                <label>Name</label>
                <input type="text" name="name"
                       placeholder="Enter your name" required>
                       </br></br>
            <!-- </div> -->

            <!-- <div class="form-group"> -->
                <label>Phone</label>
                <input type="tel" name="phone"
                       placeholder="Enter your phone number" required>
                       <br><br>
            <!-- </div> -->

            <!-- <div class="form-group"> -->
                <label>Email</label>
                <input type="email" name="email"
                       placeholder="Enter your email" required>
                       <br><br>
            <!-- </div> -->

            <button type="submit" class="btn">
                Submit
            </button>

        </form>

    <!-- </div> -->


    <!-- Footer -->
    <!-- <footer>
        <p>© 2026 MyWebsite. All Rights Reserved.</p>
    </footer> -->

</body>
</html>