<?php

namespace Osama\phpmvc;

class Validated
{
    protected $errors = [];
    protected $rules = [];
    protected $data = [];
    protected $message = [
        "required" => "The {field} field is required.",
        "max" => "The {field} field must be less than or equal to {max}.",
        "min" => "The {field} field must be greater than or equal to {min}.",
        "email" => "The email address '{field}' is invalid.",
        "confirmed" => "The {field} field must match the {confirmed} field."
    ];

   
    public function validate($data = [], $rules = [])
    {
        
        // ["???" => ["???","????"]]
        foreach($rules as $key => $value)
        {
            foreach($value as $rule)
            {
                if(is_string($rule))$ruleName = $rule;
                else {$ruleName = $rule[0];}

                if($ruleName == "required"){

                    if(strlen(trim($data[$key])) == 0){
                        $this->setError($key , $ruleName);
                    }

                }
                else if($ruleName == "max"){
                    if(strlen(trim($data[$key])) > $rule[1]+0)
                    {
                        $this->setError($key , $rule);

                    }

                }
                else if($ruleName == "min"){
                    if(strlen(trim($data[$key])) < $rule[1]+0)
                    {
                        $this->setError($key , $rule);

                    }
                }
                else if($ruleName == "email"){
                    if(!filter_var($data[$key], FILTER_VALIDATE_EMAIL))
                    {
                        $this->setError($data[$key] , $ruleName);
                    }
                }
                else if($ruleName == "confirmed"){
                    if($data[$key] != $data[$rule[1]])
                    {
                        $this->setError($key , $rule);
                    }
                }
            }
        }

        return $this->errors;
        
    }   
    
    protected function setError(string $key , $rule)
    {
        if(is_array($rule))
        {
            $errorMessage = $this->message[$rule[0]];
            $errorMessage = str_replace("{field}",$key,$errorMessage);
            $errorMessage = str_replace("{{$rule[0]}}",$rule[1],$errorMessage);
        }
        else{
            $errorMessage = $this->message[$rule];
            $errorMessage = str_replace("{field}",$key,$errorMessage);
        }
       
        $this->errors[$key][] = $errorMessage;

    }

    public function isValid():bool
    {
        return empty($this->errors);
    }
}