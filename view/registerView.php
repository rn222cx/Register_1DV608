<?php


class RegisterView
{
    private static $register = 'RegisterView::Register';
    private static $name = 'RegisterView::UserName';
    private static $password = 'RegisterView::Password';
    private static $repeatPassword = 'RegisterView::PasswordRepeat';
    private static $messageId = 'RegisterView::Message';

    private $message;
    private $registerModel;


    public function __construct(RegisterModel $registerModel)
    {
        $this->registerModel = $registerModel;
    }

    public function response()
    {
        return $this->generateRegisterFormHTML($this->message);
    }

    public function generateRegisterFormHTML($message)
    {
        return '
        <h2>Register new user</h2>
			<form method="post" >
				<fieldset>
					<legend>Register a new user - Write username and password</legend>
					<p id="' . self::$messageId . '">' . $message . '</p>
					<label for="' . self::$name . '">Username :</label>
					<input type="text" id="' . self::$name . '" name="' . self::$name . '" value="' . $this->getUsername() . '" />
                    <br>
					<label for="' . self::$password . '">Password :</label>
					<input type="password" id="' . self::$password . '" name="' . self::$password . '" />
                    <br>
                    <label for="' . self::$repeatPassword . '">Repeat password :</label>
					<input type="password" id="' . self::$repeatPassword . '" name="' . self::$repeatPassword . '" />
                    <br>
					<input type="submit" name="' . self::$register . '" value="Register" />
				</fieldset>
			</form>
		';
    }

    public function getUsername()
    {
        if (isset($_POST[self::$name]))
            return trim($_POST[self::$name]);
    }

    public function getPassword()
    {
        if (isset($_POST[self::$password]))
            return trim($_POST[self::$password]);
    }

    public function getRepeatPassword()
    {
        if (isset($_POST[self::$repeatPassword]))
            return trim($_POST[self::$repeatPassword]);
    }

    public function validateFormInputs()
    {
        if (strlen($this->getUsername()) < 3)
            $this->message .= "Username has too few characters, at least 3 characters.<br>";

        if (strlen($this->getPassword()) < 6)
            $this->message .= "Password has too few characters, at least 6 characters.<br>";

        if ($this->getPassword() != $this->getRepeatPassword())
            $this->message .= "Passwords do not match.<br>";

        if (filter_var($this->getUsername(), FILTER_SANITIZE_STRING) !== $this->getUsername()) {
            $this->message .= "Username contains invalid characters.<br>";
            $_POST[self::$name] = strip_tags($_POST[self::$name]);
        }
        return $this->message;
    }

    public function getCredentials()
    {
        return new \model\RegisterUser(
            $this->getUsername(),
            $this->getPassword());
    }

    public function userWantsToRegister()
    {
        return isset($_POST[self::$register]);
    }

    public function getExceptions($exception)
    {
        if (strpos($exception, 'userAlreadyExistException'))
            $this->message = "User exists, pick another username.";
    }

    public function redirectToLoginPage()
    {
       // header("Location: ?");
        $loginPage = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];
        header("Location: $loginPage");
    }

}