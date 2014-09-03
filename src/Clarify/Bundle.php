<?php

namespace Clarify;
use Clarify\Exceptions\InvalidEnumTypeException;
use Clarify\Exceptions\InvalidJSONException;

/**
 * Class Bundle
 * @package Clarify
 *
 * @property mixed  $metadata   This is the metadata subresource of the bundle.
 * @property mixed  $tracks     This is the tracks subresource of the bundle.
 */
class Bundle
{
    protected $client = null;

    public function __construct($key, $client = null)
    {
        $this->client = (is_null($client)) ? new \Clarify\Client($key) : $client;
    }

    public function create($name = '', $media_url = '', $metadata = '', $notify_url = '', $audio_channel = '')
    {
        $params = array();
        $params['name'] = $name;
        $params['media_url'] = $media_url;
        $params['metadata'] = $metadata;
        $params['notify_url'] = $notify_url;
        $params['audio_channel'] = $audio_channel;

        $metadata = isset($options['metadata']) ? $options['metadata'] : '';
        $ob = json_decode($metadata);
        if ($metadata != '' && $ob === null) {
            throw new InvalidJSONException();
        }

        $audio_channel = isset($options['audio_channel']) ? $options['audio_channel'] : '';
        if (!in_array($audio_channel, array('left', 'right', 'split', ''))) {
            throw new InvalidEnumTypeException();
        }

        return $this->client->post($params);
    }

    public function update($id, $name = '', $notify_url = '', $version  = 1)
    {
        $params = array();
        $params['id'] = $id;
        $params['name'] = $name;
        $params['notify_url'] = $notify_url;
        $params['version'] = $version;

        return $this->client->put($params);
    }

    public function delete($id)
    {

    }

    public function load($id)
    {
        
    }

    public function getResponse()
    {
        return $this->client->response;
    }

    public function getStatusCode()
    {
        return $this->client->statusCode;
    }

    /**
     * @param $name
     * @return Metadata|Tracks
     * @throws InvalidResourceException
     */
    public function __get($name)
    {
        switch ($name) {
            case 'tracks':
                return new Tracks($this->apiKey);
            case 'metadata':
                return new Metadata($this->apiKey);
            default:
                throw new InvalidResourceException('Not supported');
        }
    }
}