<?php

namespace App;

use App\Slide;
use \Exception;
use \SplObjectStorage;
use Ratchet\ConnectionInterface;
use Ratchet\MessageComponentInterface;


class WebSocket implements MessageComponentInterface
{
    /**
     * Store clients Web Socket connection
     *
     * @var SplObjectStorage
     */
    protected $clients;

    /**
     * Store Slide object
     *
     * @var object
     */
    protected $slide;

    /**
     * Store path of presentation file
     *
     * @var string
     */
    protected $slidePath;

    /**
     * Store contents of last active slide
     *
     * @var string
     */
    protected $slideLast;

    /**
     * Slide number
     *
     * @var int
     */
    protected $slideNumber;

    /**
     * Store filename of presentation file
     *
     * @var string
     */
    protected $slideFileName;

    /**
     * Presenters resource id
     *
     * @var array
     */
    protected $presenterResourcesId;


    /**
     * Initialize Web Socket connection
     */
    public function __construct() {
        $settings = require APP_PATH . '/config/app.php';
        $settings = $settings['settings'];

        $this->clients              = new SplObjectStorage;
        $this->slidePath            = $settings['presentation']['presentation'];
        $this->presenterResourcesId = [];

        $this->init();
    }

    /**
     * Initialize presentation broadcast
     * Send last active slide to all active Web Socket connections
     */
    protected function init()
    {
        $this->slide         = null;
        $this->slideLast     = '<h1>No active presentation.</h1><br>' .
                               '<h3>Stay tuned ;)</h3>';
        $this->slideNumber   = -1;
        $this->slideFileName = null;

        $this->sendMessageToAll();
    }

    /**
     * Add presenter to presenter list
     *
     * @param int $resourceId ResourceId of presenter
     */
    protected function addPresenter($resourceId)
    {
        if (!in_array($resourceId, $this->presenterResourcesId))
        {
            $this->presenterResourcesId[] = $resourceId;
        }
    }

    /**
     * Remove presenter from presenter list
     *
     * @param int $resourceId ResourceId of presenter
     */
    protected function removePresenter($resourceId)
    {
        $key = array_search($resourceId, $this->presenterResourcesId);
        if ($key !== false)
        {
            unset($this->presenterResourcesId[$key]);
        }
    }

    /**
     * Check Web Socket Connection is presenter or not
     *
     * @param  int     $resourceId ResourceId for Web Socket connection
     * @return boolean             Client is presenter or not
     */
    protected function isPresenter($resourceId)
    {
        return in_array($resourceId, $this->presenterResourcesId);
    }

    /**
     * Send message ie slide content to all active Web Socket connections
     */
    protected function sendMessageToAll()
    {
        $msgForViewer    = ['slide' => $this->slideLast];
        $msgForPresenter = ['slide' => $this->slideLast];

        if ($this->slide != null)
        {
            $msgForPresenter['prev'] = $this->slide->prev;
            $msgForPresenter['next'] = $this->slide->next;
        }

        $msgForViewer    = json_encode($msgForViewer);
        $msgForPresenter = json_encode($msgForPresenter);

        foreach ($this->clients as $client)
        {
            if (!$this->isPresenter($client->resourceId))
            {
                $client->send($msgForViewer);
            }
            else
            {
                $client->send($msgForPresenter);
            }
        }
    }

    /**
     * Stats of active Web Socket connections and presenters
     */
    protected function stats()
    {
        echo 'Active presenter: '   . count($this->presenterResourcesId).'. ';
        echo 'Active connections: ' . count($this->clients) . "\n";
    }

    /**
     * New Web Socket connection is opened
     *
     * @param  ConnectionInterface $conn The socket/connection that just
     *                                   connected to your application
     */
    public function onOpen(ConnectionInterface $conn) {
        $this->clients->attach($conn);

        if (!$this->isPresenter($conn->resourceId))
        {
            $msg = ['slide' => $this->slideLast];
            $msg = json_encode($msg);

            $conn->send($msg);
        }

        echo "New connection! ({$conn->resourceId})\n";
        $this->stats();
    }

    /**
     * Send message ie slide content to all active Web Socket connections
     *
     * @param  ConnectionInterface $from Sender Web Socket connection
     * @param  string              $msg  Slide content
     */
    public function onMessage(ConnectionInterface $from, $msg) {
        $msg = json_decode($msg, true);

        if (array_key_exists('presenter', $msg))
        {
            if ($msg['presenter'] == 'true')
            {
                $this->addPresenter($from->resourceId);
            }
        }
        else if (array_key_exists('filename', $msg))
        {
            if ($this->slideFileName != $msg['filename'])
            {
                $this->slideFileName = $msg['filename'];

                $slideFullPath   = $this->slidePath.$this->slideFileName;
                $this->slide     = new Slide($slideFullPath);
                $this->slideLast = $this->slide->render('start');

                if ($this->slideNumber != $this->slide->slideNumber)
                {
                    $this->sendMessageToAll();
                }
                $this->slideNumber = $this->slide->slideNumber;

                echo "Presenter ({$from->resourceId}) started new slide\n";
            }
            else if ($this->slideFileName == $msg['filename'])
            {
                $msg = ['prev'  => $this->slide->prev,
                        'next'  => $this->slide->next,
                        'slide' => $this->slide];
                $msg = json_encode($msg);
                $from->send($msg);

                echo "Presenter resumed slide from ({$from->resourceId})\n";
            }

            $this->stats();
        }
        else if (array_key_exists('action', $msg))
        {
            if ($msg['action'] == 'stop')
            {
                $this->presenterResourcesId = [];
                $this->init();

                echo "Presenter ({$from->resourceId}) stopped slide\n";
            }
            else
            {
                $this->slideLast   = $this->slide->render($msg['action']);

                $this->sendMessageToAll();

                echo "Presenter slide: {$this->slideFileName}. ";
                echo "Slide number: {$this->slide->slideNumber}. ";
                echo "Action: {$msg['action']}\n";
            }
        }
    }

    /**
     * Web Socket connection is closed
     *
     * @param  ConnectionInterface $conn The socket/connection that just
     *                                   disconnected
     */
    public function onClose(ConnectionInterface $conn)
    {
        $this->clients->detach($conn);

        if ($this->isPresenter($conn->resourceId))
        {
            $this->removePresenter($conn->resourceId);
            echo "Presenter disconnected! ($conn->resourceId)\n";
        }
        else
        {
            echo "Connection disconnected! ({$conn->resourceId})\n";
        }

        if (count($this->presenterResourcesId) == 0)
        {
            $this->init();
        }

        $this->stats();
    }

    /**
     * Error with one of the sockets
     * Or somewhere in the app
     *
     * @param  ConnectionInterface $conn Client Web Socket connection
     * @param  Exception           $e    Exception
     */
    public function onError(ConnectionInterface $conn, Exception $e) {
        echo "An error has occurred: {$e->getMessage()}\n";

        $conn->close();
    }
}
