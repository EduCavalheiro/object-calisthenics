<?php

namespace Alura\Calisthenics\Domain\Student;

use Alura\Calisthenics\Domain\Email\Email;
use Alura\Calisthenics\Domain\Video\Video;
use DateTimeInterface;
use Ds\Map;

class Student
{
    private Email $email;
    private DateTimeInterface $birthDate;
    private WatchedVideos $watchedVideos;
    public string $street;
    public string $number;
    public string $province;
    public string $city;
    public string $state;
    public string $country;
    private FullName $fullName;

    public function __construct(Email $email, DateTimeInterface $bd, FullName $fullName, string $street, string $number, string $province, string $city, string $state, string $country)
    {
        $this->watchedVideos = new WatchedVideos();
        $this->email = $email;
        $this->birthDate = $bd;
        $this->street = $street;
        $this->number = $number;
        $this->province = $province;
        $this->city = $city;
        $this->state = $state;
        $this->country = $country;
        $this->fullName = $fullName;
    }

    public function getFullName(): string
    {
        return (string) $this->fullName;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getBirthDate(): DateTimeInterface
    {
        return $this->birthDate;
    }

    public function watch(Video $video, DateTimeInterface $date)
    {
        $this->watchedVideos->add($video, $date);
    }

    public function hasAccess(): bool
    {
        if ($this->watchedVideos->count() === 0) {
            return true;
        }

        $firstDate = $this->watchedVideos->dateOfFirstVideo();

        return $firstDate->diff(new \DateTimeImmutable())->days < 90;
    }

    public function age(): int
    {
        return $this->birthDate->diff(new \DateTimeImmutable())->y;
    }
}
