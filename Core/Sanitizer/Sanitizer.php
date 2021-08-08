<?php

declare(strict_types=1);

namespace Tahir\Core\Sanitizer;

use InvalidArgumentException;

class Sanitizer
{

    public function clean(array $data = []) : ?array
    {
        $input = [];

        if (count($data) > 0)
        {
            foreach ($data as $key => $value)
            {
                if (!isset($key))
                {
                    throw new InvalidArgumentException('Invalid key');
                }

                if (!is_array($value))
                {
                    $value = trim(stripslashes($value));
                    
                    $input = array_merge( $input,$this->filterFunc($value, $key) );
                }

                if(is_array($value))
                {
                    if (count($value) > 0)
                    {
                        $arrInput = [];

                        foreach ($value as $arrKey => $arrValue)
                        {
                            $arrInput = array_merge( $arrInput, $this->filterFunc($arrValue,$arrKey) );
                        }

                        $input =  array_merge( $input, $arrInput );

                    }
                }
            }

            if (isset($input) && $input !='')
            {
                return $input;
            }
        }

        return [];
    }

    private function filterFunc( mixed $value,mixed $key ) : array
    {
        $input = [];

        switch ($value) {

            case is_int($value) :
                $input[$key] = isset($value) ? filter_var($value, FILTER_SANITIZE_NUMBER_INT) : '';
                break;
            
            case is_float($value) :
                $input[$key] = isset($value) ? filter_var($value, FILTER_SANITIZE_NUMBER_FLOAT) : '';
                break;
/*            
            case $this->is_url($value) :
                $input[$key] = isset($value) ? filter_var($value, FILTER_SANITIZE_URL) : '';
                break;
            
            case $this->is_email($value) :
                $input[$key] = isset($value) ? filter_var($value, FILTER_SANITIZE_EMAIL) : '';
                break;*/

            default:
                $input[$key] = isset($value) ? filter_var($value, FILTER_SANITIZE_STRING) : '';
        }

        return $input;
    }

    private function is_email($email)
    {
        return (preg_match("/(@.*@)|(\.\.)|(@\.)|(\.@)|(^\.)/", $email) || !preg_match("/^.+\@(\[?)[a-zA-Z0-9\-\.]+\.([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/", $email)) ? false : true;
    }

    private function is_url($posted_url)
    {
    
            $regularExpression  = "((https?|ftp)\:\/\/)?"; // SCHEME Check
            $regularExpression .= "([a-z0-9+!*(),;?&=\$_.-]+(\:[a-z0-9+!*(),;?&=\$_.-]+)?@)?"; // User and Pass Check
            $regularExpression .= "([a-z0-9-.]*)\.([a-z]{2,3})"; // Host or IP Check
            $regularExpression .= "(\:[0-9]{2,5})?"; // Port Check
            $regularExpression .= "(\/([a-z0-9+\$_-]\.?)+)*\/?"; // Path Check
            $regularExpression .= "(\?[a-z+&\$_.-][a-z0-9;:@&%=+\/\$_.-]*)?"; // GET Query String Check
            $regularExpression .= "(#[a-z_.-][a-z0-9+\$_.-]*)?"; // Anchor Check
            
            if(preg_match("/^$regularExpression$/i", $posted_url))
            { 
                return true;
            }
            
            return false;
    }

}