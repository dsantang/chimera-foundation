<?php
declare(strict_types=1);

namespace Lcobucci\Chimera;

use Psr\Http\Message\ServerRequestInterface;

/**
 * Defines the public API for a service bus which handles messages that changes the application data (write operations)
 */
interface CommandBus
{
    /**
     * Creates a command object and processes it
     *
     * @param string                 $command  The class name of the message to be created
     * @param ServerRequestInterface $request  The HTTP request
     */
    public function handle(string $command, ServerRequestInterface $request): void;
}
