<div class="login-page">
    <form method="post" class="login-form">
        <h1 class="text-center">Inloggen</h1>
        <div class="form-group">
            <label for="logonName">E-mail: </label>
            <input id="logonName" type="text" class="form-control" placeholder="E-mailadres" name="logonName" required="required">
        </div>
        <div class="form-group">
            <label for="password">Wachtwoord: </label>
            <input id="password" type="password" class="form-control" placeholder="Wachtwoord" name="password" required="required">
        </div>
        <div class="form-group">
            <input id="submitLogin" type="submit" class="form-control btn-primary" value="Inloggen" name="submitLogin">
        </div>
<!--        <div class="text-center">-->
<!--            <a href="#">Wachtwoord vergeten?</a>-->
<!--        </div>-->
    </form>
    <div class="login-form">
        <div class="form-group">
            <h3 class="text-center">Nog geen account?</h3>
            <a href="register.php"><button class="form-control btn-primary">Registreer hier!</button></a>
        </div>
    </div>
</div>