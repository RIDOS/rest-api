<?php

namespace App\Entity;

use DateTime;

/**
 * Сущность "Новости".
 * 
 * id:          Номер сущности.
 * title:       Название новости.
 * body:        Текст новости.
 * dateCreated: Дата создания новости.
 * 
 * @author a.imaev <smartsites.dev27@gmail.com>
 */
class News
{
    private ?int $id;

    private ?string $title;

    private ?string $body;

    private ?string $dateCreated;

    public function __construct()
    {
        $this->body = null;
        $this->title = null;
        $this->dateCreated = (new DateTime())->format('Y-m-d');
    }

    public function setId(int $id): static
    {
        $this->id = $id;

        return $this;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getBody(): ?string
    {
        return $this->body;
    }

    public function setBody(string $body): static
    {
        $this->body = $body;

        return $this;
    }

    public function getDateCreate(): string
    {
        return $this->dateCreated;
    }

    public function setDateCreate(string $dateCreated): static
    {
        $this->dateCreated = $dateCreated;

        return $this;
    }
}
