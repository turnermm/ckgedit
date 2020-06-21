<?php
    /**
     * Support samesite cookie flag in both php 7.2 (current production) and php >= 7.3 (when we get there)
     * From: https://github.com/GoogleChromeLabs/samesite-examples/blob/master/php.md and https://stackoverflow.com/a/46971326/2308553 
     */
     function setcookieSameSite($name, $value, $expire=0, $path ='/', $domain="", $httponly="HttpOnly", $secure=false, $samesite="Lax")
     {
          if (PHP_VERSION_ID < 70300) {
                setcookie($name, $value, $expire, "$path; samesite=$samesite", $domain, $secure, $httponly);
          }
         else {
             setcookie($name, $value, [
                     'expires' => $expire,
                     'path' => $path,
                     'domain' => $domain,
                     'samesite' => $samesite,
                     'secure' => $secure,
                     'httponly' => $httponly,
            ]);
        }
    }
?>
