<?php


namespace App\Services\Writer;


class FileWriter implements WriterInterface
{
    /** @var null|resource  */
    private $handler = null;
    /** @var string|null  */
    private ?string $path;
    /** @var string|null  */
    private ?string $mode;

    /**
     * FileWriter constructor.
     * @param string $path
     * @param string $mode
     */
    public function __construct(string $path, string $mode = 'w+')
    {
        $this->path = $path;
        $this->mode = $mode;
    }

    /**
     * @throws WriterException
     */
    public function open(): bool
    {
        $h = @fopen($this->path, $this->mode);
        if (!$h) {
            $this->checkLastError();
        }
        $this->handler = $h;
        return true;
    }

    /**
     * @param string $data
     * @return int
     * @throws WriterException
     */
    public function write(string $data): int
    {
        if ($this->handler === null) {
            throw new WriterException(sprintf("Can't write data to empty handler. Filepath %s", $this->path));
        }

        $writeBytesLen = @fwrite($this->handler, $data);
        if ($writeBytesLen === false) {
            $this->checkLastError();
        }

        return $writeBytesLen;
    }

    /**
     * @return bool
     * @throws WriterException
     */
    public function close(): bool
    {
        if ($this->handler === null) {
            throw new WriterException(sprintf("Can't close empty handler. Filepath %s", $this->path));
        }

        $isClose = @fclose($this->handler);

        $this->handler = null;
        $this->path = null;

        return $isClose;
    }

    public function isOpen(): bool
    {
        return $this->handler !== null && $this->path !== null;
    }

    public function getPath(): string
    {
        return $this->path;
    }

    /**
     * @throws WriterException
     */
    private function checkLastError(): void
    {
        $lastError = error_get_last();
        if (count($lastError) === 4) {
            throw new WriterException(sprintf(
                "Type: %d; Message: %s; File: %s; Line: %d",
                $lastError['type'],
                $lastError['message'],
                $lastError['file'],
                $lastError['line']
            ));
        }
    }
}
