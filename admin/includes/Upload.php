<?php
namespace includes;
class Upload {

    protected $uploaded = [];
    protected $destination;
    protected $messages = [];
    protected $permitted = [
        'image/gif',
        'image/jpeg',
        'image/jpg',
        'image/png'
    ];
    protected $typeCheckingOn = true;
    protected $notTrusted = ['bin', 'cgi', 'exe', 'js', 'pl', 'php', 'py', 'sh', 'package'];
    protected $suffix = '.upload';
    protected $newName;
    protected $albumName;
    protected $renameDuplicates;
    public $yep = false;


    public function __construct($path, $an) {
        if (!is_dir($path) || !is_writable($path)) {
            throw new \Exception("$path must be a valid, writable directory.");
        }
        $this->destination = $path;
        $this->albumName = $an;
    }

    public function upload($renameDuplicates = true) {
        $this->renameDuplicates = $renameDuplicates;
        $uploaded = current($_FILES);
        if (is_array($uploaded['name'])) {
            // deal with multiple uploads
            foreach ($uploaded['name'] as $key => $value) {
                $currentfile['name'] = $uploaded['name'][$key];
                $currentfile['type'] = $uploaded['type'][$key];
                $currentfile['tmp_name'] = $uploaded['tmp_name'][$key];
                $currentfile['error'] = $uploaded['error'][$key];
                $currentfile['size'] = $uploaded['size'][$key];
                if ($this->checkFile($currentFile)) {
                    $this->moveFile($currentFile);
                }
            }
        } else {
            if ($this->checkFile($uploaded)) {
                $this->moveFile($uploaded);
            }
        }
    }

    public function getMessages() {
        return $this->messages;
    }

    public function getMaxSize() {
        return number_format($this->max/1024, 1) . ' KB';
    }

    public function setMaxSize($num) {
        if (is_numeric($num) && $num > 0) {
            $this->max = (int) $num;
        }
    }

    protected function checkFile($file) {
        $accept = true;
        if ($file['error'] != 0) {
            $this->getErrorMessage($file);
            // stop checking if no file submitted
            if ($file['error'] == 4) {
                return false;
            } else {
                $accept = false;
            }
        }
        if (!$this->checkSize($file)) {
            $accept = false;
        }
        if ($this->typeCheckingOn) {
            if (!$this->checkType($file)) {
                $accept = false;
            }
        }
        if ($accept) {
            $this->checkName($file);
        }
        return $accept;
    }

    protected function getErrorMessage($file) {
        switch($file['error']) {
            case 1:
            case 2:
                $this->messages[] = $file['name'] . ' is too big: (max: ' .
                    $this->getMaxSize() . ').';
                break;
            case 3:
                $this->messages[] = $file['name'] . ' was only partially uploaded.';
                break;
            case 4:
                // $this->messages[] = 'No file submitted.';
                break;
            default:
                $this->messages[] = 'Sorry, there was a problem uploading ' . $file['name'];
                break;
        }
    }

    protected function checkSize($file) {
        if ($file['error'] == 1 || $file['error'] == 2) {
            return false;
        } elseif ($file['size'] == 0) {
            $this->messages[] = $file['name'] . ' is an empty file.';
            return false;
        } elseif ($file['size'] > $this->max) {
            $this->messages[] = $file['name'] . ' exceeds the maximum size
                for a file (' . $this->getMaxSize() . ').';
            return false;
        } else {
            return true;
        }
    }

    protected function checkType($file) {
        if (in_array($file['type'], $this->permitted)) {
            return true;
        } else {
            if (!empty($file['type'])) {
                $this->messages[] = $file['name'] . ' is not permitted type of file.';
            }
            return false;
        }
    }

    public function checkName($file) {
        //strips the name
        $extension = pathinfo($_FILES["cover"]["name"], PATHINFO_EXTENSION);
        $extension = strtolower($extension);
        $this->albumName .= '.' . $extension;

        if (!$this->typeCheckingOn && !empty($this->suffix)) {
            if (in_array($extension, $this->notTrusted) || empty($extension)) {
                $this->albumName = $this->albumName . $this->suffix;
            }
        }

        if ($this->renameDuplicates) {
            $name = isset($this->albumName) ? $this->albumName : $file['name'];
            $existing = scandir($this->destination);
            if (in_array($name, $existing)) {
                // rename file
                $basename = pathinfo($name, PATHINFO_FILENAME);
                $extension = pathinfo($name, PATHINFO_EXTENSION);
                $i = 1;
                do {
                    $this->albumName = $basename . '_' . $i++;
                    if (!empty($extension)) {
                        $this->albumName .= ".$extension";
                    }
                } while (in_array($this->albumName, $existing));
            }
        }

    }
        // if ($this->renameDuplicates) {
        //     $name = isset($this->newName) ? $this->newName : $file['name'];
        //     $existing = scandir($this->destination);
        //     if (in_array($name, $existing)) {
        //         // rename file
        //         $basename = pathinfo($name, PATHINFO_FILENAME);
        //         $extension = pathinfo($name, PATHINFO_EXTENSION);
        //         $i = 1;
        //         do {
        //             $this->newName = $basename . '_' . $i++;
        //             if (!empty($extension)) {
        //                 $this->newName .= ".$extension";
        //             }
        //         } while (in_array($this->newName, $existing));
        //     }
        // }

    // protected function checkName($file) {
    //     $this->newName = null;
    //     $nospaces = str_replace(' ', '_', $file['name']);
    //     if ($nospaces != $file['name']) {
    //         $this->newName = $nospaces;
    //     }
    //     $extension = pathinfo($nospaces, PATHINFO_EXTENSION);
    //     if (!$this->typeCheckingOn && !empty($this->suffix)) {
    //         if (in_array($extension, $this->notTrusted) || empty($extension)) {
    //             $this->newName = $nospaces . $this->suffix;
    //         }
    //     }
    //     if ($this->renameDuplicates) {
    //         $name = isset($this->newName) ? $this->newName : $file['name'];
    //         $existing = scandir($this->destination);
    //         if (in_array($name, $existing)) {
    //             // rename file
    //             $basename = pathinfo($name, PATHINFO_FILENAME);
    //             $extension = pathinfo($name, PATHINFO_EXTENSION);
    //             $i = 1;
    //             do {
    //                 $this->newName = $basename . '_' . $i++;
    //                 if (!empty($extension)) {
    //                     $this->newName .= ".$extension";
    //                 }
    //             } while (in_array($this->newName, $existing));
    //         }
    //     }
    // }

    protected function moveFile($file) {
        $filename = isset($this->albumName) ? $this->albumName : $_POST['name'];
        $success = move_uploaded_file($file['tmp_name'], $this->destination . $filename);
        if ($success) {
            $result = '<span id="success">'.$file['name'] . ' was uploaded successfully'.'</span>';
            if (!is_null($this->albumName)) {
                $result .= ', and was renamed ' . $this->albumName;
            }
            $this->messages[] = $result;
            $this->yep = true;
        } else {
            $this->messages[] = 'Could not upload ' . $file['name'];
        }
    }

    public function checkYep($yep)
    {
        if ($this->yep = true) {
            return $yep;
        }
    }


}
