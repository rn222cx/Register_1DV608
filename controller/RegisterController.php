<?php
require_once('exceptions/userAlreadyExistException.php');

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

            if ($this->registerView->validateFormInputs() == null) {
                $credentials = $this->registerView->getCredentials();
                try {
                    if ($this->registerModel->doRegister($credentials) == true)
                        $this->registerView->redirectToLoginPage();

                } catch (userAlreadyExistException $e) {
                    $this->registerView->getExceptions($e->getMessage());
                }

            }

        }

        $this->layoutView->render(false, $this->registerView);
    }
}