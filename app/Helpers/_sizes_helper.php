<?php
function getSize($size){
return constant("App\Enums\Sizes::$size")->value;
}