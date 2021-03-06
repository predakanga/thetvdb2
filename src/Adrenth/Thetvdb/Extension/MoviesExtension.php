<?php

declare(strict_types=1);

namespace Adrenth\Thetvdb\Extension;

use Adrenth\Thetvdb\ClientExtension;
use Adrenth\Thetvdb\Exception\InvalidArgumentException;
use Adrenth\Thetvdb\Exception\InvalidJsonInResponseException;
use Adrenth\Thetvdb\Exception\RequestFailedException;
use Adrenth\Thetvdb\Exception\UnauthorizedException;
use Adrenth\Thetvdb\Model\Movie;
use Adrenth\Thetvdb\Model\UpdatedMovies;
use Adrenth\Thetvdb\ResponseHandler;
use DateTimeImmutable;

/**
 * Class MoviesExtension
 *
 * @category Thetvdb
 * @package  Adrenth\Thetvdb\Extension
 * @author   Alwin Drenth <adrenth@gmail.com>
 * @license  http://opensource.org/licenses/MIT The MIT License (MIT)
 * @link     https://github.com/adrenth/thetvdb2
 */
final class MoviesExtension extends ClientExtension
{
    /**
     * @param int $movieId
     * @return Movie
     * @throws InvalidArgumentException
     * @throws InvalidJsonInResponseException
     * @throws RequestFailedException
     * @throws UnauthorizedException
     */
    public function get(int $movieId): Movie
    {
        $json = $this->client->performApiCallWithJsonResponse('get', '/movies/' . $movieId);

        /** @var Movie $movie */
        $movie = ResponseHandler::create($json, ResponseHandler::METHOD_MOVIE)->handle();

        return $movie;
    }

    /**
     * @param DateTimeImmutable $dateTime
     * @return UpdatedMovies
     * @throws InvalidArgumentException
     * @throws InvalidJsonInResponseException
     * @throws RequestFailedException
     * @throws UnauthorizedException
     */
    public function getUpdates(DateTimeImmutable $dateTime): UpdatedMovies
    {
        $json = $this->client->performApiCallWithJsonResponse(
            'get',
            sprintf('/movieupdates?since=%s', $dateTime->format('Y-m-d'))
        );

        /** @var UpdatedMovies $updatedMovies */
        $updatedMovies = ResponseHandler::create($json, ResponseHandler::METHOD_UPDATED_MOVIES)->handle();

        return $updatedMovies;
    }
}
