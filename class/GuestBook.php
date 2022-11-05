<?php
require_once 'message.php';

class GuestBook{
    private $file;

    public function __construct(string $file)
    {
        $dir = dirname($file);
        if(!is_dir($dir))
        {
            mkdir($dir, 0777, true);
        }
        if(!file_exists($file))
        {
            touch($file);
        }
        $this->file = $file;
    }
    public function addMessage(Message $message)
    {
        file_put_contents($this->file, $message->toJson()."\n", FILE_APPEND);
    }
    public function getMessage():array
    {
        $content = trim(file_get_contents($this->file));
        $lines = explode("\n",$content);
        $message = [];
        foreach($lines as $line)
        {
            $data = json_decode($line, true);
            $message[]= new Message($data['username'],$data['message'],new DateTime('@'.$data['date']));
        }
        return array_reverse($message);
    }
}