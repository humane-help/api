<?php

namespace App\Services\Contracts;

/**
 * Interface TelegramService
 * @package App\Services\Contracts
 */
interface TelegramService extends BaseService
{
    /**
     * @param $id
     * @param $text
     * @return void
     */
    public function sendMessageToClient($id, $text);

    /**
     * @param $title
     * @param $url
     * @param $image
     * @param $tags
     * @return void
     */
    public function sendMessageChannel($title, $url, $image, $tags);

    /**
     * @param $title
     * @param $url
     * @return mixed
     */
    public function sendTechChannel($url, $title = '');

    /**
     * @param $title
     * @param $url
     * @return mixed
     */
    public function sendDocumentChannel($fileUrl, $title = '', $number = '');

}
