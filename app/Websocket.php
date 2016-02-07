<?php

namespace App;

use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;

use App\Slide;

class WebSocket implements MessageComponentInterface {
    private $_clients;

    private $_slide;
    private $_slidePath;
    private $_slideLast;
    private $_slideNumber;
    private $_slideFileName;

    private $_presenterActive;
    private $_presenterResourcesId;


    public function __construct() {
        $this->_clients              = new \SplObjectStorage;
        $this->_slidePath            = APP_PATH.'/markdown/';
        $this->_presenterResourcesId = array();

        $this->_init();
    }

    private function _init()
    {
        $this->_slide         = null;
        $this->_slideLast     = '<h1>No active presentation.</h1><br><h3>Stay tuned.</h3>';
        $this->_slideNumber   = -1;
        $this->_slideFileName = null;

        $this->_sendMessageToAll();
    }

    private function _stats()
    {
        echo 'Active presenter: '.count($this->_presenterResourcesId).'. ';
        echo 'Active connections: '.count($this->_clients)."\n";
    }

    private function _addPresenter($resourceId)
    {
        if (!in_array($resourceId, $this->_presenterResourcesId))
        {
            $this->_presenterResourcesId[] = $resourceId;
        }
    }

    private function _removePresenter($resourceId)
    {
        $key = array_search($resourceId, $this->_presenterResourcesId);
        if ($key !== false)
        {
            unset($this->_presenterResourcesId[$key]);
        }
    }

    private function _isPresenter($resourceId)
    {
        if (in_array($resourceId, $this->_presenterResourcesId))
        {
            return true;
        }
        else
        {
            return false;
        }
    }


    public function onOpen(ConnectionInterface $conn) {
        $this->_clients->attach($conn);

        if (!$this->_isPresenter($conn->resourceId))
        {
            $msg = array('slide' => $this->_slideLast);
            $msg = json_encode($msg);

            $conn->send($msg);
        }

        echo "\nNew connection! ({$conn->resourceId})\n";
        $this->_stats();
    }




    public function onMessage(ConnectionInterface $from, $msg) {
        $msg = json_decode($msg, true);

        if (array_key_exists('presenter', $msg))
        {
            if ($msg['presenter'] == 'true')
            {
                $this->_addPresenter($from->resourceId);
            }
        }
        else if (array_key_exists('filename', $msg))
        {
            if ($this->_slideFileName != $msg['filename'])
            {
                $this->_slideFileName = $msg['filename'];

                $slideFullPath      = $this->_slidePath.$this->_slideFileName;
                $this->_slide       = new Slide($slideFullPath);
                $this->_slideLast   = $this->_slide->render('start');

                if ($this->_slideNumber != $this->_slide->slideNumber)
                {
                    $this->_sendMessageToAll();
                }
                $this->_slideNumber = $this->_slide->slideNumber;

                echo "\nPresenter ({$from->resourceId}) started new slide\n";
            }
            else if ($this->_slideFileName == $msg['filename'])
            {
                $msg = array('prev'  => $this->_slide->prev,
                             'next'  => $this->_slide->next,
                             'slide' => $this->_slide
                            );
                $msg = json_encode($msg);
                $from->send($msg);

                echo "\nPresenter resumed slide from ({$from->resourceId})\n";
            }

            $this->_stats();
        }
        else if (array_key_exists('action', $msg))
        {
            echo "\n";

            if ($msg['action'] == 'stop')
            {
                $this->_presenterResourcesId = array();
                $this->_init();

                echo "Presenter ({$from->resourceId}) stopped slide\n";
            }
            else
            {
                $this->_slideLast   = $this->_slide->render($msg['action']);

                $this->_sendMessageToAll();

                echo "Presenter slide: {$this->_slideFileName}. ";
                echo "Slide number: {$this->_slide->slideNumber}. ";
                echo "Action: {$msg['action']}\n";
            }
        }
    }

    private function _sendMessageToAll()
    {
        $msgOfViewer    = array('slide' => $this->_slideLast);
        $msgOfPresenter = array('slide' => $this->_slideLast);

        if ($this->_slide != null)
        {
            $msgOfPresenter['prev'] = $this->_slide->prev;
            $msgOfPresenter['next'] = $this->_slide->next;
        }

        $msgOfViewer    = json_encode($msgOfViewer);
        $msgOfPresenter = json_encode($msgOfPresenter);

        foreach ($this->_clients as $client)
        {
            if (!$this->_isPresenter($client->resourceId))
            {
                $client->send($msgOfViewer);
            }
            else
            {
                $client->send($msgOfPresenter);
            }
        }
    }

    public function onClose(ConnectionInterface $conn)
    {
        $this->_clients->detach($conn);

        echo "\n";
        if ($this->_isPresenter($conn->resourceId))
        {
            $this->_removePresenter($conn->resourceId);
            echo "Presenter disconnected! ($conn->resourceId)\n";
        }
        else
        {
            echo "Connection disconnected! ({$conn->resourceId})\n";
        }

        if (count($this->_presenterResourcesId) == 0)
        {
            $this->_init();
        }

        $this->_stats();
    }

    public function onError(ConnectionInterface $conn, \Exception $e) {
        echo "An error has occurred: {$e->getMessage()}\n";

        $conn->close();
    }
}