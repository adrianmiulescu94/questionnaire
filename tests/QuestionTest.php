<?php

namespace App\Tests;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;

class QuestionTest extends ApiTestCase
{
    public function testGetQuestions(): void
    {
        static::createClient()->request('GET', '/api/questions');

        $this->assertResponseIsSuccessful();
        $this->assertJsonContains([
            '@id' => '/api/questions',
            '@type' => 'hydra:Collection',
            'hydra:totalItems' => 8,
        ]);
    }
}
