<?php

namespace App\Service;

use Endroid\QrCode\Color\Color;
use App\Service\AesEncryptDecrypt;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\Builder\BuilderInterface;
use Endroid\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelHigh;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class QrCodeService
{
    protected $builder;
    protected AesEncryptDecrypt $aesEncryptDecrypt;

    public function __construct(BuilderInterface $builder,private ParameterBagInterface $parameter, AesEncryptDecrypt $aesEncryptDecrypt)
    {
        $this->builder=$builder;
        $this->parameter=$parameter;
        $this->aesEncryptDecrypt=$aesEncryptDecrypt;
        
    }

    public function qrcode($recherche, $nom_qr)
    {
        
        $url="volontaire/";
        $path= $this->parameter->get('qrcodeVolontaire_diretory').'/';
        $result=$this->builder
        ->data($this->aesEncryptDecrypt->encrypt($url.$recherche))
        ->encoding(new Encoding('UTF-8'))
        ->errorCorrectionLevel(ErrorCorrectionLevel::High)
        ->size(400)
        ->margin(10)
        ->backgroundColor(new Color(0, 153, 51))
        ->logoPath('assets/build/images/logo-icons/logo-njegYi.png')
        ->logoResizeToHeight(100)
        ->logoResizeToWidth(100)
        ->build()
        ;
        $namePng=$nom_qr.'.png';
        $result->saveToFile($path.$namePng);
        return $result->getDataUri();
    }
}
