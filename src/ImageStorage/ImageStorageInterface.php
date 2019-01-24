<?php

/**
 * Copyright © 2019 Ahmed Kooli. metro-guestbook challenge.
 */

namespace ImageStorage;


interface ImageStorageInterface
{
    /**
     * Saves an image into a storage, such as local disk or AWS S3
     * @param string $tmpName
     * @param string $type
     * @return string image public url
     */
    public function save(string $tmpName, string $type): string;
}