<?php
// ************************************
// This file is part of a package from:
// www.majesticform.com

// Free Version
// 2 January 2022

// You are free to use an edit for 
// your own use. But cannot resell
// or repackage in any way.
// ************************************

class FormValidate {
    
    private $error_messages = array(); 
    
    public function validate($name, $display_name, $value, $type) {

        $type_options = explode(",",$type);

        switch ($type_options[0]) {
        	
            case "NOT_EMPTY":
                if($this->isEmpty($value)) {
                    $this->error_messages[] = "'$display_name' is required";
                } else {
                    if(isset($type_options[1])) {
                        if(!$this->minlength($value, $type_options[1])) {
                            $this->error_messages[] = "'$display_name' must contain a minimum of {$type_options[1]} characters";
                        }
                    }
                    if(isset($type_options[2])) {
                        if(!$this->maxlength($value, $type_options[2])) {
                            $this->error_messages[] = "'$display_name' must contain a maximum of {$type_options[2]} characters";
                        }
                    }
                }
                break;

            case "FILE":
                if($this->isEmpty($value)) {
                    $this->error_messages[] = "'$display_name' is required";
                    continue;
                } 
                if(!$this->validFileType($value['name'], $type_options)) {
                    $this->error_messages[] = "'$display_name' has an invalid file type";
                    continue;
                }

                if(!$this->validFileSize($value['size'], $type_options[1])) {
                    $this->error_messages[] = "'$display_name' must be less than {$type_options[1]}Kb in size";
                }
                break;

            case "DIGITS":
                $exp = '/^[0-9]+$/';
                if (!$this->isEmpty($value) && !preg_match($exp, $value)) {
                    $this->error_messages[] = "'$display_name' must only contain numbers";
                } 
                break;

            case "EMAIL":
                $exp = '/^[A-Z0-9._%-]+@[A-Z0-9.-]+\.[A-Z]{2,4}$/i';
                if (!$this->isEmpty($value) && !preg_match($exp, $value)) {
                    $this->error_messages[] = "'$display_name' requires a valid email address";
                } 
                break;

        } 
    } 
    
    public function anyErrors() {
        if(count($this->error_messages) > 0) {
            return true;
        }
        return false;
    }
    
    public function getErrorString() {
        $return_value = "";
        foreach($this->error_messages as $message) {
            $return_value .= "<li>$message</li>";
        }
        return $return_value;
    }
    
    private function isEmpty($value) {
        if(is_array($value)) {
            foreach($value as $val) {
                return $this->isEmpty($val);
            }
        }
        if (trim($value) == "") {
            return true;
        } else {
            return false;
        } 
    } 

    private function validFileType($value_name, $type_options) {
        if(is_array($value_name)) {
            foreach($value_name as $filename) {
                $ext = pathinfo($filename, PATHINFO_EXTENSION);
                if (!in_array($ext, $type_options)) {
                    return false;
                }
            }
        } else {
            $ext = pathinfo($value_name, PATHINFO_EXTENSION);
            if (!in_array($ext, $type_options)) {
                return false;
            }
        }
        return true;
    }

    private function validFileSize($value_size, $maxfilesize) {
        if(is_array($value_size)) {
            foreach($value_size as $filesize) {
                if($filesize == 0 || ($filesize / 1024) > $maxfilesize) {
                    return false;
                }
            }
        } else {
            if($value_size == 0 || ($value_size / 1024) > $maxfilesize) {
                return false;
            }
        }
        return true;
    }

    private function minlength($value, $minlength) {
        if(strlen(trim($value)) < $minlength) {
            return false;
        }
        return true;
    }

    private function maxlength($value, $maxlength) {
        if(strlen(trim($value)) > $maxlength) {
            return false;
        }
        return true;
    }
    
}