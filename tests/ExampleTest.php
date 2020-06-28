<?php

/**
 * Class ExampleTest
 */
class ExampleTest extends TestCase // @codingStandardsIgnoreLine
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testExample(): void
    {
        $this->get('/');

        $this->assertEquals(
            $this->app->version(),
            $this->response->getContent()
        );
    }
}
