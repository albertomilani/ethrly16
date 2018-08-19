<?php

require('EthRly.inc.php');

$board_ip = "192.168.1.1";
$board_port = 17494;

$board = new EthRly($board_ip, $board_port);
$board->connect();

$action = $_REQUEST['action'];

switch ($action) {
  
  case 'turn_relay_on':
    $relay = $_REQUEST['relay_num'];
    $board->turnRelayOn($relay);
    echo json_encode(array('success' => true));
    break;

  case 'turn_relay_off':
    $relay = $_REQUEST['relay_num'];
    $board->turnRelayOff($relay);
    echo json_encode(array('success' => true));
    break;

  case 'turn_all_relay_off':
    $board->turnAllRelayOff();
    echo json_encode(array('success' => true));
    break;

  case 'get_all_statuses':
    $status = $board->getRelayStatus();
    echo json_encode(array('success' => true, 'data' => $status));
    break;

  case 'get_firmware':
    $version = $board->getBoardVersion();
    echo json_encode(array('success' => true, 'version' => $version));
    break;

  case 'get_input_voltage':
    $voltage = $board->getInputVoltage();
    echo json_encode(array('success' => true, 'voltage' => $voltage));
    break;

  case 'get_ip_address':
    echo json_encode(array('success' => true, 'ip' => $board_ip));
    break;

}


