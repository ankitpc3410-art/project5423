<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    

    <title>Job Portal</title>

    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">

    <link rel="stylesheet" href="/job_portal/assets/css/style.css">
   <style>
/* JobVala Homepage Styling */
.jobvala-content {
    font-family: Arial, sans-serif;
    color: #222;
}

.jobvala-content * {
    box-sizing: border-box;
}

.jobvala-container {
    width: 90%;
    max-width: 1200px;
    margin: auto;
}

.jobvala-section {
    padding: 70px 0;
}

.jobvala-heading {
    text-align: center;
    margin-bottom: 40px;
}

.jobvala-heading h2 {
    font-size: 34px;
    font-weight: 700;
    color: #171717;
    margin-bottom: 12px;
}

.jobvala-heading p {
    color: #777;
    font-size: 16px;
}

/* Search Jobs */
.jobvala-search {
    background: #f5f5f5;
    padding: 35px 0;
}

.jobvala-search h2 {
    text-align: center;
    font-size: 28px;
    margin-bottom: 22px;
}

.jobvala-search-form {
    display: flex;
    gap: 12px;
}

.jobvala-search-form input,
.jobvala-search-form select {
    flex: 1;
    min-width: 0;
    padding: 15px;
    border: 1px solid #ddd;
    background: #fff;
    font-size: 15px;
    border-radius: 4px;
}

.jobvala-btn {
    display: inline-block;
    background: #202124;
    color: #fff;
    padding: 13px 25px;
    border: 1px solid #202124;
    border-radius: 4px;
    text-decoration: none;
    cursor: pointer;
    transition: 0.3s;
}

.jobvala-btn:hover {
    background: #fff;
    color: #202124;
}

/* Categories */
.jobvala-category-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 22px;
}

.jobvala-category {
    border: 1px solid #e5e5e5;
    padding: 30px 20px;
    text-align: center;
    transition: 0.3s;
    background: #fff;
}

.jobvala-category:hover {
    border-color: #222;
    transform: translateY(-5px);
    box-shadow: 0 8px 20px rgba(0,0,0,0.07);
}

.jobvala-icon {
    font-size: 35px;
    margin-bottom: 12px;
}

.jobvala-category h3 {
    font-size: 18px;
    margin-bottom: 8px;
}

.jobvala-category p {
    color: #777;
    font-size: 14px;
}

/* Featured Jobs */
.jobvala-jobs {
    background: #f6f6f6;
}

.jobvala-job-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 25px;
}

.jobvala-job-card {
    background: #fff;
    padding: 25px;
    border: 1px solid #e5e5e5;
    transition: 0.3s;
}

.jobvala-job-card:hover {
    box-shadow: 0 8px 22px rgba(0,0,0,0.08);
    transform: translateY(-4px);
}

.jobvala-job-card h3 {
    font-size: 21px;
    margin-bottom: 8px;
}

.jobvala-company {
    font-weight: 600;
    margin-bottom: 15px;
}

.jobvala-job-info {
    color: #666;
    font-size: 14px;
    margin: 8px 0;
}

.jobvala-tag {
    display: inline-block;
    background: #eee;
    padding: 6px 12px;
    font-size: 12px;
    margin: 12px 0 18px;
}

.jobvala-job-card .jobvala-btn {
    display: block;
    text-align: center;
}

.jobvala-center {
    text-align: center;
    margin-top: 35px;
}

/* Why JobVala */
.jobvala-feature-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 30px;
}

.jobvala-feature {
    text-align: center;
    padding: 25px;
}

.jobvala-feature h3 {
    margin: 12px 0;
    font-size: 20px;
}

.jobvala-feature p {
    color: #777;
    font-size: 15px;
}

/* How It Works */
.jobvala-steps {
    background: #f6f6f6;
}

.jobvala-step-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 25px;
}

.jobvala-step {
    background: #fff;
    padding: 30px 25px;
    text-align: center;
    border: 1px solid #eee;
}

.jobvala-step-number {
    width: 55px;
    height: 55px;
    line-height: 55px;
    margin: 0 auto 20px;
    border-radius: 50%;
    background: #202124;
    color: #fff;
    font-size: 22px;
    font-weight: bold;
}

.jobvala-step h3 {
    margin-bottom: 12px;
}

.jobvala-step p {
    color: #777;
}

/* Employer Section */
.jobvala-employer {
    background: #202124;
    color: #fff;
    text-align: center;
}

.jobvala-employer h2 {
    font-size: 34px;
    margin-bottom: 15px;
}

.jobvala-employer p {
    max-width: 700px;
    margin: 0 auto 25px;
    color: #ddd;
}

.jobvala-employer .jobvala-btn {
    background: #fff;
    color: #202124;
    border-color: #fff;
}

.jobvala-employer .jobvala-btn:hover {
    background: transparent;
    color: #fff;
}

/* Career Tips */
.jobvala-tips {
    background: #f6f6f6;
}

.jobvala-tip-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 25px;
}

.jobvala-tip {
    background: #fff;
    padding: 25px;
    border: 1px solid #e5e5e5;
}

.jobvala-tip h3 {
    font-size: 19px;
    margin-bottom: 12px;
}

.jobvala-tip p {
    color: #777;
    margin-bottom: 15px;
}

.jobvala-tip a {
    color: #222;
    font-weight: bold;
    text-decoration: none;
}

.jobvala-tip a:hover {
    text-decoration: underline;
}

/* Newsletter */
.jobvala-newsletter {
    text-align: center;
}

.jobvala-newsletter h2 {
    font-size: 30px;
    margin-bottom: 12px;
}

.jobvala-newsletter p {
    color: #777;
    margin-bottom: 25px;
}

.jobvala-newsletter-form {
    display: flex;
    gap: 10px;
    max-width: 550px;
    margin: auto;
}

.jobvala-newsletter-form input {
    flex: 1;
    min-width: 0;
    padding: 14px;
    border: 1px solid #ccc;
    border-radius: 4px;
    font-size: 15px;
}

/* Responsive */
@media (max-width: 900px) {
    .jobvala-category-grid {
        grid-template-columns: repeat(2, 1fr);
    }

    .jobvala-job-grid,
    .jobvala-feature-grid,
    .jobvala-step-grid,
    .jobvala-tip-grid {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media (max-width: 600px) {
    .jobvala-section {
        padding: 45px 0;
    }

    .jobvala-heading h2,
    .jobvala-employer h2 {
        font-size: 27px;
    }

    .jobvala-category-grid,
    .jobvala-job-grid,
    .jobvala-feature-grid,
    .jobvala-step-grid,
    .jobvala-tip-grid {
        grid-template-columns: 1fr;
    }

    .jobvala-search-form,
    .jobvala-newsletter-form {
        flex-direction: column;
    }

    .jobvala-search-form input,
    .jobvala-search-form select,
    .jobvala-search-form button,
    .jobvala-newsletter-form input,
    .jobvala-newsletter-form button {
        width: 100%;
    }
}

/* ================================== */
/* login page styling */
/* ================================== */

/* JobVala Login Page */
    .login-page {
        min-height: 80vh;
        padding: 65px 15px;
        background: #f5f5f5;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .login-wrapper {
        width: 100%;
        max-width: 450px;
    }

    .login-card {
        background: #fff;
        border: 1px solid #e5e5e5;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 12px 35px rgba(0, 0, 0, 0.10);
    }

    .login-header {
        background: #202124;
        color: #fff;
        text-align: center;
        padding: 30px 20px;
    }

    .login-logo {
        font-size: 30px;
        font-weight: bold;
        letter-spacing: 1px;
        margin-bottom: 8px;
    }

    .login-header p {
        color: #d1d1d1;
        font-size: 14px;
        margin: 0;
    }

    .login-body {
        padding: 35px;
    }

    .login-title {
        font-size: 27px;
        font-weight: bold;
        color: #202124;
        margin-bottom: 8px;
        text-align: center;
    }

    .login-subtitle {
        text-align: center;
        color: #777;
        font-size: 14px;
        margin-bottom: 28px;
    }

    .login-label {
        display: block;
        font-size: 14px;
        font-weight: 600;
        color: #333;
        margin-bottom: 8px;
    }

    .login-input {
        width: 100%;
        padding: 13px 14px;
        border: 1px solid #d8d8d8;
        border-radius: 6px;
        outline: none;
        font-size: 15px;
        background: #fff;
        color: #222;
        transition: 0.3s;
    }

    .login-input:focus {
        border-color: #202124;
        box-shadow: 0 0 0 3px rgba(32, 33, 36, 0.10);
    }

    .login-field {
        margin-bottom: 22px;
    }

    .login-submit {
        width: 100%;
        padding: 14px;
        background: #202124;
        color: #fff;
        border: 2px solid #202124;
        border-radius: 6px;
        font-size: 16px;
        font-weight: 600;
        cursor: pointer;
        transition: 0.3s;
    }

    .login-submit:hover {
        background: #fff;
        color: #202124;
    }

    .login-footer {
        text-align: center;
        padding-top: 23px;
        margin-top: 25px;
        border-top: 1px solid #eee;
        color: #777;
        font-size: 14px;
    }

    .login-footer a {
        color: #202124;
        font-weight: bold;
        text-decoration: none;
    }

    .login-footer a:hover {
        text-decoration: underline;
    }

    .login-alert {
        padding: 12px 15px;
        border-radius: 5px;
        margin-bottom: 20px;
        font-size: 14px;
    }

    @media (max-width: 576px) {
        .login-page {
            padding: 35px 15px;
        }

        .login-body {
            padding: 25px 20px;
        }

        .login-logo {
            font-size: 26px;
        }

        .login-title {
            font-size: 24px;
        }
    }
/* ================================== */
/* end of styling */
/* ================================== */

/* ================================== */
/* registration styling */
/* ================================== */

/* JobVala Registration Page */
    .register-page {
        min-height: 80vh;
        padding: 55px 15px;
        background: #f5f5f5;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .register-wrapper {
        width: 100%;
        max-width: 520px;
    }

    .register-card {
        background: #fff;
        border: 1px solid #e5e5e5;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 12px 35px rgba(0, 0, 0, 0.10);
    }

    .register-header {
        background: #202124;
        color: #fff;
        text-align: center;
        padding: 28px 20px;
    }

    .register-logo {
        font-size: 30px;
        font-weight: bold;
        letter-spacing: 1px;
        margin-bottom: 8px;
    }

    .register-header p {
        color: #d1d1d1;
        font-size: 14px;
        margin: 0;
    }

    .register-body {
        padding: 32px;
    }

    .register-title {
        text-align: center;
        color: #202124;
        font-size: 27px;
        font-weight: bold;
        margin-bottom: 8px;
    }

    .register-subtitle {
        text-align: center;
        color: #777;
        font-size: 14px;
        margin-bottom: 28px;
    }

    .register-field {
        margin-bottom: 20px;
    }

    .register-label {
        display: block;
        color: #333;
        font-size: 14px;
        font-weight: 600;
        margin-bottom: 8px;
    }

    .register-input {
        width: 100%;
        padding: 13px 14px;
        border: 1px solid #d8d8d8;
        border-radius: 6px;
        outline: none;
        font-size: 15px;
        background: #fff;
        color: #222;
        transition: 0.3s;
    }

    .register-input:focus {
        border-color: #202124;
        box-shadow: 0 0 0 3px rgba(32, 33, 36, 0.10);
    }

    .register-submit {
        display: block;
        width: 100%;
        padding: 14px;
        background: #202124;
        color: #fff;
        border: 2px solid #202124;
        border-radius: 6px;
        font-size: 16px;
        font-weight: 600;
        cursor: pointer;
        transition: 0.3s;
        margin-top: 8px;
    }

    .register-submit:hover {
        background: #fff;
        color: #202124;
    }

    .register-message {
        padding: 12px 15px;
        border-radius: 5px;
        margin-bottom: 20px;
        font-size: 14px;
    }

    .register-footer {
        text-align: center;
        padding-top: 22px;
        margin-top: 24px;
        border-top: 1px solid #eee;
        color: #777;
        font-size: 14px;
    }

    .register-footer a {
        color: #202124;
        font-weight: bold;
        text-decoration: none;
    }

    .register-footer a:hover {
        text-decoration: underline;
    }

    .register-note {
        text-align: center;
        font-size: 12px;
        color: #888;
        margin-top: 18px;
    }

    @media (max-width: 576px) {
        .register-page {
            padding: 35px 15px;
        }

        .register-body {
            padding: 25px 20px;
        }

        .register-logo {
            font-size: 26px;
        }

        .register-title {
            font-size: 24px;
        }
    }

/* ================================== */
/* end of registration styling */
/* ================================== */
</style>   
</head>

<body style="background-image: url('assets/images/background-image.jpg') !important;
             background-size: cover;
             background-repeat: no-repeat;
             background-position: center;
             background-attachment: fixed;">
    
</body>