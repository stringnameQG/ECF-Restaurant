<?php

namespace App\Service;

use Exception;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Cloudinary\Configuration\Configuration;
use Cloudinary\Api\Upload\UploadApi;

$config = Configuration::instance();
$config->cloud->cloudName = 'hqzz8nqsu';
$config->cloud->apiKey = '119856113591654';
$config->cloud->apiSecret = 'Oi2fXFT2ESjQjoHrLd10-S0SwDY';
$config->url->secure = true;

class PictureService
{
    private $params;

    public function __construct(ParameterBagInterface $params)
    {
        $this->params = $params;
    }

    public function add(UploadedFile $picture)
    {
        function VerificationFormatImage($pitctureInfos): void
        {
            if($pitctureInfos === false){
                throw new Exception('Format d\'image incorrect');
            } 
        }

        function VerificationTypeImage($pitctureInfos, $picture)
        {  
            return match($pitctureInfos['mime']){
                'image/png' => imagecreatefrompng($picture),
                'image/jpeg' => imagecreatefromjpeg($picture),
                'image/webp' => imagecreatefromwebp($picture),
                default => throw new Exception('Format d\'image incorrect')
            };     
        }

        function EnregistrementFichierImage($pictureSource, $path): void
        {
            imagewebp($pictureSource, $path);
        }
        
        function EnregistrementImageCloudinary($path, $fichierNom){

            $uploadFolder = 'RestaurantArnaudMichant';

            $upload = new UploadApi();

            $upload->upload($path, [
                'public_id' => $fichierNom,
                'folder' => $uploadFolder
            ]);
        }
        
        function SupressionFichierImage($path): void
        {
            unlink($path);
        }        

        VerificationFormatImage($pitctureInfos = getimagesize($picture));

        EnregistrementFichierImage(
            VerificationTypeImage($pitctureInfos, $picture), 
            $path = $this->params->get('images_directory') . $fichierNom = md5(uniqid(rand(), true))
        );

        EnregistrementImageCloudinary($path, $fichierNom);

        SupressionFichierImage($path);

        return $fichierNom;
    }

    public function deleteImageCloudinary(string $fichier)
    {
        $uploadFolder = 'RestaurantArnaudMichant';
        $cloudinary = new UploadApi();
        $cloudinary->destroy($uploadFolder . '/' . $fichier);

        return true;
    }
}

    

