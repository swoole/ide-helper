<?php
/**
 * This file is part of Swoole.
 *
 * @link     https://www.swoole.com
 * @contact  team@swoole.com
 * @license  https://github.com/swoole/library/blob/master/LICENSE
 */

declare(strict_types=1);

namespace Swoole;

/**
 * FastCGI constants.
 */
class FastCGI
{
    /**
     * Number of bytes in a FCGI_Header.  Future versions of the protocol
     * will not reduce this number.
     */
    public const HEADER_LEN = 8;

    /**
     * Format of FCGI_HEADER for unpacking in PHP
     */
    public const HEADER_FORMAT = 'Cversion/Ctype/nrequestId/ncontentLength/CpaddingLength/Creserved';

    /**
     * Max content length of a record
     */
    public const MAX_CONTENT_LENGTH = 65535;

    /**
     * Value for version component of FCGI_Header
     */
    public const VERSION_1 = 1;

    /**
     * Values for type component of FCGI_Header
     */
    public const BEGIN_REQUEST = 1;

    public const ABORT_REQUEST = 2;

    public const END_REQUEST = 3;

    public const PARAMS = 4;

    public const STDIN = 5;

    public const STDOUT = 6;

    public const STDERR = 7;

    public const DATA = 8;

    public const GET_VALUES = 9;

    public const GET_VALUES_RESULT = 10;

    public const UNKNOWN_TYPE = 11;

    /**
     * Value for requestId component of FCGI_Header
     */
    public const DEFAULT_REQUEST_ID = 1;

    /**
     * Mask for flags component of FCGI_BeginRequestBody
     */
    public const KEEP_CONN = 1;

    /**
     * Values for role component of FCGI_BeginRequestBody
     */
    public const RESPONDER = 1;

    public const AUTHORIZER = 2;

    public const FILTER = 3;

    /**
     * Values for protocolStatus component of FCGI_EndRequestBody
     */
    public const REQUEST_COMPLETE = 0;

    public const CANT_MPX_CONN = 1;

    public const OVERLOADED = 2;

    public const UNKNOWN_ROLE = 3;
}
