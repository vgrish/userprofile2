<?php

$xpdo_meta_map = array (
  'xPDOObject' => 
  array (
    0 => 'up2Profile',
  ),
  'xPDOSimpleObject' => 
  array (
    0 => 'up2TypeField',
    1 => 'up2TypeTab',
    2 => 'up2Fields',
    3 => 'up2Tabs',
    4 => 'up2TypeProfile',
  ),
);

$this->map['modUser']['composites']['up2Profile'] = array(
    'class' => 'up2Profile',
    'local' => 'id',
    'foreign' => 'id',
    'cardinality' => 'one',
    'owner' => 'local',
);
