<?php

Yii::import('ext.wsfe.models.*', true);

class WsfeClient {
	/**
	 * TODO: pasar todos estas constantes a un archivo de configuracion
	 */
	const IVA = 0.17355;

	const SERVICE_URL = 'http://localhost:8080';

	const PUNTO_DE_VENTA = 124;

	const TIPO_DE_COMPROBANTE = 49;
	const TIPO_IVA = 5;
	const CONCEPTO = 1;
	const TIPO_DOCUMENTO_DNI = 96;
	const TIPO_DE_MONEDA = 'PES';
	const IMPORTE_NO_GRAVADO = 0;

	const OPCIONAL_NOMBRE = 91;
	const OPCIONAL_DIRECCION = 93;

	/**
	 * Devuelve el proximo numero de contrato para el cual solicitar CAE
	 * @author Richard Grinberg
	 * @return integer
	 */
	public function getProximoComprobante() {
		try {
			$output = Yii::app()->curl->get(self::SERVICE_URL . '/wsfe/cae/ultimo/' . self::TIPO_DE_COMPROBANTE . '/' . self::PUNTO_DE_VENTA);
		} catch (Exception $e) {
			die(var_dump($e));
			throw new Exception($e->message, 1);
		}

		$ultimo = CJSON::decode($output, false);

		if (!$ultimo) {
			throw new Exception("No se pudo obtener el último número de comprobante", 1);
		}

		$cbteNro = $ultimo->cbteNro;

		$cbteNro++;

		return $cbteNro;
	}

	/**
	 * Usa el jar para comunicarse con la Afip y obtener un nuevo CAE
	 * @author Richard Grinberg
	 * @param array :con los datos para armar el request para solicitar el CAE
	 * @return array : con ["nro_cae"] ["json_response"]
	 */
	public function getCaeDesdeAfip(array $comprobante_data) {
		/**  Alic IVA  N  **/
		$alicIva = new AlicIva;

		$alicIva->baseImp = $comprobante_data['impNeto'];
		$alicIva->importe = $comprobante_data['impIVA'];
		$alicIva->id = self::TIPO_IVA;

		/**  IVA array de AlicIvas  **/
		$iva = new Iva;

		$iva->alicIva[] = $alicIva;

		/** Opcional N **/
		$opcional01 = new Opcional;

		$opcional01->valor = $comprobante_data['sellerName'];
		$opcional01->id = self::OPCIONAL_NOMBRE;

		$opcional02 = new Opcional;

		$opcional02->valor = $comprobante_data['sellerAddress'];
		$opcional02->id = self::OPCIONAL_DIRECCION;

		/** Opcionales array de Opcional **/
		$opcionales = new Opcionales;

		$opcionales->opcional[] = $opcional01;
		$opcionales->opcional[] = $opcional02;

		/** FecaedetRequest N **/
		$fecaedetRequest = new FecaedetRequest;

		$fecaedetRequest->iva = $iva;
		$fecaedetRequest->concepto = self::CONCEPTO;
		$fecaedetRequest->docTipo = self::TIPO_DOCUMENTO_DNI;
		$fecaedetRequest->docNro = $comprobante_data['sellerDni'];
		$fecaedetRequest->cbteDesde = $comprobante_data['cbteNro'];
		$fecaedetRequest->cbteHasta = $comprobante_data['cbteNro'];
		$fecaedetRequest->cbteFch = date('Ymd');
		$fecaedetRequest->impTotal = $comprobante_data['impTotal'];
		$fecaedetRequest->impTotConc = self::IMPORTE_NO_GRAVADO;
		$fecaedetRequest->impNeto = $comprobante_data['impNeto'];
		$fecaedetRequest->impOpEx = 0;
		$fecaedetRequest->impTrib = 0;
		$fecaedetRequest->impIVA = $comprobante_data['impIVA'];
		$fecaedetRequest->fchServDesde = null;
		$fecaedetRequest->fchServHasta = null;
		$fecaedetRequest->fchVtoPago = null;
		$fecaedetRequest->monCotiz = 1;
		$fecaedetRequest->cbtesAsoc = null;
		$fecaedetRequest->tributos = null;
		$fecaedetRequest->opcionales = $opcionales;
		$fecaedetRequest->monId = self::TIPO_DE_MONEDA;

		/** FeDetReq array de FecaedetRequest  **/
		$feDetReq = new FeDetReq;

		$feDetReq->fecaedetRequest[] = $fecaedetRequest;

		/** FeCabReq **/
		$feCabReq = new FeCabReq;

		$feCabReq->ptoVta = self::PUNTO_DE_VENTA;
		$feCabReq->cbteTipo = self::TIPO_DE_COMPROBANTE;
		$feCabReq->cantReg = 1;

		$cae_request = new FECAERequest;

		$cae_request->feCabReq = $feCabReq;
		$cae_request->feDetReq = $feDetReq;

		$output = Yii::app()->curl->post("http://localhost:8080/wsfe/cae", CJSON::encode($cae_request));

		return $output;
	}

	/**
	 * Arma el array para construir el data request para obtener el CAE
	 * @author Richard Grinberg
	 * @param $contract_number integer
	 * @param $purchase float
	 * @param $sellr Seller
	 * @return array
	 */
	public function getCaeRequestData($contract_number, $purchase_price, Seller $seller) {
		$impIVA = round($purchase_price * self::IVA, 2);
		$impNeto = $purchase_price - $impIVA;
		$impTotal = $impNeto + $impIVA;

		$cae_request_data['impTotal'] = $impTotal;
		$cae_request_data['impNeto'] = $impNeto;
		$cae_request_data['impIVA'] = $impIVA;
		$cae_request_data['sellerName'] = $seller->name;
		$cae_request_data['sellerAddress'] = $seller->address;
		$cae_request_data['sellerDni'] = $seller->dni;
		$cae_request_data['cbteNro'] = $contract_number;

		return $cae_request_data;
	}

	/**
	 * Obtiene el proximo NUMERO DE CONRATO a pedir
	 * Una vez obtenido el NUMERO DE CONTRATO arma el array con el formato para realizar
	 * el request contra el webservice de la AFIP
	 * Obtiene el numero de CAE para ese NUMERO DE CONTRATO
	 *
	 * @author Richard Grinberg
	 * @param $purchase float
	 * @param $sellr Seller
	 * @return array
	 */
	public function getCaeParaContrato($purchase_price, Seller $seller) {

		$contract_number = $this->getProximoComprobante();

		$cae_request_data = $this->getCaeRequestData($contract_number, $purchase_price, $seller);

		$cae_json_response = $this->getCaeDesdeAfip($cae_request_data);

		$responseObj = CJSON::decode($cae_json_response, false);

		if (!isset($responseObj->feDetResp->fecaedetResponse[0]->cae)) {
			throw new Exception("La respuesta de la AFIP no trae CAE", 1);
		}

		if ($responseObj->feCabResp->resultado != 'A') {
			// 'A': Respuesta del servicio de la AFIP APROBADO
			$error_text = '';
			foreach ($responseObj->errors->err as $error) {
				$error_text .= ' - ERROR -' . $error->code . ' : ' . $error->msg;
			}

			throw new Exception($error_text, 1);
		}

		$response_array = array(
			'contract_number' => $contract_number,
			'cae' => $responseObj->feDetResp->fecaedetResponse[0]->cae,
			'json_response' => $cae_json_response,
		);

		return $response_array;

	}
}