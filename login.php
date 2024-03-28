<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f8f9fa;
    }

    .container {
        max-width: 400px;
        min-height: 400px;
        margin: 50px auto;
        background-color: #fff;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        border: 2px solid black;

    }

    .form-label {
        font-weight: bold;
    }

    .form-control {
        margin: 10px 0 0 0;
        width: 100%;
        padding: 10px;
        margin-bottom: 20px;
        border-radius: 5px;
        border: 3px solid #ccc;
    }

    .form-text {
        font-size: 14px;
        color: #6c757d;
        margin: 0 0 40px 0;
    }

    .btn-primary {
        color: #fff;
        border: none;
        padding: 10px 20px;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s ease;
        width: 100%;
        margin: 10px 0;
    }

    .btn-submit {
        background-color: #007bff;
    }

    .btn-submit:hover {
        background-color: #0056b3;
    }

    .btn-signup {
        background-color: #28a745;
    }

    .btn-signup:hover {
        background-color: #218838;
    }
</style>

<div class="container">
    <form onsubmit="submitForm()">
        <div>
            <label for="emailfield" class="form-label">Email address</label>
            <input type="email" class="form-control" id="emailfield" aria-describedby="emailHelp" placeholder="Enter Your Email" required autofocus name="email">
            <div class="form-text" id="emailHelp">We'll never share your email with anyone else.</div>
        </div>
        <div>
            <label for="passwordfield" class="form-label">Password</label>
            <input type="password" class="form-control" id="passwordfield" aria-describedby="passwordHelpBlock" name="password">
            <div class="form-text" id="passwordHelpBlock">
            </div>
        </div>
        <button type="submit" class="btn-primary btn-submit">Login</button>
        <button type="button" onclick="setActive(list[2])" class="btn-primary btn-signup">Sign Up</button>
    </form>
</div>

<script>
    function submitForm() {
        email = document.getElementById("emailfield").value;
        password = document.getElementById("passwordfield").value;
        event.preventDefault();
        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'login.action.php?email=' + email + "&password=" + password, true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.send(new FormData(document.querySelector('form')));
        xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    if (xhr.responseText.includes("<head>"))
                        window.location.href = "index.php";
                    else
                        document.getElementById("passwordHelpBlock").innerHTML = xhr.responseText;

                }
            };

        }
    }
</script>