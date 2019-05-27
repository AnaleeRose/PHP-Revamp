<?php
namespace includes\Authenticate;

class CheckPassword {

    protected $pwd;
    protected $minChars;
    protected $mixedCase = false;
    protected $minNum = 0;
    protected $minSymbols = 0;
    protected $errors = [];

    public function __construct($pwd, $minChars = 8) {
        $this->pwd = $pwd;
        $this->minChars = $minChars;
    }

    public function requireMixedCase() {
        $this->mixedCase = true;
    }

    public function requireNumbers($num = 1) {
        if (is_numeric($num) && $num > 0) {
            $this->minNum = (int) $num;
        }
    }

    public function requireSymbols($num = 1) {
        if (is_numeric($num) && $num > 0) {
            $this->minSymbols = (int) $num;
        }
    }

    public function check() {
        if (preg_match('/\s/', $this->pwd)) {
            $this->errors[] = 'Password cannot contain spaces.';
        }
        if (strlen($this->pwd) < $this->minChars) {
            $this->errors[] = "Password must be at least
                $this->minChars characters.";
        }
        if ($this->mixedCase) {
            $pattern = '/(?=.*[a-z])(?=.*[A-Z])/';
            if (!preg_match($pattern, $this->pwd)) {
                $this->errors[] = 'Password should include uppercase
                    and lowercase characters.';
            }
        }
        if ($this->minNum) {
            $pattern = '/\d/';
            $found = preg_match_all($pattern, $this->pwd, $matches);
            if ($found < $this->minNum) {
                $this->errors[] = "Password should include at least
                    $this->minNum number(s).";
            }
        }
        return $this->errors ? false : true;
    }

    public function getErrors() {
        return $this->errors;
    }

}
