<?php

namespace Gpenverne\PutioDriveBundle\Factory;

use Gpenverne\PsrCloudFiles\Factories\FileFactory;
use Gpenverne\PsrCloudFiles\Factories\FolderFactory;
use Gpenverne\PsrCloudFiles\Interfaces\CloudItemInterface;
use Gpenverne\PsrCloudFiles\Interfaces\FileInterface;
use Gpenverne\PsrCloudFiles\Interfaces\FolderInterface;
use Gpenverne\PsrCloudFiles\Models\Provider;
use PutIO\API;

class PutioApiFactory extends Provider
{
    const PROVIDER_NAME = 'putio';

    /**
     * @var API
     */
    private $api;

    /**
     * @var FileFactory
     */
    private $fileFactory;

    /**
     * @var FolderFactory
     */
    private $folderFactory;

    /**
     * @param FolderFactory $folderFactory
     * @param FileFactory   $fileFactory
     */
    public function __construct(FolderFactory $folderFactory, FileFactory $fileFactory)
    {
        $this->folderFactory = $folderFactory;
        $this->fileFactory = $fileFactory;
    }

    /**
     * @param string $token
     *
     * @return API
     */
    public function getApiClient($token = null)
    {
        if (null === $this->api) {
            $this->api = $this->createApiClient($token ? $token : $this->getToken());
        }

        return $this->api;
    }

    /**
     * @param string $token
     *
     * @return $this
     */
    public function setToken($token)
    {
        $this->token = $token;
        $this->createApiClient($token);

        return $this;
    }

    /**
     * @return string
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * @param string $path
     *
     * @return CloudItemInterface
     */
    public function findByPath($path)
    {
        $item = parent::findByPath($path);
        if ($item && $item->isFolder()) {
            $this->loadFolder($item);
        }

        return $item;
    }

    /**
     * @param FileInterface $file
     *
     * @return string
     */
    public function getLink(FileInterface $file)
    {
        return $this->getApiClient()->files->getDownloadURL($file->getId());
    }

    /**
     * @return string
     */
    public function getName()
    {
        return self::PROVIDER_NAME;
    }

    /**
     * @param string $token
     *
     * @return API
     */
    private function createApiClient($token)
    {
        $this->api = new API($token);
        $files = $this->api->files->listAll();
        $rootFolder = $this->folderFactory->create([
            'id' => 0,
            'name' => '',
            'parentFolder' => null,
            'provider' => $this,
        ]);

        $this->setRootFolder($rootFolder);
        $this->loadFolder($rootFolder);

        return $this->api;
    }

    /**
     * @param FolderInterface $folder
     *
     * @return FolderInterface
     */
    private function loadFolder(FolderInterface $folder)
    {
        $items = $this->api->files->listAll($folder->getId());

        foreach ($items as $item) {
            $parameters = array_merge($item, [
                'parentFolder' => $folder,
                'provider' => $this,
            ]);

            if ('application/x-directory' === $item['content_type']) {
                $item = $this->folderFactory->create($parameters);
            } else {
                $item = $this->fileFactory->create($parameters);
            }

            $folder->addItem($item);
        }

        return $folder;
    }
}
