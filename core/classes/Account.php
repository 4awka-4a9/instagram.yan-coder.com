<?php

class Account
{

    private $errors = array();
    private $passed = false;
    private $pdo;

    public function __construct()
    {
        $this->pdo = Database::connect();
    }

    public function register_user($username, $fullName, $email, $password)
    {

        $encryptedPassword = $this->hash_password($password);
        $ip = $this->getIP();
        $os = $this->getOS();
        $browser = $this->getBrowser();

        $stmt = $this->pdo->prepare("INSERT INTO users (username, fullName, password, email, pri_ip, pri_os, pri_browser) VALUES (:username, :fullName, :password, :email, :pri_ip, :pri_os, :pri_browser)");
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->bindParam(':fullName', $fullName, PDO::PARAM_STR);
        $stmt->bindParam(':password', $encryptedPassword, PDO::PARAM_STR);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':pri_ip', $ip, PDO::PARAM_STR);
        $stmt->bindParam(':pri_os', $os, PDO::PARAM_STR);
        $stmt->bindParam(':pri_browser', $browser, PDO::PARAM_STR);

        $stmt->execute();

        return $this->pdo->lastInsertId();

    }

    public function login_user($email_username, $password)
    {

        if (!empty($email_username) && !empty($password)) {

            $stmt = $this->pdo->prepare("SELECT * FROM users WHERE email = :username OR username = :username");
            $stmt->bindParam(':username', $email_username, PDO::PARAM_STR);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_OBJ);

            if ($stmt->rowCount() != 0) {

                if (password_verify($password, $row->password)) {

                    if (empty($this->errors())) {

                        $this->passed = true;
                        return $row->user_id;

                    }

                } else {

                    $this->addError("Username and Password Incorrect");
                    return false;

                }

            } else {

                $this->addError("Username and Passord Incorrect");
                return false;

            }

        }

    }

    public function hash_password($password)
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }

    public function getOS()
    {

        $user_agent = $_SERVER['HTTP_USER_AGENT'];
        $os_platform = "Unknown OS Platform";
        $os_array = [
            '#windows nt 10#i' => 'Windows 10',
            '#windows nt 6.3#i' => 'Windows 8.1',
            '#windows nt 6.2#i' => 'Windows 8',
            '#windows nt 6.1#i' => 'Windows 7',
            '#windows nt 6.0#i' => 'Windows Vista',
            '#windows nt 5.2#i' => 'Windows Server 2003#XP x64',
            '#windows nt 5.1#i' => 'Windows XP',
            '#windows xp#i' => 'Windows XP',
            '#windows nt 5.0#i' => 'Windows 2000',
            '#windows me#i' => 'Windows ME',
            '#win98#i' => 'Windows 98',
            '#win95#i' => 'Windows 95',
            '#win16#i' => 'Windows 3.11',
            '#macintosh|mac os x#i' => 'Mac OS X',
            '#mac_powerpc#i' => 'Mac OS 9',
            '#linux#i' => 'Linux',
            '#ubuntu#i' => 'Ubuntu',
            '#iphone#i' => 'iphone',
            '#ipod#i' => 'iPod',
            '#ipad#i' => 'iPad',
            '#android#i' => 'Android',
            '#blackberry#i' => 'BlackBerry',
            '#webos#i' => 'Mobile',
        ];

        foreach ($os_array as $regex => $value) {

            if (preg_match($regex, $user_agent)) {
                $os_platform = $value;
            }

        }

        return $os_platform;

    }

    public function getBrowser()
    {

        $user_agent = $_SERVER['HTTP_USER_AGENT'];
        $browser = "Unknown Browser";
        $browser_array = array(
            '#msie#i' => 'Internet Explorrer',
            '#firefox#i' => 'Firefox',
            '#safari#i' => 'Safari',
            '#chrome#i' => 'Chrome',
            '#edge#i' => 'Edge',
            '#opera#i' => 'Opera',
            '#netspace#i' => 'Netspace',
            '#maxthon#i' => 'Maxthon',
            '#konqueror#i' => 'Konqueror',
            '#mobile#i' => 'Handheld Browser',
        );

        foreach ($browser_array as $regex => $value) {

            if (preg_match($regex, $user_agent)) {
                $browser = $value;
            }

        }

        return $browser;

    }

    public function getIP()
    {

        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip_add = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED'])) {
            $ip_add = $_SERVER['HTTP_X_FORWARDED'];
        } else {
            $ip_add = $_SERVER['REMOTE_ADDR'];
        }

        return $ip_add;

    }

    public function check($source, $items = array())
    {

        foreach ($items as $item => $rules) {

            foreach ($rules as $rule => $rule_vale) {

                $value = $source[$item];
                $item = escape($item);

                if (!empty($value)) {

                    switch ($rule) {

                        case 'max':

                            if (strlen(trim($value)) > $rule_vale) {
                                $this->addError("{$item} must be a maximum of {$rule_vale} characters.");
                            }
                            break;

                        case 'unique':

                            if ($this->userExists($item, $value)) {
                                $this->addError("{$item} already exists.");
                            }

                            break;

                    }

                }

            }

        }

        if (empty($this->errors)) {
            $this->passed = true;
        }

    }

    private function userExists($item, $value)
    {

        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE $item = :$item");
        $stmt->bindParam(":$item", $value, PDO::PARAM_STR);
        $stmt->execute();
        $stmt->rowCount();

        if ($stmt->rowCount() > 0) {
            return true;
        } else {
            return false;
        }

    }

    public function addError($errors)
    {
        $this->errors[] = $errors;
    }
    public function errors()
    {
        return $this->errors;
    }
    public function passed()
    {
        return $this->passed;
    }

}