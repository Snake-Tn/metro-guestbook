<?php

/**
 * Copyright © 2019 Ahmed Kooli. metro-guestbook challenge.
 */

namespace ImageStorage;

class LocalImageStorage implements ImageStorageInterface
{
    /**
     * @var string
     * @TODO move hostname to configuration file.
     */
    const HOST_NAME = 'http://localhost:8001';


    /**
     * @param string $tmpName
     * @param string $type
     * @return string
     * @throws \Exception
     */
    public function save(string $tmpName, string $type): string
    {
        if (!file_exists($tmpName)) {
            throw  new \Exception(sprintf("file having [name=%s] not found", $tmpName));
        }
        $newImageName = uniqid() . '.' . $this->getImageExtension($type);
        $newImageLocation = __DIR__ . '/../../media/image/upload/';

        if (!file_exists($newImageLocation)) {
            mkdir($newImageLocation, 0777, true);
        }

        $result = rename($tmpName, $newImageLocation . $newImageName);

        if (!$result) {
            throw new \Exception('could not move image');
        }

        return self::HOST_NAME . '/image/upload/' . $newImageName;
    }

    /**
     * @param string $type
     * @return string
     * @throws \Exception
     */
    private function getImageExtension(string $type): string
    {
        switch ($type) {
            case 'image/jpeg':
                return 'jpeg';
            case 'image/png':
                return 'png';
            default:
                throw new \Exception(sprintf("not supported image type [type=%s]", $type));
        }
    }
}