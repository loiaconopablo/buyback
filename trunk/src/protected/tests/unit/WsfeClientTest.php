<?php
require_once '../../../index.php';
require_once '../../vendors/wsfe/WsfeClient.php';

class WsfeClientTest extends \PHPUnit_Framework_TestCase {

	/**
	 * @covers  \WsfeClient::__construct
	 */
	public function testLaClaseSePuedeInstanciar() {
		$obj = new WsfeClient;
		$this->assertInstanceOf(WsfeClient::class, $obj);
		return $obj;
	}
}