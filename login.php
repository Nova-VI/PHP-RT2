
    <div class="container mt-5 col-4 bg-light p-4 rounded-3 shadow">
        <form action="login.action.php" method="post">
            <div class="mb-3">
                <label for="emailfield" class="form-label">Email address</label>
                <input type="email" class="form-control" id="emailfield" aria-describedby="emailHelp"
                    placeholder="Enter Ur Email" required autofocus name="email">
                <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
            </div>
            <div class="mb-3">
                <label for="passwordfield" class="form-label">Password</label>
                <input type="password" class="form-control" id="passwordfield" aria-describedby="passwordHelpBlock"
                    name="password">
                <div id="passwordHelpBlock" class="form-text">
                    Your password must be 8-20 characters long, contain letters and numbers, and must not contain
                    spaces, special
                    characters, or emoji.
                </div>
            </div>
            <div class="mb-3 form-check">
                <input type="checkbox" class="form-check-input" id="exampleCheck1" name="check">
                <label class="form-check-label" for="exampleCheck1">Check me out</label>
            </div>
            <button type="submit" class="btn btn-primary ">Submit</button>
            <a href=signup.php class="btn btn-secondary">Sign Up</a>
        </form>
    </div>
