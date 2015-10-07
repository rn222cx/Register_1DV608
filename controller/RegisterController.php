<?php
require_once('exceptions/UserAlreadyExistException.php');
require_once('exceptions/UsernameLengthException.php');
require_once('exceptions/PasswordDosentMatchException.php');
require_once('exceptions/PasswordLengthException.php');
require_once('exceptions/UsernameInvalidCharactersException.php');
require_once('exceptions/NameAndPasswordLengthException.php');


require_once('view/RegisterView.php');
require_once('model/RegisterModel.php');
require_once('model/RegisterUser.php');


class RegisterController
{
    private $registerView;
    private $registerModel;
    private $layoutView;

    public function __construct()
    {
        $this->layoutView = new LayoutView();
        $this->registerModel = new RegisterModel();
        $this->registerView = new RegisterView($this->registerModel);
    }

    public function doControl()
    {

        if ($this->registerView->userWantsToRegister()) {

            $credentials = $this->registerView->getCredentials();
            if ($credentials) {
                try {
                    if ($this->registerModel->doRegister($credentials) == true)
                        $this->registerView->redirectToLoginPage();

                } catch (UserAlreadyExistException $e) {
                    $this->registerView->getExceptions($e->getMessage());
                }
            }
        }


        $this->layoutView->render(false, $this->registerView);
    }
}