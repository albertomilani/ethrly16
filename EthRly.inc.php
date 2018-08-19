<?php

class EthRly {

  protected $ip;
  protected $port;
  protected $socket;

  public function __construct($ip, $port) {

    $this->ip = $ip;
    $this->port = $port;
  }

  public function __destruct() {

    fclose($this->socket);
  }

  public function connect() {

    $this->socket = fsockopen($this->ip, $this->port, $errno, $errstr, 30);
    socket_set_timeout($this->socket, 1);
    if (!$this->socket) {
    }
  }

  protected function write ($command) {

    $out = pack('C', $command);
    $ret = fwrite($this->socket, $out);
    $res = fread($this->socket,1);
    $res = ord($res);
    $ret = fwrite($this->socket, "\x00");
    return $res;

  }

  public function turnRelayOn ($relay_num) {
    
    $command = 0x64 + $relay_num;
    $res = $this->write($command);
    return true;
  }

  public function turnRelayOff ($relay_num) {

    $command = 0x6E + $relay_num;
    $res = $this->write($command);
    return true;
  }

  public function turnAllRelayOn() {
    $res = $this->write(0x64);
    return true;
  }

  public function turnAllRelayOff() {
    $res = $this->write(0x6E);
    return true;
  }

  public function getRelayStatus() {
    $res = $this->write(0x5B);
    $status = array();
    $status[1] = $res & 0b00000001;
    $status[2] = ($res & 0b00000010) >> 1;
    $status[3] = ($res & 0b00000100) >> 2;
    $status[4] = ($res & 0b00001000) >> 3;
    $status[5] = ($res & 0b00010000) >> 4;
    $status[6] = ($res & 0b00100000) >> 5;
    $status[7] = ($res & 0b01000000) >> 6;
    $status[8] = ($res & 0b10000000) >> 7;
    return $status;
  }

  public function getBoardVersion() {
    $res = $this->write(0x5A);
    return $res;
  }

  public function getInputVoltage() {
    $res = floatval($this->write(0x5D))/10.0;
    return $res;
  }


}

