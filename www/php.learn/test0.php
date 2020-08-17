<?php

namespace Specialist;


function rand(){
  return 'Ураа-а-а-аа!';
}

echo rand(), "<hr />";
echo \rand(), "<hr />";
echo \Specialist\rand(), "<hr />";