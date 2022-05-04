<?php

namespace App\Http\Controllers;

use Afip;
use Illuminate\Http\Request;

class AfipController extends Controller
{
    public $afip;

    public function __construct()
    {
        $this->afip = new Afip(array('CUIT' => 20349590418));
    }

    public function lastVoucher()
    {
        return $this->afip->ElectronicBilling->GetLastVoucher(1, 11); // (punto de venta, cod tipo comprobante)
    }

    public function createVoucher()
    {
        $last_voucher = $this->lastVoucher();

        $data = array(
            'CantReg'     => 1,  // Cantidad de comprobantes a registrar
            'PtoVta'      => 1,  // Punto de venta
            'CbteTipo'    => 11,  // Tipo de comprobante (ver tipos disponibles) 
            'Concepto'    => 1,  // Concepto del Comprobante: (1)Productos, (2)Servicios, (3)Productos y Servicios
            'DocTipo'     => 99, // Tipo de documento del comprador (99 consumidor final, ver tipos disponibles)
            'DocNro'      => 0,  // Número de documento del comprador (0 consumidor final)
            'CbteDesde'   => $last_voucher + 1,  // Número de comprobante o numero del primer comprobante en caso de ser mas de uno
            'CbteHasta'   => $last_voucher + 1,  // Número de comprobante o numero del último comprobante en caso de ser mas de uno
            'CbteFch'     => today()->format('Ymd'), // (Opcional) Fecha del comprobante (yyyymmdd) o fecha actual si es nulo
            'ImpTotal'    => 190, // Importe total del comprobante
            'ImpTotConc'  => 0,   // Importe neto no gravado
            'ImpNeto'     => 190, // Importe neto gravado
            'ImpOpEx'     => 0,   // Importe exento de IVA
            'ImpIVA'      => 0,  //Importe total de IVA
            'ImpTrib'     => 0,   //Importe total de tributos
            'MonId'       => 'PES', //Tipo de moneda usada en el comprobante (ver tipos disponibles)('PES' para pesos argentinos) 
            'MonCotiz'    => 1,     // Cotización de la moneda usada (1 para pesos argentinos)  
        );

        return $this->afip->ElectronicBilling->CreateVoucher($data);
    }

    public function getVoucher()
    {
        $last_voucher = $this->lastVoucher();
        return $this->afip->ElectronicBilling->GetVoucherInfo($last_voucher, 1, 11); // num comprobante, punto de venta, tipo comprobante
    }
}
