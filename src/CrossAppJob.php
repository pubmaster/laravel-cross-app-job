<?php

namespace CrossAppJob;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

/**
 * Class CrossAppJob
 */
class CrossAppJob implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var string
     */
    private $jobClass;
    /**
     * @var array
     */
    private $data;

    /**
     * CrossAppJob constructor.
     *
     * @param string $jobClass
     * @param array $data
     */
    public function __construct(string $jobClass, array $data = [])
    {
        $this->jobClass = $jobClass;
        $this->data = $data;
    }

    public function handle(): void
    {
        dispatch(new $this->jobClass($this->data))->onConnection($this->connection)->onQueue($this->queue);
    }
}
